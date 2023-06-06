
<?php 
        echo get_the_terms(get_the_ID(),'extra');
?>

  <div class="calendar-block ">
    <div class="calendar-date">
      <div class="calendar-months flatpickr-months">
        <button class="tee--prev-month flatpickr-prev-month">
          <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 17 17"><g></g><path d="M5.207 8.471l7.146 7.147-0.707 0.707-7.853-7.854 7.854-7.853 0.707 0.707-7.147 7.146z"></path></svg>
        </button>
        <div class="tee--month ">            
          <div class="tee--current-month">
            <span class="cur-month">	<?php  echo wp_date('l j F'); ?></span>
          </div>
        </div>
        <input id="calendar-to" type="hidden">

        <div>
          <button   id="icon_clendar" data-toggle>
          <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><mask id="path-1-inside-1_4419_880" fill="white"><path d="M4.0008 1.45988C4.0008 0.95672 4.0008 0.48899 4.0008 0C4.33839 0 4.66161 0 5.00638 0C5.00638 0.481903 5.00638 0.963807 5.00638 1.4528C7.67837 1.4528 10.3216 1.4528 12.9936 1.4528C12.9936 0.970894 12.9936 0.48899 12.9936 0C13.3384 0 13.6544 0 13.992 0C13.992 0.481903 13.992 0.95672 13.992 1.46697C14.0782 1.46697 14.1429 1.46697 14.2147 1.46697C14.7678 1.47406 15.3208 1.4528 15.8667 1.5024C16.9657 1.60162 17.921 2.61504 17.9856 3.69932C17.9928 3.79853 18 3.89775 18 3.99696C18 7.73172 18 11.4736 18 15.2083C18 15.839 17.8204 16.406 17.3966 16.8879C16.8795 17.469 16.2187 17.7525 15.4501 17.7525C11.1548 17.7596 6.85954 17.7596 2.55706 17.7525C1.28571 17.7525 0.265762 16.9162 0.0430966 15.7186C0.0143655 15.5556 0.00718276 15.3926 0.00718276 15.2225C0 11.4736 0 7.73172 0 3.98279C0 3.03316 0.409417 2.29613 1.22825 1.80005C1.6233 1.5591 2.06145 1.4528 2.52833 1.4528C2.94493 1.4528 3.36872 1.4528 3.78532 1.4528C3.84996 1.45988 3.91461 1.45988 4.0008 1.45988ZM1.00559 6.40648C1.00559 6.47026 0.998404 6.51987 0.998404 6.56948C0.998404 9.44673 0.998404 12.324 0.998404 15.1941C0.998404 15.343 1.01277 15.506 1.05587 15.6477C1.26417 16.3564 1.82442 16.7461 2.60016 16.7461C6.85954 16.7461 11.1261 16.7461 15.3855 16.7461C16.3623 16.7461 16.9944 16.1225 16.9944 15.1658C16.9944 12.3098 16.9944 9.44673 16.9944 6.59074C16.9944 6.52696 16.9872 6.46318 16.9872 6.39939C11.6504 6.40648 6.3352 6.40648 1.00559 6.40648ZM13.008 2.45204C10.3288 2.45204 7.67837 2.45204 5.00638 2.45204C5.00638 2.77803 5.00638 3.09694 5.00638 3.41585C4.66161 3.41585 4.33839 3.41585 3.99362 3.41585C3.99362 3.08276 3.99362 2.77094 3.99362 2.44495C3.47646 2.44495 2.98085 2.43786 2.48524 2.44495C1.71668 2.45913 1.0846 3.00481 1.01995 3.75601C0.976856 4.25209 1.00559 4.76234 0.998404 5.25842C0.998404 5.30094 1.00559 5.33637 1.01277 5.37889C6.34238 5.37889 11.6648 5.37889 16.9944 5.37889C16.9944 4.8403 17.0231 4.31587 16.9872 3.79145C16.937 3.08985 16.4485 2.58669 15.7374 2.46621C15.5866 2.43786 15.4286 2.43786 15.2706 2.43786C14.854 2.43786 14.4374 2.43786 13.9992 2.43786C13.9992 2.77095 13.9992 3.08985 13.9992 3.41585C13.6616 3.41585 13.3384 3.41585 13.008 3.41585C13.008 3.09694 13.008 2.78512 13.008 2.45204Z"></path></mask><path d="M4.0008 1.45988C4.0008 0.95672 4.0008 0.48899 4.0008 0C4.33839 0 4.66161 0 5.00638 0C5.00638 0.481903 5.00638 0.963807 5.00638 1.4528C7.67837 1.4528 10.3216 1.4528 12.9936 1.4528C12.9936 0.970894 12.9936 0.48899 12.9936 0C13.3384 0 13.6544 0 13.992 0C13.992 0.481903 13.992 0.95672 13.992 1.46697C14.0782 1.46697 14.1429 1.46697 14.2147 1.46697C14.7678 1.47406 15.3208 1.4528 15.8667 1.5024C16.9657 1.60162 17.921 2.61504 17.9856 3.69932C17.9928 3.79853 18 3.89775 18 3.99696C18 7.73172 18 11.4736 18 15.2083C18 15.839 17.8204 16.406 17.3966 16.8879C16.8795 17.469 16.2187 17.7525 15.4501 17.7525C11.1548 17.7596 6.85954 17.7596 2.55706 17.7525C1.28571 17.7525 0.265762 16.9162 0.0430966 15.7186C0.0143655 15.5556 0.00718276 15.3926 0.00718276 15.2225C0 11.4736 0 7.73172 0 3.98279C0 3.03316 0.409417 2.29613 1.22825 1.80005C1.6233 1.5591 2.06145 1.4528 2.52833 1.4528C2.94493 1.4528 3.36872 1.4528 3.78532 1.4528C3.84996 1.45988 3.91461 1.45988 4.0008 1.45988ZM1.00559 6.40648C1.00559 6.47026 0.998404 6.51987 0.998404 6.56948C0.998404 9.44673 0.998404 12.324 0.998404 15.1941C0.998404 15.343 1.01277 15.506 1.05587 15.6477C1.26417 16.3564 1.82442 16.7461 2.60016 16.7461C6.85954 16.7461 11.1261 16.7461 15.3855 16.7461C16.3623 16.7461 16.9944 16.1225 16.9944 15.1658C16.9944 12.3098 16.9944 9.44673 16.9944 6.59074C16.9944 6.52696 16.9872 6.46318 16.9872 6.39939C11.6504 6.40648 6.3352 6.40648 1.00559 6.40648ZM13.008 2.45204C10.3288 2.45204 7.67837 2.45204 5.00638 2.45204C5.00638 2.77803 5.00638 3.09694 5.00638 3.41585C4.66161 3.41585 4.33839 3.41585 3.99362 3.41585C3.99362 3.08276 3.99362 2.77094 3.99362 2.44495C3.47646 2.44495 2.98085 2.43786 2.48524 2.44495C1.71668 2.45913 1.0846 3.00481 1.01995 3.75601C0.976856 4.25209 1.00559 4.76234 0.998404 5.25842C0.998404 5.30094 1.00559 5.33637 1.01277 5.37889C6.34238 5.37889 11.6648 5.37889 16.9944 5.37889C16.9944 4.8403 17.0231 4.31587 16.9872 3.79145C16.937 3.08985 16.4485 2.58669 15.7374 2.46621C15.5866 2.43786 15.4286 2.43786 15.2706 2.43786C14.854 2.43786 14.4374 2.43786 13.9992 2.43786C13.9992 2.77095 13.9992 3.08985 13.9992 3.41585C13.6616 3.41585 13.3384 3.41585 13.008 3.41585C13.008 3.09694 13.008 2.78512 13.008 2.45204Z" fill="#303030"></path></svg>
          </button>
        </div>
        <button class="tee--next-month flatpickr-next-month">
          <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 17 17"><g></g><path d="M13.207 8.472l-7.854 7.854-0.707-0.707 7.146-7.146-7.146-7.148 0.707-0.707 7.854 7.854z"></path></svg>
        </button>
     </div>
   </div>
  </div>


<?php   



function event_display_reservation($usedate){


    include( WPPLUGIN_DIR . 'template/e_commerce/button_add_cart.php');
?>
 

<div class="reservation" id="event_reservattion_front">
  <?php
  
    $events = array(
          'post_type'      => 'evenement',
          'meta_query' => array(
            array(
            'key' => 'pr_datetime_start',
            'compare' =>'<',
            'value' =>  $usedate,
            ),
            
            array(
              'key' => 'pr_datetime_end',
              'compare' =>'>=',
              'value' =>  $usedate,
              ),
            
         ) 
    );
    $attrR = [
      'class' =>'reservation_post_thumbnail'
    ];

      $attr = [
          'class' =>'event_post_thumbnail'
      ];
      $file = the_post_thumbnail_url();
      
      $loop1 = new WP_Query($events);
        
         while ( $loop1->have_posts() ) {
             $loop1->the_post();
         ?>

         <div class="reservation_result">
              <div class="event_content">
                   <p class="event_title"><?php the_ID(); ?></p>
                    <h1 class="event_title"><?php the_title(); ?></h1>
                   <div class="event_image"><?php the_post_thumbnail('medium',$attr);?></div> 
              </div>

            <?php
               
            $loop2 = new WP_Query( array(
              'post_type' => 'reservation',
              'nopaging' => true,            
              'meta_query' => array(
                array(
                'key' => 'pr_evenement_r',
                'compare' =>'=',
                'value' =>  get_the_ID(),
                ),
                
             )  
             ));
                
            if ( $loop2-> have_posts() ) { ;                     
             ?>

              <div class="event_reservation  ">
                 <div class="instant_booking_slot" id="grid">
                  <?php 
                       while ( $loop2->have_posts() ) 
                    { 
                       $loop2->the_post();

                         $id_reservation = get_the_ID();
                         $heur_debut = get_post_meta( get_the_ID(), 'pr_time_start', true);
                         $heur_fin = get_post_meta( get_the_ID(), 'pr_time_end', true);
                         $prix_reser= get_post_meta( get_the_ID(), 'pr_prix', true);
                         $symbol_currency = get_post_meta( get_the_ID(), 'pr_symbol', true);   
                         $place = get_post_meta( get_the_ID(), 'pr_place', true);
                    ?>
                   
                        <div class="instant_slot__wrap card_slot" id="card_complete" data-id="<?php echo get_the_id() ?>">
                        <?php 
                         if( get_the_id() == 277){?>
                          <h3>COMPLET</h3>
                          
                          <?php
                         }else{
                          ?> 
                       
                          <div class="instant_slot__hour">
                             <span class="instant_cart_heureD"><?php echo $heur_debut ?> </span> 
                                <i class="u-pxxs">-</i>
                              <span class="instant_cart_heureF"><?php echo $heur_fin ?></span>
                          </div> 
                          <div id="instant_event_need"><?php the_post_thumbnail('medium',$attrR);?></div> 
            
                          <div class="instant_cart_lot__content">                        
                            <div>
                               <strong><span class="instant_cart_slot__title" id="instant_event_need"><?php the_title();?></span></strong> 
                            </div>     
                            <div class="instant_cart_date" id="instant_event_need" ><?php echo wp_date('Y-m-d'); ?></div> 
                            <div>
                              <span class="instant_card__price"><?php echo $prix_reser ?></span><span class="instant_card__currency"><?php echo $symbol_currency ?> </span>
                            </div>

                            <div class="instant_cart_place_element">
                                  <small><span class="instant_cart_place"><?php echo $place ?></span>  places </small> 
                            </div>   
                            
                            <button class="instant_card__btn add-to-cart" data-id="<?php echo get_the_id() ?>">Réserver</button>
                          </div> 
                          <?php   } ?>
                       </div> 
                   
                  <?php   } ?>
                </div>             
              </div>
            <?php   } ?>
          </div>

   <?php  } ?>
</div>
<?php  }
//$_COOKIE['date_send_js']
$todaydate = wp_date('Y-m-d');
$selecteddate = "2022-08-26";
echo $todaydate;
echo $selecteddate;
if($selecteddate == $todaydate ){
    $todaydate = $selecteddate;
    event_display_reservation($todaydate ) ;
  }
  else{
 event_display_reservation($selecteddate) ;
  }
 ?>






<div class="reservation" id="event_reservattion_front">
  <?php
  
    $events = array(
          'post_type'      => 'service',
          
    );
    $extras = get_terms(
      array(
          'taxonomy'   => 'extra',
          'hide_empty' => false,
      ) );
    $categories = get_terms(
      array(
          'taxonomy'   => 'categorie',
          'hide_empty' => false,
     ) );
    $attrR = [
      'class' =>'reservation_post_thumbnail'
    ];

      $attr = [
          'class' =>'event_post_thumbnail'
      ];
      $file = the_post_thumbnail_url();
      
      $loop1 = new WP_Query($events);
        
         while ( $loop1->have_posts() ) {
             $loop1->the_post();
      
      
            // Check if any term exists
            if ( ! empty( $extras ) && is_array( $extras ) ) {
                // Run a loop and print them all
                foreach ( $extras as $extra ) { ?>

                    <a href="<?php echo esc_url( get_term_link( $extra ) ) ?>">
                        <?php echo $extra->name; ?>
                    </a><?php
                }
            }
          }
         