<?php
    /*
    Template Name: Nom du template
    */
    

    // Récupération de l'ID du produit source      
     $source_product_id = 810  ; 
 

    // Récupération des variations du produit source
    $source_product_variations = get_posts(array(
      'post_parent' => $source_product_id,
      'post_type' => 'product_variation',
      'posts_per_page' => -1,
      'post_status' => 'any',
      'fields' => 'ids'
    ));

    // Si le produit source a des variations
     if (!empty($source_product_variations)) {

       // Récupération de tous les produits du site
       $Allproducts = get_posts(array(
          'post_type' => 'product',
          'posts_per_page' => -1,
          'post_status' => 'any',
          'exclude' => array($source_product_id),
          'fields' => 'ids'
        ));
   
       // Pour chaque produit
        foreach ($Allproducts as $product_id) {
          $product_variations = get_posts(array(
            'post_parent' => $product_id,
            'post_type' => 'product_variation',
            'posts_per_page' => -1,
            'post_status' => 'any',
            'fields' => 'ids'
          ));

          if (!empty($product_variations)) {
            // Suppression des variations existantes
           foreach ($product_variations as $product_variations_id) {
              wp_delete_post($product_variations_id, true);
            }
          }

          // Insére de nouvelles variantes

          $source_product = wc_get_product( $source_product_id );  

             $variations = $source_product->get_available_variations();
                     // Recupere les variations du produit source
             foreach ( $variations as $variation_data ) {

                  $args_variation = array(
                      'post_title'   => 'variation #' . $product_id . ' Variation',
                      'post_name'   => 'product-' . $product_id . '-variation',
                      'guid' => home_url().'/?product_variation=product-'. $product_id . '-variation',
                      'post_status'  => 'publish',
                      'post_parent'  => $product_id,
                      'post_type'    => 'product_variation'
                    ) ;
                  $new_product_id = wp_insert_post( $args_variation );

                  $product_destinataire = wc_get_product( $product_id );         
                  $product_destinataire->set_attributes($source_product->get_attributes());
                  $product_destinataire->save();

                  // Recupere les attributs du produit source
                  foreach ( $variation_data['attributes'] as $attribute => $term_name ) {
                    update_post_meta( $new_product_id, $attribute, $term_name );
                  } 

                  update_post_meta( $new_product_id , '_price', $variation_data['display_price'] );
                  update_post_meta( $new_product_id , '_regular_price', $variation_data['display_regular_price'] );

                  if( ! empty($variation_data['max_qty']) ){
                      update_post_meta( $variation_id, '_stock_status', $variation_data['max_qty']  );
                      update_post_meta( $variation_id, '_manage_stock', 'yes' );
                      update_post_meta( $variation_id, '_stock', '' );
                  } else {     
                    update_post_meta( $variation_id, '_manage_stock', 'no' );
                  }
                  if( ! empty( $variation_data['sku'] ) ){
                    update_post_meta( $new_product_id , '_sku', $variation_data['sku'] );
                  }
                  
              }
           }
    }  

?>