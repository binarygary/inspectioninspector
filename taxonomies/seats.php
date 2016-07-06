<?php

function seats_init() {
	register_taxonomy( 'seats', array( 'restaurant' ), array(
		'hierarchical'      => false,
		'public'            => true,
		'show_in_nav_menus' => true,
		'show_ui'           => true,
		'show_admin_column' => false,
		'query_var'         => true,
		'rewrite'           => true,
		'capabilities'      => array(
			'manage_terms'  => 'edit_posts',
			'edit_terms'    => 'edit_posts',
			'delete_terms'  => 'edit_posts',
			'assign_terms'  => 'edit_posts'
		),
		'labels'            => array(
			'name'                       => __( 'Seats', 'inspection-importer' ),
			'singular_name'              => _x( 'Seats', 'taxonomy general name', 'inspection-importer' ),
			'search_items'               => __( 'Search seats', 'inspection-importer' ),
			'popular_items'              => __( 'Popular seats', 'inspection-importer' ),
			'all_items'                  => __( 'All seats', 'inspection-importer' ),
			'parent_item'                => __( 'Parent seats', 'inspection-importer' ),
			'parent_item_colon'          => __( 'Parent seats:', 'inspection-importer' ),
			'edit_item'                  => __( 'Edit seats', 'inspection-importer' ),
			'update_item'                => __( 'Update seats', 'inspection-importer' ),
			'add_new_item'               => __( 'New seats', 'inspection-importer' ),
			'new_item_name'              => __( 'New seats', 'inspection-importer' ),
			'separate_items_with_commas' => __( 'Seats separated by comma', 'inspection-importer' ),
			'add_or_remove_items'        => __( 'Add or remove seats', 'inspection-importer' ),
			'choose_from_most_used'      => __( 'Choose from the most used seats', 'inspection-importer' ),
			'not_found'                  => __( 'No seats found.', 'inspection-importer' ),
			'menu_name'                  => __( 'Seats', 'inspection-importer' ),
		),
		'show_in_rest'      => true,
		'rest_base'         => 'seats',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	) );

}
add_action( 'init', 'seats_init' );
