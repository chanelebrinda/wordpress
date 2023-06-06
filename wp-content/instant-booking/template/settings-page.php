
<div class="wrap " style="background-color: #fff">

 <div class="d-flex flex-row  align-items-center  justify-content-between p-3">
    <div class="d-flex flex-row  align-items-center border-end  ib-part1">
      <div class="ib-logo">
          <img width="100" src="<?php echo $logoInstant;?>" class="logo-big"> 
      </div> 
      <H4>Instant Booking</H4>
    </div> 
      <div class="d-flex">
        <div class="breadcome-menu">
            <span class="bread-blod ariane"><?php _e(get_admin_page_title())?></span>
        </div>
      </div>
  </div>
  <hr>

   <?php settings_errors(); 

     if( isset( get_option('Payments_Settings')['Parametre_devise'] ) || isset( get_option('reservation_settings')['Parametre_mode_reservation'] ) ) {
      $devise = esc_html( get_option('Payments_Settings')['Parametre_devise']  );
      $mode = esc_html(get_option('reservation_settings')['Parametre_mode_reservation']);
    }?>
   <?php// esc_html_e( get_admin_page_title() ); ?>
   <ul class="nav nav-tabs " style="background-color: #fff">
      <li class="active"><a href="#tab-1"><?php _e('General', 'instant_booking')?> </a></li>
      <li><a href="#tab-2"> <?php _e('Paiement', 'instant_booking')?></a></li>
      <li><a href="#tab-3"><?php _e('Reservation', 'instant_booking')?></a></li>
      <li><a href="#tab-4"><?php _e('Shortcode', 'instant_booking')?></a></li>
      <li><a href="#tab-5"><?php _e('Taxes', 'instant_booking')?></a></li>
      <li><a href="#tab-6"><?php _e('Coupons', 'instant_booking')?></a></li>
      <li><a href="#tab-7"><?php _e('Design', 'instant_booking')?></a></li>
    </ul>

  <div class="tab-content">

    <div class="tab-pane active" id="tab-1">

        <form method="post" action="options.php">
          <!-- Display necessary hidden fields for settings -->
          <?php 
              settings_fields( 'Tentee_reservation_settings' );
              // Display the settings sections for the page 
              do_settings_sections( 'Tentee_general' );
            
              submit_button( null,'primary','submit',true,['id'=>'pw_button'] );
            ?>
        </form>

    </div>

    <div class="tab-pane " id="tab-2">
        <form method="post" action="options.php">
          <!-- Display necessary hidden fields for settings -->
          <?php 
              settings_fields( 'Tentee_Payments_Settings' );
              // Display the settings sections for the page 
              do_settings_sections( 'Tentee_Payments' );
            
              submit_button( null,'primary','submit',true,['id'=>'pw_button'] );
            ?>
        </form>
    </div>

    <div class="tab-pane " id="tab-3">
        <form method="post" action="options.php">
          <!-- Display necessary hidden fields for settings -->
          <?php 
              settings_fields( 'Tentee_Settings_Reservation' );
              // Display the settings sections for the page 
              do_settings_sections( 'Reserve_Settings' );
              
              submit_button( null,'primary','submit',true,['id'=>'pw_button'] );
            ?>
        </form>
    </div> 
    <div class="tab-pane" id="tab-4">
      <h2> liste des shorcodes </h2>
      <hr>
        <div class="row">
          <p class="col-4">Page des archives services </p>
          <span class="col-7">[IB_all_services]</span>
        </div>
        <div class="row">
          <p class="col-4">Block des services </p>
          <span class="col-7">[IB_list_services]</span>
        </div>
        <div class="row">
          <p class="col-4">Page Checkout </p>
          <span class="col-7">[IB_checkout]</span>
        </div>
        <div class="row">
          <p class="col-4">Block de categorie' des services</p>
          <span class="col-7">[IB_Categorie]</span>
        </div>
        
    </div> 
    <div class="tab-pane " id="tab-5">
      <?php
     $taxes = tentee_taxe_select_all();
      ?>
      
     
  <h3><?php _e('Taxes', 'instant_booking')?></h3>
     <div class="col-lg-6 col-md-6 col-sm-6">
         <hr>
      </div>
     <div class="subhead-event row ">
     
        <h4 class="clix col-md-12"><?php _e('Enregistrer les taxes', 'instant_booking')?></h4> 
    </div>
    
    
    <div class=" row ib_taxes_block">
       <div class="col-lg-4 col-md-3 col-sm-3 ib_add_element">
          <i class="fas fa-plus"></i>
          <span class="ib-add-day-off"><?php _e('Ajouter une taxe', 'instant_booking')?></span>
       </div>
       <div class="col-lg-6 col-md-6 col-sm-9">
          <form class="ib_form_add">
            <div class="">
              <label for="nom_taxe" class="form-label"><?php _e('Nom taxe', 'instant_booking')?></label>
              <input type="text" class="form-control" id="nom_taxe" required>
            </div>
            <div class="">
              <label for="value_taxe" class="form-label"><?php _e('Value taxe', 'instant_booking')?></label>
              <input type="text" class="form-control" id="value_taxe" required>
            </div>
            <div class="col-12 my-3">
              <button class="btn btn-primary submit_taxe" type="submit"><?php _e('Ajouter', 'instant_booking')?></button>
              <button class="btn btn-secondary annuler_taxe" type="button"><?php _e('Annuler', 'instant_booking')?></button>
            </div>
         </form>

          <form class="ib_form_update">
            <div class="">
              <label for="n_taxe" class="form-label"><?php _e('Nom taxe', 'instant_booking')?></label>
              <input type="text" class="form-control" id="n_taxe" required>
            </div>
            <div class="">
              <label for="v_taxe" class="form-label"><?php _e('valeur taxe (en pourcentage)', 'instant_booking')?></label>
              <input type="text" class="form-control" id="v_taxe"  required>
            </div>
            <div class="col-12 my-3">
              <button class="btn btn-primary update_taxe" type="submit"><?php _e('Modifier', 'instant_booking')?></button>
              <button class="btn btn-secondary annuler_update_taxe" type="button"><?php _e('Annuler', 'instant_booking')?></button>
            </div>
            <input type="hidden" value="" class="ib_form_id_taxes">
          </form>
        </div>
    </div>

    <div class="col-6 col-md-8 col-sm-12 ib_display_taxes_container">
    <div id="ib_display_taxes_content">
     <?php  foreach($taxes as $taxe){ ?>
       <div class=" row ib_display_taxes">
          <div class="col-lg-4 col-md-6 col-sm-6  ib_display_nom">
            <span class=""><?php echo esc_html( $taxe->nom ) ;?></span>
          </div>
          <div class="col-lg-4 col-md-3 col-sm-2 ib_display_price">   
            <span class=""><?php echo esc_html( $taxe->price ) ;?>%</span>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-3 ib_display_action">
            <span class="ib_update_taxe" data-id="<?php echo esc_html( $taxe->id ) ;?>"><i class="fas fa-pen"></i></span>
            <span class="ib_delete_taxe" data-id="<?php echo esc_html( $taxe->id ) ;?>"><i class="fas fa-solid fa-trash"></i></span>
          </div>
       </div> 
     <?php } ?>
     </div> 
    </div>


    </div> 
    <div class="tab-pane " id="tab-6">
    <h3><?php _e('Coupons', 'instant_booking')?></h3>
      <div class="col-lg-6 col-md-6 col-sm-6">
         <hr>
      </div>
    
      <?php
     $coupons = tentee_coupon_select_all();
      ?>
      
     <div class="subhead-event row ">
     
        <h4 class="clix col-md-12"><?php _e('Enregistrer les coupons', 'instant_booking')?></h4> 
    </div>
    
    <div class="row ib_taxes_block">
       <div class="col-lg-4 col-md-3 col-sm-3 ib_add_coupon">
          <i class="fas fa-plus"></i>
          <span class="ib-add-day-off"><?php _e('Ajouter une coupon', 'instant_booking')?></span>
       </div>
       <div class="col-lg-6 col-md-6 col-sm-9">
          <form class="ib_coupon_add">
           <div class="row">
              <div class="col-lg-6">
                <label for="code_coupon" class="form-label"><?php _e('Nom coupon', 'instant_booking')?></label>
                <input type="text" class="form-control" id="code_coupon" required>
              </div>
              <div class="col-lg-6">
                <label for="date_coupon" class="form-label"><?php _e('Date d\'expiration', 'instant_booking')?></label>
                <input type="date" class="form-control" id="date_coupon" required>
              </div>
              <div class="col-md-12 pt-2 form-group">
                 <label for="deduction_coupon" class="form-label" ><?php _e('Déduction', 'instant_booking')?>(<?php echo $devise ?>)</label>
               
                  <div class="input-group "> 
                  <input type="text" class="form-control" id="deduction_coupon" required>
                    <select id="remise_coupon" class="form-select form-select-sm " aria-label=".form-select-sm example" required>
                      <option selected><?php _e('Selectionner', 'instant_booking')?></option>
                      <option value="deduction"> <?php _e('En monnaie', 'instant_booking') ; ?>(<?php echo $devise ?>)</option>
                      <option value="remise"><?php _e('En pourcentage', 'instant_booking')?></option>
                    </select>
                </div>
             </div>
              <div class="col-md-6">
                <label for="limitperson" class="form-label"><?php _e('Nombres limites de personnes', 'instant_booking')?></label>
                <input type="text" class="form-control" id="limitperson" required>
              </div>
           
          </div>
            <div class="col-12 my-3">
              <button class="btn btn-primary submit_coupon" type="submit"><?php _e('Ajouter', 'instant_booking')?></button>
              <button class="btn btn-secondary annuler_coupon" type="button"><?php _e('Annuler', 'instant_booking')?></button>
            </div>
            
         </form class="py-5">

          <form class="ib_coupon_update">
          <div class="row">
              <div class="col-md-6 pt-2">
                <label for="c_coupon" class="form-label"><?php _e('Nom coupon', 'instant_booking')?></label>
                <input type="text" class="form-control" id="c_coupon" required>
              </div>
              <div class="col-md-6 pt-2">
                <label for="d_coupon" class="form-label"><?php _e('Date d\'exporation', 'instant_booking')?></label>
                <input type="date" class="form-control" id="d_coupon" required>
              </div>
              <div class="col-md-12 pt-2 form-group">
                 <label for="d_coupon" class="form-label"><?php _e('Déduction', 'instant_booking')?>(<?php echo $devise ?>)</label>
                 <div class="input-group "> 
                    <input type="text" class="form-control " id="de_coupon" required> 
                    <select id="re_coupon" class="form-select form-select-sm " aria-label=".form-select-sm example" required>
                      <option selected><?php _e('Selectionner', 'instant_booking')?></option>
                      <option value="deduction"> <?php _e('En monnaie', 'instant_booking') ; ?>(<?php echo $devise ?>)</option>
                      <option value="remise"><?php _e('En pourcentage', 'instant_booking')?></option>
                    </select>
                </div>
             </div>
            <div class="col-md-6 pt-2">
              <label for="l-person" class="form-label"><?php _e('Nombres limites de personnes', 'instant_booking')?></label>
              <input type="text" class="form-control" id="l-person" required>
            </div>
          
          </div>
            <div class="col-12 my-6 p-2">
              <button class="btn btn-primary update_coupon" type="submit"><?php _e('Modifier', 'instant_booking')?></button>
              <button class="btn btn-secondary annuler_update_coupon" type="button"><?php _e('Annuler', 'instant_booking')?></button>
            </div>
            <input type="hidden" value="" class="ib_form_id_coupons">
          </form>
        </div>
    </div>

    <div class=" py-5 ib_display_coupons_container">
    <div id="ib_display_coupons_content" class="col-md-9">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col"><?php _e('Nom coupon', 'instant_booking')?></th>
            <th scope="col"><?php _e('Date d\'expiration', 'instant_booking')?></th>
            <th scope="col"><?php _e('Déduction', 'instant_booking')?></th>
            <th scope="col"><?php _e('Nombres limites de personnes', 'instant_booking')?></th> 
            <th scope="col"><?php _e('Actions', 'instant_booking')?></th>
          </tr>
        </thead>
        <tbody>
        <?php 
        $i = 1;
         foreach($coupons as $coupon){ ?>
          <tr>
            <th scope="row"><?php echo $i?></th>
            <td><?php echo esc_html( $coupon->code ) ;?></td>
            <td><?php echo esc_html( $coupon->date_fin ) ;?></td>
            <td><?php 
            if( $coupon->prix_pourcentage == "remise"){
               echo esc_html( $coupon->prix_monaie ).'%';
             }else{
              echo esc_html( $coupon->prix_monaie ).$devise;
            }?>
             </td>          
            <td><?php echo esc_html( $coupon->limitPersonne ) ;?></td>
            <td> 
                <span class="ib_update_coupon" data-id="<?php echo esc_html( $coupon->id ) ;?>"><i class="fas fa-pen"></i></span>
                <span class="ib_delete_coupon" data-id="<?php echo esc_html( $coupon->id ) ;?>"><i class="fas fa-solid fa-trash"></i></span>
            </td> 
          </tr>
          <?php $i++; }
          ?>
        </tbody>
      </table>
     
     
     </div> 
    </div>

    </div> 
    <div class="tab-pane " id="tab-7">
        <form method="post" action="options.php">
          <!-- Display necessary hidden fields for settings -->
          <?php 
              settings_fields( 'Tentee_Settings_design' );
              // Display the settings sections for the page 
              do_settings_sections( 'IB_design' );
              
              submit_button( null,'primary','submit',true,['id'=>'pw_button'] );
            ?>
        </form>
    </div> 

  </div>

</div>