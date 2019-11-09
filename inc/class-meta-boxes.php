<?php
/**
 * Class DCP_Meta_Boxes
 */
if ( ! class_exists( 'DCP_Meta_Boxes' ) ):
	class DCP_Meta_Boxes extends DCP_Init {

		/**
		 * DCP_Meta_Boxes constructor.
		 */
		public function __construct() {
			parent::__construct();

			add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
			add_action( 'save_post', array( $this, 'save_meta_boxes_kotw_debt' ) );
		}

		public function add_meta_boxes() {
			add_meta_box(
				$this->prefix . '-debt_options',
				'Debt Options',
				array( $this, 'debt_options_callback' ),
				'kotw_debt',
				'normal'
			);

			add_meta_box(
				$this->prefix . '-debt_logs',
				'Debt Logs',
				array( $this, 'debt_logs_callback' ),
				'kotw_debt',
				'normal'
			);
		}


		// Callbacks.
		public function debt_options_callback() {
			wp_nonce_field( 'debt_kotw_debt_options', 'debt_kotw_debt_options' );
			include $this->plugin_path . '/admin/partials/meta-boxes/debt-options.php';
		}

		public function debt_logs_callback() {
			wp_nonce_field( 'debt_kotw_debt_options', 'debt_kotw_debt_options' );
			include $this->plugin_path . '/admin/partials/meta-boxes/debt-logs.php';
		}


		/**
		 *  save_meta_boxes_kotw_debt
		 *  Save meta fields for kotw_debt custom post type.
		 */

		public function save_meta_boxes_kotw_debt( $post_id ) {
			if ( get_post_type( $post_id ) !== 'kotw_debt' ) {
				return;
			}

			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
			if ( ! isset( $_POST['debt_kotw_debt_options'] ) || ! wp_verify_nonce( $_POST['debt_kotw_debt_options'], 'debt_kotw_debt_options' ) ) {
				return;
			}


			$meta_values = array(
				array(
					'type' => 'text',
					'meta' => $this->prefix . '_remaining_debt'
				),
				array(
					'type' => 'text',
					'meta' => $this->prefix . '_paid_amount'
				),
				array(
					'type' => 'text',
					'meta' => $this->prefix . '_yearly_interest'
				),

			);

			foreach ( $meta_values as $meta ) {
				if ( isset( $_POST[ $meta['meta'] ] ) ) {
					$meta_value = ( 'text' === $meta['type'] ) ? sanitize_text_field( $_POST[ $meta['meta'] ] ) : $_POST[ $meta['meta'] ];
					update_post_meta( $post_id, $meta['meta'], $meta_value );
				}
			}

			$this->update_debt_logs(
				$post_id,
				$_POST[$this->prefix . '_remaining_debt'],
				$_POST[$this->prefix . '_paid_amount'],
				$_POST[$this->prefix . '_yearly_interest']
			);

		}

		/**
		 * update_debt_logs.
		 * Updates the debt logs with a new entry.
		 *
		 * @param $debt_id
		 * @param $remaining
		 * @param $paid
		 * @param $interest
		 *
		 * @return false|int
		 */
		public function update_debt_logs ( $debt_id, $remaining, $paid, $interest ) {
			global $wpdb;
			$table_name = $wpdb->prefix . $this->prefix . '_debt_logs';

			// Check if any of the values has changed to last debt log for the same debt.
			//$last_debt_log = $wpdb->get_var( $wpdb->prepare( "select " ) );

			$insert = $wpdb->insert( $table_name, array(
				'debt_id'           => $debt_id,
				'remaining'         => $remaining,
				'paid'              => $paid,
				'yearly_interest'   => $interest,
			) );
			return $insert;
		}
	}

	new DCP_Meta_Boxes();
endif;