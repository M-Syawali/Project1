<aside class="sidebar" id="sidebar">
        <div class="logo">
            <i data-feather="coffee"></i>
            <span>SagalaLada</span>
        </div>
    
        <ul class="menu">
            <li class="<?= ($halaman == 'dashboard') ? 'active' : '' ?>">
            <a href="/Project1/admind/main_page/dashboard.php">
                <i data-feather="home"></i>
                <span>Dashboard</span>
            </a>
            </li>
    
            <li class="<?= ($halaman == 'menu') ? 'active' : '' ?>">
            <a href="/Project1/admind/crud/menu/index_admin.php">
                <i data-feather="package"></i>
                <span>Menu</span>
            </a>
            </li>
    
            <li class="<?= ($halaman == 'kategori') ? 'active' : '' ?>">
            <a href="/Project1/admind/crud/kategori/index_kategori.php">
                <i data-feather="grid"></i>
                <span>Kategori Menu</span>
            </a>
            </li>
    
            <li class="<?= ($halaman == 'pesanan') ? 'active' : '' ?>">
            <a href="/Project1/admind/crud/pesanan/admin_pesanan.php">
                <i data-feather="shopping-bag"></i>
                <span>Pesanan</span>
            </a>
            </li>
    
            <li class="<?= ($halaman == 'laporan') ? 'active' : '' ?>">
            <a href="/Project1/admind/crud/laporan/index.php">
                <i data-feather="bar-chart-2"></i>
                <span>Laporan</span>
            </a>
            </li>
    
            <li>
            <a href="">
                <i data-feather="settings"></i>
                <span>Log Out</span>
            </a>
            </li>
        </ul>
</aside>