<?php

namespace App\Http\Controllers\Api\BicolHealthFacility\RegistrationHealthMaintenance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RegistrationMaintenanceController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 400;

    public function index()
    { }

    public function store(Request $request)
    { }

    public function show($id)
    { }

    public function show_maintenance(Request $request)
    { 
        if($request == 'Client_Type')
        {
            $client_type = DB::table('registration_maintenance as a')
            ->leftjoin('registration_maintenance_categories as b', 'a.category_id', 'b.id')
            ->where('b.id', 1)
            ->select(
                'a.id',
                'a.name',
                'a.description',
                'b.name as category_name'
            )
            ->get();
            return response()->json($client_type, 200);
        }
        if($request == 'Membership_Category')
        {
            
        }
        if($request == 'Previous_Illnesses')
        {
            
        }
        if($request == 'Family_History')
        {
            
        }
        if($request == 'Addiction')
        {
            
        }
        if($request == 'Present_Illnesses')
        {
            
        }
        if($request == 'Immunization_History')
        {
            
        }

    }

}
