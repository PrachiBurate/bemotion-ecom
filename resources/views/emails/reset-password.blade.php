<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>

<h2>Password Reset</h2>

<p>Hello,</p>

<p>Click the button below to reset your password.</p>

<p>
    <a href="{{ $link }}"
       style="background:#0d6efd;color:#fff;padding:12px 20px;text-decoration:none;border-radius:5px;">
        Reset Password
    </a>
</p>

<p>If the button doesn't work, copy this URL:</p>

<p>{{ $link }}</p>

</body>
</html>