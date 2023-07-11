<?php

namespace App\Http\Controllers\Api\InventoryManagement\Setting\Item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemBrandController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 400;
    public $branchid = 16;

    public function index()
    {
        $brand = DB::table('item_brands as a')
            ->where('a.business_unit_id', $this->branchid)
            ->select(
                'a.id',
                'a.name',
            )
            ->get();
        return response()->json($brand, 200);
    }

    public function show_brand($id)
    {
        $brand = DB::table('item_models as a')
        ->where('a.item_category_details_id', $id)
        ->leftjoin('item_brands as b', 'a.item_brand_id', 'b.id')
        ->select('b.name as brand_name')
        ->distinct()
        ->get();

        return response()->json($brand, 200);
    }

    public function store(Request $request)
    { }

    public function show($id, $cat_id)
    {
        $model = DB::table('item_models as a')
            ->where('a.item_brand_id', $id)
            ->where('a.item_category_details_id', $cat_id)
            ->select(
                'a.id',
                'a.name',
            )
            ->get();
        return response()->json($model, 200);
    }

    public function AttributeDetails($id)
    { }
}
