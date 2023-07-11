<?php

namespace App\Http\Controllers\Api\InventoryManagement\ProvisionRequest\Pending;

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
        $userAccess = DB::table('user_access')->where('user_id', 105)->select('description->inventory_management->provision_request_module as provision_request_module')->first();
        return json_decode($userAccess->provision_request_module);
    }

    public function index()
    {
        try {
            $module = $this->module();
            if($module->access == false)
            {
                return response()->json(['message'=>"No Access For This Module."], $this->errorStatus);
            }
            $itemRequestHeaders = DB::table('item_request_headers as header')
                                    ->where('header.status_id', 9)
                                    ->join('user_profiles as profiles', 'header.user_id', 'profiles.user_id')
                                    //->where('profiles',  $userProfile->business_unit_id)
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
                                    ->paginate(10);
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
            $itemRequestHeaderCount = DB::table('item_request_headers')->where('status_id', 9)->count();
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
