<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your Selected Offer Has Been Approved – Thank You for Choosing ImpurityX</title>
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
            Your Selected Offer Has Been Approved – Thank You for Choosing ImpurityX
        </div>

        <p>Dear {{ $buyer_name }},</p>

        <p>We are pleased to inform you that your selected offer for order 
            <strong>#{{ $order_id }}</strong> has been approved by our team.</p>

        <p><strong>Supplier Details:</strong></p>
        <ul>
            <li><strong>Supplier Name:</strong> {{ $seller_company }}</li>
            <li><strong>Contact Person:</strong> {{ $seller_name }}</li>
            <li><strong>Email:</strong> <a href="mailto:{{ $seller_email }}">{{ $seller_email }}</a></li>
            <li><strong>Phone:</strong> {{ $seller_phone }}</li>
            <li><strong>Address:</strong> {{ $seller_address }}</li>
        </ul>

        <p>Thank you for trusting ImpurityX to facilitate your product sourcing needs. Your order is now being processed, and we will keep you updated on the progress and delivery schedule.</p>

        <p>If you have any questions or require further assistance, please do not hesitate to reach out to us at 
            <a href="mailto:support@impurityx.com">support@impurityx.com</a> or call us at <strong>022 4450 7815</strong>.
        </p>

        <p>We appreciate your business and look forward to serving you again.</p>

        <p>Best regards,<br>
        <strong>Team ImpurityX</strong></p>

        <div class="footer">
            &copy; {{ date('Y') }} ImpurityX. All rights reserved.
        </div>
    </div>
</body>
</html>
