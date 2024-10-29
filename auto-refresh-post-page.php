<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://cubixsol.com/
 * @since             1.0.0
 * @package           Auto_refresh_post_page
 *
 * @wordpress-plugin
 * Plugin Name:       Auto Refresh Post & Page
 * Plugin URI:        https://cubixsol.com/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Cubixsol
 * Author URI:        https://cubixsol.com/our-products/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * @package           Auto_refresh_post_page
 * Domain Path:       /languages
 * 
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
 *                                    
 *                                       
 */

if ( ! defined( 'ABSPATH' ) ) exit;


if (!defined('WPINC')) {
	die;
}

// Define plugin constants.
define('ARPP_AUTO_REFRESH_VERSION', '1.0.0');
define('ARPP_AUTO_REFRESH_PLUGIN_URL', plugin_dir_url(__FILE__));
define('ARPP_AUTO_REFRESH_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('ARPP_AUTO_REFRESH_URL', get_bloginfo('url'));


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-auto_refresh_post_page-activator.php
 */
function ARPP_activate_auto_refresh_post_page()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-auto_refresh_post_page-activator.php';
	$activator = new Auto_refresh_post_page_Activator();
	$activator->activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-auto_refresh_post_page-deactivator.php
 */
function ARPP_deactivate_auto_refresh_post_page()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-auto_refresh_post_page-deactivator.php';
	$deactivator = new Auto_refresh_post_page_Deactivator();
	$deactivator->deactivate();
}

// Include activation and deactivation hooks.
require_once plugin_dir_path(__FILE__) . 'includes/class-auto_refresh_post_page-activator.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-auto_refresh_post_page-deactivator.php';

register_activation_hook(__FILE__, 'ARPP_activate_auto_refresh_post_page');
register_deactivation_hook(__FILE__, 'ARPP_deactivate_auto_refresh_post_page');

// Include the core plugin class.
require plugin_dir_path(__FILE__) . 'includes/class-auto_refresh_post_page.php';

// Initialize the plugin.
function ARPP_auto_refresh_post_page_run()
{
	$plugin = new Auto_refresh_post_page();
	$plugin->run();
}
ARPP_auto_refresh_post_page_run();

// Store refresh settings in the database.
function ARPP_store_refresh_settings()
{

	if (!isset($_POST['ARPP_nonce']) || !wp_verify_nonce(sanitize_text_field($_POST['ARPP_nonce']), 'ARPP_store_refresh_settings_nonce')) {
        wp_send_json_error('Invalid nonce.');
    }

	// Ensure the data received is an array and sanitize its elements.
	if (!isset($_POST['data']) || !is_array($_POST['data'])) {
		return;
	}

	$data = sanitize_text_field($_POST['data']);
	$new_data = array();

	foreach ($data as $key => $value) {
		// Sanitize the key and value.
		$key = sanitize_key($key);
		$value = sanitize_text_field($value);

		// Handle special case for checkboxes if needed.
		if (strpos($key, 'checkbox') !== false) {
			$exploded = explode('-', $key);
			$new_data[$exploded[1]] = $value;
		} else {
			$new_data[$key] = $value;
		}
	}

	// Store the sanitized data in the database.
	update_option('ARPP_my_option_name', $new_data);
}

add_action('wp_ajax_ARPP_store_refresh_settings', 'ARPP_store_refresh_settings');

// Add meta box for the refresh selector on pages.
function ARPP_AddRefreshOptionBox()
{
	global $post;

	if (!empty($post)) {
		$post_type = $post->post_type;
		add_meta_box(
			'ARPP_RefreshOptionsBox',
			'Auto Refresh Post & Page',
			'ARPP_RefreshOptionsBox',
			$post_type,
			'side',
			'low'
		);
	}
}

add_action('add_meta_boxes', 'ARPP_AddRefreshOptionBox');

// Output the meta box HTML for the refresh options.
function ARPP_RefreshOptionsBox($post)
{
	$meta_value_box = get_post_meta($post->ID, 'ARPP_duration_options', true);
	$meta_value_box = absint($meta_value_box);

	wp_nonce_field(plugin_basename(__FILE__), 'arpap_noncename');
	echo '<p><label>Refresh frequency in seconds:</label> <input type="number" name="ARPP_duration_options[seconds]" id="arpap_seconds" value="' . esc_attr($meta_value_box) . '" style="width: 50px;" /></p>';
	echo '<p class="description">Enter 0 for no refresh.</p>';
}

// Save refresh options on page update.
function ARPP_SaveRefreshOptions($post_id)
{
	global $post;
	
	if(isset($_POST['ARPP_duration_options'])){
		$nonce = sanitize_text_field( $_POST['arpap_noncename'] );
		if ( !wp_verify_nonce( $nonce, plugin_basename(__FILE__) ) ) {
			return;
		}
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
			return;
	
		if ( !current_user_can( 'edit_post', $post_id ) )
			return;
		
		$seconds = sanitize_text_field( $_POST['ARPP_duration_options']['seconds'] );
		update_post_meta( $post->ID, 'ARPP_duration_options',  $seconds );
	}
}

add_action('save_post', 'ARPP_SaveRefreshOptions');

// Add meta tag for auto-refresh on non-admin pages.
function ARPP_AddRefreshMetaTag()
{
	if (!is_admin()) {
		global $wp_query;
		$page_obj = $wp_query->get_queried_object();
		$meta_value = absint(get_post_meta($page_obj->ID, 'ARPP_duration_options', true));

		if ($meta_value > 0) {
			echo '<meta http-equiv="refresh" content="' . esc_attr($meta_value) . '" />';
		}
	}
}

add_action('wp_head', 'ARPP_AddRefreshMetaTag');

// Set the refresh time for post types based on stored settings.
function ARPP_setrefreshtime()
{
	$array_from_db = get_option('ARPP_my_option_name');

	foreach ($array_from_db as $key => $value) {
		// Sanitize the key and value.
		$key = sanitize_key($key);
		$value = absint($value);

		if ($value === 1) {
			$duration_key = "duration-" . $key;
			if (array_key_exists($duration_key, $array_from_db)) {
				$seconds = absint($array_from_db[$duration_key]);
				$args = array(
					'post_type' => $key,
					'posts_per_page' => -1
				);
				$pages = get_posts($args);

				foreach ($pages as $page) {
					update_post_meta($page->ID, 'ARPP_duration_options', $seconds);
				}
			}
		} elseif ($value === 0) {
			$args = array(
				'post_type' => $key,
				'posts_per_page' => -1
			);
			$pages = get_posts($args);

			foreach ($pages as $page) {
				delete_post_meta($page->ID, 'ARPP_duration_options');
			}
		}
	}
}

add_action('wp_head', 'ARPP_setrefreshtime');

