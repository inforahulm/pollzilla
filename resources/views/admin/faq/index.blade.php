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
                <div class="card-header">
                    <div class="card-header-actions">
                        <a class="btn btn-success float-right" title="Add faq" href="{{ route('admin.faq.create')  }}">Add Faq</a>
                        <button class="btn btn-danger delete_all text-white float-right mx-2" model="faq" table_id="faq_table">
                            Delete All
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @include('common.flash')

                    {!! $dataTable->table(['class' =>  'table table-bordered dt-responsive nowrap']) !!}
                </div>
            </div>
        </div>
    </div>

@endsection

@push('page_scripts')

    {!! $dataTable->scripts() !!}

    <script>
        $('.delete_all').on('click', function(){
            var ids = [];
            var this_var = $(this);
            $(this).attr('disabled', true);

            $('.select_row:checked').each(function(){
                ids.push($(this).val());
            });

            if(ids.length > 0) {
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    reverseButtons: true
                }).then((result) => {

                    if (result) {
                        $.ajax({
                            type:'POST',
                            url: "{{ route('admin.faq.bulk-delete')  }}",
                            data : {'ids' : ids},
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success:function(data) {
                                console.log(data);
                                if(data) {
                                    swal(
                                        'Deleted!',
                                        'Selected Records has been deleted.',
                                        'success'
                                    )
                                    $('input[type="checkbox"]').prop('checked', false);
                                    this_var.attr('disabled', false);
                                    window.LaravelDataTables['faq-table'].draw();
                                }
                            }
                        });
                    } else {
                        swal("Cancelled", "Your record is safe :)", "error");
                        this_var.attr('disabled', false);
                    }
                })
            } else {
                swal("No Record Selected!", "Please Selected record")
                this_var.attr('disabled', false);
            }

        })
    </script>

    <script>

        // change status
        $(document).on('click', '.changeStatus', function() {
            var this_var = this;
            $(this).attr('disabled', true);
            var faq_id = $(this).attr('faq_id');
            var status = $(this).attr('status');
            var msg = "";

            if(status == 0) {
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
                        url : "{{ route('admin.faq.change-status') }}",
                        type : 'PATCH',
                        data : {'status' : status, 'faq_id' : faq_id},
                        success : function (res) {

                            swal(
                                res.action, //get from controller (block/unblock/cancel)
                                res.msg, // get from controller
                                res.status // get from controller (success/error)
                            )

                            window.LaravelDataTables["faq-table"].draw();
                        }
                    });
                } else {
                    swal("Cancelled", "Status not changed :)", "error");
                    $(this).attr('disabled', false);
                }
            });
        });

        //delete category

        $(document).on('click', '#faq_delete', function() {
            var id = $(this).attr('faq_id');

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
                        type:'POST',
                        url: '{{ route("admin.faq.delete") }}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data : {'id' : id},
                        success:function(data) {
                            if (data) {
                                swal(
                                    'Deleted!',
                                    'Faq has been deleted.',
                                    'success'
                                )

                                window.LaravelDataTables["faq-table"].draw();
                            }

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


