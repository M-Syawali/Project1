<?php
include 'koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM menu WHERE id_menu = '$id'");
$data = mysqli_fetch_assoc($query);

$kategori_query = mysqli_query($conn, "SELECT * FROM kategori_menu");

if (isset($_POST['update'])) {
    $nama_menu   = $_POST['nama_menu'];
    $id_kategori = $_POST['id_kategori'];
    $harga       = $_POST['harga'];
    
    // Cek apakah ada gambar baru yang diupload
    if (!empty($_FILES['gambar']['name'])) {

        $gambar = $_FILES['gambar']['name'];
        $tmp    = $_FILES['gambar']['tmp_name'];

        // Validasi format gambar
        $ext = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png'];

        if(!in_array($ext, $allowed)){
            echo "<script>alert('Format gambar harus JPG/JPEG/PNG!'); window.history.back();</script>";
            exit;
        }

        // Rename file biar unik
        $nama_gambar = time() . '_' . $gambar;
        $folder = "upload/";

        // Otomatis bikin folder jika belum ada
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        // Upload file
        if (move_uploaded_file($tmp, $folder . $nama_gambar)) {
            // Hapus gambar lama dari folder jika ada
            if (!empty($data['gambar']) && file_exists($folder . $data['gambar'])) {
                unlink($folder . $data['gambar']);
            }

            // Jalur 1: Query UPDATE dengan gambar baru
            // CATATAN: ganti 'id_kategori_menu' di bawah ini dengan nama kolom asli di databasemu jika masih error
            $update = "UPDATE menu SET 
                        nama_menu='$nama_menu', 
                        id_kategori_menu='$id_kategori', 
                        harga='$harga', 
                        gambar='$nama_gambar' 
                       WHERE id_menu='$id'";
        } else {
            echo "Upload gambar gagal!";
            exit;
        }

    } else {
        // Jalur 2: Query UPDATE tanpa ganti gambar
        // CATATAN: ganti 'id_kategori_menu' di bawah ini dengan nama kolom asli di databasemu jika masih error
        $update = "UPDATE menu SET 
                    nama_menu='$nama_menu', 
                    id_kategori_menu='$id_kategori', 
                    harga='$harga' 
                   WHERE id_menu='$id'";
    }

    // Eksekusi query ke database
    if (mysqli_query($conn, $update)) {
        header("Location:../index_admin.php");
        exit();
    } else {
        echo "Gagal memperbarui data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu</title>
    <style>
        :root {
    --primary: #2c3e50;
    --accent: #e74c3c; /* merah */
    --success: #2ecc71;
    --bg: #f5f6fa;
    --text: #2f3640;
}

/* Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: var(--bg);
    color: var(--text);
}

/* Container */
.container {
    width: 100%;
    max-width: 500px;
    background: white;
    margin: 50px auto;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

/* Title */
h2 {
    text-align: center;
    margin-bottom: 20px;
    color: var(--primary);
}

/* Form */
.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: 600;
}

/* Input & Select */
.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #dcdde1;
    border-radius: 6px;
    font-size: 14px;
    transition: 0.3s;
}

.form-control:focus {
    border-color: var(--accent);
    outline: none;
    box-shadow: 0 0 5px rgba(231, 76, 60, 0.3);
}

/* Image preview */
img {
    border-radius: 6px;
    margin-top: 10px;
}

/* Buttons */
.form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.btn {
    padding: 10px 18px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-weight: 600;
    text-decoration: none;
    transition: 0.3s;
}

/* Button Colors */
.btn-success {
    background-color: var(--success);
    color: white;
}

.btn-success:hover {
    background-color: #27ae60;
}

.btn-primary {
    background-color: #7f8c8d;
    color: white;
}

.btn-primary:hover {
    background-color: #636e72;
}

/* Responsive */
@media (max-width: 600px) {
    .container {
        margin: 20px;
        padding: 20px;
    }

    .form-actions {
        flex-direction: column;
        gap: 10px;
    }

    .btn {
        width: 100%;
        text-align: center;
    }
}
    </style>
    
</head>
<body>
    <div class="container">
        <h2>Edit Menu</h2>
        <form action="" method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label>Nama Menu</label>
                <input type="text" name="nama_menu" value="<?= htmlspecialchars($data['nama_menu']); ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Kategori</label>
                <select name="id_kategori" class="form-control" required>
                    <?php while($kat = mysqli_fetch_assoc($kategori_query)) { ?>
                        <option value="<?= $kat['id_kategori_menu']; ?>" <?= $kat['id_kategori_menu'] == $data['id_kategori_menu'] ? 'selected' : ''; ?>>
                            <?= $kat['nama_kategori_menu']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label>Harga (Rp)</label>
                <input type="number" name="harga" value="<?= $data['harga']; ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Gambar Saat Ini</label><br>
                <?php if (!empty($data['gambar']) && file_exists("upload/" . $data['gambar'])) { ?>
                    <img src="upload/<?= $data['gambar']; ?>" width="120" style="border-radius: 4px; margin-top: 5px;">
                <?php } else { ?>
                    <p style="color: #e74c3c; font-style: italic;">Tidak ada gambar / file hilang</p>
                <?php } ?>
            </div>

            <div class="form-group" style="margin-top: 15px;">
                <label>Ganti Gambar *(Kosongkan jika tidak ingin diubah)</label>
                <input type="file" name="gambar" class="form-control">
            </div>

            <div class="form-actions" style="margin-top: 20px;">
                <button type="submit" name="update" class="btn btn-success">Perbarui Menu</button>
                <a href="../index_admin.php" class="btn btn-primary" style="background-color: #7f8c8d; text-decoration: none; padding: 8px 15px; border-radius: 4px; display: inline-block;">Kembali</a>
            </div>

        </form>
    </div>
</body>
</html>