<?php 

namespace Inc\Base;

use Inc\Base\BaseController;

class EnqueueAdmin extends BaseController
{
	public function register() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_script' ), 100 );
    add_action( 'admin_enqueue_scripts', array( $this, 'Ib_enqueue_style' ), 100 );
    add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_style' ),90 );
	}
  public function Ib_enqueue_style(){
    
    if (!empty($_GET['page']) && strpos($_GET['page'], 'Instant_') !== false) {
      
      wp_enqueue_style(
        'ib-admin-style',
        $this->tentee_plugin_url . 'assets/admin/css/ib-admin-style.css', 
        [],
        time()
      );

      wp_enqueue_style(
        'toast_admin_css',
        'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css', 
        [],
        time()
      );

      wp_enqueue_style(
        'tentee_admin_calendar',
        $this->tentee_plugin_url . 'assets/assets/fullcalendar/lib/main.min.css', 
        [],
        time()
      );
      wp_enqueue_style( 
        'ib-admin-calendar', 
        $this->tentee_plugin_url . 'assets/admin/css/calendar.css', 
        [],
        time()
       );

       wp_enqueue_style(
        'ib-admin-datatable',
        $this->tentee_plugin_url . 'assets/admin/css/bootstrap-table.min.css', 
        [],
        time()
      );
      
      wp_enqueue_style(
        'wpplugin-frontend-boostrap',
        $this->tentee_plugin_url . 'assets/admin/css/bootstrap-icons.css', 
        [],
        time()
      );
       

    }  
  }

  public function enqueue_style(){
    

    
    if (!empty($_GET['page']) &&  (strpos($_GET['page'], 'Instant_Booking_employe') !== false || strpos($_GET['page'], 'Instant_Booking_settings')!== false || strpos($_GET['page'], 'Instant_Booking_calendar')!== false || strpos($_GET['page'], 'Instant_Booking_reservation')!== false) ){

      wp_enqueue_style( 'load-fa', 'https://use.fontawesome.com/releases/v5.15.4/css/all.css?ver=5.0.2' );

      wp_enqueue_style( 
        'wpb-fa',
        get_stylesheet_directory_uri() . '/fonts/css/font-awesome.min.css' ,
        [],
        time()
        );    
      wp_enqueue_style( 
        'bootstrap_css', 
        'https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css',
          false,
        NULL,
        'all' 
      );


    }
   
    if (!empty($_GET['page']) && strpos($_GET['page'], 'Instant_Booking_dashboard') !== false) {

      wp_enqueue_style(
        'tentee_admin_bootstrap',
        $this->tentee_plugin_url . 'assets/assets/bootstrap/css/bootstrap.min.css', 
        [],
        time()
      );
      
      wp_enqueue_style(
        'ib-admin-main',
        $this->tentee_plugin_url . 'assets/admin/css/main.css', 
        [],
        time()
      );
      wp_enqueue_style(
        'ib-admin-animate',
        $this->tentee_plugin_url . 'assets/admin/css/animate.css', 
        [],
        time()
      );

      wp_enqueue_style(
        'ib-admin-font-awesome',
        $this->tentee_plugin_url . 'assets/admin/css/font-awesome.min.css', 
        [],
        time()
      ); 
      wp_enqueue_style(
        'ib-admin-animate',
        $this->tentee_plugin_url . 'assets/admin/css/responsive.css', 
        [],
        time()
      );
      
    }
     
  }

	public function enqueue_script() {

    wp_enqueue_script(
      'instant_action_js',
      $this->tentee_plugin_url . 'assets/admin/js/instantaction.js', 
      ['jquery'],
      time()
    ); wp_localize_script( 'instant_action_js' , 'ibactions' , [ "ajaxurl" => admin_url( 'admin-ajax.php' ) ]  );

    wp_enqueue_script(
      'calendar-moment',
      $this->tentee_plugin_url . 'assets/frontend/js/moment.js', 
      [],
      time()
    );
    wp_enqueue_script(
      'calendar-moment',
      $this->tentee_plugin_url . 'assets/frontend/js/stripe.js', 
      [],
      time()
    );
    wp_enqueue_script(
      'calendar-moment',
      "https://js.stripe.com/v3/", 
      [],
      time()
    );

    wp_enqueue_script(
      'toast admin',
      'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js', 
      [],
      time()
    );

    wp_enqueue_script(
      'poppccer_js',
      'https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js',
      array('jquery'),
      NULL, 
      true 
    );
    
    if (!empty($_GET['page']) &&  (strpos($_GET['page'], 'Instant_Booking_employe') !== false || strpos($_GET['page'], 'Instant_Booking_settings')!== false  || strpos($_GET['page'], 'Instant_Booking_reservation')!== false) ){

      wp_enqueue_script(
        'ib-admin-main',
        $this->tentee_plugin_url . 'assets/admin/js/ib-admin.js',
        ['jquery'],
        time()
      ); wp_localize_script( 'ib-admin-main' , 'settingoption' , [ "ajaxurl" => admin_url( 'admin-ajax.php' ) ]  );
      wp_enqueue_script(
        'ib-admin-rounded',
        $this->tentee_plugin_url . 'assets/admin/js/bootstrap.bundle.min.js',
        ['jquery'],
        time()
      );
      
      wp_enqueue_script(
        'sidebar_scripts_js',
        $this->tentee_plugin_url . 'assets/admin/js/scripts.js', 
        ['jquery'],
        time()
      );wp_localize_script( 'sidebar_scripts_js' , 'sendIdbd' , [ "ajaxurl" => admin_url( 'admin-ajax.php' ) ]  );


      wp_enqueue_script( 
        'bootstrap_js',
        'https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js',
          array('jquery'),
        NULL, 
        true 
      );

        wp_enqueue_script(
          'instant_sweetalert',
          $this->tentee_plugin_url . 'assets/main/sweetalert2.all.min.js', 
          ['jquery'],
          time()
        );


    }
    if (!empty($_GET['page']) && (strpos($_GET['page'], 'Instant_Booking_reservation') !== false || strpos($_GET['page'], 'Instant_Booking_dashboard') !== false)) {
        
      wp_enqueue_script(
        'ib-admin-datable',
        $this->tentee_plugin_url . 'assets/admin/js/tableExport.min.js',
        ['jquery'],
        time()
      );
     
      wp_enqueue_script(
        'ib-datable',
        $this->tentee_plugin_url . 'assets/admin/js/bootstrap-table.min.js',
        ['jquery'],
        time()
      );
      wp_enqueue_script(
        'admin-datable',
        $this->tentee_plugin_url . 'assets/admin/js/bootstrap-table-export.min.js',
        ['jquery'],
        time()
      );
 
  }
      if (!empty($_GET['page']) && strpos($_GET['page'], 'Instant_Booking_dashboard') !== false) {
           
        wp_enqueue_script(
          'ib-admin-modernizr',
          $this->tentee_plugin_url . 'assets/admin/js/modernizr-2.8.3.min.js',
          ['jquery'],
          time()
        );
    
        wp_enqueue_script(
          'ib_admin_raphael',
          $this->tentee_plugin_url . 'assets/admin/js/raphael-min.js', 
          array('jquery'),
          NULL, 
          true 
        );

        wp_enqueue_script(
          'tentee_admin_morris',
          $this->tentee_plugin_url . 'assets/admin/js/morris.js', 
          array('jquery'),
          NULL, 
          true 
        );

        wp_enqueue_script(
          'ib-admin-morriss',
          $this->tentee_plugin_url . 'assets/admin/js/morris-active.js',
          array('jquery'),
          NULL, 
          true 
        );
  
        wp_enqueue_script(
          'ib-admin-media',
          $this->tentee_plugin_url . 'assets/admin/js/jquery.media.js',
          ['jquery'],
          time()
        );
        
        wp_enqueue_script(
          'ib-admin-area',
          $this->tentee_plugin_url . 'assets/admin/js/jquery.sparkline.min.js',
         array('jquery'),
          NULL, 
          true 
        );
        
        wp_enqueue_script(
          'ib-admin-bar',
          $this->tentee_plugin_url . 'assets/admin/js/jasny-bootstrap.min.js',
         array('jquery'),
          NULL, 
          true 
        );
        
        wp_enqueue_script(
          'popper_js',
          $this->tentee_plugin_url . 'assets/admin/js/popper.min.js',
          array('jquery'),
          NULL, 
          true 
        );
        wp_enqueue_script(
          'ib-admin-line',
          $this->tentee_plugin_url . 'assets/assets/bootstrap/js/bootstrap.min.js', 
         array('jquery'),
          NULL, 
          true 
        );
      

        }
 /******************************calendar menu****************************** */       

          if (!empty($_GET['page']) && strpos($_GET['page'], 'Instant_Booking_calendar') !== false) {

            wp_enqueue_script(
              'tentee_admin_calendar_js',
              $this->tentee_plugin_url . 'assets/assets/fullcalendar/lib/main.js', 
              [],
              time()
            );
           
            wp_enqueue_script(
              'tentee_calendar_js',
              $this->tentee_plugin_url . 'assets/admin/js/calendar.js', 
              ['jquery'],
              time()
            );  wp_localize_script( 'tentee_calendar_js' , 'calendarajax' , [ "ajaxurl" => admin_url( 'admin-ajax.php' ) ]  );  
       
        }
      
	}

}



