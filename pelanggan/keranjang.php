<?php
session_start();
include "koneksi.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - SagalaLada</title>

    <link rel="stylesheet" href="css/style_keranjang.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>

    <div class="blur blur1"></div>
    <div class="blur blur2"></div>

    <header class="dashboard-header">
        <div class="logo">
            <a href="menu.php" class="back-icon">
                <i class="fa-solid fa-angle-left"></i>
            </a>
            <span>Keranjang</span>
        </div>
    </header>

    <div class="container">

        <div class="cart-card">

            <div class="title-area">
                <h2>Pesanan Anda</h2>
                <p>Cek kembali menu sebelum checkout 🍽️</p>
            </div>

            <div class="table-wrapper">

                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Menu</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php
                    $no = 1;
                    $total_belanja = 0;

                    if(!empty($_SESSION['keranjang'])){
                        foreach($_SESSION['keranjang'] as $id_menu => $jumlah){
                            $query = mysqli_query($conn, "SELECT * FROM menu WHERE id_menu='$id_menu'");
                            $data = mysqli_fetch_assoc($query);

                            $subtotal = $data['harga'] * $jumlah;
                            $total_belanja += $subtotal;
                    ?>

                        <tr>
                            <td><?= $no++; ?></td>

                            <td>
                                <div class="menu-info">
                                    <img src="../admind/crud/menu/upload/<?= $data['gambar']; ?>" alt="Foto Menu" class="img-cart">
                                    <div class="menu-name">
                                        <h4><?= $data['nama_menu']; ?></h4>
                                        <span>Menu pilihan anda</span>
                                    </div>
                                </div>
                            </td>

                            <td>
                                Rp <?= number_format($data['harga'],0,',','.'); ?>
                            </td>

                            <td>
                                <form action="update_jumlah.php" method="POST" class="qty-box">
                                    <input type="hidden" name="id_menu" value="<?= $id_menu; ?>">
                                    
                                    <button type="button" class="qty-btn minus-btn">-</button>
                                    <input type="number" name="jumlah" value="<?= $jumlah; ?>" min="1" class="qty-input">
                                    <button type="button" class="qty-btn plus-btn">+</button>
                                </form>
                            </td>

                            <td>
                                Rp <?= number_format($subtotal,0,',','.'); ?>
                            </td>

                            <td>
                                <a href="update_keranjang.php?id=<?= $id_menu; ?>&aksi=hapus" class="delete-btn" onclick="return confirm('Hapus menu ini?')">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>

                    <?php 
                        } 
                    } else { 
                    ?>
                        <tr>
                            <td colspan="6">
                                <div class="empty-cart">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                    <p>Keranjang masih kosong</p>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>

                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="4" class="total-text">Total Bayar</td>
                            <td colspan="2" class="total-price">
                                Rp <?= number_format($total_belanja,0,',','.'); ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>

            </div>

            <div class="button-area">
                <a href="menu.php" class="btn secondary-btn">
                    <i class="fa-solid fa-plus"></i> Tambah Menu
                </a>

                <?php if(!empty($_SESSION['keranjang'])): ?>
                    <a href="checkout.php" class="btn primary-btn">
                        Checkout <i class="fa-solid fa-arrow-right"></i>
                    </a>
                <?php endif; ?>
            </div>

        </div>
    </div>

<script>
const qtyForms = document.querySelectorAll('.qty-box');

qtyForms.forEach(form => {
    const input = form.querySelector('.qty-input');
    const plusBtn = form.querySelector('.plus-btn');
    const minusBtn = form.querySelector('.minus-btn');

    plusBtn.addEventListener('click', () => {
        input.value = parseInt(input.value) + 1;
        form.submit();
    });

    minusBtn.addEventListener('click', () => {
        if(parseInt(input.value) > 1){
            input.value = parseInt(input.value) - 1;
            form.submit();
        }
    });

    input.addEventListener('change', () => {
        if(input.value < 1){
            input.value = 1;
        }
        form.submit();
    });
});
</script>
</body>
</html>