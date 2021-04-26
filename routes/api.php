<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\controllers\Auth\RegisterController;
use App\Http\controllers\Auth\LoginController;
use App\Http\controllers\Admin\NewsController;
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

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);


Route::middleware('auth:api')->group(function () 
{
    Route::post('logOut', [AuthController::class, 'Logout']);
    Route::post('updateProfile', [ProfileController::class, 'UpdateProfile']);
    Route::post('getUserDetails', [ProfileController::class, 'GetUserDetails']);
    Route::post('addnews', [NewsController::class, 'Addnews']);
    
});