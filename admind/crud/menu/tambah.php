<?php
session_start(); 
include 'koneksi.php';

// AMBIL ID ADMIN OTOMATIS
if (isset($_SESSION['id_users']) && !empty($_SESSION['id_users'])) {
    $id_users = $_SESSION['id_users'];
} else {
    $ambil_users= mysqli_query($conn, "SELECT id_users FROM users LIMIT 1");
    $data_users = mysqli_fetch_assoc($ambil_users);
    $id_users   = $data_users['id_users'];
}

$kategori_query = mysqli_query($conn, "SELECT * FROM kategori_menu");

if (isset($_POST['submit'])) {
    $nama_menu   = $_POST['nama_menu'];
    $id_kategori = $_POST['id_kategori_menu'];
    $harga       = $_POST['harga'];
    $deskripsi   = $_POST['deskripsi_menu']; // Mengambil input deskripsi

    $gambar = $_FILES['gambar']['name'];
    $tmp    = $_FILES['gambar']['tmp_name'];
    $nama_gambar = time() . '_' . $gambar;
    $folder = "upload/";

    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    move_uploaded_file($tmp, $folder . $nama_gambar);

    // Query diperbaiki untuk memasukkan deskripsi_menu
    $insert = "INSERT INTO menu (nama_menu, id_kategori_menu, harga, gambar, id_users, deskripsi_menu) 
               VALUES ('$nama_menu', '$id_kategori', '$harga', '$nama_gambar', '$id_users', '$deskripsi')";
    
    if (mysqli_query($conn, $insert)) {
        header("Location: index_admin.php");
        exit();
    } else {
        echo "Gagal menambahkan data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu</title>
    <style>
        :root {
            --primary: #2c3e50;
            --accent: #e74c3c;
            --success: #2ecc71;
            --gray: #7f8c8d;
            --bg: #f4f6f8;
            --white: #ffffff;
        }
        body { margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, sans-serif; background-color: var(--bg); }
        .container { max-width: 500px; margin: 50px auto; background: var(--white); padding: 25px 30px; border-radius: 12px; box-shadow: 0 8px 20px rgba(0,0,0,0.08); }
        .container h2 { text-align: center; margin-bottom: 20px; color: var(--primary); }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 6px; color: var(--primary); }
        .form-control { width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 8px; font-size: 14px; box-sizing: border-box; }
        .form-control:focus { border-color: var(--accent); outline: none; box-shadow: 0 0 5px rgba(231, 76, 60, 0.3); }
        .btn { padding: 10px 16px; border-radius: 8px; border: none; cursor: pointer; font-weight: 600; text-decoration: none; display: inline-block; }
        .btn-success { background-color: var(--success); color: white; }
        .btn-primary { background-color: var(--gray); color: white; }
        .form-actions { display: flex; justify-content: space-between; align-items: center; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tambah Menu Baru</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Menu</label>
                <input type="text" name="nama_menu" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label>Kategori</label>
                <select name="id_kategori_menu" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php while($kat = mysqli_fetch_assoc($kategori_query)) : ?>
                        <option value="<?= $kat['id_kategori_menu']; ?>"><?= $kat['nama_kategori_menu']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Harga (Rp)</label>
                <input type="number" name="harga" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Deskripsi Menu</label>
                <textarea name="deskripsi_menu" class="form-control" rows="4" placeholder="Detail menu..." required></textarea>
            </div>

            <div class="form-group">
                <label>Gambar Menu</label>
                <input type="file" name="gambar" class="form-control" required>
            </div>
            
            <div class="form-actions">
                <button type="submit" name="submit" class="btn btn-success">Simpan Menu</button>
                <a href="index_admin.php" class="btn btn-primary">Kembali</a>
            </div>
        </form>
    </div>
</body>
</html>