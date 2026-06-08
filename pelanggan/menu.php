<?php 
session_start();
include "koneksi.php";

/* =========================
   SIMPAN NOMOR MEJA DARI QR
   ========================= */
if (isset($_GET['meja']) && $_GET['meja'] != '') {

    $id_meja_input = mysqli_real_escape_string($conn, $_GET['meja']);

    $cek_meja = mysqli_query($conn, "SELECT * FROM meja WHERE id_meja = '$id_meja_input'");

    if (mysqli_num_rows($cek_meja) > 0) {
        $_SESSION['no_meja'] = $id_meja_input;
    } else {
        echo "<script>alert('Nomor meja tidak valid!');</script>";
    }
}

/* =========================
   SEARCH & FILTER
   ========================= */
$search = isset($_GET['search']) 
    ? mysqli_real_escape_string($conn, $_GET['search']) 
    : '';

$kategori_filter = isset($_GET['kategori']) 
    ? mysqli_real_escape_string($conn, $_GET['kategori']) 
    : '';

/* =========================
   QUERY MENU
   ========================= */
$query = "SELECT menu.*, kategori_menu.nama_kategori_menu 
          FROM menu 
          JOIN kategori_menu 
          ON menu.id_kategori_menu = kategori_menu.id_kategori_menu 
          WHERE menu.nama_menu LIKE '%$search%'";

if ($kategori_filter != "") {
    $query .= " AND menu.id_kategori_menu = '$kategori_filter'";
}

$result = mysqli_query($conn, $query);

/* =========================
   GROUPING MENU
   ========================= */
$menu_berdasarkan_kategori = [];

while ($row = mysqli_fetch_assoc($result)) {
    $cat_name = strtolower($row['nama_kategori_menu']);
    $menu_berdasarkan_kategori[$cat_name][] = $row;
}

/* urutan kategori */
$urutan_kategori = ['paket', 'makanan', 'minuman'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Pembeli - SagalaLada</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style_menu.css">
</head>

<body>

<!-- NOTIF -->
<?php if(isset($_SESSION['notif'])): ?>
    <div class="notif">
        <?php 
            echo $_SESSION['notif']; 
            unset($_SESSION['notif']);
        ?>
    </div>
<?php endif; ?>

<header class="dashboard-header">
    <div class="logo">
        <a href="../index.html" class="back-icon">
            <i class="fa-solid fa-angle-left"></i>
        </a>
        SagalaLada
    </div>

    <div class="menu-right">
        <a href="rekomendasi.php" class="dashboard-link">
            Bingung Pilih? Pilihkan Untuk Saya
        </a>
        <a href="../index.html" class="dashboard-link">Beranda</a>

        <a href="keranjang.php" class="keranjang-link cart-icon">
            <i class="fa-solid fa-cart-shopping"></i>
        </a>
    </div>
</header>

<div class="container" id="menu-section">

    <h2 class="main-title">Silahkan pilih menu pesanan</h2>

    <!-- SEARCH -->
    <form action="" method="GET" id="filterForm">

        <div class="search-wrapper">

            <div class="search-box">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Cari menu favorit..." 
                    value="<?php echo htmlspecialchars($search); ?>" 
                    autocomplete="off"
                >
                <i class="fas fa-search"></i>
            </div>

            <div class="dropdown-container">
                <select name="kategori" class="dropdown-menu" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>

                    <?php
                    $query_kat = mysqli_query($conn, "SELECT * FROM kategori_menu");

                    while ($data = mysqli_fetch_array($query_kat)) {

                        $selected = ($kategori_filter == $data['id_kategori_menu']) ? 'selected' : '';

                        echo "
                            <option value='{$data['id_kategori_menu']}' $selected>
                                {$data['nama_kategori_menu']}
                            </option>
                        ";
                    }
                    ?>
                </select>

                <i class="fas fa-chevron-down dropdown-icon"></i>
            </div>

        </div>
    </form>

    <!-- MENU -->
    <?php if (count($menu_berdasarkan_kategori) > 0) { ?>

        <?php foreach ($urutan_kategori as $kat_key) { ?>

            <?php if (isset($menu_berdasarkan_kategori[$kat_key])) { ?>

                <div class="menu-grid">

                    <?php foreach ($menu_berdasarkan_kategori[$kat_key] as $row) { ?>

                        <?php $foto = "../admind/crud/menu/upload/" . $row['gambar']; ?>

                        <div class="card-menu">
                            <img src="<?= $foto ?>" alt="<?= $row['nama_menu'] ?>">
                            <h4><?= $row['nama_menu'] ?></h4>
                            <p class="desc"><?= $row['deskripsi_menu'] ?></p>
                            
                            <div class="price">
                                Rp <?= number_format($row['harga'], 0, ',', '.') ?>
                            </div>

                            <?php 
                            // LOGIKA CEK STOK DAN STATUS
                            if ($row['stok'] > 0 && $row['status'] == 'tersedia') { ?>
                                <a href="tambah_keranjang.php?id=<?= $row['id_menu'] ?>" class="btn-add">
                                    <i class="fa-solid fa-plus"></i> Keranjang
                                </a>
                            <?php } else { ?>
                                <button class="btn-add" style="background-color: #ccc; cursor: not-allowed; border: none;" disabled>
                                    <i class="fa-solid fa-ban"></i> Stok Habis
                                </button>
                            <?php } ?>
                        </div>

                    <?php } ?>

                </div>

            <?php } ?>

        <?php } ?>

        <!-- kategori tambahan -->
        <?php foreach ($menu_berdasarkan_kategori as $kat_key => $items) { ?>

            <?php if (!in_array($kat_key, $urutan_kategori)) { ?>

                <div class="menu-grid">

                    <?php foreach ($items as $row) { ?>

                        <?php $foto = "../admind/crud/menu/upload/" . $row['gambar']; ?>

                        <div class="card-menu">
                            <img src="<?= $foto ?>" alt="<?= $row['nama_menu'] ?>">
                            <h4><?= $row['nama_menu'] ?></h4>
                            <p class="desc"><?= $row['deskripsi_menu'] ?></p>
                            
                            <div class="price">
                                Rp <?= number_format($row['harga'], 0, ',', '.') ?>
                            </div>

                            <?php 
                            // LOGIKA CEK STOK DAN STATUS
                            if ($row['stok'] > 0 && $row['status'] == 'tersedia') { ?>
                                <a href="tambah_keranjang.php?id=<?= $row['id_menu'] ?>" class="btn-add">
                                    <i class="fa-solid fa-plus"></i> Keranjang
                                </a>
                            <?php } else { ?>
                                <button class="btn-add" style="background-color: #ccc; cursor: not-allowed; border: none;" disabled>
                                    <i class="fa-solid fa-ban"></i> Stok Habis
                                </button>
                            <?php } ?>
                        </div>

                    <?php } ?>

                </div>

            <?php } ?>

        <?php } ?>

    <?php } else { ?>

        <div class="empty-menu">
            <h3>Menu tidak ditemukan</h3>
        </div>

    <?php } ?>

</div>

<script>
const searchInput = document.querySelector('input[name="search"]');
const filterForm = document.getElementById('filterForm');

/* auto search */
searchInput.addEventListener('input', function () {
    clearTimeout(this.delay);
    this.delay = setTimeout(() => {
        filterForm.submit();
    }, 600);
});

/* notif auto hide */
setTimeout(() => {
    const notif = document.querySelector('.notif');
    if (notif) notif.style.display = 'none';
}, 3000);
</script>

</body>
</html> 