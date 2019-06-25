<?php
/**
 * Hook for plugin activation.
 *
 * @since      1.0.0
 * @package    dfm-wp-public
 * @subpackage dfm-wp-public/includes
 */

namespace DFM\Includes;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) :
	die;
endif;

/**
 * \DFM\Includes\DFM_WP_Public_Activator
 *
 * Handles plugin activation.
 *
 * Defines all the code necessary for plugin activation tasks.
 *
 * @since      1.0.0
 * @package    dfm-wp-public
 * @subpackage dfm-wp-public/includes
 * @author     Ian Kaplan <ian.c.kaplan@protonmail.com>
 */
class DFM_WP_Public_Activator {
	/**
	 * Activation handler.
	 *
	 * Defines actions taken to activate plugin, if any.
	 *
	 * @return void
	 */
	public static function activate() {
		if ( ! current_user_can( 'activate_plugins' ) ) :
			return;
		endif;
	}
}
