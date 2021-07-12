<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:400,500,600,700" rel="stylesheet">
    <title>Forgot Password</title>
</head>
<body style="font-family:Arial, sans-serif;margin:0; padding-top: 0; padding-bottom: 0; padding-top: 0; padding-bottom: 0;background-color: #f0f0f0; background-repeat: repeat; width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased;">
    <table width="600" cellpadding="0" cellspacing="0" border="0" align="center">
        <tr>
            <td style="padding-top: 50px;">
                <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table width="100%" bgcolor="#181b2a" align="center" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="100%" style="padding-top: 20px;padding-bottom: 20px;">
                                        <table width="250" align="center" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td>
                                                    <a href="javascript:;" target="_blank" style="text-decoration:none;display: block;">
                                                        <img src="{{ asset('assets/images/logo.png') }}" alt="" width="300" height="106" style="width: 100%;height: auto; display:block; border:none; outline:none; text-decoration:none;">
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <table width="100%" bgcolor="#ffffff" align="center" border="0" cellpadding="0" cellspacing="0" style="padding-left: 25px;padding-right: 25px;">
                                <tr>
                                    <td align="center" style="padding-top: 40px;padding-bottom: 40px;">
                                        <div style="display: block">
                                            <h1 style="font-family: 'Work Sans';font-size:22px;font-weight: 700; color: #000000;margin:0;">Forgot Password Code</h1>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td>
                                                    <div style="display: block">
                                                        <p style="font-family: 'Work Sans';font-size:14px;font-weight: 400;line-height: 20px;color: #292929;margin:0;margin-bottom: 10px;"> Dear  <strong>{{ $user->user_name }},</strong></p>
                                                        <p style="font-family: 'Work Sans';font-size:14px;font-weight: 400;line-height: 20px;color: #292929;margin:0;margin-bottom: 10px;">We have received forgot password request from {{ config('app.name') }} app.</p>
                                                        <p style="font-family: 'Work Sans';font-size:14px;font-weight: 400;line-height: 20px;color: #292929;margin:0;margin-bottom: 10px;">Please enter below code to reset password.</p>
                                                        <p style="font-family: 'Work Sans';font-size:14px;font-weight: 400;line-height: 20px;color: #292929;margin:0;margin-bottom: 10px;">One Time Password(OTP) : <strong>{{ $user->otp }}</strong></p>
                                                        <p style="font-family: 'Work Sans';font-size:14px;font-weight: 400;line-height: 20px;color: #292929;margin:0;margin-bottom: 10px;">If you have not request with us , Kindly ignore this and don't share your OTP/Password with anyone.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100%" style="padding-bottom: 40px;">
                                        <div>
                                            <h3 style="font-family: 'Work Sans';font-size:14px;font-weight:600;line-height: 20px;color: #292929;margin:0;">Regards,</h3>
                                            <h3 style="font-family: 'Work Sans';font-size:14px;font-weight:600;line-height: 20px;color: #292929;margin:0;"><strong>{{ config('app.name') }} Team</strong></h3>
                                        </div>
                                    </td>
                                </tr>

                            </table>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
