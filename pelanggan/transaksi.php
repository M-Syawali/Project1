
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
}

/* ========================= */
/* MENU KANAN */
/* ========================= */

.menu-right{
    display: flex;
    align-items: center;
}

.dashboard-kosong{
    width: 140px;
    height: 45px;
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

    .dashboard-kosong{
        display: none;
    }
}

/* ========================= */
/* RESPONSIVE HP */
/* ========================= */

@media (max-width: 480px){

    .dashboard-header{
        padding: 1.05rem;
    }

    .logo{
        font-size: 1rem;
        letter-spacing: 1px;
    }

    .back-icon{
        font-size: 18px;
    }

    .dashboard-kosong{
        width: 70px;
        height: 40px;
    }
}

</style>
<body>
<div class="dashboard-header">
<div class="logo">
        <a href="keranjang.php" class="back-icon">
            <i class="fa-solid fa-angle-left"></i>
        </a>
        SagalaLada
        </div>
            <div class="menu-right">
                <div class="dashboard-kosong"></div>
            </div>
        </div>
        
</body>
</html>