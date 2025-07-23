<?php

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$type = 'ai-agent';
$pricing_options = get_terms(array(
    'taxonomy' => $type . '-pricing-option',
    'orderby' => 'ID',
    'order' => 'ASC'
));

?>

<style>
    .active-btn {
        border-color: var(--primary);
        color: #fff;
        background-color: var(--primary);
    }
    .filter-list li{
        list-style: none !important;
    }
</style>

<section class="py-16 text-white" style="background-color: var(--primary);">
    <div class="container mx-auto px-4 text-center max-w-[1280px]">
        <h1 class="text-4xl font-bold mb-6 text-white"><?php _e('AI Agents', 'wb'); ?></h1>
        <p class="text-center">Explore the ultimate directory of AI Marketing Agents designed to automate campaigns, boost ROI, and streamline your workflow. From SEO to content creation, discover powerful AI tools, compare features, and find the perfect agent to supercharge your digital marketing.</p>
    </div>
</section>

<section class="py-8">
<h5 class="text-center text-[var(--primary)] text-[20px] font-semibold">Categories</h5>

<div class="text-center flex flex-wrap justify-center max-w-[1280px] mx-auto px-4">
    <button class="ai-agents-category-button capitalize text-black px-4 py-2 rounded-lg m-1 border-[3px] text-white active-btn" data-category="">
        <?php _e('All', 'wb'); ?>
    </button>
    <?php
    $categories = get_terms(array('taxonomy' => 'ai-agent-category', 'hide_empty' => false));
    $current_cat = $_GET['category'] ?? '';
    foreach ($categories as $category):
        $is_active = $current_cat === $category->slug ? 'active-btn text-white' : '';
        ?>
        <button class="ai-agents-category-button capitalize text-black bg-[#dfe5ff] px-4 py-2 rounded-lg m-1 border-[3px] <?php echo $is_active; ?>" data-category="<?php echo $category->slug; ?>">
            <?php echo $category->name; ?>
        </button>
    <?php endforeach; ?>
</div>
</section>

<!-- Loading Indicator -->
<div id="loading-indicator" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500 mx-auto"></div>
        <p class="mt-4 text-gray-700">Loading AI Agents...</p>
    </div>
</div>

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
                    <h2 class="text-xl font-semibold mb-6"><?php _e('Filter AI Agents', 'wb'); ?></h2>
                    <form id="ai-agents-filter" method="get" class="space-y-6">
                        <!-- Features Section -->
                        <div class="filter-section">
                            <h3><?php _e('Features', 'wb'); ?></h3>
                            <input type="text" id="featureSearch" placeholder="Search features..." class="filter-search">
                            <div class="filter-list" id="featuresList">
                                <?php
                                $tags = get_terms(array('taxonomy' => 'ai-agent-tag', 'hide_empty' => false));
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
                                $pricing_options = get_terms(array('taxonomy' => 'ai-agent-pricing-option', 'hide_empty' => false));
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
                <div id="ai-agents-results" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <?php
                    // Get current page
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                    // Setup the query args
                    $query_args = array(
                        'post_type' => 'ai-agent',
                        'posts_per_page' => 12,
                        'paged' => $paged,
                    );

                    // Handle category filter
                    if (!empty($_GET['category'])) {
                        $query_args['tax_query'][] = array(
                            'taxonomy' => 'ai-agent-category',
                            'field' => 'slug',
                            'terms' => sanitize_text_field($_GET['category']),
                        );
                    }

                    // Handle features filter
                    if (!empty($_GET['features'])) {
                        $features = is_array($_GET['features']) ? $_GET['features'] : array($_GET['features']);
                        $query_args['tax_query'][] = array(
                            'taxonomy' => 'ai-agent-tag',
                            'field' => 'slug',
                            'terms' => array_map('sanitize_text_field', $features),
                        );
                    }

                    // Handle pricing filter
                    if (!empty($_GET['pricing'])) {
                        $pricing = is_array($_GET['pricing']) ? $_GET['pricing'] : array($_GET['pricing']);
                        $query_args['tax_query'][] = array(
                            'taxonomy' => 'ai-agent-pricing-option',
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
                        <p class="text-center w-full col-span-3"><?php _e('No agents found.', 'wb'); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.getElementById("filterToggle");
    const sidebar = document.getElementById("filterSidebar");
    const filterForm = document.getElementById('ai-agents-filter');
    const loadingIndicator = document.getElementById('loading-indicator');
    
    // Add body class for AI Agents archive
    document.body.classList.add('post-type-archive-ai-agent');

    // Toggle mobile filters
    if (toggleBtn) {
        toggleBtn.addEventListener("click", function () {
            if (sidebar.classList.contains("hidden")) {
                sidebar.classList.remove("hidden");
                toggleBtn.textContent = "Hide Filters";
            } else {
                sidebar.classList.add("hidden");
                toggleBtn.textContent = "Show Filters";
            }
        });
    }

    // Handle filter form submission
    if (filterForm) {
        // Prevent default form submission
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            filterAIAgents();
        });

        // Add change event to all filter inputs
        const filterInputs = filterForm.querySelectorAll('input[type="checkbox"]');
        filterInputs.forEach(input => {
            input.addEventListener('change', filterAIAgents);
        });
    }

    // Handle category button clicks
    const categoryButtons = document.querySelectorAll('.category-button');
    categoryButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Update active state
            categoryButtons.forEach(btn => btn.classList.remove('active-btn', 'text-white'));
            this.classList.add('active-btn', 'text-white');
            
            // Trigger filter
            filterAIAgents();
        });
    });

    // Function to handle filtering
    function filterAIAgents() {
        if (loadingIndicator) loadingIndicator.classList.remove('hidden');
        
        // Get selected category
        const activeCategory = document.querySelector('.category-button.active-btn');
        const category = activeCategory ? activeCategory.dataset.category : '';
        
        // Get selected features
        const features = [];
        const featureCheckboxes = document.querySelectorAll('input[name="features[]"]:checked');
        featureCheckboxes.forEach(checkbox => {
            features.push(checkbox.value);
        });
        
        // Get selected pricing options
        const pricing = [];
        const pricingCheckboxes = document.querySelectorAll('input[name="pricing[]"]:checked');
        pricingCheckboxes.forEach(checkbox => {
            pricing.push(checkbox.value);
        });
        
        // Prepare data for AJAX
        const data = new FormData();
        data.append('action', 'filter_ai_agents');
        data.append('nonce', ajax_object.nonce);
        if (category) data.append('category', category);
        if (features.length) data.append('features', JSON.stringify(features));
        if (pricing.length) data.append('pricing', JSON.stringify(pricing));
        
        // Send AJAX request
        fetch(ajax_object.ajax_url, {
            method: 'POST',
            body: data,
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('results').innerHTML = data.data.html;
                // Update URL without reloading the page
                updateUrl(category, features, pricing);
            } else {
                console.error('Error:', data.data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        })
        .finally(() => {
            if (loadingIndicator) loadingIndicator.classList.add('hidden');
        });
    }
    
    // Function to update URL without page reload
    function updateUrl(category, features, pricing) {
        const url = new URL(window.location.href);
        
        // Update URL parameters
        if (category) {
            url.searchParams.set('category', category);
        } else {
            url.searchParams.delete('category');
        }
        
        if (features.length) {
            url.searchParams.set('features', features.join(','));
        } else {
            url.searchParams.delete('features');
        }
        
        if (pricing.length) {
            url.searchParams.set('pricing', pricing.join(','));
        } else {
            url.searchParams.delete('pricing');
        }
        
        // Update URL without reloading the page
        window.history.pushState({}, '', url);
    }
    
    // Handle browser back/forward buttons
    window.addEventListener('popstate', function() {
        // Parse URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const category = urlParams.get('category') || '';
        const features = urlParams.get('features') ? urlParams.get('features').split(',') : [];
        const pricing = urlParams.get('pricing') ? urlParams.get('pricing').split(',') : [];
        
        // Update UI to match URL parameters
        if (category) {
            const categoryButton = document.querySelector(`.category-button[data-category="${category}"]`);
            if (categoryButton) {
                categoryButtons.forEach(btn => btn.classList.remove('active-btn', 'text-white'));
                categoryButton.classList.add('active-btn', 'text-white');
            }
        } else {
            const allButton = document.querySelector('.category-button[data-category=""]');
            if (allButton) {
                categoryButtons.forEach(btn => btn.classList.remove('active-btn', 'text-white'));
                allButton.classList.add('active-btn', 'text-white');
            }
        }
        
        // Update checkboxes
        document.querySelectorAll('input[name="features[]"]').forEach(checkbox => {
            checkbox.checked = features.includes(checkbox.value);
        });
        
        document.querySelectorAll('input[name="pricing[]"]').forEach(checkbox => {
            checkbox.checked = pricing.includes(checkbox.value);
        });
        
        // Trigger filter
        filterAIAgents();
    });
    
    // Initial filter on page load if there are URL parameters
    if (window.location.search) {
        // Small delay to ensure all elements are loaded
        setTimeout(filterAIAgents, 100);
    }
});
</script>

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

    /* Loading indicator styles */
    #loading-indicator {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    #loading-indicator > div {
        background-color: white;
        padding: 2rem;
        border-radius: 0.5rem;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    #loading-indicator .spinner {
        display: inline-block;
        width: 2rem;
        height: 2rem;
        border: 3px solid rgba(0, 0, 0, 0.1);
        border-radius: 50%;
        border-top-color: #3b82f6;
        animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>

<?php get_footer(); ?>