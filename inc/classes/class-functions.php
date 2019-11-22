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
				'total_paid'      => get_post_meta( $debt_id, $this->prefix . '_total_paid', true ),
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
			    // Update the new remaining.
                $new_remaining = ( float ) $remaining - ( float ) $paid;

				$insert = $wpdb->insert( $table_name, array(
					'debt_id'           => $debt_id,
					'remaining'         => $new_remaining,
					'paid'              => $paid,
					'yearly_interest'   => $interest,
				) );

				update_post_meta( $debt_id, $this->prefix . '_remaining_debt', $new_remaining );
				$this->udpate_total_paid( $debt_id );
			}

			return $insert;
		}


		/**
		 * update_total_paid.
		 * Updates the total paid for a debt.
		 *
		 * @param $debt_id
		 */
		public function udpate_total_paid ( $debt_id ) {
			global $wpdb;
			$table_name = $wpdb->prefix . $this->prefix . '_debt_logs';
			$debt_logs = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT * FROM `$table_name` WHERE `debt_id` = %d",
					$debt_id
				)
			);
			$total_paid = 0;
			foreach ( $debt_logs as $log ) {
			    $total_paid = $total_paid + ( float ) $log->paid;
            }
			update_post_meta( $debt_id, $this->prefix . '_total_paid', $total_paid );
        }

		/**
		 * order_logs_per_month.
		 * Orders the debt logs in an array of each month since the first debt log till the last debt log.
		 *
		 * @param $debt_id
		 *
		 * @return array
		 */
        public function order_logs_per_month ( $debt_id ) {
	        global $wpdb;
	        $table_name = $wpdb->prefix . $this->prefix . '_debt_logs';
	        $first_date_log = $wpdb->get_results(
		        $wpdb->prepare(
			        "SELECT * FROM `$table_name` WHERE `debt_id` = %d order by time asc limit 1",
			        $debt_id
		        )
	        );
	        $last_date_log = $wpdb->get_results(
		        $wpdb->prepare(
			        "SELECT * FROM `$table_name` WHERE `debt_id` = %d order by time desc limit 1",
			        $debt_id
		        )
	        );


	        $first_date = date_format( date_create(  $first_date_log[0]->time ), 'd-m-Y' );
	        $last_date  = date_format( date_create(  $last_date_log[0]->time ), 'd-m-Y' );

	        $first_month = date_format( date_create( $first_date_log[0]->time ), 'm' );
	        $last_month  = date_format( date_create( $last_date_log[0]->time ), 'm' );

	        // Start Looping from first month till last month.
            $i = 0;

	        return array(
	                'first_month' => $first_month,
                    'first_date'  => $first_date,
                    'last_month'  => $last_month,
                    'last_date'   => $last_date
            );
        }


        public function get_number_months_between_dates ( $date1, $date2 ) {

        }
	}

	new DCP_Functions();
endif;