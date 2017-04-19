<?php
/**
 * The template for displaying search results pages.
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

get_header(); ?>

<div id="search-results" class="row">
	<div class="small-12 large-8 columns" role="main">

		<?php do_action( 'foundationpress_before_content' ); ?>

		<?php
			$terms = get_terms(['taxonomy' => 'specialty-cat', 'hide_empty' => false,]);
			$_name = $_GET['name'] != '' ? $_GET['name'] : '';
	    $_location = $_GET['location'] != '' ? $_GET['location'] : '';
	    $_specialty = $_GET['specialty-cat'] != '' ? $_GET['specialty-cat'] : '';
		?>
    <form id="bs-custom-search" role="search" method="get" action="<?php echo home_url( '/' ); ?>">
			<input type="hidden" name="search" value="dentist">
      <label for="name"><span class="screen-reader-text">Search by Last Name:</span>
				<input type="text" value="<?php echo $_name; ?>" name="name" id="name" placeholder="Search by Name" />
			</label>
			<label for="location"><span class="screen-reader-text">Search by City or Zip:</span>
				<input type="text" value="<?php echo $_location; ?>" name="location" id="location" placeholder="Search by City or Zip" />
			</label>
			<label for="specialty"><span class="screen-reader-text">Search by Specialty:</span>
				<select id="specialty" name="specialty-cat">
						<option value="">All Specialties</option>
					<?php foreach($terms as $term) : ?>
						<option value="<?php echo $term->name; ?>"><?php echo $term->name; ?></option>
					<?php endforeach; ?>
				</select>
			</label>
			<input type="hidden" value="dentist" name="post_type" />
			<!-- <input type="hidden" value="1" name="paged" /> -->
			<input type="hidden" value="1" name="sentence" />
      <input type="submit" id="searchsubmit" value="Search" />
    </form>

		<?php bs_more_post_ajax(); /* this function is in allonsy/library/bs-custom-functions.php */ ?>

		<?php /* AJAX request for more results is in allonsy/assets/javascript/frontend-ajax.js */ ?>

	<?php do_action( 'foundationpress_after_content' ); ?>

	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer();
