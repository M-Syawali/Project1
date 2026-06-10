<?php
session_start();
include "koneksi.php";

$total_bayar = 0;
$nomor_pesanan = "SGL-" . date("Ymd") . "-" . rand(100,999);

$no_meja = isset($_SESSION['no_meja']) ? $_SESSION['no_meja'] : null;
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

        /* --- STYLE: METODE PEMBAYARAN & BOX QRIS --- */
        .payment-box {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .payment-box .title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #333;
        }
        .payment-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 12px;
        }
        .payment-option {
            position: relative;
        }
        .payment-option input[type="radio"] {
            display: none;
        }
        .payment-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 12px;
            border: 2px solid #eee;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            font-size: 14px;
            font-weight: 500;
        }
        .payment-label i {
            font-size: 20px;
            margin-bottom: 5px;
            color: #666;
        }
        .payment-option input[type="radio"]:checked + .payment-label {
            border-color: #8b1e2d;
            background-color: #fff5f5;
            color: #8b1e2d;
        }
        .payment-option input[type="radio"]:checked + .payment-label i {
            color: #8b1e2d;
        }
        .qris-container {
            display: none; 
            text-align: center;
            margin-top: 20px;
            padding: 15px;
            border: 2px dashed #8b1e2d;
            border-radius: 10px;
            background: #fafafa;
        }
        .qris-container img {
            max-width: 230px;
            width: 100%;
            height: auto;
            margin-top: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        /* --- STYLE BARU: BUKTI PEMBAYARAN UPLOAD --- */
        .upload-bukti-wrapper {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #eee;
            text-align: left;
        }
        .upload-bukti-wrapper label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        .upload-bukti-wrapper input[type="file"] {
            display: block;
            width: 100%;
            padding: 10px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 13px;
            color: #555;
            cursor: pointer;
        }
        .upload-bukti-wrapper input[type="file"]::file-selector-button {
            background: #8b1e2d;
            color: #fff;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            margin-right: 10px;
            transition: 0.2s;
        }
        .upload-bukti-wrapper input[type="file"]::file-selector-button:hover {
            background: #6d1723;
        }
    </style>
</head>
<body>

<form action="proses_checkout.php" method="POST" enctype="multipart/form-data">

<div class="checkout-container">

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

        <div class="address-box">

            <div class="title">
                <i class="fa-solid fa-user"></i>
                <span>Detail Pemesan</span>
            </div>

            <?php if ($no_meja): ?>
            <div class="input-group">
                <label>Nomor Meja</label>
                <input 
                    type="text" 
                    value="Meja <?= htmlspecialchars($no_meja); ?>" 
                    readonly 
                    style="background-color: #f8f9fa; border: 1px solid #ddd; cursor: not-allowed; color: #555;">
                <input type="hidden" name="no_meja" value="<?= htmlspecialchars($no_meja); ?>">
            </div>
            <?php endif; ?>

            <div class="input-group">
                <label>Nama Lengkap</label>
                <input 
                    type="text" 
                    name="nama" 
                    required 
                    placeholder="Masukkan nama Anda">
            </div>

        </div>

        <div class="payment-box">
            <div class="title">
                <i class="fa-solid fa-credit-card"></i>
                <span>Metode Pembayaran</span>
            </div>
            
            <div class="payment-options">
                <div class="payment-option">
                    <input type="radio" id="bayar_kasir" name="metode_pembayaran" value="Kasir" checked required>
                    <label for="bayar_kasir" class="payment-label">
                        <i class="fa-solid fa-money-bill-wave"></i>
                        <span>Bayar di Kasir</span>
                    </label>
                </div>

                <div class="payment-option">
                    <input type="radio" id="bayar_qris" name="metode_pembayaran" value="QRIS" required>
                    <label for="bayar_qris" class="payment-label">
                        <i class="fa-solid fa-qrcode"></i>
                        <span>QRIS</span>
                    </label>
                </div>
            </div>

            <div id="qris_box" class="qris-container">
                <p style="font-weight: bold; margin-bottom: 5px; color: #333;">Silahkan Scan QRIS SagalaLada:</p>
                <img src="../bahan/csan-qr-a.jpg" alt="QRIS SagalaLada">
                
                <div class="upload-bukti-wrapper">
                    <label for="bukti_pembayaran"><i class="fa-solid fa-cloud-arrow-up"></i> Upload Bukti Pembayaran:</label>
                    <input type="file" id="bukti_pembayaran" name="bukti_pembayaran" accept="image/*">
                    <small style="color: #c62828; display: block; margin-top: 5px; font-size: 11px;">* Format gambar (.jpg, .jpeg, .png) wajib dilampirkan jika memilih QRIS</small>
                </div>
            </div>
        </div>

    </div>

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

<script>
document.addEventListener("DOMContentLoaded", function() {
    const paymentRadios = document.querySelectorAll('input[name="metode_pembayaran"]');
    const qrisBox = document.getElementById('qris_box');
    const inputBukti = document.getElementById('bukti_pembayaran'); // Mengambil element input file

    function toggleQrisBox() {
        const selectedPayment = document.querySelector('input[name="metode_pembayaran"]:checked');
        
        if (selectedPayment && selectedPayment.value === 'QRIS') {
            qrisBox.style.display = 'block'; // Munculkan gambar QRIS & form upload
            inputBukti.setAttribute('required', 'required'); // Wajib diisi hanya ketika pilih QRIS
        } else {
            qrisBox.style.display = 'none';  // Sembunyikan jika pilih Kasir
            inputBukti.removeAttribute('required'); // Batalkan wajib diisi agar opsi Kasir bisa lolos submit
            inputBukti.value = ""; // Reset file yang sempat dipilih jika user berganti pilihan
        }
    }

    // Dengarkan setiap perubahan klik pada radio button
    paymentRadios.forEach(radio => {
        radio.addEventListener('change', toggleQrisBox);
    });

    // Jalankan fungsi saat web pertama kali dibuka untuk memastikan keadaan default (Kasir checked)
    toggleQrisBox();
});
</script>

</body>
</html>