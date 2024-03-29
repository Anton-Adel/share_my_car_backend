<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponse ($result,$message)
    {
        $response=
        [
            'success'=>true,
            'result'=>$result,
            'messsage'=>$message
        ];
        return response()->json($response,200);
    }

    public function sendError ($error,$errorMessag=[],$code=404)
    {
        $response=
        [

            'success'=>false,
            'data'=>$errorMessag,
            'message'=>$error

        ];
        // if(!empty($errorMessag))
        // {
        //     $response['data']=$errorMessag;
        // }
        return response()->json($response,$code);
    }
}
