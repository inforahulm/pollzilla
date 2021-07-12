 @extends('layouts.master')

 @section('page_title', 'View User Group Details')

 @section('page_head')
 <div class="float-right page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.poll.index') }}">View User Group</a></li>
        <li class="breadcrumb-item active">View User Group Details</li>
    </ol>
</div>
@endsection

@section('content')

<div class="row">
    <div class="col-xl-5">
        <div class="card m-b-30 profile-card">
            <div class="card-body text-center p-0 pt-4">
                <h4 class="mt-0 mb-4 header-title">User Profile</h4>
                <div class="user-box-profile">
                    <img src="{{ $user->profile_picture }}" alt="">
                    <h5>{{ $user->user_name }}</h5>
                    <h6>{{ $user->first_name }}</h6>
                    <p>Created at - {{ $user->created_at }} </p>
                </div>

            </div>
        </div>

    </div>
    <div class="col-xl-7">
        <div class="card m-b-30">
            <div class="card-body">
                <ul class="nav nav-pills mb-4 group-tab-part" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">
                            Groups
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">
                            Address Book
                        </a>
                    </li>

                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <h4 class="mt-0 header-title">Groups</h4>
                        <div class="all-user-lists scrollbar-list">
                            <?php if (count($addressBookGroup)!=0): ?>
                                <?php foreach ($addressBookGroup as $value): ?>
                                    <div class="user-list-area">
                                        <div class="flr-img">
                                            <img src="{{ $value->group_icon }}" alt="">
                                        </div>
                                        <div class="flr-dtl">
                                            <h6>Group Name:<span>{{ $value->group_name }}</span></h6>
                                            <h6>Members: <span>{{ $value->total_members }}</span></h6>
                                            <button class="btn btn-sm btn-outline-primary mt-2 viewgroup" data-id="{{ $value->id }}">Member List</button>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                                <?php else: ?>
                                    <div class="user-list-area">
                                        <div class="flr-dtl">
                                            <p>No group</p>
                                        </div>
                                    </div>
                                <?php endif ?>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <h4 class="mt-0 header-title">Contacts</h4>
                            <div class="all-user-lists scrollbar-list">
                                <?php if (count($addressBook)!=0): ?>
                                    <?php foreach ($addressBook as $value): ?>
                                        <div class="user-list-area">
                                            <div class="flr-img">
                                                <img src="{{ $value->user_details->profile_picture }}" alt="">
                                            </div>
                                            <div class="flr-dtl">
                                                <h6>Pollzilla ID:<span>{{ $value->user_details->user_name }}</span></h6>
                                                <h6>Name:<span>{{ $value->user_details->first_name }}</span></h6>
                                                <p>Email:{{ $value->user_details->email }}</p>
                                                <p>Phone: {{ $value->user_details->mobile_number }}</p>
                                            </div>
                                        </div>
                                    <?php endforeach ?>

                                    <?php else: ?>
                                        <div class="user-list-area">
                                            <div class="flr-dtl">
                                                <p>No Contacts</p>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="membermodal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="group_name">Group Name</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4 class="mt-0 header-title">Participants : <span id="total_members"></span></h4>
                        <div class="all-user-lists scrollbar-list" id="memberList">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection

        @push('page_scripts')



        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

        <script>
            // Get Group Details
            $(document).on('click', '.viewgroup', function() {
                var grp_id = $(this).attr('data-id');
                $html ="";
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url : "{{ route('admin.users.getGroup') }}",
                    type : 'GET',
                    data : {'group_id' : grp_id},
                    success : function (res) {
                        $("#total_members").html(res.total_members);
                        $("#group_name").html(res.group_name);
                        for (var i = 0; i < res.member_list.length; i++) {

                            $html += "<div class='partcipant-member'><div class='flr-img'><img src='"+res.member_list[i].profile_picture+"' alt=''></div><div class='flr-dtl'><h6>"+res.member_list[i].user_name+"</h6></div></div>";
                        }
                        $("#memberList").html($html);
                        $("#membermodal").modal('show');
                    }
                });

            });
        </script>

        @endpush


