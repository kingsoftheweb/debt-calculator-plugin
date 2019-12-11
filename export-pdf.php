<?php
if( !isset( $_GET['type'] ) && $_GET['user_id'] ) die();

require( '../../../wp-load.php' );
$export = new DCP_Export_Data();
$type    = $_GET['type'];
$user_id = $_GET['user_id'];

$user_data = get_userdata( $user_id );
$user_display_name = $user_data->display_name;
$username          = $user_data->user_login;

$copyright = 'This is copyright text. All rights reserved.';
if( 'all' === $type ) :

	if ( ! $export->is_user_allowed( $user_id ) ) :
		echo 'You are not allowed to get results for the report';

	else : ?>
		<!DOCTYPE html>
		<html lang="en-US">
	<head>
		<title>Financial Report</title>
		<meta charset="utf-8">
		<!--	<meta name="viewport" content="width=device-width, initial-scale=1">-->
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

	$user_id = $_GET['user_id'];
	$meta1 =  $_GET['meta'].'1';
	$data1 = get_user_meta( $user_id, $meta1, true );

	$meta2 =  $_GET['meta'].'2';
	$data2 = get_user_meta( $user_id, $meta2, true );

	$meta3 =  $_GET['meta'].'3';
	$data3 = get_user_meta( $user_id, $meta3, true );


	$data = $export->export_all_debts_to_pdf( $user_id );
	$all_debts_array = $data['all_debts_array'];
	$all_debts_logs  = $data['all_debts_logs'];

	?>
	<style>
		.wrapper {
			height: 1697px !important;
			width: 1200px !important;
			max-width: 100%;
			position: relative;
			display: flex;
			padding: 1rem;
			flex-direction: column;
			box-sizing: border-box;
		}
		.wrapper .header {
			display: flex;
			padding: 1rem;
			justify-content: center;
			flex-direction: column;
			width: 100%;
		}
		.wrapper .header .logo {
			width: 100%;
			justify-content: center;
			display: flex;
		}
		.wrapper .header .info {
			width: 100%;
			display: flex;
			align-items: center;
			flex-direction: column;
		}
		.wrapper .header .info h1 {
			font-size: 66px;
		}
		.wrapper .header .info h3 {
			font-size: 40px;
		}
		.wrapper .header .info h4 {
			font-size: 25px;
		}
		.wrapper .header .info table {
			width: 100%;
			text-align: left;
		}
		.wrapper .header .info table th, .wrapper .header .info table td {
			padding: 10px;
		}

		.wrapper .header img {
			max-height: 500px;
			width: auto;
		}
		.wrapper .charts {
			display: flex;
			flex-direction: column;
		}
		.wrapper .charts .row {
			display: flex;
			flex-direction: row;
			justify-content: center;
			margin-bottom: 20px;
		}
		.wrapper .charts .row img {
			max-width: 100%;
			max-height: 500px;
		}

		.wrapper .charts .row .canvas-3 {
			display: flex;
			justify-content: center;
			margin-bottom: 20px;
		}
		.wrapper .row.canvas-3 {
			flex-direction: column;
			width: 100%;
			display: flex;
			justify-content: center;
		}
		.wrapper .charts table#all_debts_array {
			width: 100%;
			margin-top: 5%;
		}

		.wrapper .charts table#all_debts_array tr, .wrapper .charts table#all_debts_array th, .wrapper .charts table#all_debts_array td {
			text-align: left;
		}


		.wrapper .charts .row .canvas-3 img {
		//max-width: 50%;
		}

		canvas.pdf-canvas {
			display: none;
		}

		table.results-table {
			text-align: left;
		}

		table.results-table tr:nth-child(even){
			background-color: #f2f2f2;
		}
		table.results-table th {
			border: 1px solid #ddd;
			padding: 10px;
			text-align: left;
			background-color: #002d5b;
			color: #fde427;
		}
		table.results-table td {
			border: 1px solid #ddd;
			padding: 8px;
		}
		ul#all_debts_array {
			display: flex;
			flex-direction: column;
			max-height: 700px;
			flex-wrap: wrap;
			list-style: none;
		}
		ul#all_debts_array li {
			display: flex;
			flex-direction: row;
			align-items: center;
			font-size: 15px;
			border-bottom: 1px solid #eee;
		}
		ul#all_debts_array li div.title {
			width: 30%;
		}
		ul#all_debts_array li div.value {
			width: 15%;
		}
		ul#all_debts_array li div.date {
			width: 25%;
		}


		.wrapper .footer {
			position: absolute;
			bottom: 80px;
			text-align: center;
			width: 100%;
		}
	</style>
    <div class="wrapper" id = "page1">

        <div class="header">
            <div class="logo">
                <img src="<?php echo 'admin/assets/jay-folds-logo.png'; ?>" />
            </div>
            <div class="info">
                <h1>Financial Report</h1>
                <h3><?php echo $user_display_name; ?></h3>
                <h4><?php echo date('d-m-Y'); ?></h4>
            </div>

        </div>
	    <div class="footer">
		    <p><?php echo $copyright;?></p>
	    </div>
    </div>
	<div class="wrapper" id = "page2">

		<div class="charts">
			<div class="row">
				<div class = "canvas-wrapper canvas-1">
					<img src = "<?php echo $data1;?>" />
				</div>
			</div>
			<div class="row">
				<div class = "canvas-wrapper canvas-2">
					<img src = "<?php echo $data2;?>" />
				</div>

			</div>
			<div class="row canvas-3">
				<div class = "canvas-wrapper canvas-3">
					<img src = "<?php echo $data3;?>" />
				</div>

			</div>

		</div>

		<div class="footer">
			<p><?php echo $copyright;?></p>
		</div>

	</div>

	<div class="wrapper" id = "page3">
		<table class="results-table" id = "all_debts_array">
			<tr>
				<th>Debt</th>
				<th>Paid</th>
				<th>Remaining</th>
				<th>Interest</th>
				<!--						<th>Payment Date</th>-->
			</tr>
			<?php
			foreach ( $all_debts_array as $debt ) {
				?>
				<tr>
					<td><?php echo $debt['Debt'];?></td>
					<td><?php echo $debt['Paid'];?></td>
					<td><?php echo $debt['Remaining'];?></td>
					<td><?php echo $debt['Interest'];?></td>
					<!--							<td>--><?php //echo $debt['Payment Date'];?><!--</td>-->
				</tr>

				<?php
			}
			?>
		</table>
		<div class="tables">
			<h3>Monthly Payments</h3>
			<ul id = "all_debts_array">
				<?php
				$all_debts_logs = json_decode( json_encode( $all_debts_logs ), true );
				foreach ( $all_debts_logs as $key => $log ) {
					// if( 15>$key )continue;
					$dateLastTwoWeeks = strtotime('-4 weeks');

					if( strtotime( $log['time'] ) >= $dateLastTwoWeeks ) {
						?>

						<li>
							<div class="title"><?php echo $log['title'];?></div>
							<div class="value"><?php echo $log['paid'];?></div>
							<!--                            <div class="value">--><?php //echo $log['remaining'];?><!--</div>-->
							<!--                            <div class="value">--><?php //echo $log['yearly_interest'];?><!--</div>-->
							<div class="date"><?php echo $log['time'];?></div>
						</li>

						<?php
					}
				}
				?>
			</ul>
		</div>
		<div class="footer">
			<p><?php echo $copyright;?></p>
		</div>
	</div>





	<script>
        // Generate the PDF
        document.addEventListener( 'DOMContentLoaded', function() {
            let bodyHeight = document.body.offsetHeight;
            bodyHeight = 1697;

            setTimeout( function() {
                let pdf = new jsPDF('p','pt','a4');
                let width = pdf.internal.pageSize.getWidth();
                let height = pdf.internal.pageSize.getHeight();


                console.log( bodyHeight, width, height );
                // Page 1 wrapper
                html2canvas( document.getElementById('page1'), {
                    height: bodyHeight,
                    scale: 1
                } ).then( canvas => {
                    document.body.appendChild( canvas );
                    canvas.classList.add( 'pdf-canvas' );
                    pdf.addImage( canvas.toDataURL(), 'JPEG', 0, 0, width, height );
                    pdf.addPage();

                    html2canvas( document.getElementById('page2'), {
                        height: bodyHeight,
                        scale: 1
                    } ).then( canvas => {
                        document.body.appendChild( canvas );
                        canvas.classList.add( 'pdf-canvas' );
                        pdf.addImage( canvas.toDataURL(), 'JPEG', 0, 0, width, height );
                        pdf.addPage();

                        html2canvas( document.getElementById('page3'), {
                            height: bodyHeight,
                            scale: 1
                        } ).then( canvas => {
                            document.body.appendChild( canvas );
                            canvas.classList.add( 'pdf-canvas' );
                            pdf.addImage( canvas.toDataURL(), 'JPEG', 0, 0, width, height );

                            pdf.save('debts_payments_reports.pdf');
                        });

                    });

                });
            }, 2000 );

        }, false);

	</script>
	</body>

	<?php

	endif;

endif;

