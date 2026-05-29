<?php
session_start();
include "koneksi.php";

$total_bayar = 0;
$nomor_pesanan = "SGL-" . date("Ymd") . "-" . rand(100,999);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - SagalaLada</title>

    <link rel="stylesheet" href="css/style_checkout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<form action="proses_checkout.php" method="POST">

<div class="checkout-container">

    <!-- LEFT -->
    <div class="checkout-left">

        <div class="topbar">
            <a href="keranjang.php" class="back-btn">
                <i class="fa-solid fa-arrow-left"></i>
            </a>

            <h2>Checkout Pesanan</h2>
        </div>

        <div class="order-id-box">
                    <span>No Pesanan</span>
                    <h3><?= $nomor_pesanan; ?></h3>
                </div>

        <div class="menu-box">
            <div class="section-title">
                <i class="fa-solid fa-bowl-food"></i>
                <span>Pesanan Kamu</span>
            </div>

            <?php
            if(!empty($_SESSION['keranjang'])){

                foreach($_SESSION['keranjang'] as $id_menu => $jumlah){

                    $query = mysqli_query($conn, "SELECT * FROM menu WHERE id_menu='$id_menu'");
                    $data = mysqli_fetch_assoc($query);

                    $subtotal = $data['harga'] * $jumlah;
                    $total_bayar += $subtotal;
            ?>

            <div class="menu-item">

                <img src="../admind/crud/menu/upload/<?= $data['gambar']; ?>">

                <div class="menu-detail">
                    <h4><?= $data['nama_menu']; ?></h4>
                    <p><?= $jumlah; ?> x Rp <?= number_format($data['harga'],0,',','.'); ?></p>
                </div>

                <div class="menu-price">
                    Rp <?= number_format($subtotal,0,',','.'); ?>
                </div>

            </div>

            <?php }} ?>

        </div>
        <div class="address-box">
            <div class="title">
                <i class="fa-solid fa-location-dot"></i>
                <span>Detail Pemesan</span>
            </div>

                <div class="input-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" required>
                </div>

                <select name="meja" required>

                    <option value="">Pilih Meja</option>

                    <?php
                    $query_meja = mysqli_query($conn, "SELECT * FROM meja");

                    while($meja = mysqli_fetch_assoc($query_meja)){
                    ?>

                        <option value="<?= $meja['id_meja']; ?>">
                            Meja <?= $meja['id_meja']; ?>
                        </option>

                    <?php } ?>

                </select>

                <div class="input-group">
                    <label>Catatan Pesanan</label>
                    <textarea name="catatan" rows="4" placeholder="Contoh: pedas level 2"></textarea>
                </div>

        </div>

    </div>


    <!-- RIGHT -->
    <div class="checkout-right">

        <div class="summary-card">

            <h3>Ringkasan Belanja</h3>
            <input type="hidden" 
                name="nomor_pesanan" 
                value="<?= $nomor_pesanan; ?>">

            <div class="summary-row">
                <span>Total Pesanan</span>
                <span>Rp <?= number_format($total_bayar,0,',','.'); ?></span>
            </div>

            <div class="summary-row">
                <span>Biaya Layanan</span>
                <span>Rp 0</span>
            </div>

            <div class="summary-total">
                <span>Total Bayar</span>
                <h2>Rp <?= number_format($total_bayar,0,',','.'); ?></h2>
            </div>

            <button type="submit" class="checkout-btn">
                Pesan Sekarang
                <i class="fa-solid fa-arrow-right"></i>
            </button>

            
        </div>
        
    </div>
    
</form>
</div>

</body>
</html>