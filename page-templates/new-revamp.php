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

get_template_part('page-templates/templates/home/hero');
get_template_part('page-templates/templates/home/ai-tools-slider');
get_template_part('page-templates/templates/home/ai-agents-slider');
get_template_part('page-templates/templates/home/services-section');
get_template_part('page-templates/templates/home/tools-slider');
get_template_part('page-templates/templates/home/courses-slider');
get_template_part('page-templates/templates/home/services-slider');
get_template_part('page-templates/templates/home/content-slider');
get_template_part('page-templates/templates/home/how-it-works');
get_template_part('page-templates/templates/home/newsletter');

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
