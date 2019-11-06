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

if ( !defined( 'ABSPATH' ) ) exit;


require_once 'inc/class-init.php';
require_once 'inc/class-enqueue-scripts.php';
require_once 'inc/class-admin-init.php';
require_once 'inc/classes/class-kotw-custom-post.php';
require_once 'inc/classes/class-kotw-custom-tax.php';

require_once 'inc/classes/class-dcp-export-data.php';
require_once 'inc/classes/class-dcp-notifications.php';
require_once 'inc/classes/class-dcp-arm-hooks.php';


require_once 'inc/class-meta-boxes.php';
require_once 'inc/class-shortcodes.php';



