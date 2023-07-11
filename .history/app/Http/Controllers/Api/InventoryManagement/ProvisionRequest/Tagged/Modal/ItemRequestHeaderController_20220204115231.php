<?php

namespace App\Http\Controllers\Api\InventoryManagement\ProvisionRequest\Tagged\Modal;

use App\Http\Controllers\Controller;
use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProvisionRequestMail;
use Carbon\Carbon;
use TCPDF;

class ItemRequestHeaderController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 400;

    private function module()
    {
        $userAccess = DB::table('user_access')->where('user_id', Auth::id())->select('description->inventory_management->provision_request_module as provision_request_module')->first();
        return json_decode($userAccess->provision_request_module);
    }

    public function update(Request $request, $id) //Delivered - Close the whole request
    {
        try {
            $module = $this->module();
            if($module->access == false)
            {
                return response()->json(['message'=>"No Access For This Module."], $this->errorStatus);
            }
            $check = DB::table('item_request_headers')->where('id', $request->item_request_header_id)->where('status_id', 10)->exists();
            if(!$check)
            {
                return response()->json(['message'=>"Please check the status of Provision Request."], $this->errorStatus);
            }
            $checkItem = DB::table('item_requests')->where('item_request_header_id', $request->item_request_header_id)->whereIn('status_id', [4, 6, 7])->count();
            if($checkItem > 0)
            {
                return response()->json(['message'=>"Please check the status of item/s."], $this->errorStatus);
            }
            DB::transaction(function () use ($request) {
                $now = Carbon::now();
                DB::table('item_request_headers')
                    ->where('id', $request->item_request_header_id)
                    ->where('status_id', 10)
                    ->update([
                        'status_id' => 13, 
                        'updated_at' => $now,
                        'description->custodian->completed_closed' => $now
                    ]);
                DB::table('item_request_header_logs')->insert([
                    'item_request_header_id' => $request->item_request_header_id,
                    'status_id' => 13,
                    'user_id' => Auth::id(),
                    'action' => 'Request Completed',
                    'description' => 'Request Completed',
                    'remarks' => '', //TINANGGAL NI jm
                    'created_at' => $now,
                    'updated_at' => $now
                ]);
                $itemRequestHeader = DB::table('item_request_headers')
                                        ->where('id', $request->item_request_header_id)
                                        ->select(
                                            'description->requestor->last_name as last_name', 'description->requestor->first_name as first_name',
                                            'description->requestor->email as email', 'description->custodian->first_name as custodian_first_name',
                                            'description->custodian->last_name as custodian_last_name', 'description->custodian->email as custodian_email', 
                                        )
                                        ->first();
                $data = [
                    'title' => 'PRS: #' . $request->item_request_header_id,
                    'sender_name' => $itemRequestHeader->custodian_first_name . ' ' . $itemRequestHeader->custodian_last_name,
                    'recipient_name' => $itemRequestHeader->first_name . ' ' . $itemRequestHeader->last_name,
                    'recipient_email' => $itemRequestHeader->email,
                    'prs_no' => '#' . $request->item_request_header_id,
                    'message' => 'PRS #' . $request->item_request_header_id . ' has been closed/completed by Custodian.', 
                ];
                Mail::to($data['recipient_email'])->send(new ProvisionRequestMail($data));
                $data2 = [
                    'title' => 'PRS: #' . $request->item_request_header_id,
                    'sender_name' => $itemRequestHeader->custodian_first_name . ' ' . $itemRequestHeader->custodian_last_name,
                    'recipient_name' => $itemRequestHeader->custodian_first_name . ' ' . $itemRequestHeader->custodian_last_name,
                    'recipient_email' => Auth::user()->email,
                    'prs_no' => '#' . $request->item_request_header_id,
                    'message' => 'You have completed/closed PRS #' .  $request->item_request_header_id . '.', 
                ];
                Mail::to($data2['recipient_email'])->send(new ProvisionRequestMail($data2));
            });
            return response()->json(['message'=>"#$request->item_request_header_id Provision Request is complete."], $this->successStatus);
        } catch (Exception $e) {
			return response()->json($e);
		}
    }

    public function printPdf(Request $request)
    {
        try { 
            $module = $this->module();
            if($module->access == false)
            {
                return response()->json(['message'=>"No Access For This Module."], $this->errorStatus);
            }
            $check = DB::table('item_request_headers')->where('id', $request->item_request_header_id)->where('status_id', 10)->exists();
            if(!$check)
            {
                return response()->json(['message'=>"Please check the status of Provision Request."], $this->errorStatus);
            }
            $itemRequestHeader = DB::table('item_request_headers as header')
                                    ->where('header.id', $request->item_request_header_id)
                                    ->where('header.status_id', 10)
                                    ->join('business_units as department', 'header.user_business_unit_id', 'department.id')
                                    ->select(
                                        'header.id', 'header.date', 'header.business_unit_id', 'header.work_item_no', 
                                        'header.qto_no', 'header.purpose', 'header.status_id', 
                                        'header.created_at', 'header.project',  'header.project_id',
                                        'department.name as department_name', 
                                        'header.description->requestor->first_name as first_name', 'header.description->requestor->last_name as last_name', 
                                        'header.description->requestor->position as position',
                                        'header.description->approver_first->first_name as approver1_first_name', 'header.description->approver_first->last_name as approver1_last_name', 
                                        'header.description->approver_first->position as approver1_position', 'header.description->approver_first->approved_disapproved as approver1_approved_disapproved',
                                        'header.description->approver_second->first_name as approver2_first_name', 'header.description->approver_second->last_name as approver2_last_name', 
                                        'header.description->approver_second->position as approver2_position', 'header.description->approver_second->approved_disapproved as approver2_approved_disapproved',
                                        'header.description->custodian->first_name as custodian_first_name', 'header.description->custodian->last_name as custodian_last_name', 
                                        'header.description->custodian->position as custodian_position', 
                                        DB::raw('null as custodian_print'),
                                        DB::raw('null as project_name'),
                                        DB::raw('null as business_unit_name'),
                                    )->first();
            $itemRequestHeader->custodian_print = Carbon::now();
            $itemRequestHeader->business_unit_name = $this->businessUnit($itemRequestHeader->business_unit_id);
            $itemRequestHeader->project_name = $itemRequestHeader->business_unit_id == $itemRequestHeader->project_id ? 'CORPORATE OFFICE' : $this->project($itemRequestHeader->project_id,  $itemRequestHeader->project);
            $items = DB::table('item_requests as item')
                        ->where('item.item_request_header_id', $itemRequestHeader->id)
                        ->join('unit_of_measures as unit', 'item.unit_of_measure_id', 'unit.id')
                        ->join('item_request_status as status', 'item.status_id', 'status.id')
                        ->where('status.id', 6)
                        ->select(
                            'item.id', 'item.item_request_header_id', 'item.description', 'item.quantity', 
                            'item.date_needed', 'item.file_path', 'item.status_id', 'item.urgent',
                            'unit.name as unit_of_measure_name', 'status.name as status_name'
                        )->get(); 
            $view = \View::make('forms/inventory-management/provision-request/tagged/ProvisionRequest', ['itemRequest'=>$itemRequestHeader,'items'=>$items]);       
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

    private function businessUnit($id)
    {
        $businessUnits = DB::table('business_units as branch')
                            ->where('branch.id', $id)
                            ->leftJoin('business_unit_relations as l', 'branch.id', 'l.child')
                            ->leftJoin('business_units as location', 'l.parent', 'location.id')
                            ->orderBy('branch.code', 'ASC')
                            ->select('branch.id', 'branch.name as branch', 'location.name as location', 'branch.code')
                            ->first();
        
        return $businessUnits->code . ' (' . $businessUnits->location . ')' ;
    }

    private function project($id, $bool) 
    {
        $project = $bool == true ? DB::table('projects')->where('id', $id)->first() : DB::table('business_units')->where('id', $id)->first();
        return $project->description;
    }
}
