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
    <style>
        .img-cart {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,0.1);
        }
        table td { vertical-align: middle !important; }
        
        /* Tambahan styling untuk form opsi pedas & catatan */
        .cart-details-form {
            margin-top: 8px;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .select-pedas {
            padding: 4px 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 12px;
            width: 120px;
        }
        .input-catatan {
            padding: 4px 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 12px;
            width: 180px;
        }
    </style>
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
                            <th>Foto</th>
                            <th>Menu & Detail</th>
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

                    if (!empty($_SESSION['keranjang'])) {
                        // Looping session dengan struktur array baru
                        foreach ($_SESSION['keranjang'] as $id_menu => $item) {
                            $jumlah = $item['jumlah'];
                            $pedas_aktif = $item['pedas'];
                            $catatan_aktif = $item['catatan'];

                            // Query mengambil data menu berdasarkan ID
                            $query = mysqli_query($conn, "SELECT * FROM menu WHERE id_menu='$id_menu'");
                            $data = mysqli_fetch_assoc($query);

                            $subtotal = $data['harga'] * $jumlah;
                            $total_belanja += $subtotal;
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td>
                                <img src="../admind/crud/menu/upload/<?= $data['gambar']; ?>" alt="Foto Menu" class="img-cart">
                            </td>
                            <td class="menu-name">
                                <b><?= $data['nama_menu']; ?></b>
                                
                                <!-- Form untuk update Pedas dan Catatan (Otomatis Submit saat diganti/blur) -->
                                <form action="update_keranjang.php" method="POST" class="cart-details-form">
                                    <input type="hidden" name="id_menu" value="<?= $id_menu; ?>">
                                    
                                    <div>
                                        <label style="font-size: 11px; color:#666;">Pedas:</label>
                                        <select name="pedas" class="select-pedas" onchange="this.form.submit()">
                                            <option value="Original" <?= $pedas_aktif == 'Original' ? 'selected' : ''; ?>>sedikit</option>
                                            <option value="Sedang" <?= $pedas_aktif == 'Sedang' ? 'selected' : ''; ?>>Sedang</option>
                                            <option value="Pedas" <?= $pedas_aktif == 'Pedas' ? 'selected' : ''; ?>>Pedas</option>
                                            <option value="Gila" <?= $pedas_aktif == 'Gila' ? 'selected' : ''; ?>>Ekstra Pedas</option>
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <input type="text" name="catatan" class="input-catatan" placeholder="Tambah catatan" value="<?= htmlspecialchars($catatan_aktif); ?>" onblur="this.form.submit()">
                                    </div>
                                </form>
                            </td>
                            <td>Rp <?= number_format($data['harga'], 0, ',', '.'); ?></td>
                            <td>
                                <div class="qty-box">
                                    <a href="update_keranjang.php?id=<?= $id_menu; ?>&aksi=kurang" class="qty-btn">-</a>
                                    <span class="qty-number"><?= $jumlah; ?></span>
                                    <a href="update_keranjang.php?id=<?= $id_menu; ?>&aksi=tambah" class="qty-btn">+</a>
                                </div>
                            </td>
                            <td>Rp <?= number_format($subtotal, 0, ',', '.'); ?></td>
                            <td>
                                <a href="update_keranjang.php?id=<?= $id_menu; ?>&aksi=hapus" class="delete-btn" onclick="return confirm('Hapus menu ini?')">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php 
                        } 
                    } else {
                        echo "<tr><td colspan='7'><div class='empty-cart'><i class='fa-solid fa-cart-shopping'></i><p>Keranjang masih kosong</p></div></td></tr>";
                    }
                    ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="total-text">Total Bayar</td>
                            <td colspan="2" class="total-price">Rp <?= number_format($total_belanja, 0, ',', '.'); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="button-area">
                <a href="menu.php" class="btn secondary-btn"><i class="fa-solid fa-plus"></i> Tambah Menu</a>
                <?php if(!empty($_SESSION['keranjang'])): ?>
                    <a href="transaksi.php" class="btn primary-btn">Checkout <i class="fa-solid fa-arrow-right"></i></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>