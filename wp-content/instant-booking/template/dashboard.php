
<?php
global $wpdb;

if( isset( get_option('Payments_Settings')['Parametre_devise'] ) || isset( get_option('reservation_settings')['Parametre_mode_reservation'] ) ) {
  $devise = esc_html( get_option('Payments_Settings')['Parametre_devise']  );
  $mode = esc_html(get_option('reservation_settings')['Parametre_mode_reservation']);
}
?>
  <div class="wrap">

  </div>
  <div class="main-panel">
    <div class="content-wrapper my-2">
    <div class="row">
          <div class="col-lg-12 grid-margin stretch-card ">
                <div class="d-flex flex-row  align-items-center px-3 justify-content-between">
                    
                     
                </div>
            </div>
          </div>
    </div>
    <div class="body-wrapper">
    <div class="breadcome-area">
        <div class="header-advance-area">
            <div class="container-fluid">
              <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <div class="breadcome-list">
                          <div class="row">
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                 <div class=" ib-part1">
                                       <div class="ib-logo">
                                        <img width="100" src="<?php echo $logoInstant;?>" class="logo-big"> 
                                       </div> 
                                       <H4>Instant Booking</H4>
                                  </div> 
                              </div>
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                  <div class="breadcome-menu">
                                     <span class="bread-blod ariane"><?php _e('Tableau de bord', 'instant_booking')?></span>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
            </div>
        </div>
        <?php 
             //////////////////////// la quantité
              $nbr = tentee_reservation_count(); 
              $Napprouve =  tentee_reservation_count_etat(7);
              $Nrejete =  tentee_reservation_count_etat(21) ;
              $Ncours =  tentee_reservation_count_etat(15) ;
            //   $Nsupprime =  tentee_reservation_count_etat(28) ;
              $Ncomplete =  tentee_reservation_count_etat(9) ;
              $Nattente =  tentee_reservation_count_etat(0) ;
              $paye =  tentee_reservation_count_statut(8) ;
              $paspaye =  tentee_reservation_count_statut(2) ;
              $query = new WP_Query( array('post_type'=> 'client') );
              $totalclient = $query->found_posts; 

              //////////////////////// les pourcentages
              $Papprouve = $Napprouve != 0 ? ($Napprouve*100)/$nbr : 0;
              $Pattente =$Nattente != 0 ? ($Nattente*100)/$nbr : 0;
              $Prejete =$Nrejete != 0 ? ($Nrejete*100)/$nbr : 0;
            //   $Psupprime =$Nsupprime != 0 ?  ($Nsupprime*100)/$nbr : 0;
              $Pcomplete = $Ncomplete != 0 ? ($Ncomplete*100)/$nbr : 0;
              
       ?>

       <!-- <h2>
            <?php //echo sprintf( _n( '%s commentaire', '%s commentaires', $comment_count ),
            // $comment_count) ?>
       
        </h2> -->
        
        <div class="all-content-wrapper">
            <div class="analytics-sparkle-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="analytics-sparkle-line reso-mg-b-30">
                                <div class="analytics-content">
                                    <h5><?php _e('Reservations', 'instant_booking')?></h5>
                                    <h2><span class="counter"><?php  echo esc_html( $nbr ); ?></h2>
                                    <div class="progress m-b-0">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:20%;"> <span class="sr-only">20% Complete</span> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="analytics-sparkle-line reso-mg-b-30">
                                <div class="analytics-content">
                                    <h5><?php _e('Payée(s)', 'instant_booking')?></h5>
                                    <h2><span class="counter"><?php  echo esc_html( $paye ); ?></h2>
                                    <div class="progress m-b-0">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:30%;"> <span class="sr-only">230% Complete</span> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="analytics-sparkle-line table-mg-t-pro dk-res-t-pro-30">
                                <div class="analytics-content">
                                    <h5><?php _e('En attente de payement', 'instant_booking')?></h5>
                                    <h2><span class="counter"><?php  echo esc_html( $paspaye ); ?></h2>
                                    <div class="progress m-b-0">
                                        <div class="progress-bar progress-bar-inverse" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:80%;"> <span class="sr-only">230% Complete</span> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="analytics-sparkle-line reso-mg-b-30 table-mg-t-pro dk-res-t-pro-30">
                                <div class="analytics-content">
                                    <h5><?php _e('Nombres De Client(s)', 'instant_booking')?></h5>
                                    <h2><span class="counter"><?php  echo esc_html( $totalclient ); ?></h2>
                                    <div class="progress m-b-0">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:60%;"> <span class="sr-only">20% Complete</span> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-sales-area mg-tb-30">
            <!-- <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="product-sales-chart">
                            <div class="portlet-title">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="caption pro-sl-hd">
                                            <span class="caption-subject"><b><?php _e('Revenue', 'instant_booking')?></b></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="actions graph-rp graph-rp-dl">
                                            <p>All Earnings are in million $</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <ul class="list-inline cus-product-sl-rp">
                                <li>
                                    <h5><i class="fa fa-circle" style="color: #006DF0;"></i>CSE</h5>
                                </li>
                                <li>
                                    <h5><i class="fa fa-circle" style="color: #933EC5;"></i>Accounting</h5>
                                </li>
                                <li>
                                    <h5><i class="fa fa-circle" style="color: #65b12d;"></i>Electrical</h5>
                                </li>
                            </ul>
                            <div id="extra-area-chart" style="height: 356px;"></div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
        <div class="traffice-source-area mg-b-30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="white-box analytics-info-cs">
                            <h3 class="box-title"><?php _e('Approuvé', 'instant_booking')?></h3>
                            <ul class="list-inline two-part-sp">
                                <li>
                                    <div id="sparklinedash"></div>
                                </li>
                                <li class="text-right sp-cn-r"><i class="fa fa-level-up" aria-hidden="true"></i> <span class="counter text-success"><span class="counter"><?php  echo esc_html( $Napprouve ); ?></span></span></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="white-box analytics-info-cs res-mg-t-30 table-mg-t-pro-n">
                            <h3 class="box-title"><?php _e('En Attente', 'instant_booking')?></h3>
                            <ul class="list-inline two-part-sp">
                                <li>
                                    <div id="sparklinedash2"></div>
                                </li>
                                <li class="text-right graph-two-ctn"><i class="fa fa-level-up" aria-hidden="true"></i> <span class="counter text-purple"><span class="counter"><?php  echo esc_html( $Nattente ); ?></span></span></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="white-box analytics-info-cs res-mg-t-30 res-tablet-mg-t-30 dk-res-t-pro-30">
                            <h3 class="box-title"><?php _e('Rejété', 'instant_booking')?></h3>
                            <ul class="list-inline two-part-sp">
                                <li>
                                    <div id="sparklinedash3"></div>
                                </li>
                                <li class="text-right graph-three-ctn"><i class="fa fa-level-up" aria-hidden="true"></i> <span class="counter text-purple"><span class="counter"><?php  echo esc_html( $Nrejete ); ?></span></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="white-box analytics-info-cs res-mg-t-30 res-tablet-mg-t-30 dk-res-t-pro-30">
                            <h3 class="box-title"><?php //_e('Annulé', 'instant_booking')?></h3>
                            <ul class="list-inline two-part-sp">
                                <li>
                                    <div id="sparklinedash4"></div>
                                </li>
                                <li class="text-right graph-four-ctn"><i class="fa fa-level-down" aria-hidden="true"></i> <span class="text-danger"><span class="counter"><?php  //echo esc_html( $Nsupprime ); ?></span></span>
                                </li>
                            </ul>
                        </div>
                    </div> -->
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="white-box analytics-info-cs res-mg-t-30 res-tablet-mg-t-30 dk-res-t-pro-30">
                            <h3 class="box-title"><?php _e('Complète', 'instant_booking')?></h3>
                            <ul class="list-inline two-part-sp">
                                <li>
                                    <div id="sparklinedash5"></div>
                                </li>
                                <li class="text-right graph-two-ctn"><i class="fa fa-level-up" aria-hidden="true"></i> <span class="text-purple"><span class="counter"><?php  echo esc_html( $Ncomplete ); ?></span></span></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="courses-area mg-b-15">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="white-box">
                                <h3 class="box-title"><?php _e('Status Des Reservations', 'instant_booking')?> </h3>
                                <ul class="basic-list">
                                    <li><?php _e('Approuvé', 'instant_booking')?> <span class="pull-right badge rounded-pill bg-danger label-1 label"><?php  echo esc_html( round($Papprouve, 1) ); ?>%</span></li>
                                    <li><?php _e('En Attente', 'instant_booking')?><span class="pull-right badge rounded-pill bg-info text-dark label-2 label"><?php  echo esc_html( round($Pattente, 1) ); ?>%</span></li>
                                    <li><?php _e('Rejeté', 'instant_booking')?><span class="pull-right badge rounded-pill bg-warning text-dark label-5 label"><?php  echo esc_html( round($Prejete, 1) ); ?>%</span></li>
                                    <!-- <li><?php// _e('Annulé', 'instant_booking')?><span class="pull-right badge rounded-pill bg-primary label-4 label"><?php  //echo esc_html( round($Psupprime, 1) ); ?>%</span></li> -->
                                     <!-- <li><?php //_e('Approuve', 'instant_booking')?><span class="pull-right badge rounded-pill bg-primary label-4 label"><?php  //echo esc_html( round($Psupprime, 1) ); ?>%</span></li> -->
                                  <li><?php _e('Complete', 'instant_booking')?><span class="pull-right badge rounded-pill bg-success label-3 label"><?php  echo esc_html( round($Pcomplete, 1) ); ?>%</span></li>
                                 </ul>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="single-review-st-item res-mg-t-30 table-mg-t-pro-n">
                            <div class="single-review-st-hd">
                                <h2><?php _e('Reservations en cours', 'instant_booking')?></h2>
                            </div>
                            <?php  $all = tentee_reservation_En_cours(); 
                            if( $all != null){                                    
                                foreach($all as $ligne){
                                    
                                    $ID = intval($ligne->id);               
                                    $id_service = intval($ligne->id_service);
                                    $prix_base = intval($ligne->prix_base);
                                    $prix_total = intval($ligne->prix_Total) ;
                                    $date_debut = fandates($ligne->date_debut) ;
                                    $date_fin = fandates($ligne->date_fin) ;
                                    $title= get_post($id_service)->post_title ;   
                                    $image = get_the_post_thumbnail($id_service ,array( 100, 100));
                                    $prix_unique = get_post_meta( $id_service, 'serv_prix', true);
                                  
                                    ?>
                                    <div class="single-review-st-text">
                                    
                                        <div><?php  echo  $image ; ?></div>
                                        <div class="review-ctn-hf">
                                            <h3><?php  echo esc_html( $title ); ?></h3>
                                            <p><?php  echo esc_html( $prix_total ).''.$devise; ?></p>
                                        </div>
                                        <div class="review-item-rating">
                                            <div class="badge bg-danger  " style="display: block">
                                            <span class="c"><?php _e('Debut', 'instant_booking')?> : </span>
                                            <span class="c"><?php  echo esc_html( $date_debut ); ?></span>
                                            </div>
                                            <div class="badge bg-info text-dark my-1" >
                                            <span class="c"><?php _e('Fin', 'instant_booking')?> : </span>
                                            <span class="c"><?php  echo esc_html( $date_fin ); ?></span>
                                        </div>
                                        </div>
                                    </div>
                               <?php }
                               }else{
                                ?>
                                <div class="white-box analytics-info-cs res-mg-t-30 res-tablet-mg-t-30 dk-res-t-pro-30">
                                    <p class="box-title"><?php _e('Aucune réservation trouvée', 'instant_booking')?></p>
                                </div>
                             <?php    }   ?>
                        
                                                      
                        </div>
                    </div>
          
                    </div>
                </div>
            </div>

              <div class="data-table-area mg-b-15">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="sparkline13-list">
                                <div class="sparkline13-hd">
                                    <div class="main-sparkline13-hd">
                                        <h1>Historiques<span class="table-project-n"> Des</span> Actions</h1>
                                    </div>
                                </div>
                                <div class="sparkline13-graph">
                                    <div class="datatable-dashv1-list custom-datatable-overright">
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
                                                    <th data-field="name" data-editable="true">Date</th>
                                                    <th data-field="email" data-editable="true">Tâche</th>
                                                    <th data-field="date" data-editable="true">Element</th>
                                                    <th data-field="price" data-editable="true">Employe</th>
                                                    <!-- <th data-field="action">Action</th> -->
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
                                                    $created_on = fandatestime($ligne->created_on);
                                                    $user_mail =  get_userdata($id_employe )->user_email; 
                                                    $users_last_name = get_user_meta( $id_employe , 'last_name', true);
                                                    $users_first_name = get_user_meta( $id_employe , 'first_name', true);
                                                    $users_phone = get_user_meta( $id_employe , 'user_phone', true);

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
                                                            $employe_mail = get_userdata( $id_element)->user_mail;
                                                            $employe_last_name = get_user_meta( $id_element , 'last_name', true);
                                                            $employe_first_name = get_user_meta( $id_element , 'first_name', true);
                                                            $employe_phone = get_user_meta( $id_element , 'user_phone', true);
                                                         }
                                                    }else{
                                                         $title= 'inconnu';
                                                    }

                                                    

                                                ?>
                                                <tr>
                                                    <td></td>
                                                    <td><?php echo $ID ; ?></td>
                                                    <td><?php echo $created_on; ?></td>
                                                    <td><?php echo $action; ?></td>
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
                                                                    <div class="circle_image"><img src=" <?php echo $blankPicture;?>"></div>
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
                                                                    <div class="circle_image"><img src=" <?php echo $blankPicture;?>"></div>
                                                                    <div class="ib_user_details">
                                                                        <span><?php echo $employe_first_name ?> <?php echo $employe_last_name ?> </span>
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
                                                                <div class="circle_image"><img src=" <?php echo $blankPicture;?>"></div>
                                                                <div class="ib_user_details">
                                                                    <span><?php echo $users_last_name ?> <?php echo $users_first_name ?> </span>
                                                                    <span> <?php echo $users_phone?> </span>
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
                        </div>
                    </div>
                </div>
            </div>

            
            
        </div>

  
    </div>
   

  </div>




