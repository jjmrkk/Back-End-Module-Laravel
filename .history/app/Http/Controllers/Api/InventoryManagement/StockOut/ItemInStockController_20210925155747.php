<?php

namespace App\Http\Controllers\Api\InventoryManagement\StockOut;

use App\Http\Controllers\Controller;
use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ItemInStockController extends Controller
{
  public $successStatus = 200;
  public $errorStatus = 400;

  public function index()
  {
    try {

      $user = DB::table('user_access as a')
       ->where('a.user_id', Auth::id())
       ->select('a.description->inventory_management->warehouse_module->warehouses as warehouse_id')
       ->first();

      $warehouse = json_decode($user->warehouse_id);



      $items = DB::table('item_in_stocks') //id, balance, cost
      ->whereIn('item_in_stocks.warehouse_id', $warehouse)  //added by jm
        ->where('balance', '>', 0)
        ->join('item_details', 'item_in_stocks.item_detail_id', 'item_details.id') //item_code, name
        ->join('item_category_details', 'item_details.item_category_details_id', 'item_category_details.id') //category name
        ->join('unit_of_measures', 'item_in_stocks.unit_id', 'unit_of_measures.id') //unit name
        ->join('warehouses', 'item_in_stocks.warehouse_id', 'warehouses.id') //warehouse //added by JM
        ->join('item_locations', 'item_in_stocks.location_id', 'item_locations.id') //location //added by JM
       
        ->select(
          'item_in_stocks.id',
          'item_in_stocks.balance as quantity',
          'item_in_stocks.cost as unit_cost',
          'item_details.item_code',
          'item_details.name',
          // 'item_in_stocks.location', // removed by JM
          'warehouses.id as warehouse_id',
          'warehouses.name as warehouse_name',
          'item_locations.id as location_id',
          'item_locations.name as location_name',
          'item_category_details.name as category_name',
          'item_in_stocks.created_at',
        )
        ->orderBy('item_in_stocks.created_at', 'ASC')
        ->orderBy('item_details.id', 'ASC')
        ->get();
      return response()->json(['items' => $items], $this->successStatus);
    } catch (Exception $e) {
      return response()->json($e);
    }
  }

  public function SearchItem($search)
  {
    try {

      $user = DB::table('user_access as a')
      ->where('a.user_id', Auth::id())
      ->select('a.description->warehouses as warehouse_id')
      ->first();
    $warehouse = json_decode($user->warehouse_id);

      $items = DB::table('item_in_stocks') //id, balance, cost
        //  ->where('item_in_stocks.balance', '>', 0)
        ->join('item_details', 'item_in_stocks.item_detail_id', 'item_details.id') //item_code, name
        ->join('item_category_details', 'item_details.item_category_details_id', 'item_category_details.id') //category name
        ->join('unit_of_measures', 'item_in_stocks.unit_id', 'unit_of_measures.id') //unit name
        ->join('warehouses', 'item_in_stocks.warehouse_id', 'warehouses.id') //warehouse //added by JM
        ->join('item_locations', 'item_in_stocks.location_id', 'item_locations.id') //location //added by JM
        ->whereIn('item_in_stocks.warehouse_id', $warehouse)  //added by jm

        ->where(function ($query) use ($search) {
          $query->where([['item_details.name', 'ilike', "%$search%"], ['item_in_stocks.balance', '>', 0]]);
          $query->orWhere('item_details.item_code','ilike',"%$search%");
        })
        
        ->select(
          'item_in_stocks.id',
          'item_in_stocks.balance as quantity',
          'item_in_stocks.cost as unit_cost',
          'item_details.item_code',
          'item_details.name',
          // 'item_in_stocks.location', // removed by JM
          'warehouses.id as warehouse_id',
          'warehouses.name as warehouse_name',
          'item_locations.id as location_id',
          'item_locations.name as location_name',
          'item_category_details.name as category_name',
          'item_in_stocks.created_at',
        )
        ->orderBy('item_in_stocks.created_at', 'ASC')
        ->orderBy('item_details.id', 'ASC')
        ->get();
      return response()->json(['items' => $items], $this->successStatus);
    } catch (Exception $e) {
      return response()->json($e);
    }
  }
}
