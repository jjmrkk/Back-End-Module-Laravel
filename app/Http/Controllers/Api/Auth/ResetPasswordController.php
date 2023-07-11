<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\ResetPasswordRequest;
use App\User;

class ResetPasswordController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 400;
    
    public function reset(ResetPasswordRequest $request)
    {
        $user = Auth::user();
        try {
            if (Hash::check($request->old_password, $user->getAuthPassword())){
                User::where('id',$user->id)->update([
					'password' => Hash::make($request->password)
                ]);
                return response()->json(['message' => 'Password has been changed successfully.'], $this->successStatus);
            }
            return response()->json(['errors'=> ['old_password' => 'The old password is incorrect.']], 422);
        } catch (Exception $e) {
			return response()->json($e);
		}
    }
}
