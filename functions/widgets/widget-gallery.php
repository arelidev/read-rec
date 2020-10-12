<?php
/**
 * Gallery Grid Shortcode Widget
 *
 * @param $atts
 * @param null $content
 *
 * @return false|string
 */
function widget_gallery_grid( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		'el_class' => ''
	), $atts );

	ob_start();

	$args = array(
		'post_type'      => 'galleries',
		'posts_per_page' => - 1
	);
	$loop = new WP_Query( $args );
	?>
    <div class="grid-x grid-margin-x grid-margin-y widget-gallery-grid align-center <?= $atts['el_class']; ?>">
		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
            <div class="small-6 medium-4 large-4 cell widget-gallery-grid-single-gallery">
                <div class="widget-gallery-grid-single-gallery-inner">
                    <a href="<?php the_post_thumbnail_url( 'full' ); ?>" data-fancybox="<?php the_ID(); ?>">
						<?php the_post_thumbnail( 'woocommerce_thumbnail' ); ?>
                        <div class="widget-gallery-grid-single-gallery-inner-title text-color-white text-right">
                            <b><?php the_title(); ?></b>
                        </div>
                    </a>
                    <div class="hide">
						<?php foreach ( get_field( 'images' ) as $image ) : ?>
                            <a href="<?= wp_get_attachment_image_url( $image, 'full' ); ?>"
                               data-fancybox="<?php the_ID(); ?>">
                                Image
                            </a>
						<?php endforeach; ?>
                    </div>
                </div>
            </div>
		<?php endwhile; ?>
    </div>
	<?php
	wp_reset_postdata();

	return ob_get_clean();
}

add_shortcode( 'gallery_grid', 'widget_gallery_grid' );

// Integrate with Visual Composer
function gallery_grid_integrateWithVC() {
	try {
		vc_map( array(
			"name"     => __( "Gallery Grid", "read-rec" ),
			"base"     => "gallery_grid",
			"class"    => "",
			"category" => __( "Custom", "read-rec" ),
			"params"   => array(
				array(
					"type"       => "textfield",
					"holder"     => "el_class",
					"class"      => "",
					"heading"    => __( "Extra Class", "read-rec" ),
					"param_name" => "el_class",
					// "value" => __( "<p>I am test text block. Click edit button to change this text.</p>", "read-rec" ),
					// "description" => __( "Description for foo param.", "read-rec" )
				),
			),
		) );
	} catch ( Exception $e ) {
		echo 'Caught exception: ', $e->getMessage(), "\n";
	}
}

add_action( 'vc_before_init', 'gallery_grid_integrateWithVC' );
