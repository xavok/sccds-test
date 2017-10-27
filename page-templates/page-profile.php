<?php
/**
* Template Name: User Profile
*
* @package FoundationPress
* @since FoundationPress 1.0.0
*/

get_header();

$author = wp_get_current_user();
$user_id = $author->ID;

$args = array(
  'post_type' => 'job_application',
  'post_status' => ['interviewed', 'offer', 'new']
);
$user_application = get_posts($args);
$jobs = [];
foreach ($user_application as $job) {
  if (get_post_meta($job->ID, '_candidate_user_id', true) == $author->ID) {
    $jobs[] = $job->post_parent;
  };
}
if (!empty($jobs)) {
  $args = array(
    'post__in' => $jobs,
    'post_type' => 'job_listing',
  );
  $jobs_applied = get_posts($args);
} else {
  $jobs_applied = [];
}
$jobs_create = get_posts(array(
  'author' =>  $author->ID,
  'post_type' => 'job_listing',
));

// Get User Degree
function bs_get_user_degree() {
  $author = wp_get_current_user();
  $user_id = $author->ID;
  $key = 'degree';
  $single = true;
	$degree = get_user_meta( $user_id, $key, $single );
  if( !empty($degree) ) {
	  return ', ' . $degree;
  }
}
// Get User ADA Number
function bs_get_user_adanumber() {
  $author = wp_get_current_user();
  $user_id = $author->ID;
  $key = 'ada_number';
  $single = true;
	$adanumber = get_user_meta( $user_id, $key, $single );
  if( !empty($adanumber) ) {
	  return 'ADA#: ' . $adanumber;
  }
}
// Get User Practice Type
function bs_get_user_practicetype() {
  $author = wp_get_current_user();
  $user_id = $author->ID;
  $key = 'practice_type';
  $single = true;
	$practicetype = get_user_meta( $user_id, $key, $single );
  if( !empty($practicetype) ) {
	  return $practicetype;
  }
}

// Get User Street Address
function bs_get_user_address() {
  $author = wp_get_current_user();
  $user_id = $author->ID;
  $key = 'bs_address';
  $single = true;
	$address = get_user_meta( $user_id, $key, $single );
  if( !empty($address) ) {
	  return $address;
  }
}
// Get User City
function bs_get_user_city() {
  $author = wp_get_current_user();
  $user_id = $author->ID;
  $key = 'bs_city';
  $single = true;
	$city = get_user_meta( $user_id, $key, $single );
  if( !empty($city) ) {
	  return $city;
  }
}
// Get User State
function bs_get_user_state() {
  $author = wp_get_current_user();
  $user_id = $author->ID;
  $key = 'bs_state';
  $single = true;
	$state = get_user_meta( $user_id, $key, $single );
  if( !empty($state) ) {
	  return $state;
  }
}
// Get User Zip Code
function bs_get_user_zipcode() {
  $author = wp_get_current_user();
  $user_id = $author->ID;
  $key = 'bs_zip';
  $single = true;
	$zipcode = get_user_meta( $user_id, $key, $single );
  if( !empty($zipcode) ) {
	  return $zipcode;
  }
}

// Get User Ads
function bs_get_user_ads() {
    global $wpdb;
    $author = wp_get_current_user();
    $results =  $wpdb->get_results( 'SELECT * FROM '. $wpdb->prefix . 'awpcp_ads WHERE ad_contact_email = "'.$author->user_email .'"', OBJECT );
    foreach ( $results as $ad )
    {
        echo '<li><a href="/resources/classifieds/edit-ad/?id='.$ad->ad_id.'">Edit ' . $ad->ad_title. '</a></li>';
    }
}

?>

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
<div id="page" role="main">

<?php do_action( 'foundationpress_before_content' ); ?>
<?php while ( have_posts() ) : the_post(); ?>
 <article <?php post_class('main-content') ?> id="post-<?php the_ID(); ?>">
    <?php if( get_theme_mod('internal-breadcrumbs') != '' ) {
      if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<nav aria-label="You are here:" role="navigation"> <ul class="breadcrumbs">','</ul>'); }
    } ?>
    <?php if( get_theme_mod('internal-title-bar') == '' ) { ?>
      <h1 class="entry-title"><?php _e( 'User Profile', 'foundationpress' ); ?></h1>
    <?php } ?>
     <?php do_action( 'foundationpress_page_before_entry_content' ); ?>
     <div class="entry-content">
       <?php echo get_avatar($author->ID); ?>
       <h2 class="entry-title"><?php echo $author->user_firstname . ' ' . $author->user_lastname . bs_get_user_degree(); ?></h2>
       <p><?php echo bs_get_user_practicetype(); ?><br><?php echo bs_get_user_adanumber(); ?></p>
       <div class="contact-info">
        <h3>Contact Information</h3>
        <p>
          <?php echo bs_get_user_address(); ?><br>
          <?php echo bs_get_user_city(); ?>, <?php echo bs_get_user_state(); ?> <?php echo bs_get_user_zipcode(); ?><br>
          <a href="mailto:<?php echo $author->user_email; ?>"><?php echo $author->user_email; ?></a>
        </p>
      </div>

      <ul>
        <?php if ($author->ID == get_current_user_id()) { ?>
          <li><a href="<?php bloginfo('url'); ?>/edit-profile/">Edit Profile</a></li>
        <?php } ?>
      </ul>
      <!-- <ul>
        <li><a href="<?php bloginfo('url'); ?>/forums/user/<?php echo $author->user_login; ?>/">Forum</a></li>
      </ul> -->
      <hr>
      <h3>Classified Ads</h3>
      <ul>
        <li><a href="<?php bloginfo('url'); ?>/resources/classifieds/place-ad/">Add New Classified</a></li>
          <?php bs_get_user_ads(); ?>
      </ul>
      <hr>
      <h3>Jobs Created</h3>
      <ul>
          <?php foreach ($jobs_create as $job) {
              echo '<li><a href="' . $job->guid . '">' . $job->post_title . '</a></li>';
          }
          if( empty($jobs_create) ) {
            echo '<li>None at this time</li>';
          } ?>
      </ul>
      <h3>Jobs Applied to</h3>
      <ul>
          <?php foreach ($jobs_applied as $job) {
              echo '<li><a href="' . $job->guid . '">' . $job->post_title . '</a></li>';
          }
          if( empty($jobs_applied) ) {
            echo '<li>None at this time</li>';
          } ?>
      </ul>
      <hr>
      <h3>Your Course Info</h3>
      <p><em>Come back here once you've completed your in-person event/training to complete the quiz and receive your CE Certificate.</em></p>
      <?php /* echo do_shortcode('[ld_course_list mycourses="true" orderby="title"]'); */ ?>
      <?php echo do_shortcode('[ld_profile]'); ?>
      <!-- <hr> -->
      <h3>CE Certificates</h3>
      <?php echo do_shortcode('[uo_learndash_certificates]'); ?>


     </div>
     <footer>
         <?php wp_link_pages( array('before' => '<nav id="page-nav"><p>' . __( 'Pages:', 'foundationpress' ), 'after' => '</p></nav>' ) ); ?>
         <p><?php the_tags(); ?></p>
     </footer>
     <?php do_action( 'foundationpress_page_before_comments' ); ?>
     <?php comments_template(); ?>
     <?php do_action( 'foundationpress_page_after_comments' ); ?>
 </article>
<?php endwhile;?>

<?php do_action( 'foundationpress_after_content' ); ?>
<?php get_sidebar(); ?>

</div>

<?php get_footer();
