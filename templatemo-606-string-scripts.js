// Mobile sidebar toggle
const mobileMenuBtn = document.querySelector(".mobile-menu-btn");
const closeSidebarBtn = document.querySelector(".close-sidebar");
const mobileSidebar = document.querySelector(".mobile-sidebar");
const backdrop = document.querySelector(".sidebar-backdrop");

function toggleSidebar(show) {
  if (mobileSidebar) mobileSidebar.classList.toggle("active", show);
  if (backdrop) backdrop.classList.toggle("active", show);
  document.body.style.overflow = show ? "hidden" : "";
}

if (mobileMenuBtn) {
  mobileMenuBtn.addEventListener("click", () => toggleSidebar(true));
}

if (closeSidebarBtn) {
  closeSidebarBtn.addEventListener("click", () => toggleSidebar(false));
}

if (backdrop) {
  backdrop.addEventListener("click", () => toggleSidebar(false));
}

// Close sidebar when clicking a link
if (mobileSidebar) {
  mobileSidebar.querySelectorAll(".sidebar-links a").forEach((link) => {
    link.addEventListener("click", () => toggleSidebar(false));
  });
}

// Registration Modal functionality
const infoModal = document.querySelector("#infoModal");
const infoModalTriggers = document.querySelectorAll(".info-modal-trigger");
const closeModalBtn = document.querySelector(".modal-close");

function toggleInfoModal(show) {
  if (infoModal) {
    infoModal.classList.toggle("active", show);
    document.body.style.overflow = show ? "hidden" : "";
  }
}

infoModalTriggers.forEach((trigger) => {
  trigger.addEventListener("click", () => {
    toggleSidebar(false); // Close sidebar if open
    toggleInfoModal(true);
  });
});

if (closeModalBtn) {
  closeModalBtn.addEventListener("click", () => toggleInfoModal(false));
}

if (infoModal) {
  infoModal.addEventListener("click", (e) => {
    if (e.target === infoModal) toggleInfoModal(false);
  });
}

// Smooth scrolling for navigation links
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
  anchor.addEventListener("click", function (e) {
    e.preventDefault();

    const targetId = this.getAttribute("href");
    if (targetId === "#") return;

    const targetElement = document.querySelector(targetId);
    if (targetElement) {
      window.scrollTo({
        top: targetElement.offsetTop - 80,
        behavior: "smooth",
      });
    }
  });
});
// Project Image Sliders
document.querySelectorAll(".project-slider-wrapper").forEach((wrapper) => {
  const slider = wrapper.querySelector(".project-slider");
  const dotsContainer = wrapper.querySelector(".slider-dots");
  const images = slider.querySelectorAll("img");
  let currentIndex = 0;
  let interval;

  const isFadeSlider = wrapper.classList.contains("fade-slider");

  // Create dots
  images.forEach((img, index) => {
    const dot = document.createElement("div");
    dot.classList.add("slider-dot");
    if (index === 0) {
      dot.classList.add("active");
      if (isFadeSlider) img.classList.add("active");
    }
    dot.addEventListener("click", () => goToSlide(index));
    dotsContainer.appendChild(dot);
  });

  const dots = dotsContainer.querySelectorAll(".slider-dot");

  function updateSlider() {
    if (isFadeSlider) {
      images.forEach((img, index) => {
        img.classList.toggle("active", index === currentIndex);
      });
    } else {
      slider.style.transform = `translateX(-${currentIndex * 100}%)`;
    }

    dots.forEach((dot, index) => {
      dot.classList.toggle("active", index === currentIndex);
    });
  }

  function goToSlide(index) {
    currentIndex = index;
    updateSlider();
    resetInterval();
  }

  function nextSlide() {
    currentIndex = (currentIndex + 1) % images.length;
    updateSlider();
  }

  function resetInterval() {
    clearInterval(interval);
    if (slider.dataset.autoplay === "true") {
      interval = setInterval(nextSlide, 3500); // 3.5 seconds
    }
  }

  // Start autoplay
  resetInterval();

  // Pause on hover
  wrapper.addEventListener("mouseenter", () => clearInterval(interval));
  wrapper.addEventListener("mouseleave", resetInterval);
});
