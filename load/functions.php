<?php
 
function get_custom_login_code() {
	global $wp_query, 
		   $error; 
	$mt_options = mt_get_plugin_options(true);
    if (!is_array($wp_query->query_vars)) $wp_query->query_vars = array();	   
	nocache_headers();
	$error_message  = 	$user_login = $user_pass = $error = '';
	$is_role_check  = false;
	$class_login 	= "user-icon";
	$class_password = "pass-icon";
		  
	header('Content-Type: '.get_bloginfo('html_type').'; charset='.get_bloginfo('charset'));
	$using_cookie = false;
	
	if(isset($_POST['is_custom_login'])) {
		$user_login = $_POST['log'];
		$user_login = sanitize_user( $user_login );
		$user_pass  = $_POST['pwd'];
		$access = array();
		$access['user_login'] 	 = $user_login;
		$access['user_password'] = $user_pass;
		$access['remember']  	 = true;
					
		$user = null;
		$user = new WP_User(0, $user_login);
		$current_role = $user->roles[0];
					 
		if (count($mt_options['roles_array']) > 0) {
			foreach (array_keys($mt_options['roles_array']) as $key) {
				if ($key == $current_role) { $is_role_check = true; }	
			}
		}  else {
			$is_role_check = true;
		}
					 
		if ( !$is_role_check) {
			  $error_message  	= __('Permission access denied!', 'maintenance');
			  $class_login 		= 'error';
			  $class_password 	= 'error';
		} else {
			$user_connect = wp_signon( $access, false);
			if ( is_wp_error($user_connect) )  {
				if ($user_connect->get_error_code() == 'invalid_username') {
					$error_message  =  __('You entered your login are incorrect!', 'maintenance');;
					$class_login 	= 'error';
					$class_password = 'error';
				} else if ($user_connect->get_error_code() == 'incorrect_password') {
					$error_message  =  __('You entered your password are incorrect!', 'maintenance');
					$class_password = 'error';
				} else {
					$error_message  =  __('You entered your login and password are incorrect!', 'maintenance');
					$class_login = 'error';
					$class_password = 'error';
				}
			} else {
				wp_redirect(site_url('/'));
				exit;
			}
		}	
	} 	
	if (!isset($mt_options['503_enabled'])) {
		header('HTTP/1.1 503 Service Temporarily Unavailable');
		header('Status:  503 Service Temporarily Unavailable');
		header('Retry-After: 3600');
		header('X-Powered-By:');
	}
	
		return array($error_message, $class_login, $class_password, $user_login);
	}			

	function add_custom_style() {
			echo '<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext" media="all" />';
			echo '<link rel="stylesheet" type="text/css" href="'. MAINTENANCE_URI .'load/style.css" media="all" />';
	}	
		
	function add_custom_scripts() {
		global $wp_scripts;
		
		wp_register_script( '_placeholder', 	MAINTENANCE_URI  .'load/js/jquery.placeholder.js', 	   'jquery');
		wp_register_script( '_backstretch', 	MAINTENANCE_URI  .'load/js/jquery.backstretch.min.js', 'jquery');
		wp_register_script( '_frontend', 		MAINTENANCE_URI  .'load/js/jquery.frontend.js', 'jquery');
		
		$wp_scripts->do_items('_placeholder');
		$wp_scripts->do_items('_backstretch');		
		$wp_scripts->do_items('_frontend');
	}
	
	add_action ('load_custom_scripts', 'add_custom_style',   5);
	add_action ('load_custom_scripts', 'add_custom_scripts', 15);
	
	function get_page_title($error_message) {
		$mt_options = mt_get_plugin_options(true);
		$title = '';
		if ($error_message != '') {
		    $title =  $mt_options['page_title'] . ' - ' . $error_message;
		} else {
		    $title =  $mt_options['page_title'];
		}
		echo "<title>$title</title>";
	}
	
	function get_options_style() {
		$mt_options = mt_get_plugin_options(true);
		$options_style = '';
		$options_style = '<style type="text/css">';

		if ( isset($mt_options['body_bg_color']) ) {
			$options_style .= 'body {background-color: '. $mt_options['body_bg_color'] .'}';
		}
		
		if ( $mt_options['body_bg_color'] ) {
			 $options_style .= '.site-title   {color: '. $mt_options['font_color'] .'} ';
			 $options_style .= '.login-form   {color: '. $mt_options['font_color'] .'} ';
			 $options_style .= '.site-content {color: '. $mt_options['font_color'] .'} ';
			 $options_style .= '.company-name {color: '. $mt_options['font_color'] .'} ';
			 
		}
		$options_style .= '</style>';
		echo $options_style;
	}
	add_action('options_style', 'get_options_style', 10);
	
	function get_logo_box() {
		$mt_options = mt_get_plugin_options(true);
		$out_html = '';
			$out_html = '<a class="logo" rel="home" href="'.get_bloginfo('home') .'">';
			if ( $mt_options['logo'] ) { 
				 $logo = wp_get_attachment_image_src( $mt_options['logo'], 'full'); 
				 $out_html .= '<img src="'. $logo[0] .'" alt="logo"/>';
			} else { 
				 $out_html .= '<h1 class="site-title">'. get_bloginfo( 'name' ) .'</h1>';
			} 
			$out_html .= '</a>';
		echo $out_html;
	}
	add_action ('logo_box', 'get_logo_box', 10);
	
	
	function get_content_section() {
		$mt_options  = mt_get_plugin_options(true);
		$out_content = '';
		$out_content .= '<h3 class="heading font-center">'     . stripslashes($mt_options['heading']) .'</h3>';
		$out_content .= '<h4 class="description font-center">' . stripslashes($mt_options['description']) .'</h4>';
		echo $out_content;
	}
	add_action('content_section', 'get_content_section', 10);
	
	
	function add_single_background() {
		$out_ = '';
		$mt_options  = mt_get_plugin_options(true);
		if (isset($mt_options['body_bg'])) {
			if (!isset($mt_options['gallery_array'])) {
			$out_ .= '<script type="text/javascript">';
				$out_ .= '$(document).ready(function() { ';
					if ($mt_options['body_bg'] != '') {
							$bg    = wp_get_attachment_image_src( $mt_options['body_bg'], 'full');
							$out_ .= '$.backstretch("'. $bg[0] .'");';
					}
				
				$out_ .= '});';
			$out_ .= '</script>';
			}
		echo $out_;
		}
	}	
	add_action ('add_single_backstretch_background', 'add_single_background');
	
	function get_footer_section() {
		$out_ftext = '';
		$out_ftext .= '<a class="company-name" rel="footer" href="'.get_bloginfo('home') .'">';
			$out_ftext .= '&copy; ' . get_bloginfo( 'name' ) . ' ' . date('Y');
		$out_ftext .= '</a>';
		echo $out_ftext;
	}
	
	add_action('footer_section', 'get_footer_section', 10);
	
	function do_login_form($user_login, $class_login, $class_password) {
		$out_login_form = '';
		$out_login_form .= '<form name="login-form" id="login-form" class="login-form" method="post">';
				$out_login_form .= '<input type="text" 	   name="log" id="log" value="'. wp_specialchars(stripslashes($user_login), 1) .'" size="20"  class="input username '.$class_login.'" placeholder="Username"/>';
				$out_login_form .= '<input type="password" name="pwd" id="login_password" value="" size="20"  class="input password '.$class_password.'" placeholder="Password" />';
				$out_login_form .= '<input type="submit" class="button" name="submit" id="submit" value="'.__('Sign In','maintenance') .'" tabindex="4" />';
				$out_login_form .= '<input type="hidden" name="is_custom_login" value="1" />';
		$out_login_form .= '</form>';
		echo $out_login_form;
	}