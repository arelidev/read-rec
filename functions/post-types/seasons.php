<?php
// Register Custom Taxonomy
function tribe_events_season_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Seasons', 'Taxonomy General Name', 'read-rec' ),
		'singular_name'              => _x( 'Season', 'Taxonomy Singular Name', 'read-rec' ),
		'menu_name'                  => __( 'Seasons', 'read-rec' ),
		'all_items'                  => __( 'All Seasons', 'read-rec' ),
		'parent_item'                => __( 'Parent Season', 'read-rec' ),
		'parent_item_colon'          => __( 'Parent Season:', 'read-rec' ),
		'new_item_name'              => __( 'New Season Name', 'read-rec' ),
		'add_new_item'               => __( 'Add New Season', 'read-rec' ),
		'edit_item'                  => __( 'Edit Season', 'read-rec' ),
		'update_item'                => __( 'Update Season', 'read-rec' ),
		'view_item'                  => __( 'View Season', 'read-rec' ),
		'separate_items_with_commas' => __( 'Separate Seasons with commas', 'read-rec' ),
		'add_or_remove_items'        => __( 'Add or remove Seasons', 'read-rec' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'read-rec' ),
		'popular_items'              => __( 'Popular Seasons', 'read-rec' ),
		'search_items'               => __( 'Search Seasons', 'read-rec' ),
		'not_found'                  => __( 'Not Found', 'read-rec' ),
		'no_terms'                   => __( 'No Seasons', 'read-rec' ),
		'items_list'                 => __( 'Seasons list', 'read-rec' ),
		'items_list_navigation'      => __( 'Seasons list navigation', 'read-rec' ),
	);
	$args   = array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
	);
	register_taxonomy( 'tribe_events_seasons', array( 'tribe_events' ), $args );

}

add_action( 'init', 'tribe_events_season_taxonomy', 0 );
