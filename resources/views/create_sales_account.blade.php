<?php use Illuminate\Support\Facades\Session; ?>

@extends('master')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Create Sales Account</h1>
    

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                @if(Session::has('flash_message'))
                    <p class="alert alert-danger">
                    {{ Session::get('flash_message') }}
                    </p>
                    {{ Session::forget('flash_message') }}
                @endif
                @if(Session::has('success_message'))
                    <p class="alert alert-success">
                    {{ Session::get('success_message') }}
                    </p>
                    {{ Session::forget('success_message') }}
                @endif
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ url('/save_sales_account') }}" method="POST">
                @csrf
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <input type="text" class="form-control form-control-user" name="name"
                            placeholder="Shop Name" required="required">
                            <span>* Shop Name</span>
                    </div>
                    <div class="col-sm-6">
                        <input type="email" class="form-control form-control-user" name="email" id="email_address"
                            placeholder="Email Address" required="required" onblur="checkEmailAddressAvailability()">
                            <span>* Email Address</span>
                            <p style="color: red; display: none;" id="email_emessage">Email Address Already Exist!</p>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <select class="form-control" name="status" required="required">
                            <option value="">Select Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        <span>* Status</span>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number" />
                        <span> Phone</span>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <input type="text" class="form-control" id="mobile" name="mobile" required="required" placeholder="Enter Phone Number" />
                        <span>* Mobile</span>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="receipt_note" name="receipt_note" required="required" placeholder="Enter receipt note" />
                        <span>* Receipt Note</span>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <textarea class="form-control" name="address" placeholder="Enter shop address"></textarea>
                        <span>* Shop Address</span>
                    </div>
                    <div class="col-sm-6">
                        <input type="number" class="form-control" id="vat_percentage" name="vat_percentage" value="0" required="required" placeholder="Enter VAT percentage" />
                        <span>* VAT Percentage</span>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <input type="text" class="form-control" id="password" name="password" required="required" placeholder="Enter Password" />
                        <span>* Password</span>
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
                    url:"{{ url('/user_availability') }}",
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