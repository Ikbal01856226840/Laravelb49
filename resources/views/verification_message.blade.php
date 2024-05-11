<!DOCTYPE html>
<html>
<head>
<title>Portfolio - Account Verification</title>

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
</style>
</head>
<body>

<h1>{{ $message }}</h1>
@if($message !== 'Invalid URL! Please try again.')
    <a href="{{ url('/dashboard') }}" class="button">Go to System</a>
@endif

</body>
</html>