<?php
/**
 * Class DCP_Admin_Init
 */
if( !class_exists( 'DCP_Admin_Init' ) ):
class DCP_Admin_Init extends DCP_Init {


	/**
	 * DCP_Admin_Init constructor.
	 */
	public function __construct() {
		parent::__construct();

		add_action( 'admin_menu', array( $this, 'admin_pages' ) );
		add_action( 'wp_dashboard_setup', array( $this, 'add_dashboard_widgets' ) );
	}

	/**
	 * admin_pages
	 * Registers all admin pages and subpages needed for the dcm plugin.
	 */
	public function admin_pages () {

		add_menu_page(
			'Debt Calculator',
			'Debt Calculator',
			'manage_options',
			'debt_calculator_main',
			array( $this, 'debt_calculator_main_callback' ),
			'dashicons-controls-volumeon',
			5
		);

		add_submenu_page(
			'debt_calculator_main',
			'Documentation',
			'Documentation',
			'manage_options',
			'debt_calculator_documentation',
			array( $this, 'debt_calculator_doc_callback' )
		);

	}


	/**
	 *  add_dashboard_widgets
	 *  Registers all dashboard widgets needed for the dcm plugin.
	 */
	public function add_dashboard_widgets () {
		wp_add_dashboard_widget(
			'dcm_debt_calculator_results',
			'Debt Calculator Results',
			array( $this, 'dcm_debt_calculator_results_callback' )
		);
	}


	/** Admin Menu Pages Callbacks */
	public function debt_calculator_main_callback () {
		include $this->plugin_path . '/admin/partials/dashboard-pages/admin-main-page.php';
	}

	public function debt_calculator_doc_callback () {
		$doc_url = $this->plugin_url . '/admin/partials/dashboard-pages/documentation-page/start.html';
		?>
		<iframe
			src    ="<?php echo $doc_url; ?>"
			width  = "100%"
			height = "1000px"
			border = 0
		></iframe>
		<?php
		//include $this->plugin_path . '/admin/partials/dashboard-pages/documentation-page/start.html';
	}
	/************ End of Admin Menu Pages Callbacks ****************/


	/** Admin Dashboard Widgets Callbacks */
	public function dcm_debt_calculator_results_callback () {
		include $this->plugin_path . '/admin/partials/dashboard-widgets/debt-calculator-results.php';
	}
	/************ End of Admin Dashboard Widgets****************/


}

new DCP_Admin_Init();
endif;
