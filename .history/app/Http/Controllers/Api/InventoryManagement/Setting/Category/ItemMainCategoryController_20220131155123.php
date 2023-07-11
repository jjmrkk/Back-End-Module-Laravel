<?php

namespace App\Http\Controllers\Api\InventoryManagement\Setting\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ItemMainCategoryController extends Controller
{

    public $successStatus = 200;
    public $errorStatus = 400;
    public $branchid = 13;


    public function ShowCategoryRelations_Test($id)
    {

   //     $statement =DB::table('item_details as a')->select ('a.id')->count();
   //     $autoincrement = 1 + $statement;
   //     $str_length = 5;
   //     $str = substr("00000{$autoincrement}", -$str_length );
   //     return response($str);
  
        $maincategory = DB::table('item_category_details as a')
            ->leftjoin('warehouses as b', 'a.warehouse_id', 'b.id')
            ->where('a.tag', 1)
            ->where('b.id', $id)
            ->select(
                'a.id',
                'a.name',
                'a.code',
                'a.attribute_id',
                'a.description',
                'b.name as warehouse_name',
                'a.created_at',
                DB::raw('null as childs')
            )
            ->get();

        foreach ($maincategory as $main) {
            $subcat_02 = DB::table('item_category_relations as b')
                ->leftjoin('item_category_details as c', 'b.child', 'c.id')
                ->where('b.parent', $main->id)
                ->select('b.child as id',
                         'c.name',
                         'c.code',
                         'c.attribute_id',
                         'c.description',
                         'c.created_at',
                         DB::raw('null as childs'))
                ->get();

            $main->childs = $subcat_02;

            foreach ($subcat_02 as $main) {
                $subcat_03 = DB::table('item_category_relations as b')
                    ->leftjoin('item_category_details as c', 'b.child', 'c.id')
                    ->where('b.parent', $main->id)
                    ->select('b.child as id',
                             'c.name',
                             'c.code',
                             'c.attribute_id',
                         'c.description',
                         'c.created_at',
                             
                             DB::raw('null as childs'))
                    ->get();
                $main->childs = $subcat_03;
    
                foreach ($subcat_03 as $main) {
                    $subcat_04 = DB::table('item_category_relations as b')
                        ->leftjoin('item_category_details as c', 'b.child', 'c.id')
                        ->where('b.parent', $main->id)
                        ->select('b.child as id',
                                 'c.name',
                                 'c.code',
                                 'c.attribute_id',
                                 'c.description',
                                 'c.created_at',
                                 DB::raw('null as childs'))
                        ->get();
                    $main->childs = $subcat_04;
        
                    foreach ($subcat_04 as $main) {
                        $subcat_05 = DB::table('item_category_relations as b')
                            ->leftjoin('item_category_details as c', 'b.child', 'c.id')
                            ->where('b.parent', $main->id)
                            ->select('b.child as id',
                                     'c.name',
                                     'c.code',
                                     'c.attribute_id',
                                     'c.description',
                                     'c.created_at',
                                     DB::raw('null as childs'))
                            ->get();
                        $main->childs = $subcat_05;
            
                        foreach ($subcat_05 as $main) {
                            $subcat_06 = DB::table('item_category_relations as b')
                                ->leftjoin('item_category_details as c', 'b.child', 'c.id')
                                ->where('b.parent', $main->id)
                                ->select('b.child as id',
                                         'c.name',
                                         'c.code',
                                         'c.attribute_id',
                                         'c.description',
                                         'c.created_at',
                                         DB::raw('null as childs'))
                                ->get();
                            $main->childs = $subcat_06;
                
                            foreach ($subcat_06 as $main) {
                                $subcat_07 = DB::table('item_category_relations as b')
                                    ->leftjoin('item_category_details as c', 'b.child', 'c.id')
                                    ->where('b.parent', $main->id)
                                    ->select('b.child as id',
                                             'c.name',
                                             'c.code',
                                             'c.attribute_id',
                                             'c.description',
                                             'c.created_at',
                                             DB::raw('null as childs'))
                                    ->get();
                                $main->childs = $subcat_07;

                                foreach ($subcat_07 as $main) {
                                    $subcat_08 = DB::table('item_category_relations as b')
                                        ->leftjoin('item_category_details as c', 'b.child', 'c.id')
                                        ->where('b.parent', $main->id)
                                        ->select('b.child as id',
                                                 'c.name',
                                                 'c.code',
                                                 'c.attribute_id',
                                                 'c.description',
                                                 'c.created_at',
                                                 DB::raw('null as childs'))
                                        ->get();
                                    $main->childs = $subcat_08;

                                    foreach ($subcat_08 as $main) {
                                        $subcat_09 = DB::table('item_category_relations as b')
                                            ->leftjoin('item_category_details as c', 'b.child', 'c.id')
                                            ->where('b.parent', $main->id)
                                            ->select('b.child as id',
                                                     'c.name',
                                                     'c.code',
                                                     'c.attribute_id',
                                                     'c.description',
                                                     'c.created_at',
                                                     DB::raw('null as childs'))
                                            ->get();
                                        $main->childs = $subcat_09;

                                        foreach ($subcat_09 as $main) {
                                            $subcat_10 = DB::table('item_category_relations as b')
                                                ->leftjoin('item_category_details as c', 'b.child', 'c.id')
                                                ->where('b.parent', $main->id)
                                                ->select('b.child as id',
                                                         'c.name',
                                                         'c.code',
                                                         'c.attribute_id',
                                                         'c.description',
                                                         'c.created_at',
                                                         DB::raw('null as childs'))
                                                ->get();
                                            $main->childs = $subcat_10;
                                        }

                                    }
                                }

                            }
                        }
                    }
                }
            }
        }
        return response()->json($maincategory, 200);
    }

    public function index()
    {
        $maincategories = DB::table('item_category_details as a')
            ->where('a.tag', 1)
            ->select(
                'a.id',
                'a.name',
                'a.description',
                DB::raw('null as subcategories')
            )
            ->get();

        foreach ($maincategories as $main) {
            $subcat_07 = DB::table('item_category_relations as g')
                ->where('g.parent', $main->id)
                ->select('g.child as subid')
                ->get();
            $main->subcategories = $subcat_07;
        }

        return response()->json($maincategories, 200);
    }

    public function store(Request $request)
    {
        try {

            $name = ucwords($request->name);
            $business_unit_id = ($request->business_unit_id);
            $name_check = DB::table('item_category_details')
                ->where('name', $name)
                ->where('business_unit_id', $business_unit_id)->exists();
            if ($name_check) {
                return response()->json(['message' => "Duplicate main category entry found."], $this->errorStatus);
            }
            //   else
            //  {
            //      return response()->json(['message'=>"Success. You have been successfully added new measurement!"], $this->successStatus);
            //  }

            $maincategory = DB::table('item_category_details')->insert([
                'code' => "",
                'name' => ucwords($request->name),
                //'business_unit_id' => $this->branchid,
                'business_unit_id' => $request->business_unit_id,
                'warehouse_id' => $request->warehouse_id,
                'description' => $request->description,
                'tag' => "1",
                'attribute_id' => "[]",
            ]);
            return response()->json(['message' => "Success. You have been successfully added new main category!"], $this->successStatus);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function show($id)
    {
        $maincategory = DB::table('item_category_details as e')
            ->where('e.id', $id)
            ->select(
                'e.id',
                'e.name',
                'e.description',
                'e.attribute_id',
                DB::raw('null as attributes')
            )
            ->get();
        return response()->json($maincategory, 200);
    }

    public function categoryInfo($id)
    {
        $categories = DB::table('item_category_details as e')
            ->where('e.id', $id)
            ->select(
                'e.id',
                'e.name',
                'e.description',
                'e.attribute_id',
                DB::raw('null as attribute_array'),
                DB::raw('null as brands'),
                DB::raw('null as models')
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

             $model = DB::table('item_models as a')
                ->where('a.item_category_details_id', $id)
                ->leftjoin('item_brands as b', 'a.item_brand_id', 'b.id')
                ->select(DB::raw('CONCAT(b.name,\' - \',a.name) as model_name'))
                ->get();
            $categories->models = $model;

            $brand = DB::table('item_models as a')
                ->where('a.item_category_details_id', $id)
                ->leftjoin('item_brands as b', 'a.item_brand_id', 'b.id')
                ->select('b.name as brand_name')
                ->distinct()
                ->get();
            $categories->brands = $brand;

        return response()->json($categories, 200);
    }

    public function update(Request $request, $id)
    { }

    public function ShowMainCategoryRelation()
    {
        $maincategory = DB::table('item_category_details as a')
            ->where('a.tag', 1)
            ->select(
                'a.id',
                'a.name',
                'a.description',
                DB::raw('null as subcategories')
            )
            ->get();

        foreach ($maincategory as $main) {
            $subcat_07 = DB::table('item_category_relations as g')
                ->where('g.parent', $main->id)
                ->select('g.child as subid')
                ->get();
            $main->subcategories = $subcat_07;
        }

        return response()->json($maincategory, 200);
    }

    public function Show_Nochild_Category()
    {
        $categories = DB::table('item_category_details as b')
            ->leftjoin('unit_of_measures as a', 'b.unit_id', 'a.id')
            ->where('b.business_unit_id', $this->branchid)
            ->where('b.attribute_id', '!=', '[]')
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
}
