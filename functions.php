<?php
/**
 * For more info: https://developer.wordpress.org/themes/basics/theme-functions/
 *
 */

// TGM plugin activation
require_once( get_template_directory() . '/functions/tgm/tgm-init.php' );

// Theme support options
require_once( get_template_directory() . '/functions/theme-support.php' );

// WP Head and other cleanup functions
require_once( get_template_directory() . '/functions/cleanup.php' );

// Register scripts and stylesheets
require_once( get_template_directory() . '/functions/enqueue-scripts.php' );

// Register custom menus and menu walkers
require_once( get_template_directory() . '/functions/menu.php' );

// Register sidebars/widget areas
require_once( get_template_directory() . '/functions/sidebar.php' );

// Makes WordPress comments suck less
require_once( get_template_directory() . '/functions/comments.php' );

// Replace 'older/newer' post links with numbered navigation
require_once( get_template_directory() . '/functions/page-navi.php' );

// Adds support for multiple languages
require_once( get_template_directory() . '/functions/translation/translation.php' );

// Adds site styles to the WordPress editor
// require_once(get_template_directory().'/functions/editor-styles.php');

// Remove Emoji Support
// require_once(get_template_directory().'/functions/disable-emoji.php');

// Related post function - no need to rely on plugins
// require_once(get_template_directory().'/functions/related-posts.php');

// Use this as a template for custom post types
require_once( get_template_directory() . '/functions/custom-post-type.php' );

// Customize the WordPress login menu
// require_once(get_template_directory().'/functions/login.php');

// Customize the WordPress admin
// require_once(get_template_directory().'/functions/admin.php');

// Include all widget files dynamically
foreach ( scandir( get_template_directory() . '/functions/widgets/' ) as $filename ) {
	$path = get_template_directory() . '/functions/widgets/' . $filename;
	if ( is_file( $path ) ) {
		require_once $path;
	}
}

// ACF Pro theme options
if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page();
}

// Add Google Maps API Key for ACF Pro
function my_acf_init() {
	acf_update_setting( 'google_api_key', 'AIzaSyAD-IK4EX_Dq0gEx_FvIRJBfeCsAKOwW-A' );
}

add_action( 'acf/init', 'my_acf_init' );

// WooCommerce support
require_once( get_template_directory() . '/functions/woocommerce.php' );


/**
 * Change the Get Tickets on List View and Single Events
 *
 * @param string $translation The translated text.
 * @param string $text The text to translate.
 * @param string $domain The domain slug of the translated text.
 * @param string $context The option context string.
 *
 * @return string The translated text or the custom text.
 */
function tribe_change_get_tickets( $translation, $text, $context = "", $domain ) {

	if ( $domain != 'default' && strpos( $domain, 'event-' ) !== 0 ) {
		return $translation;
	}

	$ticket_text = [
		// Get Tickets on List View
		'Get %s'      => 'Register',
		// Get Tickets Form - Single View
		'Get Tickets' => 'Register',
	];

	// If we don't have replacement text, bail.
	if ( empty( $ticket_text[ $text ] ) ) {
		return $translation;
	}

	return $ticket_text[ $text ];
}

add_filter( 'gettext_with_context', 'tribe_change_get_tickets', 20, 4 );

function filter_ticket_label_plural() {
	return 'Participants';
}

add_filter( 'tribe_get_ticket_label_plural', 'filter_ticket_label_plural' );
