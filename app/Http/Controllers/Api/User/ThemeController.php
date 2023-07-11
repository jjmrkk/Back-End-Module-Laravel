<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ThemeController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 400;

    public function store(Request $request)
    {
        try {
            DB::table('user_profiles')->where('user_id', Auth::id())->update(['theme'=>$request->theme]);
        } catch (Exception $e) {
			return response()->json($e);
		}    
    }
}
