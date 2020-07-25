<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/muhfaris
 * @since      1.0.0
 *
 * @package    Facebook_Pixel
 * @subpackage Facebook_Pixel/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Facebook_Pixel
 * @subpackage Facebook_Pixel/includes
 * @author     Muh Faris <devmuhfaris@gmail.com>
 */
class Facebook_Pixel_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'facebook-pixel',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
