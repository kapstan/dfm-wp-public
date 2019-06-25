<?php
/**
 * Handles plugin deactivation.
 *
 * @since      1.0.0
 * @package    dfm-wp-public
 * @subpackage dfm-wp-public/includes
 */

namespace DFM\Includes;

/**
 * \DFM\Includes\DFM_WP_Public_Deactivator
 *
 * Handles plugin deactivation.
 *
 * Defines all the code necessary for plugin deactivation tasks.
 *
 * @since      1.0.0
 * @package    dfm-wp-public
 * @subpackage dfm-wp-public/includes
 * @author     Ian Kaplan <ian.c.kaplan@protonmail.com>
 */
class DFM_WP_Public_Deactivator {
	/**
	 * Deactivation handler.
	 *
	 * Defines actions taken to deactivate plugin, if any.
	 *
	 * @return void
	 */
	public static function deactivate() {
		if ( ! current_user_can( 'activate_plugins' ) ) :
			return;
		endif;
	}
}
