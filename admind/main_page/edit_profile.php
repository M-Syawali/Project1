<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id_users'])) {
    header("Location: ../../login/index.php");
    exit;
}

$id_users = $_SESSION['id_users'];

$query = mysqli_query(
    $conn,
    "SELECT * FROM users WHERE id_users='$id_users'"
);

$user = mysqli_fetch_assoc($query);

if(!$user){
    die("Data user tidak ditemukan");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Profil</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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

.container{
    max-width:700px;
    margin:40px auto;
    background:white;
    padding:30px;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,.05);
}

h2{
    color:#8B000F;
    margin-bottom:25px;
}

.form-group{
    margin-bottom:20px;
}

label{
    display:block;
    margin-bottom:8px;
    font-weight:600;
}

input{
    width:100%;
    padding:14px;
    border:1px solid #ddd;
    border-radius:12px;
}

.btn-save{
    background:#8B000F;
    color:white;
    border:none;
    padding:14px 24px;
    border-radius:12px;
    cursor:pointer;
}

.btn-save:hover{
    opacity:.9;
}

.btn-back{
    text-decoration:none;
    color:#666;
    margin-left:15px;
}

</style>
</head>
<body>

<div class="container">

    <h2>Edit Profil</h2>

    <form action="proses_edit_profile.php" method="POST">

        <input
            type="hidden"
            name="id_users"
            value="<?= $user['id_users'] ?>">

        <div class="form-group">
            <label>Username</label>

            <input
                type="text"
                name="username"
                value="<?= htmlspecialchars($_SESSION['username']) ?>"
                required>
        </div>

        <div class="form-group">
            <label>Email</label>

            <input
                type="email"
                name="email"
                value="<?= htmlspecialchars($user['email']) ?>">
        </div>

        <button type="submit" class="btn-save">
            Simpan Perubahan
        </button>

        <a href="profile.php" class="btn-back">
            Kembali
        </a>

    </form>

</div>

</body>
</html>