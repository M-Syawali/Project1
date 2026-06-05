<?php
include '../menu/koneksi.php';

$id = $_GET['id'];

$data = mysqli_query($conn,
    "SELECT * FROM kategori_menu
     WHERE id_kategori_menu='$id'"
);

$row = mysqli_fetch_assoc($data);

if(isset($_POST['update']))
{
    $nama = $_POST['nama_kategori_menu'];

    mysqli_query($conn,
        "UPDATE kategori_menu
         SET nama_kategori_menu='$nama'
         WHERE id_kategori_menu='$id'"
    );

    header("Location: index_kategori.php");
    exit;
}
?>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    background:#f5f6fa;
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
}

.card{
    width:500px;
    background:white;
    padding:40px;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
}

h2{
    color:#8b1e2d;
    text-align:center;
    margin-bottom:25px;
    font-size:32px;
}

.form-group{
    margin-bottom:20px;
}

input{
    width:100%;
    padding:14px;
    border:1px solid #ddd;
    border-radius:12px;
    font-size:15px;
}

input:focus{
    outline:none;
    border-color:#8b1e2d;
}

.btn-group{
    display:flex;
    gap:10px;
}

.btn{
    flex:1;
    padding:14px;
    border:none;
    border-radius:12px;
    font-weight:600;
    cursor:pointer;
    text-decoration:none;
    text-align:center;
}

.btn-update{
    background:#8b1e2d;
    color:white;
}

.btn-kembali{
    background:#64748b;
    color:white;
}
</style>

<div class="card">

    <h2>Edit Kategori</h2>

    <form method="POST">

        <div class="form-group">
            <input
                type="text"
                name="nama_kategori_menu"
                value="<?= $row['nama_kategori_menu']; ?>"
                required>
        </div>

        <div class="btn-group">

            <button
                type="submit"
                name="update"
                class="btn btn-update">
                Update
            </button>

            <a
                href="index_kategori.php"
                class="btn btn-kembali">
                Kembali
            </a>

        </div>

    </form>

</div>