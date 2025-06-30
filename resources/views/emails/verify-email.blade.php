<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Verify Your Email</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .button { 
            display: inline-block; 
            padding: 10px 20px; 
            background-color: #007bff; 
            color: white; 
            text-decoration: none; 
            border-radius: 5px; 
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Verify Your Email Address</h2>
        <p>Hello {{ $user->name }},</p>
        <p>Please click the button below to verify your email address:</p>
        <p>
            <a href="{{ $url }}" class="button">Verify Email Address</a>
        </p>
        <p>If you did not create an account, no further action is required.</p>
        <p>
            Regards,<br>
            {{ config('app.name') }}
        </p>
    </div>
</body>
</html>