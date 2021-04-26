<?php


namespace App\Services\Auth;
use App\Repositories\Users\AuthInterface;

class AuthServices
{
    protected $authRepo;
    public function __construct(AuthInterface $authRepo)
    {
        $this->authRepo = $authRepo;
    }

    public function getversion()
    {
        try
        {
            if (!empty($getversion = $this->authRepo->getversion())) {
                $res['status_code'] = 200;
                $res['message'] = trans('message.data_success');
                $res['data'] = $getversion;
                return $res;
            }
            $res['status_code'] = 201;
            $res['message'] = trans('message.data_fail');
            $res['data'] = false;
            return $res;
       }
       catch (\Exception $e) 
       {
            $res['status_code'] = 202;
            $res['message'] = $e->getMessage();
            $res['data'] = false;
            return $res;
       }
    }

    public function signUp(array $data)
    {
        try
        {
            if (!empty($register = $this->authRepo->signUp($data))) {
                $res['status_code'] = 200;
                $res['message'] = trans('message.registered_success');
                $res['data'] = $register;
                return $res;
            }
            $res['status_code'] = 201;
            $res['message'] = trans('message.registered_fail');
            $res['data'] = false;
            return $res;
       }
       catch (\Exception $e) 
       {
            $res['status_code'] = 202;
            $res['message'] = $e->getMessage();
            $res['data'] = false;
            return $res;
       }
    }

    public function verifyPhone(array $data)
    {
        try
        {
            if (!empty($register = $this->authRepo->verifyPhone($data))) {
                $res['status_code'] = 200;
                $res['message'] = trans('message.verification_success');
                $res['data'] = $register;
                return $res;
            }
            $res['status_code'] = 201;
            $res['message'] = trans('message.verification_fail');
            $res['data'] = false;
            return $res;
       }
       catch (\Exception $e) 
       {
            $res['status_code'] = 202;
            $res['message'] = $e->getMessage();
            $res['data'] = false;
            return $res;
       }
    }

    public function resendOTP(array $data)
    {
        try
        {
            if (!empty($register = $this->authRepo->resendOTP($data))) {
                $res['status_code'] = 200;
                $res['message'] = trans('message.sendotp_success');
                $res['data'] = $register;
                return $res;
            }
            $res['status_code'] = 201;
            $res['message'] = trans('message.sendotp_fail');
            $res['data'] = false;
            return $res;
       }
       catch (\Exception $e) 
       {
            $res['status_code'] = 202;
            $res['message'] = $e->getMessage();
            $res['data'] = false;
            return $res;
       }
    }

    public function login(array $data)
    {
        try
        {
            $login = $this->authRepo->login($data);
            if($login === 201) {
                $res['status_code'] = 201;
                $res['message'] = trans('Login failed');
                $res['data'] = false;
                return $res;
            }
            // elseif($login === 202) {
            //     $res['status_code'] = 202;
            //     $res['message'] = "Your email is not verified, we have sent OTP to your registered email";
            //     $res['data'] = array('user_id' => 0,'is_verify' => "InActive",'name' => '','profile_pic' => '','access_token' => '');
            //     return $res;
            // }
            else if (!empty($login)) {
                $res['status_code'] = 200;
                $res['message'] = trans('Successfully loggedIn');
                $res['data'] = $login;
                return $res;
            }
            $res['status_code'] = 201;
            $res['message'] = trans('Login failed');
            $res['data'] = false;
            return $res;
       }
       catch (\Exception $e) 
       {
            $res['status_code'] = 202;
            $res['message'] = $e->getMessage();
            $res['data'] = false;
            return $res;
       }
    }

    public function logOut()
    {
        try
        {
            if (!empty($logOut = $this->authRepo->logOut())) {
                $res['status_code'] = 200;
                $res['message'] = trans('message.logout_success');
                $res['data'] = $logOut;
                return $res;
            }
            $res['status_code'] = 201;
            $res['message'] = trans('message.logout_fail');
            $res['data'] = false;
            return $res;
       }
       catch (\Exception $e) 
       {
            $res['status_code'] = 202;
            $res['message'] = $e->getMessage();
            $res['data'] = false;
            return $res;
       }
    }

    public function forgotPassword(array $data)
    {
        try
        {
            $result = $this->authRepo->forgotPassword($data);
            if($result === 201) {
                $res['status_code'] = 201;
                $res['message'] = trans('message.detail_fail');
                $res['data'] = false;
                return $res;
            }
            else if (!empty($result)) {
                $res['status_code'] = 200;
                $res['message'] = trans('message.forgot_update_success');
                $res['data'] = $result;
                return $res;
            }
            $res['status_code'] = 201;
            $res['message'] = trans('message.forgot_update_fail');
            $res['data'] = false;
            return $res;
       }
       catch (\Exception $e) 
       {
            $res['status_code'] = 202;
            $res['message'] = $e->getMessage();
            $res['data'] = false;
            return $res;
       }
    }

    public function getStateWiseCities()
    {
        try
        {
            $result = $this->authRepo->getStateWiseCities();
            if(!empty($result)) {
                $res['status_code'] = 200;
                $res['message'] = trans('message.data_success');
                $res['data'] = $result;
                return $res;
            }
            $res['status_code'] = 201;
            $res['message'] = trans('message.data_fail');
            $res['data'] = false;
            return $res;
       }
       catch (\Exception $e) 
       {
            $res['status_code'] = 202;
            $res['message'] = $e->getMessage();
            $res['data'] = false;
            return $res;
       }
    }

    public function getCities()
    {
        try
        {
            $result = $this->authRepo->getCities();
            if(!empty($result)) {
                $res['status_code'] = 200;
                $res['message'] = trans('message.data_success');
                $res['data'] = $result;
                return $res;
            }
            $res['status_code'] = 201;
            $res['message'] = trans('message.data_fail');
            $res['data'] = false;
            return $res;
       }
       catch (\Exception $e) 
       {
            $res['status_code'] = 202;
            $res['message'] = $e->getMessage();
            $res['data'] = false;
            return $res;
       }
    }

    public function getCategories()
    {
        try
        {
            $result = $this->authRepo->getCategories();
            if(!empty($result)) {
                $res['status_code'] = 200;
                $res['message'] = trans('message.data_success');
                $res['data'] = $result;
                return $res;
            }
            $res['status_code'] = 201;
            $res['message'] = trans('message.data_fail');
            $res['data'] = false;
            return $res;
       }
       catch (\Exception $e) 
       {
            $res['status_code'] = 202;
            $res['message'] = $e->getMessage();
            $res['data'] = false;
            return $res;
       }
    }

    public function getBanners()
    {
        try
        {
            $result = $this->authRepo->getBanners();
            if(!empty($result)) {
                $res['status_code'] = 200;
                $res['message'] = trans('message.data_success');
                $res['data'] = $result;
                return $res;
            }
            $res['status_code'] = 201;
            $res['message'] = trans('message.data_fail');
            $res['data'] = false;
            return $res;
       }
       catch (\Exception $e) 
       {
            $res['status_code'] = 202;
            $res['message'] = $e->getMessage();
            $res['data'] = false;
            return $res;
       }
    }

    public function getFAQs()
    {
        try
        {
            $result = $this->authRepo->getFAQs();
            if(!empty($result)) {
                $res['status_code'] = 200;
                $res['message'] = trans('message.data_success');
                $res['data'] = $result;
                return $res;
            }
            $res['status_code'] = 201;
            $res['message'] = trans('message.data_fail');
            $res['data'] = false;
            return $res;
       }
       catch (\Exception $e) 
       {
            $res['status_code'] = 202;
            $res['message'] = $e->getMessage();
            $res['data'] = false;
            return $res;
       }
    }

    public function getAboutUsTerms()
    {
        try
        {
            $result = $this->authRepo->getAboutUsTerms();
            if(!empty($result)) {
                $res['status_code'] = 200;
                $res['message'] = trans('message.data_success');
                $res['data'] = $result;
                return $res;
            }
            $res['status_code'] = 201;
            $res['message'] = trans('message.data_fail');
            $res['data'] = false;
            return $res;
       }
       catch (\Exception $e) 
       {
            $res['status_code'] = 202;
            $res['message'] = $e->getMessage();
            $res['data'] = false;
            return $res;
       }
    }

    public function getBlogs()
    {
        try
        {
            $result = $this->authRepo->getBlogs();
            if(!empty($result)) {
                $res['status_code'] = 200;
                $res['message'] = trans('message.data_success');
                $res['data'] = $result;
                return $res;
            }
            $res['status_code'] = 201;
            $res['message'] = trans('message.data_fail');
            $res['data'] = false;
            return $res;
       }
       catch (\Exception $e) 
       {
            $res['status_code'] = 202;
            $res['message'] = $e->getMessage();
            $res['data'] = false;
            return $res;
       }
    }

    public function getTestimonials()
    {
        try
        {
            $result = $this->authRepo->getTestimonials();
            if(!empty($result)) {
                $res['status_code'] = 200;
                $res['message'] = trans('message.data_success');
                $res['data'] = $result;
                return $res;
            }
            $res['status_code'] = 201;
            $res['message'] = trans('message.data_fail');
            $res['data'] = false;
            return $res;
       }
       catch (\Exception $e) 
       {
            $res['status_code'] = 202;
            $res['message'] = $e->getMessage();
            $res['data'] = false;
            return $res;
       }
    }
}
