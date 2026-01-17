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

        <p>Dear <?php echo e($seller_name); ?>,</p>

        <p>A new buyer order for <strong><?php echo e($chemical_name); ?></strong> has just been activated on ImpurityX and it's now open for offers.</p>

        <p>You are invited to review the order details and submit your best offer to fulfill the buyer’s requirement. This is a great opportunity to connect with a verified buyer and expand your business.</p>

        <div class="order-summary">
            <p><strong>Order Details:</strong></p>
            <p>Order ID: <strong><?php echo e($order_id); ?></strong></p>
            <p>SKU: <strong><?php echo e($sku); ?></strong></p>
            <p>CAS NO.: <strong><?php echo e($cas_no); ?></strong></p>
            <p>Chemical Name: <strong><?php echo e($chemical_name); ?></strong></p>
            <p>Quantity Required: <strong><?php echo e($quantity); ?> <?php echo e($uom); ?></strong></p>
            <p>Purity Specification: <strong><?php echo e($purity_spec); ?>%</strong></p>
            <p>Potency Specification: <strong><?php echo e($potency_spec); ?>%</strong></p>
            <p>Delivery Location: <strong><?php echo e($delivery_location); ?></strong></p>
            <p>Offer Submission Deadline: <strong><?php echo e($offer_deadline); ?></strong></p>
        </div>

        <p>If you need any assistance, our support team is here to help: <a href="mailto:support@impurityx.com">support@impurityx.com</a></p>

        <p>Thank you for being a valued supplier on ImpurityX.</p>

        <p>Best regards,<br>
        <strong>Team ImpurityX</strong></p>

        <div class="footer">
            &copy; <?php echo e(date('Y')); ?> ImpurityX. All rights reserved.
        </div>
    </div>
</body>
</html>
<?php /**PATH /home/u321815713/domains/impurityx.com/public_html/resources/views/emails/seller_order_activated.blade.php ENDPATH**/ ?>