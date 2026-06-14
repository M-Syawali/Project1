<?php
session_start();

if (!isset($_SESSION['id_users'])) {
    header("Location: ../../login/index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Ubah Password</title>

<link rel="stylesheet" href="../asset/style_sidebar.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<script src="https://unpkg.com/feather-icons"></script>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    background:#f5f7fb;
}

.main-content{
    margin-left:260px;
    padding:30px;
}

/* TOPBAR */

.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.navbar-left h2{
    font-size:36px;
    font-weight:700;
    color:#222;
    margin-bottom:5px;
}

.navbar-left p{
    color:#777;
    font-size:14px;
}

.profile{
    position:relative;
}

#profile-btn{
    display:flex;
    align-items:center;
    gap:10px;
    border:none;
    background:white;
    padding:12px 18px;
    border-radius:14px;
    cursor:pointer;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
}

.profile-menu{
    position:absolute;
    top:60px;
    right:0;
    width:240px;
    background:white;
    border-radius:14px;
    overflow:hidden;
    display:none;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
    z-index:999;
}

.profile-menu.show{
    display:block;
}

.profile-menu a{
    display:flex;
    align-items:center;
    gap:10px;
    padding:14px 18px;
    text-decoration:none;
    color:#333;
}

.profile-menu a:hover{
    background:#f5f5f5;
}

/* CARD */

.password-card{
    background:white;
    border-radius:24px;
    padding:30px;
    box-shadow:0 5px 20px rgba(0,0,0,.05);

    max-width:1000px;
    margin-left:auto;
    margin-right:auto;
}

.password-card h2{
    color:#8B000F;
    margin-bottom:25px;
}

.form-group{
    margin-bottom:20px;
}

.form-group label{
    display:block;
    margin-bottom:8px;
    font-weight:600;
    color:#555;
}

.form-group input{
    width:100%;
    padding:15px;
    border:1px solid #ddd;
    border-radius:12px;
    background:#fafafa;
}

.form-group input:focus{
    outline:none;
    border-color:#8B000F;
}

.btn-save{
    background:#8B000F;
    color:white;
    border:none;
    padding:14px 25px;
    border-radius:12px;
    cursor:pointer;
    font-size:15px;
    font-weight:500;
}

.btn-save:hover{
    opacity:.9;
}

</style>
</head>
<body>

<?php $halaman = "profile"; ?>
<?php include "../components/sidebar.php"; ?>

<div class="main-content">

    <header class="navbar">

        <div class="navbar-left">
            <h2>Ubah Password</h2>
            <p>Kelola keamanan akun administrator.</p>
        </div>

        <div class="navbar-right">

            <div class="profile">

                <button id="profile-btn">
                    <i data-feather="user"></i>
                    <span><?= htmlspecialchars($_SESSION['username']) ?></span>
                    <i data-feather="chevron-down"></i>
                </button>

                <div class="profile-menu" id="profile-menu">

                    <a href="profile.php">
                        <i data-feather="user"></i>
                        Profil
                    </a>

                    <a href="ubah_password.php">
                        <i data-feather="lock"></i>
                        Ubah Password
                    </a>

                    <a href="/project1/login/logout.php">
                        <i data-feather="log-out"></i>
                        Logout
                    </a>

                </div>

            </div>

        </div>

    </header>
    

    <div class="password-card">

        <h2>Form Ubah Password</h2>

        <form action="proses_ubah_password.php" method="POST">

            <div class="form-group">
                <label>Password Lama</label>
                <input
                    type="password"
                    name="password_lama"
                    required>
            </div>

            <div class="form-group">
                <label>Password Baru</label>
                <input
                    type="password"
                    name="password_baru"
                    minlength="8"
                    required>
            </div>

            <div class="form-group">
                <label>Konfirmasi Password Baru</label>
                <input
                    type="password"
                    name="konfirmasi_password"
                    minlength="8"
                    required>
            </div>

            <button type="submit" class="btn-save">
                Simpan Password
            </button>

        </form>

    </div>

</div>

<script>

feather.replace();

const profileBtn = document.getElementById("profile-btn");
const profileMenu = document.getElementById("profile-menu");

if(profileBtn && profileMenu){

    profileBtn.addEventListener("click", function(e){
        e.stopPropagation();
        profileMenu.classList.toggle("show");
    });

    document.addEventListener("click", function(){
        profileMenu.classList.remove("show");
    });

}

</script>

</body>
</html>