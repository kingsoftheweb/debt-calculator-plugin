<?php
require( '../../../wp-load.php' );
require( 'inc/classes/class-functions.php' );
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<title>Debt Export</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="export.css?nocache=<?php echo time();?>" rel="stylesheet"/>
	<script src = "https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
	<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
	<script src = "front/js/createChart.min.js"></script>
	<style>

	</style>
</head>
<body>
<?php
if( !isset( $_GET['debt_id'] ) ) exit;

$debt_functions = new DCP_Functions();
$debt_logs      = $debt_functions->get_debt_logs( sanitize_text_field( ( int ) $_GET['debt_id'] ) );

?>
<div id="exportPDF">
	<div class="results-tab">
		<div class="current-debt-info">
			<div class="current-debt-values">
				<?php
				$current_debt_values = json_decode( $debt_logs['current_debt_values'] );
				?>
				<h2 class="align-center"><?php echo $current_debt_values->title; ?></h2>
				<p>
					<b>Remaining: </b><span class="debt-remaining"><?php echo $current_debt_values->remaining; ?></span>
				</p>
				<p>
					<b>Paid: </b><span class="debt-paid"><?php echo $current_debt_values->paid; ?></span>
				</p>
				<p>
					<b>Yearly Interest: </b><span class="debt-paid"><?php echo $current_debt_values->yearly_interest; ?></span>
				</p>

			</div>
		</div>
		<div class="debts-logs">
			<?php
			echo $debt_logs['debt_logs_html'];
			?>
		</div>


		<div class="reports-graphics" data-id = "<?php echo $debt_id; ?>">
			<input type = "hidden" class = "current-debt-values" data-id = "<?php echo $debt_id; ?>" value = '<?php echo $debt_logs['current_debt_values']; ?>'/>
			<input type = "hidden" class = "debt-logs-json" data-id = "<?php echo $debt_id; ?>" value = '<?php echo $debt_logs['debt_logs_json']; ?>'/>

			<div id = "doughnut-chart" class="single-graphics-wrapper">
				<canvas class="debts-reports doughnut-chart" data-id = "<?php echo$debt_id; ?>"></canvas>
			</div>
			<div id = "line-chart" class="single-graphics-wrapper">
				<canvas class="debts-reports line-chart" data-id = "<?php echo $debt_id; ?>"></canvas>
			</div>

		</div>

	</div>
</div>

<script>
    // Line Charts.
    document.querySelectorAll( 'canvas.debts-reports.line-chart' ).forEach( ( canvas ) => {
        createChart.functions.drawChart( canvas, canvas.getAttribute( 'data-id' ), 'line' );
    } );

    // Pie Charts.
    document.querySelectorAll( 'canvas.debts-reports.pie-chart' ).forEach( ( canvas ) => {
        createChart.functions.drawChart( canvas, canvas.getAttribute( 'data-id' ), 'pie' );
    } );

    // Doughnut Charts.
    document.querySelectorAll( 'canvas.debts-reports.doughnut-chart' ).forEach( ( canvas ) => {
        createChart.functions.drawChart( canvas, canvas.getAttribute( 'data-id' ), 'doughnut' );
    } );


    // Generate the PDF
    document.addEventListener('DOMContentLoaded', function() {
        //htmlToCanvas( 'exportPDF' );
    }, false);

    let htmlToCanvas = ( divID ) => {
        let div        = document.querySelector( '#' + divID );
        let bodyHeight = document.body.offsetHeight;
        html2canvas( div, {
            height: bodyHeight
        } ).then(canvas => {
            document.body.appendChild(canvas);
        });
    };


</script>
</body>