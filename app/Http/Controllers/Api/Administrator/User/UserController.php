<?php

namespace App\Http\Controllers\Api\Administrator\User;

use App\Http\Controllers\Controller;
use App\Exceptions\Handler;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Administrator\User\UserRequest;
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
                            'users.email', 'user_profiles.first_name', 'user_profiles.middle_name', 'user_profiles.last_name',
                            'user_profiles.contact_no', 'user_profiles.employee_no', 'user_profiles.theme', 'user_profiles.business_unit_id',
                            'user_profiles.business_unit_position_id', 'business_unit_positions.name as position_name', 'business_units.name as department_name',
                            DB::raw('null as business_unit_name'), 'users.id',
                        )->get();
            if($users)
            {
                foreach($users as $user)
                {
                    $user->business_unit_name = $this->businessUnit($user->business_unit_id);
                }
            }
            return response()->json(['users'=>$users], $this->successStatus);
        } catch (Exception $e) {
			return response()->json($e);
		}
    }

    public function store(UserRequest $request)
    {
        try {
            $dbTrans = DB::transaction(function () use ($request) {
                $trims = ['email', 'password', 'employee_no', 'first_name', 'middle_name', 'last_name', 'contact_no', 'theme'];
                foreach($trims as $trim) 
                {
                    $request[$trim] = trim($request[$trim], ' ');
                }
                $user = DB::table('users')->insertGetId([
                            'email' => $request->email,
                            'password' => Hash::make($request->password),
                        ]);
                $userProfile = DB::table('user_profiles')->insert([
                                    'user_id' => $user,
                                    'employee_no' => $request->employee_no,
                                    'first_name' => strtoupper($request->first_name),
                                    'middle_name' => strtoupper($request->middle_name),
                                    'last_name' => strtoupper($request->last_name),
                                    'contact_no' => $request->contact_no,
                                    'business_unit_id' => $request->department_id,
                                    'group_id' => $request->group_id,
                                    'business_unit_position_id' => $request->business_unit_position_id,
                                    'theme' => strtolower($request->theme),
                                ]);
                $userAccess = DB::table('user_access')->insert([
                                    'user_id' => $user,
                                    'description' => json_encode([
                                        "provision_request"=> [
                                            "form_module" => [
                                                "access" => true,
                                                "functions" => [],
                                                "business_units" => [],
                                                "projects" => []
                                            ],
                                            "transaction_module" => [
                                                "access" => true,
                                                "functions" => [],
                                                "business_units" => [],
                                                "projects" => []
                                            ],
                                            "approval_module" => [
                                                "access" => true,
                                                "functions" => [],
                                                "business_units" => [],
                                                "projects" => [],
                                                "approver" => []
                                            ]
                                        ],
                                        "inventory_management" => [
                                            "provision_request_module" =>[
                                                "access" => true,
                                                "functions" => [],
                                                "business_units" => [],
                                                "projects" => []
                                            ]
                                        ],
                                        "administrator" => [
                                            "user_module" => [
                                                "access" => true,
                                                "functions" => [
                                                    "add" => true,
                                                    "edit" => true,
                                                    "view" => true,
                                                    "access" => true,
                                                    "delete" => true,
                                                    "search" => true
                                                ],
                                            ],
                                            "business_unit_module" => [
                                                "access" => true,
                                                "functions" => [],
                                                "business_units" => [],
                                                "projects" => []
                                            ]
                                        ]
                                    ])
                                ]);
                return $user && $userProfile && $userAccess ? true : false;
            });
            return $dbTrans ? response()->json(['message' => 'User has been added.'], $this->successStatus) : response()->json(['message' => 'User has not been added. Contact Administrator.'], $this->errorStatus);
        } catch (Exception $e) {
			return response()->json($e);
		}
    }

    public function show($id) 
    {
        try {
            $user = DB::table('users')
                        ->where('users.id', $id)
                        ->join('user_profiles as profile', 'users.id', 'profile.user_id')
                        ->join('business_unit_relations as relation', 'profile.business_unit_id', 'relation.child')
                        ->select(
                            'users.id', 'users.email', 'profile.employee_no', 'profile.first_name', 
                            'profile.middle_name', 'profile.last_name', 'profile.contact_no', 'profile.business_unit_id as department_id',
                            'profile.business_unit_position_id', 'profile.theme', 'relation.parent as business_unit_id'
                        )->first();
            return response()->json(['user'=>$user], $this->successStatus);
        } catch (Exception $e) {
			return response()->json($e);
		}
    }

    public function update(UserRequest $request)
    {
        //
    }

    private function businessUnit($id)
    {
        try {
            $businessUnit = DB::table('business_units as department')
                                ->where('department.id', $id)
                                ->leftJoin('business_unit_relations as b', 'b.child', 'department.id')
                                ->leftJoin('business_units as branch', 'branch.id', 'b.parent')
                                ->leftJoin('business_unit_relations as l', 'branch.id', 'l.child')
                                ->leftJoin('business_units as location', 'l.parent', 'location.id')
                                ->select('branch.name as branch', 'location.name as location')
                                ->first();
            return $businessUnit->branch . ' (' . $businessUnit->location . ')';
        } catch (Exception $e) {
			return response()->json($e);
		}
    }
}
