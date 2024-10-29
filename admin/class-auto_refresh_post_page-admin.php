<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://cubixsol.com/
 * @since      1.0.0
 *
 * @package    Auto_refresh_post_page
 * @subpackage Auto_refresh_post_page/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Auto_refresh_post_page
 * @subpackage Auto_refresh_post_page/admin
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
 */


if (!defined('ABSPATH')) {
	exit;
}

class Auto_refresh_post_page_Admin
{
	private $plugin_name;
	private $page;
	private $version;

	public function __construct($plugin_name, $version)
	{
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	public function enqueue_styles($hook)
	{
		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/auto-refresh-post-page-admin.css');
	}

	public function enqueue_scripts($hook)
	{
		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/auto-refresh-post-page-admin.js', array('jquery'), $this->version, false);
		wp_localize_script($this->plugin_name, 'auto_refresh_post_page', array(
			'name' => 'cubixsol',
			'author' => 'Noman Ghaffar',
			'email' => 'info@cubixsol.com',
			'website' => 'http://cubixsol.com',
			'ajaxurl' => admin_url("admin-ajax.php"),
		));
	}

	public function auto_refresh_post_page_admin_menu()
	{
		add_menu_page('Auto Refresh Post Page', 'Auto Refresh Post Page', 'manage_options', 'auto_refresh_post_page', array($this, 'auto_refresh_post_page_activator_callback'));
		add_submenu_page('auto_refresh_post_page', 'Dashboard', 'Dashboard', 'manage_options', 'auto_refresh_post_page', array($this, 'auto_refresh_post_page_dashboard_callback'));
	}

	public function auto_refresh_post_page_activator_callback()
	{
		// Default function for activate admin menu
	}

	public function auto_refresh_post_page_dashboard_callback()
	{
		ob_start();
		include_once ARPP_AUTO_REFRESH_PLUGIN_PATH . 'admin/partials/auto_refresh_post_page-admin-dashboard.php';
		$dashboard = ob_get_contents();
		ob_end_clean();
		echo $dashboard;
	}

	public function auto_refresh_post_page_admin_ajax_requests()
	{
		global $wpdb;
		$response = sanitize_text_field($_REQUEST["ac_action"]);
		//end ajax
		wp_die();
	}
}
