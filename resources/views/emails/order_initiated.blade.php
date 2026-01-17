<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Initiated - ImpurityX</title>
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
        .order-summary {
            background-color: #ecf0f1;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
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
        Order Initiated Successfully on ImpurityX
    </div>

    <p>Dear {{ $buyer_name }},</p>

    <p>We’re pleased to inform you that the order for <strong>Order ID #{{ $order_id }}</strong> has been successfully initiated by you.</p>

    <div class="order-summary">
        <p><strong>Order Details:</strong></p>
        <p>Order ID: <strong>{{ $order_id }}</strong></p>
        <p>Seller Name: <strong>{{ $seller_name }}</strong></p>
        <p>Initiated On: <strong>{{ $initiated_date }}</strong></p>
    </div>

    <p>You may now begin processing and preparing the order as per the agreed terms. Please ensure all details are accurate and that the order is fulfilled within the expected timeline.</p>

    <p>Kindly update the order status and upload documents (if required) as the order progresses, so the buyer remains informed.</p>

    <p>If you have any questions or encounter any issues, feel free to reach us at <a href="mailto:support@impurityx.com">support@impurityx.com</a> or call <strong>022 4450 7815</strong>.</p>

    <p>Thank you for your prompt action and continued support.</p>

    <p>Best regards,<br>
    <strong>Team ImpurityX</strong></p>

    <div class="footer">
        &copy; {{ date('Y') }} ImpurityX. All rights reserved.
    </div>
</div>
</body>
</html>
