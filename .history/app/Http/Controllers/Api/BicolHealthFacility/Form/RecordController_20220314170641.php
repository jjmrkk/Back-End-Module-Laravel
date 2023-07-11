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


    public function pdf(Request $request)
    {
        try { 
            
            $view = \View::make('bicol_health_facility/forms/PHIC_Kon_Reg_Form');
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
            $pdf->Output($file_path . test123 . '.pdf', 'F');
            return response()->file($file_path . test123 . '.pdf');
        } catch (Exception $e) {
			return response()->json($e);
        }
    }

  
}
