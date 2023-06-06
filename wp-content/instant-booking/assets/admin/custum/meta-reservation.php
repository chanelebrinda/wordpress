
    <div class="set-ti">
        <div>
            <h4 class="head-event">Heure &amp; date</h4>

            <div class="subhead-event">
              <span class="clix">Chosir la periode:</span> 
              <div>
                <label for="pr_time_start">Debut:</label>
                 <input type="time" class="" id="pr_time_start" name="pr_time_start" value="<?php echo esc_attr( get_post_meta( $post->ID, 'pr_time_start', true) ); ?>">
              </div>
              <div>
                <label for="pr_time_end">Fin:</label>
                <input type="time" class="" id="pr_time_end" name="pr_time_end" value="<?php echo esc_attr( get_post_meta(  $post->ID, 'pr_time_end', true) ); ?>">
              </div>
            </div>
         </div>
         
         <div>
            <h4 class="head-event">Payement</h4>
            <div class="subhead-event">
              <span class="clix"> reservation</span>
              <div>
                 <label for="pr_prix">Prix:</label>
                   <input type="text" class="" id="pr_prix" name="pr_prix" value="<?php echo esc_attr( get_post_meta( $post->ID, 'pr_prix',true) ); ?>">
              </div>
              <div>
                <select class="" id="pr_symbol" name="pr_symbol" aria-label="Default select example">
                      <?php $current =get_post_meta( $post->ID, 'pr_symbol',true); ?>
                  <option value="$" <?php selected($current,'$' ,   false) ?> >$</option>
                  <option value="€" selected<?php selected($current, '€',  false )?> >€</option>
                  <option value="F cfa" <?php selected( $current, 'F cfa', false )?> >F cfa</option>
                </select>
              </div>
            </div>
         </div>
         <div>
            <h4 class="head-event">Autres</h4>
            <div class="subhead-event">
              <span class="clix">Capacité:</span>
              <div>
                <label for="pr_place">Nombres de places:</label>
                 <input type="number" class="" id="pr_place" name="pr_place" value="<?php echo esc_attr( get_post_meta( $post->ID, 'pr_place',true) ); ?>">
              </div>
            </div>
         </div>
         <div>
            <h4 class="head-event">Evenement</h4>
         <?php
          
            $selected_evenement = get_post_meta( $post->ID, 'pr_evenement_r', true );
            $all_evenements = get_posts( array(
                'post_type' => 'evenement',
                'numberposts' => -1,
                'orderby' => 'post_title',
                'order' => 'ASC'
            ) );
         ?>
            <div class="subhead-event">
              <span class="clix">Associer la reservation a un evenement</span> 
              <div>
                <select id="pr_evenement_r" name="pr_evenement_r">
                   <?php foreach ( $all_evenements as $evenement ) : ?>
                     <option value="<?php echo $evenement->ID; ?>"
                      <?php selected($selected_evenement,$evenement->ID ,   false) ?> >
                      <?php echo $evenement->post_title; ?></option>
                   <?php endforeach; ?>
                </select>

               

              </div>
            </div>
         </div>

          

   <!--      <div>
            <h4 class="head-event">Autres</h4>
            <div class="subhead-event">
              <span class="clix">Button:</span>
              <div>
                <label for="pr_contenu ">Contenu </label>
                 <input type="text" class="" id="pr_contenu" name="pr_contenu" value="">
              </div>
              <div>
                <label for="pr_color">Couleur</label>
                 <input type="color" class="" id="pr_color" name="pr_color" value="">
              </div>
            </div>
         </div>-->
      </div>
