<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://cubixsol.org/
 * @since      1.0.0
 *
 * @package    Auto_refresh_post_page
 * @subpackage Auto_refresh_post_page/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Auto_refresh_post_page
 * @subpackage Auto_refresh_post_page/public
 * @author     Noman Ghaffar <info@cubixsol.com>
 *  
 *                                                                
 * 
 *  ________      ___  ___      ________      ___      ___    ___  ________       ________      ___          
 * |\   ____\    |\  \|\  \    |\   __  \    |\  \    |\  \  /  /||\   ____\     |\   __  \    |\  \         
 * \ \  \___|    \ \  \\\  \   \ \  \|\ /_   \ \  \   \ \  \/  / /\ \  \___|_    \ \  \|\  \   \ \  \        
 *  \ \  \        \ \  \\\  \   \ \   __  \   \ \  \   \ \    / /  \ \_____  \    \ \  \\\  \   \ \  \       
 *   \ \  \____    \ \  \\\  \   \ \  \|\  \   \ \  \   /     \/    \|____|\  \    \ \  \\\  \   \ \  \____  
 *	  \ \_______\   \ \_______\   \ \_______\   \ \__\ /  /\   \      ____\_\  \    \ \_______\   \ \_______\
 *	   \|_______|    \|_______|    \|_______|    \|__|/__/ /\ __\    |\_________\    \|_______|    \|_______|
 *	   								   			      |__|/ \|__|    \|_________|       
 *                     		
 * 
 */
if ( ! defined( 'ABSPATH' ) ) exit;
class Auto_refresh_post_page_Public
{

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Auto_refresh_post_page_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Auto_refresh_post_page_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/auto-refresh-post-page-public.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Auto_refresh_post_page_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Auto_refresh_post_page_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script($this->plugin_name . "-jquery", ARPP_AUTO_REFRESH_PLUGIN_URL . 'assets/js/jquery.js', array(), '3.5.1', false);
		wp_enqueue_script($this->plugin_name . "-sweetalert", ARPP_AUTO_REFRESH_PLUGIN_URL . 'assets/js/sweetalert.min.js',  array('jquery'), $this->version, false);

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/auto-refresh-post-page-public.js', array('jquery'), $this->version, false);
	}
}