<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Api\FollowerFollowing\FollowerFollowingRequest;
use App\Http\Requests\Api\FollowerFollowing\FollowerFollowingListRequest;
use Illuminate\Http\Request;

use App\Contracts\FollowerFollowingContract;

class FollowerFollowingController extends BaseController
{
    protected $model;
	public function __construct(FollowerFollowingContract $model)
	{
		$this->model = $model;
	}

	public function followUnfollow(FollowerFollowingRequest $request)
	{

		$data = $request->all();
		$data['id'] = request()->user()->id;
		$data['user_name'] = request()->user()->user_name;

		$res  = $this->model->followUnfollow($data);
	        if($res['result_status']==1) { // Success
	        	unset($res['result_status']);
	        	return $this->sendResponse($res);
	        }
	        else { // Other Errors  
	        	return $this->sendError($res['message'], 422);
	        }
	}

	public function followerList(FollowerFollowingListRequest $request)
	{
		$data = $request->all();
		$data['id'] = $request['user_id'] ? $request['user_id'] : request()->user()->id;

		$res  = $this->model->followerList($data);
	        if($res['result_status']==1) { // Success
	        	unset($res['result_status']);
	        	return $this->sendResponse($res);
	        }
	        else { // Other Errors  
	        	return $this->sendError($res['message'], 422);
	        }
	}

	public function followingList(FollowerFollowingListRequest $request)
	{
		$data = $request->all();
		$data['id'] = $request['user_id'] ? $request['user_id'] : request()->user()->id;
		$data['auth_id'] = request()->user()->id;
		$res  = $this->model->followingList($data);
	        if($res['result_status']==1) { // Success
	        	unset($res['result_status']);
	        	return $this->sendResponse($res);
	        }
	        else { // Other Errors  
	        	return $this->sendError($res['message'], 422);
	        }
	}
}
