<?php

namespace App\Http\Controllers\Api\InventoryManagement\Setting\Brand;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class ItemBrandController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 400;


    public $branchid = 13;

    public function index()
    {
        $brand = DB::table('item_brands as a')
            ->where('a.business_unit_id', $this->branchid)
            ->select(
                'a.id',
                'a.name',
                DB::raw('null as model')
            )
            ->get();

        foreach ($brand as $models) {
            $brandmodel = DB::table('item_models as b')
                ->where('b.item_brand_id', $models->id)
                ->select(
                    'b.id as model_id',
                    'b.name as model_name',
                    'b.item_supplier_id',
                    DB::raw('null as supplier_array')
                )
                ->get();

            $models->model = $brandmodel;
        }

        return response()->json($brand, 200);
    }

    public function show($id)
    {
        $brand = DB::table('item_brands as a')
        ->where('a.warehouse_id', $id)
            ->select(
                'a.id',
                'a.name',
                DB::raw('null as model')
            )
            ->get();

        foreach ($brand as $models) {
            $brandmodel = DB::table('item_models as b')
                ->where('b.item_brand_id', $models->id)
                ->leftjoin('item_category_details as c', 'b.item_category_details_id', 'c.id')
                ->select(
                    'b.id as model_id',
                    'b.name as model_name',
                    'b.item_supplier_id',
                    'c.name as category_name',
                    DB::raw('null as supplier_array')
                )
                ->get();

            if (count($brandmodel)) {
                foreach ($brandmodel as $supplier) {
                    $supplier->item_supplier_id = json_decode($supplier->item_supplier_id, true);

                    if (count($supplier->item_supplier_id)) {
                        foreach ($supplier->item_supplier_id as $item_supplier_id) {
                            $supplier->supplier_array[] = DB::table('item_supplier')
                                ->where('id', $item_supplier_id)
                                ->select(
                                    'id as item_supplier_id',
                                    'name as supplier_name'
                                )
                                ->get();
                        }
                    }
                }
            }
            $models->model = $brandmodel;
        }
        return response()->json($brand, 200);
    }


    public function store(Request $request)
    {
        try {
            $name = ucwords($request->name);


            $name_check = DB::table('item_brands')
                ->where('name', $name)
                ->where('business_unit_id', $request->business_unit_id)->exists();
            if ($name_check) {
                return response()->json(['message' => "Duplicate Brand Entry Found."], $this->errorStatus);
            }
            //           else
            //         {
            //               return response()->json(['message'=>"Success. You have been successfully added new Brand!"], $this->successStatus);
            //         }

            $now = Carbon::now();
            $brand = DB::table('item_brands')->insert([
                'name' => ucwords($request->name),
                'business_unit_id' => $request->business_unit_id,
                'warehouse_id' => $request->warehouse_id,
                'user_id' => Auth::id(),
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            return response()->json(['message' => "Success. New Brand Successfully added"], $this->successStatus);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
    public function show_model($id)
    {
        $brand = DB::table('item_brands as a')
            ->where('a.id', $id)
            ->select(
                'a.id',
                'a.name',
                DB::raw('null as model')
            )
            ->get();

        foreach ($brand as $models) {
            $brandmodel = DB::table('item_models as b')
                ->where('b.item_brand_id', $models->id)
                ->leftjoin('item_category_details as c', 'b.item_category_details_id', 'c.id')
                ->select(
                    'b.id as model_id',
                    'b.name as model_name',
                    'b.item_supplier_id',
                    'c.name as category_name',
                    DB::raw('null as supplier_array')
                )
                ->get();

            if (count($brandmodel)) {
                foreach ($brandmodel as $supplier) {
                    $supplier->item_supplier_id = json_decode($supplier->item_supplier_id, true);

                    if (count($supplier->item_supplier_id)) {
                        foreach ($supplier->item_supplier_id as $item_supplier_id) {
                            $supplier->supplier_array[] = DB::table('item_supplier')
                                ->where('id', $item_supplier_id)
                                ->select(
                                    'id as item_supplier_id',
                                    'name as supplier_name'
                                )
                                ->get();
                        }
                    }
                }
            }
            $models->model = $brandmodel;
        }
        return response()->json($brand, 200);
    }
}
