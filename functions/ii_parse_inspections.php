<?php
defined('ABSPATH') or die("No script kiddies please!");

function ii_parse_downloaded_inspections() {
  global $wpdb;
  //restaurant parse
  $directory = __DIR__."/../csv-inspections/";
  $scanned_directory = array_values( array_diff( scandir( $directory ), array( '..', '.' ) ) );
  if ( !NULL == $scanned_directory[0] ) {
    if ( substr( $scanned_directory[0], -4 ) == '.csv' ) {
      $fp=fopen( __DIR__."/../csv-inspections/$scanned_directory[0]" ,'r' );
      while ( ( $inspection=fgetcsv( $fp, 0, ',' ) ) !==FALSE ) {
        bulk_add_inspection( $inspection );
        set_time_limit ( 30 );
      }
      fclose( $fp );
      unlink( __DIR__."/../csv-inspections/$scanned_directory[0]" );
    }
  }
}

function bulk_add_inspection( $inspection ) {
  $insp['lic']=$inspection[4];
  $insp['inspnum']=$inspection[9];//TAX
  $insp['visitnum']=$inspection[10];//TAX
  $insp['visittype']=$inspection[12];//TAX
  $insp['dispo']=$inspection[13]; //TAX
  $insp['date']=strtotime( $inspection[14] );
  $insp['ttlv']=$inspection[17];
  $insp['highv']=$inspection[18];
  $insp['intv']=$inspection[19];
  $insp['basv']=$inspection[20];
  $insp['visitid']=$inspection[81]; //TAX
  $insp['name']=$inspection[5];
  $insp['city']=$inspection[7];
  for ($i=22; $i<=79; $i++) {
    $inspectioncount[$i]=$inspection[$i];
  }
  $insp['inspectioncount']=serialize( $inspectioncount );
  if ( lic_exists( $insp['lic'] ) ) {
    save_inspection( $insp );
  }
}

function lic_exists( $license ) {
  $term=get_term_by( 'name', $license, 'license', ARRAY_A );
  if ( $term['count'] > 0 ) {
    return true;
  } else {
    return false;
  }
}

function save_inspection( $insp ) {
  $insppost['ID']=check_for_existing_inspection_post( $insp['visitid'] );
  $insppost['post_title']=create_inspection_post_title( $insp );
  $insppost['post_content']=print_r( $insp, TRUE );
  $insppost['post_type']='inspection';
  $insppost['post_status']='publish';
  $insppost['meta_input']=create_inspection_meta( $insp );
  $id=wp_insert_post( $insppost );
  wp_set_object_terms( $id, $insp['dispo'] , 'disposition' );
  wp_set_object_terms( $id, $insp['inspnum'] , 'inspectionnumber' );
  wp_set_object_terms( $id, $insp['lic'] , 'license' );
  wp_set_object_terms( $id, $insp['visitid'] , 'visitid' );
  wp_set_object_terms( $id, $insp['visitnum'] , 'visitnumber' );
  wp_set_object_terms( $id, $insp['visittype'] , 'visittype' );
}

function check_for_existing_inspection_post( $visitid ) {
  $args = array(
  'post_type' => array( 'inspection' ),
  'tax_query' => array(
    array( 'taxonomy' => 'visitid', 
           'field' => 'name',
           'terms' => array( $visitid ),
         ),
  ),
  'fields' => 'ids',
  );
  $query = new WP_Query( $args );
  
  if ( $query->post_count==1 ) {
    return $query->posts[0];
  } elseif ( $query->post_count>1 ) {
    foreach ( $query->posts as $delete ) {
      wp_delete_post( $delete );
    }
    return 0;
  } else {
    return 0;  
  }
}

function create_inspection_post_title( $insp ) {
  $args = array(
  'post_type' => array( 'restaurant' ),
  'tax_query' => array(
    array( 'taxonomy' => 'license', 
           'field' => 'name',
           'terms' => array( $insp['lic'] ),
         ),
    ),
  );
  $query = new WP_Query( $args );
 // write_log($query);
  
  if ( $query->post_count==1 ) {
    return $title=$query->posts[0]->post_title . " | Inspected " . date( 'l jS \of F Y', $insp['date'] );
  } else {
    return ucwords( strtolower( $insp['name'] ) ) . " - " . ucwords( strtolower( $insp['city'] ) ) . " | Inspected " . date( 'l jS \of F Y', $insp['date'] );
  }
}

function create_inspection_meta( $insp ) {
  foreach ( $insp as $attribute=>$value ) {
    $meta[$attribute]=$value;
  }  
  return $meta;
}