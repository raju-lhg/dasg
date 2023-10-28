<?php
/**
 * Plugin Name: SAMGOV Custom API Plugin
 * Description: Custom plugin to fetch data from the SAM.gov API.
 * Version: 1.0
 * Author: Raju Rayhan
 * Author URI: https://github.com/rajurayhan
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define constants.
define( 'CAP_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'CAP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Include necessary files.
require_once CAP_PLUGIN_PATH . 'inc/class-api-handler.php';
require_once CAP_PLUGIN_PATH . 'inc/class-listing-page.php';
require_once CAP_PLUGIN_PATH . 'inc/class-details-page.php';

// Enqueue styles.
function cap_enqueue_styles() {
    wp_enqueue_style( 'cap-styles', CAP_PLUGIN_URL . 'assets/style.css' );
}
add_action( 'admin_enqueue_scripts', 'cap_enqueue_styles' );
