<?php
/**
 * Author: Ole Fredrik Lie
 * URL: http://olefredrik.com
 *
 * FoundationPress functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

// function wpse_load_custom_search_template($template) {
//  if( isset($_REQUEST['search']) == 'dentist' ) {
//    $t = locate_template('search-dentist.php', false);
//    if( ! empty($t) ) $template = $t;
//  }
//  return $template;
// }
// add_action('init','wpse_load_custom_search_template');

function wpse_load_custom_search_template() {
  if( isset($_REQUEST['search']) == 'dentist' ) {
    require('search-dentist.php');
    die();
  }
}
add_action('init','wpse_load_custom_search_template');

/** Various clean up functions */
require_once( 'library/cleanup.php' );

/** Required for Foundation to work properly */
require_once( 'library/foundation.php' );

/** Register all navigation menus */
require_once( 'library/navigation.php' );

/** Add menu walkers for top-bar and off-canvas */
require_once( 'library/menu-walkers.php' );

/** Create widget areas in sidebar and footer */
require_once( 'library/widget-areas.php' );

/** Return entry meta information for posts */
require_once( 'library/entry-meta.php' );

/** Enqueue scripts */
require_once( 'library/enqueue-scripts.php' );

/** Add theme support */
require_once( 'library/theme-support.php' );

/** Add Nav Options to Customer */
require_once( 'library/custom-nav.php' );

/** Change WP's sticky post class */
require_once( 'library/sticky-posts.php' );

/** Configure responsive image sizes */
require_once( 'library/responsive-images.php' );

/** Custom Post Types */
require_once( 'library/bs-custom-post-types.php' );

/** Custom Functions - various shortcodes and other custom functions*/
require_once( 'library/bs-custom-functions.php' );

/** Customizer Additions */
require_once( 'library/bs-customizer-additions.php' );

/** Custom LearnDash Shortcodes */
require_once( 'library/bs-custom-shortcodes.php' );

/** Custom WP Jobs additions*/
require_once( 'library/bs-custom-jobs-functions.php' );

/** If your site requires protocol relative url's for theme assets, uncomment the line below */
// require_once( 'library/protocol-relative-theme-assets.php' );

// add_filter('pre_get_posts', 'query_post_type');
// function query_post_type($query) {
//   if ( is_archive() && (is_category() || is_tag()) && empty( $query->query_vars['suppress_filters'] ) ) {
//     $post_type = get_query_var('post_type');
// 	    if($post_type)
// 	      $post_type = $post_type;
// 	    else
// 	      $post_type = array('post','portfolio');
//         $query->set('post_type',$post_type);
// 	    return $query;
//     }
// }

function acf_set_featured_image( $value, $post_id, $field  ){

    if($value != ''){
	    //Add the value which is the image ID to the _thumbnail_id meta data for the current post
	    add_post_meta($post_id, '_thumbnail_id', $value);
    }

    return $value;
}

// acf/update_value/name={$field_name} - filter for a specific field based on it's name
//$thumb = get_field('bs_portfolio_thumbnail');
add_filter('acf/update_value/name=bs_portfolio_thumbnail', 'acf_set_featured_image', 10, 3);


add_filter( 'script_loader_tag', function ( $tag, $handle ) {

    if ( 'events-manager' !== $handle )
        return $tag;

    return str_replace( ' src', ' async src', $tag );
}, 10, 2 );

add_action('gform_after_submission_2', 'bs_custom_after_submission', 10, 2);
function bs_custom_after_submission() {
    $captcha_fail = true;
    if (isset($_POST['g-recaptcha-response'])) {
        $captcha = $_POST['g-recaptcha-response'];
        $secret = '6LecGSwUAAAAAIhTFMtGr6ZrFCN6zM41WKJGTGyK';
        $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']), true);
        if ($response['success'] != false) {
            $captcha_fail = false;
        }
    }
    if ($captcha_fail) {
        echo 'We are sorry, it looks like there was an error with your submission. Please use the back button on your browser and try again';
        return false;
    }
}