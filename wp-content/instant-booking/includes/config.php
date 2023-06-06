<?php

if( isset( get_option('Payments_Settings')['Parametre_devise'] ) || isset( get_option('Payments_Settings')['Parametre_private_key'] ) 
|| isset( get_option('Tentee_settings_name')['Parametre_title'] ) || isset(get_option('Tentee_settings_name')['Parametre_mail'] ) 
|| isset( get_option('reservation_settings')['Parametre_mode_reservation'] ) || isset(get_option('Tentee_settings_name')['Parametre_public_key'] ) ) {

    $ibmail = esc_html( get_option('Tentee_settings_name')['Parametre_mail']  );
    $sitename = esc_html( get_option('Tentee_settings_name')['Parametre_title']  );
    $mode = esc_html(get_option('reservation_settings')['Parametre_mode_reservation']);
    $devise = esc_html( get_option('Payments_Settings')['Parametre_devise']  );
    $cle_public =  get_option('Payments_Settings')['Parametre_public_key'];
    $cle_privee =  get_option('Payments_Settings')['Parametre_private_key'];
  }
  global $ibmail;
  global $mode;
  global $sitename;
  global $devise;
  global $cle_public;
  global $cle_privee;


// Stripe API configuration  
if( $cle_public != null && $cle_privee != null){
  define('STRIPE_API_KEY', $cle_privee); 
define('STRIPE_PUBLISHABLE_KEY', $cle_public); 
}

