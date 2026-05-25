
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Pembeli</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<style>
        :root {
    --primary-red: #e42121;
    --dark-red: #b71c1c;
    --black: #212121;
    --dark-gray: #383838;
    --light-gray: #f5f5f5;
    --text-light: #ffffff;
    --white: #ffffff;
    --text-dark: #212121;
    --sidebar-width: 260px;
    --navbar-height: 64px;
    --shadow: 0 2px 10px rgba(0,0,0,0.2);
}

*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins';
}

body{
    background: var(--light-gray);
}

/* ========================= */
/* HEADER */
/* ========================= */

.dashboard-header{
    background: var(--primary-red);
    color: var(--white);
    padding: 1.2rem 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: var(--shadow);
}

.logo{
    font-size: 1.5rem;
    font-weight: bold;
    letter-spacing: 2px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.back-icon{
    font-size: 25px;
    color: white;
    text-decoration: none;
}

.menu-right{
    display: flex;
    align-items: center;
    gap: 15px;
}

.dashboard-link{
    text-decoration: none;
    color: white;
    padding: 8px 18px;
    border: 2px solid white;
    border-radius: 30px;
    font-weight: 600;
    transition: 0.3s;
}

.dashboard-link:hover{
    background: white;
    color: var(--primary-red);
}

.keranjang{
    font-size: 25px;
}

.keranjang-link{
    color: white;
    padding: 1px 10px;
}

/* ========================= */
/* CONTAINER */
/* ========================= */

.container{
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
}

/* ========================= */
/* TITLE */
/* ========================= */

p{
    text-align: center;
    font-weight: bold;
    font-size: 30px;
    color: var(--primary-red);
    margin-bottom: 20px;
}

/* ========================= */
/* SEARCH & DROPDOWN */
/* ========================= */

.search-wrapper{
    display: flex;
    justify-content: center;
    gap: 10px;
    flex-wrap: wrap;
}

.search-container{
    width: 250px;
}

.search-box{
    width: 100%;
    position: relative;
}

.search-box input{
    width: 100%;
    padding: 12px 45px 12px 20px;
    border: 2px solid #ddd;
    border-radius: 30px;
    font-size: 16px;
    outline: none;
    transition: 0.3s;
}

.search-box input:focus{
    border-color: var(--primary-red);
    box-shadow: 0 0 8px rgba(211, 47, 47, 0.2);
}

.search-box i{
    position: absolute;
    right: 18px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--primary-red);
}

/* ========================= */
/* DROPDOWN */
/* ========================= */

.dropdown-container{
    position: relative;
    width: 250px;
}

.dropdown-menu{
    width: 100%;
    padding: 12px 45px 12px 20px;
    border: 2px solid #ddd;
    border-radius: 30px;
    font-size: 16px;
    outline: none;
    appearance: none;
    cursor: pointer;
    background: white;
    transition: 0.3s;
}

.dropdown-menu:focus{
    border-color: var(--primary-red);
    box-shadow: 0 0 8px rgba(211, 47, 47, 0.2);
}

.dropdown-icon{
    position: absolute;
    right: 18px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--primary-red);
    pointer-events: none;
}

/* ========================= */
/* RESPONSIVE TABLET */
/* ========================= */

@media (max-width: 768px){

    .dashboard-header{
        padding: 1rem;
    }

    .logo{
        font-size: 1.2rem;
        gap: 8px;
    }

    .back-icon{
        font-size: 20px;
    }

    .menu-right{
        gap: 10px;
    }

    .dashboard-link{
        padding: 6px 14px;
        font-size: 14px;
    }

    .keranjang{
        font-size: 22px;
    }

    p{
        font-size: 24px;
    }

    .search-wrapper{
        flex-direction: column;
        align-items: center;
    }

    .search-container,
    .dropdown-container{
        width: 100%;
        max-width: 350px;
    }
}

/* ========================= */
/* RESPONSIVE HP */
/* ========================= */

@media (max-width: 480px){

    .dashboard-header{
        padding: 0.9rem;
    }

    .logo{
        font-size: 1rem;
        letter-spacing: 1px;
    }

    .back-icon{
        font-size: 18px;
    }

    .dashboard-link{
        padding: 5px 12px;
        font-size: 12px;
    }

    .keranjang{
        font-size: 20px;
    }

    p{
        font-size: 20px;
        margin-bottom: 15px;
    }

    .container{
        padding: 15px;
    }

    .search-container,
    .dropdown-container{
        max-width: 80%;
    }

    .search-box input,
    .dropdown-menu{
        font-size: 14px;
        padding: 10px 40px 10px 15px;
    }

    .search-box i,
    .dropdown-icon{
        right: 15px;
        font-size: 14px;
    }
}
    

</style>
<body>
    <?php 
    // 1. Koneksi (Karena satu folder dengan menu.php)
    include "koneksi.php"; 

    if (!isset($conn)) {
        die("Error: Variabel \$conn tidak ditemukan di koneksi.php");
    }

    // 2. Logika Pencarian & Filter
    $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
    $kategori = isset($_GET['kategori']) ? mysqli_real_escape_string($conn, $_GET['kategori']) : '';

    $query = "SELECT * FROM menu WHERE nama_menu LIKE '%$search%'";
    if ($kategori != "") {
        $query .= " AND id_kategori_menu = '$kategori'";
    }
    $result = mysqli_query($conn, $query);
    ?>

    <div class="dashboard-header">
        <div class="logo">
            <a href="dashboard.php" class="back-icon">
                <i class="fa-solid fa-angle-left"></i>
            </a>
            SagalaLada
        </div>
        <div class="menu-right">
            <a href="../index.html" class="dashboard-link">Beranda</a>
            <div class="keranjang">
                <a href="keranjang.php" class="keranjang-link">
                    <i class="fa-solid fa-cart-shopping"> </i>
                </a>
            </div>
        </div>
    </div>

    <div class="container">
    <p>silahkan pilih menu pesanan</p>

    <form action="" method="GET">
        <div class="search-wrapper">
            <div class="search-container">
                <div class="search-box">
                    <input type="text" name="search" placeholder="Cari menu..." value="<?php echo htmlspecialchars($search); ?>" autocomplete="off">
                    <i class="fas fa-search"></i>
                </div>
            </div>

            <div class="dropdown-container">
                <select name="kategori" class="dropdown-menu" onchange="this.form.submit()">
                    <option value="">Pilih Kategori</option>
                    <?php
                    // Query kategori dari database
                    $query_kat = mysqli_query($conn, "SELECT * FROM kategori_menu");
                    while($data = mysqli_fetch_array($query_kat)) {
                        $selected = ($kategori == $data['id_kategori_menu']) ? 'selected' : '';
                        echo "<option value='".$data['id_kategori_menu']."' $selected>".$data['nama_kategori_menu']."</option>";
                    }
                    ?>
                </select>
                <i class="fas fa-chevron-down dropdown-icon"></i>
            </div>
        </div>
    </form> <div class="menu-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; margin-top: 40px; width: 100%;">
        <?php 
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $foto = "../admind/crud/menu/upload/" . $row['gambar'];
        ?>
            <div class="card-menu" style="background: #fff; padding: 15px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center;">
                <img src="<?php echo $foto; ?>" style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px;" alt="Menu">
                
                <h4 style="margin-top: 10px;"><?php echo $row['nama_menu']; ?></h4>
                <p style="font-size: 14px; color: #666; font-weight: normal; margin-bottom: 10px;">
                    <?php echo $row['deskripsi_menu']; ?>
                </p>
                
                <div style="font-weight: bold; color: var(--primary-red); margin-bottom: 15px;">
                    Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?>
                </div>
                
                <a href="tambah_keranjang.php?id=<?php echo $row['id_menu']; ?>" style="display: inline-block; background: var(--primary-red); color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-size: 14px;">
                    + Keranjang
                </a>
            </div>
        <?php 
            }
        } else {
            // Jika kosong, tampilkan pesan di tengah bawah
            echo "<div style='grid-column: 1/-1; text-align: center; padding: 50px 0;'>
                    <h3 style='color: var(--primary-red);'>Menu tidak tersedia.</h3>
                  </div>";
        }
        ?>
    </div>
</div>

        <div class="menu-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; margin-top: 30px;">
            <?php 
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    // JALUR GAMBAR: Keluar folder pelanggan, masuk ke folder upload admin
                    $foto = "../admind/crud/menu/upload/" . $row['gambar'];
            ?>
                <div class="card-menu" style="background: #fff; padding: 15px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center;">
                    <img src="<?php echo $foto; ?>" style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px;" alt="Menu">
                    
                    <h4 style="margin-top: 10px;"><?php echo $row['nama_menu']; ?></h4>
                    <p style="font-size: 14px; color: #666; font-weight: normal; margin-bottom: 10px;">
                        <?php echo $row['deskripsi_menu']; ?>
                    </p>
                    
                    <div style="font-weight: bold; color: #e42121; margin-bottom: 15px;">
                        Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?>
                    </div>
                    
                    <a href="tambah_keranjang.php?id=<?php echo $row['id_menu']; ?>" style="display: inline-block; background: #e42121; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-size: 14px;">
                        + Keranjang
                    </a>
                </div>
            <?php 
                }
            } else {
            }
            ?>
        </div>
    </div>
</body>