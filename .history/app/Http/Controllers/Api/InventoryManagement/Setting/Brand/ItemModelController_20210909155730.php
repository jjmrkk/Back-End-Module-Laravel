<?php

namespace App\Http\Controllers\Api\InventoryManagement\Setting\Brand;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class ItemModelController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 400;
    public $branchid = 13;

    public function index()
    {
        $model = DB::table('item_models as a')
        ->leftjoin('item_brands as b', 'a.item_brand_id', 'b.')
        ->where('b.business_unit_id', $this->branchid)
        ->select(
            'a.id',
            'a.name'
        )
        ->get();
        return response()->json($model, 200);

    }

    public function show($id)
    {
        $brand = DB::table('item_models as a')
            ->where('a.item_brand_id', $id)
            ->select(
                'a.id',
                'a.name'
            )
            ->get();
    }


    public function store(Request $request)
    {
        try {

            $code = strtoupper($request->item_code);
            $name = ucwords($request->name);
            $branch_id = ($request->business_unit_id);

          //  $name_check = DB::table('item_models as a')
          //      ->where('a.name', $name)
          //      ->join('item_brands as b', 'a.item_brand_id', 'b.id')
          //      ->where('b.business_unit_id', $this->branchid)
          //      ->exists();
           
          //  if ($name_check) {
         //       return response()->json(['message' => "Duplicate Model name Entry Found."], $this->errorStatus);
         //   }

       ///////////////////////////////////////////////////////////////////////////////////////////////////////////  
            //          if($code_check || $name_check)
            //          {
            //              if(!$code_check)
            //              {
            //                  return response()->json(['name_error'=>"Duplicate Name Entry Found."],$this->errorStatus);   
            //              }   
            //             else if(!$name_check)
            //             {
            //                  return response()->json(['code_error'=>"Duplicate Code Entry Found."],$this->errorStatus);    
            //              }   
            //              else{
            //                  return response()->json(['code_error'=>"Duplicate Code Entry Found.",'name_error'=>"Duplicate Name Entry Found."],$this->errorStatus);
            //              }
            //          }

            //          else
            //          {
            //              return response()->json(['message'=>"Success. You have been successfully added new subcategory!"], $this->successStatus);
            //          }
            $now = Carbon::now();
            $brand = DB::table('item_models')->insert([
                'name' => ucwords($request->name),
                'item_brand_id' => $request->item_brand_id,
                'item_category_details_id' => $request->item_category_details_id,
                'item_supplier_id' => ('[]'),
                'user_id' => Auth::id(),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            return response()->json(['message' => "Success. New Model Successfully added"], $this->successStatus);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
    public function category_show()
    {
        $category = DB::table('item_category_details as a')
            ->where('a.attribute_id', '!=', '[]')
            ->select(
                'a.id',
                'a.code',
                'a.name'
            )
            ->get();
        return response()->json($category, 200);
    }

    public function category_model_show($id)
    {
        $category = DB::table('item_category_details as a')
            ->leftjoin('item_models as b', 'a.id', 'b.item_category_details_id')
            ->where('a.attribute_id', '!=', '[]')
            ->where('b.item_brand_id', $id)
            ->select(
                'a.id',
                'a.code',
                'a.name'
            )
            ->distinct()
            ->get();
        return response()->json($category, 200);
    }
}
