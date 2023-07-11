<?php

namespace App\Http\Controllers\Api\MSSTest\Form;

use App\Http\Controllers\Controller;
use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use TCPDF;

class FormController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 400;

    public function pdf(Request $request)
    {
        try { 
            
            $now = Carbon::now();
            $Record_list = DB::table('mss_registration as a')
            ->leftjoin('mss_registration_maintenance as b', 'a.visit_type_id', 'b.id')
            ->leftjoin('mss_registration_status as c', 'a.id', 'c.mss_registration_id')
            ->leftjoin('user_profiles as d', 'a.user_id', 'd.user_id')

            ->where('a.id', $request->id)
            ->select(
                'a.id',
                'a.visitor_id_no',
                DB::raw('CONCAT(a.last_name,\', \',a.first_name) as name'),
                'a.gender',
                'b.name as visit_type',
                'a.contact_no',
                'a.purpose_of_visit',
                'a.note',
                'a.user_id',
                'c.id as registration_status_id',
                'c.check_in',
                'c.check_out',
                DB::raw('CONCAT(d.last_name,\', \',d.first_name) as encoded_by'),
                DB::raw('null as total')
            )
              ->first();

                $view = \View::make('bicol_health_facility/forms/MSS_Visitor_Form', ['Record_list'=>$Record_list]);
                $html_content = $view->render();
                $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
                // set document information
                $pdf->SetCreator(PDF_CREATOR);
                $pdf->SetAuthor('MSS_Visitor_Form');
                $pdf->SetTitle('MSS_Visitor_Form');
                $pdf->SetSubject('MSS_Visitor_Form');
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
                $pdf->Output($file_path . 'MSS_Visitor_Form' . '.pdf', 'F');
                return response()->file($file_path . 'MSS_Visitor_Form' . '.pdf');
        } catch (Exception $e) {
			return response()->json($e);
        }
    }


  
}
