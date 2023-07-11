<?php

namespace App\Http\Controllers\Api\ProvisionRequest\Form;

use App\Http\Controllers\Controller;
use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProvisionRequestMail;
use Carbon\Carbon;

class ItemRequestController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 400;

    private function module()
    {
        $userAccess = DB::table('user_access')->where('user_id', Auth::id())->select('description->provision_request->form_module as form_module')->first();
        return json_decode($userAccess->form_module);
    }

    public function show($warehouse_id)  //JM
    {
        $items = DB::table('item_details as a')
        ->leftjoin('item_category_details as b', 'a.item_category_details_id', 'b.id')
        ->leftjoin('item_brands as c', 'a.item_brand_id', 'c.id')
        ->leftjoin('item_models as d', 'a.item_model_id', 'd.id')
        ->leftjoin('warehouses as e', 'a.warehouse_id', 'e.id')
        ->leftjoin('business_units as h', 'e.business_unit_id', 'h.id') 
        ->leftjoin('item_locations as f', 'a.item_location_id', 'f.id')
        ->leftjoin('unit_of_measures as g', 'b.unit_id', 'g.id')
       // ->where('a.name', 'ilike', "%$search%")
        ->where('a.warehouse_id', $warehouse_id)
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

    public function search($warehouse_id, $search)  //JM
    {

       // $user = DB::table('user_access as a')
        //->where('a.user_id', 26)
       // ->select('a.description->inventory_management->warehouse_module->warehouses as warehouse_id')
       // ->first();
       //$warehouse = json_decode($user->warehouse_id);
      // return($warehouse);

        $keywordRaw = $search;
        $search = explode(' ', $keywordRaw );

       // return($search);

       // foreach ($search as $keyword){

       
        $items = DB::table('item_details as a')
        ->leftjoin('item_category_details as b', 'a.item_category_details_id', 'b.id')
        ->leftjoin('item_brands as c', 'a.item_brand_id', 'c.id')
        ->leftjoin('item_models as d', 'a.item_model_id', 'd.id')
        ->leftjoin('warehouses as e', 'a.warehouse_id', 'e.id')
        ->leftjoin('business_units as h', 'e.business_unit_id', 'h.id') 
        ->leftjoin('item_locations as f', 'a.item_location_id', 'f.id')
        ->leftjoin('unit_of_measures as g', 'b.unit_id', 'g.id')
        ->whereIn('a.name', "%$search%")
       // ->where('a.warehouse_id', 1)
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
   // }
    return response()->json($items, 200);
    }


    public function store(Request $request)
    {
        try {
            $module = $this->module();
            if($module->access == false)
            {
                return response()->json(['message'=>"No Access For This Module."], $this->errorStatus);
            }
            $transaction = DB::transaction(function () use ($request) {
                $explode_id = explode('_', $request->project_id);
                $project = $explode_id[1] == 1 ? true : false;
                $userProfile = DB::table('user_profiles')->where('user_id', Auth::id())->first();
                $position = DB::table('business_unit_positions')->where('id', $userProfile->business_unit_position_id)->first();
                $description = json_encode([
                    "requestor" => [
                        "user_id" => Auth::id(),
                        "business_unit_id" => $userProfile->business_unit_id,
                        "group_id" => $userProfile->group_id,
                        "last_name" => $userProfile->last_name,
                        "first_name" => $userProfile->first_name,
                        "middle_name" => $userProfile->middle_name,
                        "position" => $position->name,
                        "email" => Auth::user()->email
                    ],
                    "approver_first" => [
                        "user_id" => '',
                        "business_unit_id" => '',
                        "group_id" => '',
                        "last_name" => '',
                        "first_name" => '',
                        "middle_name" => '',
                        "position" => '',
                        "email" => '',
                        "tagged" => '',
                        "approved_disapproved" => ''
                    ],
                    "approver_second" => [
                        "user_id" => '',
                        "business_unit_id" => '',
                        "group_id" => '',
                        "last_name" => '',
                        "first_name" => '',
                        "middle_name" => '',
                        "position" => '',
                        "email" => '',
                        "tagged" => '',
                        "approved_disapproved" => ''
                    ],
                    "custodian" => [
                        "user_id" => '',
                        "business_unit_id" => '',
                        "group_id" => '',
                        "last_name" => '',
                        "first_name" => '',
                        "middle_name" => '',
                        "position" => '',
                        "email" => '',
                        "tagged" => '',
                        "completed_closed" => ''
                    ]
                ]);
                $checkApprover = DB::table('item_request_approvers')->where('business_unit_id', $userProfile->business_unit_id)->where('group_id', $userProfile->group_id)->where('first', '[]')->count();
                $statusId = $checkApprover == 0 ? 3 : 6;
                $now = Carbon::now();
                $YYYYMM = $now->format('Ym');
                $item_request_header_id = DB::table('item_request_headers')->latest()->select('id')->first();
                if($item_request_header_id) 
                {
                    $year = substr($item_request_header_id->id, 0, 4);
                    $yearNow = $now->format('Y');
                    if($year == $yearNow)
                    {
                        $lastSeries = (int)substr($item_request_header_id->id, 6, 5) + 1;
                        $series = sprintf('%05d', $lastSeries);
                    }
                    else 
                    {
                        $series = '00001';
                    }
                } else 
                {
                    $series = '00001';
                }
                $id = $YYYYMM . $series;
                $item_request_header_id = DB::table('item_request_headers')->insertGetId([
                    'id' => $id,
                    'date' => $now,
                    'user_id' => Auth::id(),
                    'user_business_unit_id' => $userProfile->business_unit_id,
                    'user_business_unit_position_id' => $userProfile->business_unit_position_id,
                    'business_unit_id' => $request->business_unit_id,
                    'project_id' => $explode_id[0],
                    'project' => $project,
                    'work_item_no' => $request->work_item_no,
                    'qto_no' => $request->qto_no,
                    'purpose' => $request->purpose,
                    'status_id' => $statusId,
                    //'warehouse_id' => $request->warehouse_id,
                    'warehouse_id' => 1, //Field is disabled on frontend. Hard coded as work around.
                    'description' => $description,
                    'created_at' => $now,
                    'updated_at' => $now
                ]);
                foreach($request->items as $item)
                {
                    DB::table('item_requests')->insert([
                        'item_request_header_id' => $item_request_header_id,
                        'description' => $item['description'],
                        'quantity' => $item['quantity'],
                        'unit_of_measure_id' => $item['unit_of_measure_id'],
                        'date_needed' => date('Y-m-d', strtotime($item['date_needed'])),
                        'status_id' => 1,
                        'created_at' => $now,
                        'updated_at' => $now
                    ]);
                }
                $approverMessage = $statusId == 3 ? 'Immediate Supervisor' : 'Department Head';
                $data = [
                    'title' => 'PRS: #' . $item_request_header_id,
                    'sender_name' => $userProfile->first_name . ' ' . $userProfile->last_name,
                    'recipient_name' => $userProfile->first_name . ' ' . $userProfile->last_name,
                    'recipient_email' => Auth::user()->email,
                    'prs_no' => '#' . $item_request_header_id,
                    'message' => 'PRS #' . $item_request_header_id . ' has been sent to your ' . $approverMessage .' for approval.',  
                ];
                Mail::to($data['recipient_email'])->send(new ProvisionRequestMail($data));
                if($statusId == 3)
                {
                    $approver = DB::table('item_request_approvers')
                                        ->where('business_unit_id', $userProfile->business_unit_id)
                                        ->where('group_id', $userProfile->group_id)
                                        ->select('first as approver')
                                        ->first();
                }                       
                elseif($statusId == 6)
                {
                    $approver = DB::table('item_request_approvers')
                                        ->where('business_unit_id', $userProfile->business_unit_id)
                                        ->where('group_id', $userProfile->group_id)
                                        ->select('second as approver')
                                        ->first();
                } 
                $approvers = DB::table('users as user')
                                ->whereIn('id', json_decode($approver->approver))
                                ->join('user_profiles as profile', 'user.id', 'profile.user_id')
                                ->select('user.email', 'profile.first_name', 'profile.last_name')
                                ->get();
                foreach($approvers as $approver)
                {
                    $data = [
                        'title' => 'PRS: #' . $item_request_header_id,
                        'sender_name' => $userProfile->first_name . ' ' . $userProfile->last_name,
                        'recipient_name' => $approver->first_name . ' ' . $approver->last_name,
                        'recipient_email' => $approver->email,
                        'prs_no' => '#' . $item_request_header_id,
                        'message' => 'PRS #' . $item_request_header_id . ' has been sent for your approval.',  
                    ];
                    Mail::to($data['recipient_email'])->send(new ProvisionRequestMail($data));
                }
                return $item_request_header_id;
            });
            return response()->json(['message'=>"#$transaction Provision Request has been sent for approval.", 'itemRequestHeaderId'=>$transaction], $this->successStatus);
        } catch (Exception $e) {
			return response()->json($e);
		}
    }
}
