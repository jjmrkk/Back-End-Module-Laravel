<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnitOfMeasureController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 400;

    public function index()
    {
        try {
            $unitOfMeasures = DB::table('unit_of_measures')->get();
            return response()->json(['unitOfMeasures'=>$unitOfMeasures], $this->successStatus);
        } catch (Exception $e) {
			return response()->json($e);
		}
    }
}
