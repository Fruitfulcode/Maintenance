<?php
	add_action( 'init', 'maintenance_version_check' );
	
	function maintenance_version_check() {
	  $old_version = get_option( 'maintenance_db_version' );
	  $options     = get_option( 'maintenance_options' );
		
	if ( empty( $old_version ) && false === $options )
		maintenance_install();
	elseif ( empty( $old_version ) && !empty( $options ) )
		maintenance_update();
	elseif ( intval( $old_version ) < intval( MAINTENANCE_DB_VERSION ) )
		maintenance_update();
	}
	
   function maintenance_install() {
		$options = mt_get_plugin_options();
		add_option( 'maintenance_db_version',  MAINTENANCE_DB_VERSION );
		add_option( 'maintenance_options', 	   $options);
   }
	
   function maintenance_update() {
		$options = mt_get_plugin_options();
		update_option( 'maintenance_db_version', MAINTENANCE_DB_VERSION);
		update_option( 'maintenance_options',  $options);
	}
?>	