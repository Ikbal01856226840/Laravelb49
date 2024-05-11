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
                                <h1 class="h4 text-gray-900 mb-4">Forgot Password?</h1>
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
                            <form class="user" action="{{ url('/send_reset_password_link') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="email_address"
                                        required="required" onblur="checkEmailAddressAvailability()" name="email" placeholder="Email Address">
                                        <span style="color: red; display: none;" id="email_emessage">This Email Address is not allowed to reset password!</span>
                                </div>
                                
                                <button class="btn btn-primary btn-user btn-block" id="submit_btn">
                                    Send Reset Link
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
    
        function checkEmailAddressAvailability(){
            var email = $("#email_address").val();

            if(email_address != ''){
                $.ajax({
                    type:'POST',
                    url:"/forgot_password_accessability",
                    data:{"_token": "{{ csrf_token() }}", email: email},
                    success:function(data){

                        if(data.length == 0){
                            $("#email_emessage").css('display', 'block');
                            $("#email_address").val('');
                        }

                    }
                });
            }
        }
    
    </script>

@endsection