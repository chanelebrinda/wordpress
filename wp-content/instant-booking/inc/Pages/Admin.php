<?php

namespace Inc\Pages;

use Inc\Base\BaseController;
use Inc\Controls\AdminCallbacks;

class Admin extends BaseController{

    public function register() {

		$this->callbacks = new AdminCallbacks();
		add_action( 'admin_menu', array( $this, 'add_admin_pages' ) );
	}

	public function add_admin_pages() {
	
		add_menu_page('Booking Tentee','Instant booking','manage_options','plugin_reservation',
			array( $this->callbacks, 'wpplugin_settings_page_markup'),'dashicons-calendar-alt',60);

		add_submenu_page(
			'plugin_reservation', 'Tableau de bord',__( 'Tableau de bord', 'instant_booking' ),'manage_options',
			'Instant_Booking_dashboard',array( $this->callbacks, 'Instant_Booking_dashboard'),0);
		
		  add_submenu_page(
			'plugin_reservation','Calendrier',__( 'calendrier', 'instant_booking' ),'manage_options',
			'Instant_Booking_calendar',array( $this->callbacks, 'Instant_Booking_calendar'),1);
	  
		  add_submenu_page(
			'plugin_reservation','Reservation',__( 'Reservations', 'instant_booking' ),'manage_options',
			'Instant_Booking_reservation',array( $this->callbacks, 'Instant_Booking_reservations'),2);
		
	     add_submenu_page(
			'plugin_reservation','Employé',__( 'Employé', 'instant_booking' ),'manage_options',
			'Instant_Booking_employe',array( $this->callbacks, 'Instant_Booking_employe'));
	
		  add_submenu_page(
			'plugin_reservation','Paramètre',__( 'Paramètres', 'instant_booking' ),'manage_options',
			'Instant_Booking_settings',array( $this->callbacks, 'Instant_Booking_settings'));
	
		add_submenu_page(
		'plugin_reservation','Section extra',__( 'Extras', 'instant_booking' ),'manage_options',
		'edit-tags.php?taxonomy=extra',false);

		add_submenu_page(
			'plugin_reservation','Section categorie',__( 'Categories', 'instant_booking' ),'manage_options',
			'edit-tags.php?taxonomy=categorie',false);
	}


	



}

