<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\InterestCategoryDataTable;
use App\Http\Requests\InterestCategory\AddInterestCategoryRequest;
use App\Http\Requests\InterestCategory\UpdateInterestCategoryRequest;


use App\Contracts\InterestCategoryContract;

class InterestCategoryController extends Controller
{
	protected $interestCategoryService;

	public function __construct(InterestCategoryContract $interestCategoryService)
	{
		$this->interestCategoryService = $interestCategoryService;
	}

	public function index(InterestCategoryDataTable $interestCategoryDataTable)
	{
		return $interestCategoryDataTable->render('admin.category.index');
	}

	public function create()
	{
		return view('admin.category.create');
	}

	public function store(AddInterestCategoryRequest $request)
	{
		$category = $this->interestCategoryService->create($request->all());

		if($category)
		{
			$response['status'] = 'success';
			$response['message'] = 'Category added successfully';
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
			return $this->interestCategoryService->get($request->id);
		}
	}

	public function update(UpdateInterestCategoryRequest $request)
	{
		$category = $this->interestCategoryService->update($request->all());

		if($category)
		{
			$response['status'] = 'success';
			$response['message'] = 'Category updated successfully';
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
		return $this->interestCategoryService->delete($request->id);
	}

	public function changeStatus(Request $request)
	{
		$cat = $this->interestCategoryService->changeStatus($request->all());

		if($cat) {
			if($cat['status'] == 0)
			{
				$data['msg'] = 'Category Inactivated successfully.';
				$data['action'] = 'Inactivated!';
			} else {
				$data['msg'] = 'Category Activated successfully.';
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
}
