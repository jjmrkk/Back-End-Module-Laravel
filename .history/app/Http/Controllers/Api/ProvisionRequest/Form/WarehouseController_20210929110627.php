<?php

namespace App\Http\Controllers\Api\ProvisionRequest\Form;

use App\Http\Controllers\Controller;
use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 400;

    public function show($id)
    {
     //   try {
    //        $explode_id = explode('_', $id);
    //        if($explode_id[0] == 1) 
    //        {
    //            $business_unit = DB::table('projects')->where('id', $explode_id[1])->first();
    //            $business_unit_id = $business_unit->business_unit_id;
    //        }
   //         elseif($explode_id[0] == 0)
    //        {
    //            $business_unit = DB::table('business_unit_relations')->where('child', $explode_id[1])->first();
    //            $business_unit_id = $business_unit->parent;
    //        }
    //        $warehouses = DB::table('warehouses')->where('active', true)->where('business_unit_id', $business_unit_id)->select('id', 'name', 'description', 'code')->get();
    //        return response()->json(['warehouses'=>$warehouses], $this->successStatus);
    //    } catch (Exception $e) {
	//		return response()->json($e);
	//	}

    try {
        $warehouses_name = DB::table('warehouses as b')
          ->whereIn('b.id', $id)
          ->where('b.active', true)
          ->leftjoin('business_units as a', 'b.business_unit_id', 'a.id') 
          ->select(
            'b.id',
            'b.name',
            'b.description',
            'a.name as business_unit_name',
            'a.id as business_unit_id',
          )
          ->get();
        return response()->json($warehouses_name, 200);
      } catch (Exception $e) {
        return response()->json($e);
      }



    }
}
