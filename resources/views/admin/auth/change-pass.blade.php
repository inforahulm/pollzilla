@extends('layouts.master')

@section('page_title', 'Change Password')

@section('page_head')
<div class="float-right page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
        <li class="breadcrumb-item active">Change Password</li>
    </ol>
</div>
@endsection

@section('content')
        
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card">
                <div class="card-body">
                    @include('common.flash')
                    <form class="" action="{{ route('admin.update-password') }}" method="post">

                    @csrf
                    @method('PATCH')

                        <div class="form-group">
                            <label>Old Password</label>
                            <input type="password" name="old_pass" class="form-control" required placeholder="Enter old password"/>
                        </div>

                        <div class="form-group">
                            <label>New Password</label>
                            <div>
                                <input type="password" name="new_pass" id="new_pass" class="form-control" required  placeholder="Enter new password"/>
                            </div>
                            <div class="m-t-10">
                                <input type="password" name="new_pass_confirmation" class="form-control" required
                                        data-parsley-equalto="#new_pass"
                                        placeholder="Re-Type Password"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                    Submit
                                </button>
                                <button type="reset" class="btn btn-secondary waves-effect m-l-5">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>                        
        </div>
    </div>
                        
@endsection