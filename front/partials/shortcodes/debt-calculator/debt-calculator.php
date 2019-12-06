<?php
if( is_user_logged_in() ) :

if( isset( $_GET['user_id'] ) ) {
	$author = $_GET['user_id'];
} else {
	$author = get_current_user_id();
}
?>
<div class="dcm-shortcode">
    <div class="arm-tabs dcm-wrapper dcm-shortcode">
        <div class="tabs-grid">
            <div class="single-grid-tab" data-id = "debts-list">
                <div class="icon"><i class="fa fa-th-list"></i></div>
                <div class="title">
                    <h3>Debts Reports</h3>
                </div>
            </div>
            <div class="single-grid-tab" data-id = "add-new-debt">
                <div class="icon"><i class="fa fa-plus-circle"></i></div>
                <div class="title">
                    <h3>Add New Debt</h3>
                </div>
            </div>
            <div class="single-grid-tab" data-id = "update-debt">
                <div class="icon"><i class="fa fa-edit"></i></div>
                <div class="title">
                    <h3>Update a Debt</h3>
                </div>
            </div>
            <div class="single-grid-tab" data-id = "debts-reports">
                <div class="icon"><i class="fa fa-file"></i></div>
                <div class="title">
                    <h3>Debts</h3>
                </div>
            </div>
        </div>

    </div>

	<div class="arm_account_detail_wrapper">
		<div class="arm_account_detail_tab_content_wrapper" style="border:1px solid #dee3e9;">

            <!-- debts-list -->
            <?php include_once $this->plugin_path . '/front/partials/shortcodes/debt-calculator/debts-list.php'; ?>

            <!-- add new debt -->
			<?php include_once $this->plugin_path . '/front/partials/shortcodes/debt-calculator/add-new-debt.php'; ?>

            <!-- update a debt -->
			<?php include_once $this->plugin_path . '/front/partials/shortcodes/debt-calculator/update-debt.php'; ?>


            <!-- debt reports -->
			<?php include_once $this->plugin_path . '/front/partials/shortcodes/debt-calculator/debt-reports.php'; ?>

        </div>
	</div>

</div>
<?php
endif;
?>

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