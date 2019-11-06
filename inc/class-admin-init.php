<?php
/**
 * Class KotwSetup_Admin_Init
 */
if( !class_exists( 'KotwSetup_Admin_Init' ) ):
class KotwSetup_Admin_Init extends KotwSetup_Init {


	/**
	 * KotwSetup_Admin_Init constructor.
	 */
	public function __construct() {
		parent::__construct();

		// Login Page
		add_action( 'login_enqueue_scripts',array( $this, 'kotw_login_logo' ) );

		// Admin Menus
		add_action( 'admin_menu', array( $this, 'admin_pages' ) );
	}

	public function admin_pages () {

		/*
		add_menu_page(
			'Breaking News',
			'Breaking News',
			'manage_options',
			'breaking_news',
			array( $this, 'admin_main_page_callback' ),
			'dashicons-controls-volumeon',
			5
		);
		*/
	}


	public function admin_main_page_callback () {
		//include $this->plugin_path . '/admin/partials/dashboard-pages/admin-main-page.php';
	}

	public function kotw_login_logo () {
		include $this->plugin_path . '/admin/partials/login-page/login-page.php';
	}



}

new KotwSetup_Admin_Init();
endif;
