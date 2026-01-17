<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your Order is Now in Progress</title>
</head>
<body style="margin:0;background:#f5f7fa;padding:30px;font-family:Arial,Helvetica,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="max-width:650px;margin:auto;background:#ffffff;border-radius:6px;">
    <tr>
        <td style="padding:25px 30px;text-align:center;border-bottom:1px solid #ddd;">
            <img src="https://impurityx.com/assets/logo.png" alt="ImpurityX" style="max-width:150px;">
            <h2 style="margin-top:15px;font-size:24px;color:#222;">Your Order is in Progress! </h2>
        </td>
    </tr>

    <tr>
        <td style="padding:25px 30px;font-size:15px;color:#444;line-height:26px;">
            
            <p>Hi <strong>{{ $buyer_name }}</strong>,</p>

            <p>
                We're excited to let you know that the seller has begun working on your request, and everything
                is progressing as planned.
            </p>

            <h3 style="margin:20px 0 10px;font-size:18px;color:#111;">Order Summary</h3>

            <ul style="list-style:none;padding:0;line-height:28px;">
                <li><strong>Order ID:</strong> {{ $order_id }}</li>
                <li><strong>CAS No.:</strong> {{ $cas_no }}</li>
                <li><strong>SKU No.:</strong> {{ $sku_no }}</li>
                <li><strong>Product Name:</strong> {{ $product_name }}</li>
                <li><strong>Order Value:</strong> ₹{{ $order_value }}</li>
                <li><strong>Expected Delivery:</strong> {{ $delivery_date }}</li>
            </ul>

            <p>
                You can track the progress or communicate directly with the seller through your ImpurityX dashboard.
                If any additional details are needed, the seller will reach out to you there.
            </p>

            <p>
                Thank you for choosing {{ $brand }} — we’re committed to delivering high-quality results!
            </p>

            <p>
                If you have any questions or need support, feel free to contact us anytime:
                <a href="mailto:{{ $support_email }}">{{ $support_email }}</a>
            </p>

            <br>
            <p style="margin-top:20px;">
                Best Regards,<br>
                <strong>Team {{ $brand }}</strong>
            </p>

        </td>
    </tr>

    <tr>
        <td style="padding:15px;text-align:center;background:#fafafa;border-top:1px solid #eee;font-size:13px;color:#777;">
            Message sent on {{ $initiated_date }}<br>
            Support: <a href="mailto:{{ $support_email }}">{{ $support_email }}</a>
        </td>
    </tr>
</table>

</body>
</html>
