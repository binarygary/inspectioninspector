<?php

function visitid_init() {
	register_taxonomy( 'visitid', array( 'inspection' ), array(
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
			'name'                       => __( 'Visit Ids', 'inspection-importer' ),
			'singular_name'              => _x( 'Visit Id', 'taxonomy general name', 'inspection-importer' ),
			'search_items'               => __( 'Search Visit Ids', 'inspection-importer' ),
			'popular_items'              => __( 'Popular Visit Ids', 'inspection-importer' ),
			'all_items'                  => __( 'All Visit Ids', 'inspection-importer' ),
			'parent_item'                => __( 'Parent Visit Id', 'inspection-importer' ),
			'parent_item_colon'          => __( 'Parent Visit Id:', 'inspection-importer' ),
			'edit_item'                  => __( 'Edit Visit Id', 'inspection-importer' ),
			'update_item'                => __( 'Update Visit Id', 'inspection-importer' ),
			'add_new_item'               => __( 'New Visit Id', 'inspection-importer' ),
			'new_item_name'              => __( 'New Visit Id', 'inspection-importer' ),
			'separate_items_with_commas' => __( 'Visit Ids separated by comma', 'inspection-importer' ),
			'add_or_remove_items'        => __( 'Add or remove Visit Ids', 'inspection-importer' ),
			'choose_from_most_used'      => __( 'Choose from the most used Visit Ids', 'inspection-importer' ),
			'not_found'                  => __( 'No Visit Ids found.', 'inspection-importer' ),
			'menu_name'                  => __( 'Visit Ids', 'inspection-importer' ),
		),
		'show_in_rest'      => true,
		'rest_base'         => 'visitid',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	) );

}
add_action( 'init', 'visitid_init' );
