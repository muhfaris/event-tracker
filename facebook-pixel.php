<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/muhfaris
 * @since             1.0.0
 * @package           Event_Tracker
 *
 * @wordpress-plugin
 * Plugin Name:       Event Tracker
 * Plugin URI:        https://github.com/muhfaris/event-tracker
 * Description:       This plugin help you to install Facebook Pixel to your site. Just copy Your pixel ID and paste to plugin setting.
 * Version:           1.0.0
 * Author:            Muh Faris
 * Author URI:        https://github.com/muhfaris
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       event-tracker
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
define( 'EVENT_TRACKER_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-facebook-pixel-activator.php
 */
function activate_facebook_pixel() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-facebook-pixel-activator.php';
	Facebook_Pixel_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-facebook-pixel-deactivator.php
 */
function deactivate_facebook_pixel() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-facebook-pixel-deactivator.php';
	Facebook_Pixel_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_facebook_pixel' );
register_deactivation_hook( __FILE__, 'deactivate_facebook_pixel' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-facebook-pixel.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_facebook_pixel() {

	$plugin = new Facebook_Pixel();
	$plugin->run();

}
run_facebook_pixel();
