<?php

namespace App\Http\Controllers\Api\InventoryManagement\Setting\Item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LocationController extends Controller
{
  public $successStatus = 200;
  public $errorStatus = 400;

  public function index()
  { }

  public function show($id)
  {
    $warehouse_location = DB::table('item_locations as a')
      ->where('a.warehouse_id', $id)
      ->select(
        'a.id',
        'a.name',
        'a.description'
      )
      ->get();
    return response()->json($warehouse_location, 200);
  }

  public function store(Request $request)
  {
    try {

      $name = ucwords($request->name);
      $warehouse_id = ($request->warehouse_id);
      $name_check = DB::table('item_locations')
        ->where('name', $name)
        ->where('warehouse_id', $warehouse_id)->exists();
      if ($name_check) {
        return response()->json(['message' => "Duplicate Location Name Entry Found."], $this->errorStatus);
      } else {
        //      return response()->json(['message'=>"Success. You have been successfully added new location!"], $this->successStatus);        


        $now = Carbon::now();

        $location = DB::table('item_locations')->insert([
          'name' => ucwords($request->name),
          'description' => $request->description,
          'warehouse_id' => $request->warehouse_id,
          'created_at' => $now,
          'updated_at' => $now,
        ]);

        if ($location) {
          return response()->json(['message' => "Success. You have been successfully added new location!"], $this->successStatus);
        }
      }
    } catch (\Exception $exception) {
      return $exception;
      //   return response()->json(['error'=>"Warning. Please Contact your system administrator"], $this->errorStatus);
    }
  }
}
