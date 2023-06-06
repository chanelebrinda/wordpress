<?php

function wpplugin_settings() {

  // If plugin settings don't exist, then create them
  if( false == get_option( 'Tentee_reservation_settings' ) ) {
    add_option( 'Tentee_reservation_settings' );
}
 add_settings_section( 'Parametre_general', __( 'General', 'instant_booking' ), 'settings_callback', 'Tentee_general');
// input Field
    add_settings_field( 'Parametre_title',__( 'Nom de l\'entreprise', 'instant_booking'), 'title_callback','Tentee_general','Parametre_general');
    add_settings_field('Parametre_description',__( 'Description', 'instant_booking'),'description_callback','Tentee_general','Parametre_general',);
    add_settings_field('Parametre_mail',__( 'Email', 'instant_booking'), 'mail_callback','Tentee_general','Parametre_general');
    add_settings_field('Parametre_secteur',__( 'Secteur D\'activité', 'Tentee_general'), 'secteurcallback','Tentee_general','Parametre_general',
    [
      'option_1' => 'Automobile',
      'option_2' => 'Chambres d\'hotel',
      'option_3' => 'Outils ou equipements',
      'option_4' => 'Maison ou propriété'
    ]);
    add_settings_field( 'Parametre_adress',__( 'Adresse', 'instant_booking'), 'adresscallback','Tentee_general','Parametre_general');
    add_settings_field('Parametre_numero',__( 'Telephone', 'instant_booking'), 'numerocallback','Tentee_general','Parametre_general');
  

  register_setting(
    'Tentee_reservation_settings',
    'Tentee_settings_name'
  );

}
add_action( 'admin_init', 'wpplugin_settings' );

    function settings_callback() {
    echo '<div class="col-lg-6 col-md-6 col-sm-6"><hr></div>';
    }

    function title_callback() {

      $options = get_option( 'Tentee_settings_name' );
      $titre = '';
      if( isset( $options[ 'Parametre_title' ] ) ) {
        $titre = esc_html( $options['Parametre_title'] );
      } else{ 
        $titre =  get_site_option( 'site_name' ) ;
      }
      echo '<input type="text" id="Parametre_title" name="Tentee_settings_name[Parametre_title]" value="' . $titre . '" />';
    }

    function description_callback() {

      $options = get_option( 'Tentee_settings_name' );
      $titre = '';
      if( isset( $options[ 'Parametre_description' ] ) ) {
        $titre = esc_html( $options['Parametre_description'] );
      } else{ 
        $titre =  get_site_option( '' ) ;
      }
      echo '<textarea id="Parametre_description" name="Tentee_settings_name[Parametre_description]">'. $titre .'</textarea>';
    }

    function mail_callback() {

      $options = get_option( 'Tentee_settings_name' );
      $titre = '';
      if( isset( $options[ 'Parametre_mail' ] ) ) {
        $titre = esc_html( $options['Parametre_mail'] );
      } else{ 
        $titre =  get_site_option( 'admin_email' ) ;
      }
      echo '<input type="text" id="Parametre_mail" name="Tentee_settings_name[Parametre_mail]" value="' . $titre . '" />';
    }

    function adresscallback() {

      $options = get_option( 'Tentee_settings_name' );
      $titre = '';
      if( isset( $options[ 'Parametre_adress' ] ) ) {
        $titre = esc_html( $options['Parametre_adress'] );
      }
      echo '<input type="text" id="Parametre_adress" name="Tentee_settings_name[Parametre_adress]" value="' . $titre . '" />';
    }

  function numerocallback() {

    $options = get_option( 'Tentee_settings_name' );
    $titre = '';
    if( isset( $options[ 'Parametre_numero' ] ) ) {
      $titre = esc_html( $options['Parametre_numero'] );
    }
    echo '<input type="tel" id="Parametre_numero" name="Tentee_settings_name[Parametre_numero]" value="' . $titre . '" />';
  }

  function secteurcallback($args) {

    $options = get_option( 'Tentee_settings_name' );
    $secteur = '';
    if( isset( $options[ 'Parametre_secteur' ] ) ) {
      $secteur = esc_html( $options['Parametre_secteur'] );
    }
    $html = '<select id="Parametre_secteur" name="Payments_Settings[Parametre_secteur]"> <option>Selectioner votre secteur </option>';
    $html .= '<option value="'.$args['option_1'].'"' . selected( $secteur, $args['option_1'], false) . '>' . $args['option_1'] . '</option>';
    $html .= '<option value="'.$args['option_2'].'"' . selected( $secteur, $args['option_2'], false) . '>' . $args['option_2'] . '</option>';
    $html .= '<option value="'.$args['option_3'].'"' . selected( $secteur, $args['option_3'], false) . '>' . $args['option_3'] . '</option>';
    $html .= '<option value="'.$args['option_4'].'"' . selected( $secteur, $args['option_4'], false) . '>' . $args['option_4'] . '</option>';
    $html .= '</select>';
    echo $html;
   }

/* ********************************************************************/

include( plugin_dir_path( __FILE__ ) . 'wpplugin-settings-fields-payement.php');

