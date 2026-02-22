<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>تم الرد على استشارتك</title>
</head>
<style>
    *{
        direction: rtl !important;
    }
</style>


<body style="margin:0; padding:0; background-color:#f2f4f8; font-family:Tahoma, Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f2f4f8; padding:30px 0;">
        <tr>
            <td align="center">

                <table width="620" cellpadding="0" cellspacing="0"
                    style="background-color:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.05);">

                    <!-- Header -->
                    <tr>
                        <td
                            style="background:linear-gradient(135deg,#0f4c81,#1a73e8); padding:30px; text-align:center;">
                            <h2 style="color:#ffffff; margin:0; font-size:22px; font-weight:600;">
                                إشعار برد جديد على استشارتك
                            </h2>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:35px 40px; color:#333333; font-size:16px; line-height:1.8;">

                            <p style="margin-top:0;">
                                عزيزي/عزيزتي <strong>{{ $consultation->client_name }}</strong>،
                            </p>

                            <p>
                                نود إعلامك بأنه تم إضافة رد جديد من قبل المستشار المختص على استشارتك.
                                يمكنك الآن الاطلاع على الرد ومتابعة تفاصيل الاستشارة بكل سهولة.
                            </p>

                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="margin:25px 0; background-color:#f8fafc; border:1px solid #e6eaf0; border-radius:8px;">
                                <tr>
                                    <td style="padding:15px 20px; font-size:15px;">
                                        <strong>رقم الاستشارة:</strong> {{ $consultation->consultation_number }}
                                    </td>
                                </tr>
                            </table>

                            <!-- Button -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin:30px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ url('consultation-query/' . $consultation->consultation_number) }}"
                                            style="background-color:#1a73e8;
                                  color:#ffffff;
                                  padding:14px 35px;
                                  text-decoration:none;
                                  border-radius:8px;
                                  font-size:16px;
                                  font-weight:bold;
                                  display:inline-block;">
                                            عرض تفاصيل الاستشارة
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size:14px; color:#666666;">
                                في حال لم تقم بإرسال هذه الاستشارة، يمكنك تجاهل هذا البريد بأمان.
                            </p>

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
                                هذه رسالة تلقائية، يرجى عدم الرد عليها مباشرة.
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
