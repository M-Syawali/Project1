<?php include '../menu/koneksi.php';

    $qPendapatan = mysqli_query($conn, "
    SELECT SUM(total_harga) as total
    FROM pesanan
    WHERE status_pesanan = 'selesai'
");

$pendapatan = mysqli_fetch_assoc($qPendapatan)['total'] ?? 0;

$qPesanan = mysqli_query($conn, "
    SELECT COUNT(*) as total
    FROM pesanan
    WHERE status_pesanan = 'selesai'
");

$totalPesanan = mysqli_fetch_assoc($qPesanan)['total'] ?? 0;

$qProduk = mysqli_query($conn, "
    SELECT SUM(dp.jumlah) as total
    FROM detail_pesanan dp
    JOIN pesanan p ON dp.id_pesanan = p.id_pesanan
    WHERE p.status_pesanan = 'selesai'
");

$produkTerjual = mysqli_fetch_assoc($qProduk)['total'] ?? 0;

?>



<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>

    <script src="https://unpkg.com/feather-icons"></script>

    <link rel="stylesheet" href="../../asset/style_sidebar.css">
    <link rel="stylesheet" href="css/style_laporan.css">

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
</head>

<body>

<?php $halaman = "laporan"; ?>
<?php include "../../components/sidebar.php"; ?>

<main class="main-content">

    <!-- HEADER -->
    <div class="page-header">
        <h1>Laporan Penjualan</h1>
        <p>Lihat dan analisis data penjualan restoran berdasarkan periode yang dipilih.</p>
    </div>

    <!-- JUDUL HALAMAN -->
    <section class="hero-section">

        <div class="hero-icon">
            <i data-feather="bar-chart-2"></i>
        </div>

        <div class="hero-content">
            <h2>Pilih Rentang Tanggal</h2>

            <p>
                Kelola dan lihat laporan penjualan berdasarkan
                periode yang diinginkan.
            </p>
        </div>

    </section>

    <!-- CARD STATISTIK -->
    <div class="summary-grid">

    <div class="summary-card">
        <div class="summary-icon">
            <i data-feather="package"></i>
        </div>

        <div>
            <span>Total Pesanan</span>
            <h3><?= $totalPesanan; ?></h3>
            <small>Seluruh Periode</small>
        </div>
    </div>

    <div class="summary-card">
        <div class="summary-icon">
            <i data-feather="dollar-sign"></i>
        </div>

        <div>
            <span>Total Pendapatan</span>
            <h3>Rp <?= number_format($pendapatan, 0, ',', '.'); ?></h3>
            <small>Seluruh Periode</small>
        </div>
    </div>

    <div class="summary-card">
        <div class="summary-icon">
            <i data-feather="shopping-cart"></i>
        </div>

        <div>
            <span>Produk Terjual</span>
            <h3><?= $produkTerjual; ?></h3>
            <small>Seluruh Periode</small>
        </div>
    </div>

</div>
    <!-- FILTER -->
    <section class="filter-card">

        <div class="filter-header">

            <div class="filter-icon">
                <i data-feather="calendar"></i>
            </div>

            <div>
                <h3>Filter Laporan</h3>

                <p>
                    Pilih tanggal awal dan akhir untuk
                    menampilkan laporan penjualan.
                </p>
            </div>

        </div>

        <form action="data_laporan.php" method="GET">

            <div class="form-row">

                <div class="form-group">

                    <label>Tanggal Awal</label>

                    <input
                        type="date"
                        name="tgl_awal"
                        required>

                </div>

                <div class="form-group">

                    <label>Tanggal Akhir</label>

                    <input
                        type="date"
                        name="tgl_akhir"
                        required>

                </div>

            </div>

            <div class="button-group">

                <button type="submit" class="btn-laporan">

                    <i data-feather="file-text"></i>

                    Tampilkan Laporan

                </button>

                <a
                    href="../../main_page/dashboard.php"
                    class="btn-secondary">

                    <i data-feather="home"></i>

                    Beranda Admin

                </a>

            </div>

        </form>

    </section>

    <!-- INFORMASI -->
    <section class="info-box">

        <div class="info-icon">
            <i data-feather="info"></i>
        </div>

        <div>

            <h3>Informasi</h3>

            <p>
                Data laporan penjualan akan ditampilkan
                berdasarkan rentang tanggal yang dipilih.
            </p>

        </div>

    </section>

</main>

<script>
    feather.replace();
</script>

</body>
</html>