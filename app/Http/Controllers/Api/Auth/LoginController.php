<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Exceptions\Handler;
use Carbon\Carbon;

class LoginController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 400;

    public function login(LoginRequest $request) 
    {
        try {
            if (Auth::attempt(['email' => strtolower(trim($request->email)), 'password' => $request->password, 'active' => true])) 
            {
                $user = Auth::user();
                $access = DB::table('user_access')->where('user_id', $user->id)->first();
                $userProfile = DB::table('user_profiles')->where('user_id', $user->id)->first();
                $data['token'] = $user->createToken('Hq0AoSWLeicdnKD8GWN3ylhfNxhw7XMjNISGI9ul')->accessToken;
                $data['id'] = $user->id;
                //$data['email'] = $user->email;
                $data['first_name'] = $userProfile->first_name;
                $data['last_name'] = $userProfile->last_name;
                $data['theme'] = $userProfile->theme;
                //$data['contact_no'] = $userProfile->contact_no;
                //$data['employee_no'] = $userProfile->employee_no;
                //$data['position'] = $userProfile->position;
                //$data['department'] = $userProfile->department;
                //$path = 'private/profiles/';
                //$file = Storage::exists($path . $user->id . '.png') ? $user->id . '.png' : 'default-avatar.png';
                //$data['image'] = base64_encode(Storage::get($path . $user->id . '.png'));
                $data['access'] = $access->description;

                $now = Carbon::now();
                DB::table('users')
                ->where('id', $user->id)
                ->update(['updated_at' => $now ]);

                return response()->json($data, $this->successStatus);
 

            }
            return response()->json(['message'=>'Username or password is incorrect.'], $this->errorStatus);

        } catch (Exception $e) {
			return response()->json($e);
		}
    }
}
