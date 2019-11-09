<?php
/**
 * Class DCP_Init
 */
if ( ! class_exists( 'DCP_Init' ) ):
	class DCP_Init {


		/**
		 * @var string $prefix
		 */
		public $prefix;


		/**
		 * @var string $plugin_url
		 */
		public $plugin_url;


		/**
		 * @var string $plugin_path
		 */
		public $plugin_path;


		/**
		 * @var string $text_domain
		 */
		public $text_domain;


		/**
		 * DCP_Init constructor.
		 */
		public function __construct() {
			$this->prefix      = 'debtcalcplugin';
			$this->plugin_url  = dirname( plugin_dir_url( __FILE__ ) );
			$this->plugin_path = dirname( plugin_dir_path( __FILE__ ) );
			$this->text_domain = 'debtcalcplugin';

			$this->init_imports();

		}

		/**
		 * init_imports
		 * Inits all imports needed for the plugin.
		 */
		public function init_imports() {
			require_once $this->plugin_path . '/inc/class-enqueue-scripts.php';
			require_once $this->plugin_path . '/inc/class-admin-init.php';
			require_once $this->plugin_path . '/inc/classes/class-kotw-custom-post.php';
			require_once $this->plugin_path . '/inc/classes/class-kotw-custom-tax.php';


			require_once $this->plugin_path . '/inc/classes/class-dcp-export-data.php';
			require_once $this->plugin_path . '/inc/classes/class-dcp-notifications.php';
			require_once $this->plugin_path . '/inc/classes/class-dcp-arm-hooks.php';

			require_once $this->plugin_path . '/inc/class-meta-boxes.php';

			require_once $this->plugin_path . '/inc/class-ajax.php';

			require_once $this->plugin_path . '/inc/class-shortcodes.php';

		}


		/**
		 *  activate_debtcalcplugin
		 *  Code to be run after plugin is activated.
		 */
		public static function activate_debtcalcplugin() {
			update_option( 'dcp_plugin_activated', time() );
			require_once dirname( plugin_dir_path( __FILE__ ) ) . '/inc/classes/class-dcp-activator.php';
			new DCP_Activator();
		}

		/**
		 * deactivate_debtcalcplugin
		 * Code to be run after plugin is deactivated.
		 */
		public static function deactivate_debtcalcplugin() {
			update_option( 'dcp_plugin_deactivated', time() );
		}

		/**
		 * uninstall_debtcalcplugin
		 * Code to be run after plugin is uninstalled.
		 */
		public static function uninstall_debtcalcplugin() {
			delete_option( 'dcp_plugin_activated' );
			delete_option( 'dcp_plugin_deactivated' );
		}
	}

	new DCP_Init();

endif;