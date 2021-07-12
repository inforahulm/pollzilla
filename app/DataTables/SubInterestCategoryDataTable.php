<?php

namespace App\DataTables;

use App\Models\SubInterestCategory;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SubInterestCategoryDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
        ->eloquent($query)
        ->addColumn('action', function($data){
            $result = "";
            if($data->status == 1) {
                $result .= '<button type="button" class="btn btn-secondary btn-sm changeStatus" status="0" title="click to Inactivate" category_id="'.$data->id.'"><i class="fa fa-unlock"></i></button> ';
            } else {
                $result .= '<button type="button" class="btn btn-secondary btn-sm changeStatus" status="1" title="click to Activate" category_id="'.$data->id.'"><i class="fa fa-lock"></i></button> ';
            }
            $result .= '<button class="btn btn-primary btn-sm" title="Edit Category" data-toggle="modal" data-target="#category_edit_modal" data-id="'.$data->id.'"><i class="fa fa-edit"></i></button> 
            <button type="button" id="cat_delete" class="btn btn-sm btn-danger" title="delete category" category_id="'.$data->id.'"><i class="fa fa-trash"></i></button> ';

            return $result;
        })
        ->editColumn('status',function($data) {
            if($data->status == 0) {
                return '<span class="badge badge-danger" >Inactive</span>';
            } else {
                return '<span class="badge badge-success" >Active</span>';
            }
        })->editColumn('interest_category_id',function($data) {
            // dd($data->categories);
            return $data->categories->interest_category_name;
        })
        ->rawColumns(['action', 'status', 'interest_sub_category_name'])
        ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\SubInterestCategory $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(SubInterestCategory $model)
    {
        return $model->with('categories')->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
        ->setTableId('subinterestcategory-table')
        ->columns($this->getColumns())
        ->minifiedAjax()
        ->dom('Blfrtip')
        ->orderBy(1)
        ->buttons(
            Button::make('create'),
            Button::make('export'),
            Button::make('print'),
            Button::make('reset'),
            Button::make('reload')
        );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('no')->data('DT_RowIndex')->searchable(false)->orderable(false),
            Column::make('id')->hidden(true),
            Column::make('interest_sub_category_name')->title('Sub Category Name'),
            Column::make('interest_category_id')->name('categories.interest_category_name')->title('Category Name'),

            Column::make('status')->title('Status'),
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(100)
            ->addClass('text-center')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'SubInterestCategory_' . date('YmdHis');
    }
}
