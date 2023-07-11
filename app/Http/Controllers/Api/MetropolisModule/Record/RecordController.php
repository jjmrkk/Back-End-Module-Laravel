<?php

namespace App\Http\Controllers\Api\MSSTest\Record;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RecordController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 400;
 

    public function index()
    { 
        $now = Carbon::now();

        $Record_list = DB::table('mss_registration as a')
        ->leftjoin('mss_registration_maintenance as b', 'a.visit_type_id', 'b.id')
        ->leftjoin('mss_registration_status as c', 'a.id', 'c.mss_registration_id')
        ->select(
            'a.id',
            'a.visitor_id_no',
            DB::raw('CONCAT(a.last_name,\', \',a.first_name) as name'),
            'a.gender',
            'b.name as visit_type',
            'c.id as registration_status_id',
            'c.check_in',
            'c.check_out',
            DB::raw('null as total')
        )
          ->orderBy('a.created_at','desc')->take(10)->get();
          foreach ($Record_list as $list) {

            if($list->check_out == null)
            {
            $start = \Carbon\Carbon::parse($list->check_in);
            $end = \Carbon\Carbon::parse($now);
            $interval = $start->diff($end);
            
            if($days = $interval->format('%a') == 0)
            {
                $days = $interval->format('%h')." Hour ".$interval->format('%i')." Minute";  
                $list->total = $days;
            }
            else
            {
                $days = $interval->format('%a')." Day(s), ".$interval->format('%h')." Hour ".$interval->format('%i')." Minute";  
                $list->total = $days;
            }
            }
            else
            {
            $start = \Carbon\Carbon::parse($list->check_in);
            $end = \Carbon\Carbon::parse($list->check_out);
            $interval = $start->diff($end);

            if($days = $interval->format('%a') == 0)
            {
                $days = $interval->format('%h')." Hour ".$interval->format('%i')." Minute";  
                $list->total = $days;
            }
            else
            {
                $days = $interval->format('%a')." Day(s), ".$interval->format('%h')." Hour ".$interval->format('%i')." Minute";  
                $list->total = $days;
            }
            }
        }
        return response()->json($Record_list, 200);
    }

    public function visitor_detail($id)
    { 
        try {
            $now = Carbon::now();
            $Record_list = DB::table('mss_registration as a')
            ->leftjoin('mss_registration_maintenance as b', 'a.visit_type_id', 'b.id')
            ->leftjoin('mss_registration_status as c', 'a.id', 'c.mss_registration_id')
            ->leftjoin('user_profiles as d', 'a.user_id', 'd.user_id')

            ->where('a.id', $id)
            ->select(
                'a.id',
                'a.visitor_id_no',
                DB::raw('CONCAT(a.last_name,\', \',a.first_name) as name'),
                'a.gender',
                'b.name as visit_type',
                'a.contact_no',
                'a.purpose_of_visit',
                'a.note',
                'a.user_id',
                'c.id as registration_status_id',
                'c.check_in',
                'c.check_out',
                DB::raw('CONCAT(d.last_name,\', \',d.first_name) as encoded_by'),
                DB::raw('null as total')
            )
              ->first();
            return response()->json($Record_list, 200);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function update(Request $request)
    { 
     try {
            $now = Carbon::now();
            DB::table('mss_registration_status')
            ->where('id', $request->id)
            ->update([
                     'check_out' => $now
                     ]);
                   return response()->json(['message'=>'Success! Visitor details updated.'], $this->successStatus);
        } catch (Exception $e) {
            return response()->json($e);
        }

    }

    public function show($search)
    { 
        $terms  = explode(' ', $search );
        $now = Carbon::now();
        
        $Record_list = DB::table('mss_registration as a')
        ->leftjoin('mss_registration_maintenance as b', 'a.visit_type_id', 'b.id')
        ->leftjoin('mss_registration_status as c', 'a.id', 'c.mss_registration_id')
        ->where(function($query) use ($terms){
            foreach($terms as $term){
                $query->where('a.last_name', 'ilike', "%$term%");
            }
        })
        ->orWhere(function($query) use ($terms){
            foreach($terms as $term){
                $query->where('a.first_name','ilike', "%$term%");
            }
        })
        ->orWhere(function($query) use ($terms){
            foreach($terms as $term){
                $query->where('a.visitor_id_no', $term);
            }
        })
       
        ->select(
            'a.id',
            'a.visitor_id_no',
            DB::raw('CONCAT(a.last_name,\', \',a.first_name) as name'),
            'a.gender',
            'b.name as visit_type',
            'c.id as registration_status_id',
            'c.check_in',
            'c.check_out',
            DB::raw('null as total')
        )
          ->orderBy('a.created_at','desc')->take(10)->get();
          foreach ($Record_list as $list) {

            if($list->check_out == null)
            {
            $start = \Carbon\Carbon::parse($list->check_in);
            $end = \Carbon\Carbon::parse($now);
            $interval = $start->diff($end);
            
            if($days = $interval->format('%a') == 0)
            {
                $days = $interval->format('%h')." Hour ".$interval->format('%i')." Minute";  
                $list->total = $days;
            }
            else
            {
                $days = $interval->format('%a')." Day(s), ".$interval->format('%h')." Hour ".$interval->format('%i')." Minute";  
                $list->total = $days;
            }
            }
            else
            {
            $start = \Carbon\Carbon::parse($list->check_in);
            $end = \Carbon\Carbon::parse($list->check_out);
            $interval = $start->diff($end);

            if($days = $interval->format('%a') == 0)
            {
                $days = $interval->format('%h')." Hour ".$interval->format('%i')." Minute";  
                $list->total = $days;
            }
            else
            {
                $days = $interval->format('%a')." Day(s), ".$interval->format('%h')." Hour ".$interval->format('%i')." Minute";  
                $list->total = $days;
            }
            }
    }
    return response()->json($Record_list, 200);
    }

    public function filter($date_from, $date_to, $checkbox1)
    { 
        try {     
            $now = Carbon::now();

            if($checkbox1 == 'true')
            {
        $Record_list = DB::table('mss_registration as a')
        ->leftjoin('mss_registration_maintenance as b', 'a.visit_type_id', 'b.id')
        ->leftjoin('mss_registration_status as c', 'a.id', 'c.mss_registration_id')
        ->where('c.check_out',"!=", null)
        ->whereDate('a.created_at','>=', $date_from)
        ->whereDate('a.created_at','<=', $date_to)
        ->select(
            'a.id',
            'a.visitor_id_no',
            DB::raw('CONCAT(a.last_name,\', \',a.first_name) as name'),
            'a.gender',
            'b.name as visit_type',
            'c.id as registration_status_id',
            'c.check_in',
            'c.check_out',
            DB::raw('null as total')
        )
          ->orderBy('a.created_at','desc')->take(10)->get();
          foreach ($Record_list as $list) {

            if($list->check_out == null)
            {
            $start = \Carbon\Carbon::parse($list->check_in);
            $end = \Carbon\Carbon::parse($now);
            $interval = $start->diff($end);
            
            if($days = $interval->format('%a') == 0)
            {
                $days = $interval->format('%h')." Hour ".$interval->format('%i')." Minute";  
                $list->total = $days;
            }
            else
            {
                $days = $interval->format('%a')." Day(s), ".$interval->format('%h')." Hour ".$interval->format('%i')." Minute";  
                $list->total = $days;
            }
            }
            else
            {
            $start = \Carbon\Carbon::parse($list->check_in);
            $end = \Carbon\Carbon::parse($list->check_out);
            $interval = $start->diff($end);

            if($days = $interval->format('%a') == 0)
            {
                $days = $interval->format('%h')." Hour ".$interval->format('%i')." Minute";  
                $list->total = $days;
            }
            else
            {
                $days = $interval->format('%a')." Day(s), ".$interval->format('%h')." Hour ".$interval->format('%i')." Minute";  
                $list->total = $days;
            }
            }
            }
            return response()->json($Record_list, 200);
            }
           
            if($checkbox1 == 'false')
            {
            $Record_list = DB::table('mss_registration as a')
            ->leftjoin('mss_registration_maintenance as b', 'a.visit_type_id', 'b.id')
            ->leftjoin('mss_registration_status as c', 'a.id', 'c.mss_registration_id')
            ->whereDate('a.created_at','>=', $date_from)
            ->whereDate('a.created_at','<=', $date_to)
            ->select(
            'a.id',
            'a.visitor_id_no',
            DB::raw('CONCAT(a.last_name,\', \',a.first_name) as name'),
            'a.gender',
            'b.name as visit_type',
            'c.id as registration_status_id',
            'c.check_in',
            'c.check_out',
            DB::raw('null as total')
        )
          ->orderBy('a.created_at','desc')->take(10)->get();
          foreach ($Record_list as $list) {

            if($list->check_out == null)
            {
            $start = \Carbon\Carbon::parse($list->check_in);
            $end = \Carbon\Carbon::parse($now);
            $interval = $start->diff($end);
            
            if($days = $interval->format('%a') == 0)
            {
                $days = $interval->format('%h')." Hour ".$interval->format('%i')." Minute";  
                $list->total = $days;
            }
            else
            {
                $days = $interval->format('%a')." Day(s), ".$interval->format('%h')." Hour ".$interval->format('%i')." Minute";  
                $list->total = $days;
            }
            }
            else
            {
            $start = \Carbon\Carbon::parse($list->check_in);
            $end = \Carbon\Carbon::parse($list->check_out);
            $interval = $start->diff($end);

            if($days = $interval->format('%a') == 0)
            {
                $days = $interval->format('%h')." Hour ".$interval->format('%i')." Minute";  
                $list->total = $days;
            }
            else
            {
                $days = $interval->format('%a')." Day(s), ".$interval->format('%h')." Hour ".$interval->format('%i')." Minute";  
                $list->total = $days;
            }
            }
    }
    return response()->json($Record_list, 200);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

}
