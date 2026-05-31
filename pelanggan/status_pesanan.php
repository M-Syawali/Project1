<?php
include "koneksi.php";

// 1. Pastikan ID ada di URL
if (!isset($_GET['id'])) {
    die("ID Pesanan tidak ditemukan.");
}

$id_pesanan = mysqli_real_escape_string($conn, $_GET['id']);

// 2. Ambil data pesanan awal
$query = mysqli_query($conn, "SELECT * FROM pesanan WHERE id_pesanan='$id_pesanan'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data pesanan tidak ada di database.");
}

$status = $data['status_pesanan']; 
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

function renderStatus(status) {
    status = status ? status.toLowerCase().trim() : "";
    if (status === currentStatus) return; 
    currentStatus = status;

    const displayID = "#SGL-" + idPesanan; 

    // KONDISI 1: DIPROSES
    if (status === "diproses") {
        statusCard.innerHTML = `
            <div class="order-id">PESANAN ${displayID}</div>
            <div class="loader"></div>
            <h2>Pesanan Diproses</h2>
            <p>Sabar ya, koki kami sedang meracik bumbu rahasia untuk pesananmu.</p>
        `;
    } 
    // KONDISI 2: SELESAI
    else if (status === "selesai") {
        statusCard.innerHTML = `
            <div class="order-id">PESANAN ${displayID}</div>
            <div class="check-icon bg-gold">
                <i class="fa-solid fa-utensils"></i>
            </div>
            <h2>Pesanan Selesai</h2>
            <p>Pesananmu sudah siap di meja! Selamat menikmati hidangan kami. 🍜</p>
        `;
    }
    // KONDISI 3: DIBAYAR
    else if (status === "dibayar") {
        statusCard.innerHTML = `
            <div class="order-id">TRANSAKSI ${displayID}</div>
            <div class="check-icon bg-maroon">
                <i class="fa-solid fa-house-user"></i>
            </div>
            <h2>Selamat Datang Kembali!</h2>
            <p>Terima kasih sudah berkunjung ke SagalaLada. Kami tunggu kedatanganmu berikutnya!</p>
            <a href="../index.html" class="btn-dashboard">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        `;
    } 
    // KONDISI TERBARU: DIBATALKAN
    else if (status === "dibatalkan") {
        statusCard.innerHTML = `
            <div class="order-id">PESANAN ${displayID}</div>
            <div class="check-icon" style="background: #ef4444;">
                <i class="fa-solid fa-xmark"></i>
            </div>
            <h2>Pesanan Dibatalkan</h2>
            <p>Mohon maaf, pesananmu tidak dapat kami proses saat ini. Silakan hubungi kasir atau buat pesanan baru.</p>
            <a href="menu.php" class="btn-dashboard" style="background: #444;">
                <i class="fa-solid fa-rotate-left"></i> Pesan Lagi
            </a>
        `;
    }
    // KONDISI LAIN: LOADING / ERROR
    else {
        statusCard.innerHTML = `
            <div class="order-id">MENYINKRONKAN...</div>
            <div class="loader"></div>
            <h2>Memperbarui Status</h2>
            <p>Tunggu sebentar, kami sedang mengambil data terbaru.</p>
        `;
    }
}

// Jalankan pertama kali saat halaman dimuat
renderStatus("<?= $status; ?>");

// Cek status secara Real-time setiap 3 detik
const autoCheck = setInterval(() => {
    // Berhenti cek jika status sudah 'dibayar' (biar hemat resource)
    if (currentStatus === "dibayar") {
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