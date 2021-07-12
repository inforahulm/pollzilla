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
                @include('common.flash')
                <h4 class="mt-0 header-title">Update a Poll</h4>
                <form action="{{ route('admin.poll.update') }}" method="post" >
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
                                <div class="col-md-6" id="poll_style_id_div">
                                    <div class="form-group">
                                        <label>Select Poll Style</label>
                                        <select name="poll_style_id" id="poll_style_id" class="form-control">
                                            <option value="1" {{ $polls->poll_style_id == 1 ? 'selected':'' }}>Text</option>
                                            <option value="2" {{ $polls->poll_style_id == 2 ? 'selected':'' }}>Image</option>
                                            <option value="3" {{ $polls->poll_style_id == 3 ? 'selected':'' }}>Music</option>
                                            <option value="4" {{ $polls->poll_style_id == 4 ? 'selected':'' }}>Video</option>
                                            <option value="0" {{ $polls->poll_style_id == 0 ? 'selected':'' }}>Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 d-none" id="poll_style_id_div_other">
                                    <div class="form-group">
                                        <label>Select Sub Poll Style</label>
                                        <select name="poll_style_id_other" id="poll_style_id_other" class="form-control">
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

                            <div class="row">
                                <div class="col-xl-3 col-lg-4 col-md-6 answer_conainter" id="answer_conainter_1">
                                    <div class="form-group">
                                        <label class="upload_label">Answer 1</label>
                                        <div class="poll-ans-row">
                                            <div class="poll-upload-area d-img poll-upload-img" data-rel="2">
                                                <div class="poll-upload-viewedit">
                                                    <a href="javascript:;" class="editBtn"><i class="fa fa-pencil"></i><input type="file" class="form-control answer-img" data-id="1">
                                                        <input type="hidden" name="poll_source_answer[]" value="{{ !empty($PollAnswer[0]->poll_source_answer) ? ($PollAnswer[0]->is_link== 0 ? $PollAnswer[0]->getRawOriginal('poll_source_answer') : $PollAnswer[0]->poll_source_answer) :'' }}" id="poll_source_answer_1">
                                                        <input type="hidden" name="video_thumb[]" value="{{ !empty($PollAnswer[0]->video_thumb) ? $PollAnswer[0]->video_thumb :''  }}" id="video_thumb_answer_1">
                                                        <input type="hidden" name="answer_index[]" value="{{ $PollAnswer[0]->answer_index ?? 0}}" >
                                                    </a>
                                                </div>
                                                <a href="javascript:;" class="d-viewbtn imgpopup" >
                                                    <img src="{{ $PollAnswer[0]->poll_source_answer ?? asset('assets/images/imgview-bg.jpg') }}" id="answer_img_1" class="img-fluid" alt="">
                                                    <i class="v-play-icon"><i class="ion-search"></i></i>
                                                </a>
                                            </div>
                                            <div class="poll-upload-area d-img poll-upload-audio" data-rel="3">
                                                <div class="poll-upload-viewedit">
                                                    <a href="javascript:;" class="editBtn"><i class="fa fa-pencil"></i><input type="file" class="form-control answer-music" data-id="1" ></a>
                                                </div>
                                                <audio id="audioplayer1" class="audiomp3" controls>
                                                    <source src="{{ $PollAnswer[0]->poll_source_answer ?? 'https://cdn.plyr.io/static/demo/Kishi_Bashi_-_It_All_Began_With_a_Burst.mp3'}}" >
                                                    </audio>
                                                </div>
                                                <div class="poll-upload-area d-img poll-upload-video" data-rel="4">
                                                    <div class="uv-thumbnail">
                                                        <img src="{{ !empty($PollAnswer[0]->video_thumb) ? $PollAnswer[0]->video_thumb : asset('assets/images/bg-1_.png') }}" class="img-fluid" alt="">
                                                        <div class="uploadvideobtn">
                                                            <ul>
                                                                <li><a href="javascript:;" class="videopopup" data-id="1"><i class="fa fa-play" ></i></a></li>
                                                                <li><a href="javascript:;" data-id="1" class="editVideoPopup"><i class="fa fa-pencil" ></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control mt-2" placeholder="Title 1" value="{{ $PollAnswer[0]->poll_text_answer ?? '' }}" name="poll_text_answer[]" >
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-md-6 answer_conainter" id="answer_conainter_2">
                                        <div class="form-group">
                                            <label class="upload_label">Answer 2</label>
                                            <div class="poll-ans-row">
                                                <div class="poll-upload-area d-img poll-upload-img" data-rel="2">
                                                    <div class="poll-upload-viewedit">
                                                        <a href="javascript:;" class="editBtn"><i class="fa fa-pencil"></i><input type="file" class="form-control answer-img" data-id="2" ></a> 
                                                        <input type="hidden" name="poll_source_answer[]" value="{{ !empty($PollAnswer[1]->poll_source_answer) ? ($PollAnswer[1]->is_link== 0 ? $PollAnswer[1]->getRawOriginal('poll_source_answer') : $PollAnswer[1]->poll_source_answer) :'' }}" id="poll_source_answer_2">
                                                        <input type="hidden" name="video_thumb[]" value="{{ !empty($PollAnswer[1]->video_thumb) ? $PollAnswer[1]->video_thumb :''  }}" id="video_thumb_answer_2">
                                                        <input type="hidden" name="answer_index[]" value="{{ $PollAnswer[1]->answer_index ?? 0}}" >
                                                    </div>
                                                    <a href="javascript:;" class="d-viewbtn imgpopup" >
                                                        <img src="{{ $PollAnswer[1]->poll_source_answer ?? asset('assets/images/imgview-bg.jpg') }}" id="answer_img_2" class="img-fluid" alt="">
                                                        <i class="v-play-icon"><i class="ion-search"></i></i>
                                                    </a>
                                                </div>
                                                <div class="poll-upload-area d-img poll-upload-audio" data-rel="3">
                                                    <div class="poll-upload-viewedit">
                                                        <a href="javascript:;" class="editBtn" ><i class="fa fa-pencil"></i><input type="file" class="form-control answer-music" data-id="2" ></a>
                                                    </div>
                                                    <audio id="audioplayer2" class="audiomp3" controls>
                                                        <source src="{{ $PollAnswer[1]->poll_source_answer ?? 'https://cdn.plyr.io/static/demo/Kishi_Bashi_-_It_All_Began_With_a_Burst.mp3'}}" >
                                                        </audio>
                                                    </div>
                                                    <div class="poll-upload-area d-img poll-upload-video" data-rel="4">
                                                        <div class="uv-thumbnail">
                                                           <img src="{{ !empty($PollAnswer[1]->video_thumb) ? $PollAnswer[1]->video_thumb : asset('assets/images/bg-1_.png') }}" class="img-fluid" alt="">
                                                           <div class="uploadvideobtn">
                                                            <ul>
                                                                <li><a href="javascript:;" class="videopopup" data-id="2"><i class="fa fa-play" ></i></a></li>
                                                                <li><a href="javascript:;" data-id="2" class="editVideoPopup"><i class="fa fa-pencil" ></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control mt-2" placeholder="Title 2" value="{{ $PollAnswer[1]->poll_text_answer ?? '' }}" name="poll_text_answer[]" >
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-md-6 answer_conainter" id="answer_conainter_3">
                                        <div class="form-group">
                                            <label class="upload_label" data-id="3">Answer 3</label>
                                            <div class="poll-ans-row">
                                                <div class="poll-upload-area d-img poll-upload-img" data-rel="2">
                                                    <div class="poll-upload-viewedit">
                                                        <a href="javascript:;" class="editBtn"><i class="fa fa-pencil"></i><input type="file" class="form-control answer-img" data-id="3" ></a>
                                                        <input type="hidden" name="poll_source_answer[]" value="{{ !empty($PollAnswer[2]->poll_source_answer) ? ($PollAnswer[2]->is_link== 0 ? $PollAnswer[2]->getRawOriginal('poll_source_answer') : $PollAnswer[2]->poll_source_answer) :'' }}" id="poll_source_answer_3">
                                                        <input type="hidden" name="video_thumb[]" value="{{ !empty($PollAnswer[2]->video_thumb) ? $PollAnswer[2]->video_thumb :''  }}" id="video_thumb_answer_3">
                                                        <input type="hidden" name="answer_index[]" value="{{ $PollAnswer[2]->answer_index ?? 0}}" >
                                                    </div>
                                                    <a href="javascript:;" class="d-viewbtn imgpopup" >
                                                        <img src="{{ $PollAnswer[2]->poll_source_answer ?? asset('assets/images/imgview-bg.jpg') }}" class="img-fluid" id="answer_img_3" alt="">
                                                        <i class="v-play-icon"><i class="ion-search"></i></i>
                                                    </a>
                                                </div>
                                                <div class="poll-upload-area d-img poll-upload-audio" data-rel="3">
                                                    <div class="poll-upload-viewedit">
                                                        <a href="javascript:;" class="editBtn"><i class="fa fa-pencil"></i><input type="file" class="form-control answer-music" data-id="3" ></a>
                                                    </div>
                                                    <audio id="audioplayer3" class="audiomp3" controls>
                                                        <source src="{{ $PollAnswer[2]->poll_source_answer ?? 'https://cdn.plyr.io/static/demo/Kishi_Bashi_-_It_All_Began_With_a_Burst.mp3'}}" >
                                                        </audio>
                                                    </div>
                                                    <div class="poll-upload-area d-img poll-upload-video" data-rel="4">
                                                        <div class="uv-thumbnail">
                                                          <img src="{{ !empty($PollAnswer[2]->video_thumb) ? $PollAnswer[2]->video_thumb : asset('assets/images/bg-1_.png') }}" class="img-fluid" alt="">
                                                          <div class="uploadvideobtn">
                                                            <ul>
                                                                <li><a href="javascript:;" class="videopopup" data-id="3"><i class="fa fa-play" ></i></a></li>
                                                                <li><a href="javascript:;" data-id="3" class="editVideoPopup"><i class="fa fa-pencil" ></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control mt-2" placeholder="Title 3" value="{{ $PollAnswer[2]->poll_text_answer ?? '' }}" name="poll_text_answer[]" >
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-md-6 answer_conainter" id="answer_conainter_4">
                                        <div class="form-group">
                                            <label class="upload_label">Answer 4</label>
                                            <div class="poll-ans-row">
                                                <div class="poll-upload-area d-img poll-upload-img" data-rel="2">
                                                    <div class="poll-upload-viewedit">
                                                        <a href="javascript:;" class="editBtn"><i class="fa fa-pencil"></i><input type="file" class="form-control answer-img" data-id="4" ></a>
                                                        <input type="hidden" name="poll_source_answer[]" value="{{ !empty($PollAnswer[3]->poll_source_answer) ? ($PollAnswer[3]->is_link== 0 ? $PollAnswer[3]->getRawOriginal('poll_source_answer') : $PollAnswer[3]->poll_source_answer) :'' }}" id="poll_source_answer_4">
                                                        <input type="hidden" name="video_thumb[]" value="{{ !empty($PollAnswer[3]->video_thumb) ? $PollAnswer[3]->video_thumb :''  }}" id="video_thumb_answer_4">
                                                        <input type="hidden" name="answer_index[]" value="{{ $PollAnswer[3]->answer_index ?? 0}}" >
                                                    </div>
                                                    <a href="javascript:;" class="d-viewbtn imgpopup" >
                                                        <img src="{{ $PollAnswer[3]->poll_source_answer ?? asset('assets/images/imgview-bg.jpg') }}" class="img-fluid" alt="" id="answer_img_4">
                                                        <i class="v-play-icon"><i class="ion-search"></i></i>
                                                    </a>
                                                </div>
                                                <div class="poll-upload-area d-img poll-upload-audio" data-rel="3">
                                                    <div class="poll-upload-viewedit">
                                                        <a href="javascript:;" class="editBtn"><i class="fa fa-pencil"></i><input type="file" class="form-control answer-music" data-id="4" ></a>
                                                    </div>
                                                    <audio id="audioplayer4" class="audiomp3" controls>
                                                        <source src="{{ $PollAnswer[3]->poll_source_answer ?? 'https://cdn.plyr.io/static/demo/Kishi_Bashi_-_It_All_Began_With_a_Burst.mp3'}}" >
                                                        </audio>
                                                    </div>
                                                    <div class="poll-upload-area d-img poll-upload-video" data-rel="4">
                                                        <div class="uv-thumbnail">
                                                           <img src="{{ !empty($PollAnswer[3]->video_thumb) ? $PollAnswer[3]->video_thumb : asset('assets/images/bg-1_.png') }}" class="img-fluid" alt="">
                                                           <div class="uploadvideobtn">
                                                            <ul>
                                                                <li><a href="javascript:;" class="videopopup" data-id="4"><i class="fa fa-play" ></i></a></li>
                                                                <li><a href="javascript:;" data-id="4" class="editVideoPopup"><i class="fa fa-pencil" ></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control mt-2" placeholder="Title 4" value="{{ $PollAnswer[3]->poll_text_answer ?? '' }}" name="poll_text_answer[]" >
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-md-6 answer_conainter" id="answer_conainter_5">
                                        <div class="form-group">
                                            <label class="upload_label">Answer 5</label>
                                            <div class="poll-ans-row">
                                                <div class="poll-upload-area d-img poll-upload-img" data-rel="2">
                                                    <div class="poll-upload-viewedit">
                                                        <a href="javascript:;" class="editBtn"><i class="fa fa-pencil"></i><input type="file" class="form-control answer-img" data-id="5"></a>
                                                        <input type="hidden" name="poll_source_answer[]" value="{{ !empty($PollAnswer[4]->poll_source_answer) ? ($PollAnswer[4]->is_link== 0 ? $PollAnswer[4]->getRawOriginal('poll_source_answer') : $PollAnswer[4]->poll_source_answer) :'' }}" id="poll_source_answer_5">
                                                        <input type="hidden" name="video_thumb[]" value="{{ !empty($PollAnswer[4]->video_thumb) ? $PollAnswer[4]->video_thumb :''  }}" id="video_thumb_answer_5">
                                                        <input type="hidden" name="answer_index[]" value="{{ $PollAnswer[4]->answer_index ?? 0}}" >
                                                    </div>
                                                    <a href="javascript:;" class="d-viewbtn imgpopup" >
                                                        <img src="{{ $PollAnswer[4]->poll_source_answer ?? asset('assets/images/imgview-bg.jpg') }}" class="img-fluid" alt="" id="answer_img_5">
                                                        <i class="v-play-icon"><i class="ion-search"></i></i>
                                                    </a>
                                                </div>
                                                <div class="poll-upload-area d-img poll-upload-audio" data-rel="3">
                                                    <div class="poll-upload-viewedit">
                                                        <a href="javascript:;" class="editBtn"><i class="fa fa-pencil"></i><input type="file" class="form-control answer-music" data-id="5" ></a>
                                                    </div>
                                                    <audio id="audioplayer5" class="audiomp3" controls>
                                                        <source src="{{ $PollAnswer[4]->poll_source_answer ?? 'https://cdn.plyr.io/static/demo/Kishi_Bashi_-_It_All_Began_With_a_Burst.mp3'}}" >
                                                        </audio>
                                                    </div>
                                                    <div class="poll-upload-area d-img poll-upload-video" data-rel="4">
                                                        <div class="uv-thumbnail">
                                                           <img src="{{ !empty($PollAnswer[4]->video_thumb) ? $PollAnswer[4]->video_thumb : asset('assets/images/bg-1_.png') }}" class="img-fluid" alt="">
                                                           <div class="uploadvideobtn">
                                                            <ul>
                                                                <li><a href="javascript:;" class="videopopup" data-id="5"><i class="fa fa-play" ></i></a></li>
                                                                <li><a href="javascript:;" data-id="5" class="editVideoPopup"><i class="fa fa-pencil" ></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control mt-2" placeholder="Title 5" name="poll_text_answer[]"  value="{{ $PollAnswer[4]->poll_text_answer ?? '' }}">
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
                                        <div class="form-group">
                                            <label>Select Color Theme</label>
                                            <select name="color_palette_id" id="color_palette_id" class="form-control">
                                                @foreach ($colorPalette as  $value): 
                                                <option value="{{ $value->id }}" {{ $polls->color_palette_id == $value->id ? 'selected':'' }}>{{ $value->color_palette_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group upload-file-part">
                                            <label>Add Background Image</label>
                                            <div class="choose-file-part mb-3">
                                                <input type="file" class="form-control" id="background">
                                                <input type="hidden" name="background" id="background_hidden" value="{{ $polls->getRawOriginal('background') }}">
                                                <p><i class="ion-upload"></i> Upload File</p>
                                            </div>
                                            <div class="upload-bg-imgview">
                                                <img src="{{ $polls->background ?? asset('assets/images/imgview-bg.jpg') }}" class="img-fluid" alt="" id="upload-bg-imgview">

                                                <a href="javascript:;" class="upload-bg-del {{empty($polls->background) ? 'd-none' :''}}"> <i class="ion-close-round"></i></a>

                                            </div>
                                        </div>
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
                                                <option value="1" {{ $polls->forever_status == 1 ? 'selected':'' }}> Forever</option>
                                                <option value="0" {{ $polls->forever_status == 0 ? 'selected':'' }}>Minutes</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2 d-none" id="set_duration_id">
                                        <div class="form-group">
                                            <label>Set Duration in Minutes</label>
                                            <input type="number" min="1" class="form-control" id="set_duration_value" name="set_duration_value" value="{{!empty($polls->set_duration) ? $polls->set_duration:''}}">
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
                                            <select name="is_secret" id="is_secret" class="form-control">
                                                <option value="1" {{ $polls->is_secret == 1 ? 'selected':'' }}>Yes</option>
                                                <option value="2" {{ $polls->is_secret == 2 ? 'selected':'' }}>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Share</label>
                                            <select name="share_status" id="share_status" class="form-control">
                                                <option value="1" {{ $polls->share_status == 1 ? 'selected':'' }} >Yes</option>
                                                <option value="2" {{ $polls->share_status == 2 ? 'selected':'' }} >No</option>
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
                        @if($Pollcount==0 && $isStartedPoll ==1 )
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <button type="submit" class="btn btn-success">Edit Poll Details</button>
                                <input type="hidden" name="id" value="{{$polls->id}}">
                            </div>
                        </div>
                        @elseif($polls->poll_current_status==1 || $polls->poll_current_status==41)
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <button type="button" class="btn btn-danger" id="btnEndPoll" data-id="{{$polls->id}}">End Poll </button>
                            </div>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="videoModal" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" >
                <div class="modal-body ">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <div class="video-box">
                        <video id="videoPreview" controls class="embed-responsive-item" autoplay></video>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="videoModallink" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="width: auto">
                <div class="modal-body videopopup-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <div class="video-box" id="youtubepreview">
                        <iframe id="Geeks3" width="550" height="350" src= "" frameborder="0" allowfullscreen> </iframe> 
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade " id="imgpopup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body videopopup-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <div class="imgpopup-tag">
                        <img src="{{ asset('assets/images/bg-1.png') }}" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade editTextPopup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">Edit Text</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form action="javascript:;">
                    <div class="modal-body">
                        <div class="poll-edit-text">
                            <div class="form-group">
                                <label>Answer Text</label>
                                <textarea rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success">Save</button> 
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editVideoPopup"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="answer_title_modal"></h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form action="javascript:;">
                    <div class="modal-body">
                        <div class="poll-video">
                            <label>Video Type</label>
                            <div class="video-type-part">
                                <div class="video-type-radio mb-4">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="videotype" id="videolink" value="videolink" checked="">
                                        <label class="form-check-label" for="videolink">Video Link</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="videotype" id="videoupload" value="videoupload">
                                        <label class="form-check-label" for="videoupload">Video Upload</label>
                                    </div>
                                </div>
                                <div class="video-type-content">
                                    <div class="video-type-row videolink active">
                                        <div class="form-group">
                                            <label>Video Link</label>
                                            <input type="text" class="form-control" id="videoupload_text"  placeholder="Video Link" />
                                        </div>
                                    </div>
                                    <div class="video-type-row videoupload">
                                        <div class="form-group">
                                            <label>Video Upload</label>
                                            <input type="file" class="form-control" id="videoupload_video" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="save_video" class="btn btn-success">Save</button> 
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @endsection

    @push('page_scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

    <script>
        $('.poll-upload-text').slimScroll({
            height: '150px'
        });
        Array.from(document.querySelectorAll('.audiomp3')).map(p => new Plyr(p));
        $(".video-type-radio input[type='radio']").change(function(){
            var getval = $(this).val();
            $(".video-type-row").removeClass('active');
            $(".video-type-row."+getval).addClass('active');
        })

        var no_of_option = '{{$polls->no_of_option}}';
        var forever_status = '{{$polls->forever_status}}';
        var media_type = '{{$PollAnswer[0]->media_type}}';
        console.log(media_type);
        $('#launch_date_time').datetimepicker({
            format: 'Y-m-d H:i:s',
            formatTime: 'H:i:s',
            formatDate: 'Y-m-d',
            startDate: new Date(),
            minDate:0
        });

        $("#poll_style_id,#poll_style_id_other").change(function(){
            var id = $(this).val();
            $('#template_id').val('');
            $('.grpOption').attr('disabled','disabled');
            $("#option"+id).removeAttr('disabled')

            var selected = '{{ $polls->template_id }}';
            var idname = $(this).attr('id');
            if(id ==0) {
                $("#poll_style_id_div_other").removeClass('d-none');
            } else {
                if(idname!='poll_style_id_other')
                    $("#poll_style_id_div_other").addClass('d-none');
            }
            console.log(id);
            id = id==0 ? 2:id;
            console.log(id);
            $("#option"+id).find("option[data-value='" + selected + "']").prop("selected", true);

            $('.poll-upload-area').removeClass('active');
            $('[data-rel='+ id + '].poll-upload-area').addClass('active');

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
            if($(this).val() == 0)
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
                        $("#no_of_option").val(2)
                    }

                }

                if(id ==2 || id== 3){
                    if($(this).val() ==2){
                        $(this).prop("disabled", false);
                        $("#no_of_option").val(2)
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
            if(id==1 || id==6 ){
                $('#poll_style_id').children('option[value="0"]').attr('disabled', true);
            } else {
                $('#poll_style_id').children('option[value="0"]').attr('disabled', false);
            }
            elementHideShow();
        });
        setTimeout(function(){
            $("#no_of_option").val(no_of_option).change();
            console.log(forever_status);
            $("#forever_status").val(forever_status).change();
        },1000);

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

        // background   
        $("#background").change(function(){
            var ext = $(this).val().split('.').pop().toLowerCase();
            if($.inArray(ext,['png','jpg','jpeg']) == -1) {
                $(this).val('');
                return alert('invalid Image !');
            }

            uploadsFiles($('#background'),'5',$('#background_hidden'),'upload-bg-imgview');
            $(".upload-bg-del").removeClass('d-none');

        });

        // upload  File Image Answers
        $(".answer-img").change(function(){
            id = $(this).data('id');
            var ext = $(this).val().split('.').pop().toLowerCase();
            if($.inArray(ext,['png','jpg','jpeg']) == -1) {
                $(this).val('');
                return alert('invalid Image !');
            }
            uploadsFiles($(this),'6',$('#poll_source_answer_'+id),'answer_img_'+id);
        });


        // Image  pre view 
        $('.imgpopup').on('click', function (e) {
            $('#imgpopup').find('img').attr('src', $(this).find('img').attr('src'));
            $('#imgpopup').modal('show');
        })

        // Video preview
        $(".videopopup").click(function(event) {
            id = $(this).data('id');
            link = $('#poll_source_answer_'+id).val();

            var regExp = /^(http(s)?:\/\/)?((w){3}.)?youtu(be|.be)?(\.com)?\/.+/gm;
            if (link.match(regExp)) {
                var regExp = /^.*(youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
                var match = link.match(regExp);
                if (match && match[2].length == 11) {
                    $("#youtubepreview").find('iframe').attr('src','https://www.youtube.com/embed/'+match[2]);
                } 
                $("#videoModallink").modal('show');
            } else {
                $link = "{{asset('/storage/uploads/poll')}}/"+link;
                $("#videoPreview").html('<source src="'+$link+'" >');
                $("#videoModal").modal('show');
            }

        });

        // Stop  video on close Yuotube  video Modal
        $('#videoModallink').on('hidden.bs.modal', function (e) {
            $("#youtubepreview").find('iframe').attr('src','');
        });
        $('#videoModal').on('hidden.bs.modal', function (e) {
            $("#videoPreview").html('');
        });
        // upload  Music Answers
        $(".answer-music").change(function(){
            id = $(this).data('id');
            var ext = $(this).val().split('.').pop().toLowerCase();
            if($.inArray(ext,['mp3','acc','m4a','wav']) == -1) {
                $(this).val('');
                return alert('invalid audio !');
            }
            console.log(id);
            uploadsFiles($(this),'1',$('#poll_source_answer_'+id),'audioplayer'+id);
        })

        // upload  Video Answers check file validate or not 
        $("#videoupload_video").change(function(){
            id = $(this).data('id');
            console.log(id);
            var ext = $(this).val().split('.').pop().toLowerCase();
            if($.inArray(ext,['mp4','flv','3gp','mov','avi','wmv','qt']) == -1) {
                $(this).val('');
                return alert('invalid video !');
            }


        })
        // Video  Upload  
        $(".editVideoPopup").click(function(){
            var id = $(this).data('id');
            $("#answer_title_modal").html('Answer '+ id);
            $("#editVideoPopup").find('#videoupload_video').attr('data-id',id)
            $("#editVideoPopup").find('#videoupload_text').attr('data-id',id)

            $("#editVideoPopup").modal('show');
        });

        //upload  Video  
        $("#save_video").click(function(event) {

            uploadType = $('input[name="videotype"]:checked').val();
            var id = $("#videoupload_text").attr('data-id');

            if(uploadType == "videolink") {
                var link =  $("#videoupload_text").val();
                var regExp = /^(http(s)?:\/\/)?((w){3}.)?youtu(be|.be)?(\.com)?\/.+/gm;
                if (!link.match(regExp)) {
                    return alert('Please add valid youtube video link');
                    return false;
                }
                var regExp = /^.*(youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
                var match = link.match(regExp);
                if (match && match[2].length == 11) {
                    $("#answer_conainter_"+id).find(".uv-thumbnail>img").attr('src',"https://img.youtube.com/vi/"+match[2]+"/0.jpg");
                    $("#video_thumb_answer_"+id).val("https://img.youtube.com/vi/"+match[2]+"/0.jpg");
                } 
                $('#poll_source_answer_'+id).val(link)

            } else {
                $('#poll_source_answer_'+id).val('');
                uploadsFiles($("#videoupload_video"),'2',$('#poll_source_answer_'+id),'answer_img_'+id);
            }
            $("#editVideoPopup").modal('hide');
        });

        // Delete Backgoud Image
        $(".upload-bg-del").click(function(event) {
            if(confirm('are to want sure remove background image ?')) {
                $("#background_hidden").val('');
                $(this).addClass('d-none');
                $("#upload-bg-imgview").attr('src', "{{asset('assets/images/imgview-bg.jpg')}}");
            }
        });

        function uploadsFiles(element,fileType,outputElement,srcfile=null) { 

            var formData = new FormData();
            formData.append('file', element.prop('files')[0]);
            formData.append('type', fileType);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url : '{{ route("admin.upload_file") }}',
                type: 'post',
                data :formData,
                contentType: false,
                processData: false,
                success: function(result){
                    if(result) {
                        if(srcfile!=null)
                            $("#"+srcfile).attr('src', result.full_url);
                        outputElement.val(result.file)
                    }
                },
                complete:function(){

                },
                error: function (data) {
                    if(data.status === 422) {
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors.errors, function (key, value) {
                            alert(value)
                        });
                    }
                }
            });
        }
        $("#btnEndPoll").click(function() {
            var this_var = this;
            $(this).attr('disabled', true);
            var id = $(this).attr('data-id');

            swal({
                title: 'Are you sure want to End poll?',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Poll End it!',
                reverseButtons: true
            }).then((result) => {
                if (result) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url : "{{ route('admin.poll.endPoll') }}",
                        type : 'POST',
                        data : {'id' : id},
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


