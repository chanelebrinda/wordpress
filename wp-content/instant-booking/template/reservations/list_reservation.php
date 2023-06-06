
<?php

    global $wpdb;

    if( isset( get_option('Payments_Settings')['Parametre_devise'] ) || isset( get_option('reservation_settings')['Parametre_mode_reservation'] ) ) {
      $devise = esc_html( get_option('Payments_Settings')['Parametre_devise']  );
      $mode = esc_html(get_option('reservation_settings')['Parametre_mode_reservation']);
    }
    
    $result = $wpdb->get_results ("SELECT * FROM IB_tentee_reservation ORDER BY id DESC ");

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
                          <button type="button" class=" btn ib_primary_button " data-toggle="modal" data-target="#employeeModal">
                            <span><i class="fas fa-plus"></i><?php _e('Ajouter une Reservation','instant_booking')  ?></span>
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
      <div class="table-responsive pt-3 Ib-list-day-title ">
        <table class="table table-bordered table-hover" id="dftsgts-buttons " 
            data-search="true"
            data-pagination="true"
            data-show-columns="true"
            data-show-pagination-switch="true"
            data-show-refresh="true"
            data-buttons-align="left"
            data-show-toggle="true" 
            data-resizable="true" 
            data-buttons-class="primary"
            data-show-export="true"
            data-toggle="table"
            >
          <thead>
          <tr>
                <th data-field="state" data-checkbox="true"></th>
                <th data-field="id">ID</th>
                <th data-field="date" ><?php _e('Date','instant_booking')  ?></th>
                <th data-field="image" ><?php _e('Image','instant_booking')  ?></th>
                <th data-field="reservation" ><?php _e('Reservation','instant_booking')  ?></th>
                <th data-field="clients" ><?php _e('Clients','instant_booking')  ?></th>
                <th data-field="periode" ><?php _e('periode','instant_booking')  ?></th>
                <th data-field="lieu" ><?php _e('Lieu','instant_booking')  ?></th>
                <th data-field="extra" ><?php _e('Extra','instant_booking')  ?></th>
                <th data-field="prix_total" ><?php _e('Prix Total','instant_booking')  ?></th>
                <th data-field="payé" data-events="operateEvent"><?php _e('payé','instant_booking')  ?></th>
                <th data-field="etat" data-events="operateEvent"><?php _e('Etat','instant_booking')  ?></th>
            </tr>
          </thead>
          <tbody>
          <?php
          $i=0;
            foreach($result as $ligne){
                
                $ID = intval($ligne->id);               
                $id_evenement = intval($ligne->id_event);
                $id_service = intval($ligne->id_service);
                $id_client = intval($ligne->id_client);
                $prix_base = intval($ligne->prix_base);
                $depart = strval($ligne->depart);
                $depot = strval($ligne->depot);
                $extras = json_decode($ligne->extra);
                $type_r = intval($ligne->id_event) != 0 ? $type_r =  strval('evenement')  :$type_r = strval('service') ; ;
                $prix_total = intval($ligne->prix_Total) ;
                $date_debut = fandates($ligne->date_debut) ;
                $date_fin = fandates($ligne->date_fin) ;
                $heure_debut =  $type = 'evenement' ?  fantimes($ligne->heure_debut) : null;
                $heure_fin = $type = 'evenement' ?  fantimes($ligne->heure_fin) : null;
                $created_on = fandatestime($ligne->created_on) ;
                $status = intval($ligne->status_payement);
                $etat = intval($ligne->etat);
            if(intval($ligne->id_event) == 0){
                $title= get_post($id_service)->post_title ;
            }else{
                $title = $type = get_post($id_evenement)->post_title;
            }
            
                $image = get_the_post_thumbnail($id_service ,array( 100, 100));
                $prix_unique = get_post_meta( $id_service, 'serv_prix', true);
                $symbol_currency =  $type = 'evenement' ? get_post_meta( $id_evenement, 'pr_symbole', true): get_post_meta( $id_service, 'ser_symbole', true);   
                $place = $type = 'evenement' ? get_post_meta( $id_evenement, 'pr_places', true) : null;
                $client_nom=get_post_meta( $id_client, 'pr_nom', true) ;
                $client_prenom =get_post_meta( $id_client, 'pr_prenom', true) ;
                $client_mail =get_post_meta( $id_client, 'pr_mail', true) ;
                $client_tel =get_post_meta( $id_client, 'pr_tel', true) ;
                $date_on = date('Y-m-d');
                $date_on_debut = $ligne->date_debut;
                $date_on_fin = $ligne->date_fin;
        
        ?>
        
            <tr>
               <td></td>
                <td><?php echo $ID ?></td>    
                <td>
                  <div class="ib_date_create"> 
                    <?php echo $created_on?>
                  </div>
                </td>
                <td>
                  <div class=""> 
                    <?php echo $image?>
                  </div>
                </td>
                <td><?php echo $title?> </td>
                <td>
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
                    
                </td>
                <td>
                    <div class="ib_date_details">    
                        <span class="ib_date_name"><?php _e('Debut','instant_booking')  ?>:</span><span class="ib_date_value"> <?php echo $date_debut?> </span></br>
                        <span class="ib_date_name"><?php _e('Fin','instant_booking')  ?> : </span><span class="ib_date_value"><?php echo  $date_fin;?></span></br>
                        <span class="ib_date_name"><?php _e('Durée','instant_booking')  ?>: </span><span class="ib_date_value"><?php echo  strval(get_post_meta( 404, 'pr_mail', true));"3jours"?> </span>
                        
                    </div>
                </td>
                <td>
                    <div class="ib_date_details">    
                        <span class="ib_date_name"><?php _e('Depart','instant_booking')  ?>:</span><span class="ib_date_value"> <?php echo $depart?> </span></br>
                        <span class="ib_date_name"><?php _e('Depot','instant_booking')  ?> : </span><span class="ib_date_value"><?php echo  $depot;?></span></br>
                   </div>
                </td>
                <td><?php 
                foreach($extras as $extra){?>
                  <div class="ib_date_details">    
                    <span class="ib_date_value"><i class="fas fa-check text-success "></i>
                    <?php echo esc_html(get_term_by( 'term_id',$extra,'extra')->name) ?> </span></br>
                  </div>
                <?php } ?>
                </td>
                  <!-- <td><?php echo $prix_base;echo $devise;?></td> -->
                <td class="text-danger"> 
                  <span class="fw-bold"> <?php echo $prix_total;echo $devise;?>
                  <i class="fa fa-money-bill-wave"></i>
                  </span>
                </td>
                <td>
                  <div class="appointment-status-icon ml-3" >
                    <?php if($status == "2"){?>
                        <i style="color: #ffbb44 ;background-color: #fd9b782b" class="far fa-clock Ib_payement_book" aria-hidden="true">
                        <input type="hidden" value="<?php echo $ID ?>"></i>
                    <?php }else if($status == "8"){?>
                        <i style="color: #53d56c; background-color: #53d56c2b" class="fas fa-check" aria-hidden="true"></i>
                    <?php } ?>
                  </div>    
                </td>
                <td>
                    <span class="dropdown" style="display: inline"> 
                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="sr-only">Toggle Dropleft</span>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item ib_annuleBtn" href="#"><?php _e('Annuler','instant_booking')  ?></a>
                            <!-- <a class="dropdown-item" href="#">Another action</a> -->
                        </div> 
                    </span>
                    <?php
                     if($etat == "0"){?>
                        <label class="badge badge-danger ib_approuveBtn" data-val ="<?php echo $ID ?>">
                            <?php _e('En Attente','instant_booking')  ?>
                            <input type="hidden" value="<?php echo $ID ?>">
                        </label>
                    <?php }else if($status == "8" && $etat == "7" || $etat == "7"){?>
                        <label class="badge badge-success "><?php _e('Approuvé','instant_booking') ?>
                        <input type="hidden" value="<?php echo $ID ?>"></label>

                         <?php  if ($etat == "7" && ($date_on >= $date_on_debut && $date_on_fin >= $date_on)){?>                 
                           <label class="badge badge-warning"style="display:block"><?php _e('En cours','instant_booking')?>
                        <?php } ?>
                    <?php }else if ($etat == "7" && $date_on_fin <= $date_on){?>

                        <label class="badge badge-primary "><?php _e('Complété','instant_booking')?></label>
                        <?php  if ($etat == "9"){?>                 
                           <label class="badge badge-info " style="display:block"><?php _e('Confirmé','instant_booking')?></label>
                        <?php }else{?>
                            <label class="badge badge-danger ib_actionBtn " style="display:block"><?php  _e('Non confirmé','instant_booking')?>
                            <input type="hidden" value="<?php echo $ID ?>"></label>
                        <?php } ?>                  
                    <?php }else if ($etat == "21"){?>
                        <label class="badge badge-secondary "><?php _e('rejete' ,'instant_booking')?>
                    <?php }else {?>
                        <label class="badge ib_Btn"><?php _e('Annulé','instant_booking')?>
                    <?php } ?>
                    
                </td>
                <!-- <td class="text-right show"> 
                  <i class="fa fa-eye-slash row_is_disabled"></i>
                  <span class="actions_btn" data-toggle="dropdown" aria-haspopup="false" aria-expanded="true">
                    <i class="fa fa-ellipsis-h"></i>
                  </span>
                  <div class="dropdown-menu dropdown-menu-right row-actions-area show" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-116px, 52px, 0px);">
                    <button class="dropdown-item datatable_action_btn" data-action="info" type="button">Info</button>
                    <button class="dropdown-item datatable_action_btn" data-action="edit" type="button">Edit</button>
                    <button class="dropdown-item datatable_action_btn" data-action="delete" type="button">Delete</button>
                  </div>
                </td> -->
            </tr>
            
        <?php }?>
        
          </tbody>
        </table>
        
      </div>
    </div>
       
  
</div>

