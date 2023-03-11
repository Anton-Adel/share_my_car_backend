<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class RegisterController extends BaseController
{
    public function register (Request $request)
    {

        $validator =Validator::make($request->all(),
        [
            'first_name'=>'required|max:50',
            'last_name'=>'required|max:50',
            'gender'=>'required',
            'age'=>'required',
            'id_number'=>'required|min:14', // ممكن تضرب بسبب ده
            'personal_image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'card_image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'email'=>'required|unique:users,email',
            'password'=>'required|min:9',
            'country'=>'required',
            'city'=>'required',
            'address'=>'required',
            'phone_number'=>'required|unique:users,phone_number|digits_between:10,20',
            'have_car'=>'required',
            'car_model'=>'nullable',
            'car_color'=>'nullable',
            'car_plate_number'=>'nullable',
            'car_image'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'car_plate_image'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'car_license_image'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'c_password'=>'required|same:password',

        ]);
        if($validator->fails())
        {
            return $this->sendError('Please validate your data',$validator->errors());
        }
        $personal_image_name=Str::random(32).".".$request->personal_image->getClientOriginalExtension();
        $card_image_name=Str::random(32).".".$request->card_image->getClientOriginalExtension();
        if($request->car_image)
        {
            $car_image_name=Str::random(32).".".$request->car_image->getClientOriginalExtension();
        }

        if($request->car_plate_image)
        {
            $car_plate_image_name=Str::random(32).".".$request->car_plate_image->getClientOriginalExtension();
        }

        if($request->car_license_image)
        {
            $car_license_image_name=Str::random(32).".".$request->car_license_image->getClientOriginalExtension();
        }
        $input=$request->all();
        $hassed_password=Hash::make($input['password']);
        //$user=User::create($input);


        $user=User::create(
            [
                'first_name'=>$request->first_name,
                'last_name'=>$request->last_name,
                'gender'=>$request->gender,
                'age'=>$request->age,
                'id_number'=>$request->id_number,
                'personal_image'=>$personal_image_name,
                'card_image'=>$card_image_name,
                'email'=>$request->email,
                'password'=> $hassed_password,
                'country'=>$request->country,
                'city'=>$request->city,
                'address'=>$request->address,
                'phone_number'=>$request->phone_number,
                'have_car'=>$request->have_car,
                'car_model'=>$request->car_model,
                'car_color'=>$request->car_color,
                'car_plate_number'=>$request->car_plate_number,
                'car_image'=>$car_image_name,
                'car_plate_image'=>$car_plate_image_name,
                'car_license_image'=>$car_license_image_name,
            ]
        );
        //Storage::disk('public/PersonalImages')->put($imageName,file_get_contents($request->personal_image));
        //personal image
        $request->personal_image->move(public_path('PersonalImages'), $personal_image_name);
        $path="public/PersonalImages/$personal_image_name";
        $user->personal_image =$path;
        //card image
        $request->card_image->move(public_path('CardImages'), $card_image_name);
        $path="public/CardImages/$card_image_name";
        $user->card_image =$path;
        //car image
        $request->car_image->move(public_path('CarImages'), $car_image_name);
        $path="public/CarImages/$car_image_name";
        $user->car_image =$path;
        // plate image
        $request->car_plate_image->move(public_path('CarPlateImages'), $car_plate_image_name);
        $path="public/CarPlateImages/$car_plate_image_name";
        $user->car_plate_image =$path;
        // lincese image
        $request->car_license_image->move(public_path('CarLicenseImages'), $car_license_image_name);
        $path="public/CarLicenseImages/$car_license_image_name";
        $user->car_license_image =$path;
        $user->save();

        $success['token']=$user->createToken('Anton')->accessToken;
        $success['first_name']=$user->first_name;
        return $this->sendResponse($success,"User registered successfully");

    }
}
