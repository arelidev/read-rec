<?php

// Register the action for the Edit order screen.
add_filter( 'woocommerce_order_actions', 'tec_event_tickets_plus_wc_register_force_regenerate_attendees' );

// Register the bulk action for the Orders screen.
add_filter( 'bulk_actions-edit-shop_order', 'tec_event_tickets_plus_wc_register_force_regenerate_attendees' );

/**
 * Register the custom action to the list of order actions.
 *
 * @param array $actions List of order actions.
 *
 * @return array List of order actions with new action registered.
 */
function tec_event_tickets_plus_wc_register_force_regenerate_attendees( array $actions ) {
	$actions['tec_event_tickets_plus_wc_force_regenerate_attendees'] = __( 'Regenerate Attendees', 'event-tickets-plus' );

	return $actions;
}

/**
 * Handle regenerating of attendees for an order.
 *
 * @param Tribe__Tickets_Plus__Commerce__WooCommerce__Main $commerce_woo The Event Tickets Plus commerce provider for
 *                                                                       WooCommerce.
 * @param WC_Order $order The WooCommerce order object.
 */
function tec_event_tickets_plus_wc_force_regenerate_attendees_for_order( Tribe__Tickets_Plus__Commerce__WooCommerce__Main $commerce_woo, WC_Order $order ) {
	$order_id = $order->get_id();

	// Remove the flag from the order meta that indicates the attendee is already generated.
	update_post_meta( $order_id, '_tribe_has_tickets', 0 );

	$commerce_woo->generate_tickets( $order_id );

	$order->add_order_note( 'Force regenerated attendees' );
}

/**
 * Regenerate action for missing attendees
 *
 * @param $order WC_Order The WooCommerce order object.
 */
add_action( 'woocommerce_order_action_tec_event_tickets_plus_wc_force_regenerate_attendees', static function ( WC_Order $order ) {
	/** @var Tribe__Tickets_Plus__Commerce__WooCommerce__Main $commerce_woo */
	$commerce_woo = tribe( 'tickets-plus.commerce.woo' );

	tec_event_tickets_plus_wc_force_regenerate_attendees_for_order( $commerce_woo, $order );
} );

/**
 * Regenerate bulk action for missing attendees.
 *
 * @param string $redirect_to The URL to redirect to.
 * @param string $action The bulk action name that is running.
 * @param array $ids The list of Order ids.
 *
 * @return string The URL to redirect to.
 */
add_filter( 'handle_bulk_actions-edit-shop_order', static function ( $redirect_to, $action, $ids ) {
	if ( 'tec_event_tickets_plus_wc_force_regenerate_attendees' !== $action ) {
		return $redirect_to;
	}

	$ids = apply_filters( 'woocommerce_bulk_action_ids', array_reverse( array_map( 'absint', $ids ) ), $action, 'order' );

	if ( empty( $ids ) ) {
		return $redirect_to;
	}

	/** @var Tribe__Tickets_Plus__Commerce__WooCommerce__Main $commerce_woo */
	$commerce_woo = tribe( 'tickets-plus.commerce.woo' );

	$changed = 0;

	$report_action = 'tec_event_tickets_plus_wc_force_regenerated_attendees';

	foreach ( $ids as $id ) {
		$order = wc_get_order( $id );

		if ( ! $order ) {
			continue;
		}

		tec_event_tickets_plus_wc_force_regenerate_attendees_for_order( $commerce_woo, $order );

		$changed ++;
	}

	if ( $changed ) {
		$args = [
			'post_type'   => $commerce_woo->order_object,
			'bulk_action' => $report_action,
			'changed'     => $changed,
			'ids'         => implode( ',', $ids ),
		];

		$redirect_to = add_query_arg( $args, $redirect_to );
	}

	return $redirect_to;
}, 9, 3 );

/**
 * Handle the admin notice success message.
 */
add_action( 'admin_notices', static function () {
	global $post_type, $pagenow;

	// Bail out if not on shop order list page.
	if ( 'edit.php' !== $pagenow || 'shop_order' !== $post_type || ! isset( $_REQUEST['bulk_action'] ) ) { // WPCS: input var ok, CSRF ok.
		return;
	}

	$number      = isset( $_REQUEST['changed'] ) ? absint( $_REQUEST['changed'] ) : 0; // WPCS: input var ok, CSRF ok.
	$bulk_action = wc_clean( wp_unslash( $_REQUEST['bulk_action'] ) ); // WPCS: input var ok, CSRF ok.

	if ( 'tec_event_tickets_plus_wc_force_regenerated_attendees' !== $bulk_action ) {
		return;
	}

	/* translators: %d: orders count */
	$message = sprintf( _n( '%d order has had attendees regenerated.', '%d orders have had their attendees regenerated.', $number, 'event-tickets-plus' ), number_format_i18n( $number ) );
	echo '<div class="updated"><p>' . esc_html( $message ) . '</p></div>';
} );
