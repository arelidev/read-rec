<?php
/**
 * Announcements Shortcode Widget
 *
 * @param $atts
 * @param null $content
 *
 * @return false|string
 */
function widget_announcements( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		'el_class' => ''
	), $atts );

	ob_start();

	$args = array(
		'post_type'      => 'announcements',
		'posts_per_page' => - 1
	);
	$loop = new WP_Query( $args );
	?>
    <div class="widget-announcements <?= $atts['el_class']; ?>">
		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
            <div class="single-announcement grid-x">
                <div class="shrink cell">
                    <div class="single-announcement-date text-center">
						<div class="date-month text-color-white">
							<b><?= get_the_date( 'M', get_the_ID() ); ?></b>
                        </div>
                        <div class="date-day">
	                        <b><?= get_the_date( 'j', get_the_ID() ); ?></b>
                        </div>
                    </div>
                </div>
                <div class="auto cell">
                    <p class="single-announcement-title"><b><?php the_title(); ?></b></p>
                    <div class="single-announcement-content text-color-dark-gray">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
		<?php endwhile; ?>
    </div>
	<?php
	wp_reset_postdata();

	return ob_get_clean();
}

add_shortcode( 'announcements', 'widget_announcements' );

// Integrate with Visual Composer
function announcements_integrateWithVC() {
	try {
		vc_map( array(
			"name"     => __( "Announcements", "read-rec" ),
			"base"     => "announcements",
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

add_action( 'vc_before_init', 'announcements_integrateWithVC' );
