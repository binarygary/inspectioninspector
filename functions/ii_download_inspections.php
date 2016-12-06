<?php
defined( 'ABSPATH' ) or die( "No script kiddies please!" );

function ii_download_inspection_files() {
	$opt_val = get_option( 'ii_urls' );
	if ( is_array( $urlarray = explode( ',', $opt_val ) ) ) {
		$urlarray = explode( ',', $opt_val );
		foreach ( $urlarray as $url ) {
			if ( ! null == $url ) {
				$ch       = curl_init( $url );
				$filename = parse_url_remote_filename( $url );
				$fp       = fopen( plugin_dir_path( __DIR__ ) . "csv-inspections/$filename", "w" );
				curl_setopt( $ch, CURLOPT_FILE, $fp );
				curl_exec( $ch );
				curl_close( $ch );
				set_time_limit( 30 );
				split_inspection_csv( $filename );
				unlink( plugin_dir_path( __DIR__ ) . "csv-inspections/$filename" );
			}
		}
	} else {
		return;
	}
}

function parse_url_remote_filename( $url ) {
	if ( is_array( $urlarray = explode( '/', $url ) ) ) {
		$urlarray = explode( '/', $url );

		return end( $urlarray );
	} else {
		return;
	}
}

function update_url_stats( $data ) {
	if ( ! get_option( 'ii_url_stats' ) ) {
		update_option( 'ii_url_stats', $data );
	} else {
		$result = get_option( 'ii_url_stats' );
		if ( is_array( $result ) ) {
			$combined = array_merge( $data, $result );
			update_option( 'ii_url_stats', $combined );
		} else {
			return;
		}
	}
}

function split_inspection_csv( $filename ) {
	$inputFile  = $filename;
	$outputFile = $filename;
	$splitSize  = 50;
	$in         = fopen( plugin_dir_path( __DIR__ ) . "csv-inspections/$filename", 'r' );

	$rowCount  = 0;
	$fileCount = 1;

	if ( ! in ) {
		return;
	}

	while ( ! feof( $in ) ) {
		if ( ( $rowCount % $splitSize ) == 0 ) {
			if ( $rowCount > 0 ) {
				fclose( $out );
			}
			$out = fopen( plugin_dir_path( __DIR__ ) . "csv-inspections/" . $outputFile . $fileCount ++ . '.csv', 'w' );
		}
		$data = fgetcsv( $in );
		if ( $data ) {
			fputcsv( $out, $data );
		}
		$rowCount ++;
	}

	fclose( $out );
}