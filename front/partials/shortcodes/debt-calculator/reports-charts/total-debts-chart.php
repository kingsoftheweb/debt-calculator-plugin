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
        'title'      => 'Total Debts',
        'remaining'  => $total_debt_remaining,
        'total_paid' => $total_debt_paid
);
?>
<div class="total-debts-chart__main">
    <div class="total-debts-header">
        <span class="title">Total Number of Debts : </span>
        <span class="content"><?php echo count( $debts ); ?></span>
    </div>
	<input type = "hidden" name = "total_debts_info" value = '<?php echo json_encode( $total_debt_info ); ?>'/>
	<canvas class="total-debts-canvas doughnut-chart"></canvas>
</div>