
<?php get_header(); ?>

<div class="container-sm py-5">
<?php while ( have_posts() ) : the_post(); 

if( isset(get_option('Payments_Settings')['Parametre_​nombre_decimales'] ) || isset(get_option('Payments_Settings')['Parametre_separateur_prix'] ) ||  isset( get_option('Payments_Settings')['Parametre_devise'] ) || isset( get_option('reservation_settings')['Parametre_mode_reservation'] ) ) {
  $devise = esc_html( get_option('Payments_Settings')['Parametre_devise']  );
  $mode = esc_html(get_option('reservation_settings')['Parametre_mode_reservation']);
  $separateur = esc_html(get_option('Payments_Settings')['Parametre_separateur_prix']); 
  $position_symbole = esc_html(get_option('Payments_Settings')['Parametre_separateur_prix']); 
  $decimales = intval(esc_html(get_option('Payments_Settings')['Parametre_​nombre_decimales']));

}
$taxes = tentee_taxe_select_all();
$totalTaxes  = 0;
 foreach($taxes as $taxe){ 
   $totalTaxes +=  $taxe->price ;
 }
?>

 <div class="row">
    <div class="col-lg-8 p-3" style="background-color:#fff">
       <div class="col-md-6 ">
            <?php the_post_thumbnail('medium_large');?>
       </div>
      <h3 class="pb-4 mb-4 fst-italic border-bottom ib_title">
       <?php the_title(); ?>
      </h3>
       <p class="lead my-3"> <?php  the_content();  ?></p>

    </div>

    <div class="col-lg-4">
      <div  class="ib_grid_sidebar d-flex flex-column"  style="background-color:#fff">
      <?php $url  =  get_permalink(get_page_by_path( 'checkout' )) ; ?>
     
      <form name="checkout" method="post" class="ib_single_form"  action="<?php echo esc_url( add_query_arg( array('id'=>get_the_ID()) , $url)) ?>">
       
        <div class="ib_grid_priceunique text-center p-3" style="top: 2rem;">
        <input type="hidden" class="ib_priceUni" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'serv_prix',true) )?>" data-separate="<?php echo $separateur ?>" data-decimal="<?php echo $decimales ?>">
           <?php 
              if( $separateur == "virgule-point"){?>
                 <h4 class="fst-italic" > <span class="ib_price_set">  <?php echo number_format(get_post_meta( get_the_ID(), 'serv_prix',true),$decimales,".",",").$devise.' '.$mode; ?></span>        </h4>           
                <?php 
              }else if( $separateur == "point-virgule"){?>
               <h4 class="fst-italic" > <span class="ib_price_set">  <?php echo number_format(get_post_meta( get_the_ID(), 'serv_prix',true),$decimales,",",".").$devise.' '.$mode; ?></span>  </h4>                
                <?php 
              }else if( $separateur == "espace-dot"){?>
                <h4 class="fst-italic" >  <span class="ib_price_set">  <?php echo number_format(get_post_meta( get_the_ID(), 'serv_prix',true),$decimales,"."," ").$devise.' '.$mode; ?></span>  </h4>                         
                <?php 
              }else{?>
                <h4 class="fst-italic" ><span class="ib_price_set"> <?php echo number_format(get_post_meta( get_the_ID(), 'serv_prix',true),$decimales,","," ").$devise.' '.$mode; ?></span></h4>
                <?php 
              }
            ?>
          </div>  
        <div class="pt-4 px-4 rounded ib_grid_content">
          <input type="hidden" class="ib_input_content" value="<?php echo get_the_ID();?>">   
          <input type="hidden" class="ib_input_taxes" value="<?php echo $totalTaxes;?>">   
          
          <div class="d-flex flex-row" value="">
            <div class="ib-check-in col-6 p-2">
              <div class="ib-dates ib-date-check-in">
                <label class="ddd">Date de retrait</label>
              </div>
              <input type="text" id="date_check_in" class="form-control form-control-sm" required>
            </div>
            <div class="ib-check-out col-6 p-2">
              <div class="ib-dates ib-date-check-out">
                <label class=" ">Date de retour</label>
              </div>
              <input type="text" id="date_check_out" value="" class="form-control form-control-sm" required>
            </div>
            
          </div>
           <div class="row justify-content-between text-left">
              <div class="form-group col-sm-6 flex-column d-flex"> 
                  <label class="form-control-label"><?php _e('Lieu de retrait', 'instant_booking')?>
                      
                  </label>
                  <select class="form-select form-select-sm mb-3" id="pickselect">
                  <option value="simbock">simbock</option>
                      <option value="mendong">mendong</option>
                      <option value="nsam">nsam</option>
                  </select>
             </div>
             <div class="form-group col-sm-6 flex-column d-flex"> 
                  <label class="form-control-label"><?php _e('Lieu de dépôt', 'instant_booking')?>
                      
                  </label>
                  <select class="form-select form-select-sm mb-3" id="dropselect">
                  <option value="simbock">simbock</option>
                      <option value="mendong">mendong</option>
                      <option value="nsam">nsam</option>
                  </select>
             </div>          
          </div>

          <div class="ib_extra" >
              <div class="form-group">
                <?php

                  $terms = get_the_terms( $post->ID ,'extra' );
                  if($terms){
                      $i = 1;
                      foreach ( $terms as $term ) {?>
                    
                    <div class="form-check d-flex justify-content-between lh-sm">
                      <div>
                        <label class="form-check-label">
                          <input type="checkbox" class="form-check-input ib_extra_list" name="extra<?php echo $i ?>" value ="<?php echo esc_html($term->term_id); ?>" data_calculate="<?php echo esc_html(get_term_meta( $term->term_id, 'extraPrice',true)); ?>">
                        <span class="ib_checbox"> <?php echo esc_html($term->name); ?></span>
                        </label>
                      </div>
                      <p class="text-muted pe-2">
                        
                        <?php 
                              if( $separateur == "virgule-point"){?>
                                 <span class="ib_extra_price" basic-price="<?php echo esc_html(get_term_meta( $term->term_id, 'extraPrice',true)); ?>">  <?php echo esc_html(get_term_meta( $term->term_id, 'extraPrice',true))?></span> <span><?php echo $devise.' '.$mode; ?></span>                   
                               <?php 
                              }else if( $separateur == "point-virgule"){?>
                                <span class="ib_extra_price" basic-price="<?php echo esc_html(get_term_meta( $term->term_id, 'extraPrice',true)); ?>">  <?php echo esc_html(get_term_meta( $term->term_id, 'extraPrice',true))?></span> <span><?php echo $devise.' '.$mode; ?></span>                  
                                <?php 
                              }else if( $separateur == "espace-dot"){?>
                                 <span class="ib_extra_price" basic-price="<?php echo esc_html(get_term_meta( $term->term_id, 'extraPrice',true)); ?>">  <?php echo esc_html(get_term_meta( $term->term_id, 'extraPrice',true))?></span> <span><?php echo $devise.' '.$mode; ?></span>                           
                                <?php 
                              }else{?>
                                <span class="ib_extra_price" basic-price="<?php echo esc_html(get_term_meta( $term->term_id, 'extraPrice',true)); ?>"> <?php echo esc_html(get_term_meta( $term->term_id, 'extraPrice',true))?></span> <span><?php echo $devise.' '.$mode; ?></span>
                                <?php 
                              }
                            ?>
                      </p>
                    </div>
                    <?php
                          $i++;} 
                  }
                
                  
                ?>
              </div> 
          </div>
          <?php 
              if( $separateur == "virgule-point"){?>
                 <h4>Total : <span class="ib_grid_pricetotal fst-italic" initial-price="<?php echo esc_html(get_post_meta( get_the_ID(), 'serv_prix',true)  );?>"><?php echo esc_html(number_format( get_post_meta( get_the_ID(), 'serv_prix',true),$decimales,".",",") );?></span><?php echo esc_html($devise) ;?></h4>
              <?php 
              }else if( $separateur == "point-virgule"){?>
              <h4>Total : <span class="ib_grid_pricetotal fst-italic" initial-price="<?php echo esc_html(get_post_meta( get_the_ID(), 'serv_prix',true)  );?>"><?php echo esc_html(number_format( get_post_meta( get_the_ID(), 'serv_prix',true),$decimales,",",".") );?></span><?php echo esc_html($devise) ;?></h4>
                <?php 
              }else if( $separateur == "espace-dot"){?>
              <h4>Total : <span class="ib_grid_pricetotal fst-italic" initial-price="<?php echo esc_html(get_post_meta( get_the_ID(), 'serv_prix',true)  );?>"><?php echo esc_html(number_format( get_post_meta( get_the_ID(), 'serv_prix',true),$decimales,"."," ") );?></span><?php echo esc_html($devise) ;?></h4>
             <?php 
              }else{?>
              <h4>Total : <span class="ib_grid_pricetotal fst-italic" initial-price="<?php echo esc_html(get_post_meta( get_the_ID(), 'serv_prix',true)  );?>"><?php echo esc_html(number_format( get_post_meta( get_the_ID(), 'serv_prix',true),$decimales,",","") );?></span><?php echo esc_html($devise) ;?></h4>
              <?php 
              }
            ?>
        </div>
        <button type="submit" class="ib_reserve_button text-center m-3" style="padding: 15px 40px">
          Reserver
        </button>

      </form>
    </div>
      
</div>

<?php endwhile; ?>
</div>
<?php get_footer(); ?>