<?php
// Register Custom Post Type
function media_post_type() {

	$labels = array(
		'name'                  => _x( 'Galleries', 'Post Type General Name', 'read-rec' ),
		'singular_name'         => _x( 'Gallery', 'Post Type Singular Name', 'read-rec' ),
		'menu_name'             => __( 'Galleries', 'read-rec' ),
		'name_admin_bar'        => __( 'Galleries', 'read-rec' ),
		'archives'              => __( 'Gallery Archives', 'read-rec' ),
		'attributes'            => __( 'Gallery Attributes', 'read-rec' ),
		'parent_item_colon'     => __( 'Parent Gallery:', 'read-rec' ),
		'all_items'             => __( 'All Galleries', 'read-rec' ),
		'add_new_item'          => __( 'Add New Gallery', 'read-rec' ),
		'add_new'               => __( 'Add New', 'read-rec' ),
		'new_item'              => __( 'New Gallery', 'read-rec' ),
		'edit_item'             => __( 'Edit Gallery', 'read-rec' ),
		'update_item'           => __( 'Update Gallery', 'read-rec' ),
		'view_item'             => __( 'View Gallery', 'read-rec' ),
		'view_items'            => __( 'View Galleries', 'read-rec' ),
		'search_items'          => __( 'Search Gallery', 'read-rec' ),
		'not_found'             => __( 'Not found', 'read-rec' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'read-rec' ),
		'featured_image'        => __( 'Featured Image', 'read-rec' ),
		'set_featured_image'    => __( 'Set featured image', 'read-rec' ),
		'remove_featured_image' => __( 'Remove featured image', 'read-rec' ),
		'use_featured_image'    => __( 'Use as featured image', 'read-rec' ),
		'insert_into_item'      => __( 'Insert into Gallery', 'read-rec' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Gallery', 'read-rec' ),
		'items_list'            => __( 'Galleries list', 'read-rec' ),
		'items_list_navigation' => __( 'Galleries list navigation', 'read-rec' ),
		'filter_items_list'     => __( 'Filter Galleries list', 'read-rec' ),
	);
	$args   = array(
		'label'               => __( 'Gallery', 'read-rec' ),
		'description'         => __( 'Media galleries', 'read-rec' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 20,
		'menu_icon'           => 'dashicons-images-alt2',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'rewrite'             => false,
		'capability_type'     => 'page',
	);
	register_post_type( 'galleries', $args );

}

add_action( 'init', 'media_post_type', 0 );
