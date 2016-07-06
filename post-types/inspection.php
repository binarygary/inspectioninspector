<?php

function inspection_init() {
	register_post_type( 'inspection', array(
		'labels'            => array(
			'name'                => __( 'Inspections', 'inspection-importer' ),
			'singular_name'       => __( 'Inspection', 'inspection-importer' ),
			'all_items'           => __( 'All Inspections', 'inspection-importer' ),
			'new_item'            => __( 'New Inspection', 'inspection-importer' ),
			'add_new'             => __( 'Add New', 'inspection-importer' ),
			'add_new_item'        => __( 'Add New Inspection', 'inspection-importer' ),
			'edit_item'           => __( 'Edit Inspection', 'inspection-importer' ),
			'view_item'           => __( 'View Inspection', 'inspection-importer' ),
			'search_items'        => __( 'Search Inspections', 'inspection-importer' ),
			'not_found'           => __( 'No Inspections found', 'inspection-importer' ),
			'not_found_in_trash'  => __( 'No Inspections found in trash', 'inspection-importer' ),
			'parent_item_colon'   => __( 'Parent Inspection', 'inspection-importer' ),
			'menu_name'           => __( 'Inspections', 'inspection-importer' ),
		),
		'public'            => true,
		'hierarchical'      => false,
		'show_ui'           => true,
		'show_in_nav_menus' => true,
		'supports'          => array( 'title', 'editor' ),
		'has_archive'       => true,
		'rewrite'           => true,
		'query_var'         => true,
		'menu_icon'         => 'dashicons-admin-post',
		'show_in_rest'      => true,
		'rest_base'         => 'inspection',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	) );

}
add_action( 'init', 'inspection_init' );

function inspection_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['inspection'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Inspection updated. <a target="_blank" href="%s">View Inspection</a>', 'inspection-importer'), esc_url( $permalink ) ),
		2 => __('Custom field updated.', 'inspection-importer'),
		3 => __('Custom field deleted.', 'inspection-importer'),
		4 => __('Inspection updated.', 'inspection-importer'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('Inspection restored to revision from %s', 'inspection-importer'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Inspection published. <a href="%s">View Inspection</a>', 'inspection-importer'), esc_url( $permalink ) ),
		7 => __('Inspection saved.', 'inspection-importer'),
		8 => sprintf( __('Inspection submitted. <a target="_blank" href="%s">Preview Inspection</a>', 'inspection-importer'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		9 => sprintf( __('Inspection scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Inspection</a>', 'inspection-importer'),
		// translators: Publish box date format, see http://php.net/date
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		10 => sprintf( __('Inspection draft updated. <a target="_blank" href="%s">Preview Inspection</a>', 'inspection-importer'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'inspection_updated_messages' );
