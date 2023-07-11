<?php

namespace App\Http\Controllers\Api\BicolHealthFacility\User;

use App\Http\Controllers\Controller;
use App\Exceptions\Handler;
use Illuminate\Http\Request;
//use App\Http\Requests\Api\Administrator\User\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 400;

    public function index()
    {
        try {
            $users = DB::table('users')
                        ->join('user_profiles', 'user_profiles.user_id', 'users.id')
                        ->join('business_unit_positions', 'business_unit_positions.id', 'user_profiles.business_unit_position_id')
                        ->join('business_units', 'business_units.id', 'user_profiles.business_unit_id')
                        ->select(
                            'users.active', 'users.email', 'user_profiles.first_name', 'user_profiles.middle_name', 'user_profiles.last_name',
                            'user_profiles.contact_no', 'user_profiles.employee_no', 'user_profiles.theme', 'user_profiles.business_unit_id',
                            'user_profiles.business_unit_position_id', 'business_unit_positions.name as position_name', 'business_units.name as department_name',
                            DB::raw('null as business_unit_name'), 'users.id',
                        )->get();
           
            return response()->json(['users'=>$users], $this->successStatus);
        } catch (Exception $e) {
			return response()->json($e);
		}
    }


    public function store(Request $request)
    {
       // return response()->json(['message'=>'Success! User created.'], $this->successStatus); 

        try {
            $dbTrans = DB::transaction(function () use ($request) {
                $trims = ['email', 'password', 'employee_no', 'first_name', 'middle_name', 'last_name', 'contact_no', 'theme'];
                foreach($trims as $trim) 
                {
                    $request[$trim] = trim($request[$trim], ' ');
                }
                $user = DB::table('users')->insertGetId([
                            'email' => $request->email,
                            'password' => Hash::make(12345678),
                        ]);
                $userProfile = DB::table('user_profiles')->insert([
                                    'user_id' => $user,
                                    'employee_no' => $request->employee_no,
                                    'first_name' => strtoupper($request->first_name),
                                    'middle_name' => strtoupper($request->middle_name),
                                    'last_name' => strtoupper($request->last_name),
                                    'contact_no' => 0,
                                    'business_unit_id' => $request->department_id,
                                    'group_id' => $request->group_id,
                                    'business_unit_position_id' => $request->business_unit_position_id,
                                    'theme' => strtolower($request->theme),
                                ]);
                $userAccess = DB::table('user_access')->insert([
                                    'user_id' => $user,
                                    'description' => json_encode([
                                        "bicol_health_facility" => [
                                            "user_module" => [
                                                "functions" => [
                                                    "access" => false,
                                                    "edit" => false,
                                                    "view" => false,
                                                ],
                                            ],
                                            "record_module" => [
                                                "functions" => [
                                                    "access" => false,
                                                    "edit" => false,
                                                    "view" => false,
                                                    "print" => false,
                                                ],     
                                            ],
                                            "registration_module" => [
                                                "functions" => [
                                                    "access" => false,
                                                ],     
                                            ],
                                            "system_maintenance_module" => [
                                                "functions" => [
                                                    "access" => false,
                                                    "edit" => false,
                                                ],     
                                            ],
                                        ]
                                    ])
                                ]);
                return $user && $userProfile && $userAccess ? true : false;
            });
            return $dbTrans ? response()->json(['message' => 'Success! User has been added.'], $this->successStatus) : response()->json(['message' => 'User has not been added. Contact Administrator.'], $this->errorStatus);
        } catch (Exception $e) {
			return response()->json($e);
		}
    }

    public function access($id)
    {
        try {
            $access = DB::table('user_access')->where('user_id', $id)->first();
            return response()->json($access->description, $this->successStatus);
		} catch (Exception $e) {
			return response()->json($e);
		}
    }

    public function update_access(Request $request)
    {
        try {
            $modules = DB::table('modules')
                            ->join('module_functions', 'modules.id', 'module_functions.module_id')
                            ->select('modules.id as id', 'modules.system_id as system_id', 'modules.name as name', 'modules.description as description', 'module_functions.functions as functions')
                            ->get();
            foreach($modules as $module)
            {
                $module->functions = json_decode($module->functions, true);
            }
            $access = [];
          //  $access['business_units'] = [];
          //  $access['documents'] = [];
            foreach($modules as $module)
            {
             //   if($request->has($module->name))
             //   {
             //      $access[$module->name] = ['access' => $request[$module->name], 'functions' => []];
             //   }
                
                foreach($module->functions as $function)
                {
                    if($request->has($module->name . '.' . $function)) 
                    {
                        $access['bicol_health_facility'][$module->name]['functions'][$function] = $request[$module->name . '.' . $function];
                    }
                }
            }
            
            $access = json_encode($access);
            DB::table('user_access')->updateOrInsert(
                ['user_id' => $request->user_id],
                ['user_id' => $request->user_id, 'description' => $access]
            );
            return response()->json(['message'=>'Success! User access updated.'], $this->successStatus);
        } catch (Exception $e) {
			return response()->json($e);
		}
    }
}
