<?php
/**
 * The off-canvas menu uses the Off-Canvas Component
 *
 * For more info: http://jointswp.com/docs/off-canvas-menu/
 */

global $woocommerce;
?>

<div class="grid-container grid-x grid-padding-x align-middle" id="top-bar-menu">
    <div class="shrink cell">
        <ul class="menu">
            <li>
				<?php if ( has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?>
				<?php else : ?>
                    <a href="<?= home_url(); ?>"><?php bloginfo( 'name' ); ?></a>
				<?php endif; ?>
            </li>
        </ul>
    </div>
    <div class="auto cell show-for-large">
		<?php joints_top_nav(); ?>
    </div>
    <div class="shrink cell show-for-large">
        <ul class="menu">
            <li>
                <a href="https://www.facebook.com/ReadingtonRecreation/" class="text-color-white"><i class="fab fa-facebook-f fa-lg"></i></a>
            </li>
            <li>
                <a href="<?= wc_get_cart_url(); ?>" title="<?= __('View your shopping cart', 'woothemes'); ?>" class="text-color-white"><i class="far fa-shopping-cart fa-lg"></i></a>
            </li>
        </ul>
    </div>
    <div class="shrink cell show-for-large">
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
    <div class="auto cell hide-for-large">
        <ul class="menu align-right">
            <li>
                <button class="menu-icon
                <?= ( get_field( 'header_overlay_menu' ) == false || is_singular( 'facilities' ) == false ) ? 'dark' : ''; ?>"
                        type="button" data-toggle="off-canvas"></button>
            </li>
        </ul>
    </div>
</div>
