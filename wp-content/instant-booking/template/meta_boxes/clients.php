
<div class="set-ti">
   <div>
     <h4 class="head-event">Information Du Client</h4>
     <form class="row">
       
         <div class="col-sm-6">
            <label for="pr_nom" class="form-label">Nom</label>
            <input type="text" class="form-control" name="pr_nom"  id="pr_nom"  value="<?php echo esc_attr( get_post_meta( $post->ID, 'pr_nom', true) ); ?>">>
          </div>

          <div class="col-sm-6">
            <label for="pr_prenom" class="form-label">Prenom</label>
            <input type="text" class="form-control" name="pr_prenom" id="pr_prenom" value="<?php echo esc_attr( get_post_meta(  $post->ID, 'pr_prenom', true) ); ?>" >
          </div>

          <div class="col-12">
            <label for="pr_mail" class="form-label">Email <span class="text-muted">(Optional)</span></label>
            <input type="email" class="form-control" name="pr_mail" id="pr_mail" value="<?php echo esc_attr( get_post_meta( $post->ID, 'pr_mail',true) ); ?>">
          </div>
         <div class="col-12">
              <label for="pr_adresse" class="form-label">Address</label>
              <input type="text" class="form-control" id="pr_adresse" name="pr_adresse" value="<?php echo esc_attr( get_post_meta( $post->ID, 'pr_adresse',true) ); ?>" >
         </div>

         <div class="col-12">
              <label for="pr_tel" class="form-label">Telephone<span class="text-muted"></span></label>
              <input type="tel" class="form-control" id="pr_tel"  name="pr_tel" value="<?php echo esc_attr( get_post_meta( $post->ID, 'pr_tel',true) ); ?>">
         </div>
         <div class="col-md-5">
              <label for="pr_pays" class="form-label">Pays</label>
              <input type="text" class="form-control" name="pr_pays" id="pr_pays" value="<?php echo esc_attr( get_post_meta( $post->ID, 'pr_pays',true) ); ?>">
            </div>

            <div class="col-md-4">
              <label for="pr_ville" class="form-label">Ville</label>
              <input type="text" class="form-control" name="pr_ville" id="pr_ville" value="<?php echo esc_attr( get_post_meta( $post->ID, 'pr_ville',true) ); ?>">
            </div>

            <div class="col-md-3">
              <label for="pr_zip" class="form-label">Code Postal</label>
              <input type="text" class="form-control" name="pr_zip" id="pr_zip" placeholder="" value="<?php echo esc_attr( get_post_meta( $post->ID, 'pr_zip',true) ); ?>">
            </div>   
         <div>
         <div class="col-md-12">
             <label for="pr_note" class="form-label">Note</label>
              <textarea class="form-control" id="pr_note" name="pr_note"><?php echo esc_attr( get_post_meta( $post->ID, 'pr_note',true) ); ?></textarea>
          </div>
       </form>
         
</div>
</div>
