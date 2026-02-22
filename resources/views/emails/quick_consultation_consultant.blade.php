<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>استشارة جديدة بانتظارك</title>
</head>
<body style="margin:0; padding:0; background-color:#f2f4f8; font-family:Tahoma, Arial, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f2f4f8; padding:30px 0;">
<tr>
<td align="center">

<table width="620" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.05);">

    <!-- Header -->
    <tr>
        <td style="background:linear-gradient(135deg,#0f4c81,#1a73e8); padding:30px; text-align:center;">
            <h2 style="color:#ffffff; margin:0; font-size:22px; font-weight:600;">
                استشارة جديدة بانتظار ردك
            </h2>
        </td>
    </tr>

    <!-- Body -->
    <tr>
        <td style="padding:35px 40px; color:#333333; font-size:16px; line-height:1.8;">

            <p style="margin-top:0;">
                عزيزي المستشار،
            </p>

            <p>
                تم استلام استشارة جديدة وتعيينها لك، وهي الآن بانتظار مراجعتك والرد عليها.
                فيما يلي تفاصيل الطلب:
            </p>

            <!-- Client Info Box -->
            <table width="100%" cellpadding="0" cellspacing="0" style="margin:25px 0; background-color:#f8fafc; border:1px solid #e6eaf0; border-radius:8px;">
                <tr>
                    <td style="padding:15px 20px; font-size:15px;">
                        <p style="margin:5px 0;"><strong>اسم العميل:</strong> {{ $consultation->client_name }}</p>
                        <p style="margin:5px 0;"><strong>البريد الإلكتروني:</strong> {{ $consultation->client_email }}</p>
                        <p style="margin:5px 0;"><strong>رقم الهاتف:</strong> {{ $consultation->client_phone }}</p>
                        <p style="margin:5px 0;"><strong>رقم الاستشارة:</strong> {{ $consultation->consultation_number }}</p>
                    </td>
                </tr>
            </table>

            <!-- Consultation Text -->
            <p><strong>تفاصيل الاستشارة:</strong></p>

            <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:10px; background-color:#f8fafc; border:1px solid #e6eaf0; border-radius:8px;">
                <tr>
                    <td style="padding:20px; font-size:15px; line-height:1.7;">
                        {{ $consultation->consultation_text }}
                    </td>
                </tr>
            </table>

            <!-- Button -->
            <table width="100%" cellpadding="0" cellspacing="0" style="margin:30px 0;">
                <tr>
                    <td align="center">
                        <a href="{{ route('dashboard.quick_consultations.show', $consultation) }}"
                           style="background-color:#1a73e8;
                                  color:#ffffff;
                                  padding:14px 35px;
                                  text-decoration:none;
                                  border-radius:8px;
                                  font-size:16px;
                                  font-weight:bold;
                                  display:inline-block;">
                            فتح الاستشارة في لوحة التحكم
                        </a>
                    </td>
                </tr>
            </table>

        </td>
    </tr>

    <!-- Divider -->
    <tr>
        <td style="height:1px; background-color:#eaeaea;"></td>
    </tr>

    <!-- Footer -->
    <tr>
        <td style="padding:25px 30px; text-align:center; font-size:13px; color:#888888;">
            <p style="margin:5px 0;">
                هذه رسالة إشعار تلقائية من نظام الاستشارات.
            </p>

            <p style="margin:5px 0;">
                © {{ date('Y') }} {{ get_general_value('website_name') }}  
                جميع الحقوق محفوظة
            </p>
        </td>
    </tr>

</table>

</td>
</tr>
</table>

</body>
</html>