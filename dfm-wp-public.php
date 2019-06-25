<?php
/**
 * DFM Wordpress Plugin.
 *
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

declare( strict_types = 1 );

namespace DFM;

use DFM\Includes;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) :
	die;
endif;

/**
 * Include autoloader and define action to kick off plugin operation.
 */
require_once plugin_dir_path( __FILE__ ) . 'lib/autoloader.php';
add_action( 'plugins_loaded', __NAMESPACE__ . '\\dfm_wp_public_init' );

/**
 * Register activation & deactivation hooks
 */
register_activation_hook( __FILE__, array( 'DFM\\Includes\\DFM_WP_Public_Activator', 'activate' ) );

/**
 * Instantiates each class defined in the autoloader.
 *
 * @since 1.0.0
 * @author Ian Kaplan <ian.c.kaplan@protonmail.com>
 */
function dfm_wp_public_init() {
	$plugin = new Includes\DFM_WP_Public( __FILE__ );
	$plugin->run();
}
