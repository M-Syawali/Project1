<?php 
// Mengatur agar session cookie bertahan lama (30 hari) agar tidak keluar sendiri
$waktu_session = 2592000; 
ini_set('session.gc_maxlifetime', $waktu_session);
session_set_cookie_params($waktu_session);

session_start();
include "koneksi.php";

if (isset($_GET['jenis'])) {
    if ($_GET['jenis'] === 'delivery') {
        $_SESSION['jenis_pesanan'] = 'delivery';
        $_SESSION['no_meja'] = null; // Hapus nomor meja karena delivery
    } else if ($_GET['jenis'] === 'dinein') {
        $_SESSION['jenis_pesanan'] = 'dinein';
    }
}

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

// PERBAIKAN: Menghapus unset() agar akun tidak ter-logout saat pilih dinein
if(isset($_GET['jenis']) && $_GET['jenis'] == 'dinein')
{
    $_SESSION['jenis_pesanan'] = 'dinein';
}

/* urutan kategori */
$urutan_kategori = ['paket', 'makanan', 'minuman'];
$jumlah_keranjang = 0;

if(isset($_SESSION['keranjang'])){
    foreach($_SESSION['keranjang'] as $item){
        $jumlah_keranjang += $item['jumlah'];
    }
}
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

<header class="dashboard-header">
    <div class="logo">
        <a href="../index.php" class="back-icon">
            <i class="fa-solid fa-angle-left"></i>
        </a>
        SagalaLada
    </div>

    <div class="menu-right">
        <a href="rekomendasi.php" class="dashboard-link">
            Bingung Pilih? Pilihkan Untuk Saya
        </a>
        <?php if(isset($_SESSION['username'])) { ?>

            <div class="profile-dropdown">

            <button type="button" class="profile-btn" onclick="toggleProfile()">
                <i class="fa-solid fa-user"></i>
                <?= htmlspecialchars($_SESSION['username']); ?>
            </button>

                <div class="profile-content">

                    <a href="profile.php">
                        <i class="fa-solid fa-user"></i>
                        Profile
                    </a>

                    <a href="../login/logout.php">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        Logout
                    </a>

                </div>

            </div>

            <?php } else { ?>

            <a href="../index.php" class="dashboard-link">
                Beranda
            </a>

            <?php } ?>

        <a href="keranjang.php" class="cart-icon">
            <i class="fa-solid fa-cart-shopping"></i>

            <?php if($jumlah_keranjang > 0){ ?>
                <span class="cart-badge">
                    <?= $jumlah_keranjang ?>
                </span>
            <?php } ?>
        </a>
    </div>
</header>

<div class="container" id="menu-section">

<?php if(
    isset($_SESSION['jenis_pesanan']) &&
    $_SESSION['jenis_pesanan'] == 'delivery'
) { ?>

<h2 class="main-title">
    Selamat datang,
    <?= htmlspecialchars($_SESSION['username'] ?? 'Pelanggan'); ?> 👋
</h2>

<p class="sub-title">
    Silahkan memilih pesanan Anda
</p>

<?php } else { ?>

<h2 class="main-title">
    Silahkan pilih menu pesanan
</h2>

<?php } ?>

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
                                <button
                                    class="btn-add btn-ajax-add"
                                    data-id="<?= $row['id_menu'] ?>"
                                    data-nama="<?= htmlspecialchars($row['nama_menu']) ?>"
                                    type="button">

                                    <i class="fa-solid fa-plus"></i> Keranjang

                                </button>
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
                                <button
                                    class="btn-add btn-ajax-add"
                                    data-id="<?= $row['id_menu'] ?>"
                                    data-nama="<?= htmlspecialchars($row['nama_menu']) ?>"
                                    type="button">

                                    <i class="fa-solid fa-plus"></i> Keranjang

                                </button>
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
function updateCartBadge(){

    let badge = document.querySelector('.cart-badge');

    if(!badge){
        const cart = document.querySelector('.cart-icon');

        cart.insertAdjacentHTML(
            'beforeend',
            '<span class="cart-badge">1</span>'
        );

        return;
    }

    let jumlah = parseInt(badge.textContent) || 0;

    badge.textContent = jumlah + 1;

    badge.classList.remove('bounce');

    setTimeout(() => {
        badge.classList.add('bounce');
    }, 10);

    const cart = document.querySelector('.cart-icon');

    cart.classList.remove('cart-bounce');

    setTimeout(() => {
        cart.classList.add('cart-bounce');
    }, 10);
}
/* Toggle Dropdown Profil */
function toggleProfile() {
    const content = document.querySelector('.profile-content');
    if(content) {
        content.classList.toggle('show');
    }
}
</script>
<script>
document.querySelectorAll('.btn-ajax-add').forEach(button => {
    button.addEventListener('click', function() {

        const menuId = this.dataset.id;

        fetch(`tambah_keranjang.php?id=${menuId}`)
            .then(response => response.json())
            .then(data => {

                if(data.status === "success"){
                    updateCartBadge();
                }

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: data.status,
                    title: data.message,
                    showConfirmButton: false,
                    timer: 1800,
                    timerProgressBar: true,
                    background: '#8b1e2d',
                    color: '#fff'
                });

            });

    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>