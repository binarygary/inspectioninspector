<?php

function visitnumber_init() {
	register_taxonomy( 'visitnumber', array( 'inspection' ), array(
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
			'name'                       => __( 'Visit Numbers', 'inspection-importer' ),
			'singular_name'              => _x( 'Visit Number', 'taxonomy general name', 'inspection-importer' ),
			'search_items'               => __( 'Search Visit Numbers', 'inspection-importer' ),
			'popular_items'              => __( 'Popular Visit Numbers', 'inspection-importer' ),
			'all_items'                  => __( 'All Visit Numbers', 'inspection-importer' ),
			'parent_item'                => __( 'Parent Visit Number', 'inspection-importer' ),
			'parent_item_colon'          => __( 'Parent Visit Number:', 'inspection-importer' ),
			'edit_item'                  => __( 'Edit Visit Number', 'inspection-importer' ),
			'update_item'                => __( 'Update Visit Number', 'inspection-importer' ),
			'add_new_item'               => __( 'New Visit Number', 'inspection-importer' ),
			'new_item_name'              => __( 'New Visit Number', 'inspection-importer' ),
			'separate_items_with_commas' => __( 'Visit Numbers separated by comma', 'inspection-importer' ),
			'add_or_remove_items'        => __( 'Add or remove Visit Numbers', 'inspection-importer' ),
			'choose_from_most_used'      => __( 'Choose from the most used Visit Numbers', 'inspection-importer' ),
			'not_found'                  => __( 'No Visit Numbers found.', 'inspection-importer' ),
			'menu_name'                  => __( 'Visit Numbers', 'inspection-importer' ),
		),
		'show_in_rest'      => true,
		'rest_base'         => 'visitnumber',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	) );

}
add_action( 'init', 'visitnumber_init' );
