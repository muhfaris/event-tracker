<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/muhfaris
 * @since      1.0.0
 *
 * @package    Facebook_Pixel
 * @subpackage Facebook_Pixel/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Facebook_Pixel
 * @subpackage Facebook_Pixel/admin
 * @author     Muh Faris <devmuhfaris@gmail.com>
 */
class Facebook_Pixel_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Facebook_Pixel_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Facebook_Pixel_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/facebook-pixel-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Facebook_Pixel_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Facebook_Pixel_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/facebook-pixel-admin.js', array( 'jquery' ), $this->version, false );

	}

    /**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     *
     * @since    1.0.0
     */

    public function add_plugin_admin_menu() {

        /*
         * Add a settings page for this plugin to the Settings menu.
         *
         * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
         *
         *        Administration Menus: http://codex.wordpress.org/Administration_Menus
         *
         */
        add_menu_page( 'Facebook Pixel', 'Facebook Pixel', 'manage_options', 'pixel-setting', array($this, 'display_plugin_setup_page'));
    }

     /**
     * Add settings action link to the plugins page.
     *
     * @since    1.0.0
     */

    public function add_action_links( $links ) {
        /*
        *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
        */
       $settings_link = array(
        '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
       );
       return array_merge(  $settings_link, $links );

    }

    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */

    public function display_plugin_setup_page() {
        include_once( 'partials/facebook-pixel-admin-display.php' );
    }

	/**
	 * Register all related settings of this plugin
	 *
	 * @since  1.0.0
	 */
	public function register_setting() {
        register_setting(
            'pixel-group', // Option group
            'pixel-options', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'section_id', // ID
            '', // Title
            '', // Callback
            'pixel-setting' // Page
        );

        add_settings_field(
            'pixel_id',
            'Pixel ID',
            array( $this, 'facebook_pixel_id_cb' ),
            'pixel-setting',
            'section_id'
        );
	}

    /**
	 * Render the treshold day input for this plugin
	 *
	 * @since  1.0.0
	 */
	public function facebook_pixel_id_cb() {
        printf(
            '<input type="text" id="pixel_id" name="pixel-options[pixel_id]" value="%s" />',
            isset( $this->options['pixel_id'] ) ? esc_attr( $this->options['pixel_id']) : ''
        );
	}

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input ) {
        $new_input = array();
        if( isset( $input['pixel_id'] ) )
            $new_input['pixel_id'] = sanitize_text_field( $input['pixel_id'] );

        return $new_input;
    }

    /**
     * facebook_pixel_setting_errors
     *
     * @since  1.0.0
     */
    public function facebook_pixel_setting_errors(){
        settings_errors();
    }
}
