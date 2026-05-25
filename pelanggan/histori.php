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
    transition: 0.3s;
}

.back-icon:hover{
    transform: translateX(-4px);
}

/* ========================= */
/* MENU KANAN */
/* ========================= */

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
    font-weight: 600;
    transition: 0.3s;
}

.keranjang-link:hover{
    opacity: 0.8;
}

/* ========================= */
/* JUDUL HALAMAN */
/* ========================= */

.histori{
    padding: 20px;
}

.histori p{
    font-size: 28px;
    font-weight: bold;
    color: var(--primary-red);
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
        font-size: 22px;
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

    .histori{
        padding: 18px;
    }

    .histori p{
        font-size: 24px;
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
        gap: 6px;
    }

    .back-icon{
        font-size: 18px;
    }

    .menu-right{
        gap: 8px;
    }

    .dashboard-link{
        padding: 5px 10px;
        font-size: 12px;
    }

    .keranjang{
        font-size: 18px;
    }

    .keranjang-link{
        padding: 0;
    }

    .histori{
        padding: 15px;
    }

    .histori p{
        font-size: 20px;
    }
}

</style>
<body>
    <div class="dashboard-header">
            <div class="logo">
            <a href="dashboard.php" class="back-icon">
                <i class="fa-solid fa-angle-left"></i>
            </a>    
            SagalaLada</div>
            <div class="menu-right">
            <a href="dashboard.php" class="dashboard-link">Beranda</a>
            <div class="keranjang">
              <a href="keranjang.php" class="keranjang-link">
                  <i class="fa-solid fa-cart-shopping"> </i>
              </a>
            </div>
        </div>
    </div>
    <div class="histori">
        <p>Riwayat Pesanan</p>
    </div>
</body>
</html>