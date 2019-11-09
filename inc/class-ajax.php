<?php


class DCP_Ajax extends DCP_Init{

	/**
	 * DCP_Ajax constructor.
	 */
	public function __construct() {
		parent::__construct();

		add_action( 'wp_ajax_nopriv_update_dcp_debt', array( $this, 'update_dcp_debt' ) );
	}

	public function update_dcp_debt () {

		$debt = new DCP_Meta_Boxes();
		$debt->update_debt_logs(
			$_POST['debtID'],
			$_POST['remaining'],
			$_POST['paid'],
			$_POST['interest']
		);
		wp_die();
	}
}

new DCP_Ajax();