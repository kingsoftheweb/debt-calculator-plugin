<?php
$debts = get_posts(
	array(
		'post_type'   => 'kotw_debt',
		'post_status' => 'publish',
		'post_author' => get_current_user_id()
	)
);
$total_debt_remaining = 0;
$total_debt_paid      = 0;
foreach ($debts as $debt) {
	$debt_id = isset( $debt ) ? $debt->ID : 0;
	if( 0 !== $debt_id ) {
		$total_debt_remaining += (float) get_post_meta( $debt_id, $this->prefix . '_remaining_debt', true );
		$total_debt_paid      += (float) get_post_meta( $debt_id, $this->prefix . '_total_paid', true );
	}

}
$total_debt_info = array(
	'remaining' => $total_debt_remaining,
	'paid'      => $total_debt_paid
);
?>
<div class="total-debts-chart__main">
	<input type = "hidden" name = "total_debts_info" value = '<?php echo json_encode( $total_debt_info ); ?>'/>
	<canvas class="total-debts-canvas debts-reports doughnut-chart"></canvas>
</div>