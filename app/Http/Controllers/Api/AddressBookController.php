<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests\Api\AddressBook\AddressBookRequest;
use App\Http\Requests\Api\AddressBook\DeleteAddressBookRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\AddressBook;

use App\Contracts\AddressBookContract;


class AddressBookController extends BaseController
{
	protected $model;
	public function __construct(AddressBookContract $model)
	{
		$this->model = $model;
	}

	public function create(AddressBookRequest $request)
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

	public function myAddressBook()
	{
		$id = request()->user()->id;
		$res  = $this->model->myAddressBook($id);
	        if($res['result_status']==1) { // Success
	        	unset($res['result_status']);
	        	return $this->sendResponse($res);
	        }
	        else { // Other Errors  
	        	return $this->sendError($res['message'], 422);
	        }
	}

	public function deleteAddressBook(DeleteAddressBookRequest $request)
	{
		$res  = $this->model->deleteAddressBook($request->all());
	        if($res['result_status']==1) { // Success
	        	unset($res['result_status']);
	        	return $this->sendResponse($res);
	        }
	        else { // Other Errors  
	        	return $this->sendError($res['message'], 422);
	        }
	}

	public function searchUser(Request $request)
	{
		$data = $request->all();
		$data['user_id'] = request()->user()->id;
		
		$res  = $this->model->searchUser($data);
	        if($res['result_status']==1) { // Success
	        	unset($res['result_status']);
	        	return $this->sendResponse($res);
	        }
	        else { // Other Errors  
	        	return $this->sendError($res['message'], 422);
	        }
	}

}