@extends('layouts.master')

@section('page_title', 'View Poll Details')

@section('page_head')
<div class="float-right page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.poll.index') }}">Poll</a></li>
        <li class="breadcrumb-item active">View Poll Details</li>
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-5">
        <div class="card m-b-30">
            <div class="card-body text-center">
                <h4 class="mt-0 header-title">My Polls</h4>
                <div class="all-user-lists">
                    @php 
                    $minutes = 0;
                    $startTime = \Carbon\Carbon::parse($PollDetails->launch_date_time);
                    $endTime = \Carbon\Carbon::parse($PollDetails->launch_date_time);
                    if($PollDetails->forever_status == 0){
                        $endTime = \Carbon\Carbon::parse($endTime->add('minutes',$PollDetails->set_duration));
                    } else {
                        $endTime = \Carbon\Carbon::now();
                    } 
                    $minutes = $endTime->diffInMinutes($startTime);
                    
                    $isStarted = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $startTime)->isFuture();
                    
                    $currentTime = \Carbon\Carbon::now();
                    @endphp
                    <div class="poll-box-data">
                        <a href="javascript:void(0);">
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
                            <div class="poll-foot d-none">
                                <div class="progress">
                                    <div class="progress-bar bg-success" id="pbar_innerdiv" role="progressbar" style="width: {{ (($PollDetails->poll_current_status == 1 || $PollDetails->poll_current_status == 41) && $isStarted ==1) ?'30':'100' }}%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-text"><i class="fa fa-clock-o mr-2"></i>{{ (($PollDetails->poll_current_status == 1 || $PollDetails->poll_current_status == 41) && $isStarted==1) ?'Running':'Completed' }}</div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="poll-dtl-data">
                        <a href="javascript:void(0);">
                            <span class="poll-data-text">Time duration</span>
                            <span class="poll-data-right-text">{{ getHumanReable($minutes) }}</span>
                        </a>
                    </div>

                    @if($isStarted == 1 && $PollDetails->forever_status == 0)
                    <div class="poll-dtl-data">
                        <a href="javascript:void(0);">
                            <span class="poll-data-text">Launch time remaining</span>
                            <span class="poll-data-right-text" id="countDownpast">00 : 00 : 00</span>
                        </a>
                    </div>
                    @endif


                    <div class="poll-dtl-data">
                        <a href="javascript:void(0);">
                            <span class="poll-data-text">Poll type</span>
                            <span class="poll-data-right-text">@if($PollDetails->poll_privacy==0) {{'Public'}} @else {{'Private'}} @endif</span>
                        </a>
                    </div>
                    <div class="poll-dtl-data">
                        <a href="javascript:void(0);">
                            <span class="poll-data-text">Is Poll Secret</span>
                            <span class="poll-data-right-text">@if($PollDetails->is_secret==1) {{'Yes'}} @else {{'No'}} @endif</span>
                        </a>
                    </div>
                    <div class="poll-dtl-data">
                        <a href="javascript:void(0);">
                            <span class="poll-data-text">Poll Sharable</span>
                            <span class="poll-data-right-text">@if($PollDetails->share_status==1) {{'Yes'}} @else {{'No'}} @endif</span>
                        </a>
                    </div>
                    <div class="poll-dtl-data">
                        <a href="javascript:void(0);">
                            <span class="poll-data-text">Poll Result Chart</span>
                            <span class="poll-data-right-text">{{ $PollDetails->chart_id==1 ? 'Donut Chart':($PollDetails->chart_id==2?'Pie Chart':'Bar Chart')}}</span>
                        </a>
                    </div>
                    <div class="poll-dtl-data">
                        <a href="javascript:void(0);">
                            <span class="poll-data-text">Number of votes</span>
                            <span class="poll-data-right-text">{{ $PollDetails->poll_votting_count }}</span>
                        </a>
                    </div>
                    <div class="poll-dtl-data">
                        <a href="javascript:void(0);">
                            <span class="poll-data-text">Comments</span>
                            <span class="poll-data-right-text">{{ $PollDetails->poll_comment_count }}</span>
                        </a>
                    </div>
                    <div class="poll-dtl-data">
                        <a href="javascript:void(0);">
                            <span class="poll-data-text">Repolls</span>
                            <span class="poll-data-right-text">{{ $PollDetails->repoll_count }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card m-b-30">
            <div class="card-body">
                <h4 class="mt-0 header-title">Comments</h4>
                <div class="all-user-lists scrollbar-list">
                    @foreach($PollComment as $comment)
                    <div class="user-list-area">
                        <div class="flr-img">
                            <img src="{{ $comment->user_data->profile_picture}}" alt="" />
                        </div>
                        <div class="flr-dtl">
                            <h6>{{ $comment->user_data->user_name}}<span>{{ $comment->created_at->diffForHumans() }}</span></h6>
                            <p>{{ $comment->comment }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-7">
        <div class="card m-b-30">
            <div class="card-body">
                <h4 class="mt-0 header-title">Result</h4>
                @if(array_sum($ChartsValue) !=0)
                <div class="row justify-content-center">
                    @if($PollDetails->chart_id==1)
                    <div class="col-md-10 mb-4">
                        <canvas id="donut-example"></canvas>
                    </div>
                    @elseif($PollDetails->chart_id==2)
                    <div class="col-md-10 mb-4">
                        <canvas id="pie-example"></canvas>

                    </div>
                    @else
                    <div class="col-md-10 mb-4">
                        <canvas id="bar-example"></canvas>
                    </div>
                    @endif
                </div>
                @else 
                <div class="text-center">
                    <div class="poll-r-empty">
                        <img src="{{ asset('assets/images/poll-result-empty.png') }}" class="img-fluid" alt="">
                    </div>
                    <p>Poll No one can votting on this poll</p>
                </div>
                @endif
            </div>
        </div>
        <div class="card m-b-30">
            <div class="card-body">
                <h4 class="mt-0 header-title">Activity Feed</h4>
                <div class="all-user-lists scrollbar-list">
                    @foreach($PollActiviyFeed as $ActiviyFeed)
                    @php 
                    $type="";
                    switch ($ActiviyFeed->get_feed->poll_style_id) {
                        case 1:
                        $type='Text';
                        break; 

                        case 2:
                        $type='Image';
                        break; 

                        case 3:
                        $type='Music';
                        break; 

                        case 4:
                        $type='Video';
                        break;

                    }
                    @endphp
                    <div class="user-list-area">
                        <div class="flr-img">
                            <img src="{{ $ActiviyFeed->user_data->profile_picture }}" alt="" />
                        </div>
                        <div class="flr-dtl feed-act">
                            <h6>{{ $ActiviyFeed->user_data->user_name}} <span class="simple-txt">
                                @if($ActiviyFeed->type == 1) 
                                {{'voted'}} 
                                @else 
                                {{ 'Commented' }} 
                            @endif in your {{ $type }}  poll:</span><span>{{$ActiviyFeed->get_feed->generic_title}}</span></h6>
                            <p></p>
                            <p class="time-data">{{$ActiviyFeed->created_at}}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('page_scripts')

<!--Morris Chart-->
<script src="{{ asset('assets/plugins/morris/morris.min.js') }}"></script>
<script src="{{ asset('assets/plugins/raphael/raphael-min.js') }}"></script>
<script src="{{ asset('assets/plugins/chart.js/chart.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>


<script>
    var ChartsTitleArr =<?php echo json_encode($ChartsTitle );?>;
    var ChartsValueArr =<?php echo json_encode($ChartsValue );?>;
    var total = 0;
    var dynamicColors = function() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    };
    var coloR = [];
    for (var i = ChartsValueArr.length - 1; i >= 0; i--) {
        total += ChartsValueArr[i];
        coloR.push(dynamicColors());
    }

    var countDownDate = new Date("{{$PollDetails->launch_date_time}}").getTime();
    var countDownnow = new Date("{{$currentTime}}").getTime();
    var distanceTime = 0;
    var x = setInterval(function() {
        var now = new Date().getTime();
        var distance = distanceTime=  countDownDate - now;
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        $("#countDownpast").html(hours+' : '+minutes+' : '+seconds);
        if (distance < 0) {
            clearInterval(x);
            $("#countDownpast").html('Poll Ended');
        }
    }, 1000);



    $(".scrollbar-list").slimscroll({
        height: "auto",
        position: "right",
        size: "5px",
        color: "#9ea5ab",
        touchScrollStep: 50,
    });



    function ChartRender(type) {

        console.log(type);
        if(type == 1) {

            var ctx = document.getElementById("donut-example").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ChartsTitleArr,
                    datasets: [{    
                        data: ChartsValueArr,
                        backgroundColor: coloR,
                        borderColor: 'rgba(200, 200, 200, 0.75)',
                        hoverBorderColor: 'rgba(200, 200, 200, 1)'
                    }]},         
                    options: {
                        legend: {
                            display: true,
                            position: 'bottom',
                        }
                    }
                });


        } else if(type==2) {
            var ctx = document.getElementById("pie-example").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ChartsTitleArr,
                    datasets: [{    
                        data: ChartsValueArr,
                        backgroundColor: coloR,
                        borderColor: 'rgba(200, 200, 200, 0.75)',
                        hoverBorderColor: 'rgba(200, 200, 200, 1)'
                    }]},         
                    options: {
                        legend: {
                            display: true,
                            position: 'bottom',
                        },
                    }
                });

        } else {
            var ctx = document.getElementById("bar-example").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels:ChartsTitleArr,
                    datasets: [{    
                        data: ChartsValueArr,
                        backgroundColor: coloR,
                        borderColor: 'rgba(200, 200, 200, 0.75)',
                        hoverBorderColor: 'rgba(200, 200, 200, 1)'
                    }]},         
                    options: {
                        scales: {
                            yAxes: [{
                              gridLines: {
                                display: false,
                            },
                        }],
                        xAxes: [{
                          gridLines: {
                            display: false,
                        },
                    }],
                },
                legend: {
                    display: false,
                    position: 'bottom',
                } 
            }
        });
        }
    }
    setTimeout(function(){
        if(total!=0)
            ChartRender({{$PollDetails->chart_id}})
        else 
            console.log('Poll No one can votting on this poll');
        
    },500)


    var start = new Date();
    var timeoutVal = Math.floor(distance/100);
    animateUpdate();

    function updateProgress(percentage) {
        $('#pbar_innerdiv').css("width", percentage + "%");
        $('#pbar_innertext').text(percentage + "%");
    }

    function animateUpdate() {
        var now = new Date();
        var timeDiff = now.getTime() - start.getTime();
        var perc = Math.round((timeDiff/distance)*100);
        console.log(perc);
        if (perc <= 100) {
         updateProgress(perc);
         setTimeout(animateUpdate, timeoutVal);
     }
 }
</script>

@endpush


