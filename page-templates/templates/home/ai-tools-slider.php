<section class=" px-3 sm:px-5 py-[80px] relative"  data-aos-delay="100">
  <div class="ai-tools-loading-overlay fixed inset-0 flex items-center justify-center bg-white/70 z-50 hidden">
    <div class="banter-loader"><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div></div>
  </div>
  <section class="max-w-[1440px] mx-auto">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
      <div class="flex items-center gap-2">
        <?php $ai_tools_count = wp_count_posts('ai-tool')->publish; ?>
        <span class="bg-[#FFCC00] text-[var(--primary)] py-1 px-2 rounded-sm text-[20px]"> <?php echo $ai_tools_count; ?> </span>
        <h1 class="text-[22px] sm:text-[40px]">AI <span class="text-[var(--primary)]">Tools</span></h1>
      </div>
      <div class="flex justify-end">
        <a href="/ai-tools" class="bg-[var(--primary)] w-fit h-fit text-white py-2 px-3 sm:px-5 rounded-sm">View All</a>
      </div>
    </div>
    <?php $ai_tool_categories = get_terms(['taxonomy' => 'ai-tool-category', 'hide_empty' => true, 'number' => 6]); ?>
    <div class="mt-5 lg:flex grid grid-cols-2 items-center gap-5" id="ai-tool-categories">
      <button class="bg-white py-2.5 px-4 rounded-sm text-[14px] text-[#5A6478] cursor-pointer active" data-category="all">All</button>
      <?php foreach ($ai_tool_categories as $category): ?>
        <button class="bg-white py-2.5 px-4 rounded-sm text-[14px] text-[#5A6478] cursor-pointer" data-category="<?php echo (string) $category->term_id; ?>"><?php echo $category->name; ?></button>
      <?php endforeach; ?>
    </div>
    <div class="mt-5 swiper-flex-wrap relative" style="display:flex;align-items:center;position:relative;">
      <div class="swiper-button-prev ai-tools-prev text-base"></div>
      <div class="swiper-container-wrap" style="flex:1;overflow:hidden;">
        <div class="swiper ai-tools-swiper" style="overflow:visible;">
          <div class="swiper-wrapper">
            <?php
            $ai_tools = new WP_Query([
              'post_type' => 'ai-tool',
              'posts_per_page' => 12,
              'orderby' => 'date',
              'order' => 'DESC',
            ]);
            if ($ai_tools->have_posts()):
              while ($ai_tools->have_posts()):
                $ai_tools->the_post();
                ?>
            <div class="swiper-slide tool-slide" data-tags="<?php $tags = get_the_terms(get_the_ID(), 'ai-tool-tag'); echo esc_attr($tags && !is_wp_error($tags) ? implode(',', array_map(function($tag) { return $tag->name; }, $tags)) : ''); ?>" data-img="<?php echo esc_url(has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'medium') : 'https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/Saly-1.png'); ?>" data-title="<?php echo esc_attr(get_the_title()); ?>" data-excerpt="<?php echo esc_attr(wp_trim_words(get_the_excerpt(), 20)); ?>" data-link="<?php echo esc_url(get_permalink()); ?>">
              <a href="<?php the_permalink(); ?>" class="no-d-hover block bg-[#B3C5FF1A] p-6 rounded-xl h-full flex flex-col border border-[var(--primary)]">
                <div class="flex flex-col flex-1 w-full gap-3">
                  <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('medium', ['class' => 'w-full h-[210px] object-cover rounded-md']); ?>
                  <?php else: ?>
                    <img src="https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/Saly-1.png" alt="<?php the_title(); ?>" class="w-full h-[210px] object-cover rounded-md" />
                  <?php endif; ?>
                  <h1 class="text-[#1B1D1F] text-[20px] font-semibold"><?php the_title(); ?></h1>
                  <p class="text-[#5A6478] text-[14px] font-normal"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                  <div class="ai-tool-features">
                    <?php
                    $tags = get_the_terms(get_the_ID(), 'ai-tool-tag');
                    if ($tags && !is_wp_error($tags)) {
                      echo '<ul class="feature-list flex gap-2 flex-wrap">';
                      foreach ($tags as $tag) {
                        echo '<li class="text-[var(--primary)] bg-[#0F44F31A] p-2 text-[14px] font-normal rounded-full">' . esc_html($tag->name) . '</li>';
                      }
                      echo '</ul>';
                    } else {
                      echo '<p>No tags available.</p>';
                    }
                    ?>  
                  </div>
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
      <div class="swiper-button-next ai-tools-next text-base"></div>
    </div>
  </section>
</section>
