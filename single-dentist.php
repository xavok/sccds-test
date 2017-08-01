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
      if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<nav aria-label="You are here:" role="navigation"> <ul class="breadcrumbs">','</ul>'); }
    } ?>
    <?php if( get_theme_mod('internal-title-bar') == '' ) { ?>
      <h1 class="entry-title"><?php the_title(); ?></h1>
    <?php } ?>
		<?php do_action( 'foundationpress_post_before_entry_content' ); ?>
		<div class="entry-content">

		<!-- <?php
			if ( has_post_thumbnail() ) { ?>
			<div class="single-featured-image">
				<?php the_post_thumbnail(); ?>
			</div>
		<?php }	?> -->

		<?php the_content(); ?>
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

		<?php
      $id = get_the_author_meta('ID');
      $practice_type = get_the_author_meta('practice_type');
      $dental_school = get_the_author_meta('dental_school');
      $degree = get_the_author_meta('degree');
      $dental_school_graduation_year = get_the_author_meta('dental_school_graduation_year');
      $spec_school = get_the_author_meta('spec_school');
      $spec_school_graduation_year = get_the_author_meta('spec_school_graduation_year');
      $email = get_the_author_meta('email');
      $website_url = get_the_author_meta('url');
      $company = get_the_author_meta('company');
      $address = get_the_author_meta('bs_address');
      $city = get_the_author_meta('bs_city');
      $state = get_the_author_meta('bs_state');
      $zip = get_the_author_meta('bs_zip');
      $phone = get_the_author_meta('phone');
      $denti_cal = get_the_author_meta('denti_cal');
      $primary_languages = get_the_author_meta('primary_languages');
      $secondary_company = get_the_author_meta('secondary_company');
      $secondary_address = get_the_author_meta('secondary_address');
      $secondary_city = get_the_author_meta('secondary_city');
      $secondary_state = get_the_author_meta('secondary_state');
      $secondary_zip = get_the_author_meta('secondary_zip');
      $secondary_phone = get_the_author_meta('secondary_phone');
      $secondary_fax = get_the_author_meta('secondary_fax');
      $fax = get_the_author_meta('fax');
      $open = [];
      $close = [];
      for ($i = 1; $i <= 7; $i++) {
        $open[] = get_the_author_meta($i . '_day_open');
        $close[] = get_the_author_meta($i . '_day_close');
      }
    $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>

    <div class="about-the-dentist-wrap">
      <div class="dentist-info-top">
        <div class="dentist-info-left">
          <div class="dentist-image">
              <?php echo get_avatar($id, 200); ?>
          </div>
          <div class="dentist-info">
            <p><strong>Active Specialty: </strong><?php echo $practice_type; ?><br>
            <strong>Dental School:</strong> <?php echo $dental_school; ?><br>
            <strong>Degree:</strong> <?php echo $degree; ?><br>
            <strong>Graduation Year:</strong> <?php echo $dental_school_graduation_year; ?><br>
            <?php if( $spec_school ) { ?><strong>Spec School:</strong> <?php echo $spec_school; ?><br><?php } ?>
            <?php if( $spec_school_graduation_year ) { ?><strong>Spec School Graduation Year:</strong> <?php echo $spec_school_graduation_year; ?><br><?php } ?>
            <strong>Email:</strong> <?php echo $email; ?><br>
            <strong>Language(s) Spoken:</strong> <?php echo $primary_languages; ?><br>
            <?php if (isset($denti_cal)) { ?><strong>DentilCal:</strong> <?php echo $denti_cal; ?><br><?php } ?>
            <?php if (isset($website_url) && !empty($website_url)) { ?>
              <br><strong>Website:</strong> <a href="<?php echo $website_url; ?>"><?php echo $website_url; ?></a></p>
            <?php } else { ?></p><?php } ?>
          </div>
        </div>
        <div class="dentist-info-right">
          <div class="dentist-info-adv">
            <div class="dentist-primary-location">
              <h3>Primary Location</h3>
              <?php if( $company ) { ?><p style="margin-bottom: 0;"><strong><?php echo $company; ?></strong></p><?php } ?>
              <p><?php echo $address; ?><br>
              <?php echo $city; ?>, <?php echo $state; ?> <?php echo $zip; ?></p>

              <div class="dentist-phone">
                <?php if (isset($phone) && !empty($phone)) { ?>
                  <p><strong>Phone:</strong> <?php echo $phone; ?></p>
                <?php } ?>
                <?php if (isset($fax) && !empty($fax)) { ?>
                  <p><strong>Fax:</strong> <?php echo $fax; ?></p>
                <?php } ?>
              </div>
            </div>

            <?php if( $secondary_company ) { ?>
            <div class="dentist-secondary-location">
              <h3>Secondary Location</h3>
              <p style="margin-bottom: 0;"><strong><?php echo $secondary_company; ?></strong></p>
              <p><?php echo $secondary_address; ?><br>
              <?php echo $secondary_city; ?>, <?php echo $secondary_state; ?> <?php echo $secondary_zip; ?></p>

              <div class="dentist-phone">
                <?php if (isset($secondary_phone) && !empty($secondary_phone)) { ?>
                  <p><strong>Phone:</strong> <?php echo $secondary_phone; ?></p>
                <?php } ?>
                <?php if (isset($secondary_fax) && !empty($secondary_fax)) { ?>
                  <p><strong>Fax:</strong> <?php echo $secondary_fax; ?></p>
                <?php } ?>
              </div>
            </div>
            <?php } ?>

            <h3>Office Hours</h3>
            <div class="dentist-office-hours">
            <?php for ($i = 0; $i < count($open); $i++) {
                if(!empty($open[$i]) && !empty($close[$i])) {
                    switch ($i) {
                        case 0:
                            echo "<p><strong>Sunday</strong>: ";
                            break;
                        case 1:
                            echo "<p><strong>Monday</strong>: ";
                            break;
                        case 2:
                            echo "<p><strong>Tuesday</strong>: ";
                            break;
                        case 3:
                            echo "<p><strong>Wednsday</strong>: ";
                            break;
                        case 4:
                            echo "<p><strong>Thursday</strong>: ";
                            break;
                        case 5:
                            echo "<p><strong>Friday</strong>: ";
                            break;
                        case 6:
                            echo "<p><strong>Saturday</strong>: ";
                            break;
                    }
                    echo ' ' . $open[$i] . ' &#8212; ' . $close[$i] . '</p>';
                }
                ?>
            <?php } ?>
            </div>
          </div>
        </div>
      </div>
      <div class="dentist-info-bottom">
        <div id="map"></div>
        <p><strong><a href="" class="map-link" target="_blank" rel="noopener">Get Directions &raquo;</a></p>
        <script>
            function initMap() {
                var lat, lng;
                $.ajax({
                    url: "https://maps.googleapis.com/maps/api/geocode/json?address=<?php echo $address; ?>,<?php echo $city; ?>,<?php echo $state; ?>&key=AIzaSyA3TI_6H074rSCoNpcDVqGBoYh9wB_zm4s",
                    async: false,
                    success: function (data) {
                        var location = data.results[0].geometry.location;
                        lat = location.lat;
                        lng = location.lng;
                        $('.map-link').attr('href', 'https://www.google.com/maps?saddr=My+Location&daddr=' + lat + "," + lng);
                    }
                });
                var uluru = {lat: lat, lng: lng};
                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 16,
                    center: uluru
                });

                var contentString = '<div id="content">'+
                '<h4 style="margin-bottom: 0;"><?php echo $company; ?></h4>'+
                '<div id="bodyContent">'+
                '<p style="margin-bottom: 0;"><?php echo $address; ?><br><?php echo $city; ?>, <?php echo $state; ?> <?php echo $zip; ?><br>'+
                '<a href="https://www.google.com/maps?saddr=My+Location&daddr=' + lat + ',' + lng + '" class="map-link" target="_blank" rel="noopener">Get Directions &raquo;</a></p>'+
                '</div>'+
                '</div>';

                var infowindow = new google.maps.InfoWindow({
                  content: contentString
                });

                var marker = new google.maps.Marker({
                    position: uluru,
                    map: map,
                    title: '<?php echo $company; ?>'
                });
                // marker.addListener('click', function() {
                  infowindow.open(map, marker);
                // });
            }
        </script>
        <script async defer
          src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA3TI_6H074rSCoNpcDVqGBoYh9wB_zm4s&callback=initMap">
        </script>
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
<?php get_sidebar(); ?>
</div>
<?php get_footer();
