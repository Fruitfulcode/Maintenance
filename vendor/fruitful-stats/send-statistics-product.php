<?php

class Maintenance_Stats extends FruitfulStatistic {
	
	public $product_type = 'plugin';
	
    public $product_option_name = 'maintenance_options';
    
	/**
	 * Constructor
	 **/
	public function __construct( $root_file ) {
		parent::__construct( $root_file );
	}
    
    /**
	 * Function update product options from general ffc statistic option
	 * (individual for each product)
	 */
	public function product_stats_settings_update() {
		$ffc_statistics_option = get_option('ffc_statistics_option');
		$options = get_option( $this->product_option_name );

		if( !empty($ffc_statistics_option) ) {

			if( isset($ffc_statistics_option['ffc_statistic']) ) {
				$options['ffc_statistic'] = ($ffc_statistics_option['ffc_statistic'] === 1) ? '1' : '0';
			} else {
				$options['ffc_statistic'] = '1';
			}

			if( isset($ffc_statistics_option['ffc_subscribe']) ) {
				$options['ffc_subscribe']= ($ffc_statistics_option['ffc_subscribe'] === 1) ? '1' : '0';
			} else {
				$options['ffc_subscribe'] = '0';
			}

			if( isset($ffc_statistics_option['ffc_subscribe_name']) ) {
				$options['ffc_subscribe_name'] = sanitize_text_field($ffc_statistics_option['ffc_subscribe_name']);
			} else {
				$options['ffc_subscribe_name'] = '';
			}

			if( isset($ffc_statistics_option['ffc_subscribe_email']) ) {
				$options['ffc_subscribe_email'] = sanitize_email($ffc_statistics_option['ffc_subscribe_email']);
			} else {
				$options['ffc_subscribe_email'] = '';
			}

			update_option( $this->product_option_name, $options );
		}
	}
	
		/**
		 * Function update general ffc_statistics_option on save theme PRODUCT options
		 * (individual for each product)
		 *
		 * @param $value
		 * @param $old_value
		 *
		 * @return mixed
		 */
		public function general_stats_option_update( $value, $old_value ) {
			
			if ( ! isset( $value['ffc_subscribe'] ) && ! isset( $old_value['ffc_subscribe'] ) &&
			     ! isset( $value['ffc_subscribe_name'] ) && ! isset( $old_value['ffc_subscribe_name'] ) &&
			     ! isset( $value['ffc_subscribe_email'] ) && ! isset( $old_value['ffc_subscribe_email'] ) &&
			     ! isset( $value['ffc_statistic'] ) && ! isset( $old_value['ffc_statistic'] ) ) {
				
				return $value;
			}
			
			$value['ffc_statistic'] = (isset($value['ffc_statistic']))? $value['ffc_statistic'] : 0;
			$value['ffc_subscribe'] = (isset($value['ffc_subscribe']))? $value['ffc_subscribe'] : 0;
			$value['ffc_subscribe_name'] = (isset($value['ffc_subscribe_name']))? $value['ffc_subscribe_name'] : 0;
			$value['ffc_subscribe_email'] = (isset($value['ffc_subscribe_email']))? $value['ffc_subscribe_email'] : 0;

			$old_value['ffc_statistic'] = (isset($old_value['ffc_statistic']))? $old_value['ffc_statistic'] : 0;
			$old_value['ffc_subscribe'] = (isset($old_value['ffc_subscribe']))? $old_value['ffc_subscribe'] : 0;
			$old_value['ffc_subscribe_name'] = (isset($old_value['ffc_subscribe_name']))? $old_value['ffc_subscribe_name'] : 0;
			$old_value['ffc_subscribe_email'] = (isset($old_value['ffc_subscribe_email']))? $old_value['ffc_subscribe_email'] : 0;

			
			if ( $value['ffc_subscribe'] !== $old_value['ffc_subscribe'] ||
			     $value['ffc_subscribe_name'] !== $old_value['ffc_subscribe_name'] ||
			     $value['ffc_subscribe_email'] !== $old_value['ffc_subscribe_email'] ||
			     $value['ffc_statistic'] !== $old_value['ffc_statistic']
			) {
				$ffc_statistics_option = get_option( 'ffc_statistics_option' );

				$ffc_statistics_option['ffc_statistic']       = ( $value['ffc_statistic'] === '1' ) ? 1 : 0;
				$ffc_statistics_option['ffc_subscribe']       = ( $value['ffc_subscribe'] === '1' ) ? 1 : 0;
				$ffc_statistics_option['ffc_subscribe_email'] = sanitize_email( $value['ffc_subscribe_email'] );
				$ffc_statistics_option['ffc_subscribe_name']  = sanitize_text_field( $value['ffc_subscribe_name'] );
				
				update_option( 'ffc_statistics_option', $ffc_statistics_option );
				
			}
			
			return $value;
		}
}
