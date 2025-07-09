let toolsSwiper, aiAgentsSwiper, aiToolsSwiper, coursesSwiper, servicesSwiper, contentSwiper;
jQuery(document).ready(function ($) {
  // --- TOOLS ---
  function initToolsSwiper() {
    if (toolsSwiper) toolsSwiper.destroy(true, true);
    toolsSwiper = new Swiper(".tools-swiper", {
      slidesPerView: 1,
      spaceBetween: 20,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      breakpoints: {
        640: { slidesPerView: 2 },
        1024: { slidesPerView: 3 },
        1200: { slidesPerView: 4 },
      },
    });
  }
  initToolsSwiper();
  $("#tool-categories button").removeClass("active bg-[#FFCC00] text-[#0C2452]");
  $('#tool-categories button[data-category="all"]').addClass("active bg-[#FFCC00] text-[#0C2452]");
  document.querySelectorAll("#tool-categories button").forEach((btn) => {
    btn.addEventListener("click", function () {
      showToolsLoading();
      const categoryId = this.getAttribute("data-category");
      document
        .querySelectorAll("#tool-categories button")
        .forEach((b) => b.classList.remove("active", "bg-[#FFCC00]", "text-[#0C2452]"));
      this.classList.add("active", "bg-[#FFCC00]", "text-[#0C2452]");
      showToolsLoading();
      fetch(`${ajaxurl}?action=filter_tools_by_category&category_id=${categoryId}`)
        .then((res) => res.text())
        .then((html) => {
          document.querySelector(".tools-swiper .swiper-wrapper").innerHTML = html;
          initToolsSwiper();
        })
        .catch((error) => {
          console.error('Error loading tools:', error);
        })
        .finally(() => {
          hideToolsLoading();
        });
    });
  });

  // --- AI AGENTS ---
  function initAiAgentsSwiper() {
    if (aiAgentsSwiper) aiAgentsSwiper.destroy(true, true);
    aiAgentsSwiper = new Swiper(".ai-agents-swiper", {
      slidesPerView: 1,
      spaceBetween: 20,
      navigation: {
        nextEl: ".ai-agents-next",
        prevEl: ".ai-agents-prev",
      },
      breakpoints: {
        640: { slidesPerView: 2 },
        1024: { slidesPerView: 3 },

      },
    });
  }
  initAiAgentsSwiper();
  $("#ai-agent-categories button").removeClass("active bg-[#FFCC00] text-[#0C2452]");
  $('#ai-agent-categories button[data-category="all"]').addClass("active bg-[#FFCC00] text-[#0C2452]");
  document.querySelectorAll("#ai-agent-categories button").forEach((btn) => {
    btn.addEventListener("click", function () {
      showAiAgentsLoading();
      const categoryId = this.getAttribute("data-category");
      document
        .querySelectorAll("#ai-agent-categories button")
        .forEach((b) => b.classList.remove("active", "bg-[#FFCC00]", "text-[#0C2452]"));
      this.classList.add("active", "bg-[#FFCC00]", "text-[#0C2452]");
      showAiAgentsLoading();
      fetch(`${ajaxurl}?action=filter_ai_agents_by_category&category_id=${categoryId}`)
        .then((res) => res.text())
        .then((html) => {
          document.querySelector(".ai-agents-swiper .swiper-wrapper").innerHTML = html;
          initAiAgentsSwiper();
        })
        .catch((error) => {
          console.error('Error loading AI agents:', error);
        })
        .finally(() => {
          hideAiAgentsLoading();
        });
    });
  });

  // --- AI TOOLS ---
  function initAiToolsSwiper() {
    if (aiToolsSwiper) aiToolsSwiper.destroy(true, true);
    aiToolsSwiper = new Swiper(".ai-tools-swiper", {
      slidesPerView: 1,
      spaceBetween: 20,
      navigation: {
        nextEl: ".ai-tools-next",
        prevEl: ".ai-tools-prev",
      },
      breakpoints: {
        640: { slidesPerView: 2 },
        1024: { slidesPerView: 3 },
      },
    });
  }
  initAiToolsSwiper();
  $("#ai-tool-categories button").removeClass("active bg-[#FFCC00] text-[#0C2452]");
  $('#ai-tool-categories button[data-category="all"]').addClass("active bg-[#FFCC00] text-[#0C2452]");
  document.querySelectorAll("#ai-tool-categories button").forEach((btn) => {
    btn.addEventListener("click", function () {
      showAiToolsLoading();
      const categoryId = this.getAttribute("data-category");
      document
        .querySelectorAll("#ai-tool-categories button")
        .forEach((b) => b.classList.remove("active", "bg-[#FFCC00]", "text-[#0C2452]"));
      this.classList.add("active", "bg-[#FFCC00]", "text-[#0C2452]");
      showAiToolsLoading();
      fetch(`${ajaxurl}?action=filter_ai_tools_by_category&category_id=${categoryId}`)
        .then((res) => res.text())
        .then((html) => {
          document.querySelector(".ai-tools-swiper .swiper-wrapper").innerHTML = html;
          initAiToolsSwiper();
        })
        .catch((error) => {
          console.error('Error loading AI tools:', error);
        })
        .finally(() => {
          hideAiToolsLoading();
        });
    });
  });

  // --- COURSES ---
  function initCoursesSwiper() {
    if (coursesSwiper) coursesSwiper.destroy(true, true);
    coursesSwiper = new Swiper(".courses-swiper", {
      slidesPerView: 1,
      spaceBetween: 20,
      navigation: {
        nextEl: ".courses-next",
        prevEl: ".courses-prev",
      },
      breakpoints: {
        640: { slidesPerView: 2 },
        1024: { slidesPerView: 3 },
        1200: { slidesPerView: 4 },
      },
    });
  }
  initCoursesSwiper();
  $("#course-categories button").removeClass("active bg-[#FFCC00] text-[#0C2452]");
  $('#course-categories button[data-category="all"]').addClass("active bg-[#FFCC00] text-[#0C2452]");
  document.querySelectorAll("#course-categories button").forEach((btn) => {
    btn.addEventListener("click", function () {
      showCoursesLoading();
      const categoryId = this.getAttribute("data-category");
      document
        .querySelectorAll("#course-categories button")
        .forEach((b) => b.classList.remove("active", "bg-[#FFCC00]", "text-[#0C2452]"));
      this.classList.add("active", "bg-[#FFCC00]", "text-[#0C2452]");
      showCoursesLoading();
      fetch(`${ajaxurl}?action=filter_courses_by_category&category_id=${categoryId}`)
        .then((res) => res.text())
        .then((html) => {
          document.querySelector(".courses-swiper .swiper-wrapper").innerHTML = html;
          initCoursesSwiper();
        })
        .catch((error) => {
          console.error('Error loading courses:', error);
        })
        .finally(() => {
          hideCoursesLoading();
        });
    });
  });

  // --- SERVICES ---
  function initServicesSwiper() {
    if (servicesSwiper) servicesSwiper.destroy(true, true);
    servicesSwiper = new Swiper(".services-swiper", {
      slidesPerView: 1,
      spaceBetween: 20,
      navigation: {
        nextEl: ".services-next",
        prevEl: ".services-prev",
      },
      breakpoints: {
        640: { slidesPerView: 2 },
        1024: { slidesPerView: 3 },
        1200: { slidesPerView: 4 },
      },
    });
  }
  initServicesSwiper();
  $("#service-categories button").removeClass("active bg-[#FFCC00] text-[#0C2452]");
  $('#service-categories button[data-category="all"]').addClass("active bg-[#FFCC00] text-[#0C2452]");
  document.querySelectorAll("#service-categories button").forEach((btn) => {
    btn.addEventListener("click", function () {
      showServicesLoading();
      const categoryId = this.getAttribute("data-category");
      document
        .querySelectorAll("#service-categories button")
        .forEach((b) => b.classList.remove("active", "bg-[#FFCC00]", "text-[#0C2452]"));
      this.classList.add("active", "bg-[#FFCC00]", "text-[#0C2452]");
      showServicesLoading();
      fetch(`${ajaxurl}?action=filter_services_by_category&category_id=${categoryId}`)
        .then((res) => res.text())
        .then((html) => {
          document.querySelector(".services-swiper .swiper-wrapper").innerHTML = html;
          initServicesSwiper();
        })
        .catch((error) => {
          console.error('Error loading services:', error);
        })
        .finally(() => {
          hideServicesLoading();
        });
    });
  });

  // --- CONTENT ---
  function initContentSwiper() {
    if (contentSwiper) contentSwiper.destroy(true, true);
    contentSwiper = new Swiper(".content-swiper", {
      slidesPerView: 1,
      spaceBetween: 20,
      navigation: {
        nextEl: ".content-next",
        prevEl: ".content-prev",
      },
      breakpoints: {
        640: { slidesPerView: 2 },
        1024: { slidesPerView: 3 },
        1200: { slidesPerView: 4 },
      },
    });
  }
  initContentSwiper();
  $("#content-categories button").removeClass("active bg-[#FFCC00] text-[#0C2452]");
  $('#content-categories button[data-category="all"]').addClass("active bg-[#FFCC00] text-[#0C2452]");
  document.querySelectorAll("#content-categories button").forEach((btn) => {
    btn.addEventListener("click", function () {
      const categoryId = this.getAttribute("data-category");
      document
        .querySelectorAll("#content-categories button")
        .forEach((b) => b.classList.remove("active", "bg-[#FFCC00]", "text-[#0C2452]"));
      this.classList.add("active", "bg-[#FFCC00]", "text-[#0C2452]");
      
      showContentLoading();
      fetch(`${ajaxurl}?action=filter_content_by_category&category_id=${categoryId}`)
        .then((res) => res.json())
        .then((data) => {
          if (data.success) {
            document.querySelector(".content-swiper .swiper-wrapper").innerHTML = data.data;
            initContentSwiper();
          } else {
            console.error('Error loading content:', data.message || 'Unknown error');
          }
        })
        .catch((error) => {
          console.error('Error loading content:', error);
        })
        .finally(() => {
          hideContentLoading();
        });
    });
  });

  // Typed.js for hero
  $(".element").typed({
    strings: ["Tools", "Courses", "Services"],
    typeSpeed: 50,
    backSpeed: 30,
    backDelay: 3000,
    loop: true,
    showCursor: true,
    cursorChar: "",
  });

  // --- LOADER TEMPLATE ---
  function getLoaderHTML() {
    return `
      <div class="absolute inset-0 bg-white/70 flex items-center justify-center z-10 rounded-xl">
        <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-[var(--primary)]"></div>
      </div>
    `;
  }

  // --- TOOLS ---
  function showToolsLoading() {
    const swiperWrapper = document.querySelector('.tools-swiper .swiper-wrapper');
    if (swiperWrapper) {
      swiperWrapper.style.position = 'relative';
      swiperWrapper.insertAdjacentHTML('beforeend', getLoaderHTML());
    }
  }
  
  function hideToolsLoading() {
    const loader = document.querySelector('.tools-swiper .swiper-wrapper > div[style*="absolute"]');
    if (loader) loader.remove();
  }

  // --- AI AGENTS ---
  function showAiAgentsLoading() {
    const swiperWrapper = document.querySelector('.ai-agents-swiper .swiper-wrapper');
    if (swiperWrapper) {
      swiperWrapper.style.position = 'relative';
      swiperWrapper.insertAdjacentHTML('beforeend', getLoaderHTML());
    }
  }
  
  function hideAiAgentsLoading() {
    const loader = document.querySelector('.ai-agents-swiper .swiper-wrapper > div[style*="absolute"]');
    if (loader) loader.remove();
  }

  // --- COURSES ---
  function showCoursesLoading() {
    const swiperWrapper = document.querySelector('.courses-swiper .swiper-wrapper');
    if (swiperWrapper) {
      swiperWrapper.style.position = 'relative';
      swiperWrapper.insertAdjacentHTML('beforeend', getLoaderHTML());
    }
  }
  
  function hideCoursesLoading() {
    const loader = document.querySelector('.courses-swiper .swiper-wrapper > div[style*="absolute"]');
    if (loader) loader.remove();
  }

  // --- SERVICES ---
  function showServicesLoading() {
    const swiperWrapper = document.querySelector('.services-swiper .swiper-wrapper');
    if (swiperWrapper) {
      swiperWrapper.style.position = 'relative';
      swiperWrapper.insertAdjacentHTML('beforeend', getLoaderHTML());
    }
  }
  
  function hideServicesLoading() {
    const loader = document.querySelector('.services-swiper .swiper-wrapper > div[style*="absolute"]');
    if (loader) loader.remove();
  }

  // --- CONTENT ---
  function showContentLoading() {
    const swiperWrapper = document.querySelector('.content-swiper .swiper-wrapper');
    if (swiperWrapper) {
      swiperWrapper.style.position = 'relative';
      swiperWrapper.insertAdjacentHTML('beforeend', getLoaderHTML());
    }
  }
  
  function hideContentLoading() {
    const loader = document.querySelector('.content-swiper .swiper-wrapper > div[style*="absolute"]');
    if (loader) loader.remove();
  }

  // --- AI TOOLS ---
  function showAiToolsLoading() {
    const swiperWrapper = document.querySelector('.ai-tools-swiper .swiper-wrapper');
    if (swiperWrapper) {
      swiperWrapper.style.position = 'relative';
      swiperWrapper.insertAdjacentHTML('beforeend', getLoaderHTML());
    }
  }
  
  function hideAiToolsLoading() {
    const loader = document.querySelector('.ai-tools-swiper .swiper-wrapper > div[style*="absolute"]');
    if (loader) loader.remove();
  }

  // --- LOADING ---
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
    header.style.opacity = "1";
    header.style.transform = "translateY(0)";
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
});
