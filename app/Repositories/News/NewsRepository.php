<?php 
namespace App\Repositories\News;

use App\Repositories\News\NewsInterface;
use App\Models\News;
use App\Helpers\CommonHelper;

class NewsRepository implements NewsInterface
{

 public function __construct(News $news,CommonHelper $helpers)
   {
     $this->news = $news;
     $this->helpers = $helpers;
   }

   public function addnews(array $data)
    {
    	if (!empty($data)){
          	if(!is_null($data['image']))
		    {
		      $data['image'] = $this->helpers->uploadFiles($data['image'],'files','file_'.rand(),0);
		    }
          	if(!is_null($data['video']))
		    {
		      $data['video'] = $this->helpers->uploadFiles($data['video'],'video','video_'.rand(),0);
		    }
		    $news = $this->news->create($data);
          return true;
    	}else{
    		return false;
    	}

    }

}
