<?php
/**
 * The template for displaying WooCommerce pages
 *
 * This is the template that displays all pages by default.
 */

get_header(); ?>

<div class="content">

	<div class="inner-content">

		<main class="main" role="main">

			<?php woocommerce_content(); ?>

		</main> <!-- end #main -->

	</div> <!-- end #inner-content -->

</div> <!-- end #content -->

<?php get_footer(); ?>
