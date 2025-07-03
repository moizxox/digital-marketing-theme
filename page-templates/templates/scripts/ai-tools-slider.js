// AI Tools Slider
let aiToolsSwiper;

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

function showAiToolsLoading() {
  document.querySelector(".ai-tools-loading-overlay").classList.remove("hidden");
  setTimeout(() => {
    document.querySelector(".ai-tools-loading-overlay").classList.add("hidden");
  }, 500);
}

// Initialize on load
document.addEventListener("DOMContentLoaded", function() {
  initAiToolsSwiper();
  
  // Set default active category
  $("#ai-tool-categories button").removeClass("active bg-[#FFCC00] text-[#0C2452]");
  $('button[data-category="all"]').addClass("active bg-[#FFCC00] text-[#0C2452]");

  // Handle category filter clicks
  document.querySelectorAll("#ai-tool-categories button").forEach((btn) => {
    btn.addEventListener("click", function() {
      showAiToolsLoading();
      const categoryId = this.getAttribute("data-category");
      document
        .querySelectorAll("#ai-tool-categories button")
        .forEach((b) => b.classList.remove("active", "bg-[#FFCC00]", "text-[#0C2452]"));
      this.classList.add("active", "bg-[#FFCC00]", "text-[#0C2452]");
      
      fetch(`${ajaxurl}?action=filter_ai_tools_by_category&category_id=${categoryId}`)
        .then((res) => res.text())
        .then((html) => {
          document.querySelector(".ai-tools-swiper .swiper-wrapper").innerHTML = html;
          initAiToolsSwiper();
          document.querySelectorAll('.ai-tools-swiper .swiper-slide').forEach((slide) => {
            slide.innerHTML = `<a href="${slide.dataset.link}" class="no-d-hover block bg-[#B3C5FF1A] p-6 rounded-xl h-full flex flex-col border border-[var(--primary)]">
                                <div class="flex flex-col flex-1 w-full gap-3">
                                  <img src="${slide.dataset.img}" alt="${slide.dataset.title}" class="w-full h-[210px] object-cover rounded-md" />
                                  <h1 class="text-[#1B1D1F] text-[20px] font-semibold">${slide.dataset.title}</h1>
                                </div>
                              </a>`;
          });
        });
    });
  });
});
