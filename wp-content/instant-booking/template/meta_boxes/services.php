<?php

$options = get_option('Payments_Settings');
    $devise = '';
    if( isset( $options['Parametre_devise'] ) ) {

      $devise = esc_html( $options['Parametre_devise'] );
    }



    
    
?>
    <div class="set-ti">
       
    <div>
             <h4 class="head-event">Payement</h4>
             <div class="subhead-event">
                 <span class="clix"> reservation</span>
                 <div class="">
                     <label for="serv_prix">Prix:</label>
                        <input type="text" id="serv_prix" name="serv_prix" value="<?php echo esc_attr( get_post_meta( $post->ID, 'serv_prix',true) );?> "\>
                       
                    </div>
                 </div>
       
              <div>
             
        </div>
    
</div>


               