<div class="navbar">

    <div class="navbar-left">

        <h2><?= $judul_halaman ?? "Dashboard" ?></h2>

        <p>
            <?= $subjudul_halaman ?? "Kelola data sistem" ?>
        </p>

    </div>

    <div class="navbar-right">

        <div class="profile">

            <button id="profile-btn">

                <i data-feather="user"></i>

                <span>
                    <?= htmlspecialchars($_SESSION['username']) ?>
                </span>

                <i data-feather="chevron-down"></i>

            </button>

            <div class="profile-menu" id="profile-menu">

                <a href="profile.php">
                    <i data-feather="user"></i>
                    Profil Saya
                </a>

                <a href="ubah_password.php">
                    <i data-feather="lock"></i>
                    Ubah Password
                </a>

                <a href="../../index.php">
          <i data-feather="log-out"></i>
          Halaman Awal
        </a>

            </div>

        </div>

    </div>

</div>