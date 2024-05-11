<!DOCTYPE html>
<html>
<head>
<title>Email Verification</title>

<style>
    body {
        margin: auto;
        width: 640px; 
        padding: 50px;
        font-family: 'Lexend Deca', sans-serif; 
        color: #2E475D;    
    }

    .button {
        background-color: #4CAF50; /* Green */
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
    }
    .button_logout {
        background-color: red; /* Green */
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
    }
</style>
</head>
<body>

<!-- <h1>{{ $message ?? '' }}</h1> -->
@if(Session::has('success_message'))
    <p class="alert alert-success">
    {{ Session::get('success_message') }}
    </p>
    {{ Session::forget('success_message') }}
@endif
<a href="{{ url('/send_verification_email') }}" class="button">Verify Email</a>
<a href="{{ url('/logout') }}" class="button_logout">Logout</a>

</body>
</html>