<?php use Illuminate\Support\Facades\Session; ?>

@extends('master')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Edit Registration Request</h1>
    

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"></h6>
        </div>
        <div class="card-body">
            <form action="{{ url('/update_registration_info/'.$user_info->id) }}" method="POST">
                @csrf
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <input type="text" class="form-control form-control-user" name="name"
                            value="{{ $user_info->name }}" placeholder="User Name" readonly="readonly" required="required">
                            <span>* User Name</span>
                    </div>
                    <div class="col-sm-6">
                        <input type="email" class="form-control form-control-user" name="email"
                            value="{{ $user_info->email }}" placeholder="Email Address" readonly="readonly" required="required">
                            <span>* Email Address</span>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <input type="number" class="form-control form-control-user" name="allow_sub_accounts"
                            value="{{ $user_info->allow_sub_accounts }}" placeholder="Allow Number of Sub-Accounts" required="required">
                            <span>* Allow Sub-Account</span>
                    </div>
                    <div class="col-sm-6">
                        <select class="form-control" name="status" required="required">
                            <option value="">Select Status</option>
                            <option value="1" <?php echo ($user_info->status == 1 ? "selected='selected'" : '');?>>Active</option>
                            <option value="0" <?php echo ($user_info->status == 0 ? "selected='selected'" : '');?>>Inactive</option>
                        </select>
                        <span>* Status</span>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <select class="form-control" name="registration_status" required="required">
                            <option value="">Registration Status</option>
                            <option value="0" <?php echo ($user_info->reg_approval_status == 0 ? "selected='selected'" : '');?>>Deny</option>
                            <option value="1" <?php echo ($user_info->reg_approval_status == 1 ? "selected='selected'" : '');?>>Approve</option>
                            <option value="2" <?php echo ($user_info->reg_approval_status == 2 ? "selected='selected'" : '');?>>Pending</option>
                        </select>
                        <span>* Registration Status</span>
                    </div>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" id="account_valid_till" name="account_valid_till" required="required" />
                        <span>* Valid Till</span>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <input type="text" class="form-control" id="service_charge" name="service_charge" required="required" />
                        <span>* Service Charge</span>
                    </div>
                    <div class="col-sm-6">
                        <button class="btn btn-success">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

    <script>
        $('#datepicker').datepicker({
            uiLibrary: 'bootstrap'
        });
    </script>

@endsection