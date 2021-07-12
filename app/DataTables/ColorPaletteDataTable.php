<?php

namespace App\DataTables;

use App\Models\ColorPalette;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ColorPaletteDataTable extends DataTable
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
        ->addColumn('theme_palette', function($data){
            return '<div><i style="background-color: '.$data->background_code.'; width: 15px;display:inline-block;height:16px;" title="Backgroud Color"></i><i style="background-color: '.$data->components_code.'; width: 15px;display:inline-block;height:16px;" title="Components Color"></i></div>';
        })
        ->editColumn('status',function($data) {
            if($data->status == 0) {
                return '<span class="badge badge-danger" >Inactive</span>';
            } else {
                return '<span class="badge badge-success" >Active</span>';
            }
        })
        ->rawColumns(['action', 'status', 'theme_palette'])
        ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ColorPalette $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ColorPalette $model)
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
        ->setTableId('colorpalette-table')
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
            Column::make('color_palette_name'),
            Column::computed('theme_palette')->title('Theme Palette')
            ->exportable(false)
            ->printable(false)
            ->width(60)
            ->addClass('text-center'),
            Column::make('status')->title('Status'),
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
        return 'ColorPalette_' . date('YmdHis');
    }
}
