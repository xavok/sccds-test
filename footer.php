<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "off-canvas-wrap" div and all content after.
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

?>

		</section>
		<div id="footer-container">
			<footer id="footer">
				<?php do_action( 'foundationpress_before_footer' ); ?>
				<?php dynamic_sidebar( 'footer-widgets' ); ?>
				<?php do_action( 'foundationpress_after_footer' ); ?>
			</footer>
		</div>
		<div id="copyright-container">
			<footer id="copyright" <?php if( get_theme_mod('social-copyright') != '' ) { ?>class="has-social"<?php } ?>>
				<?php if( get_theme_mod('social-copyright') != '') { ?><div class="small-12 large-9"><?php } ?>
				<?php if( get_theme_mod('copyright')): ?>
					<p>&copy; <?php echo date('Y'); ?> <?php echo get_theme_mod('copyright','default'); ?></p>
				<?php else: ?>
					<p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
				<?php endif; ?>
				<?php if( get_theme_mod('social-copyright') != '' ) { ?></div><div class="small-12 large-3"><?php echo do_shortcode('[bs_social_urls]');?></div><?php } ?>
			</footer>
		</div>
		<div id="back-top">
  		<a href="#" title="Back to top"><i class="fa fa-chevron-up"></i></a>
		</div>

		<?php do_action( 'foundationpress_layout_end' ); ?>

<?php if ( get_theme_mod( 'wpt_mobile_menu_layout' ) == 'offcanvas' ) : ?>
		</div><!-- Close off-canvas wrapper inner -->
	</div><!-- Close off-canvas wrapper -->
</div><!-- Close off-canvas content wrapper -->
<?php endif; ?>


<?php wp_footer(); ?>

<script type="text/javascript">

	var windowWidth;
	var headerHeight;
	var topScrollOffset;
	var windowWidth = jQuery(window).width();
	var headerHeight = jQuery('#masthead').height();
	if(windowWidth > 640) {

	}

	$(window).resizeend(function() {
		if ($(window).width() > 639) {
			$('.js-off-canvas-exit.is-visible').click();
		}
	});

	jQuery(document).ready(function($) {

		$('table#ee_filter_table, table.tkt-slctr-tbl').wrap('<div class="rwd-table-wrap"></div>');
		if ($(window).width() < 480) {
			$('.rwd-table-wrap').before('<p class="table-wrap-notice">Scroll left/right to view the entire list of events</p>');
			$('.rwd-table-wrap').after('<p class="table-wrap-notice">Scroll left/right to view the entire list of events</p>');
		}

		// Filebase toggle buttons
		$('li.tab-name a').click(function() {
			$('li.bs-tab a.active').removeClass('active');
			$(this).addClass('active');
			$('div.tab-content.show').removeClass('show');
			$('div.tab-content-name').addClass('show');
		});
		$('li.tab-date a').click(function() {
			$('li.bs-tab a.active').removeClass('active');
			$(this).addClass('active');
			$('div.tab-content.show').removeClass('show');
			$('div.tab-content-date').addClass('show');
		});

		// $('label > [type="checkbox"], label > [type="radio"]').click(function() {
		// 	// $('label.is-checked').not(this).removeClass('is-checked');
		// 	$(this).parents('label').toggleClass('is-checked');
		// });

		// Show/Hide Search Form
		$('nav.top-bar.has-search button.search-toggle').click(function() {
			$('nav.top-bar.has-search .menu-search-wrapper form#searchform').toggleClass('show');
		});
		$('ul.social-media-wrapper.has-search button.search-toggle').click(function() {
			$('ul.social-media-wrapper.has-search .menu-search-wrapper form#searchform').toggleClass('show');
		});

    $('.learndash p:contains("Quiz"), .learndash span:contains("Quiz")').html(function(_, html) {
      return  html.replace(/(Quiz)/g, 'Keyword');
    });
		$('.learndash p:contains("quiz"), .learndash span:contains("quiz")').html(function(_, html) {
      return  html.replace(/(quiz)/g, 'keyword');
    });

		// $('input[type="checkbox"]').click(function() {
		// 	var inputID = $(this).attr('id');
		//  	$('label[for="' + inputID + '"]').toggleClass('checked');
		// });
		$('ul.project-filters li.projects a').click(function() {
			$('#projects-list').addClass('show-filters');
			$('body').addClass('filters-open');
			$('input#impact-all').click();
			return false;
		});
		$('.close-project-filters a').click(function() {
			$('#projects-list.show-filters').removeClass('show-filters');
			$('body').removeClass('filters-open');
			return false;
		});
		$heightOnLoad = $('#home-hero-wrapper').height();
		// console.log($heightOnLoad);
		$(window).resize(function() {
			$('body.mobile #home-hero-wrapper').css({'min-height':$heightOnLoad});
		});
	});

	jQuery(document).ready(function($) {
		$('#preloader img').delay(10).show();
		$('.home #video-iframe-1').delay(500).load(function() {

			// Site Preloader
			$('#preloader').addClass('loaded')
			// $('#preloader img').fadeIn('fast');
			// $('#preloader .spinner').addClass('loaded');
			// $('#preloader img').addClass('loaded');
			$('#preloader.loaded').delay(250).fadeOut(1000, function() {
				$(this).hide();
			});
		});

		$(window).imagesLoaded(function() {

			// Site Preloader
			$('#preloader').addClass('loaded')
			$('#preloader.loaded').delay(250).fadeOut(1000, function() {
				$(this).hide();
			});

		});

	  // Back to top script
	  $('#back-top').hide();
	  $(function () {
	    $(window).scroll(function () {
	      if ($(this).scrollTop() > 800) {
	        $('#back-top').fadeIn();
	      } else {
	        $('#back-top').fadeOut();
	      }
	    });
			if($('body').hasClass('mobile')) {
				// do nothing
			} else {
		    $('#back-top a').click(function () {
		      $('body,html').animate({ scrollTop: '0px' }, 'slow');
		      return false;
		    });
			}
	  });

		// jQuery(function($) {
		// 	// Scroll to hash on click
		//   $('a[href*="#"]:not([href="#"].scroll-to-id)').click(function() {
		//     // if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
		//       var target = $(this.hash);
		// 			console.log(target);
		//       target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
		//       if (target.length) {
		//         $('html, body').animate({
		//           scrollTop: target.offset().top
		//         }, 1000);
		//         return false;
		//       }
		//     // }
		//   });
		//
		// });

		// Float Labels
		function floatLabel(inputType) {
			$(inputType).each(function(){
					var $this = $(this);
					$this.focus(function(){
						$this.closest('li.gfield').find('label').attr("data-attr","active");
					});
					$this.blur(function(){
						if($this.val() === '' || $this.val() === 'blank'){
							$this.closest('li.gfield').find('label').attr("data-attr","");
						}
					});
			});
		}
		floatLabel(".floatLabel input");
		floatLabel(".floatLabel textarea");

	});

	// Masonry Layout for Portfolio, Blog Posts, and Events
	(function ($) {
		var $container = $('.bs-isotope');
		$container.imagesLoaded(function() {
			$container.isotope({
				itemSelector: '.bs-isotope-item',
				layoutMode: 'masonry'
			});
			$container.isotope('layout').isotope();
		});
		$(window).trigger('resize');
	}(jQuery));


	// Lazy Load with Isotope/Masonry Layout
	$('.lazy-isotope-wrapper').each(function(){

		var $isotope = $('.lazy-isotope', this);

		$isotope.isotope({
			itemSelector: '.bs-isotope-item',
			layoutMode: 'masonry'
		});

	  $isotope[0].addEventListener('load', (function(){
	    var runs;
	    var update = function(){
	      $isotope.isotope('layout');
	      runs = false;
	    };
	    return function(){
	      if(!runs){
	        runs = true;
	        setTimeout(update, 33);
	      }
	    };
	  }()), true);

	});


	// Isotope Filters for Portfolio
	jQuery(document).ready(function($) {
		// cache container
		var $container = $('.portfolio-container');
		// filter items when filter link is clicked
		$('#filters a').click(function(){
		  var selector = $(this).attr('data-filter');
		  $container.isotope({ filter: selector });
			$('#filters a.active').not(this).removeClass('active');
			$(this).addClass('active');
		  return false;
		});
		$('.title-bar .menu-icon').click(function() {
			$('body').toggleClass('off-canvas-open');
		});
		jQuery('.portfolio-filter-toggle a').click(function() {
			$('#filters').slideToggle('fast');
			return false;
		});
	});

	// initiating the isotope page
	jQuery(window).load(function($) {

	    // Store # parameter and add "." before hash
	    var hashID = "." + window.location.hash.substring(1);

	    //  the current version of isotope, the hack works in v2 also
	    var $container = jQuery('.portfolio-container');

	    $container.imagesLoaded(function(){
	        $container.isotope({
	            itemSelector: ".single-portfolio-item",
	            filter: hashID, // the variable filter hack
	        });
					jQuery('#filters a.active').removeClass('active');
					jQuery('#filters a[data-filter="' + hashID + '"]').addClass('active');
	    });

	});

	// jQuery(function($) {
	// 	// Scroll to hash on click
	//   $('a[href*="#"]:not([href="#"])').click(function() {
	//     if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
	//       var target = $(this.hash);
	// 			console.log(target);
	//       target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
	//       if (target.length) {
	//         $('html, body').animate({
	//           scrollTop: target.offset().top - topScrollOffset
	//         }, 1000);
	//         return false;
	//       }
	//     }
	//   });
	//
	// });
	<?php if( get_theme_mod( 'sticky-header' ) != '') { ?>
	// Sticky Header Classie script
	function init() {
		window.addEventListener('scroll', function(e){
      var distanceY = window.pageYOffset || document.documentElement.scrollTop,
        stickPrep = jQuery('#masthead').height() + 35,
        header = document.querySelector("body");
      if (distanceY > stickPrep) {
        classie.add(header,"sticky-prep");

      } else {
        if (classie.has(header,"sticky-prep")) {
          classie.remove(header,"sticky-prep");
        }
      }
  	});
    window.addEventListener('scroll', function(e){
      var distanceY = window.pageYOffset || document.documentElement.scrollTop,
        stickOn = jQuery('#masthead').height() + jQuery('.top-bar-bottom').height(),
        header = document.querySelector("body");
      if (distanceY > stickOn) {
        classie.add(header,"sticky-header");

      } else {
        if (classie.has(header,"sticky-header")) {
          classie.remove(header,"sticky-header");
        }
      }
  	});
	}
	window.onload = init();
	<?php } ?>
	$('.bs-carousel').slick({
	  dots: false,
	  infinite: false,
	  speed: 300,
	  slidesToShow: 3,
	  slidesToScroll: 1,
		arrows: true,
		prevArrow: '<button aria-hidden="true" role="presentation" type="button" class="slick-prev"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/prev-arrow.svg" alt="Previous Arrow" width="20" /></button>',
		nextArrow: '<button aria-hidden="true" role="presentation" type="button" class="slick-next"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/next-arrow.svg" alt="Next Arrow" width="20" /></button>',
	  responsive: [{
      breakpoint: 1024,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1,
        infinite: true,
      }
    },{
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    },{
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }]
	});

	$('.portfolio-gallery').slick({
	  dots: true,
	  infinite: true,
	  speed: 300,
	  slidesToShow: 1,
	  slidesToScroll: 1,
		arrows: false
	});

	;( function( $ ) {
		$( '.swipebox, .thickbox, .enlarge, .fbPhoto' ).swipebox( {
			useCSS : true, // false will force the use of jQuery for animations
			useSVG : true, // false to force the use of png for buttons
			initialIndexOnArray : 0, // which image index to init when a array is passed
			hideCloseButtonOnMobile : false, // true will hide the close button on mobile devices
			removeBarsOnMobile : true, // false will show top bar on mobile devices
			hideBarsDelay : 3000000, // delay before hiding bars on desktop
			videoMaxWidth : 1140, // videos max width
			beforeOpen: function() {}, // called before opening
			afterOpen: null, // called after opening
			afterClose: function() {}, // called after closing
			loopAtEnd: false // true will return to the first image after the last image is reached
		} );
	} )( jQuery );

	//Light header switch Waypoint script
	shrinkOn = jQuery('#masthead').height() * 2;

	// var sharewaypoint = new Waypoint({
	// 	element: document.getElementById('toggle-reverse'),
	// 	handler: function(direction) {
	// 		jQuery('#masthead').toggleClass('reverse-header');
	// 		jQuery('.down-arrow').removeClass('animated');
	// 	},
	// 	offset: shrinkOn
	// });

</script>

<?php do_action( 'foundationpress_before_closing_body' ); ?>
<script id="__bs_script__">//<![CDATA[document.write("<script async src='http://HOST:3000/browser-sync/browser-sync-client.2.12.3.js'><\/script>".replace("HOST", location.hostname));
//]]></script>
</body>
</html>
