<?php

namespace App\Services\Auth;

use App\Repositories\Profile\ProfileInterface;

class ProfileServices
{
	protected $authRepo;
    public function __construct(ProfileInterface $authRepo)
    {
        $this->authRepo = $authRepo;
    }

    public function updateProfile(array $data)
    {
        try
        {
            if (!empty($updateProfile = $this->authRepo->updateProfile($data))) {
                $res['status_code'] = 200;
                $res['message'] = trans('message.update_profile_success');
                $res['data'] = $updateProfile;
                return $res;
            }
            $res['status_code'] = 201;
            $res['message'] = trans('message.update_profile_fail');
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

    public function changePassword(array $data)
    {
        try
        {
            $changePassword = $this->authRepo->changePassword($data);
            if($changePassword === 201)
            {
                $res['status_code'] = 201;
                $res['message'] = trans('message.current_password_fail');
                $res['data'] = false;
                return $res;
            }
            else if($changePassword === 202)
            {
                $res['status_code'] = 202;
                $res['message'] = trans('message.current_password_same_fail');
                $res['data'] = false;
                return $res;
            }
            else if (!empty($changePassword)) {
                $res['status_code'] = 200;
                $res['message'] = trans('message.change_password_success');
                $res['data'] = $changePassword;
                return $res;
            }
            $res['status_code'] = 201;
            $res['message'] = trans('message.change_password_fail');
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

    public function profilePic(array $data)
    {
      try
      {
        if (!empty($profilePic = $this->authRepo->profilePic($data))) {
            $res['status_code'] = 200;
            $res['message'] = trans('message.profile_pic_success');
            $res['data'] = $profilePic;
            return $res;
        }
        $res['status_code'] = 201;
        $res['message'] = trans('message.profile_pic_fail');
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

    public function getUserDetails()
    {
        try
        {
            if (!empty($getUserDetails = $this->authRepo->getUserDetails())) {
                $res['status_code'] = 200;
                $res['message'] = trans('message.profile_details_success');
                $res['data'] = $getUserDetails;
                return $res;
            }
            $res['status_code'] = 201;
            $res['message'] = trans('message.profile_details_fail');
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

    public function couponsList(array $data)
    {
        try
        {
            if (!empty($couponsList = $this->authRepo->couponsList($data))) {
                $res['status_code'] = 200;
                $res['message'] = trans('message.coupons_list_success');
                $res['data'] = $couponsList;
                return $res;
            }
            $res['status_code'] = 201;
            $res['message'] = trans('message.coupons_list_success_fail');
            $res['data'] = false;
            return $res;
       }
       catch (\Exception $e) 
       {
            $res['status_code'] = 202;
            $res['message'] =  $e->getMessage();
            $res['data'] = false;
            return $res;
       }
    }

    public function couponDetails(array $data)
    {
        try
        {
            if (!empty($getUserDetails = $this->authRepo->couponDetails($data))) {
                $res['status_code'] = 200;
                $res['message'] = trans('message.coupons_details_success');
                $res['data'] = $getUserDetails;
                return $res;
            }
            $res['status_code'] = 201;
            $res['message'] = trans('message.coupons_details_success_fail');
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

    public function redeemCoupon(array $data)
    {
        try
        {
            $getUserDetails = $this->authRepo->redeemCoupon($data);
            if($getUserDetails === 201)
            {
                $res['status_code'] = 201;
                $res['message'] = trans('message.coupons_details_success_fail');
                $res['data'] = false;
                return $res;
            }
            elseif($getUserDetails === 202)
            {
                $res['status_code'] = 201;
                $res['message'] = trans('message.already_redeem_success');
                $res['data'] = false;
                return $res;
            }
            elseif(!empty($getUserDetails)) {
                $res['status_code'] = 200;
                $res['message'] = trans('message.redeem_success');
                $res['data'] = $getUserDetails;
                return $res;
            }
            $res['status_code'] = 201;
            $res['message'] = trans('message.redeem_fail');
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

    public function addAddress(array $data)
    {
        try
        {
            $getUserDetails = $this->authRepo->addAddress($data);
            if($getUserDetails === 201)
            {
                $res['status_code'] = 201;
                $res['message'] = trans('message.address_already_success_fail');
                $res['data'] = false;
                return $res;
            }
            elseif(!empty($getUserDetails)) {
                $res['status_code'] = 200;
                $res['message'] = trans('message.address_add_success');
                $res['data'] = $getUserDetails;
                return $res;
            }
            $res['status_code'] = 201;
            $res['message'] = trans('message.address_add_fail');
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

    public function updateAddress(array $data)
    {
        try
        {
            $getUserDetails = $this->authRepo->updateAddress($data);
            if($getUserDetails === 201)
            {
                $res['status_code'] = 201;
                $res['message'] = trans('message.address_not_found_fail');
                $res['data'] = false;
                return $res;
            }
            elseif(!empty($getUserDetails)) {
                $res['status_code'] = 200;
                $res['message'] = trans('message.address_updated_success');
                $res['data'] = $getUserDetails;
                return $res;
            }
            $res['status_code'] = 201;
            $res['message'] = trans('message.address_update_fail');
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

    public function deleteAddress(array $data)
    {
        try
        {
            $getUserDetails = $this->authRepo->deleteAddress($data);
            if($getUserDetails === 201)
            {
                $res['status_code'] = 201;
                $res['message'] = trans('message.address_not_found_fail');
                $res['data'] = false;
                return $res;
            }
            elseif(!empty($getUserDetails)) {
                $res['status_code'] = 200;
                $res['message'] = trans('message.address_deleted_success');
                $res['data'] = $getUserDetails;
                return $res;
            }
            $res['status_code'] = 201;
            $res['message'] = trans('message.address_deleted_fail');
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

    public function addressList(array $data)
    {
        try
        {
            if (!empty($couponsList = $this->authRepo->addressList($data))) {
                $res['status_code'] = 200;
                $res['message'] = trans('message.address_list_success');
                $res['data'] = $couponsList;
                return $res;
            }
            $res['status_code'] = 201;
            $res['message'] = trans('message.address_list_success_fail');
            $res['data'] = false;
            return $res;
       }
       catch (\Exception $e) 
       {
            $res['status_code'] = 202;
            $res['message'] =  $e->getMessage();
            $res['data'] = false;
            return $res;
       }
    }

    public function addressDetails(array $data)
    {
        try
        {
            if (!empty($couponsList = $this->authRepo->addressDetails($data))) {
                $res['status_code'] = 200;
                $res['message'] = trans('message.address_list_success');
                $res['data'] = $couponsList;
                return $res;
            }
            $res['status_code'] = 201;
            $res['message'] = trans('message.address_list_success_fail');
            $res['data'] = false;
            return $res;
       }
       catch (\Exception $e) 
       {
            $res['status_code'] = 202;
            $res['message'] =  $e->getMessage();
            $res['data'] = false;
            return $res;
       }
    }

    public function placeOrder(array $data)
    {
        try
        {
            $couponsList = $this->authRepo->placeOrder($data);
            if($couponsList === 201)
            {
                $res['status_code'] = 201;
                $res['message'] = trans('message.order_already_placed');
                $res['data'] = false;
                return $res;
            }
            elseif (!empty($couponsList)) {
                $res['status_code'] = 200;
                $res['message'] = trans('message.order_placed_success');
                $res['data'] = $couponsList;
                return $res;
            }
            $res['status_code'] = 201;
            $res['message'] = trans('message.order_placed_fail');
            $res['data'] = false;
            return $res;
       }
       catch (\Exception $e) 
       {
            $res['status_code'] = 202;
            $res['message'] =  $e->getMessage();
            $res['data'] = false;
            return $res;
       }
    }


    public function orderDetails(array $data)
    {
        try
        {
            $couponsList = $this->authRepo->orderDetails($data);
            if($couponsList === 201)
            {
                $res['status_code'] = 201;
                $res['message'] = trans('message.order_not_found');
                $res['data'] = false;
                return $res;
            }
            elseif (!empty($couponsList)) {
                $res['status_code'] = 200;
                $res['message'] = trans('message.order_details_success');
                $res['data'] = $couponsList;
                return $res;
            }
            $res['status_code'] = 201;
            $res['message'] = trans('message.order_details_fail');
            $res['data'] = false;
            return $res;
       }
       catch (\Exception $e) 
       {
            $res['status_code'] = 202;
            $res['message'] =  $e->getMessage();
            $res['data'] = false;
            return $res;
       }
    }

    public function orderList(array $data)
    {
        try
        {
            $couponsList = $this->authRepo->orderList($data);
            if (!empty($couponsList)) {
                $res['status_code'] = 200;
                $res['message'] = trans('message.order_details_success');
                $res['data'] = $couponsList;
                return $res;
            }
            $res['status_code'] = 201;
            $res['message'] = trans('message.order_details_fail');
            $res['data'] = false;
            return $res;
       }
       catch (\Exception $e) 
       {
            $res['status_code'] = 202;
            $res['message'] =  $e->getMessage();
            $res['data'] = false;
            return $res;
       }
    }
}