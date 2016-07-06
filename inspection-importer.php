<?php
/**
 * Plugin Name: Inspection Importer
 * Version: 0.0.1
 * Description: Downloads Daily Inspection Data
 * Author: Gary Kovar
 * Author URI: https://www.binarygary.com
 * Plugin URI: 
 * Text Domain: inspection-importer
 * Domain Path: /languages
 * @package Inspection Importer
 */

defined('ABSPATH') or die("No script kiddies please!");

//Include the import bootstrap functions and register cron related stuff
add_filter( 'cron_schedules', 'ii_add_times' );
include plugin_dir_path( __FILE__ ) . 'functions/ii_setup.php';
register_activation_hook( __FILE__ , 'ii_activation' );
register_deactivation_hook( __FILE__ , 'ii_deactivation' );

//CPT
include plugin_dir_path( __FILE__ ) . 'post-types/inspection.php';
include plugin_dir_path( __FILE__ ) . 'post-types/restaurant.php';
$scanned_directory = array_values( array_diff( scandir( __DIR__ . '/taxonomies/' ), array( '..', '.' ) ) );
foreach ( $scanned_directory as $file ) {
  include plugin_dir_path( __FILE__ ) . 'taxonomies/' .$file;
}

//Download the files
include plugin_dir_path( __FILE__ ) . 'functions/ii_download_inspections.php';
include plugin_dir_path( __FILE__ ) . 'functions/ii_download_restaurants.php';

//Parse the downloaded files
include plugin_dir_path( __FILE__ ) . 'functions/ii_google_places.php';
include plugin_dir_path( __FILE__ ) . 'functions/ii_parse.php';
include plugin_dir_path( __FILE__ ) . 'functions/ii_parse_inspections.php';

//Interface stuff
include plugin_dir_path( __FILE__ ) . 'functions/ii_admin_settings.php';


