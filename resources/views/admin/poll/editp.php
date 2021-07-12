@extends('layouts.master')

@section('page_title', 'Update Poll Details')

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
    <div class="col-xl-12">
        <div class="card m-b-30 profile-card">
            <div class="card-body">
                <h4 class="mt-0 header-title">Update a Poll</h4>
                <form action="{{ route('admin.poll.update') }}" method="post">
                    @csrf
                    <div class="poll-section">
                        <div class="poll-header">
                            <div class="poll-num">1</div>
                            <div class="poll-head-text">Set up</div>
                        </div>
                        <div class="poll-body">
                            <div class="row">
                                <div class="col-md-6 col-xl-4">
                                    <div class="form-group">
                                        <label>Poll Category</label>
                                        <select name="interest_category_id" id="interest_category_id" class="form-control">
                                            <option>Select Poll Category</option>
                                            @foreach ($InterestCategory as  $value):
                                            <option value="{{ $value->id }}" {{ ($polls->interest_category_id == $value->id) ? 'selected':'' }} >{{ $value->interest_category_name }}</option>
                                            @endforeach 
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-4">
                                    <div class="form-group">
                                        <label>Poll Sub Category</label>
                                        <select name="interest_sub_category_id" id="interest_sub_category_id" class="form-control">

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-4">
                                    <div class="form-group">
                                        <label>Generic Title</label>
                                        <input type="text" class="form-control" name="generic_title" id="generic_title" value="{{ $polls->generic_title }}">
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-xl-4">
                                    <div class="form-group">
                                        <label>Select Poll Type</label>
                                        <select name="poll_type_id" id="poll_type_id" class="form-control">
                                            <option value="1" {{ $polls->poll_type_id == 1 ? 'selected':'' }}>Pic One</option>
                                            <option value="2" {{ $polls->poll_type_id == "2" ? 'selected':'' }}>Thumbs Up / Thumbs Down</option>
                                            <option value="3" {{ $polls->poll_type_id == 3 ? 'selected':'' }}>Yes / No</option>
                                            <option value="4" {{ $polls->poll_type_id == "4" ? 'selected':'' }}>Heat-O-Meter</option>
                                            <option value="5" {{ $polls->poll_type_id == "5" ? 'selected':'' }}>Rank In Order</option>
                                            <option value="6" {{ $polls->poll_type_id == "6" ? 'selected':'' }}>Ratting</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xl-4">
                                    <div class="form-group">
                                        <label>Choose No. of options</label>
                                        <select name="no_of_option" id="no_of_option" class="form-control">
                                            <option value="1" {{ $polls->no_of_option == "1" ? 'selected':'' }}>1</option>
                                            <option value="2" {{ $polls->no_of_option == "2" ? 'selected':'' }}>2</option>
                                            <option value="3" {{ $polls->no_of_option == "3" ? 'selected':'' }}>3</option>
                                            <option value="4" {{ $polls->no_of_option == "4" ? 'selected':'' }}>4</option>
                                            <option value="5" {{ $polls->no_of_option == "5" ? 'selected':'' }}>5</option>
                                        </select>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="poll-section">
                        <div class="poll-header">
                            <div class="poll-num">2</div>
                            <div class="poll-head-text">Template</div>
                        </div>
                        <div class="poll-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select Poll Style</label>
                                        <select name="poll_style_id" id="poll_style_id" class="form-control">ca
                                            <option value="1" {{ $polls->poll_style_id == 1 ? 'selected':'' }}>Text</option>
                                            <option value="2" {{ $polls->poll_style_id == 2 ? 'selected':'' }}>Image</option>
                                            <option value="3" {{ $polls->poll_style_id == 3 ? 'selected':'' }}>Music</option>
                                            <option value="4" {{ $polls->poll_style_id == 4 ? 'selected':'' }}>Video</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Choose a Template</label>
                                        <select name="template_id" id="template_id" class="form-control">

                                            <!-- Text -->
                                            <optgroup label="Text" id="option1" disabled="" class="grpOption">
                                                <option data-value="1" value="1" {{ ($polls->poll_style_id ==1 && $polls->template_id == 1) ? 'selected':'' }}>Text Boxes</option>
                                                <option data-value="2" value="2" {{ ($polls->poll_style_id ==1 && $polls->template_id == 2) ? 'selected':'' }}>Vertical Text Boxes</option>
                                                <option data-value="3" value="3" {{ ($polls->poll_style_id ==1 && $polls->template_id == 3) ? 'selected':'' }}>Horizontal Text Boxes</option>
                                            </optgroup>
                                            <!-- // Image -->
                                            <optgroup label="Image"  id="option2" disabled="" class="grpOption">
                                                <option data-value="1" value="1" {{ ($polls->poll_style_id ==2 && $polls->template_id == 1) ? 'selected':'' }}>Square</option>
                                                <option data-value="2" value="2" {{ ($polls->poll_style_id ==2 && $polls->template_id == 2) ? 'selected':'' }}>Circle</option>
                                                <option data-value="3" value="3" {{ ($polls->poll_style_id ==2 && $polls->template_id == 3) ? 'selected':'' }}>Horizontal Reactangle</option>
                                                <option data-value="4" value="4" {{ ($polls->poll_style_id ==2 && $polls->template_id == 4) ? 'selected':'' }}>Vertical Reactangle</option>
                                            </optgroup>
                                            <!-- Music -->
                                            <optgroup label="Music" id="option3" disabled="" class="grpOption">
                                                <option data-value="1" value="1" {{ ($polls->poll_style_id ==3 && $polls->template_id == 1) ? 'selected':'' }}>Square</option>
                                                <option data-value="2" value="2" {{ ($polls->poll_style_id ==3 && $polls->template_id == 2) ? 'selected':'' }}>Circle</option>
                                            </optgroup>
                                            <!-- video -->
                                            <optgroup label="Video" id="option4" disabled="" class="grpOption">
                                                <option data-value="1" value="1" {{ ($polls->poll_style_id ==4 && $polls->template_id == 1) ? 'selected':'' }}>Square</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-row">
                                <div class="col-lg-3 col-md-6 answer_conainter" id="answer_conainter_1">
                                    <div class="form-group">
                                        <label class="upload_label">Answer 1</label>
                                        <div class="poll-ans-row">
                                            <div class="poll-upload-area" data-rel="text" data-id="1">
                                                <div class="poll-upload-text">
                                                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Maiores reprehenderit, fugit, nisi mollitia nulla iste nihil odio quae recusandae esse perspiciatis labore incidunt corporis, sit nemo dignissimos! Similique, repudiandae doloremque.</p>
                                                    <p>nisi mollitia nulla iste nihil odio quae recusandae esse perspiciatis labore incidunt corporis, sit nemo dignissimos! Similique.</p>
                                                </div>
                                                <!-- <div class="poll-preview" style="background-image: url({{ $PollAnswer[0]->poll_source_answer ?? '' }});">
                                                    <div class="video-icon">
                                                        <i class="fa fa-play"></i>
                                                    </div>
                                                </div> -->
                                                <!-- <div class="poll-upload-file">
                                                    <input type="file" class="form-control" name="poll_source_answer[]">
                                                    <i class="fa fa-pencil"></i>
                                                </div> -->
                                            </div>
                                            <!-- <div class="poll-upload-area" data-rel="image">
                                                
                                            </div> -->
                                        </div>
                                        <input type="text" class="form-control mt-2" placeholder="Title 1" value="{{ $PollAnswer[0]->poll_text_answer ?? '' }}" name="poll_text_answer[]" >
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 answer_conainter" id="answer_conainter_2">
                                    <div class="form-group">
                                        <label class="upload_label">Answer 2</label>
                                        <div class="poll-ans-row">
                                            <!-- <div class="poll-upload-area" data-rel="text" data-id="1">
                                                <div class="poll-upload-text">
                                                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Maiores reprehenderit, fugit, nisi mollitia nulla iste nihil odio quae recusandae esse perspiciatis labore incidunt corporis, sit nemo dignissimos! Similique, repudiandae doloremque.</p>
                                                    <p>nisi mollitia nulla iste nihil odio quae recusandae esse perspiciatis labore incidunt corporis, sit nemo dignissimos! Similique.</p>
                                                </div>
                                            </div> -->
                                            <div class="poll-upload-area poll-upload-img" data-rel="image">
                                                <span><img src="{{ asset('assets/images/bg-1.png') }}" class="img-fluid" alt=""></span>
                                            </div>
                                        </div>
                                        <!-- <div class="poll-upload-area" data-id="2">
                                            <div class="poll-preview" style="background-image: url({{ $PollAnswer[1]->poll_source_answer ?? '' }});">
                                            </div>
                                            <div class="poll-upload-file">
                                                <input type="file" class="form-control" name="poll_source_answer[]">
                                                <i class="fa fa-pencil"></i>
                                            </div>
                                        </div> -->
                                        <input type="text" class="form-control mt-2" placeholder="Title 2" value="{{ $PollAnswer[1]->poll_text_answer ?? '' }}" name="poll_text_answer[]" >
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6 answer_conainter" id="answer_conainter_3">
                                    <div class="form-group">
                                        <label class="upload_label" data-id="3">Answer 3</label>
                                        <div class="poll-upload-area poll-upload-video" data-rel="video">
                                            <div class="embed-responsive embed-responsive-16by9">
                                                <video id="videoplayer" playsinline controls data-poster="https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-HD.jpg">
                                                    <source src="https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-720p.mp4" type="video/mp4" />
                                                </video>
                                            </div>
                                        </div>
                                        <!-- <div class="poll-upload-area">
                                            <div class="poll-preview" style="background-image: url({{ $PollAnswer[2]->poll_source_answer ?? '' }})">
                                            </div>
                                            <div class="poll-upload-file">
                                                <input type="file" class="form-control" name="poll_source_answer[]">
                                                <i class="fa fa-pencil"></i>    
                                            </div>
                                        </div> -->
                                        <input type="text" class="form-control mt-2" placeholder="Title 3" value="{{ $PollAnswer[2]->poll_text_answer ?? '' }}" name="poll_text_answer[]" >
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 answer_conainter" id="answer_conainter_4">
                                    <div class="form-group">
                                        <label class="upload_label">Answer 4</label>
                                        <div class="poll-upload-area poll-upload-audio" data-rel="audio">
                                            <audio id="audioplayer" controls>
                                                <source src="https://cdn.plyr.io/static/demo/Kishi_Bashi_-_It_All_Began_With_a_Burst.mp3" type="audio/mp3">
                                                <source src="https://cdn.plyr.io/static/demo/Kishi_Bashi_-_It_All_Began_With_a_Burst.ogg" type="audio/ogg">
                                            </audio>
                                        </div>
                                        <!-- <div class="poll-upload-area" data-id="4">
                                            <div class="poll-preview" style="background-image: url({{ $PollAnswer[3]->poll_source_answer ?? '' }});">
                                                <div class="video-icon">
                                                    <i class="fa fa-play"></i>
                                                </div>
                                            </div>
                                            <div class="poll-upload-file">
                                                <input type="file" class="form-control" name="poll_source_answer[]">
                                                <i class="fa fa-pencil"></i>    
                                            </div>
                                        </div> -->
                                        <input type="text" class="form-control mt-2" placeholder="Title 4" value="{{ $PollAnswer[3]->poll_text_answer ?? '' }}" name="poll_text_answer[]" >
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 answer_conainter" id="answer_conainter_5">
                                    <div class="form-group">
                                        <label class="upload_label">Answer 5</label>
                                        <div class="poll-upload-area" data-id="5">
                                            <div class="poll-preview" style="background-image: url({{ $PollAnswer[4]->poll_source_answer ?? '' }});">
                                                <div class="video-icon">
                                                    <i class="fa fa-play"></i>
                                                </div>
                                            </div>
                                            <div class="poll-upload-file">
                                                <input type="file" class="form-control" name="poll_source_answer[]">
                                                <i class="fa fa-pencil"></i>    
                                            </div>
                                        </div>
                                        <input type="text" class="form-control mt-2" placeholder="Title 5" value="{{ $PollAnswer[4]->poll_text_answer ?? '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="poll-section">
                        <div class="poll-header">
                            <div class="poll-num">3</div>
                            <div class="poll-head-text">Design</div>
                        </div>
                        <div class="poll-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Select Poll Theme</label>
                                        <select name="is_light" id="is_light" class="form-control">
                                            <option value="1" {{ $polls->is_light == 1 ? 'selected':'' }}>Light</option>
                                            <option value="0" {{ $polls->is_light == 0 ? 'selected':'' }}>Dark</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Select Color Theme</label>
                                        <select name="color_palette_id" id="color_palette_id" class="form-control">
                                            @foreach ($colorPalette as  $value): 
                                            <option value="{{ $value->id }}" {{ $polls->color_palette_id == $value->id ? 'selected':'' }}>{{ $value->color_palette_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Add Background Image</label>
                                        <input type="file" class="form-control" name="background" id="background">
                                    </div>
                                </div>
                                <div class="col-md-2">

                                    @if($polls->is_background_image)
                                    <a href="{{ $polls->background ?? ''}}" target="_blank"><img src="{{ $polls->background ?? ''}} " alt="" width="100px" height="100px"></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="poll-section">
                        <div class="poll-header">
                            <div class="poll-num">4</div>
                            <div class="poll-head-text">Settings</div>
                        </div>
                        <div class="poll-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Set Duration </label>
                                        <select name="forever_status" id="forever_status" class="form-control">
                                            <option value="1" {{ $polls->forever_status == 1 ? 'selected':'' }}> Hours</option>
                                            <option value="0" {{ $polls->forever_status == 0 ? 'selected':'' }}>Forever</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 d-none" id="set_duration_id">
                                    <div class="form-group">
                                        <label>Set Duration in hours</label>
                                        <input type="number" min="1" class="form-control" id="set_duration_value" name="set_duration_value" value="{{ $polls->set_duration }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Schedule Poll Launch Date & Time</label>
                                        <input type="text" class="form-control" id="launch_date_time" name="launch_date_time" value="{{ $polls->launch_date_time }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Public/Private Poll</label>
                                        <select name="poll_privacy" id="poll_privacy" class="form-control">
                                            <option value="1" {{ $polls->poll_privacy == 1 ? 'selected':'' }}>Public</option>
                                            <option value="2" {{ $polls->poll_privacy == 2 ? 'selected':'' }}>Private</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Secret Poll</label>
                                        <select name="" id="" class="form-control">
                                            <option value="1" {{ $polls->poll_privacy == 1 ? 'selected':'' }}>ON</option>
                                            <option value="2" {{ $polls->poll_privacy == 2 ? 'selected':'' }}>OFF</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Share</label>
                                        <select name="share_status" id="share_status" class="form-control">
                                            <option value="1" {{ $polls->share_status == 1 ? 'selected':'' }} >On</option>
                                            <option value="2" {{ $polls->share_status == 2 ? 'selected':'' }} >Off</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Show Results As</label>
                                        <select name="chart_id" id="chart_id" class="form-control">
                                            <option value="1" {{ $polls->share_status == 1 ? 'selected':'' }} >Pie Chart</option>
                                            <option value="2" {{ $polls->share_status == 2 ? 'selected':'' }} >Donut Chart</option>
                                            <option value="3" {{ $polls->share_status == 3 ? 'selected':'' }} >Bar Chart</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(true ||$Pollcount==0 && ($polls->poll_current_status =="3" || $polls->poll_current_status =="43"))
                    <div class="row">
                        <div class="col-md-12 mt-4">
                            <button type="submit" class="btn btn-primary">Edit Poll Details</button>
                            <input type="hidden" name="id" value="{{$polls->id}}">
                        </div>
                    </div>
                    @endif
                </form>
            </div>
        </div>

    </div>

</div>

@endsection

@push('page_scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

<script>
    var no_of_option = '{{$polls->no_of_option}}';
    $('#launch_date_time').datetimepicker({
        format: 'Y-m-d H:i',
        formatTime: 'H:i',
        formatDate: 'Y-m-d',
        startDate: new Date(),
        minDate:0,
                    // minTime:0
                });

    $("#poll_style_id").change(function(){
        var id = $(this).val();
        $('#template_id').val('');
        $('.grpOption').attr('disabled','disabled');
        $("#option"+id).removeAttr('disabled')

        var selected = '{{ $polls->template_id }}';
        $("#option"+id).find("option[data-value='" + selected + "']").prop("selected", true);

    }); 
    $("#interest_category_id").change(function(){
        var id = $(this).val();
        if(id!="") {
            $html = "";
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: '{{ route("admin.subcategory.getSubcategories") }}',
                type: 'get',
                data : {id : id},
                async:false,
                beforeSend: function(){
                    $(document).find('.ajax-loader').addClass('active');
                },
                success: function(result){
                    $(document).find('.ajax-loader').removeClass('active');
                    for (var i = 0; i < result.length; i++) {
                        $html +='<option value="'+result[i].id+'">'+result[i].interest_sub_category_name+'</option>';
                    }
                    $("#interest_sub_category_id").html($html);

                },
                complete:function(){
                    $(document).find('.ajax-loader').removeClass('active');
                }
            });
        }
    });

    $("#forever_status").change(function(){
        if($(this).val() == 1)
            $("#set_duration_id").removeClass('d-none');
        else 
            $("#set_duration_id").addClass('d-none');
    });
    $("#poll_type_id").change(function(){
        var  id = $(this).val();
        var Optionsenable = ["1","5"];
        $("#no_of_option > option").each(function(index, el) {
            $(this).prop("disabled", true);

            if(id ==1 || id== 5){
                if($(this).val() >=2) {
                    $(this).prop("disabled", false);
                    $("#no_of_option").val(no_of_option)
                }

            }

            if(id ==2 || id== 3){
                if($(this).val() ==2){
                    $(this).prop("disabled", false);
                    $("#no_of_option").val(no_of_option)
                }

            }
            if(id ==4 || id== 6){
                if($(this).val() ==1){
                    $(this).prop("disabled", false);
                    $("#no_of_option").val(1)
                }

            }

            if(Optionsenable.includes($(this).val())){
            }
        });
        elementHideShow();
    });


    // Option change 
    $("#no_of_option").change(function(){
        elementHideShow();
    });

    $("#poll_style_id").change(function(event) {
        elementHideShow();
    });
    $("#poll_style_id").trigger('change');
    $("#interest_category_id").trigger('change');
    $("#poll_type_id").trigger('change');
    $("#interest_sub_category_id").val('{{$polls->interest_sub_category_id}}');

    function elementHideShow() {
        var poll_style_id = $("#poll_style_id").val();
        var no_of_option = $("#no_of_option").val();
        $(".answer_conainter").addClass('d-none');

        if(poll_style_id == 1){
            $(".upload_label,.poll-upload-area").addClass('d-none');
        } else {
            $(".upload_label,.poll-upload-area").removeClass('d-none');
        }
        for (var i = 1; i <=no_of_option; i++) {
            $("#answer_conainter_"+i).removeClass('d-none')
            $("#answer_conainter_"+i).find(".upload_label,.poll-upload-area").removeClass('d-none');   
        }
    }   
</script>


@endpush


