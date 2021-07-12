<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\DataTables\CategoryDataTable;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;

class CategoryController extends Controller
{
    protected $model;

    public function __construct(Category $category)
    {
        $this->model = new CategoryRepository($category);
    }

    public function index(CategoryDataTable $categorydataTable)
    {
        return $categorydataTable->render('admin.category.index');
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(StoreRequest $request)
    {
        $category = $this->model->create($request->all());

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

    public function show($id)
    {
        //
    }

    public function edit(Request $request)
    {
        if($request->id) {
            return $this->model->edit($request->id);
        }
    }

    public function update(UpdateRequest $request)
    {
        $category = $this->model->update($request->all(), $request->category_id);

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
        return $this->model->delete($request->id);
    }

    public function changeStatus(Request $request)
    {
        $cat = $this->model->changeStatus($request->all());

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
