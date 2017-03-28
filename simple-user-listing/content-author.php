<?php
/**
 * The Template for displaying Author listings
 *
 * Override this template by copying it to yourtheme/authors/content-author.php
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $user;

$user_info = get_userdata( $user->ID );
$num_posts = count_user_posts( $user->ID );
?>
<div id="user-<?php echo $user->ID; ?>" class="author-block">
	<?php echo get_avatar( $user->ID, 90 ); ?>

	<h3><?php echo $user_info->first_name . ' ' . $user_info->last_name; ?><?php if( $user_info->degree ): echo ', ' . $user_info->degree; endif; ?></h3>
	<p><?php echo $user_info->user_email; ?><?php if( $user_info->url ): ?><br><a href="<?php echo $user_info->url; ?>" title="<?php echo $user_info->first_name . ' ' . $user_info->last_name; ?>'s website" target="_blank" rel="noopener"><?php echo $user_info->url; ?></a><?php endif; ?></p>
	<?php if( $user_info->description ): ?><p class="user-description"><?php echo $user_info->description; ?></p><?php endif; ?>
	<?php if( $user_info->ada_number ): ?><p class="ada-number"><strong>ADA Number:</strong> <?php echo $user_info->ada_number; ?></p><?php endif; ?>
	<?php if( $user_info->company ): ?><p><strong>Company:</strong> <?php echo $user_info->company; ?></p><?php endif; ?>
	<?php if( $user_info->address): ?><p class="address"><?php echo $user_info->address; ?><br><?php echo $user_info->city; ?>, <?php echo $user_info->state; ?><br><?php echo $user_info->zip; ?></p><?php endif; ?>
	<?php if( $user_info->phone ): ?><p><strong>Phone:</strong> <?php echo $user_info->phone; ?><?php if( $user_info->fax ): ?><br><strong>Fax:</strong> <?php echo $user_info->fax; ?><?php endif; ?></p><?php endif; ?>

</div>
