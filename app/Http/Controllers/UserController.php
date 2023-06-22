<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Exists;

use function PHPUnit\Framework\fileExists;
use function PHPUnit\Framework\isNull;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return $this->sendResponse($users,"Users retrived successfully");
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if(is_null($user))
        {
            return $this->sendError('there is no user found');
        }

        return $this->sendResponse($user,"User retrived successfully");
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
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
        $user = User::find($id);
        if(is_null($user))
        {
            return $this->sendError('there is no user found');
        }
        $validator =Validator::make($request->all(),
        [
            'first_name'=>'required|max:50',
            'last_name'=>'required|max:50',
            // 'gender'=>'required',
            // 'age'=>'required',
            // 'id_number'=>'required|min:14', // ممكن تضرب بسبب ده
             'personal_image'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'card_image'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            // 'email'=>'required|unique:users,email',
            // 'password'=>'required|min:9',
            // 'country'=>'required',
            // 'city'=>'required',
            // 'address'=>'required',
            // 'phone_number'=>'required|unique:users,phone_number|digits_between:10,20',
            // 'have_car'=>'required',
            'car_model'=>'nullable',
            'car_color'=>'nullable',
            'car_plate_number'=>'nullable',
            'car_image'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'car_plate_image'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'car_license_image'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            // 'car_seats' => 'required',
            // 'cluster_number' =>'nullable',
            // 'c_password'=>'required|same:password',
            // 'trip_gender'=>'required',
            // 'smoke'=>'required',
            // 'trip_smoke'=>'required',
            // 'trip_music'=>'required',
            // 'trip_conditioner'=>'required',
            // 'trip_children'=>'required',
            // 'trip_pets'=>'required',
        ]);


        if($validator->fails())
        {
            return $this->sendError('Please validate your data',$validator->errors());
        }


        $user->first_name= $request->first_name;
        $user->last_name= $request->last_name;
        // $user->gender= $request->gender;
        // $user->age= $request->age;
        // $user->id_number= $request->id_number;
        // $user->email= $request->email;
        // $user->password= $request->password;
        // $user->country= $request->country;
        // $user->city= $request->city;
        // $user->address= $request->address;
        // $user->phone_number= $request->phone_number;
        // $user->have_car= $request->have_car;
        // $user->car_model= $request->car_model;
        // $user->car_color= $request->car_color;
        // $user->car_plate_number= $request->car_plate_number;
        // $user->car_seats = $request->car_seats;
        // $user->cluster_number = $request->cluster_number;
        // $user->trip_gender= $request->trip_gender;
        // $user->smoke= $request->smoke;
        // $user->trip_smoke= $request->trip_smoke;
        // $user->trip_music= $request->trip_music;
        // $user->trip_conditioner= $request->trip_conditioner;
        // $user->trip_children= $request->trip_children;
        // $user->trip_pets= $request->trip_pets;



        // public_path('PersonalImages')::exist($user->personal_image)


         //$public_ =public_path('PersonalImages');
        if($request->personal_image)
        {
            if(file_exists(public_path('PersonalImages/'.$user->personal_image)))
            {
                unlink(public_path('PersonalImages/'.$user->personal_image));
            }
            $personal_image_name=Str::random(32).".".$request->personal_image->getClientOriginalExtension();
            $request->personal_image->move(public_path('PersonalImages'), $personal_image_name);
            // $path="public/PersonalImages/$personal_image_name";
            $user->personal_image= $personal_image_name;
        }

        if($request->card_image)
        {
            if(file_exists(public_path('CardImages/'.$user->card_image)))
            {
                unlink(public_path('CardImages/'.$user->card_image));
            }
            $card_image_name=Str::random(32).".".$request->personal_image->getClientOriginalExtension();
            $request->card_image->move(public_path('CardImages'), $card_image_name);
            // $path="public/PersonalImages/$personal_image_name";
            $user->card_image= $card_image_name;
        }

        if($request->car_image)
        {
            if(file_exists(public_path('CarImages/'.$user->card_image)))
            {
                unlink(public_path('CarImages/'.$user->card_image));
            }

            $car_image_name=Str::random(32).".".$request->car_image->getClientOriginalExtension();
            $request->car_image->move(public_path('CarImages'), $car_image_name);
            $user->car_image= $car_image_name;
        }

        if($request->car_plate_image)
        {
            if(file_exists(public_path('CarPlateImages/'.$user->card_image)))
            {
                unlink(public_path('CarPlateImages/'.$user->card_image));
            }

            $car_plate_image_name=Str::random(32).".".$request->car_plate_image->getClientOriginalExtension();
            $request->car_plate_image->move(public_path('CarPlateImages'), $car_plate_image_name);
            $user->car_plate_image= $car_plate_image_name;
        }


        if($request->car_license_image)
        {
            if(file_exists(public_path('CarLicenseImages/'.$user->card_image)))
            {
                unlink(public_path('CarLicenseImages/'.$user->card_image));
            }
            $car_license_image_name=Str::random(32).".".$request->car_license_image->getClientOriginalExtension();
            $request->car_license_image->move(public_path('CarLicenseImages'), $car_license_image_name);
            $user->car_license_image= $car_license_image_name;
        }
        $user->save();
        return $this->sendResponse($user,"User updated successfully");

    //     if($request->card_image_name)
    //     {
    //         if(public_path('PersonalImages')::file_exists($request->card_image_name))
    //         {

    //         }


    // }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}



// $card_image_name=Str::random(32).".".$request->card_image->getClientOriginalExtension();
// }

// if($request->car_image)
// {
//     $car_image_name=Str::random(32).".".$request->car_image->getClientOriginalExtension();
// }

// if($request->car_plate_image)
// {
//     $car_plate_image_name=Str::random(32).".".$request->car_plate_image->getClientOriginalExtension();
// }

// if($request->car_license_image)
// {
//     $car_license_image_name=Str::random(32).".".$request->car_license_image->getClientOriginalExtension();
// }
