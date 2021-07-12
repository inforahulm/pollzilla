<?php

namespace App\DataTables;

use App\Models\Category;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CategoryDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function($data){
                $result = "";
                if($data->is_active == 1) {
                    $result .= '<button type="button" class="btn btn-secondary btn-sm changeStatus" status="0" title="click to Inactivate" category_id="'.$data->id.'"><i class="fa fa-unlock"></i></button> ';
                } else {
                    $result .= '<button type="button" class="btn btn-secondary btn-sm changeStatus" status="1" title="click to Activate" category_id="'.$data->id.'"><i class="fa fa-lock"></i></button> ';
                }
                $result .= '<button class="btn btn-primary btn-sm" title="Edit Category" data-toggle="modal" data-target="#category_edit_modal" data-id="'.$data->id.'"><i class="fa fa-edit"></i></button> 
                             <button type="button" id="cat_delete" class="btn btn-sm btn-danger" title="delete category" category_id="'.$data->id.'"><i class="fa fa-trash"></i></button> ';

                return $result;
            })
            ->editColumn('image', function($data){
                if($data->image) {
                    return '<img src="'.$data->image.'" width=50px height=50px />';
                } else {
                    return '<img src="'.asset('images/no-image.png').'" width=50px height=50px/>';
                }
            })
            ->editColumn('is_active',function($data) {
                if($data->is_active == 0) {
                    return '<span class="badge badge-danger">Inactive</span>';
                } else {
                    return '<span class="badge badge-success">Active</span>';
                }
            })
            ->rawColumns(['action', 'is_active', 'image'])
            ->addIndexColumn();
    }


    public function query(Category $model)
    {
        return $model->newQuery();
    }

    public function html()
    {
        return $this->builder()
                    ->setTableId('category-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Blfrtip')
                    ->orderBy([1,'DESC'])
                    ->buttons(
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }

    protected function getColumns()
    {
        return [
            Column::make('no')->data('DT_RowIndex')->searchable(false)->orderable(false),
            Column::make('id')->hidden(true),
            Column::make('name'),
            Column::make('image'),
            Column::make('is_active')->title('Status'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(100)
                  ->addClass('text-center')
        ];
    }

    protected function filename()
    {
        return 'Category_' . date('YmdHis');
    }
}
