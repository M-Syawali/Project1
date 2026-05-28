const container = document.querySelector('.container');
const registerBtn = document.querySelector('.register-btn');
const loginBtn = document.querySelector('.login-btn');

// Logika perpindahan Register/Login
registerBtn.addEventListener('click', () => {
    container.classList.add('active');
});
loginBtn.addEventListener('click', () => {
    container.classList.remove('active');
});

// Animasi Fade-in Tombol Dashboard saat Load
window.onload = function(){
    const tombol = document.querySelectorAll(".dashboard-btn");

    tombol.forEach((btn, index) => {
        btn.style.opacity = "0";
        btn.style.transform = "translateY(30px)";

        setTimeout(() => {
            btn.style.transition = "0.6s";
            btn.style.opacity = "1";
            btn.style.transform = "translateY(0)";
        }, 500 + (index * 300));
    });
}

document.querySelectorAll('.btn-ajax-add').forEach(button => {
    button.addEventListener('click', function(e) {
        const menuId = this.getAttribute('data-id');
        const namaMenu = this.getAttribute('data-nama');
        
        // Animasi Loading pada tombol (opsional)
        this.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Loading...';

        // Kirim data ke tambah_keranjang.php di background
        fetch(`tambah_keranjang.php?id=${menuId}`)
            .then(response => {
                // Tampilkan Animasi Berhasil
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: namaMenu + ' telah ditambahkan ke keranjang.',
                    showConfirmButton: false,
                    timer: 1500, // Hilang otomatis dalam 1.5 detik
                    position: 'center',
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                });

                // Kembalikan teks tombol semula
                this.innerHTML = '<i class="fa-solid fa-plus"></i> Keranjang';
            })
            .catch(error => {
                Swal.fire('Error', 'Gagal menambahkan menu', 'error');
                this.innerHTML = '<i class="fa-solid fa-plus"></i> Keranjang';
            });
    });
});