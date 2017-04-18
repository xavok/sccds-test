<?php
// Custom Excerpt Length
function custom_excerpt_length( $length ) {
	return 45;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );


// Allow the upload of SVG graphics to Media Library
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');


// Add 'mobile' to body class on mobile device
function my_body_classes($c) {
    wp_is_mobile() ? $c[] = 'mobile' : null;
    return $c;
}
add_filter('body_class','my_body_classes');

// Add not-home to body class
function add_not_home_body_class($classes) {
    if( !is_front_page() ) $classes[] = 'not-home';
    return $classes;
}
add_filter('body_class','add_not_home_body_class');


// Enqueue Scripts
function bs_scripts_enqueue() {
		$ajaxurl = '';
		if( in_array('sitepress-multilingual-cms/sitepress.php', get_option('active_plugins')) ){
			$ajaxurl .= admin_url( 'admin-ajax.php?lang=' . ICL_LANGUAGE_CODE );
		} else{
			$ajaxurl .= admin_url( 'admin-ajax.php');
		}
    wp_enqueue_script( 'slick', get_stylesheet_directory_uri() . '/assets/javascript/slick.min.js', array( 'jquery' ) );
		wp_enqueue_script( 'frontend-ajax', get_template_directory_uri() . '/assets/javascript/frontend-ajax.js', array('jquery'), null, true );
		wp_localize_script( 'frontend-ajax', 'frontend_ajax_object',
			array(
				'ajaxurl' => $ajaxurl,
				'noposts' => esc_html__('No additional results found', 'allonsy'),
				'loadmore' => esc_html__('Load more results', 'allonsy')
			)
		);
}
add_action( 'wp_enqueue_scripts', 'bs_scripts_enqueue' );

// Shortcodes in widget
add_filter('widget_text', 'do_shortcode');


add_filter('query_vars', 'bs_add_qv');
function bs_add_qv($qv) {
	$qv[] = 'location';
	$qv[] = 'name';
	$qv[] = 'specialty-cat';
	return $qv;
}

function bs_more_post_ajax() {

	global $post;
	$out = '';
	$ppp = (isset($_POST['ppp'])) ? $_POST['ppp'] : 10;
	$offset = (isset($_POST['offset'])) ? $_POST['offset'] : 0;
	$_name = $_GET['name'] != '' ? $_GET['name'] : '';
	$_location = $_GET['location'] != '' ? $_GET['location'] : '';
    $_specialty = $_GET['specialty-cat'] != '' ? $_GET['specialty-cat'] : '';
    if ($_name == ''  && isset($_POST['name'])) {
        $_name = $_POST['name'];
    }
    if ($_location == '' && isset($_POST['location'])) {
        $_location = $_POST['location'];
    }
    if ($_specialty == '' && isset($_POST['specialty-cat'])) {
        $_specialty = $_POST['specialty-cat'];
    }

	// Search for just Name
	if ($_name != '' && $_location == '' && $_specialty == '') {

		$d_args = array(
			'post_type'  => 'dentist',
			'posts_per_page' => $ppp,
			'offset' => $offset,
			'meta_query' => array(
				'relation'	=> 'OR',
				array(
					'key'			=> 'first_name',
					'value'		=> $_name,
					'compare' => '=',
				),
				array(
					'key'			=> 'last_name',
					'value'		=> $_name,
					'compare' => '=',
				)
			),
		);
	}

	// Search for Name and Location
	if ($_name != '' && $_location != '' && $_specialty == '') {
		$d_args = array(
			'post_type'  => 'dentist',
			'posts_per_page' => $ppp,
			'offset' => $offset,
			'meta_query' => array(
				'relation'	=> 'AND',
				array(
					'relation'  => 'OR',
					array(
						'key'			=> 'first_name',
						'value'		=> $_name,
						'compare' => '=',
					),
					array(
						'key'			=> 'last_name',
						'value'		=> $_name,
						'compare' => '=',
					)
				),
				array(
					'relation'  => 'OR',
					array(
						'key' 		=> 'bs_city',
						'value'		=> $_location,
						'compare' 	=> '=',
					),
					array(
						'key' 		=> 'bs_state',
						'value'		=> $_location,
						'compare' 	=> '=',
					),
					array(
						'key' 		=> 'bs_zip',
						'value'		=> $_location,
						'compare' 	=> '=',
					)
				)
			),
		);
	}

	// Search for Name and Specialty
	if ($_name != '' && $_specialty != '' && $_location == '') {
		$d_args = array(
			'post_type'  => 'dentist',
			'posts_per_page' => $ppp,
			'offset' => $offset,
			'tax_query'  => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'specialty-cat',
					'field'    => 'name',
					'terms'    => $_specialty,
				),
			),
			'meta_query' => array(
				'relation'  => 'OR',
				array(
					'key'			=> 'first_name',
					'value'		=> $_name,
					'compare' => '=',
				),
				array(
					'key'			=> 'last_name',
					'value'		=> $_name,
					'compare' => '=',
				),
			),
		);
	}

	// Search for Name, Location, and Specialty
	if ($_name != '' && $_location != '' && $_specialty != '') {
		$d_args = array(
			'post_type'  => 'dentist',
			'posts_per_page' => $ppp,
			'offset' => $offset,
			'tax_query'  => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'specialty-cat',
					'field'    => 'name',
					'terms'    => $_specialty,
				),
			),
			'meta_query' => array(
				'relation'	=> 'AND',
				array(
					'relation'  => 'OR',
					array(
						'key'			=> 'first_name',
						'value'		=> $_name,
						'compare' => '=',
					),
					array(
						'key'			=> 'last_name',
						'value'		=> $_name,
						'compare' => '=',
					)
				),
				array(
					'relation'  => 'OR',
					array(
						'key' 		=> 'bs_city',
						'value'		=> $_location,
						'compare' 	=> '=',
					),
					array(
						'key' 		=> 'bs_state',
						'value'		=> $_location,
						'compare' 	=> '=',
					),
					array(
						'key' 		=> 'bs_zip',
						'value'		=> $_location,
						'compare' 	=> '=',
					)
				)
			),
		);
	}

	// Search for just Location
	if ($_location != '' && $_name == '' && $_specialty == '') {
		$d_args = array(
			'post_type'  => 'dentist',
			'posts_per_page' => $ppp,
			'offset' => $offset,
			'meta_query' => array(
				'relation'  => 'OR',
				array(
					'key' 		=> 'bs_city',
					'value'		=> $_location,
					'compare' 	=> '=',
				),
				array(
					'key' 		=> 'bs_state',
					'value'		=> $_location,
					'compare' 	=> '=',
				),
				array(
					'key' 		=> 'bs_zip',
					'value'		=> $_location,
					'compare' 	=> '=',
				)
			),
		);
	}

	// Search for Location and Specialty
	if ($_location != '' && $_specialty != '' && $_name == '') {
	$d_args = array(
			'post_type'  => 'dentist',
			'posts_per_page' => $ppp,
			'offset' => $offset,
			'tax_query'  => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'specialty-cat',
					'field'    => 'name',
					'terms'    => $_specialty,
				),
			),
			'meta_query' => array(
				'relation'  => 'OR',
				array(
					'key' 		=> 'bs_city',
					'value'		=> $_location,
					'compare' 	=> '=',
				),
				array(
					'key' 		=> 'bs_state',
					'value'		=> $_location,
					'compare' 	=> '=',
				),
				array(
					'key' 		=> 'bs_zip',
					'value'		=> $_location,
					'compare' 	=> '=',
				)
			),
		);
	}

	// Search for just Specialty
	if ($_specialty != '' && $_name == '' && $_location == '') {
		$d_args = array(
			'post_type'  => 'dentist',
			'posts_per_page' => $ppp,
			'offset' => $offset,
			'tax_query'  => array(
				'relation' => 'OR',
				array(
					'taxonomy' => 'specialty-cat',
					'field'    => 'name',
					'terms'    => $_specialty,
				),
			),
		);
	}

	$d_query = new WP_Query( $d_args );

	if( $d_query->have_posts() ) :

		while( $d_query->have_posts() ) : $d_query->the_post(); ?>
			<?php
				global $post;
				$d_ada = get_field('ada_number');
				$d_phone = get_field('phone');
				$d_email = get_field('email_address');
				$d_address = get_field('bs_address');
				$d_city = get_field('bs_city');
				$d_state = get_field('bs_state');
				$d_zip = get_field('bs_zip');
				$d_company = get_field('company');
				$d_taxonomy = 'specialty-cat';
				$specialty_terms = wp_get_post_terms($post->ID, $d_taxonomy, array('fields' => 'all'));
				$d_count = $d_query->found_posts;
			?>

			<?php
			$out .= '
			<article id="post-' . get_the_ID() . '" class="' . implode(' ', get_post_class('index-card')) . '">
				<div class="entry-content">
					<div class="blog-page-title-excerpt article-right">
						<h3>' . get_the_title() . '</h3>';
						if( $specialty_terms ) {
						$out .= '<p class="dentist-specialty">';
							foreach ($specialty_terms as $specialty_term) {
								$out .= '<span class="specialty-term">' . $specialty_term->name . '</span>';
							}
						$out .= '</p>';
						}
						if( $d_ada ) {
						$out .= '<div class="dentist-info">';
							if( $d_address ) :
								$out .= '<p class="d-address"><strong>Contact Information:</strong><br>' . $d_address . '<br>' . $d_city . ', ' . $d_state . ' ' . $d_zip . '</p>';
							endif;
							if( $d_phone ) {
								$out .= '<p class="d-phone">' . $d_phone . '</p>';
							}
							if( $d_email ) {
								$out .= '<p class="d-email"><a href="mailto:' . $d_email . '">' . $d_email . '</a></p>';
							}
						$out .= '</div>';
						}
						$out .= '<div class="post-excerpt">' . get_the_excerpt() . '</div>
					</div>
				</div>
			</article>';

		endwhile; ?>

        <?php if($offset == 0) { ?>
		<h2><?php echo $d_count; ?> Search Results for "<?php if( $_name != '' ) { echo $_name . ' '; } ?><?php if($_location != '' ) { echo 'in ' . $_location . ' '; } ?><?php if( $_specialty != '' ) { echo 'specializing in ' . $_specialty; } ?>"</h2>
        <?php } ?>
	<?php else : ?>
		<h2>Your search returned no results.</h2>
		<p>If searching by location, try using only the city name or the zip code, not both. Also, when searching by city use only the city name for your search (i.e. Gilroy, not <strike>Gilroy, CA</strike>)</p>

	<?php endif; wp_reset_postdata(); ?>
	<div class="blogpost-entry all-posts-wrapper dentist-search ajax_posts">
		<?php echo $out; ?>
	</div>
    <?php if($offset == 0) { ?>

	<div id="more_posts"><button class="bs-btn bs-btn-purple load-more-posts">Load more results</button></div>
    <?php } ?>

<?php }
add_action('wp_ajax_nopriv_bs_more_post_ajax', 'bs_more_post_ajax');
add_action('wp_ajax_bs_more_post_ajax', 'bs_more_post_ajax');


//Custom User Meta Fields
add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );
add_action( 'user_new_form', 'my_show_extra_profile_fields' );

function my_show_extra_profile_fields( $user ) { ?>

    <h3>Extra profile information</h3>

    <table class="form-table">

			<tr>
					<th><label for="first_name">First Name</label></th>

					<td>
							<input disabled type="text" name="first_name" id="first_name" value="<?php echo esc_attr( get_the_author_meta( 'first_name', $user->ID ) ); ?>" class="regular-text" />
					</td>
			</tr>
			<tr>
					<th><label for="last_name">Last Name</label></th>

					<td>
							<input disabled type="text" name="last_name" id="last_name" value="<?php echo esc_attr( get_the_author_meta( 'last_name', $user->ID ) ); ?>" class="regular-text" />
					</td>
			</tr>
			<tr>
					<th><label for="middle_name">Middle Name</label></th>

					<td>
							<input type="text" name="middle_name" id="middle_name" value="<?php echo esc_attr( get_the_author_meta( 'middle_name', $user->ID ) ); ?>" class="regular-text" />
					</td>
			</tr>
			<tr>
					<th><label for="degree">Degree</label></th>

					<td>
							<input type="text" name="degree" id="degree" value="<?php echo esc_attr( get_the_author_meta( 'degree', $user->ID ) ); ?>" class="regular-text" />
					</td>
			</tr>
        <tr>
            <th><label for="bs_address">Street Address</label></th>

            <td>
                <input type="text" name="bs_address" id="bs_address" value="<?php echo esc_attr( get_the_author_meta( 'bs_address', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
				<tr>
            <th><label for="bs_city">City</label></th>

            <td>
                <input type="text" name="bs_city" id="bs_city" value="<?php echo esc_attr( get_the_author_meta( 'bs_city', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
				<tr>
            <th><label for="bs_state">State</label></th>

            <td>
                <input type="text" name="bs_state" id="bs_state" value="<?php echo esc_attr( get_the_author_meta( 'bs_state', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
				<tr>
            <th><label for="bs_zip">Zip / Postal Code</label></th>

            <td>
                <input type="text" name="bs_zip" id="bs_zip" value="<?php echo esc_attr( get_the_author_meta( 'bs_zip', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
				<tr>
            <th><label for="geo_longitude">Longitude</label></th>

            <td>
                <input type="text" name="geo_longitude" id="geo_longitude" value="<?php echo esc_attr( get_the_author_meta( 'geo_longitude', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
				<tr>
            <th><label for="geo_latitude">Latitude</label></th>

            <td>
                <input type="text" name="geo_latitude" id="geo_latitude" value="<?php echo esc_attr( get_the_author_meta( 'geo_latitude', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
				<tr>
            <th><label for="company">Company</label></th>

            <td>
                <input type="text" name="company" id="company" value="<?php echo esc_attr( get_the_author_meta( 'company', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
				<tr>
            <th><label for="phone">Phone</label></th>

            <td>
                <input type="text" name="phone" id="phone" value="<?php echo esc_attr( get_the_author_meta( 'phone', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
				<tr>
            <th><label for="fax">Fax</label></th>

            <td>
                <input type="text" name="fax" id="fax" value="<?php echo esc_attr( get_the_author_meta( 'fax', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
				<tr>
            <th><label for="ada_number">ADA Number</label></th>

            <td>
                <input type="text" name="ada_number" id="ada_number" value="<?php echo esc_attr( get_the_author_meta( 'ada_number', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
				<tr>
            <th><label for="url">URL</label></th>

            <td>
                <input type="text" name="url" id="url" value="<?php echo esc_attr( get_the_author_meta( 'url', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
				<tr>
            <th><label for="practice_type">Practice Type</label></th>

            <td>
                <input type="text" name="practice_type" id="practice_type" value="<?php echo esc_attr( get_the_author_meta( 'practice_type', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
				<!-- <tr>
            <th><label for="specialty">Specialty</label></th>

            <td>
                <input type="text" name="specialty" id="specialty" value="<?php echo esc_attr( get_the_author_meta( 'specialty', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr> -->
				<tr>
            <th><label for="dental_school">Dental School</label></th>

            <td>
                <input type="text" name="dental_school" id="dental_school" value="<?php echo esc_attr( get_the_author_meta( 'dental_school', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
				<tr>
            <th><label for="dental_school_graduation_year">Dental School Graduation Year</label></th>

            <td>
                <input type="text" name="dental_school_graduation_year" id="dental_school_graduation_year" value="<?php echo esc_attr( get_the_author_meta( 'dental_school_graduation_year', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
				<tr>
            <th><label for="spec_school">Spec School</label></th>

            <td>
                <input type="text" name="spec_school" id="spec_school" value="<?php echo esc_attr( get_the_author_meta( 'spec_school', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
				<tr>
            <th><label for="spec_school_graduation_year">Spec School Graduation Year</label></th>

            <td>
                <input type="text" name="spec_school_graduation_year" id="spec_school_graduation_year" value="<?php echo esc_attr( get_the_author_meta( 'spec_school_graduation_year', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
				<tr>
            <th><label for="retire_date">Retire Date</label></th>

            <td>
                <input type="text" name="retire_date" id="retire_date" value="<?php echo esc_attr( get_the_author_meta( 'retire_date', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
    </table>
    <h2>Work Hours</h2>
    <table>
        <tr>
            <th><label for="1_day">Sunday</label></th>
            <td>
                <input type="text" name="1_day_open" id="1_day_open" value="<?php echo esc_attr( get_the_author_meta( '1_day_open', $user->ID ) ); ?>" class="regular-text" placeholder="Open at: HH:MM AM" />
                <input type="text" name="1_day_close" id="1_day_close" value="<?php echo esc_attr( get_the_author_meta( '1_day_close', $user->ID ) ); ?>" class="regular-text" placeholder="Close at: HH:MM PM"/>
            </td>
        </tr>
        <tr>
            <th><label for="2_day">Monday</label></th>
            <td>
                <input type="text" name="2_day_open" id="2_day_open" value="<?php echo esc_attr( get_the_author_meta( '2_day_open', $user->ID ) ); ?>" class="regular-text" placeholder="Open at: HH:MM AM" />
                <input type="text" name="2_day_close" id="2_day_close" value="<?php echo esc_attr( get_the_author_meta( '2_day_close', $user->ID ) ); ?>" class="regular-text" placeholder="Close at: HH:MM PM"/>
            </td>
        </tr>
        <tr>
            <th><label for="3_day">Tuesday</label></th>
            <td>
                <input type="text" name="3_day_open" id="3_day_open" value="<?php echo esc_attr( get_the_author_meta( '3_day_open', $user->ID ) ); ?>" class="regular-text" placeholder="Open at: HH:MM AM" />
                <input type="text" name="3_day_close" id="3_day_close" value="<?php echo esc_attr( get_the_author_meta( '3_day_close', $user->ID ) ); ?>" class="regular-text" placeholder="Close at: HH:MM PM"/>
            </td>
        </tr>
        <tr>
            <th><label for="4_day">Wednesday</label></th>
            <td>
                <input type="text" name="4_day_open" id="4_day_open" value="<?php echo esc_attr( get_the_author_meta( '4_day_open', $user->ID ) ); ?>" class="regular-text" placeholder="Open at: HH:MM AM" />
                <input type="text" name="4_day_close" id="4_day_close" value="<?php echo esc_attr( get_the_author_meta( '4_day_close', $user->ID ) ); ?>" class="regular-text" placeholder="Close at: HH:MM PM"/>
            </td>
        </tr>
        <tr>
            <th><label for="5_day">Thursday</label></th>
            <td>
                <input type="text" name="5_day_open" id="5_day_open" value="<?php echo esc_attr( get_the_author_meta( '5_day_open', $user->ID ) ); ?>" class="regular-text" placeholder="Open at: HH:MM AM" />
                <input type="text" name="5_day_close" id="5_day_close" value="<?php echo esc_attr( get_the_author_meta( '5_day_close', $user->ID ) ); ?>" class="regular-text" placeholder="Close at: HH:MM PM"/>
            </td>
        </tr>
        <tr>
            <th><label for="6_day">Friday</label></th>
            <td>
                <input type="text" name="6_day_open" id="6_day_open" value="<?php echo esc_attr( get_the_author_meta( '6_day_open', $user->ID ) ); ?>" class="regular-text" placeholder="Open at: HH:MM AM" />
                <input type="text" name="6_day_close" id="6_day_close" value="<?php echo esc_attr( get_the_author_meta( '6_day_close', $user->ID ) ); ?>" class="regular-text" placeholder="Close at: HH:MM PM"/>
            </td>
        </tr>
        <tr>
            <th><label for="7_day">Saturday</label></th>
            <td>
                <input type="text" name="7_day_open" id="7_day_open" value="<?php echo esc_attr( get_the_author_meta( '7_day_open', $user->ID ) ); ?>" class="regular-text" placeholder="Open at: HH:MM AM" />
                <input type="text" name="7_day_close" id="7_day_close" value="<?php echo esc_attr( get_the_author_meta( '7_day_close', $user->ID ) ); ?>" class="regular-text" placeholder="Close at: HH:MM PM"/>
            </td>
        </tr>
    </table>
<?php }

add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );
add_action( 'user_register', 'my_save_extra_profile_fields' );

function my_save_extra_profile_fields( $user_id ) {

    if (!current_user_can('edit_user', $user_id))
        return false;

    /* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
    update_user_meta(absint($user_id), 'first_name', wp_kses_post($_POST['first_name']));
    update_user_meta(absint($user_id), 'last_name', wp_kses_post($_POST['last_name']));
    update_user_meta(absint($user_id), 'middle_name', wp_kses_post($_POST['middle_name']));
    update_user_meta(absint($user_id), 'degree', wp_kses_post($_POST['degree']));

    update_user_meta(absint($user_id), 'bs_address', wp_kses_post($_POST['bs_address']));
    update_user_meta(absint($user_id), 'bs_city', wp_kses_post($_POST['bs_city']));
    update_user_meta(absint($user_id), 'bs_state', wp_kses_post($_POST['bs_state']));
    update_user_meta(absint($user_id), 'bs_zip', wp_kses_post($_POST['bs_zip']));
    update_user_meta(absint($user_id), 'geo_longitude', wp_kses_post($_POST['geo_longitude']));
    update_user_meta(absint($user_id), 'geo_latitude', wp_kses_post($_POST['geo_latitude']));
    update_user_meta(absint($user_id), 'company', wp_kses_post($_POST['company']));
    update_user_meta(absint($user_id), 'phone', wp_kses_post($_POST['phone']));
    update_user_meta(absint($user_id), 'fax', wp_kses_post($_POST['fax']));
    update_user_meta(absint($user_id), 'ada_number', wp_kses_post($_POST['ada_number']));
    update_user_meta(absint($user_id), 'url', wp_kses_post($_POST['url']));
    update_user_meta(absint($user_id), 'practice_type', wp_kses_post($_POST['practice_type']));
    // update_user_meta( absint( $user_id ), 'specialty', wp_kses_post( $_POST['specialty'] ) );
    update_user_meta(absint($user_id), 'dental_school', wp_kses_post($_POST['dental_school']));
    update_user_meta(absint($user_id), 'dental_school_graduation_year', wp_kses_post($_POST['dental_school_graduation_year']));
    update_user_meta(absint($user_id), 'spec_school', wp_kses_post($_POST['spec_school']));
    update_user_meta(absint($user_id), 'spec_school_graduation_year', wp_kses_post($_POST['spec_school_graduation_year']));
    update_user_meta(absint($user_id), 'retire_date', wp_kses_post($_POST['retire_date']));
    for($i = 1; $i <= 7; $i++) {
        update_user_meta(absint($user_id), $i.'_day_open', wp_kses_post($_POST[$i.'_day_open']));
        update_user_meta(absint($user_id), $i.'_day_close', wp_kses_post($_POST[$i.'_day_close']));
    }
}


add_action('user_register','create_new_user_posts');
add_action('user_new_form','create_new_user_posts');
function create_new_user_posts($user_id){
	global $wpdb;
	$table_name = $wpdb->prefix . 'dentist_search';
	$user = get_user_by('id', $user_id);
	if ( !$user_id > 0 )
		return;
		//here we know the user has been created

	// Create post object
	$bs_create_dentist = array(
		'post_type' => 'dentist',
		'post_title' => $user->first_name . ' ' . $user->last_name . ', ' . $user->degree,
		'post_status' => 'publish',
		'post_author' => $user_id
	);

	// Insert the post into the database
	$create_dentist = wp_insert_post( $bs_create_dentist );
	$specialty_terms = explode(', ',$user->practice_type );
	wp_set_object_terms( $dentist_post_id, $specialty_terms, 'specialty-cat');

	// $charset_collate = $wpdb->get_charset_collate();
	// $sql = "CREATE TABLE IF NOT EXISTS $table_name (
	// 	id mediumint(9) NOT NULL AUTO_INCREMENT,
	// 	time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
	// 	dentist_id mediumint(9) NOT NULL,
	// 	name text NOT NULL,
	// 	city tinytext NOT NULL,
	// 	specialty text NOT NULL,
	// 	geo_long DECIMAL(10,7) NOT NULL,
	// 	geo_lat DECIMAL(10,7) NOT NULL,
	// 	PRIMARY KEY  (id)
	// ) $charset_collate;";
	//
	// require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
	// dbDelta( $sql );
	//
	// $name = $user->first_name . ' ' . $user->last_name . ', ' . $user->degree;
	// $city = $user->bs_city;
	// $specialty = $specialty_terms;
	// $long = $user->geo_longitude;
	// $lat = $user->geo_latitude;
	//
	// $wpdb->insert(
	// 	$table_name,
	// 	array(
	// 		'time' => current_time( 'mysql' ),
	// 		'dentist_id' => $create_dentist,
	// 		'name' => $name,
	// 		'city' => $city,
	// 		'specialty' => $specialty,
	// 		'geo_long' => $long,
	// 		'geo_lat'  => $lat,
	// 	)
	// );

	wp_update_user( array( 'ID' => $user_id ) );

	// save a values from user to custom fields in Dentists post type
	$field_key1 = 'field_58c7504d680bc';
	$value1 = $user->first_name;
	update_field( $field_key1, $value1, $create_dentist );

	$field_key2 = 'field_58c7505a680bd';
	$value2 = $user->last_name;
	update_field( $field_key2, $value2, $create_dentist );

	$field_key3 = 'field_58c75063680be';
	$value3 = $user->middle_name;
	update_field( $field_key3, $value3, $create_dentist );

	$field_key03 = 'field_58c75075680bf';
	$value03 = $user->degree;
	update_field( $field_key03, $value03, $create_dentist );

	$field_key4 = 'field_58c7509c680c1';
	$value4 = $user->bs_address;
	update_field( $field_key4, $value4, $create_dentist );

	$field_key5 = 'field_58c750f6680c2';
	$value5 = $user->bs_city;
	update_field( $field_key5, $value5, $create_dentist );

	$field_key6 = 'field_58c750fd680c3';
	$value6 = $user->bs_state;
	update_field( $field_key6, $value6, $create_dentist );

	$field_key7 = 'field_58c75105680c4';
	$value7 = $user->bs_zip;
	update_field( $field_key7, $value7, $create_dentist );

	$field_key8 = 'field_58c75113680c5';
	$value8 = $user->geo_longitude;
	update_field( $field_key8, $value8, $create_dentist );

	$field_key9 = 'field_58c75121680c6';
	$value9 = $user->geo_latitude;
	update_field( $field_key9, $value9, $create_dentist );

	$field_key10 = 'field_58c7512d680c7';
	$value10 = $user->company;
	update_field( $field_key10, $value10, $create_dentist );

	$field_key011 = 'field_58c75080680c0';
	$value011 = $user->user_email;
	update_field( $field_key011, $value011, $create_dentist);

	$field_key11 = 'field_58c75132680c8';
	$value11 = $user->phone;
	update_field( $field_key11, $value11, $create_dentist );

	$field_key12 = 'field_58c7513a680c9';
	$value12 = $user->fax;
	update_field( $field_key12, $value12, $create_dentist );

	$field_key13 = 'field_58c75141680ca';
	$value13 = $user->ada_number;
	update_field( $field_key13, $value13, $create_dentist );

	$field_key013 = 'field_58c7514d680cb';
	$value013 = $user->url;
	update_field( $field_key013, $value013, $create_dentist );

	$field_key14 = 'field_58c75154680cc';
	$value14 = $user->practice_type;
	update_field( $field_key14, $value14, $create_dentist );

	$field_key15 = 'field_58c7515c680cd';
	$value15 = $user->dental_school;
	update_field( $field_key15, $value15, $create_dentist );

	$field_key16 = 'field_58c75165680ce';
	$value16 = $user->dental_school_graduation_year;
	update_field( $field_key16, $value16, $create_dentist );

	$field_key17 = 'field_58c75170680cf';
	$value17 = $user->spec_school;
	update_field( $field_key17, $value17, $create_dentist );

	$field_key18 = 'field_58c75178680d0';
	$value18 = $user->spec_school_graduation_year;
	update_field( $field_key18, $value18, $create_dentist );

	$field_key19 = 'field_58c7518c680d1';
	$value19 = $user->retire_date;
	update_field( $field_key19, $value19, $create_dentist );

	//and if you want to store the post ids in
	//the user meta then simply use update_user_meta
	update_user_meta($user_id,'_dentist_post',$create_dentist);

}

add_action('profile_update','update_user_dentist_posts');
// add_action('is_iu_post_user_import','update_user_dentist_posts');
function update_user_dentist_posts($user_id){
	if ( !$user_id > 0 )
		return;

	$user = get_user_by('id', $user_id);
	$dentist_post_id = $user->_dentist_post;
	global $wpdb;

	// $table_name = $wpdb->prefix . 'dentist_search';

	// $charset_collate = $wpdb->get_charset_collate();
	// $sql = "CREATE TABLE $table_name (
	// 	id mediumint(9) NOT NULL AUTO_INCREMENT,
	// 	time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
	// 	-- dentist_id mediumint(9) NOT NULL,
	// 	name text NOT NULL,
	// 	city tinytext NOT NULL,
	// 	specialty text NOT NULL,
	// 	geo_long DECIMAL(10,7) NOT NULL,
	// 	geo_lat DECIMAL(10,7) NOT NULL,
	// 	PRIMARY KEY  (id)
	// ) $charset_collate;";
	//
	// require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
	// dbDelta( $sql );
	//
	// $name = $user->first_name . ' ' . $user->last_name . ', ' . $user->degree;
	// $city = $user->bs_city;
	// $specialty = $user->practice_type;
	// $long = $user->geo_longitude;
	// $lat = $user->geo_latitude;
	// $specialty_terms = explode(', ', $specialty );
	//
	// $wpdb->update(
	// 	$table_name,
	// 	array(
	// 		// 'dentist_id' => $dentist_post_id,
	// 		'name' => $name,
	// 		'city' => $city,
	// 		'specialty' => $specialty,
	// 		'geo_long' => $long,
	// 		'geo_lat'  => $lat,
	// 	),
	// 	array( 'dentist_id' => $dentist_post_id ),
	// 	array( '%s','%s','%s','%f','%f' ),
	// 	array( '%s' )
	// );

	// Create post object
	// $bs_create_dentist = array(
	// 	'post_type' => 'dentist',
	// 	'post_title' => $user->first_name . ' ' . $user->last_name . ', ' . $user->degree,
	// 	'post_status' => 'publish',
	// 	'post_author' => $user_id
	// );

	// Insert the post into the database
	//$create_dentist = wp_insert_post( $bs_create_dentist );
	$specialty_terms = explode(', ',$user->practice_type );

	//wp_set_object_terms( $create_dentist, $specialty_terms, 'specialty-cat' );

	// save a values from user to custom fields in Dentists post type
	$field_key1 = 'field_58c7504d680bc';
	$value1 = $user->first_name;
	update_field( $field_key1, $value1, $dentist_post_id );

	$field_key2 = 'field_58c7505a680bd';
	$value2 = $user->last_name;
	update_field( $field_key2, $value2, $dentist_post_id );

	$field_key3 = 'field_58c75063680be';
	$value3 = $user->middle_name;
	update_field( $field_key3, $value3, $dentist_post_id );

	$field_key03 = 'field_58c75075680bf';
	$value03 = $user->degree;
	update_field( $field_key03, $value03, $dentist_post_id );

	$field_key4 = 'field_58c7509c680c1';
	$value4 = $user->bs_address;
	update_field( $field_key4, $value4, $dentist_post_id );

	$field_key5 = 'field_58c750f6680c2';
	$value5 = $user->bs_city;
	update_field( $field_key5, $value5, $dentist_post_id );

	$field_key6 = 'field_58c750fd680c3';
	$value6 = $user->bs_state;
	update_field( $field_key6, $value6, $dentist_post_id );

	$field_key7 = 'field_58c75105680c4';
	$value7 = $user->bs_zip;
	update_field( $field_key7, $value7, $dentist_post_id );

	$field_key8 = 'field_58c75113680c5';
	$value8 = $user->geo_longitude;
	update_field( $field_key8, $value8, $dentist_post_id );

	$field_key9 = 'field_58c75121680c6';
	$value9 = $user->geo_latitude;
	update_field( $field_key9, $value9, $dentist_post_id );

	$field_key10 = 'field_58c7512d680c7';
	$value10 = $user->company;
	update_field( $field_key10, $value10, $dentist_post_id );

	$field_key011 = 'field_58c75080680c0';
	$value011 = $user->user_email;
	update_field( $field_key011, $value011, $dentist_post_id);

	$field_key11 = 'field_58c75132680c8';
	$value11 = $user->phone;
	update_field( $field_key11, $value11, $dentist_post_id );

	$field_key12 = 'field_58c7513a680c9';
	$value12 = $user->fax;
	update_field( $field_key12, $value12, $dentist_post_id );

	$field_key13 = 'field_58c75141680ca';
	$value13 = $user->ada_number;
	update_field( $field_key13, $value13, $dentist_post_id );

	$field_key013 = 'field_58c7514d680cb';
	$value013 = $user->url;
	update_field( $field_key013, $value013, $dentist_post_id );

	$field_key14 = 'field_58c75154680cc';
	$value14 = $user->practice_type;
	update_field( $field_key14, $value14, $dentist_post_id );

	$field_key15 = 'field_58c7515c680cd';
	$value15 = $user->dental_school;
	update_field( $field_key15, $value15, $dentist_post_id );

	$field_key16 = 'field_58c75165680ce';
	$value16 = $user->dental_school_graduation_year;
	update_field( $field_key16, $value16, $dentist_post_id );

	$field_key17 = 'field_58c75170680cf';
	$value17 = $user->spec_school;
	update_field( $field_key17, $value17, $dentist_post_id );

	$field_key18 = 'field_58c75178680d0';
	$value18 = $user->spec_school_graduation_year;
	update_field( $field_key18, $value18, $dentist_post_id );

	$field_key19 = 'field_58c7518c680d1';
	$value19 = $user->retire_date;
	update_field( $field_key19, $value19, $dentist_post_id );

	update_user_meta($user_id,'_dentist_post',$dentist_post_id);

}

add_action('delete_user','delete_user_posts');
function delete_user_posts($user_id) {
	global $wpdb;
	$user = get_user_by('id', $user_id);
	$user_post_id = $user->_dentist_post;
	//$table_name = $wpdb->prefix . 'dentist_search';

	wp_delete_post( $user_post_id, true);
	// $wpdb->delete( $table_name, array( 'dentist_id' => $user_post_id ) );
}

// ACF lat/long field data into a custom table for searching
function acf_google_maps_search_table_install() {

  global $wpdb;
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  $charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'acf_google_map_search_geodata';
  $sql = "CREATE TABLE $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    post_id BIGINT NULL UNIQUE,
    lat DECIMAL(9,6) NULL,
    lng DECIMAL(9,6) NULL,
    UNIQUE KEY id (id)
  ) {$charset_collate};";
  dbDelta( $sql );

	// now update historic post data
	$acf_gms = new acf_gms;
	$acf_gms->update_historic_post_gm_data();
}

// save post
add_action('acf/save_post', 'acf_google_maps_search_save_post', 20);
function acf_google_maps_search_save_post( $post_id ) {
  // bail early if no ACF data
  //if( empty($_POST['acf']) ) {
  //  return;
  //}
	$geo_lat = get_field( 'geo_latitude', $post_id );
	$geo_long = get_field( 'geo_longitude', $post_id );

	if( $geo_lat && $geo_long ){
		$acf_gms = new acf_gms;
		$data = [
			'post_id' => $post_id,
			'lng' => $geo_long,
			'lat' => $geo_lat,
		];
		$acf_gms->save( $data );
	}
}

// Get User Degree
function bs_qo_get_user_degree() {
  $author = get_queried_object();
  $user_id = $author->ID;
  $key = 'degree';
  $single = true;
	$degree = get_user_meta( $user_id, $key, $single );
  if( !empty($degree) ) {
	  return ', ' . $degree;
  }
}
// Get User ADA Number
function bs_qo_get_user_adanumber() {
  $author = get_queried_object();
  $user_id = $author->ID;
  $key = 'ada_number';
  $single = true;
	$adanumber = get_user_meta( $user_id, $key, $single );
  if( !empty($adanumber) ) {
	  return 'ADA#: ' . $adanumber;
  }
}
// Get User Practice Type
function bs_qo_get_user_practicetype() {
  $author = get_queried_object();
  $user_id = $author->ID;
  $key = 'practice_type';
  $single = true;
	$practicetype = get_user_meta( $user_id, $key, $single );
  if( !empty($practicetype) ) {
	  return $practicetype;
  }
}

// Get User Street Address
function bs_qo_get_user_address() {
  $author = get_queried_object();
  $user_id = $author->ID;
  $key = 'bs_address';
  $single = true;
	$address = get_user_meta( $user_id, $key, $single );
  if( !empty($address) ) {
	  return $address;
  }
}
// Get User City
function bs_qo_get_user_city() {
  $author = get_queried_object();
  $user_id = $author->ID;
  $key = 'bs_city';
  $single = true;
	$city = get_user_meta( $user_id, $key, $single );
  if( !empty($city) ) {
	  return $city;
  }
}
// Get User State
function bs_qo_get_user_state() {
  $author = get_queried_object();
  $user_id = $author->ID;
  $key = 'bs_state';
  $single = true;
	$state = get_user_meta( $user_id, $key, $single );
  if( !empty($state) ) {
	  return $state;
  }
}
// Get User Zip Code
function bs_qo_get_user_zipcode() {
  $author = get_queried_object();
  $user_id = $author->ID;
  $key = 'bs_zip';
  $single = true;
	$zipcode = get_user_meta( $user_id, $key, $single );
  if( !empty($zipcode) ) {
	  return $zipcode;
  }
}
