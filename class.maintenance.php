<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


if ( ! class_exists( 'MaintenancePlugin' ) ) {
    class MaintenancePlugin
    {

        protected static $instance;  // object instance
        public $options_page;

        /**
         * Get active instance
         *
         * @access      public
         * @since       3.1.3
         * @return      self::$instance The one true MaintenancePlugin
         */
        public static function instance()
        {
            if ( ! self::$instance ) {
                self::$instance = new self;
                self::$instance->hooks();
                self::$instance->includes();
            }
            return self::$instance;
        }


        /**
         * Run action and filter hooks
         *
         * @access      private
         * @since       3.1.3
         * @return      void
         */
        private function hooks()
        {
//            add_action( 'plugins_loaded', array(self::$instance, 'constants'), 	1); // now in index file
            add_action('plugins_loaded', array($this, 'lang'), 2); // include languages files
            add_action('plugins_loaded', array($this, 'includes'), 3); // include func files
//            add_action( 'plugins_loaded', array( $this, 'admin'),	 	4);

//            add_action('template_include', array( $this, 'mt_template_include'), 9999);
            add_action('wp_logout',	array( $this, 'mt_user_logout'));
            add_action('init', array($this, 'mt_admin_bar')); // show admin bar
//            add_action('init', array( $this, 'mt_set_global_options'), 1);
            add_action('admin_menu', array($this, 'maintenance_admin_page')); // add page to admin panel

            register_activation_hook  ( __FILE__, array( $this,  'mt_activation' ));
            register_deactivation_hook( __FILE__, array( $this, 'mt_deactivation') );
        }



        /**
         * Load translations
         *
         * @return void
         */
        function lang() {
            load_plugin_textdomain( 'maintenance', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
        }


        /**
         * Include required files
         *
         * @access      public
         * @return      void
         */
        public function includes()
        {
            // Include MaintenanceCore
//            require_once( MAINTENANCE_INCLUDES . 'functions.php' );
//            require_once( MAINTENANCE_INCLUDES . 'update.php' );
//            require_once( MAINTENANCE_DIR 	   . 'load/functions.php' );

        }


        /**
         * Plugin page in admin panel
         *
         * @return void
         */
        public function maintenance_admin_page()
        {

            add_action('add_mt_meta_boxes', array($this, 'maintenance_page_create_meta_boxes'), 10);
            /* add page */
            $this->options_page = add_menu_page( __( 'Maintenance', 'maintenance' ), __( 'Maintenance', 'maintenance' ), 'manage_options', 'maintenance', array($this, 'manage_options'),  MAINTENANCE_URI . '/images/icon-small.png');

            global $options_page;
            $options_page = $this->options_page;
            /* add scripts and metaboxes */
            add_action("admin_init", array($this, 'mt_register_settings'));
            add_action("admin_head-{$this->options_page}", array($this, 'maintenance_metaboxes_scripts'));
            add_action("admin_print_styles-{$this->options_page}",  array($this, 'admin_print_custom_styles'));
            add_action("load-{$this->options_page}", array($this, 'maintenance_page_add_meta_boxes'));
        }

        public function maintenance_page_add_meta_boxes() {
            do_action('add_mt_meta_boxes', $this->options_page);
        }

        /**
         * Save plugin options
         *
         * @return void
         */
        public function mt_register_settings() {
            if ( !empty($_POST['lib_options']) && check_admin_referer('maintenance_edit_post','maintenance_nonce') ) {
                if (!isset($_POST['lib_options']['state'])) { $_POST['lib_options']['state'] = 0; }
                else {	   $_POST['lib_options']['state'] = 1; }

                if (isset($_POST['lib_options']['htmlcss'])) {
                    $_POST['lib_options']['htmlcss'] = wp_kses_stripslashes($_POST['lib_options']['htmlcss']);
                }

                if (isset($_POST['lib_options'])) {
                    update_option( 'maintenance_options',  $_POST['lib_options']);
                    maintenance::mt_clear_cache();
                }
            }
        }


        /**
         * Add scripts and styles
         *
         * @return void
         */
        function admin_print_custom_styles() {
            if( function_exists( 'wp_enqueue_media' ) ){
                wp_enqueue_media();
            } else {
                wp_enqueue_script('media-upload');
                wp_enqueue_script('thickbox');
                wp_enqueue_style ('thickbox');
            }

            wp_enqueue_script( 'common' );
            wp_enqueue_script( 'wp-lists' );
            wp_enqueue_script( 'postbox' );

            wp_enqueue_style  ('arvo', '//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700|Arvo:400,400italic,700,700italic' );
            wp_enqueue_style  ('wp-color-picker' );

            // fix a bug with WooCommerce 3.2.2
            wp_dequeue_script ('select2' );
            wp_enqueue_script ('select2',    MAINTENANCE_URI .'js/select2/select2.min.js' );
            wp_enqueue_style  ('select2',    MAINTENANCE_URI .'js/select2/select2.css' );

            wp_enqueue_script ('uplaods_',    MAINTENANCE_URI .'js/uploads_.min.js' );
            wp_register_script ('maintenance', MAINTENANCE_URI .'js/init.min.js', array( 'wp-color-picker' ), false, true );
            wp_localize_script( 'maintenance', 'maintenance', 	array( 	'path' 	=> MAINTENANCE_URI)	);
            wp_enqueue_script  ('maintenance');
            wp_enqueue_style  ('maintenance', MAINTENANCE_URI .'css/admin.css' );
        }


        /**
         * Show plugin page
         */
        function manage_options()  {
            $this->generate_plugin_page();
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

        /**
         * Generate plagin page
         */
        function generate_plugin_page() {
            $mt_option = $this->mt_get_plugin_options(true);
            ?>
            <div id="maintenance-options" class="wrap">
                <form method="post" action="" enctype="multipart/form-data" name="options-form">
                    <?php wp_nonce_field('maintenance_edit_post','maintenance_nonce'); ?>
                    <?php wp_nonce_field('meta-box-order',  'meta-box-order-nonce', false ); ?>
                    <?php wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false ); ?>
                    <div class="postbox-container header-container column-1 normal">
                        <h1><?php _e('Maintenance', 'maintenance'); ?><input type="checkbox" id="state" name="lib_options[state]" <?php checked($mt_option['state'], 1); ?> /> <?php submit_button(__('Save changes', 'maintenance'), 'primary'); ?></h1>

                    </div>
                    <div class="clear"></div>
                    <div id="poststuff">
                        <div class="metabox-holder">
                            <div id="all-fileds" class="postbox-container column-1 normal">

                                <?php do_meta_boxes($this->options_page,'normal',null); ?>
                                <?php do_meta_boxes($this->options_page,'advanced',null); ?>
                            </div>

                            <div id="promo" class="postbox-container column-2 normal">
                                <?php do_meta_boxes($this->options_page,'side',null); ?>
                            </div>

                        </div>
                        <?php submit_button(__('Save changes', 'maintenance'), 'primary'); ?>
                    </div>
                </form>
            </div>
            <?php
        }

        function mt_get_plugin_options($is_current = false) {
            $saved	  = (array) get_option('maintenance_options');
            if (!$is_current) {
                $options  = wp_parse_args(get_option('maintenance_options', array()),  mt_get_default_array());
            } else {
                $options  = $saved;
            }
            return $options;
        }


        /**
         * Show admin panel at front page
         *
         * @return void
         */
        function mt_admin_bar() {
            add_action('admin_bar_menu', array($this, 'maintenance_add_toolbar_items'), 100);
            if (!is_super_admin() ) {
                $mt_options = $this->mt_get_plugin_options(true);
                if (isset($mt_options['admin_bar_enabled']) && is_user_logged_in()) {
                    add_filter('show_admin_bar', '__return_true');
                } else {
                    add_filter('show_admin_bar', '__return_false');
                }
            }
        }

        function maintenance_add_toolbar_items(){
            global $wp_admin_bar, $wpdb;
            $mt_options	= $this->mt_get_plugin_options(true);
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

        function mt_user_logout() {
            wp_safe_redirect(get_bloginfo('url'));
            exit;
        }
        function maintenance_page_create_meta_boxes() {
            add_meta_box( 'maintenance-general', __( 'General Settings', 'maintenance' ),  array($this, 'add_data_fields'), $this->options_page, 'normal', 'default');
            add_meta_box( 'maintenance-css', 	 __( 'Custom CSS', 'maintenance' ),        'add_css_fields', $this->options_page, 'normal', 'default');
            add_meta_box( 'maintenance-excludepages', 	 __( 'Exclude pages from maintenance mode', 'maintenance' ), 'add_exclude_pages_fields', $this->options_page, 'normal', 'default');
        }

        function add_data_fields ($object, $box) {
            $mt_option = $this->mt_get_plugin_options(true);
            $is_blur   = false;

            /*Deafult Variable*/
            $page_title = $heading = $description = $logo_width = $logo_height = '';

            $allowed_tags = wp_kses_allowed_html( 'post' );
            if (isset($mt_option['page_title']))  $page_title 	= wp_kses(stripslashes($mt_option['page_title']), $allowed_tags);
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
    }

}