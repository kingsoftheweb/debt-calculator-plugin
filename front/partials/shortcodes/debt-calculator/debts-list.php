<div class="arm_account_detail_tab arm_account_detail_tab_content arm_account_content_active"
     data-tab="debts-list">
	<div class="arm_account_detail_tab_heading">Debts List</div>
	<div class="arm_account_detail_tab_body arm_account_detail_tab_debts-list">
		<div class="arm_view_profile_wrapper arm_account_detail_block">
			<table class="form-table">
				<tr>
					<th class="arm-form-table-label">Debt</th>
					<th class="arm-form-table-label">Remaining</th>
					<th class="arm-form-table-label">Paid</th>
					<th class="arm-form-table-label">Yearly Interest</th>
<!--                    <th class="arm-form-table-label">Update</th>-->
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
						?>
						<tr data-id="<?php echo $debt_id; ?>">
							<td class="arm-form-table-content"><a href = "<?php echo get_edit_post_link( $debt_id );?>" target = "_blank"><?php echo $debt->post_title; ?></a></td>
							<td class="arm-form-table-content"><?php echo $debt_id; ?></td>
							<td class="arm-form-table-content"><?php echo $debt_id; ?></td>
							<td class="arm-form-table-content"><?php echo $debt_id; ?></td>
<!--							<td class="arm-form-table-content" data-id = "--><?php //echo $debt_id; ?><!--">Update</td>-->

						</tr>
					<?php
					endif;
				}

				?>
			</table>
		</div>
	</div>
</div>