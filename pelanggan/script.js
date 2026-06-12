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

        this.innerHTML =
            '<i class="fa-solid fa-spinner fa-spin"></i> Loading...';

        fetch(`tambah_keranjang.php?id=${menuId}`)
            .then(response => response.json())
            .then(data => {

                if (data.status === "success") {

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 1800,
                        timerProgressBar: true,
                        background: '#8b1e2d',
                        color: '#fff'
                    });

                } else if (data.status === "warning") {

                    Swal.fire({
                        icon: 'warning',
                        title: 'Stok Tidak Cukup',
                        text: data.message,
                        confirmButtonColor: '#8b1e2d'
                    });

                } else {

                    Swal.fire({
                        icon: 'error',
                        title: 'Menu Habis',
                        text: data.message,
                        confirmButtonColor: '#8b1e2d'
                    });

                }

                this.innerHTML =
                    '<i class="fa-solid fa-plus"></i> Keranjang';
            })
            .catch(error => {

                console.error(error);

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Gagal menambahkan menu'
                });

                this.innerHTML =
                    '<i class="fa-solid fa-plus"></i> Keranjang';
            });

    });
});