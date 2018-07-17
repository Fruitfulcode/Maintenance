<p class="description">
	<?php _e( 'We would be happy if you assist us in becoming better. Share your site anonymous technical data to help us
					improve our products and services. Also, don’t forget to subscribe to the Fruitful Code
					newsletters for the latest updates!', 'maintenance' ); ?>
</p>
		
<table class="form-table">
	<tbody>
		<tr valign="top">
			<th scope="row"><?php _e( 'Send configuration information', 'maintenance' ) ?></th>
			<td>
				<filedset>
						<input type="checkbox"
							   name="lib_options[ffc_statistic]"
							   value="1"
							   <?php if($ffc_statistic === 1) { _e( 'checked'); }?> >
				</filedset>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e( 'Subscribe to the Fruitful Code newsletters', 'maintenance' ) ?></th>
			<td>
				<filedset>
						<input type="checkbox"
							   name="lib_options[ffc_subscribe]"
							   value="1"
							<?php if($ffc_subscribe === 1) { _e( 'checked'); }?> >
				</filedset>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e( 'Name', 'maintenance' ); ?>*</th>
			<td>
				<filedset>
					<input type="text" placeholder="Name" name="lib_options[ffc_subscribe_name]" value="<?php _e( $ffc_name ); ?>">
				</filedset>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e( 'E-mail', 'maintenance' ); ?>*</th>
			<td>
				<filedset>
					<input type="email" placeholder="E-mail" name="lib_options[ffc_subscribe_email]" value="<?php _e( $ffc_email ); ?>">
				</filedset>
			</td>
		</tr>
	</tbody>
</table>
