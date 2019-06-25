<?php
/**
 * Plugin admin area setup.
 *
 * @link       https://github.com/kapstan/dfm-wp-public
 * @since      1.0.0
 * @package    dfm-wp-public
 * @subpackage dfm-wp-public/includes
 * @author     Ian Kaplan <ian.c.kaplan@protonmail.com>
 */

namespace DFM\Includes;

// bail if this is accessed directly.
defined( 'ABSPATH' ) || exit();

/**
 * \DFM_WP_Public_Admin
 *
 * Setup for UI/UX env in plugin's admin area.
 *
 * @version  1.0.0
 * @author   Ian Kaplan <ian.c.kaplan@protonmail.com>
 */
class DFM_WP_Public_Admin {
	/**
	 * Constructor.
	 *
	 * Didn't want to get into static instances/singletons
	 * as they are a PITA to test, if it's possible to test
	 * successfully at all. Forgive the verbosity...
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
	}

	/**
	 * Enqueues css for use only on plugin menu page.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_styles() {
		if ( 'toplevel_page_dfm-wp-public-menu' !== get_current_screen()->base ) :
			return;
		endif;

		wp_enqueue_style( 'bootstrap', '//stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css', array(), '4.3.1', 'screen' );
	}

	/**
	 * Enqueues scripts for use only on plugin menu page.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_scripts() {
		if ( 'toplevel_page_dfm-wp-public-menu' !== get_current_screen()->base ) :
			return;
		endif;

		wp_enqueue_script( 'bootstrap', '//stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', array( 'jquery' ), '4.3.1.', false, true );
		wp_enqueue_script( 'dfm-wp-public-scripts', plugins_url( 'dfm-wp-public/pub/assets/dist/dfm-wp-public.js' ), array( 'jquery', 'bootstrap' ), '1.0.0', false, true );
	}
}
