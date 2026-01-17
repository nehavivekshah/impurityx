@php
    $brand = $details['brand'] ?? 'Impurity X';
    $name  = $details['user_name'] ?? 'there';
    $otp   = $details['otp'] ?? '------';
    $mins  = (int)($details['expires_minutes'] ?? 10);
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Verify your email address</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin:0;padding:0;background:#f5f7fb;font-family:Arial,Helvetica,sans-serif;color:#2c3e50;">
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f5f7fb;padding:24px 0;">
    <tr>
      <td align="center">
        <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:12px;overflow:hidden;border:1px solid #e6ebf1;">
          <tr>
            <td style="padding:24px 24px 0;font-weight:bold;font-size:20px;">
              {{ $brand }}
            </td>
          </tr>
          <tr>
            <td style="padding:16px 24px 0;font-size:16px;line-height:1.6;">
              <p style="margin:0 0 12px;">Hi {{ $name }},</p>
              <p style="margin:0 0 12px;">Thank you for registering. Your verification code is:</p>
              <p style="margin:16px 0 16px;text-align:center;">
                <span style="display:inline-block;font-size:28px;letter-spacing:4px;font-weight:700;color:#2c3e50;background:#f0f3f8;border-radius:8px;padding:12px 16px;">
                  {{ $otp }}
                </span>
              </p>
              <p style="margin:0 0 12px;">This code will expire in {{ $mins }} minutes.</p>
              <p style="margin:0 0 12px;">If you didn’t request this, you can safely ignore this email.</p>
            </td>
          </tr>
          <tr>
            <td style="padding:16px 24px 24px;font-size:14px;color:#6b7280;border-top:1px solid #eef2f7;">
              <p style="margin:0;">Regards,<br>{{ $brand }} Team</p>
              @if(!empty($details['support_email']))
                <p style="margin:8px 0 0;">Need help? Contact us at <a href="mailto:{{ $details['support_email'] }}">{{ $details['support_email'] }}</a></p>
              @endif
            </td>
          </tr>
        </table>
        <p style="color:#9aa3af;font-size:12px;margin:12px 0 0;">© {{ date('Y') }} {{ $brand }}. All rights reserved.</p>
      </td>
    </tr>
  </table>
</body>
</html>
