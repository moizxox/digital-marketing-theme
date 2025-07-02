<section class="bg-[#FF92001A] px-3 sm:px-5 py-[80px] relative"  data-aos-delay="100">
    <div class="tools-loading-overlay fixed inset-0 flex items-center justify-center bg-white/70 z-50 hidden">
      <div class="banter-loader"><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div></div>
    </div>
    <section class="max-w-[1440px] mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <div class="flex items-center gap-2">
                <?php
                $tools_count = wp_count_posts('tool')->publish;
                ?>
                <span class="bg-[#FFCC00] text-[var(--primary)] py-1 px-2 rounded-sm text-[20px]"><?php echo $tools_count; ?></span>
                <h1 class="text-[22px] sm:text-[40px]">
                    <?php _e('Digital Marketing', 'wb'); ?> <span class="text-[var(--primary)]"><?php _e('Tools', 'wb'); ?></span>
                </h1>
            </div>
            <div class="flex justify-end">
                <a href="/tools" class="bg-[var(--primary)] w-fit h-fit text-white py-2 px-3 sm:px-5 rounded-sm">
                    <?php _e('View All', 'wb'); ?>
                </a>
            </div>
        </div>

        <?php
        // Get tool categories
        $tool_categories = get_terms(array(
            'taxonomy' => 'tool-category',
            'hide_empty' => true,
            'number' => 6
        ));
        ?>
        <div class="mt-5 lg:flex grid grid-cols-2 items-center gap-5" id="tool-categories">
            <button class="bg-white py-2.5 px-4 rounded-sm text-[14px] text-[#5A6478] cursor-pointer active" data-category="all">
                <?php _e('All', 'wb'); ?>
            </button>
            <?php foreach ($tool_categories as $category): ?>
                <button class="bg-white py-2.5 px-4 rounded-sm text-[14px] text-[#5A6478] cursor-pointer" data-category="<?php echo (string) $category->term_id; ?>">
                    <?php echo $category->name; ?>
                </button>
            <?php endforeach; ?>
        </div>

        <?php
        // Get all tools
        $all_tools = new WP_Query(array(
            'post_type' => 'tool',
            'posts_per_page' => 100,
            'orderby' => 'date',
            'order' => 'DESC'
        ));
        ?>
        <div class="mt-5 swiper-flex-wrap" style="display:flex;align-items:center;position:relative;">
            <div class="swiper-button-prev text-base"></div>
            <div class="swiper-container-wrap" style="flex:1;overflow:hidden;">
                <div class="swiper tools-swiper" style="overflow:visible;">
                    <div class="swiper-wrapper">
                        <?php
                        if ($all_tools->have_posts()):
                            while ($all_tools->have_posts()):
                                $all_tools->the_post();
                                $price = get_post_meta(get_the_ID(), '_price', true);
                                $price_from = get_post_meta(get_the_ID(), '_price_from', true);
                                $categories = wp_get_post_terms(get_the_ID(), 'tool-category', array('fields' => 'ids'));
                                $category_classes = implode(' ', array_map(function ($cat) {
                                    return 'category-' . $cat;
                                }, $categories));
                                $data_categories = implode(',', array_map('strval', $categories));
                                ?>
                            <div class="swiper-slide tool-slide <?php echo $category_classes; ?>" data-categories="<?php echo esc_attr($data_categories); ?>">
                                <div class="bg-white rounded-sm h-full flex flex-col">
                                    <div class="p-4 flex flex-col items-center flex-1 w-full gap-3">
                                        <?php if (has_post_thumbnail()): ?>
                                            <?php the_post_thumbnail('medium', array('class' => 'w-full h-[210px] object-cover')); ?>
                                        <?php else: ?>
                                            <img src="https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/Saly-1.png" alt="<?php the_title(); ?>" class="w-full h-[210px] object-cover" />
                                        <?php endif; ?>
                                        <h1 class="text-[#1B1D1F] text-center text-[20px] font-semibold"><?php the_title(); ?></h1>
                                        <p class="text-[#5A6478] text-center text-[14px] font-normal">
                                            <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                                        </p>
                                        <?php if ($price || $price_from): ?>
                                            <h1 class="flex gap-2 items-center justify-center text-[#1B1D1F] text-[14px] text-center mt-2">
                                                <?php _e('Price from', 'wb'); ?>
                                                <span class="text-[#1B1D1F] text-center text-[20px] font-semibold">
                                                    <?php echo $price_from ? '$' . $price_from : '$' . $price; ?>
                                                </span>
                                            </h1>
                                        <?php endif; ?>
                                    </div>
                                    <a href="<?php the_permalink(); ?>" class="block text-center py-3.5 rounded-b-sm bg-[var(--primary)] text-white mt-auto w-full">
                                        <?php _e('Buy Now', 'wb'); ?>
                                    </a>
                                </div>
                            </div>
                        <?php
                            endwhile;
                        else:
                            ?>
                            <div class="swiper-slide col-span-4 text-center text-red-500 font-bold">No tools found.</div>
                        <?php
                        endif;
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
            </div>
            <div class="swiper-button-next text-base"></div>
        </div>
    </section>
</section>
