<?php
/*
Template Name: Member Directory Results
*/
get_header();

// The search term
$search_term = 'jose';

// WP_User_Query arguments
$args = array (
    //'role' => 'members',
    'order' => 'ASC',
    'orderby' => 'display_name',
    'search' => '*'.esc_attr( $search_term ).'*',
    'meta_query' => array(
        'relation' => 'OR',
        array(
            'key'     => 'first_name',
            'value'   => $search_term,
            'compare' => 'LIKE'
        ),
        array(
            'key'     => 'last_name',
            'value'   => $search_term,
            'compare' => 'LIKE'
        ),
        array(
            'key'     => 'full_name',
            'value'   => $search_term,
            'compare' => 'LIKE'
        ),
        array(
            'key'     => 'bs_city',
            'value'   => $search_term,
            'compare' => '=',
        ),
    )
);

// Create the WP_User_Query object
$wp_user_query = new WP_User_Query($args);

// Get the results
$authors = $wp_user_query->get_results();

?>

<?php if( get_theme_mod('internal-title-bar') != '' ) {
  get_template_part( 'template-parts/title-bar' );
} ?>

<div id="page-full-width" role="main">

<?php do_action( 'foundationpress_before_content' ); ?>

  <article <?php post_class('main-content') ?> id="post-<?php the_ID(); ?>">
    <?php if( get_theme_mod('internal-breadcrumbs') != '' ) {
      if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<nav aria-label="You are here:" role="navigation"> <ul class="breadcrumbs">','</ul>'); }
    } ?>
    <?php if( get_theme_mod('internal-title-bar') == '' ) { ?>
      <h1 class="entry-title"><?php the_title(); ?></h1>
    <?php } ?>
      <?php do_action( 'foundationpress_page_before_entry_content' ); ?>
      <div class="entry-content">
          <?php
          // Check for results
            if (!empty($authors)) {
              echo '<ul>';
              // loop through each author
              foreach ($authors as $author)
              {
                  // get all the user's data
                  $author_info = get_userdata($author->ID);
                  echo '<li>' . $author_info->first_name . ' ' . $author_info->last_name . ', ' . $author_info->degree . '</li>';
              }
              echo '</ul>';
            } else {
              echo 'No authors found';
            }
          ?>
      </div>
      <?php do_action( 'foundationpress_page_before_comments' ); ?>
      <?php comments_template(); ?>
      <?php do_action( 'foundationpress_page_after_comments' ); ?>
  </article>

<?php do_action( 'foundationpress_after_content' ); ?>

</div>

<?php get_footer();
