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

    <style>
        .pedas-badge{
            display:inline-block;
            padding:4px 10px;
            background:#ffe5e5;
            color:#c62828;
            border-radius:20px;
            font-size:12px;
            font-weight:600;
            margin-top:5px;
        }

        .catatan-box{
            margin-top:8px;
            color:#666;
            font-size:13px;
        }

        .edit-menu-btn{
            display:inline-block;
            margin-top:10px;
            padding:6px 12px;
            background:#8b1e2d;
            color:#fff;
            text-decoration:none;
            border-radius:8px;
            font-size:12px;
            transition:.3s;
        }

        .edit-menu-btn:hover{
            background:#6d1723;
        }

        .menu-item{
            display:flex;
            gap:15px;
            align-items:flex-start;
            padding:15px 0;
            border-bottom:1px solid #eee;
        }

        .menu-item img{
            width:80px;
            height:80px;
            object-fit:cover;
            border-radius:10px;
        }

        .menu-detail{
            flex:1;
        }

        .menu-price{
            font-weight:bold;
            color:#8b1e2d;
            white-space:nowrap;
        }
    </style>
</head>
<body>

<form action="proses_checkout.php" method="POST">

<div class="checkout-container">

    <!-- KIRI -->
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

                foreach($_SESSION['keranjang'] as $id_menu => $item){

                    $query = mysqli_query(
                        $conn,
                        "SELECT * FROM menu WHERE id_menu='$id_menu'"
                    );

                    $data = mysqli_fetch_assoc($query);

                    if($data){

                        $qty = $item['jumlah'];
                        $pedas = $item['pedas'] ?? 'Original';
                        $catatan = $item['catatan'] ?? '';

                        $harga = (float)$data['harga'];

                        $subtotal = $harga * $qty;
                        $total_bayar += $subtotal;
            ?>

            <div class="menu-item">

                <img src="../admind/crud/menu/upload/<?= $data['gambar']; ?>" alt="Menu">

                <div class="menu-detail">

                    <h4><?= $data['nama_menu']; ?></h4>

                    <p>
                        <?= $qty; ?> x Rp <?= number_format($harga,0,',','.'); ?>
                    </p>

                    <div class="pedas-badge">
                        🌶 <?= $pedas; ?>
                    </div>

                    <?php if(!empty($catatan)): ?>
                        <div class="catatan-box">
                            <i class="fa-solid fa-note-sticky"></i>
                            <?= htmlspecialchars($catatan); ?>
                        </div>
                    <?php endif; ?>

                    <a href="keranjang.php" class="edit-menu-btn">
                        <i class="fa-solid fa-pen"></i>
                        Edit Menu
                    </a>

                </div>

                <div class="menu-price">
                    Rp <?= number_format($subtotal,0,',','.'); ?>
                </div>

            </div>

            <?php
                    }
                }

            } else {
                echo "
                <div style='padding:20px;text-align:center;'>
                    Keranjang masih kosong
                </div>";
            }
            ?>

        </div>

        <!-- DATA PEMESAN -->
        <div class="address-box">

            <div class="title">
                <i class="fa-solid fa-user"></i>
                <span>Detail Pemesan</span>
            </div>

            <div class="input-group">
                <label>Nama Lengkap</label>
                <input
                    type="text"
                    name="nama"
                    required
                    placeholder="Masukkan nama Anda">
            </div>

        </div>

    </div>

    <!-- KANAN -->
    <div class="checkout-right">

        <div class="summary-card">

            <h3>Ringkasan Belanja</h3>

            <input
                type="hidden"
                name="nomor_pesanan"
                value="<?= $nomor_pesanan; ?>">

            <div class="summary-row">
                <span>Total Pesanan</span>
                <span>
                    Rp <?= number_format($total_bayar,0,',','.'); ?>
                </span>
            </div>

            <div class="summary-row">
                <span>Biaya Layanan</span>
                <span>Rp 0</span>
            </div>

            <div class="summary-total">
                <span>Total Bayar</span>
                <h2>
                    Rp <?= number_format($total_bayar,0,',','.'); ?>
                </h2>
            </div>

            <button type="submit" class="checkout-btn">
                Pesan Sekarang
                <i class="fa-solid fa-arrow-right"></i>
            </button>

        </div>

    </div>

</div>

</form>

</body>
</html>