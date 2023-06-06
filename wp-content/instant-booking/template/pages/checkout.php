<?php
  if( isset(get_option('Payments_Settings')['Parametre_payement'] ) || isset(get_option('Payments_Settings')['Parametre_​nombre_decimales'] ) || isset(get_option('Payments_Settings')['Parametre_separateur_prix'] ) || isset(get_option('Payments_Settings')['Parametre_devise'] ) || isset( get_option('reservation_settings')['Parametre_mode_reservation'] ) ) {
    $devise = esc_html( get_option('Payments_Settings')['Parametre_devise']  );
    $mode = esc_html(get_option('reservation_settings')['Parametre_mode_reservation']);
    $separateur = esc_html(get_option('Payments_Settings')['Parametre_separateur_prix']); 
    $position_symbole = esc_html(get_option('Payments_Settings')['Parametre_separateur_prix']); 
    $decimales = intval(esc_html(get_option('Payments_Settings')['Parametre_​nombre_decimales']));  
  
  }
 $id_service = $_GET['id'];
 $taxes = tentee_taxe_select_all(); 
 $totalTaxes  = 0;
  foreach($taxes as $taxe){ 
    $totalTaxes +=  $taxe->price ;
  }

?>

<div class=" bg-light p-5" id="IB_checkout_page">
    <div class="py-5 text-center"><h2><?php _e('Checkout', 'instant_booking')?></h2></div>
    <input type="hidden" class="ib_settings"data-separate="<?php echo $separateur ?>" data-decimal="<?php echo $decimales ?>">
        
    <div class="row g-5">
      <div class="col-md-5 order-md-2 mb-4">
        <h2 class="d-flex justify-content-between align-items-center m-3">
          <span class=""><?php _e('Votre Panier', 'instant_booking')?></span>
        </h2>
        <ul class="list-group mb-3">
         <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h5 class="my-0"><?php _e('Service', 'instant_booking')?></h5>
            </div>
            <h5><?php _e('Total', 'instant_booking')?></h5>
            
          </li>
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class=" ib_checkout_service"><?php echo esc_html(get_post($id_service)->post_title); ?></h6>
              <small class="text-muted"><span class="text-muted ib_checkout_unique_price"> </span> jours</small>
            </div>
            <p><span class="text-muted ib_checkout_unique_total"></span> <?php echo $devise ?></p>
            
          </li>
          <div class="ib_all_extra">

          </div>
          <li class="list-group-item d-flex justify-content-between ">
            <h6><?php _e('Taxes', 'instant_booking')?></h6>
            <p><strong class="ib_checkout_taxes_price"></strong>
            <span>%</span></p>
            
          </li>
          <li class="list-group-item d-flex justify-content-between bg-light">
            <div class="text-success">
              <h6 class="my-0">Promo code</h6> 
            </div>
            <span class="text-success"> - <span class="ib_checkout_coupon">0 </span><?php echo $devise ?></span>
          </li>
          <li class="list-group-item list-group-item-primary d-flex justify-content-between ">
            <strong><?php _e('Total', 'instant_booking')?> </strong>
            <p><strong class="ib_checkout_Total_price"></strong>
            <span><?php echo ' '.$devise?></span></p>
            
          </li>
        </ul>
        <form class="card p-2" id="ib_reduction_code">
          <div class="input-group">
            <input type="text" id="ib_promo_code" class="form-control" placeholder="Promo code">
            <div class="input-group-append">
              <button type="submit" class="btn btn-secondary">Reduire</button>
            </div>
          </div>
        </form>
        
      </div>
      <div class="col-md-7 order-md-1">
      <h4 class="mb-3"><?php echo esc_html(get_post($id_service)->post_title); ?></h4>
      <div class="ib_details_contains row g-3">
        <div class="ib_details_img col-md-6">
          <div class="bd-placeholder-img card-img-top "><?php echo get_the_post_thumbnail( $id_service );?></div>         
        </div>
        <div class="ib_details_content col-md-6">
          <div class="ib_details_date">      
          </div>
          <div class="ib_details_others"></div>
        </div>
      </div>

        <h2 class="mb-3"><?php _e('Informations du clients', 'instant_booking')?></h2>
        <form class="needs_validation" id="ib_payement_form" method="POST">
          <div class="row g-3">
            <div class="col-sm-6">
              <label for="IB_firstName" class="form-label"><?php _e('Nom', 'instant_booking')?></label>
              <input type="text" class="form-control" id="IB_firstName" placeholder="" value="" required>
            </div>

            <div class="col-sm-6">
              <label for="IB_lastName" class="form-label"><?php _e('Prenom', 'instant_booking')?></label>
              <input type="text" class="form-control" id="IB_lastName" placeholder="" value="" required>
            </div>

          
           <div class="col-12">
              <label for="IB_email" class="form-label"><?php _e('Email', 'instant_booking')?> <span class="text-muted">(required)</span></label>
              <input type="email" class="form-control" id="IB_email" placeholder="you@example.com" required>
            </div> 
            <div class="col-12">
              <label for="IB_address" class="form-label"><?php _e('Address', 'instant_booking')?><span class="text-muted">(Optional)</span></label>
              <input type="text" class="form-control" id="IB_address" placeholder="1234 Main St" >
            </div>

            <div class="col-12">
              <label for="IB_telephone" class="form-label"><?php _e('Telephone', 'instant_booking')?><span class="text-muted">(Optional)</span></label>
              <input type="tel" class="form-control" id="IB_telephone" placeholder=" ">
            </div>

            <div class="col-md-5">
              <label for="IB_pays" class="form-label"><?php _e('Pays', 'instant_booking')?></label>
              <input type="text" class="form-control" id="IB_pays" placeholder="United States">
            </div>

            <div class="col-md-4">
              <label for="IB_ville" class="form-label"><?php _e('State', 'instant_booking')?></label>
              <input type="text" class="form-control" id="IB_ville" placeholder="California">
            </div>

            <div class="col-md-3">
              <label for="IB_zip" class="form-label"><?php _e('Code Postal', 'instant_booking')?></label>
              <input type="text" class="form-control" id="IB_zip" placeholder="" required>
            </div>   

            <div class="col-md-12">
              <label for="IB_note" class="form-label"><?php _e('Note', 'instant_booking')?></label>
              <textarea class="form-control" id="IB_note"></textarea>
            </div>

          </div>
          
  <?php if( isset(get_option('Payments_Settings')['Parametre_payement'] )){ ?>

         
       <div id="container_payment">
          <hr class="my-4">

          <h4 class="mb-3">Payment</h4> 

           <!-- <div class="my-3 ib_payment">
             <div class="card ">
                <div class="card-header ib_payment">
                    <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                   
                        <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                            <li class="nav-item"> <a data-toggle="pill" href="#credit-card" class="nav-link active "> <i class="fas fa-credit-card mr-2"></i> Credit Card </a> </li>
                            <li class="nav-item"> <a data-toggle="pill" href="#paypal" class="nav-link "> <i class="fab fa-paypal mr-2"></i> Paypal </a> </li>
                             <li class="nav-item"> <a data-toggle="pill" href="#net-banking" class="nav-link "> <i class="fas fa-mobile-alt mr-2"></i> Net Banking </a> </li>
                        </ul>
                    </div>   
                    <div class="tab-content">
                         
                        <div id="credit-card" class="tab-pane fade show active pt-3">
                            <form role="form" onsubmit="event.preventDefault()">
                               
                                <div class="form-group"> <label for="cardNumber">
                                        <h6>Card number</h6>
                                    </label>
                                    <div class="input-group">
                                       <input type="text" class="form-control" id="ib_cc_number" value="4242 4242 4242 4242" name="ib_cc_number" size="20" autocomplete="on" placeholder="1234 5678 9012 3456" required>
             
                                        <div class="input-group-append"> <span class="input-group-text text-muted"> <i class="fab fa-cc-visa mx-1"></i> <i class="fab fa-cc-mastercard mx-1"></i> <i class="fab fa-cc-amex mx-1"></i> </span> </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group"> <label><span class="hidden-xs">
                                                    <h6>Expiration Date</h6>
                                                </span></label>
                                            <div class="input-group"> 
                                               <input type="number" class="form-control" name="ib_cc_cvv" value="123"  id="ib_cc_cvv" size="4" autocomplete="off" placeholder="123" required>
                                               <input type="number" class="form-control" id="ib_cc_expiration"  value="12" name="ib_cc_expiration" size="2" placeholder="MM" required>
            
                                                <input type="number" placeholder="YY" name="" class="form-control" required> </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group mb-4"> <label data-toggle="tooltip" title="Three digit CV code on the back of your card">
                                                <h6>CVV <i class="fa fa-question-circle d-inline"></i></h6>
                                            </label> <input type="text" required class="form-control"> </div>
                                    </div>
                                </div>
                                <div class="card-footer"> <button type="button" class="subscribe btn btn-primary btn-block shadow-sm"> Confirm Payment </button>
                            </form>
                        </div>
                    </div>  
                     
                    <div id="paypal" class="tab-pane fade pt-3">
                        <h6 class="pb-2">Select your paypal account type</h6>
                        <div class="form-group "> <label class="radio-inline"> <input type="radio" name="optradio" checked> Domestic </label> <label class="radio-inline"> <input type="radio" name="optradio" class="ml-5">International </label></div>
                        <div id="paypal-button-container"></div>
                        <p> <button type="button" class="btn btn-primary "><i class="fab fa-paypal mr-2"></i> Log into my Paypal</button> </p>
                        <p class="text-muted"> Note: After clicking on the button, you will be directed to a secure gateway for payment. After completing the payment process, you will be redirected back to the website to view details of your order. </p>
                    </div> End -->
                    <!-- bank transfer info -->
                    <!-- <div id="net-banking" class="tab-pane fade pt-3">
                        <div class="form-group "> <label for="Select Your Bank">
                                <h6>Select your Bank</h6>
                            </label> <select class="form-control" id="ccmonth">
                                <option value="" selected disabled>--Please select your Bank--</option>
                                <option>Bank 1</option>
                                <option>Bank 2</option>
                                <option>Bank 3</option>
                                <option>Bank 4</option>
                                <option>Bank 5</option>
                                <option>Bank 6</option>
                                <option>Bank 7</option>
                                <option>Bank 8</option>
                                <option>Bank 9</option>
                                <option>Bank 10</option>
                            </select> </div>
                        <div class="form-group">
                            <p> <button type="button" class="btn btn-primary "><i class="fas fa-mobile-alt mr-2"></i> Proceed Payment</button> </p>
                        </div>
                        <p class="text-muted">Note: After clicking on the button, you will be directed to a secure gateway for payment. After completing the payment process, you will be redirected back to the website to view details of your order. </p>
                    </div>  
                </div>
             </div>
          </div> --> 
            <div class="" id="ib_payment_message"  role="alert">
                 
            </div>
          <div class="row gy-3">
          
            <div class="col-md-6">
              <label for="ib_cc_number" class="form-label">Credit card number</label>
              <input type="text" class="form-control" id="ib_cc_number" value="4242 4242 4242 4242" name="ib_cc_number" size="20" autocomplete="on" required>
              <div class="invalid-feedback">
                Credit card number is required
              </div>
            </div>
            <div class="col-md-3">
              <label for="ib_cc_cvv" class="form-label">CVV</label>
              <input type="text" class="form-control" name="ib_cc_cvv" value="123"  id="ib_cc_cvv" size="4" autocomplete="on" required>
              <div class="invalid-feedback">
                Security code required
              </div>
            </div>

            <div class="col-md-3">
              <label for="ib_cc_expiration" class="form-label">Mois d'Expiration</label>
              <input type="text" class="form-control" id="ib_cc_expiration" name="ib_cc_expiration" size="2" placeholder="MM" value="12" required>
              <div class="invalid-feedback">
                Expiration date required
              </div>
            </div>

            <div class="col-md-3">
              <label for="ib_year_expiration" class="form-label">Année d'expiration</label>
              <input type="text" class="form-control" id="ib_year_expiration" name="ib_year_expiration" size="4" placeholder="YYYY" value="2022" required>
              <div class="invalid-feedback">
                Expiration date required
              </div>
            </div>

          </div>
        </div>

        <?php  }else{ ?>
           
       <?php }?>
          
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="save-info"  required>
            <label class="form-check-label" for="save-info"><a href="<?php echo esc_url(get_permalink(get_page_by_path( 'privacy-policy' ))) ?>">J'accepte les conditions de location du site</a></label>
          </div>

          <button class="btn btn-primary  my-3 ib_confirme_reservation" type="submit"><?php _e('Confirme La Commande', 'instant_booking')?></button>
          
        </form>
      </div>
    </div>
  </div>

 <?php
 

 ?>