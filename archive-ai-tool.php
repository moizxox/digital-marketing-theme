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
	.category-button.active-btn {
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
		<button class="category-button capitalize text-black bg-transparent px-4 py-2 rounded-lg m-1 border-[3px]  <?php echo $is_active; ?>" data-category="<?php echo $category->slug; ?>">
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
					<h2 class="text-xl font-semibold mb-4"><?php _e('Filter AI Tools', 'wb'); ?></h2>
					<form method="get" class="space-y-6">
						<div>
							<h3 class="font-medium mb-2"><?php _e('Features', 'wb'); ?></h3>
							<ul class="space-y-2">
								<?php
								$tags = get_terms(array('taxonomy' => 'ai-tool-tag', 'hide_empty' => false));
								foreach ($tags as $tag):
									?>
									<li>
										<label class="flex items-center gap-2">
											<input type="checkbox" name="features[]" value="<?php echo $tag->slug; ?>" <?php checked(in_array($tag->slug, $_GET['features'] ?? [])); ?> class="form-checkbox">
											<span><?php echo $tag->name; ?></span>
										</label>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
						<div>
							<h3 class="font-medium mb-2"><?php _e('Pricing Options', 'wb'); ?></h3>
							<ul class="space-y-2">
								<?php
								$pricing_options = get_terms(array('taxonomy' => 'ai-tool-pricing-option', 'hide_empty' => false));
								foreach ($pricing_options as $option):
									?>
									<li>
										<label class="flex items-center gap-2">
											<input type="checkbox" name="pricing[]" value="<?php echo $option->slug; ?>" <?php checked(in_array($option->slug, $_GET['pricing'] ?? [])); ?> class="form-checkbox">
											<span><?php echo $option->name; ?></span>
										</label>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
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

<script>
document.addEventListener("DOMContentLoaded", function () {
	const toggleBtn = document.getElementById("filterToggle");
	const sidebar = document.getElementById("filterSidebar");

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
});
</script>

<?php get_footer(); ?>