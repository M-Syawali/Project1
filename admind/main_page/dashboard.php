<?php
include "koneksi.php";

// Query pesanan

$qPesananHariIni = mysqli_query(
  $conn, 
  "SELECT COUNT(*) AS total 
  FROM pesanan
  WHERE DATE(tanggal) = CURDATE()
AND status_pesanan = 'selesai'
  ");

  $pesananHariIni = mysqli_fetch_assoc($qPesananHariIni)['total'];

  
// Query Pendapatan hari ini 
$qPendapatanHariIni = mysqli_query(
  $conn,
  "SELECT COALESCE(SUM(total_harga),0) AS total
  FROM pesanan
  WHERE DATE(tanggal) = CURDATE()
  AND status_pesanan IN ('selesai')"
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
  WHERE status_pesanan IN ('selesai')"
);

$pendapatanTotal = mysqli_fetch_assoc($qPendapatanTotal)['total'];

$qPesananTerbaru = mysqli_query(
    $conn,
    "SELECT p.*, pl.nama_pelanggan
     FROM pesanan p
     JOIN pelanggan pl
       ON p.id_pelanggan = pl.id_pelanggan
     WHERE LOWER(TRIM(p.status_pesanan))
     IN ('pending','dibayar','diproses')
     ORDER BY p.id_pesanan DESC
     LIMIT 5"
);

// QUERY GRAFIK BULANAN
$qChart = mysqli_query($conn,
"SELECT 
    MONTH(tanggal) AS bulan,
    SUM(total_harga) AS total
FROM pesanan
WHERE status_pesanan = 'selesai'
GROUP BY MONTH(tanggal)
ORDER BY MONTH(tanggal)
");
$bulanLabel = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
$dataBulan = array_fill(0, 12, 0);

while ($row = mysqli_fetch_assoc($qChart)) {
    $bulanIndex = (int)$row['bulan'] - 1;
    $dataBulan[$bulanIndex] = (int)$row['total'];
}
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
    <h2>Dashboard</h2>
    <p>
        Ringkasan aktivitas bisnis, pesanan pelanggan, pendapatan hari ini, dan tren penjualan bulanan.
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
          <a href="profile.php">
            <i data-feather="user"></i>
            Profil
        </a>

        <a href="ubah_password.php">
            <i data-feather="lock"></i>
            Ubah Password
        </a>

        <a href="../../index.php">
          <i data-feather="log-out"></i>
          Halaman Awal
        </a>
      </div>
    </div>
  </div>
</header>

      <!-- CARD STATISTIK -->
      <div class="summary-grid">

    

    <div class="summary-card">
        <div class="summary-icon">
            <i data-feather="shopping-cart"></i>
        </div>
        <div>
            <span>Pesanan</span>
            <h3><?= $pesananHariIni ?></h3>
            <small>Pesanan Hari Ini</small>
        </div>
    </div>

    <div class="summary-card">
        <div class="summary-icon">
            <i data-feather="dollar-sign"></i>
        </div>
        <div>
            <span>Pendapatan</span>
            <h3>Rp <?= number_format($pendapatanHariIni, 0, ',', '.') ?></h3>
            <small>Pendapatan Hari Ini</small>
        </div>
    </div>



</div>

      <!-- GRAFIK -->
      <section class="chart-box">
        <div class="section-title">Grafik Pendapatan Bulanan</div>

        <canvas id="salesChart"></canvas>
      </section>

      <h2 class="table-title">Pesanan Terbaru</h2>
      <!-- TABEL -->
      <section class="table-box">

        <table>
          <thead>
            <tr>
                <th>Pelanggan</th>
                <th>Tipe</th>
                <th>Metode</th>
                <th>Status</th>
            </tr>
          </thead>
  <tbody>
    <?php
    if(mysqli_num_rows($qPesananTerbaru) > 0){

        while($row = mysqli_fetch_assoc($qPesananTerbaru)){

            $status = strtolower(trim($row['status_pesanan']));
    $jenis_pesanan = strtolower($row['jenis_pesanan'] ?? '');
    $metode = strtoupper($row['metode_pembayaran'] ?? '');
    ?>
    <tr>
        <td>
    <div class="pelanggan-box">

        <div class="pelanggan-icon">
                <i data-feather="user"></i>
                </div>
                <div>

                    <span class="nomor-pesanan">
                        <?= $row['nomor_pesanan']; ?>
                    </span>

    
                <div class="nama-pelanggan">
                    <?= htmlspecialchars($row['nama_pelanggan']); ?>
                </div>
                    <span class="tanggal-pesanan">
                        <?= date('d M Y H:i', strtotime($row['tanggal'])); ?>
                    </span>
                </div>

            


            

        </div>
    </td>

    <td>

        <?php if($jenis_pesanan == 'delivery'): ?>

            <span class="tipe-badge delivery">
                Delivery
            </span>

        <?php elseif(!empty($row['id_meja'])): ?>

            <span class="tipe-badge dinein">
                Dine In
            </span>

        <?php else: ?>

            <span class="tipe-badge takeaway">
                Dine In
            </span>

        <?php endif; ?>

    </td>

    <td>
        <span class="metode-badge <?= strtolower($metode); ?>">
            <?= $metode; ?>
        </span>
    </td>


    <td>

        <?php
        $labelStatus = '';

        switch($status){

            case 'pending':
                $labelStatus = 'Menunggu Pembayaran';
            break;

            case 'dibayar':
                $labelStatus = 'Siap Diproses';
            break;

            case 'diproses':
                $labelStatus = 'Sedang Diproses';
            break;

            case 'selesai':
                $labelStatus = 'Selesai';
            break;

            default:
                $labelStatus = ucfirst($status);
        }
        ?>

        <span
        id="status_<?= $id_p ?>"
        class="status-badge <?= $status ?>">
        <?= $labelStatus ?>
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

const ctx = document.getElementById('salesChart').getContext('2d');

const dataBulan = <?= json_encode($dataBulan) ?>;

// pastikan tetap render walaupun semua 0
const formatRp = (v) => {
    if (v >= 1000000) return (v / 1000000) + ' jt';
    if (v >= 1000) return (v / 1000) + ' rb';
    return v;
};

new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($bulanLabel) ?>,
        datasets: [{
            data: dataBulan,
            borderColor: '#7D0A0A',
            backgroundColor: 'rgba(125,10,10,0.15)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointRadius: 5
        }]
    },

    options: {
        responsive: true,
        maintainAspectRatio: false,

        plugins: {
            legend: { display: false }
        },

        scales: {
      y: {
    beginAtZero: true,
    suggestedMax: 15000000,

    ticks: {
        stepSize: 2000000,

        callback: function(value) {
            if (value === 0) return '0';

            if (value >= 1000000) {
                return (value / 1000000) + ' jt';
            }

            if (value >= 1000) {
                return (value / 1000) + ' rb';
            }

            return value;
        }
    },

    grid: {
        color: "rgba(0,0,0,0.05)"
    }
},

            x: {
                grid: { display: false }
            }
        }
    }
});
</script>
  </body>
</html>
