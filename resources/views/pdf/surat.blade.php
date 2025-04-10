<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; font-size: 18px; font-weight: bold; }
        .content { margin-top: 20px; }
        .signature { margin-top: 50px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Surat Persetujuan</h2>
    </div>
    <div class="content">
        <p><strong>Nomor Surat:</strong> {{ $surat->nomor_surat }}</p>
        <p><strong>Nama Pemohon:</strong> {{ $surat->nama_pemohon }}</p>
        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($surat->created_at)->format('d F Y') }}</p>
        <p><strong>Status Persetujuan:</strong> {{ $surat->suratDetail->status_persetujuan }}</p>
    </div>
    <div class="signature">
        <p>Hormat kami,</p>
        <p><strong>{{ $surat->penandatangan }}</strong></p>
    </div>
</body>
</html>
