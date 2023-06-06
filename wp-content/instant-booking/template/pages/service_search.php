<?php 
/**
 * Template Name: Search Page
 */

get_header();
global $wp_query;

$catname = $_GET['CATEGORIE_NAME'];

$args = array(
   'post_type'   => 'service',
   'posts_per_page' => 8,
   'order' => 'DESC',
   'tax_query' => array(
      array (
          'taxonomy' => 'categorie',
          'field' => 'name',
          'terms' =>  $catname,
      )
  ),
);
?>
<div id="primary">
   <main id="main" class="site-main p-5 m-14" role="main">
      <div class="container">
         <header class="mb-5">
            <h1 class="page-title">
               <?php _e( 'Search results for', 'instant_booking' ); ?>: "<?php echo the_search_query(); ?>"
            </h1>
         </header>

         <?php if ( have_posts() ) { ?>

                 <div class=" justify-content-lg-center ib_result_block">
                     <?php 
                        
                        if( isset( get_option('Payments_Settings')['Parametre_devise'] ) || isset( get_option('reservation_settings')['Parametre_mode_reservation'] ) ) {
                        $devise = esc_html( get_option('Payments_Settings')['Parametre_devise']  );
                           $mode = esc_html(get_option('reservation_settings')['Parametre_mode_reservation']);
                        }

                           if ( have_posts() ) {      

                              while ( have_posts() ) {
                                the_post();
                                ?>

                              <div class="">
                                 <!-- col col-sm-9 -->
                                 <div class="row g-0 border overflow-hidden  flex-md-row mb-4 shadow-sm h-md-250 position-relative ib_result_card">
                                    <div class="col p-4 d-flex flex-column position-static">
                                       <strong class="d-inline-block mb-2 text-primary ib_card_price"> <?php echo esc_attr( get_post_meta( get_the_ID(), 'serv_prix',true) ).$devise.$mode;?></strong>
                                       <h3 class="mb-0"><?php the_title(); ?></h3>
                                       <div class="mb-1 text-muted">
                                             <p class="card-text mb-auto"><?php  the_content();  ?></p>
                                       </div>
                                       <form name="checkout" method="post"  action="<?php the_permalink(); ?>">
                                                <div class="mb-1 text-muted"> 
                                                   <button type="submit" class="ib_reserve_button text-center m-3" style="padding: 15px 40px">
                                                   Reserver
                                                   </button>
                                                </div> 
                                       </form>
                                     
                                    </div>
                                    <div class="col-auto  d-lg-block">
                                       <?php the_post_thumbnail('medium');?>
                                    </div>
                               </div>
                            </div>
                            <?php wp_reset_postdata();?>
                           <?php } ?>
                 

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
                                 <?php previous_posts_link('&laquo;',$wp_query->max_num_pages); ?>          
                              </li>
                              <?php } foreach( ib_services_paginated( $wp_query ) as $link ) : ?>
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
                                 <?php next_posts_link('&raquo;',$wp_query->max_num_pages); ?>          
                              </li>
                              
                           </ul>
                        
                     </nav>
                     </div> 
               <?php } ?>
            </div>
         <?php } else {?>
           <h2 class="text-center"><?php _e( 'Aucun résultat trouvé', 'instant_booking' );?></h2>
           <?php } ?>

      </div>
   </main>
</div>
<?php get_footer(); ?>