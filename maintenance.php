<?php
/**
 * Plugin Name: Maintenance
 * Version: 4
 */

if(!defined('MAINTENANCE_DIR')) define('MAINTENANCE_DIR', trailingslashit(plugin_dir_path( __FILE__ )));
if(!defined('MAINTENANCE_URI')) define('MAINTENANCE_URI', trailingslashit( plugin_dir_url( __FILE__ )));

require_once plugin_dir_path( __FILE__ ) . 'class.maintenance.php';
require_once plugin_dir_path( __FILE__ ) . 'trash.php';

MaintenancePlugin::instance();
