<?php

if( isset( get_option('Tentee_settings_name')['Parametre_mail'] ) || isset( get_option('Tentee_settings_name')['Parametre_title'] ) ) {
    $ibmail = esc_html( get_option('Tentee_settings_name')['Parametre_mail']  );
    $Ibtitle = esc_html(get_option('Tentee_settings_name')['Parametre_title']);
  }

    


  add_action( 'phpmailer_init', 'Ib_custum_mailer' );
  function Ib_custum_mailer( $phpmailer ) {
  
    //*****************settings*********************//
    $SMTPhost = 'smtp.mailtrap.io';
    $PAuth = true;
    $SMTPport = 2525;
    $user = '029c93737b2b93';
    $pass = '920812721829f4';

    $phpmailer->isSMTP();
    $phpmailer->Host = $SMTPhost;
    $phpmailer->SMTPAuth = $PAuth;
    $phpmailer->Port = $SMTPport;
    $phpmailer->Username = $user;
    $phpmailer->Password = $pass;
    // $phpmailer->From     = 'azanfackchanele@gmail.com';
    // $phpmailer->setFrom('azanfackchanele@gmail.com');
    // $phpmailer->FromName   = $site_name;
   // $phpmailer->addReplyTo($email, $site_name);
    // $phpmailer->SMTPOptions = array(
    //     'ssl' => array(
    //         'verify_peer' => false,
    //         'verify_peer_name' => false,
    //         'allow_self_signed' => true
    //     ));
    } 
    
    add_action( 'wp_mail_failed', 'onMailError', 10, 1 );
    function onMailError( $wp_error ) {
        echo "<pre>";
        print_r($wp_error);
        echo "</pre>";
    }     
    function Ib_html_mail_content_type() {
      return 'text/html';
    }
    add_filter( 'wp_mail_content_type', 'Ib_html_mail_content_type' );