<?php

namespace App\Http\Controllers\Api\ProvisionRequest\ForApproval\History;

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
        $userAccess = DB::table('user_access')->where('user_id', Auth::id())->select('description->provision_request->approval_module as approval_module')->first();
        return json_decode($userAccess->approval_module);
    }

    private function status()
    {
        return [5, 8, 11, 13];
    }

    public function index()
    {
        try {
            $module = $this->module();
            if($module->access == false)
            {
                return response()->json(['message'=>"No Access For This Module."], $this->errorStatus);
            }
            $firstApprovals = DB::table('item_request_approvers')->whereJsonContains('first', Auth::id())->select('business_unit_id', 'group_id')->get();
            $secordApprovals = DB::table('item_request_approvers')->whereJsonContains('second', Auth::id())->select('business_unit_id', 'group_id')->get();
            if($firstApprovals || $secordApprovals)
            {
                $itemRequestHeaders = DB::table('item_request_headers as header')
                                            ->where(function ($query) use ($firstApprovals, $secordApprovals) {
                                                if($firstApprovals)
                                                {
                                                    foreach($firstApprovals as $firstApproval)
                                                    {
                                                        $query->orWhereIn('header.status_id', $this->status('first'))
                                                                ->where('header.description->requestor->business_unit_id', $firstApproval->business_unit_id)
                                                                ->where('header.description->requestor->group_id', $firstApproval->group_id)
                                                                ->join('item_request_header_logs as log', function ($join) {
                                                                    $join->on('header.id', '=', 'log.item_request_header_id')
                                                                        ->whereColumn('header.updated_at', 'log.created_at')
                                                                        ->where('log.user_id', Auth::id())
                                                                        ->where('log.status_id', 4);
                                                                });
                                                               
                                                    }
                                                }
                                                if($secordApprovals)
                                                {
                                                    foreach($secordApprovals as $secordApproval)
                                                    {
                                                        $query->orWhereIn('header.status_id', $this->status('second'))
                                                                ->where('header.description->requestor->business_unit_id', $secordApproval->business_unit_id)
                                                                ->where('header.description->requestor->group_id', $secordApproval->group_id)
                                                                ->join('item_request_header_logs as log', function ($join) {
                                                                    $join->on('header.id', '=', 'log.item_request_header_id')
                                                                        ->whereColumn('header.updated_at', 'log.created_at')
                                                                        ->where('log.user_id', Auth::id())
                                                                        ->where('log.status_id', 7);
                                                                });
                                                    }
                                                }
                                            })
                                            ->join('item_request_header_status as status', 'header.status_id', 'status.id')
                                            //->join('warehouses', 'header.warehouse_id', 'warehouses.id')
                                            ->select(
                                                'header.id', 'header.date', 'header.business_unit_id', 'header.work_item_no', 
                                                'header.qto_no', 'header.status_id', 'header.project', 'header.project_id',
                                                'header.description->requestor->first_name as first_name', 'header.description->requestor->middle_name as middle_name', 
                                                'header.description->requestor->last_name as last_name',
                                                DB::raw('null as business_unit_name'), DB::raw('null as project_name'),
                                                'status.name as item_request_header_status_name', 
                                                //'warehouses.name as warehouse_name',
                                            )
                                            ->orderBy('header.date', 'desc' )
                                            ->paginate(10);
            }
            if($itemRequestHeaders)
            {
                foreach($itemRequestHeaders as $itemRequestHeader)
                {
                    $itemRequestHeader->business_unit_name = $this->businessUnit($itemRequestHeader->business_unit_id);
                    $itemRequestHeader->project_name = $itemRequestHeader->business_unit_id == $itemRequestHeader->project_id ? 'CORPORATE OFFICE' : $this->project($itemRequestHeader->project_id,  $itemRequestHeader->project);
                }
            }
            return response()->json(['itemRequestHeaders'=>$itemRequestHeaders], $this->successStatus);
        } catch (Exception $e) {
			return response()->json($e);
		}
    }

    public function index1()
    {
        try {
            $module = $this->module();
            if($module->access == false)
            {
                return response()->json(['message'=>"No Access For This Module."], $this->errorStatus);
            }
            $firstApprovals = DB::table('item_request_approvers')->whereJsonContains('first', Auth::id())->select('business_unit_id', 'group_id')->get();
            $itemRequestHeaders = [];
            if($firstApprovals)
            {
                foreach($firstApprovals as $firstApproval)
                {
                    $headers = DB::table('item_request_headers as header')
                                    ->whereIn('header.status_id', $this->status())
                                    ->where('header.description->requestor->business_unit_id', $firstApproval->business_unit_id)
                                    ->where('header.description->requestor->group_id', $firstApproval->group_id)
                                    ->join('item_request_header_logs as log', function ($join) {
                                        $join->on('header.id', '=', 'log.item_request_header_id')
                                            ->where('log.user_id', Auth::id())
                                            ->where('log.status_id', 4);
                                    })
                                    ->join('user_profiles as profiles', 'header.user_id', 'profiles.user_id')
                                    ->join('item_request_header_status as status', 'header.status_id', 'status.id')
                                    //->join('warehouses', 'header.warehouse_id', 'warehouses.id')
                                    ->select(
                                        'header.id', 'header.date', 'header.business_unit_id', 'header.work_item_no', 
                                        'header.qto_no', 'header.status_id', 'header.project', 'header.project_id',
                                        DB::raw('null as business_unit_name'), DB::raw('null as project_name'),
                                        'profiles.first_name', 'profiles.middle_name', 'profiles.last_name', 'status.name as item_request_header_status_name', 
                                        //'warehouses.name as warehouse_name',
                                    )
                                    ->orderBy('header.date', 'desc' )
                                    ->distinct()
                                    ->get()->toArray();
                    $itemRequestHeaders = array_merge($itemRequestHeaders, $headers);
                }
            }
            $secordApprovals = DB::table('item_request_approvers')->whereJsonContains('second', Auth::id())->select('business_unit_id', 'group_id')->get();
            if($secordApprovals)
            {
                foreach($secordApprovals as $secordApproval)
                {
                    $headers = DB::table('item_request_headers as header')
                                    ->whereIn('header.status_id', $this->status())
                                    ->where('header.description->requestor->business_unit_id', $secordApproval->business_unit_id)
                                    ->where('header.description->requestor->group_id', $secordApproval->group_id)
                                    ->join('item_request_header_logs as log', function ($join) {
                                        $join->on('header.id', '=', 'log.item_request_header_id')
                                            ->where('log.user_id', Auth::id())
                                            ->where('log.status_id', 7);
                                    })
                                    ->join('user_profiles as profiles', 'header.user_id', 'profiles.user_id')
                                    ->join('item_request_header_status as status', 'header.status_id', 'status.id')
                                    //->join('warehouses', 'header.warehouse_id', 'warehouses.id')
                                    ->select(
                                        'header.id', 'header.date', 'header.business_unit_id', 'header.work_item_no', 
                                        'header.qto_no', 'header.status_id', 'header.project', 'header.project_id',
                                        DB::raw('null as business_unit_name'), DB::raw('null as project_name'),
                                        'profiles.first_name', 'profiles.middle_name', 'profiles.last_name', 'status.name as item_request_header_status_name', 
                                        //'warehouses.name as warehouse_name',
                                    )
                                    ->orderBy('header.date', 'desc' )
                                    ->distinct()
                                    ->get()->toArray();
                    $itemRequestHeaders = array_merge($itemRequestHeaders, $headers);
                }
            }
            if($itemRequestHeaders)
            {
                foreach($itemRequestHeaders as $itemRequestHeader)
                {
                    $itemRequestHeader->business_unit_name = $this->businessUnit($itemRequestHeader->business_unit_id);
                    $itemRequestHeader->project_name = $itemRequestHeader->business_unit_id == $itemRequestHeader->project_id ? 'CORPORATE OFFICE' : $this->project($itemRequestHeader->project_id,  $itemRequestHeader->project);
                }
            }
            return response()->json(['itemRequestHeaders'=>$itemRequestHeaders], $this->successStatus);
        } catch (Exception $e) {
			return response()->json($e);
		}
    }

    public function itemRequestCount()
    {
        try {
            $module = $this->module();
            if($module->access == false)
            {
                return response()->json(['message'=>"No Access For This Module."], $this->errorStatus);
            }
            $firstApprovals = DB::table('item_request_approvers')->whereJsonContains('first', Auth::id())->select('business_unit_id', 'group_id')->get();
            $itemRequestHeaderCount = 0;
            if($firstApprovals)
            {
                foreach($firstApprovals as $firstApproval)
                {
                    $count = DB::table('item_request_headers as header')
                                ->whereIn('header.status_id', $this->status())
                                ->where('header.description->requestor->business_unit_id', $firstApproval->business_unit_id)
                                ->where('header.description->requestor->group_id', $firstApproval->group_id)
                                ->join('item_request_header_logs as log', function ($join) {
                                    $join->on('header.id', '=', 'log.item_request_header_id')
                                        ->where('log.user_id', Auth::id())
                                        ->where('log.status_id', 4);
                                })
                                ->distinct('header.id')
                                ->count();
                    $itemRequestHeaderCount += $count;
                }
            }
            $secordApprovals = DB::table('item_request_approvers')->whereJsonContains('second', Auth::id())->select('business_unit_id', 'group_id')->get();
            if($secordApprovals)
            {
                foreach($secordApprovals as $secordApproval)
                {
                    $count = DB::table('item_request_headers as header')
                                ->whereIn('header.status_id', $this->status())
                                ->where('header.description->requestor->business_unit_id', $secordApproval->business_unit_id)
                                ->where('header.description->requestor->group_id', $secordApproval->group_id)
                                ->join('item_request_header_logs as log', function ($join) {
                                    $join->on('header.id', '=', 'log.item_request_header_id')
                                        ->where('log.user_id', Auth::id())
                                        ->where('log.status_id', 7);
                                })
                                ->distinct('header.id')
                                ->count();
                    $itemRequestHeaderCount += $count;
                }
            }
            return response()->json(['itemRequestHeaderCount'=>$itemRequestHeaderCount], $this->successStatus);
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
}
