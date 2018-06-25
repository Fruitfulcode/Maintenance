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

class ffc_maintenance_stats
{
	/**
	 * Constructor
	 **/
	public function __construct()
	{
		// Add general action hook for fruitful products to send stat
		add_action( 'fruitful_send_stats', array( $this, 'ffc_send_stats') );

		// Add theme activate action to send stat
		add_action( 'after_switch_theme', function () {	do_action('fruitful_send_stats'); } );

		// Add any update action to send stats
		add_action( 'upgrader_process_complete', function () {	do_action('fruitful_send_stats'); } );

		// Add update general ffc statistics option action to change "fruitful" theme settings option
		add_action( 'update_option_ffc_statistics_option', function () { do_action('fruitful_stats_settings_update'); } );

		// Add general action hook for fruitful products on ffc statistics option change
		add_action( 'fruitful_stats_settings_update', array( $this, 'ffc_theme_fruitful_stats_settings_update' ) );

		// Add first init action
		add_action( 'init', array( $this, 'ffc_check_stats') , 999 );

		// Load classes
		$this->_dispatch();

	}

	/**
	 * Load and instantiate all application
	 * classes neccessary for ffc statistics
	 **/
	private function _dispatch() {

		$controller = new stdClass();

		// Controller for modal notification
		require_once __DIR__ . '/send-statistics-modal.php';
		$controller->modal = new ffc_maintenance_stats_modal();

		// Controller for stat options on plugin settings page
		require_once __DIR__ . '/send-statistics-settings-options.php';
		$controller->option = new ffc_maintenance_stats_option();
	}

	/**
	 * Function sends request to our server
	 */
	public function ffc_send_stats() {

		$pararms = $this->ffc_get_stats_info_array(false);

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
	 * Function check stat options and returns statistic info array
	 *
	 * @param bool $is_theme
	 *
	 * @return array
	 */
	public function ffc_get_stats_info_array ($is_theme = true) {
		$ffc_statistic = $ffc_subscribe = $ffc_email = $ffc_name = '';

		/** General statistics option for all fruitfulcode products */
		$ffc_statistics_option = get_option('ffc_statistics_option');

		if( $ffc_statistics_option ) {

			if( isset($ffc_statistics_option['ffc_statistic']) ) {
				$ffc_statistic = $ffc_statistics_option['ffc_statistic'];
			}
			if( isset($ffc_statistics_option['ffc_subscribe']) ) {
				$ffc_subscribe = $ffc_statistics_option['ffc_subscribe'];
			}
			if( isset($ffc_statistics_option['ffc_subscribe_email']) ) {
				$ffc_email = $ffc_statistics_option['ffc_subscribe_email'];
			}
			if( isset($ffc_statistics_option['ffc_subscribe_name']) ) {
				$ffc_name = $ffc_statistics_option['ffc_subscribe_name'];
			}
		}

		return $this->ffc_build_stats_info_array ($ffc_statistic, $ffc_subscribe, $ffc_email, $ffc_name, $is_theme);
	}

	/**
	 * Function returns statistic info array
	 *
	 * @param int $ffc_statistic
	 * @param int $ffc_subscribe
	 * @param string $ffc_email
	 * @param string $ffc_name
	 * @param bool $is_theme
	 *
	 * @return array
	 */
	public function ffc_build_stats_info_array($ffc_statistic, $ffc_subscribe, $ffc_email, $ffc_name, $is_theme = true) {

		/** @var string $wp_version version of installed wordpress instance */
		global $wp_version;
		/** @var WP_Theme $theme_info */
		$theme_info = wp_get_theme();

		$plugin_data = [];

		if( $is_theme ) {
			$basic_params = [
				'product_name' => $theme_info->get( 'Name' ),
				'domain'       => site_url(),
			];
		}
		else {
			$path = plugin_dir_path( __FILE__ ).'/../maintenance.php';

			if( !function_exists('get_plugin_data') ){
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}

			$plugin_data = get_plugin_data( $path );
			$basic_params = [
				'product_name' => $plugin_data['Name'],
				'domain'       => site_url(),
			];
		}
		$site_info  = array();
		$stats_info = array();

		if ( $ffc_subscribe === 1 ) {

			$client_email = $ffc_email;
			$client_name  = $ffc_name;

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

		if ( $ffc_statistic === 1 ) {
			if($is_theme)
			{
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
			} else {
				$site_info = array(
					'site_name'    => get_option( 'blogname' ),
					'php'          => PHP_VERSION,
					'product_ver'  => $plugin_data['Version'],
					'platform'     => 1,
					'platform_ver' => $wp_version,
					'service_info' => json_encode( array(
						'plugins' => get_option( 'active_plugins' )
					) )
				);
			}
		}

		if ( ! empty( $user_info ) || ! empty( $site_info ) ) {
			$stats_info = array_merge( $basic_params, $user_info, $site_info );
		}

		return $stats_info;
	}

	/**
	 * Function send statistics on first theme init
	 */
	public function ffc_check_stats() {

		$ffc_maintenance_stat_sent = get_transient( 'ffc_maintenance_stat_sent' );

		if ( empty( $ffc_maintenance_stat_sent ) ) {
			set_transient( 'ffc_maintenance_stat_sent', '1', 1728000 ); //1728000 = 3600 * 24 * 20
			do_action('fruitful_send_stats');
		}
	}

	/**
	 * Function update general ffc statistics options on save theme customizer option
	 *
	 * @param $value
	 * @param $old_value
	 *
	 * @return mixed
	 */
	public function ffc_fruitful_send_stats_on_save( $value, $old_value ) {

		if( isset($value['ffc_subscribe'], $old_value['ffc_subscribe'], $value['ffc_subscribe_name'], $old_value['ffc_subscribe_name'],
				$value['ffc_subscribe_email'], $old_value['ffc_subscribe_email'], $value['ffc_statistic'], $old_value['ffc_statistic']) ) {

			if ($value['ffc_subscribe'] !== $old_value['ffc_subscribe'] ||
				$value['ffc_subscribe_name'] !== $old_value['ffc_subscribe_name'] ||
				$value['ffc_subscribe_email'] !== $old_value['ffc_subscribe_email'] ||
				$value['ffc_statistic'] !== $old_value['ffc_statistic']
			) {
				$ffc_statistics_option = get_option('ffc_statistics_option');

				$ffc_statistics_option['ffc_statistic'] = ($value['ffc_statistic'] === 'on') ? 1 : 0;
				$ffc_statistics_option['ffc_subscribe'] = ($value['ffc_subscribe'] === 'on') ? 1 : 0;
				$ffc_statistics_option['ffc_subscribe_email'] = $value['ffc_subscribe_email'];
				$ffc_statistics_option['ffc_subscribe_name'] = $value['ffc_subscribe_name'];

				update_option('ffc_statistics_option', $ffc_statistics_option);
				do_action('fruitful_send_stats');
			}
		}
		return $value;
	}

	/**
	 * Send stat on ffc stat option update
	 */
	public function ffc_theme_fruitful_stats_settings_update() {
		// Plugin settings already saved that only send stat
		do_action('fruitful_send_stats');
	}
}
