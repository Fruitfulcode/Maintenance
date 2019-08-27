<?php

add_action( 'admin_menu', 'mtnc_admin_setup' );

function mtnc_admin_setup() {
	global  $mtnc_variable;
			$mtnc_variable->options_page = add_menu_page( __( 'Maintenance', 'maintenance' ), __( 'Maintenance', 'maintenance' ), 'manage_options', 'maintenance', 'mtnc_manage_options', MTNC_URI . '/images/icon-small.png' );

	add_action( 'admin_init', 'mtnc_register_settings' );
	add_action( "admin_head-{$mtnc_variable->options_page}", 'mtnc_metaboxes_scripts' );
	add_action( "admin_print_styles-{$mtnc_variable->options_page}", 'mtnc_admin_print_custom_styles' );
	add_action( "load-{$mtnc_variable->options_page}", 'mtnc_page_add_meta_boxes' );
	add_action( 'admin_enqueue_scripts', 'mtnc_load_later_scripts', 1 );
	add_action( 'admin_enqueue_scripts', 'mtnc_codemirror_enqueue_scripts' );
}

function mtnc_page_add_meta_boxes() {
	global  $mtnc_variable;
	do_action( 'add_mt_meta_boxes', $mtnc_variable->options_page );

}

function mtnc_register_settings() {
	global  $mtnc;
	if ( ! empty( $_POST['lib_options'] ) && check_admin_referer( 'mtnc_edit_post', 'mtnc_nonce' ) ) {
		if ( ! isset( $_POST['lib_options']['state'] ) ) {
			$_POST['lib_options']['state'] = 0;
		} else {
			$_POST['lib_options']['state'] = 1;
		}

		if ( isset( $_POST['lib_options']['htmlcss'] ) ) {
			$_POST['lib_options']['htmlcss'] = wp_kses_stripslashes( $_POST['lib_options']['htmlcss'] );  // Allowed all tags as for WYSIWYG post content
		}

		if ( isset( $_POST['lib_options'] ) ) {
			$lib_options = sanitize_post( wp_unslash( $_POST['lib_options'] ), 'db' );
			update_option( 'maintenance_options', $lib_options );
			MTNC::mtnc_clear_cache();
		}
	}

}

function mtnc_admin_print_custom_styles() {
	if ( function_exists( 'wp_enqueue_media' ) ) {
		wp_enqueue_media();
	} else {
		wp_enqueue_script( 'media-upload' );
		wp_enqueue_script( 'thickbox' );
		wp_enqueue_style( 'thickbox' );
	}

		wp_enqueue_script( 'common' );
		wp_enqueue_script( 'wp-lists' );
		wp_enqueue_script( 'postbox' );

		wp_enqueue_style( 'arvo', '//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700|Arvo:400,400italic,700,700italic' );
		wp_enqueue_style( 'wp-color-picker' );

		wp_enqueue_script( 'uplaods_', MTNC_URI . 'js/uploads_.min.js', 'jquery', filemtime( MTNC_DIR . 'js/uploads_.min.js' ), '' );
		wp_register_script( 'mtnc', MTNC_URI . 'js/init.js', array( 'wp-color-picker' ), filemtime( MTNC_DIR . 'js/init.js' ), true );
		wp_localize_script( 'mtnc', 'mtnc', array( 'path' => MTNC_URI ) );
		wp_enqueue_script( 'mtnc' );
		wp_enqueue_style( 'mtnc', MTNC_URI . 'css/admin.css', '', filemtime( MTNC_DIR . 'css/admin.css' ) );
}

function mtnc_codemirror_enqueue_scripts( $hook ) {
	if ( 'toplevel_page_maintenance' !== $hook ) {
		return;
	}
	$cm_settings['codeEditor'] = wp_enqueue_code_editor( array( 'type' => 'text/css' ) );
	wp_localize_script( 'jquery', 'cm_settings', $cm_settings );

	wp_enqueue_script( 'wp-theme-plugin-editor' );
	wp_enqueue_style( 'wp-codemirror' );
}

function mtnc_load_later_scripts() {
	// fix a bug with WooCommerce 3.2.2 .
	global $current_screen;
	if ( ! empty( $current_screen->id ) && $current_screen->id === 'toplevel_page_maintenance' ) {
		wp_deregister_script( 'select2' );
		wp_deregister_style( 'select2' );
		wp_dequeue_script( 'select2' );
		wp_dequeue_style( 'select2' );
		wp_enqueue_script( 'select2', MTNC_URI . 'js/select2/select2.min.js', 'jquery', filemtime( MTNC_DIR . 'js/select2/select2.min.js' ), '' );
		wp_enqueue_style( 'select2', MTNC_URI . 'js/select2/select2.css', '', filemtime( MTNC_DIR . 'js/select2/select2.css' ) );
	}
}

function mtnc_manage_options() {
	mtnc_generate_plugin_page();
}

function mtnc_generate_plugin_page() {
	global  $mtnc_variable;
	$mt_option = mtnc_get_plugin_options( true );
	?>
		<div id="maintenance-options" class="wrap">
			<form method="post" action="" enctype="multipart/form-data" name="options-form">
			<?php wp_nonce_field( 'mtnc_edit_post', 'mtnc_nonce' ); ?>
			<?php wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false ); ?>
			<?php wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
				<div class="postbox-container header-container column-1 normal">
				<h1><?php esc_html_e( 'Maintenance', 'maintenance' ); ?><input type="checkbox" id="state" name="lib_options[state]" <?php checked( $mt_option['state'], 1 ); ?> /> <?php submit_button( __( 'Save changes', 'maintenance' ), 'primary' ); ?></h1>

				</div>
				<div class="clear"></div>
				<div id="poststuff">
					<div class="metabox-holder">
						<div id="all-fileds" class="postbox-container column-1 normal">

						<?php do_meta_boxes( $mtnc_variable->options_page, 'normal', null ); ?>
						<?php do_meta_boxes( $mtnc_variable->options_page, 'advanced', null ); ?>

						</div>

						<div id="promo" class="postbox-container column-2 normal">
						<?php do_meta_boxes( $mtnc_variable->options_page, 'side', null ); ?>
						</div>

					</div>
				<?php submit_button( __( 'Save changes', 'maintenance' ), 'primary' ); ?>
				</div>
			</form>
		</div>
	<?php
}
