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
         //   $user = DB::table('user_access as a')
        //     ->where('a.user_id', Auth::id())
         //    ->select('a.description->inventory_management->warehouse_module->warehouses as warehouse_id')
         //    ->first();
         //   $warehouse = json_decode($user->warehouse_id);
      
          //  return $warehouse;

          $warehouse = "1";
      
            $warehouses_name = DB::table('warehouses as b')
              ->whereIn('b.id', $warehouse)
              ->where('b.active', true)
              ->select(
                'b.id',
                'b.name',
                'b.description',
                DB::raw('null as location')
              )
              ->get();
      
            foreach ($warehouses_name as $warehouse) {
              $warehouse_location = DB::table('item_locations as a')
                ->where('a.warehouse_id', $warehouse->id)
                ->select(
                  'a.id',
                  'a.name',
                  'a.description'
                )
                ->get();
              $warehouse->location = $warehouse_location;
            }
            return response()->json($warehouses_name, 200);
          } catch (Exception $e) {
            return response()->json($e);
          }

    }

    public function show($id)
    {
       
    }
}
