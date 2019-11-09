<div class="arm_account_detail_tab arm_account_detail_tab_content arm_account_content_active"
     data-tab="debts-reports">
	<div class="arm_account_detail_tab_heading">Debts Reports</div>
	<div class="arm_account_detail_tab_body arm_account_detail_tab_debts-list">
		<div class="arm_view_profile_wrapper arm_account_detail_block">
			<table class="form-table">
				<tr>
					<th class="arm-form-table-label">Debt</th>
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
							<td class="arm-form-table-content tab-has-result">
                                <span class = "title"><?php echo $debt->post_title; ?></span>
                                <div class="results-tab">
                                    THis is result tab
                                </div>
                            </td>
						</tr>
					<?php
					endif;
				}

				?>
			</table>
		</div>
	</div>
</div>