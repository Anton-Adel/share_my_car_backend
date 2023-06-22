<?php

namespace App\Http\Controllers;
use App\Models\Trip;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class TripController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trips = Trip::all();
        return $this->sendResponse($trips,"Trips get successfully");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {

    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator =Validator::make($request->all(),
        [
            'start_location'=>'required',
            'end_location'=>'required',
            'start_time'=>'required',
            'end_time'=>'nullable',
            'user_id'=>'required', // ممكن تضرب بسبب ده
            'user_cluster' => 'required'
        ]);
        if($validator->fails())
        {
            return $this->sendError('Please validate your data',$validator->errors());
        }
        $input=$request->all();
        $trip=Trip::create($input);
        // $success['user_id']=$request->user_id;
        // $user=User::find($request->user_id);
        // if(is_null($user))
        // {
        //     return $this->sendError('there is no user found');
        // }
        // $success['name']=$user->first_name;
        return $this->sendResponse($trip,"Trip Created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $trip=Trip::find($id);
        if(is_null($trip))
        {
            return $this->sendError('there is no trip found');
        }

        return $this->sendResponse($trip,"Trip Created successfully");

        // $trips =Trip::where('user_id',$id)->get();
        // //$trips=Trip::find($id);
        // if(is_null($trips))
        // {
        //     return $this->sendError('there is no trip found');
        // }

        // return $this->sendResponse($trips,"Trips get successfully");
    }

    public function get_User_trips($id)
    {
        // $trip=Trip::find($id);
        // if(is_null($trip))
        // {
        //     return $this->sendError('there is no trip found');
        // }

        // return $this->sendResponse($trip,"Trip Created successfully");

        $trips =Trip::where('user_id',$id)->get();
        //$trips=Trip::find($id);
        if(is_null($trips))
        {
            return $this->sendError('there is no trip found');
        }

        return $this->sendResponse($trips,"Trips get successfully");
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $trip=Trip::find($id);
        //return $this->sendResponse($trip,"trip updated successfully");
        if(is_null($trip))
        {
            return $this->sendError('there is no trip found');
        }
        $validator =Validator::make($request->all(),
        [
            'start_location'=>'required',
            'end_location'=>'required',
            'start_time'=>'required',
            'end_time'=>'nullable',
            'user_id'=>'required', // ممكن تضرب بسبب ده
            'user_cluster' => 'required'
        ]);
        if($validator->fails())
        {
            return $this->sendError('Please validate your data',$validator->errors());
        }
        $trip->start_location= $request->start_location;
        $trip->end_location= $request->end_location;
        $trip->start_time= $request->start_time;
        $trip->end_time= $request->end_time;
        $trip->user_id= $request->user_id;
        $trip->user_cluster= $request->user_cluster;
        $trip->save();
        return $this->sendResponse($trip,"trip updated successfully");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $trip=Trip::find($id);
        if(is_null($trip))
        {
            return $this->sendError('there is no trip found');
        }
        $trip->delete();
        return $this->sendResponse($trip,"Trip Deleteted successfully");


    }
}
