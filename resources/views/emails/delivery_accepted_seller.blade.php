<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Delivery Accepted – Order Completed</title>
</head>
<body style="margin:0;background:#f5f7fa;padding:30px;font-family:Arial,Helvetica,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="max-width:650px;margin:auto;background:#ffffff;border-radius:6px;">
        <tr>
            <td style="padding:25px 30px;text-align:center;border-bottom:1px solid #ddd;">
                <img src="https://impurityx.com/assets/logo.png" alt="ImpurityX" style="max-width:150px;">
                <h2 style="margin-top:15px;font-size:24px;color:#222;">Delivery Accepted by Buyer</h2>
            </td>
        </tr>

        <tr>
            <td style="padding:25px 30px;font-size:15px;color:#444;line-height:26px;">
                <p style="margin:0 0 15px;">
                    Dear <strong>{{ $seller_name }}</strong>,
                </p>

                <p>
                    We’re pleased to inform you that the buyer has confirmed acceptance of the delivery for
                    <strong>Order ID: {{ $order_id }}</strong>.
                </p>

                <p>
                    The order is now marked as completed on the platform.
                </p>

                <p>
                    Thank you for your prompt service and for ensuring a smooth delivery process. If you have
                    any further questions or require support, please feel free to reach out to
                    <a href="mailto:{{ $support_email }}">{{ $support_email }}</a>.
                </p>

                <p>
                    We appreciate your continued partnership with <strong>{{ $brand }}</strong>.
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
                Delivered on {{ $completed_date }}<br>
                Need help? Contact: <a href="mailto:{{ $support_email }}">{{ $support_email }}</a>
            </td>
        </tr>
    </table>

</body>
</html>
