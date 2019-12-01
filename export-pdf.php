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
        width: 100%;
        display: flex;
        padding: 1rem;
        justify-content: center;
        flex-direction: column;
        box-sizing: border-box;
    }
    .wrapper .header {
        display: flex;
        padding: 1rem;
        justify-content: center;
    }
    .wrapper .header img {
        max-height: 300px;
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
</style>
<div class="wrapper" id = "exportPDF">

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

<?php

$export->export_all_debts_to_pdf( $user_id );

?>

<script>
    // Generate the PDF
    document.addEventListener('DOMContentLoaded', function() {
        htmlToCanvas( 'body' );
    }, false);

    let htmlToCanvas = ( element ) => {
        let div        = document.querySelector( element );
        let bodyHeight = document.body.offsetHeight;
        html2canvas( div, {
            height: bodyHeight,
            scale: 1
        } ).then(canvas => {
            var pdf = new jsPDF('p','pt','a4');
            var width = pdf.internal.pageSize.getWidth();
            var height = pdf.internal.pageSize.getHeight();
            let newCanvasData = canvas.toDataURL();

          //  pdf.addImage(newCanvasData, 'JPEG', 0, 0, width, bodyHeight);
           // pdf.save('myPage.pdf');
            console.log( width, height, bodyHeight );
        });
    };

</script>
</body>

<?php

endif;

endif;

