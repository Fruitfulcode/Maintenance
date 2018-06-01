<?php
/**
 * Send statistics to system via Curl
 *
 * PHP version 5.4
 *
 * @category   Fruitful
 * @package    Fruitful
 * @author     Fruitful code <support@fruitfulcode.com>
 * @copyright  2018 Fruitful code
 * @version    1.0
 * @since      3.6.1
 * @license    https://opensource.org/licenses/OSL-3.0
 */

/**
 * Function sends request to our server
 */
function fruitful_send_stats() {

	$pararms = fruitful_build_stats_info_array();

	if ( ! empty( $pararms ) ) {

		$host = 'https://app.fruitfulcode.com/';
		$uri  = 'api/product/statistics';

		wp_remote_post( $host . $uri, array(
			'method'    => 'POST',
			'sslverify' => true,
			'timeout'   => 30,
			'body'      => $pararms
		) );
	}
}

/**
 * Function returns statistic info array
 *
 * @return array
 */
function fruitful_build_stats_info_array() {

	/** @var string $wp_version version of installed wordpress instance */
	global $wp_version, $thx_config;
	/** @var WP_Theme $theme_info */
	$theme_info = wp_get_theme();

	$options = $thx_config;

	$basic_params = [
		'product_name' => $theme_info->get( 'Name' ),
		'domain'       => site_url(),
	];

	$site_info  = array();
	$stats_info = array();

	if ( $options['ffc_subscribe'] === '1' ) {

		$client_email = $options['ffc_subscribe_email'];
		$client_name  = $options['ffc_subscribe_name'];

		$user_info = array(
			'client_name' => $client_name,
			'email'       => $client_email,
		);

	} else {
		$user_info = array(
			'client_name' => 'deleted',
			'email'       => 'deleted',
		);
	}


	if ( $options['ffc_statistic'] === '1' ) {
		$site_info = array(
			'site_name'    => get_option( 'blogname' ),
			'php'          => PHP_VERSION,
			'product_ver'  => $theme_info->get( 'Version' ),
			'platform'     => 1,
			'platform_ver' => $wp_version,
			'service_info' => json_encode( array(
				'plugins' => get_option( 'active_plugins' )
			) )
		);
	}

	if ( ! empty( $user_info ) || ! empty( $site_info ) ) {
		$stats_info = array_merge( $basic_params, $user_info, $site_info );
	}

	return $stats_info;
}

function fruitful_check_stats() {

	$fruitful_stat_sent = get_transient( 'fruitful_stat_sent' );

	if ( empty( $fruitful_stat_sent ) ) {
		set_transient( 'fruitful_stat_sent', '1', 3600 * 24 * 20 );
		fruitful_send_stats();
	}
}


/**
 * Add theme activate action
 */
add_action( 'after_switch_theme', 'fruitful_send_stats' );

/**
 * Add any update action
 */
add_action( 'upgrader_process_complete', 'fruitful_send_stats' );

/**
 * Add first init action
 */
add_action( 'init', 'fruitful_check_stats', 999 );

/**
 * Update options on save
 *
 * @param $value
 * @param $old_value
 *
 * @return mixed
 */
function fruitful_send_stats_on_save( $value, $old_value ) {

	if ( $value['ffc_subscribe'] !== $old_value['ffc_subscribe'] ||
	     $value['ffc_subscribe_name'] !== $old_value['ffc_subscribe_name'] ||
	     $value['ffc_subscribe_email'] !== $old_value['ffc_subscribe_email'] ||
	     $value['ffc_statistic'] !== $old_value['ffc_statistic']
	) {
		add_action( 'redux/options/thx_config/saved', 'fruitful_send_stats', 10, 3 );
	}

	return $value;
}

add_filter( 'pre_update_option_thx_config', 'fruitful_send_stats_on_save', 10, 3 );
