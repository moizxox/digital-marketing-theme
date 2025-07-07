<?php

/** Template Name: New Revamp Local */
if (!defined('ABSPATH')) {
    exit;
}

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

 
<?php

// Hero Section
?>
<section data-aos="fade-up" data-aos-delay="100">
    <?php get_template_part('page-templates/templates/home/hero'); ?>
</section>

<!-- AI Tools Slider -->
<section data-aos="fade-up" data-aos-delay="150">
    <?php get_template_part('page-templates/templates/home/ai-tools-slider'); ?>
</section>

<!-- AI Agents Slider -->
<section data-aos="fade-up" data-aos-delay="200">
    <?php get_template_part('page-templates/templates/home/ai-agents-slider'); ?>
</section>

<!-- Services Section -->
<section data-aos="fade-up" data-aos-delay="250">
    <?php get_template_part('page-templates/templates/home/services-section'); ?>
</section>

<!-- Tools Slider -->
<section data-aos="fade-up" data-aos-delay="300">
    <?php get_template_part('page-templates/templates/home/tools-slider'); ?>
</section>

<!-- Courses Slider -->
<section data-aos="fade-up" data-aos-delay="350">
    <?php get_template_part('page-templates/templates/home/courses-slider'); ?>
</section>

<!-- Services Slider -->
<section data-aos="fade-up" data-aos-delay="400">
    <?php get_template_part('page-templates/templates/home/services-slider'); ?>
</section>

<!-- Content Slider -->
<section data-aos="fade-up" data-aos-delay="450">
    <?php get_template_part('page-templates/templates/home/content-slider'); ?>
</section>

<!-- How It Works -->
<section data-aos="fade-up" data-aos-delay="500">
    <?php get_template_part('page-templates/templates/home/how-it-works'); ?>
</section>

<!-- Newsletter -->
<section data-aos="fade-up" data-aos-delay="550">
    <?php get_template_part('page-templates/templates/home/newsletter'); ?>
</section>

?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
<script>var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';</script>
<script src="<?php echo get_template_directory_uri(); ?>/page-templates/templates/scripts/script.js"></script>

<style>
    @import url("<?php echo get_template_directory_uri(); ?>/page-templates/templates/css/style.css");
</style>
<script src="<?php echo get_template_directory_uri(); ?>/page-templates/templates/scripts/page-load.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/page-templates/templates/scripts/searchForm.handler.js"></script>


<?php get_footer(); ?>
