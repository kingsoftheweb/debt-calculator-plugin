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


		// Admin Menus
		add_action( 'admin_menu', array( $this, 'admin_pages' ) );
	}

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


}

new DCP_Admin_Init();
endif;
