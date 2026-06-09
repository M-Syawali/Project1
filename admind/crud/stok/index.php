<?php include 'koneksi.php'; 
// Logika card

$qTotalMenu = mysqli_query($conn, "SELECT COUNT(*) as total FROM menu");
$totalMenu = mysqli_fetch_assoc($qTotalMenu)['total'] ?? 0;

$qTersedia = mysqli_query($conn, "SELECT COUNT(*) as total FROM menu WHERE stok > 5");
$tersedia = mysqli_fetch_assoc($qTersedia)['total'] ?? 0;

$qMenipis = mysqli_query($conn, "SELECT COUNT(*) as total FROM menu WHERE stok > 0 AND stok <= 5");
$menipis = mysqli_fetch_assoc($qMenipis)['total'] ?? 0;

$qHabis = mysqli_query($conn, "SELECT COUNT(*) as total FROM menu WHERE stok = 0");
$habis = mysqli_fetch_assoc($qHabis)['total'] ?? 0;

$qTotalUnit = mysqli_query($conn, "SELECT SUM(stok) as total FROM menu");
$totalUnit = mysqli_fetch_assoc($qTotalUnit)['total'] ?? 0;

// Logika badge

$totalMenu = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM menu"))['total'] ?? 0;

$tersedia = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM menu WHERE stok > 0"))['total'] ?? 0;

$percent = $totalMenu > 0 ? round(($tersedia / $totalMenu) * 100) : 0;

if ($percent >= 50) {
    $label = "Tersedia";
    $class = "safe";
} elseif ($percent >= 30) {
    $label = "Tersedia";
    $class = "warning";
} else {
    $label = "Tersedia";
    $class = "danger";
}

// Logila
$total = $totalMenu;
$tersediaPct = $total ? ($tersedia / $total) * 100 : 0;
$menipisPct = $total ? ($menipis / $total) * 100 : 0;
$habisPct = $total ? ($habis / $total) * 100 : 0;

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Stok Menu</title>
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="../../asset/style_sidebar.css">
    <link rel="stylesheet" href="css/style.css">

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
</head>
<body>

<?php $halaman = "stok"; ?>
<?php include "../../components/sidebar.php"; ?>

<div class="main-content">
    <div class="page-header">
        <h1>Manajemen Stok</h1>
        <p>Kelola seluruh pesanan pelanggan mulai dari konfirmasi pembayaran hingga pesanan selesai.</p>
    </div>

<div class="summary-grid">

    <div class="summary-card">
        <div class="summary-icon">
            <i data-feather="package"></i>
        </div>
        <div>
            <span>Total Menu</span>
            <h3><?= $totalMenu ?></h3>
            <p>Semua menu terdaftar</p>
        </div>
    </div>

    <div class="summary-card">
        <div class="summary-icon">
            <i data-feather="check-circle"></i>
        </div>
        <div>
            <span>Stok Tersedia</span>
            <h3><?= $tersedia ?></h3>
            <p>menu siap dipesan</p>
        </div>
    </div>

    <div class="summary-card">
        <div class="summary-icon">
            <i data-feather="alert-triangle"></i>
        </div>
        <div>
            <span>Stok Menipis</span>
            <h3><?= $menipis ?></h3>
            <p>perlu segera isi ulang</p>
        </div>
    </div>

    <div class="summary-card">
        <div class="summary-icon">
            <i data-feather="x-circle"></i>
        </div>
        <div>
            <span>Stok Habis</span>
            <h3><?= $habis ?></h3>
            <p>Tidak tersedia hari ini</p>
        </div>
    </div>

    <div class="summary-card">
        <div class="summary-icon">
            <i data-feather="layers"></i>
        </div>
        <div>
            <span>Total Unit Stok</span>
            <h3><?= $totalUnit ?? 0 ?></h3>
            <p>Jumlah seluruh stok</p>
        </div>
    </div>

</div>
<div class="stock-overview">

    <div class="stock-progress-card">

        <div class="stock-top">

            <!-- KIRI -->
            <div class="stock-info">

                <div class="stock-header">

                    <div>
                        <h3>Ringkasan Status Stok</h3>
                    </div>

                    <div class="stock-badge <?= $class ?>">
                        <?= $percent ?>% <?= $label ?>
                    </div>

                </div>

                <div class="stock-bar">

                    <div class="stock-available" style="width: <?= $tersediaPct ?>%"></div>

                    <div class="stock-warning" style="width: <?= $menipisPct ?>%"></div>

                    <div class="stock-empty" style="width: <?= $habisPct ?>%"></div>

                </div>

                <div class="stock-legend">

                    <div class="legend-item">
                        <i class="dot available"></i>
                        <span>Tersedia</span>
                        <strong><?= $tersedia ?></strong>
                    </div>

                    <div class="legend-item">
                        <i class="dot warning"></i>
                        <span>Menipis</span>
                        <strong><?= $menipis ?></strong>

                    </div>

                    <div class="legend-item">
                        <i class="dot empty"></i>
                        <span>Habis</span>
                        <strong><?= $habis ?></strong>  
                    </div>

                </div>

            </div>

            <!-- KANAN -->
            <div class="stock-alert">

                <div class="alert-icon">
                    <i data-feather="bell"></i>
                </div>

                <div>
                    <h4>Perhatian!</h4>
                    <p>
                        Beberapa menu memiliki stok yang hampir habis.
                        Segera lakukan restock untuk menjaga ketersediaan menu.
                    </p>
                </div>

            </div>

        </div>

    </div>

</div>


<!-- FILTER -->
<form method="GET" class="table-toolbar">

    <div class="filter">

        <input
        type="text"
        name="search"
        placeholder="Cari menu..."
        value="<?= $_GET['search'] ?? '' ?>"
        class="search-input"
        oninput="this.form.submit()">

        <select
            name="status"
            class="filter-select"
            onchange="this.form.submit()">
            <option value="">Semua Status</option>

            <option value="tersedia"
                <?= ($_GET['status'] ?? '') == 'tersedia' ? 'selected' : '' ?>>
                Tersedia
            </option>

            <option value="habis"
                <?= ($_GET['status'] ?? '') == 'habis' ? 'selected' : '' ?>>
                Habis
            </option>

        </select>


    </div>

</form>


<!-- FORM UPDATE STOK -->
<form action="update_stok.php" method="POST">

    <div class="table-wrapper">

        <table>

            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Menu</th>
                    <th>Stok Saat Ini</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>

            <?php

            $search = $_GET['search'] ?? '';
            $status = $_GET['status'] ?? '';

            $sql = "SELECT * FROM menu WHERE 1=1";

            if (!empty($search)) {
                $search = mysqli_real_escape_string($conn, $search);
                $sql .= " AND nama_menu LIKE '%$search%'";
            }

            if (!empty($status)) {

                if ($status == 'tersedia') {
                    $sql .= " AND stok > 5";
                }

                if ($status == 'habis') {
                    $sql .= " AND stok = 0";
                }
            }

            $data = mysqli_query($conn, $sql);

            $no = 1;

            while ($row = mysqli_fetch_array($data)) {
            ?>

                <tr>

                    <td><?= $no++ ?></td>

                    <td>
                        <?= htmlspecialchars($row['nama_menu']) ?>

                        <input
                            type="hidden"
                            name="id_menu[]"
                            value="<?= $row['id_menu'] ?>">
                    </td>

                    <td>

                        <input
                            type="number"
                            name="stok[]"
                            value="<?= $row['stok'] ?>"
                            min="0"
                            required
                            class="stok-input">

                    </td>

                    <td>

                        <select
                            name="status[]"
                            class="status-select">

                            <option value="tersedia"
                                <?= $row['status'] == 'tersedia' ? 'selected' : '' ?>>
                                Tersedia
                            </option>

                            <option value="habis"
                                <?= $row['status'] == 'habis' ? 'selected' : '' ?>>
                                Habis
                            </option>

                        </select>

                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

    <div class="table-footer">

        <span>
            Kelola dan perbarui stok menu restoran secara real-time.
        </span>

        <button type="submit" class="btn-update">
            <i data-feather="save"></i>
            Update Semua Stok
        </button>

    </div>

</form>

</div>
<script>
    feather.replace();
</script>
</body>
</html>
