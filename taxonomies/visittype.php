<?php

function visittype_init() {
	register_taxonomy( 'visittype', array( 'inspection' ), array(
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
			'name'                       => __( 'Visit Types', 'inspection-importer' ),
			'singular_name'              => _x( 'Visit Type', 'taxonomy general name', 'inspection-importer' ),
			'search_items'               => __( 'Search Visit Types', 'inspection-importer' ),
			'popular_items'              => __( 'Popular Visit Types', 'inspection-importer' ),
			'all_items'                  => __( 'All Visit Types', 'inspection-importer' ),
			'parent_item'                => __( 'Parent Visit Type', 'inspection-importer' ),
			'parent_item_colon'          => __( 'Parent Visit Type:', 'inspection-importer' ),
			'edit_item'                  => __( 'Edit Visit Type', 'inspection-importer' ),
			'update_item'                => __( 'Update Visit Type', 'inspection-importer' ),
			'add_new_item'               => __( 'New Visit Type', 'inspection-importer' ),
			'new_item_name'              => __( 'New Visit Type', 'inspection-importer' ),
			'separate_items_with_commas' => __( 'Visit Types separated by comma', 'inspection-importer' ),
			'add_or_remove_items'        => __( 'Add or remove Visit Types', 'inspection-importer' ),
			'choose_from_most_used'      => __( 'Choose from the most used Visit Types', 'inspection-importer' ),
			'not_found'                  => __( 'No Visit Types found.', 'inspection-importer' ),
			'menu_name'                  => __( 'Visit Types', 'inspection-importer' ),
		),
		'show_in_rest'      => true,
		'rest_base'         => 'visittype',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	) );

}
add_action( 'init', 'visittype_init' );
