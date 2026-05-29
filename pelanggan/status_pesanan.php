<?php
include "koneksi.php";

$id_pesanan = $_GET['id'];

$query = mysqli_query($conn,
"SELECT * FROM pesanan WHERE id_pesanan='$id_pesanan'");

$data = mysqli_fetch_assoc($query);

$status = $data['status_pesanan'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Status Pesanan</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:#f5f5f5;
}

.status-card{
    width:340px;
    background:white;
    border-radius:25px;
    padding:50px 30px;
    text-align:center;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
}

.order-id{
    font-size:14px;
    color:#999;
    margin-bottom:40px;
}

/* LOADING */

.loader{
    width:70px;
    height:70px;
    border:6px solid #eee;
    border-top:6px solid #8b1e2d;
    border-radius:50%;
    margin:auto;
    animation:spin 1s linear infinite;
}

@keyframes spin{
    100%{
        transform:rotate(360deg);
    }
}

/* CHECK ICON */

.check-icon{
    width:80px;
    height:80px;
    margin:auto;
    border-radius:50%;
    background:#22c55e;
    display:flex;
    justify-content:center;
    align-items:center;
    color:white;
    font-size:38px;
    animation:pop .4s ease;
}

.done{
    background:#f59e0b;
}

@keyframes pop{
    from{
        transform:scale(0);
    }
    to{
        transform:scale(1);
    }
}

h2{
    margin-top:30px;
    margin-bottom:10px;
    color:#222;
}

p{
    color:#777;
    line-height:1.6;
}

</style>
</head>

<body>

<div class="status-card" id="statusCard">

    <div class="order-id">
        No Pesanan: <?= $data['nomor_pesanan']; ?>
    </div>

    <?php if($status == 'pending'){ ?>

        <div class="loader"></div>

        <h2>Menunggu Konfirmasi</h2>

        <p>
            Mohon tunggu, admin sedang mengecek pesanan kamu
        </p>

    <?php } elseif($status == 'diproses'){ ?>

        <div class="check-icon">
            <i class="fa-solid fa-check"></i>
        </div>

        <h2>Pesanan Diproses</h2>

        <p>
            Pesanan kamu sedang dibuat dapur
        </p>

    <?php } elseif($status == 'selesai'){ ?>

        <div class="check-icon done">
            <i class="fa-solid fa-utensils"></i>
        </div>

        <h2>Pesanan Selesai</h2>

        <p>
            Pesanan sudah selesai dan siap dinikmati 🍜
        </p>

    <?php } ?>

</div>

<script>

const statusCard = document.getElementById("statusCard");
let currentStatus = ""; 

function renderStatus(status){
    status = status ? status.toLowerCase().trim() : "";

    if (status === currentStatus && status !== "") return; 
    currentStatus = status;

    const noPesanan = "<?= isset($data['nomor_pesanan']) ? $data['nomor_pesanan'] : '-'; ?>";

    if(status === "pending"){
        statusCard.innerHTML = `
            <div class="order-id">No Pesanan: ${noPesanan}</div>
            <div class="loader"></div>
            <h2>Menunggu Konfirmasi</h2>
            <p>Mohon tunggu, admin sedang mengecek pesanan kamu</p>
        `;
    }
    else if(status === "diproses"){
        statusCard.innerHTML = `
            <div class="order-id">No Pesanan: ${noPesanan}</div>
            <div class="check-icon">
                <i class="fa-solid fa-check"></i>
            </div>
            <h2>Pesanan Diproses</h2>
            <p>Pesanan kamu sedang dibuat dapur</p>
        `;
    }
    else if(status === "selesai"){
        statusCard.innerHTML = `
            <div class="order-id">No Pesanan: ${noPesanan}</div>
            <div class="check-icon done">
                <i class="fa-solid fa-utensils"></i>
            </div>
            <h2>Pesanan Selesai</h2>
            <p>Pesanan sudah selesai dan siap dinikmati 🍜</p>
            <p style="font-size: 12px; margin-top: 15px; color: #aaa;">
                Mengalihkan kembali ke menu dalam <span id="countdown">3</span> detik...
            </p>
        `;

        let waktuSisa = 3;
        const elemenCountdown = document.getElementById("countdown");

        const hitungMundur = setInterval(() => {
            waktuSisa--;
            if (elemenCountdown) elemenCountdown.textContent = waktuSisa;

            if (waktuSisa <= 0) {
                clearInterval(hitungMundur);
                window.location.href = "menu.php";
            }
        }, 1000); 
    }
    else {
        statusCard.innerHTML = `
            <div class="order-id">No Pesanan: ${noPesanan}</div>
            <div class="loader"></div>
            <h2>Memuat Status...</h2>
            <p>Sedang menghubungkan ke server, mohon tunggu.</p>
            <p style="font-size: 10px; color: #ccc; margin-top: 10px;">Status terdeteksi: "${status}"</p>
        `;
    }
}

renderStatus("<?= $status; ?>");
const cekInterval = setInterval(() => {
    if (currentStatus === "selesai") {
        clearInterval(cekInterval);
        return;
    }

    fetch("cek_status.php?id=<?= $id_pesanan; ?>")
    .then(response => response.text())
    .then(status => {
        if(status.trim() !== "") {
            renderStatus(status);
        }
    })
    .catch(err => console.log("Gagal memuat status:", err));
}, 3000);


</script>

</body>
</html>