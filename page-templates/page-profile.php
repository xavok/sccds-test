<?php
/*
Template Name: User Profile
*/
if (!is_user_logged_in()) {
    auth_redirect();
}
get_header();
$current_user = wp_get_current_user();
$args = array(
    'post_type' => 'job_application',
    'post_status' => ['interviewed', 'offer', 'new']
);
$user_application = get_posts($args);
$jobs = [];
foreach ($user_application as $job) {
    if (get_post_meta($job->ID, '_candidate_user_id', true) == $current_user->ID) {
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


?>

    <div id="page-full-width" role="main">

        <?php do_action('foundationpress_before_content'); ?>
        <?php while (have_posts()) : the_post(); ?>
            <article <?php post_class('main-content') ?> id="post-<?php the_ID(); ?>">
                <?php echo get_avatar($current_user->ID); ?>
                <h1><?php echo $current_user->user_login . '<br />'; ?></h1>
                <ul>
                    <li><a href="/edit-profile/">Edit Profile</a></li>
                    <li><a href="/forums/user/<?php echo $current_user->user_login; ?>/">Check Your Forum</a></li>
                    <li><a href="/resources/classifieds/">Add/Edit ads</a></li>
                </ul>
                <?php echo do_shortcode('[job_dashboard]'); ?>
                <h3>Jobs Applied to</h3>
                <ul>
                    <?php foreach ($jobs_applied as $job) {
                        echo '<li><a href="/job/' . $job->post_title .'/">' . $job->post_title . '</a></li>';
                    } ?>
                </ul>
                <h3>Courses Enrolled in</h3>
                <?php echo do_shortcode('[ld_course_list mycourses=’1′]'); ?>
            </article>
        <?php endwhile; ?>



        <?php do_action('foundationpress_after_content'); ?>

    </div>

<?php get_footer();
