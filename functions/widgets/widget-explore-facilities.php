<?php
/**
 * Explore Facilities Shortcode Widget
 *
 * @param $atts
 * @param null $content
 *
 * @return false|string
 */
function widget_explore_facilities( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		'title'    => 'START EXPLORING',
		'el_class' => ''
	), $atts );

	ob_start();

	$args = array(
		'post_type'      => 'facilities',
		'posts_per_page' => - 1
	);
	$loop = new WP_Query( $args );
	?>
    <div class="widget-explore-facilities grid-x <?= $atts['el_class']; ?>">

        <div class="small-order-2 medium-order-1 small-12 medium-6 large-8 cell" id="facilities-main">
            <div class="explore-facilities-main-slider">
				<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                    <div class="explore-facilities-main-slider-slide"
                         style="background-image: url(<?= get_the_post_thumbnail_url( get_the_ID(), 'full' ); ?>">
                        <div class="explore-facilities-main-slider-slide-inner grid-x">
                            <div class="small-12 medium-6 large-6 cell grid-container">
                                <div class="grid-y grid-padding-y" style="height: 100%;">
                                    <div class="cell">
                                        <p class="explore-facilities-main-slider-slide-inner-title h1 text-color-white">
											<?php the_title(); ?>
                                        </p>
                                    </div>
                                    <div class="auto cell separator"></div>
                                    <div class="cell">
                                        <p class="explore-facilities-main-slider-slide-inner-address text-color-white">
                                            <i class="fas fa-dot-circle"></i> <?= get_field( 'facility_address' )['address'] ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="small-12 medium-6 large-6 cell">
                                <div class="facility-excerpt">
                                    <div class="facility-excerpt-inner">
										<?= apply_filters( 'the_content', get_field( 'facility_excerpt' ) ); ?>
                                        <a href="<?= get_permalink(); ?>" class="button hollow">
											<?= __( 'READ MORE', 'read-rec' ); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
				<?php endwhile; ?>
            </div>
        </div>
        <div class="small-order-1 medium-order-2 small-12 medium-6 large-4 cell explore-facilities-controls" data-sticky-container>
            <div class="sticky" data-sticky data-anchor="facilities-main">
                <h2 class="h1 text-right"><?= $atts['title']; ?></h2>
                <ul class="menu vertical text-right">
					<?php $i = 1; while ( $loop->have_posts() ) : $loop->the_post(); ?>
                        <li>
                            <a href="#" data-slide="<?= $i; ?>" class="<?= ( $i == 1 ) ? "active" : ""; ?>">
								<?php the_title(); ?> <span></span>
                            </a>
                        </li>
						<?php $i++; endwhile; ?>
                </ul>

                <img src="<?= get_template_directory_uri(); ?>/assets/images/hunterdon-county.svg" style="width: 100%;" class="show-for-large">
            </div>
        </div>
    </div>
	<?php
	wp_reset_postdata();

	return ob_get_clean();
}

add_shortcode( 'explore_facilities', 'widget_explore_facilities' );

// Integrate with Visual Composer
function explore_facilities_integrateWithVC() {
	try {
		vc_map( array(
			"name"     => __( "Explore Facilities", "read-rec" ),
			"base"     => "explore_facilities",
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

add_action( 'vc_before_init', 'explore_facilities_integrateWithVC' );
