<?php
/**
 * The template for displaying the footer.
 *
 * Comtains closing divs for header.php.
 *
 * For more info: https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */
?>

<footer class="footer" role="contentinfo">

    <div class="inner-footer grid-container grid-x grid-padding-x">

        <div class="small-12 medium-4 large-4 cell">
			<?php dynamic_sidebar( 'footer1' ); ?>
        </div>

        <div class="small-12 medium-4 large-3 large-offset-1 cell">
            <h5 class="font-family-body text-color-white">
				<?= __( 'About Us', 'read-rec' ); ?>
            </h5>
			<?php joints_footer_nav(); ?>
        </div>

        <div class="small-12 medium-4 large-4 cell">
            <h5 class="font-family-body text-color-white">
				<?= __( 'Contact Us', 'read-rec' ); ?>
            </h5>
            <p>
                <small>
                    <i class="fal fa-map-marker-alt"></i>
                    <span class="text-color-medium-gray">509 Route 523, Whitehouse Station, NJ 08889</span>
                </small>
            </p>
            <p>
                <small>
                    <i class="fal fa-mobile-alt"></i>
                    <span class="text-color-medium-gray">(908) 534-9752</span>
                </small>
            </p>
            <p>
                <small>
                    <i class="far fa-fax"></i>
                    <span class="text-color-medium-gray">(908) 534-0038</span>
                </small>
            </p>

            <br>

            <h5 class="font-family-body text-color-white">
				<?= __( 'Office Hours', 'read-rec' ); ?>
            </h5>
            <p>
                <small>
                    <i class="fal fa-clock"></i>
                    <span class="text-color-medium-gray">9:00 am - 2:00 pm</span>
                </small>
            </p>
        </div>

    </div> <!-- end #inner-footer -->

    <div class="lower-footer grid-container grid-x grid-padding-x">

        <div class="small-12 medium-6 large-6 cell">
            <p class="source-org copyright text-color-medium-gray"><small>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>.</small></p>
        </div>

        <div class="small-12 medium-6 large-6 cell">
            <nav role="navigation">
				<?php joints_footer_links(); ?>
            </nav>
        </div>

    </div>

</footer> <!-- end .footer -->

</div>  <!-- end .off-canvas-content -->

</div> <!-- end .off-canvas-wrapper -->

<?php wp_footer(); ?>

</body>

</html> <!-- end page -->




