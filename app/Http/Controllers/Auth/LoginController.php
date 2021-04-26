<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Services\Auth\AuthServices;

class LoginController extends Controller
{

 private $service;

  public function __construct(AuthServices $service)
  {
    $this->service = $service;
  }

   public function login(Request $request)
    {

       $res = $this->service->login($request->all());
       return response()->json($res, 200);

        // if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
        //     $user = Auth::user(); 
        //     $success['token'] =  $user->createToken('MyApp')-> accessToken; 
        //     $success['name'] =  $user->name;
        //     $success['email'] =  $user->email;
   
        //     return $this->sendResponse($success, 'User login successfully.');
        // } 
        // else{ 
        //     return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        // } 
    }

}
