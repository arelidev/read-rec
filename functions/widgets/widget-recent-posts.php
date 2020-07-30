<?php
/**
 * Recent Posts Shortcode Widget
 *
 * @param $atts
 * @param null $content
 *
 * @return false|string
 */
function widget_recent_posts( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		'el_class' => ''
	), $atts );

	ob_start();

	$args = array(
		'post_type'      => 'post',
		'posts_per_page' => 2
	);
	$loop = new WP_Query( $args );
	?>
    <div class="widget-recent-posts <?= $atts['el_class']; ?>">
		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
            <div class="single-recent-post grid-x grid-padding-x">
				<?php if ( has_post_thumbnail() ) : ?>
                    <div class="small-12 medium-6 large-6 cell">
                        <a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail( 'medium' ); ?>
                        </a>
                    </div>
				<?php endif; ?>
                <div class="small-12 medium-auto large-auto cell">
                    <div class="single-recent-post-meta">
                        <small>
                            <span class="categories"><?php the_category( "," ); ?></span>
                            <span class="separator"><i class="fas fa-circle"></i></span>
                            <span class="date text-color-medium-gray"><?= get_the_date( '', get_the_ID() ); ?></span>
                        </small>
                    </div>
                    <h5 class="single-recent-post-title font-family-body"><b><?php the_title(); ?></b></h5>
                    <div class="single-recent-post-excerpt text-color-dark-gray"><?php the_excerpt(); ?></div>
                    <a href="<?php the_permalink(); ?>" class="button hollow">
						<?= __( 'READ MORE', 'read-rec' ); ?>
                    </a>
                </div>
            </div>
		<?php endwhile; ?>
    </div>
	<?php
	wp_reset_postdata();

	return ob_get_clean();
}

add_shortcode( 'recent_posts', 'widget_recent_posts' );

// Integrate with Visual Composer
function recent_posts_integrateWithVC() {
	try {
		vc_map( array(
			"name"     => __( "Recent Posts", "read-rec" ),
			"base"     => "recent_posts",
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

add_action( 'vc_before_init', 'recent_posts_integrateWithVC' );
