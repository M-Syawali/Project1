<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pesanan</title>
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="../../asset/style_sidebar.css">
    <link rel="stylesheet" href="css/style_laporan.css">
</head>
<body>
<?php $halaman = "laporan"; ?>
<?php include "../../components/sidebar.php"; ?>
<div class="main-content">
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

        <a href="../../main_page/dashboard.php" class="btn-kembali">
            ← Kembali ke Dashboard
        </a>
    </form>
    </div>
</div>
<script>
feather.replace();
</script>
</body>
</html>