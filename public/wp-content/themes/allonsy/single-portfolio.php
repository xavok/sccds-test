<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

get_header(); ?>

<?php get_template_part( 'template-parts/portfolio-title-bar' ); ?>

<div id="single-post" class="page-full-width max-width-sixteen-hundred no-sidebar" role="main">

<?php do_action( 'foundationpress_before_content' ); ?>
<?php while ( have_posts() ) : the_post(); ?>
	<article <?php post_class('main-content') ?> id="post-<?php the_ID(); ?>">
		<?php do_action( 'foundationpress_post_before_entry_content' ); ?>
		<div class="entry-content">

		<?php
		  global $post;
			$description = get_field('bs_portfolio_description');
			$gallery = get_field('bs_portfolio_gallery');
			$completed = get_field('bs_portfolio_completed');
			$budget = get_field('bs_portfolio_budget');
			$tax_terms = get_the_terms( $post->ID , 'portfolio-cat' );
		?>
			<div class="portfolio-wrap">
				<div class="portfolio-main-image">
					<?php if($gallery) { ?>
					<ul class="portfolio-gallery">
						<?php foreach( $gallery as $image ): ?>
							<li>
								<a href="<?php echo $image['url']; ?>" class="swipebox">
									<img src="<?php echo $image['sizes']['portfolio-gallery']; ?>" alt="<?php $image['alt']; ?>">
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
					<?php } ?>
				</div>
				<div class="portfolio-description">
					<div class="portfolio-description-inner">
						<h2 class="portfolio-title"><?php the_title(); ?></h2>
						<?php if($completed) { ?>
						<p><strong>Completed:</strong> <?php echo $completed; ?></p>
						<?php } ?>
						<?php if($budget) { ?>
						<p><strong>Budget:</strong> $<?php echo $budget; ?></p>
						<?php } ?>
						<p><strong>Category:</strong> <?php foreach ($tax_terms as $tax_term) { echo '<span class="term-name">' . $tax_term->name . '</span>'; } ?></p>
						<?php if($description) { ?>
						<p><strong>Features:</strong> <?php echo $description; ?></p>
						<?php } ?>

						<?php $posttags = get_the_tags(); if ($posttags) { ?>
						<div class="the-tags">
							<?php foreach($posttags as $tag) {
							  echo '<a href="' . get_bloginfo('url') . '/tag/'  . $tag->slug . '"><span class="tag">#' . $tag->slug . '</a></span>';
							} ?>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>

		</div>

		<nav id="nav-single" class="nav-single">
			<div class="nav-single-inner">
				<span class="nav-previous"><?php next_post_link( '%link', '<span class="meta-nav">' . _x( '&laquo;', 'Previous post link', 'wp-forge' ) . '</span> %title' ); ?></span>
				<span class="nav-next"><?php previous_post_link( '%link', '%title <span class="meta-nav">' . _x( '&raquo;', 'Next post link', 'wp-forge' ) . '</span>' ); ?></span>
			</div>
		</nav><!-- .nav-single -->
		<?php do_action( 'foundationpress_post_before_comments' ); ?>
		<?php comments_template(); ?>
		<?php do_action( 'foundationpress_post_after_comments' ); ?>
	</article>
<?php endwhile;?>

<?php do_action( 'foundationpress_after_content' ); ?>
</div>
<?php get_footer();
