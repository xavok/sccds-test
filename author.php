<?php

get_header();
$author = get_queried_object();
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

?>

    <div id="page" role="main">

        <?php do_action('foundationpress_before_content'); ?>
            <article <?php post_class('main-content') ?> id="post-<?php the_ID(); ?>">
                <?php echo get_avatar($author->ID); ?>
                <h1><?php echo $author->user_firstname . ' ' . $author->user_lastname . bs_qo_get_user_degree(); ?></h1>
                <p><?php echo bs_qo_get_user_practicetype(); ?><br><?php echo bs_qo_get_user_adanumber(); ?></p>
                <div class="contact-info">
                  <p>
                    <strong>Contact Information</strong><br>
                    <?php echo bs_qo_get_user_address(); ?><br>
                    <?php echo bs_qo_get_user_city(); ?>, <?php echo bs_qo_get_user_state(); ?> <?php echo bs_qo_get_user_zipcode(); ?><br>
                    <a href="mailto:<?php echo $author->user_email; ?>"><?php echo $author->user_email; ?></a>
                  </p>
                </div>
                <ul>
                    <?php if ($author->ID == get_current_user_id()) { ?>
                        <li><a href="<?php bloginfo('url'); ?>/edit-profile/">Edit Profile</a></li>
                    <?php } ?>

                    <li><a href="<?php bloginfo('url'); ?>/forums/user/<?php echo $author->user_login; ?>/">Forum</a></li>
                    <li><a href="<?php bloginfo('url'); ?>/resources/classifieds/">Add/Edit ads</a></li>
                </ul>
                <h3>Jobs Created</h3>
                <ul>
                    <?php foreach ($jobs_create as $job) {
                        echo '<li><a href="' . get_bloginfo('url') . '/job/' . $job->post_title .'/">' . $job->post_title . '</a></li>';
                    }
                    if( empty($jobs_create) ) {
                      echo '<li>No results</li>';
                    } ?>
                </ul>
                <h3>Jobs Applied to</h3>
                <ul>
                    <?php foreach ($jobs_applied as $job) {
                        echo '<li><a href="' . get_bloginfo('url') . '/job/' . $job->post_title .'/">' . $job->post_title . '</a></li>';
                    }
                    if( empty($jobs_applied) ) {
                      echo '<li>None at this time</li>';
                    } ?>
                </ul>
                <h3>Courses Enrolled in</h3>
                <?php echo do_shortcode('[ld_course_list mycourses="1"]'); ?>
            </article>



        <?php do_action('foundationpress_after_content'); ?>

      <?php get_sidebar(); ?>

    </div>

<?php get_footer();
