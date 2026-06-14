<?php
// 1. Jalur ini sudah benar untuk masuk ke folder pesanan
require_once __DIR__ . '/pesanan/koneksi.php'; 

// 2. HITUNG JUMLAH PESANAN PENDING (Ubah $koneksi menjadi $conn)
$query_pending = "SELECT COUNT(*) as total FROM pesanan WHERE status_pesanan = 'pending'";
$result_pending = mysqli_query($conn, $query_pending);
$data_pending = mysqli_fetch_assoc($result_pending);
$jumlah_pending = $data_pending['total'];

// Mengambil nama file yang sedang berjalan untuk mendeteksi class 'active'
$current_page = basename($_SERVER['PHP_SELF']);
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --primary-color: #a62626; /* Warna merah maroon utama */
        --dark-color: #821c1c;    /* Merah maroon lebih gelap untuk background utama sidebar */
        --active-color: #611313;  /* Merah maroon sangat gelap untuk menu yang aktif / di-hover */
        --light-color: #f8f9fa;
        --text-muted: #f5cfcf;    /* Warna teks putih agak pink pudar agar estetik */
    }

    .sidebar {
        width: 260px;
        height: 100vh;
        background-color: var(--dark-color); /* Sekarang background full merah maroon gelap */
        position: fixed;
        top: 0;
        left: 0;
        font-family: 'Poppins', sans-serif;
        box-shadow: 3px 0 10px rgba(0,0,0,0.15);
        display: flex;
        flex-direction: column;
        z-index: 1000;
    }

    .sidebar-brand {
        padding: 24px;
        font-size: 22px;
        font-weight: 700;
        color: #ffffff;
        text-align: center;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    /* Ikon sendok garpu jadi warna putih bersih agar menyala di background merah */
    .sidebar-brand i {
        color: #ffffff;
        margin-right: 8px;
    }

    .sidebar-menu {
        list-style: none;
        padding: 20px 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .sidebar-menu li {
        margin: 4px 16px;
    }

    .sidebar-menu li a {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        color: var(--text-muted);
        text-decoration: none;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .sidebar-menu li a i {
        margin-right: 12px;
        width: 20px;
        text-align: center;
        font-size: 16px;
        color: var(--text-muted);
    }

    /* Efek Hover Menu: Berubah jadi merah maroon lebih gelap */
    .sidebar-menu li a:hover {
        background-color: rgba(0, 0, 0, 0.15);
        color: #ffffff;
    }
    
    .sidebar-menu li a:hover i {
        color: #ffffff;
    }

    /* Menu Aktif: Dikunci dengan warna maroon paling pekat */
    .sidebar-menu li.active a {
        background-color: var(--active-color);
        color: #ffffff;
        font-weight: 600;
    }
    
    .sidebar-menu li.active a i {
        color: #ffffff;
    }

    /* Badge angka antrean: Bulatan putih tulisan merah biar kontras */
    .badge-count {
        background-color: #ffffff;
        color: var(--primary-color);
        font-size: 11px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 20px;
        margin-left: auto;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .sidebar-menu li.logout {
        margin-top: auto;
        margin-bottom: 20px;
    }

    /* Efek khusus untuk tombol logout */
    .sidebar-menu li.logout a:hover {
        background-color: #c0392b; /* Merah terang saat hover keluar */
        color: #ffffff;
    }
    
    .sidebar-menu li.logout a:hover i {
        color: #ffffff;
    }
    
    ~ .main-content, ~ main, ~ body {
        padding-left: 260px;
    }
</style>

<div class="sidebar">
    <div class="sidebar-brand">
        <i class="fa-solid fa-utensils"></i> SagalaLada
    </div>
    <ul class="sidebar-menu">
        <li class="<?= ($current_page == 'index_kasir.php') ? 'active' : ''; ?>">
            <a href="/project1/kasir/index_kasir.php"><i class="fa-solid fa-cash-register"></i> Transaksi Manual</a>
        </li>
        <li class="<?= ($current_page == 'admin_pesanan.php') ? 'active' : ''; ?>">
            <a href="/project1/kasir/pesanan/admin_pesanan.php">
                <i class="fa-solid fa-bell"></i> Antrean Web 
                <?php if ($jumlah_pending > 0): ?>
                    <span class="badge-count"><?= $jumlah_pending ?></span>
                <?php endif; ?>
            </a>
        </li>
        <li class="logout">
            <a href="/project1/kasir/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Log Out</a>
        </li>
    </ul>
</div>