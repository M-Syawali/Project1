<?php
// 1. KONEKSI DATABASE
$host = "localhost";
$user = "root";
$pass = "";
$db   = "sagalalada_db";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// 2. AMBIL DATA MENU DARI DATABASE (Hanya yang statusnya 'tersedia')
$query_menu = "SELECT * FROM menu WHERE status = 'tersedia' ORDER BY id_kategori_menu ASC";
$result_menu = mysqli_query($koneksi, $query_menu);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir SagalaLada</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            background-color: #f8f9fa;
            height: 100vh;
            overflow: hidden; /* Dikunci untuk mode desktop */
        }

        /* --- MAIN CONTENT STYLE --- */
        .main-content {
            flex-grow: 1;
            padding: 30px;
            overflow-y: auto;
            margin-left: 260px; 
        }

        .banner-kasir {
            background-color: #a7232d;
            color: white;
            padding: 25px 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(167, 35, 45, 0.2);
        }

        .banner-kasir h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        /* Layout Grid POS Kasir */
        .kasir-grid {
            display: grid;
            grid-template-columns: 1.7fr 1.3fr;
            gap: 25px;
            height: calc(100vh - 180px);
        }

        .card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            border-bottom: 2px solid #f1f1f1;
            padding-bottom: 10px;
        }

        /* Grid Produk Menu */
        .menu-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 15px;
            overflow-y: auto;
            padding-bottom: 10px;
        }

        .menu-item {
            border: 1px solid #eee;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            background: #fff;
            user-select: none;
        }

        .menu-item:hover {
            border-color: #a7232d;
            box-shadow: 0 4px 8px rgba(167, 35, 45, 0.1);
            transform: translateY(-2px);
        }

        .menu-item img {
            width: 100%;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 8px;
            background-color: #f1f1f1;
        }

        .menu-name {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .menu-price {
            font-size: 13px;
            color: #a7232d;
            font-weight: bold;
        }

        /* Form Keranjang Belanja Belah Kanan */
        .cart-container {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .cart-items {
            flex-grow: 1;
            overflow-y: auto;
            margin-bottom: 15px;
            border-bottom: 2px dashed #eee;
            padding-right: 5px;
        }

        .cart-item-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #f1f1f1;
        }

        .cart-item-info {
            flex-grow: 1;
            max-width: 60%;
        }

        .cart-item-qty {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .qty-btn {
            background: #f1f1f1;
            border: none;
            width: 25px;
            height: 25px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .qty-btn:hover {
            background: #ddd;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 12px;
        }

        .form-group {
            margin-bottom: 12px;
        }

        .form-group label {
            font-size: 12px;
            font-weight: 600;
            color: #666;
            display: block;
            margin-bottom: 4px;
        }

        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }

        .btn-primary {
            background-color: #a7232d;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            width: 100%;
            transition: background 0.2s;
            font-size: 15px;
        }

        .btn-primary:hover {
            background-color: #801b23;
        }

        /* ========================================================
           PERBAIKAN TOTAL LAYOUT MOBILE (Max 768px)
           ======================================================== */
        /* ========================================================
           PERBAIKAN EKSTREM: SEMBUNYIKAN SIDEBAR DI MOBILE
           ======================================================== */
        @media screen and (max-width: 768px) {
            body {
                flex-direction: column !important;
                height: auto !important;
                overflow-x: hidden !important;
                overflow-y: auto !important;
            }

            /* HANYA SEMBUNYIKAN SIDEBAR DI HP */
            .sidebar, 
            aside, 
            div[class*="sidebar"] {
                display: none !important; /* Paksa sidebar hilang */
            }

            /* Pastikan main-content memenuhi lebar layar */
            .main-content {
                margin-left: 0 !important;
                width: 100% !important;
                padding: 10px !important;
                height: auto !important;
                overflow-y: visible !important;
            }

            .kasir-grid {
                display: flex !important;
                flex-direction: column !important;
                gap: 15px !important;
                height: auto !important;
            }

            .card {
                height: auto !important;
                max-height: none !important; /* Biarkan konten memanjang sesuai isi */
            }

            .menu-container {
                grid-template-columns: repeat(2, 1fr) !important; /* Paksa 2 kolom di HP */
                gap: 10px !important;
            }
        }
    </style>
</head>
<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="banner-kasir">
            <h1>Workspace Kasir - Langsung Selesai</h1>
            <p>Klik pada item menu di sebelah kiri untuk memasukkan ke struk. Pembayaran otomatis diproses Lunas & Selesai.</p>
        </div>

        <div class="kasir-grid">
            
            <div class="card">
                <div class="card-title"><i class="fa-solid fa-utensils"></i> Pilihan Menu Resto</div>
                <div class="menu-container">
                    <?php while ($menu = mysqli_fetch_assoc($result_menu)): ?>
                        <div class="menu-item" onclick="tambahKeKeranjang(<?= $menu['id_menu'] ?>, '<?= addslashes($menu['nama_menu']) ?>', <?= $menu['harga'] ?>)">
                            <img src="../admind/crud/menu/upload/<?= $menu['gambar'] ? $menu['gambar'] : 'default.jpg' ?>" alt="<?= $menu['nama_menu'] ?>">
                            <div class="menu-name"><?= $menu['nama_menu'] ?></div>
                            <div class="menu-price">Rp <?= number_format($menu['harga'], 0, ',', '.') ?></div>
                            <div style="font-size: 11px; color:#999; margin-top:3px;">Stok: <?= $menu['stok'] ?></div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <div class="card">
                <div class="card-title"><i class="fa-solid fa-receipt"></i> Struk Pembelian Langsung</div>
                <form action="proses_tambah_manual.php" method="POST" id="formKasir" class="cart-container">
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nama Pembeli</label>
                            <input type="text" name="nama_pelanggan" class="form-control" placeholder="Isi 'Pelanggan' jika kosong">
                        </div>
                        <div class="form-group">
                            <label>No. Meja</label>
                            <input type="text" name="no_meja" class="form-control" placeholder="Kosongkan jika Take Away">
                        </div>
                    </div>

                    <div class="cart-items" id="cartItems">
                        <p id="emptyCartText" style="color: #999; font-style: italic; text-align: center; margin-top: 40px;">Belum ada menu yang dipilih.</p>
                    </div>

                    <div class="form-group" style="display: flex; justify-content: space-between; font-weight: bold; font-size: 18px; margin-bottom: 15px; border-top: 1px solid #eee; padding-top: 10px;">
                        <span>Total:</span>
                        <span id="totalHargaText" style="color: #a7232d;">Rp 0</span>
                        <input type="hidden" name="total_harga" id="totalHargaInput" value="0">
                    </div>

                    <div class="form-group">
                        <label>Uang Tunai Diterima (Rp)</label>
                        <input type="number" name="uang_diterima" id="uangDiterima" class="form-control" placeholder="Masukkan nominal pembayaran" required>
                    </div>

                    <input type="hidden" name="status_pesanan" value="Selesai">
                    <input type="hidden" name="status_pembayaran" value="Lunas">

                    <button type="submit" class="btn-primary"><i class="fa-solid fa-print"></i> Bayar & Otomatis Cetak</button>
                </form>
            </div>

        </div>
    </div>

    <script>
        let keranjang = [];

        function tambahKeKeranjang(id, nama, harga) {
            let itemSama = keranjang.find(item => item.id === id);

            if (itemSama) {
                itemSama.qty += 1;
            } else {
                keranjang.push({
                    id: id,
                    nama: nama,
                    harga: harga,
                    qty: 1
                });
            }
            perbaruiTampilanKeranjang();
        }

        function ubahQty(id, perubahan) {
            let item = keranjang.find(item => item.id === id);
            if (item) {
                item.qty += perubahan;
                if (item.qty <= 0) {
                    keranjang = keranjang.filter(item => item.id !== id);
                }
            }
            perbaruiTampilanKeranjang();
        }

        function perbaruiTampilanKeranjang() {
            const container = document.getElementById('cartItems');
            const emptyText = document.getElementById('emptyCartText');
            const totalText = document.getElementById('totalHargaText');
            const totalInput = document.getElementById('totalHargaInput');

            container.innerHTML = '';

            if (keranjang.length === 0) {
                container.appendChild(emptyText);
                totalText.innerText = "Rp 0";
                totalInput.value = 0;
                return;
            }

            let totalHarga = 0;

            keranjang.forEach(item => {
                let subtotal = item.harga * item.qty;
                totalHarga += subtotal;

                let row = document.createElement('div');
                row.className = 'cart-item-row';
                row.innerHTML = `
                    <div class="cart-item-info">
                        <div style="font-weight: 600; font-size:14px;">${item.nama}</div>
                        <div style="font-size: 12px; color: #777;">@ Rp ${item.harga.toLocaleString('id-ID')}</div>
                        <input type="hidden" name="id_menu[]" value="${item.id}">
                        <input type="hidden" name="jumlah[]" value="${item.qty}">
                        <input type="hidden" name="subtotal[]" value="${subtotal}">
                    </div>
                    <div class="cart-item-qty">
                        <button type="button" class="qty-btn" onclick="ubahQty(${item.id}, -1)">-</button>
                        <span style="font-weight: 600; font-size:14px; min-width:15px; text-align:center;">${item.qty}</span>
                        <button type="button" class="qty-btn" onclick="ubahQty(${item.id}, 1)">+</button>
                    </div>
                    <div style="font-weight: 600; font-size:14px; color: #333; min-width: 70px; text-align: right;">
                        Rp ${subtotal.toLocaleString('id-ID')}
                    </div>
                `;
                container.appendChild(row);
            });

            totalText.innerText = "Rp " + totalHarga.toLocaleString('id-ID');
            totalInput.value = totalHarga;
        }

        document.getElementById('formKasir').addEventListener('submit', function(e) {
            const totalHarga = parseInt(document.getElementById('totalHargaInput').value);
            const uangDiterima = parseInt(document.getElementById('uangDiterima').value);

            if(keranjang.length === 0) {
                alert('Keranjang masih kosong!');
                e.preventDefault();
                return;
            }

            if (uangDiterima < totalHarga) {
                alert('Uang yang diterima kurang dari total akhir!');
                e.preventDefault();
                return;
            }
        });
    </script>
</body>
</html>