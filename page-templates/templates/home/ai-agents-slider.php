<section class="bg-white px-3 sm:px-5 py-[80px] relative"  data-aos-delay="100">
  <div class="ai-agents-loading-overlay fixed inset-0 flex items-center justify-center bg-white/70 z-50 hidden">
    <div class="banter-loader"><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div></div>
  </div>
  <section class="max-w-[1440px] mx-auto">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
      <div class="flex items-center gap-2">
        <?php $ai_agents_count = wp_count_posts('ai-agent')->publish; ?>
        <span class="bg-[#FFCC00] text-[var(--primary)] py-1 px-2 rounded-sm text-[20px]"> <?php echo $ai_agents_count; ?> </span>
        <h1 class="text-[22px] sm:text-[40px]">AI <span class="text-[var(--primary)]">Agents</span></h1>
      </div>
      <div class="flex justify-end">
        <a href="/ai-agents" class="bg-[var(--primary)] w-fit h-fit text-white py-2 px-3 sm:px-5 rounded-sm">View All</a>
      </div>
    </div>
    <?php $ai_agent_categories = get_terms(['taxonomy' => 'ai-agent-category', 'hide_empty' => true, 'number' => 6]); ?>
    <div class="mt-5 lg:flex grid grid-cols-2 items-center gap-5" id="ai-agent-categories">
      <button class="bg-white py-2.5 px-4 rounded-sm text-[14px] text-[#5A6478] cursor-pointer active" data-category="all">All</button>
      <?php foreach ($ai_agent_categories as $category): ?>
        <button class="bg-white py-2.5 px-4 rounded-sm text-[14px] text-[#5A6478] cursor-pointer" data-category="<?php echo (string) $category->term_id; ?>"><?php echo $category->name; ?></button>
      <?php endforeach; ?>
    </div>
    <div class="mt-5 swiper-flex-wrap relative" style="display:flex;align-items:center;position:relative;">
      <div class="swiper-button-prev ai-agents-prev text-base"></div>
      <div class="swiper-container-wrap" style="flex:1;overflow:hidden;">
        <div class="swiper ai-agents-swiper" style="overflow:visible;">
          <div class="swiper-wrapper">
            <?php
            $ai_agents = new WP_Query([
              'post_type' => 'ai-agent',
              'posts_per_page' => 12,
              'orderby' => 'date',
              'order' => 'DESC',
            ]);
            if ($ai_agents->have_posts()):
              while ($ai_agents->have_posts()):
                $ai_agents->the_post();
                ?>
            <div class="swiper-slide tool-slide my-gradient-background p-4 rounded-3xl" data-amount="<?php $amount = get_post_meta(get_the_ID(), '_amount', true);
                echo !empty($amount) ? esc_attr($amount) : ''; ?>" data-currency="<?php $currency = get_post_meta(get_the_ID(), '_currency', true);
                echo !empty($currency) ? esc_attr($currency) : ''; ?>" data-img="<?php echo esc_url(has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'medium') : 'https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/Saly-1.png'); ?>" data-title="<?php echo esc_attr(get_the_title()); ?>" data-excerpt="<?php echo esc_attr(wp_trim_words(get_the_excerpt(), 20)); ?>" data-link="<?php echo esc_url(get_permalink()); ?>">
              <div class="rounded-sm h-full flex flex-col gap-2">
                <div class="flex flex-col flex-1 w-full gap-3">
                  <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('medium', ['class' => 'w-full h-[240px] rounded-md object-cover']); ?>
                  <?php else: ?>
                    <img src="https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/Saly-1.png" alt="<?php the_title(); ?>" class="w-full h-[240px] rounded-md object-cover" />
                  <?php endif; ?>
                  <h1 class="text-white text-[20px] font-semibold"><?php the_title(); ?></h1>
                  <span class="text-white text-[14px] font-normal">24/7</span>
                  <p class="text-white text-[14px] font-normal"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                </div >
                <div class="flex items-center gap-2">
                  <h4 class="text-white text-[20px] font-semibold grow"><?php $amount = get_post_meta(get_the_ID(), '_amount', true);
                $currency = get_post_meta(get_the_ID(), '_currency', true);
                echo !empty($amount) ? esc_html($amount) : 'N/A'; ?> <?php echo !empty($currency) ? esc_html($currency) : ''; ?></h4>
                  
                  <a href="<?php the_permalink(); ?>" class=" text-center p-3 rounded-md bg-white border border-[var(--primary)] text-[var(--primary)]">Deploy Agent</a>
                </div>
              </div>
            </div>
            <?php endwhile;
              wp_reset_postdata();
            else: ?>
            <div class="swiper-slide col-span-4 text-center text-red-500 font-bold">No items found.</div>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="swiper-button-next ai-agents-next text-base"></div>
    </div>
  </section>
</section>
