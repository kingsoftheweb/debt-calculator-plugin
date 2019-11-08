<?php
/**
 * Class DCP_Meta_Boxes
 */
if( !class_exists( 'DCP_Meta_Boxes' ) ):
class DCP_Meta_Boxes extends DCP_Init {

	/**
	 * DCP_Meta_Boxes constructor.
	 */
	public function __construct() {
		parent::__construct();

		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_meta_boxes_kotw_debt' ) );
	}

	public function add_meta_boxes () {
		add_meta_box(
			$this->prefix . '-debts_options',
			'Debts Options',
			array( $this, 'debts_options_callback' ),
			'kotw_debt',
			'normal'
		);
	}


	// Callbacks.
	public function debts_options_callback () {
		wp_nonce_field( 'debt_kotw_debts_options', 'debt_kotw_debts_options' );
		include $this->plugin_path . '/admin/partials/meta-boxes/debts-options.php';
	}



	/**
	 *  save_meta_boxes_kotw_debt
	 *  Save meta box for kotw_debt custom post type.
	 */

	public function save_meta_boxes_kotw_debt ( $post_id ) {
		if ( get_post_type( $post_id ) !== 'kotw_debt' ) return;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		if ( !current_user_can( 'edit_post', $post_id ) ) return;
		if ( ! isset( $_POST['debt_kotw_debts_options'] ) || ! wp_verify_nonce( $_POST['debt_kotw_debts_options'], 'debt_kotw_debts_options' ) ) return;


		// Saving text values.
		$meta_text_values = [
			$this->prefix . '_remaining_debt',
			$this->prefix . '_paid_amount',
			$this->prefix . '_yearly_interest',
		];

		foreach ( $meta_text_values as $meta ) {
			if ( isset( $_POST[$meta] ) ) {
				$meta_value = $_POST[$meta];
				update_post_meta( $post_id, $meta, $meta_value );
			}
		}

	}
}

new DCP_Meta_Boxes();
endif;