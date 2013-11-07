<?php 
	$mess_arr = array();
	$mess_arr = get_custom_login_code(); 
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="viewport" content="width=640" />
	<?php get_page_title($mess_arr[0]); ?>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
</head>
<body>
	<?php do_action('before_content_section'); ?>
	<div id="wrapper">
		<div class="center">
			<header>
				<?php do_action('logo_box'); ?>
				<?php do_login_form($mess_arr[3], $mess_arr[1], $mess_arr[2]); ?>
			</header>
		</div>
		<div class="center">
			<div id="content" class="site-content">
				<?php do_action('content_section'); ?>
			</div>
		</div>
	</div> <!-- end wrapper -->		
	<footer role="contentinfo">
		<div class="center">
			<?php do_action('footer_section'); ?>
		</div>
	</footer>
	
	<?php do_action('after_content_section'); ?>
	<?php do_action('load_custom_scripts'); ?>
	<?php do_action('options_style'); ?>
	<?php do_action('add_single_backstretch_background'); ?>
</body>
</html>