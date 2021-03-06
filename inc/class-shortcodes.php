<?php
/**
 * Class DCP_Shortcodes
 */
if ( ! class_exists( 'DCP_Shortcodes' ) ):
	class DCP_Shortcodes extends DCP_Init {

		/**
		 * DCP_Shortcodes constructor.
		 */
		public function __construct() {
			parent::__construct();

			/** Adding Shortcodes */

			// The debt calculator shortcode.
			add_shortcode( 'debt-calculator', array( $this, 'debt_calculator_shortcode_callback' ) );


			// View Debts for user
			add_shortcode( 'view-debts-user', array( $this, 'view_debts_user_shortcode_callback' ) );


		}


		/** Callbacks */
		public function debt_calculator_shortcode_callback() {
			ob_start();
			include_once $this->plugin_path . '/front/partials/shortcodes/debt-calculator/debt-calculator.php';
			$html = ob_get_contents();
			ob_end_clean();

			return $html;
		}

		public function view_debts_user_shortcode_callback() {
			if( !current_user_can( 'administrator' ) ) {
				return __( 'You are not allowed', 'dcmCalc' );
			} else {
				ob_start();
				include_once $this->plugin_path . '/front/partials/shortcodes/debt-calculator/debt-calculator.php';
				$html = ob_get_contents();
				ob_end_clean();

				return $html;
			}

		}
	}

	new DCP_Shortcodes();
endif;