<?php
/**
 * Core plugin definition.
 *
 * @link       https://github.com/kapstan/dfm-wp-public
 * @since      1.0.0
 * @package    dfm-wp-public
 * @subpackage dfm-wp-public/includes
 * @author     Ian Kaplan <ian.c.kaplan@protonmail.com>
 */

namespace DFM\Includes;

// bail if this is accessed directly.
if ( ! defined( 'WPINC' ) ) :
	die();
endif;

define( 'PUB_PATH', trailingslashit( realpath( plugin_dir_path( __FILE__ ) . '../pub' ) ) );
define( 'VIEWS_PATH', trailingslashit( PUB_PATH . 'views' ) );
define( 'PLUGIN_FRIENDLY_NAME', 'DFM WP Public Posts by Category Viewer' );
define( 'ERROR_EMPTY_CATEGORY_LIST', 'Error! Encountered an empty category list. Cannot continue.' );

/**
 * \DFM_WP_Public
 *
 * The core plugin class.
 *
 * @version  1.0.0
 * @author   Ian Kaplan <ian.c.kaplan@protonmail.com>
 */
class DFM_WP_Public {
	/**
	 * The string used to uniquely identify this plugin.
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string
	 */
	public $plugin_name;

	/**
	 * The plugin_url
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string
	 */
	public $plugin_url;

	/**
	 * The plugin_path
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string
	 */
	public $plugin_path;

	/**
	 * Current version of the plugin
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string
	 */
	public $version;

	/**
	 * List of registered categories.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    array
	 */
	protected $categories;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name, url, path and plugin version that can be used throughout the plugin.
	 *
	 * @since  1.0.0
	 * @param  string $plugin_root Plugin's installation location.
	 * @access public
	 */
	public function __construct( $plugin_root ) {
		$this->plugin_name      = 'dfm-wp-public';
		$this->plugin_url       = plugin_dir_url( $plugin_root );
		$this->plugin_path      = plugin_dir_path( $plugin_root );
		$this->version          = '1.0.0';
		$this->plugin_admin     = new DFM_WP_Public_Admin();
		$this->plugin_loader    = new DFM_WP_Public_Loader();
		$this->plugin_activator = new DFM_WP_Public_Activator();
		$this->categories       = get_categories();

		// sanity check on categories.
		if ( empty( $this->categories ) ) :
			wp_die( esc_html( ERROR_EMPTY_CATEGORY_LIST ) );
		endif;

		// go ahead and define/register hooks since
		// we have what we need to continue.
		$this->define_hooks();
	}

	/**
	 * Register the actions and filters
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function run() {
		// actually register hooks.
		$this->plugin_loader->run();
	}

	/**
	 * Defines actions used by plugin and passed to loader class.
	 *
	 * @since 1.0.0
	 * @access private
	 * @return void
	 */
	private function define_hooks() {
		// define plugin's hooks.
		$this->plugin_loader->add_action( 'admin_enqueue_scripts', $this->plugin_admin, 'enqueue_styles' );
		$this->plugin_loader->add_action( 'admin_enqueue_scripts', $this->plugin_admin, 'enqueue_scripts' );
		$this->plugin_loader->add_action( 'admin_menu', $this, 'register_menu_page' );
		$this->plugin_loader->add_action( 'dfm-wp-public_render_content', $this, 'render_content', 10, 2 );
		$this->plugin_loader->add_action( 'dfm-wp-public_render_no_content_found', $this, 'display_no_content_found_message', 10, 1 );
		$this->plugin_loader->add_filter( 'dfm-wp-public_capitalize_words', $this, 'capitalize_word', 10, 1 );
	}

	/**
	 * Registers and adds the plugin's menu page.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function register_menu_page() {
		add_menu_page(
			'DFM WP Public Admin Page',
			'DFM WP Public Content',
			'manage_options',
			'dfm-wp-public-menu',
			array( $this, 'render_menu_page' ),
			'dashicons-media-code',
			80
		);
	}

	/**
	 * Simply renders the plugin's menu page.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function render_menu_page() {
		include VIEWS_PATH . 'dfm-wp-public-options-page.php';
	}

	/**
	 * Action handler.
	 * Does prep work for displaying posts within a chosen category.
	 *
	 * @param  string $category_slug The category slug which we'll use to grab a term id.
	 * @param  array  $args          Query args sent to action handler which we'll merge with some defaults later.
	 * @return void
	 */
	public function render_content( $category_slug, $args ) {
		$term_id = $this->retrieve_object_property_from_array( $this->categories, 'slug', $category_slug );

		/**
		 * Sanity check on $term_id,
		 * if it's null that means there aren't
		 * any posts associated with category
		 * and we can bail.
		 */
		if ( is_null( $term_id ) ) :
			do_action( 'dfm-wp-public_render_no_content_found', $category_slug );
			return;
		endif;

		// merge term id into arguments.
		$args = array_merge( $args, array( 'cat' => $term_id ) );

		$content = $this->fetch_content( $args );
		$this->display_content( $content, $category_slug );
	}

	/**
	 * Displays content with template tags, listing posts within
	 * a chosen category.
	 *
	 * @since        1.0.0
	 * @access       public
	 * @param array  $content       The array of content to be iterated.
	 * @param string $category_slug The slug of the category used if there are no posts found.
	 * @return void
	 */
	public function display_content( $content, $category_slug ) {
		if ( $content->have_posts() ) :
			while ( $content->have_posts() ) :
				$content->the_post();
				include VIEWS_PATH . 'template-parts/loop-category-post.php';
			endwhile;
			wp_reset_postdata();
		else :
			do_action( 'dfm-wp-public_render_no_content_found' );
		endif;
	}

	/**
	 * Action handler.
	 * Displays a message that no content was found for the chosen category.
	 *
	 * @since        1.0.0
	 * @access       public
	 * @param string $category_slug The slug of the chosen category, used for messaging.
	 * @return void
	 */
	public function display_no_content_found_message( $category_slug ) {
		include VIEWS_PATH . 'template-parts/content-not-found.php';
	}

	/**
	 * Filter to capitalize words in a string.
	 *
	 * @since         1.0.0
	 * @access        public
	 * @param  string $string The string to run through the filter.
	 * @return string
	 */
	public function capitalize_word( $string ) {
		return esc_html( ucwords( $string ) );
	}

	/**
	 * Just a wrapper to make following the code a bit easier.
	 *
	 * @since        1.0.0
	 * @access       private
	 * @param  array $args    WP_Query arguments.
	 * @return \WP_Query
	 */
	private function fetch_content( $args ) {
		$content = $this->performQuery( $args );
		return $content;
	}

	/**
	 * Performs a query and returns results.
	 *
	 * @since        1.0.0
	 * @access       private
	 * @param  array $args Query arguments.
	 * @return \WP_Query
	 */
	private function performQuery( $args ) {
		$args = array_merge(
			$args,
			array(
				'order'   => 'desc',
				'orderby' => 'date',
			)
		);

		$result = new \WP_Query( $args );
		return $result;
	}

	/**
	 * Retrieves value of an object property
	 * from an array of objects.
	 *
	 * @since         1.0.0
	 * @access        private
	 * @param  array  $arr          An array of objects.
	 * @param  string $search_key   The key we're searching for.
	 * @param  value  $search_value The key's value which we'll use for comparison.
	 * @param  string $desired_prop The property value desired.
	 * @return mixed
	 */
	private function retrieve_object_property_from_array( $arr, $search_key, $search_value, $desired_prop = 'term_id' ) {
		$property = array_values(
			array_filter(
				$arr,
				function( $item ) use ( &$search_key, &$search_value, &$desired_prop ) {
					return $search_value === $item->$search_key;
				}
			)
		);

		return( ! empty( $property ) )
			? $property[0]->$desired_prop
			: null;
	}
}
