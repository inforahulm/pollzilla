<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\ColorPaletteDataTable;
use App\Contracts\ColorPaletteContract;
use App\Http\Requests\Colors\AddColorRequest;

class ColorPaletteController extends Controller
{
	protected $colorPaletteContractService;

	public function __construct(ColorPaletteContract $colorPaletteContractService)
	{
		$this->colorPaletteContractService = $colorPaletteContractService;
	}

	public function index(ColorPaletteDataTable $colorPaletteDataTable)
	{
		return $colorPaletteDataTable->render('admin.color.index');
	}

	public function create()
	{
		return view('admin.color.create');
	}

	public function store(AddColorRequest $request)
	{
		$category = $this->colorPaletteContractService->create($request->all());

		if($category)
		{
			$response['status'] = 'success';
			$response['message'] = 'Color added successfully';
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
			return $this->colorPaletteContractService->get($request->id);
		}
	}

	public function update(AddColorRequest $request)
	{
		$category = $this->colorPaletteContractService->update($request->all());

		if($category)
		{
			$response['status'] = 'success';
			$response['message'] = 'Color updated successfully';
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
		return $this->colorPaletteContractService->delete($request->id);
	}

	public function changeStatus(Request $request)
	{
		$cat = $this->colorPaletteContractService->changeStatus($request->all());

		if($cat) {
			if($cat['status'] == 0)
			{
				$data['msg'] = 'Color Inactivated successfully.';
				$data['action'] = 'Inactivated!';
			} else {
				$data['msg'] = 'Color Activated successfully.';
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
