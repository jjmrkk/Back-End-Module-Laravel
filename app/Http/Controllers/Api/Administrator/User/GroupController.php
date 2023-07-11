<?php

namespace App\Http\Controllers\Api\Administrator\User;

use App\Http\Controllers\Controller;
use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 400;

    public function show($id)
    {
        try {
            $groups = DB::table('business_unit_relations as g')
                            ->where('g.parent', $id)
                            ->join('business_units as group', 'g.child', 'group.id')
                            ->orderBy('group.name', 'ASC')
                            ->select('group.id', 'group.name as group')
                            ->get();
            return response()->json(['groups'=>$groups], $this->successStatus);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
