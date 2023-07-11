<?php

namespace App\Http\Controllers\Api\Administrator\User;

use App\Http\Controllers\Controller;
use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 400;

    public function show($id)
    {
        try {
            $departments = DB::table('business_unit_relations as d')
                            ->where('d.parent', $id)
                            ->join('business_units as department', 'd.child', 'department.id')
                            ->orderBy('department.name', 'ASC')
                            ->select('department.id', 'department.name as department')
                            ->get();
            return response()->json(['departments'=>$departments], $this->successStatus);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
