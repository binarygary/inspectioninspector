<?php
defined('ABSPATH') or die("No script kiddies please!");

function ii_download_restaurant_files() {
  $opt_val=get_option( 'ii_restaurants' );
  if ( is_array( $urlarray = explode( ',' , $opt_val ) ) ) {
    $urlarray = explode( ',' , $opt_val );
    foreach ($urlarray as $url) {
      if (!NULL==$url) {
        $ch = curl_init( $url );
        $filename = parse_url_remote_filename( $url );
        $fp = fopen( plugin_dir_path( __DIR__) . "csv-restaurants/$filename", "w" );
        curl_setopt( $ch, CURLOPT_FILE, $fp );
        curl_exec( $ch );
        curl_close( $ch );
        set_time_limit ( 30 );
        split_restaurant_csv( $filename );
        unlink( plugin_dir_path( __DIR__) . "csv-restaurants/$filename" );
      } 
    }
  } else {
    return;
  }
}


function split_restaurant_csv( $filename ) {
  $inputFile = $filename;
  $outputFile = $filename;
  $splitSize = 50;
  $in = fopen( plugin_dir_path( __DIR__) . "csv-restaurants/$filename", 'r');

   $rowCount = 0;
   $fileCount = 1;
   while (!feof($in)) {
    if (($rowCount % $splitSize) == 0) {
        if ($rowCount > 0) {
            fclose($out);
        }
        $out = fopen( plugin_dir_path( __DIR__) . "csv-restaurants/" . $outputFile . $fileCount++ . '.csv', 'w');
    }
    $data = fgetcsv($in);
    if ($data)
        fputcsv($out, $data);
    $rowCount++;
}

fclose($out);
}