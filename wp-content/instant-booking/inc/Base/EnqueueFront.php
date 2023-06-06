<?php 

namespace Inc\Base;

class EnqueueFront extends BaseController
{
	public function register() {
	   	add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_script' ), 100 );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_style' ), 100 );
        add_filter('script_loader_tag', array( $this,'add_data_attribute'), 10, 2);
	}

	
    public function enqueue_style(){

        wp_enqueue_style(
            'wpplugin-frontend',
            $this->tentee_plugin_url . 'assets/frontend/css/wpplugin-frontend-style.css',
            [],
            time()
          );

          wp_enqueue_style( 'load-fa', 'https://use.fontawesome.com/releases/v5.15.4/css/all.css?ver=5.0.2' );

  
          wp_enqueue_style(
            'Ib-calendar-front2',
            $this->tentee_plugin_url . 'assets/frontend/css/lightpick.css',
            [],
            time()
          );

          wp_enqueue_style(
            'toast_front_css',
            'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css', 
            [],
            time()
          );
    
          
        
          wp_enqueue_style(
            'wpplugin-frontend-boostrap',
            $this->tentee_plugin_url . 'assets/assets/bootstrap/css/bootstrap.min.css', 
            [],
            time()
          );
          wp_enqueue_style(
            'wpplugin-frontend-cart',
            $this->tentee_plugin_url . 'assets/frontend/css/style.css',
            [],
            time()
          );
    
    }
    public function add_data_attribute($tag, $handle) {
    
      if ( 'ib_stripe' !== $handle )
       return $tag;
       if(isset( get_option('Payments_Settings')['Parametre_payement'] )){
        $tst = STRIPE_PUBLISHABLE_KEY ; 
       }else{
        $tst = 0 ;
       }
       return str_replace( 'src', 'STRIPE_PUBLISHABLE_KEY = '.$tst.' src', $tag );
   }
  


	public function enqueue_script() {

        wp_enqueue_script(
            'IB-reservation-front',
            $this->tentee_plugin_url . 'assets/frontend/js/wpplugin-frontend.js',
            ['jquery'],
            time()
          );
          wp_localize_script( 'IB-reservation-front' , 'settingoption' , [ "ajaxurl" => admin_url( 'admin-ajax.php' ) ]  );
          wp_localize_script( 'IB-reservation-front' , 'reservationFront' , [ "ajaxurl" => admin_url( 'admin-ajax.php' ) ]  );
          wp_enqueue_script(
            'stripe_js',
            "https://js.stripe.com/v2/", 
            [],
            time()
          );
          wp_enqueue_script(
            'ib_stripe',
            $this->tentee_plugin_url . 'assets/frontend/js/stripe.js', 
            array('jquery'),
            time()
          ); wp_localize_script( 'ib_stripe' , 'ajaxstripe' , [ "ajaxurl" => admin_url( 'admin-ajax.php' ) ]  );
          
          
           wp_enqueue_script(
            'instant_sweetalert',
            $this->tentee_plugin_url . 'assets/main/sweetalert2.all.min.js', 
            ['jquery'],
            time()
          );
          wp_enqueue_script(
            'wpplugin-select2',
            $this->tentee_plugin_url . 'assets/assets/select2/select2.min.js', 
            [],
            time()
          );
          wp_enqueue_script(
            'wpplugin-moment',
            $this->tentee_plugin_url . 'assets/frontend/js/moment.js', 
            [],
            time()
          );
          wp_enqueue_script( 
            'bootstrap_js',
            'https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js',
              array('jquery'),
            NULL, 
            true 
          );
          wp_enqueue_script(
            'toastfront',
            'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js', 
            [],
            time()
          );
           
          wp_enqueue_script(
            'Ib-calendar-front',
            $this->tentee_plugin_url . 'assets/frontend/js/lightpick.js',
            ['jquery'],
            time()
          );
        
          wp_enqueue_script(
            'tentee_admin_calendar_js',
            $this->tentee_plugin_url . 'assets/assets/fullcalendar/lib/main.js', 
            [],
            time()
          );
          // wp_enqueue_script(
          //   'tentee_calendar_js',
          //   $this->tentee_plugin_url . 'assets/admin/js/calendar.js', 
          //   [],
          //   time()
          // );
          // wp_localize_script( 'wpplugin-admin' , 'calendarajax' , [ "ajaxurl" => admin_url( 'admin-ajax.php' ) ]  );

	}

}

