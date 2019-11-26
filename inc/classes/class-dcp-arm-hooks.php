<?php

/**
 * Class DCP_ARM_Hooks
 * Registers all the hooks and filters needed for the ARMember plugin for the frontend profile.
 */
class DCP_ARM_Hooks extends DCP_Init {

	/**
	 * DCP_ARM_Hooks constructor.
	 */
	public function __construct() {
		parent::__construct();
		add_filter( 'arm_change_account_details_after_display', array(
			$this,
			'content_after_arm_profile_field'
		), 10, 2 );


	}

	public function content_after_arm_profile_field( $content, $atts ) {
		ob_start();
		echo do_shortcode( '[debt-calculator]' );
		$new_content = ob_get_clean();

		return $content . $new_content;
	}

}

new DCP_ARM_Hooks();