<style>
    :root {
    --primary: #2c3e50;
    --accent: #e74c3c;
    --bg: #f5f6fa;
    --text: #2f3640;
}

body {
    font-family: 'Segoe UI', Tahoma, sans-serif;
    background-color: var(--bg);
    color: var(--text);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Container Form */
form {
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    width: 320px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

/* Judul */
h2 {
    text-align: center;
    margin-bottom: 20px;
    margin-right: 20px;
}

/* Input */
input[type="text"] {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
    margin-bottom: 15px;
    font-size: 14px;
    transition: 0.2s;
}

input[type="text"]:focus {
    border-color: var(--accent);
    outline: none;
}

/* Button */
button {
    width: 100%;
    padding: 10px;
    border: none;
    background: var(--accent);
    color: white;
    font-weight: bold;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.2s;
}

button:hover {
    background: #c0392b;
}
</style>
<?php
include '../menu/koneksi.php';

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama_kategori_menu'];

    mysqli_query($conn, "INSERT INTO kategori_menu (nama_kategori_menu) VALUES ('$nama')");
    header("Location: index_kategori.php");
}
?>

<h2>Tambah Kategori</h2>

<form method="POST">
    <input type="text" name="nama_kategori_menu" placeholder="Nama Kategori" required>
    <button type="submit" name="simpan">Simpan</button>
</form>