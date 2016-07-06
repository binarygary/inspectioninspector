<?php
defined('ABSPATH') or die("No script kiddies please!");

add_action( 'ii_download', 'ii_download_inspection_files' );
add_action( 'ii_download_restaurants', 'ii_download_restaurant_files' ); 
add_action( 'ii_parse', 'ii_parse_downloaded_files' ); //restaurants
add_action( 'ii_parse_inspections', 'ii_parse_downloaded_inspections' );

function ii_activation() {
	
	ii_empty_download_directories();

	ii_default_options();

  if ( !wp_next_scheduled ( 'ii_download' ) ) {
  	wp_schedule_event( time(), 'everyotherday', 'ii_download' );
  } 
	
	if ( !wp_next_scheduled ( 'ii_download_restaurants' ) ) {
  	wp_schedule_event( time(), 'everyotherday', 'ii_download_restaurants' );
  }
	
	if( !wp_next_scheduled ( 'ii_parse' ) ) {
		wp_schedule_event( time(), 'fiveminutes', 'ii_parse' );
	}
	
	if( !wp_next_scheduled ( 'ii_parse_inspections' ) ) {
		wp_schedule_event( time(), 'fiveminutes', 'ii_parse_inspections' );
	}
	
}

function ii_deactivation() {
	wp_clear_scheduled_hook( 'ii_download' );
	wp_clear_scheduled_hook( 'ii_download_restaurants' );
	wp_clear_scheduled_hook( 'ii_parse' );
	wp_clear_scheduled_hook( 'ii_parse_inspections' );
}

function ii_add_times() {
	$schedules['hourly'] = array(
		'interval' => 3600,
		'display' => __('Once Hourly')
	);
	$schedules['fiveminutes'] = array(
		'interval' => 300,
		'display' => __('Every 5 Minutes')
	);
	$schedules['everyotherday'] = array(
		'interval' => 172800,
		'display' => __('Every Other Day')
	);
	return $schedules;
}

function ii_empty_download_directories() {
	$files = glob( plugin_dir_path( __DIR__) . "csv-inspections/" ); // get all file names
	ii_empty_download_directories_loop( $files );
	$files = glob( plugin_dir_path( __DIR__) . "csv-resturants/" ); // get all file names
	ii_empty_download_directories_loop( $files );
}

function ii_empty_download_directories_loop( $files ) {
	write_log($files);
	foreach($files as $file){ // iterate files
  	if(is_file($file)) {
			unlink($file); // delete file
		}
	}
}

function ii_default_options() {
	$opt_val=get_option( 'ii_urls' );
  $res_val=get_option( 'ii_restaurants' );
	if ( NULL == $opt_val ) {
		update_option( 'ii_urls', 'ftp://dbprftp.state.fl.us/pub/llweb/1fdinspi.csv,ftp://dbprftp.state.fl.us/pub/llweb/2fdinspi.csv,ftp://dbprftp.state.fl.us/pub/llweb/3fdinspi.csv,ftp://dbprftp.state.fl.us/pub/llweb/4fdinspi.csv,ftp://dbprftp.state.fl.us/pub/llweb/5fdinspi.csv,ftp://dbprftp.state.fl.us/pub/llweb/6fdinspi.csv,ftp://dbprftp.state.fl.us/pub/llweb/7fdinspi.csv,http://www.myfloridalicense.com/dbpr/sto/file_download/hr/1fdinspi_1415.csv,http://www.myfloridalicense.com/dbpr/sto/file_download/hr/2fdinspi_1415.csv,http://www.myfloridalicense.com/dbpr/sto/file_download/hr/3fdinspi_1415.csv,http://www.myfloridalicense.com/dbpr/sto/file_download/hr/4fdinspi_1415.csv,http://www.myfloridalicense.com/dbpr/sto/file_download/hr/5fdinspi_1415.csv,http://www.myfloridalicense.com/dbpr/sto/file_download/hr/6fdinspi_1415.csv,http://www.myfloridalicense.com/dbpr/sto/file_download/hr/7fdinspi_1415.csv,http://www.myfloridalicense.com/dbpr/sto/file_download/hr/1fdinspi_1314.csv,http://www.myfloridalicense.com/dbpr/sto/file_download/hr/2fdinspi_1314.csv,http://www.myfloridalicense.com/dbpr/sto/file_download/hr/3fdinspi_1314.csv,http://www.myfloridalicense.com/dbpr/sto/file_download/hr/4fdinspi_1314.csv,http://www.myfloridalicense.com/dbpr/sto/file_download/hr/5fdinspi_1314.csv,http://www.myfloridalicense.com/dbpr/sto/file_download/hr/6fdinspi_1314.csv,http://www.myfloridalicense.com/dbpr/sto/file_download/hr/7fdinspi_1314.csv,http://www.myfloridalicense.com/dbpr/sto/file_download/hr/1fdinspi_1213.csv,http://www.myfloridalicense.com/dbpr/sto/file_download/hr/2fdinspi_1213.csv,http://www.myfloridalicense.com/dbpr/sto/file_download/hr/3fdinspi_1213.csv,http://www.myfloridalicense.com/dbpr/sto/file_download/hr/4fdinspi_1213.csv,http://www.myfloridalicense.com/dbpr/sto/file_download/hr/5fdinspi_1213.csv,http://www.myfloridalicense.com/dbpr/sto/file_download/hr/6fdinspi_1213.csv,http://www.myfloridalicense.com/dbpr/sto/file_download/hr/7fdinspi_1213.csv' );
	}
	if ( NULL == $res_val ) {
		update_option( 'ii_restaurants' , 'ftp://dbprftp.state.fl.us/pub/llweb/hrfood1.csv,ftp://dbprftp.state.fl.us/pub/llweb/hrfood2.csv,ftp://dbprftp.state.fl.us/pub/llweb/hrfood3.csv,ftp://dbprftp.state.fl.us/pub/llweb/hrfood4.csv,ftp://dbprftp.state.fl.us/pub/llweb/hrfood5.csv,ftp://dbprftp.state.fl.us/pub/llweb/hrfood6.csv,ftp://dbprftp.state.fl.us/pub/llweb/hrfood7.csv' );
	}
}


if (!function_exists('write_log')) {
    function write_log ( $log )  {
        if ( true === WP_DEBUG ) {
            if ( is_array( $log ) || is_object( $log ) ) {
                error_log( print_r( $log, true ) );
            } else {
                error_log( $log );
            }
        }
    }
}
