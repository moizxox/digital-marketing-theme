function handlePageLoad() {
  const pageContent = document.querySelector(".page-content");
  const pageLoading = document.querySelector(".page-loading");

  // Mark content as loaded
  pageContent.classList.add("loaded");

  // Hide loading state after a small delay
  setTimeout(() => {
    pageLoading.classList.add("hidden");
    // Remove loading element after transition
    setTimeout(() => {
      pageLoading.remove();
    }, 300);
  }, 100);
}

// Check if page is already loaded
if (document.readyState === "complete") {
  handlePageLoad();
} else {
  window.addEventListener("load", handlePageLoad);
}

// Initialize other animations
const header = document.querySelector("header, .site-header, #header, .main-header");
if (header) {
  header.style.opacity = "0";
  header.style.transform = "translateY(-20px)";
  header.style.transition = "opacity 0.6s ease-out, transform 0.6s ease-out";

  // Trigger header animation after a small delay
  setTimeout(() => {
    header.style.opacity = "1";
    header.style.transform = "translateY(0)";
  }, 100);
}

// Initialize typed.js
if (typeof Typed !== "undefined") {
  new Typed(".element", {
    strings: ["Tools", "Courses", "Services"],
    typeSpeed: 50,
    backSpeed: 30,
    backDelay: 3000,
    loop: true,
    showCursor: true,
    cursorChar: "",
  });
}
