<?php
session_start();
include "koneksi.php";

/*
|--------------------------------------------------------------------------
| CEK LOGIN
|--------------------------------------------------------------------------
*/

if (
    !isset($_SESSION['id_users']) ||
    !isset($_SESSION['username'])
) {
    header("Location: ../../login/index.php");
    exit;
}

$id_users = $_SESSION['id_users'];
$username = $_SESSION['username'];

/*
|--------------------------------------------------------------------------
| AMBIL DATA USER
|--------------------------------------------------------------------------
*/

$query = mysqli_query(
    $conn,
    "SELECT * FROM users
     WHERE id_users='$id_users'"
);

if (!$query) {
    die("Query Error : " . mysqli_error($conn));
}

$admin = mysqli_fetch_assoc($query);

if (!$admin) {
    die("Data user tidak ditemukan");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Profil Admin</title>

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

/* HEADER */

.profile-header{
    background:linear-gradient(135deg,#8B000F,#B11226);
    border-radius:24px;
    padding:40px;
    display:flex;
    align-items:center;
    gap:30px;
    color:white;
    box-shadow:0 10px 30px rgba(139,0,15,.15);
    margin-bottom:25px;
    max-width:1000px;
    margin-left:auto;
    margin-right:auto;
}

.profile-avatar{
    width:120px;
    height:120px;
    border-radius:50%;
    background:white;

    display:flex;
    align-items:center;
    justify-content:center;

    box-shadow:0 8px 20px rgba(0,0,0,.12);
}

.profile-avatar i{
    width:55px;
    height:55px;
    color:#8B000F;
}

.profile-info h2{
    font-size:30px;
    margin-bottom:5px;
}

.profile-info p{
    opacity:.9;
}

/* CARD */

.profile-card{
    background:white;
    border-radius:24px;
    padding:30px;
    box-shadow:0 5px 20px rgba(0,0,0,.05);
    max-width:1000px;
    margin-left:auto;
    margin-right:auto;
}

.card-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.card-header h3{
    color:#8B000F;
}

.btn-edit{
    display:flex;
    align-items:center;
    gap:8px;

    background:#8B000F;
    color:white;
    text-decoration:none;

    padding:12px 18px;
    border-radius:12px;

    font-weight:500;
}

.btn-edit:hover{
    opacity:.9;
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
    padding:14px;
    border:1px solid #ddd;
    border-radius:12px;
    background:#f8f8f8;
    color:#444;
}

/* TOPBAR */

.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
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

    transition:.3s;
}

.profile-menu a:hover{
    background:#f5f5f5;
}

</style>

</head>
<body>

<?php $halaman = "profile"; ?>
<?php include "../components/sidebar.php"; ?>

<div class="main-content">

<header class="navbar">

    <div class="navbar-left">
        <h2>Profil Admin</h2>
        <p>Kelola informasi akun administrator dan keamanan akun.</p>
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

    <div class="profile-card">

        <div class="card-header">

            <h3>Informasi Akun</h3>

            <a href="edit_profile.php" class="btn-edit">
                <i data-feather="edit"></i>
                Edit Profil
            </a>

        </div>

        <div class="form-group">
            <label>Username</label>

            <input
type="text"
value="<?= $_SESSION['username']; ?>"
readonly>
        </div>

        <div class="form-group">
            <label>Email</label>

            <input
                type="text"
                value="<?= !empty($admin['email']) ? htmlspecialchars($admin['email']) : 'Belum diisi' ?>"
                readonly>
        </div>

        <div class="form-group">
            <label>Role</label>

            <input
                type="text"
                value="<?= htmlspecialchars($admin['role']) ?>"
                readonly>
        </div>

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