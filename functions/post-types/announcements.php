<?php
// Register Custom Post Type
function announcements_post_type() {

	$labels = array(
		'name'                  => _x( 'Announcements', 'Post Type General Name', 'read-rec' ),
		'singular_name'         => _x( 'Announcement', 'Post Type Singular Name', 'read-rec' ),
		'menu_name'             => __( 'Announcements', 'read-rec' ),
		'name_admin_bar'        => __( 'Announcement', 'read-rec' ),
		'archives'              => __( 'Announcement Archives', 'read-rec' ),
		'attributes'            => __( 'Announcement Attributes', 'read-rec' ),
		'parent_item_colon'     => __( 'Parent Announcement:', 'read-rec' ),
		'all_items'             => __( 'All Announcements', 'read-rec' ),
		'add_new_item'          => __( 'Add New Announcement', 'read-rec' ),
		'add_new'               => __( 'Add New', 'read-rec' ),
		'new_item'              => __( 'New Announcement', 'read-rec' ),
		'edit_item'             => __( 'Edit Announcement', 'read-rec' ),
		'update_item'           => __( 'Update Announcement', 'read-rec' ),
		'view_item'             => __( 'View Announcement', 'read-rec' ),
		'view_items'            => __( 'View Announcements', 'read-rec' ),
		'search_items'          => __( 'Search Announcement', 'read-rec' ),
		'not_found'             => __( 'Not found', 'read-rec' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'read-rec' ),
		'featured_image'        => __( 'Featured Image', 'read-rec' ),
		'set_featured_image'    => __( 'Set featured image', 'read-rec' ),
		'remove_featured_image' => __( 'Remove featured image', 'read-rec' ),
		'use_featured_image'    => __( 'Use as featured image', 'read-rec' ),
		'insert_into_item'      => __( 'Insert into Announcement', 'read-rec' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Announcement', 'read-rec' ),
		'items_list'            => __( 'Announcements list', 'read-rec' ),
		'items_list_navigation' => __( 'Announcements list navigation', 'read-rec' ),
		'filter_items_list'     => __( 'Filter Announcements list', 'read-rec' ),
	);
	$args   = array(
		'label'               => __( 'Announcement', 'read-rec' ),
		'description'         => __( 'Announcements', 'read-rec' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 20,
		'menu_icon'           => 'dashicons-megaphone',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'rewrite'             => false,
		'capability_type'     => 'page',
	);
	register_post_type( 'announcements', $args );

}

add_action( 'init', 'announcements_post_type', 0 );
