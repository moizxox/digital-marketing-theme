<?php

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$type = 'ai-tool';
$pricing_options = get_terms(array(
    'taxonomy' => $type . '-pricing-option',
    'orderby' => 'ID',
    'order' => 'ASC'
));

?>
<style>
	.category.active-btn {
    border-color: var(--primary);
    color: #fff;
	background-color: var(--primary);
  }
</style>

<section class="py-16 text-white" style="background-color: var(--primary);">
	<div class="container mx-auto px-4 text-center max-w-[1280px]">
		<h1 class="text-4xl font-bold mb-6 text-white"><?php _e('AI Tools', 'wb'); ?></h1>
		<p class="text-center">Discover the best AI marketing tools for SEO, content marketing, email, social media, and more. Use AI to automate repetitive tasks, improve performance, and scale your efforts with cutting-edge technology. Compare tools, and find the right fit for your goals.</p>
	</div>
</section>

<section class="py-8">
<h5 class="text-center text-[var(--primary)] text-[20px] font-semibold">Categories</h5>

<div class=" text-center flex justify-center max-w-[1280px] mx-auto px-4 flex-wrap">
	<button class="category-button capitalize text-black px-4 py-2 rounded-lg m-1 border-[3px] text-white active-btn" data-category="">
		<?php _e('All', 'wb'); ?>
	</button>
	<?php
    $categories = get_terms(array('taxonomy' => 'ai-tool-category', 'hide_empty' => false));
    $current_cat = $_GET['category'] ?? '';
    foreach ($categories as $category):
        $is_active = $current_cat === $category->slug ? 'active-btn text-white' : '';
        ?>
		<button class="category-button capitalize text-black bg-[#94a9ff] px-4 py-2 rounded-lg m-1 border-[3px]  <?php echo $is_active; ?>" data-category="<?php echo $category->slug; ?>">
			<?php echo $category->name; ?>
		</button>
	<?php endforeach; ?>
</div>
</section>



<main class="py-12">
	<div class="container mx-auto px-4">
		<div class="flex flex-col lg:flex-row gap-8">
			<aside class="w-full lg:w-1/4">
                <div class="mb-4 lg:hidden">
                    <button id="filterToggle" class="bg-blue-600 text-white px-4 py-2 rounded-md w-full">
                        Show Filters
                    </button>
                </div>
                <div id="filterSidebar" class="bg-gray-100 p-6 rounded-lg hidden lg:block">
                    <h2 class="text-xl font-semibold mb-6"><?php _e('Filter AI Tools', 'wb'); ?></h2>
                    <form method="get" class="space-y-6">
                        <!-- Features Section -->
                        <div class="filter-section">
                            <h3><?php _e('Features', 'wb'); ?></h3>
                            <input type="text" id="featureSearch" placeholder="Search features..." class="filter-search">
                            <div class="filter-list" id="featuresList">
                                <?php
                                $tags = get_terms(array('taxonomy' => 'ai-tool-tag', 'hide_empty' => false));
                                if (!empty($tags) && !is_wp_error($tags)):
                                    ?>
                                    <ul class="space-y-2">
                                        <?php foreach ($tags as $tag): ?>
                                            <li>
                                                <label class="flex items-center gap-2">
                                                    <input type="checkbox" name="features[]" value="<?php echo $tag->slug; ?>" 
                                                           <?php checked(in_array($tag->slug, $_GET['features'] ?? [])); ?> 
                                                           class="form-checkbox feature-checkbox">
                                                    <span class="feature-name"><?php echo $tag->name; ?></span>
                                                </label>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <p class="no-results"><?php _e('No features available', 'wb'); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Pricing Options Section -->
                        <div class="filter-section">
                            <h3><?php _e('Pricing Options', 'wb'); ?></h3>
                            <input type="text" id="pricingSearch" placeholder="Search pricing options..." class="filter-search">
                            <div class="filter-list" id="pricingList">
                                <?php
                                $pricing_options = get_terms(array('taxonomy' => 'ai-tool-pricing-option', 'hide_empty' => false));
                                if (!empty($pricing_options) && !is_wp_error($pricing_options)):
                                    ?>
                                    <ul class="space-y-2">
                                        <?php foreach ($pricing_options as $option): ?>
                                            <li>
                                                <label class="flex items-center gap-2">
                                                    <input type="checkbox" name="pricing[]" value="<?php echo $option->slug; ?>" 
                                                           <?php checked(in_array($option->slug, $_GET['pricing'] ?? [])); ?> 
                                                           class="form-checkbox pricing-checkbox">
                                                    <span class="pricing-name"><?php echo $option->name; ?></span>
                                                </label>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <p class="no-results"><?php _e('No pricing options available', 'wb'); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition-colors">
                            <?php _e('Apply Filters', 'wb'); ?>
                        </button>
                    </form>
                </div>
			</aside>

			<div class="w-full lg:w-3/4">
				<div id="results" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
					<?php
                    // Get current page
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                    // Setup the query args
                    $query_args = array(
                        'post_type' => 'ai-tool',
                        'posts_per_page' => 12,
                        'paged' => $paged,
                    );

                    // Handle category filter
                    if (!empty($_GET['category'])) {
                        $query_args['tax_query'][] = array(
                            'taxonomy' => 'ai-tool-category',
                            'field' => 'slug',
                            'terms' => sanitize_text_field($_GET['category']),
                        );
                    }

                    // Handle features filter
                    if (!empty($_GET['features'])) {
                        $features = is_array($_GET['features']) ? $_GET['features'] : array($_GET['features']);
                        $query_args['tax_query'][] = array(
                            'taxonomy' => 'ai-tool-tag',
                            'field' => 'slug',
                            'terms' => array_map('sanitize_text_field', $features),
                        );
                    }

                    // Handle pricing filter
                    if (!empty($_GET['pricing'])) {
                        $pricing = is_array($_GET['pricing']) ? $_GET['pricing'] : array($_GET['pricing']);
                        $query_args['tax_query'][] = array(
                            'taxonomy' => 'ai-tool-pricing-option',
                            'field' => 'slug',
                            'terms' => array_map('sanitize_text_field', $pricing),
                        );
                    }

                    // Set relation for tax queries if we have multiple
                    if (isset($query_args['tax_query']) && count($query_args['tax_query']) > 1) {
                        $query_args['tax_query']['relation'] = 'AND';
                    }

                    // Create a new query
                    $custom_query = new WP_Query($query_args);

                    if ($custom_query->have_posts()):
                        while ($custom_query->have_posts()):
                            $custom_query->the_post();
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

                        // Pagination
                        $pagination = paginate_links(array(
                            'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                            'format' => '?paged=%#%',
                            'current' => max(1, $paged),
                            'total' => $custom_query->max_num_pages,
                            'prev_text' => '&laquo;',
                            'next_text' => '&raquo;',
                            'type' => 'array',
                        ));

                        if ($pagination):
                            echo '<div class="mt-8 w-full"><ul class="flex flex-wrap justify-center gap-2">';
                            foreach ($pagination as $page_link) {
                                echo '<li>' . str_replace('page-numbers', 'px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700', $page_link) . '</li>';
                            }
                            echo '</ul></div>';
                        endif;

                        wp_reset_postdata();
                    else:
                        ?>
						<p class="text-center w-full col-span-3"><?php _e('No tools found.', 'wb'); ?></p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</main>

<style>
    /* Filter sidebar styles */
    .filter-section {
        margin-bottom: 1.5rem;
    }
    
    .filter-section h3 {
        font-weight: 600;
        margin-bottom: 0.75rem;
        color: #374151;
    }
    
    .filter-search {
        width: 100%;
        padding: 0.5rem;
        margin-bottom: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        font-size: 0.875rem;
    }
    
    .filter-list {
        max-height: 300px;
        overflow-y: auto;
        padding-right: 0.5rem;
        scrollbar-width: thin;
        scrollbar-color: #9ca3af #f3f4f6;
    }
    
    .filter-list::-webkit-scrollbar {
        width: 6px;
    }
    
    .filter-list::-webkit-scrollbar-track {
        background: #f3f4f6;
        border-radius: 3px;
    }
    
    .filter-list::-webkit-scrollbar-thumb {
        background-color: #9ca3af;
        border-radius: 3px;
    }
    
    .filter-list li {
        margin-bottom: 0.5rem;
    }
    
    .filter-list label {
        display: flex;
        align-items: center;
        padding: 0.375rem 0.5rem;
        border-radius: 0.25rem;
        transition: background-color 0.15s;
    }
    
    .filter-list label:hover {
        background-color: #f3f4f6;
    }
    
    .filter-list input[type="checkbox"] {
        margin-right: 0.5rem;
    }
    
    .no-results {
        color: #6b7280;
        font-style: italic;
        padding: 0.5rem 0;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle filter sidebar on mobile
    const filterToggle = document.getElementById('filterToggle');
    const filterSidebar = document.getElementById('filterSidebar');
    
    if (filterToggle && filterSidebar) {
        filterToggle.addEventListener('click', function() {
            filterSidebar.classList.toggle('hidden');
            filterToggle.textContent = filterSidebar.classList.contains('hidden') ? 'Show Filters' : 'Hide Filters';
        });
    }

    // Feature search functionality
    const featureSearch = document.getElementById('featureSearch');
    if (featureSearch) {
        featureSearch.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const featureItems = document.querySelectorAll('#featuresList .feature-name');
            
            featureItems.forEach(item => {
                const label = item.closest('li');
                if (item.textContent.toLowerCase().includes(searchTerm)) {
                    label.style.display = 'block';
                } else {
                    label.style.display = 'none';
                }
            });
        });
    }

    // Pricing search functionality
    const pricingSearch = document.getElementById('pricingSearch');
    if (pricingSearch) {
        pricingSearch.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const pricingItems = document.querySelectorAll('#pricingList .pricing-name');
            
            pricingItems.forEach(item => {
                const label = item.closest('li');
                if (item.textContent.toLowerCase().includes(searchTerm)) {
                    label.style.display = 'block';
                } else {
                    label.style.display = 'none';
                }
            });
        });
    }

    // Handle category buttons
    document.querySelectorAll(".category-button").forEach((button) => {
        button.addEventListener("click", function() {
            const category = this.getAttribute("data-category");
            const url = new URL(window.location.href);

            if (category) {
                url.searchParams.set("category", category);
            } else {
                url.searchParams.delete("category");
            }

            // Reset to first page when changing category
            url.searchParams.set("paged", 1);

            window.location.href = url.toString();
        });
    });
});
</script>

<?php get_footer(); ?>