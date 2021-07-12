<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Group\AddGroupRequest;
use App\Http\Requests\Api\Group\GroupDetailsRequest;
use App\Http\Requests\Api\Group\EditGroupRequest;
use App\Http\Requests\Api\Group\DeleteGroupRequest;
use App\Http\Requests\Api\Group\addGroupMembersRequest;
use App\Http\Requests\Api\Group\DeleteGroupMemberRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use App\Models\Group;

use App\Contracts\GroupContract;

class GroupController extends BaseController
{
	protected $model;
	public function __construct(GroupContract $model)
	{
		$this->model = $model;
	}

	public function create(AddGroupRequest $request)
	{
		$data = $request->all();
		$data['user_id'] = request()->user()->id;
		$res  = $this->model->create($data);
	        if($res['result_status']==1) { // Success
	        	unset($res['result_status']);
	        	return $this->sendResponse($res['data']);
	        }
	        else { // Other Errors  
	        	return $this->sendError($res['message'], 422);
	        }
	    }

	    public function myGroup()
	    {
	    	$id = request()->user()->id;
	    	$res  = $this->model->myGroup($id);
	        if($res['result_status']==1) { // Success
	        	unset($res['result_status']);
	        	return $this->sendResponse($res);
	        }
	        else { // Other Errors  
	        	return $this->sendError($res['message'], 422);
	        }
	    }

	    public function groupDetails(GroupDetailsRequest $request)
	    {
	    	$res  = $this->model->groupDetails($request->all());
	        if($res['result_status']==1) { // Success
	        	unset($res['result_status']);
	        	return $this->sendResponse($res);
	        }
	        else { // Other Errors  
	        	return $this->sendError($res['message'], 422);
	        }
	    }

	    public function editGroup(EditGroupRequest $request)
	    {
	    	$res  = $this->model->editGroup($request->all());
	        if($res['result_status']==1) { // Success
	        	unset($res['result_status']);
	        	return $this->sendResponse($res['data']);
	        }
	        else { // Other Errors  
	        	return $this->sendError($res['message'], 422);
	        }
	    }

	    public function deleteGroup(DeleteGroupRequest $request)
	    {
	    	$res  = $this->model->DeleteGroup($request->all());
	        if($res['result_status']==1) { // Success
	        	unset($res['result_status']);
	        	return $this->sendResponse($res);
	        }
	        else { // Other Errors  
	        	return $this->sendError($res['message'], 422);
	        }
	    }

	    public function addGroupMembers(addGroupMembersRequest $request)
	    {
	    	$data = $request->all();
	    	$data['user_id'] = request()->user()->id;

	    	$res  = $this->model->addGroupMembers($data);
	        if($res['result_status']==1) { // Success
	        	unset($res['result_status']);
	        	return $this->sendResponse($res);
	        }
	        else { // Other Errors  
	        	return $this->sendError($res['message'], 422);
	        }
	    }

	    public function deleteGroupMember(DeleteGroupMemberRequest $request)
	    {
	    	$res  = $this->model->DeleteGroupMember($request->all());
	        if($res['result_status']==1) { // Success
	        	unset($res['result_status']);
	        	return $this->sendResponse($res);
	        }
	        else { // Other Errors  
	        	return $this->sendError($res['message'], 422);
	        }
	    }
	}
