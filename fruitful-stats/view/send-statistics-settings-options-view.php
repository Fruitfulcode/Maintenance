<tr class="ff-settings-options-form postbox" id="subscribe-notification-container">

	<td colspan="2" class="frtfl-modal__content">
		<h2><?php _e( 'Fruitful Code statistic', 'maintenance' ); ?></h2>
		<p class="description">
			<?php _e( 'We would be happy if you assist us in becoming better. Share your site statistic to help us
                        improve our products and services. Also, don’t forget to subscribe to the Fruitful code
                        newsletters for the latest updates!', 'maintenance' ); ?>
		</p>
		<div class="form-group">
			<label>
				<input type="checkbox"
				       name="ffc_statistic"
				       id="modal-ffc-statistic"
				       value="<?php _e($ffc_statistic); ?>"
				       <?php if($ffc_statistic=='1') { _e( 'checked'); }?> >
				<?php _e( 'Send configuration information to Fruitful Code to help to improve this plugin', 'maintenance' ) ?>
			</label>
		</div>

		<div class="form-group" id="modal-ffc-subscribe__wrapper">
			<label>
				<input type="checkbox"
				       name="ffc_subscribe"
				       id="modal-ffc-subscribe"
				       value="<?php _e($ffc_subscribe); ?>"
					<?php if($ffc_subscribe=='1') { _e( 'checked'); }?> >
				<?php _e( 'Subscribe to the Fruitful Code newsletters', 'maintenance' ) ?>
			</label>

			<div class="frtfl-modal__content_user-info <?php if($ffc_subscribe=='0') { _e( 'hidden'); }?>" id="frtfl-modal__content_user-info">
				<div class="floating-placeholder__wrapper subscribe__input_name">
					<input type="text" placeholder="Name" name="ffc_subscribe_name" required <?php if($ffc_statistic!='1') { _e( 'disabled'); }?>  value="<?php _e( $ffc_name ); ?>">
					<label><?php _e( 'Name', 'maintenance' ); ?>*</label>
				</div>
				<div class="floating-placeholder__wrapper subscribe__input_email">
					<input type="email" placeholder="E-mail" name="ffc_subscribe_email"  required <?php if($ffc_statistic!='1') { _e( 'disabled'); }?> value="<?php _e( $ffc_email ); ?>">
					<label><?php _e( 'E-mail', 'maintenance' ); ?>*</label>
				</div>
			</div>
		</div>

	</td>

</tr>



