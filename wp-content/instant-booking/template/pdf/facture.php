<!DOCTYPE html>
  <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="x-apple-disable-message-reformatting">
    <title></title>
  </head>
  <body style="">
<div class="main-panel">
<div class="content-wrapper">
 <div class="row">
       <div class="col-lg-12 grid-margin stretch-card">
          <div class="">
            <div class="card-body">
             <div class="d-flex flex-row  align-items-center  justify-content-between">
                <div class="d-flex flex-row  align-items-center border-end  ib-part1">
                  <div class="ib-logo">
                      <img width="100" src="<?php echo $logoInstant;?>" class="logo-big"> 
                  </div> 
                  <H4>Instant Booking</H4>
                </div> 
                  <div class="d-flex">
                      <button type="button" class=" btn ib_primary_button pdf_generation" data-toggle="modal" data-target="#employeeModal">
                        <span><i class="fas fa-plus"></i>Generer un pdf</span>
                    </button>
                  </div>
             </div>
             <hr>
           </div>
          </div>
        </div>
      </div>
</div>
<div class="body-wrapper">
  
</div>
   

</div>


<?php

    global $wpdb;

    if( isset( get_option('Payments_Settings')['Parametre_devise'] ) || isset( get_option('reservation_settings')['Parametre_mode_reservation'] ) ) {
      $devise = esc_html( get_option('Payments_Settings')['Parametre_devise']  );
      $mode = esc_html(get_option('reservation_settings')['Parametre_mode_reservation']);
    }
    
    global $wpdb;
      $sql = "SELECT * FROM IB_tentee_historique ORDER BY id DESC" ;
	    $result = $wpdb->get_results ($wpdb->prepare( $sql));

    function fantimes($times){
        $date=date_create($times);
        return date_format($date,"H:i");
       }
    
       function fandates($daten){
        $date=date_create($daten);
        return date_format($date,"d M Y");
       }
       function fandatestime($daten){
        $date=date_create($daten);
        return date_format($date,"d M Y , H:i");
       }
?>
<div class="wrap">

</div>
<div class="main-panel">
   <div class="content-wrapper">
     <div class="row">
           <div class="col-lg-12 grid-margin stretch-card">
                <div class="  ib-part1">
                      <H4>Historique</H4>  
                 </div>
          </div>
   </div>
   <div class="body-wrapper">
      <div class="table-responsive pt-3 Ib-list-day-title ">
        <table class="table table-bordered table-hover">
          <thead>
          <tr>
                <th scope="col">Date</th>
                <th scope="col">Action</th>
                <th scope="col">Element</th>
                <th scope="col">Employe</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $i=0;
        foreach($result as $ligne){

          $ID = intval($ligne->id);               
          $id_employe = intval($ligne->id_employe);
          $id_element = intval($ligne->id_element);
          $action = $ligne->actions;
          $type_r = strval($ligne->type_r);
          $created_on = fandatestime($ligne->created_on) ;

          if($type_r == 'service'){
           if($action = 'Supression' || is_null(get_post($id_element))){
            $action = 'Supression';
            }else{
            $title= get_post($id_element)->post_title ;
            $image = get_the_post_thumbnail($id_element ,array( 100, 100));
            $prix_unique = get_post_meta( $id_element, 'serv_prix', true);
            }
          }elseif($type_r == 'client'){
            if($action = 'Supression' || is_null(get_post($id_element))){
              $action = 'Supression';
            }else{
            $client_nom=get_post_meta( $id_element, 'pr_nom', true) ;
            $client_prenom =get_post_meta( $id_element, 'pr_prenom', true) ;
            $client_mail =get_post_meta( $id_element, 'pr_mail', true) ;
            $client_tel =get_post_meta( $id_element, 'pr_tel', true) ;
            }
          }elseif($type_r == 'reservations'){
            $title= get_post($id_element);
            $ib_book = $wpdb->get_results ("SELECT * FROM IB_tentee_reservation WHERE id = $id_element");
            $id_client = $ib_book[0]->id;
            $id_service = $ib_book[0]->id_service;   
            $title= get_post($id_service)->post_title ;   
            $prix_total =$ib_book[0]->prix_Total ;
            $date_debut = fandates($ib_book[0]->date_debut) ;
            $date_fin = fandates($ib_book[0]->date_fin) ;
          }elseif($type_r == 'employee'){
            if($action = 'Supression' || is_null(get_post($id_element))){
              $action = 'Supression';
            }else{
            $employe_mail =get_userdata( $id_element)->user_email ;
            $employe_last_name = get_user_meta( $id_element , 'last_name', true);
            $employe_first_name = get_user_meta( $id_element , 'first_name', true);
            $employe_phone = get_user_meta( $id_element , 'user_phone', true);
            }
          }else{
            $title= 'inconnu';
          }
            
          $user_mail =get_userdata( $id_employe)->user_mail ;
          $users_last_name = get_user_meta( $id_employe , 'last_name', true);
          $users_first_name = get_user_meta( $id_employe , 'first_name', true);
          $users_phone = get_user_meta( $id_employe , 'user_phone', true);
  
        ?>
        
            <tr>  
                <td>
                    <?php echo $created_on?>
                  </div>
                </td>
                <td><?php echo $action?> </td>
                <td>
                  
                  <?php if($type_r == 'service'){
                     if($action = 'Supression' || is_null(get_post($id_element))){?>
                     <p>Cette element a été supprimé</p>
                    <?php }else{?>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="ib_user_details">
                            <span> <?php echo $title?> </span>
                            <span><?php echo  $prix_unique;?></span>
                        </div>
                    </div>
                  
                    <?php } }elseif($type_r == 'client'){
                       if($action = 'Supression' || is_null(get_post($id_element))){?>
                           <p>Cette element a été supprimé</p>
                       <?php }else{ ?>
                       <div class="d-flex align-items-center justify-content-between">
                          <div class="ib_user_card">
                              <div class="circle_image"><img src="<?php echo $blankPicture;?>"></div>
                              <div class="ib_user_details">
                                  <span><?php echo $client_nom ?> <?php echo $client_prenom ?> </span>
                                  <span> <?php echo $client_mail?> </span>
                                  <span><?php echo  $client_tel;?></span>
                              </div>
                          </div>
                      </div>
                    <?php } } elseif($type_r == 'reservations'){?>
                      <div class="ib_date_details">   
                        <span class="ib_date_name">ID : <?php echo $id_service ?></span></br> 
                        <span class="ib_date_name">Titre : <?php echo $title ?></span></br>
                        <span class="ib_date_name">Periode: <?php echo $date_debut .' - '. $date_fin;?> </span></br>
                        <span class="ib_date_name">Prix Total:<?php echo $prix_total.''. $devise;?></span>
                     </div>
                    <?php }elseif($type_r == 'employee'){?>
                      <div class="d-flex align-items-center justify-content-between">
                          <div class="ib_user_card">
                              <div class="circle_image"><img src="<?php echo $blankPicture;?>"></div>
                              <div class="ib_user_details">
                                  <span><?php echo $employe_last_name ?> <?php echo $employe_first_name ?> </span>
                                  <span> <?php echo $employe_mail?> </span>
                                  <span><?php echo  $employe_phone;?></span>
                              </div>
                          </div>
                      </div>
                      <?php }else{?>
                        <p>inconnu</p>
                      <?php }?>
                </td>
                <td>
                 <div class="d-flex align-items-center justify-content-between">
                    <div class="ib_user_card">
                        <div class="circle_image"><img src="<?php echo $blankPicture;?>"></div>
                        <div class="ib_user_details">
                            <span><?php echo $employe_last_name ?> <?php echo $employe_first_name ?> </span>
                            <span> <?php echo $employe_phone?> </span>
                            <span><?php echo  $user_mail;?></span>
                        </div>
                    </div>
                </div>
                </td>
                
                
                
            </tr>
            
        <?php }?>
          </tbody>
        </table>
      </div>
    </div>
</div>
</body>
  </html>
