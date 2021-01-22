<?php
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
		'Get %s'      => 'Register',
		'Get Tickets' => 'Register',
	];

	// If we don't have replacement text, bail.
	if ( empty( $ticket_text[ $text ] ) ) {
		return $translation;
	}

	return $ticket_text[ $text ];
}

add_filter( 'gettext_with_context', 'tribe_change_get_tickets', 20, 4 );

/**
 * @return string
 */
function filter_ticket_label_plural() {
	return 'Participants';
}

add_filter( 'tribe_get_ticket_label_plural', 'filter_ticket_label_plural' );

/**
 * @return string
 */
function filter_ticket_label_singular() {
	return 'Participant';
}

add_filter( 'tribe_get_ticket_label_singular', 'filter_ticket_label_singular' );

// Add page-attribute support of Events post type
add_post_type_support( 'tribe_events', 'page-attributes' );

add_filter( 'pre_get_posts', 'tribe_change_event_order' );
function tribe_change_event_order( $query ) {
	if ( tribe_is_list_view() ) :
		$query->set( 'orderby', 'menu_order' );
	endif;
}

// Add Order action
add_filter( 'woocommerce_order_actions', 'rt_add_regenerate_action_for_et' );
function rt_add_regenerate_action_for_et( $actions ) {
	$actions['tribe_force_regenerate_ticket'] = __( 'Regenerate Attendees' );

	return $actions;
}

/**
 * Regenerate action for missing attendees
 *
 * @param $order WC_Order
 */
add_action( 'woocommerce_order_action_tribe_force_regenerate_ticket', 'rt_regenerate_tickets_by_order' );
function rt_regenerate_tickets_by_order( $order ) {
	tribe( 'tickets-plus.commerce.woo' )->generate_tickets( $order->get_id() );

	$order->add_order_note( 'Force regenerated attendees' );
}


// Adding to admin order list bulk dropdown a custom action 'custom_downloads'
add_filter( 'bulk_actions-edit-shop_order', 'downloads_bulk_actions_edit_product', 20, 1 );
function downloads_bulk_actions_edit_product( $actions ) {
	$actions['regenerate_attendees'] = __( 'Regenerate Attendees' );

	return $actions;
}

// Make the action from selected orders
add_filter( 'handle_bulk_actions-edit-shop_order', 'downloads_handle_bulk_action_edit_shop_order', 10, 3 );
function downloads_handle_bulk_action_edit_shop_order( $redirect_to, $action, $post_ids ): string {
	if ( $action !== 'regenerate_attendees' ) {
		return $redirect_to;
	}

	$processed_ids = array();

	foreach ( $post_ids as $post_id ) {
		$order = wc_get_order( $post_id );
		tribe( 'tickets-plus.commerce.woo' )->generate_tickets( $order->get_id() );
		$order->add_order_note( 'Force regenerated attendees' );
		$processed_ids[] = $post_id;
	}

	return $redirect_to = add_query_arg( array(
		'regenerate_attendees' => '1',
		'processed_count'      => count( $processed_ids ),
		'processed_ids'        => implode( ',', $processed_ids ),
	), $redirect_to );
}

// The results notice from bulk action on orders
add_action( 'admin_notices', 'downloads_bulk_action_admin_notice' );
function downloads_bulk_action_admin_notice() {
	if ( empty( $_REQUEST['regenerate_attendees'] ) ) {
		return;
	} // Exit

	$count = intval( $_REQUEST['processed_count'] );

	printf( '<div id="message" class="updated fade"><p>' .
	        _n( 'Processed %s Order.',
		        'Processed %s Orders.',
		        $count,
		        'regenerate_attendees'
	        ) . '</p></div>', $count );
}
