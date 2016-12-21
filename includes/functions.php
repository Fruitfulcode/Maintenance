<?php
	global $standart_fonts;
	$standart_fonts = array(
        "Arial, Helvetica, sans-serif" 			=> "Arial, Helvetica, sans-serif",
        "Arial Black, Gadget, sans-serif" 		=> "Arial Black, Gadget, sans-serif",
        "Bookman Old Style, serif" 				=> "Bookman Old Style, serif",
        "Comic Sans MS, cursive" 				=> "Comic Sans MS, cursive",
        "Courier, monospace" 					=> "Courier, monospace",
        "Garamond, serif" 						=> "Garamond, serif",
        "Georgia, serif" 						=> "Georgia, serif",
        "Impact, Charcoal, sans-serif" 			=> "Impact, Charcoal, sans-serif",
        "Lucida Console, Monaco, monospace" 	=> "Lucida Console, Monaco, monospace",
        "Lucida Sans Unicode, Lucida Grande, sans-serif" => "Lucida Sans Unicode, Lucida Grande, sans-serif",
        "MS Sans Serif, Geneva, sans-serif" 	=> "MS Sans Serif, Geneva, sans-serif",
        "MS Serif, New York, sans-serif" 		=> "MS Serif, New York, sans-serif",
        "Palatino Linotype, Book Antiqua, Palatino, serif" => "Palatino Linotype, Book Antiqua, Palatino, serif",
        "Tahoma,Geneva, sans-serif" 			=> "Tahoma, Geneva, sans-serif",
        "Times New Roman, Times,serif" 			=> "Times New Roman, Times, serif",
        "Trebuchet MS, Helvetica, sans-serif" 	=> "Trebuchet MS, Helvetica, sans-serif",
        "Verdana, Geneva, sans-serif" 			=> "Verdana, Geneva, sans-serif",
    );
		
	
	function mt_get_plugin_options($is_current = false) {
		$saved	  = (array) get_option('maintenance_options');
		if (!$is_current) {
			$options  = wp_parse_args(get_option('maintenance_options', array()),  mt_get_default_array());
		} else {
			$options  = $saved;
		}
		return $options;
	}

	function generate_input_filed($title, $id, $name, $value, $placeholder = '') {
		$out_filed = '';
		$out_filed .= '<tr valign="top">';
		$out_filed .= '<th scope="row">' . esc_attr($title) .'</th>';
			$out_filed .= '<td>';
				$out_filed .= '<filedset>';
					$out_filed .= '<input type="text" id="'.esc_attr($id).'" name="lib_options['.$name.']" value="'. wp_kses_post(stripslashes($value)) .'" placeholder="'.$placeholder.'"/>';
				$out_filed .= '</filedset>';
			$out_filed .= '</td>';
		$out_filed .= '</tr>';			
		echo $out_filed;
	}

function generate_number_filed($title, $id, $name, $value, $placeholder = '') {
		$out_filed = '';
		$out_filed .= '<tr valign="top">';
		$out_filed .= '<th scope="row">' . esc_attr($title) .'</th>';
			$out_filed .= '<td>';
				$out_filed .= '<filedset>';
					$out_filed .= '<input type="number" min="0" step="1" pattern="[0-9]{10}" id="'.esc_attr($id).'" name="lib_options['.$name.']" value="'. wp_kses_post(stripslashes($value)) .'" placeholder="'.$placeholder.'"/>';
				$out_filed .= '</filedset>';
			$out_filed .= '</td>';
		$out_filed .= '</tr>';			
		echo $out_filed;
	}
	
	function generate_textarea_filed($title, $id, $name, $value) {
		$out_filed = '';
		$out_filed .= '<tr valign="top">';
		$out_filed .= '<th scope="row">' . esc_attr($title) .'</th>';
			$out_filed .= '<td>';
				$out_filed .= '<filedset>';
					$out_filed .= '<textarea name="lib_options['.$name.']" id="'.esc_attr($id).'" cols="30" rows="10">'. wp_kses_post(stripslashes($value)) .'</textarea>';
				$out_filed .= '</filedset>';
			$out_filed .= '</td>';
		$out_filed .= '</tr>';			
		echo $out_filed;
	}


	function generate_tinymce_filed($title, $id, $name, $value) {
		$out_filed = '';
		$out_filed .= '<tr valign="top">';
		$out_filed .= '<th scope="row">' . esc_attr($title) .'</th>';
		$out_filed .= '<td>';
		$out_filed .= '<filedset>';
		ob_start();
		wp_editor($value, $id, array('textarea_name' => 'lib_options['.$name.']', 'teeny'=>1, 'media_buttons'=>0) );
		$out_filed .= ob_get_contents();
		ob_clean();
		$out_filed .= '</filedset>';
		$out_filed .= '</td>';
		$out_filed .= '</tr>';
		echo $out_filed;
	}


	function generate_check_filed($title, $label, $id, $name, $value) {
		$out_filed = '';
		$out_filed .= '<tr valign="top">';
		$out_filed .= '<th scope="row">' . esc_attr($title) .'</th>';
			$out_filed .= '<td>';
				$out_filed .= '<filedset>';
					$out_filed .= '<label for='.esc_attr($id).'>';
						$out_filed .= '<input type="checkbox"  id="'.esc_attr($id).'" name="lib_options['.$name.']" value="1" '. checked( true, $value, false ) .'/>';
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
		$out_filed .= '<th scope="row">' . esc_attr($title) .'</th>';
			$out_filed .= '<td>';
				$out_filed .= '<filedset>';
					$out_filed .= '<input type="hidden" id="'.esc_attr($id).'" name="lib_options['.$name.']" value="'.esc_attr($value).'" />';
					$out_filed .= '<div class="img-container">';
						$url = ''; 
						if($value != '') { 
							$image = wp_get_attachment_image_src( $value, 'full'); 
							$url   = esc_url($image[0]);
						} 
					
						$out_filed .= '<div class="'.esc_attr($class).'" style="background-image:url('.$url.')">';
							if ( $value ) { 
								$out_filed .= '<input class="button button-primary delete-img remove" type="button" value="x" />';
							}	
						$out_filed .= '</div>';
						$out_filed .= '<input type="button" class="'.esc_attr($class_btn).'" value="'.esc_attr($name_btn).'"/>';
						
					$out_filed .= '</div>';
				$out_filed .= '</filedset>';
			$out_filed .= '</td>';
		$out_filed .= '</tr>';
		echo $out_filed;		
	}
	
	function get_color_field($title, $id, $name, $value, $default_color) {
			$out_filed = '';
			$out_filed .= '<tr valign="top">';
					$out_filed .= '<th scope="row">'. esc_attr($title) .'</th>';
					$out_filed .= '<td>';
						$out_filed .= '<filedset>';
							$out_filed .= '<input type="text" id="'.esc_attr($id).'" name="lib_options['.$name.']" data-default-color="'.esc_attr($default_color).'" value="'. wp_kses_post(stripslashes($value)) .'" />';
						$out_filed .= '<filedset>';
					$out_filed .= '</td>';	
				$out_filed .= '</tr>';
			echo $out_filed;
	}		
	
	function mt_get_google_font($font = null) {	
		$font_params = $full_link = $gg_fonts = '';
		
		$gg_fonts = json_decode( mt_get_google_fonts() );
			
		if (property_exists ($gg_fonts, $font)) {
			$curr_font = $gg_fonts->{$font};
			if (!empty($curr_font)) {
				$name_font = str_replace(' ','+',$font);
				foreach ($curr_font->variants as $values) {
					$font_params .= $values->id . ',';
				}
			
				$font_params = trim($font_params, ",");
				$full_link = $name_font . ':' . $font_params;
				$full_link = 'http'. ( is_ssl() ? 's' : '' ) .'://fonts.googleapis.com/css?family=' . $full_link;
			}	
		}	
		
		return $full_link;
	}

    function get_fonts_field($title, $id, $name, $value) {
			global $standart_fonts;
			$out_items = $gg_fonts = '';
			
			$gg_fonts = json_decode( mt_get_google_fonts() );

			$out_filed = '';
			$out_filed .= '<tr valign="top">';
					$out_filed .= '<th scope="row">'. esc_attr($title) .'</th>';
					$out_filed .= '<td>';
						$out_filed .= '<filedset>';
						if(!empty($standart_fonts)) {
								$out_items .= '<optgroup label="' . __('Standard Fonts', 'maintenance') . '">';
								foreach ($standart_fonts as $key => $options) {
									$out_items .= '<option value="'.$key.'" '. selected( $value, $key, false ) .'>'.$options.'</option>';
								}
						}	
						
						if (!empty($gg_fonts)) {
								$out_items .= '<optgroup label="' . __('Google Web Fonts', 'maintenance') . '">';
							foreach ($gg_fonts as $key => $options) {
								$out_items .= '<option value="'.$key .'" '. selected( $value, $key, false ) .'>'.$key.'</option>';
							}
						}
						
						if (!empty($out_items)) {
							$out_filed .= '<select class="select2_customize" name="lib_options['.$name.']" id="'.esc_attr($id).'">';
								$out_filed .= $out_items;
							$out_filed .= '</select>';
						}	
						$out_filed .= '<filedset>';
					$out_filed .= '</td>';	
				$out_filed .= '</tr>';
			return $out_filed;
	}

	function get_fonts_subsets($title, $id, $name, $value) {
			global $standart_fonts;
			$out_items = $gg_fonts = $curr_font = $mt_option = '';
			$mt_option = mt_get_plugin_options(true);
			$curr_font = esc_attr($mt_option['body_font_family']);
			$vars 	   = "subsets";

			$gg_fonts = json_decode( mt_get_google_fonts(), true);
			
			if (!empty($gg_fonts)) {
			
				$out_filed = '';
				$out_filed .= '<tr valign="top">';
						$out_filed .= '<th scope="row">'. esc_attr($title) .'</th>';
						$out_filed .= '<td>';
							$out_filed .= '<filedset>';
								$out_filed .= '<select class="select2_customize" name="lib_options['.$name.']" id="'.esc_attr($id).'">';
								if(!empty($gg_fonts[$curr_font])){
									foreach ($gg_fonts[$curr_font][$vars] as $key) {
										$out_filed .= '<option value="'.$key['id'] .'" '. selected( $value, $key['id'], false ) .'>'.$key['name'].'</option>';
									}
								}
								$out_filed .= '</select>';
								
							$out_filed .= '<filedset>';
						$out_filed .= '</td>';	
					$out_filed .= '</tr>';
			}
			return $out_filed;
	}	
	
	function maintenance_page_create_meta_boxes() {
		global $maintenance_variable;
		add_meta_box( 'maintenance-general', __( 'General Settings', 'maintenance' ),  'add_data_fields', $maintenance_variable->options_page, 'normal', 'default');
		add_meta_box( 'maintenance-css', 	 __( 'Custom CSS', 'maintenance' ),        'add_css_fields', $maintenance_variable->options_page, 'normal', 'default');
		add_meta_box( 'maintenance-excludepages', 	 __( 'Exclude pages from maintenance mode', 'maintenance' ), 'add_exclude_pages_fields', $maintenance_variable->options_page, 'normal', 'default');
	}
	add_action('add_mt_meta_boxes', 'maintenance_page_create_meta_boxes', 10);
	
	function maintenance_page_create_meta_boxes_widget_pro() {
		global $maintenance_variable;
		add_meta_box( 'promo-extended',   	 __( 'Pro version', 'maintenance' ),  'maintenanace_extended_version',  $maintenance_variable->options_page, 'side',   'default' );
	}
	add_action('add_mt_meta_boxes', 'maintenance_page_create_meta_boxes_widget_pro', 11);
	

	function maintenance_page_create_meta_boxes_our_themes() {
		global $maintenance_variable;
		add_meta_box( 'promo-our-themes',   	 __( 'Fruitful Code projects',  'maintenance' ),  'maintenanace_our_themes',   $maintenance_variable->options_page, 'side',   'default' );
	}	
	add_action('add_mt_meta_boxes', 'maintenance_page_create_meta_boxes_our_themes', 12);	
	
	function maintenance_page_create_meta_boxes_widget_support() {
		global $maintenance_variable;
		add_meta_box( 'promo-content',   	 __( 'Support',  'maintenance' ),  'maintenanace_contact_support',   $maintenance_variable->options_page, 'side',   'default' );
	}	
	add_action('add_mt_meta_boxes', 'maintenance_page_create_meta_boxes_widget_support', 13);	
	
	function maintenance_page_create_meta_boxes_improve_translate() {
		global $maintenance_variable;
		add_meta_box( 'promo-translate',   	 __( 'Translation',  'maintenance' ),  'maintenanace_improve_translate',   $maintenance_variable->options_page, 'side',   'default' );
	}	
	add_action('add_mt_meta_boxes', 'maintenance_page_create_meta_boxes_improve_translate', 14);		
	
	function add_data_fields ($object, $box) {
		$mt_option = mt_get_plugin_options(true);
		$is_blur   = false; 
		
		/*Deafult Variable*/
		$page_title = $heading = $description = $logo_width = $logo_height = '';
		
		$allowed_tags = wp_kses_allowed_html( 'post' );
		if (isset($mt_option['page_title']))  $page_title 	= wp_kses_post($mt_option['page_title']);
		if (isset($mt_option['heading']))     $heading 		= wp_kses_post($mt_option['heading']);
		if (isset($mt_option['description'])) $description 	= wp_kses(stripslashes($mt_option['description']), $allowed_tags) ;
		if (isset($mt_option['footer_text'])) $footer_text 	= wp_kses_post($mt_option['footer_text']);
		if (isset($mt_option['logo_width']))  $logo_width 	= wp_kses_post($mt_option['logo_width']);
		if (isset($mt_option['logo_height'])) $logo_height 	= wp_kses_post($mt_option['logo_height']);
		
		?>
		<table class="form-table">
			<tbody>
		<?php	
				generate_input_filed(__('Page title', 'maintenance'), 'page_title', 'page_title', $page_title);
				generate_input_filed(__('Headline', 'maintenance'),	'heading', 'heading', $heading);
				generate_tinymce_filed(__('Description', 'maintenance'), 'description', 'description', $description);
				generate_input_filed(__('Footer Text', 'maintenance'),	'footer_text', 'footer_text', 	$footer_text);
				generate_number_filed(__('Set Logo width', 'maintenance'), 'logo_width', 'logo_width', $logo_width);
				generate_number_filed(__('Set Logo height', 'maintenance'), 'logo_height', 'logo_height', $logo_height);
				generate_image_filed(__('Logo', 'maintenance'), 'logo', 'logo', intval($mt_option['logo']), 'boxes box-logo', __('Upload Logo', 'maintenance'), 'upload_logo upload_btn button');
				generate_image_filed(__('Retina logo', 'maintenance'), 'retina_logo', 'retina_logo', intval($mt_option['retina_logo']), 'boxes box-logo', __('Upload Retina Logo', 'maintenance'), 'upload_logo upload_btn button');
				do_action('maintenance_background_field');
				do_action('maintenance_color_fields');
				do_action('maintenance_font_fields');
				generate_check_filed(__('Show admin bar', 'maintenance'), '', 'admin_bar_enabled', 'admin_bar_enabled', isset($mt_option['admin_bar_enabled']));
				generate_check_filed(__('503', 'maintenance'), __('Service temporarily unavailable, Google analytics will be disable.', 'maintenance'), '503_enabled', '503_enabled',  !empty($mt_option['503_enabled']));
				
				$gg_analytics_id = '';
				if (!empty($mt_option['gg_analytics_id'])) {
					$gg_analytics_id = esc_attr($mt_option['gg_analytics_id']);
				}
				
				generate_input_filed(__('Google Analytics ID',  'maintenance'), 'gg_analytics_id', 'gg_analytics_id', $gg_analytics_id,  __('UA-XXXXX-X', 'maintenance'));
				generate_input_filed(__('Set blur intensity',  'maintenance'), 'blur_intensity', 'blur_intensity', intval($mt_option['blur_intensity']));

				if (isset($mt_option['is_blur'])) {
					if ($mt_option['is_blur']) $is_blur = true; 
				} 
				
				generate_check_filed(__('Apply background blur', 'maintenance'), '', 'is_blur', 'is_blur', $is_blur);
				generate_check_filed(__('Enable frontend login', 'maintenance'),  '', 'is_login', 'is_login', isset($mt_option['is_login']));
		?>		
			</tbody>
		</table>
		<?php
	}	
	
	
	function add_css_fields() {
		$mt_option = mt_get_plugin_options(true);
		echo '<table class="form-table">';
			echo '<tbody>';
				generate_textarea_filed(__('CSS Code', 'maintenance'), 'custom_css', 'custom_css', wp_kses_stripslashes($mt_option['custom_css']));
			echo '</tbody>';
		echo '</table>';	
	}
	
	function add_exclude_pages_fields() {
		$mt_option = mt_get_plugin_options(true);
		$out_filed = '';
		
		$post_types = get_post_types(array('show_ui' => true, 'public' => true), 'objects' );
		
		$out_filed .= '<table class="form-table">';
			$out_filed .= '<tbody>';
			$out_filed .= '<tr valign="top">';	
				$out_filed .= '<th colspan="2" scope="row">' . __('Select the page to be displayed:', 'maintenance') .'</th>';
			$out_filed .= '</tr>';
						
			foreach ($post_types as $post_slug => $type) {
					
				if (($post_slug == 'attachment') || 
					($post_slug == 'revision') || 
					($post_slug == 'nav_menu_item')
					) continue;
				
				
				$args = array();
				$args = array(
					'posts_per_page'   => -1,
					'orderby'          => 'NAME',
					'order'            => 'ASC',
					'post_type'        => $post_slug,
					'post_status'      => 'publish'); 

				$posts_array = get_posts( $args );
				$db_pages_ex = array();					
				
				if (!empty($posts_array)) {
					
					/*Exclude pages from maintenance mode*/
					if (!empty($mt_option['exclude_pages']) && isset($mt_option['exclude_pages'][$post_slug])) { 
						$db_pages_ex = $mt_option['exclude_pages'][$post_slug]; 
					}
					
					$out_filed .= '<tr valign="top">';	
						$out_filed .= '<th scope="row">' . $type->labels->name .'</th>';
					
						$out_filed .= '<filedset>';	
						$out_filed .= '<td>';	
					
						$out_filed .= '<select id="exclude-pages" name="lib_options[exclude_pages]['.$post_slug.'][]" style="width:100%;" class="exclude-pages multiple-select-mt" multiple="multiple">';
						
						foreach ($posts_array as $post_values) {
							$current = null;
							if (!empty($db_pages_ex)) {
								if (in_array($post_values->ID, $db_pages_ex)) {
									$current = $post_values->ID;
								}
							}	
							$selected = selected($current, $post_values->ID, false);
							$out_filed .= '<option value="'.$post_values->ID.'" '.$selected .'>'.$post_values->post_title.'</option>';
						}
						
						$out_filed .= '</select>';	
				
						$out_filed .= '</filedset>';	
						$out_filed .= '</td>';	
					$out_filed .= '</tr>';						
				}
		}
		
			$out_filed .= '</tbody>';
		$out_filed .= '</table>';	
		
		echo $out_filed;
	}
	
	function get_background_fileds_action() {
		$mt_option = mt_get_plugin_options(true);
		generate_image_filed(__('Background image', 'maintenance'), 'body_bg', 'body_bg', esc_attr($mt_option['body_bg']), 'boxes box-bg', __('Upload Background', 'maintenance'), 'upload_background upload_btn button');
	}
	add_action ('maintenance_background_field', 'get_background_fileds_action', 10);
	
	function get_color_fileds_action() {
		$mt_option = mt_get_plugin_options(true);
		get_color_field(__('Background color', 'maintenance'), 'body_bg_color', 'body_bg_color', esc_attr($mt_option['body_bg_color']), '#1111111');
		get_color_field(__('Font color', 'maintenance'), 'font_color', 'font_color', esc_attr($mt_option['font_color']), 	  '#ffffff');
	}	
	add_action ('maintenance_color_fields', 'get_color_fileds_action', 10);
	
	
	function get_font_fileds_action() {
		$mt_option = mt_get_plugin_options(true);
		echo get_fonts_field(__('Font family', 'maintenance'), 'body_font_family', 'body_font_family', esc_attr($mt_option['body_font_family'])); 
 		$subset = '';
		if(!empty($mt_option['body_font_subset'])) {
			$subset = $mt_option['body_font_subset'];
		}
		echo get_fonts_subsets(__('Subsets', 'maintenance'), 'body_font_subset', 'body_font_subset', esc_attr($subset));		
	}	
	add_action ('maintenance_font_fields', 'get_font_fileds_action', 10);
	
	
	function maintenanace_contact_support() {
		$promo_text  = '';
		$promo_text .= '<div class="sidebar-promo" id="sidebar-promo">';
			$promo_text .= '<h4 class="support">'. __('Have any questions?','maintenance'). '</h3>';
			$promo_text .= '<p>'. sprintf(__('You may find answers to your questions at <a target="_blank" href="http://support.fruitfulcode.com/hc/en-us/sections/200406386">support forum</a><br>You may  <a target="_blank" href="http://support.fruitfulcode.com/hc/en-us/requests/new">contact us</a> with customization requests and suggestions.<br> Please visit our website to learn about us and our services <a href="%1$s" title="%2$s">%2$s</a>', 'maintenance'), 
											 'http://fruitfulcode.com',
											 'fruitfulcode.com'
										 ).'</p>';
		$promo_text .= '</div>';		
		echo $promo_text;
	}
	
	function maintenanace_improve_translate() {
		$promo_text  = '';
		$promo_text .= '<div class="sidebar-promo" id="sidebar-translate">';
			$promo_text .= '<h4 class="translate">'. __('This plugin is translation friendly','maintenance'). '</h3>';
			$promo_text .= '<p>'. sprintf(__('Want to improve translation or make one for your native language? <a href="%1$s" title="%2$s">%2$s</a>', 'maintenance'), 
											 'http://support.fruitfulcode.com/hc/en-us/articles/204268628',
											 __('Follow this tutorial', 'maintenance')
										 ).'</p>';
		$promo_text .= '</div>';		
		echo $promo_text;
	}

	function maintenanace_our_themes() {
		$promo_text  = '';
		$promo_text .= '<div class="sidebar-promo" id="sidebar-themes">';
			$promo_text .= '<h4 class="themes">'. __('Premium WordPress themes','maintenance'). '</h3>';
			
			$rand_banner = rand(0, 2);
			
			$class ="anaglyph-theme";
			$link = "http://themeforest.net/item/anaglyph-one-page-multi-page-wordpress-theme/7874320?ref=fruitfulcode";
			$title = __('ANAGLYPH - One page / Multi Page WordPress Theme', 'maintenance');
			
			if ($rand_banner == 1) {
				$class ="lovely-theme";
				$link = "http://themeforest.net/item/lovely-simple-elegant-wordpress-theme/8428221?ref=fruitfulcode";
				$title = __('Love.ly - Simple & Elegant WordPress theme', 'maintenance');
			}
			
			if ($rand_banner == 2) {
				$class ="zoner-theme";
				$link = "http://themeforest.net/item/zoner-real-estate-wordpress-theme/9099226?ref=fruitfulcode";
				$title = __('Zoner - Real Estate WordPress theme', 'maintenance');
			}
			
			
			$promo_text .= '<p>'. sprintf ('<a target="_blank" class="%1s" href="%2s" title="%3s"></a>', $class, $link, $title ) . '</p>';
			
		$promo_text .= '</div>';		
		echo $promo_text;
	}
	
	function maintenanace_extended_version() {
		$promo_text  = '';
		$promo_text .= '<div class="sidebar-promo worker" id="sidebar-promo">';
			$promo_text .= '<h4 class="star">'. __('Extended functionality','maintenance') .'</h3>';
			$promo_text .= '<p>' . sprintf(__('Purchase <a href="http://codecanyon.net/item/maintenance-wordpress-plugin/2781350?ref=fruitfulcode" target="_blank">PRO</a> version  with extended functionality. %1$s If you like our plugin please <a target="_blank" href="http://wordpress.org/support/view/plugin-reviews/maintenance?filter=5">rate it</a>, <a title="leave feedbacks" href="%2$s" target="_blank">leave feedbacks</a>.', 'maintenance'), 
										   '<br />',
										   'http://wordpress.org/support/view/plugin-reviews/maintenance') .'</p>';
			$promo_text .= sprintf('<a class="button button-primary" title="%1$s" href="%2$s" target="_blank">%1$s</a>', 
							__('Demo website', 'maintenance'),
							'http://plugins.fruitfulcode.com/maintenance/'
							);
		$promo_text .= '</div>';	
		echo $promo_text;
	}
	
	function mt_curPageURL() {
		$pageURL = 'http';
		if (isset($_SERVER["HTTPS"])) {$pageURL .= "s";}
			$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
	
	function mtCheckExclude() {
		global $mt_options, $post;
		$mt_options = mt_get_plugin_options(true);
		$is_skip 	= false;
		$curUrl 	= mt_curPageURL();
		if (is_page() || is_single()) {
			$currID = $post->ID;	
		} else {
			if (is_home()) {
				$blog_id = get_option( 'page_for_posts');
				if ($blog_id) $currID = $blog_id;
			}
			
			if (is_front_page()) {
				$front_page_id = get_option( 'show_on_front');
				if ($front_page_id) $currID = $front_page_id;
				
			}
		}
			
		
		if (isset($mt_options['exclude_pages']) && !empty($mt_options['exclude_pages'])) {
			$exlude_objs = $mt_options['exclude_pages'];
			foreach ($exlude_objs as $objs_id) {
				foreach ($objs_id as $obj_id) {
					if ( $currID == $obj_id) {
						 $is_skip = true;
						 break;
					}
				}	
			}
		}
		
        return $is_skip;
	}
	
	
	function load_maintenance_page() {
		global $mt_options;
		
		$vCurrDate_start = $vCurrDate_end = $vCurrTime = '';
		
		$vdate_start = $vdate_end = date_i18n( 'Y-m-d', strtotime( current_time('mysql', 0) )); 
		$vtime_start = date_i18n( 'h:i:s A', strtotime( '01:00:00 am')); 
		$vtime_end 	 = date_i18n( 'h:i:s A', strtotime( '12:59:59 pm')); 
			
			if (!is_user_logged_in()) {
				if (!empty($mt_options['state'])) {
					
					if (!empty($mt_options['expiry_date_start']))
						$vdate_start = $mt_options['expiry_date_start'];
					if (!empty($mt_options['expiry_date_end']))
						$vdate_end = $mt_options['expiry_date_end'];
						
					if (!empty($mt_options['expiry_time_start']))
						$vtime_start = $mt_options['expiry_time_start'];
					if (!empty($mt_options['expiry_time_end']))
						$vtime_end = $mt_options['expiry_time_end'];
					 
						$vCurrTime 		 = strtotime(current_time('mysql', 0));
						
						$vCurrDate_start = strtotime($vdate_start . ' ' . $vtime_start); 
						$vCurrDate_end 	 = strtotime($vdate_end   . ' ' . $vtime_end); 
						
						if (mtCheckExclude()) return true;
						
						if (($vCurrTime > $vCurrDate_start) && ($vCurrTime > $vCurrDate_end)) 
							if (!empty($mt_options['is_down'])) return true;
						
				} else {
					return true;		
				}				
				
				if ( file_exists (MAINTENANCE_LOAD . 'index.php')) {
				  	 include_once MAINTENANCE_LOAD . 'index.php';
					 exit;
				}	
			}
	}
	
	
	function maintenance_metaboxes_scripts() {
		global $maintenance_variable; 
	?>
		<script type="text/javascript">
		//<![CDATA[
		jQuery(document).ready( function() {
			jQuery('.if-js-closed').removeClass('if-js-closed').addClass('closed');
			postboxes.add_postbox_toggles( '<?php echo esc_js($maintenance_variable->options_page); ?>' );
		});
		//]]>
		</script>
	<?php }	
	
	function maintenance_add_toolbar_items(){
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
		$wp_admin_bar->add_menu( array( 'id' => 'maintenance_options', 'title' => __( 'Maintenance', 'maintenance' ) . __( ' is ', 'maintenance' ) . $check, 'href' => $url_to, 'meta'  => array( 'title' => __( 'Maintenance', 'maintenance' ) . __( ' is ', 'maintenance' ) . $check)));	
	} 
	
	
	function maintenance_hex2rgb($hex) {
		$hex = str_replace("#", "", $hex);

		if(strlen($hex) == 3) {
			$r = hexdec(substr($hex,0,1).substr($hex,0,1));
			$g = hexdec(substr($hex,1,1).substr($hex,1,1));
			$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		} else {
			$r = hexdec(substr($hex,0,2));
			$g = hexdec(substr($hex,2,2));
			$b = hexdec(substr($hex,4,2));
		}
		$rgb = array($r, $g, $b);
		return implode(",", $rgb); 
	}


	function mt_insert_attach_sample_files() {
		global $wpdb;
		$title = '';
		$attach_id   = 0;
		$is_attach_exists = $wpdb->get_results( "SELECT p.ID FROM $wpdb->posts p WHERE  p.post_title LIKE '%mt-sample-background%'", OBJECT );

		if (!empty($is_attach_exists)) {
			$attach_id = current($is_attach_exists)->ID;
		} else {
			require_once(ABSPATH . 'wp-admin/includes/image.php');
			$upload_dir  = wp_upload_dir();
			$image_url 	 = MAINTENANCE_URI . 'images/mt-sample-background.jpg';
			$file_name   = basename( $image_url );
			$file_content = file_get_contents($image_url);
			$upload      = wp_upload_bits( $file_name, null, $file_content, current_time( 'mysql', 0));
			if ($upload['error'] == '') {
				$title = preg_replace('/\.[^.]+$/', '', basename($image_url));

				$wp_filetype = wp_check_filetype(basename($upload['file']), null );
				$attachment = array(
						'guid' 			 => $upload['url'],
						'post_mime_type' => $wp_filetype['type'],
						'post_title' 	 => $title,
						'post_content' 	 => '',
						'post_status' 	 => 'inherit'
					);

				$attach_id   = wp_insert_attachment($attachment, $upload['file']);
				$attach_data = wp_generate_attachment_metadata($attach_id, $upload['file']);
				wp_update_attachment_metadata($attach_id, $attach_data);

			}
		}

		if (!empty($attach_id)) {
			return $attach_id;
		} else {
			return '';
		}
	}
	
	function mt_get_default_array() {
		$defaults = array(
			'state'		  		=> true,
			'page_title'  	=> __('Website is under construction', 'maintenance'),
			'heading'	  		=> __('Maintenance mode is on', 'maintenance'),	
			'description' 	=> __('Website will be available soon', 'maintenance'),
			'footer_text'		=> '&copy; ' . get_bloginfo( 'name' ) . ' ' . date('Y'),
			'logo_width'  	=> 220,
			'logo_height'  	=> '',
			'logo'		  		=> '',
			'retina_logo'		=> '',
			'body_bg'	  		=> mt_insert_attach_sample_files(),
			'body_bg_color' => '#111111',
			'font_color' 		=> '#ffffff',
			'body_font_family' 	=> 'Open Sans',
			'body_font_subset'	=> 'Latin',
			'is_blur'			=> false,
			'blur_intensity'	=> 5,	
			'admin_bar_enabled' => true,
			'503_enabled'		=> false,
			'gg_analytics_id'   => '',
			'is_login'			=> true,
			'custom_css'		=> '',
			'exclude_pages'		=> ''
		);
		return apply_filters( 'mt_get_default_array', $defaults );
	}
	
	if ( !function_exists( 'mt_get_google_fonts') ) {
		function mt_get_google_fonts() {
			$gg_fonts_file = '{"ABeeZee":{"variants":[{"id":"400","name":"Normal 400"},{"id":"400italic","name":"Normal 400 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"Abel":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Abril Fatface":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Aclonica":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Acme":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Actor":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Adamina":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Advent Pro":{"variants":[{"id":"100","name":"Ultra-Light 100"},{"id":"200","name":"Light 200"},{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"500","name":"Medium 500"},{"id":"600","name":"Semi-Bold 600"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"greek","name":"Greek"}]},"Aguafina Script":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Akronim":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Aladin":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Aldrich":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Alef":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"}]},"Alegreya":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"900","name":"Ultra-Bold 900"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"},{"id":"900italic","name":"Ultra-Bold 900 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Alegreya SC":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"900","name":"Ultra-Bold 900"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"},{"id":"900italic","name":"Ultra-Bold 900 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Alegreya Sans":{"variants":[{"id":"100","name":"Ultra-Light 100"},{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"500","name":"Medium 500"},{"id":"700","name":"Bold 700"},{"id":"800","name":"Extra-Bold 800"},{"id":"900","name":"Ultra-Bold 900"},{"id":"100italic","name":"Ultra-Light 100 Italic"},{"id":"300italic","name":"Book 300 Italic"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"500italic","name":"Medium 500 Italic"},{"id":"700italic","name":"Bold 700 Italic"},{"id":"800italic","name":"Extra-Bold 800 Italic"},{"id":"900italic","name":"Ultra-Bold 900 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"vietnamese","name":"Vietnamese"}]},"Alegreya Sans SC":{"variants":[{"id":"100","name":"Ultra-Light 100"},{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"500","name":"Medium 500"},{"id":"700","name":"Bold 700"},{"id":"800","name":"Extra-Bold 800"},{"id":"900","name":"Ultra-Bold 900"},{"id":"100italic","name":"Ultra-Light 100 Italic"},{"id":"300italic","name":"Book 300 Italic"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"500italic","name":"Medium 500 Italic"},{"id":"700italic","name":"Bold 700 Italic"},{"id":"800italic","name":"Extra-Bold 800 Italic"},{"id":"900italic","name":"Ultra-Bold 900 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"vietnamese","name":"Vietnamese"}]},"Alex Brush":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Alfa Slab One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Alice":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Alike":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Alike Angular":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Allan":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Allerta":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Allerta Stencil":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Allura":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Almendra":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Almendra Display":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Almendra SC":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Amarante":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Amaranth":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"Amatic SC":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"}]},"Amethysta":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Anaheim":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Andada":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Andika":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"cyrillic-ext","name":"Cyrillic Extended"}]},"Angkor":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"khmer","name":"Khmer"}]},"Annie Use Your Telescope":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Anonymous Pro":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"cyrillic-ext","name":"Cyrillic Extended"},{"id":"greek","name":"Greek"},{"id":"greek-ext","name":"Greek Extended"}]},"Antic":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Antic Didone":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Antic Slab":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Anton":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Arapey":{"variants":[{"id":"400","name":"Normal 400"},{"id":"400italic","name":"Normal 400 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"Arbutus":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Arbutus Slab":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Architects Daughter":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Archivo Black":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Archivo Narrow":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Arimo":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"cyrillic-ext","name":"Cyrillic Extended"},{"id":"greek","name":"Greek"},{"id":"vietnamese","name":"Vietnamese"},{"id":"greek-ext","name":"Greek Extended"}]},"Arizonia":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Armata":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Artifika":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Arvo":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"Asap":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Asset":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Astloch":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"}]},"Asul":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"}]},"Atomic Age":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Aubrey":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Audiowide":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Autour One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Average":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Average Sans":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Averia Gruesa Libre":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Averia Libre":{"variants":[{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"300italic","name":"Book 300 Italic"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"Averia Sans Libre":{"variants":[{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"300italic","name":"Book 300 Italic"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"Averia Serif Libre":{"variants":[{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"300italic","name":"Book 300 Italic"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"Bad Script":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"}]},"Balthazar":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Bangers":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Basic":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Battambang":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"khmer","name":"Khmer"}]},"Baumans":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Bayon":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"khmer","name":"Khmer"}]},"Belgrano":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Belleza":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"BenchNine":{"variants":[{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Bentham":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Berkshire Swash":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Bevan":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Bigelow Rules":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Bigshot One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Bilbo":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Bilbo Swash Caps":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Bitter":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Black Ops One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Bokor":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"khmer","name":"Khmer"}]},"Bonbon":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Boogaloo":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Bowlby One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Bowlby One SC":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Brawler":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Bree Serif":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Bubblegum Sans":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Bubbler One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Buda":{"variants":[{"id":"300","name":"Book 300"}],"subsets":[{"id":"latin","name":"Latin"}]},"Buenard":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Butcherman":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Butterfly Kids":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Cabin":{"variants":[{"id":"400","name":"Normal 400"},{"id":"500","name":"Medium 500"},{"id":"600","name":"Semi-Bold 600"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"500italic","name":"Medium 500 Italic"},{"id":"600italic","name":"Semi-Bold 600 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"Cabin Condensed":{"variants":[{"id":"400","name":"Normal 400"},{"id":"500","name":"Medium 500"},{"id":"600","name":"Semi-Bold 600"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"}]},"Cabin Sketch":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"}]},"Caesar Dressing":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Cagliostro":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Calligraffitti":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Cambo":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Candal":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Cantarell":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"Cantata One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Cantora One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Capriola":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Cardo":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"greek","name":"Greek"},{"id":"greek-ext","name":"Greek Extended"}]},"Carme":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Carrois Gothic":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Carrois Gothic SC":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Carter One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Caudex":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"greek","name":"Greek"},{"id":"greek-ext","name":"Greek Extended"}]},"Cedarville Cursive":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Ceviche One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Changa One":{"variants":[{"id":"400","name":"Normal 400"},{"id":"400italic","name":"Normal 400 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"Chango":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Chau Philomene One":{"variants":[{"id":"400","name":"Normal 400"},{"id":"400italic","name":"Normal 400 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Chela One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Chelsea Market":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Chenla":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"khmer","name":"Khmer"}]},"Cherry Cream Soda":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Cherry Swash":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Chewy":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Chicle":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Chivo":{"variants":[{"id":"400","name":"Normal 400"},{"id":"900","name":"Ultra-Bold 900"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"900italic","name":"Ultra-Bold 900 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"Cinzel":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"900","name":"Ultra-Bold 900"}],"subsets":[{"id":"latin","name":"Latin"}]},"Cinzel Decorative":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"900","name":"Ultra-Bold 900"}],"subsets":[{"id":"latin","name":"Latin"}]},"Clicker Script":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Coda":{"variants":[{"id":"400","name":"Normal 400"},{"id":"800","name":"Extra-Bold 800"}],"subsets":[{"id":"latin","name":"Latin"}]},"Coda Caption":{"variants":[{"id":"800","name":"Extra-Bold 800"}],"subsets":[{"id":"latin","name":"Latin"}]},"Codystar":{"variants":[{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Combo":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Comfortaa":{"variants":[{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"cyrillic-ext","name":"Cyrillic Extended"},{"id":"greek","name":"Greek"}]},"Coming Soon":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Concert One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Condiment":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Content":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"khmer","name":"Khmer"}]},"Contrail One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Convergence":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Cookie":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Copse":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Corben":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"}]},"Courgette":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Cousine":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"cyrillic-ext","name":"Cyrillic Extended"},{"id":"greek","name":"Greek"},{"id":"vietnamese","name":"Vietnamese"},{"id":"greek-ext","name":"Greek Extended"}]},"Coustard":{"variants":[{"id":"400","name":"Normal 400"},{"id":"900","name":"Ultra-Bold 900"}],"subsets":[{"id":"latin","name":"Latin"}]},"Covered By Your Grace":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Crafty Girls":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Creepster":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Crete Round":{"variants":[{"id":"400","name":"Normal 400"},{"id":"400italic","name":"Normal 400 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Crimson Text":{"variants":[{"id":"400","name":"Normal 400"},{"id":"600","name":"Semi-Bold 600"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"600italic","name":"Semi-Bold 600 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"Croissant One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Crushed":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Cuprum":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Cutive":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Cutive Mono":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Damion":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Dancing Script":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"}]},"Dangrek":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"khmer","name":"Khmer"}]},"Dawning of a New Day":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Days One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Delius":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Delius Swash Caps":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Delius Unicase":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"}]},"Della Respira":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Denk One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Devonshire":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Didact Gothic":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"cyrillic-ext","name":"Cyrillic Extended"},{"id":"greek","name":"Greek"},{"id":"greek-ext","name":"Greek Extended"}]},"Diplomata":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Diplomata SC":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Domine":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Donegal One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Doppio One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Dorsa":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Dosis":{"variants":[{"id":"200","name":"Light 200"},{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"500","name":"Medium 500"},{"id":"600","name":"Semi-Bold 600"},{"id":"700","name":"Bold 700"},{"id":"800","name":"Extra-Bold 800"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Dr Sugiyama":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Droid Sans":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"}]},"Droid Sans Mono":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Droid Serif":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"Duru Sans":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Dynalight":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"EB Garamond":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"cyrillic-ext","name":"Cyrillic Extended"},{"id":"vietnamese","name":"Vietnamese"}]},"Eagle Lake":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Eater":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Economica":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Electrolize":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Elsie":{"variants":[{"id":"400","name":"Normal 400"},{"id":"900","name":"Ultra-Bold 900"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Elsie Swash Caps":{"variants":[{"id":"400","name":"Normal 400"},{"id":"900","name":"Ultra-Bold 900"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Emblema One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Emilys Candy":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Engagement":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Englebert":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Enriqueta":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Erica One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Esteban":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Euphoria Script":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Ewert":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Exo":{"variants":[{"id":"100","name":"Ultra-Light 100"},{"id":"200","name":"Light 200"},{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"500","name":"Medium 500"},{"id":"600","name":"Semi-Bold 600"},{"id":"700","name":"Bold 700"},{"id":"800","name":"Extra-Bold 800"},{"id":"900","name":"Ultra-Bold 900"},{"id":"100italic","name":"Ultra-Light 100 Italic"},{"id":"200italic","name":"Light 200 Italic"},{"id":"300italic","name":"Book 300 Italic"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"500italic","name":"Medium 500 Italic"},{"id":"600italic","name":"Semi-Bold 600 Italic"},{"id":"700italic","name":"Bold 700 Italic"},{"id":"800italic","name":"Extra-Bold 800 Italic"},{"id":"900italic","name":"Ultra-Bold 900 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Exo 2":{"variants":[{"id":"100","name":"Ultra-Light 100"},{"id":"200","name":"Light 200"},{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"500","name":"Medium 500"},{"id":"600","name":"Semi-Bold 600"},{"id":"700","name":"Bold 700"},{"id":"800","name":"Extra-Bold 800"},{"id":"900","name":"Ultra-Bold 900"},{"id":"100italic","name":"Ultra-Light 100 Italic"},{"id":"200italic","name":"Light 200 Italic"},{"id":"300italic","name":"Book 300 Italic"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"500italic","name":"Medium 500 Italic"},{"id":"600italic","name":"Semi-Bold 600 Italic"},{"id":"700italic","name":"Bold 700 Italic"},{"id":"800italic","name":"Extra-Bold 800 Italic"},{"id":"900italic","name":"Ultra-Bold 900 Italic"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Expletus Sans":{"variants":[{"id":"400","name":"Normal 400"},{"id":"500","name":"Medium 500"},{"id":"600","name":"Semi-Bold 600"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"500italic","name":"Medium 500 Italic"},{"id":"600italic","name":"Semi-Bold 600 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"Fanwood Text":{"variants":[{"id":"400","name":"Normal 400"},{"id":"400italic","name":"Normal 400 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"Fascinate":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Fascinate Inline":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Faster One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Fasthand":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"khmer","name":"Khmer"}]},"Fauna One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Federant":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Federo":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Felipa":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Fenix":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Finger Paint":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Fjalla One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Fjord One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Flamenco":{"variants":[{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Flavors":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Fondamento":{"variants":[{"id":"400","name":"Normal 400"},{"id":"400italic","name":"Normal 400 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Fontdiner Swanky":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Forum":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"cyrillic-ext","name":"Cyrillic Extended"}]},"Francois One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Freckle Face":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Fredericka the Great":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Fredoka One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Freehand":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"khmer","name":"Khmer"}]},"Fresca":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Frijole":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Fruktur":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Fugaz One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"GFS Didot":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"greek","name":"Greek"}]},"GFS Neohellenic":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"greek","name":"Greek"}]},"Gabriela":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Gafata":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Galdeano":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Galindo":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Gentium Basic":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Gentium Book Basic":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Geo":{"variants":[{"id":"400","name":"Normal 400"},{"id":"400italic","name":"Normal 400 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"Geostar":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Geostar Fill":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Germania One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Gilda Display":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Give You Glory":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Glass Antiqua":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Glegoo":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Gloria Hallelujah":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Goblin One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Gochi Hand":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Gorditas":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"}]},"Goudy Bookletter 1911":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Graduate":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Grand Hotel":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Gravitas One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Great Vibes":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Griffy":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Gruppo":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Gudea":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Habibi":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Hammersmith One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Hanalei":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Hanalei Fill":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Handlee":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Hanuman":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"khmer","name":"Khmer"}]},"Happy Monkey":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Headland One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Henny Penny":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Herr Von Muellerhoff":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Holtwood One SC":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Homemade Apple":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Homenaje":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"IM Fell DW Pica":{"variants":[{"id":"400","name":"Normal 400"},{"id":"400italic","name":"Normal 400 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"IM Fell DW Pica SC":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"IM Fell Double Pica":{"variants":[{"id":"400","name":"Normal 400"},{"id":"400italic","name":"Normal 400 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"IM Fell Double Pica SC":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"IM Fell English":{"variants":[{"id":"400","name":"Normal 400"},{"id":"400italic","name":"Normal 400 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"IM Fell English SC":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"IM Fell French Canon":{"variants":[{"id":"400","name":"Normal 400"},{"id":"400italic","name":"Normal 400 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"IM Fell French Canon SC":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"IM Fell Great Primer":{"variants":[{"id":"400","name":"Normal 400"},{"id":"400italic","name":"Normal 400 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"IM Fell Great Primer SC":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Iceberg":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Iceland":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Imprima":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Inconsolata":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Inder":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Indie Flower":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Inika":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Irish Grover":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Istok Web":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"cyrillic-ext","name":"Cyrillic Extended"}]},"Italiana":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Italianno":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Jacques Francois":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Jacques Francois Shadow":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Jim Nightshade":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Jockey One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Jolly Lodger":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Josefin Sans":{"variants":[{"id":"100","name":"Ultra-Light 100"},{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"600","name":"Semi-Bold 600"},{"id":"700","name":"Bold 700"},{"id":"100italic","name":"Ultra-Light 100 Italic"},{"id":"300italic","name":"Book 300 Italic"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"600italic","name":"Semi-Bold 600 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"Josefin Slab":{"variants":[{"id":"100","name":"Ultra-Light 100"},{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"600","name":"Semi-Bold 600"},{"id":"700","name":"Bold 700"},{"id":"100italic","name":"Ultra-Light 100 Italic"},{"id":"300italic","name":"Book 300 Italic"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"600italic","name":"Semi-Bold 600 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"Joti One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Judson":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"Julee":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Julius Sans One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Junge":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Jura":{"variants":[{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"500","name":"Medium 500"},{"id":"600","name":"Semi-Bold 600"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"cyrillic-ext","name":"Cyrillic Extended"},{"id":"greek","name":"Greek"},{"id":"greek-ext","name":"Greek Extended"}]},"Just Another Hand":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Just Me Again Down Here":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Kameron":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"}]},"Kantumruy":{"variants":[{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"khmer","name":"Khmer"}]},"Karla":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Kaushan Script":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Kavoon":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Kdam Thmor":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"khmer","name":"Khmer"}]},"Keania One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Kelly Slab":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Kenia":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Khmer":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"khmer","name":"Khmer"}]},"Kite One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Knewave":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Kotta One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Koulen":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"khmer","name":"Khmer"}]},"Kranky":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Kreon":{"variants":[{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"}]},"Kristi":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Krona One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"La Belle Aurore":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Lancelot":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Lato":{"variants":[{"id":"100","name":"Ultra-Light 100"},{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"900","name":"Ultra-Bold 900"},{"id":"100italic","name":"Ultra-Light 100 Italic"},{"id":"300italic","name":"Book 300 Italic"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"},{"id":"900italic","name":"Ultra-Bold 900 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"League Script":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Leckerli One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Ledger":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Lekton":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Lemon":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Libre Baskerville":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Life Savers":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Lilita One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Lily Script One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Limelight":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Linden Hill":{"variants":[{"id":"400","name":"Normal 400"},{"id":"400italic","name":"Normal 400 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"Lobster":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"cyrillic-ext","name":"Cyrillic Extended"}]},"Lobster Two":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"Londrina Outline":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Londrina Shadow":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Londrina Sketch":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Londrina Solid":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Lora":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Love Ya Like A Sister":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Loved by the King":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Lovers Quarrel":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Luckiest Guy":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Lusitana":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"}]},"Lustria":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Macondo":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Macondo Swash Caps":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Magra":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Maiden Orange":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Mako":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Marcellus":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Marcellus SC":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Marck Script":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Margarine":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Marko One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Marmelad":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Marvel":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"Martel Sans":{"variants":[{"id":"200","name":"Extra-light 200"},{"id":"300","name":"Light 300"},{"id":"400","name":"Normal 400"},{"id":"600","name":"Semi-bold 600"},{"id":"700","name":"Bold 700"},{"id":"800","name":"Extra-bold 800"},{"id":"900","name":"Black 900"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"devanagari","name":"Devanagari"}]},"Mate":{"variants":[{"id":"400","name":"Normal 400"},{"id":"400italic","name":"Normal 400 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"Mate SC":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Maven Pro":{"variants":[{"id":"400","name":"Normal 400"},{"id":"500","name":"Medium 500"},{"id":"700","name":"Bold 700"},{"id":"900","name":"Ultra-Bold 900"}],"subsets":[{"id":"latin","name":"Latin"}]},"McLaren":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Meddon":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"MedievalSharp":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Medula One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Megrim":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Meie Script":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Merienda":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Merienda One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Merriweather":{"variants":[{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"900","name":"Ultra-Bold 900"},{"id":"300italic","name":"Book 300 Italic"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"},{"id":"900italic","name":"Ultra-Bold 900 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Merriweather Sans":{"variants":[{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"800","name":"Extra-Bold 800"},{"id":"300italic","name":"Book 300 Italic"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"},{"id":"800italic","name":"Extra-Bold 800 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Metal":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"khmer","name":"Khmer"}]},"Metal Mania":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Metamorphous":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Metrophobic":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Michroma":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Milonga":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Miltonian":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Miltonian Tattoo":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Miniver":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Miss Fajardose":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Modern Antiqua":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Molengo":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Molle":{"variants":[{"id":"400italic","name":"Normal 400 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Monda":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Monofett":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Monoton":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Monsieur La Doulaise":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Montaga":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Montez":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Montserrat":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"}]},"Montserrat Alternates":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"}]},"Montserrat Subrayada":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"}]},"Moul":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"khmer","name":"Khmer"}]},"Moulpali":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"khmer","name":"Khmer"}]},"Mountains of Christmas":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"}]},"Mouse Memoirs":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Mr Bedfort":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Mr Dafoe":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Mr De Haviland":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Mrs Saint Delafield":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Mrs Sheppards":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Muli":{"variants":[{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"300italic","name":"Book 300 Italic"},{"id":"400italic","name":"Normal 400 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"Mystery Quest":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Neucha":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"}]},"Neuton":{"variants":[{"id":"200","name":"Light 200"},{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"800","name":"Extra-Bold 800"},{"id":"400italic","name":"Normal 400 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"New Rocker":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"News Cycle":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Niconne":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Nixie One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Nobile":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"Nokora":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"khmer","name":"Khmer"}]},"Norican":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Nosifer":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Nothing You Could Do":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Noticia Text":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"vietnamese","name":"Vietnamese"}]},"Noto Sans":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"devanagari","name":"Devanagari"},{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"cyrillic-ext","name":"Cyrillic Extended"},{"id":"greek","name":"Greek"},{"id":"vietnamese","name":"Vietnamese"},{"id":"greek-ext","name":"Greek Extended"}]},"Noto Serif":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"cyrillic-ext","name":"Cyrillic Extended"},{"id":"greek","name":"Greek"},{"id":"vietnamese","name":"Vietnamese"},{"id":"greek-ext","name":"Greek Extended"}]},"Nova Cut":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Nova Flat":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Nova Mono":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"greek","name":"Greek"}]},"Nova Oval":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Nova Round":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Nova Script":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Nova Slim":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Nova Square":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Numans":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Nunito":{"variants":[{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"}]},"Odor Mean Chey":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"khmer","name":"Khmer"}]},"Offside":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Old Standard TT":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"Oldenburg":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Oleo Script":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Oleo Script Swash Caps":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Open Sans":{"variants":[{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"600","name":"Semi-Bold 600"},{"id":"700","name":"Bold 700"},{"id":"800","name":"Extra-Bold 800"},{"id":"300italic","name":"Book 300 Italic"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"600italic","name":"Semi-Bold 600 Italic"},{"id":"700italic","name":"Bold 700 Italic"},{"id":"800italic","name":"Extra-Bold 800 Italic"}],"subsets":[{"id":"devanagari","name":"Devanagari"},{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"cyrillic-ext","name":"Cyrillic Extended"},{"id":"greek","name":"Greek"},{"id":"vietnamese","name":"Vietnamese"},{"id":"greek-ext","name":"Greek Extended"}]},"Open Sans Condensed":{"variants":[{"id":"300","name":"Book 300"},{"id":"700","name":"Bold 700"},{"id":"300italic","name":"Book 300 Italic"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"cyrillic-ext","name":"Cyrillic Extended"},{"id":"greek","name":"Greek"},{"id":"vietnamese","name":"Vietnamese"},{"id":"greek-ext","name":"Greek Extended"}]},"Oranienbaum":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"cyrillic-ext","name":"Cyrillic Extended"}]},"Orbitron":{"variants":[{"id":"400","name":"Normal 400"},{"id":"500","name":"Medium 500"},{"id":"700","name":"Bold 700"},{"id":"900","name":"Ultra-Bold 900"}],"subsets":[{"id":"latin","name":"Latin"}]},"Oregano":{"variants":[{"id":"400","name":"Normal 400"},{"id":"400italic","name":"Normal 400 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Orienta":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Original Surfer":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Oswald":{"variants":[{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Over the Rainbow":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Overlock":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"900","name":"Ultra-Bold 900"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"},{"id":"900italic","name":"Ultra-Bold 900 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Overlock SC":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Ovo":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Oxygen":{"variants":[{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Oxygen Mono":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"PT Mono":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"cyrillic-ext","name":"Cyrillic Extended"}]},"PT Sans":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"cyrillic-ext","name":"Cyrillic Extended"}]},"PT Sans Caption":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"cyrillic-ext","name":"Cyrillic Extended"}]},"PT Sans Narrow":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"cyrillic-ext","name":"Cyrillic Extended"}]},"PT Serif":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"cyrillic-ext","name":"Cyrillic Extended"}]},"PT Serif Caption":{"variants":[{"id":"400","name":"Normal 400"},{"id":"400italic","name":"Normal 400 Italic"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"cyrillic-ext","name":"Cyrillic Extended"}]},"Pacifico":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Paprika":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Parisienne":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Passero One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Passion One":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"900","name":"Ultra-Bold 900"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Pathway Gothic One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Patrick Hand":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"vietnamese","name":"Vietnamese"}]},"Patrick Hand SC":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"vietnamese","name":"Vietnamese"}]},"Patua One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Paytone One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Peralta":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Permanent Marker":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Petit Formal Script":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Petrona":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Philosopher":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"}]},"Piedra":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Pinyon Script":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Pirata One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Plaster":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Play":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"cyrillic-ext","name":"Cyrillic Extended"},{"id":"greek","name":"Greek"},{"id":"greek-ext","name":"Greek Extended"}]},"Playball":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Playfair Display":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"900","name":"Ultra-Bold 900"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"},{"id":"900italic","name":"Ultra-Bold 900 Italic"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Playfair Display SC":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"900","name":"Ultra-Bold 900"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"},{"id":"900italic","name":"Ultra-Bold 900 Italic"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Podkova":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"}]},"Poiret One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Poller One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Poly":{"variants":[{"id":"400","name":"Normal 400"},{"id":"400italic","name":"Normal 400 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"Pompiere":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Pontano Sans":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Port Lligat Sans":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Port Lligat Slab":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Prata":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Preahvihear":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"khmer","name":"Khmer"}]},"Press Start 2P":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"greek","name":"Greek"}]},"Princess Sofia":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Prociono":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Prosto One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Puritan":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"Purple Purse":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Quando":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Quantico":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"Quattrocento":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Quattrocento Sans":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Questrial":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Quicksand":{"variants":[{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"}]},"Quintessential":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Qwigley":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Racing Sans One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Radley":{"variants":[{"id":"400","name":"Normal 400"},{"id":"400italic","name":"Normal 400 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Raleway":{"variants":[{"id":"100","name":"Ultra-Light 100"},{"id":"200","name":"Light 200"},{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"500","name":"Medium 500"},{"id":"600","name":"Semi-Bold 600"},{"id":"700","name":"Bold 700"},{"id":"800","name":"Extra-Bold 800"},{"id":"900","name":"Ultra-Bold 900"}],"subsets":[{"id":"latin","name":"Latin"}]},"Raleway Dots":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Rambla":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Rammetto One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Ranchers":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Rancho":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Rationale":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Redressed":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Reenie Beanie":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Revalia":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Ribeye":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Ribeye Marrow":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Righteous":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Risque":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Roboto":{"variants":[{"id":"100","name":"Ultra-Light 100"},{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"500","name":"Medium 500"},{"id":"700","name":"Bold 700"},{"id":"900","name":"Ultra-Bold 900"},{"id":"100italic","name":"Ultra-Light 100 Italic"},{"id":"300italic","name":"Book 300 Italic"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"500italic","name":"Medium 500 Italic"},{"id":"700italic","name":"Bold 700 Italic"},{"id":"900italic","name":"Ultra-Bold 900 Italic"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"cyrillic-ext","name":"Cyrillic Extended"},{"id":"greek","name":"Greek"},{"id":"vietnamese","name":"Vietnamese"},{"id":"greek-ext","name":"Greek Extended"}]},"Roboto Condensed":{"variants":[{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"300italic","name":"Book 300 Italic"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"cyrillic-ext","name":"Cyrillic Extended"},{"id":"greek","name":"Greek"},{"id":"vietnamese","name":"Vietnamese"},{"id":"greek-ext","name":"Greek Extended"}]},"Roboto Slab":{"variants":[{"id":"100","name":"Ultra-Light 100"},{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"cyrillic-ext","name":"Cyrillic Extended"},{"id":"greek","name":"Greek"},{"id":"vietnamese","name":"Vietnamese"},{"id":"greek-ext","name":"Greek Extended"}]},"Rochester":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Rock Salt":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Rokkitt":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"}]},"Romanesco":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Ropa Sans":{"variants":[{"id":"400","name":"Normal 400"},{"id":"400italic","name":"Normal 400 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Rosario":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"Rosarivo":{"variants":[{"id":"400","name":"Normal 400"},{"id":"400italic","name":"Normal 400 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Rouge Script":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Ruda":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"900","name":"Ultra-Bold 900"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Rufina":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Ruge Boogie":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Ruluko":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Rum Raisin":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Ruslan Display":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"cyrillic-ext","name":"Cyrillic Extended"}]},"Russo One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Ruthie":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Rye":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Sacramento":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Sail":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Salsa":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Sanchez":{"variants":[{"id":"400","name":"Normal 400"},{"id":"400italic","name":"Normal 400 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Sancreek":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Sansita One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Sarina":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Satisfy":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Scada":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Schoolbell":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Seaweed Script":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Sevillana":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Seymour One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Shadows Into Light":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Shadows Into Light Two":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Shanti":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Share":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Share Tech":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Share Tech Mono":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Shojumaru":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Short Stack":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Siemreap":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"khmer","name":"Khmer"}]},"Sigmar One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Signika":{"variants":[{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"600","name":"Semi-Bold 600"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Signika Negative":{"variants":[{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"600","name":"Semi-Bold 600"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Simonetta":{"variants":[{"id":"400","name":"Normal 400"},{"id":"900","name":"Ultra-Bold 900"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"900italic","name":"Ultra-Bold 900 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Sintony":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Sirin Stencil":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Six Caps":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Skranji":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Slackey":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Smokum":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Smythe":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Sniglet":{"variants":[{"id":"400","name":"Normal 400"},{"id":"800","name":"Extra-Bold 800"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Snippet":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Snowburst One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Sofadi One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Sofia":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Sonsie One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Sorts Mill Goudy":{"variants":[{"id":"400","name":"Normal 400"},{"id":"400italic","name":"Normal 400 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Source Code Pro":{"variants":[{"id":"200","name":"Light 200"},{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"500","name":"Medium 500"},{"id":"600","name":"Semi-Bold 600"},{"id":"700","name":"Bold 700"},{"id":"900","name":"Ultra-Bold 900"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Source Sans Pro":{"variants":[{"id":"200","name":"Light 200"},{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"600","name":"Semi-Bold 600"},{"id":"700","name":"Bold 700"},{"id":"900","name":"Ultra-Bold 900"},{"id":"200italic","name":"Light 200 Italic"},{"id":"300italic","name":"Book 300 Italic"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"600italic","name":"Semi-Bold 600 Italic"},{"id":"700italic","name":"Bold 700 Italic"},{"id":"900italic","name":"Ultra-Bold 900 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"vietnamese","name":"Vietnamese"}]},"Special Elite":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Spicy Rice":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Spinnaker":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Spirax":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Squada One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Stalemate":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Stalinist One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Stardos Stencil":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"}]},"Stint Ultra Condensed":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Stint Ultra Expanded":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Stoke":{"variants":[{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Strait":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Sue Ellen Francisco":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Sunshiney":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Supermercado One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Suwannaphum":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"khmer","name":"Khmer"}]},"Swanky and Moo Moo":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Syncopate":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"}]},"Tangerine":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"}]},"Taprom":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"khmer","name":"Khmer"}]},"Tauri":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Telex":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Tenor Sans":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"cyrillic-ext","name":"Cyrillic Extended"}]},"Text Me One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"The Girl Next Door":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Tienne":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"900","name":"Ultra-Bold 900"}],"subsets":[{"id":"latin","name":"Latin"}]},"Tinos":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"cyrillic-ext","name":"Cyrillic Extended"},{"id":"greek","name":"Greek"},{"id":"vietnamese","name":"Vietnamese"},{"id":"greek-ext","name":"Greek Extended"}]},"Titan One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Titillium Web":{"variants":[{"id":"200","name":"Light 200"},{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"600","name":"Semi-Bold 600"},{"id":"700","name":"Bold 700"},{"id":"900","name":"Ultra-Bold 900"},{"id":"200italic","name":"Light 200 Italic"},{"id":"300italic","name":"Book 300 Italic"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"600italic","name":"Semi-Bold 600 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Trade Winds":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Trocchi":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Trochut":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"Trykker":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Tulpen One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Ubuntu":{"variants":[{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"500","name":"Medium 500"},{"id":"700","name":"Bold 700"},{"id":"300italic","name":"Book 300 Italic"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"500italic","name":"Medium 500 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"cyrillic-ext","name":"Cyrillic Extended"},{"id":"greek","name":"Greek"},{"id":"greek-ext","name":"Greek Extended"}]},"Ubuntu Condensed":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"cyrillic-ext","name":"Cyrillic Extended"},{"id":"greek","name":"Greek"},{"id":"greek-ext","name":"Greek Extended"}]},"Ubuntu Mono":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"},{"id":"cyrillic-ext","name":"Cyrillic Extended"},{"id":"greek","name":"Greek"},{"id":"greek-ext","name":"Greek Extended"}]},"Ultra":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Uncial Antiqua":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Underdog":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Unica One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"UnifrakturCook":{"variants":[{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"}]},"UnifrakturMaguntia":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Unkempt":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"}]},"Unlock":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Unna":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"VT323":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Vampiro One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Varela":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Varela Round":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Vast Shadow":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Vibur":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Vidaloka":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Viga":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Voces":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Volkhov":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"Vollkorn":{"variants":[{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"},{"id":"400italic","name":"Normal 400 Italic"},{"id":"700italic","name":"Bold 700 Italic"}],"subsets":[{"id":"latin","name":"Latin"}]},"Voltaire":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Waiting for the Sunrise":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Wallpoet":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Walter Turncoat":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Warnes":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Wellfleet":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Wendy One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Wire One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Yanone Kaffeesatz":{"variants":[{"id":"200","name":"Light 200"},{"id":"300","name":"Book 300"},{"id":"400","name":"Normal 400"},{"id":"700","name":"Bold 700"}],"subsets":[{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Yellowtail":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Yeseva One":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"cyrillic","name":"Cyrillic"},{"id":"latin","name":"Latin"},{"id":"latin-ext","name":"Latin Extended"}]},"Yesteryear":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]},"Zeyada":{"variants":[{"id":"400","name":"Normal 400"}],"subsets":[{"id":"latin","name":"Latin"}]}}';
			return $gg_fonts_file;
		}	
	}
