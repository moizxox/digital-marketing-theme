<style>
  .newsletter {
   background:url('<?php echo get_template_directory_uri(); ?>/images/home/newsletter-bg.png') no-repeat center center/cover;
  }
</style>
<section class="px-3 sm:px-5 py-[80px] bg-white"  data-aos-delay="100">
  <div class="max-w-[1440px] mx-auto newsletter text-white rounded-lg px-4 py-10">
    <div class="flex flex-col items-center">
      <h1 class="text-center text-[25px] sm:text-[40px] leading-tight mb-2 font-bold text-white">
        Subscribe to Our <span class="text-[#FFCC00]">Newsletter</span>
      </h1>
      <h2 class="text-center text-[18px] sm:text-[22px] font-medium mb-6 text-white">
        Stay up to date with the latest marketing tools and tips.
      </h2>

      <form action="#" method="post" class="w-full sm:w-[70%]">
        <div class="bg-[#FFFFFF1A] rounded-[8px] p-3 flex flex-col md:flex-row gap-3 items-center">
          <input 
            class="bg-white text-[#797979] px-4 py-3 rounded-sm w-full md:flex-1"
            type="email" 
            placeholder="example@email.com" 
            required
          />
          <button 
            type="submit" 
            class="cursor-pointer bg-[#FFCC00] px-5 py-3 flex items-center justify-center gap-2 rounded-sm text-[var(--primary)] text-[16px] font-semibold w-full md:w-auto"
          >
            Subscribe <i class="fa-solid fa-paper-plane"></i>
          </button>
        </div>
      </form>
    </div>
  </div>
</section>