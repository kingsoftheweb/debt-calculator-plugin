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
        <div class="row">
            <h4 class="title">Total Number of Debts : <span class="content"><?php echo count( $debts ); ?></span></h4>

        </div>
        <div class="row">
            <h4 class="title">Total Paid : <span class="content">$<?php echo number_format($total_debt_paid); ?></span></h4>

        </div>
        <div class="row">
            <h4 class="title">Total Remaining : <span class="content">$<?php echo number_format($total_debt_remaining); ?></span></h4>

        </div>


    </div>
	<input type = "hidden" name = "total_debts_info" value = '<?php echo json_encode( $total_debt_info ); ?>'/>
	<canvas class="total-debts-canvas doughnut-chart"></canvas>
</div>


<div class="total-debts-chart__main all_debts">
    <?php

    $get_debts = get_posts(
            array(
	            'post_type'   => 'kotw_debt',
	            'post_status' => 'publish',
	            'post_author' => get_current_user_id()
            )
    );
    $debts_array  = [];
    $labels_array = [];
    foreach ( $get_debts as $debt ) {
        if( isset($debt) ) {
            $debt_id = $debt->ID;
	        $debts_array[]  = get_post_meta( $debt_id, $this->prefix . '_remaining_debt', true );
	        $labels_array[] = get_the_title( $debt_id );
        }
    }
    ?>
    <input type = "hidden" name = "total_debts_info" value = '<?php echo json_encode( $debts_array ); ?>'/>
    <input type = "hidden" name = "total_debts_info_labels" value = '<?php echo json_encode( $labels_array ); ?>'/>
    <canvas class="total-debts-canvas doughnut-chart"></canvas>
</div>

<div class="total-debts-chart__main all_debts">
	<?php

	$get_debts = get_posts(
		array(
			'post_type'   => 'kotw_debt',
			'post_status' => 'publish',
			'post_author' => get_current_user_id()
		)
	);
	$debts_array  = [];
	$labels_array = [];
	foreach ( $get_debts as $debt ) {
		if( isset($debt) ) {
			$debt_id = $debt->ID;
			$debts_array[]  = get_post_meta( $debt_id, $this->prefix . '_remaining_debt', true );
			$labels_array[] = get_the_title( $debt_id );
		}
	}
	?>
    <input type = "hidden" name = "total_debts_info" value = '<?php echo json_encode( $debts_array ); ?>'/>
    <input type = "hidden" name = "total_debts_info_labels" value = '<?php echo json_encode( $labels_array ); ?>'/>
    <canvas class="total-debts-canvas doughnut-chart"></canvas>
</div>