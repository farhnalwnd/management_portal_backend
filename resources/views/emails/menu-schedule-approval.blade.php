<!DOCTYPE html>
<html>
<head>
    <title>Persetujuan Penjadwalan Menu</title>
</head>
<body>
    <h2>Pengajuan Penjadwalan Menu Baru</h2>
    <p>Terdapat pengajuan penjadwalan menu dengan detail sebagai berikut:</p>
    <ul>
        <li><strong>Menu:</strong> {{ $menuSchedule->menu->menu_name }}</li>
        <li><strong>Aksi:</strong> {{ ucfirst($menuSchedule->action_type) }}</li>
        <li><strong>Waktu Eksekusi:</strong> {{ $menuSchedule->scheduled_at }}</li>
    </ul>
    <p>Silakan klik tombol di bawah ini untuk memproses pengajuan:</p>
    <div style="margin-top: 20px;">
        <a href="{{ $approveLink }}" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-right: 10px;">Approve</a>
        <a href="{{ $rejectLink }}" style="background-color: #f44336; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Reject</a>
    </div>
</body>
</html>
