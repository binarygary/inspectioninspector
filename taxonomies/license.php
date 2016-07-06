<?php

function license_init() {
	register_taxonomy( 'license', array( 'restaurant', 'inspection' ), array(
		'hierarchical'      => false,
		'public'            => false,
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
			'name'                       => __( 'Licenses', 'inspection-importer' ),
			'singular_name'              => _x( 'License', 'taxonomy general name', 'inspection-importer' ),
			'search_items'               => __( 'Search licenses', 'inspection-importer' ),
			'popular_items'              => __( 'Popular licenses', 'inspection-importer' ),
			'all_items'                  => __( 'All licenses', 'inspection-importer' ),
			'parent_item'                => __( 'Parent license', 'inspection-importer' ),
			'parent_item_colon'          => __( 'Parent license:', 'inspection-importer' ),
			'edit_item'                  => __( 'Edit license', 'inspection-importer' ),
			'update_item'                => __( 'Update license', 'inspection-importer' ),
			'add_new_item'               => __( 'New license', 'inspection-importer' ),
			'new_item_name'              => __( 'New license', 'inspection-importer' ),
			'separate_items_with_commas' => __( 'Licenses separated by comma', 'inspection-importer' ),
			'add_or_remove_items'        => __( 'Add or remove licenses', 'inspection-importer' ),
			'choose_from_most_used'      => __( 'Choose from the most used licenses', 'inspection-importer' ),
			'not_found'                  => __( 'No licenses found.', 'inspection-importer' ),
			'menu_name'                  => __( 'Licenses', 'inspection-importer' ),
		),
		'show_in_rest'      => true,
		'rest_base'         => 'license',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	) );

}
add_action( 'init', 'license_init' );
