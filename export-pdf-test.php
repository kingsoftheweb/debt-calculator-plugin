<?php
if( !isset( $_GET['type'] ) && $_GET['user_id'] ) die();

require( '../../../wp-load.php' );
$export = new DCP_Export_Data();
$type    = $_GET['type'];
$user_id = $_GET['user_id'];

if( 'all' === $type ) :

	if ( ! $export->is_user_allowed( $user_id ) ) :
		echo 'You are not allowed to get results for the report';

	else : ?>
		<!DOCTYPE html>
		<html lang="en-US">
	<head>
		<title>Debt Export</title>
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

	?>
	<style>
		.wrapper {
			height: 1697px !important;
			width: 1200px !important;
			max-width: 100%;
			display: flex;
			padding: 1rem;
			flex-direction: column;
			box-sizing: border-box;
		}
		.wrapper .header {
			display: flex;
			padding: 1rem;
			justify-content: center;
		}
		.wrapper .header img {
			max-height: 200px;
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
			margin-bottom: 40px;
		}
		.wrapper .charts .row img {
			max-width: 100%;
		}

		.wrapper .charts .row .canvas-3 {
			display: flex;
			width: 100%;
			justify-content: center;
		}
		.wrapper .charts .row .canvas-3 img {
			max-width: 50%;
		}

		canvas.pdf-canvas {
		//display: none;
		}
	</style>
	<div class="wrapper" id = "page1">

		<div class="header">
			<img src="<?php echo 'admin/assets/jay-folds-logo.png'; ?>" />
		</div>
		<div class="charts">
			<div class="row">
				<div class = "canvas-wrapper canvas-1">
					<img src = "<?php echo $data1;?>" />
				</div>

				<div class = "canvas-wrapper canvas-2">
					<img src = "<?php echo $data2;?>" />
				</div>

			</div>
			<div class="row">
				<div class = "canvas-wrapper canvas-3">
					<img src = "<?php echo $data3;?>" />
				</div>
			</div>

		</div>


	</div>

	<div class="wrapper" id = "page-2">
		<div class="tables">
			<?php

			$data = $export->export_all_debts_to_pdf( $user_id );
			echo '<pre>';
			print_r($data);
			echo '</pre>';

			?>
		</div>
	</div>



	<script>



        // Generate the PDF
        document.addEventListener( 'DOMContentLoaded', function() {
            let bodyHeight = document.body.offsetHeight;
            let wrappers = document.querySelectorAll( '.wrapper' );
            wrappers.forEach( (wrapper, index) => {
                console.log(wrapper);
                let id = wrapper.getAttribute( 'id' );
                let div        = document.getElementById( id );
                html2canvas( div, {
                    height: bodyHeight,
                    scale: 1
                } ).then( canvas => {
                    document.body.appendChild( canvas );
                    canvas.classList.add( 'pdf-canvas' );
                    if( index === wrappers.length-1 ) {
                        document.dispatchEvent(new CustomEvent ( 'lastWrapper' ) );
                    }
                });
            } );

        }, false);

        setTimeout( () => {
            let pdfCanvases = document.querySelectorAll( 'canvas.pdf-canvas' );

            let pdf = new jsPDF('p','pt','a4');
            let width = pdf.internal.pageSize.getWidth();
            let height = pdf.internal.pageSize.getHeight();

            pdf.addImage( pdfCanvases[0].toDataURL(), 'JPEG', 0, 0, width, height );

            /* for( let i=1; i<canvasesArray.length-1; i++ ) {
				 pdf.addPage();
				 pdf.addImage( canvasesArray[i], 'JPEG', 0, 0, width, height );
			 }
			 console.log(pdfCanvases);*/
            pdf.save('myPage.pdf');


            console.log(pdfCanvases);
        }, 1000 );
        document.addEventListener( 'lastWrapper', function () {
            console.log('last wrapper');
            let pdfCanvases = document.querySelectorAll( 'canvas.pdf-canvas' );

            let pdf = new jsPDF('p','pt','a4');
            let width = pdf.internal.pageSize.getWidth();
            let height = pdf.internal.pageSize.getHeight();

            let canvasesArray = [];
            pdfCanvases.forEach( (canvas) => {
                canvasesArray.push( canvas.toDataURL() );
            } );
            /*
			 pdf.addImage( canvasesArray[0], 'JPEG', 0, 0, width, height );

			 for( let i=1; i<canvasesArray.length-1; i++ ) {
				 pdf.addPage();
				 pdf.addImage( canvasesArray[i], 'JPEG', 0, 0, width, height );
			 }
			 console.log(pdfCanvases);
			 pdf.save('myPage.pdf');*/
        } );



	</script>
	</body>

	<?php

	endif;

endif;

<?php
