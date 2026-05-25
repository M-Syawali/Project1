// =====================================
// FEATHER ICONS
// =====================================

feather.replace();

// =====================================
// ELEMENT
// =====================================

const sidebar = document.getElementById("sidebar");
const hamburger = document.getElementById("menu-toggle");
const mainContent = document.getElementById("main-content");
const profileBtn = document.getElementById("profile-btn");
const profileMenu = document.getElementById("profile-menu");

// =====================================
// SIDEBAR TOGGLE
// =====================================

hamburger.addEventListener("click", () => {
  sidebar.classList.add("active");
  mainContent.classList.add("shrink");
});

sidebar.addEventListener("transitionend", (e) => {
  if (e.propertyName === "transform") {
    window.dispatchEvent(new Event("resize"));
  }
});

document.addEventListener("click", (e) => {
  const isClickInside =
    sidebar.contains(e.target) || hamburger.contains(e.target);

  if (!isClickInside) {
    sidebar.classList.remove("active");
    mainContent.classList.remove("shrink");
  }
});
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

const canvas = document.getElementById("salesChart");

if (canvas) {
  const ctx = canvas.getContext("2d");

  new Chart(ctx, {
    type: "line",

    data: {
      labels: [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "Mei",
        "Jun",
        "Jul",
        "Agu",
        "Sep",
        "Okt",
        "Nov",
        "Des",
      ],

      datasets: [
        {
          data: [120, 190, 170, 220, 260, 310, 340, 390, 420, 460, 500, 580],

          borderColor: "#7D0A0A",

          backgroundColor: "rgba(125,10,10,.12)",

          borderWidth: 3,

          fill: true,

          tension: 0.45,

          pointRadius: 5,

          pointHoverRadius: 8,

          pointBackgroundColor: "#7D0A0A",
        },
      ],
    },

    options: {
      responsive: true,

      maintainAspectRatio: false,

      interaction: {
        intersect: false,
        mode: "index",
      },

      plugins: {
        legend: {
          display: false,
        },
      },

      animation: {
        duration: 1800,
        easing: "easeOutQuart",
      },

      scales: {
        y: {
          beginAtZero: true,

          grid: {
            color: "rgba(0,0,0,.05)",
          },
        },

        x: {
          grid: {
            display: false,
          },
        },
      },
    },
  });
}

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
