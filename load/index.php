<?php
$mess_arr    = array();
$ebody_class = null;
$mess_arr    = mtnc_get_custom_login_code();
if ( ! empty( $mess_arr[0] ) ) {
	$ebody_class = 'error';
}
$mt_options       = mtnc_get_plugin_options( true );
$site_title       = get_bloginfo( 'title' );
$site_description = get_bloginfo( 'description' );

$page_title = ( isset( $mt_options['page_title'] ) && ! empty( $mt_options['page_title'] ) ) ? wp_strip_all_tags( stripslashes( $mt_options['page_title'] ) ) : $site_title;
$logo       = ( isset( $mt_options['logo'] ) && ! empty( $mt_options['logo'] ) ) ? esc_attr( $mt_options['logo'] ) : null;
$logo_ext   = null;

if ( ! empty( $logo ) ) {
	$logo     = wp_get_attachment_image_src( $logo, 'full' );
	$logo     = esc_url( $logo[0] );
	$logo_ext = pathinfo( $logo, PATHINFO_EXTENSION );
	$logo_ext = str_replace( '.', '', $logo_ext );
}

$page_description = ( isset( $mt_options['description'] ) && ! empty( $mt_options['description'] ) ) ? wp_strip_all_tags( stripslashes( $mt_options['description'] ) ) : $site_description;
if ( ! empty( $page_description ) ) {
	$page_description = apply_filters( 'wpautop', stripslashes( $page_description ) );
}

$bg      = wp_get_attachment_image_src( $mt_options['body_bg'], 'full' );
$body_bg = esc_url( $bg[0] );
if ( ! empty( $mt_options['bg_image_portrait'] ) ) {
	$bg_image_portrait = wp_get_attachment_image_src( $mt_options['bg_image_portrait'], 'full' );
	$bg_image_portrait = ! empty( $bg_image_portrait ) ? $bg_image_portrait[0] : false;
}
$google_fonts = mtnc_add_google_fonts();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php esc_attr( bloginfo( 'charset' ) ); ?>" />
	<?php mtnc_get_page_title(); ?>
	<?php
	if ( function_exists( 'wp_site_icon' ) ) {
		wp_site_icon();
	}
	?>
	<meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, minimum-scale=1">
	<meta name="description" content="<?php echo esc_attr( $site_description ); ?>"/>
	<meta http-equiv="X-UA-Compatible" content="" />
	<meta property="og:site_name" content="<?php echo esc_attr( $site_title ) . ' - ' . esc_attr( $site_description ); ?>"/>
	<meta property="og:title" content="<?php echo esc_attr( $page_title ); ?>"/>
	<meta property="og:type" content="Maintenance"/>
	<meta property="og:url" content="<?php echo esc_url( site_url() ); ?>"/>
	<meta property="og:description" content="<?php echo esc_attr( $page_description ); ?>"/>
	<?php
	if ( ! empty( $logo ) ) {
		?>
				<meta property="og:image" content="<?php echo esc_url( $logo ); ?>" />
				<meta property="og:image:url" content="<?php echo esc_url( $logo ); ?>"/>
				<meta property="og:image:secure_url" content="<?php echo esc_url( $logo ); ?>"/>
				<meta property="og:image:type" content="<?php echo esc_attr( $logo_ext ); ?>"/>
			<?php
	}
	?>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php esc_url( bloginfo( 'pingback_url' ) ); ?>" />
	<?php do_action( 'load_custom_style' ); ?>
	<?php do_action( 'add_gg_analytics_code' ); ?>
	<!--[if IE]>
	<style type="text/css">

	</style>
	<script type="text/javascript" src="<?php echo esc_url( MTNC_URI . 'load/js/jquery.backstretch.min.js' ); ?>"></script>
	<![endif]-->
	<?php
	if ( ! empty( $google_fonts[1] ) ) {
		echo '<link rel="stylesheet" href="' . esc_url( 'https://fonts.googleapis.com/css?family=' . esc_attr( $google_fonts[1] ) . '|' . esc_attr( $google_fonts[0] ) ) . '">';
	} elseif ( ! empty( $google_fonts[0] ) ) {
		echo '<link rel="stylesheet" href="' . esc_url( 'https://fonts.googleapis.com/css?family=' . esc_attr( $google_fonts[0] ) ) . '">';
	}
	?>
</head>

<body <?php body_class( 'maintenance ' . $ebody_class ); ?>>

<?php do_action( 'before_main_container' ); ?>
<div class="main-container">
	<?php do_action( 'before_content_section' ); ?>
	<div id="wrapper">
		<div class="center logotype">
			<header>
				<?php do_action( 'logo_box' ); ?>
			</header>
		</div>
		<div id="content" class="site-content">
			<div class="center">
				<?php do_action( 'content_section' ); ?>
			</div>
		</div>
	</div> <!-- end wrapper -->
	<footer>
		<div class="center">
			<?php do_action( 'footer_section' ); ?>
		</div>
	</footer>
	<?php do_action( 'after_content_section' ); ?>
	<?php do_action( 'user_content_section' ); ?>
	<?php
	if ( empty( $body_bg ) && ! empty( $bg_image_portrait ) ) {
		$body_bg = $bg_image_portrait;
	}
	if ( ! empty( $body_bg ) ) :
		?>
		<picture class="bg-img">
			<?php
			if ( ! empty( $bg_image_portrait ) ) :
				?>
				<source media="(max-width: 100vh)" srcset="<?php echo esc_url( $bg_image_portrait ); ?>">
			<?php endif; ?>
			<img src="<?php echo esc_url( $body_bg ); ?>">
		</picture>
	<?php endif; ?>
</div>

<?php do_action( 'after_main_container' ); ?>
<?php if ( isset( $mt_options['is_login'] ) ) : ?>
	<div class="login-form-container">
		<?php mtnc_do_login_form( esc_attr( $mess_arr[3] ), esc_attr( $mess_arr[1] ), esc_attr( $mess_arr[2] ), esc_attr( $mess_arr[0] ) ); ?>
		<?php mtnc_do_button_login_form(); ?>
	</div>
<?php endif; ?>
<?php do_action( 'load_options_style' ); ?>
<?php do_action( 'load_custom_scripts' ); ?>

</body>
</html>
