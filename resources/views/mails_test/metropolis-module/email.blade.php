<body style="margin: 0; padding: 0;">
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td style="padding: 20px 0 30px 0;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse; border: 1px solid #cccccc;">
                    <tr>
                        <td align="center">
                            <img src="{{ $message->embed(public_path('/img/sunwest.jpg')) }}"  alt="Creating Email Magic." width="500" height="250" style="display: block;">
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
                                <tr>
                                    <td style="color: #153643; font-family: Arial, sans-serif;">
                                        <h1 style="font-size: 24px; margin: 0;">Hi {{ $data['recipient_name'] }},</h1>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 24px; padding: 20px 0 30px 0;">
                                        <p style="margin: 0;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $data['message'] }} </p>
                                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; You may access the system through this <a href="http://18.139.117.151">Link</a>.</p>
                                        
                                        <br><br>
                                        Have a great day!
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffb444" style="padding: 30px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
                                <tr>
                                    <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;">
                                        <p style="margin: 0;">&reg; Metropolis Test Email </p>
                                        <p><b>This email is auto generated, No need to reply.</b></p>
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