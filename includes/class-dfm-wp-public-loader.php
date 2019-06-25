<?php
/**
 * Registers plugin admin hooks.
 *
 * @link       https://github.com/kapstan/dfm-wp-public
 * @since      1.0.0
 * @package    dfm-wp-public
 * @subpackage dfm-wp-public/includes
 * @author     Ian Kaplan <ian.c.kaplan@protonmail.com>
 */

namespace DFM\Includes;

// bail if this is accessed directly.
if ( ! defined( 'WPINC' ) ) {
	die();
}

/**
 * \DFM_WP_Public_Loader
 *
 * Registers custom admin-area hooks for plugin functionality.
 *
 * @version  1.0.0
 * @author   Ian Kaplan <ian.c.kaplan@protonmail.com>
 */
class DFM_WP_Public_Loader {
	/**
	 * Array of registered actions.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    array    $actions    Actions registered to WordPress; firing on plugin load.
	 */
	protected $actions;

	/**
	 * Array of registered content filters.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    array    $actions    Filters registered to WordPress; firing on plugin load.
	 */
	protected $filters;

	/**
	 * Class constructor/init.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		$this->actions = array();
		$this->filters = array();
	}

	/**
	 * Registers plugin's filters and actions.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function run() {
		foreach ( $this->filters as $filter ) :
			add_filter( $filter['hook'], array( $filter['instance'], $filter['callback'] ), $filter['priority'], $filter['accepted_args'] );
		endforeach;

		foreach ( $this->actions as $action ) :
			add_action( $action['hook'], array( $action['instance'], $action['callback'] ), $action['priority'], $action['accepted_args'] );
		endforeach;
	}

	/**
	 * Add a new action for registration with WordPress.
	 *
	 * @since         1.0.0
	 * @access        public
	 * @param string  $hook            Name of action to be registered.
	 * @param object  $instance        Reference to an object instance where action is defined.
	 * @param string  $callback        Handler defined within $instance.
	 * @param integer $priority        Execution priority.
	 * @param integer $accepted_args   How many arguments the action accepts/expects.
	 * @return void
	 */
	public function add_action( $hook, $instance, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->actions = $this->add( $this->actions, $hook, $instance, $callback, $priority, $accepted_args );
	}

	/**
	 * Add a new filter for registration with WordPress.
	 *
	 * @since         1.0.0
	 * @access        public
	 * @param string  $hook            Name of filter to be registered.
	 * @param object  $instance        Reference to an object instance where filter is defined.
	 * @param string  $callback        Handler defined within $instance.
	 * @param integer $priority        Execution priority.
	 * @param integer $accepted_args   How many arguments the filter accepts/expects.
	 * @return void
	 */
	public function add_filter( $hook, $instance, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->filters = $this->add( $this->filters, $hook, $instance, $callback, $priority, $accepted_args );
	}

	/**
	 * Adds filters and actions into a single collection.
	 *
	 * @since         1.0.0
	 * @access        private
	 * @param array   $hooks          Collection of actions/filters being added.
	 * @param string  $hook           Name of action/filter being registeed.
	 * @param object  $instance       Reference to object instance where action/filter is defined.
	 * @param string  $callback       Handler defined within $instance.
	 * @param integer $priority       Execution priority.
	 * @param integer $accepted_args  How many arguments action/filter accepts/expects.
	 * @return array  $hooks
	 */
	private function add( $hooks, $hook, $instance, $callback, $priority, $accepted_args ) {
		$hooks[] = array(
			'hook'          => $hook,
			'instance'      => $instance,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args,
		);

		return $hooks;
	}
}
