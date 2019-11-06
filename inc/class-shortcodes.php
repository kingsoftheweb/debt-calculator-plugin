<?php
/**
 * Class KotwSetup_Shortcodes
 */
if( !class_exists( 'KotwSetup_Shortcodes' ) ):
class KotwSetup_Shortcodes extends KotwSetup_Init {

	/**
	 * KotwSetup_Shortcodes constructor.
	 */
	public function __construct() {
		parent::__construct();

		/** Adding Shortcodes */

		// The kotw-footer shortcode.
		add_shortcode( 'kotw-footer', array( $this, 'kotw_footer_callback' ) );
		//Append the kotw-footer shortcode to the footer.
		add_action(
			'wp_footer',
			function () {
				echo do_shortcode( '[kotw-footer]' );
			}
		);

	}


	/** Callbacks */
	public function kotw_footer_callback () {
		ob_start();
		include_once $this->plugin_path . '/front/partials/shortcodes/kotw-footer/kotw-footer.php';
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
}

new KotwSetup_Shortcodes();
endif;