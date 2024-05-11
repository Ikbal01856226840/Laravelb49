@extends('master')

@section('content')
    
    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create Account!</h1>
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
                            </div>
                            <form class="user" action="{{ url('/registration') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="exampleFirstName"
                                        required="required" name="user_name" placeholder="User Name">
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="email_address"
                                        required="required" onblur="checkEmailAddressAvailability()" name="email" placeholder="Email Address">
                                        <span style="color: red; display: none;" id="email_emessage">Email Address Already Exist!</span>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="mobile"
                                        required="required" name="mobile" placeholder="Your Mobile Number">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user" required="required"
                                            name="password" id="password" placeholder="Password" onblur="checkPasswordValidity();">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user" required="required"
                                            id="confirm_password" placeholder="Confirm Password" onblur="checkPasswordValidity();">
                                    </div>
                                    <span style="color: red; display: none;" id="password_emessage">Password Mismatch!</span>
                                </div>
                                <button class="btn btn-primary btn-user btn-block" id="submit_btn" disabled="disabled">
                                    Register Account
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="{{ url('/') }}">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script type="text/javascript">
    
        function checkPasswordValidity(){
            var password = $("#password").val();
            var confirm_password = $("#confirm_password").val();

            if(password == ''){
                $("#confirm_password").val('');
                $("#submit_btn").attr('disabled', 'disabled');
            }else{
                if(password == confirm_password){
                    $("#password_emessage").css('display', 'none');
                    $("#submit_btn").attr('disabled', false);
                }else{
                    $("#password_emessage").css('display', 'block');
                    $("#confirm_password").val('');
                    $("#submit_btn").attr('disabled', 'disabled');
                }
            }

        }

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