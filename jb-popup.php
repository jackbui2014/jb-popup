<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://jbprovider.com/author/jackbui
 * @since             1.0.0
 * @package           Jb_Popup
 *
 * @wordpress-plugin
 * Plugin Name:       JB Popup
 * Plugin URI:        https://jbprovider.com/plugins/jb-popup
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Jack Bui
 * Author URI:        https://jbprovider.com/author/jackbui
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       jb-popup
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'JB_POPUP_VERSION', '1.0.0' );
define( 'JB_POPUP', 'jb_popup');
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-jb-popup-activator.php
 */
function activate_jb_popup() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-jb-popup-activator.php';
	Jb_Popup_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-jb-popup-deactivator.php
 */
function deactivate_jb_popup() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-jb-popup-deactivator.php';
	Jb_Popup_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_jb_popup' );
register_deactivation_hook( __FILE__, 'deactivate_jb_popup' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-jb-popup.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_jb_popup() {

	$plugin = new Jb_Popup();
	$plugin->run();

}
run_jb_popup();
