<?php
// Mendapatkan nama file saat ini untuk penanda menu aktif
$current_page = basename($_SERVER['PHP_SELF']);
?>

<aside class="sidebar" id="sidebar">
    <div class="logo">
        <i data-feather="coffee"></i>
        <span>SagalaLada</span>
    </div>
    
    <ul class="menu">
        <li class="<?= ($current_page == 'dashboard.php') ? 'active' : '' ?>">
            <a href="/project1/admind/main_page/dashboard.php">
                <i data-feather="home"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="<?= ($current_page == 'index_admin.php') ? 'active' : '' ?>">
            <a href="/project1/admind/crud/menu/index_admin.php">
                <i data-feather="package"></i>
                <span>Menu</span>
            </a>
        </li>

        <li class="<?= ($current_page == 'admin_pesanan.php') ? 'active' : '' ?>">
            <a href="/project1/admind/crud/pesanan/admin_pesanan.php">
                <i data-feather="shopping-bag"></i>
                <span>Pesanan</span>
            </a>
        </li>

        <li class="<?= ($current_page == 'index.php') ? 'active' : '' ?>">
            <a href="/project1/admind/crud/laporan/index.php">
                <i data-feather="bar-chart-2"></i>
                <span>Laporan</span>
            </a>
        </li>
    </ul>
</aside>