<?php
/**
 * Created by PhpStorm.
 * User: viktor
 * Date: 31/05/18
 * Time: 13:00
 */

if ( class_exists( 'ReduxFramework' ) ) {
	/**
	 * Enqueue scripts for all admin pages
	 */
	add_action( 'admin_enqueue_scripts', 'thx_add_admin_scripts' );
	function thx_add_admin_scripts() {
		wp_enqueue_script( 'fruitful-stats-modal', get_template_directory_uri() . '/includes/admin/fruitful-stats/assets/js/admin_scripts.js', array( 'jquery' ) );
		wp_enqueue_style( 'fruitful-stats-modal-styles', get_template_directory_uri() . '/includes/admin/fruitful-stats/assets/styles/admin_styles.css' );
	}

	function thx_shortcodes_admin_notice() {
		global $thx_config;
		$options = $thx_config;

		if ( $options['ffc_is_hide_subscribe_notification'] === '0' ) {
			require get_template_directory(). '/includes/admin/fruitful-stats/view/send-statistics-modal-view.php';
		}
	}

	add_action( 'admin_footer', 'thx_shortcodes_admin_notice' );


	add_action( 'wp_ajax_thx_submit_modal', 'thx_submit_modal' );
	function thx_submit_modal() {

		global $thx_config;
		$request_data = $_POST['data'];

		$response = array(
			'status'            => 'failed',
			'title'             => __( 'Uh oh!', 'thx' ),
			'error_message'     => __( 'Sorry, something went wrong, and we failed to receive the shared data from you.', 'thx' ),
			'error_description' => __( 'No worries; go to the theme option to enter the required data manually and save changes.', 'thx' ),
			'stat_msg'          => '',
			'subscr_msg'        => ''
		);


		if ( ! empty( $request_data ) ) {
			foreach ( $request_data as $option => $value ) {
				if ( isset( $thx_config[ $option ] ) ) {
					Redux::setOption( 'thx_config', $option, $value );
				}
			}
			Redux::setOption( 'thx_config', 'ffc_is_hide_subscribe_notification', '1' );

			if ( $request_data['ffc_statistic'] === '1' || $request_data['ffc_subscribe'] === '1' ) {
				$response = array(
					'status'            => 'success',
					'title'             => __( 'Thank you!', 'thx' ),
					'error_message'     => '',
					'error_description' => '',
					'stat_msg'          => __( 'Thank you for being supportive, we appreciate your understanding and assistance!', 'thx' ),
					'subscr_msg'        => $request_data['ffc_subscribe'] === '1' ? __( "Don't forget to check your inbox for our latest letter - you’d like that!", 'thx' ) : ''
				);
			} else {
				$response = array(
					'status'            => 'success',
					'title'             => __( 'What a pity!', 'thx' ),
					'error_message'     => '',
					'error_description' => '',
					'stat_msg'          => __( 'We wish you could have shared your site statistic and joined our community.', 'thx' ),
					'subscr_msg'        => __( 'But if you ever change your mind, you can always do that in the theme options.', 'thx' )
				);
			}
		}

		fruitful_send_stats();
		wp_send_json( $response );
	}

	add_action( 'wp_ajax_thx_dismiss_subscribe_notification', 'thx_dismiss_subscribe_notification' );
	function thx_dismiss_subscribe_notification() {
		Redux::setOption( 'thx_config', 'ffc_is_hide_subscribe_notification', '1' );

		wp_send_json( 'success' );
	}
}
