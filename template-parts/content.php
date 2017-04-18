<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */
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
?>

<div id="post-<?php the_ID(); ?>" <?php post_class('blogpost-entry all-posts-wrapper'); ?>>

	<article id="post-<?php the_ID(); ?>" <?php post_class('index-card'); ?>>
		<div class="entry-content <?php if( is_singular( 'dentist' ) ) { ?>DENTIST<?php } ?>">
			<?php if ( has_post_thumbnail() ) { ?>
			<div class="article-left blog-page-featured-image">
				<figure><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a></figure>
			</div>
			<?php } ?>
			<div class="blog-page-title-excerpt article-right <?php if ( !has_post_thumbnail() ) { ?>no-thumbnail<?php } ?>">
				<h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
				<?php if( $specialty_terms ) : ?>
					<p class="dentist-specialty">
					<?php foreach ($specialty_terms as $specialty_term) { ?>
						<span class="specialty-term"><?php echo $specialty_term->name; ?></span>
					<?php } ?>
				</p>
				<?php endif; ?>
				<?php if( !$d_ada ) : ?><p class="author-date post-meta"><span class="post-meta-date"><?php the_date('M j, Y'); ?></span></p><?php endif; ?>
				<?php if( $d_ada ) : ?>
				<div class="dentist-info">
<!--					<p class="d-ada-number">ADA #--><?php //echo $d_ada; ?><!--</p>-->
					<p class="d-address"><strong>Contact Information:</strong><br><?php echo $d_address; ?><br><?php echo $d_city; ?>, <?php echo $d_state; ?> <?php echo $d_zip; ?></p>
					<?php if( $d_phone ) { ?><p class="d-phone"><?php echo $d_phone; ?></p><?php } ?>
					<?php if( $d_email ) { ?><p class="d-email"><a href="mailto:<?php echo $d_email; ?>"><?php echo $d_email; ?></a></p><?php } ?>
				</div>
				<?php endif; ?>
				<div class="post-excerpt"><?php the_excerpt(); ?></div>
			</div>
		</div>
	</article>
</div>
