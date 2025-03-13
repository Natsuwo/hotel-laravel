<!DOCTYPE html>
<html>

<head>
    <title>Invitation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            background-color: #ffffff;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
        }

        .header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .content p {
            margin: 10px 0;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #888888;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">Invitation</div>
        <div class="content">
            <p>Hi, {{ $invite->name }}</p>

            <p>You are invited to join our platform. Please find the details below:</p>

            <p>
                Invite link: <a href="{{ $url }}">click here</a> or
                {{ $url }}<br>
                Expire: {{ $invite->expired_at }}
            </p>

            <p>We look forward to having you with us.</p>
        </div>
        <div class="footer">
            <p>Best regards,<br>Your Company</p>
        </div>
    </div>
</body>

</html>
