<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Notifications\ConfirmTrip;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Notifications\EmailVerification;

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
            'id_number'=>'required|unique:users,id_number|min:14', // ممكن تضرب بسبب ده
            'personal_image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'card_image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'email'=>'required|unique:users,email',
            'password'=>'required|min:9',
            'country'=>'required',
            'city'=>'required',
            'address'=>'required',
            'phone_number'=>'required|unique:users,phone_number|digits_between:10,20',
            'cluster_number'=>'nullable',
            'have_car'=>'required',
            'car_model'=>'nullable',
            'car_color'=>'nullable',
            'car_plate_number'=>'nullable',
            'car_image'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'car_plate_image'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'car_license_image'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'car_seats'=>'nullable',
            'c_password'=>'required|same:password',
            'trip_gender'=>'required',
            'smoke'=>'required',
            'trip_smoke'=>'required',
            'trip_music'=>'required',
            'trip_conditioner'=>'required',
            'trip_children'=>'required',
            'trip_pets'=>'required',
        ]);
        if($validator->fails())
        {
            return $this->sendError('Please validate your data',$validator->errors());
        }
        $personal_image_name=Str::random(32).".".$request->personal_image->getClientOriginalExtension();
        $card_image_name=Str::random(32).".".$request->card_image->getClientOriginalExtension();
        $car_image_name=null;
        if($request->car_image)
        {
            $car_image_name=Str::random(32).".".$request->car_image->getClientOriginalExtension();
            $request->car_image->move(public_path('CarImages'), $car_image_name);
        }

        $car_plate_image_name=null;
        if($request->car_plate_image)
        {
            $car_plate_image_name=Str::random(32).".".$request->car_plate_image->getClientOriginalExtension();
            $request->car_plate_image->move(public_path('CarPlateImages'), $car_plate_image_name);
        }

        $car_license_image_name=null;
        if($request->car_license_image)
        {
            $car_license_image_name=Str::random(32).".".$request->car_license_image->getClientOriginalExtension();
            $request->car_license_image->move(public_path('CarLicenseImages'), $car_license_image_name);
        }
        $input=$request->all();
        $hashed_password=Hash::make($input['password']);
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
                'password'=> $hashed_password,
                'country'=>$request->country,
                'city'=>$request->city,
                'address'=>$request->address,
                'phone_number'=>$request->phone_number,
                'have_car'=>$request->have_car,
                'car_model'=>$request->car_model ,
                'car_color'=>$request->car_color ,
                'car_plate_number'=>$request->car_plate_number ,
                'car_image'=>$car_image_name,
                'car_plate_image'=>$car_plate_image_name ,
                'car_license_image'=>$car_license_image_name ,
                'trip_gender'=>$request->trip_gender,
                'smoke'=>$request->smoke,
                'trip_smoke'=>$request->trip_smoke,
                'trip_music'=>$request->trip_music,
                'trip_conditioner'=>$request->trip_conditioner,
                'trip_children'=>$request->trip_children,
                'trip_pets'=>$request->trip_pets,
                'car_seats'=>$request->car_seats,
                'cluster_number'=>$request->cluster_number

            ]
        );
        // Storage::disk('public/PersonalImages')->put($imageName,file_get_contents($request->personal_image));
        // personal image
         $request->personal_image->move(public_path('PersonalImages'), $personal_image_name);
        // $path="public/PersonalImages/$personal_image_name";
        // $user->personal_image =$path;
        //card image
        $request->card_image->move(public_path('CardImages'), $card_image_name);
        // $path="public/CardImages/$card_image_name";
        // $user->card_image =$path;
        //car image

        // $path="public/CarImages/$car_image_name";
        // $user->car_image =$path;
        // plate image

        // $path="public/CarPlateImages/$car_plate_image_name";
        // $user->car_plate_image =$path;
        // lincese image

        // $path="public/CarLicenseImages/$car_license_image_name";
        // $user->car_license_image =$path;
        // $user->save();


       // $success['token']=$user->createToken('Anton')->accessToken;
        //$success['first_name']=$user->first_name;
        // $randomNumber = random_int(1000, 9000);
        // //dd($randomNumber);
         $success['email']=$request['email'];
         $success['password']=$request['password'];
        // $user['code']=$randomNumber;


        // $user->notify(new EmailVerification());
        return $this->sendResponse($success,"User registered successfully");

    }






    public function send_code(Request $request )
    {
        $validator =Validator::make($request->all(),
        [
            'first_name'=>"required",
            'last_name'=>"required",
            'email'=>'required',

        ]);
        if($validator->fails())
        {
            return $this->sendError('Please your email is required',$validator->errors());
        }
        $input=$request->all();
        $randomNumber = random_int(1000, 9000);

        //dd($randomNumber);

        $user= new User();
        $success['code']=$randomNumber;
        $user['code']=$randomNumber;
        $user['email']=$request['email'];
        $user['first_name']=$request['first_name'];
        $user['last_name']=$request['last_name'];

        $user->notify(new EmailVerification());
        return $this->sendResponse($user,"User registered successfully");
    }


    public function send_confirm_car(Request $request )
    {
        $validator =Validator::make($request->all(),
        [
            'first_name'=>"required",
            'last_name'=>"required",
            'phone'=>"required",
            'email'=>'required',

        ]);
        if($validator->fails())
        {
            return $this->sendError('Please your email is required',$validator->errors());
        }
        $input=$request->all();


        //dd($randomNumber);

        $user= new User();

        $user['phone']=$request['phone'];
        $user['email']=$request['email'];
        $user['first_name']=$request['first_name'];
        $user['last_name']=$request['last_name'];

        $user->notify(new ConfirmTrip());
        return $this->sendResponse($user,"User confirm the trip successfully");
    }






}
