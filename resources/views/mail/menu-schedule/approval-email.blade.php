<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persetujuan Penjadwalan Menu</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #ecfeff;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .wrapper {
            width: 100%;
            background-color: #ecfeff;
            padding: 40px 20px;
            box-sizing: border-box;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(8, 145, 178, 0.1), 0 2px 4px -1px rgba(8, 145, 178, 0.06);
        }
        .header {
            background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%);
            padding: 32px 24px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            font-size: 24px;
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.025em;
        }
        .content {
            padding: 40px 32px;
        }
        .content p {
            color: #164e63;
            font-size: 16px;
            line-height: 1.6;
            margin: 0 0 24px 0;
        }
        .details-card {
            background-color: #f0fdfa;
            border: 1px solid #ccfbf1;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 32px;
        }
        .details-title {
            color: #134e4a;
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 16px 0;
            border-bottom: 1px solid #ccfbf1;
            padding-bottom: 8px;
        }
        .detail-row {
            display: table;
            width: 100%;
            margin-bottom: 12px;
        }
        .detail-label {
            display: table-cell;
            width: 35%;
            color: #0891b2;
            font-size: 14px;
            font-weight: 500;
        }
        .detail-value {
            display: table-cell;
            color: #134e4a;
            font-size: 14px;
            font-weight: 600;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 9999px;
            text-transform: uppercase;
        }
        .badge-activate {
            background-color: #dcfce7;
            color: #15803d;
        }
        .badge-deactivate {
            background-color: #fee2e2;
            color: #b91c1c;
        }
        .actions {
            text-align: center;
            margin-top: 32px;
        }
        .btn {
            display: inline-block;
            padding: 12px 32px;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            border-radius: 8px;
            margin: 0 8px 12px 8px;
            transition: all 0.2s ease;
        }
        .btn-approve {
            background-color: #059669;
            color: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(5, 150, 105, 0.2);
        }
        .btn-reject {
            background-color: #ef4444;
            color: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.2);
        }
        .footer {
            background-color: #f0fdfa;
            padding: 24px;
            text-align: center;
            border-top: 1px solid #ccfbf1;
        }
        .footer p {
            color: #0891b2;
            font-size: 12px;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <h1>PT. Oneject Indonesia</h1>
                <p>Aplication Management Portal</p>
            </div>
            <div class="content">
                <p>Halo,</p>
                <p>Terdapat pengajuan penjadwalan perubahan status menu yang memerlukan persetujuan Anda sebagai Approver:</p>
                
                <div class="details-card">
                    <div class="details-title">Detail Pengajuan</div>
                    <div class="detail-row">
                        <div class="detail-label">Nama Menu</div>
                        <div class="detail-value">{{ ucwords($menuSchedule->menu?->menu_name ?? '-') }}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Jenis Aksi</div>
                        <div class="detail-value">
                            @if($menuSchedule->action_type === 'activate')
                                <span class="badge badge-activate">Activate Menu</span>
                            @else
                                <span class="badge badge-deactivate">Deactivate Menu</span>
                            @endif
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Waktu Eksekusi</div>
                        <div class="detail-value">{{ \Carbon\Carbon::parse($menuSchedule->scheduled_at)->format('d F Y H:i') }}</div>
                    </div>
                </div>

                <p>Silakan tinjau dan ambil tindakan dengan mengklik salah satu tombol di bawah ini:</p>
                
                <div class="actions">
                    <a href="{{ $approveLink }}" class="btn btn-approve">Setujui Pengajuan</a>
                    <a href="{{ $rejectLink }}" class="btn btn-reject">Tolak Pengajuan</a>
                </div>
            </div>
            <div class="footer">
                <p>Email ini dikirim secara otomatis oleh Sistem Portal Oneject. Harap tidak membalas email ini.</p>
            </div>
        </div>
    </div>
</body>
</html>
