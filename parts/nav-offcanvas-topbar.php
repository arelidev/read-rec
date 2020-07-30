<?php
/**
 * The off-canvas menu uses the Off-Canvas Component
 *
 * For more info: http://jointswp.com/docs/off-canvas-menu/
 */
?>

<div class="grid-container grid-x grid-padding-x align-middle" id="top-bar-menu">
    <div class="shrink cell">
        <ul class="menu">
            <li>
				<?php if ( has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?>
				<?php else : ?>
                    <a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a>
				<?php endif; ?>
            </li>
        </ul>
    </div>
    <div class="auto cell show-for-medium">
		<?php joints_top_nav(); ?>
    </div>
    <div class="shrink cell show-for-large">
		<?= do_shortcode( "[social_icons_group id='" . get_field( 'header_social_icons_shortcode', 'option' ) . "']" ); ?>
    </div>
    <div class="shrink cell show-for-large">
	    <?php if ( is_user_logged_in() ) { ?>
            <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('My Account','woothemes'); ?>" class="button hollow"><?php _e('My Account','woothemes'); ?></a>
	    <?php }
	    else { ?>
            <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('Login / Register','woothemes'); ?>" class="button hollow"><?php _e('Login / Register','woothemes'); ?></a>
	    <?php } ?>
    </div>
    <div class="auto cell show-for-small-only">
        <ul class="menu">
            <!-- <li><button class="menu-icon" type="button" data-toggle="off-canvas"></button></li> -->
            <li><a data-toggle="off-canvas"><?php _e( 'Menu', 'jointswp' ); ?></a></li>
        </ul>
    </div>
</div>
