<?php
if( !isset( $_GET['type'] ) && $_GET['user_id'] ) die();

require( '../../../wp-load.php' );
$export = new DCP_Export_Data();
$type    = $_GET['type'];
$user_id = $_GET['user_id'];

$user_data = get_userdata( $user_id );
$user_display_name = $user_data->first_name . $user_data->last_name;
$username          = $user_data->user_login;

$copyright = '© 2019 Jay Folds Financial Military Coaching. All rights reserved. ';
if( 'all' === $type ) :

	if ( ! $export->is_user_allowed( $user_id ) ) :
		echo 'You are not allowed to get results for the report';

	else : ?>
		<!DOCTYPE html>
		<html lang="en-US">
	<head>
		<title>Financial Report</title>
		<meta charset="utf-8">
<!--		<link href="export.css?nocache=--><?php //echo time();?><!--" rel="stylesheet"/>-->
		<script src = "https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
<!--		<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>-->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.3.5/jspdf.plugin.autotable.js"></script>

<!--		<script src = "front/js/createChart.min.js"></script>-->
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

	$meta4 =  $_GET['meta'].'4';
	$data4 = get_user_meta( $user_id, $meta4, true );


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
    <div class="info">
        <input type = "hidden" class="footer" = value = "<?php echo $copyright;?>"/>
        <input type = "hidden" class="data1" = value = "<?php echo $data1;?>"/>
        <input type = "hidden" class="data2" = value = "<?php echo $data2;?>"/>
        <input type = "hidden" class="data3" = value = "<?php echo $data3;?>"/>
        <input type = "hidden" class="data4" = value = "<?php echo $data4;?>"/>
    </div>

    <div class="wrapper" id = "page1">

        <div class="header">
            <div class="logo">
                <img src="<?php echo 'admin/assets/jay-folds-logo.png'; ?>" />
            </div>
            <div class="info">
                <h1 class = "title">Financial Report</h1>
                <h3 class = "name"><?php echo $user_display_name; ?></h3>
                <h4 class = "date"><?php echo date('d-m-Y'); ?></h4>
            </div>

        </div>
	    <div class="footer">
		    <p><?php echo $copyright;?></p>
	    </div>
    </div>
	<div class="wrapper" id = "page2">

		<div class="charts">
			<div class="row">
				<div class = "canvas-wrapper canvas-1" id = "total-debts-chart">
					<img src = "<?php echo $data1;?>" />
                    <table class="results-table" id = "all_debts_array">
                        <tr>
                            <th>Debt</th>
                            <th>Paid</th>
                            <th>Remaining</th>
                            <th>Interest</th>
                        </tr>
						<?php
						foreach ( $all_debts_array as $debt ) {
							?>
                            <tr class = "value">
                                <td class = "col1"><?php echo $debt['Debt'];?></td>
                                <td class = "col2">$<?php echo number_format( (float) $debt['Paid'] );?></td>
                                <td class = "col3"><?php echo $debt['Remaining'];?></td>
                                <td class = "col4"><?php echo $debt['Interest'];?></td>
                            </tr>

							<?php
						}
						?>
                    </table>
				</div>
			</div>

		</div>

		<div class="footer">
			<p><?php echo $copyright;?></p>
		</div>

	</div>

	<div class="wrapper" id = "page3">

        <div class="charts">
            <div class="row">
                <div class = "canvas-wrapper canvas-2" id = "monthly-payments-chart">
                    <img src = "<?php echo $data4;?>" />
                </div>

            </div>
            <div class="tables">
                <h3>Monthly Payments</h3>
                <ul id = "all_debts_array">
			        <?php
			        $all_debts_logs = json_decode( json_encode( $all_debts_logs ), true );
			        foreach ( $all_debts_logs as $key => $log ) {
				        $dateLastTwoWeeks = strtotime('-4 weeks');

				        if( strtotime( $log['time'] ) >= $dateLastTwoWeeks ) {
					        ?>
                            <li>
                                <div class="title"><?php echo $log['title'];?></div>
                                <div class="value"><?php echo $log['paid'];?></div>
                                <div class="date"><?php echo $log['time'];?></div>
                            </li>

					        <?php
				        }
			        }
			        ?>
                </ul>
            </div>
        </div>


		<div class="footer">
			<p><?php echo $copyright;?></p>
		</div>
	</div>



    <div class="wrapper" id = "page4">

        <div class="charts">
            <div class="row">
                <div class = "canvas-wrapper canvas-2" id = "all-payments-chart">
                    <img src = "<?php echo $data2;?>" />
                </div>

            </div>

            <div class="row canvas-3">
                <div class = "canvas-wrapper canvas-3" id = "yearly-payments-chart">
                    <img src = "<?php echo $data3;?>" />
                </div>

            </div>
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

            let title  = document.querySelector( '.info .title' ).innerHTML;
            let name   = document.querySelector( '.info .name' ).innerHTML;
            let date   = document.querySelector( '.info .date' ).innerHTML;
            let footer = document.querySelector( '.info .footer' ).value;

            let data1 = document.querySelector( '.info .data1' ).value;
            let data2 = document.querySelector( '.info .data2' ).value;
            let data3 = document.querySelector( '.info .data3' ).value;
            let data4 = document.querySelector( '.info .data4' ).value;

            let logoSrc  = document.querySelector( '.logo img' ).src;
            let logo = new Image();
            logo.src = logoSrc;
            logo.onload = () => {
                let canvas    = document.createElement( 'canvas' );
                canvas.width  = logo.naturalWidth;
                canvas.height = logo.naturalHeight;

                let ctx = canvas.getContext('2d');
                ctx.drawImage( logo, 0, 0, canvas.width, canvas.height );
                let logoData = canvas.toDataURL();

                var doc = new jsPDF();
                var pageHeight = doc.internal.pageSize.height || doc.internal.pageSize.getHeight();
                var pageWidth = doc.internal.pageSize.width || doc.internal.pageSize.getWidth();


                /** PAGE 1**/
                doc.addImage( logoData, 'JPEG', 60, 20, 90, 90 );
                var startY = 120;
                doc.setFontSize(40);
                doc.text( title, pageWidth / 2,  startY, 'center');

                doc.setFontSize(30);
                doc.text( name, pageWidth / 2,  startY + 30, 'center');

                doc.setFontSize(20);
                doc.text( date, pageWidth / 2,  startY + 50, 'center');

                doc.setFontSize(10);
                doc.text( footer, pageWidth / 2,  pageHeight - 20, 'center');



                /** PAGE 2**/
                doc.addPage();
                doc.addImage( data1, 'JPEG', 15, 20, 180, 90 );
                var columns = [
                    {title: "Debt", dataKey: "col1"},
                    {title: "Paid", dataKey: "col2"},
                    {title: "Remaining", dataKey: "col3"},
                    {title: "Interest", dataKey: "col4"}
                ];
                let tableRows = document.querySelectorAll('#all_debts_array tr.value');
                let rows      = [];
                tableRows.forEach( ( row ) => {
                    rows.push(
                        {
                            'col1' : row.querySelector( '.col1' ).innerHTML,
                            'col2' : row.querySelector( '.col2' ).innerHTML,
                            'col3' : row.querySelector( '.col3' ).innerHTML,
                            'col4' : row.querySelector( '.col4' ).innerHTML,
                        }
                    );
                } );

                doc.autoTable(columns, rows, {
                    styles: {
                        fillColor: [0,49,91],
                        lineColor: [255,255,255],
                        textColor: [253,228,39],
                        lineWidth: 1,
                    },
                    columnStyles: {
                        col1: {fillColor: false, textColor:false},
                        col2: {fillColor: false, textColor:false},
                        col3: {fillColor: false, textColor:false},
                        col4: {fillColor: false, textColor:false},
                    },
                    margin: {top: 160},
                    addPageContent: function(data) {
                        doc.text("", 40, 100);
                    }
                });

                doc.setFontSize(10);
                doc.text( footer, pageWidth / 2,  pageHeight - 20, 'center');





                /** PAGE 3**/
                doc.addPage();
                doc.addImage( data4, 'JPEG', 15, 20, 180, 90 );
                var columns = [
                    {title: "Debt", dataKey: "col1"},
                    {title: "Payment", dataKey: "col2"},
                    {title: "Date", dataKey: "col3"},
                ];
                let tableRows3 = document.querySelectorAll('#all_debts_array li');
                let rows3      = [];
                tableRows3.forEach( ( row ) => {
                    rows3.push(
                        {
                            'col1' : row.querySelector( '.title' ).innerHTML,
                            'col2' : row.querySelector( '.value' ).innerHTML,
                            'col3' : row.querySelector( '.date' ).innerHTML,
                        }
                    );
                } );

                doc.autoTable(columns, rows3, {
                    styles: {
                        fillColor: [255,255,255],
                        lineColor: [255,255,255],
                        textColor: [0,0,0],
                        lineWidth: 1,
                    },
                    columnStyles: {
                        col1: {fillColor: false, textColor:false},
                        col2: {fillColor: false, textColor:false},
                        col3: {fillColor: false, textColor:false},
                    },
                    margin: {top: 120},
                    addPageContent: function(data) {
                        doc.text("", 40, 100);
                    }
                });

                doc.setFontSize(10);
                doc.text( footer, pageWidth / 2,  pageHeight - 20, 'center');


                /** Page 4 */
                doc.addPage();
                doc.addImage( data2, 'JPEG', 15, 20, 180, 90 );
                doc.addImage( data3, 'JPEG', 15, 120, 180, 90 );


                doc.setFontSize(10);
                doc.text( footer, pageWidth / 2,  pageHeight - 20, 'center');

                doc.save('payments_report.pdf');

            };



           /* setTimeout( function() {
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

                            html2canvas( document.getElementById('page4'), {
                                height: bodyHeight,
                                scale: 1
                            } ).then( canvas => {
                                document.body.appendChild( canvas );
                                canvas.classList.add( 'pdf-canvas' );
                                pdf.addImage( canvas.toDataURL(), 'JPEG', 0, 0, width, height );
                                pdf.addPage();

                                pdf.save('debts_payments_reports.pdf');
                            });

                        });

                    });

                });
            }, 2000 );
*/
        }, false);

	</script>
	</body>

	<?php

	endif;

endif;

