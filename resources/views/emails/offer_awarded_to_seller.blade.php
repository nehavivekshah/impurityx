<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Offer Awarded Notification</title>
</head>
<body>
    <p>Dear {{ $seller_name }},</p>

    <p>
        We are pleased to inform you that the buyer has selected your offer for order #{{ $order_id }} 
        on <strong>ImpurityX</strong> and the order has now been awarded to you.
    </p>

    <p>Below are the details of the customer to help you proceed with the order fulfillment:</p>

    <ul>
        <li><strong>Buyer Name:</strong> {{ $buyer_name }}</li>
        <li><strong>Contact Person:</strong> {{ $contact_name }}</li>
        <li><strong>Email:</strong> {{ $buyer_email }}</li>
        <li><strong>Phone:</strong> {{ $buyer_phone }}</li>
        <li><strong>Delivery Location:</strong> {{ $delivery_location }}</li>
    </ul>

    <p>
        Please reach out to the buyer promptly to confirm order details and next steps.  
        If you need any assistance, feel free to contact us at <a href="mailto:support@impurityx.com">support@impurityx.com</a> 
        or call us at 022 4450 7815.
    </p>

    <p>Thank you for your continued partnership with ImpurityX.</p>

    <p>Best regards,<br>Team ImpurityX</p>
</body>
</html>
