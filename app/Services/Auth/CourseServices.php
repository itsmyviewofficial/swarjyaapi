<?php

namespace App\Services\Auth;

use App\Repositories\Course\CourseInterface;

class CourseServices
{
	protected $courseRepo;
    public function __construct(CourseInterface $courseRepo)
    {
        $this->courseRepo = $courseRepo;
    }

    public function getCourses(array $data)
    {
        try
        {
            $result = $this->courseRepo->getCourses($data);
            if(!empty($result)) {
                $res['status_code'] = 200;
                $res['success'] = array('message' => trans('message.data_success'));
                $res['data'] = $result;
                return $res;
            }
            $res['status_code'] = 201;
            $res['error'] = array('message' => trans('message.data_fail'));
            $res['data'] = (object) [];
            return $res;
       }
       catch (\Exception $e) 
       {
            $res['status_code'] = 202;
            $res['error'] = array('message' => $e->getMessage());
            $res['data'] = (object) [];
            return $res;
       }
    }

    public function getCourseDetails(array $data)
    {
        try
        {
            $result = $this->courseRepo->getCourseDetails($data);
            if(!empty($result)) {
                $res['status_code'] = 200;
                $res['success'] = array('message' => trans('message.data_success'));
                $res['data'] = $result;
                return $res;
            }
            $res['status_code'] = 201;
            $res['error'] = array('message' => trans('message.data_fail'));
            $res['data'] = (object) [];
            return $res;
       }
       catch (\Exception $e) 
       {
            $res['status_code'] = 202;
            $res['error'] = array('message' => $e->getMessage());
            $res['data'] = (object) [];
            return $res;
       }
    }
}