<!--<div class="dcm-wrapper">
    <div class="dcm-heading">List of Debts</div>
    <table>
        <tr>
            <th>Debt</th>
            <th>Remaining</th>
            <th>Paid</th>
            <th>Yearly Interest</th>
        </tr>
    </table>
</div>-->


<div class="dcm-shortcode">
    <h3>Debt Control</h3>
    <div class="arm-tabs dcm-wrapper dcm-shortcode">
        <div class = "single-tab active arm-form-table-label" data-id = "debts-list">Debts List</div>
        <div class = "single-tab arm-form-table-label" data-id = "new-debt">Add New Debt</div>
    </div>

    <div class="arm_account_detail_wrapper">
        <div class="arm_account_detail_tab_content_wrapper" style="border:1px solid #dee3e9;">

            <div class    = "arm_account_detail_tab arm_account_detail_tab_content arm_account_content_active active"
                 data-tab = "debts-list">
                <div class="arm_account_detail_tab_heading">Debts List</div>
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
                                if( 0 !== $debt_id ):
                                ?>
                                <tr data-id = "<?php echo $debt_id; ?>">
                                    <td class="arm-form-table-content"><?php echo $debt->post_title;?></td>
                                    <td class="arm-form-table-content"><?php echo $debt_id;?></td>
                                    <td class="arm-form-table-content"><?php echo $debt_id;?></td>
                                    <td class="arm-form-table-content"><?php echo $debt_id;?></td>

                                </tr>
                                <?php
                                endif;
                            }

                            ?>
                        </table>
                    </div>
                </div>
            </div>


            <div class    = "arm_account_detail_tab arm_account_detail_tab_content arm_account_content_active"
                 data-tab = "new-debt">
                <div class="arm_account_detail_tab_heading">Add New Debt</div>
                <div class="arm_account_detail_tab_body arm_account_detail_tab_debts-list">
                    <div class="arm_view_profile_wrapper arm_account_detail_block">

                        <div id = "debt-calculator-shortcode" class="dcm-wrapper dcm-shortcode">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="debt-calculator">
                                        <div class="result">
                                            <div class="result-text">
                                                <h1><span id="bmiValue">24.8 </span>kg/m2</h1><small id="bmid">Normal</small>
                                            </div>
                                        </div>
                                        <div class="calculator">
                                            <h2 class="text-center calculator-title">What's Your BMI?</h2>
                                            <hr class="calculator-hr">
                                            <div class="height">
                                                <input class="value_range" id="height" type="range" value="182" min="100" max="250" step="1" style="background-image: -webkit-gradient(linear, 0% 0%, 100% 0%, color-stop(0.02, rgb(247, 57, 70)), color-stop(0.02, rgb(39, 40, 58)));">
                                                <div class="label-height field-text">103</div>
                                            </div>
                                            <div class="weight">
                                                <input class="value_range" id="weight" type="range" value="82" min="0" max="250" step="1" style="background-image: -webkit-gradient(linear, 0% 0%, 100% 0%, color-stop(0.424, rgb(247, 57, 70)), color-stop(0.424, rgb(39, 40, 58)));">
                                                <div class="label-weight field-text">106</div>
                                            </div>
                                            <div class="submit">
                                                <input class="submit" type="submit" id="submit" value="Calculate">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>


        </div>
    </div>

</div>





<!--<div id = "debt-calculator-shortcode" class="dcm-wrapper dcm-shortcode">
	<div class="row">
		<div class="col-md-12">
			<div class="debt-calculator">
				<div class="result">
					<div class="result-text">
						<h1><span id="bmiValue">24.8 </span>kg/m2</h1><small id="bmid">Normal</small>
					</div>
				</div>
				<div class="calculator">
					<h2 class="text-center calculator-title">What's Your BMI?</h2>
					<hr class="calculator-hr">
					<div class="height">
						<input class="value_range" id="height" type="range" value="182" min="100" max="250" step="1" style="background-image: -webkit-gradient(linear, 0% 0%, 100% 0%, color-stop(0.02, rgb(247, 57, 70)), color-stop(0.02, rgb(39, 40, 58)));">
						<div class="label-height field-text">103</div>
					</div>
					<div class="weight">
						<input class="value_range" id="weight" type="range" value="82" min="0" max="250" step="1" style="background-image: -webkit-gradient(linear, 0% 0%, 100% 0%, color-stop(0.424, rgb(247, 57, 70)), color-stop(0.424, rgb(39, 40, 58)));">
						<div class="label-weight field-text">106</div>
					</div>
					<div class="submit">
						<input class="submit" type="submit" id="submit" value="Calculate">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>-->