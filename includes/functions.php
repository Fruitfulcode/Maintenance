<?php
	
	function mt_get_plugin_options($is_current = false) {
		$saved	  = (array) get_option('maintenance_options');
		if (!$is_current) {
			$defaults = mt_get_default_array();
			$defaults = apply_filters('mt_plugin_default_options', $defaults );
			$options  = wp_parse_args($saved, $defaults );
			$options  = array_intersect_key( $options, $defaults );
		} else {
			$options  = $saved;
		}
		
		return $options;
	}
	
	function generate_input_filed($title, $id, $name, $value) {
		$out_filed = '';
		$out_filed .= '<tr valign="top">';
		$out_filed .= '<th scope="row">' . $title .'</th>';
			$out_filed .= '<td>';
				$out_filed .= '<filedset>';
					$out_filed .= '<input type="text" id="'.$id.'" name="lib_options['.$name.']" value="'. stripslashes($value) .'" />';
				$out_filed .= '</filedset>';
			$out_filed .= '</td>';
		$out_filed .= '</tr>';			
		echo $out_filed;
	}	
	
	
	function generate_textarea_filed($title, $id, $name, $value) {
		$out_filed = '';
		$out_filed .= '<tr valign="top">';
		$out_filed .= '<th scope="row">' . $title .'</th>';
			$out_filed .= '<td>';
				$out_filed .= '<filedset>';
					$out_filed .= '<textarea name="lib_options['.$name.']" id="'.$id.'" cols="30" rows="10">'. stripslashes($value) .'</textarea>';
				$out_filed .= '</filedset>';
			$out_filed .= '</td>';
		$out_filed .= '</tr>';			
		echo $out_filed;
	}	
	
	function generate_check_filed($title, $label, $id, $name, $value) {
		$out_filed = '';
		$out_filed .= '<tr valign="top">';
		$out_filed .= '<th scope="row">' . $title .'</th>';
			$out_filed .= '<td>';
				$out_filed .= '<filedset>';
					$out_filed .= '<label for='.$id.'>';
						$out_filed .= '<input type="checkbox"  id="'.$id.'" name="lib_options['.$name.']" value="1" '. checked( true, $value, false ) .'/>';
						$out_filed .= $label;
					$out_filed .= '</label>';
				$out_filed .= '</filedset>';
			$out_filed .= '</td>';
		$out_filed .= '</tr>';			
		echo $out_filed;		
	}			
	
	function generate_image_filed($title, $id, $name, $value, $class, $name_btn, $class_btn) {
		$out_filed = '';
		
		$out_filed .= '<tr valign="top">';
		$out_filed .= '<th scope="row">' . $title .'</th>';
			$out_filed .= '<td>';
				$out_filed .= '<filedset>';
					$out_filed .= '<input type="hidden" id="'.$id.'" name="lib_options['.$name.']" value="'.$value.'" />';
					$out_filed .= '<div class="img-container">';
						$url = ''; 
						if($value != '') { 
							$image = wp_get_attachment_image_src( $value, 'full'); 
							$url   = $image[0];
						} 
					
						$out_filed .= '<div class="'.$class.'" style="background-image:url('.$url.')">';
							if ( $value ) { 
								$out_filed .= '<input class="button button-primary delete-img remove" type="button" value="x" />';
							}	
						$out_filed .= '</div>';
						$out_filed .= '<input type="button" class="'.$class_btn.'" value="'.$name_btn.'"/>';
						
					$out_filed .= '</div>';
				$out_filed .= '</filedset>';
			$out_filed .= '</td>';
		$out_filed .= '</tr>';
		echo $out_filed;		
	}
	
	function get_color_field($title, $id, $name, $value, $default_color) {
			$out_filed = '';
			$out_filed .= '<tr valign="top">';
					$out_filed .= '<th scope="row">'. $title .'</th>';
					$out_filed .= '<td>';
						$out_filed .= '<filedset>';
							$out_filed .= '<input type="text" id="'.$id.'" name="lib_options['.$name.']" data-default-color="'.$default_color.'" value="'. stripslashes($value) .'" />';
						$out_filed .= '<filedset>';
					$out_filed .= '</td>';	
				$out_filed .= '</tr>';
			echo $out_filed;
	}		
				
	function maintenance_page_create_meta_boxes() {
		global $maintenance_variable;
		add_meta_box( 'maintenance-general', _x( 'General Settings', 'meta box', 'maintenance' ),  'add_data_fields', 				 $maintenance_variable->options_page, 'normal', 'default');
	 	add_meta_box( 'promo-contant',   	 _x( 'Contact support', 'meta box', 'maintenance' ),   'maintenanace_contact_support',   $maintenance_variable->options_page, 'side',   'default' );
		add_meta_box( 'promo-extended',   	 _x( 'Extended version', 'meta box', 'maintenance' ),  'maintenanace_extended_version',  $maintenance_variable->options_page, 'side',   'default' );
	}
	add_action('add_meta_boxes', 'maintenance_page_create_meta_boxes', 10);
	
	function add_data_fields ($object, $box) {
		$mt_option = mt_get_plugin_options(true);
		echo '<table class="form-table">';
			echo '<tbody>';
				generate_input_filed(__('Page title', 'maintenance'), 'page_title', 'page_title', $mt_option['page_title']);
				generate_input_filed(__('Headline', 'maintenance'),	'heading', 'heading', 		  $mt_option['heading']);
				generate_textarea_filed(__('Description', 'maintenance'), 'description', 'description', $mt_option['description']);
				generate_image_filed(__('Logo', 'maintenance'), 'logo', 'logo', $mt_option['logo'], 'boxes box-logo', __('Upload Logo', 'maintenance'), 'upload_logo upload_btn button');
				do_action('maintenance_background_field');
				do_action('maintenance_color_fields');
				generate_check_filed(__('Admin bar', 'maintenance'), __('Show admin bar', 'maintenance'), 'admin_bar_enabled', 'admin_bar_enabled', isset($mt_option['admin_bar_enabled']));
				generate_check_filed(__('503', 'maintenance'), __('Service temporarily unavailable', 'maintenance'), '503_enabled', '503_enabled', isset($mt_option['503_enabled']));
			echo '</tbody>';
		echo '</table>';
	}	
	
	function get_background_fileds_action() {
		$mt_option = mt_get_plugin_options(true);
		generate_image_filed(__('Background image', 'maintenance'), 'body_bg', 'body_bg', $mt_option['body_bg'], 'boxes box-bg', __('Upload Background', 'maintenance'), 'upload_background upload_btn button');
	}
	add_action ('maintenance_background_field', 'get_background_fileds_action', 10);
	
	function get_color_fileds_action() {
		$mt_option = mt_get_plugin_options(true);
		get_color_field(__('Background color', 'maintenance'), 'body_bg_color', 'body_bg_color', $mt_option['body_bg_color'], '#333333');
		get_color_field(__('Font color', 'maintenance'), 'font_color', 'font_color', $mt_option['font_color'], 	  '#ffffff');
	}	
	add_action ('maintenance_color_fields', 'get_color_fileds_action', 10);
	
	
	function maintenanace_contact_support() {
		$promo_text  = '';
		$promo_text .= '<div class="sidebar-promo" id="sidebar-promo">';
			$promo_text .= '<h4 class="support">'. __('Contact support','maintenance'). '</h3>';
			$promo_text .= '<p>'. __('If you faced with any problems, have a question or suggestion you always can contact us with any request on our website fruitfulcode.com', 'maintenance').'</p>';
		$promo_text .= '</div>';		
		echo $promo_text;
	}
	
	function maintenanace_extended_version() {
		$promo_text  = '';
		$promo_text .= '<div class="sidebar-promo worker" id="sidebar-promo">';
			$promo_text .= '<h4 class="star">'. __('Extended version','maintenance') .'</h3>';
			$promo_text .= '<p>' . __('If you like our plugin please rate it, <br /> <a title="leave feedback" href="http://wordpress.org/support/view/plugin-reviews/maintenance" target="_blank">leave feedback</a> or purchase extended vesion <br /> with more other features.', 'maintenance') .'</p>';
			$promo_text .= '<a class="button button-primary" title="'. __('Purchase', 'maintenance') .'" href="http://codecanyon.net/item/maintenance-wordpress-plugin/2781350" target="_blank">'. __('Purchase', 'maintenance') .'</a>';
		$promo_text .= '</div>';	
		echo $promo_text;
	}
	function load_maintenace_page() {
		global $mt_options;
		$vCurrDate = '';
		$mt_options	= mt_get_plugin_options(true);
			if (!is_user_logged_in()) {
				if ($mt_options['state']) {
					if ( isset($mt_options['expiry_date'])) {
						if ($mt_options['expiry_date'] != '') {
							$vCurrDate =  DateTime::createFromFormat('d/m/Y', $mt_options['expiry_date']);
							list( $date, $time ) = explode( ' ', current($vCurrDate));
							list( $day, $month, $year ) 	 = explode(  '-', $date );
							list( $hour, $minute, $second )  = explode ( ':', $time );
							$timestamp = mktime( $hour, $minute, $second, $month, $day, $year );
							if ( time() > $timestamp ) {
								return true;
							}
						}
					}	

					if ( file_exists (MAINTENANCE_LOAD . 'index.php')) {
					  	 include_once MAINTENANCE_LOAD . 'index.php';
						 exit();
					}
				}
			}
	}

	function maintenace_metaboxes_scripts() {
		global $maintenance_variable; ?>
		<script type="text/javascript">
		//<![CDATA[
		jQuery(document).ready( function($) {
			$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
			postboxes.add_postbox_toggles( '<?php echo $maintenance_variable->options_page; ?>' );
		});
		//]]>
		</script>
	<?php }	
	
	function maintenace_add_toolbar_items(){
		global $wp_admin_bar, $wpdb;
			   $mt_options	= mt_get_plugin_options(true);
			   $check = '';
		if ( !is_super_admin() || !is_admin_bar_showing() ) return;		
		$url_to = admin_url( 'admin.php?page=maintenance');
		
		if ($mt_options['state']) { 
			$check = 'On';
		} else {
			$check = 'Off';
		}
		$wp_admin_bar->add_menu( array( 'id' => 'maintenance_options', 'title' => __( 'Maintenace', 'maintenance' ) . ' is ' . $check, 'href' => $url_to, 'meta'  => array( 'title' => __( 'Maintenace', 'maintenance' ) . ' is ' . $check)));	
	} 
	
	
	function mt_get_default_array() {
		return array(
			'state'		  		=> true,
			'page_title'  		=> __('Website is under construction', 'maintenance'),
			'heading'	  		=> __('Maintenance mode is on', 'maintenance'),	
			'description' 		=> __('Be first of your friends who will know when the website goes live.', 'maintenance'),
			'logo'		  		=> '',
			'body_bg'	  		=> '',
			'body_bg_color'   	=> '#333333',
			'font_color' 		=> '#ffffff',
			'admin_bar_enabled' => true,
			'503_enabled'		=> true
		);
	}