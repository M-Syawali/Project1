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
    <section class="cards">

        <div class="card">

            <div class="card-icon">
                <i data-feather="package"></i>
            </div>

            <div>
                <p>Total Pesanan</p>
                <h2>125</h2>
                <span class="card-subtitle">Seluruh Periode</span>
            </div>

        </div>

        <div class="card">

            <div class="card-icon">
                <i data-feather="dollar-sign"></i>
            </div>

            <div>
                <p>Total Pendapatan</p>
                <h2>Rp 5.200.000</h2>
                <span class="card-subtitle">Seluruh Periode</span>
            </div>

        </div>

        <div class="card">

            <div class="card-icon">
                <i data-feather="shopping-cart"></i>
            </div>

            <div>
                <p>Produk Terjual</p>
                <h2>358</h2>
                <span class="card-subtitle">Seluruh Periode</span>
            </div>

        </div>

    </section>

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