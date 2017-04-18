<?php

// Shortcode for if user is logged in
function check_user ($params, $content = null){
  if ( is_user_logged_in() ){
    return do_shortcode($content);
  }
  else{
    return;
  }
}
add_shortcode('loggedin', 'check_user' );

// Shortcode for if user is not logged in
function check_user2 ($params, $content = null){
  if ( !is_user_logged_in() ){
    return do_shortcode($content);
  }
  else{
    return;
  }
}
add_shortcode('loggedout', 'check_user2' );

// Current Year Shortcode
function bs_current_year() {
	$year = date('Y');
	return $year;
}
add_shortcode('year','bs_current_year');

// Current Date Shortcode
function bs_current_date() {
	$year = date('F jS, Y');
	return $year;
}
add_shortcode('current_date','bs_current_date');


// Custome Search Shortcode

/* Join posts and postmeta tables */
function bs_search_join( $join ) {
  global $wpdb;
  if ( is_search() ) {
    $join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
  }
  return $join;
}
add_filter('posts_join', 'bs_search_join' );

/* Modify the search query with posts_where */
function bs_search_where( $where ) {
  global $wpdb;
  if ( is_search() ) {
    $where = preg_replace(
			"/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
      "(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
  }
  return $where;
}
add_filter( 'posts_where', 'bs_search_where' );

/* Prevent duplicates */
function bs_search_distinct( $where ) {
  global $wpdb;
  if ( is_search() ) {
    return "DISTINCT";
  }
  return $where;
}
add_filter( 'posts_distinct', 'bs_search_distinct' );

// add_filter('relevanssi_modify_wp_query', 'bs_dentist_tax_query');
// function bs_dentist_tax_query($query) {
//     $tax_query = array();
//     if (!empty($query->query_vars['specialty-cat'])) {
//         $tax_query[] = array(
//             'taxonomy' => 'specialty-cat',
//             'field' => 'name',
//             'terms' => $query->query_vars['specialty-cat']
//         );
//     }
//     if (!empty($tax_query)) {
//         $tax_query['relation'] = 'OR';
//         $query->set('tax_query', $tax_query);
//     }
//     return $query;
// }
//
// add_filter('relevanssi_modify_wp_query', 'bs_add_meta_query');
// function bs_add_meta_query($query) {
// 	if (isset($query->query_vars['location']) || isset($query->query_vars['name'])) {
// 		if (!empty($query->query_vars['location']) || isset($query->query_vars['name'])) {
//
// 			$meta_query = array(
// 				'relation'	=> 'OR',
// 				array(
// 					'relation'  => 'OR',
// 					array(
// 						'key'			=> 'first_name',
// 						'value'		=>$query->query_vars['name'],
// 						'compare' => '=',
// 					),
// 					array(
// 						'key'			=> 'last_name',
// 						'value'		=> $query->query_vars['name'],
// 						'compare' => '=',
// 					)
// 				),
// 				array(
// 					'relation'  => 'OR',
// 					array(
// 						'key' 		=> 'bs_city',
// 						'value'		=> $query->query_vars['location'],
// 						'compare' 	=> '=',
// 					),
// 					array(
// 						'key' 		=> 'bs_state',
// 						'value'		=> $query->query_vars['location'],
// 						'compare' 	=> '=',
// 					),
// 					array(
// 						'key' 		=> 'bs_zip',
// 						'value'		=> $query->query_vars['location'],
// 						'compare' 	=> '=',
// 					),
// 				)
// 			);
//
// 			$query->set('meta_query', $meta_query);
// 		}
// 	}
// 	return $query;
// }

add_shortcode( 'bs_custom_search', 'bs_custom_search_shortcode' );
function bs_custom_search_shortcode( $atts ) {
    $args = shortcode_atts( array(
      'results' => ''
    ), $atts, 'bs_custom_search' );
    ob_start(); ?>

		<?php $terms = get_terms(['taxonomy' => 'specialty-cat', 'hide_empty' => false,]);	?>
    <form id="bs-custom-search" role="search" method="get" action="<?php echo home_url( '/' ); ?>">
			<input type="hidden" name="search" value="dentist">
      <label for="name"><span class="screen-reader-text">Search by Last Name:</span>
				<input type="text" value="" name="name" id="name" placeholder="Search by Name" />
			</label>
			<label for="location"><span class="screen-reader-text">Search by City or Zip:</span>
				<input type="text" value="" name="location" id="location" placeholder="Search by City or Zip" />
			</label>
			<label for="specialty"><span class="screen-reader-text">Search by Specialty:</span>
				<select id="specialty" name="specialty-cat">
						<option value="" selected>All Specialties</option>
					<?php foreach($terms as $term) : ?>
						<option value="<?php echo $term->name; ?>"><?php echo $term->name; ?></option>
					<?php endforeach; ?>
				</select>
			</label>
			<input type="hidden" value="dentist" name="post_type" />
			<!-- <input type="hidden" value="1" name="paged" /> -->
			<!-- <input type="hidden" value="lat" name="<?php echo $json_lat; ?>" /> -->
			<!-- <input type="hidden" value="long" name="<?php echo $json_long; ?>" /> -->
			<input type="hidden" value="1" name="sentence" />
      <input type="submit" id="searchsubmit" value="Search" />
    </form>

    <?php $bs_custom_search_variable = ob_get_clean();
    return $bs_custom_search_variable;
}


// Customizer Social Media Links Shortcode
add_shortcode( 'bs_social_urls', 'bs_social_urls_shortcode' );
function bs_social_urls_shortcode( $atts ) {
    extract( shortcode_atts( array(
      'align' => '',
      'color' => ''
    ), $atts ) );
    ob_start(); ?>

    <ul class="social-media-wrapper <?php echo $align; ?> <?php echo $color; ?>">
      <?php if( get_theme_mod('facebook')): ?><li class="facebook"><a href="<?php echo get_theme_mod('facebook','default'); ?>" target="_blank" title="Find us on Facebook"><i class="fa fa-facebook"></i></a></li><?php endif; ?>
      <?php if( get_theme_mod('twitter')): ?><li class="twitter"><a href="<?php echo get_theme_mod('twitter','default'); ?>" target="_blank" title="Follow us on Twitter"><i class="fa fa-twitter"></i></a></li><?php endif; ?>
      <?php if( get_theme_mod('linkedin')): ?><li class="linkedin"><a href="<?php echo get_theme_mod('linkedin','default'); ?>" target="_blank" title="Connect with us on LinkedIn"><i class="fa fa-linkedin"></i></a></li><?php endif; ?>
			<?php if( get_theme_mod('flickr')): ?><li class="flickr"><a href="<?php echo get_theme_mod('flickr','default'); ?>" target="_blank" title="Check us out on Flickr"><i class="fa fa-flickr"></i></a></li><?php endif; ?>
      <?php if( get_theme_mod('instagram')): ?><li class="instagram"><a href="<?php echo get_theme_mod('instagram','default'); ?>" target="_blank" title="Follow us on Instagram"><i class="fa fa-instagram"></i></a></li><?php endif; ?>
      <?php if( get_theme_mod('youtube')): ?><li class="youtube"><a href="<?php echo get_theme_mod('youtube','default'); ?>" target="_blank" title="Check out our YouTube Channel"><i class="fa fa-youtube-play"></i></a></li><?php endif; ?>
      <?php if( get_theme_mod('pinterest')): ?><li class="pinterest"><a href="<?php echo get_theme_mod('pinterest','default'); ?>" target="_blank" title="Follow us on Pinterest"><i class="fa fa-pinterest"></i></a></li><?php endif; ?>
      <?php if( get_theme_mod('vimeo')): ?><li class="vimeo"><a href="<?php echo get_theme_mod('vimeo','default'); ?>" target="_blank" title="Check out our Vimeo Channel"><i class="fa fa-vimeo"></i></a></li><?php endif; ?>
			<?php if( get_theme_mod('contact')): ?><li class="contact"><a href="<?php echo get_theme_mod('contact','default'); ?>"><i class="fa fa-envelope-o"></i></a></li><?php endif; ?>
      <?php if( get_theme_mod('rss')): ?><li class="rss"><a href="<?php echo get_theme_mod('rss','default'); ?>" target="_blank" title="Subscribe to our RSS Feed"><i class="fa fa-rss"></i></a></li><?php endif; ?>
    </ul>

    <?php $bs_social_variable = ob_get_clean();
    return $bs_social_variable;
}


// Instagram Feed Shortcode
function bs_instagram_feed( $atts ) {
  extract( shortcode_atts(array(), $atts) );
  ob_start(); ?>

  <div id="instafeed"></div>

  <?php
    wp_enqueue_script( 'instafeed', get_template_directory_uri() . '/assets/javascript/instafeed.js', array('jquery'), '1.0', true );
    $bs_ig_feed_variable = ob_get_clean();
    return $bs_ig_feed_variable;
}
add_shortcode( 'bs_ig_feed', 'bs_instagram_feed' );


// BS Social Share shortcode
add_shortcode( 'bs_social_share', 'bs_social_share_shortcode' );
function bs_social_share_shortcode( $atts ) {
ob_start(); ?>
<div class="bs-social-share-container">
	<div class="bs-social-share-inner">

		<div class="single-social-share social-share-twitter">
			<script type="text/javascript" src="https://platform.twitter.com/widgets.js"></script>
			<a class="twitter-button" href="https://twitter.com/intent/tweet?text=<?php the_title(); ?>%2E&amp;url=<?php the_permalink(); ?>&amp;via=uptownstudios" data-social-action="Twitter : Tweet" title="Share on Twitter"><i class="fa fa-twitter"></i></a>
		</div>

		<div class="single-social-share social-share-facebook">
			<a href="javascript:void(0)" class="btn" onClick="fb_share()" title="Share on Facebook"><i class="fa fa-facebook"></i></a><span><?php echo customFShare(); ?></span>
		</div>

		<div class="single-social-share social-share-google">
			<script src="https://apis.google.com/js/platform.js" async defer></script>
			<?php
				$google_plusones = function ( $url ) {
					$curl = curl_init();
					curl_setopt( $curl, CURLOPT_URL, "https://clients6.google.com/rpc" );
					curl_setopt( $curl, CURLOPT_POST, 1 );
					curl_setopt( $curl, CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . $url . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]' );
					curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
					curl_setopt( $curl, CURLOPT_HTTPHEADER, array( 'Content-type: application/json' ) );
					$curl_results = curl_exec( $curl );
					curl_close( $curl );
					$json = json_decode( $curl_results, true );

			return intval( $json[0]['result']['metadata']['globalCounts']['count'] );
			};
			$url = get_permalink();
			?>
			<a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" data-link="https://plus.google.com/share?url=<?php the_permalink(); ?>" target="_blank" title="Share on Google+"><i class="fa fa-google-plus"></i></a><span><?php echo $google_plusones ("$url"); ?></span>
		</div>

		<div class="single-social-share social-share-linkedin">
			<script src="//platform.linkedin.com/in.js" type="text/javascript"> lang: en_US</script>
			<?php $linkedin_shares = function ( $url ) {
				$li_json_string = file_get_contents( "https://www.linkedin.com/countserv/count/share?format=json&url=" . $url );
				$li_json = json_decode($li_json_string, true);
				return isset($li_json['count'])?intval($li_json['count']):0;
			}; ?>
			<a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php the_title();?>&source=uptownstudios.net" target="_blank" title="Share on LinkedIn"><i class="fa fa-linkedin"></i></a><span><?php $url = get_permalink(); echo $linkedin_shares ("$url"); ?></span>
		</div>

		<div class="single-social-share social-share-pinterest">
			<script type="text/javascript" async defer src="//assets.pinterest.com/js/pinit.js"></script>
			<?php $pinterest_pins = function ( $url ) {
				$api = file_get_contents( 'https://api.pinterest.com/v1/urls/count.json?callback%20&url=' . $url );
				$body = preg_replace( '/^receiveCount\((.*)\)$/', '\\1', $api );
				$count = json_decode( $body );
				return $count->count;
			}; ?>
			<a href="https://www.pinterest.com/pin/create/button/" data-pin-count="true" data-pin-custom="true" title="Share on Pinterest"><i class="fa fa-pinterest"></i></a><span><?php $url = get_permalink(); echo $pinterest_pins ("$url"); ?></span>
		</div>

	</div>
</div>
<?php $bs_social_variable = ob_get_clean();
return $bs_social_variable;
}


// Get User First Name
function bs_usermeta_firstname() {
  $current_user = wp_get_current_user();
  $user_id = $current_user->ID;
  $key = 'first_name';
  $single = true;
	$firstname = get_user_meta( $user_id, $key, $single );
	return $firstname;
}
add_shortcode('bs_firstname','bs_usermeta_firstname');

// Get User Last Name
function bs_usermeta_lastname() {
  $current_user = wp_get_current_user();
  $user_id = $current_user->ID;
  $key = 'last_name';
  $single = true;
	$lastname = get_user_meta( $user_id, $key, $single );
	return $lastname;
}
add_shortcode('bs_lastname','bs_usermeta_lastname');

// Get User Degree Credentials
function bs_usermeta_degree() {
  $current_user = wp_get_current_user();
  $user_id = $current_user->ID;
  $key = 'degree';
  $single = true;
	$degree = get_user_meta( $user_id, $key, $single );
	return $degree;
}
add_shortcode('bs_degree','bs_usermeta_degree');

// Get User ADA Number
function bs_usermeta_ada() {
  $current_user = wp_get_current_user();
  $user_id = $current_user->ID;
  $key = 'ada_number';
  $single = true;
	$ada_number = get_user_meta( $user_id, $key, $single );
	return 'ADA#: ' . $ada_number . '<br>';
}
add_shortcode('bs_ada_number','bs_usermeta_ada');
