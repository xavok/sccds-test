	<?php
	  /* This template file arranges the header with the logo on the left, social
		icons on right, and menu beneath both of those */
		$search_position = get_theme_mod('search-position');
	?>

	<header id="masthead" class="site-header header-option-two <?php if( get_theme_mod( 'sticky-header' ) != '') { ?>sticky-header<?php } ?>" role="banner">
		<div class="title-bar" data-responsive-toggle="site-navigation">
			<div class="title-bar-title">
				<?php if ( function_exists( 'the_custom_logo' ) ) { the_custom_logo(); } ?>
			</div>
			<button class="menu-icon" type="button" data-toggle="mobile-menu"></button>
		</div>

		<nav id="site-navigation" class="main-navigation top-bar <?php if( $search_position == 'search-menu' ) { ?>has-search<?php } ?>" role="navigation">
			<div class="top-bar-left-right-wrapper">
				<div class="top-bar-left logo-wrapper hide-for-small-only">
					<?php if ( function_exists( 'the_custom_logo' ) ) { the_custom_logo(); } ?>
				</div>
				<div class="top-bar-right">
					<?php if( get_theme_mod('contact') || get_theme_mod('facebook') || get_theme_mod('twitter') || get_theme_mod('linkedin') || get_theme_mod('instagram') || get_theme_mod('youtube') || get_theme_mod('pinterest') || get_theme_mod('rss') || get_theme_mod('vimeo')) { ?>
					<div class="top-bar-social">
						<?php get_template_part('template-parts/social-media'); ?>
						<?php if( $search_position == 'search-above-menu' ) { ?>
						<div class="above-menu-search-wrapper">
							<?php get_search_form(); ?>
						</div>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ( ! get_theme_mod( 'wpt_mobile_menu_layout' ) || get_theme_mod( 'wpt_mobile_menu_layout' ) == 'topbar' ) : ?>
						<?php get_template_part( 'template-parts/mobile-top-bar' ); ?>
					<?php endif; ?>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="top-bar-bottom">
				<?php foundationpress_top_bar_r(); ?>
				<?php if( $search_position == 'search-menu' ) { ?>
				<div class="menu-search-wrapper">
					<button class="search-toggle"><i class="fa fa-search" aria-hidden="true"></i></button>
					<?php get_search_form(); ?>
				</div>
				<?php } ?>
			</div>
		</nav>
	</header>
