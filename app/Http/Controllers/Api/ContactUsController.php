<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\ContactUs\ContactUsRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\ContactUs;

use App\Contracts\ContactUsContract;

class ContactUsController extends BaseController
{
    protected $contact_us_model;
    public function __construct(ContactUsContract $contact_us_model)
    {
       $this->model = $contact_us_model;
    }

    public function create(ContactUsRequest $request)
	{

		$data = $request->all();
		$data['user_id'] = request()->user()->id;

		$res  = $this->model->create($data);
	        if($res['result_status']==1) { // Success
	        	unset($res['result_status']);
	        	return $this->sendResponse($res);
	        }
	        else { // Other Errors  
	        	return $this->sendError($res['message'], 422);
	        }
	}

	public function myContactUs()
	{
		$id = request()->user()->id;
		$res  = $this->model->myContactUs($id);
	        if($res['result_status']==1) { // Success
	        	unset($res['result_status']);
	        	return $this->sendResponse($res);
	        }
	        else { // Other Errors  
	        	return $this->sendError($res['message'], 422);
	        }
	}
	
}
