<?php

namespace App\Http\Controllers\Api\InventoryManagement\ProvisionRequest\Tagged\Modal;

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
        $userAccess = DB::table('user_access')->where('user_id', Auth::id())->select('description->inventory_management->provision_request_module as provision_request_module')->first();
        return json_decode($userAccess->provision_request_module);
    }
    
    private function status($action)
    {
        if($action == 'cancel') 
        {
            return ['id' => 5, 'action' => 'Cancelled By Custodian', 'description' => 'Cancelled By Custodian'];
        }
        elseif($action == 'purchase')
        {
            return ['id' => 6, 'action' => 'For Purchase', 'description' => 'For Purchase'];
        }
        elseif($action == 'partial')
        {
            return ['id' => 7, 'action' => 'Partially Delivered', 'description' => 'Partially Delivered'];
        }
        elseif($action == 'deliver')
        {
            return ['id' => 8, 'action' => 'Delivered', 'description' => 'Delivered'];
        }
    }

    public function store(Request $request)
    {
        $current_quantity = DB::table('item_details as a')
        ->where('a.id', $request->item_id)
        ->sum('a.quantity');

        $total_stockout_quantity = DB::table('item_request_details as a')
        ->where('a.item_request_header_id', $request->item_request_header_id)
        ->where('a.item_request_id', $request->item_request_id)
        ->where('a.status', '!=', 'Cancelled')
        ->sum('a.quantity');

        $total_request_quantity = DB::table('item_requests as a')
        ->where('a.id', $request->item_request_id)
        ->where('a.item_request_header_id', $request->item_request_header_id)
        ->sum('a.quantity');

        $requested = $request->quantity;
        $total = $requested + $total_stockout_quantity;

        if ($requested > $current_quantity) 
        {
            return response()->json(['message' => "Insufficient Stock"], $this->errorStatus);
        }         
        elseif ($total < $total_request_quantity) //Pede
        {

            try {

                $now = Carbon::now();
                $item = DB::table('item_request_details')->insert([
                    'item_request_header_id' => $request->item_request_header_id,
                    'item_request_id' => $request->item_request_id,
                    'item_id' => $request->item_id,
                    'quantity' => $request->quantity,
                    'custodian_id' => Auth::id(),
                    'status' => 'Packaging',
                    'created_at' => $now,
                ]);
    
                $item_detail = DB::table('item_details')->where('id', $request->item_id)->first();  //Item quantity Deduction
                $quantity = $item_detail->quantity - $request->quantity;
                DB::table('item_details as a')
                ->where('a.id', $request->item_id)
                ->update(['a.quantity' => $quantity]);

                DB::table('item_requests')  //Automatic Partial Request
                ->where('id', $request->item_request_id)
                ->where('item_request_header_id', $request->item_request_header_id)
                ->update(['status_id' => 7]);

                $check = DB::table('item_request_logs')
                ->where('item_request_header_id', $request->item_request_header_id)
                ->where('item_request_id', $request->item_request_id)
                ->where('status_id', 7)
                ->exists();
                if(!$check) 
                {
                    DB::table('item_request_logs')->insert([
                        'item_request_header_id' => $request->item_request_header_id,
                        'item_request_id' => $request->item_request_id,
                        'status_id' => 7,
                        'user_id' => Auth::id(),
                        'action' => 'partially delivered',
                        'description' => 'partially delivered',
                        'created_at' => $now,
                        'updated_at' => $now
                    ]);    
                }
                else{

                }

               
    
                return response()->json(['message' => "Item has been Packed"], $this->successStatus);
            } catch (Exception $e) {
                return response()->json($e);
            }
        } 
        elseif($total == $total_request_quantity) //Complete
        {
            try {
                $now = Carbon::now();
                $item = DB::table('item_request_details')->insert([
                    'item_request_header_id' => $request->item_request_header_id,
                    'item_request_id' => $request->item_request_id,
                    'item_id' => $request->item_id,
                    'quantity' => $request->quantity,
                    'custodian_id' => Auth::id(),
                    'status' => 'Packaging',
                    'created_at' => $now,
                ]);
    
                $item_detail = DB::table('item_details')->where('id', $request->item_id)->first();
                $quantity = $item_detail->quantity - $request->quantity;
                DB::table('item_details as a')
                ->where('a.id', $request->item_id)
                ->update(['a.quantity' => $quantity]);

                DB::table('item_requests')  //Automatic Partial pa din ang request kasi di pa nya na d deliver yung Request
                ->where('id', $request->item_request_id)
                ->where('item_request_header_id', $request->item_request_header_id)
                ->update(['status_id' => 7]);
    
                return response()->json(['message' => "Item has been Packed"], $this->successStatus);
            } catch (Exception $e) {
                return response()->json($e);
            }
        }
        else 
        {
            return response()->json(['message' => "Excessive Request Quantity"], $this->errorStatus);
        }

    }

    public function update_status(Request $request, $id)
    {  

      //  return response()->json(['message' =>  'id:'.$id .' '.'item_id:'.$request->item_id .' item_request_header_id:'. $request->item_request_header_id.' item_request_id:'. $request->item_request_id], $this->errorStatus);

      
        if($request->action == 'delivered') 
        {
            $total_stockout_quantity = DB::table('item_request_details as a')
            ->where('a.item_request_header_id', $request->item_request_header_id)
            ->where('a.item_request_id', $request->item_request_id)
            ->where('a.status', '=', 'Delivered')
            ->sum('a.quantity');
    
            $total_request_quantity = DB::table('item_requests as a')
            ->where('a.id', $request->item_request_id)
            ->where('a.item_request_header_id', $request->item_request_header_id)
            ->sum('a.quantity');

            $requested = $request->quantity;
            $total = $requested + $total_stockout_quantity;

            if($total == $total_request_quantity) //Complete
            {
              // return response()->json(['message' => $total . ' Complete' . $total_stockout_quantity .'=' . $total_request_quantity ], $this->errorStatus);
                try {
                    $now = Carbon::now();
                    DB::table('item_request_details as a')
                            ->where('a.id', $id)
                            ->update(['a.status' => 'Delivered',
                                      'a.updated_at' => $now,]);

                    DB::table('item_requests')  //Automatic Delivered/Complte Request
                            ->where('id', $request->item_request_id)
                            ->where('item_request_header_id', $request->item_request_header_id)
                            ->update(['status_id' => 8]);
                            
                    DB::table('item_request_logs')->insert([
                        'item_request_header_id' => $request->item_request_header_id,
                        'item_request_id' => $request->item_request_id,
                        'status_id' => 8,
                        'user_id' => Auth::id(),
                        'action' => 'delivered',
                        'description' => 'delivered',
                        'created_at' => $now,
                        'updated_at' => $now
                    ]);  
                
        $count_request = DB::table('item_requests as a')  //Every Deliverd Item e c check na yung PRS kung complete na and pede na e close
        ->where('a.item_request_header_id', $request->item_request_header_id)
        ->where('a.status_id','!=',5)
        ->where('a.status_id','!=',2)
        ->count();

        $count_deivered = DB::table('item_request_logs as b') 
        ->where('b.item_request_header_id', $request->item_request_header_id)
        ->where('b.status_id', 8)
        ->count();

        if($count_request == $count_deivered) 
        {
            try {  
                DB::transaction(function () use ($request) {
                    $now = Carbon::now();
                    DB::table('item_request_headers')
                        ->where('id', $request->item_request_header_id)
                        ->where('status_id', 10)
                        ->update([
                            'status_id' => 13, 
                            'updated_at' => $now,
                            'description->custodian->completed_closed' => $now
                        ]);
                    DB::table('item_request_header_logs')->insert([
                        'item_request_header_id' => $request->item_request_header_id,
                        'status_id' => 13,
                        'user_id' => Auth::id(),
                        'action' => 'Request Completed',
                        'description' => 'Request Completed',
                        'remarks' => '', //TINANGGAL NI JM
                        'created_at' => $now,
                        'updated_at' => $now
                    ]);
                    $itemRequestHeader = DB::table('item_request_headers')
                                            ->where('id', $request->item_request_header_id)
                                            ->select(
                                                'description->requestor->last_name as last_name', 'description->requestor->first_name as first_name',
                                                'description->requestor->email as email', 'description->custodian->first_name as custodian_first_name',
                                                'description->custodian->last_name as custodian_last_name', 'description->custodian->email as custodian_email', 
                                            )
                                            ->first();
                    $data = [
                        'title' => 'PRS: #' . $request->item_request_header_id,
                        'sender_name' => $itemRequestHeader->custodian_first_name . ' ' . $itemRequestHeader->custodian_last_name,
                        'recipient_name' => $itemRequestHeader->first_name . ' ' . $itemRequestHeader->last_name,
                        'recipient_email' => $itemRequestHeader->email,
                        'prs_no' => '#' . $request->item_request_header_id,
                        'message' => 'PRS #' . $request->item_request_header_id . ' has been closed/completed by Custodian.', 
                    ];
                    Mail::to($data['recipient_email'])->send(new ProvisionRequestMail($data));
                    $data2 = [
                        'title' => 'PRS: #' . $request->item_request_header_id,
                        'sender_name' => $itemRequestHeader->custodian_first_name . ' ' . $itemRequestHeader->custodian_last_name,
                        'recipient_name' => $itemRequestHeader->custodian_first_name . ' ' . $itemRequestHeader->custodian_last_name,
                        'recipient_email' => Auth::user()->email,
                        'prs_no' => '#' . $request->item_request_header_id,
                        'message' => 'You have completed/closed PRS #' .  $request->item_request_header_id . '.', 
                    ];
                    Mail::to($data2['recipient_email'])->send(new ProvisionRequestMail($data2));
                });
                return response()->json(['message'=>"#$request->item_request_header_id Provision Request is complete."], $this->successStatus); // Do not change the status message naka link yan sa angular as trigger
            } catch (Exception $e) {
                return response()->json($e);
            }
        }
        else{ //kULANG PA
        }
                return response()->json(['message' => "Item has been Delivered and Completed"], $this->successStatus);
                } catch (Exception $e) {
                return response()->json($e);
                }
            }
            else 
            {
              //  return response()->json(['message' => $total . ' Kulang Pa'. $total_stockout_quantity .'=' . $total_request_quantity ], $this->errorStatus);
                try {
                    $now = Carbon::now();
                    DB::table('item_request_details as a')
                            ->where('a.id', $id)
                            ->update(['a.status' => 'Delivered',
                                      'a.updated_at' => $now,]);

                    return response()->json(['message' => "Item has been Delivered"], $this->successStatus);
                } catch (Exception $e) {
                    return response()->json($e);
                }
               
            }
        }
        elseif($request->action == 'cancel')
        {
            try {
                $now = Carbon::now();
                DB::table('item_request_details as a')
                        ->where('a.id', $id)
                        ->update(['a.status' => 'Cancelled',
                                  'a.updated_at' => $now,]);

                DB::table('item_requests')  //Automatic Partial pa din Request
                ->where('id', $request->item_id)
                ->where('item_request_header_id', $request->item_request_header_id)
                ->update(['status_id' => 7]);                 
                
                $item_detail = DB::table('item_details')->where('id', $request->alternative_item_id)->first(); //iabab;lik yung quantuty
                $quantity = $item_detail->quantity + $request->quantity;
                DB::table('item_details as a')
                ->where('a.id', $request->alternative_item_id)
                ->update(['a.quantity' => $quantity]);

                return response()->json(['message' => "Item has been Cancelled"], $this->successStatus);
            } catch (Exception $e) {
                return response()->json($e);
            }
        }

      
    }


    public function update(Request $request, $id)
    {
        try {
            $module = $this->module();
            if($module->access == false)
            {
                return response()->json(['message'=>"No Access For This Module."], $this->errorStatus);
            }
            $check = DB::table('item_request_headers')->where('id', $request->item_request_header_id)->where('status_id', 10)->exists();
            if(!$check) 
            {
                return response()->json(['message'=>"#$request->item_request_header_id Please check the status of Provision Request."], $this->errorStatus); 
            }
            $status = $this->status($request->action);
            $message = "Item has been " . $status['description'] . ".";
            DB::transaction(function () use ($request, $status) {
                $now = Carbon::now();
                DB::table('item_requests')->where('id', $request->item_request_id)->where('item_request_header_id', $request->item_request_header_id)->update(['status_id' => $status['id']]);
                DB::table('item_request_logs')->insert([
                    'item_request_header_id' => $request->item_request_header_id,
                    'item_request_id' => $request->item_request_id,
                    'status_id' => $status['id'],
                    'user_id' => Auth::id(),
                    'action' => $request->action,
                    'description' => $request->action,
                    'remarks' => $request->remarks,
                    'created_at' => $now,
                    'updated_at' => $now
                ]);
            });
            return response()->json(['message'=>$message], $this->successStatus);
        } catch (Exception $e) {
			return response()->json($e);
		}
    }
}
