<?php

namespace App\Http\Controllers\Api\InventoryManagement\Setting\Item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemCategoryController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 400;
    public $branchid = 16;

    public function index()
    {
        $maincategory = DB::table('item_category_details as a')
            ->where('a.business_unit_id', $this->branchid)
            ->where('a.tag', '1')
            ->select(
                'a.id',
                'a.name',
                'a.description'
            )
            ->get();
        return response()->json($maincategory, 200);
    }

    public function store(Request $request)
    { }
    public function show($id)
    {
        $relation = DB::table('item_category_relations as b')
            ->where('b.parent', $id)
            ->leftjoin('item_category_details as a', 'b.child', 'a.id')
            ->select(
                'a.id',
                'a.name',
                'a.code',
                'a.description'
            )
            ->get();
        return response()->json($relation, 200);
    }
}
