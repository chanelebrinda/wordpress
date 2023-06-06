<?php 

namespace Inc\Controls;

use Inc\Base\BaseController;
use Fpdf\Fpdf;

class AdminCallbacks extends BaseController
{
   public  $logoInstant = '';
   public  $blankPicture = '';
    
	public function wpplugin_settings_page_markup()
	{	
		include( $this->tentee_plugin_path . 'assets/admin/settings-page.php');
	}

	public function pr_ajout_reservation()
	{
	    include( $this->tentee_plugin_path . 'assets/admin/formReservation.php');
	}

	public function Instant_Booking_settings()
	{
		$logoInstant = $this->tentee_plugin_url.'assets/admin/img/Instant_Booking_logo-Trnasparent_500x500.png';		
		$blankPicture = $this->tentee_plugin_url.'assets/admin/img/blank-profile-picture.png';
		include( $this->tentee_plugin_path . 'template/settings-page.php');
	}
	public function Instant_Booking_reservations($result)
	{
		$logoInstant = $this->tentee_plugin_url.'assets/admin/img/Instant_Booking_logo-Trnasparent_500x500.png';
		$blankPicture = $this->tentee_plugin_url.'assets/admin/img/blank-profile-picture.png';
		include( $this->tentee_plugin_path . 'template/reservations/list_reservation.php');
	}

	public function Instant_Booking_employe()
	{
		$logoInstant = $this->tentee_plugin_url.'assets/admin/img/Instant_Booking_logo-Trnasparent_500x500.png';		
		$blankPicture = $this->tentee_plugin_url.'assets/admin/img/blank-profile-picture.png';
	   include( $this->tentee_plugin_path . 'template/employe/list_employe.php');
	}
	public function Instant_Booking_dashboard(){
		$logoInstant = $this->tentee_plugin_url.'assets/admin/img/Instant_Booking_logo-Trnasparent_500x500.png';		
		$blankPicture = $this->tentee_plugin_url.'assets/admin/img/blank-profile-picture.png';
	   include( $this->tentee_plugin_path . 'template/dashboard.php');
	}

	public function Instant_Booking_calendar()
	{ 
		$logoloading = $this->tentee_plugin_url.'assets/admin/img/logogif.gif';
		$logoloadingmp4 = $this->tentee_plugin_url.'assets/admin/img/Sans titre.mp4';		
		$blankPicture = $this->tentee_plugin_url.'assets/admin/img/blank-profile-picture.png';
		$logoInstant = $this->tentee_plugin_url.'assets/admin/img/Instant_Booking_logo-Trnasparent_500x500.png';	
		include( $this->tentee_plugin_path . 'template/calendars/c_reservation.php');
	}

	public function services_box_html($post){	 
		wp_nonce_field ( plugin_basename ( __FILE__ ), 'pr_services_box_nonce');
		include( $this->tentee_plugin_path . 'template/meta_boxes/services.php');
	}

	public function evenemements_box_html($post){	 
		wp_nonce_field ( plugin_basename ( __FILE__ ), 'pr_evenement_box_nonce');
		include( $this->tentee_plugin_path . 'template/meta_boxes/evenemements.php');
	}

	public function client_box_html( $post ) {

		wp_nonce_field ( plugin_basename ( __FILE__ ), 'pr_client_box_nonce');
		include( $this->tentee_plugin_path . 'template/meta_boxes/clients.php');
	  }


	  /***********************************db************* */
	  
}