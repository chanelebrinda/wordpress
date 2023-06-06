<?php 

namespace Inc\CustumHook;

use Inc\Controls\AdminCallbacks;

class DataBaseRequest
{


	public function register() {

			add_action( 'init', array( $this, 'tentee_select_dabase' ));
	
	}
    

    public function tentee_select_dabase(){
        global $wpdb;
        $result = $wpdb->get_results ("SELECT * FROM IB_tentee_reservation");
         return $result;
        do_action('tentee_select_dabase',$result);

    }


}

