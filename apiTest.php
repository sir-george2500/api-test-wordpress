<?php
/**
 * Plugin name: Query APIs
 * Plugin URI: https://omukiguy.com
 * Description: Exchange information with external APIs in WordPress
 * Author: Laurence Bahiirwa
 * Author URI: https://omukiguy.com
 * text-domain: query-apis
 */

// If this file is accessed directly, abort!!!
defined( 'ABSPATH' ) or die( 'Unauthorized Access' );

// Make $subscription_key global
global $subscription_key;
$subscription_key = '0c70d421836d4a209654871ba4dcec19';

function generate_api_key() {
    // Use the global subscription key
    global $subscription_key;

    // Set the request parameters
    $request_url      = 'https://sandbox.momodeveloper.mtn.com/v1_0/apiuser/7899fe12-8a0d-11ee-b9d1-0242ac120002/apikey';
    $request_headers  = [
        'Ocp-Apim-Subscription-Key' => $subscription_key,
    ];
    $request_body     = ''; // Set your request body if needed

    // Make the request using wp_remote_post
    $response = wp_remote_post(
        $request_url,
        [
            'headers' => $request_headers,
            'body'    => $request_body,
        ]
    );

    // Check for errors
    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        echo "Something went wrong: $error_message";
    } else {
        echo '<pre>';
        var_dump(wp_remote_retrieve_body($response));
        echo '</pre>';
    }

    // Return the API key
    return $response['body'];
}

function generate_token() {
    //Use the global subscription_key
    global $subscription_key;

    $user_id = '0c02c30f-9ec2-456b-8d73-fddf92ec2692';
    
    $api_key = 'd786dff63eef455ba66df33fbf991dda';

    $api_user_and_key = $user_id.':'.$api_key;

    $encoded = base64_encode($api_user_and_key);

    $headers = [
    # Request headers
    'Authorization'=> 'Basic '.$encoded,
    'Ocp-Apim-Subscription-Key'=> $subscription_key,
    ];

    $url = 'https://sandbox.momodeveloper.mtn.com/collection/token/';
    $request_body     = ''; // Set your request body if needed

    // Make the request using wp_remote_post
    $response = wp_remote_post(
        $url,
        [
            'headers' => $headers,
            'body'    => $request_body,
        ]
    );

    echo '<pre>';
    var_dump(wp_remote_retrieve_body($response));
    echo '</pre>';


}
function get_send_data() {
    // First, generate the API key
  generate_api_key();

  //  if ($api_key) {
        // Then, generate the token using the obtained API key
       generate_token();
   // }
}

/**
 * Register a custom menu page
 */
function wpdocs_register_my_custom_menu_page() {
    add_menu_page(
        __( 'API Test Settings', 'textdomain' ),
        'API Test',
        'manage_options',
        'api-test.php',
        'get_send_data',
        'dashicons-testimonial',
        85
    );
}

add_action( 'admin_menu', 'wpdocs_register_my_custom_menu_page' );

