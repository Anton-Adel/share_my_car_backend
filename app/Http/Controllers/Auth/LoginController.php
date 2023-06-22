<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\EmailVerification;
class LoginController extends BaseController
{
    public function login (Request $request)
    {
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password]))
        {
            // $input=$request->all();
            // $input['password']=Hash::make($input['password']);
            // $user=User::create($input);
            //$user = Auth::user();
            $user=User::where('email',$request->email)->first();
            $user['token']=$user->createToken('Anton')->accessToken;

            //$user->notify(new EmailVerification());
            return $this->sendResponse($user,"User login successfully");
        }
        else
        {
            return $this->sendError('Please validate your Auth',['error'=>"Uuauthorized"]);
        }
    }
}
