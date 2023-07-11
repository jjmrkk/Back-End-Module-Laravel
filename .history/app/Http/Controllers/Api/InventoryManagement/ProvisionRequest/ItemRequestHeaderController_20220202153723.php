<?php

namespace App\Http\Controllers\Api\InventoryManagement\ProvisionRequest;

use App\Http\Controllers\Controller;
use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemRequestHeaderController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 400;

    private function module()
    {
        $userAccess = DB::table('user_access')->where('user_id', Auth::id())->select('description->inventory_management->provision_request_module as provision_request_module')->first();
        return json_decode($userAccess->provision_request_module);
    }

    public function show($id)
    {
        try {
            $module = $this->module();
            if($module->access == false)
            {
               return response()->json(['message'=>"No Access For This Module."], $this->errorStatus);
            }
            $itemRequestHeader = DB::table('item_request_headers as header')
                                    ->where('header.id', $id)
                                    ->join('item_request_header_status as status', 'header.status_id', 'status.id')
                                    //->join('warehouses', 'header.warehouse_id', 'warehouses.id')
                                    ->select(
                                        'header.id', 'header.date', 'header.business_unit_id', 'header.work_item_no', 
                                        'header.qto_no', 'header.purpose', 'header.warehouse_id', 'header.status_id',
                                        'header.created_at', 'header.project', 'header.project_id', 'status.name as item_request_header_status_name', 
                                        'header.description->requestor->first_name as first_name', 'header.description->requestor->middle_name as middle_name', 
                                        'header.description->requestor->last_name as last_name',
                                        'header.description->approver_first->first_name as approver1_first_name', 'header.description->approver_first->middle_name as approver1_middle_name', 
                                        'header.description->approver_first->last_name as approver1_last_name',
                                        'header.description->approver_second->first_name as approver2_first_name', 'header.description->approver_second->middle_name as approver2_middle_name', 
                                        'header.description->approver_second->last_name as approver2_last_name',
                                        DB::raw('null as business_unit_name'), DB::raw('null as project_name'),
                                         //'warehouses.name as warehouse_name',
                                    )->first();
            $itemRequestHeader->business_unit_name = $this->businessUnit($itemRequestHeader->business_unit_id);
            $itemRequestHeader->project_name = $itemRequestHeader->business_unit_id == $itemRequestHeader->project_id ? 'CORPORATE OFFICE' : $this->project($itemRequestHeader->project_id,  $itemRequestHeader->project);
            $items = DB::table('item_requests as item')
                        ->where('item.item_request_header_id', $itemRequestHeader->id)
                        ->where('item.status_id', '!=', 2)
                        ->join('item_request_status as status', 'item.status_id', 'status.id')
                        ->join('unit_of_measures as unit', 'item.unit_of_measure_id', 'unit.id')
                        ->leftjoin('item_details as a', 'item.item_details_id', 'a.id') //JM
                        ->select(
                            'item.id', 'item.item_request_header_id', 'item.description', 'item.quantity', 'a.quantity as current_quantity','a.id as item_id','a.item_category_details_id as category_id','a.warehouse_id',
                            'item.date_needed', 'item.file_path', 'item.status_id', 'item.urgent',
                            'unit.name as unit_of_measure_name', 'status.name as status_name','status.id as status_id', DB::raw('null as remarks'),
                            DB::raw('null as logs'), DB::raw('null as stockout_total'), //JM 
                        )->get();

            foreach($items as $item) 
            {
                if($item->status_id == 5 || $item->status_id == 7)
                {
                    $remarks = DB::table('item_request_logs as log')
                                        ->where('log.item_request_header_id', $item->item_request_header_id)
                                        ->where('log.item_request_id', $item->id)
                                        ->where('log.status_id', $item->status_id)
                                        ->latest()->first();
                    $item->remarks = $remarks;
                }
            }

            foreach($items as $item) 
            {
                    $logs = DB::table('item_request_details as a')
                                        ->where('a.item_request_header_id', $item->item_request_header_id)
                                        ->where('a.item_request_id', $item->id)
                                        ->leftjoin('user_profiles as b', 'a.custodian_id', 'b.user_id')
                                        ->leftjoin('item_details as c', 'a.item_id', 'c.id')
                                        ->select('a.id', 'c.name','c.id as item_id', 'a.quantity','b.first_name','b.last_name','a.status','a.created_at','a.updated_at')
                                        ->orderBy('a.created_at', 'desc' )
                                        ->get();
                    $item->logs = $logs;     
            }

            foreach($items as $item) 
            {
                    $logs = DB::table('item_request_details as a')
                                        ->where('a.item_request_header_id', $item->item_request_header_id)
                                        ->where('a.item_request_id', $item->id)
                                        ->where('a.status', '!=', 'Cancelled')
                                        ->sum('a.quantity');
                    $item->stockout_total = $logs;     
            }

            $comments = $this->comment($itemRequestHeader->id);
            return response()->json(['itemRequest'=>$itemRequestHeader,'items'=>$items,'comments'=>$comments], $this->successStatus);
        } catch (Exception $e) {
			return response()->json($e);
		}
    }

    public function alternative($category_id, $warehouse_id)
    {
        $items = DB::table('item_details as a')
        ->leftjoin('item_category_details as b', 'a.item_category_details_id', 'b.id')
        ->leftjoin('item_brands as c', 'a.item_brand_id', 'c.id')
        ->leftjoin('item_models as d', 'a.item_model_id', 'd.id')
        ->leftjoin('warehouses as e', 'a.warehouse_id', 'e.id')
        ->leftjoin('business_units as h', 'e.business_unit_id', 'h.id') 
        ->leftjoin('item_locations as f', 'a.item_location_id', 'f.id')
        ->leftjoin('unit_of_measures as g', 'b.unit_id', 'g.id')
        ->where('a.warehouse_id', $warehouse_id)
        ->where('a.item_category_details_id', $category_id)
        ->where('a.quantity','!=',0)
        ->select(
            'a.sku',
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
            'g.id as measurement_id',
            'g.name as measurement_name',
            'g.abbr as measurement_abbr',
            'h.description as unit_location',
            'h.name as business_unit',
        )
        ->get();
    return response()->json($items, 200);
    }

    public function test2($id)
    {
        try {
           
            $itemRequestHeader = DB::table('item_request_headers as header')
                                    ->where('header.id', $id)
                                    ->join('item_request_header_status as status', 'header.status_id', 'status.id')
                                    //->join('warehouses', 'header.warehouse_id', 'warehouses.id')
                                    ->select(
                                        'header.id', 'header.date', 'header.business_unit_id', 'header.work_item_no', 
                                        'header.qto_no', 'header.purpose', 'header.warehouse_id', 'header.status_id', 
                                        'header.created_at', 'header.project', 'header.project_id',
                                        DB::raw('null as business_unit_name'), DB::raw('null as project_name'),
                                        'status.name as item_request_header_status_name',
                                        'header.description->approver_first->first_name as approver1_first_name', 'header.description->approver_first->middle_name as approver1_middle_name', 
                                        'header.description->approver_first->last_name as approver1_last_name',
                                        'header.description->approver_second->first_name as approver2_first_name', 'header.description->approver_second->middle_name as approver2_middle_name', 
                                        'header.description->approver_second->last_name as approver2_last_name',
                                        //'warehouses.name as warehouse_name', 
                                    )->first();
            $itemRequestHeader->business_unit_name = $this->businessUnit($itemRequestHeader->business_unit_id);
            $itemRequestHeader->project_name = $itemRequestHeader->business_unit_id == $itemRequestHeader->project_id ? 'CORPORATE OFFICE' : $this->project($itemRequestHeader->project_id,  $itemRequestHeader->project);
            $items = DB::table('item_requests as item')
                        ->where('item.item_request_header_id', $itemRequestHeader->id)
                        ->join('unit_of_measures as unit', 'item.unit_of_measure_id', 'unit.id')
                        ->join('item_request_status as status', 'item.status_id', 'status.id')
                        ->select(
                            'item.id', 'item.item_request_header_id', 'item.description', 'item.quantity', 
                            'item.date_needed', 'item.file_path', 'item.status_id', 'item.urgent',
                            'unit.name as unit_of_measure_name', 'status.name as status_name', DB::raw('null as remarks'),
                            DB::raw('null as logs'), DB::raw('null as stockout_total'), //JM 
                        )->get();
            foreach($items as $item) 
            {
                if($item->status_id == 5 || $item->status_id == 7)
                {
                    $remarks = DB::table('item_request_logs as log')
                                        ->where('log.item_request_header_id', $item->item_request_header_id)
                                        ->where('log.item_request_id', $item->id)
                                        ->where('log.status_id', $item->status_id)
                                        ->latest()->first();
                    $item->remarks = $remarks;
                }
            }

            foreach($items as $item) 
            {
                    $logs = DB::table('item_request_details as a')
                                        ->where('a.item_request_header_id', $item->item_request_header_id)
                                        ->where('a.item_request_id', $item->id)
                                        ->leftjoin('user_profiles as b', 'a.custodian_id', 'b.user_id')
                                        ->leftjoin('item_details as c', 'a.item_id', 'c.id')
                                        ->select('a.id', 'c.name', 'a.quantity','b.first_name','b.last_name','a.status','a.created_at','a.updated_at')
                                        ->orderBy('a.created_at', 'desc' )
                                        ->get();
                    $item->logs = $logs;     
            }

            foreach($items as $item) 
            {
                    $logs = DB::table('item_request_details as a')
                                        ->where('a.item_request_header_id', $item->item_request_header_id)
                                        ->where('a.item_request_id', $item->id)
                                        ->where('a.status', '!=', 'Cancelled')
                                        ->sum('a.quantity');
                    $item->stockout_total = $logs;     
            }

            $comments = $this->comment($itemRequestHeader->id);
            return response()->json(['itemRequest'=>$itemRequestHeader, 'items'=>$items, 'comments'=>$comments], $this->successStatus);
        } catch (Exception $e) {
			return response()->json($e);
		}
    }

    public function test($id)
    {
        try {
            $itemRequestHeader = DB::table('item_request_headers as header')
                                    ->where('header.id', $id)
                                    ->join('item_request_header_status as status', 'header.status_id', 'status.id')
                                    //->join('warehouses', 'header.warehouse_id', 'warehouses.id')
                                    ->select(
                                        'header.id', 'header.date', 'header.business_unit_id', 'header.work_item_no', 
                                        'header.qto_no', 'header.purpose', 'header.warehouse_id', 'header.status_id',
                                        'header.created_at', 'header.project', 'header.project_id', 'status.name as item_request_header_status_name', 
                                        'header.description->requestor->first_name as first_name', 'header.description->requestor->middle_name as middle_name', 
                                        'header.description->requestor->last_name as last_name',
                                        'header.description->approver_first->first_name as approver1_first_name', 'header.description->approver_first->middle_name as approver1_middle_name', 
                                        'header.description->approver_first->last_name as approver1_last_name',
                                        'header.description->approver_second->first_name as approver2_first_name', 'header.description->approver_second->middle_name as approver2_middle_name', 
                                        'header.description->approver_second->last_name as approver2_last_name',
                                        DB::raw('null as business_unit_name'), DB::raw('null as project_name'),
                                         //'warehouses.name as warehouse_name',
                                    )->first();
            $itemRequestHeader->business_unit_name = $this->businessUnit($itemRequestHeader->business_unit_id);
            $itemRequestHeader->project_name = $itemRequestHeader->business_unit_id == $itemRequestHeader->project_id ? 'CORPORATE OFFICE' : $this->project($itemRequestHeader->project_id,  $itemRequestHeader->project);
            $items = DB::table('item_requests as item')
                        ->where('item.item_request_header_id', $itemRequestHeader->id)
                        ->where('item.status_id', '!=', 2)
                        ->join('item_request_status as status', 'item.status_id', 'status.id')
                        ->join('unit_of_measures as unit', 'item.unit_of_measure_id', 'unit.id')
                        ->leftjoin('item_details as a', 'item.item_details_id', 'a.id') //JM
                        ->select(
                            'item.id', 'item.item_request_header_id', 'item.description', 'item.quantity', 'a.quantity as current_quantity','a.id as item_id','a.item_category_details_id as category_id','a.warehouse_id',
                            'item.date_needed', 'item.file_path', 'item.status_id', 'item.urgent',
                            'unit.name as unit_of_measure_name', 'status.name as status_name','status.id as status_id', DB::raw('null as remarks'),
                            DB::raw('null as logs'), DB::raw('null as stockout_total'), //JM 
                        )->get();

            foreach($items as $item) 
            {
                if($item->status_id == 5 || $item->status_id == 7)
                {
                    $remarks = DB::table('item_request_logs as log')
                                        ->where('log.item_request_header_id', $item->item_request_header_id)
                                        ->where('log.item_request_id', $item->id)
                                        ->where('log.status_id', $item->status_id)
                                        ->latest()->first();
                    $item->remarks = $remarks;
                }
            }

            foreach($items as $item) 
            {
                    $logs = DB::table('item_request_details as a')
                                        ->where('a.item_request_header_id', $item->item_request_header_id)
                                        ->where('a.item_request_id', $item->id)
                                        ->leftjoin('user_profiles as b', 'a.custodian_id', 'b.user_id')
                                        ->leftjoin('item_details as c', 'a.item_id', 'c.id')
                                        ->select('a.id', 'c.name', 'a.quantity','b.first_name','b.last_name','a.status','a.created_at','a.updated_at')
                                        ->orderBy('a.created_at', 'desc' )
                                        ->get();
                    $item->logs = $logs;     
            }

            foreach($items as $item) 
            {
                    $logs = DB::table('item_request_details as a')
                                        ->where('a.item_request_header_id', $item->item_request_header_id)
                                        ->where('a.item_request_id', $item->id)
                                        ->where('a.status', '!=', 'Cancelled')
                                        ->sum('a.quantity');
                    $item->stockout_total = $logs;     
            }

            $comments = $this->comment($itemRequestHeader->id);
            return response()->json(['itemRequest'=>$itemRequestHeader,'items'=>$items,'comments'=>$comments], $this->successStatus);
        } catch (Exception $e) {
			return response()->json($e);
		}
    }

    private function businessUnit($id)
    {
        $businessUnits = DB::table('business_units as branch')
                            ->where('branch.id', $id)
                            ->leftJoin('business_unit_relations as l', 'branch.id', 'l.child')
                            ->leftJoin('business_units as location', 'l.parent', 'location.id')
                            ->orderBy('branch.code', 'ASC')
                            ->select('branch.id', 'branch.name as branch', 'location.name as location')
                            ->first();
        return $businessUnits->branch . ' (' . $businessUnits->location . ')' ;
    }

    private function project($id, $bool) 
    {
        $project = $bool == true ? DB::table('projects')->where('id', $id)->first() : DB::table('business_units')->where('id', $id)->first();
        return $project->description;
    }

    private function comment($id)
    {
        $comments = DB::table('item_request_header_comments as comment')->where('comment.item_request_header_id', $id)->select('comment.description')->orderBy('created_at', 'asc')->get();
        $messages = array();
        foreach($comments as $comment)
        {
            $messages[] = json_decode($comment->description);
        }
        return $messages;
    }
}
