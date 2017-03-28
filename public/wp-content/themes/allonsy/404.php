<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package allonsy
 * @since allonsy 1.0.0
 */

get_header(); ?>

<?php if( get_theme_mod('internal-title-bar') != '' ) {
  get_template_part( 'template-parts/title-bar' );
} ?>

<div id="four-o-four-wrapper" class="row">
	<div class="small-12 large-8 columns" role="main">

		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<?php if( get_theme_mod('internal-breadcrumbs') != '' ) {
	      if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<nav aria-label="You are here:" role="navigation"> <ul class="breadcrumbs">','</ul>'); }
	    } ?>
	    <?php if( get_theme_mod('internal-title-bar') == '' ) { ?>
	      <h1 class="entry-title"><?php _e( 'Error 404: Page Not Found', 'allonsy' ); ?></h1>
	    <?php } ?>
			<div class="entry-content">
				<div class="error">
					<p class="bottom"><?php _e( 'The page you are looking cannot be found. It might have been removed, had its name changed, or is temporarily unavailable.', 'allonsy' ); ?></p>
				</div>
				<h3><?php _e( 'Please try the following', 'allonsy' ); ?></h3>
				<ul>
					<li><?php _e( 'Make sure your spelling is correct.', 'allonsy' ); ?></li>
					<li><?php printf( __( 'Return to the <a href="%s">home page</a>', 'allonsy' ), home_url() ); ?></li>
					<li><?php _e( 'Click the <a href="javascript:history.back()">Back</a> button', 'allonsy' ); ?></li>
				</ul>
				<p><?php _e( 'Even though you couldn&rsquo;t find what you were looking for, we do have other great stuff to look at. Below is a list of our latest posts: ', 'wp-forge' ); ?></p>
					<div class="row fourohfour-recent-posts">
						<ul class="small-12 large-4 columns">
						<?php
							$recent_posts = wp_get_recent_posts(array('post_status' => 'publish', 'numberposts' => 3));
							foreach( $recent_posts as $recent ){
								echo '<li><a href="' . get_permalink($recent["ID"]) . '">' .   $recent["post_title"].'</a> </li> ';
							}
						?>
						</ul>
						<ul class="small-12 large-4 columns">
						<?php
							$recent_posts = wp_get_recent_posts(array('post_status' => 'publish', 'numberposts' => 3, 'offset' => 3));
							foreach( $recent_posts as $recent ){
								echo '<li><a href="' . get_permalink($recent["ID"]) . '">' .   $recent["post_title"].'</a> </li> ';
							}
						?>
						</ul>
						<ul class="small-12 large-4 columns">
						<?php
							$recent_posts = wp_get_recent_posts(array('post_status' => 'publish', 'numberposts' => 3, 'offset' => 6));
							foreach( $recent_posts as $recent ){
								echo '<li><a href="' . get_permalink($recent["ID"]) . '">' .   $recent["post_title"].'</a> </li> ';
							}
						?>
						</ul>
					</div>
			</div>
		</article>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer();
