<?php

namespace App\Http\Controllers\Api\Administrator\User;

use App\Http\Controllers\Controller;
use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BusinessUnitPositionController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 400;

    public function show($id)
    {
        try {
            $businessUnitPositions = DB::table('business_unit_positions')
                                        ->where('business_unit_id', $id)
                                        ->orderBy('name', 'ASC')
                                        ->select('id', 'name')
                                        ->get();
            return response()->json(['businessUnitPositions'=>$businessUnitPositions], $this->successStatus);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
