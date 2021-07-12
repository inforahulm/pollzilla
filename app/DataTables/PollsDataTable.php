<?php

namespace App\DataTables;

use App\Models\Poll;
use App\Models\ReportAbuse;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PollsDataTable extends DataTable
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
            $result .= '<a href="'.route('admin.poll.edit', encryptString($data->id)).'" class="btn btn-primary btn-sm" title="edit poll"><i class="fa fa-edit"></i></a>  ';
            $result .= '<a href="'.route('admin.poll.view', encryptString($data->id)).'" class="btn btn-success btn-sm" title="View Poll Details "><i class="dripicons-graph-pie"></i></a>  ';

            $result .= '<button type="button" id="cat_delete" class="btn btn-sm btn-danger" title="delete poll" data-id="'.$data->id.'"><i class="fa fa-trash"></i></button> ';


            return $result;
        })
        ->editColumn('poll_current_status',function($data) {
            if($data->poll_current_status == 1 || $data->poll_current_status == 41) {
                return '<span class="badge badge-success" >Running</span>';
            } else if($data->poll_current_status == 2 || $data->poll_current_status == 42) {
                return '<span class="badge badge-danger" >End</span>';
            } else {
                return '<span class="badge badge-info" >Upcoming</span>';
            }
        })
        ->editColumn('interest_category_id',function($data) {
            return $data->categories->interest_category_name;
        })
        ->editColumn('interest_sub_category_id',function($data) {
            return $data->subcategories->interest_sub_category_name;
        })
        ->addColumn('reported',function($data) {
            return ReportAbuse::where('poll_id',$data->id)->count();
        })

        ->editColumn('poll_style_id',function($data) {
            if($data->poll_style_id == 1) {
                return '<span class="badge badge-primary" >Text</span>';
            } else if($data->poll_style_id == 2){
                return '<span class="badge badge-primary" >Image</span>';
            } else if($data->poll_style_id == 3){
                return '<span class="badge badge-primary" >Music</span>';
            } else {
                return '<span class="badge badge-primary" >Video</span>';
            }
        })
        ->rawColumns(['action', 'poll_current_status','poll_style_id'])
        ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Poll $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Poll $model)
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
        ->setTableId('polls-table')
        ->columns($this->getColumns())
        ->minifiedAjax()
        ->dom('Bfrtip')
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
            Column::make('generic_title')->title('Generic Title'),
            Column::make('interest_category_id')->title('Category'),
            Column::make('interest_sub_category_id')->title('Sub Category'),
            Column::make('poll_style_id')->title('Poll Style'),
            Column::make('poll_current_status')->title('Status'),
            Column::make('reported')->title('Report Abuse'),
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(60)
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
        return 'Polls_' . date('YmdHis');
    }
}
