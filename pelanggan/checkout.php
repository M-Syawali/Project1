<?php
session_start();
include "koneksi.php";

$total_bayar = 0;
$nomor_pesanan = "SGL-" . date("Ymd") . "-" . rand(100,999);

$no_meja = isset($_SESSION['no_meja']) ? $_SESSION['no_meja'] : null;

// Mengambil status jenis pesanan (Dine In / Delivery)
$jenis_pesanan = isset($_SESSION['jenis_pesanan']) ? $_SESSION['jenis_pesanan'] : 'dinein'; 
?>

<!DOCTYPE html>
<html lang="id">  
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - SagalaLada</title>

    <link rel="stylesheet" href="css/style_checkout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        .pedas-badge{
            display:inline-block;
            padding:4px 10px;
            background:#ffe5e5;
            color:#c62828;
            border-radius:20px;
            font-size:12px;
            font-weight:600;
            margin-top:5px;
        }

        .catatan-box{
            margin-top:8px;
            color:#666;
            font-size:13px;
        }

        .edit-menu-btn{
            display:inline-block;
            margin-top:10px;
            padding:6px 12px;
            background:#8b1e2d;
            color:#fff;
            text-decoration:none;
            border-radius:8px;
            font-size:12px;
            transition:.3s;
        }

        .edit-menu-btn:hover{
            background:#6d1723;
        }

        .menu-item{
            display:flex;
            gap:15px;
            align-items:flex-start;
            padding:15px 0;
            border-bottom:1px solid #eee;
        }

        .menu-item img{
            width:80px;
            height:80px;
            object-fit:cover;
            border-radius:10px;
        }

        .menu-detail{
            flex:1;
        }

        .menu-price{
            font-weight:bold;
            color:#8b1e2d;
            white-space:nowrap;
        }

        /* --- STYLE: METODE PEMBAYARAN & BOX QRIS --- */
        .payment-box {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .payment-box .title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #333;
        }
        .payment-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 12px;
        }
        .payment-option {
            position: relative;
        }
        .payment-option input[type="radio"] {
            display: none;
        }
        .payment-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 12px;
            border: 2px solid #eee;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            font-size: 14px;
            font-weight: 500;
        }
        .payment-label i {
            font-size: 20px;
            margin-bottom: 5px;
            color: #666;
        }
        .payment-option input[type="radio"]:checked + .payment-label {
            border-color: #8b1e2d;
            background-color: #fff5f5;
            color: #8b1e2d;
        }
        .payment-option input[type="radio"]:checked + .payment-label i {
            color: #8b1e2d;
        }
        .qris-container {
            display: none; 
            text-align: center;
            margin-top: 20px;
            padding: 15px;
            border: 2px dashed #8b1e2d;
            border-radius: 10px;
            background: #fafafa;
        }
        .qris-container img {
            max-width: 230px;
            width: 100%;
            height: auto;
            margin-top: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        /* --- STYLE BUKTI PEMBAYARAN UPLOAD --- */
        .upload-bukti-wrapper {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #eee;
            text-align: left;
        }
        .upload-bukti-wrapper label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        .upload-bukti-wrapper input[type="file"] {
            display: block;
            width: 100%;
            padding: 10px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 13px;
            color: #555;
            cursor: pointer;
        }
        .upload-bukti-wrapper input[type="file"]::file-selector-button {
            background: #8b1e2d;
            color: #fff;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            margin-right: 10px;
            transition: 0.2s;
        }
        .upload-bukti-wrapper input[type="file"]::file-selector-button:hover {
            background: #6d1723;
        }

        /* --- STYLE CONTAINER MAPS LEAFLET --- */
        #map {
            width: 100%;
            height: 240px;
            margin-top: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            z-index: 1;
        }
        .btn-gps-style {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
            padding: 10px 15px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-gps-style:hover {
            background: #218838;
        }
        
        /* Info Jarak Badge */
        .jarak-info-badge {
            display: inline-block;
            margin-top: 8px;
            padding: 6px 12px;
            background: #e3f2fd;
            color: #0d47a1;
            border-radius: 6px;
            font-size: 13px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<form action="proses_checkout.php" method="POST" enctype="multipart/form-data">

<div class="checkout-container">

    <div class="checkout-left">

        <div class="topbar">
            <a href="keranjang.php" class="back-btn">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h2>Checkout Pesanan</h2>
        </div>

        <div class="order-id-box">
            <span>No Pesanan</span>
            <h3><?= $nomor_pesanan; ?></h3>
        </div>

        <div class="menu-box">

            <div class="section-title">
                <i class="fa-solid fa-bowl-food"></i>
                <span>Pesanan Kamu</span>
            </div>

            <?php
            if(!empty($_SESSION['keranjang'])){
                foreach($_SESSION['keranjang'] as $id_menu => $item){
                    $query = mysqli_query($conn, "SELECT * FROM menu WHERE id_menu='$id_menu'");
                    $data = mysqli_fetch_assoc($query);

                    if($data){
                        $qty = $item['jumlah'];
                        $pedas = $item['pedas'] ?? 'Original';
                        $catatan = $item['catatan'] ?? '';
                        $harga = (float)$data['harga'];
                        $subtotal = $harga * $qty;
                        $total_bayar += $subtotal;
            ?>

            <div class="menu-item">
                <img src="../admind/crud/menu/upload/<?= $data['gambar']; ?>" alt="Menu">
                <div class="menu-detail">
                    <h4><?= $data['nama_menu']; ?></h4>
                    <p><?= $qty; ?> x Rp <?= number_format($harga,0,',','.'); ?></p>
                    <div class="pedas-badge">🌶 <?= $pedas; ?></div>

                    <?php if(!empty($catatan)): ?>
                        <div class="catatan-box">
                            <i class="fa-solid fa-note-sticky"></i>
                            <?= htmlspecialchars($catatan); ?>
                        </div>
                    <?php endif; ?>

                    <a href="keranjang.php" class="edit-menu-btn">
                        <i class="fa-solid fa-pen"></i> Edit Menu
                    </a>
                </div>
                <div class="menu-price">
                    Rp <?= number_format($subtotal,0,',','.'); ?>
                </div>
            </div>

            <?php
                    }
                }
            } else {
                echo "<div style='padding:20px;text-align:center;'>Keranjang masih kosong</div>";
            }
            ?>

        </div>

        <div class="address-box">
            <div class="title">
                <i class="fa-solid fa-user"></i>
                <span>Detail Pemesan</span>
            </div>

            <?php if ($no_meja && $jenis_pesanan !== 'delivery'): ?>
            <div class="input-group">
                <label>Nomor Meja</label>
                <input 
                    type="text" 
                    value="Meja <?= htmlspecialchars($no_meja); ?>" 
                    readonly 
                    style="background-color: #f8f9fa; border: 1px solid #ddd; cursor: not-allowed; color: #555;">
                <input type="hidden" name="no_meja" value="<?= htmlspecialchars($no_meja); ?>">
            </div>
            <?php endif; ?>

            <div class="input-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" required placeholder="Masukkan nama Anda">
            </div>
      
<?php if ($jenis_pesanan === 'delivery'): ?>

<div class="input-group">
    <label>No HP</label>
    <input
        type="tel"
        name="no_hp"
        required
        placeholder="Masukan no hp">
</div>

<div class="input-group" style="margin-top:15px;">
    <label>
        <i class="fa-solid fa-map-marker-alt" style="color:#8b1e2d;"></i>
        Alamat Pengiriman Lengkap
    </label>

    <button
        type="button"
        id="btn_gps"
        class="btn-gps-style"
        onclick="getLokasiGPS()">
        <i class="fa-solid fa-location-crosshairs"></i>
        Gunakan Lokasi GPS Saya
    </button>

    <textarea
        name="alamat"
        required
        rows="3"
        placeholder="Ketik detail alamat..."></textarea>

    <div id="jarak_badge" class="jarak-info-badge">
        Jarak ke toko: Hitung...
    </div>

    <input type="hidden" id="latitude" name="latitude">
    <input type="hidden" id="longitude" name="longitude">

    <div id="map"></div>

</div>

<?php endif; ?>
        </div>

       <div class="payment-box">

    <div class="title">
        <i class="fa-solid fa-credit-card"></i>
        <span>Metode Pembayaran</span>
    </div>

   <?php if ($jenis_pesanan === 'delivery'): ?>

    <input
        type="hidden"
        name="metode_pembayaran"
        value="QRIS">

    <div class="payment-options">
        <div class="payment-option">
            <div class="payment-label">
                <i class="fa-solid fa-qrcode"></i>
                <span>QRIS</span>
            </div>
        </div>
    </div>

    <div
        id="qris_box"
        class="qris-container"
        style="display:block;">

        <p style="font-weight: bold; margin-bottom: 5px; color: #333;">
            Silahkan Scan QRIS SagalaLada:
        </p>

        <img src="../bahan/csan-qr-a.jpg" alt="QRIS SagalaLada">

        <div class="upload-bukti-wrapper">
            <label for="bukti_pembayaran">
                <i class="fa-solid fa-cloud-arrow-up"></i>
                Upload Bukti Pembayaran:
            </label>

            <input
                type="file"
                id="bukti_pembayaran"
                name="bukti_pembayaran"
                accept="image/*"
                required>

            <small style="color: #c62828; display: block; margin-top: 5px; font-size: 11px;">
                * Format gambar (.jpg, .jpeg, .png) wajib dilampirkan
            </small>
        </div>
    </div>

<?php else: ?>
        <!-- KODE DINE IN LAMA -->
        <div class="payment-options">

            <div class="payment-option">
                <input type="radio"
                       id="bayar_kasir"
                       name="metode_pembayaran"
                       value="Kasir"
                       checked
                       required>

                <label for="bayar_kasir" class="payment-label">
                    <i class="fa-solid fa-money-bill-wave"></i>
                    <span>Bayar di Kasir</span>
                </label>
            </div>

            <div class="payment-option">
                <input type="radio"
                       id="bayar_qris"
                       name="metode_pembayaran"
                       value="QRIS"
                       required>

                <label for="bayar_qris" class="payment-label">
                    <i class="fa-solid fa-qrcode"></i>
                    <span>QRIS</span>
                </label>
            </div>

        </div>

        <div id="qris_box" class="qris-container">
                <p style="font-weight: bold; margin-bottom: 5px; color: #333;">Silahkan Scan QRIS SagalaLada:</p>
                <img src="../bahan/csan-qr-a.jpg" alt="QRIS SagalaLada">
                
                <div class="upload-bukti-wrapper">
                    <label for="bukti_pembayaran"><i class="fa-solid fa-cloud-arrow-up"></i> Upload Bukti Pembayaran:</label>
                    <input type="file" id="bukti_pembayaran" name="bukti_pembayaran" accept="image/*">
                    <small style="color: #c62828; display: block; margin-top: 5px; font-size: 11px;">* Format gambar (.jpg, .jpeg, .png) wajib dilampirkan jika memilih QRIS</small>
                </div>
            </div>

    <?php endif; ?>

</div>
    </div>

    <div class="checkout-right">
        <div class="summary-card">
            <h3>Ringkasan Belanja</h3>
            <input type="hidden" name="nomor_pesanan" value="<?= $nomor_pesanan; ?>">
            <input type="hidden" name="jenis_pesanan" value="<?= $jenis_pesanan; ?>">
            
            <input type="hidden" id="input_ongkir" name="ongkir" value="0">

            <div class="summary-row">
                <span>Total Pesanan</span>
                <span>Rp <?= number_format($total_bayar,0,',','.'); ?></span>
            </div>

            <div class="summary-row">
                <span>Ongkos Kirim</span>
                <span id="tampil_ongkir">Rp 0</span>
            </div>

            <div class="summary-total">
                <span>Total Bayar</span>
                <h2 id="tampil_total">Rp <?= number_format($total_bayar,0,',','.'); ?></h2>
            </div>

            <button type="submit" class="checkout-btn">
                Pesan Sekarang <i class="fa-solid fa-arrow-right"></i>
            </button>
        </div>
    </div>

</div>
</form>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
// SIMPAN NILAI TOTAL MENU DARI PHP KE JAVASCRIPT
const totalPesananMenu = <?= $total_bayar; ?>;
const jenisPesanan = '<?= $jenis_pesanan; ?>';

// KOORDINAT UTAMA TOKO/RESTO SAGALALADA (Silakan ganti sesuai Lat & Lng toko Anda sebenarnya)
const restoLat = -6.57424915166697;
const restoLng = 107.76943239922228;

// TARIF ONGKIR PER KILOMETER (Contoh: Rp 2.500 per km)
const tarifPerKm = 1000;

// Rumus Haversine untuk kalkulasi jarak koordinat bumi
function hitungJarakHaversine(lat1, lon1, lat2, lon2) {
    const R = 6371; // Radius bumi dalam kilometer
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a = 
        Math.sin(dLat/2) * Math.sin(dLat/2) +
        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * Math.sin(dLon/2) * Math.sin(dLon/2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    return R * c; // Hasil dalam Kilometer
}

// Fungsi memformat angka ke mata uang Rupiah
function formatRupiah(angka) {
    return 'Rp ' + angka.toLocaleString('id-ID');
}

document.addEventListener("DOMContentLoaded", function() {
    // Logic Hide/Show Upload Box QRIS
    const paymentRadios = document.querySelectorAll('input[name="metode_pembayaran"]');
    const qrisBox = document.getElementById('qris_box');
    const inputBukti = document.getElementById('bukti_pembayaran');

    function toggleQrisBox() {

    if (jenisPesanan === "delivery") {
        qrisBox.style.display = 'block';

        if (inputBukti) {
            inputBukti.setAttribute('required', 'required');
        }

        return;
    }

    const selectedPayment = document.querySelector(
        'input[name="metode_pembayaran"]:checked'
    );

    if (selectedPayment && selectedPayment.value === 'QRIS') {

        qrisBox.style.display = 'block';

        if (inputBukti) {
            inputBukti.setAttribute('required', 'required');
        }

    } else {

        qrisBox.style.display = 'none';

        if (inputBukti) {
            inputBukti.removeAttribute('required');
            inputBukti.value = "";
        }
    }
}

    if (paymentRadios.length > 0) {
    paymentRadios.forEach(radio => {
        radio.addEventListener('change', toggleQrisBox);
    });
}
    toggleQrisBox();

    // LOGIK PETA & HITUNG ONGKIR OTOMATIS
    const mapDiv = document.getElementById('map');
    if (mapDiv && jenisPesanan === 'delivery') {
        
        // Render Peta awal berpusat di lokasi Toko
        const map = L.map('map').setView([restoLat, restoLng], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Tambahkan marker Toko (Opsional sebagai pembanding)
        L.marker([restoLat, restoLng]).addTo(map).bindPopup('<b>Toko SagalaLada</b>').openPopup();

        // Marker Rumah Pembeli (Bisa digeser)
        const markerKurir = L.marker([restoLat, restoLng], { draggable: true }).addTo(map);

        function updateOngkirDanKoordinat(lat, lng) {
            // 1. Simpan koordinat ke input hidden
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            // 2. Hitung jarak dari toko ke titik koordinat baru rumah pembeli
            const jarakKm = hitungJarakHaversine(restoLat, restoLng, lat, lng);
            
            // Bulatkan 1 angka di belakang koma untuk kenyamanan display pembeli
            document.getElementById('jarak_badge').innerText = `Jarak ke toko: ${jarakKm.toFixed(1)} Km`;

            // 3. Kalkulasi harga ongkir (Jarak x Tarif)
            // Anda bisa mengatur ongkir minimum di sini jika diperlukan, misal: Math.max(5000, jarakKm * tarifPerKm)
            const totalOngkir = Math.round(jarakKm * tarifPerKm);
            const totalKeseluruhan = totalPesananMenu + totalOngkir;

            // 4. Update element HTML Ringkasan Belanja
            document.getElementById('input_ongkir').value = totalOngkir;
            document.getElementById('tampil_ongkir').innerText = formatRupiah(totalOngkir);
            document.getElementById('tampil_total').innerText = formatRupiah(totalKeseluruhan);
        }

        // Jalankan kalkulasi setiap penanda digeser manual oleh pelanggan
        markerKurir.on('dragend', function(e) {
            const position = markerKurir.getLatLng();
            updateOngkirDanKoordinat(position.lat, position.lng);
        });

        // Inisialisasi hitungan awal pertama kali buka page
        updateOngkirDanKoordinat(restoLat, restoLng);

        // Ambil Lokasi Otomatis lewat GPS HP/Device pembeli
        window.getLokasiGPS = function() {
            const btn = document.getElementById('btn_gps');
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Membaca GPS Anda...';
            
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const customerLat = position.coords.latitude;
                    const customerLng = position.coords.longitude;

                    // Pindahkan posisi peta dan marker tepat ke lokasi GPS pembeli
                    map.setView([customerLat, customerLng], 16);
                    markerKurir.setLatLng([customerLat, customerLng]);
                    
                    // Update ongkir dan data form
                    updateOngkirDanKoordinat(customerLat, customerLng);
                    
                    btn.innerHTML = '<i class="fa-solid fa-circle-check"></i> Lokasi & Ongkir Terkunci';
                    btn.style.background = '#007bff';
                }, function() {
                    alert("Gagal mengakses GPS. Harap periksa izin lokasi browser Anda.");
                    btn.innerHTML = '<i class="fa-solid fa-location-crosshairs"></i> Gunakan Lokasi GPS Saya';
                });
            } else {
                alert("Perangkat Anda tidak mendukung pelacakan lokasi.");
                btn.innerHTML = '<i class="fa-solid fa-location-crosshairs"></i> Gunakan Lokasi GPS Saya';
            }
        }
    }
});

// =========================
// VALIDASI SEBELUM CHECKOUT
// =========================
document.querySelector("form").addEventListener("submit", function(e) {

    const metode = document.querySelector('input[name="metode_pembayaran"]:checked').value;
    const jenis = jenisPesanan;

    // QRIS wajib upload bukti
    if (metode === "QRIS") {
        const file = document.getElementById("bukti_pembayaran").files.length;

        if (file === 0) {
            e.preventDefault();
            alert("Upload bukti pembayaran QRIS wajib!");
            return;
        }
    }

    // DELIVERY wajib alamat + GPS
    if (jenis === "delivery") {
        const alamat = document.querySelector("textarea[name='alamat']").value;
        const lat = document.getElementById("latitude").value;
        const lng = document.getElementById("longitude").value;

        if (!alamat) {
            e.preventDefault();
            alert("Alamat wajib diisi!");
            return;
        }

        if (!lat || !lng) {
            e.preventDefault();
            alert("Silakan tentukan lokasi di peta atau GPS!");
            return;
        }
    }

});
</script>

</body>
</html>