<?php

namespace App\DataTables;

use App\Models\NotifictionAdmins;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class NotifictionAdminsDataTable extends DataTable
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
            $result .= '<button type="button" class="btn btn-secondary btn-sm sendPush" title="click to Send Notification" category_id="'.$data->id.'"><i class="fa fa-send"></i></button> ';
            $result .= '<button class="btn btn-primary btn-sm" title="Edit Category" data-toggle="modal" data-target="#category_edit_modal" data-id="'.$data->id.'"><i class="fa fa-edit"></i></button> 
            <button type="button" id="cat_delete" class="btn btn-sm btn-danger" title="delete category" category_id="'.$data->id.'"><i class="fa fa-trash"></i></button> ';

            return $result;
        })
        ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\NotifictionAdmin $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(NotifictionAdmins $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
        ->setTableId('notifictionadmins-table')
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
            // Column::make('id')->data('DT_RowIndex')->searchable(false)->orderable(false),
            Column::make('id')->title('Sr No'),
            Column::make('title'),
            Column::make('description'),
            Column::make('sended_at'),
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
        return 'NotifictionAdmins_' . date('YmdHis');
    }
}
