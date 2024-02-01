<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            text-align: center;
            margin: 20px;
        }

        .container {
            background-color: #fff;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        h1 {
            color: #007bff;
            margin-bottom: 30px;
        }

        .message {
            font-size: 18px;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .code {
            font-size: 28px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 30px;
        }

        .link {
            display: inline-block;
            padding: 15px 30px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .link:hover {
            background-color: #0056b3;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Password Reset Request</h1>
        <p class="message">Hi User,</p>
        <p class="message">We received a request to reset your Facebook password.</p>
        <p class="message">To proceed, enter the following password reset code:</p>
        <p class="code">{{ $body }}</p>


        <p class="message">Didn't request this change?</p>
        <p class="message">If you didn't request a new password, please ignore this email.</p>

        <div class="footer">
            <p>The UpProg Team</p>
            <p>© UpProg. inodev Platforms</p>
        </div>
    </div>
</body>
</html>
