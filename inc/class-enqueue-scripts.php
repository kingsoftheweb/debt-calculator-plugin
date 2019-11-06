<?php
/**
 * Class KotwSetup_Enqueue_Scripts
 */

if( !class_exists( 'KotwSetup_Enqueue_Scripts' ) ):
class KotwSetup_Enqueue_Scripts extends KotwSetup_Init {


	/**
	 * KotwSetup_Enqueue_Scripts constructor.
	 */
	public function __construct() {
		parent::__construct();

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'front_scripts' ) );
	}


	/**
	 * admin_scripts
	 */
	public function admin_scripts () {
		wp_enqueue_style( $this->prefix . '-admin',  $this->plugin_url . '/admin/sass/admin.css', [], time() );
		wp_enqueue_script( $this->prefix . '-admin', $this->plugin_url . '/admin/js/admin.min.js', [], time(), true );
	}


	/**
	 * front_scripts
	 */
	public function front_scripts () {
		wp_enqueue_style( $this->prefix . '-front',  $this->plugin_url . '/front/sass/front.css', [], time() );
		wp_enqueue_script( $this->prefix . '-front', $this->plugin_url . '/front/js/front.min.js', [], time(), true );
	}
}

new KotwSetup_Enqueue_Scripts();
endif;
