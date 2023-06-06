<?php
function register_employer( $username, $email, $first_name, $last_name ,$telephone, $bio ) {

?>
   <form action="<?php  $_SERVER['REQUEST_URI']  ?>" method="post" class="row ">

     <div class="row">    
           <div class="form-group row col">
             <label for="firstname" class="form-label"><?php _e( 'First Name' ); ?></label>
             <input type="text" class="col-10"  name="fname" value="<?php echo esc_html( ( isset( $_POST['fname']) ? $first_name : null ) )?>">
           </div>
           
           <div class="form-group row col">
             <label for="website" class="form-label"><?php _e( 'Last Name' ); ?></label>
             <input type="text" class="col-10"  name="lname" value="<?php echo esc_html( ( isset( $_POST['lname']) ? $last_name : null ) )?>">
           </div>
    </div>
    <div class="row">  
           <div class="form-group row col">
             <label for="username" class="form-label"><?php _e( 'Username' ); ?></label>
              <input type="text" class="col-10"  name="username" value="<?php echo esc_html( ( isset( $_POST['username']) ? $username: null ) )?>">
           </div>

           <div class="form-group row col" >
             <label for="email" class="form-label"> <?php _e( 'Email' ); ?></label>
             <input type="text" class="col-10" name="email" value="<?php echo esc_html( ( isset( $_POST['email']) ? $email : null ) )?>">
           </div>
    </div>
     <div class="row">  
           <div class="form-group row col">
             <label for="telephone" class="form-label"><?php _e( 'Telephone' ); ?></label>
             <input type="text" class="col-10"  name="telephone" value="<?php ( isset( $_POST['telephone'] ) ? $telephone : null )  ?>">
           </div>
       
           <div class="form-group row col">
             <label for="bio" class="form-label" ><?php _e( 'About / Bio' ); ?></label>
             <textarea name="bio" class="col-10" ><?php echo esc_textarea(( isset( $_POST['bio']) ? $bio : null ) )?></textarea>
           </div>
     </div>
       <div class="row col-6">
           <div class="col-3">
           <input type="button" name="submit" value="<?php _e( 'Envoyer' ); ?>"/> 
           </div>
           <div class="col-3">
           <input type="submit" name="" value="<?php _e( 'annuler' ); ?>" /> 
           </div>
       </div>

       

   </form>
   <?php
}

/******************************function de validation***********************8***** */

function registration_validation( $username, $email, $first_name, $last_name, $telephone, $bio )  {
global $reg_errors;
$reg_errors = new WP_Error;

if ( empty( $username ) || empty( $email ) ) {
   $reg_errors->add('field', 'Required form field is missing');
}

if ( !is_email( $email ) ) {
   $reg_errors->add( 'email_invalid', 'Email is not valid' );
}

if ( email_exists( $email ) ) {
   $reg_errors->add( 'email', 'Email Already in use' );
}

if ( is_wp_error( $reg_errors ) ) {

   foreach ( $reg_errors->get_error_messages() as $error ) {
    
       echo '<div>';
       echo '<strong>ERROR</strong>:';
       echo $error . '<br/>';
       echo '</div>';
   }

}

}

function complete_registration(){
   global $reg_errors, $username, $email, $first_name, $last_name , $telephone, $bio ;
   if ( 1 > count( $reg_errors->get_error_messages() ) ) {
       $userdata = array(
       'user_login'    =>   $username,
       'user_email'    =>   $email,
       'first_name'    =>   $first_name,
       'last_name'     =>   $last_name,
       'user_phone'     =>   $telephone,
       'description'   =>   $bio,
       'role' => 'Employe',
       );
       $user = wp_update_user( $userdata );



     //  add_user_meta( $user['id'], 'user_phone', $_POST['user_phone'] );
     update_user_meta( $user, 'user_phone', $_POST['telephone'] );

   }
}


function custom_registration_function() {

   global $username, $email, $first_name, $last_name, $telephone ,$bio ;
   if ( isset($_POST['submit'] ) ) {
       registration_validation(
       $_POST['username'],
       $_POST['email'],
       $_POST['fname'],
       $_POST['lname'],  
       $_POST['telephone'],
       $_POST['bio'],
       );
        
       // sanitize user form input
   
       $username   =   sanitize_user( $_POST['username'] );
       $email      =   sanitize_email( $_POST['email'] );
       $first_name =   sanitize_text_field( $_POST['fname'] );
       $last_name  =   sanitize_text_field( $_POST['lname'] );
       $telephone  = sanitize_text_field( $_POST['telephone'] );
       $bio        =   esc_textarea( $_POST['bio'] );

       // call @function complete_registration to create the user
       // only when no WP_error is found
       complete_registration(
       $username,
       $email,
       $first_name,
       $last_name,
       $telephone,
       $bio
       );
   }

  register_employer( $username, $email,$first_name, $last_name, $telephone, $bio );
   
}