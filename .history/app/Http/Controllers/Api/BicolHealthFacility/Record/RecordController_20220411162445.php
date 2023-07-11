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

    public function update(Request $request)
    { 
     
     try {
        if ($request->action == 'pd')
        {
            $now = Carbon::now();
            DB::table('registration')
            ->where('id', $request->id)
            ->update(
                     ['philhealth_id' => $request->philhealth_id,
                     'client_type_id' => $request->client_type_id,
                     'membership_category_id' => $request->membership_category_id,
                     'last_name' => $request->last_name,
                     'first_name' => $request->first_name,
                     'middle_name' => $request->middle_name,
                     'extension' => $request->extension,
                   //  'date_of_birth' => $request->date_of_birth,
                     'gender' => $request->gender,
                     'email' => $request->email,
                     'contact_number' => $request->contact_number,
                     'home_address' => $request->home_address,
                     'maintenance_medication' => $request->maintenance_medication,
                     'note' => $request->note,
                     'registration_no' => $request->registration_no,
                     'atc_no' => $request->atc_no,
                     'updated_at' => $now]
                    );
        //    return response()->json(['message'=>'User access updated.'], $this->successStatus);
        }

        if ($request->action == 'pif')
        {
            $previous_illnesses = DB::table('registration_maintenance')->where('category_id', 3)->select('id')->get();
            foreach($previous_illnesses as $a)
            {
                if($request->has('id:'.$a->id) && $request['id:'.$a->id] == true)
                {
                  $previous_illnesses_checked[] = $a->id;
               }
            }
            $previous_illnesses_checked = json_encode($previous_illnesses_checked);
    
    
            DB::table('registration')->updateOrInsert(
                ['id' => $request->user_id],
                ['id' => $request->user_id, 'previous_illnesses' => $previous_illnesses_checked]
            );
            //return response()->json(['message'=>'User access updated.'], $this->successStatus);
        }

        if ($request->action == 'fhff')
        {
            $family_history_father = DB::table('registration_maintenance')->where('category_id', 4)->select('id')->get();
            foreach($family_history_father as $a)
            {
                if($request->has('id:'.$a->id) && $request['id:'.$a->id] == true)
                {
                  $family_history_father_checked[] = $a->id;
               }
            }
            $family_history_father_checked = json_encode($family_history_father_checked);
    
    
            DB::table('registration')->updateOrInsert(
                ['id' => $request->user_id],
                ['id' => $request->user_id, 'family_history_father' => $family_history_father_checked]
            );
         //   return response()->json(['message'=>'User access updated.'], $this->successStatus);
        }

        if ($request->action == 'fhmf')
        {
            $family_history_mother = DB::table('registration_maintenance')->where('category_id', 5)->select('id')->get();
            foreach($family_history_mother as $a)
            {
                if($request->has('id:'.$a->id) && $request['id:'.$a->id] == true)
                {
                  $family_history_mother_checked[] = $a->id;
               }
            }
            $family_history_mother_checked = json_encode($family_history_mother_checked);
    
    
            DB::table('registration')->updateOrInsert(
                ['id' => $request->user_id],
                ['id' => $request->user_id, 'family_history_mother' => $family_history_mother_checked]
            );
         //   return response()->json(['message'=>'User access updated.'], $this->successStatus);
        }

        if ($request->action == 'li')
        {
            $lifestyle_info = DB::table('registration_maintenance')->where('category_id', 6)->select('id')->get();
            foreach($lifestyle_info as $a)
            {
                if($request->has('id:'.$a->id) && $request['id:'.$a->id] == true)
                {
                  $lifestyle_info_checked[] = $a->id;
               }
            }
            $lifestyle_info_checked = json_encode($lifestyle_info_checked);
    
    
            DB::table('registration')->updateOrInsert(
                ['id' => $request->user_id],
                ['id' => $request->user_id, 'lifestyle_info' => $lifestyle_info_checked]
            );
           // return response()->json(['message'=>'User access updated.'], $this->successStatus);
        }

        if ($request->action == 'pi')
        {
            $present_illnesses = DB::table('registration_maintenance')->where('category_id', 7)->select('id')->get();
            foreach($present_illnesses as $a)
            {
                if($request->has('id:'.$a->id) && $request['id:'.$a->id] == true)
                {
                  $present_illnesses_checked[] = $a->id;
               }
            }
            $present_illnesses_checked = json_encode($present_illnesses_checked);
    
    
            DB::table('registration')->updateOrInsert(
                ['id' => $request->user_id],
                ['id' => $request->user_id, 'present_illnesses' => $present_illnesses_checked]
            );
          //  return response()->json(['message'=>'User access updated.'], $this->successStatus);
        }

        if ($request->action == 'ih')
        {
            $immunization_history = DB::table('registration_maintenance')->where('category_id', 8)->select('id')->get();
            foreach($immunization_history as $a)
            {
                if($request->has('id:'.$a->id) && $request['id:'.$a->id] == true)
                {
                  $immunization_history_checked[] = $a->id;
               }
            }
            $immunization_history_checked = json_encode($immunization_history_checked);
    
    
            DB::table('registration')->updateOrInsert(
                ['id' => $request->user_id],
                ['id' => $request->user_id, 'immunization_history' => $immunization_history_checked]
            );
            return response()->json(['message'=>'Success! Patient details updated.'], $this->successStatus);
        }

        } catch (Exception $e) {
            return response()->json($e);
        }

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

    public function filter(Request $request)
    { 
       
        $Record_list = DB::table('registration as a')
        ->leftjoin('registration_maintenance as b', 'a.client_type_id', 'b.id')
        ->leftjoin('registration_maintenance as c', 'a.membership_category_id', 'c.id')
        ->select(
            'a.id',
            'a.philhealth_id',
            'a.registration_no',
            'b.name as client_type',
            'c.name as membership_category',
            DB::raw('CONCAT(a.last_name,\', \',a.first_name,\' \',a.extension,\', \',a.middle_name) as name'),
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
            'c.id as membership_category_id',
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
