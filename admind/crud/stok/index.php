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

$tersedia = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM menu WHERE stok > 5"))['total'] ?? 0;

$percent = $totalMenu > 0 ? round(($tersedia / $totalMenu) * 100) : 0;

if ($percent >= 50) {
    $label = "Stok Aman";
    $class = "safe";
} elseif ($percent >= 30) {
    $label = "Perlu Perhatian";
    $class = "warning";
} else {
    $label = "Stok Kritis";
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
    <div class="summary-card safe-card">
    <div class="summary-icon">
        <i data-feather="check-circle"></i>
    </div>
    <div>
        <span>Stok Aman</span>
        <h3><?= $tersedia ?></h3>
        <small>menu siap dipesan</small>
    </div>
</div>

    <div class="summary-card warning-card">
    <div class="summary-icon">
        <i data-feather="alert-triangle"></i>
    </div>
    <div>
        <span>Stok Menipis</span>
        <h3><?= $menipis ?></h3>
        <small>perlu segera isi ulang</small>
    </div>
</div>

<div class="summary-card danger-card">
    <div class="summary-icon">
        <i data-feather="x-circle"></i>
    </div>
    <div>
        <span>Stok Habis</span>
        <h3><?= $habis ?></h3>
        <small>tidak tersedia hari ini</small>
    </div>
</div>

    <div class="summary-card stock-card">
    <div class="summary-icon">
        <i data-feather="layers"></i>
    </div>
    <div>
        <span>Total Unit Stok</span>
        <h3><?= $totalUnit ?? 0 ?></h3>
        <small>jumlah seluruh stok</small>
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
                        <span>Aman</span>
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
        id="searchInput"
        placeholder="Cari menu..."
        value="<?= $_GET['search'] ?? '' ?>"
        class="search-input">

        <select
            name="status"
            id="statusSelect"
            class="filter-select">
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

            $sql = "SELECT * FROM menu ";


            $data = mysqli_query($conn, $sql);

            $no = 1;

            while ($row = mysqli_fetch_array($data)) {

                if ($row['stok'] == 0) {
                    $stokClass = 'stok-habis';
                } elseif ($row['stok'] <= 5) {
                    $stokClass = 'stok-warning';
                } else {
                    $stokClass = 'stok-aman';
                }

            ?>

                <tr>

                    <td><?= $no++ ?></td>

                    <td class="menu-name">
                        <?= htmlspecialchars($row['nama_menu']) ?>

                        <input
                            type="hidden"
                            name="id_menu[]"
                            value="<?= $row['id_menu'] ?>">
                    </td>

                    <td>
                        <div class="stok-control <?= $stokClass ?>">

                            <button type="button" class="btn-minus">−</button>

                            <input
                                type="number"
                                name="stok[]"
                                value="<?= $row['stok'] ?>"
                                min="0"
                                required
                                class="stok-input">

                            <button type="button" class="btn-plus">+</button>

                        </div>
                    </td>

                    <td>

                        <select
                            name="status[]"
                            class="status-select <?= $row['status'] ?> ">

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
<script>
document.querySelectorAll('.btn-plus').forEach(btn => {
    btn.addEventListener('click', function() {

        let input = this.parentElement.querySelector('.stok-input');

        input.value = parseInt(input.value || 0) + 1;
    });
});

document.querySelectorAll('.btn-minus').forEach(btn => {
    btn.addEventListener('click', function() {

        let input = this.parentElement.querySelector('.stok-input');

        let value = parseInt(input.value || 0);

        if(value > 0){
            input.value = value - 1;
        }
    });
});
</script>
<script>
document.getElementById("searchInput").addEventListener("input", filterStok);
document.getElementById("statusSelect").addEventListener("change", filterStok);

function filterStok() {

    const keyword =
        document.getElementById("searchInput").value.toLowerCase();

    const status =
        document.getElementById("statusSelect").value;

    const rows =
        document.querySelectorAll("tbody tr");

    rows.forEach(row => {

        const namaMenu =
            row.cells[1].textContent.toLowerCase();

       const statusMenu =
    row.querySelector('select[name="status[]"]').value;

const cocokNama =
    namaMenu.includes(keyword);

let cocokStatus = true;

if (status !== "") {
    cocokStatus = statusMenu === status;
}

        row.style.display =
            (cocokNama && cocokStatus) ? "" : "none";
   
        });
}
</script>
</body>
</html>
