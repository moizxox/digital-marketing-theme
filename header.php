<?php if (!defined('ABSPATH')) exit; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('-', true, 'right'); ?></title>
    <?php wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap'); ?>
    <?php wp_enqueue_style('font-awesome', WB_THEME_URL . '/css/font-awesome.css'); ?>
    <?php wp_enqueue_style('style', get_stylesheet_uri()); ?>
    <?php wp_enqueue_style('responsive', WB_THEME_URL . '/css/responsive.css'); ?>
    <?php wp_enqueue_script('cookie', WB_THEME_URL . '/js/cookie.js', array('jquery')); ?>
    <?php wp_enqueue_script('jquery.formstyler', WB_THEME_URL . '/js/jquery.formstyler.js', array('cookie')); ?>
    <?php wp_enqueue_script('main', WB_THEME_URL . '/js/main.js', array('jquery.formstyler')); ?>
    <?php wp_head(); ?>
    <style>
        body a:hover {
            text-decoration: none ;
        }
        #main-menu a {
            transition: all .4s;
            padding: 8px;
            border-radius: 4px;
          &:hover{
                background-color: #FFCC00;
            color:black;
          }
        }
        
        /* Mobile menu styles */
        .mobile-menu-button {
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            width: 2rem;
            height: 2rem;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 0;
            z-index: 60;
        }
        
        .mobile-menu-button:focus {
            outline: none;
        }
        
        .mobile-menu-button__line {
            width: 2rem;
            height: 0.25rem;
            background: white;
            border-radius: 10px;
            transition: all 0.3s linear;
            position: relative;
            transform-origin: 1px;
        }
        
        /* Animated hamburger icon */
        .mobile-menu-button[aria-expanded="true"] .mobile-menu-button__line:first-child {
            transform: rotate(45deg);
        }
        
        .mobile-menu-button[aria-expanded="true"] .mobile-menu-button__line:nth-child(2) {
            opacity: 0;
            transform: translateX(20px);
        }
        
        .mobile-menu-button[aria-expanded="true"] .mobile-menu-button__line:last-child {
            transform: rotate(-45deg);
        }
        
        /* Mobile menu overlay */
        #mobile-menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
        }
        
        #mobile-menu-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        /* Mobile menu panel */
        #mob-nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 80%;
            max-width: 320px;
            height: 100vh;
            background: var(--primary);
            z-index: 44;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            padding-top: 86px;
            overflow-y: auto;
        }
        
        #mob-nav.active {
            transform: translateX(0);
        }
        
        /* Prevent body scroll when menu is open */
        body.menu-open {
            overflow: hidden;
        }
    </style>
    <!-- Google tag (gtag.js) -->
<!--<script async src="https://www.googletagmanager.com/gtag/js?id=G-2XQSGX52CE"></script>-->
<!--<script>-->
<!--  window.dataLayer = window.dataLayer || [];-->
<!--  function gtag(){dataLayer.push(arguments);}-->
<!--  gtag('js', new Date());-->

<!--  gtag('config', 'G-2XQSGX52CE');-->
<!--</script>-->
</head>

<body <?php body_class(); ?>>
    <?php if (function_exists('gtm4wp_the_gtm_tag')) gtm4wp_the_gtm_tag(); ?>
    <div class="main-wrap">
        <header class="flex h-[86px] items-center justify-between px-[10%] bg-[var(--primary)] py-4 relative z-50">
            <a class='no-d-hover' href="<?php echo esc_url(home_url('/')); ?>">
                <img src="https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/logo.png" alt="Logo" class="h-10" />
            </a>
            
            <nav class="hidden lg:block">
                <?php
                wp_nav_menu([
                    'theme_location' => 'main',
                    'container' => false,
                    'menu_class' => 'flex gap-6 text-white',
                    'fallback_cb' => 'wb_nav_main_menu_fallback',
                    'items_wrap' => '<ul id="main-menu" class="%2$s">%3$s</ul>',
                    'walker' => $custom_nav_walker,
                ]);
                ?>
            </nav>

                <a href="<?php echo esc_url(home_url('/submit-ai/')); ?>" class="hidden lg:flex rounded-lg bg-[var(--secondary)] px-4 py-2 font-medium flex gap-3 items-center">
                    <span class="text-[var(--primary)] hidden md:block">Submit Ai Tool</span>
                </a>
           
            
            <!-- Mobile Menu Toggle -->
            <button class="lg:hidden ml-4 mobile-menu-button" id="toggle-btn1" aria-label="Menu" aria-expanded="false">
                <span class="mobile-menu-button__line"></span>
                <span class="mobile-menu-button__line"></span>
                <span class="mobile-menu-button__line"></span>
            </button>
        </header>
        
        <!-- Mobile Menu Overlay -->
        <div id="mobile-menu-overlay"></div>
        
        <!-- Mobile Menu Panel -->
        <div id="mob-nav">
            <div class="h-full overflow-y-auto">
                <nav class="p-6">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'main',
                        'container' => false,
                        'menu_class' => 'flex flex-col gap-6 text-white hover:text-[var(--secondary)]',
                        'fallback_cb' => 'wb_nav_main_menu_fallback',
                        'items_wrap' => '<ul class="%2$s">%3$s</ul>',
                    ]);
                    ?>
                </nav>
                
            
            </div>
        </div>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const toggleBtn = document.getElementById('toggle-btn1');
                const mobNav = document.getElementById('mob-nav');
                const overlay = document.getElementById('mobile-menu-overlay');
                const body = document.body;
                mobNav.classList.remove('hidden');
                
                function toggleMenu() {
                    const isExpanded = toggleBtn.getAttribute('aria-expanded') === 'true';
                    
                    // Toggle menu state
                    toggleBtn.setAttribute('aria-expanded', !isExpanded);
                    mobNav.classList.toggle('active');
                    overlay.classList.toggle('active');
                    body.classList.toggle('menu-open');
                }
                
                // Initialize menu state
                toggleBtn.setAttribute('aria-expanded', 'false');
                mobNav.classList.remove('active');
                overlay.classList.remove('active');
                body.classList.remove('menu-open');
                
                // Toggle menu on button click
                toggleBtn.addEventListener('click', toggleMenu);
                
                // Close menu when clicking on overlay
                overlay.addEventListener('click', toggleMenu);
                
                // Close menu when pressing Escape key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && mobNav.classList.contains('active')) {
                        toggleMenu();
                    }
                });
            });
        </script>
    </div>
</body>

</html>