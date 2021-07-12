<?php

namespace App\DataTables;

use App\Models\Faq;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class FAQDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function($data){
                $result = "";

                if($data->is_active == 1) {
                    $result .= ' <button type="button" class="btn btn-danger btn-sm changeStatus" status="0" title="click to Inactivate" faq_id="'.$data->id.'"><i class="fa fa-unlock"></i></button> ';
                } else {
                    $result .= ' <button type="button" class="btn btn-secondary btn-sm changeStatus" status="1" title="click to Activate" faq_id="'.$data->id.'"><i class="fa fa-lock"></i></button> ';
                }

                $result .= '<a href="'.route('admin.faq.edit', $data->id).'" class="btn btn-success btn-sm" title="Edit faq"><i class="fa fa-edit"></i></a>
                <button id="faq_delete" type="button" class="btn btn-sm btn-danger round" faq_id="'.$data->id.'"><i class="fa fa-trash"></i></button>';

                return $result;
            })
            ->editColumn('is_active',function($data) {
                if($data->is_active == 0) {
                    return '<span class="badge badge-danger">Inactive</span>';
                } else {
                    return '<span class="badge badge-success">Active</span>';
                }
            })
            ->editColumn('id', function($data){
                return '&nbsp&nbsp<input type="checkbox" name="faq_id" value="'.$data->id.'" class="select_row">';
            })
            ->editColumn('answer', function($data){
                if(str_word_count($data->answer) > 20) {
                    return '<div class="word-wrap">'.strip_tags($data->answer).'</div>';
                } else {
                    return strip_tags($data->answer);
                }
            })
            ->filterColumn('is_active', function($query, $keyword) {
                if (stripos('active', $keyword) !== false) {
                    return $query->where('is_active', '1');
                }
                if (stripos('inactive', $keyword) !== false) {
                    return $query->where('is_active', '0');
                }
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'is_active', 'id', 'answer', 'type']);
    }

    public function query(FAQ $model)
    {
        return $model->newQuery();
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('faq-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Blfrtip')
            ->orderBy([0, 'desc'])
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
            Column::make('id')->title('<input type="checkbox" name="select_all" id="select_all">')->searchable(false)->orderable(false),
            Column::make('no')->data('DT_RowIndex')->searchable(false)->orderable(false),
            Column::make('question'),
            Column::make('answer'),
            Column::make('is_active')->title('Status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'FAQ_' . date('YmdHis');
    }
}
