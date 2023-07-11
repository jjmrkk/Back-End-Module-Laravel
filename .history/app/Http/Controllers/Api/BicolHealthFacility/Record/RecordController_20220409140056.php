<?php

namespace App\Http\Controllers\Api\BicolHealthFacility\Record;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RecordController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 400;

    public function index()
    { 
        $Record_list = DB::table('registration as a')
        ->leftjoin('registration_maintenance as b', 'a.client_type_id', 'b.id')
        ->leftjoin('registration_maintenance as c', 'a.membership_category_id', 'c.id')
        ->select(
            'a.id',
            'a.philhealth_id',
            'b.name as client_type',
            'a.registration_no',
            'c.name as membership_category',
            DB::raw('CONCAT(a.last_name,\', \',a.first_name,\' \',a.extension,\', \',a.middle_name) as name'),
          //  Carbon::parse('a.created_at')->format('Y-m-d'),
            'a.created_at',
        )
          ->orderBy('created_at','desc')->take(10)->get();
        return response()->json($Record_list, 200);
    }

    public function store(Request $request)
    { 
       
    }

    public function update($request)
    { 
        return response()->json(dasdasf, 200);
    }

    public function show($search)
    { 
        $terms  = explode(' ', $search );
        
        $Record_list = DB::table('registration as a')
        ->leftjoin('registration_maintenance as b', 'a.client_type_id', 'b.id')
        ->leftjoin('registration_maintenance as c', 'a.membership_category_id', 'c.id')
        ->where(function($query) use ($terms){
            foreach($terms as $term){
                $query->where('a.last_name', 'ilike', "%$term%");
            }
        })
        ->orWhere(function($query) use ($terms){
            foreach($terms as $term){
                $query->where('a.first_name','ilike', "%$term%");
            }
        })
        ->orWhere(function($query) use ($terms){
            foreach($terms as $term){
                $query->where('a.created_at','ilike', "%$term%");
            }
        })
        ->orWhere(function($query) use ($terms){
            foreach($terms as $term){
                $query->where('a.philhealth_id', $term);
            }
        })
        ->select(
            'a.id',
            'a.philhealth_id',
            'a.registration_no',
            'b.name as client_type',
            'c.name as membership_category',
            DB::raw('CONCAT(a.last_name,\', \',a.first_name,\' \',a.extension,\', \',a.middle_name) as name'),
          //  Carbon::parse('a.created_at')->format('Y-m-d'),
            'a.created_at',
        )
        ->orderBy('created_at','desc')
        ->get();
        return response()->json($Record_list, 200);
    }

public function previous_illnesses($id)
{
    try {
        $access = DB::table('registration')->where('id', $id)->first();
        return response()->json($access->previous_illnesses, $this->successStatus);
    } catch (Exception $e) {
        return response()->json($e);
    }
}


public function family_history_father($id)
{
    try {
        $access = DB::table('registration')->where('id', $id)->first();
        return response()->json($access->family_history_father, $this->successStatus);
    } catch (Exception $e) {
        return response()->json($e);
    }
}

public function family_history_mother($id)
{
    try {
        $access = DB::table('registration')->where('id', $id)->first();
        return response()->json($access->family_history_mother, $this->successStatus);
    } catch (Exception $e) {
        return response()->json($e);
    }
}

public function lifestyle_info($id)
{
    try {
        $access = DB::table('registration')->where('id', $id)->first();
        return response()->json($access->lifestyle_info, $this->successStatus);
    } catch (Exception $e) {
        return response()->json($e);
    }
}

public function present_illnesses($id)
{
    try {
        $access = DB::table('registration')->where('id', $id)->first();
        return response()->json($access->present_illnesses, $this->successStatus);
    } catch (Exception $e) {
        return response()->json($e);
    }
}

public function immunization_history($id)
{
    try {
        $access = DB::table('registration')->where('id', $id)->first();
        return response()->json($access->immunization_history, $this->successStatus);
    } catch (Exception $e) {
        return response()->json($e);
    }
}


    public function individual($id)
    { 
        $info = DB::table('registration as a')
        ->leftjoin('registration_maintenance as b', 'a.client_type_id', 'b.id')
        ->leftjoin('registration_maintenance as c', 'a.membership_category_id', 'c.id')
        ->where('a.id', $id)
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
            'b.id as client_type_id',
            'b.name as client_type',
            'c.name as membership_category_id',
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
            'a.registration_no',
            'a.atc_no',

            DB::raw('null as previous_illnesses_array'),
       //   DB::raw('null as hospitalization_array'),
            DB::raw('null as family_history_father_array'),
            DB::raw('null as family_history_mother_array'),
            DB::raw('null as lifestyle_info_array'),
            DB::raw('null as present_illnesses_array'),
            DB::raw('null as immunization_history_array'),
            'a.created_at',
        )
        ->first();

        $info->hospitalization = json_decode($info->hospitalization, true);
              
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

        return response()->json($info, 200);
    }   


}
