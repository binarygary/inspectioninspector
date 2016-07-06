<?php

function inspectionnumber_init() {
	register_taxonomy( 'inspectionnumber', array( 'inspection' ), array(
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
			'name'                       => __( 'Inspection Numbers', 'inspection-importer' ),
			'singular_name'              => _x( 'Inspection Number', 'taxonomy general name', 'inspection-importer' ),
			'search_items'               => __( 'Search Inspection Numbers', 'inspection-importer' ),
			'popular_items'              => __( 'Popular Inspection Numbers', 'inspection-importer' ),
			'all_items'                  => __( 'All Inspection Numbers', 'inspection-importer' ),
			'parent_item'                => __( 'Parent Inspection Number', 'inspection-importer' ),
			'parent_item_colon'          => __( 'Parent Inspection Number:', 'inspection-importer' ),
			'edit_item'                  => __( 'Edit Inspection Number', 'inspection-importer' ),
			'update_item'                => __( 'Update Inspection Number', 'inspection-importer' ),
			'add_new_item'               => __( 'New Inspection Number', 'inspection-importer' ),
			'new_item_name'              => __( 'New Inspection Number', 'inspection-importer' ),
			'separate_items_with_commas' => __( 'Inspection Numbers separated by comma', 'inspection-importer' ),
			'add_or_remove_items'        => __( 'Add or remove Inspection Numbers', 'inspection-importer' ),
			'choose_from_most_used'      => __( 'Choose from the most used Inspection Numbers', 'inspection-importer' ),
			'not_found'                  => __( 'No Inspection Numbers found.', 'inspection-importer' ),
			'menu_name'                  => __( 'Inspection Numbers', 'inspection-importer' ),
		),
		'show_in_rest'      => true,
		'rest_base'         => 'inspectionnumber',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	) );

}
add_action( 'init', 'inspectionnumber_init' );
