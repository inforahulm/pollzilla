<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\FaqRepository;
use Illuminate\Http\Request;
use App\DataTables\FAQDataTable;
use App\Http\Requests\Faq\StoreRequest;
use App\Http\Requests\Faq\UpdateRequest;
use App\Models\Faq;

class FAQController extends Controller
{
    protected $model;

    public function __construct(Faq $faq)
    {
        $this->model = new FaqRepository($faq);
    }

    public function index(FAQDataTable $faqdatatable)
    {
        return $faqdatatable->render('admin.faq.index');
    }

    public function create()
    {
        return view('admin.faq.create');
    }

    public function store(StoreRequest $request)
    {
        $this->model->create($request->all());

        return redirect()->route('admin.faq.index')->with('success', 'FAQ Created Successfully');
    }

    public function show($id)
    {
        //
    }

    public function edit(Faq $faq)
    {
        return view('admin.faq.create', compact('faq'));
    }

    public function update(UpdateRequest $request, Faq $faq)
    {
        $this->model->update($request->all(), $faq->id);

        return redirect()->route('admin.faq.index')->with('success', 'FAQ Edited Successfully');
    }

    public function delete(Request $request)
    {
        return $this->model->delete($request->id);
    }

    public function changeStatus(request $request)
    {
        $faq = $this->model->changeStatus($request->all());

        if($faq) {
            if($faq['status'] == 0)
            {
                $data['msg'] = 'FAQ Inactivated successfully.';
                $data['action'] = 'Inactivated!';
            } else {
                $data['msg'] = 'FAQ Activated successfully.';
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

    public function bulkDelete(Request $request)
    {
        if(count($request->ids)) {
            return $this->model->bulkDelete($request->ids);
        }
        return false;
    }
}
