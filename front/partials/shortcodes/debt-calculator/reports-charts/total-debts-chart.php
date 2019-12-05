<?php

$user_id = $author;

$debts = get_posts(
	array(
		'post_type'   => 'kotw_debt',
		'post_status' => 'publish',
		'numberposts' => -1,
		'author'      => $author
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
if( 0 == ( (float) $total_debt_paid + (float) $total_debt_remaining ) ) {
	$paid_progress = 0;
} else {
	$paid_progress   = 100 * (float)$total_debt_paid / ( (float) $total_debt_paid + (float) $total_debt_remaining );
}

if( 0 == ( (float) $total_debt_paid + (float) $total_debt_remaining ) ) {
	$remaining_progress = 0;
} else {
	$remaining_progress = 100 * (float)$total_debt_remaining / ( (float) $total_debt_paid + (float) $total_debt_remaining );
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
            <h4 class="title">Total Paid :
	            <span class="content">$<?php echo number_format( $total_debt_paid ) . ' (<em>' . round( $paid_progress, 2 );  ?>%</em>)</span>
            </h4>

        </div>
        <div class="row">
            <h4 class="title">Total Remaining : <span class="content">$<?php echo number_format( $total_debt_remaining ) . ' (<em>' . round( $remaining_progress, 2 );  ?>%</em>)</span></h4>

        </div>

	    <div class="row export">
		    <div class="export-current-debt">
                <a class="button-primary export-pdf"
                   hrefff = "<?php echo $this->plugin_url . '/export-pdf.php?type=all&user_id=' . $user_id . '" target="_blank" data-userID = "' . $user_id . '" 
                   data-href = "' . $this->plugin_url . '/export-pdf.php?type=all&user_id=' . $user_id;?>"
                   data-meta = "<?php echo $this->prefix . '_canvas_data_'; ?>"
                   data-id = "<?php echo $debt_id; ?>">Export All Debts to PDF</a>
		    </div>
	    </div>
	    <div class="row export">
		    <div class="export-current-debt">
			    <a class="button-primary export-excel" href = "<?php echo $this->plugin_url . '/export-excel.php?type=all&user_id=' . $user_id . '" target="_blank" data-href = "' . $this->plugin_url . '/export-excel.php?type=all&user_id=' . $user_id;?>" data-id = "<?php echo $debt_id; ?>">Export All Debts to Excel</a>
		    </div>
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
	            'numberposts' => -1,
	            'author'      => $author
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
			'author' => get_current_user_id()
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