<?php

namespace App\Http\Controllers\Api\InventoryManagement\Setting\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ItemWarehouseController extends Controller
{

    public $successStatus = 200;
    public $errorStatus = 400;
    public $branchid = 13;


    public function index()
    {
      
        try {
            $user = DB::table('user_access as a')
          //  ->where('a.user_id', Auth::id())
            ->where('a.user_id', 26)
             ->select('a.description->inventory_management->warehouse_module->warehouses as warehouse_id')
             ->first();
            $warehouse = json_decode($user->warehouse_id);
      
          //  return $warehouse;

          $warehouses_name = DB::table('warehouses as b')
          ->whereIn('b.id', $warehouse)
          ->where('b.active', true)
          ->leftjoin('business_units as a', 'b.business_unit_id', 'a.id')
          ->select(
            'b.id',
            'b.name',
            'b.description',
            'a.name as business unit name'
          )
          ->get();
  

        return response()->json($warehouses_name, 200);
      } catch (Exception $e) {
        return response()->json($e);
      }

    }

    public function show($id)
    {
       
    }
}
