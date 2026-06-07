<?php
include "koneksi.php";

// Query pesanan

$qPesananHariIni = mysqli_query(
  $conn, 
  "SELECT COUNT(*) AS total 
  FROM pesanan
  WHERE DATE(tanggal) = CURDATE()
  ");

  $pesananHariIni = mysqli_fetch_assoc($qPesananHariIni)['total'];

  
// Query Pendapatan hari ini 
$qPendapatanHariIni = mysqli_query(
  $conn,
  "SELECT COALESCE(SUM(total_harga),0) AS total
  FROM pesanan
  WHERE DATE(tanggal) = CURDATE()
  AND status_pesanan IN ('dibayar')"
);

if (!$qPendapatanHariIni) {
    die(mysqli_error($conn));
}

$pendapatanHariIni = mysqli_fetch_assoc($qPendapatanHariIni)['total'];

// Query pendapatan total
$qPendapatanTotal = mysqli_query(
  $conn,
  "SELECT COALESCE(SUM(total_harga),0) AS total 
  FROM pesanan 
  WHERE status_pesanan IN ('dibayar')"
);

$pendapatanTotal = mysqli_fetch_assoc($qPendapatanTotal)['total'];

$qPesananTerbaru = mysqli_query(
  $conn,
  "SELECT p.*, pl.nama_pelanggan
  FROM pesanan p
  JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
  WHERE LOWER(TRIM(p.status_pesanan))
  IN ('diproses','selesai')
  ORDER BY p.id_pesanan DESC
  LIMIT 3"
);
?>



<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Admin UMKM Kuliner SagalaLada</title>

    <!-- Google Font -->
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- Chart JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  
    <!-- CSS -->
    <link rel="stylesheet" href="../asset/style_sidebar.css">
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <?php $halaman = "dashboard"; ?>
    <!-- SIDEBAR -->
    <?php include "../components/sidebar.php"; ?>

    <!-- MAIN CONTENT -->
    <!-- NAVBAR -->
    <main class="main-content" id="main-content">
      <header class="navbar">
  <div class="navbar-left">
    <h2>Laporan Penjualan</h2>
    <p>
      Kelola dan pantau seluruh data laporan penjualan, transaksi, dan rekap pendapatan secara detail.
    </p>
  </div>

  <div class="navbar-right">
    <div class="profile">
      <button id="profile-btn">
        <i data-feather="user"></i>
        <span>Admin</span>
        <i data-feather="chevron-down"></i>
      </button>

      <div class="profile-menu" id="profile-menu">
        <a href="#">
          <i data-feather="user"></i>
          Profil
        </a>

        <a href="#">
          <i data-feather="lock"></i>
          Ubah Password
        </a>

        <a href="#">
          <i data-feather="settings"></i>
          Pengaturan Akun
        </a>

        <a href="../../index.html">
          <i data-feather="log-out"></i>
          Halaman Awal
        </a>
      </div>
    </div>
  </div>
</header>

      <!-- CARD STATISTIK -->
      <section class="cards">
        <div class="card">
          <div class="card-icon">
            <i data-feather="package"></i>
          </div>

          <div>
            <h4>Total Produk</h4>
            <h2 class="counter" data-target="120">0</h2>
          </div>
        </div>

        <div class="card">
          <div class="card-icon">
            <i data-feather="shopping-cart"></i>
          </div>

          <div>
            <h4>Pesanan Hari Ini</h4>
            <h2><?= $pesananHariIni ?></h2>
          </div>
        </div>

        <div class="card">
          <div class="card-icon">
            <i data-feather="dollar-sign"></i>
          </div>

          <div>
            <h4>Pendapatan Hari Ini</h4>
            <h2>Rp <?= number_format($pendapatanHariIni,0,',','.')?></h2>
          </div>
        </div>

        <div class="card">
          <div class="card-icon">
            <i data-feather="trending-up"></i>
          </div>

          <div>
            <h4>Pendapatan Keseluruhan</h4>
            <h2>Rp <?= number_format($pendapatanTotal, 0, ',', '.') ?></h2>
        </div>
        </div>
      </section>

      <!-- GRAFIK -->
      <section class="chart-box">
        <div class="section-title">Grafik Penjualan Bulanan</div>

        <canvas id="salesChart"></canvas>
      </section>

      <h2 class="table-title">Pesanan Terbaru</h2>
      <!-- TABEL -->
      <section class="table-box">

        <table>
          <thead>
            <tr>
                <th>Pelanggan</th>
                <th>Detail Item</th>
                <th>Total Bayar</th>
                <th>Status</th>
            </tr>
          </thead>
  <tbody>
    <?php
    if(mysqli_num_rows($qPesananTerbaru) > 0){

        while($row = mysqli_fetch_assoc($qPesananTerbaru)){

            $status = strtolower(trim($row['status_pesanan']));
    ?>
    <tr>
        <td>
    <div class="pelanggan-box">

        <div class="pelanggan-icon">
            <i data-feather="user"></i>
        </div>

        <div>
            <span class="nomor-pesanan">
                <?= $row['nomor_pesanan'] ?>
            </span>

            <div class="nama-pelanggan">
                <?= htmlspecialchars($row['nama_pelanggan']) ?>
            </div>
            <small>
                <?= $row['tanggal'] ?>
            </small>
        </div>

    </div>
</td>

        <td>
            <?php
            $idPesanan = $row['id_pesanan'];

            $qDetail = mysqli_query(
                $conn,
                "SELECT m.nama_menu, dp.jumlah
                FROM detail_pesanan dp
                JOIN menu m ON dp.id_menu = m.id_menu
                WHERE dp.id_pesanan = '$idPesanan'"
            );

            while($detail = mysqli_fetch_assoc($qDetail)){
            ?>
                <div class="item-menu">

                    <div class="nama-menu">
                        <?= $detail['nama_menu'] ?>

                        <span class="qty">
                            x<?= $detail['jumlah'] ?>
                        </span>
                    </div>

                </div>
            <?php
            }
            ?>
        </td>

        <td>
          <span class="total-bayar">
              Rp <?= number_format($row['total_harga'],0,',','.') ?>
          </span>
      </td>

        <td>
            <span class="status-badge <?= $status ?>">
                <?= ucfirst($status) ?>
            </span>
        </td>
    </tr>

    <?php
        }
    }else{
    ?>
    <tr>
        <td colspan="4" style="text-align:center">
            Belum ada pesanan.
        </td>
    </tr>
    <?php } ?>
  </tbody>
        </table>
      </section>
    </main>

    <script src="script.js"></script>
    <script>
      feather.replace();
    </script>
  </body>
</html>
