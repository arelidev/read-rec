<?php
/**
 * Event Categories Shortcode Widget
 *
 * @param $atts
 * @param null $content
 *
 * @return false|string
 */
function widget_event_categories( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		'el_class' => ''
	), $atts );

	ob_start();

	$categories = get_categories( array(
		'taxonomy'   => 'tribe_events_cat',
		'orderby'    => 'name',
		'order'      => 'ASC',
		'hide_empty' => true,
	) );
	?>
    <div class="grid-x widget-event-categories <?= $atts['el_class']; ?>">
		<?php foreach ( $categories as $category ) : ?>
            <div class="small-6 medium-4 large-3 cell widget-event-categories-single-category">
                <div class="widget-event-categories-single-category-inner">
                    <a href="<?= get_term_link( $category->term_id ); ?>">
						<?= wp_get_attachment_image( get_field( 'thumbnail', $category->taxonomy . '_' . $category->term_id ), 'event-category' ); ?>
                        <div class="widget-event-categories-single-category-inner-title text-color-white text-right">
                            <b><?= $category->name; ?></b>
                        </div>
                    </a>
                </div>
            </div>
		<?php endforeach; ?>
    </div>
	<?php
	wp_reset_postdata();

	return ob_get_clean();
}

add_shortcode( 'event_categories', 'widget_event_categories' );

// Integrate with Visual Composer
function event_categories_integrateWithVC() {
	try {
		vc_map( array(
			"name"     => __( "Event Categories", "read-rec" ),
			"base"     => "event_categories",
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

add_action( 'vc_before_init', 'event_categories_integrateWithVC' );
