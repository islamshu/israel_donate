<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>استشارة جديدة</title>
</head>
<body style="font-family: 'Arial', sans-serif; background-color:#f4f4f7; margin:0; padding:0;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:10px; overflow:hidden; margin-top:30px;">
                    <tr>
                        <td style="background-color:#28a745; padding:20px; text-align:center;">
                            <h1 style="color:#ffffff; margin:0; font-size:24px;">استشارة جديدة بانتظارك</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:30px; color:#333333; font-size:16px; line-height:1.6;">
                            <p><strong>العميل:</strong> {{ $consultation->client_name }}</p>
                            <p><strong>البريد:</strong> {{ $consultation->client_email }}</p>
                            <p><strong>الهاتف:</strong> {{ $consultation->client_phone }}</p>
                            <p><strong>رقم الاستشارة:</strong> {{ $consultation->consultation_number }}</p>

                            <hr style="border:none; border-top:1px solid #eee; margin:20px 0;">
                            <p><strong>نص الاستشارة:</strong></p>
                            <p style="background-color:#f9f9f9; padding:15px; border-radius:5px; border:1px solid #eee;">
                                {{ $consultation->consultation_text }}
                            </p>

                            <p style="margin-top:20px; text-align:center;">
                                <a href="{{ route('dashboard.quick_consultations.show', $consultation) }}" 
                                   style="display:inline-block; padding:12px 25px; background-color:#28a745; color:#fff; text-decoration:none; border-radius:5px; font-weight:bold;">
                                    عرض الاستشارة
                                </a>
                            </p>
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