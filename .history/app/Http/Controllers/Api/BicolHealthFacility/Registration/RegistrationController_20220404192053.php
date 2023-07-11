<?php

namespace App\Http\Controllers\Api\BicolHealthFacility\Registration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RegistrationController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 400;

    public function index()
    { }

    public function store(Request $request)
    { 
        try {

            $phil_health_no = DB::table('registration')
            ->where('philhealth_id', $request->philhealth_id)
            ->exists();
            if ($phil_health_no) {
            return response()->json(['message' => "Duplicate PhilHealth No. Entry Found for $request->philhealth_id."], $this->errorStatus);
            }
           
            $now = Carbon::now();
            $reg_details = DB::table('registration')->insert([
                        'philhealth_id' => $request->philhealth_id,
                        'client_type_id' => $request->client_type_id,
                        'membership_category_id' => $request->membership_category_id,
                        'last_name' => $request->last_name,
                        'first_name' => $request->first_name,
                        'middle_name' => $request->middle_name,
                        'extension' => $request->extension,
                        'date_of_birth' => $request->date_of_birth,
                        'gender' => $request->gender,
                        'contact_number' => $request->contact_number,
                        'home_address' => $request->home_address,
                        'email' => $request->email,
                        'hospitalization' => json_encode($request->hospitalization),
                        'previous_illnesses' => json_encode($request->previous_illnesses, JSON_NUMERIC_CHECK),          
                        'family_history_father' => json_encode($request->family_history_father, JSON_NUMERIC_CHECK),
                        'family_history_mother' => json_encode($request->family_history_mother, JSON_NUMERIC_CHECK),          
                        'lifestyle_info' => json_encode($request->lifestyle_info, JSON_NUMERIC_CHECK),
                        'present_illnesses' => json_encode($request->present_illnesses, JSON_NUMERIC_CHECK),
                        'immunization_history' => json_encode($request->immunization_history, JSON_NUMERIC_CHECK), //revove quatation " "
                        'maintenance_medication' => $request->maintenance_medication,
                        'note' => $request->note,
                       // 'user_id' => Auth::id(),
                        'user_id' => '11',
                        'created_at' => $now,
                        'updated_at' => $now,
            ]);
            return response()->json(['message' => "Success! Registration Complete."], $this->successStatus);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function show($id)
    { }

    public function show_maintenance($action)
    { 
        if($action == 'client_type')
        {
            $Client_Type = DB::table('registration_maintenance as a')
            ->leftjoin('registration_maintenance_categories as b', 'a.category_id', 'b.id')
            ->where('b.id', 1)
            ->select(
                'a.id',
                'a.name',
                'a.description',
                'b.name as category_name'
            )
            ->get();
            return response()->json($Client_Type, 200);
        }
        if($action == 'membership_category')
        {
            $Membership_Category = DB::table('registration_maintenance as a')
            ->leftjoin('registration_maintenance_categories as b', 'a.category_id', 'b.id')
            ->where('b.id', 2)
            ->select(
                'a.id',
                'a.name',
                'a.description',
                'b.name as category_name'
            )
            ->get();
            return response()->json($Membership_Category, 200);
        }
        if($action == 'previous_illnesses')
        {
            $Previous_Illnesses = DB::table('registration_maintenance as a')
            ->leftjoin('registration_maintenance_categories as b', 'a.category_id', 'b.id')
            ->where('b.id', 3)
            ->select(
                'a.id',
                'a.name',
                'a.description',
                'b.name as category_name'
            )
            ->get();
            return response()->json($Previous_Illnesses, 200);
        }
        if($action == 'family_history_father')
        {
            $Family_History = DB::table('registration_maintenance as a')
            ->leftjoin('registration_maintenance_categories as b', 'a.category_id', 'b.id')
            ->where('b.id', 4) //father side
            ->select(
                'a.id',
                'a.name',
                'a.description',
                'b.id as category_id',
                'b.name as category_name'
            )
            ->orderBy('a.id', 'asc')
            ->get();
            return response()->json($Family_History, 200);
        }

        if($action == 'family_history_mother')
        {
            $Family_History = DB::table('registration_maintenance as a')
            ->leftjoin('registration_maintenance_categories as b', 'a.category_id', 'b.id')
            ->where('b.id', 5) //Mother side
            ->select(
                'a.id',
                'a.name',
                'a.description',
                'b.id as category_id',
                'b.name as category_name'
            )
            ->orderBy('a.id', 'asc')
            ->get();
            return response()->json($Family_History, 200);
        }

        if($action == 'lifestyle_info')
        {
            $Lifestyle_info = DB::table('registration_maintenance as a')
            ->leftjoin('registration_maintenance_categories as b', 'a.category_id', 'b.id')
            ->where('b.id', 6)
            ->select(
                'a.id',
                'a.name',
                'a.description',
                'b.name as category_name'
            )
            ->get();
            return response()->json($Lifestyle_info, 200);
        }
        if($action == 'present_illnesses')
        {
            $Present_Illnesses = DB::table('registration_maintenance as a')
            ->leftjoin('registration_maintenance_categories as b', 'a.category_id', 'b.id')
            ->where('b.id', 7)
            ->select(
                'a.id',
                'a.name',
                'a.description',
                'b.name as category_name'
            )
            ->get();
            return response()->json($Present_Illnesses, 200);
        }
        if($action == 'immunization_history')
        {
            $Immunization_History = DB::table('registration_maintenance as a')
            ->leftjoin('registration_maintenance_categories as b', 'a.category_id', 'b.id')
            ->where('b.id', 8)
            ->select(
                'a.id',
                'a.name',
                'a.description',
                'b.name as category_name'
            )
            ->get();
            return response()->json($Immunization_History, 200);
        }
        return response('No Record Found');
    }
}
