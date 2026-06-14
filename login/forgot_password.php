<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Lupa Password - SagalaLada</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
    padding:20px;
    overflow:hidden;
    background:
    radial-gradient(circle at top right,
    rgba(255,255,255,.08) 0,
    rgba(255,255,255,.08) 220px,
    transparent 220px),

    radial-gradient(circle at bottom left,
    rgba(255,255,255,.08) 0,
    rgba(255,255,255,.08) 220px,
    transparent 220px),

    linear-gradient(135deg,#7d0a0a,#a31621);
}

.reset-card{
    width:100%;
    max-width:520px;
    background:#fff;
    border-radius:24px;
    overflow:hidden;
    box-shadow:0 20px 40px rgba(0,0,0,.15);
}

.top-header{
    height:180px;
    background:linear-gradient(135deg,#7d0a0a,#b91c1c);
    position:relative;
}

.top-header::after{
    content:'';
    position:absolute;
    bottom:-50px;
    left:0;
    width:100%;
    height:100px;
    background:white;
    border-radius:50%;
}

.lock-icon{
    width:80px;
    height:80px;
    background:#fff5f5;
    border-radius:50%;
    position:absolute;
    left:50%;
    transform:translateX(-50%);
    bottom:-40px;
    z-index:10;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:34px;
}

.content{
    padding:60px 35px 30px;
}

.content h2{
    text-align:center;
    color:#8b1e2d;
    font-size:36px;
    margin-bottom:12px;
}

.content p{
    text-align:center;
    color:#6b7280;
    margin-bottom:35px;
}

.input-group{
    display:flex;
    align-items:center;
    border:1px solid #e5e7eb;
    border-radius:16px;
    overflow:hidden;
    margin-bottom:25px;
}

.input-icon{
    width:60px;
    background:#fff1f2;
    text-align:center;
    font-size:20px;
    color:#8b1e2d;
    padding:14px;
}

.input-group input{
    flex:1;
    border:none;
    padding:14px;
    font-size:15px;
    outline:none;
}

.btn-reset{
    width:100%;
    border:none;
    cursor:pointer;
    border-radius:14px;
    padding:14px;

    background:linear-gradient(
        135deg,
        #8b1e2d,
        #b91c1c
    );

    color:white;
    font-size:16px;
    font-weight:600;
}

.btn-reset:hover{
    transform:translateY(-2px);
    box-shadow:0 12px 25px rgba(139,30,45,.25);
}

.back-login{
    display:block;
    text-align:center;
    margin-top:25px;
    text-decoration:none;
    color:#8b1e2d;
    font-weight:600;
}

.back-login:hover{
    text-decoration:underline;
}
</style>
</head>

<body>

<div class="reset-card">

    <div class="top-header">
        <div class="lock-icon">🔒</div>
    </div>

    <div class="content">

        <h2>Reset Password</h2>

        <p>
            Masukkan email Anda untuk menerima
            link reset password.
        </p>

        <form action="send_reset.php" method="POST">

            <div class="input-group">
                <div class="input-icon">✉</div>

                <input
                    type="email"
                    name="email"
                    placeholder="Masukkan Email"
                    required>
            </div>

            <button class="btn-reset" type="submit">
                Kirim Link Reset
            </button>

        </form>

        <a href="index.php" class="back-login">
            ← Kembali ke halaman login
        </a>

    </div>

</div>

</body>
</html>