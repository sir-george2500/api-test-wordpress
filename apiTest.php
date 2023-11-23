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

function get_send_data() {

    $subscription_key = '0c70d421836d4a209654871ba4dcec19';

    // Set the request parameters
    $request_url = 'https://sandbox.momodeveloper.mtn.com/v1_0/apiuser/7899fe12-8a0d-11ee-b9d1-0242ac120002/apikey';
    $request_headers = [
        'Ocp-Apim-Subscription-Key' => $subscription_key,
    ];
    $request_body = ''; // Set your request body if needed

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

