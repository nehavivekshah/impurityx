<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Better Offer Available - Update Your Offer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #eee;
            border-radius: 8px;
            background-color: #fafafa;
        }
        .header {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #2c3e50;
        }
        .footer {
            font-size: 12px;
            color: #7f8c8d;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            Better Offer Available - Update Your Offer
        </div>

        <p>Dear {{ $seller_name }},</p>

        <p>There is another seller who has provided a better offer for order number <strong>#{{ $order_id }}</strong>.</p>

        <p>You may want to update your offer. Please note that the offer window will remain active only till <strong>{{ $offer_end_time }}</strong>.</p>

        <p>If you need any assistance, our support team is here to help: 
            <a href="mailto:support@impurityx.com">support@impurityx.com</a>
        </p>

        <p>Best regards,<br>
        <strong>Team ImpurityX</strong></p>

        <div class="footer">
            &copy; {{ date('Y') }} ImpurityX. All rights reserved.
        </div>
    </div>
</body>
</html>
