<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reset Password - {{ $brand }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color:#f9f9f9; padding:20px;">
    <div style="max-width:600px; background:#fff; margin:auto; border-radius:8px; padding:30px;">
        <h2 style="color:#333;">Hello {{ $user_name }},</h2>
        <p>You recently requested to reset your password for your <strong>{{ $brand }}</strong> account.</p>
        <p>Click the button below to reset it:</p>
        <p style="text-align:center;">
            <a href="{{ $reset_link }}" 
               style="display:inline-block; padding:10px 20px; color:#fff; background-color:#000; text-decoration:none; border-radius:5px;">
               Reset Password
            </a>
        </p>
        <p>If you didn’t request this, you can safely ignore this email.</p>
        <br>
        <p>— The {{ $brand }} Team</p>
        <small>If you need help, contact us at <a href="mailto:{{ $support_email }}">{{ $support_email }}</a></small>
    </div>
</body>
</html>
