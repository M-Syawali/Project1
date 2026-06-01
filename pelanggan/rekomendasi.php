<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bingung Pilih Menu</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    min-height:100vh;
    background:linear-gradient(135deg,#5c0f16,#8b1e2d);
    display:flex;
    justify-content:center;
    align-items:center;
    padding:30px;
}

.container{
    width:100%;
    max-width:1200px;
}

.judul{
    text-align:center;
    color:white;
    margin-bottom:40px;
}

.judul h1{
    font-size:45px;
    margin-bottom:10px;
}

.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:25px;
}

.card{
    background:white;
    padding:35px;
    border-radius:25px;
    text-align:center;
    transition:.3s;
    box-shadow:0 15px 35px rgba(0,0,0,.25);
}

.card:hover{
    transform:translateY(-10px);
}

.icon{
    font-size:80px;
}

.card h2{
    margin:15px 0;
}

.card p{
    color:#666;
}

.btn{
    display:inline-block;
    margin-top:20px;
    padding:12px 25px;
    background:#8b1e2d;
    color:white;
    text-decoration:none;
    border-radius:12px;
}
</style>
</head>
<body>

<div class="container">

<div class="judul">
<h1>🤔 Bingung Mau Pesan Apa?</h1>
<p>Biarkan sistem memilihkan menu terbaik untuk Anda</p>
</div>

<div class="cards">

<div class="card">
<div class="icon">🍽️</div>
<h2>Makanan</h2>
<p>Sistem akan memilih makanan secara otomatis.</p>
<a href="hasil_rekomendasi.php?jenis=makanan" class="btn">
Pilih Makanan
</a>
</div>

<div class="card">
<div class="icon">🥤</div>
<h2>Minuman</h2>
<p>Sistem akan memilih minuman secara otomatis.</p>
<a href="hasil_rekomendasi.php?jenis=minuman" class="btn">
Pilih Minuman
</a>
</div>

<div class="card">
<div class="icon">🍽️🥤</div>
<h2>Makanan & Minuman</h2>
<p>Sistem memilih paket makanan dan minuman.</p>
<a href="hasil_rekomendasi.php?jenis=semua" class="btn">
Pilih Keduanya
</a>
</div>

</div>

</div>

</body>
</html>