<?php
if( !isset( $_GET['type'] ) && $_GET['user_id'] ) die();

require( '../../../wp-load.php' );
$export = new DCP_Export_Data();
$type    = $_GET['type'];
$user_id = $_GET['user_id'];
if( 'all' === $type ) {

	if( !$export->is_user_allowed( $user_id ) ) {
		echo 'You are not allowed to get results for the report';
	} else {
		$export->export_all_debts_to_excel( $user_id );
	}

}