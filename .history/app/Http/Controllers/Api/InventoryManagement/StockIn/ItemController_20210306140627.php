<?php

namespace App\Http\Controllers\Api\InventoryManagement\StockIn;

use App\Http\Controllers\Controller;
use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ItemController extends Controller
{
  public $successStatus = 200;
  public $errorStatus = 400;

  public function index()
  {
    try {
      $user = DB::table('user_access as a')
        ->where('a.user_id', Auth::id())
        ->select('a.description->warehouses as warehouse_id')
        ->first();
      $warehouse = json_decode($user->warehouse_id);

      $items = DB::table('item_details as a')
        ->leftjoin('item_category_details as b', 'a.item_category_details_id', 'b.id')
        ->leftjoin('item_brands as c', 'a.item_brand_id', 'c.id')
        ->leftjoin('item_models as d', 'a.item_model_id', 'd.id')
        ->leftjoin('warehouses as e', 'a.warehouse_id', 'e.id')
        ->leftjoin('item_locations as f', 'a.item_location_id', 'f.id')
        ->leftjoin('unit_of_measures as g', 'b.unit_id', 'g.id')
        //->where('a.name','LIKE',"%$search%")
        //->where('e.branch_id', $this->branchid)
        ->whereIn('a.warehouse_id', $warehouse)
        ->select(
          'a.id',
          'a.item_code',
          'a.name',
          'a.quantity',
          'b.name as category_name',
          'b.code as category_code',
          'c.name as brand_name',
          'd.name as model_name',
          'e.id as warehouse_id',
          'e.name as warehouse_name',
          'f.name as location_name',
          'a.minimum',
          'a.maximum',
          'b.unit_id',
          'g.name as measurement_name',
          'g.abbr as measurement_abbr',    
        )
        ->orderBy('a.id', 'ASC')
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


      $items = DB::table('item_details as a')
        ->leftjoin('item_category_details as b', 'a.item_category_details_id', 'b.id')
        ->leftjoin('item_brands as c', 'a.item_brand_id', 'c.id')
        ->leftjoin('item_models as d', 'a.item_model_id', 'd.id')
        ->leftjoin('warehouses as e', 'a.warehouse_id', 'e.id')
        ->leftjoin('item_locations as f', 'a.item_location_id', 'f.id')
        ->leftjoin('unit_of_measures as g', 'b.unit_id', 'g.id')
        ->whereIn('a.warehouse_id', $warehouse)
       // ->where('a.name', 'ilike', "%$search%")
       // ->orwhere('a.item_code','ilike',"%$search%")
        ->where(function ($query) use ($search) {
          $query->where('a.name', 'ilike', "%$search%");
          $query->orWhere('a.item_code','ilike',"%$search%");
      })
        
        ->select(
          'a.id',
          'a.item_code',
          'a.name',
          'a.quantity',
          'b.name as category_name',
          'b.code as category_code',
          'c.name as brand_name',
          'd.name as model_name',
          'e.id as warehouse_id',
          'e.name as warehouse_name',
          'f.name as location_name',
          'a.minimum',
          'a.maximum',
          'b.unit_id',
          'g.name as measurement_name',
          'g.abbr as measurement_abbr',
        )
        ->orderBy('a.id', 'ASC')
        ->get();
      return response()->json(['items' => $items], $this->successStatus);
    } catch (Exception $e) {
      return response()->json($e);
    }
  }
}
