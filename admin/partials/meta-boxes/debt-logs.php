<?php
global $post;
$debt_id = $post->ID;

global $wpdb;
$table_name = $wpdb->prefix . $this->prefix . '_debt_logs';
$sql        = $wpdb->prepare( "select * from `$table_name` where `debt_id` =  %d", $debt_id );
$debt_logs  = $wpdb->get_results( $sql );





?>
<div class="kotw-meta-box">
	<table id = "debt-logs">
		<tr>
			<th>ID</th>
			<th>Debt Name</th>
			<th>Remaining</th>
			<th>Paid</th>
			<th>Yearly Interest</th>
			<th>Time</th>
		</tr>
		<?php
		foreach ( $debt_logs as $log ) {
			?>
			<tr>
				<td><?php echo $log->id;?></td>
				<td><?php echo $post->post_title;?></td>
				<td><?php echo $log->remaining;?></td>
				<td><?php echo $log->paid;?></td>
				<td><?php echo $log->yearly_interest;?></td>
				<td><?php echo $log->time;?></td>
			</tr>
			<?php
		}
		?>
	</table>
</div>
