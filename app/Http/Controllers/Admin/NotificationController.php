<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\NotifictionAdminsDataTable;
use App\Contracts\NotificationContract;
use App\Http\Requests\Notifications\AddNotificaiotnRequest;

class NotificationController extends Controller
{
	protected $notificationAdminService;

	public function __construct(NotificationContract $notificationAdminService)
	{
		$this->notificationAdminService = $notificationAdminService;
	}

	public function index(NotifictionAdminsDataTable $notificationdataTable)
	{
		return $notificationdataTable->render('admin.notification.index');
	}

	public function create()
	{
		return view('admin.notification.create');
	}

	public function store(AddNotificaiotnRequest $request)
	{
		$category = $this->notificationAdminService->create($request->all());

		if($category)
		{
			$response['status'] = 'success';
			$response['message'] = 'Notification added successfully';
		}
		else
		{
			$response['status'] = 'danger';
			$response['message'] = 'Something went wrong! Try again later...';
		}

		return $response;
	}

	public function edit(Request $request)
	{
		if($request->id) {
			return $this->notificationAdminService->get($request->id);
		}
	}

	public function update(AddNotificaiotnRequest $request)
	{
		$category = $this->notificationAdminService->update($request->all(), $request->category_id);

		if($category)
		{
			$response['status'] = 'success';
			$response['message'] = 'Notification updated successfully';
		}
		else
		{
			$response['status'] = 'danger';
			$response['message'] = 'Something went wrong! Try again later...';
		}

		return $response;
	}

	public function delete(Request $request)
	{
		return $this->notificationAdminService->delete($request->id);
	}

	public function sendPush(Request $request)
	{
		$cat = $this->notificationAdminService->sendPush($request->id);

		if($cat) {
			if($cat['status'] == 0)
			{
				$data['msg'] = 'Notification Send successfully.';
				$data['action'] = 'Sended !';
			}
			$data['status'] = 'success';
		} else {

			$data['msg'] = 'Something went wrong';
			$data['action'] = 'Cancelled!';
			$data['status'] = 'error';
		}

		return $data;
	}
}
