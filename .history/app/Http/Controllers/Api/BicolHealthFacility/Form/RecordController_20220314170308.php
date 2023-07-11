<?php

namespace App\Http\Controllers\Api\BicolHealthFacility\Form;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use TCPDF;

class RecordController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 400;

    public function store(Request $request)
    { 
       
    }

    
    public function pdf(Request $request)
    {
        try { 
            $itemRequestHeader = DB::table('item_request_headers as header')
                                    ->where('header.id', $request->item_header_id)
                                    ->join('user_profiles as profile', 'header.user_id', 'profile.user_id')
                                    ->join('business_units as department', 'header.user_business_unit_id', 'department.id')
                                    ->join('business_unit_positions as position', 'header.user_business_unit_position_id', 'position.id')
                                    ->join('item_request_header_status as status', 'header.status_id', 'status.id')
                                    ->select(
                                        'header.id', 'header.date', 'header.business_unit_id', 'header.work_item_no', 
                                        'header.qto_no', 'header.purpose', 'header.status_id', 
                                        'header.created_at', 'header.project',  'header.project_id',
                                        'profile.first_name', 'profile.last_name',
                                        'department.name as department_name',
                                        'position.name as position_name',
                                        'status.name as item_request_header_status_name', 
                                        DB::raw('null as project_name'),
                                        DB::raw('null as business_unit_name'),
                                    )->first();
            $itemRequestHeader->business_unit_name = $this->businessUnit($itemRequestHeader->business_unit_id);
            $itemRequestHeader->project_name = $itemRequestHeader->business_unit_id == $itemRequestHeader->project_id ? 'CORPORATE OFFICE' : $this->project($itemRequestHeader->project_id,  $itemRequestHeader->project);
            $items = DB::table('item_requests as item')
                        ->where('item.item_request_header_id', $itemRequestHeader->id)
                        ->join('unit_of_measures as unit', 'item.unit_of_measure_id', 'unit.id')
                        ->select(
                            'item.id', 'item.item_request_header_id', 'item.description', 'item.quantity', 
                            'item.date_needed', 'item.file_path', 'item.status_id', 'item.urgent',
                            'unit.name as unit_of_measure_name'
                        )->get();
            $userProfile = DB::table('user_profiles')->where('user_id', Auth::id())->first();
            $itemRequestApprovers = DB::table('item_request_approvers')->where('business_unit_id', $userProfile->business_unit_id)->where('group_id', $userProfile->group_id)->first();
            $view = \View::make('forms/ProvisionRequest', ['itemRequest'=>$itemRequestHeader,'items'=>$items,'itemRequestApprovers'=>$itemRequestApprovers]);
            $html_content = $view->render();
            $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('PURCHASE REQUISITION SLIP');
            $pdf->SetTitle('PURCHASE REQUISITION SLIP');
            $pdf->SetSubject('TPURCHASE REQUISITION SLIP');
            //$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
            // set margins
            $pdf->SetMargins(3, 1, 3);
            $pdf->SetHeaderMargin(0);
            $pdf->SetFooterMargin(0);
            $pdf->SetAutoPageBreak(TRUE, 1);
            $pdf->SetPrintHeader(false);
            $pdf->SetPrintFooter(false);
            $pdf->SetFont('helvetica', '', 9);
            $pdf->AddPage();
            $pdf->writeHTML($html_content, true, 0, true, 0);
            $pdf->lastPage();
            $root = 'private/temp/';
            $file_path = storage_path('app/' . $root);
            $pdf->Output($file_path . $itemRequestHeader->id . '.pdf', 'F');
            return response()->file($file_path . $itemRequestHeader->id . '.pdf');
        } catch (Exception $e) {
			return response()->json($e);
        }
    }

  
}
