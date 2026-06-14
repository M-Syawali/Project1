// =====================================
// FEATHER ICONS
// =====================================

feather.replace();

// =====================================
// ELEMENT
// =====================================

const profileBtn = document.getElementById("profile-btn");
const profileMenu = document.getElementById("profile-menu");

// =====================================
// SIDEBAR TOGGLE
// =====================================

// Main conten

// =====================================
// PROFILE DROPDOWN
// =====================================

profileBtn.addEventListener("click", (e) => {
  e.stopPropagation();

  profileMenu.classList.toggle("show");
});

// Klik luar dropdown

document.addEventListener("click", (e) => {
  if (!profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
    profileMenu.classList.remove("show");
  }
});

// ESC untuk menutup dropdown

document.addEventListener("keydown", (e) => {
  if (e.key === "Escape") {
    profileMenu.classList.remove("show");
  }
});

// =====================================
// SIDEBAR ACTIVE MENU
// =====================================

const menuItems = document.querySelectorAll(".menu li");

menuItems.forEach((item) => {
  item.addEventListener("click", () => {
    menuItems.forEach((i) => {
      i.classList.remove("active");
    });

    item.classList.add("active");
  });
});

// =====================================
// CHART
// =====================================

// =====================================
// REVEAL ANIMATION
// =====================================

window.addEventListener("load", () => {
  const navbar = document.querySelector(".navbar");

  navbar.style.animation = "navbarReveal .7s ease forwards";

  const cards = document.querySelectorAll(".card");

  cards.forEach((card, index) => {
    setTimeout(
      () => {
        card.style.animation = "reveal .7s ease forwards";
      },
      150 + index * 120,
    );
  });

  const chartBox = document.querySelector(".chart-box");

  if (chartBox) {
    setTimeout(() => {
      chartBox.style.animation = "reveal .7s ease forwards";
    }, 650);
  }

  const tableBox = document.querySelector(".table-box");

  if (tableBox) {
    setTimeout(() => {
      tableBox.style.animation = "reveal .7s ease forwards";
    }, 850);
  }
});

// =====================================
// COUNTER ANIMATION
// =====================================

const counters = document.querySelectorAll(".counter");

function animateValue(element, start, end, duration) {
  let startTime = null;

  function update(currentTime) {
    if (!startTime) {
      startTime = currentTime;
    }

    const progress = Math.min((currentTime - startTime) / duration, 1);

    element.textContent = Math.floor(progress * (end - start) + start);

    if (progress < 1) {
      requestAnimationFrame(update);
    }
  }

  requestAnimationFrame(update);
}

window.addEventListener("load", () => {
  counters.forEach((counter) => {
    const target = parseInt(counter.dataset.target);

    animateValue(counter, 0, target, 1800);
  });
});

// =====================================
// TABLE HOVER EFFECT
// =====================================

//

window.addEventListener("load", () => {
  const tableTitle = document.querySelector(".table-title");

  if (tableTitle) {
    setTimeout(() => {
      tableTitle.classList.add("show");
    }, 850);
  }
});
