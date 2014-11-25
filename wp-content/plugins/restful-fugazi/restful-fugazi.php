<?php
/**
 * The WordPress Plugin Boilerplate.
 *
 * A foundation off of which to build well-documented WordPress plugins that
 * also follow WordPress Coding Standards and PHP best practices.
 *
 * @package   RESTful_Fugazi
 * @author    Nick Morss <mail@nickmorss.com>
 * @license   GPL-2.0+
 * @link      
 * @copyright 2014 Nick Morss
 *
 * @wordpress-plugin
 * Plugin Name:       RESTful Fugazi
 * Plugin URI:       morss.net
 * Description:       Adminsitartion console tool for creating RESTful queries
 * Version:           1.0.0
 * Author:       Nick Morss
 * Author URI:       
 * Text Domain:       restful-fugazi
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/<owner>/<repo>
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

/*
 * @TODO:
 *
 * - replace `class-restful-fugazi.php` with the name of the plugin's class file
 *
 */
require_once( plugin_dir_path( __FILE__ ) . 'public/class-restful-fugazi.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 *
 * @TODO:
 *
 * - replace RESTful_Fugazi with the name of the class defined in
 *   `class-restful-fugazi.php`
 */
register_activation_hook( __FILE__, array( 'RESTful_Fugazi', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'RESTful_Fugazi', 'deactivate' ) );

/*
 * @TODO:
 *
 * - replace RESTful_Fugazi with the name of the class defined in
 *   `class-restful-fugazi.php`
 */
add_action( 'plugins_loaded', array( 'RESTful_Fugazi', 'get_instance' ) );

		add_action( 'admin_menu', 'restful_tool_page');


/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

/*
 * @TODO:
 *
 * - replace `class-restful-fugazi-admin.php` with the name of the plugin's admin file
 * - replace RESTful_Fugazi_Admin with the name of the class defined in
 *   `class-restful-fugazi-admin.php`
 *
 * If you want to include Ajax within the dashboard, change the following
 * conditional to:
 *
 * if ( is_admin() ) {
 *   ...
 * }
 *
 * The code below is intended to to give the lightest footprint possible.
 */
if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-restful-fugazi-admin.php' );
	add_action( 'plugins_loaded', array( 'RESTful_Fugazi_Admin', 'get_instance' ) );

}

function restful_tool_page() {
    
add_menu_page('Page title', 'Ranking', 'manage_options', 'restful-fugazi', 'my_magic_function');
add_management_page( __('Test Tools','menu-test'), __('Test Tools','menu-test'), 'manage_options', 'testtools', 'mt_tools_page');

}

function mt_tools_page() {
    echo "<h2>" . __( 'Test Tools', 'menu-test' ) . "</h2>";
}
