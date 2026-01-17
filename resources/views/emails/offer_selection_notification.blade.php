<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Offer Submission Window Closed – Select the Best Offer</title>
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
            Offer Submission Window Closed – Select the Best Offer
        </div>

        <p>Dear {{ $details['buyer_name'] }},</p>

        <p>The offer submission window for your order <strong>#{{ $details['order_id'] }}</strong> has now closed.</p>

        <p>We’ve received offer(s) from verified supplier(s) eager to fulfill your product requirement.</p>

        <p>Now it's time to review the submitted offers and select the one that best meets your needs in terms of pricing, stability, and delivery timelines.</p>

        <p><strong>Offer Window Ended:</strong> {{ $details['auction_end'] }}</p>

        <p>Thank you for choosing ImpurityX — your reliable partner for sourcing high-quality products with confidence and transparency.</p>

        <p>Best regards,<br>
        <strong>Team ImpurityX</strong><br>
        📩 <a href="mailto:support@impurityx.com">support@impurityx.com</a></p>

        <div class="footer">
            &copy; {{ date('Y') }} ImpurityX. All rights reserved.
        </div>
    </div>
</body>
</html>
