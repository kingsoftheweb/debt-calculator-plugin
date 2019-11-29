<div class="arm_account_detail_tab arm_account_detail_tab_content arm_account_content_active"
     data-tab="update-debt">
	<div class="arm_account_detail_tab_heading">Debts List</div>
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
						'post_status' => 'publish',
						'numberposts' => -1,
						'author' => get_current_user_id()
					)
				);
				foreach ( $debts as $debt ) {
					$debt_id   = isset( $debt ) ? $debt->ID : 0;
					$remaining = get_post_meta( $debt_id, $this->prefix . '_remaining_debt', true );
					$interest  = get_post_meta( $debt_id, $this->prefix . '_yearly_interest', true );
					if ( 0 !== $debt_id ):
						?>
                        <tr data-id="<?php echo $debt_id; ?>">
                            <td class="arm-form-table-content tab-has-result">
                                <span class = "title"><?php echo $debt->post_title; ?></span>
                                <div class="results-tab">
                                    <div class="update-debt-form">
                                        <input type = "hidden" value = "<?php echo $debt_id; ?>" name = "debt_id"/>
                                        <h3>New Payment</h3>
                                        <p class="input-field">
                                            <input type = "hidden" name = "remaining" value = "<?php echo $remaining; ?>" />
                                            <input type = "hidden" name = "interest" value = "<?php echo $interest; ?>" />
                                            <input type = "number" step = "0.01" name = "pay_amount" />
                                        </p>
                                        <p class="input-field">
                                            <input type = "submit" class = "submit update-debt" value = "Update" />
                                        </p>
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