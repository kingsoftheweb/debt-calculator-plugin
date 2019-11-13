<?php
/**
 * Class DCP_Functions
 */
if ( ! class_exists( 'DCP_Functions' ) ):
	class DCP_Functions extends DCP_Init {

		/**
		 * DCP_Meta_Boxes constructor.
		 */
		public function __construct() {
			parent::__construct();
		}


		/**
		 * get_debt_logs.
		 * Gets the debt logs using the debt_id.
		 *
		 * @param $debt_id
		 *
		 * @return array
		 */
		public function get_debt_logs ( $debt_id ) {

			$debt_title = get_the_title( $debt_id );

			global $wpdb;
			$table_name = $wpdb->prefix . $this->prefix . '_debt_logs';
			$sql        = $wpdb->prepare( "select * from `$table_name` where `debt_id` =  %d", $debt_id );
			$debt_logs  = $wpdb->get_results( $sql );

			$debts_logs_array = [];
			ob_start();
			?>
			<table class = "debt-logs">
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
					$debts_logs_array[] = array(
						'title'           => $debt_title,
						'remaining'       => $log->remaining,
						'paid'            => $log->paid,
						'yearly_interest' => $log->yearly_interest,
						'time'            => $log->time
					);
					?>
					<tr>
						<td><?php echo $log->id;?></td>
						<td><?php echo $debt_title;?></td>
						<td><?php echo $log->remaining;?></td>
						<td><?php echo $log->paid;?></td>
						<td><?php echo $log->yearly_interest;?></td>
						<td><?php echo $log->time;?></td>
					</tr>
					<?php
				}
				?>
			</table>
			<?php
			$debt_logs_table = ob_get_clean();

			$current_debt_values = array(
				'title'           => $debt_title,
				'remaining'       => get_post_meta( $debt_id, $this->prefix . '_remaining_debt', true ),
				'paid'            => get_post_meta( $debt_id, $this->prefix . '_paid_amount', true ),
				'yearly_interest' => get_post_meta( $debt_id, $this->prefix . '_yearly_interest', true ),
			);

			return array(
				'debt_logs_json'      => json_encode( $debts_logs_array ),
				'debt_logs_html'      => $debt_logs_table,
				'current_debt_values' => json_encode( $current_debt_values )
			);
		}

		/**
		 * update_debt_logs.
		 * Updates the debt logs with a new entry.
		 *
		 * @param $debt_id
		 * @param $remaining
		 * @param $paid
		 * @param $interest
		 *
		 * @return false|int
		 */
		public function update_debt_logs ( $debt_id, $remaining, $paid, $interest ) {
			global $wpdb;
			$table_name = $wpdb->prefix . $this->prefix . '_debt_logs';

			// Check if any of the values has changed to last debt log for the same debt.
			$last_debt_log = $wpdb->get_var(
				$wpdb->prepare(
					"SELECT * FROM `$table_name` WHERE `debt_id` = %d and `remaining` = %s and `paid` = %s and `yearly_interest` = %s ",
					$debt_id,
					$remaining,
					$paid,
					$interest
				)
			);

			$insert = false;
			if ( empty( $last_debt_log ) ) {
				$insert = $wpdb->insert( $table_name, array(
					'debt_id'           => $debt_id,
					'remaining'         => $remaining,
					'paid'              => $paid,
					'yearly_interest'   => $interest,
				) );
			}

			return $insert;
		}
	}

	new DCP_Functions();
endif;