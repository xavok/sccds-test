<?php
$search_position = get_theme_mod('search-position');
$header_layout = get_theme_mod('header-layout');
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "container" div.
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

?>
<!doctype html>
<!--[if IE 9]>    <html class="no-js ie9 oldie" <?php language_attributes(); ?> "> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" <?php language_attributes(); ?> > <!--<![endif]-->
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
		<?php if( get_theme_mod('highlight_color')): ?>
		<meta name="theme-color" content="<?php echo esc_attr(get_theme_mod('highlight_color','default')); ?>">
		<?php endif; ?>
		<?php wp_head(); ?>
		<link rel="icon" sizes="192x192" href="<?php bloginfo('url'); ?>/wp-content/uploads/2016/08/favicon.png">
		<?php if( get_theme_mod('analytics')): ?><?php echo get_theme_mod('analytics','default'); ?><?php endif; ?>

	</head>
	<body <?php body_class(); ?>>
		<!-- <div id="preloader" style="position: fixed; left: 0; top: 0; z-index: 9999999; width: 100%; height: 100%; overflow: visible; background: #FFF;"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo-stacked-black.svg" width="600" class="preloader-logo"></div> -->
		<!-- <script>window.fbAsyncInit = function() { FB.init({ appId: '317466291976025', xfbml: true, version: 'v2.5' }); };
    (function(d, s, id){ var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id; js.src = "//connect.facebook.net/en_US/sdk.js"; fjs.parentNode.insertBefore(js, fjs); } (document, 'script', 'facebook-jssdk'));
    function fb_share() { FB.ui({ method: 'share', href: '<?php the_permalink(); ?>' },
        function(response) { if (response && !response.error_code) {
              // window.location = "http://imintohire.org/thank-you-for-sharing-on-facebook/"
            } else { } }); }
    </script>

    <div id="fb-root"></div>
    <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
    fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    <?php function customFShare() {
        $like_results = file_get_contents('http://graph.facebook.com/'. get_permalink());
        $like_array = json_decode($like_results, true);
        $like_count =  $like_array['shares'];
        return ($like_count ) ? $like_count : "0";
    } ?> -->

	<?php do_action( 'foundationpress_after_body' ); ?>

	<?php if ( get_theme_mod( 'wpt_mobile_menu_layout' ) == 'offcanvas' ) : ?>
	<div class="off-canvas-wrapper">
		<div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>
		<?php get_template_part( 'template-parts/mobile-off-canvas' ); ?>
	<?php endif; ?>

	<?php do_action( 'foundationpress_layout_start' ); ?>

	<?php
		if( $header_layout == 'menu-right') { get_template_part('template-parts/header_option_one'); }
		if( $header_layout == 'menu-bottom') { get_template_part('template-parts/header_option_two'); }
		if( $header_layout == 'menu-right-social-top') { get_template_part('template-parts/header_option_three'); }
	?>

	<section class="container">
		<?php do_action( 'foundationpress_after_header' );

		// $all_meta_for_user = get_user_meta( 1 ); print_r( $all_meta_for_user );
