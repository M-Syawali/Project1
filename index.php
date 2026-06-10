<?php
// Mengatur agar session cookie bertahan lama di browser (contoh: 30 hari)
// Mengatur agar session cookie bertahan lama (30 hari)
$waktu_session = 2592000; 
ini_set('session.gc_maxlifetime', $waktu_session);
session_set_cookie_params($waktu_session);

// Memulai session PHP
session_start();

// CEK LOGIN: Sekarang kita cek apakah role-nya adalah pelanggan
$is_logged_in = (isset($_SESSION['role']) && $_SESSION['role'] == 'pelanggan');
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SAGALA LADA</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <div class="blur1"></div>
  <div class="blur2"></div>

  <nav>
    <h1>SAGALA LADA</h1>
    <ul>
      <li><a href="#home">Beranda</a></li>
      <li><a href="pelanggan/menu.php">Menu</a></li>
      <li><a href="#tentang">Tentang</a></li>
      <li><a href="#kontak">Kontak</a></li>
      
      <?php if ($is_logged_in): ?>
        <li><a href="login/logout.php" style="color: #ff4d4d; font-weight: bold;">Logout</a></li>
      <?php else: ?>
        <li><a href="login/index.php">Login Admin</a></li>
      <?php endif; ?>

    </ul>
  </nav>

  <section class="hero" id="home">

    <div class="hero-text">
      <h2>
        Nikmati Sensasi <span>Pedas</span><br>
        Yang Bikin Nagih 
      </h2>

      <p>
        UMKM makanan pedas dengan cita rasa khas nusantara.
        Dibuat dari bahan pilihan dan premium.
      </p>

      <div class="hero-btn">
        <a href="pelanggan/menu.php?jenis=dinein" class="btn btn-dayin">
            🍽️ Dine In
        </a>

        <?php if ($is_logged_in): ?>
          <a href="pelanggan/menu.php?jenis=delivery" class="btn btn-delivery">
              🛵 Delivery
          </a>
        <?php else: ?>
          <a href="login/index.php?pesan=wajib_login" class="btn btn-delivery" onclick="return alertWajibLogin();">
              🛵 Delivery
          </a>
        <?php endif; ?>
      </div>
    </div>

    <div class="hero-image">
      <img src="bahan/Gemini_Generated_Image_4rsbpq4rsbpq4rsb (1).png" alt="Makanan Pedas">
    </div>

  </section>

  <section class="menu-section" id="tentang">

    <h2 class="section-title">Tentang Kami</h2>

    <div class="menu-grid">

        <div class="menu-card">
            <video
              autoplay
              muted
              loop
              playsinline
              style="width:100%; height:500px; object-fit:cover; border-radius:20px;"
            >
              <source src="bahan/video.mp4" type="video/mp4">
            </video>
        </div>

        <div class="menu-content">
            <h3>
                Tempat Kuliner Pedas<br>
                Favorit Semua Orang
            </h3>

            <p>
                Mitra kami menghadirkan pengalaman kuliner modern
                dengan berbagai menu pedas khas Nusantara,
                suasana nyaman, dan pelayanan terbaik, cocok digunakan untuk kumpul keluarga
                maupun dengan teman teman
            </p>
        </div>

    </div>

  </section>

  <section class="about-section">

    <div class="about-image">
      <div class="image-card">
        <video autoplay muted loop playsinline style="width:100%; height:100%; object-fit:cover; border-radius:20px;">
            <source src="bahan/WhatsApp Video 2026-05-22 at 14.26.01.mp4" type="video/mp4">
        </video>
      </div>
    </div>

    <div class="about-content">
      <h2>
        Pedas Modern<br>
        Dengan <span>Cita Rasa Nusantara</span>
      </h2>

      <p>
        Sagala Lada menghadirkan pengalaman kuliner pedas
        dengan sambal khas, bahan premium, dan tampilan modern.
      </p>

      <p>
        Kami menggunakan cabai pilihan terbaik untuk menghasilkan
        rasa pedas gurih yang bikin pelanggan ketagihan.
      </p>

      <div class="about-features">
        <div class="feature-box">
          <div class="feature-icon">🌶</div>
          <div>
            <h3>Cabai Premium</h3>
            <p>Cabai segar pilihan terbaik.</p>
          </div>
        </div>

        <div class="feature-box">
          <div class="feature-icon">🍜</div>
          <div>
            <h3>Menu Variatif</h3>
            <p>Banyak pilihan makanan pedas.</p>
          </div>
        </div>

        <div class="feature-box">
          <div class="feature-icon">⚡</div>
          <div>
            <h3>Pelayanan Cepat</h3>
            <p>Pesanan cepat dan higienis.</p>
          </div>
        </div>
      </div>

    </div>

  </section>

  <section class="testimoni">

    <h2 class="section-title">Testimoni Pelanggan</h2>

    <div class="testimoni-grid">

      <div class="testi-card">
         <video autoplay muted loop playsinline width="300" height="450" style="object-fit:cover; border-radius:20px;">
            <source src="bahan/vidio 1.mp4" type="video/mp4">
         </video>
      </div>

      <div class="testi-card">
        <video autoplay muted loop playsinline width="300" height="450" style="object-fit:cover; border-radius:20px;">
            <source src="bahan/vidio 3.mp4" type="video/mp4">
        </video>
      </div>

      <div class="testi-card">
        <video autoplay muted loop playsinline width="300" height="450" style="object-fit:cover; border-radius:20px;">
            <source src="bahan/vidio 2.mp4" type="video/mp4">
        </video>
      </div>

    </div>

  </section>

  <footer id="kontak">

    <div class="footer-container">

      <div class="footer-box">
        <h2>SAGALA LADA</h2>
        <p>
          UMKM makanan pedas dengan cita rasa khas nusantara dan kualitas premium.
        </p>
      </div>

      <div class="footer-box">
        <h3>Kontak</h3>
        <p>📍 Jl. Raden Ajeng Kartini No.39, Pasirkareumbi, Kec. Subang, Kabupaten Subang, Jawa Barat 41211, Indonesia</p>
        <p>📞 0812-8668-3093</p>
        <p>📧 sagalalada@gmail.com</p>
      </div>

      <div class="footer-box">
        <h3>Sosial Media</h3>
        <a href="https://www.instagram.com/sagalalada01?igsh=MTB6Y2F3MGp2c3Bvbw==" target="_blank">Instagram : @sagalalada01</a>
        <a href="https://www.tiktok.com/@sagalaladabundaintan?is_from_webapp=1&sender_device=pc" target="_blank">TikTok : @sagalaladabundaintan</a>
        <a href="https://wa.me/6281286683093" target="_blank">WhatsApp : 0812-8668-3093</a>
      </div>

    </div>

    <div class="footer-bottom">
      © SagalaLada🔥
    </div>

  </footer>

  <script>
    function alertWajibLogin() {
        alert("Silakan login terlebih dahulu untuk menikmati layanan Delivery.");
        return true; 
    }
  </script>

</body>
</html>