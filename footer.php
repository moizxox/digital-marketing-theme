<?php if (!defined('ABSPATH')) exit; ?>
<footer class="my-gradient-background py-[60px] px-3 sm:px-5 ">
    <section class="max-w-[1440px] mx-auto"><div class="flex flex-col lg:flex-row flex-wrap lg:flex-nowrap gap-6 justify-between border-b border-white pb-9">
        <!-- Logo -->
        <div class="w-full lg:w-auto flex justify-center lg:justify-start">
           <a href="/"> <img src="https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/logo.png" alt="Logo" class="h-12" />
        </a></div>

        <!-- Menu -->
        <nav class="w-full lg:w-auto">
            <ul class="flex flex-col md:flex-row md:flex-wrap items-center md:justify-center gap-4 md:gap-6 text-white text-center">
                <li><a href="https://digitalmarketingsupermarket.com/about/" class="hover:text-[#FFCC00]">About</a></li>
                <li><a href="https://digitalmarketingsupermarket.com/blog/" class="hover:text-[#FFCC00]">Blog</a></li>
                <li><a href="https://digitalmarketingsupermarket.com/contact-us/" class="hover:text-[#FFCC00]">Contact</a></li>
                <li><a href="https://digitalmarketingsupermarket.com/terms-and-conditions/" class="hover:text-[#FFCC00]">Terms & Conditions</a></li>
                <li><a href="https://digitalmarketingsupermarket.com/privacy-policy-2/" class="hover:text-[#FFCC00]">Privacy Policy</a></li>
            </ul>
        </nav>

        <!-- Social Icons -->
        <div class="w-full lg:w-auto flex justify-center lg:justify-end">
            <ul class="flex gap-3">
                <li>
                    <a href="https://www.facebook.com/DigitalMarketingSupermarket" target="_blank" rel="noopener noreferrer" class="bg-[#FFCC00] flex items-center justify-center text-[#0C2452] w-9 h-9 rounded-full hover:bg-white transition-colors duration-300">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                </li>
                <li>
                    <a href="https://www.linkedin.com/company/digital-marketing-supermarket/" target="_blank" rel="noopener noreferrer" class="bg-[#FFCC00] flex items-center justify-center text-[#0C2452] w-9 h-9 rounded-full hover:bg-white transition-colors duration-300">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                </li>
                <li>
                    <a href="https://www.instagram.com/digitalmarketingsupermarket/" target="_blank" rel="noopener noreferrer" class="bg-[#FFCC00] flex items-center justify-center text-[#0C2452] w-9 h-9 rounded-full hover:bg-white transition-colors duration-300">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Copyright -->
    <p class="mt-6 text-white text-xs text-center">
        © 2025 Copyright Digital Marketing Supermarket. Made by 
        <a href="https://tetraintech.com" class="text-[#FFCC00] hover:underline">Tetra In Tech</a>
    </p></section>
</footer>

<?php wp_footer(); ?>

<!-- Cookie Bar -->
<div class="cookie-bar hidden">
    <div class="content-cb">
        <video autoplay loop muted playsinline>
            <source src="<?php echo WB_THEME_URL; ?>/images/woobro-cookie.webm" type="video/webm">
            <source src="<?php echo WB_THEME_URL; ?>/images/woobro-cookie.mp4" type="video/mp4">
        </video>
        <h3>We use Cookies</h3>
        <p>
            This website uses cookies to ensure you get the best experience.
            <a href="<?php echo home_url('/privacy-policy-2/'); ?>" title="Privacy Policy">Learn more.</a>
        </p>
        <a href="#" title="Accept Cookies" class="accept-cta">Accept</a>
    </div>
</div>
</body>
</html>
