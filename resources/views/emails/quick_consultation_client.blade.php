<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>استلام استشارتك</title>
</head>
<body style="font-family: 'Arial', sans-serif; background-color:#f4f4f7; margin:0; padding:0;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:10px; overflow:hidden; margin-top:30px;">
                    <tr>
                        <td style="background-color:#1a73e8; padding:20px; text-align:center;">
                            <h1 style="color:#ffffff; margin:0; font-size:24px;">مرحباً {{ $consultation->client_name }}!</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:30px; color:#333333; font-size:16px; line-height:1.6;">
                            <p>تم استلام استشارتك بنجاح.</p>
                            <p><strong>رقم الاستشارة:</strong> {{ $consultation->consultation_number }}</p>
                            <p>يمكنك متابعة حالة استشارتك عبر الرابط التالي:</p>
                            
                            <p style="text-align:center; margin:20px 0;">
                                <a href="{{ url('consultation-query/'.$consultation->consultation_number) }}" 
                                   style="display:inline-block; padding:12px 25px; background-color:#1a73e8; color:#fff; text-decoration:none; border-radius:5px; font-weight:bold;">
                                    عرض الاستشارة
                                </a>
                            </p>

                            <hr style="border:none; border-top:1px solid #eee; margin:20px 0;">
                            <p style="font-size:14px; color:#888888;">إذا لم تقم بإرسال هذه الاستشارة، يرجى تجاهل هذا الإيميل.</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color:#f4f4f7; text-align:center; padding:15px; color:#888888; font-size:12px;">
                            جميع الحقوق محفوظة &copy; {{ date('Y') }} {{ get_general_value('website_name') }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>