<section class="bg-white px-3 sm:px-5 py-[80px] relative"  data-aos-delay="100">
  <section class="max-w-[1440px] mx-auto">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
      <div class="flex items-center gap-2">
        <?php $courses_count = wp_count_posts('course')->publish; ?>
        <span class="bg-[#FFCC00] text-[var(--primary)] py-1 px-2 rounded-md text-[20px]"> <?php echo $courses_count; ?> </span>
        <h1 class="text-[22px] sm:text-[40px] font-semibold">Digital Marketing <span class="text-[var(--primary)]">Courses</span></h1>
      </div>
      <div class="flex justify-end">
        <a href="/courses" class="bg-[var(--primary)] w-fit h-fit text-white py-2 px-3 sm:px-5 rounded-md">View All</a>
      </div>
    </div>
    <?php $course_categories = get_terms(['taxonomy' => 'course-category', 'hide_empty' => true, 'number' => 6]); ?>
    <div class="mt-5 lg:flex grid grid-cols-2 items-center gap-5" id="course-categories">
      <button class="bg-white py-2.5 px-4 rounded-sm text-[14px] text-[#5A6478] cursor-pointer active" data-category="all">All</button>
      <?php foreach ($course_categories as $category): ?>
        <button class="bg-white py-2.5 px-4 rounded-sm text-[14px] text-[#5A6478] cursor-pointer" data-category="<?php echo (string) $category->term_id; ?>"><?php echo $category->name; ?></button>
      <?php endforeach; ?>
    </div>
    <div class="mt-5 swiper-flex-wrap relative" style="display:flex;align-items:center;position:relative;">
      <div class="swiper-button-prev courses-prev text-base"></div>
      <div class="swiper-container-wrap" style="flex:1;overflow:hidden;">
        <div class="swiper courses-swiper" style="overflow:visible;">
          <div class="swiper-wrapper">
            <?php
            $courses = new WP_Query([
              'post_type' => 'course',
              'posts_per_page' => 12,
              'orderby' => 'date',
              'order' => 'DESC',
            ]);
            if ($courses->have_posts()):
              while ($courses->have_posts()):
                $courses->the_post();
                $categories = wp_get_post_terms(get_the_ID(), 'course-category', array('fields' => 'ids'));
                $category_classes = implode(' ', array_map(function ($cat) {
                    return 'category-' . $cat;
                }, $categories));
                $data_categories = implode(',', array_map('strval', $categories));
                ?>
            <a href="<?php the_permalink(); ?>" class="swiper-slide tool-slide block h-full <?php echo $category_classes; ?>" data-categories="<?php echo esc_attr($data_categories); ?>">
              <div class="bg-white rounded-xl h-full flex flex-col overflow-hidden border border-[#C9C9C961] hover:shadow-lg transition-shadow duration-300">
                <div class="p-4 flex flex-col items-center flex-1 w-full gap-3">
                  <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('medium', ['class' => 'w-full h-[210px] object-cover']); ?>
                  <?php else: ?>
                    <img src="https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/Saly-1.png" alt="<?php the_title(); ?>" class="w-full h-[210px] object-cover" />
                  <?php endif; ?>
                  <h1 class="text-[#1B1D1F] text-center text-[20px] font-semibold"><?php the_title(); ?></h1>
                  <p class="text-[#5A6478] text-center text-[14px] font-normal"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                </div>
                <div class="p-4 pt-0 mt-auto">
                  <?php 
                  // Get price and currency from meta fields
                  $course_price = get_post_meta(get_the_ID(), '_amount', true);
                  $currency = get_post_meta(get_the_ID(), '_currency', true) ?: 'USD';
                  
                  if ($course_price !== ''): 
                  ?>
                    <div class="flex flex-col items-center gap-1">
                      <?php if ($course_price !== '0'): ?>
                        <span class="text-[#5A6478] text-sm"><?php _e('Starting from', 'wb'); ?></span>
                        <div class="flex items-center justify-center gap-1">
                          <span class="text-[var(--primary)] text-2xl font-bold">
                            <?php 
                            if ($course_price === '0') {
                                _e('FREE', 'wb');
                            } else {
                                echo esc_html($currency . $course_price);
                            }
                            ?>
                          </span>
                        </div>
                      <?php else: ?>
                        <span class="text-[var(--primary)] text-2xl font-bold">
                          <?php _e('FREE', 'wb'); ?>
                        </span>
                      <?php endif; ?>
                    </div>
                  <?php else: ?>
                    <div class="text-center py-2 text-[#5A6478] text-sm">
                      <?php _e('', 'wb'); ?>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </a>
            <?php endwhile;
              wp_reset_postdata();
            else: ?>
            <div class="swiper-slide col-span-4 text-center text-red-500 font-bold">No items found.</div>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="swiper-button-next courses-next text-base"></div>
    </div>
  </section>
</section>
