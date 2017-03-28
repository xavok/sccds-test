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
?>

<div id="post-<?php the_ID(); ?>" <?php post_class('blogpost-entry all-posts-wrapper'); ?>>

	<article id="post-<?php the_ID(); ?>" <?php post_class('index-card heeeeeey'); ?>>
		<div class="entry-content">
			<?php if ( has_post_thumbnail() ) { ?>
			<div class="article-left blog-page-featured-image">
				<figure><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a></figure>
			</div>
			<?php } ?>
			<div class="blog-page-title-excerpt article-right">
				<h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
				<p class="author-date post-meta"><span class="post-meta-date"><?php the_date('M j, Y'); ?></span></p>
				<div class="post-excerpt"><?php the_excerpt(); ?></div>
			</div>
		</div>
	</article>
</div>
