<?php
/**
 * Class KotwSetup_Init
 */
if ( !class_exists( 'KotwSetup_Init' ) ):
class KotwSetup_Init {


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
	 * BNews_Init constructor.
	 */
	public function __construct() {
		$this->prefix       = 'kotwSetup';
		$this->plugin_url   = dirname( plugin_dir_url(__FILE__) );
		$this->plugin_path  = dirname( plugin_dir_path( __FILE__ ) );
		$this->text_domain  = 'kotwSetup';
	}

}
new KotwSetup_Init();

endif;