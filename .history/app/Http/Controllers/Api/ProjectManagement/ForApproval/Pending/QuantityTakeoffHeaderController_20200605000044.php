<?php

namespace App\Http\Controllers\Api\ProjectManagement\ForApproval\Pending;

use App\Http\Controllers\Controller;
use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuantityTakeoffHeaderController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 400;

    public function index()
    {
        try {
            $qtoHeaders = DB::table('quantity_takeoff_headers as header')
                            ->where('header.status_id', 3)
                            ->join('user_profiles as profile', 'header.user_id', 'profile.user_id')
                            ->select(
                                'header.id', 'header.date', 'header.project_id', 'header.status_id',
                                'header.total_cost', DB::raw('null as project_name'), 'profile.first_name', 'profile.last_name'
                            )
                            ->orderBy('header.date', 'asc')
                            ->get();
            if($qtoHeaders)
            {
                foreach($qtoHeaders as $qtoHeader)
                {
                    $qtoHeader->project_name = $this->project($qtoHeader->project_id);
                }
            }
            return response()->json(['qtoHeaders'=>$qtoHeaders], $this->successStatus);
        } catch (Exception $e) {
			return response()->json($e);
		}
    }

    public function qtoHeaderCount()
    {
        try {
            $qtoHeaderCount = DB::table('quantity_takeoff_headers')->where('status_id', 3)->count();
            return response()->json(['qtoHeaderCount'=>$qtoHeaderCount], $this->successStatus);
        } catch (Exception $e) {
			return response()->json($e);
		}
    }

    private function project($id)
    {
        $project = DB::table('projects as project')
                    ->where('project.id', $id)
                    ->leftJoin('business_units as branch', 'project.business_unit_id', 'branch.id')
                    ->leftJoin('business_unit_relations as l', 'branch.id', 'l.child')
                    ->leftJoin('business_units as location', 'l.parent', 'location.id')
                    ->leftJoin('business_unit_relations as d', 'location.id', 'd.child')
                    ->leftJoin('business_units as division', 'd.parent', 'division.id')
                    ->orderBy('project.code', 'ASC')
                    ->orderBy('branch.name', 'ASC')
                    ->select('project.id as id', 'project.name as department', 'branch.code as branch', 'location.name as location', 'division.name as division')
                    ->first();
        return $project->branch . ' (' . $project->location . ') - ' . $project->department;
    }
}
