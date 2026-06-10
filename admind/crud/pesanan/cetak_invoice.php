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
    SELECT dp.*, m.nama_menu
    FROM detail_pesanan dp
    JOIN menu m ON dp.id_menu = m.id_menu
    WHERE dp.id_pesanan = '$id'
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Struk #<?= $data['nomor_pesanan']; ?></title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family: Arial, sans-serif;
    width:80mm;
    margin:auto;
    padding:8px;
    font-size:12px;
    color:#000;
}

.header{
    text-align:center;
}

.header h2{
    margin-bottom:3px;
}

.header p{
    font-size:11px;
}

.divider{
    border-top:1px dashed #000;
    margin:8px 0;
}

.info p{
    margin:2px 0;
}

.item{
    margin-bottom:6px;
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
    margin:3px 0;
}

.grand-total{
    font-weight:bold;
    font-size:14px;
}

.footer{
    text-align:center;
    margin-top:10px;
    font-size:11px;
}

.text-center{
    text-align:center;
}

@media print{
    @page{
        margin:0;
    }

    body{
        margin:0;
    }
}
</style>

<script>
window.onload = function() {
    window.print();

    window.onafterprint = function() {
        window.location.href = 'admin_pesanan.php';
    };
};
</script>

</head>
<body>

<div class="header">
    <h2>SAGALALADA</h2>
    <p>Restaurant & Cafe</p>
    <p>Terima Kasih Atas Kunjungan Anda</p>
</div>

<div class="divider"></div>

<div class="info">
    <p>No Pesanan : <?= $data['nomor_pesanan']; ?></p>
    <p>Pelanggan : <?= htmlspecialchars($data['nama_pelanggan']); ?></p>

    <p>Tipe Pesanan : 
        <?php if(!empty($data['id_meja'])): ?>
            Meja <?= htmlspecialchars($data['id_meja']); ?>
        <?php else: ?>
            <strong>Take Away</strong>
        <?php endif; ?>
    </p>

    <?php if(!empty($data['metode_pembayaran'])): ?>
        <p>Metode Bayar : <?= htmlspecialchars(strtoupper($data['metode_pembayaran'])); ?></p>
    <?php endif; ?>

    <p>Tanggal : <?= date('d-m-Y H:i', strtotime($data['tanggal'])); ?></p>
</div>

<div class="divider"></div>

<?php while($d = mysqli_fetch_assoc($detail)): ?>

<div class="item">

    <div class="item-name">
        <?= htmlspecialchars($d['nama_menu']); ?>
    </div>

    <div class="item-detail">
        <span><?= $d['jumlah']; ?> x</span>

        <?php if(isset($d['harga'])): ?>
            <span>
                Rp <?= number_format($d['harga'],0,',','.'); ?>
            </span>
        <?php endif; ?>
    </div>

    <?php if(!empty($d['pedas'])): ?>
        <div style="font-size:11px;">
            Level Pedas : <?= htmlspecialchars($d['pedas']); ?>
        </div>
    <?php endif; ?>

    <?php if(!empty($d['catatan'])): ?>
        <div style="font-size:11px;">
            Catatan : <?= htmlspecialchars($d['catatan']); ?>
        </div>
    <?php endif; ?>

</div>

<?php endwhile; ?>

<div class="divider"></div>

<div class="total-section">

    <div class="total-row grand-total">
        <span>Total</span>
        <span>
            Rp <?= number_format($data['total_harga'],0,',','.'); ?>
        </span>
    </div>

    <?php if(isset($data['metode_pembayaran']) && strtolower($data['metode_pembayaran']) == 'tunai'): ?>
        <div class="total-row">
            <span>Uang Tunai</span>
            <span>
                Rp <?= number_format($data['uang_diterima'],0,',','.'); ?>
            </span>
        </div>

        <div class="total-row">
            <span>Kembalian</span>
            <span>
                Rp <?= number_format(
                    $data['uang_diterima'] - $data['total_harga'],
                    0,
                    ',',
                    '.'
                ); ?>
            </span>
        </div>
    <?php endif; ?>

</div>

<div class="divider"></div>

<div class="footer">
    <p>Pesanan Selesai</p>
    <p>Terima Kasih</p>
    <br>
    <p>www.sagalalada.com</p>
</div>

</body>
</html>