<?php

namespace App\Repositories\Users;
use App\Repositories\Users\AuthInterface;
use App\Models\User;
use App\Helpers\CommonHelper;
use Carbon\Carbon;
use Auth;
use Session;

class AuthRepository implements AuthInterface
{
    protected $user;
    protected $helpers;
    // protected $states;
    // protected $cities;
    // protected $categories;
    // protected $homeBanners;
    // protected $faqs;
    // protected $defaults;
    // protected $testimonial;

    public function __construct(User $user,CommonHelper $helpers)
    {
        $this->user = $user;
        $this->helpers = $helpers;
        // $this->categories = $categories;
        // $this->homeBanners = $homeBanners;
        // $this->faqs = $faqs;
        // $this->defaults = $defaults;
        // $this->testimonial = $testimonial;
    }

    public function getversion()
    {
        return $this->helpers->v1_getVersion();
    }

    public function signUp(array $data)
    {
        $data['reset_hash'] = $this->helpers->generateRandomHexString(50);
        $data['reset_code'] = $this->helpers->randomPin();
    	$data['password'] = bcrypt($data['password']);
        do 
        {
          $referral_code = strtoupper($this->helpers->generateRandomHexString(6));
        }while($this->user::where('referral_code',$referral_code)->exists());

        $data['referral_code'] = $referral_code;
        $data['app_version'] = $this->helpers->v1_getVersion();

        // if($data['is_registered'] == 1)
        // {
            // $subject = env('APP_NAME').'- You are almost there | Confirm your Activation';
            // \Mail::to($data['email'])->send(new SendOTP($subject,$data));
        // }

        $user = $this->user->create($data);
        
        $res['user_id'] = $user->id;
        $res['name'] = $user->first_name.' '.$user->last_name;
        $res['profile_pic'] = $user->profile_pic;
        $res['access_token'] = $user->createToken('AppName')->accessToken;
        $res['reset_hash'] = $user->reset_hash; 
        return $res;
    }

    public function verifyPhone(array $data)
    {
        $user = $this->user::where('email','=',$data['email'])->first();
        if($user)
        {
            if($user->reset_code != $data['otp']){
              return false;
            }
            $data['is_email_verified'] = 1;
            $data['email_verified_at'] = now();
            $user->update($data);

            $res['user_id'] = $user->id;
            $res['name'] = $user->first_name.' '.$user->last_name;
            $res['profile_pic'] = $user->profile_pic;
            $res['access_token'] = $user->createToken('AppName')->accessToken;
            return $res;
        }
        else
        {
            return false;
        }
    }

    public function resendOTP(array $data)
    {
        $user = $this->user::where('email','=',$data['email'])->first();
        if($user){
            $data['phone'] = $user->phone;
            $data['reset_hash'] = $this->helpers->generateRandomHexString(50);
            $data['reset_code'] = $this->helpers->randomPin();
            $subject = env('APP_NAME').'- You are almost there | Confirm your Activation';
            \Mail::to($data['email'])->send(new SendOTP($subject,$data));
            $user->update($data);
            $res['reset_code'] = $data['reset_code'];
            return true;
        }
        else{
            return false;
        }
    }

    public function login(array $data)
    {
        $username = $data['email'];
        $user = $this->user::where(function($q)use ($username) {
                    $q->where('email', $username);
             })
        ->first();
        if ($user){
            // if($user->is_verify === "InActive"){
            //     $data['reset_code'] = $user->reset_code;
            //     $subject = env('APP_NAME').'- You are almost there | Confirm your Activation';
            //     \Mail::to($user->email)->send(new SendOTP($subject,$data));
            //     return 202;
            // }
           if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
                $field = 'email';
            }
            $credentials = [$field => $username,'password' => $data['password']];
            if (Auth::attempt($credentials)) {
                $res['user_id'] = $user->id;
                //$res['is_verify'] = $user->is_verify;
                $res['name'] = $user->name;
                //$res['profile_pic'] = $user->profile_pic;
                $res['token'] = $user->createToken('AppName')->accessToken;
                $res['reset_hash'] = $user->reset_hash; 
                return $res;
            }
            else{
                return false;
            }
        }
        return 201; 
    }

    public function logOut()
    {
        $user = Auth::user();
        $token = Auth::user()->token();
        $token->delete();
        return true;
    }

    // public function getStateWiseCities()
    // {
    //     return $this->states::with('cities')->Orderby('state','asc')->get(['id','state']);
    // }

    // public function getCities()
    // {
    //     return $this->cities::where('is_active','=',1)->Orderby('city','asc')->get(['id','city']);
    // }

    // public function getCategories()
    // {
    //     $categories = $this->categories::where('is_active','=',1)
    //     ->Orderby('category_name','asc')->get(['id','category_name','category_image','parent_id']);
    //     return $this->helpers->buildTree($categories, $parent_id = 0);
    // }

    // public function getBanners()
    // {
    //     return $this->homeBanners::where('is_active','=',1)
    //     ->Orderby('header_title','asc')->get(['id','header_title','hear_image']);
    // }

    // public function getFAQs()
    // {
    //     return $this->faqs::where('is_active','=',1)->get(['id','question','answer']);
    // }

    // public function getAboutUsTerms()
    // {
    //     return $this->defaults::first(['id','about_us','terms_conditions']);
    // }

    // public function getBlogs()
    // {
    //     return $this->blogs::where('is_active','=',1)
    //     ->Orderby('id','desc')
    //     ->get();
    // }

    // public function getTestimonials()
    // {
    //     return $this->testimonial::where('is_active','=',1)
    //     ->Orderby('id','desc')
    //     ->get();
    // }
}
