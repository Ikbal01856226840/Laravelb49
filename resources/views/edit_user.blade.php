<?php use Illuminate\Support\Facades\Session; ?>

@extends('master')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Edit User</h1>
    

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"></h6>
        </div>
        <div class="card-body">
            <form action="{{ url('/update_user/'.$user_info->id) }}" method="POST">
                @csrf
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <input type="text" class="form-control form-control-user" name="name"
                            value="{{ $user_info->name }}" placeholder="User Name">
                        <span>* User Name</span>
                    </div>
                    <div class="col-sm-6">
                        <input type="email" class="form-control form-control-user" name="email" readonly="readonly"
                            value="{{ $user_info->email }}" placeholder="Email Address">
                        <span>* Email</span>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <input type="number" class="form-control form-control-user" name="allow_sub_accounts"
                            value="{{ $user_info->allow_sub_accounts }}" placeholder="Allow Number of Sub-Accounts">
                        <span>* Allow Number of Sub-Accounts</span>
                    </div>
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <select class="form-control" name="status">
                            <option value="">Select Status</option>
                            <option value="1" <?php echo ($user_info->status == 1 ? "selected='selected'" : '');?>>Active</option>
                            <option value="0" <?php echo ($user_info->status == 0 ? "selected='selected'" : '');?>>Inactive</option>
                        </select>
                        <span>* Status</span>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <input type="date" class="form-control" id="account_valid_till" name="account_valid_till" required="required" value="{{ $user_info->account_valid_till }}" />
                        <span>* Valid Till</span>
                    </div>
                    <div class="col-sm-6">
                        <input type="number" class="form-control form-control-user" name="service_charge"
                            value="{{ $user_info->service_charge }}" placeholder="Service Charge">
                        <span>* Service Charge</span>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <button class="btn btn-success">Update</button>
                        <a class="btn btn-primary" href="{{ url('/reset_password/'.$user_info->id) }}" onclick="return confirm('Are you sure to reset password?');">Reset Password</a>
                    </div>
                    <div class="col-sm-6">
                        
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection