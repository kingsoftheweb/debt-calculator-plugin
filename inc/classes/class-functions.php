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
			$sql        = $wpdb->prepare( "select * from `$table_name` where `debt_id` =  %d order by time asc", $debt_id );
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
		 *  get_total_debt_values_at_date
		 *  Returns the total debt values at a specific date.
		 *
		 * @param $debt_id
		 * @param $date
		 *
		 * @param null $start_date
		 *
		 * @return array
		 */
		public function get_total_debt_values_at_date ( $debt_id, $date, $start_date = null ) {
			$date       = date('Y-m-d', strtotime( $date ) );
			$start_date = date('Y-m-d', strtotime( $start_date ) );
			global $wpdb;
			$table_name = $wpdb->prefix . $this->prefix . '_debt_logs';
			if( null !== $start_date ) {
				$sql        = $wpdb->prepare( "select * from `$table_name` where `debt_id` =  %d and time >= %s and time <= %s order by time asc", $debt_id, $start_date, $date );
			} else {
				$sql        = $wpdb->prepare( "select * from `$table_name` where `debt_id` =  %d and time <= %s order by time asc", $debt_id, $date );
			}
			$debt_logs  = $wpdb->get_results( $sql, OBJECT );

			$total_paid         = 0;
			$number_of_payments = 0;
			foreach ( $debt_logs as $log ) {
				$total_paid      = $total_paid + ( float ) $log->paid;
				$number_of_payments++;
			}

			// Get the remaining at that exact date
			if( $debt_logs ) {
				$last_row  = $debt_logs[0];
				$remaining = $last_row->remaining;
				return array(
					'number_of_payments' => $number_of_payments,
					'total_paid'         => $total_paid,
					'remaining'          => $remaining
				);
			} else {
				return array(
					'number_of_payments' => 0,
					'total_paid'         => 0,
					'remaining'          => 0
				);
			}


		}


		/**
		 *  is_still_debt_at_date
		 *  Returns Boolean true or false, if the debt is still a debt at a date ( Remaining > 0 ).
		 *
		 * @param $debt_id
		 * @param $date
		 *
		 * @param null $start_date
		 *
		 * @return array
		 */
		public function is_still_debt_at_date ( $debt_id, $date ) {
			$debt_values = $this->get_total_debt_values_at_date( $debt_id, $date );
			if( (float)$debt_values['remaining'] > 0 ) {
				return true;
			} else {
				return false;
			}
		}

		/**
		 *  get_total_payments_per_month
		 *  Returns the total payments per month.
		 *
		 *
		 * @param $author_id
		 *
		 * @return array
		 * @throws Exception
		 */
		public function get_total_payments_per_month ( $author_id ) {
			$first_debt = get_posts(
				array(
					'post_type'   => 'kotw_debt',
					'post_status' => 'publish',
					'numberposts' => 1,
					'orderby'     => 'date',
					'order'       => 'asc',
					'author'      => $author_id,
				)
			);
			$last_debt = get_posts(
				array(
					'post_type'   => 'kotw_debt',
					'post_status' => 'publish',
					'numberposts' => 1,
					'orderby'     => 'date',
					'order'       => 'desc',
					'author'      => $author_id,
				)
			);
			if( count($first_debt ) < 1 || count ( $last_debt ) < 1 ) return [];
			$first_date = $first_debt ? get_the_date( 'Y-m-d', $first_debt[0] ) : 0;
			$last_date  = $last_debt ? get_the_date( 'Y-m-d', $last_debt[0] ) : 0;


			$start    = new DateTime( $first_date );
			$interval = new DateInterval('P1M');
			$end      = new DateTime( $last_date );
			$period   = new DatePeriod( $start, $interval, $end );

			$months = [];
			// Only one debt is added.
			if( $end == $start ) {
				$first_day = '01-' . $start->format( 'm-Y' );
				$last_day  = date( "t-m-Y", strtotime( $start->format('d-m-Y') ) );

				$months[] = array(
					'title'     => $start->format( 'M-Y' ),
					'month'     => $start->format( 'm' ),
					'year'      => $start->format( 'Y' ),
					'first_day' => $first_day,
					'last_day'  => $last_day
				);

			} else {
			    // More than one debt are added.
				foreach ( $period as $dt ) {
					$first_day = '01-' . $dt->format( 'm-Y' );
					$last_day  = date( "t-m-Y", strtotime( $dt->format('d-m-Y') ) );

					$months[] = array(
						'title'     => $dt->format( 'M-Y' ),
						'month'     => $dt->format( 'm' ),
						'year'      => $dt->format( 'Y' ),
						'first_day' => $first_day,
						'last_day'  => $last_day
					);
				}

			}

			$debts_per_months_array = [];
			foreach ( $months as $month ) {
				$all_debts_per_month = get_posts(
					array(
						'post_type'   => 'kotw_debt',
						'post_status' => 'publish',
						'numberposts' => -1,
						'orderby'     => 'date',
						'order'       => 'asc',
						'author'      => $author_id,
						'date_query'  => array(
							'after'      => $month['first_day'],
							'before'     => $month['last_day'],
							'inclusive'  => true
						)
					)
				);
				$debts = [];
				$total_paid         = 0;
				$number_of_payments = 0;
				$total_remaining    = 0;
				foreach ( $all_debts_per_month as $single_debt ) {

					if( $this->is_still_debt_at_date( $single_debt->ID, $month['last_day'] ) || 1==1 ) {

						$debts_values_per_month = $this->get_total_debt_values_at_date( $single_debt->ID, $month['last_day'], $month['first_day'] );
						$total_paid         += (float) $debts_values_per_month['total_paid'];
						$number_of_payments += (int) $debts_values_per_month['number_of_payments'];
						$total_remaining    += (float) $debts_values_per_month['remaining'];

						$debts[] = array(
							'title'        => $single_debt->post_title,
							'is_stil_debt' => $this->is_still_debt_at_date( $single_debt->ID, $month['last_day'] ) ? 'yes' : 'no',
							'debt_values'  => $debts_values_per_month,
						);
					}
				}

				$debts_per_months_array[] = array(
					'title'           => $month['title'],
					'month'           => $month['month'],
					'year'            => $month['year'],
					'start_date'      => $month['first_day'],
					'end_date'        => $month['last_day'],
					'total_paid'      => $total_paid,
					'remaining'       => $total_remaining,
					'number_payments' => $number_of_payments,
					'debts'           => $debts
				);
			}

			return $debts_per_months_array;
		}

		/**
		 *  get_total_payments_per_year
		 *  Returns the total payments per year.
		 *
		 * @param $author_id
		 *
		 * @return array
		 */
		public function get_total_payments_per_year ( $author_id ) {
			$first_debt = get_posts(
				array(
					'post_type'   => 'kotw_debt',
					'post_status' => 'publish',
					'numberposts' => 1,
					'orderby'     => 'date',
					'order'       => 'asc',
					'author' => $author_id,
				)
			);
			$last_debt = get_posts(
				array(
					'post_type'   => 'kotw_debt',
					'post_status' => 'publish',
					'numberposts' => 1,
					'orderby'     => 'date',
					'order'       => 'desc',
					'author' => $author_id,
				)
			);
			$first_year = $first_debt ? get_the_date( 'Y', $first_debt[0] ) : 0;
			$last_year  = $last_debt ? get_the_date( 'Y', $last_debt[0] ) : 0;
			$years = [];
			$i = $first_year;
			for( $i; $i<=$last_year; $i++ ) {
				$years[] = $i;
			}
			$debts_per_year_array = [];
			foreach ( $years as $year ) {
				$all_debts_till_year = get_posts(
					array(
						'post_type'   => 'kotw_debt',
						'post_status' => 'publish',
						'numberposts' => -1,
						'orderby'     => 'date',
						'order'       => 'asc',
						'author' => $author_id,
						'date_query'  => array(
							'before'     => '31-12-'.$year,
							'inclusive' => true
						)
					)
				);
				$debts = [];
				foreach ( $all_debts_till_year as $single_debt ) {
					if( $this->is_still_debt_at_date( $single_debt->ID, '31-12-'.$year ) ) {
						$debts[] = array(
							'title'        => $single_debt->post_title,
							'is_stil_debt' => $this->is_still_debt_at_date( $single_debt->ID, '31-12-'.$year ) ? 'yes' : 'no',
							'debt_values'  => $this->get_total_debt_values_at_date( $single_debt->ID, '31-12-'.$year, '1-1-'.$year )
						);
					}
				}

				$debts_per_year_array[] = array(
					'year'  => $year,
					'debts' => $debts
				);
			}

			return $debts_per_year_array;
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
				$this->update_total_paid( $debt_id );
			}

			return $insert;
		}


		/**
		 * update_total_paid.
		 * Updates the total paid for a debt.
		 *
		 * @param $debt_id
		 */
		public function update_total_paid ( $debt_id ) {
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
		 * @throws Exception
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


			$first_date = $first_date_log ? date_format( date_create( $first_date_log[0]->time ), 'd-m-Y' ) : '';
			$last_date  = $last_date_log ? date_format( date_create( $last_date_log[0]->time ), 'd-m-Y' ) : '';

			// Start Looping from first month till last month.
			$months_dates = $this->get_all_periods_between_dates( $first_date, $last_date );

			// get debt logs between start and end of each month.
            $debt_title = get_the_title( $debt_id );
			$debt_logs  = [];
			foreach( $months_dates as $period ) {
				$start_date = $period['start'];
				$end_date   = $period['end'];
				$period_debt_logs = $this->get_debt_logs_between_two_dates( $debt_id, $start_date, $end_date );

				$debt_info = $this->get_total_debt_values_at_date( $debt_id, date_format( date_create( $end_date ), 'Y-m-d H:i:s') );
				$debt_logs[] = array(
				        'title'      => $debt_title,
					    'total_paid' => $debt_info['total_paid'],
					    'remaining'  => $debt_info['remaining'],
					    'start_date' => $start_date,
					    'end_date'   => $end_date,
					    'debt_logs'  => $period_debt_logs
				);
			}
			return $debt_logs;
		}

		/**
		 *  get_debt_logs_between_two_dates
		 *  Returns all debt logs between two dates of a debt.
		 *
		 * @param $debt_id
		 * @param $date1
		 * @param $date2
		 *
		 * @return array
		 */
		public function get_debt_logs_between_two_dates ( $debt_id, $date1, $date2 ) {
			$date1 = date_format( date_create( $date1 ), 'Y-m-d H:i:s');
			$date2 = date_format( date_create( $date2 ), 'Y-m-d H:i:s');
			global $wpdb;
			$table_name = $wpdb->prefix . $this->prefix . '_debt_logs';
			$debt_logs = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT * FROM `$table_name` WHERE `debt_id` = %d and time >= %s and time <= %s;",
					$debt_id,
					$date1,
					$date2
				)
			);
			$debt_logs_array = [];
			foreach ( $debt_logs as $debt ) {
				$debt_logs_array[] = $debt;
			}
			return $debt_logs_array;
		}


		/**
		 * get_all_periods_between_dates.
		 * Gets all monthly periods ( start date - end date ) between two dates.
		 *
		 * @param $date1
		 * @param $date2
		 *
		 * @return array
		 * @throws Exception
		 */
        public function get_all_periods_between_dates ( $date1, $date2 ) {
        	$first_month_start = ( new DateTime( $date1 ) )->modify('first day of this month');
	        $last_date         = ( new DateTime( $date2 ) );


	        $interval = DateInterval::createFromDateString('1 month');
	        $first_period   = new DatePeriod( $first_month_start, $interval, $last_date );

	        $start_dates = [];
	        $end_dates = [];
	        $all_dates = [];
	        foreach ($first_period as $dt) {
		        $start_dates[] = $dt->format("d-m-Y");
		        $end_dates[]   =  $dt->modify('last day of this month')->format("d-m-Y");
	        }

	        foreach ($start_dates as $key=>$date) {
		        $all_dates[] = array(
			        'start' => $start_dates[$key],
			        'end' => $end_dates[$key]
		        );
	        }

	        return $all_dates;
        }

	}

	new DCP_Functions();
endif;