<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

use App\Contracts\UserContract;
use App\Contracts\AddressBookContract;
use App\Contracts\GroupContract;
use App\Contracts\FollowerFollowingContract;
use App\Contracts\PollContract;
use App\DataTables\UsersDataTable;

class UserController extends Controller
{

	protected $usersService;
	protected $addressBookService;
	protected $addressGroupServices;
	protected $followerFollowingSerivce;
	protected $pollSerivce;

	public function __construct(UserContract $usersService,AddressBookContract $addressBookService,GroupContract $addressGroupServices,FollowerFollowingContract $followerFollowingSerivce,PollContract $pollSerivce)
	{
		$this->usersService 				= $usersService;
		$this->addressBookService 			= $addressBookService;
		$this->addressGroupServices 		= $addressGroupServices;
		$this->followerFollowingSerivce 	= $followerFollowingSerivce;
		$this->pollSerivce 					= $pollSerivce;
	}

	public function index(UsersDataTable $usersDataTable)
	{
		return $usersDataTable->render('admin.users.index');
	}

	public function delete(Request $request)
	{
		return $this->usersService->delete($request->id);
	}

	public function changeStatus(Request $request)
	{
		$cat = $this->usersService->updateDataWhere($request->all());

		if($cat['result_status']==1) {
			if($request->status== 0)
			{
				$data['msg'] = 'User Inactivated successfully.';
				$data['action'] = 'Inactivated!';
			} else {
				$data['msg'] = 'User Activated successfully.';
				$data['action'] = 'Activated!';
			}
			$data['status'] = 'success';
		} else {

			$data['msg'] = 'Something went wrong';
			$data['action'] = 'Cancelled!';
			$data['status'] = 'error';
		}

		return $data;
	}

	public function edit($id)
	{	
		

		$id = decryptString($id);
		$user 	 	= $this->usersService->get($id);
		
		$follower 	= $this->followerFollowingSerivce->followerList(['id'=>$id,'is_all'=>1]);
		if($follower['result_status']==1){
			unset($follower['result_status']);
		}

		$following 	= $this->followerFollowingSerivce->followingList(['id'=>$id,'is_all'=>1]);
		if($following['result_status']==1){
			unset($following['result_status']);
		}
		$interest 	= $this->usersService->getInterestList($id);
		if($interest['result_status']==1){
			$interest = $interest['data'];
		}

		$poll 	= $this->pollSerivce->list(['user_id'=>$id]);
		if($poll['result_status']==1){
			$poll = $poll['data'];
		}
		return view('admin.users.viewprofile', compact('user','follower','following','interest','poll'));
	}

	public function usergroup($id)
	{	

		$id = decryptString($id);
		$user 	 	 = $this->usersService->get($id);
		$addressBook = $this->addressBookService->myAddressBook($id);
		if($addressBook['result_status']==1){
			unset($addressBook['result_status']);	
		}
		$addressBookGroup = $this->addressGroupServices->myGroup($id);
		if($addressBookGroup['result_status']==1){
			unset($addressBookGroup['result_status']);	
		}
		return view('admin.users.usergroup',compact('user','addressBook','addressBookGroup') );
	}

	public function getGroup(Request $request)
	{	
		return $this->addressGroupServices->groupDetails($request->all());
	}


}
