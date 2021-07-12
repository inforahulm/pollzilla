@extends('layouts.master')

@section('page_title', 'Faq List')

@section('breadcrumb')
    <div class="float-right page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
            <li class="breadcrumb-item active">Faq</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body">
                    @if(isset($faq))
                        <form method="post" action="{{ route('admin.faq.update', $faq->id)  }}">
                        @method('PATCH')
                    @else
                        <form method="post" action="{{ route('admin.faq.store')  }}">
                    @endif
                        @csrf

                            <div class="form-group">
                                <label>Question</label>
                                <input type="text" name="question" class="form-control" placeholder="Enter faq question.." value="{{ old('question',isset($faq) ? $faq->question : '')}}" required/>

                                @if($errors->has('question'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('question')  }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Answer</label>
                                <textarea id="answer" name="answer" class="tinymice">
                                    {{ old('answer',isset($faq) ? $faq->answer : '')}}
                                </textarea>

                                @if($errors->has('answer'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('answer')  }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div>
                                @if(isset($faq))
                                    <input type="hidden" name="faq_id" value="{{$faq->id}}">
                                @endif
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>

                        </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('page_scripts')

    <script>
        $(document).ready(function () {
            console.log($(".tinymice").length);
            if($(".tinymice").length > 0){
                tinymce.init({
                    selector: "textarea",
                    theme: "modern",
                    height:300,
                    plugins: [
                        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                        "save table contextmenu directionality emoticons template paste textcolor"
                    ],
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",


                });
            }
        });
    </script>
@endpush


