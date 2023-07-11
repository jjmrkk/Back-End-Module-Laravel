<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Exceptions\Handler;

class LogoutController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 400;

    public function logout()
    {
        try { 
            //return $request->header('Authorization');
            Auth::user()->token()->revoke();
            return response()->json(['message'=>'Logged out.'], $this->successStatus);
        } catch (Exception $e) {
			return response()->json($e);
		}
    }
}
