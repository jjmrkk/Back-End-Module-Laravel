<?php

namespace App\Http\Controllers\Api\Administrator\User;

use App\Http\Controllers\Controller;
use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BusinessUnitController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 400;

    public function index()
    {
        try {
            $businessUnits = DB::table('business_units as branch')
                                ->whereIn('branch.business_unit_type_id', [4]) //Branch
                                ->leftJoin('business_unit_relations as l', 'branch.id', 'l.child')
                                ->leftJoin('business_units as location', 'l.parent', 'location.id')
                                ->orderBy('branch.name', 'ASC')
                                ->select('branch.id', 'branch.name as branch', 'location.name as location')
                                ->get();
            return response()->json(['businessUnits'=>$businessUnits], $this->successStatus);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
