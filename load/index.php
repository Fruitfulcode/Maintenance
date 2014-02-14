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
	<?php get_page_title(esc_attr($mess_arr[0])); ?>
	<?php maintenance_fruitful_metadevice(); ?>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php do_action('load_custom_scripts'); ?>
	<?php do_action('options_style'); ?>
	<?php do_action('add_single_backstretch_background'); ?>
	<?php do_action('add_gg_analytics_code'); ?>
</head>
<body>
	<?php do_action('before_content_section'); ?>
	<div id="wrapper">
		<div class="center">
			<header>
				<?php do_action('logo_box'); ?>
				<?php do_login_form(esc_attr($mess_arr[3]), esc_attr($mess_arr[1]), esc_attr($mess_arr[2])); ?>
			</header>
		</div>
		
		<div id="content" class="site-content">
			<div class="center">
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
</body>
</html>