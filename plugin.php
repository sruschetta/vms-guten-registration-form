<?php
/**
 * @wordpress-plugin
 * Plugin Name: 			VMS Contest Manager
 * Description:       This is the Verbania Model Show Contest Manager official plugin.
 * Version:           1.0.0
 * Author:            Stefano Ruschetta
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
**/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists('VMS') ) {

	class VMS {

		function __construct() {

			if ( ! function_exists( 'register_block_type' ) ) {
				return;
			}

			require_once(plugin_dir_path(__FILE__). './php/db.php');

			//DB
			$vms_db = VMS_DB::getInstance();

			register_activation_hook( __FILE__, array( $vms_db, 'generateDB' ) );
			register_activation_hook( __FILE__, array( $vms_db, 'generateDataset' ) );
			register_deactivation_hook( __FILE__, array( $vms_db, 'dropDB' ) );

			//Register Blocks and Meta

			require_once(plugin_dir_path(__FILE__). './php/blocks.php');

			$vms_blocks = VMS_Blocks::getInstance();

			$vms_blocks->registerMeta();
			$vms_blocks->registerBlocks();


			//Actions

			require_once(plugin_dir_path(__FILE__). './php/actions.php');

			$vms_actions = VMS_Actions::getInstance();

			$vms_actions->registerActions();


			//Admin & Roles

			require_once(plugin_dir_path(__FILE__). './php/admin.php');

			$vms_admin = VMS_Admin::getInstance();

			$vms_admin->initRoles();
			$vms_admin->initAdminScripts();
			$vms_admin->initSettingsPage();
			$vms_admin->initExtraCSS();
    }
	}

	//Plugin Execution
	$vms = new VMS;
}
