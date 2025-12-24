<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif;">
    <h2>Halo {{ $data['name'] }},</h2>

    <p>Selamat! Membership Anda telah <strong>AKTIF</strong>.</p>

    <table cellpadding="6">
        <tr>
            <td>Nomor Member</td>
            <td>: <strong>{{ $data['card_no'] }}</strong></td>
        </tr>
        <tr>
            <td>Jenis Member</td>
            <td>: {{ $data['type'] }}</td>
        </tr>
        <tr>
            <td>Masa Aktif</td>
            <td>: {{ $data['from'] }} s/d {{ $data['to'] }}</td>
        </tr>
    </table>

    <p>Terima kasih telah bergabung 🙏</p>

    <p><strong>Assalaam Hypermarket</strong></p>
</body>
</html>
