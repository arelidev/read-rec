<?php
/**
 * HeaderSpacer Shortcode Widget
 *
 * @param $atts
 * @param null $content
 *
 * @return false|string
 */
function widget_header_spacer( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		'el_class' => ''
    ), $atts );

	ob_start();
	?>
	<div class="header-spacer <?= $atts['el_class']; ?>"></div>
	<?php
	return ob_get_clean();
}

add_shortcode( 'header_spacer', 'widget_header_spacer' );

// Integrate with Visual Composer
function header_spacer_integrateWithVC() {
	try {
		vc_map( array(
			"name"     => __( "Header Spacer", "read-rec" ),
			"base"     => "header_spacer",
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

add_action( 'vc_before_init', 'header_spacer_integrateWithVC' );
