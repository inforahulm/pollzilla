<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Api\InterestSubCategory\InterestSubCategoryRequest;
use App\Http\Requests\Api\Image\ImageRequest;
use App\Http\Requests\Api\State\stateRequest;
use App\Http\Requests\Api\City\cityRequest;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\InterestCategory;
use App\Models\SubInterestCategory;
use App\Models\Notifications;

use App\Contracts\CommonContract;
use App\Contracts\InterestCategoryContract;
use App\Contracts\SubInterestCategoryContract;
use App\Contracts\ColorPaletteContract;
use App\Contracts\ActivityContract;

class CommanController extends BaseController
{
    //
    protected $common_model;
    protected $interest_category_model;
    protected $interest_sub_category_model;
    protected $color_palette_model;
    protected $activityService;
    public function __construct(CommonContract $common_model,InterestCategoryContract $interest_category_model,SubInterestCategoryContract $interest_sub_category_model,ColorPaletteContract $color_palette_model, ActivityContract $activityService)
    {
        $this->common_model = $common_model;
        $this->interest_category_model = $interest_category_model;
        $this->interest_sub_category_model = $interest_sub_category_model;
        $this->color_palette_model = $color_palette_model;
        $this->activityService = $activityService;
    }


    public function categoryList()
    {
        $res  = $this->interest_category_model->list(array());
        return $this->sendResponse($res);
    }

    public function subCategoryList(InterestSubCategoryRequest $request)
    {
        $res  = $this->interest_sub_category_model->list($request->all());
        return $this->sendResponse($res);
    }

    public function colorPaletteList()
    {
        $res  = $this->color_palette_model->list(array());
        return $this->sendResponse($res);
    }

    public function countryList()
    {
        $res  = $this->common_model->countryList(array());
        return $this->sendResponse($res);
    }

    public function stateList(stateRequest $request)
    {
        $res  = $this->common_model->stateList($request->all());
        return $this->sendResponse($res);
    }

    public function cityList(cityRequest $request)
    {
        $res  = $this->common_model->cityList($request->all());
        return $this->sendResponse($res);
    }

    public function getReportAbuseCat(Request $request)
    {
        $res  = $this->common_model->getReportAbuseCat($request->all());
        return $this->sendResponse($res);
    }

    public function uploadFile(ImageRequest $request) {

        $res  = $this->common_model->uploadFile($request);
        return $this->sendResponse($res);
    }

    public function getActivity(Request $request) {

        $data['user_id'] = request()->user()->id;
        $res  = $this->activityService->list($data);
        if($res['result_status']==1) { // Success
            unset($res['result_status']);
            return $this->sendResponse($res['data']);
        }
        else { // Other Errors  
            return $this->sendError($res['message'], 422);
        }
    }

    public function getNotification(Request $request) 
    {
        $user_id = request()->user()->id;
        $page_id = (isset($data['page_id']) && $data['page_id'] !=null) ? $data['page_id']*10:0;
        $res = Notifications::With('user_data')->where('user_id',$user_id)->select('id','notification_type','notification_title','notification_description','created_at','sender_user_id','poll_id')->orderBy('id','DESC')->skip($page_id)->take(10)->get();
        return $this->sendResponse($res);
    }

    public function reportAbuse(Request $request) 
    {   
        $data = $request->all();
        $data['user_id'] = request()->user()->id;
        $res  = $this->common_model->reportAbuse($data);
        if($res['result_status']==1) { // Success
            unset($res['result_status']);
            return $this->sendResponse($res['data']);
        }
        else { // Other Errors  
            return $this->sendError($res['message'], 422);
        }
    }
}
