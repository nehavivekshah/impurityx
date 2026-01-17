<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your Order is Now Live for Offers on ImpurityX</title>
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
            Your Order is Now Live for Offers on ImpurityX
        </div>

        <p>Dear <?php echo e($buyer_name); ?>,</p>

        <p>We’re pleased to inform you that your order <strong>#<?php echo e($order_id); ?></strong> has been successfully activated and is now live for quotes on ImpurityX.</p>

        <div class="order-summary">
            <p><strong>Order Summary:</strong></p>
            <p>Order ID: <strong><?php echo e($order_id); ?></strong></p>
            <p>Product/Service: <strong><?php echo e($product_name); ?></strong></p>
            <p>Date Activated: <strong><?php echo e($activated_date); ?></strong> till <strong><?php echo e($expiry_date); ?></strong></p>
        </div>

        <p>If you have any questions or need assistance, feel free to contact our support team at <a href="mailto:support@impurityx.com">support@impurityx.com</a> or call us at <strong>022 4450 7815</strong> during normal business hours.</p>

        <p>Thank you for choosing ImpurityX. We look forward to helping you find the best value for your needs.</p>

        <p>Warm regards,<br>
        <strong>ImpurityX Team</strong></p>

        <div class="footer">
            &copy; <?php echo e(date('Y')); ?> ImpurityX. All rights reserved.
        </div>
    </div>
</body>
</html>
<?php /**PATH /home/u321815713/domains/impurityx.com/public_html/resources/views/emails/order_activated.blade.php ENDPATH**/ ?>