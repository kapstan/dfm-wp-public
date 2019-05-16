<?php
/**
 * @link http://www.digitalfirstmedia.com
 * @since 1.0.0
 * @package DFM_WP_Public
 *
 * @wordpress-plugin
 * Plugin Name: DFM WP Public
 * Plugin URI: https://github.com/dfmedia/dfm-wp-public
 * Description: DFM WordPress public plugin
 * Version: 1.0.0
 * Author: DFM
 * Author URI: http://www.digitalfirstmedia.com
 * Text Domain: dfm-wp-public
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-dfm-wp-public.php';

/**
 * Begins execution of the plugin.
 *
 * @since 1.0.0
 */
function run_dfm_wp_public() {

	$plugin = new DFM_WP_Public( __FILE__ );
	$plugin->run();

}
run_dfm_wp_public();
