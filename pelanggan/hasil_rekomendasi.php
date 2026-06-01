<?php
include "koneksi.php";

$jenis = $_GET['jenis'] ?? '';

function getMenu($conn, $id_kategori) {
    $query = mysqli_query($conn, "SELECT * FROM menu WHERE id_kategori_menu = " . (int)$id_kategori . " ORDER BY RAND() LIMIT 1");
    return mysqli_fetch_assoc($query);
}

$makanan = ($jenis == "makanan" || $jenis == "semua") ? getMenu($conn, 18) : null;
$minuman = ($jenis == "minuman" || $jenis == "semua") ? getMenu($conn, 19) : null;
$data = ($jenis == "makanan") ? $makanan : $minuman;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekomendasi Menu</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        <style>
    * {
        margin:0;
        padding:0;
        box-sizing:border-box;
        font-family:'Poppins', sans-serif;
    }

    body {
        background:linear-gradient(135deg,#5c0f16,#8b1e2d);
        min-height:100vh;
        display:flex;
        justify-content:center;
        align-items:center;
        padding:20px;
    }

    .loading {
        color:white;
        text-align:center;
    }

    .loader {
        width:80px;
        height:80px;
        border:8px solid rgba(255,255,255,.2);
        border-top:8px solid white;
        border-radius:50%;
        margin:20px auto;
        animation:putar 1s linear infinite;
    }

    @keyframes putar {
        100% {
            transform:rotate(360deg);
        }
    }

    .result {
        display:none;
        width:100%;
        max-width:1000px;
    }

    .flex {
        display:flex;
        flex-wrap:wrap;
        gap:30px;
        justify-content:center;
        margin-bottom:30px;
    }

    .card {
        background:white;
        width:350px;
        border-radius:25px;
        overflow:hidden;
        box-shadow:0 15px 40px rgba(0,0,0,.25);
        animation:muncul .6s ease;
        text-align:center;
    }

    @keyframes muncul {
        from {
            opacity:0;
            transform:translateY(30px);
        }
        to {
            opacity:1;
            transform:translateY(0);
        }
    }

    .card img {
        width:100%;
        height:200px;
        object-fit:cover;
        display:block;
    }

    .content {
        padding:20px;
    }

    .nama {
        font-size:22px;
        font-weight:700;
        margin-top:5px;
    }

    .harga {
        font-size:18px;
        color:#8b1e2d;
        margin:10px 0;
        font-weight:700;
    }

    .btn {
        display:inline-block;
        padding:12px 25px;
        background:#8b1e2d;
        color:white;
        text-decoration:none;
        border-radius:12px;
        font-weight:600;
        transition:0.3s;
        cursor:pointer;
        border:none;
    }

    /* TOMBOL TAMBAH PAKET MERAH */
    .btn-paket {
        background:#8b1e2d;
        color:white;
        padding:15px 40px;
        font-size:18px;
        font-weight:700;
        border:none;
        border-radius:12px;
        box-shadow:0 6px 15px rgba(139,30,45,.4);
        transition:all .3s ease;
    }

    .btn:hover,
    .btn-paket:hover {
        background:#a5273a;
        transform:translateY(-3px) scale(1.05);
        box-shadow:0 10px 20px rgba(139,30,45,.5);
    }

    .footer-action {
        text-align:center;
    }

    .kembali {
        display:inline-block;
        margin-top:20px;
        padding:12px 25px;
        background:white;
        color:#8b1e2d;
        border-radius:12px;
        text-decoration:none;
        font-weight:bold;
        transition:.3s;
    }

    .kembali:hover {
        transform:scale(1.05);
    }

    /* Notifikasi */
    .notif-keranjang {
        display:none;
        position:fixed;
        top:0;
        left:0;
        width:100%;
        height:100%;
        background:rgba(0,0,0,0.6);
        z-index:9999;
        justify-content:center;
        align-items:center;
    }

    .notif-content {
        background:white;
        padding:40px;
        border-radius:20px;
        text-align:center;
        transform:scale(0.8);
        transition:0.3s;
    }

    .notif-keranjang.show {
        display:flex;
    }

    .success-checkmark {
        width:80px;
        height:80px;
        margin:0 auto 15px;
    }

    .check-icon {
        width:80px;
        height:80px;
        position:relative;
        border-radius:50%;
        border:4px solid #ffffff;
    }

    .icon-line {
        height:5px;
        background-color:#ffffff;
        display:block;
        border-radius:2px;
        position:absolute;
        z-index:10;
    }

    .line-tip {
        top:46px;
        left:14px;
        width:25px;
        transform:rotate(45deg);
        animation:icon-line-tip .75s;
    }

    .line-long {
        top:38px;
        right:8px;
        width:47px;
        transform:rotate(-45deg);
        animation:icon-line-long .75s;
    }

    @keyframes icon-line-tip {
        0% {
            width:0;
            left:1px;
            top:19px;
        }
        54% {
            width:0;
            left:1px;
            top:19px;
        }
        70% {
            width:50px;
            left:-8px;
            top:37px;
        }
        84% {
            width:17px;
            left:21px;
            top:48px;
        }
        100% {
            width:25px;
            left:14px;
            top:46px;
        }
    }

    @keyframes icon-line-long {
        0% {
            width:0;
            right:46px;
            top:54px;
        }
        65% {
            width:0;
            right:46px;
            top:54px;
        }
        84% {
            width:55px;
            right:0;
            top:35px;
        }
        100% {
            width:47px;
            right:8px;
            top:38px;
        }
    }
</style>
    </style>
</head>
<body>

<div class="loading" id="loading">
    <h2>Sedang memilih menu terbaik...</h2>
    <div class="loader"></div>
</div>

<div class="result" id="result">
    <div class="flex">
        <?php if($jenis == "semua"): ?>
            <div class="card">
                <img src="../admind/crud/menu/upload/<?= $makanan['gambar']; ?>" alt="Makanan">
                <div class="content">
                    <h2>🍽️ Makanan</h2>
                    <div class="nama"><?= $makanan['nama_menu']; ?></div>
                    <div class="harga">Rp <?= number_format($makanan['harga']); ?></div>
                </div>
            </div>
            <div class="card">
                <img src="../admind/crud/menu/upload/<?= $minuman['gambar']; ?>" alt="Minuman">
                <div class="content">
                    <h2>🥤 Minuman</h2>
                    <div class="nama"><?= $minuman['nama_menu']; ?></div>
                    <div class="harga">Rp <?= number_format($minuman['harga']); ?></div>
                </div>
            </div>
        <?php else: ?>
            <div class="card">
                <img src="../admind/crud/menu/upload/<?= $data['gambar']; ?>" alt="Menu">
                <div class="content">
                    <h2><?= ($jenis=="makanan") ? "🍽️ Makanan" : "🥤 Minuman"; ?></h2>
                    <div class="nama"><?= $data['nama_menu']; ?></div>
                    <div class="harga">Rp <?= number_format($data['harga']); ?></div>
                    <a href="tambah_keranjang.php?id=<?= $data['id_menu']; ?>" class="btn">🛒 Tambah ke Keranjang</a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="footer-action">
        <?php if($jenis == "semua"): ?>
            <a href="tambah_keranjang.php?id_m=<?= $makanan['id_menu']; ?>&id_min=<?= $minuman['id_menu']; ?>" class="btn btn-paket">🛒 Tambahkan Paket</a>
            <br>
        <?php endif; ?>
        <a href="rekomendasi.php" class="kembali">🔄 Cari Lagi</a>
    </div>
</div>

<div class="notif-keranjang" id="notif">
    <div class="notif-content">
        <div class="success-checkmark">
            <div class="check-icon">
                <span class="icon-line line-tip"></span>
                <span class="icon-line line-long"></span>
            </div>
        </div>
        <p><b>Berhasil!</b> Pesanan masuk keranjang.</p>
    </div>
</div>

<script>
    // Loading Screen
    setTimeout(function(){
        document.getElementById('loading').style.display='none';
        document.getElementById('result').style.display='block';
    }, 2500);

    // Animasi Klik
    document.querySelectorAll('.btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const targetUrl = this.href;
            document.getElementById('notif').classList.add('show');
            setTimeout(() => { window.location.href = targetUrl; }, 1500);
        });
    });
</script>

</body>
</html>