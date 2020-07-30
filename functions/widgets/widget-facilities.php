<?php
/**
 * Facilities Grid Shortcode Widget
 *
 * @param $atts
 * @param null $content
 *
 * @return false|string
 */
function widget_facilities_grid( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		'el_class' => ''
	), $atts );

	ob_start();

	$args = array(
		'post_type'      => 'facilities',
		'posts_per_page' => - 1
	);
	$loop = new WP_Query( $args );
	?>
    <div class="grid-x widget-event-categories <?= $atts['el_class']; ?>">
		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
            <div class="small-6 medium-4 large-3 cell widget-event-categories-single-category">
                <div class="widget-event-categories-single-category-inner">
                    <a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail( 'woocommerce_thumbnail' ); ?>
                        <div class="widget-event-categories-single-category-inner-title text-color-white text-right">
                            <b><?php the_title(); ?></b>
                        </div>
                    </a>
                </div>
            </div>
		<?php endwhile; ?>
    </div>
	<?php
	wp_reset_postdata();

	return ob_get_clean();
}

add_shortcode( 'facilities_grid', 'widget_facilities_grid' );

// Integrate with Visual Composer
function facilities_grid_integrateWithVC() {
	try {
		vc_map( array(
			"name"     => __( "Facilities Grid", "read-rec" ),
			"base"     => "facilities_grid",
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

add_action( 'vc_before_init', 'facilities_grid_integrateWithVC' );
