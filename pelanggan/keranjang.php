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
        .badge-pedas {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            margin-top: 5px;
            background: #ffcdd2; 
            color: #c62828;
        }
        .catatan-text {
            display: block;
            font-size: 0.85rem;
            color: #666;
            font-style: italic;
            margin-top: 4px;
        }
        /* Style tambahan untuk menandakan loading/tersimpan */
        .status-save {
            font-size: 10px;
            color: #4caf50;
            display: none;
            margin-top: 5px;
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
                <p>Cek kembali menu & catatan sebelum checkout 🍽️</p>
            </div>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
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

                    if(!empty($_SESSION['keranjang'])){
                        foreach($_SESSION['keranjang'] as $id_menu => $item){
                            $query = mysqli_query($conn, "SELECT * FROM menu WHERE id_menu='$id_menu'");
                            $data = mysqli_fetch_assoc($query);

                            $qty_fix = (int)$item['jumlah'];
                            $pedas = $item['pedas'] ?? 'Original';
                            $catatan = $item['catatan'] ?? '';

                            $harga_fix = (int)$data['harga'];
                            $subtotal = $harga_fix * $qty_fix;
                            $total_belanja += $subtotal;
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td>
                                <div class="menu-info">
                                    <img src="../admind/crud/menu/upload/<?= $data['gambar']; ?>" alt="Foto Menu" class="img-cart">
                                    <div class="menu-name">
                                        <h4><?= $data['nama_menu']; ?></h4>
                                        
                                        <form class="auto-save-form" style="margin-top: 10px;">
                                            <input type="hidden" name="id_menu" value="<?= $id_menu ?>">

                                            <div style="margin-top:8px;">
                                                <label style="font-size: 12px;"><b>Tingkat Pedas:</b></label>
                                                <select name="pedas" class="form-control auto-input" style="width: 100%; padding: 5px; border-radius: 4px; border: 1px solid #ddd;">
                                                    <?php 
                                                    $levels = ['Original', 'Level 1', 'Level 2', 'Level 3', 'Level 4', 'Level 5'];
                                                    foreach($levels as $lv): 
                                                    ?>
                                                        <option value="<?= $lv ?>" <?= ($pedas == $lv) ? "selected" : "" ?>><?= $lv ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div style="margin-top:8px;">
                                                <label style="font-size: 12px;"><b>Catatan:</b></label>
                                                <textarea
                                                    name="catatan"
                                                    rows="2"
                                                    class="form-control auto-input"
                                                    placeholder="Contoh: jangan pakai bawang"
                                                    style="width: 100%; padding: 5px; border-radius: 4px; border: 1px solid #ddd; font-size: 13px;"
                                                ><?= htmlspecialchars($catatan) ?></textarea>
                                            </div>
                                            <span class="status-save"><i class="fa-solid fa-check"></i> Tersimpan</span>
                                        </form>
                                    </div>
                                </div>
                            </td>

                            <td>Rp <?= number_format($data['harga'],0,',','.'); ?></td>

                            <td>
                                <form action="update_jumlah.php" method="POST" class="qty-box">
                                    <input type="hidden" name="id_menu" value="<?= $id_menu; ?>">
                                    <button type="button" class="qty-btn minus-btn">-</button>
                                    <input type="number" name="jumlah" value="<?= $qty_fix; ?>" min="1" class="qty-input">
                                    <button type="button" class="qty-btn plus-btn">+</button>
                                </form>
                            </td>

                            <td>Rp <?= number_format($subtotal,0,',','.'); ?></td>

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
                            <td colspan="6" style="text-align:center; padding: 50px 0;">
                                <div class="empty-cart">
                                    <i class="fa-solid fa-cart-shopping" style="font-size: 3rem; color: #ccc;"></i>
                                    <p>Keranjang masih kosong</p>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="4" style="text-align:right; font-weight:bold; padding: 20px;">TOTAL PEMBAYARAN</td>
                            <td colspan="2" class="total-price" style="color:#e65100; font-size:1.3rem; font-weight:bold;">
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
/**
 * AUTO SAVE FUNCTIONALITY
 */
document.querySelectorAll('.auto-input').forEach(input => {
    // Gunakan 'change' untuk Select dan 'blur' (saat klik di luar) untuk Textarea
    const eventType = input.tagName === 'SELECT' ? 'change' : 'blur';

    input.addEventListener(eventType, function() {
        const form = this.closest('.auto-save-form');
        const statusText = form.querySelector('.status-save');
        const formData = new FormData(form);

        // Kirim data ke update_keranjang.php di background
        fetch('update_keranjang.php', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (response.ok) {
                // Tampilkan indikator "Tersimpan" sejenak
                statusText.style.display = 'block';
                setTimeout(() => {
                    statusText.style.display = 'none';
                }, 2000);
            }
        })
        .catch(error => console.error('Error saving:', error));
    });
});

/**
 * QUANTITY BUTTONS
 */
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
        if(input.value < 1) input.value = 1;
        form.submit();
    });
});
</script>
</body>
</html>