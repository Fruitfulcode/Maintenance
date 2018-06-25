<?php

class ffc_maintenance_stats_modal
{
	/**
	 * Constructor
	 **/
	public function __construct()
	{
		// Add action to enqueue modal notification scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'ffc_add_admin_scripts' ) );

		// Add action to show modal notification
		add_action( 'admin_footer', array( $this, 'ffc_shortcodes_admin_notice' ) );

		// Add action on submit modal notification
		add_action( 'wp_ajax_fruitful_maintenance_submit_modal', array( $this, 'ffc_submit_modal' ) );

		// Add action on click close button modal notification
		add_action( 'wp_ajax_fruitful_maintenance_dismiss_subscribe_notification', array( $this, 'ffc_dismiss_subscribe_notification' ) );
	}

	/**
	 * Function enqueue scripts for all admin pages
	 */
	public function ffc_add_admin_scripts() {
		
		if(!wp_script_is( 'fruitful-stats-modal', 'enqueued' )) {
			wp_enqueue_script( 'fruitful-stats-modal', plugins_url( '/assets/js/admin_scripts.js', __FILE__ ), array( 'jquery' ) );
		}
		if(!wp_style_is( 'fruitful-stats-modal-styles', 'enqueued' )) {
			wp_enqueue_style( 'fruitful-stats-modal-styles', plugins_url( '/assets/styles/admin_styles.css', __FILE__ ) );
		}
	}

	/**
	 * Function show modal notification
	 * And update fruitful theme settings options on first theme init
	 */
	public function ffc_shortcodes_admin_notice() {

		$ffc_statistics_option = get_option('ffc_statistics_option');

		if( !$ffc_statistics_option ) {
			update_option('ffc_statistics_option', array('ffc_is_now_showing_subscribe_notification' => 1, 'ffc_is_hide_subscribe_notification' => 0, 'ffc_path_to_current_notification' => __FILE__ ) );
			require plugin_dir_path( __FILE__ ). '/view/send-statistics-modal-view.php';
		}
		elseif( isset($ffc_statistics_option['ffc_is_hide_subscribe_notification'], $ffc_statistics_option['ffc_is_now_showing_subscribe_notification'], $ffc_statistics_option['ffc_path_to_current_notification']) )
		{
			if( $ffc_statistics_option['ffc_is_hide_subscribe_notification'] === 0 ) {
				if ( $ffc_statistics_option['ffc_is_now_showing_subscribe_notification'] !== 1 || $ffc_statistics_option['ffc_path_to_current_notification'] === __FILE__) {
					$ffc_statistics_option['ffc_is_now_showing_subscribe_notification'] = 1;
					$ffc_statistics_option['ffc_path_to_current_notification'] = __FILE__;
					update_option('ffc_statistics_option', $ffc_statistics_option);
					require plugin_dir_path( __FILE__ ). '/view/send-statistics-modal-view.php';
				}
			}
		}
	}

	/**
	 * Action on submit statistics modal notification
	 */
	public function ffc_submit_modal() {

		$request_data = $_POST['data'];

		$response = array(
			'status'            => 'failed',
			'title'             => __( 'Uh oh!', 'maintenance' ),
			'error_message'     => __( 'Sorry, something went wrong, and we failed to receive the shared data from you.', 'maintenance' ),
			'error_description' => __( 'No worries; go to the theme option to enter the required data manually and save changes.', 'maintenance' ),
			'stat_msg'          => '',
			'subscr_msg'        => ''
		);

		$ffc_statistics_option = get_option('ffc_statistics_option');

		if ( ! empty( $request_data ) ) {
			foreach ( $request_data as $option => $value ) {
				if ( isset( $option, $value ) ) {
					if ( $option === 'ffc_statistic' || $option === 'ffc_subscribe' ) { $ffc_statistics_option[$option] = (int)$value; }
					else { $ffc_statistics_option[$option] = $value; }
				}
			}
			$ffc_statistics_option['ffc_is_hide_subscribe_notification'] = 1;
			$ffc_statistics_option['ffc_is_now_showing_subscribe_notification'] = 0;
			$ffc_statistics_option['ffc_path_to_current_notification'] = '';
			update_option('ffc_statistics_option', $ffc_statistics_option);

			if ( $request_data['ffc_statistic'] === 1 || $request_data['ffc_subscribe'] === 1 ) {
				$response = array(
					'status'            => 'success',
					'title'             => __( 'Thank you!', 'maintenance' ),
					'error_message'     => '',
					'error_description' => '',
					'stat_msg'          => __( 'Thank you for being supportive, we appreciate your understanding and assistance!', 'maintenance' ),
					'subscr_msg'        => $request_data['ffc_subscribe'] === 1 ? __( "Don't forget to check your inbox for our latest letter - you’d like that!", 'maintenance' ) : ''
				);
			} else {
				$response = array(
					'status'            => 'success',
					'title'             => __( 'What a pity!', 'maintenance' ),
					'error_message'     => '',
					'error_description' => '',
					'stat_msg'          => __( 'We wish you could have shared your site statistic and joined our community.', 'maintenance' ),
					'subscr_msg'        => __( 'But if you ever change your mind, you can always do that in the theme options.', 'maintenance' )
				);
			}
		}
		do_action('fruitful_stats_settings_update');
		do_action('fruitful_send_stats');
		wp_send_json( $response );
	}

	/**
	 * Action click close button statistics modal notification
	 */
	public function ffc_dismiss_subscribe_notification() {

		$ffc_statistics_option = get_option('ffc_statistics_option');
		$ffc_statistics_option['ffc_is_now_showing_subscribe_notification'] = 0;
		$ffc_statistics_option['ffc_is_hide_subscribe_notification'] = 1;
		$ffc_statistics_option['ffc_path_to_current_notification'] = '';
		update_option('ffc_statistics_option', $ffc_statistics_option);
		do_action('fruitful_send_stats');
		wp_send_json( 'success' );
	}
}
