<?php
/**
 * The template part for displaying offcanvas content
 *
 * For more info: http://jointswp.com/docs/off-canvas-menu/
 */
?>

<div class="off-canvas position-right" id="off-canvas" data-off-canvas>
	<?php joints_off_canvas_nav(); ?>

    <div class="grid-x grid-padding-x">
		<?php if ( is_active_sidebar( 'offcanvas' ) ) : ?>
            <div class="cell">
				<?php dynamic_sidebar( 'offcanvas' ); ?>
            </div>
		<?php endif; ?>
        <div class="cell">
			<?php if ( is_user_logged_in() ) : ?>
                <a href="<?= get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ); ?>"
                   title="<?= __( 'My Account', 'woothemes' ); ?>"
                   class="button hollow"><?= __( 'My Account', 'woothemes' ); ?></a>
			<?php else : ?>
                <a href="<?= get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ); ?>"
                   title="<?= __( 'Login / Register', 'woothemes' ); ?>"
                   class="button hollow"><?= __( 'Login / Register', 'woothemes' ); ?></a>
			<?php endif; ?>
        </div>
        <div class="cell">
			<?= do_shortcode( "[social_icons_group id='" . get_field( 'header_social_icons_shortcode', 'option' ) . "']" ); ?>
        </div>
    </div>

</div>
