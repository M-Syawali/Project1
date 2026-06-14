<?php
include "koneksi.php";

if (!isset($_GET['id'])) {
    die("ID Pesanan tidak ditemukan!");
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

$query = mysqli_query($conn, "
    SELECT p.*, pl.nama_pelanggan
    FROM pesanan p
    JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
    WHERE p.id_pesanan = '$id'
");

$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data pesanan tidak ditemukan!");
}

$detail = mysqli_query($conn, "
    SELECT dp.*, m.nama_menu, (dp.subtotal / dp.jumlah) as harga_satuan
    FROM detail_pesanan dp
    JOIN menu m ON dp.id_menu = m.id_menu
    WHERE dp.id_pesanan = '$id'
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Struk #<?= $data['nomor_pesanan']; ?></title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family: 'Courier New', Courier, monospace;
    width: 100%;
    max-width: 80mm; /* Batasi lebar maksimal struk */
    margin: 0 auto;
    padding: 15px 10px;
    font-size: 13px; /* Sedikit dinaikkan agar lebih terbaca di layar HP */
    color: #000;
    background-color: #fff;
}

.header{
    text-align:center;
}

.header h2{
    margin-bottom:3px;
    font-size: 18px;
}

.header p{
    font-size:11px;
}

.divider{
    border-top:1px dashed #000;
    margin:10px 0;
}

.info p{
    margin:4px 0;
}

.item{
    margin-bottom:8px;
}

.item-name{
    font-weight:bold;
}

.item-detail{
    display:flex;
    justify-content:space-between;
    margin-top:2px;
}

.total-section{
    margin-top:8px;
}

.total-row{
    display:flex;
    justify-content:space-between;
    margin:4px 0;
}

.grand-total{
    font-weight:bold;
    font-size:15px;
}

.footer{
    text-align:center;
    margin-top:20px;
    font-size:11px;
}

/* Tombol Aksi khusus di Layar HP (Tidak akan ikut tercetak) */
.action-buttons {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}
.btn {
    flex: 1;
    padding: 12px;
    font-size: 14px;
    font-weight: bold;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-align: center;
    text-decoration: none;
    font-family: sans-serif;
}
.btn-print { background-color: #28a745; color: white; }
.btn-back { background-color: #6c757d; color: white; }

/* ========================================================
   ATURAN CETAK (PRINTER THERMAL / PDF BLUETOOTH HP)
   ======================================================== */
@media print{
    /* Sembunyikan tombol saat dicetak */
    .action-buttons {
        display: none !important;
    }
    
    @page{
        size: 80mm auto;
        margin: 0;
    }

    body{
        width: 80mm;
        margin: 0;
        padding: 5px;
        background-color: #fff;
    }
}
/* ========================================================
   OPTIMASI RESPONSIVE UNTUK HP / LAYAR KECIL (Max 768px)
   ======================================================== */
@media screen and (max-width: 768px) {
    /* 1. Paksa Body menggunakan flex-direction column jika memakai flex */
    body {
        flex-direction: column !important;
        overflow-x: hidden;
    }

    /* 2. Sembunyikan Sidebar atau buat dia memenuhi layar / melayang */
    .sidebar {
        width: 100% !important;
        height: auto !important;
        position: relative !important;
        padding: 15px !important;
    }
    
    /* Alternatif jika sidebar ingin dijadikan tombol menu (bisa disesuaikan nanti), 
       tapi opsi paling aman agar tidak merusak layout awal adalah mengubah posisinya relatif */

    /* 3. Reset Margin Left pada Main Content agar tidak terdorong ke kanan */
    .main-content {
        margin-left: 0 !important;
        padding: 15px !important; /* Perkecil padding agar space lebih luas */
        width: 100% !important;
    }

    /* 4. Ubah Grid Kasir dari beberapa kolom menjadi 1 kolom saja vertikal */
    .kasir-grid {
        display: flex !important;
        flex-direction: column !important;
        gap: 15px !important;
    }

    /* 5. Pastikan card menu dan struk mengambil lebar penuh */
    .pilihan-menu-resto, 
    .struk-pembayaran-langsung,
    .banner-kasir {
        width: 100% !important;
        max-width: 100% !important;
    }
}
</style>

</head>
<body>

<div class="action-buttons">
    <a href="../index_kasir.php" class="btn btn-back">⬅ Kembali</a>
    <button onclick="window.print();" class="btn btn-print">🖨️ Cetak / PDF</button>
</div>

<div class="header">
    <h2>SAGALALADA</h2>
    <p>Restaurant & Cafe</p>
    <p>Terima Kasih Atas Kunjungan Anda</p>
</div>

<div class="divider"></div>

<div class="info">
    <p>No Pesanan : <?= $data['nomor_pesanan']; ?></p>
    <p>Pelanggan  : <?= htmlspecialchars($data['nama_pelanggan']); ?></p>
    <p>Tipe       : <?= htmlspecialchars($data['jenis_pesanan']); ?></p> 
    <p>Metode     : <?= htmlspecialchars(strtoupper($data['metode_pembayaran'])); ?></p>
    <p>Tanggal    : <?= date('d-m-Y H:i', strtotime($data['tanggal'])); ?></p>
</div>

<div class="divider"></div>

<?php while($d = mysqli_fetch_assoc($detail)): ?>

<div class="item">
    <div class="item-name">
        <?= htmlspecialchars($d['nama_menu']); ?>
    </div>

    <div class="item-detail">
        <span><?= $d['jumlah']; ?> x Rp <?= number_format($d['harga_satuan'], 0, ',', '.'); ?></span>
        <span>Rp <?= number_format($d['subtotal'], 0, ',', '.'); ?></span>
    </div>

    <?php if(!empty($d['pedas']) && $d['pedas'] !== '-'): ?>
        <div style="font-size:11px; font-style: italic; color: #333; margin-left: 5px;">
            ↳ Level Pedas: <?= htmlspecialchars($d['pedas']); ?>
        </div>
    <?php endif; ?>

    <?php if(!empty($d['catatan']) && $d['catatan'] !== '-'): ?>
        <div style="font-size:11px; font-style: italic; color: #333; margin-left: 5px;">
            ↳ Catatan: <?= htmlspecialchars($d['catatan']); ?>
        </div>
    <?php endif; ?>
</div>

<?php endwhile; ?>

<div class="divider"></div>

<div class="total-section">
    <div class="total-row grand-total">
        <span>Total Akhir</span>
        <span>Rp <?= number_format($data['total_harga'], 0, ',', '.'); ?></span>
    </div>

    <div class="total-row">
        <span>Uang Tunai</span>
        <span>Rp <?= number_format($data['uang_diterima'], 0, ',', '.'); ?></span>
    </div>

    <div class="total-row">
        <span>Kembalian</span>
        <span>
            Rp <?= number_format($data['uang_diterima'] - $data['total_harga'], 0, ',', '.'); ?>
        </span>
    </div>
</div>

<div class="divider"></div>

<div class="footer">
    <p>** PESANAN LUNAS & SELESAI **</p>
    <p>Terima Kasih</p>
    <br>
    <p>www.sagalalama.com</p>
</div>

</body>
</html>