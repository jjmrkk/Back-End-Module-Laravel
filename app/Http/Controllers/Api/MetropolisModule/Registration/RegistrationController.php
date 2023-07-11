<?php

namespace App\Http\Controllers\Api\MSSTest\Registration;

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
        $now = Carbon::now();

        try {

            $visitors_id = DB::table('mss_registration as a')
            ->leftjoin('mss_registration_status as b', 'a.id', 'b.mss_registration_id') 
            ->where('a.visitor_id_no', $request->visitors_id)
            ->where('b.check_out','=', null)
            ->exists();

            if ($visitors_id) {
            return response()->json(['message' => "This Visitors ID No. $request->visitors_id are not properly return. "], $this->errorStatus);
            }

            $mss_registration = DB::table('mss_registration')->insertGetId([
                       'visitor_id_no' => $request->visitors_id,
                       'visit_type_id' => $request->visit_type_id,
                       'last_name' => $request->last_name,
                       'first_name' => $request->first_name,
                       'gender' => $request->gender,
                       'contact_no' => $request->contact_number,
                       'purpose_of_visit' => $request->purpose_of_visit,
                       'note' => $request->note,
                       'user_id' => Auth::id(),
                       'created_at' => $now
           ]);

           $mss_registration_status = DB::table('mss_registration_status')->insert([
            'mss_registration_id' => $mss_registration,
            'contact_no' => $request->contact_number,
            'check_in' => $now,
          ]);

            return response()->json(['message' => "Success! Registration Complete."], $this->successStatus);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function show_maintenance($action)
    { 
        if($action == 'visit_type')
        {
            $Visit_Type = DB::table('mss_registration_maintenance as a')
            ->where('a.category_id', 1) //Category ID # Coreesponding to visit type
            ->select(
                'a.id',
                'a.name',
                'a.description',
            )
            ->get();
            return response()->json($Visit_Type, 200);
        }
        return response('No Record Found');
    }
}
