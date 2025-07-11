<section class="bg-white px-3 sm:px-5 py-[80px] relative"  data-aos-delay="100">
  <section class="max-w-[1440px] mx-auto">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
      <div class="flex items-center gap-2">
        <?php $content_count = wp_count_posts()->publish; ?>
        <span class="bg-[#FFCC00] text-[var(--primary)] py-1 px-2 rounded-md text-[20px]"> <?php echo $content_count; ?> </span>
        <h1 class="text-[22px] sm:text-[40px] font-semibold">Content</h1>
      </div>
    
    </div>
    <?php $content_categories = get_categories(['hide_empty' => true, 'number' => 6]); ?>
    <div class="mt-5 lg:flex grid grid-cols-2 items-center gap-5" id="content-categories">
      <button class="bg-white py-2.5 px-4 rounded-sm text-[14px] text-[#5A6478] cursor-pointer active" data-category="all">All</button>
      <?php foreach ($content_categories as $category): ?>
        <button class="bg-white py-2.5 px-4 rounded-sm text-[14px] text-[#5A6478] cursor-pointer" data-category="<?php echo (string) $category->term_id; ?>"><?php echo $category->name; ?></button>
      <?php endforeach; ?>
    </div>
    <div class="mt-5 swiper-flex-wrap relative" style="display:flex;align-items:center;position:relative;">
      <div class="swiper-button-prev content-prev text-base"></div>
      <div class="swiper-container-wrap" style="flex:1;overflow:hidden;">
        <div class="swiper content-swiper" style="overflow:visible;">
          <div class="swiper-wrapper">
            <?php
            $contents = new WP_Query([
              'post_type' => 'post',
              'posts_per_page' => 12,
              'orderby' => 'date',
              'order' => 'DESC',
            ]);
            if ($contents->have_posts()):
              while ($contents->have_posts()):
                $contents->the_post();
                ?>
            <div class="swiper-slide content-slide h-full">
                <a href="<?php the_permalink(); ?>" class="block bg-white rounded-sm h-full flex flex-col border border-[#C9C9C961] overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="p-4 flex flex-col items-center flex-1 w-full gap-3">
                        <?php 
                        // First try to get the featured image
                        $thumbnail_id = get_post_thumbnail_id();
                        
                        if ($thumbnail_id) {
                            // Get the image source with medium size
                            $thumbnail_src = wp_get_attachment_image_src($thumbnail_id, 'medium');
                            if ($thumbnail_src && !empty($thumbnail_src[0])) {
                                echo '<img src="' . esc_url($thumbnail_src[0]) . '" alt="' . esc_attr(get_the_title()) . '" class="w-full h-[210px] object-cover" loading="lazy" />';
                            } else {
                                // Try to get the full size if medium is not available
                                $full_src = wp_get_attachment_image_src($thumbnail_id, 'full');
                                if ($full_src && !empty($full_src[0])) {
                                    echo '<img src="' . esc_url($full_src[0]) . '" alt="' . esc_attr(get_the_title()) . '" class="w-full h-[210px] object-cover" loading="lazy" />';
                                } else {
                                    // Fallback to default image
                                    echo '<img src="' . esc_url(get_template_directory_uri() . '/images/placeholder.jpg') . '" alt="' . esc_attr(get_the_title()) . '" class="w-full h-[210px] object-cover" />';
                                }
                            }
                        } else {
                            // Check if there are any images attached to the post
                            $attachments = get_posts(array(
                                'post_type' => 'attachment',
                                'posts_per_page' => 1,
                                'post_parent' => get_the_ID(),
                                'exclude' => get_post_thumbnail_id()
                            ));
                            
                            if ($attachments) {
                                $first_attachment = wp_get_attachment_image_src($attachments[0]->ID, 'medium');
                                if ($first_attachment && !empty($first_attachment[0])) {
                                    echo '<img src="' . esc_url($first_attachment[0]) . '" alt="' . esc_attr(get_the_title()) . '" class="w-full h-[210px] object-cover" loading="lazy" />';
                                } else {
                                    // Fallback to default image
                                    echo '<img src="' . esc_url(get_template_directory_uri() . '/images/placeholder.jpg') . '" alt="' . esc_attr(get_the_title()) . '" class="w-full h-[210px] object-cover" />';
                                }
                            } else {
                                // Default image if no images found
                                echo '<img src="' . esc_url(get_template_directory_uri() . '/images/placeholder.jpg') . '" alt="' . esc_attr(get_the_title()) . '" class="w-full h-[210px] object-cover" />';
                            }
                        }
                        ?>
                        <div class="flex-1 flex flex-col">
                            <h1 class="text-[#1B1D1F] text-center text-[20px] font-semibold"><?php the_title(); ?></h1>
                            <p class="text-[#5A6478] text-center text-[14px] font-normal mt-2">
                                <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                            </p>
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
      <div class="swiper-button-next content-next text-base"></div>
    </div>
  </section>
</section>
