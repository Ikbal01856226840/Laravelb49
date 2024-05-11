<?php use Illuminate\Support\Facades\Session; ?>

@extends('master')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">New User</h1>
    

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"></h6>
        </div>
        <div class="card-body">
            <form action="/save_new_user" method="POST">
                @csrf
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <input type="text" class="form-control form-control-user" name="name"
                            required="required" placeholder="User Name">
                        <span>* User Name</span>
                    </div>
                    <div class="col-sm-6">
                        <input type="email" class="form-control form-control-user" name="email" id="email_address"
                            required="required" placeholder="Email Address" onblur="checkEmailAddressAvailability()">
                        <span>* Email</span>
                        <p style="color: red; display: none;" id="email_emessage">Email Address Already Exist!</p>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <input type="number" class="form-control form-control-user" name="allow_sub_accounts"
                            required="required" placeholder="Allow Number of Sub-Accounts">
                        <span>* Allow Number of Sub-Accounts</span>
                    </div>
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <select class="form-control" name="status" required="required">
                            <option value="">Select Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        <span>* Status</span>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <input type="text" class="form-control" id="service_charge" name="service_charge" required="required" placeholder="Service Charge" />
                        <span>* Service Charge</span>
                    </div>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" id="account_valid_till" name="account_valid_till" required="required" />
                        <span>* Valid Till</span>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <input type="text" class="form-control" id="mobile" name="mobile" required="required" placeholder="Mobile Number" />
                        <span>* Mobile Number</span>
                    </div>
                    <div class="col-sm-6">
                        <button class="btn btn-success">SAVE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

<script type="text/javascript">
    
        function checkEmailAddressAvailability(){
            var email = $("#email_address").val();

            if(email_address != ''){
                $.ajax({
                    type:'POST',
                    url:"/user_availability",
                    data:{"_token": "{{ csrf_token() }}", email: email},
                    success:function(data){
                        if(data.length > 0){
                            $("#email_emessage").css('display', 'block');
                            $("#email_address").val('');
                            $("#submit_btn").attr('disabled', 'disabled');
                        }else{
                            $("#email_emessage").css('display', 'none');
                            $("#submit_btn").attr('disabled', false);

                            $("#confirm_password").blur();
                        }
                    }
                });
            }
        }

    </script>

@endsection