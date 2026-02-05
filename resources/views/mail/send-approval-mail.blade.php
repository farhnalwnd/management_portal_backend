<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #F8F9FA;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #FFFFFF;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #E5E7EB;
        }

        .header {
            background-color: #2C6975;
            padding: 30px;
            text-align: center;
            color: #FFFFFF;
        }

        .content {
            padding: 30px;
            color: #4D4D4D;
            line-height: 1.6;
        }

        .footer {
            background-color: #F3F4F6;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #9CA3AF;
        }

        .button {
            display: inline-block;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            margin: 10px 5px;
        }

        .btn-approve {
            background-color: #2C6975;
            color: #FFFFFF !important;
        }

        .btn-reject {
            background-color: #68B2D8;
            color: #FFFFFF !important;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .info-table td {
            padding: 8px 0;
            border-bottom: 1px solid #F3F4F6;
        }

        .label {
            font-weight: bold;
            color: #2C6975;
            width: 30%;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2 style="margin:0;">Request Approval</h2>
            <p style="margin:5px 0 0 0; opacity: 0.8;">Portal Management System</p>
        </div>

        <div class="content">
            <p>Halo, <strong>Approver</strong>,</p>
            <p>Terdapat permohonan aktifasi konten baru yang memerlukan tinjauan Anda:</p>

            <table class="info-table">
                <tr>
                    <td class="label">Judul</td>
                    <td>{{ $contentMgt->title }}</td>
                </tr>
                <tr>
                    <td class="label">Tipe</td>
                    <td>{{ $contentMgt->type }}</td>
                </tr>
                <tr>
                    <td class="label">Versi</td>
                    <td>{{ $contentMgt->version }}</td>
                </tr>
            </table>

            <p>Silakan klik tombol di bawah ini untuk memberikan keputusan langsung:</p>

            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ $approveLink }}" class="button btn-approve">
                    Setujui (Approve)
                </a>
                <a href="{{ $rejectLink }}" class="button btn-reject">
                    Tolak (Reject)
                </a>
            </div>
        </div>

        <div class="footer">
            <p>&copy; 2026 PT Oneject Indonesia - IT Department</p>
            <p>Email ini dikirim secara otomatis oleh sistem, mohon tidak membalas.</p>
        </div>
    </div>
</body>

</html>
