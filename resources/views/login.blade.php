@extends('master')

@section('content')

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 mb-4 awesome">RESTAURANT POS</h1>
                                        
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
                                    <form class="user" action="{{ url('/login') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="email" name="email" autocomplete="off"
                                                placeholder="Enter Email Address...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="password" name="password" placeholder="Password" autocomplete="off">
                                        </div>
                                        <button class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                        <div class="text-right mt-2">
                                            <a class="small" href="{{ url('/forgot_password') }}">Forgot Password?</a>
                                        </div>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="btn btn-success" href="{{ url('/register') }}">Create New Account</a>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection