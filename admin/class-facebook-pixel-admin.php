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
     * The author
     * @var string
     */
    protected $author;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $author ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        $this->author = $author;

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
        add_menu_page( 'Events Tracker', 'Events Tracker', 'manage_options', 'events-tracker-setting', array($this, 'display_plugin_setup_page'), 'dashicons-facebook-alt');
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
            'mfa-pixel-options', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'section_id', // ID
            '', // Title
            '', // Callback
            'events-tracker-setting' // Page
        );

        add_settings_field(
            'pixel_id',
            'Pixel ID',
            array( $this, 'facebook_pixel_id_cb' ),
            'events-tracker-setting',
            'section_id'
        );
	}

    /**
	 * Render the input for this plugin
	 *
	 * @since  1.0.0
	 */
	public function facebook_pixel_id_cb() {
        printf(
            '<input type="text" id="pixel_id" name="mfa-pixel-options[pixel_id]" pattern="[0-9]+" value="%s" />',
            isset( $this->options['pixel_id'] ) ? esc_attr( $this->options['pixel_id']) : ''
        );
        echo '<p class="description" id="pixel-id-description">enter facebook pixel ID.</p>';
	}

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input ) {
        $errors = new WP_Error();
        $new_input = array();
        if (isset($input[ 'pixel_id' ]) && $input[ 'pixel_id' ] == '') {
            $errors->add('pixel_id_error', 'Please fill in a valid pixel id.');
        }

        if( isset( $input['pixel_id'] ) )
            $new_input['pixel_id'] = absint( $input['pixel_id'] );

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

    public function facebook_pixel_js(){
        $this->options = get_option( 'mfa-pixel-options' );
        echo $this->options['pixel_id'];
        ?>
        <!-- Facebook Pixel Code -->
        <script>
          !function(f,b,e,v,n,t,s)
          {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
          n.callMethod.apply(n,arguments):n.queue.push(arguments)};
          if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
          n.queue=[];t=b.createElement(e);t.async=!0;
          t.src=v;s=b.getElementsByTagName(e)[0];
          s.parentNode.insertBefore(t,s)}(window, document,'script',
          'https://connect.facebook.net/en_US/fbevents.js');
          fbq('init', <?php $this->options['pixel_id']?>);
          fbq('track', 'PageView');
        </script>
        <noscript>
          <img height="1" width="1" style="display:none"
          src="https://www.facebook.com/tr?id=<?php $this->options['pixel_id']?>&ev=PageView&noscript=1"/>
        </noscript>
<!-- End Facebook Pixel Code -->        <?php
    }
}
