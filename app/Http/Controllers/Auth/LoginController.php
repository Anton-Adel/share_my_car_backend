<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
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
            $success['token']=$user->createToken('Anton')->accessToken;
            $success['data']=$user->all() ;
            return $this->sendResponse($success,"User login successfully");
        }
        else
        {
            return $this->sendError('Please validate your Auth',['error'=>"Uuauthorized"]);
        }
    }
}
