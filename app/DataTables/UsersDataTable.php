<?php

namespace App\DataTables;

use App\Models\User;
use App\Models\PollVote;
use App\Models\Poll;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
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
            $result .= '<a href="'.route('admin.users.edit', encryptString($data->id)).'" class="btn btn-primary btn-sm" title="view  user profile"><i class="fa fa-eye"></i></a>  ';
            $result .= '<a href="'.route('admin.users.usergroup', encryptString($data->id)).'" class="btn btn-success btn-sm" title="View User Group"><i class="fa fa-users"></i></a>  ';

            return $result;
        })
        ->editColumn('status',function($data) {
            if($data->status == 0) {
                return '<span class="badge badge-danger" >Inactive</span>';
            } else {
                return '<span class="badge badge-success" >Active</span>';
            }
        })
        ->addColumn('voted_poll',function($data) {
            return PollVote::where('user_id',$data->id)->count();
        })
        ->addColumn('created_poll',function($data) {
            return Poll::where('user_id',$data->id)->count();
        })
        // ->orderColumn('voted_poll', function ($data, $order) {
        //     dd($data->id);
        //    // return  User::withCount('getUserVoted')->orderBy('get_user_voted_count', $order)->get();
        //    return PollVote::where('user_id',$data->id)->orderBy('get_user_voted_count', $order)->count();
        // })
        ->rawColumns(['action', 'status', 'gender'])
        ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->newQuery()->where('isguest',0);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
        ->setTableId('users-table')
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
            Column::make('user_name'),
            Column::make('first_name'),
            Column::make('email'),
            Column::make('voted_poll')->title('Voted Poll'),
            Column::make('created_poll')->title('Created Poll'),
            Column::make('created_at')->title('Joined Date /Time(UTC)'),
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
        return 'Users_' . date('YmdHis');
    }
}
