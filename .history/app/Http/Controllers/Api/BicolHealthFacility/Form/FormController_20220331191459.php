<?php

namespace App\Http\Controllers\Api\BicolHealthFacility\Form;

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

public function test ()
{
    try { 
               
    $info = DB::table('registration as a')
    ->leftjoin('registration_maintenance as b', 'a.client_type_id', 'b.id')
    ->leftjoin('registration_maintenance as c', 'a.membership_category_id', 'c.id')
    ->where('a.id', 4)
    ->select(
        'a.id',
        'a.philhealth_id',
        'a.last_name',
        'a.first_name',
        'a.middle_name',
        'a.extension',
        'a.date_of_birth',
        'a.gender',
        'a.email',
        'a.contact_number',
        'a.home_address',
        'b.name as client_type',
        'c.name as membership_category',
        'a.previous_illnesses',
        'a.hospitalization',
        'a.family_history_father',
        'a.family_history_mother',
        'a.lifestyle_info',
        'a.present_illnesses',
        'a.immunization_history',
        'a.maintenance_medication',
        'a.note',
        'a.created_at',
        DB::raw('null as previous_illnesses_array'),
        DB::raw('null as family_history_father_array'),
        DB::raw('null as family_history_mother_array'),
        DB::raw('null as lifestyle_info_array'),
        DB::raw('null as present_illnesses_array'),
        DB::raw('null as immunization_history_array'),
        
    )
    ->first();

   // $hospitals = $info->hospitalization = json_decode($info->hospitalization, true);
  
   $info->previous_illnesses = json_decode($info->previous_illnesses, true);
   foreach ($info->previous_illnesses as $previous_illnesses) {
       $info->previous_illnesses_array[] = DB::table('registration_maintenance as a')
           ->where('a.id', $previous_illnesses)
           ->select(
               'id as previous_illnesses_id',
               'name as previous_illnesses_name',
           )
           ->first();
   }
   
    $info->family_history_father = json_decode($info->family_history_father, true);
    foreach ($info->family_history_father as $family_history_father) {
        $info->family_history_father_array[] = DB::table('registration_maintenance as a')
            ->where('a.id', $family_history_father)
            ->select(
                'id as family_history_id',
                'name as family_history_name',
            )
            ->first();
    }
    $info->family_history_mother = json_decode($info->family_history_mother, true);
    foreach ($info->family_history_mother as $family_history_mother) {
        $info->family_history_mother_array[] = DB::table('registration_maintenance as a')
            ->where('a.id', $family_history_mother)
            ->select(
                'id as family_history_id',
                'name as family_history_name',
            )
            ->first();
    }

    $info->lifestyle_info = json_decode($info->lifestyle_info, true);
    foreach ($info->lifestyle_info as $lifestyle_info) {
        $info->lifestyle_info_array[] = DB::table('registration_maintenance as a')
            ->where('a.id', $lifestyle_info)
            ->select(
                'id as lifestyle_info_id',
                'name as lifestyle_info_name',
            )
           
            ->first();
    }

    $info->present_illnesses = json_decode($info->present_illnesses, true);
    foreach ($info->present_illnesses as $present_illnesses) {
        $info->present_illnesses_array[] = DB::table('registration_maintenance as a')
            ->where('a.id', $present_illnesses)
            ->select(
                'id as present_illnesses_id',
                'name as present_illnesses_name',
            )
            ->first();
    }

    $info->immunization_history = json_decode($info->immunization_history, true);
    foreach ($info->immunization_history as $immunization_history) {
        $info->immunization_history_array[] = DB::table('registration_maintenance as a')
            ->where('a.id', $immunization_history)
            ->select(
                'id as immunization_history_id',
                'name as immunization_history_name',
            )
            ->first();
    }
//------------------------------------------------------------------------------------------//

//if( $info->previous_illnesses == [])
//{
// $info->previous_illnesses_array = "[]";
//}

return response()->json($info);

            $view = \View::make('bicol_health_facility/forms/FPEF_Form', ['info'=>$info]);
            $html_content = $view->render();
            $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('FPEF_Form');
            $pdf->SetTitle('FPEF_Form');
            $pdf->SetSubject('FPEF_Form');
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
            $pdf->Output($file_path . 'FPEF_Form' . '.pdf', 'F');
            return response()->file($file_path . 'FPEF_Form' . '.pdf');
        
        } catch (Exception $e) {
			return response()->json($e);
        }       
 
}


    public function pdf(Request $request)
    {
        try { 
            
            if($request->action == 'PHIC')
            {
                $view = \View::make('bicol_health_facility/forms/PHIC_Form');
                $html_content = $view->render();
                $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
                // set document information
                $pdf->SetCreator(PDF_CREATOR);
                $pdf->SetAuthor('PHIC_Form');
                $pdf->SetTitle('PHIC_Form');
                $pdf->SetSubject('PHIC_Form');
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
                $pdf->Output($file_path . 'PHIC_Form' . '.pdf', 'F');
                return response()->file($file_path . 'PHIC_Form' . '.pdf');
            }

            if($request->action == 'RATC')
            {
               
                $view = \View::make('bicol_health_facility/forms/RATC_Form');
                $html_content = $view->render();
                $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
                // set document information
                $pdf->SetCreator(PDF_CREATOR);
                $pdf->SetAuthor('RATC_Form');
                $pdf->SetTitle('RATC_Form');
                $pdf->SetSubject('RATC_Form');
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
                $pdf->Output($file_path . 'RATC_Form' . '.pdf', 'F');
                return response()->file($file_path . 'RATC_Form' . '.pdf');
            }

            if($request->action == 'EKAS')
            {
               
                $view = \View::make('bicol_health_facility/forms/EKAS_Form');
                $html_content = $view->render();
                $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
                // set document information
                $pdf->SetCreator(PDF_CREATOR);
                $pdf->SetAuthor('EKAS_Form');
                $pdf->SetTitle('EKAS_Form');
                $pdf->SetSubject('EKAS_Form');
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
                $pdf->Output($file_path . 'EKAS_Form' . '.pdf', 'F');
                return response()->file($file_path . 'EKAS_Form' . '.pdf');
            }

            if($request->action == 'EPRESS')
            {
               
                $view = \View::make('bicol_health_facility/forms/EPRESS_Form');
                $html_content = $view->render();
                $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
                // set document information
                $pdf->SetCreator(PDF_CREATOR);
                $pdf->SetAuthor('EPRESS_Form');
                $pdf->SetTitle('EPRESS_Form');
                $pdf->SetSubject('EPRESS_Form');
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
                $pdf->Output($file_path . 'EPRESS_Form' . '.pdf', 'F');
                return response()->file($file_path . 'EPRESS_Form' . '.pdf');
            }

            if($request->action == 'FPEF')
            {

               
        $info = DB::table('registration as a')
        ->leftjoin('registration_maintenance as b', 'a.client_type_id', 'b.id')
        ->leftjoin('registration_maintenance as c', 'a.membership_category_id', 'c.id')
        ->where('a.id', $request->id)
        ->select(
            'a.id',
            'a.philhealth_id',
            'a.last_name',
            'a.first_name',
            'a.middle_name',
            'a.extension',
            'a.date_of_birth',
            'a.gender',
            'a.email',
            'a.contact_number',
            'a.home_address',
            'b.name as client_type',
            'c.name as membership_category',
            'a.previous_illnesses',
            'a.hospitalization',
            'a.family_history_father',
            'a.family_history_mother',
            'a.lifestyle_info',
            'a.present_illnesses',
            'a.immunization_history',
            'a.maintenance_medication',
            'a.note',

            DB::raw('null as previous_illnesses_array'),
            DB::raw('null as family_history_father_array'),
            DB::raw('null as family_history_mother_array'),
            DB::raw('null as lifestyle_info_array'),
            DB::raw('null as present_illnesses_array'),
            DB::raw('null as immunization_history_array'),
            'a.created_at',
        )
        ->first();

       // $hospitals = $info->hospitalization = json_decode($info->hospitalization, true);
              
        $info->previous_illnesses = json_decode($info->previous_illnesses, true);
                foreach ($info->previous_illnesses as $previous_illnesses) {
                    $info->previous_illnesses_array[] = DB::table('registration_maintenance as a')
                        ->where('a.id', $previous_illnesses)
                        ->select(
                            'id as previous_illnesses_id',
                            'name as previous_illnesses_name',
                        )
                        ->first();
                }

        $info->family_history_father = json_decode($info->family_history_father, true);
        foreach ($info->family_history_father as $family_history_father) {
            $info->family_history_father_array[] = DB::table('registration_maintenance as a')
                ->where('a.id', $family_history_father)
                ->select(
                    'id as family_history_id',
                    'name as family_history_name',
                )
                ->first();
        }
        $info->family_history_mother = json_decode($info->family_history_mother, true);
        foreach ($info->family_history_mother as $family_history_mother) {
            $info->family_history_mother_array[] = DB::table('registration_maintenance as a')
                ->where('a.id', $family_history_mother)
                ->select(
                    'id as family_history_id',
                    'name as family_history_name',
                )
                ->first();
        }

        $info->lifestyle_info = json_decode($info->lifestyle_info, true);
        foreach ($info->lifestyle_info as $lifestyle_info) {
            $info->lifestyle_info_array[] = DB::table('registration_maintenance as a')
                ->where('a.id', $lifestyle_info)
                ->select(
                    'id as lifestyle_info_id',
                    'name as lifestyle_info_name',
                )
               
                ->first();
        }

        $info->present_illnesses = json_decode($info->present_illnesses, true);
        foreach ($info->present_illnesses as $present_illnesses) {
            $info->present_illnesses_array[] = DB::table('registration_maintenance as a')
                ->where('a.id', $present_illnesses)
                ->select(
                    'id as present_illnesses_id',
                    'name as present_illnesses_name',
                )
                ->first();
        }

        $info->immunization_history = json_decode($info->immunization_history, true);
        foreach ($info->immunization_history as $immunization_history) {
            $info->immunization_history_array[] = DB::table('registration_maintenance as a')
                ->where('a.id', $immunization_history)
                ->select(
                    'id as immunization_history_id',
                    'name as immunization_history_name',
                )
                ->first();
        }

//------------------------------------------------------------------------------------------//

                $view = \View::make('bicol_health_facility/forms/FPEF_Form', ['info'=>$info]);
                $html_content = $view->render();
                $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
                // set document information
                $pdf->SetCreator(PDF_CREATOR);
                $pdf->SetAuthor('FPEF_Form');
                $pdf->SetTitle('FPEF_Form');
                $pdf->SetSubject('FPEF_Form');
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
                $pdf->Output($file_path . 'FPEF_Form' . '.pdf', 'F');
                return response()->file($file_path . 'FPEF_Form' . '.pdf');
            }
     
        } catch (Exception $e) {
			return response()->json($e);
        }
    }


  
}
