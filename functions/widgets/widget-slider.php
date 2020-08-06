<?php
/**
 * Slider Shortcode Widget
 *
 * @param $atts
 * @param null $content
 *
 * @return false|string
 */
function widget_slider( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		'slider'   => '',
		'el_class' => ''
	), $atts );

	ob_start();

	$args = array(
		'p'              => $atts['slider'],
		'post_type'      => 'sliders',
		'posts_per_page' => - 1
	);
	$loop = new WP_Query( $args );

	ob_start();
	?>
    <div class="widget-slider-wrapper">
        <div class="widget-slider-background">
            <div class="header-spacer"></div>
            <div class="grid-container">
                <div class="grid-x grid-padding-x">
                    <div class="cell">
						<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                            <div class="widget-slider">
								<?php if ( have_rows( 'slides' ) ): while ( have_rows( 'slides' ) ) : the_row(); ?>
                                    <div class="widget-slider-slide"
                                         data-background="<?php the_sub_field( 'background_image' ); ?>">
                                        <div class="grid-x grid-padding-x">
                                            <div class="small-12 medium-8 large-6 cell">
                                                <h1 class="widget-slider-slide-title"><?php the_sub_field( 'title' ); ?></h1>
                                                <div class="widget-slider-slide-content">
                                                    <?php the_sub_field( 'content' ); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
								<?php endwhile; endif; ?>
                            </div>
						<?php endwhile; ?>
                    </div>
                </div>

                <div class="grid-x grid-padding-x align-bottom">
                    <div class="small-12 medium-auto cell show-for-medium">
                        <div class="widget-slider-controls grid-x grid-padding-x">
							<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
								<?php if ( have_rows( 'slides' ) ): $i=0; while ( have_rows( 'slides' ) ) : the_row(); ?>
                                    <div class="widget-slider-control small-3 cell <?= ( $i == 0 ) ? "active" : ""; ?>" id="slide-control-<?= $i; ?>">
                                        <div class="grid-x">
                                            <div class="shrink cell">
                                                <div class="slide-number"><span><?= $i + 1; ?></span></div>
                                            </div>
                                            <div class="auto cell">
                                                <h5 class="widget-slider-control-title"><?php the_sub_field( 'thumbnail_title' ); ?></h5>
                                                <p class="widget-slider-control-subtitle"><?php the_sub_field( 'thumbnail_subtitle' ); ?></p>
                                            </div>
                                        </div>
                                    </div>
								<?php $i++; endwhile; endif; ?>
							<?php endwhile; ?>
                        </div>
                    </div>
                    <div class="small-6 medium-shrink cell text-center">
                        <button class="slick-prev-custom slick-custom widget-slider-nav-prev">
                            <i class="far fa-chevron-left fa-lg"></i>
                        </button>
                    </div>
                    <div class="small-6 medium-shrink cell text-center">
                        <button class="slick-next-custom slick-custom widget-slider-nav-next">
                            <i class="far fa-chevron-right fa-lg"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<?php
	wp_reset_postdata();

	return ob_get_clean();
}

add_shortcode( 'slider', 'widget_slider' );

// Integrate with Visual Composer
function slider_integrateWithVC() {
	try {
		$args = array( 'post_type' => 'sliders', 'posts_per_page' => - 1 );
		$loop = new WP_Query( $args );

		$sliders_array = array();
		// todo: this is breaking the single events loop
//		while ( $loop->have_posts() ) : $loop->the_post();
//			$sliders_array[ get_the_title() ] = get_the_ID();
//		endwhile;

		wp_reset_postdata();

		vc_map( array(
			"name"     => __( "Slider", "read-rec" ),
			"base"     => "slider",
			"class"    => "",
			"category" => __( "Custom", "read-rec" ),
			"params"   => array(
				array(
					'param_name'  => 'slider',
					'type'        => 'dropdown',
					'value'       => $sliders_array,
					'heading'     => __( 'Select slider:', 'read-rec' ),
					'description' => '',
					'class'       => ''
				),
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

add_action( 'vc_before_init', 'slider_integrateWithVC' );
