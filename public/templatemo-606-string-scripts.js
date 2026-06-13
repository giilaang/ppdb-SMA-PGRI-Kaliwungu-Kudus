// Mobile sidebar toggle
const mobileMenuBtn = document.querySelector(".mobile-menu-btn");
const mobileSidebar = document.querySelector(".mobile-sidebar");
const backdrop = document.querySelector(".sidebar-backdrop");

// Set --header-height CSS variable so sidebar starts exactly below the fixed header
function updateHeaderHeight() {
  const header = document.querySelector(".main-header");
  if (header) {
    const h = header.offsetHeight;
    document.documentElement.style.setProperty("--header-height", h + "px");
  }
}
updateHeaderHeight();
window.addEventListener("resize", updateHeaderHeight);

function toggleSidebar(show) {
  if (mobileSidebar) mobileSidebar.classList.toggle("active", show);
  if (backdrop) backdrop.classList.toggle("active", show);
  // Tidak perlu lock scroll body — sidebar bukan full screen
}

if (mobileMenuBtn) {
  mobileMenuBtn.addEventListener("click", () => {
    const isOpen = mobileSidebar.classList.contains("active");
    toggleSidebar(!isOpen);
  });
}


if (backdrop) {
  backdrop.addEventListener("click", () => toggleSidebar(false));
}

// Tombol tutup ✕ di dalam sidebar (gaya UMKU)
const sidebarCloseBtn = document.getElementById("sidebarCloseBtn");
if (sidebarCloseBtn) {
  sidebarCloseBtn.addEventListener("click", () => toggleSidebar(false));
}

// Tombol bahasa di sidebar → tutup sidebar, buka dropdown bahasa di top-bar
const sidebarLangBtn = document.querySelector(".sidebar-lang");
if (sidebarLangBtn) {
  sidebarLangBtn.addEventListener("click", () => {
    toggleSidebar(false);
    // Buka dropdown bahasa di top-bar setelah sidebar tutup
    setTimeout(() => {
      const langContent = document.querySelector(".lang-dropdown-content");
      if (langContent) langContent.classList.add("show");
    }, 350); // tunggu animasi sidebar selesai
  });
}

// Close sidebar when clicking a link & Handle Mobile Submenus
if (mobileSidebar) {
  mobileSidebar.querySelectorAll(".sidebar-links a").forEach((link) => {
    link.addEventListener("click", (e) => {
      if (link.classList.contains("sidebar-dropdown-trigger")) {
        e.preventDefault();
        const parent = link.parentElement;
        const submenu = parent.querySelector(".sidebar-submenu");
        
        parent.classList.toggle("open");
        if (submenu) {
          if (submenu.style.display === "block") {
            submenu.style.display = "none";
          } else {
            submenu.style.display = "block";
          }
        }
      } else {
        toggleSidebar(false);
      }
    });
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
        top: targetElement.offsetTop - 120,
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

// ==========================================================================
// Language Switching & Google Translation Script
// ==========================================================================
const langDropbtn = document.querySelector(".lang-dropbtn");
const langDropdownContent = document.querySelector(".lang-dropdown-content");
const langItems = document.querySelectorAll(".lang-item");

// Toggle dropdown on click (mobile & desktop)
if (langDropbtn && langDropdownContent) {
  langDropbtn.addEventListener("click", function(e) {
    e.stopPropagation();
    langDropdownContent.classList.toggle("show");
  });

  // Close dropdown when clicking outside
  document.addEventListener("click", function() {
    langDropdownContent.classList.remove("show");
  });
}

// Function to set the googtrans cookie for Google Translate
function setLanguageCookie(lang) {
  const cookieValue = lang === 'id' ? '/id/id' : `/id/${lang}`;
  
  // Set for current domain
  document.cookie = `googtrans=${cookieValue}; path=/;`;
  
  // Also set for domain without port/subdomains
  const domain = window.location.hostname;
  document.cookie = `googtrans=${cookieValue}; path=/; domain=${domain};`;
  
  // Also set for .domain to cover subdomains
  if (domain !== 'localhost' && domain !== '127.0.0.1') {
    document.cookie = `googtrans=${cookieValue}; path=/; domain=.${domain};`;
  }
}

// Function to update UI states (does not reload)
function updateLanguageUI(lang) {
  // 1. Update dropdown trigger button flag & text
  const currentFlagEl = document.querySelector(".lang-current-flag");
  const currentTextEl = document.querySelector(".lang-current-text");
  
  const flags = { id: "🇮🇩", en: "🇬🇧", ar: "🇸🇦" };
  const texts = { id: "Indonesia", en: "English", ar: "Arab" };
  
  if (currentFlagEl) currentFlagEl.textContent = flags[lang];
  if (currentTextEl) currentTextEl.textContent = texts[lang];

  // 2. Mark selected language active in dropdown list
  langItems.forEach((item) => {
    if (item.getAttribute("data-lang") === lang) {
      item.classList.add("active");
    } else {
      item.classList.remove("active");
    }
  });

  // 3. Sinkronisasi tampilan bahasa di sidebar topbar
  const sidebarFlagEl = document.getElementById("sidebar-lang-flag");
  const sidebarTextEl = document.getElementById("sidebar-lang-text");
  if (sidebarFlagEl) sidebarFlagEl.textContent = flags[lang];
  if (sidebarTextEl) sidebarTextEl.textContent = texts[lang];

  // 4. Update document language/direction attributes (RTL for Arabic)
  document.documentElement.dir = lang === "ar" ? "rtl" : "ltr";
  document.documentElement.lang = lang;
}

// Function to perform full page translation and save selection
function selectLanguage(lang) {
  setLanguageCookie(lang);
  localStorage.setItem("selected_language", lang);
  updateLanguageUI(lang);
  
  // Reload the page to let Google Translate initialize and translate all content
  location.reload();
}

// Attach click listeners to language items
langItems.forEach((item) => {
  item.addEventListener("click", function(e) {
    e.preventDefault();
    const lang = this.getAttribute("data-lang");
    selectLanguage(lang);
    if (langDropdownContent) {
      langDropdownContent.classList.remove("show");
    }
  });
});

// Load saved language UI state on init
document.addEventListener("DOMContentLoaded", () => {
  const savedLang = localStorage.getItem("selected_language") || "id";
  updateLanguageUI(savedLang);
  // Ensure the cookie matches saved value (in case it expired)
  setLanguageCookie(savedLang);
});

// ==========================================================================
// Bulletproof JavaScript helper to hide Google Translate native toolbar
// ==========================================================================
function forceHideGoogleTranslateUI() {
  const elements = [
    document.querySelector(".goog-te-banner-frame"),
    document.querySelector(".goog-te-banner-frame.skiptranslate"),
    document.querySelector("#goog-gt-tt"),
    document.querySelector(".goog-te-balloon-frame"),
    document.querySelector(".goog-te-preview-frame")
  ];
  
  elements.forEach((el) => {
    if (el) {
      el.style.setProperty("display", "none", "important");
      el.style.setProperty("visibility", "hidden", "important");
    }
  });

  if (document.body.style.top !== "0px" && document.body.style.top !== "") {
    document.body.style.setProperty("top", "0px", "important");
  }
}

// Watch DOM for changes to immediately hide translation bar if it appears
const translateObserver = new MutationObserver(forceHideGoogleTranslateUI);
translateObserver.observe(document.documentElement, {
  childList: true,
  subtree: true,
  attributes: true,
  attributeFilter: ["style"]
});

// Fallback interval check
setInterval(forceHideGoogleTranslateUI, 150);
