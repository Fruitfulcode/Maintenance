<?php

class ffc_maintenance_stats_option
{
	/**
	 * Constructor
	 **/
	public function __construct()
	{
		// Add action to enqueue modal notification scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'ffc_add_admin_scripts' ) );

		// Add action display plugin settings to add stat settings fields
		add_action( 'ff_maintenance_display_settings_page', array( $this, 'ffc_display_admin_settings' ) );

		// Add action save plugin settings to update ffc stat option
		add_action( 'ff_maintenance_plugin_setting_save', array( $this, 'ffc_update_stat_option_on_save_plugin_settings' ) );
	}

	/**
	 * Enqueue scripts for all admin pages
	 */
	public function ffc_add_admin_scripts() {
		if(!wp_script_is( 'fruitful-stats-modal', 'enqueued' )) {
			wp_enqueue_script( 'fruitful-stats-modal', plugins_url( '/assets/js/admin_scripts.js', __FILE__ ), array( 'jquery' ) );
		}
		if(!wp_style_is( 'fruitful-stats-modal-styles', 'enqueued' )) {
			wp_enqueue_style( 'fruitful-stats-modal-styles', plugins_url( '/assets/styles/admin_styles.css', __FILE__ ) );
		}
		if(!wp_style_is( 'fruitful-stats-settings-options-styles', 'enqueued' )) {
			wp_enqueue_style( 'fruitful-stats-settings-options-styles', plugins_url( '/assets/styles/admin_settings_form_styles.css', __FILE__ ) );
		}
	}

	/**
	 * Add stat settings to plugin settings page
	 */
	public function ffc_display_admin_settings() {

		/** Default values statistics options */
		$ffc_email = $ffc_name = '';
		$ffc_statistic = 1;
		$ffc_subscribe = 0;

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

		/**  Require view */
		require plugin_dir_path( __FILE__ ). '/view/send-statistics-settings-options-view.php';
	}

	/**
	 * Save plugin settings action
	 */
	public function ffc_update_stat_option_on_save_plugin_settings() {

		$post = $_POST;
		if( !empty($post) ){

			$ffc_statistics_option = get_option('ffc_statistics_option');

			if( isset($post['ffc_statistic']) ) { $ffc_statistics_option['ffc_statistic'] = (int)$post['ffc_statistic'];	}
			else{ $ffc_statistics_option['ffc_statistic'] = 0; }

			if( isset($post['ffc_subscribe']) ) { $ffc_statistics_option['ffc_subscribe'] = (int)$post['ffc_subscribe'];	}
			else{ $ffc_statistics_option['ffc_subscribe'] = 0; }

			if( isset($post['ffc_subscribe_email']) ) { $ffc_statistics_option['ffc_subscribe_email'] = $post['ffc_subscribe_email']; }
			else{ $ffc_statistics_option['ffc_subscribe_email'] = ''; }

			if( isset($post['ffc_subscribe_name']) ) { $ffc_statistics_option['ffc_subscribe_name'] = $post['ffc_subscribe_name'];	}
			else{ $ffc_statistics_option['ffc_subscribe_name'] = ''; }

			update_option('ffc_statistics_option', $ffc_statistics_option);
			do_action('fruitful_stats_settings_update');
		}
	}
}
