<?php

function risk_init() {
	register_taxonomy( 'risk', array( 'restaurant' ), array(
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
			'name'                       => __( 'Risks', 'inspection-importer' ),
			'singular_name'              => _x( 'Risk', 'taxonomy general name', 'inspection-importer' ),
			'search_items'               => __( 'Search risks', 'inspection-importer' ),
			'popular_items'              => __( 'Popular risks', 'inspection-importer' ),
			'all_items'                  => __( 'All risks', 'inspection-importer' ),
			'parent_item'                => __( 'Parent risk', 'inspection-importer' ),
			'parent_item_colon'          => __( 'Parent risk:', 'inspection-importer' ),
			'edit_item'                  => __( 'Edit risk', 'inspection-importer' ),
			'update_item'                => __( 'Update risk', 'inspection-importer' ),
			'add_new_item'               => __( 'New risk', 'inspection-importer' ),
			'new_item_name'              => __( 'New risk', 'inspection-importer' ),
			'separate_items_with_commas' => __( 'Risks separated by comma', 'inspection-importer' ),
			'add_or_remove_items'        => __( 'Add or remove risks', 'inspection-importer' ),
			'choose_from_most_used'      => __( 'Choose from the most used risks', 'inspection-importer' ),
			'not_found'                  => __( 'No risks found.', 'inspection-importer' ),
			'menu_name'                  => __( 'Risks', 'inspection-importer' ),
		),
		'show_in_rest'      => true,
		'rest_base'         => 'risk',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	) );

}
add_action( 'init', 'risk_init' );
