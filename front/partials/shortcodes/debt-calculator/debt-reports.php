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
						$functions = new DCP_Functions();
						$debt_logs = $functions->get_debt_logs( $debt_id );
						?>
						<tr data-id="<?php echo $debt_id; ?>">
							<td class="arm-form-table-content tab-has-result">
                                <span class = "title"><?php echo $debt->post_title; ?></span>
                                <div class="results-tab">
	                                <div class="current-debt-values">
		                                <?php
		                                $current_debt_values = json_decode( $debt_logs['current_debt_values'] );
		                                ?>
		                               <p>
			                                <b>Title: </b><span class="debt-title"><?php echo $current_debt_values->title; ?></span>
		                                </p>

		                               <p>
			                                <b>Remaining: </b><span class="debt-remaining"><?php echo $current_debt_values->remaining; ?></span>
		                                </p>
		                                <p>
			                                <b>Total Paid: </b><span class="debt-paid"><?php echo $current_debt_values->total_paid; ?></span>
		                                </p>
		                                <p>
			                                <b>Yearly Interest: </b><span class="debt-paid"><?php echo $current_debt_values->yearly_interest; ?></span>
		                                </p>

	                                </div>

	                                <div class="reports-graphics">
		                                <input type = "hidden" class = "current-debt-values" data-id = "<?php echo $debt_id; ?>" value = '<?php echo $debt_logs['current_debt_values']; ?>'/>
		                                <input type = "hidden" class = "debt-logs-json" data-id = "<?php echo $debt_id; ?>" value = '<?php echo $debt_logs['debt_logs_json']; ?>'/>

		                                <div class="single-graphics-wrapper">
			                                <canvas class="debts-reports doughnut-chart" data-id = "<?php echo$debt_id; ?>"></canvas>
		                                </div>
		                                <div class="debts-logs">
			                                <?php
			                                echo $debt_logs['debt_logs_html'];
			                                ?>
		                                </div>
		                                <div class="single-graphics-wrapper">
			                                <canvas class="debts-reports line-chart" data-id = "<?php echo$debt_id; ?>"></canvas>
		                                </div>

	                                </div>

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