<?php

namespace Inc\Database;


use Inc\Controls\AdminCallbacks;

class Tentee_reservation_select
{
    public $callbacks;

	public function register() {
          
            do_action('tentee_select_dabase',array( $this->callbacks, 'Tentee_reservation_list_page' ));
	}


    public function tentee_reservation_select() {
        global $wpdb;

        $result = $wpdb->get_results ("SELECT * FROM IB_tentee_reservation");
       // foreach($result as $ligne){
          //  echo $ligne->nom_colonne;
          //  }

        //    Tentee_reservation_list_page
        return $result;  //display data
        
    }

}