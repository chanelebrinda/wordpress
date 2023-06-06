
    <?php

/******************************validation***********************8***** */

    if ( isset($_POST['register'] ) ) {
       
        // sanitize user form input
    
        $username   =   sanitize_user( $_POST['username'] );
        $email      =   sanitize_email( $_POST['email'] );
        $first_name =   sanitize_text_field( $_POST['fname'] );
        $last_name  =   sanitize_text_field( $_POST['lname'] );
        $telephone  = sanitize_text_field( $_POST['telephone'] );
        $bio        =   esc_textarea( $_POST['bio'] );

        global $reg_errors;
        $reg_errors = new WP_Error;

        if ( empty( $username ) || empty( $email ) ) {
            $reg_errors->add('field', 'Required form field is missing');
        }

        if ( !is_email( $email ) ) {
            $reg_errors->add( 'email_invalid', 'Email is not valid' );
        }

        if ( is_wp_error( $reg_errors ) ) {
        
            foreach ( $reg_errors->get_error_messages() as $error ) {
            
                echo '<div>';
                echo '<strong>ERROR</strong>:';
                echo $error . '<br/>';
                echo '</div>';
            }
        
        }

        if ( 1 > count( $reg_errors->get_error_messages() ) ) {
          $userdata = array(
          'user_login'    =>   $username,
          'user_email'    =>   $email,
          'first_name'    =>   $first_name,
          'last_name'     =>   $last_name,
          'user_phone'     =>   $telephone,
          'user_pass'     =>   '',
          'description'   =>   $bio,
          'role' => 'Employe',
          );
          $user = wp_insert_user( $userdata );
          add_user_meta( $user, 'user_phone', $_POST['telephone'] );
          
        }
    }
?>


<form action="<?php  get_the_permalink()  ?>" method="post" class="row ">

<div class="row">    
      <div class="form-group row col">
        <label for="firstname" class="form-label"><?php _e( 'First Name' ); ?></label>
        <input type="text" class="col-10"  name="fname" >
      </div>
      
      <div class="form-group row col">
        <label for="website" class="form-label"><?php _e( 'Last Name' ); ?></label>
        <input type="text" class="col-10"  name="lname" >
      </div>
</div>
<div class="row">  
      <div class="form-group row col">
        <label for="username" class="form-label"><?php _e( 'Username' ); ?></label>
         <input type="text" class="col-10"  name="username">
      </div>

      <div class="form-group row col" >
        <label for="email" class="form-label"> <?php _e( 'Email' ); ?></label>
        <input type="text" class="col-10" name="email" >
      </div>
</div>
<div class="row">  
      <div class="form-group row col">
        <label for="telephone" class="form-label"><?php _e( 'Telephone' ); ?></label>
        <input type="text" class="col-10"  name="telephone">
      </div>
  
      <div class="form-group row col">
        <label for="bio" class="form-label" ><?php _e( 'About / Bio' ); ?></label>
        <textarea name="bio" class="col-10" ></textarea>
      </div>
</div>
  <div class="row col-6">
      <div class="col-3">
      <input type="button" name="register" value="<?php _e( 'Envoyer' ); ?>"/> 
      </div>
      <div class="col-3">
      <input type="submit" name="reset" value="<?php _e( 'annuler' ); ?>" /> 
      </div>
  </div>

  

</form>