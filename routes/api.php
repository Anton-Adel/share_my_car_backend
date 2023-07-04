<?php

use App\Http\Controllers\TripController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register','Auth\RegisterController@register');
Route::post('sendconfirm','Auth\RegisterController@send_confirm_car');


Route::post('sendcode','Auth\RegisterController@send_code');

Route::post('login','Auth\LoginController@login');

Route::middleware('auth:api')->group(function()
{
    Route::resource('user', 'UserController');
}

);

// Route::get('t','Trip2Controller@get_users');

Route::middleware('auth:api')->group(function()
{
    Route::resource('trip', 'TripController');

}
);
Route::get('/user_trips/{id}', [TripController::class, 'get_User_trips']);


// Route::middleware('auth:api')->group(function()
// {
//     // Route::resource('/t', "Trip2Controller");
//     return Route::get('t','Trip2Controller@show');

// }
// );
// Route::get('/t',function(){


//     return Route::get('t','Trip2Controller@show');

// });




