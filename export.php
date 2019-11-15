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

</head>
<body>
<?php
if( !isset( $_GET['debt_id'] ) ) exit;

$debt_functions = new DCP_Functions();
$debt_logs      = $debt_functions->get_debt_logs( sanitize_text_field( ( int ) $_GET['debt_id'] ) );
echo '<pre>';
print_r( $debt_logs );
echo '</pre>';

?>

</body>