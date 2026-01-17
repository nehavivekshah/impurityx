<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Completed - ImpurityX</title>
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
        Order Completed Successfully on ImpurityX
    </div>

    <p>Dear {{ $buyer_name }},</p>

    <p>Thank you for updating the status of <strong>Order ID #{{ $order_id }}</strong>. We have received confirmation that the order has been marked as completed from your end.</p>

    <div class="order-summary">
        <p><strong>Order Details:</strong></p>
        <p>Order ID: <strong>{{ $order_id }}</strong></p>
        <p>Seller Name: <strong>{{ $seller_name }}</strong></p>
        <p>Completion Date: <strong>{{ $completed_date }}</strong></p>
    </div>

    <p>The buyer will now be notified and prompted to review and acknowledge the completion.</p>

    <p>If there are any issues or updates required, feel free to reach out to our support team at <a href="mailto:support@impurityx.com">support@impurityx.com</a> or call <strong>022 4450 7815</strong>.</p>

    <p>Thank you for your continued professionalism and for being a valued part of the ImpurityX platform.</p>

    <p>Best regards,<br>
    <strong>Team ImpurityX</strong></p>

    <div class="footer">
        &copy; {{ date('Y') }} ImpurityX. All rights reserved.
    </div>
</div>
</body>
</html>
