<?php
// Session tetap dimulai agar sistem Anda yang lain tidak error
session_start(); 

include 'koneksi.php';

// AMBIL ID ADMIN OTOMATIS:
// Jika session ada, kita pakai. Jika kosong (karena bug session), 
// kita ambil ID Admin pertama yang ada di database Anda agar tidak merusak foreign key.
if (isset($_SESSION['id_admin']) && !empty($_SESSION['id_admin'])) {
    $id_admin = $_SESSION['id_admin'];
} else {
    // Mengambil ID Admin paling pertama dari database secara otomatis
    $ambil_admin = mysqli_query($conn, "SELECT id_admin FROM admin LIMIT 1");
    $data_admin  = mysqli_fetch_assoc($ambil_admin);
    $id_admin    = $data_admin['id_admin'];
}

// Ambil data kategori untuk opsi pilihan di form
$kategori_query = mysqli_query($conn, "SELECT * FROM kategori_menu");

if (isset($_POST['submit'])) {
    $nama_menu   = $_POST['nama_menu'];
    $id_kategori = $_POST['id_kategori_menu'];
    $harga       = $_POST['harga'];

    // Ambil data file gambar
    $gambar = $_FILES['gambar']['name'];
    $tmp    = $_FILES['gambar']['tmp_name'];

    // Biar nama file unik dan tidak bentrok saat di-upload
    $nama_gambar = time() . '_' . $gambar;

    $folder = "upload/";

    // OTOMATIS: Buat folder 'upload' jika belum ada di dalam project
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    // Pindahkan file gambar dari temporary server ke folder upload
    move_uploaded_file($tmp, $folder . $nama_gambar);

    // Query insert menggunakan $id_admin yang sudah didapatkan otomatis di atas
    // Hapus id_admin dari daftar kolom dan dari daftar VALUES
$insert = "INSERT INTO menu (nama_menu, id_kategori_menu, harga, gambar, stok, deskripsi_menu) 
           VALUES ('$nama_menu', '$id_kategori', '$harga', '$nama_gambar', 0, '')";
    if (mysqli_query($conn, $insert)) {
        // Jika berhasil, langsung dialihkan ke halaman utama admin
        header("Location: ../index_admin.php");
        exit();
    } else {
        // Jika gagal karena masalah database, munculkan pesan error
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
            --accent: #e74c3c; /* merah */
            --success: #2ecc71;
            --gray: #7f8c8d;
            --bg: #f4f6f8;
            --white: #ffffff;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background-color: var(--bg);
        }

        /* Container utama */
        .container {
            max-width: 500px;
            margin: 50px auto;
            background: var(--white);
            padding: 25px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }

        /* Judul */
        .container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: var(--primary);
        }

        /* Form group */
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
            color: var(--primary);
        }

        /* Input & select */
        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            transition: 0.2s;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: var(--accent);
            outline: none;
            box-shadow: 0 0 5px rgba(231, 76, 60, 0.3);
        }

        /* Button */
        .btn {
            padding: 10px 16px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: 0.2s;
        }

        /* Tombol simpan */
        .btn-success {
            background-color: var(--success);
            color: white;
        }

        .btn-success:hover {
            background-color: #27ae60;
        }

        /* Tombol kembali */
        .btn-primary {
            background-color: var(--gray);
            color: white;
        }

        .btn-primary:hover {
            background-color: #636e72;
        }

        /* Actions */
        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
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
                    <?php while($kat = mysqli_fetch_assoc($kategori_query)) { ?>
                        <option value="<?= $kat['id_kategori_menu']; ?>"><?= $kat['nama_kategori_menu']; ?></option>
                    <?php } ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Harga (Rp)</label>
                <input type="number" name="harga" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Gambar Menu</label>
                <input type="file" name="gambar" class="form-control" required>
            </div>
            
            <div class="form-actions" style="margin-top: 20px;">
                <button type="submit" name="submit" class="btn btn-success">Simpan Menu</button>
                <a href="../index_admin.php" class="btn btn-primary">Kembali</a>
            </div>
        </form>
    </div>
</body>
</html>