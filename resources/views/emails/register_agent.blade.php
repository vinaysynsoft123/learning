<!DOCTYPE html>
<html>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Welcome to Our Website</title>
</head>

<body style="margin:0;padding:0;background-color:#f4f6f8;font-family:Arial, Helvetica, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
        style="background-color:#f4f6f8;padding:30px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" role="presentation"
                    style="background:#ffffff;border-radius:8px;overflow:hidden;border:1px solid #e5e7eb;">
                    <tr>
                        <td
                            style="background:#0d6efd;padding:20px;color:#ffffff;text-align:left;font-size:20px;font-weight:600;">
                            Welcome, {{ $user->name }}!
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:20px;color:#333333;font-size:16px;line-height:1.5;">
                            <p style="margin:0 0 12px;">Thank you for registering with us. Your account has been created
                                successfully.</p>
                            <p style="margin:0 0 12px;">You can now log in using your email:
                                <strong>{{ $user->email }}</strong></p>

                            <table cellpadding="0" cellspacing="0" role="presentation" style="margin-top:16px;">
                                <tr>
                                    <td style="border-radius:4px;background:#0d6efd;">
                                        <a href="{{ url('/') }}"
                                            style="display:inline-block;padding:10px 18px;color:#ffffff;text-decoration:none;border-radius:4px;font-weight:600;">Go
                                            to site</a>
                                    </td>
                                </tr>
                            </table>

                            <hr style="border:none;border-top:1px solid #e9ecef;margin:20px 0;">
                            <p style="margin:0;font-size:14px;color:#666666;">Best regards,<br>The Team</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>

</html>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Welcome, {{ $user->name }}!</h4>
            </div>
            <div class="card-body">
                <p class="lead">Thank you for registering with us. Your account has been created successfully.
                </p>
                <p>You can now log in using your email: <strong>{{ $user->email }}</strong></p>
                <p class="mt-3"><a href="{{ url('/') }}" class="btn btn-primary">Go to site</a></p>
                <hr>
                <p class="mb-0">Best regards,<br>
                    The Team</p>
            </div>
        </div>
    </div>
</div>
</div>
</body>

</html>
