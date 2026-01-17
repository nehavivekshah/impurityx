<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Delivery Completed - ImpurityX</title>
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
        Delivery Completed – Awaiting Buyer’s Acceptance
    </div>

    <p>Dear {{ $buyer_name }},</p>

    <p>You have successfully marked the delivery for <strong>Order ID #{{ $order_id }}</strong> as completed.</p>

    <div class="order-summary">
        <p><strong>Delivery Details:</strong></p>
        <p>Order ID: <strong>{{ $order_id }}</strong></p>
        <p>Seller Name: <strong>{{ $seller_name }}</strong></p>
        <p>Delivery Completed On: <strong>{{ $completed_date }}</strong></p>
        <p>Courier: <strong>{{ $courier_name }}</strong></p>
        <p>Tracking ID: <strong>{{ $tracking_id }}</strong></p>
    </div>

    <p>The buyer has been notified and will now review the delivery to confirm acceptance. Kindly note that the order will only be considered fully closed once the buyer accepts the delivery.</p>

    <p>We appreciate your timely efforts and request your patience while the buyer completes this last step.</p>

    <p>For any questions or concerns, feel free to contact our support team at <a href="mailto:support@impurityx.com">support@impurityx.com</a> or call <strong>022 4450 7815</strong>.</p>

    <p>Best Regards,<br>
    <strong>Team ImpurityX</strong></p>

    <div class="footer">
        &copy; {{ date('Y') }} ImpurityX. All rights reserved.
    </div>
</div>
</body>
</html>
