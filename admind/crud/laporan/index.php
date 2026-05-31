<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pesanan</title>
    <link rel="stylesheet" href="css/style_laporan.css">
</head>
<body>
    <div class="container">
    <h2>📅 Pilih Tanggal Laporan</h2>
    <p class="subtitle">
        Tentukan rentang tanggal untuk melihat data laporan pesanan.
    </p>

    <form action="data_laporan.php" method="GET">

        <div class="form-group">
            <label>Tanggal Awal</label>
            <input type="date" name="tgl_awal" required>
        </div>

        <div class="form-group">
            <label>Tanggal Akhir</label>
            <input type="date" name="tgl_akhir" required>
        </div>

        <button type="submit" class="btn-laporan">
            Tampilkan Laporan
        </button>

        <a href="../../main_page/dashboard.html" class="btn-kembali">
            ← Kembali ke Dashboard
        </a>
    </form>
</div>
</body>
</html>