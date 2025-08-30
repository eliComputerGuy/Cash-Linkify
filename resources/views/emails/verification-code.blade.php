<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Email Verification</title>
  <style>
    /* ...existing styles... */
    body { margin: 0; padding: 0; font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; color: #333; background-color: #fff; }
    .container { margin: 0 auto; width: 100%; max-width: 600px; padding: 20px; border-radius: 5px; line-height: 1.6; }
    .header { border-bottom: 1px solid #eee; padding-bottom: 10px; text-align: center; }
    .header a { font-size: 1.6em; color: #000; text-decoration: none; font-weight: 700; }
    .otp { background: linear-gradient(to right, #00bc69 0, #00bc88 50%, #00bca8 100%); margin: 20px auto; width: max-content; padding: 10px 20px; font-size: 1.5em; color: #fff; border-radius: 6px; letter-spacing: 2px; }
    .footer { color: #aaa; font-size: 0.8em; font-weight: 300; margin-top: 30px; line-height: 1.4; }
    .email-info { color: #666; font-weight: 400; font-size: 13px; line-height: 18px; text-align: center; }
    .email-info a { text-decoration: none; color: #00bc69; }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <a href="#">{{ config('app.name') }}</a>
    </div>

    <p><strong>Hello {{ $user->name }},</strong></p>

    <p>
      Thank you for signing up with <strong>{{ config('app.name') }}</strong>! To complete your registration and verify your email address, please use the verification code below:
    </p>

    <div class="otp">{{ $code }}</div>

    <p style="font-size: 0.9em;">
      If you did not create an account, please ignore this email.
      <br /><br />
      For your security, please do not share this code with anyone.
    </p>

    <p>
      Best regards,<br />
      <strong>{{ config('app.name') }}</strong>
    </p>

    <hr style="border: none; border-top: 0.5px solid #ccc;" />

    <div class="footer">
      <p>This is an automated message, please do not reply.</p>
      <p>Visit <a href="#">{{ config('app.name') }}</a> for more information.</p>
    </div>
  </div>

  <div class="email-info">
    <p>
      This email was sent to
      <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
    </p>
    <p>
      <a href="#">{{ config('app.name') }}</a>
    </p>
    <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
  </div>
</body>
</html>