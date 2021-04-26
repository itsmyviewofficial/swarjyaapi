<?php

namespace App\Services\General;
use App\Repositories\News\NewsInterface;

class NewsServices
{

 protected $newsRepo;
    public function __construct(NewsInterface $newsRepo)
    {
        $this->newsRepo = $newsRepo;
    }

	public function addnews(array $data)
    {
        try
        {
            if (!empty($addnews = $this->newsRepo->addnews($data))) {
                $res['status_code'] = 200;
                $res['message'] = trans('Successfully created');
                $res['data'] = $addnews;
                return $res;
            }
            $res['status_code'] = 201;
            $res['message'] = trans('Please fill the all manditory fileds');
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
