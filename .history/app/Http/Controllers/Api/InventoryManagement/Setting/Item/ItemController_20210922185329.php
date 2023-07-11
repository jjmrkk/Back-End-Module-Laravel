<?php

namespace App\Http\Controllers\Api\InventoryManagement\Setting\Item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class ItemController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 400;

    public function index()
    { }

    public function store(Request $request)
    {
        try {

            $attrname = '';
            $attrvalue = '';
            $arrayvalue = '';
            $item_name = $request->item_name;
            foreach ($request->item_attributes_list as $attribute) {
                $attrname .= ", " . $attribute['attribute_name'] .= ": " . $attribute['attribute_value'];
                $attrvalue .= "" . $attribute['attribute_value'];
                $arrayvalue .= '"' . $attribute['attribute_value'] .= '",';
            }
            $itemname_attr = ($item_name . "" . $attrname);
     
            $array = array("","","");
            $a = count($array);
            $b = count(array_filter($array));


            //return response()->json(['message' => "$a .'-'. $b "], $this->errorStatus);
           
            foreach ($request->item_attributes_list as $attributes) {

                foreach ($attributes[] as $dsds) {

                    return response()->json(['message' => "Emptssy: $dsds"], $this->errorStatus);

                }

             //   $array = array($attribute['attribute_value']);
             //   if( $array  != array_filter( $array )) 
             //   return response()->json(['message' => "not"], $this->errorStatus);
             //   else
             //   return response()->json(['message' => "workings"], $this->errorStatus);
           

            }

        


        return response()->json(['message' => ($attrvalue)], $this->errorStatus);



            $name_check = DB::table('item_details')->where('name', ($itemname_attr))->exists();
            if ($name_check) {
                return response()->json(['message' => "Duplicate Name Entry Found for $itemname_attr."], $this->errorStatus);
            }

            //    else
            //    {
            //        return response()->json(['message'=>"Success. You have been successfully added new subcategory!"], $this->successStatus);
            //    }

           // $id=DB::select("SHOW TABLE STATUS LIKE 'Your table name'");
           // $next_id = $id[0]->Auto_increment;
           // echo $next_id;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
           $statement =DB::table('item_details as a')->select ('a.id')->count();
           $autoincrement = 1 + $statement;
           $str_length = 5;
           $str = substr("00000{$autoincrement}", -$str_length );
        //   return response($str);
   
            $now = Carbon::now();
            $item = DB::table('item_details')->insert([
                'item_code' => ($request->item_code ."-". $str),
                'name' => ($name . ", " . $attrname),
                'item_category_details_id' => $request->item_category_details_id,
                'description' => $request->description,
                'item_brand_id' => $request->item_brand_id,
                'item_model_id' => $request->item_model_id,
                'warehouse_id' => $request->warehouse_id,
                'item_location_id' => $request->item_location_id,
                'minimum' => $request->maximum,          // Something is wrong on angular validation
                'maximum' => $request->minimum,          //
                'minimum_msg' => $request->minimum_msg,
                'maximum_msg' => $request->maximum_msg,
                'item_attributes' => json_encode($request->item_attributes),
                'quantity' => "0.00",
                'user_id' => Auth::id(),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            return response()->json(['message' => "Success. You have been successfully added new Item!"], $this->successStatus);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function SearchItem($search)
    {
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
            ->where('a.name', 'ilike', "%$search%")
            ->whereIn('a.warehouse_id', $warehouse)
            // ->where('e.branch_id', $this->branchid)
            ->select(
                'a.id',
                'a.item_code',
                'a.name',
                'a.quantity',
                'b.name as category_name',
                'b.code as category_code',
                'c.name as brand_name',
                'd.name as model_name',
                'e.name as warehouse_name',
                'f.name as location_name',
                'a.minimum',
                'a.maximum',
                'b.unit_id',
                'g.name as measurement_name',
                'g.abbr as measurement_abbr',
            )
            ->get();

        return response()->json($items, 200);
    }

    public function Log($id)
    { }


    public function show($id)
    {
       
        //  $date_needed = Carbon::parse($tat_date)->format('F d, Y h:m:s A');

        $user = DB::table('user_access as a')
            ->where('a.user_id', Auth::id())
            ->select('a.description->warehouses as warehouse_id')
            ->first();

        $warehouse = json_decode($user->warehouse_id);


        $items = DB::table('item_details as a')
            ->leftjoin('item_category_details as b', 'a.item_category_details_id', 'b.id')
            ->leftjoin('item_locations as f', 'a.item_location_id', 'f.id')
            ->leftjoin('unit_of_measures as g', 'b.unit_id', 'g.id')
            ->where('a.id', $id)
            ->select(
                'a.id',
                'a.item_code',
                'a.name',
                'a.quantity',
                'b.name as category_name',
                'b.code as category_code',
                'g.name as measurement_name',
                DB::raw('null as item_in'),
            )
            ->get();

        foreach ($items as $logs_in) {
            $in = DB::table('item_in_stocks as a')
                ->leftjoin('user_profiles as b', 'a.user_id', 'b.user_id')
                ->leftjoin('warehouses as c', 'a.warehouse_id', 'c.id') //warehouse //added by JM
                ->leftjoin('item_locations as d', 'a.location_id', 'd.id') //location //added by JM
                ->where('a.item_detail_id', $logs_in->id)
                ->whereIn('c.id', $warehouse)
                ->select(
                    'a.id',
                    'a.quantity',
                    'a.balance',
                    'a.created_at',
                    'c.name as warehouse',
                    'd.name as location',
                    'b.first_name',
                    'b.last_name',
                    DB::raw('null as item_out'),
                )
                ->orderBy('a.created_at', 'ASC')
                ->get();
            $logs_in->item_in = $in;

        }
        return response()->json($items, 200);
    }
}
