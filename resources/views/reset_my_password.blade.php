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
                                <h1 class="h4 text-gray-900 mb-4">Reset My Password</h1>
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
                            <form class="user" action="{{ url('/resetting_password/'.$email.'/'.$code) }}" method="POST">
                                @csrf
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
                                <button class="btn btn-primary btn-user btn-block" id="submit_btn">
                                    Update
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="{{ url('/') }}"> << Back to Login</a>
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
    
    </script>

@endsection