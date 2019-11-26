<div class="arm_account_detail_tab arm_account_detail_tab_content arm_account_content_active"
     data-tab="debts-list">
	<div class="arm_account_detail_tab_heading">Debts List</div>
    <div class="total-debts-chart">
		<?php include_once $this->plugin_path . '/front/partials/shortcodes/debt-calculator/reports-charts/total-debts-chart.php'; ?>
    </div>
	<div class="arm_account_detail_tab_body arm_account_detail_tab_debts-list">
		<div class="arm_view_profile_wrapper arm_account_detail_block">
			<table class="form-table">
				<tr>
					<th class="arm-form-table-label">Debt</th>
					<th class="arm-form-table-label">Remaining</th>
					<th class="arm-form-table-label">Paid</th>
					<th class="arm-form-table-label">Yearly Interest</th>
				</tr>
				<?php

				$debts = get_posts(
					array(
						'post_type'   => 'kotw_debt',
						'post_status' => 'publish'
					)
				);
				foreach ( $debts as $debt ) {
					$debt_id = isset( $debt ) ? $debt->ID : 0;
					if ( 0 !== $debt_id ):
                        $total_paid      = get_post_meta( $debt_id, $this->prefix . '_total_paid', true );
                        $remaining       = get_post_meta( $debt_id, $this->prefix . '_remaining_debt', true );
                        $yearly_interest = get_post_meta( $debt_id, $this->prefix . '_yearly_interest', true );

						?>
						<tr data-id="<?php echo $debt_id; ?>">
							<td class="arm-form-table-content"><a href = "<?php echo get_edit_post_link( $debt_id );?>" target = "_blank"><?php echo $debt->post_title; ?></a></td>
							<td class="arm-form-table-content">$<?php echo number_format( (float) $remaining ); ?></td>
							<td class="arm-form-table-content">$<?php echo number_format( (float) $total_paid ); ?></td>
							<td class="arm-form-table-content"><?php echo $yearly_interest; ?>%</td>

						</tr>
					<?php
					endif;
				}

				?>
			</table>
		</div>
	</div>
</div>