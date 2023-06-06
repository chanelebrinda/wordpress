<?php

if(isset( get_option('Payments_Settings')['Parametre_​nombre_decimales'] ) || isset( get_option('Payments_Settings')['Parametre_separateur_prix'] ) || isset( get_option('Payments_Settings')['Parametre_​nombre_decimales'] ) || isset( get_option('Payments_Settings')['Parametre_devise'] )|| isset( get_option('reservation_settings')['Parametre_mode_reservation']) || isset( get_option('design_settings')['Parametre_mode_affichage'] ) ) {
  $devise = esc_html( get_option('Payments_Settings')['Parametre_devise']  );
  $mode_affiche = esc_html(get_option('design_settings')['Parametre_mode_affichage']);
  $mode = esc_html(get_option('reservation_settings')['Parametre_mode_reservation']); 
  $separateur = esc_html(get_option('Payments_Settings')['Parametre_separateur_prix']); 
  $position_symbole = esc_html(get_option('Payments_Settings')['Parametre_separateur_prix']); 
  $decimales = intval(esc_html(get_option('Payments_Settings')['Parametre_​nombre_decimales']));
}
 
$argext = array(
  'taxonomy' => 'categorie',
);

$extcats = get_categories($argext);

  if( empty($extcats)){
    cardsimple();
  }else if( $mode_affiche == "Par Categorie" && !empty($extcats)){
    cardcategory();
  }else{
    cardsimple();
  }

  function cardsimple(){
      global $devise;
      global $mode;
      global $mode_affiche;
      $decimales = intval(esc_html(get_option('Payments_Settings')['Parametre_​nombre_decimales']));   
      $separateur = esc_html(get_option('Payments_Settings')['Parametre_separateur_prix']); 

       ?>
       <div class="container-md m-5">
       <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-3">
              
         <?php
            $events = array(
                  'post_type'      => 'service',
                   
            );
            $attr = [
              'class' =>'event_post_thumbnail'
            ];

            $loop1 = new WP_Query($events);                 
                while ( $loop1->have_posts() ) {
                    $loop1->the_post();                 
              ?>
                <div class="col">
                  <div class="card shadow-sm">
                    <!-- <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="medium_large" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>
                    -->
                    <div class="bd-placeholder-img card-img-top "><?php the_post_thumbnail('medium_large' , $attr);?></div> 
                    
                    <div class="card-body ">
                      <h5><?php the_title(); ?></h5>
                      <p class="card-text" style="color: #1754AB;font-size: 16px">
                      <?php 
                          if( $separateur == "virgule-point"){?>
                              <strong class="ib_card_price">  <?php echo number_format(get_post_meta( get_the_ID(), 'serv_prix',true),$decimales,".",",").$devise.' '.$mode; ?></strong>                   
                            <?php 
                          }else if( $separateur == "point-virgule"){?>
                            <strong class="ib_card_price">  <?php echo number_format(get_post_meta( get_the_ID(), 'serv_prix',true),$decimales,",",".").$devise.' '.$mode; ?></strong>                  
                            <?php 
                          }else if( $separateur == "espace-dot"){?>
                              <strong class="ib_card_price">  <?php echo number_format(get_post_meta( get_the_ID(), 'serv_prix',true),$decimales,"."," ").$devise.' '.$mode; ?></strong>                           
                            <?php 
                          }else{?>
                            <strong class="ib_card_price" > <?php echo number_format(get_post_meta( get_the_ID(), 'serv_prix',true),$decimales,","," ").$devise.' '.$mode; ?></strong>
                            <?php 
                          }
                        ?>
                       </p>                         
                      <a href="<?php  echo get_permalink(get_the_ID());  ?>" class="btn ib_reservation_btn px-4" style="text-decoration: none"><?php _e('Reserver', 'instant_booking')?></a>                        
                    </div>
                  </div>
                </div> 
              
        <?php }  ?>      
     </div>
</div>
<?php }

  function cardcategory(){
    global $devise;
    global $mode;
    global $mode_affiche;
    $decimales = intval(esc_html(get_option('Payments_Settings')['Parametre_​nombre_decimales']));   
    $separateur = esc_html(get_option('Payments_Settings')['Parametre_separateur_prix']); 


    $args = array(
        'taxonomy' => 'categorie',
        'orderby' => 'name',
        'order'   => 'DESC'
    );

    $cats = get_categories($args);
    foreach($cats as $cat) {
      ?>
      <div class="ib_card_cat mx-5 my-4">
          <span class="ib_catnme"><?php echo esc_html($cat->name); ?></span>
          <span class="ib_catprice px-1">( <?php echo esc_html(get_term_meta( $cat->term_id, 'categoriePrice',true)).$devise.$mode;; ?> )</span>
      </div>
          <div class="container-md mx-5">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-3">
                      
                 <?php
                    $events = array(
                          'post_type'      => 'service',
                          'tax_query' => array(
                            array (
                                'taxonomy' => 'categorie',
                                'field' => 'name',
                                'terms' =>  $cat->name,
                            )
                        ),
                    );
                    $attr = [
                      'class' =>'event_post_thumbnail'
                    ];

                    $loop1 = new WP_Query($events);                 
                        while ( $loop1->have_posts() ) {
                            $loop1->the_post();                 
                  ?>
                        <div class="col">
                          <div class="card shadow-sm">
                            <!-- <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="medium_large" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>
                            -->
                            <div class="bd-placeholder-img card-img-top "><?php the_post_thumbnail('medium_large , $attr');?></div> 
                            
                            <div class="card-body ">
                              <h5><?php the_title(); ?></h5>
                              <p class="card-text" style="color: #1754AB;font-size: 16px">
                              <?php 
                              if( $separateur == "virgule-point"){?>
                                 <strong class="ib_card_price">  <?php echo number_format(get_post_meta( get_the_ID(), 'serv_prix',true),$decimales,".",",").$devise.' '.$mode; ?></strong>                   
                               <?php 
                              }else if( $separateur == "point-virgule"){?>
                                <strong class="ib_card_price">  <?php echo number_format(get_post_meta( get_the_ID(), 'serv_prix',true),$decimales,",",".").$devise.' '.$mode; ?></strong>                  
                                <?php 
                              }else if( $separateur == "espace-dot"){?>
                                 <strong class="ib_card_price">  <?php echo number_format(get_post_meta( get_the_ID(), 'serv_prix',true),$decimales,"."," ").$devise.' '.$mode; ?></strong>                           
                                <?php 
                              }else{?>
                                <strong class="ib_card_price" > <?php echo number_format(get_post_meta( get_the_ID(), 'serv_prix',true),$decimales,","," ").$devise.' '.$mode; ?></strong>
                                <?php 
                              }
                              ?>
                               </p>                         
                              <a href="<?php  echo get_permalink(get_the_ID());  ?>" class="btn ib_reservation_btn px-4" style="text-decoration: none"><?php _e('Reserver', 'instant_booking')?></a>                        
                            </div>
                          </div>
                        </div> 
                      
                <?php }  ?>      
             </div>
       </div>
   <?php }
   
  }
   ?>  
      
       

