<?php


class DCP_Ajax extends DCP_Init{

	/**
	 * DCP_Ajax constructor.
	 */
	public function __construct() {
		parent::__construct();

		add_action( 'wp_ajax_add_dcp_debt', array( $this, 'add_dcp_debt' ) );
		add_action( 'wp_ajax_nopriv_add_dcp_debt', array( $this, 'add_dcp_debt' ) );

		add_action( 'wp_ajax_update_dcp_debt', array( $this, 'update_dcp_debt' ) );
		add_action( 'wp_ajax_nopriv_update_dcp_debt', array( $this, 'update_dcp_debt' ) );

	}

	public function update_dcp_debt () {

		$functions = new DCP_Functions();
		$functions->update_debt_logs(
			$_POST['debtID'],
			$_POST['remaining'],
			$_POST['paid'],
			$_POST['interest']
		);
		wp_die();
	}


	public function add_dcp_debt () {

		$debt_id = wp_insert_post(
			array(
				'post_type'   => 'kotw_debt',
				'post_status' => 'publish',
				'post_title'  => sanitize_text_field( $_POST['debt_title'] ),
				'author' => sanitize_text_field( $_POST['author_id'] )
			)
		);
		if( $debt_id ) {
			update_post_meta( $debt_id, $this->prefix . '_remaining_debt', sanitize_text_field( $_POST['debt_amount'] ) );
			update_post_meta( $debt_id, $this->prefix . '_yearly_interest', sanitize_text_field( $_POST['yearly_interest'] ) );
			update_post_meta( $debt_id, $this->prefix . '_paid_amount', 0 );

			echo $debt_id;
		}


		wp_die();
	}



}

new DCP_Ajax();