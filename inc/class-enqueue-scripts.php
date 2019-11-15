<?php
/**
 * Class DCP_Enqueue_Scripts
 */

if ( ! class_exists( 'DCP_Enqueue_Scripts' ) ):
	class DCP_Enqueue_Scripts extends DCP_Init {


		/**
		 * DCP_Enqueue_Scripts constructor.
		 */
		public function __construct() {
			parent::__construct();

			add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'front_scripts' ) );
		}


		/**
		 * admin_scripts
		 */
		public function admin_scripts() {
			wp_enqueue_style( $this->prefix . '-admin', $this->plugin_url . '/admin/sass/admin.css', [], time() );
			wp_enqueue_script( $this->prefix . '-admin', $this->plugin_url . '/admin/js/admin.min.js', [], time(), true );
		}


		/**
		 * front_scripts
		 */
		public function front_scripts() {
			// Styles
			//wp_enqueue_style( $this->prefix . '-bootstrap4',  'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css', [], time() );
			wp_enqueue_style( $this->prefix . '-fontawesome',  'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', [], time() );
			wp_enqueue_style( $this->prefix . '-front', $this->plugin_url . '/front/sass/front.css', [], time() );

			// Scripts
			//wp_enqueue_script( $this->prefix . '-bootstrap4', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', array('jquery'), time(), true );

			// Public Libraries
			wp_enqueue_script( $this->prefix . '-chartJS', 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js', [], time(), true );
			wp_enqueue_script( $this->prefix . '-jsPDF', 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js', [], time(), true );

			// Plugin Scripts
			wp_enqueue_script( $this->prefix . '-createChart', $this->plugin_url . '/front/js/createChart.min.js', [], time(), true );
			wp_enqueue_script( $this->prefix . '-exportTable', $this->plugin_url . '/front/js/exportTable.min.js', [], time(), true );
			wp_enqueue_script( $this->prefix . '-front', $this->plugin_url . '/front/js/front.min.js', [], time(), true );
			wp_enqueue_script( $this->prefix . '-shortcodes', $this->plugin_url . '/front/js/shortcodes.min.js', array(
				'jquery',
				'jquery-ui-slider'
			), time(), true );
			wp_localize_script( $this->prefix . '-shortcodes', 'dcp_object',
				array(
					'ajaxurl' => admin_url( 'admin-ajax.php' )
				)
			);
		}
	}

	new DCP_Enqueue_Scripts();
endif;
