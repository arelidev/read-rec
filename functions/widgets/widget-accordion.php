<?php
/**
 * Accordion Shortcode Widget
 *
 * @param $atts
 * @param null $content
 *
 * @return false|string
 */
function accordion_widget( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		'el_class' => ''
	), $atts );

	ob_start();
	?>
    <ul class="accordion accordion-widget <?= $atts['el_class']; ?>"
        data-accordion data-allow-all-closed="true" data-deep-link="true" data-deep-link-smudge="true">
		<?= do_shortcode( $content ); ?>
    </ul>
	<?php
	return ob_get_clean();
}

add_shortcode( 'accordion', 'accordion_widget' );

/**
 * Accordion Item
 *
 * @param $atts
 * @param $content
 */
function accordion_widget_item( $atts, $content ) {
	$atts = shortcode_atts( array(
		'el_class'  => '',
		'is_active' => false, // add class is-active
		'title'     => '',
	), $atts );

	$slug = vc_slugify( $atts['title'] );
	?>
    <li class="accordion-item accordion-item <?= $atts['el_class']; ?>" data-accordion-item>
        <a href="#<?= $slug; ?>" class="accordion-title text-color-black font-family-body"><b><?= $atts['title']; ?></b></a>
        <div class="accordion-content" data-tab-content id="<?= $slug; ?>">
			<?= do_shortcode( $content ); ?>
        </div>
    </li>
	<?php
}

add_shortcode( 'accordion_item', 'accordion_widget_item' );

// Integrate with Visual Composer
function accordion_integrateWithVC() {
	try {
		vc_map( array(
			"name"                    => __( "Accordion", "read-rec" ),
			"base"                    => "accordion",
			"as_parent"               => array( 'only' => 'accordion_item' ),
			"content_element"         => true,
			"show_settings_on_create" => false,
			"is_container"            => true,
			"category"                => __( "Custom", "steak-house" ),
			"params"                  => array(
				array(
					"type"        => "textfield",
					"heading"     => __( "Extra class name", "read-rec" ),
					"param_name"  => "el_class",
					"description" => __( "", "read-rec" )
				)
			),
			"js_view"                 => 'VcColumnView'
		) );

		vc_map( array(
			"name"            => __( "Accordion Item", "read-rec" ),
			"base"            => "accordion_item",
			"content_element" => true,
			"as_child"        => array( 'only' => 'accordion' ),
			"params"          => array(
				array(
					"type"        => "textfield",
					"heading"     => __( "Title", "read-rec" ),
					"param_name"  => "title",
					"holder"      => "h3",
					"description" => __( "", "read-rec" )
				),
				array(
					"type"        => "textarea_html",
					"class"       => "",
					"heading"     => __( "Content", "read-rec" ),
					"param_name"  => "content",
					"value"       => '',
					"description" => __( "Enter description.", "read-rec" )
				),
				array(
					"type"        => "textfield",
					"heading"     => __( "Extra class name", "read-rec" ),
					"param_name"  => "el_class",
					"description" => __( "", "read-rec" )
				)
			)
		) );

		if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
			class WPBakeryShortCode_Accordion extends WPBakeryShortCodesContainer {
			}
		}

		if ( class_exists( 'WPBakeryShortCode' ) ) {
			class WPBakeryShortCode_Accordion_Item extends WPBakeryShortCode {
			}
		}
	} catch ( Exception $e ) {
		echo 'Caught exception: ', $e->getMessage(), "\n";
	}
}

add_action( 'vc_before_init', 'accordion_integrateWithVC' );
