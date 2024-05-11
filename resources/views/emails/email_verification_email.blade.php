<h1>Email Verification Mail</h1>
  
Please verify your email with bellow link: 
<a href="{{ route('user.verify', ['token' => $token,'user_id' => $user_id]) }}">Verify Email</a>