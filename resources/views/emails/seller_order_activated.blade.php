<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Order Available – Submit Your Offer on ImpurityX</title>
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
            New Order Available – Submit Your Offer on ImpurityX
        </div>

        <p>Dear {{ $seller_name }},</p>

        <p>A new buyer order for <strong>{{ $chemical_name }}</strong> has just been activated on ImpurityX and it's now open for offers.</p>

        <p>You are invited to review the order details and submit your best offer to fulfill the buyer’s requirement. This is a great opportunity to connect with a verified buyer and expand your business.</p>

        <div class="order-summary">
            <p><strong>Order Details:</strong></p>
            <p>Order ID: <strong>{{ $order_id }}</strong></p>
            <p>SKU: <strong>{{ $sku }}</strong></p>
            <p>CAS NO.: <strong>{{ $cas_no }}</strong></p>
            <p>Chemical Name: <strong>{{ $chemical_name }}</strong></p>
            <p>Quantity Required: <strong>{{ $quantity }} {{ $uom }}</strong></p>
            <p>Purity Specification: <strong>{{ $purity_spec }}%</strong></p>
            <p>Potency Specification: <strong>{{ $potency_spec }}%</strong></p>
            <p>Delivery Location: <strong>{{ $delivery_location }}</strong></p>
            <p>Offer Submission Deadline: <strong>{{ $offer_deadline }}</strong></p>
        </div>

        <p>If you need any assistance, our support team is here to help: <a href="mailto:support@impurityx.com">support@impurityx.com</a></p>

        <p>Thank you for being a valued supplier on ImpurityX.</p>

        <p>Best regards,<br>
        <strong>Team ImpurityX</strong></p>

        <div class="footer">
            &copy; {{ date('Y') }} ImpurityX. All rights reserved.
        </div>
    </div>
</body>
</html>
