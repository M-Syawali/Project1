const container = document.querySelector('.container');
const registerBtn = document.querySelector('.register-btn');
const loginBtn = document.querySelector('.login-btn');

registerBtn.addEventListener('click', () => {
    container.classList.add('active');
});
loginBtn.addEventListener('click', () => {
    container.classList.remove('active');
});

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
