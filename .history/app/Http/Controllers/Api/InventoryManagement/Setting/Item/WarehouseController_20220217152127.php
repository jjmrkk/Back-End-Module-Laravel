<?php

namespace App\Http\Controllers\Api\InventoryManagement\Setting\Item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class WarehouseController extends Controller
{
  public $successStatus = 200;
  public $errorStatus = 400;
  public $branchid = 13;


  private function module()
    {
        $userAccess = DB::table('user_access')
        ->where('user_id', Auth::id())
        ->select('description->inventory_management->warehouse_module as warehouse_module')->first();
        return json_decode($userAccess->warehouse_module);
    }

  public function index()
  {
    try {

      $module = $this->module();
      if($module->access == false)
      {
          return response()->json(['message'=>"No Access For This Module."], $this->errorStatus);
      }
      $user = DB::table('user_access as a')
       ->where('a.user_id', Auth::id())
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
          'a.name as business_unit_name',
          'a.id as business_unit_id',
          'a.description as unit_location',

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


  public function store(Request $request)
  {

    try {

      $name = ucwords($request->name);
      $name_check = DB::table('warehouses')
        ->where('name', $name)
        ->exists();
      if ($name_check) {
        return response()->json(['message' => "Duplicate warehouse Entry Found."], $this->errorStatus);
      } else {
        //         return response()->json(['message'=>"Success. You have been successfully added new warehouse!!!!"], $this->successStatus);        

        $now = Carbon::now();
      
        $warehouse = DB::table('warehouses')->insert([
          'name' => ucwords($request->name),
          'description' => $request->description,
          'code' => 'ABCD',
          'active' => true,
          'business_unit_id' => $request->business_unit_id,
          'user_id' => Auth::id(),
          'created_at' => $now,
          'updated_at' => $now,
        ]);
        if ($warehouse) {
          return response()->json(['message' => "Success. You have been successfully added new warehouse!"], $this->successStatus);
        }
      }
    } catch (\Exception $exception) {
      return $exception;
    }
  }


  public function show($id)
  {
    $warehouse_crate = DB::table('item_locations as a')
      ->where('a.warehouse_id', $id)
      ->select(
        'a.id',
        'a.name',
        'a.description'
      )
      ->get();
    return response()->json($warehouse_crate, 200);
  }

  public function business_unit()
  {
    $business_unit = DB::table('business_units as a')
      ->where('a.business_unit_type_id', 4)
      ->select(
        'a.id',
        'a.name',
        'a.description as unit_location',
      )
      ->get();
    return response()->json($business_unit, 200);
  }

}
