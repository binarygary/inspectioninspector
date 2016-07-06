<?php
defined('ABSPATH') or die("No script kiddies please!");

function ii_parse_downloaded_files() {
  global $wpdb;
  //restaurant parse
  $directory = __DIR__."/../csv-restaurants/";
  $scanned_directory = array_values( array_diff( scandir( $directory ), array( '..', '.' ) ) );
  if ( !NULL == $scanned_directory[0] ) {
    if ( substr( $scanned_directory[0], -4 ) == '.csv' ) {
      $fp=fopen( __DIR__."/../csv-restaurants/$scanned_directory[0]" ,'r' );
      while ( ( $restaurant=fgetcsv( $fp, 0, ',' ) ) !==FALSE ) {
        bulk_add_restaurants( $restaurant );
        set_time_limit ( 15 );
      }
      fclose( $fp );
      unlink( __DIR__."/../csv-restaurants/$scanned_directory[0]" );
    }
  }
}

function bulk_add_restaurants( $restaurant ) {
  $restauranttypes=array('SEAT','NOST','MFDV');
  $rest['type']=$restaurant[3];
  $rest['name']=$restaurant[14];
  $rest['add1']=$restaurant[16];
  $rest['add2']=$restaurant[17];
  $rest['add3']=$restaurant[18];
  $rest['city']=$restaurant[19];
  $rest['state']=$restaurant[20];
  $rest['zip']=$restaurant[21];
  $rest['lic']=substr( $restaurant[26], 3);
  $rest['lastinspec']=$restaurant[30];
  $rest['seats']=$restaurant[31];
  $rest['risk']=$restaurant[32];
  if ( in_array( $rest['type'], $restauranttypes ) ) {
    save_restaurant( $rest );
  }
}

function save_restaurant( $restaurant ) {
  $restaurant=validate_sanitize_restaurant( $restaurant );
  $restaurantpost['ID']=check_for_existing_restaurant_post( $restaurant['lic'] );
  $restaurantpost['post_title']=create_restaurant_post_title( $restaurant );
  $restaurantpost['post_content']=print_r( $restaurant, TRUE );
  $restaurantpost['post_type']='restaurant';
  $restaurantpost['post_status']='publish';
  $restaurantpost['meta_input']=create_restaurant_meta( $restaurant );
  $id=wp_insert_post( $restaurantpost );
  wp_set_object_terms( $id, $restaurant['city'] , 'city' );
  wp_set_object_terms( $id, $restaurant['lic'] , 'license' );
  wp_set_object_terms( $id, $restaurant['risk'] , 'risk');
  wp_set_object_terms( $id, $restaurant['seats'], 'seats' );
  wp_set_object_terms( $id, $restaurant['type'], 'ii_type' );
  $result=ii_search( $restaurant['name'] . $restaurant['add1'] . $restaurant['add2'] . $restaurant['add3'] . $restaurant['city'] . $restaurant['state'] . $restaurant['zip'] );
  update_post_meta( $id, '_WP_Places_meta_Google_response', $result);
	$placeDetails=ii_placeDetails($result);
	update_post_meta( $id, '_WP_Places_lat', $placeDetails['lat']);
	update_post_meta( $id, '_WP_Places_lng', $placeDetails['lng']);
	update_post_meta( $id, '_WP_Places_name', $placeDetails['name']);
  
  
}

function validate_sanitize_restaurant( $restaurant ) {
  $restaurant['name']=ucwords( strtolower( $restaurant['name'] ) );
  $restaurant['add1']=ucwords( strtolower( $restaurant['add1'] ) );
  $restaurant['add2']=ucwords( strtolower( $restaurant['add2'] ) );
  $restaurant['add3']=ucwords( strtolower( $restaurant['add3'] ) );
  $restaurant['city']=ucwords( strtolower( $restaurant['city'] ) );
  $restaurant['zip']=substr( $restaurant['zip'], 0, 5 );
  if ( !is_null( $restaurant['lastinspec'] ) ) {
    $restaurant['lastinspec']=strtotime( $restaurant['lastinspec'] );
  }
  return $restaurant;
}

function check_for_existing_restaurant_post( $restaurant ) {
  $args = array(
    'post_type' => array( 'restaurant' ),
    'tax_query' => array(
      array( 'taxonomy' => 'license', 
             'field' => 'name',
             'terms' => array( $restaurant ),
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

function create_restaurant_meta( $restaurant ) {
  foreach ( $restaurant as $attribute=>$value ) {
    $meta[$attribute]=$value;
  }  
  return $meta;
}

function create_restaurant_post_title( $restaurant ) {
  $title=$restaurant['name'] . " - " . $restaurant['city'] . ", Florida";
  return $title;
}

/*zomato api
1e7319da3875600d0ebd478652d72cde
*/

/*
RESTAURANT
Title: Business Name, Street Location 1 [2,3] City
Taxonomy: City
Meta: Number of Seats, Last Inspection Date, Base Risk, 2ndary Risk, last updated timestamp.
Put License # into new table with Restaurant CPT->ID
*/

/*
FOOD TRUCK
Title: Truck Name
Taxononmy: City

/*restaurant file
Board Code (all should be 200)
License Type AND 
  2010 (SEAT or NOST) Permanent Food Service 
  2013 CATR Catering
  2014 (MFDV (food truck) or HTDG) Food Truck or Hot Dog Cart
  2005 BNB Bed and Breakfast
LICENSE NAME
RANK CODE
  2010 (SEAT or NOST)
  2012 PARK
  2013 CATR
  2014 (MFDV (food truck) or HTDG)
  2015 VEND
  2005 BNB
MODIFIER CODE (NOT NEEDED)
MAILING NAME
STREET 1
STREET 2
STREET 3
CITY
STATE
ZIP
COUNTY CODE
PRIMARY PHONE
BUSINESS NAME ***(GOOGLE PLACES LOOKUP)***
FILLER
LOCATION STREET1
STREET 2
STREET 3
CITY
STATE
ZIP
COUNTY CODE 
2NDARY PHONE
DISTRICT
REGION
LICENSE NUMBER
PRIMARY STATUS
SECONDARY STATUS
EXPIRY DATE
LAST INSPECTION DATE
NUMBER OF SEATS
BASE RISK LEVEL
2NDARY RISK LEVEL
*/