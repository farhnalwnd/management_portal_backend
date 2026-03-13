<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @media screen and (max-width: 600px) {
            .content {
                padding: 20px !important;
            }

            .button-container {
                display: block !important;
            }

            .btn {
                display: block !important;
                margin-bottom: 10px !important;
                width: auto !important;
                text-align: center !important;
            }
        }
    </style>
</head>

<body style="margin: 0; padding: 0; background-color: #f9fafb; font-family: 'Inter', Helvetica, Arial, sans-serif;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table class="container" width="600" border="0" cellpadding="0" cellspacing="0"
                    style="background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden;">

                    <tr>
                        <td style="background-color: #1e293b; padding: 20px; text-align: center;">
                            <span
                                style="color: #ffffff; font-weight: bold; font-size: 18px; letter-spacing: 1px;">APPROVAL
                                SYSTEM</span>
                        </td>
                    </tr>

                    <tr>
                        <td class="content" style="padding: 40px; color: #374151;">
                            <h2 style="margin-top: 0; color: #111827; font-size: 20px;">Permohonan Approval Baru</h2>
                            <p style="font-size: 15px; line-height: 1.5; color: #6b7280;">
                                Halo <strong>{{ $contentMgt->user->first_name . ' ' . $contentMgt->user->last_name }}</strong>, Anda menerima permintaan persetujuan untuk konten dengan rincian sebagai berikut:
                            </p>

                            <table width="100%" border="0" cellpadding="12" cellspacing="0"
                                style="background-color: #f3f4f6; border-radius: 8px; margin: 25px 0;">
                                <tr>
                                    <td style="font-size: 14px; border-bottom: 1px solid #e5e7eb;">
                                        <strong style="color: #4b5563;">Title:</strong><br>
                                        <span style="font-size: 16px; color: #111827;">{{ $contentMgt->title }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 14px; border-bottom: 1px solid #e5e7eb;">
                                        <strong style="color: #4b5563;">Type:</strong><br>
                                        <span style="font-size: 16px; color: #111827;">{{ $contentMgt->type }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 14px;">
                                        <strong style="color: #4b5563;">Version:</strong><br>
                                        <span style="font-size: 16px; color: #111827;">v{{ $contentMgt->version
                                            }}</span>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size: 15px; color: #374151;">Mohon untuk segera meninjau permohonan ini
                                dengan menekan salah satu tombol di bawah:</p>

                            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top: 30px;">
                                <tr>
                                    <td class="button-container" align="center">
                                        <a href="{{ $approveLink }}" class="btn"
                                            style="background-color: #10b981; color: #ffffff; padding: 12px 25px; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 14px; display: inline-block; margin: 0 5px;">
                                            Approve Now
                                        </a>
                                        <a href="{{ $rejectLink }}" class="btn"
                                            style="background-color: #ef4444; color: #ffffff; padding: 12px 25px; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 14px; display: inline-block; margin: 0 5px;">
                                            Reject Request
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td
                            style="background-color: #f9fafb; padding: 20px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0; font-size: 12px; color: #9ca3af;">
                                Email ini dikirim secara otomatis oleh Portal Management System.<br>
                                &copy; 2026 PT Oneject Indonesia.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
