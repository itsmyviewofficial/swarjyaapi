<?php

namespace App\Http\Controllers\admin
;
use App\Http\Controllers\Controller;
use App\Services\General\NewsServices;
use App\Http\Requests\NewsPostRequest;
use Illuminate\Http\Request;

class NewsController extends Controller
{

 private $service;

  public function __construct(NewsServices $service)
  {
    $this->service = $service;
  }

  public function Addnews(NewsPostRequest $request)
  {
  	$res = $this->service->addnews($request->all());
    return response()->json($res, 200);
  }
}
