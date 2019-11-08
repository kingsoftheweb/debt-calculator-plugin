<?php
/*
Plugin Name: Debt Calculator Plugin
Plugin URI: https://kingsoftheweb.ca
Description: Must Use Plugin for KingsOfTheWeb Network.
Version: 1.0
Author: Kings Of The Web
Author URI: https://kingsoftheweb.ca
License: GPL2
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Requires DCP_Init - Main init class for the plugin.
 */
require_once 'inc/class-init.php';


/**
 * Registers activation and deactivation hooks
 */
register_activation_hook( __FILE__, array( 'DCP_Init', 'activate_debtcalcplugin' ) );
register_deactivation_hook( __FILE__, array( 'DCP_Init', 'deactivate_debtcalcplugin' ) );
register_uninstall_hook( __FILE__, array( 'DCP_Init', 'uninstall_debtcalcplugin' ) );

