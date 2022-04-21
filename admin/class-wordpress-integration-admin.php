<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://typhon.agency
 * @since      1.0.0
 *
 * @package    Wordpress_Integration
 * @subpackage Wordpress_Integration/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wordpress_Integration
 * @subpackage Wordpress_Integration/admin
 * @author     Safa Marhaba <safamarhaba244@gmail.com>
 */
class Wordpress_Integration_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

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
		 * defined in Icecat_Integration_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Icecat_Integration_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wordpress-integration-admin.css', array(), $this->version, 'all' );

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
		 * defined in Icecat_Integration_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Icecat_Integration_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wordpress-integration-admin.js', array( 'jquery' ), $this->version, false );

	}
    
    public function display_admin_page(){
        add_menu_page(
            'DAS360 Plugin', // page title
            'DAS360 Plugin', // menu title
            'manage_options', // capabilities
            'das360-plugin', // menu slug
            array($this, 'showPage'), // function
            '', // icon url
            '2' // place in nav menu
            );
        
        add_submenu_page(
            'das360-plugin', // parent slug
            'Fetch Icecat Products', // page title
            'Fetch Icecat Products', // menu title
            'manage_options', // capabilities
            'fetch-products', // menu slug
            array($this, 'show_forHomePage') // function
            );
        add_submenu_page(
            'das360-plugin', // parent slug
            'Slider Images', // page title
            'Slider Images', // menu title
            'manage_options', // capabilities
            'slider-images', // menu slug
            array($this, 'show_forSlider') // function
            );
        add_submenu_page(
            'das360-plugin', // parent slug
            'Offer Images', // page title
            'Offer Images', // menu title
            'manage_options', // capabilities
            'offer-images', // menu slug
            array($this, 'show_forOffers') // function
            );
        add_submenu_page(
            'das360-plugin', // parent slug
            'Sales Packages', // page title
            'Sales Packages', // menu title
            'manage_options', // capabilities
            'sales-packages', // menu slug
            array($this, 'show_forSalesPackages') // function
            );
            
    }
    public function show_forHomePage(){
        include __DIR__.'/partials/wordpress-integration-admin-display.php';
    }
    public function show_forSlider(){
        include __DIR__.'/partials/wordpress-integration-admin-display-slider-images.php';
    }
    public function show_forOffers(){
        include __DIR__.'/partials/wordpress-integration-admin-display-offer-images.php';
    }
    public function show_forSalesPackages(){
        include __DIR__.'/partials/wordpress-integration-admin-display-sales-packages.php';
    }
    public function showPage(){
        include __DIR__.'/partials/wordpress-integration-admin-display.php';
    }
}
