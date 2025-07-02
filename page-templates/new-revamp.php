<?php

/** Template Name: New Revamp Local */
if (!defined('ABSPATH')) {
    exit;
}

// Add critical CSS inline in head
add_action('wp_head', function () {
    ?>
    <style>
    /* Basic layout styles */
    .page-content {
        opacity: 1;
    }
    </style>
    <?php
}, 1);

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



<!-- Main Content -->
<div class="page-content" style="opacity: 1;">

<!-- New Hero Section -->
<?php
get_template_part('page-templates/templates/home/hero');
?>

<!-- Hero Section -->
<section class="relative overflow-hidden my-gradient-background z-0" >
hello
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
        <div class="mb-7 xl:w-[60%] max-w-[680px] flex flex-col gap-5" >
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
            <?php if ($search_page = wb_get_page_by_template('search')): ?>
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
            <?php if ($popular_terms): ?>
                <div class="flex flex-wrap gap-3 mt-2 pp-terms">
                    <?php foreach ($popular_terms as $popular_term): ?>
                        <a href="<?php echo get_term_link($popular_term); ?>"
                           class="bg-white hover:bg-[#FFCC00] transition text-[var(--primary)] border border-gray-300 py-2 px-4 rounded-full text-sm font-medium">
                            <?php echo $popular_term->name; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Right Hero Image -->
        <div class="hidden xl:block" >
            <img class="w-full max-w-[400px]"
                 src="https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/740Vector_Flat-01-1-1.png"
                 alt="<?php _e('Hero Image', 'wb'); ?>" />
        </div>
    </div>
</section>
<!-- Tools Section -->
<?php get_template_part('page-templates/templates/home/tools-slider'); ?>
<!-- Courses Section -->
<?php get_template_part('page-templates/templates/home/courses-slider'); ?>
<!-- Services Section -->
<?php get_template_part('page-templates/templates/home/services-slider'); ?>
<!-- Content Section -->
<?php get_template_part('page-templates/templates/home/content-slider'); ?>

<!-- How it Work Section -->
<?php get_template_part('page-templates/templates/home/how-it-works'); ?>

<!-- Newsletter -->
<?php get_template_part('page-templates/templates/home/newsletter'); ?>


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
    }

    // --- AI AGENTS ---
    function showAiAgentsLoading() {
    }

    // --- AI TOOLS ---
    function showAiToolsLoading() {
    }

    // --- COURSES ---
    function showCoursesLoading() {
    }

    // --- SERVICES ---
    function showServicesLoading() {
    }

    // --- CONTENT ---
    function showContentLoading() {
    }

    // --- LOADING ---
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
        header.style.opacity = '1';
        header.style.transform = 'translateY(0)';
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

<style>
    a{
        transition: all 0.3s ease;
        &:hover{
            transform: scale(1.05);
            
        }
    }
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
<script>
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
