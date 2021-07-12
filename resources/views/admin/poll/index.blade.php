@extends('layouts.master')

@section('page_title', 'Polls')

@section('page_head')
<div class="float-right page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
        <li class="breadcrumb-item active">Polls</li>
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-header">
                <h4 class="mt-0 header-title">Polls List</h4>
            </div>
            <div class="card-body">
                @include('common.flash')

                <!-- ajax form response -->
                <div class="ajax-msg"></div>
                <div class="table-responsive">
                    {!! $dataTable->table(['class' =>  'table table-bordered dt-responsive nowrap']) !!}
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@push('page_scripts')

{!! $dataTable->scripts() !!}

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

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
                    url : "{{ route('admin.poll.change_status') }}",
                    type : 'PATCH',
                    data : {'status' : status, 'id' : category_id},
                    success : function (res) {

                        swal(
                                res.action, //get from controller (block/unblock/cancel)
                                res.msg, // get from controller
                                res.status // get from controller (success/error)
                                )

                        window.LaravelDataTables["polls-table"].draw();
                    }
                });
            } else {
                swal("Cancelled", "Status not changed :)", "error");
                $(this).attr('disabled', false);
            }
        });
    });


    // add category
    $('#category_add_modal').on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget)
        var category_id = button.data('id');
        $(this).find("input").val('');
        $('.error-msg-input').text('');
        $('.invalid-feedback').text('');

        $('#category_id').val(category_id);
    });

    function addCategory(form) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: '{{ route("admin.category.store") }}',
            type: 'post',
            processData: false,
            contentType: false,
            data : new FormData(form),
            success: function(result){
                if(result) {
                    $html = '<div class="alert alert-block alert-'+result.status+'"><button type="button" class="close" data-dismiss="alert">×</button><strong>'+result.message+'</strong></div>';

                    $('.ajax-msg').append($html);
                }
                $('#category_add_modal').modal('hide');

                window.LaravelDataTables["polls-table"].draw();
            },
            complete:function(){
                window.setTimeout(function() {
                    $(".alert").fadeTo(500, 0).slideUp(500, function(){
                        $(this).remove();
                    });
                }, 3000);
            },
            error: function (data) {
                if(data.status === 422) {
                    var errors = $.parseJSON(data.responseText);
                    $.each(errors.errors, function (key, value) {
                        $('#add_category_form').find('input[name='+key+']').parents('.form-group')
                        .find('.error-msg-input').html(value);
                    });
                }
            }
        });
    }

    $("#add_category_form").validate({
        errorClass: 'invalid-feedback animated fadeInDown',
        errorElement: 'div',
        rules: {
            interest_category_name: {
                required: true,
            }
        },
        messages: {
            interest_category_name: {
                required: "category Name field is required.",
            },
        },
        submitHandler: function (form) {
            addCategory(form);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).parents("div.form-control").addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents(".error").removeClass(errorClass).addClass(validClass);
        }
    });


    // edit category
    $('#category_edit_modal').on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget)
        var category_id = button.data('id');
        $(this).find("input").val('');
        $('.error-msg-input').text('');
        $('.invalid-feedback').text('');

        $('#category_id').val(category_id);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: '{{ route("admin.category.edit") }}',
            type: 'get',
            data : {id : category_id},
            success: function(result){

                if(result) {
                    $('#category_edit_modal').find('#category_id').val(result.id);
                    $('#category_edit_modal').find('#interest_category_name').val(result.interest_category_name);

                }
            },
        });
    });

    function editCategory(form) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url : '{{ route("admin.category.update") }}',
            type: 'post',
            processData: false,
            contentType: false,
            data : new FormData(form),
            success: function(result){
                if(result) {
                    $html = '<div class="alert alert-block alert-'+result.status+'"><button type="button" class="close" data-dismiss="alert">×</button><strong>'+result.message+'</strong></div>';

                    $('.ajax-msg').append($html);
                }
                $('#category_edit_modal').modal('hide');

                window.LaravelDataTables["polls-table"].draw();
            },
            complete:function(){
                window.setTimeout(function() {
                    $(".alert").fadeTo(500, 0).slideUp(500, function(){
                        $(this).remove();
                    });
                }, 3000);
            },
            error: function (data) {
                if(data.status === 422) {
                    var errors = $.parseJSON(data.responseText);
                    $.each(errors.errors, function (key, value) {
                        $('#edit_category_form').find('input[name='+key+']').parents('.form-group')
                        .find('.error-msg-input').html(value);
                    });
                }
            }
        });
    }

    $("#edit_category_form").validate({
        errorClass: 'invalid-feedback animated fadeInDown',
        errorElement: 'div',
        rules: {
            name: {
                required: true,
            },
        },
        messages: {
            name: {
                required: "The name field is required.",
            },
            image: {
                required: "The image field is required.",
            },
        },
        submitHandler: function (form) {
            editCategory(form);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).parents("div.form-control").addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents(".error").removeClass(errorClass).addClass(validClass);
        }
    });

    //delete category

    $(document).on('click', '#cat_delete', function() {
        var id = $(this).attr('data-id');

        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            reverseButtons: true
        }).then((result) => {
            if (result) {
                $.ajax({
                    type:'DELETE',
                    url: '{{ route("admin.poll.delete") }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data : {'id' : id},
                    success:function(data) {
                        if (data.result_status) {
                            swal(
                                'Deleted!',
                                'Poll has been deleted.',
                                'success'
                                )

                            window.LaravelDataTables["polls-table"].draw();
                        } else {
                            swal("Cancelled", data.message, "error");
                        }

                    },
                    error: function (data) {
                        console.log(data)
                        swal("Cancelled", "unable to delete please remove first dependence data", "error");
                        
                    }
                });
            } else {
                swal("Cancelled", "Your record is safe :)", "error");
            }
        })
    });
</script>
</script>

@endpush


