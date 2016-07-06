<?php

function disposition_init() {
	register_taxonomy( 'disposition', array( 'inspection' ), array(
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
			'name'                       => __( 'Dispositions', 'inspection-importer' ),
			'singular_name'              => _x( 'Disposition', 'taxonomy general name', 'inspection-importer' ),
			'search_items'               => __( 'Search Dispositions', 'inspection-importer' ),
			'popular_items'              => __( 'Popular Dispositions', 'inspection-importer' ),
			'all_items'                  => __( 'All Dispositions', 'inspection-importer' ),
			'parent_item'                => __( 'Parent Disposition', 'inspection-importer' ),
			'parent_item_colon'          => __( 'Parent Disposition:', 'inspection-importer' ),
			'edit_item'                  => __( 'Edit Disposition', 'inspection-importer' ),
			'update_item'                => __( 'Update Disposition', 'inspection-importer' ),
			'add_new_item'               => __( 'New Disposition', 'inspection-importer' ),
			'new_item_name'              => __( 'New Disposition', 'inspection-importer' ),
			'separate_items_with_commas' => __( 'Dispositions separated by comma', 'inspection-importer' ),
			'add_or_remove_items'        => __( 'Add or remove Dispositions', 'inspection-importer' ),
			'choose_from_most_used'      => __( 'Choose from the most used Dispositions', 'inspection-importer' ),
			'not_found'                  => __( 'No Dispositions found.', 'inspection-importer' ),
			'menu_name'                  => __( 'Dispositions', 'inspection-importer' ),
		),
		'show_in_rest'      => true,
		'rest_base'         => 'disposition',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	) );

}
add_action( 'init', 'disposition_init' );
