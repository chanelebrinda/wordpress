<div class=" row container-fluid py-5 ib_search_page">
    <div class="col-xl-4 col-lg-4 col-md-4 col-12">
    <?php
        global $devise;
        global $mode;
        global $mode_affiche;
        $decimales = intval(esc_html(get_option('Payments_Settings')['Parametre_​nombre_decimales']));   
        $separateur = esc_html(get_option('Payments_Settings')['Parametre_separateur_prix']); 
  
      
         $cat_terms = get_terms('categorie');
         $cat_term_name = wp_list_pluck($cat_terms, 'name');


        if( !empty($_GET['date_check_in']) && !empty($_GET['date_check_out'])  ){

            $check_out = $_GET['date_check_out'];
            $check_in = $_GET['date_check_in'];
            $dates = tentee_reservation_search_date_inout($check_in ,$check_out);
            $catname = $cat_term_name ;

        }else if( !empty($_GET['date_check_in']) && !empty($_GET['date_check_out']) && !empty($_GET['catname'])){

            $catname = $_GET['catname'];
            $check_out = $_GET['date_check_out'];
            $check_in = $_GET['date_check_in'];
            $dates = tentee_reservation_search_date_inout($check_in ,$check_out);
            
        }else if( !empty($_GET['catname']) ){

            $catname = $_GET['catname'];
            $check_out = date("Y-m-d");
            $dates = tentee_reservation_search_date($check_out);

        }else {

            $catname = $cat_term_name ;
            $check_out = date("Y-m-d");
            $dates = tentee_reservation_search_date($check_out);

        }
        $DatArray = array();
        foreach($dates as $got){
            array_push( $DatArray,$got->ID);
        }
        $DatA =   $DatArray;
           
        $count_terms = count(get_terms( array(
            'taxonomy' => 'categorie'
        ) )); 

        
          $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

          if ($count_terms > 0) {

            $events = array(
                'post_type' => 'service',
                'post__in' => $DatA,
                'posts_per_page' => 5,
                'paged' => $paged,
                'tax_query' => array(
                  array (
                      'taxonomy' => 'categorie',
                      'field' => 'name',
                      'terms' => $catname,
                  )
              ),
            );

          } else {
                $events = array(
              'post_type' => 'service',
              'post__in' => $DatA,
              'posts_per_page' => 5,
              'paged' => $paged,
          );
           };
             
          
          $attr = [
          'class' =>'service_post_thumbnail'
          ];
          
        ?>


              <div class="row d-flex justify-content-center ib_search_box">
                    <div class="">
                         <div class="card ib_search">
                                <h4 class="text-center mb-4"><?php _e('RECHERCHE RAPIDE', 'instant_booking')?></h4>
                                <form class="form-card" role="search" method="get">
                                    <div class="row justify-content-between text-left">
                                        <div class="form-group  flex-column d-flex"> 
                                            <?php if( !empty($_GET['page_id']) ){?>
                                              <input type="hidden"  name="page_id" value="<?php echo $_GET['page_id'] ?>"> 
                                            <?php } 
                                             if ($count_terms > 0) {?>

                                                <label class="form-control-label"><?php _e('Categorie', 'instant_booking')?>
                                                
                                                </label>
                                                <select class="form-select form-select-sm mb-3" id="pickselect" name="catname">
                                                <option value=""><?php _e('Choisir une categorie', 'instant_booking')?></option>
                                                  <?php 
                                                    $cargs = array('taxonomy' => 'categorie', 'orderby' => 'name','order'   => 'DESC' );
                                                    $cats = get_categories($cargs);
                                                    foreach($cats as $cat) {
                                                    ?>
                                                    <option value="<?php echo esc_html( $cat->name) ; ?>"><?php echo esc_html( $cat->name) ; ?></option>
                                                   
                                                <?php  }?>
                                                </select>

                                                <?php
                                            }?>
                                            
                                      </div>
                                    </div>
                                    <div class="row justify-content-between text-left">
                                        <div class="form-group col-sm-6 flex-column d-flex">
                                             <label class="form-control-label"><?php _e('Date de retrait', 'instant_booking')?></label> 
                                             <input type="text" class="form-control form-control-sm" id="date_check_in" name="date_check_in" placeholder=""> 
                                             <input type="hidden" class="form-control form-control-sm" value="" id=" check_in" name=" check_in"> 
                                        </div>
                                        <div class="form-group col-sm-6 flex-column d-flex"> 
                                            <label class="form-control-label"><?php _e('Date de retour', 'instant_booking')?></label> 
                                            <input type="text" class="form-control form-control-sm" id="date_check_out" name="date_check_out" placeholder="">
                                            <input type="hidden" class="form-control form-control-sm" value="" id=" check_out" name=" check_out"> 
                                       </div>
                                    </div>
                                    <div class="row justify-content-end">
                                        <div class="form-group col-sm-12"> <button type="submit" class="btn-block ib_search_submit"><?php _e('Rechercher', 'instant_booking')?></button> </div>
                                    </div>
                                 
                                </form>
                            </div>
                        </div>
                </div>
        
      </div>
      <div class="col-xl-8 col-lg-8 col-md-8 col-12">

        
        <div class=" justify-content-lg-center ib_result_block">

            <?php 
                
                $loop1 = new WP_Query($events);
              if ( $loop1->have_posts() ) {          
                while ( $loop1->have_posts() ) {
                    $loop1->the_post();
            ?>

            <div class="">
            <!-- col col-sm-9 -->
              <div class="row g-0 border overflow-hidden  flex-md-row mb-4 shadow-sm h-md-250 position-relative ib_result_card">
                  <div class="col p-4 d-flex flex-column position-static">
                      <?php 
                          if( $separateur == "virgule-point"){?>
                              <strong class="d-inline-block mb-2 text-primary ib_card_price">  <?php echo number_format(get_post_meta( get_the_ID(), 'serv_prix',true),$decimales,".",",").$devise.' '.$mode; ?></strong>                   
                            <?php 
                          }else if( $separateur == "point-virgule"){?>
                            <strong class="d-inline-block mb-2 text-primary ib_card_price">  <?php echo number_format(get_post_meta( get_the_ID(), 'serv_prix',true),$decimales,",",".").$devise.' '.$mode; ?></strong>                  
                            <?php 
                          }else if( $separateur == "espace-dot"){?>
                              <strong class="d-inline-block mb-2 text-primary ib_card_price">  <?php echo number_format(get_post_meta( get_the_ID(), 'serv_prix',true),$decimales,"."," ").$devise.' '.$mode; ?></strong>                           
                            <?php 
                          }else{?>
                            <strong class="d-inline-block mb-2 text-primary ib_card_price" > <?php echo number_format(get_post_meta( get_the_ID(), 'serv_prix',true),$decimales,","," ").$devise.' '.$mode; ?></strong>
                            <?php 
                          }
                        ?>
                    
                    <h3 class="mb-0"><?php the_title(); ?></h3>
                    <div class="mb-1 text-muted">
                        <p class="card-text mb-auto"><?php  the_content();  ?></p>
                    </div>
                    <form name="checkout" method="post"  action="<?php the_permalink(); ?>">
                        <div class="mb-1 text-muted"> 
                            <button type="submit" class="ib_reserve_button text-center m-3" style="padding: 15px 40px">
                            <?php _e('Reserver', 'instant_booking')?>
                            </button>
                        </div> 
                    </form>               
                </div>
                <div class="col-auto  d-lg-block">
                   <?php the_post_thumbnail('medium',$attr);?>
                </div>
            </div>
            <!-- </div> -->
            <?php wp_reset_postdata();?>
            <?php } ?>
      </div>
      <nav aria-label="Page navigation example">
        <?php
        function ib_services_paginated( $query ) {

            $currentPage = max( 1, get_query_var( 'paged', 1 ) );         
            $pages = range( 1, max( 1, $query->max_num_pages ) );
            return array_map( function( $page ) use ( $currentPage ) {
                return ( object ) array(
                    "isCurrent" => $page == $currentPage,
                    "page" => $page,
                    "url" => get_pagenum_link( $page )
                );
            }, $pages );
        }
        
        ?>
           <ul class="pagination">
              <?php  if ( get_previous_posts_link() ) {?>
                <li class="page-item page-link" >
                  <?php previous_posts_link('&laquo;',$loop1->max_num_pages); ?>          
                </li>
                <?php } foreach( ib_services_paginated( $loop1 ) as $link ) : ?>
                <li class="page-item">
                    <?php if ( $link->isCurrent ): ?>
                        <strong class="page-link active" ><?php _e( $link->page ) ?></strong>
                    <?php else : ?>
                        <a class="page-link"  href="<?php esc_attr_e( $link->url ) ?>">
                            <?php _e( $link->page ) ?>
                        </a>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
                  <li class="page-item page-link" >
                    <?php next_posts_link('&raquo;',$loop1->max_num_pages); ?>          
                 </li>
                 
            </ul>
          
        </nav>  
        <?php
            } else{ 
                _e('any things found', 'instant_booking');
                return;
          }
         wp_reset_postdata();?>
      </div>
  </div>

</div>
