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
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-2XQSGX52CE"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-2XQSGX52CE');
</script>
		
    <?php wp_head(); ?>
    <style>
        body a:hover {
            text-decoration: none;
        }

        #main-menu li.menu-item-has-children > a::after {
            content: " ▼";
            font-size: 0.7rem;
        }

        #main-menu ul.submenu {
            display: none;
            position: absolute;
            background: #fff;
            padding: 10px;
            border-radius: 6px;
            z-index: 9999;
        }

        #main-menu li:hover > ul.submenu {
            display: block;
        }

        #main-menu ul.submenu li {
            position: relative;
            a{
                color:var(--primary);
                font-weight: 600;
                font-size: 16px;
                white-space: nowrap;
            }
        }

        #main-menu a {
            transition: all .4s;
            padding: 8px;
            border-radius: 4px;
            display: inline-block;
        }

        #main-menu a:hover {
            background-color: #FFCC00;
            color: black;
        }

        /* Mobile styles */
        #mob-nav ul.submenu {
            display: none;
        }

        #mob-nav li.menu-item-has-children > a::after {
            content: " ▼";
            float: right;
        }

        #mob-nav li.menu-item-has-children.open > ul.submenu {
            display: block;
        }

        .mobile-menu-button {
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            width: 2rem;
            height: 2rem;
            background: transparent;
            border: none;
            cursor: pointer;
            z-index: 60;
        }

        .mobile-menu-button__line {
            width: 2rem;
            height: 0.25rem;
            background: white;
            border-radius: 10px;
        }

        .mobile-menu-button[aria-expanded="true"] .mobile-menu-button__line:first-child {
            transform: rotate(45deg);
        }

        .mobile-menu-button[aria-expanded="true"] .mobile-menu-button__line:nth-child(2) {
            opacity: 0;
        }

        .mobile-menu-button[aria-expanded="true"] .mobile-menu-button__line:last-child {
            transform: rotate(-45deg);
        }

        #mobile-menu-overlay {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        #mobile-menu-overlay.active {
            opacity: 1;
            visibility: visible;
        }

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

        body.menu-open {
            overflow: hidden;
        }
    </style>
</head>

<body <?php body_class(); ?>>
    <?php if (function_exists('gtm4wp_the_gtm_tag')) gtm4wp_the_gtm_tag(); ?>
    <div class="main-wrap">
        <header class="flex h-[86px] items-center justify-between px-[10%] bg-[var(--primary)] py-4 relative z-50">
            <a class="no-d-hover" href="<?php echo esc_url(home_url('/')); ?>">
                <img src="https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/logo.png" alt="Logo" class="h-10" />
            </a>

            <nav class="hidden lg:block z-50">
                <?php
                wp_nav_menu([
                    'theme_location' => 'main',
                    'container' => false,
                    'menu_class' => 'flex gap-6 text-white',
                    'items_wrap' => '<ul id="main-menu" class="%2$s">%3$s</ul>',
                    'walker' => new Custom_Nav_Walker(),
                ]);
                ?>
            </nav>

            <a href="<?php echo esc_url(home_url('/submit-ai/')); ?>" class="hidden lg:flex rounded-lg bg-[var(--secondary)] px-4 py-2 font-medium gap-3 items-center">
                <span class="text-[var(--primary)] hidden md:block">Submit Ai Tool</span>
            </a>

            <button class="lg:hidden ml-4 mobile-menu-button" id="toggle-btn1" aria-label="Menu" aria-expanded="false">
                <span class="mobile-menu-button__line"></span>
                <span class="mobile-menu-button__line"></span>
                <span class="mobile-menu-button__line"></span>
            </button>
        </header>

        <div id="mobile-menu-overlay"></div>

        <div id="mob-nav">
            <div class="h-full overflow-y-auto">
                <nav class="p-6">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'main',
                        'container' => false,
                        'menu_class' => 'flex flex-col gap-4 text-white',
                        'walker' => new Custom_Nav_Walker(),
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

                toggleBtn.addEventListener('click', () => {
                    const isOpen = toggleBtn.getAttribute('aria-expanded') === 'true';
                    toggleBtn.setAttribute('aria-expanded', !isOpen);
                    mobNav.classList.toggle('active');
                    overlay.classList.toggle('active');
                    body.classList.toggle('menu-open');
                });

                overlay.addEventListener('click', () => {
                    mobNav.classList.remove('active');
                    overlay.classList.remove('active');
                    toggleBtn.setAttribute('aria-expanded', 'false');
                    body.classList.remove('menu-open');
                });

                document.addEventListener('click', function(e) {
                    if (e.target.closest('#mob-nav li.menu-item-has-children > a')) {
                        e.preventDefault();
                        const li = e.target.closest('li');
                        li.classList.toggle('open');
                    }
                });
            });
        </script>
    </div>
</body>
</html>
