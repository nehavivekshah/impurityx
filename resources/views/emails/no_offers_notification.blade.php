<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>We Apologize - No Offers Received for Your Order</title>
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
            color: #c0392b;
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
            We Apologize - No Offers Received for Your Order
        </div>

        <p>Dear {{ $details['buyer_name'] }},</p>

        <p>The offer period for your order <strong>#{{ $details['order_id'] }}</strong> has ended. We regret to inform you that none of the sellers have submitted offers for your requested product.</p>

        <p>We suggest that you reinitiate your requirement once again and keep it active for a longer duration to increase the chances of receiving better offers. Meanwhile, if you find another source for your product, please feel free to let us know.</p>

        <p>If you have any questions, our support team is here to help:<br>
        📩 <a href="mailto:support@impurityx.com">support@impurityx.com</a> | ☎️ 022 4450 7815</p>

        <p>Thank you for using <strong>ImpurityX</strong>.</p>

        <p>Best regards,<br>
        <strong>Team ImpurityX</strong></p>

        <div class="footer">
            &copy; {{ date('Y') }} ImpurityX. All rights reserved.
        </div>
    </div>
</body>
</html>
