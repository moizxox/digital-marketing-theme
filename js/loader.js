jQuery(document).ready(function($) {
    // Temporarily disabled loader
    /*
    // Add loader HTML to the page
    $('body').prepend(`
        <div class="page-loader">
            <div class="loader"></div>
        </div>
    `);
    */

    // Initialize AOS
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true,
        disable: 'mobile'
    });

    // Temporarily disabled loader
    /*
    // Hide loader when everything is loaded
    $(window).on('load', function() {
        setTimeout(function() {
            $('.page-loader').addClass('hidden');
            
            // Remove loader from DOM after animation completes
            setTimeout(function() {
                $('.page-loader').remove();
            }, 500);
        }, 500);
    });
    */
});
