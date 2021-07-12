  <!-- end row -->
  <div class="row">
    <div class="col-xl-5">
        <div class="card m-b-30 profile-card">
            <div class="card-body text-center p-0 pt-4">
                <h4 class="mt-0 header-title">User Profile</h4>
                <div class="user-box-profile">
                    <img src="{{ $user->profile_picture }}" alt="">
                    <h5>{{ $user->user_name }}</h5>
                    <h6>{{ $user->first_name }}</h6>
                    <h6>Created at - {{ $user->created_at }} </h6>
                </div>
                <ul class="nav nav-pills user-data-boxes" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">
                            <div class="user-flr-box">
                                <h6>{{ count($follower) }}</h6>
                                <p>Followers <i class="fa fa-check-circle"></i></p>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">
                            <div class="user-flr-box">
                                <h6>{{ count($following) }}</h6>
                                <p>Following <i class="fa fa-check-circle"></i></p>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">
                            <div class="user-flr-box">
                                <h6>{{ count($poll) }}</h6>
                                <p>Polls Created</p>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card m-b-30">
            <div class="card-body">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <h4 class="mt-0 header-title">Followers</h4>
                        <div class="all-user-lists scrollbar-list">
                            <?php if (count($follower)!=0): ?>
                            <?php  foreach ($follower as $value): ?>
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
                                    <p>No follower users</p>
                                </div>
                            </div>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <h4 class="mt-0 header-title">Following</h4>
                        <div class="all-user-lists scrollbar-list">
                            <?php if (count($following)!=0): ?>
                            <?php  foreach ($following as $value):?>
                            <div class="user-list-area">
                                <div class="flr-img">
                                    <img src="{{ $value->userDetails->profile_picture }}" alt="">
                                </div>
                                <div class="flr-dtl">
                                    <h6>Pollzilla ID:<span>{{ $value->userDetails->user_name }}</span></h6>
                                    <h6>Name:<span>{{ $value->userDetails->first_name }}</span></h6>
                                    <p>Email:{{ $value->userDetails->email }}</p>
                                    <p>Phone: {{ $value->userDetails->mobile_number }}</p>
                                </div>
                            </div>
                            <?php endforeach ?>
                            <?php else: ?>
                            <div class="user-list-area">
                                <div class="flr-dtl">
                                    <p>No Following users</p>
                                </div>
                            </div>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                        <h4 class="mt-0 header-title">My Polls</h4>
                        <div class="all-user-lists scrollbar-list">

                            @foreach($poll as $PollDetails)
                            @php 
                            $minutes = 0;
                            $startTime = \Carbon\Carbon::parse($PollDetails->launch_date_time);
                
                            $isStarted = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $startTime)->isFuture();
                            
                            @endphp
                            <div class="poll-box-data">
                                <a href="{{route('admin.poll.view', encryptString($PollDetails->id))}}" title="Click to view poll details">
                                    <div class="poll-head">
                                        <div class="poll-left">
                                            <h6>{{ $PollDetails->generic_title }}</h6>
                                            <p>{{ $PollDetails->categories->interest_category_name}}</p>
                                        </div>
                                        <div class="poll-right">
                                            <h6>{{ ($PollDetails->poll_current_status == 2 || $PollDetails->poll_current_status == 42) ? 'Completed': (($PollDetails->poll_current_status == 1 || $PollDetails->poll_current_status == 41) ? 'Running':'Upcoming')}} </h6>
                                            <p>{{ $PollDetails->launch_date_time }}</p>
                                        </div>
                                    </div>
                                    <div class="poll-foot">
                                        <div class="progress">
                                            <div class="progress-bar bg-success" id="pbar_innerdiv" role="progressbar" style="width: {{ (($PollDetails->poll_current_status == 1 || $PollDetails->poll_current_status == 41) && $isStarted ==1) ?'30':'100' }}%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                            <div class="progress-text"><i class="fa fa-clock-o mr-2"></i>{{ (($PollDetails->poll_current_status == 1 || $PollDetails->poll_current_status == 41) && $isStarted==1) ?'Running':'Completed' }}</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-7">
        <div class="card m-b-30">
            <div class="card-body">
                <h4 class="mt-0 header-title">Profile Detail</h4>
                <form action="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" required="" placeholder="Username" value="{{ $user->user_name }}" readonly="">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Email adderess</label>
                                <input type="text" class="form-control" required="" placeholder="Email adderess" value="{{ $user->email }}" readonly="">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Phone number</label>
                                <input type="text" class="form-control" required="" placeholder="Phone number" value="{{ $user->mobile_number }}" readonly="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Birth of date</label>
                                <input type="text" class="form-control" required="" placeholder="Birth of date" value="{{ $user->birthdate }}" readonly="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Gender</label>
                                <select name="" id="" class="form-control" readonly="">
                                    <option value="1" value="{{ $user->gender == '1' ?'selected':'' }}">Male</option>
                                    <option value="2" value="{{ $user->gender == '2' ?'selected':'' }}">Female</option>
                                    <option value="3" value="{{ $user->gender == '3' ?'selected':'' }}">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Country</label>
                                <select name="" id="" class="form-control" readonly="">
                                    <option >{{ $user->getCountry->country_name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>State</label>
                                <select name="" id="" class="form-control" readonly="">
                                    <option >{{ $user->getState->state_name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>City</label>
                                <select name="" id="" class="form-control" readonly="">
                                    <option >{{ $user->getCity->city_name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Company</label>
                                <input type="text" class="form-control" required="" placeholder="Company" value="Microsoft" value="{{ $user->company_name }}" readonly="">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>School</label>
                                <input type="text" class="form-control" required="" placeholder="School" value="California Institute of Technology" value="{{ $user->school_name }}" readonly="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Facebook</label>
                                <input type="text" class="form-control" required="" placeholder="Facebook"  value="{{ $user->facebook_url }}" readonly="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Twitter</label>
                                <input type="text" class="form-control" required="" placeholder="Twitter" value="{{ $user->twitter_url }}" readonly="">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card m-b-30">
            <div class="card-body">
                <h4 class="mt-0 header-title">My Interest</h4>
                <div class="interest-tabs">
                    <?php if (count($interest)!=0): ?>

                    <?php foreach ($interest as  $value): ?>
                    <div class="int-tab">{{ $value->interest_sub_category_name}}</div>
                    <?php endforeach ?>
                    <?php else: ?>
                    <p>No interest selected</p>
                    <?php endif ?>
                </div>
            </div>
        </div>

    </div>
</div>
            <!-- end row -->