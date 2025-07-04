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

<section class="py-16 text-white" style="background-color: var(--primary);">
	<div class="container mx-auto px-4 text-center max-w-4xl">
		<h1 class="text-4xl font-bold mb-6 text-white"><?php _e('AI Tools', 'wb'); ?></h1>
		<?php if ($search_page = wb_get_page_by_template('search')): ?>
			<form action="<?php echo get_permalink($search_page); ?>" method="get" class="flex flex-col sm:flex-row justify-center gap-4">
				<input type="text" name="query" class="px-4 py-2 rounded-md text-black w-full sm:w-2/3" placeholder="<?php _e('e.g. ChatGPT or Midjourney', 'wb'); ?>">
				<input type="hidden" name="type" value="<?php echo $type; ?>">
				<button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md">
					<i class="icon icon-search"></i> <?php _e('SEARCH', 'wb'); ?>
				</button>
			</form>
		<?php endif; ?>
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
						<div>
							<h3 class="font-medium mb-2"><?php _e('Price', 'wb'); ?></h3>
							<input type="number" name="min_price" placeholder="Min Price" value="<?php echo esc_attr($_GET['min_price'] ?? ''); ?>" class="w-full p-2 border rounded mb-2">
							<input type="number" name="max_price" placeholder="Max Price" value="<?php echo esc_attr($_GET['max_price'] ?? ''); ?>" class="w-full p-2 border rounded">
						</div>
						<button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 w-full">Apply Filters</button>
					</form>
				</div>
			</aside>

			<div class="w-full lg:w-3/4">
				<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
					<?php
					$query_args = array_merge($wp_query->query_vars, ['posts_per_page' => 16]);

					if (!empty($_GET['features'])) {
						$query_args['tax_query'][] = array(
							'taxonomy' => 'ai-tool-tag',
							'field' => 'slug',
							'terms' => $_GET['features'],
						);
					}

					if (!empty($_GET['pricing'])) {
						$query_args['tax_query'][] = array(
							'taxonomy' => 'ai-tool-pricing-option',
							'field' => 'slug',
							'terms' => $_GET['pricing'],
						);
					}

					if (!empty($_GET['min_price']) || !empty($_GET['max_price'])) {
						$meta_query = array('relation' => 'AND');
						if (!empty($_GET['min_price'])) {
							$meta_query[] = array(
								'key' => '_price',
								'value' => $_GET['min_price'],
								'compare' => '>=',
								'type' => 'NUMERIC'
							);
						}
						if (!empty($_GET['max_price'])) {
							$meta_query[] = array(
								'key' => '_price',
								'value' => $_GET['max_price'],
								'compare' => '<=',
								'type' => 'NUMERIC'
							);
						}
						$query_args['meta_query'] = $meta_query;
					}

					query_posts($query_args);

					if (have_posts()):
						while (have_posts()):
							the_post();
							?>
							<div class="bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition duration-300">
								<?php if (has_post_thumbnail()): ?>
									<a href="<?php the_permalink(); ?>">
										<?php the_post_thumbnail('medium', ['class' => 'w-full h-48 object-cover']); ?>
									</a>
								<?php endif; ?>
								<div class="p-4">
									<h3 class="text-lg font-semibold mb-2">
										<a href="<?php the_permalink(); ?>" class="hover:text-blue-600">
											<?php the_title(); ?>
										</a>
									</h3>
									<p class="text-sm text-gray-600"><?php echo get_the_excerpt(); ?></p>
								</div>
							</div>
						<?php endwhile;
					else: ?>
						<p class="text-center w-full"><?php _e('No tools found.', 'wb'); ?></p>
					<?php endif; ?>
				</div>

				<!-- Pagination -->
				<div class="mt-8 flex justify-center">
					<?php
					$pagination_args = array(
						'total' => $wp_query->max_num_pages,
						'current' => max(1, get_query_var('paged')),
						'show_all' => false,
						'end_size' => 1,
						'mid_size' => 2,
						'prev_next' => true,
						'prev_text' => __('« Previous'),
						'next_text' => __('Next »'),
						'type' => 'array',
						'add_args' => false,
					);
					$pagination = paginate_links($pagination_args);
					if ($pagination):
						?>
						<ul class="flex flex-wrap justify-center gap-2 mt-4">
							<?php foreach ($pagination as $link): ?>
								<li><?php echo str_replace('page-numbers', 'px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700', $link); ?></li>
							<?php endforeach; ?>
						</ul>
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