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

<div class="py-8 text-center flex overflow-x-auto justify-start max-w-[1280px] mx-auto custom-scroll px-4">
	<button class="category-button capitalize text-black whitespace-nowrap  px-4 py-2 rounded-lg m-1 border-[3px] text-white active-btn" data-category="">
		<?php _e('All', 'wb'); ?>
	</button>
	<?php
	$categories = get_terms(array('taxonomy' => 'ai-tool-category', 'hide_empty' => false));
	$current_cat = $_GET['category'] ?? '';
	foreach ($categories as $category):
		$is_active = $current_cat === $category->slug ? 'active-btn text-white' : '';
		?>
		<button class="category-button capitalize text-black whitespace-nowrap bg-transparent px-4 py-2 rounded-lg m-1 border-[3px]  <?php echo $is_active; ?>" data-category="<?php echo $category->slug; ?>">
			<?php echo $category->name; ?>
		</button>
	<?php endforeach; ?>
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
				<div id="results" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3  gap-6">
					<?php
					$query_args = array_merge($wp_query->query_vars, ['posts_per_page' => 12]);

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

					query_posts($query_args);

					if (have_posts()):
						while (have_posts()):
							the_post();
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
					else:
						?>
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
						'prev_text' => __('Previous'),
						'next_text' => __('Next'),
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