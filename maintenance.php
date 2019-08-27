<?php
/*
	Plugin Name: Maintenance
	Plugin URI: http://wordpress.org/plugins/maintenance/
	Description: Take your website for maintenance away from public view. Use maintenance plugin if your website is in development or you need to change a few things, run an upgrade. Make it only accessible by login and password. Plugin has a options to add a logo, background, headline, message, colors, login, etc. Extended PRO with more features version is available for purchase.
	Version: 3.7.0
	Author: fruitfulcode
	Author URI: https://fruitfulcode.com
	License: GPL2
*/
/*  Copyright 2013  Fruitful Code  (email : mail@fruitfulcode.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class MTNC {
	public function __construct() {
		global  $mtnc_variable;
		$mtnc_variable = new stdClass();

		add_action( 'plugins_loaded', array( &$this, 'mtnc_constants' ), 1 );
		add_action( 'plugins_loaded', array( &$this, 'mtnc_lang' ), 2 );
		add_action( 'plugins_loaded', array( &$this, 'mtnc_includes' ), 3 );
		add_action( 'plugins_loaded', array( &$this, 'mtnc_admin' ), 4 );

		register_activation_hook( __FILE__, array( &$this, 'mtnc_activation' ) );
		register_deactivation_hook( __FILE__, array( &$this, 'mtnc_deactivation' ) );

		add_action( 'template_include', array( &$this, 'mtnc_template_include' ), 999999 );
		add_action( 'wp_logout', array( &$this, 'mtnc_user_logout' ) );
		add_action( 'init', array( &$this, 'mtnc_set_global_options' ), 1 );
	}

	public function mtnc_constants() {
		define( 'MTNC_VERSION', '3.7.0' );
		define( 'MTNC_DB_VERSION', 1 );
		define( 'MTNC_WP_VERSION', get_bloginfo( 'version' ) );
		define( 'MTNC_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
		define( 'MTNC_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );
		define( 'MTNC_INCLUDES', MTNC_DIR . trailingslashit( 'includes' ) );
		define( 'MTNC_LOAD', MTNC_DIR . trailingslashit( 'load' ) );
	}

	public function mtnc_set_global_options() {
		global $mt_options;
		$mt_options = mtnc_get_plugin_options( true );
	}

	public function mtnc_lang() {
		load_plugin_textdomain( 'maintenance', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	public function mtnc_includes() {
		require_once MTNC_INCLUDES . 'functions.php';
		require_once MTNC_INCLUDES . 'update.php';
		require_once MTNC_DIR . 'load/functions.php';
	}

	public function mtnc_admin() {
		if ( is_admin() ) {
			require_once MTNC_INCLUDES . 'admin.php';
		}
	}

	public function mtnc_activation() {
		/*Activation Plugin*/
		self::mtnc_clear_cache();
	}

	public function mtnc_deactivation() {
		/*Deactivation Plugin*/
		self::mtnc_clear_cache();
	}

	public static function mtnc_clear_cache() {
		global $file_prefix;
		if ( function_exists( 'w3tc_pgcache_flush' ) ) {
			w3tc_pgcache_flush();
		}
		if ( function_exists( 'wp_cache_clean_cache' ) ) {
			wp_cache_clean_cache( $file_prefix, true );
		}
	}

	public function mtnc_user_logout() {
		wp_safe_redirect( get_bloginfo( 'url' ) );
		exit;
	}

	public function mtnc_template_include( $original_template ) {
		$original_template = mtnc_load_maintenance_page( $original_template );
		return $original_template;
	}

}

$mtnc = new MTNC();
