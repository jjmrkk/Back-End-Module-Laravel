<?php

namespace App\Http\Controllers\Api\BicolHealthFacility\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Exceptions\Handler;

class ModuleController extends Controller
{
    public function __construct()
    {
  //      $this->middleware('auth');
	}

	public $successStatus = 200;
    public $errorStatus = 400;

    public function index()
    {

        try {
            $modules = DB::table('modules')
                        ->join('module_functions', 'modules.id', 'module_functions.module_id')
                        ->select('modules.id as id', 'modules.system_id as system_id', 'modules.name as name', 'modules.description as description', 'module_functions.functions as functions')
                        ->orderBy('modules.name', 'asc')
                        ->get();
            foreach($modules as $module)
            {
                $module->functions = json_decode($module->functions, true);
            }
            return response()->json($modules, $this->successStatus);
        } catch (Exception $e) {
			return response()->json($e);
		}
    }
}
