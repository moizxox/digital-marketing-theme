<section class="bg-[#FF92001A] px-3 sm:px-5 py-[80px] relative" data-aos-delay="100">
  <div class="services-loading-overlay fixed inset-0 flex items-center justify-center bg-white/70 z-50 hidden">
    <div class="banter-loader">
      <div class="banter-loader__box"></div>
      <div class="banter-loader__box"></div>
      <div class="banter-loader__box"></div>
      <div class="banter-loader__box"></div>
      <div class="banter-loader__box"></div>
      <div class="banter-loader__box"></div>
      <div class="banter-loader__box"></div>
      <div class="banter-loader__box"></div>
      <div class="banter-loader__box"></div>
    </div>
  </div>
  <section class="max-w-[1440px] mx-auto">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
      <div class="flex items-center gap-2">
        <?php $services_count = wp_count_posts('service')->publish; ?>
        <span class="bg-[#FFCC00] text-[var(--primary)] py-1 px-2 rounded-sm text-[20px]"> <?php echo $services_count; ?> </span>
        <h1 class="text-[22px] sm:text-[40px]">Digital Marketing <span class="text-[var(--primary)]">Services</span></h1>
      </div>
      <div class="flex justify-end">
        <a href="/services" class="bg-[var(--primary)] w-fit h-fit text-white py-2 px-3 sm:px-5 rounded-sm">View All</a>
      </div>
    </div>
    <?php $service_categories = get_terms(['taxonomy' => 'service-category', 'hide_empty' => true, 'number' => 6]); ?>
    <div class="mt-5 lg:flex grid grid-cols-2 items-center gap-5" id="service-categories">
      <button class="bg-white py-2.5 px-4 rounded-sm text-[14px] text-[#5A6478] cursor-pointer active" data-category="all">All</button>
      <?php foreach ($service_categories as $category): ?>
        <button class="bg-white py-2.5 px-4 rounded-sm text-[14px] text-[#5A6478] cursor-pointer" data-category="<?php echo (string) $category->term_id; ?>"><?php echo $category->name; ?></button>
      <?php endforeach; ?>
    </div>
    <div class="mt-5 swiper-flex-wrap relative" style="display:flex;align-items:center;position:relative;">
      <div class="swiper-button-prev services-prev text-base"></div>
      <div class="swiper-container-wrap" style="flex:1;overflow:hidden;">
        <div class="swiper services-swiper" style="overflow:visible;">
          <div class="swiper-wrapper">
            <?php
            $services = new WP_Query([
              'post_type' => 'service',
              'posts_per_page' => 12,
              'orderby' => 'date',
              'order' => 'DESC',
            ]);
            if ($services->have_posts()):
              while ($services->have_posts()):
                $services->the_post();
                ?>
                <div class="swiper-slide tool-slide">
                  <a href="<?php the_permalink(); ?>" class="no-d-hover bg-white rounded-lg h-full flex flex-col overflow-hidden ">
                    <div class="p-4 flex flex-col items-center flex-1 w-full gap-3">
                      <?php if (has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('medium', ['class' => 'w-full h-[210px] object-cover']); ?>
                      <?php else: ?>
                        <img src="https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/Saly-1.png" alt="<?php the_title(); ?>" class="w-full h-[210px] object-cover" />
                      <?php endif; ?>
                      <h1 class="text-[#1B1D1F] text-center text-[20px] font-semibold"><?php the_title(); ?></h1>
                      <p class="text-[#5A6478] text-center text-[14px] font-normal"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                    </div>

                  </a>
                </div>
              <?php endwhile;
              wp_reset_postdata();
            else: ?>
              <div class="swiper-slide col-span-4 text-center text-red-500 font-bold">No items found.</div>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="swiper-button-next services-next text-base"></div>
    </div>
  </section>
</section>