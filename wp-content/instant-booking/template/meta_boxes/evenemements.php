
    <div class="set-ti">
        <div>
            <h4 class="head-event">Heure &amp; date</h4>

            <div class="subhead-event row">
                <span class="clix col-lg-3 col-md-12" >Chosir la periode:</span>
                <div class="col-lg-9 col-md-12 row">
                    <div class="form-group col-md-4 ">
                        <label for="pr_datetime_start">Debut:</label>
                        <input type="date" class="" id="pr_datetime_start" name="pr_datetime_start" value="<?php echo esc_attr( get_post_meta( $post->ID, 'pr_datetime_start',true) ); ?>" min="2022-06-01" max="2040-06-18">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="pr_datetime_end">Fin:</label>
                        <input type="date" class="" id="pr_datetime_end" name="pr_datetime_end" value="<?php echo esc_attr( get_post_meta( $post->ID, 'pr_datetime_end',true) ); ?>" min="2022-06-01" max="2040-06-18">
                    </div>
                </div>  
            </div>

            <div class="subhead-event row ">
                <span class="clix col-md-12">Creer vos creanaux horaires:</span> 
                <form class="col-md-12" id="form-crenaux" name="form-crenaux">
                    <input Type="hidden" class="ib_crenaux_event" value="<?php echo get_the_ID() ?>">
                    <table class="display table table-bordered" id="ib_book_add_delete_table">
                        <thead>
                            <tr>
                            <th >Debut</th>
                            <th>Fin</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="tf_lenght" id="ib_crenaux_element0">  
                              <td> 
                                 <input id="ib_crenaux_debut" type="time" value= ""  class="form-control" name="ib_crenaux_debut[]">
                              </td> 
                              <td> 
                                <input id="ib_crenaux_fin" type="time" class="form-control" name="ib_crenaux_debut[]">
                             </td>
                              <th> 
                                 <button type="button" class="btn btn-success ib_add_crenaux" name="add" id="">Ajouter</button> 
                                </th>
                            </tr>
                        </tbody>     
                   </table>
              
                   <input type="submit" class="btn btn-primary " name="ib_send_crenaux" id="ib_send_crenaux" value="envoyer">  
              </form>

            </div>
            <div id="ib-display-crenaux"></div>

        </div>
        <div>
            <h4 class="head-event">Localisation</h4>
            <div class="subhead-event">
               <span class="clix">Chosir la lieu:</span>
                <div>
                    <input type="text" class="" id="pr_lieu" name="pr_lieu" value="<?php echo esc_attr( get_post_meta( $post->ID, 'pr_lieu',true) ); ?>">
                </div>
            </div>
        </div>
			  
        <div>
        <?php
            if( isset( get_option('Payments_Settings')['Parametre_devise'] ) || 
                isset( get_option('Payments_Settings')['Parametre_separateur_prix'] ) ||
                isset( get_option('Payments_Settings')['Parametre_position_symbole'] ) ) {
                $devise = esc_html( get_option('Payments_Settings')['Parametre_devise']  );
                $separateur = esc_html( get_option('Payments_Settings')['Parametre_separateur_prix']  );
                $position = esc_html(get_option('Payments_Settings')['Parametre_position_symbole']);
            } 

        ?>          
             <h4 class="head-event">Payement</h4>
             <div class="subhead-event">
                 <span class="clix"> reservation</span>
                
            <div>
            <div class="input-group mb-3">
                <?php if( $position == 'Avant' || $position == 'Avant avec espace'){?>
                    <span class="input-group-text"><?php echo $devise ?></span>
                    <input type="tel" class="form-control" id="pr_price" name="pr_price" aria-label="Amount (to the nearest dollar)">
                 <?php }
                 else{?>
                    <input type="tel" class="form-control" id="pr_price" name="pr_price" aria-label="Amount (to the nearest dollar)">
                    <span class="input-group-text"><?php echo $devise ?></span>
                <?php }?>
            </div>
        </div>
    
</div>
         <div>
            <h4 class="head-event">Autres</h4>
            <div class="subhead-event">
              <span class="clix">Nombres de places:</span>
              <div>
                 <input type="number" class="" id="pr_places" name="pr_places" value="<?php echo esc_attr( get_post_meta( $post->ID, 'pr_places',true) ); ?>">
              </div>
            </div>
         </div>

         
