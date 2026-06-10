<?php
include "koneksi.php";

// 1. Pastikan ID ada di URL
if (!isset($_GET['id'])) {
    die("ID Pesanan tidak ditemukan.");
}

$id_pesanan = mysqli_real_escape_string($conn, $_GET['id']);

// 2. Ambil data pesanan awal (pastikan kolom metode_pembayaran ada di tabel pesanan)
$query = mysqli_query($conn, "SELECT * FROM pesanan WHERE id_pesanan='$id_pesanan'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data pesanan tidak ada di database.");
}

$status = $data['status_pesanan']; 
// Mengambil metode pembayaran untuk dicek di JavaScript (default 'tunai' jika kosong)
$metode_bayar = isset($data['metode_pembayaran']) ? strtolower($data['metode_pembayaran']) : 'tunai';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pesanan - SagalaLada</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
        body { min-height:100vh; display:flex; justify-content:center; align-items:center; background:#f5f5f5; }
        .status-card { width:350px; background:white; border-radius:25px; padding:40px 25px; text-align:center; box-shadow:0 10px 30px rgba(0,0,0,0.08); transition: all 0.5s ease; }
        .order-id { font-size:13px; color:#bbb; margin-bottom:30px; letter-spacing: 1px; }
        
        /* Animasi Loader */
        .loader { width:60px; height:60px; border:5px solid #f3f3f3; border-top:5px solid #8b1e2d; border-radius:50%; margin:auto; animation:spin 1s linear infinite; }
        @keyframes spin { 100% { transform:rotate(360deg); } }
        
        /* Icon Berhasil */
        .check-icon { width:80px; height:80px; margin:auto; border-radius:50%; background:#22c55e; display:flex; justify-content:center; align-items:center; color:white; font-size:35px; animation:pop .4s ease; }
        .bg-gold { background: #f59e0b !important; }
        .bg-maroon { background: #8b1e2d !important; }
        
        @keyframes pop { from { transform:scale(0); } to { transform:scale(1); } }
        
        h2 { margin-top:25px; margin-bottom:10px; color:#222; font-size: 22px; }
        p { color:#777; line-height:1.5; font-size: 14px; margin-bottom: 20px; }
        
        .btn-dashboard { display:inline-block; padding:12px 25px; background:#8b1e2d; color:white; text-decoration:none; border-radius:50px; font-weight:600; font-size: 13px; transition: 0.3s; }
        .btn-dashboard:hover { background:#6d1723; transform: scale(1.05); }
    </style>
</head>
<body>

<div class="status-card" id="statusCard">
</div>

<script>
const statusCard = document.getElementById("statusCard");
let currentStatus = ""; 
const idPesanan = "<?= $id_pesanan; ?>";
const metodeBayar = "<?= $metode_bayar; ?>"; // Mengambil metode bayar dari PHP

function renderStatus(status) {
    status = status ? status.toLowerCase().trim() : "";

    if (status === currentStatus) return;
    currentStatus = status;

    const displayID = "#SGL-" + idPesanan;

    // PENDING
    if (status === "pending") {
        // CEK JIKALAU METODE BAYAR ADALAH QRIS
        if (metodeBayar === "qris") {
            statusCard.innerHTML = `
                <div class="order-id">PESANAN ${displayID}</div>

                <div class="check-icon bg-gold">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>

                <h2>Menunggu Konfirmasi Pembayaran</h2>

                <p>
                    Bukti pembayaran QRIS Anda telah dikirim. 
                    Mohon tunggu sebentar, admin sedang memverifikasi pembayaran Anda.
                </p>
            `;
        } else {
            // JIKA TUNAI / DEFAULT
            statusCard.innerHTML = `
                <div class="order-id">PESANAN ${displayID}</div>

                <div class="check-icon bg-gold">
                    <i class="fa-solid fa-money-bill-wave"></i>
                </div>

                <h2>Menunggu Pembayaran</h2>

                <p>
                    Pesanan berhasil dibuat.
                    Silakan lakukan pembayaran ke kasir agar pesanan dapat diproses.
                </p>
            `;
        }
    }

    // DIBAYAR
    else if (status === "dibayar") {

        statusCard.innerHTML = `
            <div class="order-id">PESANAN ${displayID}</div>

            <div class="check-icon bg-maroon">
                <i class="fa-solid fa-check"></i>
            </div>

            <h2>Pembayaran Berhasil</h2>

            <p>
                Terima kasih.
                Pembayaran telah dikonfirmasi dan pesanan akan segera diproses oleh dapur.
            </p>
        `;
    }

    // DIPROSES (UBAH MENJADI PESANAN DIBUAT)
    else if (status === "diproses") {

        statusCard.innerHTML = `
            <div class="order-id">PESANAN ${displayID}</div>

            <div class="loader"></div>

            <h2>Pesanan Dibuat</h2>

            <p>
                Koki kami sedang menyiapkan pesanan Anda.
                Mohon tunggu sebentar.
            </p>
        `;
    }

    // SELESAI
    else if (status === "selesai") {

        statusCard.innerHTML = `
            <div class="order-id">PESANAN ${displayID}</div>

            <div class="check-icon bg-gold">
                <i class="fa-solid fa-utensils"></i>
            </div>

            <h2>Pesanan Siap!</h2>

            <p>
                Pesanan Anda sudah selesai dibuat dan siap disajikan.
                Selamat menikmati 😊
            </p>

            <a href="../index.html" class="btn-dashboard">
                <i class="fa-solid fa-house"></i>
                Kembali ke Beranda
            </a>
        `;
    }

    // DIBATALKAN
    else if (status === "dibatalkan") {

        statusCard.innerHTML = `
            <div class="order-id">PESANAN ${displayID}</div>

            <div class="check-icon" style="background:#ef4444;">
                <i class="fa-solid fa-xmark"></i>
            </div>

            <h2>Pesanan Dibatalkan</h2>

            <p>
                Pesanan ini telah dibatalkan.
                Jika terjadi kesalahan silakan hubungi kasir.
            </p>

            <a href="menu.php" class="btn-dashboard" style="background:#444;">
                <i class="fa-solid fa-rotate-left"></i>
                Pesan Lagi
            </a>
        `;
    }

    else {

        statusCard.innerHTML = `
            <div class="order-id">MENYINKRONKAN...</div>

            <div class="loader"></div>

            <h2>Memperbarui Status</h2>

            <p>
                Mohon tunggu sebentar...
            </p>
        `;
    }
}

// Jalankan pertama kali saat halaman dimuat
renderStatus("<?= $status; ?>");

// Cek status secara Real-time setiap 3 detik
const autoCheck = setInterval(() => {
    // Berhenti cek jika status sudah 'selesai' atau 'dibatalkan'
    if (
    currentStatus === "selesai" ||
    currentStatus === "dibatalkan"
    ) {
        clearInterval(autoCheck);
        return;
    }

    fetch("cek_status.php?id=" + idPesanan)
    .then(res => res.text())
    .then(data => {
        if(data.trim() !== "") {
            renderStatus(data);
        }
    })
    .catch(err => console.log("Gagal sinkron status:", err));
}, 3000);
</script>

</body>
</html>