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

<?php 
session_start();
include "koneksi.php";

// SIMPAN NOMOR MEJA DARI QR
if(isset($_GET['meja'])){
    $_SESSION['no_meja'] = $_GET['meja'];
}

$search = isset($_GET['search']) 
    ? mysqli_real_escape_string($conn, $_GET['search']) 
    : '';

$kategori_filter = isset($_GET['kategori']) 
    ? mysqli_real_escape_string($conn, $_GET['kategori']) 
    : '';

// Query menu
$query = "SELECT menu.*, kategori_menu.nama_kategori_menu 
          FROM menu 
          JOIN kategori_menu 
          ON menu.id_kategori_menu = kategori_menu.id_kategori_menu 
          WHERE menu.nama_menu LIKE '%$search%'";

if ($kategori_filter != "") {
    $query .= " AND menu.id_kategori_menu = '$kategori_filter'";
}

$result = mysqli_query($conn, $query);

// Kelompokkan menu berdasarkan kategori
$menu_berdasarkan_kategori = [];

while($row = mysqli_fetch_assoc($result)) {
    $cat_name = strtolower($row['nama_kategori_menu']);
    $menu_berdasarkan_kategori[$cat_name][] = $row;
}

// Urutan kategori
$urutan_kategori = ['paket', 'makanan', 'minuman'];
?>

<!-- NOTIFIKASI -->
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

    <h2 class="main-title">
        Silahkan pilih menu pesanan
    </h2>

    <!-- FORM SEARCH -->
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

            <!-- DROPDOWN -->
            <div class="dropdown-container">

                <select 
                    name="kategori" 
                    class="dropdown-menu" 
                    onchange="this.form.submit()"
                >

                    <option value="">
                        Semua Kategori
                    </option>

                    <?php
                    $query_kat = mysqli_query($conn, "SELECT * FROM kategori_menu");

                    while($data = mysqli_fetch_array($query_kat)) {

                        $selected = ($kategori_filter == $data['id_kategori_menu']) 
                            ? 'selected' 
                            : '';

                        echo "
                            <option value='".$data['id_kategori_menu']."' $selected>
                                ".$data['nama_kategori_menu']."
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


        <?php 
        if(count($menu_berdasarkan_kategori) > 0) {

            // kategori utama
            foreach ($urutan_kategori as $kat_key) {

                if (isset($menu_berdasarkan_kategori[$kat_key])) {

                    echo "<div class='menu-grid'>";

                    foreach ($menu_berdasarkan_kategori[$kat_key] as $row) {

                        $foto = "../admind/crud/menu/upload/" . $row['gambar'];
                        ?>

                        <div class="card-menu">

                            <img 
                                src="<?php echo $foto; ?>" 
                                alt="<?php echo $row['nama_menu']; ?>"
                            >

                            <h4>
                                <?php echo $row['nama_menu']; ?>
                            </h4>

                            <p class="desc">
                                <?php echo $row['deskripsi_menu']; ?>
                            </p>

                            <div class="price">
                                Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?>
                            </div>

                            <a 
                                href="tambah_keranjang.php?id=<?php echo $row['id_menu']; ?>" 
                                class="btn-add"
                            >
                                <i class="fa-solid fa-plus"></i> 
                                Keranjang
                            </a>

                        </div>

                        <?php
                    }

                    echo "</div>";
                }
            }

            // kategori tambahan
            foreach ($menu_berdasarkan_kategori as $kat_key => $items) {

                if (!in_array($kat_key, $urutan_kategori)) {

                    echo "<div class='menu-grid'>";

                    foreach ($items as $row) {

                        $foto = "../admind/crud/menu/upload/" . $row['gambar'];
                        ?>

                        <div class="card-menu">

                            <img 
                                src="<?php echo $foto; ?>" 
                                alt="<?php echo $row['nama_menu']; ?>"
                            >

                            <h4>
                                <?php echo $row['nama_menu']; ?>
                            </h4>

                            <p class="desc">
                                <?php echo $row['deskripsi_menu']; ?>
                            </p>

                            <div class="price">
                                Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?>
                            </div>

                            <a 
                                href="tambah_keranjang.php?id=<?php echo $row['id_menu']; ?>" 
                                class="btn-add"
                            >
                                <i class="fa-solid fa-plus"></i> 
                                Keranjang
                            </a>

                        </div>

                        <?php
                    }

                    echo "</div>";
                }
            }

        } else {
            ?>

            <div class="empty-menu">
                <h3>Menu tidak ditemukan</h3>
            </div>

            <?php
        }
        ?>



</div>

<script>
    const searchInput = document.querySelector('input[name="search"]');
    const filterForm = document.getElementById('filterForm');

    // AUTO SEARCH
    searchInput.addEventListener('input', function() {

        clearTimeout(this.delay);

        this.delay = setTimeout(function() {
            filterForm.submit();
        }.bind(this), 600);

    });

    // autofocus di akhir text
    if (searchInput.value !== "") {

        const val = searchInput.value;

        searchInput.value = '';
        searchInput.focus();
        searchInput.value = val;
    }

    // notif hilang otomatis
    setTimeout(() => {

        const notif = document.querySelector('.notif');

        if(notif){
            notif.style.display = 'none';
        }

    }, 3000);

    const buttons = document.querySelectorAll('.btn-add');
const cartIcon = document.querySelector('.cart-icon');

buttons.forEach(button => {

    button.addEventListener('click', function(e){

        e.preventDefault();

        const card = this.closest('.card-menu');

        const img = card.querySelector('img');

        const imgRect = img.getBoundingClientRect();
        const cartRect = cartIcon.getBoundingClientRect();

        // clone gambar
        const flyingImg = img.cloneNode(true);

        flyingImg.classList.add('flying-image');

        // posisi awal
        flyingImg.style.left = imgRect.left + 'px';
        flyingImg.style.top = imgRect.top + 'px';

        document.body.appendChild(flyingImg);

        // trigger animasi
        setTimeout(() => {

            flyingImg.style.transform = `
                translate(
                    ${cartRect.left - imgRect.left}px,
                    ${cartRect.top - imgRect.top}px
                )
                scale(0.2)
            `;

            flyingImg.style.opacity = '0.3';

        }, 10);

        // bounce cart
        setTimeout(() => {

            cartIcon.classList.add('cart-bounce');

        }, 700);

        // hapus animasi
        setTimeout(() => {

            flyingImg.remove();

            cartIcon.classList.remove('cart-bounce');

            // lanjut ke PHP tambah keranjang
            window.location.href = button.href;

        }, 1000);

    });

});
</script>

</body>
</html>