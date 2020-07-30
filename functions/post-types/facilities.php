<?php
// Register Custom Post Type
function facility_post_type() {

	$labels = array(
		'name'                  => _x( 'Facilities', 'Post Type General Name', 'read-rec' ),
		'singular_name'         => _x( 'Facility', 'Post Type Singular Name', 'read-rec' ),
		'menu_name'             => __( 'Facilities', 'read-rec' ),
		'name_admin_bar'        => __( 'Facility', 'read-rec' ),
		'archives'              => __( 'Facility Archives', 'read-rec' ),
		'attributes'            => __( 'Facilitym Attributes', 'read-rec' ),
		'parent_item_colon'     => __( 'Parent Facility:', 'read-rec' ),
		'all_items'             => __( 'All Facilities', 'read-rec' ),
		'add_new_item'          => __( 'Add New Facility', 'read-rec' ),
		'add_new'               => __( 'Add New', 'read-rec' ),
		'new_item'              => __( 'New Facility', 'read-rec' ),
		'edit_item'             => __( 'Edit Facility', 'read-rec' ),
		'update_item'           => __( 'Update Facility', 'read-rec' ),
		'view_item'             => __( 'View Facility', 'read-rec' ),
		'view_items'            => __( 'View Items', 'read-rec' ),
		'search_items'          => __( 'Search Facility', 'read-rec' ),
		'not_found'             => __( 'Not found', 'read-rec' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'read-rec' ),
		'featured_image'        => __( 'Featured Image', 'read-rec' ),
		'set_featured_image'    => __( 'Set featured image', 'read-rec' ),
		'remove_featured_image' => __( 'Remove featured image', 'read-rec' ),
		'use_featured_image'    => __( 'Use as featured image', 'read-rec' ),
		'insert_into_item'      => __( 'Insert into Facility', 'read-rec' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Facility', 'read-rec' ),
		'items_list'            => __( 'Facilities list', 'read-rec' ),
		'items_list_navigation' => __( 'Facilities list navigation', 'read-rec' ),
		'filter_items_list'     => __( 'Filter Facilities list', 'read-rec' ),
	);
	$args = array(
		'label'                 => __( 'Facility', 'read-rec' ),
		'description'           => __( 'Facilities post type', 'read-rec' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 20,
		'menu_icon'             => 'dashicons-location',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'facilities', $args );

}
add_action( 'init', 'facility_post_type', 0 );
