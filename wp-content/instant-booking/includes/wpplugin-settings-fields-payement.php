<?php


function tentee_Payments() {

    if( false == get_option( 'Tentee_Payments_Settings' ) ) {
      add_option( 'Tentee_Payments_Settings' );
    }
  
   add_settings_section( 'Parametre_payement', __( 'Configuration', 'instant_booking' ), 'settings_callback', 'Tentee_Payments');
  // input Field
    add_settings_field( 'Parametre_devise',__( 'Devise:', 'instant_booking'), 'devise_callback','Tentee_Payments','Parametre_payement',
    [
        'option_1' => 'fr',
        'option_2' => '$',
        'option_3' => '฿',
        'option_4' => 'CFA',
        'option_5' => 'FCFA',
        'option_6' => '¥',
        'option_7' => '€',
        'option_8' => '£',
        'option_9' => 'DM',
        'option_10' => '₹',
        'option_11' => 'Rp',
        'option_12' => 'L,£',
        'option_13' => 'lei',
        'option_14' => '₽',
        'option_15' => 'FRw',
      ]);

    add_settings_field('Parametre_position_symbole',__( 'Position du symbole de prix :', 'instant_booking'),'position_symbole_callback','Tentee_Payments','Parametre_payement',
    [
      'option_1' => 'Avant',
      'option_2' => 'Après',
    ]);
    add_settings_field('Parametre_separateur_prix',__( 'Séparateur de prix', 'instant_booking'), 'separateur_prix_callback','Tentee_Payments','Parametre_payement',[
        'option_1' => 'virgule-point',
        'option_2' => 'point-virgule',
        'option_3' => 'espace-dot',
        'option_4' => 'space-virgule'
      ]);
    add_settings_field('Parametre_​nombre_decimales',__( 'Prix ​​Nombre de décimales :', 'instant_booking'), 'Parametre_​nombre_decimales_callback','Tentee_Payments','Parametre_payement');
  
    register_setting(
      'Tentee_Payments_Settings',
      'Payments_Settings'
    );
  
  }
  add_action( 'admin_init', 'tentee_Payments');  

  function devise_callback($args) {
    $options = get_option('Payments_Settings');
    $devise = '';
    if( isset( $options['Parametre_devise'] ) ) {
      $devise = esc_html( $options['Parametre_devise'] );
    }

   $html = '<select id="Parametre_devise" name="Payments_Settings[Parametre_devise]"> <option>Select currency</option>';
    $html .= '<option value="fr"' . selected( $devise,$args['option_1'], false) . '>Franc -' . $args['option_1'] . '</option>';
    $html .= '<option value="$"' . selected( $devise,$args['option_2'], false) . '>Dollar -' . $args['option_2'] . '</option>';
    $html .= '<option value="฿"' . selected( $devise,$args['option_3'], false) . '>Bitcoin -' . $args['option_3'] . '</option>';
    $html .= '<option value="CFA"' . selected( $devise,$args['option_4'], false) . '>Franc BCEAO -' . $args['option_4'] . '</option>';
    $html .= '<option value="FCFA"' . selected( $devise,$args['option_5'], false) . '>Franc BEAC -' . $args['option_5'] . '</option>';
    $html .= '<option value="¥"' . selected( $devise,$args['option_6'], false) . '>Yuan/Yen -' . $args['option_6'] . '</option>';
    $html .= '<option value="€"' . selected( $devise,$args['option_7'], false) . '>Euro -' . $args['option_7'] . '</option>';
    $html .= '<option value="£"' . selected( $devise,$args['option_8'], false) . '>Falkland Islands Pound -' . $args['option_8'] . '</option>';
    $html .= '<option value="DM"' . selected( $devise,$args['option_9'], false) . '>German Mark -' . $args['option_9'] . '</option>';
    $html .= '<option value="₹"' . selected( $devise,$args['option_10'], false) . '>Indian Rupee -' . $args['option_10'] . '</option>';
    $html .= '<option value="Rp"' . selected( $devise,$args['option_11'], false) . '>Italian Lira -' . $args['option_11'] . '</option>';
    $html .= '<option value="L,£"' . selected( $devise,$args['option_12'], false) . '>Indonesian Rupiah -' . $args['option_12'] . '</option>';
    $html .= '<option value="lei"' . selected( $devise,$args['option_13'], false) . '>Romanian Leu -' . $args['option_13'] . '</option>';
    $html .= '<option value="₽"' . selected( $devise,$args['option_14'], false) . '>Russian Ruble -' . $args['option_14'] . '</option>';
    $html .= '<option value="FRw"' . selected( $devise,$args['option_15'], false) . '>Rwandan Franc -' . $args['option_15'] . '</option>';
    $html .= '</select>';
    echo $html;
  } 

  function position_symbole_callback($args) {
    $options = get_option( 'Payments_Settings' );
    $position_symbole = '';
    if( isset( $options[ 'Parametre_position_symbole' ] ) ) {
      $position_symbole = esc_html( $options['Parametre_position_symbole'] );
    }

   $html = '<select id="Parametre_position_symbole" name="Payments_Settings[Parametre_position_symbole]"> <option>Selectionez la position du symbole de prix </option>';
    $html .= '<option value="'.$args['option_1'].'"' . selected( $position_symbole,$args['option_1'], false) . '>' . $args['option_1'] . '</option>';
    $html .= '<option value="'.$args['option_2'].'"' . selected( $position_symbole,$args['option_2'], false) . '>' . $args['option_2'] . '</option>';
    $html .= '</select>';
    echo $html;
  }
  function separateur_prix_callback($args) {
    $options = get_option( 'Payments_Settings' );
    $position_symbole = '';
    if( isset( $options[ 'Parametre_separateur_prix' ] ) ) {
      $position_symbole = esc_html( $options['Parametre_separateur_prix'] );
    }

   $html = '<select id="Parametre_separateur_prix" name="Payments_Settings[Parametre_separateur_prix]"> <option>Selectionez le separateur de prix </option>';
    $html .= '<option value="'.$args['option_1'].'"' . selected( $position_symbole, $args['option_1'], false) . '>' . $args['option_1'] . '</option>';
    $html .= '<option value="'.$args['option_2'].'"' . selected( $position_symbole, $args['option_2'], false) . '>' . $args['option_2'] . '</option>';
    $html .= '<option value="'.$args['option_3'].'"' . selected( $position_symbole, $args['option_3'], false) . '>' . $args['option_3'] . '</option>';
    $html .= '<option value="'.$args['option_4'].'"' . selected( $position_symbole, $args['option_4'], false) . '>' . $args['option_4'] . '</option>';
    $html .= '</select>';
    echo $html;
  }
  
  function Parametre_​nombre_decimales_callback() {

    $options = get_option( 'Payments_Settings' );
    $titre = '';
    if( isset( $options[ 'Parametre_​nombre_decimales' ] ) ) {
      $titre = esc_html( $options['Parametre_​nombre_decimales'] );
    }
    
    $html = '<input type="number" id="Parametre_​nombre_decimales" name="Payments_Settings[Parametre_​nombre_decimales]" value="' . $titre . '"  min="0" max="5"/>';
    echo $html;
  }

  
  function tentee_Payments_stripe() {

    if( false == get_option( 'Tentee_Payments_Stripe' ) ) {
      add_option( 'Tentee_Payments_Stripe' );
    }
  
   add_settings_section( 'Parametre_stripe', __( 'Stripe', 'instant_booking' ), 'settings_callback', 'Tentee_Payments');
  // input Field
    add_settings_field( 'Parametre_payement',__( 'Stripe Service:', 'instant_booking'), 'stripe_payments','Tentee_Payments','Parametre_stripe');
    
    add_settings_field( 'Parametre_public_key',__( 'Clé public:', 'instant_booking'), 'public_key_callback','Tentee_Payments','Parametre_stripe');
    add_settings_field( 'Parametre_private_key',__( 'Clé privée:', 'instant_booking'), 'private_key_callback','Tentee_Payments','Parametre_stripe');

    register_setting(
      'Tentee_Payments_Stripe',
      'Payments_Settings'
    );
  
  }
  add_action( 'admin_init', 'tentee_Payments_stripe');  

  function stripe_payments() {
    $options = get_option( 'Payments_Settings' );
    $check = 0;
    if( isset( $options["Parametre_payement" ] ) ) {
      $check = $options['Parametre_payement']  ;
    } 
    
    $html = '<input type="checkbox" id="Parametre_payement" name="Payments_Settings[Parametre_payement]"  value="1"' . checked($check, 1, false) . '"/> 
            Utiliser la solution d\'integration stripe.<span></span>';
    echo $html; 
    
}
  function public_key_callback() {

    $options = get_option( 'Payments_Settings' );
    $public_key = '';
    if( isset( $options[ 'Parametre_public_key' ] ) ) {
      $public_key = esc_html( $options['Parametre_public_key'] );
    }
    $html = '<input type="text" class="form-control col-lg-4 col-md-6" id="Parametre_public_key" name="Payments_Settings[Parametre_public_key]" value="' . $public_key . '"/>';
    echo $html;
  }
  function private_key_callback() {

    $options = get_option( 'Payments_Settings' );
    $privata_key = '';
    if( isset( $options[ 'Parametre_private_key' ] ) ) {
      $privata_key = esc_html( $options['Parametre_private_key'] );
    }
   
    $html = '<input type="text" class="form-control col-lg-4 col-md-6" id="Parametre_private_key" name="Payments_Settings[Parametre_private_key]" value="' . $privata_key . '"/>';
    echo $html;
  }


  function tentee_setting_reservation() {

    if( false == get_option( 'Tentee_Settings_Reservation' ) ) {
      add_option( 'Tentee_Settings_Reservation' );
    }
  
   add_settings_section( 'Parametre_reduction', __( 'Reduction', 'instant_booking' ), 'settings_callback', 'Reserve_Settings');
  // input Field
    add_settings_field( 'Parametre_taux_fidelite',__( 'Taux de fidelité', 'instant_booking'), 'fidelite_callback','Reserve_Settings','Parametre_reduction');
    add_settings_field( 'Parametre_mode_reservation',__( 'Mode de reservation', 'instant_booking'), 'mode_reservation_callback','Reserve_Settings','Parametre_reduction',
      [     
      'option_1' => '/Jour',
      'option_2' => '/Nuit',
      'option_3' => '/Mois',
      'option_4' => '/Tranche Horaire'
      ]);

    register_setting(
      'Tentee_Settings_Reservation',
      'reservation_settings'
    );
  
  }
  add_action( 'admin_init', 'tentee_setting_reservation');  

  function fidelite_callback() {

    $options = get_option( 'reservation_settings' );
    $titre = '';
    if( isset( $options[ 'Parametre_taux_fidelite' ] ) ) {
      $titre = esc_html( $options['Parametre_taux_fidelite'] );
    }
    
    $html = '<input type="number" id="Parametre_taux_fidelite" name="reservation_settings[Parametre_taux_fidelite]" placeholder="23" value="' . $titre . '"/>';
    echo $html;
  }

  function mode_reservation_callback($args) {
    $options = get_option('reservation_settings');
    $mode_reservation = '';
    if( isset( $options['Parametre_mode_reservation']) ) {
      $mode_reservation = esc_html($options['Parametre_mode_reservation']);
    }

      $html = '<select id="Parametre_mode_reservation" name="reservation_settings[Parametre_mode_reservation]"> <option>Selectionez le mode de reservation </option>';
      $html .= '<option value="' . $args['option_1'] . '"' . selected( $mode_reservation, $args['option_1'], false) . '>' . $args['option_1'] . '</option>';
      $html .= '<option value="' . $args['option_2'] . '"' . selected( $mode_reservation, $args['option_2'], false) . '>' . $args['option_2'] . '</option>';
      $html .= '<option value="' . $args['option_3'] . '"' . selected( $mode_reservation, $args['option_3'], false) . '>' . $args['option_3'] . '</option>';
      $html .= '<option value="' . $args['option_4'] . '"' . selected( $mode_reservation, $args['option_4'], false) . '>' . $args['option_4'] . '</option>';
      $html .= '</select>';

      echo $html;
  }

  
  function IB_setting_design() {

    if( false == get_option( 'Tentee_Settings_design' ) ) {
      add_option( 'Tentee_Settings_design' );
    }
  
   add_settings_section( 'Parametre_structure', __( 'Structure', 'instant_booking' ), 'settings_callback', 'IB_design');
  // input Field
    add_settings_field( 'Parametre_mode_affichage',__( 'Mode d\'affichage', 'instant_booking'), 'block_callback','IB_design','Parametre_structure',
    [     
      'option_2' => 'Simple',
      'option_1' => 'Par Categorie',
      ]);
    
    add_settings_field( 'Parametre_modele',__( 'Template', 'instant_booking'), 'modele_callback','IB_design','Parametre_structure',
    [     
      'option_2' => 'card simple',
      'option_1' => 'carousel card',
      ]);

    register_setting(
      'Tentee_Settings_design',
      'design_settings'
    );
  
  }
  add_action( 'admin_init', 'IB_setting_design');  

  function block_callback($args) {

    $options = get_option('design_settings');
    $mode_affichage = '';
    if( isset( $options['Parametre_mode_affichage']) ) {
      $mode_affichage = esc_html($options['Parametre_mode_affichage']);
    }

      $html = '<select id="Parametre_mode_affichage" name="design_settings[Parametre_mode_affichage]"> <option>Selectionez le mode d\'affichage </option>';
      $html .= '<option value="' . $args['option_1'] . '"' . selected( $mode_affichage, $args['option_1'], false) . '>' . $args['option_1'] . '</option>';
      $html .= '<option value="' . $args['option_2'] . '"' . selected( $mode_affichage, $args['option_2'], false) . '>' . $args['option_2'] . '</option>';
      $html .= '</select>';

      echo $html;
  }
  function modele_callback($args) {

    $options = get_option('design_settings');
    $modele = '';
    if( isset( $options['Parametre_modele']) ) {
      $modele = esc_html($options['Parametre_modele']);
    }

      $html = '<select id="Parametre_modele" name="design_settings[Parametre_modele]"> <option>Selectionez le modele d\'affichage </option>';
      $html .= '<option value="' . $args['option_1'] . '"' . selected( $modele, $args['option_1'], false) . '>' . $args['option_1'] . '</option>';
      $html .= '<option value="' . $args['option_2'] . '"' . selected( $modele, $args['option_2'], false) . '>' . $args['option_2'] . '</option>';
      $html .= '</select>';

      echo $html;
  }