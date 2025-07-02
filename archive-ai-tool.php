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

<div class="hero hero_posts hero_center heading-bg">
	<div class="container">
		<div class="hero__inner clearfix max-w-823">
			<h1 class="hero__title"><?php _e('AI Tools', 'wb'); ?></h1>
			<?php if ($search_page = wb_get_page_by_template('search')) : ?>
				<form action="<?php echo get_permalink($search_page); ?>" method="get" class="hero-search hero-search_single">
					<div class="hero-search__input">
						<input type="text" name="query" class="form-control" placeholder="<?php _e('e.g. ChatGPT or Midjourney', 'wb'); ?>">
						<input type="hidden" name="type" value="<?php echo $type; ?>">
					</div>
					<div class="hero-search__append">
						<button type="submit" class="btn btn-green hero-search__btn">
							<i class="icon icon-search"></i> <?php _e('SEARCH', 'wb'); ?>
						</button>
					</div>
				</form>
			<?php endif; ?>
		</div>
	</div>
</div>

<main class="main page-posts">
	<div class="container">
		<div class="control-bar">
			<form method="get" class="control-bar__right">
				<ul class="control-bar-list">
					<li class="control-bar-item">
						<div class="control-bar__label"><?php _e('Sort by', 'wb'); ?></div>
						<select name="sort" class="control-bar__select select-styler">
							<option value="alphabetically" <?php selected('alphabetically', isset($_GET['sort']) ? $_GET['sort'] : 'alphabetically'); ?>>
								<?php _e('Alphabetically', 'wb'); ?>
							</option>
							<option value="popularity" <?php selected('popularity', isset($_GET['sort']) ? $_GET['sort'] : ''); ?>>
								<?php _e('Popularity', 'wb'); ?>
							</option>
						</select>
					</li>
				</ul>
			</form>
		</div>
		<div class="posts-grid">
			<div class="row display-flex row-gap-10">
				<?php if (have_posts()) : ?>
					<?php while (have_posts()) : the_post(); ?>
						<div class="col-xl-3 col-md-4 col-sm-6 col-gap-10">
							<div class="post-box">
								<div class="post-box__image">
									<?php if (has_post_thumbnail()) : ?>
										<a href="<?php the_permalink(); ?>">
											<?php the_post_thumbnail('290x220'); ?>
										</a>
									<?php endif; ?>
								</div>
								<div class="post-box__info">
									<h3 class="post-box__title box-title">
										<a href="<?php the_permalink(); ?>">
											<?php the_title(); ?>
										</a>
									</h3>
									<div class="post-box__desc box-desc">
										<?php echo get_the_excerpt(); ?>
									</div>
								</div>
							</div>
						</div>
					<?php endwhile; ?>
					<?php wb_pagination(); ?>
				<?php else : ?>
					<div class="col-md-12">
						<p class="text-center"><?php _e('Apologies, but no entries were found.', 'wb'); ?></p>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</main>

<?php get_footer(); ?> 