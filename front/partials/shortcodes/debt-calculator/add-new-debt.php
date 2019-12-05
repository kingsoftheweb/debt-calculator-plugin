<div class="arm_account_detail_tab arm_account_detail_tab_content arm_account_content_active"
     data-tab="add-new-debt">
	<div class="arm_account_detail_tab_heading">Add New Debt</div>
	<div class="arm_account_detail_tab_body arm_account_detail_tab_debts-list">
		<div class="arm_view_profile_wrapper arm_account_detail_block">

			<div id="debt-calculator-shortcode" class="dcm-wrapper dcm-shortcode">
				<div class="row">
					<div class="col-md-12">
						<div class="debt-calculator">
							<div class="result">
								<div class="result-text">
                                    <input type = "text" name = "debt_name" placeholder = "Name of Debt"/>
								</div>
							</div>
							<div class="calculator">
								<h2 class="text-center calculator-title">Amount You Owe</h2>
								<div class="height">
                                    <input type = "number" name = "debt_amount" placeholder = "example: 23000"/>
								</div>
                                <h2 class="text-center calculator-title">Yearly Interest (%)</h2>
                                <div class="height">
                                    <input type = "number" name = "yearly_interest" step= "0.1" placeholder = "example: 2"/>
                                </div>
								<div class="submit">
									<input type = "hidden" name = "author_id" value = "<?php echo $author; ?>" />
									<input class="submit add-new-debt" type="submit" id="submit" value="Add New Debt">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>


		</div>
	</div>
</div>