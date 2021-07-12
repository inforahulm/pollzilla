@extends('layouts.master')

@section('page_title', 'Dashboard')

@section('page_head')
<div class="float-right page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
</div>
@endsection

@section('content')

<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card mini-stat bg-primary-blue m-b-30">
            <div class="p-3 text-white">
                <div class="mini-stat-icon">
                    <i class="mdi dripicons-user-group float-right mb-0"></i>
                </div>
                <h6 class="text-capitalize mb-0">Total Users</h6>
            </div>
            <div class="card-body">
                <div class="mt-1 text-muted">
                    <h3 class="m-0">{{ $countsData['totalUsers'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card mini-stat bg-success m-b-30">
            <div class="p-3 text-white">
                <div class="mini-stat-icon">
                    <i class="mdi dripicons-graph-line  float-right mb-0"></i>
                </div>
                <h6 class="text-capitalize mb-0">Total Poll</h6>
            </div>
            <div class="card-body">
                <div class="mt-1 text-muted">
                    <h3 class="m-0">{{ $countsData['totalPoll'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card mini-stat bg-danger m-b-30">
            <div class="p-3 text-white">
                <div class="mini-stat-icon">
                    <i class="mdi dripicons-graph-pie float-right mb-0"></i>
                </div>
                <h6 class="text-capitalize mb-0">Total Voted Poll</h6>
            </div>
            <div class="card-body">
                <div class="mt-1 text-muted">
                    <h3 class="m-0">{{ $countsData['totalVotedPoll'] }}</h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card mini-stat bg-dark m-b-30">
            <div class="p-3 text-white">
                <div class="mini-stat-icon">
                    <i class="mdi mdi-account-network float-right mb-0"></i>
                </div>
                <h6 class="text-capitalize mb-0">Today's User</h6>
            </div>
            <div class="card-body">
                <div class="mt-1 text-muted">
                    <h3 class="m-0">{{ $countsData['totalTodayPoll'] }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xl-12">
        <div class="card m-b-30">
            <div class="card-body">
                <h4 class="mt-0 header-title mb-4">Latest User</h4>
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>Sr No</th>
                                <th>Username</th>
                                <th>First Name</th>
                                <th>Email</th>
                                <th>Voted Poll</th>
                                <th>Created Poll</th>
                                <th>Joined Date / Time</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>

                        </thead>
                        <tbody>
                            @if(count($leatestUser)>0)
                            @php
                            $count=1;
                            @endphp
                            @foreach($leatestUser as  $user)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ $user['user_name'] }}</td>
                                <td>{{ $user['first_name'] }}</td>
                                <td>{{ $user['email'] }}</td>
                                <td>{{ count($user['getUserVoted'])}}</td>
                                <td>{{ count($user['getUserCreatedPoll'])}}</td>
                                <td>{{ $user['created_at'] }}</td>
                                <td>
                                    @if($user['status'] == 0) 
                                    {!! $status ='<span class="badge badge-danger" >Inactive</span>' !!}
                                    @else 
                                    {!! $status= '<span class="badge badge-success" >Active</span>' !!}
                                    @endif  
                                </td>
                                <td>
                                    @if($user['status'] == 1) 
                                    {!!  '<button type="button" class="btn btn-secondary btn-sm changeStatus" status="0" title="click to Inactivate" category_id="'.$user['id'].'"><i class="fa fa-unlock"></i></button> ' !!}
                                    @else
                                    {!!  '<button type="button" class="btn btn-secondary btn-sm changeStatus" status="1" title="click to Activate" category_id="'.$user['id'].'"><i class="fa fa-lock"></i></button> ' !!}
                                    @endif
                                    {!!  '<a href="'.route('admin.users.edit', encryptString($user['id'])).'" class="btn btn-primary btn-sm" title="view  user profile"><i class="fa fa-eye"></i></a>  '; !!}
                                    {!!  '<a href="'.route('admin.users.usergroup', encryptString($user['id'])).'" class="btn btn-success btn-sm" title="View User Group"><i class="fa fa-users"></i></a>  ' !!}
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr align="center"><td colspan="9">No data available</td></tr>
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xl-12">
        <div class="card m-b-30">
            <div class="card-body">
                <h4 class="mt-0 header-title mb-4">Latest Poll Created</h4>
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>Sr No</th>
                                <th>Generic Title</th>
                                <th>Category</th>
                                <th>Sub Category</th>
                                <th>Poll Style</th>
                                <th>Creation Date Time</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>

                        </thead>
                        <tbody>
                            @if(count($leatestPoll)>0)
                            @php
                            $count=1;
                            @endphp
                            @foreach($leatestPoll as $poll)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ $poll->generic_title }}</td>
                                <td>{{ $poll->categories->interest_category_name }}</td>
                                <td>{{ $poll->subcategories->interest_sub_category_name }}</td>
                                <td>
                                    @if($poll->poll_style_id == 1) 
                                    {!! $status ='<span class="badge badge-primary" >Text</span>' !!}
                                    @elseif($poll->poll_style_id == 2) 
                                    {!! $status= '<span class="badge badge-primary" >Image</span>' !!}
                                    @elseif($poll->poll_style_id == 3) 
                                    {!! $status= '<span class="badge badge-primary" >Music</span>' !!}
                                    @elseif($poll->poll_style_id == 4) 
                                    {!! $status= '<span class="badge badge-primary" >Video</span>' !!}
                                    @else
                                    {!! $status= '<span class="badge badge-primary" >Hito Meter</span>' !!}
                                    @endif  
                                </td>
                                <td>{{ $poll->created_at }}</td>
                                <td>
                                    @if($poll->status == 0) 
                                    {!! $status ='<span class="badge badge-danger" >Inactive</span>' !!}
                                    @else 
                                    {!! $status= '<span class="badge badge-success" >Active</span>' !!}
                                    @endif  
                                </td>
                                <td>
                                    @if($poll['status'] == 1) 
                                    {!!  '<button type="button" class="btn btn-secondary btn-sm changeStatuspoll" status="0" title="click to Inactivate" category_id="'.$poll['id'].'"><i class="fa fa-unlock"></i></button> ' !!}
                                    @else
                                    {!!  '<button type="button" class="btn btn-secondary btn-sm changeStatuspoll" status="1" title="click to Activate" category_id="'.$poll['id'].'"><i class="fa fa-lock"></i></button> ' !!}
                                    @endif
                                    {!!  '<a href="'.route('admin.poll.edit', encryptString($poll['id'])).'" class="btn btn-primary btn-sm" title="view  user profile"><i class="fa fa-eye"></i></a>  '; !!}
                                    {!!  '<a href="'.route('admin.poll.view', encryptString($poll['id'])).'" class="btn btn-success btn-sm" title="View User Group"><i class="fa fa-users"></i></a>  ' !!}
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr align="center"><td colspan="8">No data available</td></tr>
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card m-b-30">
            <div class="card-body">
                <h4 class="mt-0 header-title mb-4">Latest Voted Poll </h4>
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>Created By</th>
                                <th>Voted By</th>
                                <th>Poll Style</th>
                                <th>Age</th>
                                <th>Poll Title</th>
                                <th>Date Time</th>
                            </tr>

                        </thead>
                        <tbody>
                            @if(count($leatestVotedPoll)>0)
                            @foreach($leatestVotedPoll as  $vote)
                            <tr>
                                <td>{{ $vote->getPollCreator->pollCreatorUser->user_name}}</td>
                                <td>{{ $vote->getPollVoter->user_name}}</td>
                                <td>
                                    @if($vote->getPollDetails->poll_style_id == 1) 
                                    {!! $status ='<span class="badge badge-primary" >Text</span>' !!}
                                    @elseif($vote->getPollDetails->poll_style_id == 2) 
                                    {!! $status= '<span class="badge badge-primary" >Image</span>' !!}
                                    @elseif($vote->getPollDetails->poll_style_id == 3) 
                                    {!! $status= '<span class="badge badge-primary" >Music</span>' !!}
                                    @elseif($vote->getPollDetails->poll_style_id == 4) 
                                    {!! $status= '<span class="badge badge-primary" >Video</span>' !!}
                                    @else
                                    {!! $status= '<span class="badge badge-primary" >Hito Meter</span>' !!}
                                    @endif  
                                </td>
                                @if(!empty($vote->getPollVoter->birthdate))
                                <td>{{ \Carbon\Carbon::parse($vote->getPollVoter->birthdate)->diff(\Carbon\Carbon::now())->format('%y year(s)') }}</td>
                                @else
                                <td>-</td>
                                @endif

                                <td>{{ $vote->getPollDetails->generic_title }}</td>
                                <td>{{ $vote->created_at }}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr align="center"><td colspan="8">No data available</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('page_scripts')

<script>
      // change status
      $(document).on('click', '.changeStatus', function() {
        var this_var = this;
        $(this).attr('disabled', true);
        var category_id = $(this).attr('category_id');
        var status = $(this).attr('status');
        var msg = "";
        console.log(status);
        if(status == "0") {
            msg = "Inactive";
        } else {
            msg = "Active";
        }

        swal({
            title: 'Are you sure want to '+msg+'?',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, '+msg+' it!',
            reverseButtons: true
        }).then((result) => {
            if (result) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url : "{{ route('admin.users.change_status') }}",
                    type : 'PATCH',
                    data : {'status' : status, 'id' : category_id},
                    success : function (res) {

                        swal(
                                res.action, //get from controller (block/unblock/cancel)
                                res.msg, // get from controller
                                res.status // get from controller (success/error)
                                )

                        window.location.reload();
                    }
                });
            } else {
                swal("Cancelled", "Status not changed :)", "error");
                $(this).attr('disabled', false);
            }
        });
    });

       // change status of poll
       $(document).on('click', '.changeStatuspoll', function() {
        var this_var = this;
        $(this).attr('disabled', true);
        var category_id = $(this).attr('category_id');
        var status = $(this).attr('status');
        var msg = "";
        console.log(status);
        if(status == "0") {
            msg = "Inactive";
        } else {
            msg = "Active";
        }

        swal({
            title: 'Are you sure want to '+msg+'?',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, '+msg+' it!',
            reverseButtons: true
        }).then((result) => {
            if (result) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url : "{{ route('admin.poll.change_status') }}",
                    type : 'PATCH',
                    data : {'status' : status, 'id' : category_id},
                    success : function (res) {

                        swal(
                                res.action, //get from controller (block/unblock/cancel)
                                res.msg, // get from controller
                                res.status // get from controller (success/error)
                                )

                        window.location.reload();
                    }
                });
            } else {
                swal("Cancelled", "Status not changed :)", "error");
                $(this).attr('disabled', false);
            }
        });
    });


</script>

@endpush