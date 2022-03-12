<?php

/**
* Plugin Name: Gravity Forms Entry Counter
* Description: Gravity Forms Entry Counter
* Version: 0.1
* Author: Sainath Mahadev Nale.
* Author URI: --
* Text Domain: gravity-forms-entry-counter
* License: later
*

* @package TEC
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

define( 'gf_PLUGIN_FILE', __FILE__ );

/*** Loads the action plugin*/

require_once dirname( gf_PLUGIN_FILE ) . '/include/Main.php';

GF_LEAD_Main::instance();

register_activation_hook( gf_PLUGIN_FILE, array( 'GF_LEAD_Main', 'activate' ) );

register_deactivation_hook( gf_PLUGIN_FILE, array( 'GF_LEAD_Main', 'deactivate' ) );

register_uninstall_hook( gf_PLUGIN_FILE, array( 'GF_LEAD_Main', 'uninstall' ) );     

add_action( 'admin_init', 'child_plugin_has_parent_plugin' );

function child_plugin_has_parent_plugin() {
	if ( is_admin()  &&  !is_plugin_active( 'gravityforms/gravityforms.php' ) ) {
		add_action( 'admin_notices', 'child_plugin_notice' );
		deactivate_plugins( plugin_basename( __FILE__ ) ); 
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
	}
}

function child_plugin_notice(){
	?>
	<div class="error"><p>Gravity Forms Entry Counter is not enabled. It requires Gravity Forms to be activated</p></div>
	<?php
}

