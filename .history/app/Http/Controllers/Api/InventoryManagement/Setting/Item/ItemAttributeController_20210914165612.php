<?php

namespace App\Http\Controllers\Api\InventoryManagement\Setting\Item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemAttributeController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 400;

    public function index()
    { }

    public function store(Request $request)
    { }
    public function show($id)
    {
        $categories = DB::table('item_category_details as b')
            ->leftjoin('unit_of_measures as a', 'b.unit_id', 'a.id')
            ->where('b.id', $id)
            ->select(
                'b.id',
                'b.name',
                'b.code',
                'b.description',
                'b.attribute_id',
                'b.unit_id',
                'a.id as unit_id',
                'a.name as measurement_name',
                DB::raw('null as attribute_array')
            )
            ->get();

        if (count($categories)) {
            foreach ($categories as $attribute) {
                $attribute->attribute_id = json_decode($attribute->attribute_id, true);
                if (count($attribute->attribute_id)) {
                    foreach ($attribute->attribute_id as $attribute_id) {
                        $attribute->attribute_array[] = DB::table('item_attributes')
                            ->where('id', $attribute_id)
                            ->select(
                                'id as attribute_id',
                                'name as attribute_name',
                                'description as attribute_description'
                            )
                            ->get();
                    }
                }
            }
        }
        return response()->json($categories, 200);
    }

    public function AttributeDetail($id)
    {
        $categories = DB::table('item_category_details as b')
            ->leftjoin('unit_of_measures as a', 'b.unit_id', 'a.id')
            ->where('b.id', $id)
            ->select(
                'b.id',
                'b.name',
                'b.code',
                'b.description',
                'b.attribute_id',
                'b.unit_id',
                'a.id as unit_id',
                'a.name as measurement_name',
                DB::raw('null as attribute_array')
            )
            ->first();

        if ($categories) {
            $categories->attribute_id = json_decode($categories->attribute_id, true);
            if (count($categories->attribute_id)) {
                foreach ($categories->attribute_id as $attribute_id) {
                    $categories->attribute_array[] = DB::table('item_attributes')
                        ->where('id', $attribute_id)
                        ->select(
                            'id as attribute_id',
                            'name as attribute_name',
                            'description as attribute_description'
                        )
                        ->first();
                }
            }
        }
        return response()->json($categories, 200);
    }

    public function Attribute_Array($id)
    {
       $test = '12345678';

        $categories = DB::table('item_category_details as b')
            ->where('b.id', $id)
            ->select(
                'b.id',
                'b.name',
                'b.attribute_id',
                DB::raw('null as attribute_array')
            )
            ->first();

            $categories->attribute_id = json_decode($categories->attribute_id, true);
                foreach ($categories->attribute_id as $attribute_id) {
                    $categories->attribute_array[] = DB::table('item_attributes')
                        ->where('id', $attribute_id)
                        ->select(
                            'id as attribute_id',
                            'name as attribute_name',
                            'description as attribute_description'
                        )
                        ->first();
                }
            
        //return response()->json($categories->attribute_array, 200);

        return response()->json($test, 200);
    }

}
