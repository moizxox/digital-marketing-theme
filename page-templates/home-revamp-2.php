<?php

/**
 * Template Name: Homepage revamp 2
 */

if (!defined('ABSPATH')) {
	exit;
}

// Add critical CSS inline in head
add_action('wp_head', function() {
    ?>
    <style>
    /* Critical CSS for initial render */
    .page-loading {
        position: fixed;
        inset: 0;
        background: #fff;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: opacity 0.3s ease-out, visibility 0.3s ease-out;
    }
    .page-loading.hidden {
        opacity: 0;
        visibility: hidden;
    }
    .page-content {
        opacity: 0;
        transition: opacity 0.3s ease-in;
    }
    .page-content.loaded {
        opacity: 1;
    }
    /* Initial state for animated elements */
    [data-aos] {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }
    [data-aos].aos-animate {
        opacity: 1;
        transform: translateY(0);
    }
    /* Loading spinner */
    .loading-spinner {
        width: 50px;
        height: 50px;
        border: 3px solid #f3f3f3;
        border-top: 3px solid var(--primary);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    </style>
    <?php
}, 1);

wp_enqueue_script('typed', WB_THEME_URL . '/js/typed.js', array('main'));

get_header();

if (($popular_terms = wp_cache_get('_popular_terms')) === false) {
	$popular_terms = get_terms(array(
		'taxonomy' => array(
			'tool-category',
			'tool-tag',
			'course-category',
			'course-tag',
			'service-category',
			'service-tag'
		),
		'number' => 4,
		'meta_query' => array(
			array(
				'key' => '_views',
				'type' => 'NUMERIC'
			)
		),
		'orderby' => 'meta_value_num',
		'order' => 'DESC'
	));

	wp_cache_set('_popular_terms', $popular_terms, 'wb', DAY_IN_SECONDS);
}

?>

<!-- Loading State -->
<div class="page-loading">
    <div class="loading-spinner"></div>
</div>

<!-- Main Content -->
<div class="page-content">

<!-- Hero Section -->
<section class="relative overflow-hidden my-gradient-background z-0" data-aos="fade-up">

    <!-- Background Left Image -->
    <div class="absolute bottom-0 left-0 z-0">
        <img src="https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/bg-left-e1748528653547.png" alt="" />
    </div>

    <!-- Background Right Image -->
    <div class="absolute top-[-60px] right-0 z-0">
        <img class="h-full" src="https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/bg-right.png" alt="" />
    </div>

    <!-- Content Wrapper -->
    <div class="relative z-[1] flex flex-col lg:flex-row items-center justify-between gap-5 max-w-[1440px] mx-auto py-[120px] md:min-h-[calc(100vh-86px)] px-3 sm:px-5">

        <!-- Left Content -->
        <div class="mb-7 xl:w-[60%] max-w-[680px] flex flex-col gap-5" data-aos="fade-right" data-aos-delay="100">
            <h1 class="text-white text-[30px] sm:text-[40px] leading-[33px] sm:leading-[45px] mb-1.5 font-bold">
                <?php _e('One Stop Shop For All Your', 'wb'); ?>
                <span class="text-[#FFCC00]"><?php _e('Digital Marketing', 'wb'); ?></span>
                <?php _e('Needs', 'wb'); ?>
            </h1>

            <h2 class="text-[18px] sm:text-[22px] font-medium mb-4.75 text-white">
                <?php _e('Search for Digital Marketing', 'wb'); ?>
                <span class="element text-white"
                      data-text1="Tools"
                      data-text2="Courses"
                      data-text3="Services"
                      data-loop="true"
                      data-backdelay="3000">
                    <?php _e('Tools', 'wb'); ?>
                </span>
                <span class="typed-cursor">|</span>
            </h2>

            <!-- Search Form -->
            <?php if ($search_page = wb_get_page_by_template('search')) : ?>
                <form action="<?php echo get_permalink($search_page); ?>" method="get">
                    <div class="mb-4 w-full bg-[#FFFFFF1A] rounded-[8px] p-3 flex gap-2 items-center">
                        <input class="bg-white text-[#797979] px-3 py-2 rounded-sm w-full"
                               name="query"
                               type="text"
                               placeholder="<?php _e('e.g. SEO or Email Marketing', 'wb'); ?>" />
                        <button type="submit"
                                class="bg-[#FFCC00] px-4 py-2 rounded-sm text-[var(--primary)] flex items-center gap-2">
                            <?php _e('Search', 'wb'); ?> <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>

                    <!-- Radio Filter Options -->
                    <div class="flex gap-6 items-center text-white">
                        <label class="flex items-center gap-2 cursor-pointer" for="tools">
                            <input type="radio" name="type" id="tools" value="tool" class="accent-[#FFCC00]" checked>
                            <span>Tools</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer" for="courses">
                            <input type="radio" name="type" id="courses" value="course" class="accent-[#FFCC00]">
                            <span>Courses</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer" for="services">
                            <input type="radio" name="type" id="services" value="service" class="accent-[#FFCC00]">
                            <span>Services</span>
                        </label>
                    </div>
                </form>
            <?php endif; ?>

            <!-- Popular Terms -->
            <?php if ($popular_terms) : ?>
                <div class="flex flex-wrap gap-3 mt-2 pp-terms">
                    <?php foreach ($popular_terms as $popular_term) : ?>
                        <a href="<?php echo get_term_link($popular_term); ?>"
                           class="bg-white hover:bg-[#FFCC00] transition text-[var(--primary)] border border-gray-300 py-2 px-4 rounded-full text-sm font-medium">
                            <?php echo $popular_term->name; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Right Hero Image -->
        <div class="hidden xl:block" data-aos="fade-left" data-aos-delay="200">
            <img class="w-full max-w-[400px]"
                 src="https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/740Vector_Flat-01-1-1.png"
                 alt="<?php _e('Hero Image', 'wb'); ?>" />
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="px-3 sm:px-5 py-[80px] flex flex-col gap-5 max-w-[1440px] mx-auto" data-aos="fade-up" data-aos-delay="100">
    <h4 class="text-center text-[40px]">
      Our <span class="text-[var(--primary)]">Services</span>
    </h1>
    <div class="services-boxes grid sm:grid-cols-2 xl:grid-cols-4 justify-between gap-5">
      <div class="bg-[#EAEFFF70]   basis-[25%] text-white h-[300px] flex flex-col justify-between rounded-sm p-4" data-aos="zoom-in" data-aos-delay="100">
        <div>
          <img class="mb-3" src="https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/Frame-40.png"
            alt="Digital Marketing" />
          <h2 class="text-[#1B2134] mb-1 text-[19px] font-semibold">Digital Marketing Tools</h2>
          <p class="text-[#737373] mb-1">
            Discover Essential Digital Marketing Tools to Help You Achieve Your Goals
          </p>
        </div>

        <a href="#" class="py-3 px-3 rounded-sm flex items-center gap-2 w-fit bg-[#0F44F31A] text-[var(--primary)]">
          Explore
          <i class="fa-solid fa-chevron-right"></i>
        </a>
      </div>
      <div
        class="bg-[#EAEFFF70]   basis-[25%] text-white h-[300px] flex flex-col justify-between rounded-sm p-4" data-aos="zoom-in" data-aos-delay="200">
        <div>
          <img class="mb-3" src="https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/Group.png"
            alt="Digital Marketing" />
          <h2 class="text-[#1B2134] mb-1 text-[20px] font-semibold">Digital Marketing Courses</h2>
          <p class="text-[#737373] mb-1">
            Explore a Wide Range of Digital Marketing Courses and Learn From The Experts
          </p>
        </div>

        <a href="#" class="py-3 px-3 rounded-sm flex items-center gap-2 w-fit bg-[#0F44F31A] text-[var(--primary)]">
          Explore
          <i class="fa-solid fa-chevron-right"></i>
        </a>
      </div>
      <div
        class="bg-[#EAEFFF70]   basis-[25%]  text-white h-[300px] flex flex-col justify-between rounded-sm p-4" data-aos="zoom-in" data-aos-delay="300">
        <div>
          <img class="mb-3" src="https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/Layer_1-1.png"
            alt="Digital Marketing" />
          <h2 class="text-[#1B2134] mb-1 text-[20px] font-semibold">
            Digital Marketing Services
          </h2>
          <p class="text-[#737373] mb-1">
            Find and Compare The Best Digital Marketing Service Providers to Help Your Business
            Grow
          </p>
        </div>

        <a href="#" class="py-3 px-3 rounded-sm flex items-center gap-2 w-fit bg-[#0F44F31A] text-[var(--primary)]">
          Explore
          <i class="fa-solid fa-chevron-right"></i>
        </a>
      </div>
      <div
        class="basis-[25%] bg-[#EAEFFF70]    text-white h-[300px] flex flex-col justify-between rounded-sm p-4" data-aos="zoom-in" data-aos-delay="400">
        <div>
          <img class="mb-3" src="https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/layer1.png"
            alt="Digital Marketing" />
          <h2 class="text-[#1B2134] mb-1 text-[22px] font-semibold">Content</h2>
          <p class="text-[#737373] mb-1">
            Find and Compare The Best Digital Marketing Service Providers to help Your Business
            Grow
          </p>
        </div>

        <a href="#" class="py-3 px-3 rounded-sm flex items-center gap-2 w-fit bg-[#0F44F31A] text-[var(--primary)]">
          Explore
          <i class="fa-solid fa-chevron-right"></i>
        </a>
      </div>
    </div>
  </section>

<!-- Digital Marketing Tools Section -->
<section class="bg-[#FF92001A] px-3 sm:px-5 py-[80px] relative" data-aos="fade-up" data-aos-delay="100">
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
            <?php foreach ($tool_categories as $category) : ?>
                <button class="bg-white py-2.5 px-4 rounded-sm text-[14px] text-[#5A6478] cursor-pointer" data-category="<?php echo (string)$category->term_id; ?>">
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
                        if ($all_tools->have_posts()) :
                            while ($all_tools->have_posts()) : $all_tools->the_post(); 
                                $price = get_post_meta(get_the_ID(), '_price', true);
                                $price_from = get_post_meta(get_the_ID(), '_price_from', true);
                                $categories = wp_get_post_terms(get_the_ID(), 'tool-category', array('fields' => 'ids'));
                                $category_classes = implode(' ', array_map(function($cat) { return 'category-' . $cat; }, $categories));
                                $data_categories = implode(',', array_map('strval', $categories));
                        ?>
                            <div class="swiper-slide tool-slide <?php echo $category_classes; ?>" data-categories="<?php echo esc_attr($data_categories); ?>">
                                <div class="bg-white rounded-sm h-full flex flex-col">
                                    <div class="p-4 flex flex-col items-center flex-1 w-full gap-3">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <?php the_post_thumbnail('medium', array('class' => 'w-full h-[210px] object-cover')); ?>
                                        <?php else : ?>
                                            <img src="https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/Saly-1.png" alt="<?php the_title(); ?>" class="w-full h-[210px] object-cover" />
                                        <?php endif; ?>
                                        <h1 class="text-[#1B1D1F] text-center text-[20px] font-semibold"><?php the_title(); ?></h1>
                                        <p class="text-[#5A6478] text-center text-[14px] font-normal">
                                            <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                                        </p>
                                        <?php if ($price || $price_from) : ?>
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

<!-- AI Agents Section (white) -->
<section class="bg-white px-3 sm:px-5 py-[80px] relative" data-aos="fade-up" data-aos-delay="100">
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
    <?php $ai_agent_categories = get_terms(['taxonomy'=>'ai-agent-category','hide_empty'=>true,'number'=>6]); ?>
    <div class="mt-5 lg:flex grid grid-cols-2 items-center gap-5" id="ai-agent-categories">
      <button class="bg-white py-2.5 px-4 rounded-sm text-[14px] text-[#5A6478] cursor-pointer active" data-category="all">All</button>
      <?php foreach ($ai_agent_categories as $category): ?>
        <button class="bg-white py-2.5 px-4 rounded-sm text-[14px] text-[#5A6478] cursor-pointer" data-category="<?php echo (string)$category->term_id; ?>"><?php echo $category->name; ?></button>
      <?php endforeach; ?>
    </div>
    <div class="mt-5 swiper-flex-wrap relative" style="display:flex;align-items:center;position:relative;">
      <div class="swiper-button-prev ai-agents-prev text-base"></div>
      <div class="swiper-container-wrap" style="flex:1;overflow:hidden;">
        <div class="swiper ai-agents-swiper" style="overflow:visible;">
          <div class="swiper-wrapper">
            <?php
            $ai_agents = new WP_Query([
              'post_type'=>'ai-agent',
              'posts_per_page'=>12,
              'orderby'=>'date',
              'order'=>'DESC',
            ]);
            if ($ai_agents->have_posts()):
              while ($ai_agents->have_posts()): $ai_agents->the_post();
            ?>
            <div class="swiper-slide tool-slide">
              <div class="bg-white rounded-sm h-full flex flex-col">
                <div class="p-4 flex flex-col items-center flex-1 w-full gap-3">
                  <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('medium', ['class'=>'w-full h-[210px] object-cover']); ?>
                  <?php else: ?>
                    <img src="https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/Saly-1.png" alt="<?php the_title(); ?>" class="w-full h-[210px] object-cover" />
                  <?php endif; ?>
                  <h1 class="text-[#1B1D1F] text-center text-[20px] font-semibold"><?php the_title(); ?></h1>
                  <p class="text-[#5A6478] text-center text-[14px] font-normal"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                </div>
                <a href="<?php the_permalink(); ?>" class="block text-center py-3.5 bg-[var(--primary)] text-white w-full">View Details</a>
              </div>
            </div>
            <?php endwhile; wp_reset_postdata(); else: ?>
            <div class="swiper-slide col-span-4 text-center text-red-500 font-bold">No items found.</div>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="swiper-button-next ai-agents-next text-base"></div>
    </div>
  </section>
</section>

<!-- AI Tools Section (yellow)  -->
<section class="bg-[#FF92001A] px-3 sm:px-5 py-[80px] relative" data-aos="fade-up" data-aos-delay="100">
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
    <?php $ai_tool_categories = get_terms(['taxonomy'=>'ai-tool-category','hide_empty'=>true,'number'=>6]); ?>
    <div class="mt-5 lg:flex grid grid-cols-2 items-center gap-5" id="ai-tool-categories">
      <button class="bg-white py-2.5 px-4 rounded-sm text-[14px] text-[#5A6478] cursor-pointer active" data-category="all">All</button>
      <?php foreach ($ai_tool_categories as $category): ?>
        <button class="bg-white py-2.5 px-4 rounded-sm text-[14px] text-[#5A6478] cursor-pointer" data-category="<?php echo (string)$category->term_id; ?>"><?php echo $category->name; ?></button>
      <?php endforeach; ?>
    </div>
    <div class="mt-5 swiper-flex-wrap relative" style="display:flex;align-items:center;position:relative;">
      <div class="swiper-button-prev ai-tools-prev text-base"></div>
      <div class="swiper-container-wrap" style="flex:1;overflow:hidden;">
        <div class="swiper ai-tools-swiper" style="overflow:visible;">
          <div class="swiper-wrapper">
            <?php
            $ai_tools = new WP_Query([
              'post_type'=>'ai-tool',
              'posts_per_page'=>12,
              'orderby'=>'date',
              'order'=>'DESC',
            ]);
            if ($ai_tools->have_posts()):
              while ($ai_tools->have_posts()): $ai_tools->the_post();
            ?>
            <div class="swiper-slide tool-slide">
              <div class="bg-white rounded-sm h-full flex flex-col">
                <div class="p-4 flex flex-col items-center flex-1 w-full gap-3">
                  <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('medium', ['class'=>'w-full h-[210px] object-cover']); ?>
                  <?php else: ?>
                    <img src="https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/Saly-1.png" alt="<?php the_title(); ?>" class="w-full h-[210px] object-cover" />
                  <?php endif; ?>
                  <h1 class="text-[#1B1D1F] text-center text-[20px] font-semibold"><?php the_title(); ?></h1>
                  <p class="text-[#5A6478] text-center text-[14px] font-normal"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                </div>
                <a href="<?php the_permalink(); ?>" class="block text-center py-3.5 bg-[var(--primary)] text-white w-full">View Details</a>
              </div>
            </div>
            <?php endwhile; wp_reset_postdata(); else: ?>
            <div class="swiper-slide col-span-4 text-center text-red-500 font-bold">No items found.</div>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="swiper-button-next ai-tools-next text-base"></div>
    </div>
  </section>
</section>

<!-- Courses Section (white) -->
<section class="bg-white px-3 sm:px-5 py-[80px] relative" data-aos="fade-up" data-aos-delay="100">
  <div class="courses-loading-overlay fixed inset-0 flex items-center justify-center bg-white/70 z-50 hidden">
    <div class="banter-loader"><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div></div>
  </div>
  <section class="max-w-[1440px] mx-auto">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
      <div class="flex items-center gap-2">
        <?php $courses_count = wp_count_posts('course')->publish; ?>
        <span class="bg-[#FFCC00] text-[var(--primary)] py-1 px-2 rounded-sm text-[20px]"> <?php echo $courses_count; ?> </span>
        <h1 class="text-[22px] sm:text-[40px]">Digital Marketing <span class="text-[var(--primary)]">Courses</span></h1>
      </div>
      <div class="flex justify-end">
        <a href="/courses" class="bg-[var(--primary)] w-fit h-fit text-white py-2 px-3 sm:px-5 rounded-sm">View All</a>
      </div>
    </div>
    <?php $course_categories = get_terms(['taxonomy'=>'course-category','hide_empty'=>true,'number'=>6]); ?>
    <div class="mt-5 lg:flex grid grid-cols-2 items-center gap-5" id="course-categories">
      <button class="bg-white py-2.5 px-4 rounded-sm text-[14px] text-[#5A6478] cursor-pointer active" data-category="all">All</button>
      <?php foreach ($course_categories as $category): ?>
        <button class="bg-white py-2.5 px-4 rounded-sm text-[14px] text-[#5A6478] cursor-pointer" data-category="<?php echo (string)$category->term_id; ?>"><?php echo $category->name; ?></button>
      <?php endforeach; ?>
    </div>
    <div class="mt-5 swiper-flex-wrap relative" style="display:flex;align-items:center;position:relative;">
      <div class="swiper-button-prev courses-prev text-base"></div>
      <div class="swiper-container-wrap" style="flex:1;overflow:hidden;">
        <div class="swiper courses-swiper" style="overflow:visible;">
          <div class="swiper-wrapper">
            <?php
            $courses = new WP_Query([
              'post_type'=>'course',
              'posts_per_page'=>12,
              'orderby'=>'date',
              'order'=>'DESC',
            ]);
            if ($courses->have_posts()):
              while ($courses->have_posts()): $courses->the_post();
            ?>
            <div class="swiper-slide tool-slide">
              <div class="bg-white rounded-sm h-full flex flex-col">
                <div class="p-4 flex flex-col items-center flex-1 w-full gap-3">
                  <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('medium', ['class'=>'w-full h-[210px] object-cover']); ?>
                  <?php else: ?>
                    <img src="https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/Saly-1.png" alt="<?php the_title(); ?>" class="w-full h-[210px] object-cover" />
                  <?php endif; ?>
                  <h1 class="text-[#1B1D1F] text-center text-[20px] font-semibold"><?php the_title(); ?></h1>
                  <p class="text-[#5A6478] text-center text-[14px] font-normal"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                </div>
                <a href="<?php the_permalink(); ?>" class="block text-center py-3.5 bg-[var(--primary)] text-white w-full">View Details</a>
              </div>
            </div>
            <?php endwhile; wp_reset_postdata(); else: ?>
            <div class="swiper-slide col-span-4 text-center text-red-500 font-bold">No items found.</div>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="swiper-button-next courses-next text-base"></div>
    </div>
  </section>
</section>

<!-- Services Section (yellow) -->
<section class="bg-[#FF92001A] px-3 sm:px-5 py-[80px] relative" data-aos="fade-up" data-aos-delay="100">
  <div class="services-loading-overlay fixed inset-0 flex items-center justify-center bg-white/70 z-50 hidden">
    <div class="banter-loader"><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div></div>
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
    <?php $service_categories = get_terms(['taxonomy'=>'service-category','hide_empty'=>true,'number'=>6]); ?>
    <div class="mt-5 lg:flex grid grid-cols-2 items-center gap-5" id="service-categories">
      <button class="bg-white py-2.5 px-4 rounded-sm text-[14px] text-[#5A6478] cursor-pointer active" data-category="all">All</button>
      <?php foreach ($service_categories as $category): ?>
        <button class="bg-white py-2.5 px-4 rounded-sm text-[14px] text-[#5A6478] cursor-pointer" data-category="<?php echo (string)$category->term_id; ?>"><?php echo $category->name; ?></button>
      <?php endforeach; ?>
    </div>
    <div class="mt-5 swiper-flex-wrap relative" style="display:flex;align-items:center;position:relative;">
      <div class="swiper-button-prev services-prev text-base"></div>
      <div class="swiper-container-wrap" style="flex:1;overflow:hidden;">
        <div class="swiper services-swiper" style="overflow:visible;">
          <div class="swiper-wrapper">
            <?php
            $services = new WP_Query([
              'post_type'=>'service',
              'posts_per_page'=>12,
              'orderby'=>'date',
              'order'=>'DESC',
            ]);
            if ($services->have_posts()):
              while ($services->have_posts()): $services->the_post();
            ?>
            <div class="swiper-slide tool-slide">
              <div class="bg-white rounded-sm h-full flex flex-col">
                <div class="p-4 flex flex-col items-center flex-1 w-full gap-3">
                  <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('medium', ['class'=>'w-full h-[210px] object-cover']); ?>
                  <?php else: ?>
                    <img src="https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/Saly-1.png" alt="<?php the_title(); ?>" class="w-full h-[210px] object-cover" />
                  <?php endif; ?>
                  <h1 class="text-[#1B1D1F] text-center text-[20px] font-semibold"><?php the_title(); ?></h1>
                  <p class="text-[#5A6478] text-center text-[14px] font-normal"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                </div>
                <a href="<?php the_permalink(); ?>" class="block text-center py-3.5 bg-[var(--primary)] text-white w-full">View Details</a>
              </div>
            </div>
            <?php endwhile; wp_reset_postdata(); else: ?>
            <div class="swiper-slide col-span-4 text-center text-red-500 font-bold">No items found.</div>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="swiper-button-next services-next text-base"></div>
    </div>
  </section>
</section>

<!-- Content Section (white) -->
<section class="bg-white px-3 sm:px-5 py-[80px] relative" data-aos="fade-up" data-aos-delay="100">
  <div class="content-loading-overlay fixed inset-0 flex items-center justify-center bg-white/70 z-50 hidden">
    <div class="banter-loader"><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div><div class="banter-loader__box"></div></div>
  </div>
  <section class="max-w-[1440px] mx-auto">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
      <div class="flex items-center gap-2">
        <?php $content_count = wp_count_posts()->publish; ?>
        <span class="bg-[#FFCC00] text-[var(--primary)] py-1 px-2 rounded-sm text-[20px]"> <?php echo $content_count; ?> </span>
        <h1 class="text-[22px] sm:text-[40px]">Content</h1>
      </div>
      <div class="flex justify-end">
        <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="bg-[var(--primary)] w-fit h-fit text-white py-2 px-3 sm:px-5 rounded-sm">View All</a>
      </div>
    </div>
    <?php $content_categories = get_categories(['hide_empty'=>true,'number'=>6]); ?>
    <div class="mt-5 lg:flex grid grid-cols-2 items-center gap-5" id="content-categories">
      <button class="bg-white py-2.5 px-4 rounded-sm text-[14px] text-[#5A6478] cursor-pointer active" data-category="all">All</button>
      <?php foreach ($content_categories as $category): ?>
        <button class="bg-white py-2.5 px-4 rounded-sm text-[14px] text-[#5A6478] cursor-pointer" data-category="<?php echo (string)$category->term_id; ?>"><?php echo $category->name; ?></button>
      <?php endforeach; ?>
    </div>
    <div class="mt-5 swiper-flex-wrap relative" style="display:flex;align-items:center;position:relative;">
      <div class="swiper-button-prev content-prev text-base"></div>
      <div class="swiper-container-wrap" style="flex:1;overflow:hidden;">
        <div class="swiper content-swiper" style="overflow:visible;">
          <div class="swiper-wrapper">
            <?php
            $contents = new WP_Query([
              'post_type'=>'post',
              'posts_per_page'=>12,
              'orderby'=>'date',
              'order'=>'DESC',
            ]);
            if ($contents->have_posts()):
              while ($contents->have_posts()): $contents->the_post();
            ?>
            <div class="swiper-slide tool-slide">
              <div class="bg-white rounded-sm h-full flex flex-col">
                <div class="p-4 flex flex-col items-center flex-1 w-full gap-3">
                  <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('medium', ['class'=>'w-full h-[210px] object-cover']); ?>
                  <?php else: ?>
                    <img src="https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/Saly-1.png" alt="<?php the_title(); ?>" class="w-full h-[210px] object-cover" />
                  <?php endif; ?>
                  <h1 class="text-[#1B1D1F] text-center text-[20px] font-semibold"><?php the_title(); ?></h1>
                  <p class="text-[#5A6478] text-center text-[14px] font-normal"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                </div>
                <a href="<?php the_permalink(); ?>" class="block text-center py-3.5 bg-[var(--primary)] text-white w-full">View Details</a>
              </div>
            </div>
            <?php endwhile; wp_reset_postdata(); else: ?>
            <div class="swiper-slide col-span-4 text-center text-red-500 font-bold">No items found.</div>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="swiper-button-next content-next text-base"></div>
    </div>
  </section>
</section>

<!-- How it Work Section -->
<section class="px-3 sm:px-5 py-[80px] bg-white" data-aos="fade-up" data-aos-delay="100">
  <div class="max-w-[1440px] mx-auto">
    <h1 class="text-center mb-6 text-[40px]">
      How it <span class="text-[var(--primary)]">Works</span>
    </h1>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 justify-between gap-5">
      <div class="border border-[#0000000F] flex flex-col justify-between rounded-sm p-4 bg-white" data-aos="zoom-in" data-aos-delay="100">
        <div>
          <img class="mb-4 p-2.5 rounded-sm bg-[#0F44F333]" src="https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/Layer_1.png" alt="Digital Marketing" />
          <h1 class="text-[var(--primary)] mb-4 text-[18px] font-bold">
            Discover The Best Tools and Courses
          </h1>
          <p class="text-[#6D6D6D] text-[14px] mb-1">
            Browse through our growing database of 7000+ Digital Marketing Tools, 4000+ Digital Marketing Service providers and over 950 Digital Marketing Courses collected in a wide range of categories.
          </p>
        </div>
      </div>
      <div class="border border-[#0000000F] flex flex-col justify-between rounded-sm p-4 bg-white" data-aos="zoom-in" data-aos-delay="200">
        <div>
          <img class="mb-4 p-2.5 rounded-sm bg-[#0F44F333]" src="https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/Layer_1.png" alt="Digital Marketing" />
          <h1 class="text-[var(--primary)] mb-4 text-[20px] font-bold">Compare Your Options</h1>
          <p class="text-[#6D6D6D] text-[14px] mb-1">
            Browse through our growing database of 7000+ Digital Marketing Tools, 4000+ Digital Marketing Service providers and over 950 Digital Marketing Courses collected in a wide range of categories.
          </p>
        </div>
      </div>
      <div class="border border-[#0000000F] flex flex-col justify-between rounded-sm p-4 bg-white" data-aos="zoom-in" data-aos-delay="300">
        <div>
          <img class="mb-4 p-2.5 rounded-sm bg-[#0F44F333]" src="https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/Layer_1.png" alt="Digital Marketing" />
          <h1 class="text-[var(--primary)] mb-4 text-[20px] font-bold">Grow Your Business</h1>
          <p class="text-[#6D6D6D] text-[14px] mb-1">
            Browse through our growing database of 7000+ Digital Marketing Tools, 4000+ Digital Marketing Service providers and over 950 Digital Marketing Courses collected in a wide range of categories.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Newsletter -->
<section class="px-3 sm:px-5 py-[80px]" data-aos="fade-up" data-aos-delay="100">
  <div class="max-w-[1440px] mx-auto my-gradient-background text-white rounded-sm">
    <div class="p-4 sm:p-6 flex flex-col items-center">
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
            placeholder="e.g. SEO or Email Marketing" 
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


<!-- Add Swiper CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
<script>var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';</script>
<script>
let toolsSwiper, aiAgentsSwiper, aiToolsSwiper, coursesSwiper, servicesSwiper, contentSwiper;
jQuery(document).ready(function($) {
    // --- TOOLS ---
    function initToolsSwiper() {
        if (toolsSwiper) toolsSwiper.destroy(true, true);
        toolsSwiper = new Swiper('.tools-swiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                640: { slidesPerView: 2 },
                1024: { slidesPerView: 3 },
                1200: { slidesPerView: 4 }
            }
        });
    }
    initToolsSwiper();
    $('#tool-categories button').removeClass('active bg-[#FFCC00] text-[#0C2452]');
    $('#tool-categories button[data-category="all"]').addClass('active bg-[#FFCC00] text-[#0C2452]');
    document.querySelectorAll('#tool-categories button').forEach(btn => {
        btn.addEventListener('click', function () {
            showToolsLoading();
            const categoryId = this.getAttribute('data-category');
            document.querySelectorAll('#tool-categories button').forEach(b => b.classList.remove('active', 'bg-[#FFCC00]', 'text-[#0C2452]'));
            this.classList.add('active', 'bg-[#FFCC00]', 'text-[#0C2452]');
            fetch(`${ajaxurl}?action=filter_tools_by_category&category_id=${categoryId}`)
                .then(res => res.text())
                .then(html => {
                    document.querySelector('.tools-swiper .swiper-wrapper').innerHTML = html;
                    initToolsSwiper();
                    hideToolsLoading();
                });
        });
    });

    // --- AI AGENTS ---
    function initAiAgentsSwiper() {
        if (aiAgentsSwiper) aiAgentsSwiper.destroy(true, true);
        aiAgentsSwiper = new Swiper('.ai-agents-swiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            navigation: {
                nextEl: '.ai-agents-next',
                prevEl: '.ai-agents-prev',
            },
            breakpoints: {
                640: { slidesPerView: 2 },
                1024: { slidesPerView: 3 },
                1200: { slidesPerView: 4 }
            }
        });
    }
    initAiAgentsSwiper();
    $('#ai-agent-categories button').removeClass('active bg-[#FFCC00] text-[#0C2452]');
    $('#ai-agent-categories button[data-category="all"]').addClass('active bg-[#FFCC00] text-[#0C2452]');
    document.querySelectorAll('#ai-agent-categories button').forEach(btn => {
        btn.addEventListener('click', function () {
            showAiAgentsLoading();
            const categoryId = this.getAttribute('data-category');
            document.querySelectorAll('#ai-agent-categories button').forEach(b => b.classList.remove('active', 'bg-[#FFCC00]', 'text-[#0C2452]'));
            this.classList.add('active', 'bg-[#FFCC00]', 'text-[#0C2452]');
            fetch(`${ajaxurl}?action=filter_ai_agents_by_category&category_id=${categoryId}`)
                .then(res => res.text())
                .then(html => {
                    document.querySelector('.ai-agents-swiper .swiper-wrapper').innerHTML = html;
                    initAiAgentsSwiper();
                    hideAiAgentsLoading();
                });
        });
    });

    // --- AI TOOLS ---
    function initAiToolsSwiper() {
        if (aiToolsSwiper) aiToolsSwiper.destroy(true, true);
        aiToolsSwiper = new Swiper('.ai-tools-swiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            navigation: {
                nextEl: '.ai-tools-next',
                prevEl: '.ai-tools-prev',
            },
            breakpoints: {
                640: { slidesPerView: 2 },
                1024: { slidesPerView: 3 },
                1200: { slidesPerView: 4 }
            }
        });
    }
    initAiToolsSwiper();
    $('#ai-tool-categories button').removeClass('active bg-[#FFCC00] text-[#0C2452]');
    $('#ai-tool-categories button[data-category="all"]').addClass('active bg-[#FFCC00] text-[#0C2452]');
    document.querySelectorAll('#ai-tool-categories button').forEach(btn => {
        btn.addEventListener('click', function () {
            showAiToolsLoading();
            const categoryId = this.getAttribute('data-category');
            document.querySelectorAll('#ai-tool-categories button').forEach(b => b.classList.remove('active', 'bg-[#FFCC00]', 'text-[#0C2452]'));
            this.classList.add('active', 'bg-[#FFCC00]', 'text-[#0C2452]');
            fetch(`${ajaxurl}?action=filter_ai_tools_by_category&category_id=${categoryId}`)
                .then(res => res.text())
                .then(html => {
                    document.querySelector('.ai-tools-swiper .swiper-wrapper').innerHTML = html;
                    initAiToolsSwiper();
                    hideAiToolsLoading();
                });
        });
    });

    // --- COURSES ---
    function initCoursesSwiper() {
        if (coursesSwiper) coursesSwiper.destroy(true, true);
        coursesSwiper = new Swiper('.courses-swiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            navigation: {
                nextEl: '.courses-next',
                prevEl: '.courses-prev',
            },
            breakpoints: {
                640: { slidesPerView: 2 },
                1024: { slidesPerView: 3 },
                1200: { slidesPerView: 4 }
            }
        });
    }
    initCoursesSwiper();
    $('#course-categories button').removeClass('active bg-[#FFCC00] text-[#0C2452]');
    $('#course-categories button[data-category="all"]').addClass('active bg-[#FFCC00] text-[#0C2452]');
    document.querySelectorAll('#course-categories button').forEach(btn => {
        btn.addEventListener('click', function () {
            showCoursesLoading();
            const categoryId = this.getAttribute('data-category');
            document.querySelectorAll('#course-categories button').forEach(b => b.classList.remove('active', 'bg-[#FFCC00]', 'text-[#0C2452]'));
            this.classList.add('active', 'bg-[#FFCC00]', 'text-[#0C2452]');
            fetch(`${ajaxurl}?action=filter_courses_by_category&category_id=${categoryId}`)
                .then(res => res.text())
                .then(html => {
                    document.querySelector('.courses-swiper .swiper-wrapper').innerHTML = html;
                    initCoursesSwiper();
                    hideCoursesLoading();
                });
        });
    });

    // --- SERVICES ---
    function initServicesSwiper() {
        if (servicesSwiper) servicesSwiper.destroy(true, true);
        servicesSwiper = new Swiper('.services-swiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            navigation: {
                nextEl: '.services-next',
                prevEl: '.services-prev',
            },
            breakpoints: {
                640: { slidesPerView: 2 },
                1024: { slidesPerView: 3 },
                1200: { slidesPerView: 4 }
            }
        });
    }
    initServicesSwiper();
    $('#service-categories button').removeClass('active bg-[#FFCC00] text-[#0C2452]');
    $('#service-categories button[data-category="all"]').addClass('active bg-[#FFCC00] text-[#0C2452]');
    document.querySelectorAll('#service-categories button').forEach(btn => {
        btn.addEventListener('click', function () {
            showServicesLoading();
            const categoryId = this.getAttribute('data-category');
            document.querySelectorAll('#service-categories button').forEach(b => b.classList.remove('active', 'bg-[#FFCC00]', 'text-[#0C2452]'));
            this.classList.add('active', 'bg-[#FFCC00]', 'text-[#0C2452]');
            fetch(`${ajaxurl}?action=filter_services_by_category&category_id=${categoryId}`)
                .then(res => res.text())
                .then(html => {
                    document.querySelector('.services-swiper .swiper-wrapper').innerHTML = html;
                    initServicesSwiper();
                    hideServicesLoading();
                });
        });
    });

    // --- CONTENT ---
    function initContentSwiper() {
        if (contentSwiper) contentSwiper.destroy(true, true);
        contentSwiper = new Swiper('.content-swiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            navigation: {
                nextEl: '.content-next',
                prevEl: '.content-prev',
            },
            breakpoints: {
                640: { slidesPerView: 2 },
                1024: { slidesPerView: 3 },
                1200: { slidesPerView: 4 }
            }
        });
    }
    initContentSwiper();
    $('#content-categories button').removeClass('active bg-[#FFCC00] text-[#0C2452]');
    $('#content-categories button[data-category="all"]').addClass('active bg-[#FFCC00] text-[#0C2452]');
    document.querySelectorAll('#content-categories button').forEach(btn => {
        btn.addEventListener('click', function () {
            showContentLoading();
            const categoryId = this.getAttribute('data-category');
            document.querySelectorAll('#content-categories button').forEach(b => b.classList.remove('active', 'bg-[#FFCC00]', 'text-[#0C2452]'));
            this.classList.add('active', 'bg-[#FFCC00]', 'text-[#0C2452]');
            fetch(`${ajaxurl}?action=filter_content_by_category&category_id=${categoryId}`)
                .then(res => res.json())
                .then(data => {
                    document.querySelector('.content-swiper .swiper-wrapper').innerHTML = data.data;
                    initContentSwiper();
                    hideContentLoading();
                });
        });
    });

    // Typed.js for hero
    $('.element').typed({
        strings: ['Tools', 'Courses', 'Services'],
        typeSpeed: 50,
        backSpeed: 30,
        backDelay: 3000,
        loop: true,
        showCursor: true,
        cursorChar: ''
    });

    // --- TOOLS ---
    function showToolsLoading() {
        document.querySelector('.tools-loading-overlay').classList.remove('hidden');
    }
    function hideToolsLoading() {
        document.querySelector('.tools-loading-overlay').classList.add('hidden');
    }

    // --- AI AGENTS ---
    function showAiAgentsLoading() {
        document.querySelector('.ai-agents-loading-overlay').classList.remove('hidden');
    }
    function hideAiAgentsLoading() {
        document.querySelector('.ai-agents-loading-overlay').classList.add('hidden');
    }

    // --- AI TOOLS ---
    function showAiToolsLoading() {
        document.querySelector('.ai-tools-loading-overlay').classList.remove('hidden');
    }
    function hideAiToolsLoading() {
        document.querySelector('.ai-tools-loading-overlay').classList.add('hidden');
    }

    // --- COURSES ---
    function showCoursesLoading() {
        document.querySelector('.courses-loading-overlay').classList.remove('hidden');
    }
    function hideCoursesLoading() {
        document.querySelector('.courses-loading-overlay').classList.add('hidden');
    }

    // --- SERVICES ---
    function showServicesLoading() {
        document.querySelector('.services-loading-overlay').classList.remove('hidden');
    }
    function hideServicesLoading() {
        document.querySelector('.services-loading-overlay').classList.add('hidden');
    }

    // --- CONTENT ---
    function showContentLoading() {
        document.querySelector('.content-loading-overlay').classList.remove('hidden');
    }
    function hideContentLoading() {
        document.querySelector('.content-loading-overlay').classList.add('hidden');
    }
});
</script>
<style>
.swiper-flex-wrap {
    display: flex;
    align-items: center;
    position: relative;
    width: 100%;
}
.swiper-container-wrap {
    overflow: hidden;
    position: relative;
    flex: 1;
}
.swiper {
    width: 100%;
    padding: 20px 0;
    position: relative;
    overflow: visible;
}
.swiper-slide {
    height: auto;
    transition: opacity 0.2s, visibility 0.2s;
}
.swiper-slide.d-none {
    opacity: 0 !important;
    visibility: hidden !important;
    pointer-events: none !important;
    position: absolute !important;
}
.swiper-button-next,
.swiper-button-prev {
    color: var(--primary);
    background: white;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    z-index: 10;
    position: relative;
    &:after{
        font-size:16px;
    }
}
.swiper-button-next {
    margin-left: 10px;
}
.swiper-button-prev {
    margin-right: 10px;
}
/* Loading spinner styles */
/* From Uiverse.io by mrpumps31232 */ 
.loading-wave {
  width: 300px;
  height: 100px;
  display: flex;
  justify-content: center;
  align-items: flex-end;
}

.loading-bar {
  width: 20px;
  height: 10px;
  margin: 0 5px;
  background-color: var(--primary);
  border-radius: 5px;
  animation: loading-wave-animation 1s ease-in-out infinite;
}

.loading-bar:nth-child(2) {
  animation-delay: 0.1s;
}

.loading-bar:nth-child(3) {
  animation-delay: 0.2s;
}

.loading-bar:nth-child(4) {
  animation-delay: 0.3s;
}

@keyframes loading-wave-animation {
  0% {
    height: 10px;
  }

  50% {
    height: 50px;
  }

  100% {
    height: 10px;
  }
}

/* Tab active state */
#tool-categories button.active {
    background-color: #FFCC00 !important;
    color: #0C2452 !important;
    font-weight: 600;
}
#tool-categories button,
#ai-agent-categories button,
#ai-tool-categories button,
#course-categories button,
#service-categories button,
#content-categories button {
    border: 1px solid #e5e7eb; /* Tailwind border-gray-200 */
    box-shadow: 0 1px 2px rgba(0,0,0,0.03);
}
#tool-categories button.active,
#ai-agent-categories button.active,
#ai-tool-categories button.active,
#course-categories button.active,
#service-categories button.active,
#content-categories button.active {
    background-color: #FFCC00 !important;
    color: #0C2452 !important;
    font-weight: 600;
}



.services-boxes > div {
  position: relative;
  overflow: hidden;
  transition: all 0.5s;
}

.services-boxes > div::before {
  content: '';
  position: absolute;
  inset: 0;
  background: 
    linear-gradient(0deg, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)),
    linear-gradient(239.04deg, #0f4bcd 0%, #000000 100%);
  background-repeat: no-repeat;
  z-index: 0;
  width: 0;
  transition: width 0.5s;
}

.services-boxes > div div,
.services-boxes > div a {
  z-index: 4;
  position: relative;
}

.services-boxes > div img {
  transition: filter 0.5s;
}

.services-boxes > div h2,
.services-boxes > div p,
.services-boxes > div a {
  transition: all 0.5s;
  position: relative;
  z-index: 4;
}

.services-boxes > div:hover::before {
  width: 100%;
}

.services-boxes > div:hover h2,
.services-boxes > div:hover p,
.services-boxes > div:hover a {
  color: white;
}

/* Optional hover effect for image (uncomment if needed) */
/*
.services-boxes > div:hover img {
  filter: brightness(100%);
}
*/


.pp-terms{
    a{ transition: all .3s;
        &:hover{
            background-color:#FFCC00 !important;
            color:black;
            border:#FFCC00;
        }
    }
}
</style>

<!-- Add AOS CSS and JS for entrance animations -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize AOS with proper settings
    if (window.AOS) {
        AOS.init({
            duration: 900,
            once: true,
            startEvent: 'load',
            disable: 'mobile',
            offset: 50,
            delay: 0
        });
    }

    // Handle page loading state
    function handlePageLoad() {
        const pageContent = document.querySelector('.page-content');
        const pageLoading = document.querySelector('.page-loading');
        
        // Mark content as loaded
        pageContent.classList.add('loaded');
        
        // Hide loading state after a small delay
        setTimeout(() => {
            pageLoading.classList.add('hidden');
            // Remove loading element after transition
            setTimeout(() => {
                pageLoading.remove();
            }, 300);
        }, 100);
    }

    // Check if page is already loaded
    if (document.readyState === 'complete') {
        handlePageLoad();
    } else {
        window.addEventListener('load', handlePageLoad);
    }

    // Initialize other animations
    const header = document.querySelector('header, .site-header, #header, .main-header');
    if (header) {
        header.style.opacity = '0';
        header.style.transform = 'translateY(-20px)';
        header.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
        
        // Trigger header animation after a small delay
        setTimeout(() => {
            header.style.opacity = '1';
            header.style.transform = 'translateY(0)';
        }, 100);
    }

    // Initialize typed.js
    if (typeof Typed !== 'undefined') {
        new Typed('.element', {
            strings: ['Tools', 'Courses', 'Services'],
            typeSpeed: 50,
            backSpeed: 30,
            backDelay: 3000,
            loop: true,
            showCursor: true,
            cursorChar: ''
        });
    }
});
</script>

<!-- Remove the old FOUC fix styles and scripts -->

<?php get_footer(); ?>
