<?php

function restaurant_init() {
	register_post_type( 'restaurant', array(
		'labels'                => array(
			'name'               => __( 'Restaurants', 'inspection-importer' ),
			'singular_name'      => __( 'Restaurant', 'inspection-importer' ),
			'all_items'          => __( 'All Restaurants', 'inspection-importer' ),
			'new_item'           => __( 'New Restaurant', 'inspection-importer' ),
			'add_new'            => __( 'Add New', 'inspection-importer' ),
			'add_new_item'       => __( 'Add New Restaurant', 'inspection-importer' ),
			'edit_item'          => __( 'Edit Restaurant', 'inspection-importer' ),
			'view_item'          => __( 'View Restaurant', 'inspection-importer' ),
			'search_items'       => __( 'Search Restaurants', 'inspection-importer' ),
			'not_found'          => __( 'No Restaurants found', 'inspection-importer' ),
			'not_found_in_trash' => __( 'No Restaurants found in trash', 'inspection-importer' ),
			'parent_item_colon'  => __( 'Parent Restaurant', 'inspection-importer' ),
			'menu_name'          => __( 'Restaurants', 'inspection-importer' ),
		),
		'public'                => true,
		'hierarchical'          => false,
		'show_ui'               => true,
		'show_in_nav_menus'     => true,
		'supports'              => array( 'title', 'editor' ),
		'has_archive'           => true,
		'rewrite'               => true,
		'query_var'             => true,
		'menu_icon'             => 'dashicons-admin-post',
		'show_in_rest'          => true,
		'rest_base'             => 'restaurant',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	) );

}

add_action( 'init', 'restaurant_init' );

function restaurant_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['restaurant'] = array(
		0  => '', // Unused. Messages start at index 1.
		1  => sprintf( __( 'Restaurant updated. <a target="_blank" href="%s">View Restaurant</a>', 'inspection-importer' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'inspection-importer' ),
		3  => __( 'Custom field deleted.', 'inspection-importer' ),
		4  => __( 'Restaurant updated.', 'inspection-importer' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Restaurant restored to revision from %s', 'inspection-importer' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6  => sprintf( __( 'Restaurant published. <a href="%s">View Restaurant</a>', 'inspection-importer' ), esc_url( $permalink ) ),
		7  => __( 'Restaurant saved.', 'inspection-importer' ),
		8  => sprintf( __( 'Restaurant submitted. <a target="_blank" href="%s">Preview Restaurant</a>', 'inspection-importer' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		9  => sprintf( __( 'Restaurant scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Restaurant</a>', 'inspection-importer' ),
			// translators: Publish box date format, see http://php.net/date
			date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		10 => sprintf( __( 'Restaurant draft updated. <a target="_blank" href="%s">Preview Restaurant</a>', 'inspection-importer' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}

add_filter( 'post_updated_messages', 'restaurant_updated_messages' );


add_filter( 'manage_edit-restaurant_columns', 'add_restaurant_columns' );
function add_restaurant_columns( $columns ) {
	$columns['seats'] = 'Seats';

	return $columns;
}

add_action( 'manage_restaurant_custom_column', 'restaurant_show_column' );
function restaurant_show_columng( $name ) {
	global $post;
	switch ( $name ) {
		case 'seats':
			if ( ! null == get_post_meta( $post->ID, 'seats', true ) ) {
				echo get_post_meta( $post->ID, 'seats', true );
			}
	}
}
