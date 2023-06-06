<?php
// creating Ajax call for WordPress



if( isset(get_option('Payments_Settings')['Parametre_​nombre_decimales'] ) || isset(get_option('Payments_Settings')['Parametre_separateur_prix'] ) ||  isset( get_option('Payments_Settings')['Parametre_devise'] ) || isset( get_option('Payments_Settings')['Parametre_private_key'] ) || isset( get_option('Tentee_settings_name')['Parametre_title'] ) || isset(get_option('Tentee_settings_name')['Parametre_mail'] ) || isset( get_option('reservation_settings')['Parametre_mode_reservation'] ) ) {
  $ibmail = esc_html( get_option('Tentee_settings_name')['Parametre_mail']  );
  $sitename = esc_html( get_option('Tentee_settings_name')['Parametre_title']  );
  $mode = esc_html(get_option('reservation_settings')['Parametre_mode_reservation']);
  $devise = esc_html( get_option('Payments_Settings')['Parametre_devise']  ); 
  $decimales = intval(esc_html(get_option('Payments_Settings')['Parametre_​nombre_decimales']));
  
}
global $ibmail;
global $mode;
global $sitename;
global $devise;
global $decimales;


/***********************************FUNCTION De payement stripe****************************/

function ajaxstripepayement_fn(){

    if(!empty($_POST['token'])){
        //get token, card and user info from the form
        $token  = $_POST['token'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $card_num = $_POST['number'];
        $card_cvc = $_POST['cvc'];
        $card_exp_month = $_POST['exp_month'];
        $card_exp_year = $_POST['exp_year'];
        $card_price_total = intval($_POST['price_total']);
        $card_service_id = $_POST['service_id'];
        $card_book_id = $_POST['book_id']; 
       
         // Set API key 
       \Stripe\Stripe::setApiKey(STRIPE_API_KEY); 
         
        //add customer to stripe
        $customer = \Stripe\Customer::create(array(
            'email' => $email, 
            'name' => $name,
            'description' => 'booking services',
            'source'  => $token
        ));
        
        //item information
        $itemName= get_post($card_service_id)->post_title ;
        $itemPrice = $card_price_total;
        if($devise = '$'){
          $currency = 'eur';
        }else if($devise = '€'){
          $currency = 'usb';
        }else{
          $currency = 'xaf';
        }
     
        //charge a credit or a debit card
        $charge = \Stripe\Charge::create(array(
            'customer' => $customer->id,
            'amount'   => $itemPrice,
            'currency' => $currency,
            'description' => $itemName,
        ));
        
        //retrieve charge details
        $chargeJson = $charge->jsonSerialize();
        
        //check whether the charge is successful
        if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1){
            //order details 
            $amount = $chargeJson['amount'];
            $deduction = $chargeJson['balance_transaction'];
            $payment_method = $chargeJson['payment_method'];
            $status = $chargeJson['status'];
            $date = date("Y-m-d H:i:s");
            $due_amount = $itemPrice - $amount;
            tentee_payement($card_book_id,$name,$email,$itemPrice,$amount,$due_amount,$payment_method,$deduction,$status,$date);
            Instant_booking_status_reservation( 8 ,$card_book_id);  
            //if order inserted successfully
            if( $status == 'succeeded'){
                $statusMsg = "succeeded";
            }else{
                $statusMsg = "failed";
            }
            
        }else{
            $statusMsg = "failed";
        }
    }else{
        $statusMsg = "error";
    } 
    //show success or error message

wp_send_json($statusMsg);
}
add_action( 'wp_ajax_nopriv_ajaxstripepayement', 'ajaxstripepayement_fn' );
add_action( 'wp_ajax_ajaxstripepayement', 'ajaxstripepayement_fn' );


  /***********************************FUNCTION D'ENVOI D'EMAIL****************************/

function my_email_body_function($book) {

   function fandates($daten){
    $date=date_create($daten);
    return date_format($date,"d M Y");
   }
   global $ibmail;
   global $mode;
   global $sitename;
   global $devise;
   global $wpdb;

  $result = $wpdb->get_results ("SELECT * FROM IB_tentee_reservation WHERE id = $book");

  $id_client = $result[0]->id_client;
  $num_facture = $result[0]->numero_commande;
  $id_service = $result[0]->id_service;
  $client_nom=get_post_meta( $id_client, 'pr_nom', true) ;
  $client_prenom =get_post_meta( $id_client, 'pr_prenom', true) ;
  $title= get_post($id_service)->post_title;
  $prix_unique = get_post_meta( $id_service, 'serv_prix', true);              
  $client_tel =get_post_meta( $id_client, 'pr_tel', true) ;
  $client_adr =get_post_meta( $id_client, 'pr_adresse', true) ;
  $prix_total =$result[0]->prix_Total ;
  $status = $result[0]->status_payement;
   $created = fandates($result[0]->created_on);
   $extras = json_decode($result[0]->extra);
  $date_debut = fandates($result[0]->date_debut) ;
  $date_fin = fandates($result[0]->date_fin);
  
  ob_start(); // We have to turn on output buffering. VERY IMPORTANT! or else wp_mail() wont work 
  // Then setup your email body using the postfields from the attritbutes passed on. ?>
  <!DOCTYPE html>
  <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="x-apple-disable-message-reformatting">
    <title></title>
    <!--[if mso]>
    <noscript>
      <xml>
        <o:OfficeDocumentSettings>
          <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
      </xml>
    </noscript>
    <![endif]-->
  </head>
  <body style="">
    <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
      <tr>
        <td align="center" style="padding:0;">
           <table role="presentation" style="width:100%;border-collapse:collapse;border-spacing:0;text-align:left;">
             <tbody >
                <tr>
                  <td style="font-size: 16px; margin: 0; padding:0 16px;">
                    <div style="">
                      <p align="center" style="font-size: 26px; padding:16px; 0">Numéro De Commande :<?php echo $num_facture ?></p>
                    </div>
                    <div style="display: flex ;justify-content: space-between; paddind:0px 20px ;color: #626262;font-size: 18px">
                      <div style="display: flex; flex-direction: column;">
                        <span style="color: #0080d3; padding-bottom: 5px"><?php echo strtoupper($client_nom .' '. $client_prenom) ?></span>
                        <span style="padding-bottom: 5px"><?php echo ucwords($client_adr) ?></span>
                        <span style="padding-bottom: 5px"><?php echo $client_tel?></span>
                      </div>
                      <div style="display: flex; flex-direction: column">
                        <span style="padding-bottom: 5px">Status: 
                           <?php if($status == "2"){?>
                            <strong style="color: #28a745;">Impayé</strong>
                           <?php }else if($status == "8"){?>
                            <strong style="color: #28a745;">Payé</strong>    <?php } ?>
                        </span>
                        <span style="padding-bottom: 5px"><?php echo $created ?></span>
                      </div>
                    </div>

                    <div style="display: flex ;justify-content: space-around;height:70px;margin: 15px 0; padding:20px ;color: #2c2c2c;font-size: 18px;background-color: #f0f0f0;">
                      <div style="display: flex; flex-direction: column;">
                        <span style="font-weight: 600">Date Départ </span>
                        <span><?php echo $date_debut?></span>
                      </div>
                      <div style="display: flex; flex-direction: column;">
                        <span style="font-weight: 600">Date retour </span>
                        <span><?php echo $date_fin ?></span>
                      </div>
                    </div>

                    <div style="padding: 20px 30px"></div> 
                    <table style="width: 100%;border-collapse: collapse;border: 1px solid #ddd;">
                      <tbody>

                        <tr align="left">
                        <div class="table-responsive">
                              <table style="padding: 8px;width: 100%">
                                  <thead style="background-color: #0080d3;text-align: left">
                                      <tr class="">
                                          <th style=" padding: 8px;">Description</th>
                                          <th style=" padding: 8px;">Prix par jour</th>
                                          <th style=" padding: 8px;">prix total</th>
                                      </tr>
                                  </thead>
              
                                  <tbody class="background-color: #0080d3">
                                      <tr></tr>
                                      <tr>
                                          <td style=" padding: 8px;"><?php echo ucwords($title) ?> </td>
                                          <td style=" padding: 8px;"><?php echo $prix_unique.''. $devise ?> </td>
                                          <td style=" padding: 8px;"><?php echo $prix_unique.''. $devise ?> </td>
                                      </tr> 
                                      <?php
                                      foreach($extras as $extra){?>
                                      <tr style="border-top: 1px solid #b8b8b8;">
                                        <td style=" padding: 8px;"><?php echo ucwords(get_term_by( 'term_id',$extra,'extra')->name) ?></td>
                                        <td style=" padding: 8px; "></td>
                                        <td style=" padding: 8px;"><?php echo esc_html(get_term_meta( $extra, 'extraPrice',true)).''. $devise ?></td>
                                      </tr>
                                      <?php } ?>
                                     
                                  </tbody>
                              </table>
                          </div>
                        </tr>

                      </tbody>
                    </table>
                    <div style="display: flex;padding: 20px 50px 20px 20px;color: #626262;font-size: 16px;">
                      <div style="flex; width: 60%">
                           
                      </div>

                      <div style="display: flex;flex-direction: column; width: 40%">
                          <div style="display: flex;flex-direction: row; justify-content: space-between; padding: 5px 0">
                              <div style="">
                                  NET A Payer
                              </div>
                              <div style="">
                                  <span style="text-120 text-secondary-d1"><?php echo esc_html($prix_total .''. $devise) ?></span>
                              </div>
                          </div>

                          <div style="display: flex;flex-direction: row; justify-content: space-between; padding: 5px 0">
                              <div style="">
                                  Tax (0%)
                              </div>
                              <div style="">
                                  <span style="text-110 text-secondary-d1"></span>
                              </div>
                          </div>

                          <div style="display: flex;flex-direction: row; justify-content: space-between; padding: 5px 0; font-size: 20px ; font-weight: 600">
                              <div style="">
                                  Somme Total
                              </div>
                              <div style="">
                                  <span style="color: #0080d3;"><?php echo esc_html($prix_total .''. $devise) ?></span>
                              </div>
                          </div>
                      </div>
                    </div>
                
                  </td>
                </tr>
             </tbody>
           </table>
        </td>
     </tr>
    </table>
       
  </body>
  </html>
  <?php 
   return ob_get_clean();

}

function my_email_body_all($book ,$message) {
  global $mode;
  global $devise;

   function fandates($daten){
    $date=date_create($daten);
    return date_format($date,"d M Y");
   }

  $result =tentee_reservation_select_reservation($book);
  
  $id_client = $result[0]->id_client;
  $num_facture = $result[0]->numero_commande;
  $id_service = $result[0]->id_service;
  $client_nom=get_post_meta( $id_client, 'pr_nom', true) ;
  $client_prenom =get_post_meta( $id_client, 'pr_prenom', true) ;
  $title= get_post($id_service)->post_title ;
  $prix_unique = get_post_meta( $id_service, 'serv_prix', true);              
  $client_tel =get_post_meta( $id_client, 'pr_tel', true) ;
  $client_adr =get_post_meta( $id_client, 'pr_adresse', true) ;
  $prix_total =$result[0]->prix_Total ;
  $status = $result[0]->status_payement;
   $created = fandates($result[0]->created_on);
   $extras = json_decode($result[0]->extra);
  $date_debut = fandates($result[0]->date_debut) ;
  $date_fin = fandates($result[0]->date_fin);
   
  ob_start(); // We have to turn on output buffering. VERY IMPORTANT! or else wp_mail() wont work 
  // Then setup your email body using the postfields from the attritbutes passed on. ?>
  <!DOCTYPE html>
  <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="x-apple-disable-message-reformatting">
    <title></title>
    <!--[if mso]>
    <noscript>
      <xml>
        <o:OfficeDocumentSettings>
          <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
      </xml>
    </noscript>
    <![endif]-->
  </head>
  <body style="">
    <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
      <tr>
        <td align="center" style="padding:0;">
           <table role="presentation" style="width:100%;border-collapse:collapse;border-spacing:0;text-align:left;">
             <tbody >
                <tr>
                  <td style="font-size: 16px; margin: 0; padding:0 16px;">
                    <div style="">
                      <p align="center" style="font-size: 26px; padding:16px; 0">Numéro De Commande :<?php echo $num_facture ?></p>
                    </div> 
                    <div style="display: flex; flex-direction: column ; paddind:0px 20px ;color: #626262;font-size: 18px">
                      <span style="padding-bottom: 5px">Status: 
                          <?php if($status == "2"){?>
                          <strong style="color: #28a745;">Impayé</strong>
                          <?php }else if($status == "8"){?>
                          <strong style="color: #28a745;">Payé</strong>    <?php } ?>
                      </span>
                      <span style="padding-bottom: 5px">Date : <?php echo $created ?></span>
                    </div>

                    <div style="display: flex ;justify-content: space-around;height:40px;margin: 10px 0; padding:20px ;color: #2c2c2c;font-size: 18px;background-color: #f0f0f0;">
                      <div style="display: flex; flex-direction: column;">
                        <span style="font-weight: 600">Date Départ </span>
                        <span><?php echo $date_debut?></span>
                      </div>
                      <div style="display: flex; flex-direction: column;font-weight: 600">
                        <span >Date retour </span>
                        <span><?php echo $date_fin ?></span>
                      </div>
                    </div>
                    <div style="display: flex ;justify-content: space-around;">
                        <div style="display: flex; flex-direction: column;">
                          <p style="font-weight: 600; padding-bottom: 5px; font-size: 18px"> LES INFORMATIONS DU CLIENTS</p>
                          <span style="color: #0080d3; padding-bottom: 5px;font-weight: 600"><?php echo strtoupper($client_nom .' '. $client_prenom) ?></span>
                          <span style="padding-bottom: 5px"><?php echo ucwords($client_adr) ?></span>
                          <span style="padding-bottom: 5px"><?php echo $client_tel?></span>
                        </div>

                        <div style="display: flex ;flex-direction: column;">
                          <p style="font-weight: 600; padding-bottom: 5px; font-size: 18px"> LES INFORMATIONS DU SERVICES</p>
                          <span style="color: #0080d3; padding-bottom: 5px;font-weight: 500"><?php echo ucwords($title) ?></span>
                          <span style="padding-bottom: 5px"><?php echo $prix_unique.''. $devise ?></span>
                          <span style="padding-bottom: 5px"><?php echo $prix_unique.''. $devise ?></span>    
                        </div>  
                     </div>            
                    <div style="font-size: 18px; padding:20px 0px">
                      <?php  echo $message ?>
                     </div>
                  </td>
                </tr>
             </tbody>
           </table>
        </td>
     </tr>
    </table>
       
  </body>
  </html>
  <?php 
   
   return ob_get_clean();
   
}
/**********************************Generer pdf********************** */

function Ib_HistoriquePdf(){

  ib_historique_pdf();
   wp_die();

}
add_action( 'wp_ajax_nopriv_ajaxHistoriquePdf', 'Ib_HistoriquePdf' );
add_action( 'wp_ajax_ajaxHistoriquePdf', 'Ib_HistoriquePdf' );


// ////////////////////////////////////////////////////front-end////////////////////////////////////////////////

/*************************enregistrer un reservation************** */

function savereservation_front(){
  global $ibmail;  
  global $sitename;
   
  $address   =   sanitize_user( $_POST['address'] );
  $email      =  sanitize_email( $_POST['email'] );
  $first_name =  sanitize_text_field( $_POST['first_name'] );
  $last_name  =  sanitize_text_field( $_POST['last_name'] );
  $telephone  = sanitize_text_field( $_POST['telephone'] );
  $pays =  sanitize_text_field( $_POST['pays'] );
  $code_postal  =  sanitize_text_field( $_POST['code_postal'] );
  $ville  = sanitize_text_field( $_POST['ville'] );
  $note        =   esc_textarea( $_POST['note'] );
  $reduction        =   isset( $_POST['id_promo']) ? $_POST['id_promo'] : null;

  
  $price_total =  sanitize_text_field( $_POST['price_total'] );
  $service_id  =  sanitize_text_field( $_POST['service_id'] );
  $prix_base  = sanitize_text_field( $_POST['prix_base'] );
  $start_date    =   esc_attr( $_POST['start_date'] );
  $end_date    =   esc_attr( $_POST['end_date'] );
  $depart    =   esc_attr( $_POST['depart'] );
  $depot    =   esc_attr( $_POST['depot'] );
  $extra    =    $_POST['ExtraTab'];
  $njours = sanitize_text_field( $_POST['njours'] );
  $title= get_post($service_id)->post_title ;

  $to = $email; 
  $headers = array('From: '.$sitename.'<'.$ibmail.'>','Cc: ReceiverName <second email>','Bcc: Receiver2Name <third email>');
  $subject ="Action sur '$sitename'";
  $nomfichier="facture.pdf"; 
  $id_em = get_current_user_id();
  $compteur = 0; 
  if( isset($_POST['email']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['telephone']) && isset($_POST['pays']) && isset($_POST['code_postal']) && isset($_POST['ExtraTab']) && isset($_POST['ville'])){
      $args = array(
        'post_type' => 'client',
        'meta_query' => array(
          array(
              'key'     => 'pr_mail',
              'value'   => $email,
              'compare' => 'LIKE',
          ),
        ),
      );
      $query = new WP_Query( $args );
      $nas = $query->found_posts;
        if($nas >= 1){
          $post_id = $query->posts[0]->ID;
          $old_compteur = get_post_meta( $post_id, 'pr_compteur', true) ;
          $newcompteur = intval($old_compteur ) + 1;
          update_post_meta( $post_id, 'pr_compteur', $newcompteur);
 
        }else{
          $clientdata = array (
            'post_type'    => 'client',
            'post_status'  => 'publish',
            'post_name'    => "ClientFront",
            'pr_nom'       =>$first_name,
          );
         $post_id = wp_insert_post($clientdata);
          $actions  = "Création d'une client";
           $type_r = 'client';
           $newcompteur = $compteur + 1;

            add_post_meta($post_id, 'pr_nom', $first_name);
            add_post_meta($post_id, 'pr_prenom', $last_name);
            add_post_meta($post_id, 'pr_mail', $email);
            add_post_meta($post_id, 'pr_tel', $telephone);
            add_post_meta($post_id, 'pr_adresse',$address);
            add_post_meta($post_id, 'pr_note', $note);
            add_post_meta($post_id, 'pr_pays',  $pays);
            add_post_meta($post_id, 'pr_ville', $ville);
            add_post_meta($post_id, 'pr_zip', $code_postal);
            add_post_meta($post_id, 'pr_compteur',  $newcompteur);
            tentee_reservation_historique($id_em,$post_id,$actions,$type_r);
        }
        

          $resertest =tentee_reservation_select_date_select($start_date,$end_date);
          $Dat = [];
      
          foreach($resertest as $got){
            array_push($Dat,strval($got->id_service));
          }
         if( in_array("$service_id",$Dat)){
            $data = array(
              'code' => 220,
            );
         }else{
            $maxreduction =tentee_coupon_get_limit($reduction);
              if($maxreduction == null){
                
                $nbr_send = 1;

              }else{

                $nbr_send += 1;
              }

             $change = tentee_reservation_insert_reservation($service_id,$post_id,$prix_base,$extra,$price_total,$start_date,$end_date,$depart,$depot,$njours); ;
             $book_id = IB_select_id_client($post_id);
             $body = my_email_body_function($book_id); 
            //  wp_send_json(intval($book_id));
            
             $path=ib_facturepdf($book_id);
            //  wp_send_json($path);
             wp_mail( $to, $subject, $body, $headers , $path);   
             if($change == true ){

              $actions  = "Création d'une reservation";
              $type_r = 'reservations';
              
              tentee_reservation_historique($id_em,$book_id,$actions,$type_r);  
              tentee_coupon_update_limit($reduction,$nbr_send);
              $data = array(
                  'code' => 200,
                  'book_id' => $book_id
                );

            }else{

              $data = array(
                'code' => 400,
                'book_id' => $book_id,
                'error'=> $wp_error
              );
        
            }
         } 
      
    }  
 wp_send_json($data);

}add_action( 'wp_ajax_nopriv_ajaxServiceReservation', 'savereservation_front' );
add_action( 'wp_ajax_ajaxServiceReservation', 'savereservation_front' );

///////Afficher les reservations dans la bd///////////

function ajaxselect_all_reservation(){

  $result = tentee_reservation_select_all();

  function fantimes($times){
    $date=date_create($times);
    return date_format($date,"H:i:s");
   }

   function fandates($daten){
    $date=date_create($daten);
    return date_format($date,"Y-m-d");
   }
   function fandatestime($daten){
    $date=date_create($daten);
    return date_format($date,"d M Y , H:i");
   }

 $dataR = [];
 foreach($result as $ligne){
           
      $ID = intval($ligne->id);               
      $id_evenement = intval($ligne->id_event);
      $id_service = intval($ligne->id_service);
      $id_client = intval($ligne->id_client);
      $prix_base = intval($ligne->prix_base);
      $prix_total = intval($ligne->prix_Total) ;
      $date_debut = fandates($ligne->date_debut) ;
      $date_fin = fandates($ligne->date_fin) ;
      $heure_debut =  fantimes($ligne->heure_debut);
      $heure_fin = fantimes($ligne->heure_fin);
      $created_on = fandatestime($ligne->created_on) ;
      $color = intval($ligne->etat) == 0  ? 'En attente' :  $type = 'Approuvé';

      $title = $type = get_post($id_service)->post_title;
      $prix_unique = get_post_meta( $id_service, 'serv_prix', true);
      $client_nom=get_post_meta( $id_client, 'pr_nom', true) ;
      $client_prenom =get_post_meta( $id_client, 'pr_prenom', true) ;
      $client_mail =get_post_meta( $id_client, 'pr_mail', true) ;
      $client_tel =get_post_meta( $id_client, 'pr_tel', true) ;

		$datas = [
			'title' => $title,
      'start' =>  $date_debut,
      'end' => $date_fin,
      'end' => $date_fin,
      'location' => $client_nom.''. $client_prenom,
      'description'=> 'first description' ,
      'class' => ""
		];
    array_push($dataR , $datas);
	}
	//$d = json_encode($dataR);
  wp_send_json($dataR);
}
add_action( 'wp_ajax_nopriv_ajaxselect_all', 'ajaxselect_all_reservation' );
add_action( 'wp_ajax_ajaxselect_all', 'ajaxselect_all_reservation' );


function ajaxdisplay_front_reservation(){

  $result = tentee_reservation_select_all();

	
	//$d = json_encode($data);
  wp_send_json($dataR);
}
add_action( 'wp_ajax_nopriv_ajaxdisplay_front', 'ajaxdisplay_front_reservation' );
add_action( 'wp_ajax_ajaxdisplay_front', 'ajaxdisplay_front_reservation' );

/*
function ajaxoption_send_fn(){
date_format($heur_debut,"hh:mm:ss")
  $peu = $_POST['pr_totalP']; 
  $cpt = count($_POST['pr_product']);


  require WPPLUGIN_DIR .'vendor/autoload.php';

  \Stripe\Stripe::setApiKey('sk_test_51L82n0KaE22cyrkbZGChWTYtm9h7b2rMhyLvWC233xAyNwNJijmxDj0jSWMOe6wdKQwyRJJ2k1bLH38rVwCQK5zW00n0flgYvL');
  
  header('Content-Type: application/json');
  
  $YOUR_DOMAIN = 'WPPLUGIN_URL';    
  $checkout_session = \Stripe\Checkout\Session::create([
     'line_items' => [[
       'price_data' =>[
                   'unit_amount' => 2000,
                   'currency' => 'usd',
                   'product_data' => [
                                 'name' => 'ycjhcgjzky',
                             ],
                 ],
       'quantity'=> 1
     ]],
     'mode' => 'payment',
     'success_url' => 'https://example.com/success',
     'cancel_url' => 'https://example.com/cancel',
   ]);

  
      $response = array(
        'session'   => $checkout_session
      );
  
      wp_send_json($response);

}
add_action( 'wp_ajax_nopriv_ajaxoption_send', 'ajaxoption_send_fn' );

add_action( 'wp_ajax_ajaxoption_send', 'ajaxoption_send_fn' );*/

/***************************************************/
/**                 employer                       */
/***************************************************/

/*************************mettre a jour un employer************** */

function ajaxUpdateEmplyee_fn(){
   
  $username   =   sanitize_user( $_POST['username'] );
  $email      =   sanitize_email( $_POST['email'] );
  $first_name =   sanitize_text_field( $_POST['first_name'] );
  $last_name  =   sanitize_text_field( $_POST['last_name'] );
  $telephone  = sanitize_text_field( $_POST['telephone'] );
  $bio        =   esc_textarea( $_POST['bio'] );
 $unique =  get_user_by( 'email', $email );
 $actions  = "Mise à jour d'un employé";
 $type_r = 'employee';
 $id_em = get_current_user_id();
    
    global $reg_errors;
    $reg_errors = new WP_Error;

     
    $userdata = array(
      'user_login'    =>   $username,
      'user_email'    =>   $email,
      'first_name'    =>   $first_name,
      'last_name'     =>   $last_name,
      'user_phone'     =>   $telephone,
      'description'   =>   $bio,
      );
      $user = wp_update_user( $userdata );
      if (is_wp_error( $user )) {  
        $response = array(
          'code' => 400,
          'error' => $user->get_error_message()
        );
      }else{  
        $response = array(
          'code' => 200
        );  
        tentee_reservation_historique($id_em,$user,$actions,$type_r);
       } 
       
       wp_send_json($response);
  
}add_action( 'wp_ajax_nopriv_ajaxUpdateEmplyee', 'ajaxUpdateEmplyee_fn' );
add_action( 'wp_ajax_ajaxUpdateEmplyee', 'ajaxUpdateEmplyee_fn' );


/*************************creer un emplyer************** */

function createEmployee_user(){
   
  $username   =   sanitize_user( $_POST['username'] );
  $email      =   sanitize_email( $_POST['email'] );
  $first_name =   sanitize_text_field( $_POST['first_name'] );
  $last_name  =   sanitize_text_field( $_POST['last_name'] );
  $telephone  = sanitize_text_field( $_POST['telephone'] );
  $bio        =   esc_textarea( $_POST['bio'] );
 $unique =  get_user_by( 'email', $email );
 
 $actions  = "Création d'un employé";
 $type_r = 'employee';
 $id_em = get_current_user_id();

  $userdata = array(
      'user_login'    =>   $username,
      'user_email'    =>   $email,
      'first_name'    =>   $first_name,
      'last_name'     =>   $last_name,
      'user_phone'     =>   $telephone,
      'description'   =>   $bio,
      'role' => 'Employe',
      );
      $user = wp_insert_user( $userdata );

      $meta = add_user_meta( $user, 'user_phone', $telephone );
 
    if (is_wp_error( $user )) {  
      $response = array(
        'code' => 400,
        'error' => $user->get_error_message()
      );
    }else{
      tentee_reservation_historique($id_em,$user,$actions,$type_r);
         $response =[
           'code' => 200,
       ];    
    }

  wp_send_json($response);
 
}add_action( 'wp_ajax_nopriv_ajaxcreateEmployee', 'createEmployee_user' );
add_action( 'wp_ajax_ajaxcreateEmployee', 'createEmployee_user' );


/*************************afficher un employer************** */

function DisplayEmployee_user(){
   
  $user_id = $_POST['id_element'];
  $employe = get_user_by('ID' ,$user_id) ; 
  $username = $employe->user_login ;
  $email = $employe->user_email;
  $last_name = get_user_meta( $employe->ID , 'last_name', true);
  $first_name = get_user_meta( $employe->ID , 'first_name', true);
  $telephone = get_user_meta( $employe->ID , 'user_phone', true);
  $bio = get_user_meta( $employe->ID , 'description', true); 
  
 
  $dataR[] = [
    "ID" => $user_id,
    'username' => $username,
    'email' =>  $email,
    'last_name' => $last_name,
    'first_name' => $first_name,
    'telephone' =>  $telephone,
    'bio' => $bio,
  ];

 wp_send_json( $dataR ) ;
 
}add_action( 'wp_ajax_nopriv_ajaxDisplayEmployee', 'DisplayEmployee_user' );
add_action( 'wp_ajax_ajaxDisplayEmployee', 'DisplayEmployee_user' );


/*************************editer un employer************** */

function UpdateEmployee_user(){
   
  $user_id   =   sanitize_user( $_POST['ID'] );
  $username   =   sanitize_user( $_POST['username'] );
  $email      =   sanitize_email( $_POST['email'] );
  $first_name =   sanitize_text_field( $_POST['first_name'] );
  $last_name  =   sanitize_text_field( $_POST['last_name'] );
  $telephone  = sanitize_text_field( $_POST['telephone'] );
  $bio        =   esc_textarea( $_POST['bio'] );
  $unique =  get_user_by( 'email', $email );
  $actions  = "Mise à jour d'un employé";
  $type_r = 'employee';
  $id_em = get_current_user_id();

    $userdata = array(
      'ID' => $user_id,
      'user_login'    =>   $username,
      'user_email'    =>   $email,
      'first_name'    =>   $first_name,
      'last_name'     =>   $last_name,
      'user_phone'     =>   $telephone,
      'description'   =>   $bio,
      );
    $user = wp_update_user( $userdata );
 
    update_user_meta( $user, 'user_phone', $telephone );
    
    if (is_wp_error( $user )) {  

      $response = array(
        'code' => 400
      );

    }else{
     
      tentee_reservation_historique($id_em,$user,$actions,$type_r);
        $response =[
          'code' => 200
        ]; 
    }

  wp_send_json($response);
 
}add_action( 'wp_ajax_nopriv_ajaxUpdateEmployee', 'UpdateEmployee_user' );
add_action( 'wp_ajax_ajaxUpdateEmployee', 'UpdateEmployee_user' );


/*************************supprimer un employer************** */

function DeleteEmployee_user(){
   
  $user_id   =   sanitize_user( $_POST['ID'] );
  $actions  = "Suppression";
  $type_r = 'employee';
  $id_em = get_current_user_id();

  if(isset($_POST['ID']) )
  {
    $user = wp_delete_user( $user_id );
    update_user_meta( $user, 'user_phone', $telephone );
    tentee_reservation_historique($id_em,$user,$actions,$type_r);
    $response =[
      'code' => 200,
    ];
  } else{
    $response = array(
      'code' => 400,
    );
  }

  wp_send_json($response);
 
}add_action( 'wp_ajax_nopriv_ajaxDEleteEmployee', 'DeleteEmployee_user' );
add_action( 'wp_ajax_ajaxDEleteEmployee', 'DeleteEmployee_user' );


/************************enregistrer des crenaux horaires************/

function ajaxsaveCrenaux_fn(){

  $crenaux = $_POST['crenaux'];
  $event_id = $_POST['event_id']; 

   $test = tentee_reservation_select_id_creanaux($event_id);
   if($test){
      tentee_reservation_update_creanaux( $event_id ,$crenaux);
      wp_send_json($test);
          // foreach($test as $row)
          // {
          //   $output .= '
          //     <div> <ol class="list-group list-group-numbered">
          //     <li class="list-group-item">'.$row["crenaux"].'</li>
          //     </ol></div>
          //   ';
          // }
          // echo $output;
     }else{
    
       tentee_reservation_insert_creanaux( $event_id , $crenaux);
       wp_send_json($test);
     }
  
  //var_dump($crenauxtest);
 // wp_send_json($crenauxtest);
  
 wp_die();

}add_action( 'wp_ajax_nopriv_ajaxsaveCrenaux', 'ajaxsaveCrenaux_fn' );
add_action( 'wp_ajax_ajaxsaveCrenaux', 'ajaxsaveCrenaux_fn' );


/*************************recuperer et afficher les extras************** */

function Extra_reservation_list(){
  $extraCount  = count($_POST['id_reser']);
  $jours  = $_POST['njours'];
  for($i=0 ; $i<$extraCount ;$i++){
    $extra_id   =   sanitize_text_field( $_POST['id_reser'][$i] );
    $extraName = get_term_by( 'term_id',$extra_id,'extra')->name;
    $extraPrix = get_term_meta( $extra_id, 'extraPrice',true);
    $extratotal = $extraPrix * $jours;

    if( isset( get_option('Payments_Settings')['Parametre_devise'] ) || isset( get_option('Payments_Settings')['Parametre_mode_reservation'] ) ) {
      $devise = esc_html( get_option('Payments_Settings')['Parametre_devise']  );
      
  $decimales = intval(esc_html(get_option('Payments_Settings')['Parametre_​nombre_decimales']));
    }

    echo '<li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0">'.$extraName.'</h6>
              <small class="text-muted"><span class="text-muted">'.$jours.'</span> jours</small>
            </div> 
            <p><span class="text-muted">'.number_format(intval($extratotal),$decimales).'</span><span>'.$devise.'</span></p>
          </li>';
  } 
wp_die();
 
}add_action( 'wp_ajax_nopriv_ajaxget_extra_send', 'Extra_reservation_list' );
add_action( 'wp_ajax_ajaxget_extra_send', 'Extra_reservation_list' );


/*************************Approuver une reservation************** */

function Ib_approveBooking(){
  global $ibmail;  
  global $sitename;
      $book_id  = $_POST['book_id'];
      $actions  = "Approuver une reservation";
      $type_r = 'reservations';
      $id_em = get_current_user_id();
      $client_id = tentee_reservation_select_client_reservation($book_id);
      $to = get_post_meta( $client_id[0]->id_client, 'pr_mail', true) ; 
      $headers = array('From: '.$sitename.'<'.$ibmail.'>','Cc: ReceiverName <second email>','Bcc: Receiver2Name <third email>');
       $body = my_email_body_function($book_id);
       $subject ="Action sur '$sitename'";
       $nomfichier="facture.pdf";
       $path=ib_facturepdf( );
     
     wp_mail( $to, $subject, $body, $headers , $path);
    $change =  Instant_booking_approuve_reservation( 7 ,$book_id);   
    wp_mail($to, $subject, $body,$headers);
    if($change == true ){
      tentee_reservation_historique($id_em,$book_id,$actions,$type_r);
    $data = array(
      'code' => 200,
    );
    }else{
      $data = array(
        'code' => 400,
      );

    }

wp_send_json($data);

}add_action( 'wp_ajax_nopriv_ib_approveBooking', 'Ib_approveBooking' );
add_action( 'wp_ajax_ib_approveBooking', 'Ib_approveBooking' );

/*************************marquer une reservation payé ************** */

function ib_buy_Booking(){
    global $ibmail;  
    global $sitename;
    $book_id  = $_POST['book_id'];
    $actions  = "marquer une reservation payée";
    $type_r = 'reservations';
    $id_em = get_current_user_id();
    $client_id = tentee_reservation_select_client_reservation($book_id);
    $to = get_post_meta( $client_id[0]->id_client, 'pr_mail', true) ;
    $subject ="Action sur '$sitename'";
    $body = my_email_body_all($book_id , $message);
    $headers = array('From: '.$sitename.'<'.$ibmail.'>'
              ,'Cc: ReceiverName <second email>','Bcc: Receiver2Name <third email>');
    $message = "Nous avons reçu votre payement ";    
    
    $change =  Instant_booking_status_reservation( 8 ,$book_id);   
    wp_mail($to, $subject, $body,$headers);
    if($change == true ){
      tentee_reservation_historique($id_em,$book_id,$actions,$type_r);
      Instant_booking_approuve_reservation( 7,$book_id);
      $act = "marquer une reservation approuvé";
      tentee_reservation_historique($id_em,$book_id,$act,$type_r);        
      $data = array(
          'code' => 200,
        );
    }else{
      $data = array(
        'code' => 400,
        'error'=> $wp_error
      );

    }

wp_send_json($data);
  
}add_action( 'wp_ajax_nopriv_ib_buy_Booking', 'ib_buy_Booking' );
add_action( 'wp_ajax_ib_buy_Booking', 'ib_buy_Booking' );

/*************************Rejeter une reservation************** */

function ib_rejectedBooking(){
  global $ibmail;  
  global $sitename;
  $book_id  = $_POST['book_id'];
  $actions  = "Rejéter une reservation";
  $type_r = 'reservations';
  $id_em = get_current_user_id();
  $client_id = tentee_reservation_select_client_reservation($book_id);
  $to = get_post_meta( $client_id[0]->id_client, 'pr_mail', true) ;
  $headers = array('From: '.$sitename.'<'.$ibmail.'>','Cc: ReceiverName <second email>','Bcc: Receiver2Name <third email>');
  $message = "!!!!Votre réservation a été rejeté , veuillez en essayer une autre ou changer de période de réservation .!!!! Your reservation has been rejected, please try another one or change the reservation period";
  $body = my_email_body_all($book_id , $message);            
  $subject ="Action sur '$sitename'";
  
  $change = Instant_booking_approuve_reservation( 21 ,$book_id);
  wp_mail( $to, $subject, $body, $headers );
  if($change == true ){
     tentee_reservation_historique($id_em,$book_id,$actions,$type_r);
      $response =[
          'code' => 200,
          'data' => $data
      ];
  }else{
    $response = array(
      'code' => 400,
    );
  }
 wp_send_json($response);

}add_action( 'wp_ajax_nopriv_ib_rejectedBooking', 'ib_rejectedBooking' );
add_action( 'wp_ajax_ib_rejectedBooking', 'ib_rejectedBooking' );
/*************************approuver une reservation************** */

function ib_getBooking(){

  $book_id  = $_POST['book_id'];

  $change = intval(tentee_reservation_paye($book_id));

  wp_send_json($change);
}add_action( 'wp_ajax_nopriv_ib_getBooking', 'ib_getBooking' );
add_action( 'wp_ajax_ib_getBooking', 'ib_getBooking' );



/*************************suprimer une reservation************** */

function ib_cancelBooking(){
  global $ibmail;
  global $sitename;
  $book_id  = $_POST['book_id'];
  $actions  = "Annuler une reservation";
  $type_r = 'reservations';
  $id_em = get_current_user_id();
  $headers = array('From: '.$sitename.'<'.$ibmail.'>'
            ,'Cc: ReceiverName <second email>','Bcc: Receiver2Name <third email>');
  $message = "Cette réservation a été supprimée";
  $body = my_email_body_all($book_id , $message);            
  $subject ="Action sur '$sitename'";
  
  $change = Instant_booking_approuve_reservation( 21 ,$book_id);
  wp_mail( $ibmail, $subject, $body, $headers );
  if($change == true ){
     tentee_reservation_historique($id_em,$book_id,$actions,$type_r);
      $response =[
          'code' => 200,
          'data' => $data
      ];
   }else{
      $response = array(
        'code' => 400,
      );
    }
  wp_send_json($response);
}add_action( 'wp_ajax_nopriv_ib_cancelBooking', 'ib_cancelBooking' );
add_action( 'wp_ajax_ib_cancelBooking', 'ib_cancelBooking' );



/*************************completer une reservation************** */

function ib_completeBooking_fn(){
  global $ibmail;
  global $sitename;
  $book_id  = $_POST['book_id'];
  $actions  = "compléter une reservation";
  $type_r = 'reservations';
  $id_em = get_current_user_id();
  $client_id = tentee_reservation_select_client_reservation($book_id);
  $to = get_post_meta( $client_id[0]->id_client, 'pr_mail', true) ;
  $headers = array('From: '.$sitename.'<'.$ibmail.'>'
            ,'Cc: ReceiverName <second email>','Bcc: Receiver2Name <third email>');
  $message = "Votre reservation est complete";
  $body = my_email_body_all($book_id , $message);            
  $subject ="Action sur '$sitename'";
  $wesd = intval(tentee_reservation_paye($book_id));
    
  $change =  Instant_booking_approuve_reservation( 9 ,$book_id);
  wp_mail( $to, $subject, $body, $headers );
  if($change == true ){
     tentee_reservation_historique($id_em,$book_id,$actions,$type_r);
    $data = array(
      'code' => 200,
    );
  }else{
    $data = array(
      'code' => 400,
    );
  }

wp_send_json($data);

}add_action( 'wp_ajax_nopriv_ib_completeBooking', 'ib_completeBooking_fn' );
add_action( 'wp_ajax_ib_completeBooking', 'ib_completeBooking_fn' );

/***************************************************/
/**                 Taxes                          */
/***************************************************/

/**********************Ajouter une taxe*****************************/

function ajaxadd_taxes_fn(){

  $nom_taxe   =   sanitize_text_field( $_POST['nom_taxe'] );
  $value_taxe =   sanitize_text_field( $_POST['value_taxe'] );
  if(isset($_POST['nom_taxe']) && isset($_POST['value_taxe']) ){

    $geto = tentee_taxe_select_nom($nom_taxe);
    if(empty($geto)){

        $result = tentee_taxe_insert($nom_taxe,$value_taxe);
        if( $result == true){
          $response =[
            'code' => 200
          ];
        }else{
          $response =[
            'code' => 300
          ];
        }

      }else{
        $response =[
          'code' => 201
        ];
  
      }

  }
  wp_send_json($response);
}
add_action( 'wp_ajax_nopriv_ajaxadd_taxes', 'ajaxadd_taxes_fn' );
add_action( 'wp_ajax_ajaxadd_taxes', 'ajaxadd_taxes_fn' );

/*********************modifier une taxe*****************************/

function ajaxupdate_taxes_fn(){

  $id_element =   sanitize_text_field( $_POST['id_element'] );
  if (isset($_POST['id_element']) ){

    $result = tentee_taxe_select_id($id_element);
  }
  wp_send_json($result);
}
add_action( 'wp_ajax_nopriv_ajaxupdate_taxes', 'ajaxupdate_taxes_fn' );
add_action( 'wp_ajax_ajaxupdate_taxes', 'ajaxupdate_taxes_fn' );

function ajaxupdateall_taxes_fn(){

  $id_element =   sanitize_text_field( $_POST['id_element'] );
  $nom_taxe   =   sanitize_text_field( $_POST['n_taxe'] );
  $value_taxe =   sanitize_text_field( $_POST['v_taxe'] );
  if(isset($_POST['n_taxe']) && isset($_POST['id_element']) && isset($_POST['v_taxe']) ){

        $result = tentee_taxe_update($id_element,$nom_taxe,$value_taxe);
        if( $result == true){
            $response =[
              'code' => 200
            ];
          }else{
            $response =[
              'code' => 300
            ];
          }

  }

  wp_send_json($response);
}
add_action( 'wp_ajax_nopriv_ajaxupdateall_taxes', 'ajaxupdateall_taxes_fn' );
add_action( 'wp_ajax_ajaxupdateall_taxes', 'ajaxupdateall_taxes_fn' );

/**********************delete une taxe******************************/

function ajaxDelete_taxes_fn(){

  $id_element =   sanitize_text_field( $_POST['id_element'] );
  if (isset($_POST['id_element']) ){

    $result = tentee_taxe_delete($id_element);
      if( $result == true){
        $response =[
          'code' => 200
        ];
      }else{
        $response =[
          'code' => 300
        ];
      }
  }
  wp_send_json($response);
}
add_action( 'wp_ajax_nopriv_ajaxDelete_taxes', 'ajaxDelete_taxes_fn' );
add_action( 'wp_ajax_ajaxDelete_taxes', 'ajaxDelete_taxes_fn' );

/***************************************************/
/**                 Coupons                        */
/***************************************************/

/**********************Ajouter une coupon*****************************/

function ajaxadd_coupons_fn(){

  $code_coupon   =   sanitize_text_field( $_POST['code_coupon'] );
  $date_coupon =   sanitize_text_field( $_POST['date_coupon'] );
  $deduction_coupon =  sanitize_text_field($_POST['deduction_coupon']);
  $remise_coupon  =  sanitize_text_field($_POST['remise_coupon']);
  $limitperson   =   sanitize_text_field( $_POST['limitperson'] );
  
  if(isset($_POST['code_coupon']) && isset($_POST['date_coupon']) ){
    // wp_send_json($remise_coupon);
    $hetp = tentee_coupon_select_code($code_coupon);
    if(empty($hetp)){

      $result = tentee_coupon_insert($code_coupon,$deduction_coupon,$remise_coupon,$limitperson,$date_coupon);
      if( $result == true){
        $response =[
          'code' => 200,
          'data' => $code_coupon
        ];
      }else{
        $response =[
          'code' => 300,
          'data' => $code_coupon
        ];
      }
    }else{
      $response =[
        'code' => 201,
        'data' => $code_coupon
      ];

    }
  }
  wp_send_json($response);
}
add_action( 'wp_ajax_nopriv_ajaxadd_coupons', 'ajaxadd_coupons_fn' );
add_action( 'wp_ajax_ajaxadd_coupons', 'ajaxadd_coupons_fn' );

/*********************modifier une coupon*****************************/

function ajaxupdate_coupons_fn(){

  $id_element =   sanitize_text_field( $_POST['id_element'] );
  if (isset($_POST['id_element']) ){

    $result = tentee_coupon_select_id($id_element);
  }
  wp_send_json($result);
}
add_action( 'wp_ajax_nopriv_ajaxupdate_coupons', 'ajaxupdate_coupons_fn' );
add_action( 'wp_ajax_ajaxupdate_coupons', 'ajaxupdate_coupons_fn' );

function ajaxupdateall_coupons_fn(){

  $code_coupon  = sanitize_text_field( $_POST['c_coupon'] );
  $date_coupon = sanitize_text_field( $_POST['d_coupon'] );
  $deduction_coupon = sanitize_text_field( $_POST['de_coupon'] );
  $remise_coupon = sanitize_text_field( $_POST['re_coupon'] );
  $limitperson  = sanitize_text_field( $_POST['l-person'] );
  $id_element =   sanitize_text_field( $_POST['id_element'] );
  
  if(isset($_POST['c_coupon']) && isset($_POST['id_element']) && isset($_POST['d_coupon']) ){
 

     $result = tentee_coupon_update($id_element,$code_coupon,$deduction_coupon,$remise_coupon,$limitperson,$date_coupon);
      if( $result == true){
        $response =[
          'code' => 200,
          'data' => $nom_coupon
        ];
      }else{
        $response =[
          'code' => 300,
          'data' => $nom_coupon
        ];
      }
  
  }

  wp_send_json($response);
}
add_action( 'wp_ajax_nopriv_ajaxupdateall_coupons', 'ajaxupdateall_coupons_fn' );
add_action( 'wp_ajax_ajaxupdateall_coupons', 'ajaxupdateall_coupons_fn' );

/**********************delete une coupon******************************/

function ajaxDelete_coupons_fn(){

  $id_element =   sanitize_text_field( $_POST['id_element'] );
  if (isset($_POST['id_element']) ){

    $result = tentee_coupon_delete($id_element);
    if( $result == true){
      $response =[
        'code' => 200
      ];
    }else{
      $response =[
        'code' => 300
      ];
    }
   
  }
  wp_send_json($response);
}
add_action( 'wp_ajax_nopriv_ajaxDelete_coupons', 'ajaxDelete_coupons_fn' );
add_action( 'wp_ajax_ajaxDelete_coupons', 'ajaxDelete_coupons_fn' );


/*****************use coupon*************** */

function ajaxReductioncoupon_fn(){

  $code =   sanitize_text_field( $_POST['code'] );
  if (isset($_POST['code']) ){

    $result = tentee_coupon_select_code($code);
  }
  wp_send_json($result);
}
add_action( 'wp_ajax_nopriv_ajaxReductioncoupon', 'ajaxReductioncoupon_fn' );
add_action( 'wp_ajax_ajaxReductioncoupon', 'ajaxReductioncoupon_fn' );