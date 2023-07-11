<?php

namespace App\Http\Controllers\Api\ProvisionRequest\Transaction;

use App\Http\Controllers\Controller;
use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemRequestController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 400;

    private function module()
    {
        $userAccess = DB::table('user_access')->where('user_id', Auth::id())->select('description->provision_request->transaction_module as transaction_module')->first();
        return json_decode($userAccess->transaction_module);
    }

    public function show($id)
    {
       
        try {
      //      $module = $this->module();
       //     if($module->access == false)
       //     {
       //         return response()->json(['message'=>"No Access For This Module."], $this->errorStatus);
       //     }
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

            

            $comments = $this->comment($itemRequestHeader->id);
            return response()->json(['itemRequest'=>$itemRequestHeader, 'items'=>$items, 'comments'=>$comments], $this->successStatus);
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























































































































































