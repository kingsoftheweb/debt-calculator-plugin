<div class="arm_account_detail_tab arm_account_detail_tab_content arm_account_content_active"
     data-tab="debts-list">
	<div class="arm_account_detail_tab_heading">Debts List</div>
    <div class="total-debts-chart">
		<?php include_once $this->plugin_path . '/front/partials/shortcodes/debt-calculator/reports-charts/total-debts-chart.php'; ?>
    </div>
	<div class="arm_account_detail_tab_body arm_account_detail_tab_debts-list">
		<div class="arm_view_profile_wrapper arm_account_detail_block">
			<h4>All Debts</h4>
			<table class="form-table all-debts">
				<tr>
					<th class="arm-form-table-label">Debt</th>
					<th class="arm-form-table-label">Remaining</th>
					<th class="arm-form-table-label">Paid</th>
					<th class="arm-form-table-label">Yearly Interest</th>
					<th class="arm-form-table-label">Start Date</th>
				</tr>
				<?php

				$debts = get_posts(
					array(
						'post_type'   => 'kotw_debt',
						'post_status' => 'publish',
						'numberposts' => -1,
						'post_author' => get_current_user_id()
					)
				);
				foreach ( $debts as $debt ) {
					$debt_id = isset( $debt ) ? $debt->ID : 0;
					if ( 0 !== $debt_id ):
						$total_paid      = get_post_meta( $debt_id, $this->prefix . '_total_paid', true );
						$remaining       = get_post_meta( $debt_id, $this->prefix . '_remaining_debt', true );
						$yearly_interest = get_post_meta( $debt_id, $this->prefix . '_yearly_interest', true );
						$start_date      = get_the_date( 'd-m-Y', $debt_id );

						?>
						<tr data-id="<?php echo $debt_id; ?>">
							<td class="arm-form-table-content"><a href = "<?php echo get_edit_post_link( $debt_id );?>" target = "_blank"><?php echo $debt->post_title; ?></a></td>
							<td class="arm-form-table-content">$<?php echo number_format( (float) $remaining ); ?></td>
							<td class="arm-form-table-content">$<?php echo number_format( (float) $total_paid ); ?></td>
							<td class="arm-form-table-content"><?php echo $yearly_interest; ?>%</td>
							<td class="arm-form-table-content"><?php echo $start_date; ?></td>

						</tr>
					<?php
					endif;
				}

				?>
			</table>

			<h4>Yearly Payments</h4>
			<?php
			$functions = new DCP_Functions();
			$payments_per_years = $functions->get_total_payments_per_year( get_current_user_id() );
			$payments_per_years = array_reverse( $payments_per_years ); // Re-arrange years array to be DESC.
			?>

			<div class="yearly-payments-chart__main">
				<input type = "hidden" name = "yearly_payments_values" value = '<?php echo json_encode( $payments_per_years ); ?>'/>
				<canvas class="yearly-payments-canvas line-chart"></canvas>
			</div>


			<table class="form-table yearly-payments">
				<tr>
					<th class="arm-form-table-label">Year</th>
					<th class="arm-form-table-label">Number of Debts</th>
					<th class="arm-form-table-label">Total Paid</th>
				</tr>
				<?php
				foreach ( $payments_per_years as $year_info ) {
					$total_paid = 0;
					$number_of_debts = count( $year_info['debts'] );
					foreach ( $year_info['debts'] as $debt ) {
						$total_paid += (float)$debt['debt_values']['total_paid'];
					}
					?>
					<tr>
						<td><?php echo $year_info['year'];?></td>
						<td><?php echo $number_of_debts;?></td>
						<td><?php echo number_format( $total_paid );?></td>
					</tr>
					<?php
				}
			/*	echo '<pre>';
				print_r($payments_per_years);
				echo '</pre>';*/

				?>
			</table>


		</div>
	</div>
</div>