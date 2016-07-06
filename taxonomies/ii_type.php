<?php

function ii_type_init() {
	register_taxonomy( 'ii_type', array( 'restaurant' ), array(
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
			'name'                       => __( 'Types', 'inspection-importer' ),
			'singular_name'              => _x( 'Type', 'taxonomy general name', 'inspection-importer' ),
			'search_items'               => __( 'Search Types', 'inspection-importer' ),
			'popular_items'              => __( 'Popular Types', 'inspection-importer' ),
			'all_items'                  => __( 'All Types', 'inspection-importer' ),
			'parent_item'                => __( 'Parent Type', 'inspection-importer' ),
			'parent_item_colon'          => __( 'Parent Type:', 'inspection-importer' ),
			'edit_item'                  => __( 'Edit Type', 'inspection-importer' ),
			'update_item'                => __( 'Update Type', 'inspection-importer' ),
			'add_new_item'               => __( 'New Type', 'inspection-importer' ),
			'new_item_name'              => __( 'New Type', 'inspection-importer' ),
			'separate_items_with_commas' => __( 'Types separated by comma', 'inspection-importer' ),
			'add_or_remove_items'        => __( 'Add or remove Types', 'inspection-importer' ),
			'choose_from_most_used'      => __( 'Choose from the most used Types', 'inspection-importer' ),
			'not_found'                  => __( 'No Types found.', 'inspection-importer' ),
			'menu_name'                  => __( 'Types', 'inspection-importer' ),
		),
		'show_in_rest'      => true,
		'rest_base'         => 'ii_type',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	) );

}
add_action( 'init', 'ii_type_init' );
