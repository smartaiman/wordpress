<?php
/**
 * Main class
 *
 * @author Yithemes
 * @package YITH WooCommerce Added to Cart Popup
 * @version 1.0.0
 */


if ( ! defined( 'YITH_WACP' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WACP' ) ) {
	/**
	 * YITH WooCommerce Added to Cart Popup
	 *
	 * @since 1.0.0
	 */
	class YITH_WACP {

		/**
		 * Single instance of the class
		 *
		 * @var \YITH_WACP
		 * @since 1.0.0
		 */
		protected static $instance;

		/**
		 * Plugin version
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $version = YITH_WACP_VERSION;


		/**
		 * Returns single instance of the class
		 *
		 * @return \YITH_WACP
		 * @since 1.0.0
		 */
		public static function get_instance(){
			if( is_null( self::$instance ) ){
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Constructor
		 *
		 * @return mixed YITH_WACP_Admin | YITH_WACP_Frontend
		 * @since 1.0.0
		 */
		public function __construct() {

			// check if mobile
			$enable = wp_is_mobile() && get_option( 'yith-wacp-enable-mobile' ) == 'no' ? false: true;

			// Class admin
			if ( is_admin() && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX && isset( $_REQUEST['context'] ) && $_REQUEST['context'] == 'frontend' ) ) {

				// Load Plugin Framework
				add_action( 'after_setup_theme', array( $this, 'plugin_fw_loader' ), 1 );

				YITH_WACP_Admin_Premium();
				YITH_WACP_Exclusions_Handler();
			}
			elseif( $enable ) {
				YITH_WACP_Frontend_Premium();
			}

			add_action( 'init', array( $this, 'register_size' ) );
		}

		/**
		 * Load Plugin Framework
		 *
		 * @since  1.0
		 * @access public
		 * @return void
		 * @author Andrea Grillo <andrea.grillo@yithemes.com>
		 */
		public function plugin_fw_loader() {

			if ( ! defined( 'YIT' ) || ! defined( 'YIT_CORE_PLUGIN' ) ) {
				require_once( YITH_WACP_DIR . '/plugin-fw/yit-plugin.php' );
			}

		}

		/**
		 * Register size
		 *
		 * @access public
		 * @since 1.0.0
		 * @author Francesco Licandro
		 */
		public function register_size() {
			// set image size
			$size   = get_option( 'yith-wacp-image-size' );
			$width  = isset( $size['width'] ) ? $size['width'] : 0;
			$height = isset( $size['height'] ) ? $size['height'] : 0;
			$crop   = isset( $size['crop'] ) ? $size['crop'] : false;

			add_image_size( 'yith_wacp_image_size', $width, $height, $crop );
		}
	}
}

/**
 * Unique access to instance of YITH_WACP class
 *
 * @return \YITH_WACP
 * @since 1.0.0
 */
function YITH_WACP(){
	return YITH_WACP::get_instance();
}