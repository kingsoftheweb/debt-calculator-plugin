<?php


class DCP_Export_Data extends DCP_Init {

	/**
	 * DCP_Export_Data constructor.
	 */
	public function __construct() {
		parent::__construct();
	}

	public function init_data ( $author_id ) {
		$dcp_functions = new DCP_Functions();
		$all_debts = get_posts(
			array(
				'post_type'   => 'kotw_debt',
				'post_status' => 'publish',
				'numberposts' => -1,
				'author' => $author_id,
			)
		);
		$all_debts_array = [];
		$all_debts_logs  = [];
		foreach ( $all_debts as $key=>$debt ) {
			$debt_id = isset( $debt ) ? $debt->ID : 0;
			if ( 0 !== $debt_id ):
				$total_paid      = get_post_meta( $debt_id, $this->prefix . '_total_paid', true );
				$remaining       = get_post_meta( $debt_id, $this->prefix . '_remaining_debt', true );
				$yearly_interest = get_post_meta( $debt_id, $this->prefix . '_yearly_interest', true );
				$start_date      = get_the_date( 'd-m-Y', $debt_id );
				$all_debts_array[] = array(
					'Debt'       => $debt->post_title,
					'Paid'       => $total_paid,
					'Remaining'  => '$' . number_format( ( float ) $remaining ),
					'Interest'   => $yearly_interest . '%',
					'Payment Date' => $start_date

				);
				$current_debt_all_logs_array    = json_decode( $dcp_functions->get_debt_logs( $debt_id )['debt_logs_json'] );
				foreach ($current_debt_all_logs_array as $single_debt_logs ) {
					$all_debts_logs[] = $single_debt_logs;
				}
			endif;
		}


		return array(
			'all_debts_array' => $all_debts_array,
			'all_debts_logs'  => $all_debts_logs
		);
	}

	public function export_single_debt_to_pdf() {

	}

	public function export_single_debt_to_excel() {

	}

	public function export_all_debts_to_pdf ( $author_id ) {
		$data = $this->init_data( $author_id );

		return $data;
	}

	public function export_all_debts_to_excel( $author_id ) {

		$data = $this->init_data( $author_id );
		$all_debts_array = $data['all_debts_array'];
		$all_debts_array[] = array(
			'',
			'',
			'',
			''
		);
		$all_debts_array[] = array(
			'',
			'ALL PAYMENTS',
			'',
			''
		);
		$all_logs_array  = $data['all_debts_logs'];
		$all_logs_array = json_decode(json_encode( $all_logs_array ), True); // converts std-class object to array.


		$file_name_1 = 'debts_report_' . $author_id . '_' . date('d_m_Y');
		$file_name_2 = 'payments_report_' . $author_id . '_' . date('d_m_Y');

		/*echo '<pre>';
		print_r( $all_debts_array );
		echo '</pre>';
		*/

		//$this->outputCsv( $file_name_1 . '.csv', $all_debts_array );
		$this->outputCsv( $file_name_2 . '.csv', array_merge( $all_debts_array,$all_logs_array ) );

	}


	public function is_user_allowed ( $debts_author_id ) {

		if( $debts_author_id === get_current_user_id() || current_user_can( 'administrator' ) ) return true;
		else return false;
	}

	public function outputCsv($fileName, $assocDataArray) {
		ob_clean();
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private', false);
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment;filename=' . $fileName);
		if(isset($assocDataArray['0'])){
			$fp = fopen('php://output', 'w');
			fputcsv($fp, array_keys($assocDataArray['0']));
			foreach($assocDataArray AS $values){
				fputcsv($fp, $values);
			}
			fclose($fp);
		}
		ob_flush();
	}
}

new DCP_Init();