<?php

/**
 * Class DCP_Activator
 * Adds all functions, hooks and filters to be run after plugin is activated.
 */
class DCP_Activator extends DCP_Init {

	/**
	 * DCP_Activator constructor.
	 */
	public function __construct() {
		parent::__construct();
		$this->create_database_tables();
	}

	/**
	 *  create_database_tables
	 *  Adds all database tables needed for the plugin.
	 */
	public function create_database_tables() {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->prefix . '_debt_logs';
		if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) != $table_name ) {
			$charset_collate = $wpdb->get_charset_collate();

			$sql = "CREATE TABLE $table_name (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				debt_id mediumint(9) NOT NULL,
				remaining text NOT NULL,
				paid text NOT NULL,
				yearly_interest text NOT NULL,
				time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				PRIMARY KEY  (id)
		) $charset_collate;";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}

	}

}