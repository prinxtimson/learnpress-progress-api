<?php
/*
Plugin Name:  My LearnPress Progress Api
Plugin URI:   https://www.tabtech.com 
Description:  My LearnPress User Progress Rest api. 
Version:      1.0
Author:       Tabtech
Author URI:   https://www.tabtech.com
Text Domain:  my-lp-progress-api
Domain Path:  /languages
*/

if(! defined('ABSPATH')){
  exit;
}

function get_users_progress($data)
{
  global $wpdb;
  $lpa_user = get_user_by( 'email', $data['email'] );

  $lpa_table_name = $wpdb->prefix . "learnpress_user_items";

  $lpa_data = $wpdb->get_results( "SELECT * FROM $lpa_table_name WHERE user_id = $lpa_user->id" );

  return $lpa_data;
}

add_action('rest_api_init', function () {
  register_rest_route('my-lpa/v1', '/user-progress', array(
    'methods' => 'GET',
    'callback' => 'get_users_progress',
    'args' => array(
      'email' => array(
        'required' => true,
        'validate_callback' => 'is_email'
      )
    )
  ));
});