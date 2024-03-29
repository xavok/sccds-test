<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

get_header(); ?>

<?php if( get_theme_mod('internal-title-bar') != '' ) {
  get_template_part( 'template-parts/title-bar' );
} ?>

<?php if( get_field('page_intro_text') ) { ?>
  <div class="page-intro-text">
    <div class="page-intro-text-inner">
      <p><?php the_field('page_intro_text'); ?></p>
    </div>
  </div>
<?php } ?>

<div id="single-post" class="page-full-width max-width-one-thousand no-sidebar" role="main">

<?php do_action( 'foundationpress_before_content' ); ?>
<?php while ( have_posts() ) : the_post(); ?>
	<article <?php post_class('main-content') ?> id="post-<?php the_ID(); ?>">
		<?php if( get_theme_mod('internal-breadcrumbs') != '' ) {
      if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<nav aria-label="You are here:" role="navigation"> <ul class="breadcrumbs">','</ul></nav>'); }
    } ?>
    <?php if( get_theme_mod('internal-title-bar') == '' ) { ?>
      <h1 class="entry-title espresso-entry-title heeey"><span class="espresso-event-date-card"><?php espresso_event_date_as_calendar_page(); ?></span><?php the_title(); ?></h1>
      <div class="espresso-event-categories"><?php espresso_event_categories(); ?></div>
    <?php } ?>
		<?php do_action( 'foundationpress_post_before_entry_content' ); ?>
		<div class="entry-content">

		<?php
			if ( has_post_thumbnail() ) { ?>
			<div class="single-featured-image">
				<?php the_post_thumbnail(); ?>
			</div>
		<?php }	?>

    <section class="espresso-event-content">
      <div class="espresso-event-top">
        <div class="espresso-status-banner clearfix"><?php espresso_event_status(); ?></div>
        <h3>Event Description</h3>
        <?php the_content(); ?>

      </div>
      <div class="espress-event-bottom">
        <h3>Event Details</h3>
        <div class="espresso-list-of-event-dates"><?php espresso_list_of_event_dates(); ?></div>
        <div class="espresso-event-tickets">
          <?php /* echo do_shortcode('[ESPRESSO_TICKET_SELECTOR]'); */ ?>
          <?php global $post; $event_obj = $post->EE_Event;
            if ( $event_obj instanceof EE_Event ){
              espresso_ticket_selector( $event_obj );
            }
          ?>
        </div>
      </div>

    </section>

		</div>

		<?php if( get_theme_mod('show-post-tags') != '' ) {
		$posttags = get_the_tags(); if ($posttags) { ?>
		<div class="the-tags">
			<hr>
			<h6>Post Tags</h6>
			<?php foreach($posttags as $tag) {
				echo '<a href="' . get_bloginfo('url') . '/tag/'  . $tag->slug . '"><span class="tag">#' . $tag->slug . '</a></span>';
			} ?>
		</div>
		<?php } } ?>

		<!--<nav id="nav-single" class="nav-single">
			<div class="nav-single-inner">
				<span class="nav-previous"><?php next_post_link( '%link', '<span class="meta-nav">' . _x( '&laquo;', 'Previous post link', 'wp-forge' ) . '</span> %title' ); ?></span>
				<span class="nav-next"><?php previous_post_link( '%link', '%title <span class="meta-nav">' . _x( '&raquo;', 'Next post link', 'wp-forge' ) . '</span>' ); ?></span>
			</div>
		</nav> --><!-- .nav-single -->
		<!-- <?php do_action( 'foundationpress_post_before_comments' ); ?>
		<?php comments_template(); ?>
		<?php do_action( 'foundationpress_post_after_comments' ); ?> -->
	</article>
<?php endwhile;?>

<?php do_action( 'foundationpress_after_content' ); ?>
<?php get_sidebar(); ?>
</div>
<?php get_footer();
