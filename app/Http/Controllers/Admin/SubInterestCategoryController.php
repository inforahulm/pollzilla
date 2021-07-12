<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SubInterestCategory\AddSubInterestCategoryRequest;
use App\Http\Requests\SubInterestCategory\UpdateSubInterestCategoryRequest;

use App\DataTables\SubInterestCategoryDataTable;

use App\Contracts\SubInterestCategoryContract;
use App\Contracts\InterestCategoryContract;

class SubInterestCategoryController extends Controller
{
	protected $subinterestCategoryService;
	protected $interestCategoryService;

	public function __construct(SubInterestCategoryContract $subinterestCategoryService,InterestCategoryContract $interestCategoryService)
	{
		$this->subinterestCategoryService 	= $subinterestCategoryService;
		$this->interestCategoryService 		= $interestCategoryService;
	}

	public function index(SubInterestCategoryDataTable $subinterestCategoryDataTable)
	{
		$interestCategory = $this->interestCategoryService->list([]);
		return $subinterestCategoryDataTable->render('admin.subcategory.index',compact('interestCategory'));
	}

	public function create()
	{

		return view('admin.subcategory.create');
	}

	public function store(AddSubInterestCategoryRequest $request)
	{
		$category = $this->subinterestCategoryService->create($request->all());

		if($category)
		{
			$response['status'] = 'success';
			$response['message'] = 'Sub Category added successfully';
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
			return $this->subinterestCategoryService->get($request->id);
		}
	}

	public function update(UpdateSubInterestCategoryRequest $request)
	{
		$category = $this->subinterestCategoryService->update($request->all());

		if($category)
		{
			$response['status'] = 'success';
			$response['message'] = 'Sub Category updated successfully';
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
		return $this->subinterestCategoryService->delete($request->id);
	}

	public function changeStatus(Request $request)
	{
		$cat = $this->subinterestCategoryService->changeStatus($request->all());

		if($cat) {
			if($cat['status'] == 0)
			{
				$data['msg'] = 'Sub Category Inactivated successfully.';
				$data['action'] = 'Inactivated!';
			} else {
				$data['msg'] = 'Sub Category Activated successfully.';
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

	public function getSubcategories(Request $request) {

		$subcategories = $this->subinterestCategoryService->list(['interest_category_id'=>$request->id]);
		return $subcategories;
	}
}
