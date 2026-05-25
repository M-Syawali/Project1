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
    padding-bottom: 120px;
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

/* ========================= */
/* JUDUL */
/* ========================= */

.keranjang p{
    font-size: 28px;
    font-weight: bold;
    color: var(--primary-red);
    margin: 20px;
}

/* ========================= */
/* CHECKOUT BAR */
/* ========================= */

.checkout-bar{
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background: white;
    padding: 18px 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
    z-index: 999;
}

/* ========================= */
/* KIRI */
/* ========================= */

.checkout-left{
    display: flex;
    align-items: center;
    gap: 10px;
}

.check-all{
    width: 22px;
    height: 22px;
    accent-color: var(--primary-red);
    cursor: pointer;
}

.checkout-left label{
    font-size: 17px;
    font-weight: 600;
}

/* ========================= */
/* KANAN */
/* ========================= */

.checkout-right{
    display: flex;
    align-items: center;
    gap: 20px;
}

/* ========================= */
/* TOTAL */
/* ========================= */

.total-section p{
    font-size: 13px;
    color: gray;
}

.total-section h3{
    color: var(--primary-red);
    font-size: 24px;
    font-weight: bold;
}

/* ========================= */
/* BUTTON */
/* ========================= */

.checkout-btn{
    background: var(--primary-red);
    color: white;
    text-decoration: none;
    padding: 14px 28px;
    border-radius: 40px;
    font-weight: bold;
    display: flex;
    align-items: center;
    gap: 10px;

    transition: 0.3s;
}

.checkout-btn:hover{
    background: var(--dark-red);
    transform: scale(1.05);
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

    .dashboard-link{
        padding: 6px 14px;
        font-size: 14px;
    }

    .keranjang p{
        font-size: 24px;
    }

    .checkout-bar{
        padding: 15px;
        gap: 15px;
    }

    .checkout-right{
        gap: 15px;
    }

    .total-section h3{
        font-size: 20px;
    }

    .checkout-btn{
        padding: 12px 20px;
        font-size: 14px;
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
        padding: 5px 10px;
        font-size: 12px;
    }

    .keranjang p{
        font-size: 20px;
        margin: 15px;
    }

    .checkout-bar{
        flex-direction: column;
        align-items: stretch;
        gap: 15px;
        padding: 15px;
    }

    .checkout-left{
        justify-content: left;
    }

    .checkout-right{
        width: 100%;

        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .total-section h3{
        font-size: 18px;
    }

    .checkout-btn{
        padding: 12px 18px;
        font-size: 13px;
    }
}
</style>
<body>
    <div class="dashboard-header">
            <div class="logo">
            <a href="menu.php" class="back-icon">
                <i class="fa-solid fa-angle-left"></i>
            </a>    
            SagalaLada</div>
            <div class="menu-right">
            <a href="dashboard.php" class="dashboard-link">Beranda</a>
        </div>
    </div>
    <div class="keranjang">
        <p>Keranjang Pesanan</p>
    </div>
    <div class="checkout-bar">
    <div class="checkout-left">
        <input type="checkbox" class="check-all">
        <label>Pilih Semua</label>
    </div>
    <div class="checkout-right">
        <div class="total-section">
            <p>Total</p>
            <h3>Rp 75.000</h3>
        </div>
        <a href="transaksi.php" class="checkout-btn">
            Check Out
        </a>
    </div>
</div>
</body>
</html>