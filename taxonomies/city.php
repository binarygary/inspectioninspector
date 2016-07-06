<?php

function city_init() {
	register_taxonomy( 'city', array( 'restaurant' ), array(
		'hierarchical'      => false,
		'public'            => true,
		'show_in_nav_menus' => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => true,
		'capabilities'      => array(
			'manage_terms'  => 'edit_posts',
			'edit_terms'    => 'edit_posts',
			'delete_terms'  => 'edit_posts',
			'assign_terms'  => 'edit_posts'
		),
		'labels'            => array(
			'name'                       => __( 'Cities', 'inspection-importer' ),
			'singular_name'              => _x( 'City', 'taxonomy general name', 'inspection-importer' ),
			'search_items'               => __( 'Search Cities', 'inspection-importer' ),
			'popular_items'              => __( 'Popular Cities', 'inspection-importer' ),
			'all_items'                  => __( 'All Cities', 'inspection-importer' ),
			'parent_item'                => __( 'Parent City', 'inspection-importer' ),
			'parent_item_colon'          => __( 'Parent City:', 'inspection-importer' ),
			'edit_item'                  => __( 'Edit City', 'inspection-importer' ),
			'update_item'                => __( 'Update City', 'inspection-importer' ),
			'add_new_item'               => __( 'New City', 'inspection-importer' ),
			'new_item_name'              => __( 'New City', 'inspection-importer' ),
			'separate_items_with_commas' => __( 'Cities separated by comma', 'inspection-importer' ),
			'add_or_remove_items'        => __( 'Add or remove Cities', 'inspection-importer' ),
			'choose_from_most_used'      => __( 'Choose from the most used Cities', 'inspection-importer' ),
			'not_found'                  => __( 'No Cities found.', 'inspection-importer' ),
			'menu_name'                  => __( 'Cities', 'inspection-importer' ),
		),
		'show_in_rest'      => true,
		'rest_base'         => 'city',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	) );

}
add_action( 'init', 'city_init' );
