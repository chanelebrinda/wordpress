<?php 
/**
 * Plugin Name:       Instant-Booking
 * Description:       module de réservation de services(voitures,hotels,salles,outils etc..)
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.3
 * Author:            Tentee global
 * Author URI:        https://tenteeglobal.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       instant_booking
 * Domain Path:       /languages
 */

 // If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_action( 'plugins_loaded', 'tentee_load_text_domain' );
function tentee_load_text_domain() {
    load_plugin_textdomain( 'instant_booking', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

function ib_load_my_own_textdomain( $mofile, $domain ) {
	if ( 'my-domain' === $domain && false !== strpos( $mofile, WP_LANG_DIR . '/plugins/' ) ) {
		$locale = apply_filters( 'plugin_locale', determine_locale(), $domain );
		$mofile = WP_PLUGIN_DIR . '/' . dirname( plugin_basename( __FILE__ ) ) . '/languages/' . $domain . '-' . $locale . '.mo';
	}
	return $mofile;
}
add_filter( 'load_textdomain_mofile', 'ib_load_my_own_textdomain', 10, 2 );

add_action( 'after_setup_theme', 'reset_permalinks' );
function reset_permalinks() {
    global $wp_rewrite;
    $wp_rewrite->set_permalink_structure('/%postname%/');
    $wp_rewrite->flush_rules();
}


if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}
//include (plugin_dir_path( __FILE__ ) . 'dompdf/dompdf/fpdf.php')

use Dompdf\Dompdf;
use Dompdf\Options;

 function ib_facturepdf($book_id){ 
  global $wpdb;
   $result = $wpdb->get_results ("SELECT * FROM IB_tentee_reservation WHERE id = $book_id");
   $num_facture = $result[0]->numero_commande;
   $id_client = $result[0]->id_client;
  $num_facture = $result[0]->numero_commande;
  $id_service = $result[0]->id_service;
  $client_nom=get_post_meta( $id_client, 'pr_nom', true) ;
  $client_prenom =get_post_meta( $id_client, 'pr_prenom', true) ;
  $title= get_post($id_service)->post_title;
  $prix_unique = get_post_meta( $id_service, 'serv_prix', true);              
  $client_tel =get_post_meta( $id_client, 'pr_tel', true) ;
  $client_adr =get_post_meta( $id_client, 'pr_adresse', true) ;
  $prix_total =$result[0]->prix_Total ;
  $status = $result[0]->status_payement;
   $created = fandates($result[0]->created_on);
   $extras = json_decode($result[0]->extra);
  $date_debut = fandates($result[0]->date_debut) ;
  $date_fin = fandates($result[0]->date_fin);

ob_start();
require (plugin_dir_path( __FILE__ ) . 'template/pdf/invoice.php');
$html = ob_get_contents();
ob_end_clean();
// $html = myfactutrInmail($book_id);

$options = new Options();
$options->set('defaultFont', 'Courier');

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html );
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$output = $dompdf->output();
$pdfOutput = 'facture'.uniqid(rand(), true).'.pdf';
file_put_contents( $pdfOutput, $output);

 return $pdfOutput;
}



function ib_historique_pdf(){

  ob_start();
  require (plugin_dir_path( __FILE__ ) . 'template/pdf/facture.php');
  $html = ob_get_contents();
  ob_end_clean();
  
  $options = new Options();
  $options->set('defaultFont', 'Courier');
      
  $dompdf = new Dompdf($options);
  //$options = $dompdf->getOptions();
  $dompdf->loadHtml($html); 
  $dompdf->setPaper('A4', 'portrait'); 
  $dompdf->render();
  $fichier = 'Historique'. date("YmdHis").'.pdf';
  $dompdf->stream($fichier);
  return $fichier;
}

if ( class_exists( 'Inc\\Init' ) ) {
	Inc\Init::register_services();
}

use Inc\Base\Activate;
use Inc\Base\Deactivate;
use Inc\Pages\Admin;

  function tenteeReservation_activate() {
      Activate::activate();
 
  }

  function tenteeReservation_deactivate(){
      Deactivate::deactivate();
  }

  //activer et deactiver le plugin
  register_activation_hook( __FILE__, 'tenteeReservation_activate' );
  register_deactivation_hook( __FILE__,  'tenteeReservation_deactivate' );


  
function add_my_post_types_to_query( $query ) {
  if ( is_home() && $query->is_main_query() )
      $query->set( 'post_type', array( 'post', 'evenement' ) );
  return $query;
}
add_action( 'pre_get_posts', 'add_my_post_types_to_query' );

/**
* Adds a optiond
*/

if( isset( get_option('Payments_Settings')['Parametre_devise'] )|| isset( get_option('reservation_settings')['Parametre_mode_reservation']) || isset( get_option('design_settings')['Parametre_mode_affichage'] ) ) {
  $devise = esc_html( get_option('Payments_Settings')['Parametre_devise']  );
  $mode_affiche = esc_html(get_option('design_settings')['Parametre_mode_affichage']);
  $mode = esc_html(get_option('reservation_settings')['Parametre_mode_reservation']);
  }

/**
* Adds a shortcode
*/
function Event_display()
{
  ob_start();
  require_once( plugin_dir_path( __FILE__ ) . 'template/evenement.php');
  return ob_get_clean();
}
add_shortcode( 'IB_list_services', 'Event_display');

function service_checkout_page()
{
  ob_start();
  require_once( plugin_dir_path( __FILE__ ) . 'template/pages/checkout.php'); 
  return ob_get_clean();
}
add_shortcode( 'IB_checkout', 'service_checkout_page');

function service_service_categorie_page()
{
  ob_start();
  require_once( plugin_dir_path( __FILE__ ) . 'template/pages/service_categorie.php');
	 return ob_get_clean();
}
add_shortcode( 'IB_Categorie', 'service_categorie');

function service_allServices_page()
{
  ob_start();
  require_once( plugin_dir_path( __FILE__ ) . 'template/pages/all-services.php');
	//echo "<script src=\"plugin_dir_path( __FILE__ ) . 'templates/frontend/js/evenement.js'\"></script>";
  return ob_get_clean();
}
add_shortcode( 'IB_all_services', 'service_allServices_page');

function search_block()
{
  ob_start();
  require_once( plugin_dir_path( __FILE__ ) . 'template/pages/search_block.php');
  return ob_get_clean();
}
add_shortcode( 'IB_search_services', 'search_block');


// Create Settings Fields
include( plugin_dir_path( __FILE__ ) . 'includes/wpplugin-settings-fields.php');
// Create des requete ajax
include( plugin_dir_path( __FILE__ ) . 'includes/ajax-handler.php');
include( plugin_dir_path( __FILE__ ) . 'includes/ajaxcalendar.php');
include( plugin_dir_path( __FILE__ ) . 'includes/ajax-payement.php');
// Create a menu cart
include( plugin_dir_path( __FILE__ ) . 'includes/config.php');

// Create Plugin Admin Menus and Setting Pages
include( plugin_dir_path( __FILE__ ) . 'includes/mail/ib_mail.php');

//include( plugin_dir_path( __FILE__ ) . '/template/stripepayement/sessioncart.php');

// creer une table de reservation
include( plugin_dir_path( __FILE__ ) . 'assets/database/Tentee_reservation_creation.php');
include( plugin_dir_path( __FILE__ ) . 'assets/database/Tentee_reservation_insertion.php');


/**
 * iB_single_template
 *
 * allows to redirect the display of an post type to a page configured in 'single_template'.
 * @param  mixed $template
 * @return void
 */
 
add_filter( 'single_template', 'iB_single_template' );
function iB_single_template( $single_template ){
    global $post;
    if('service' === $post->post_type){
    $file = dirname(__FILE__) .'/template/pages/single-service.php';

      $single_template = $file;
    }
    return $single_template;
}
  

add_action('insbook_before_add_to_cart_button', 'add_to_cart_button');
 
  function add_to_cart_button( $post_type){
      if ( isset ( $_GET['reser_id'] ) )
          echo esc_html( $_GET['reser_id'] );  
 }

// Insert the post page  into the database

function add_my_custom_page() {

    // Create post object
    add_page('checkout','checkout','[IB_checkout]');
    add_page('services','services','[IB_all_services]');

}

function add_page($post_title,$post_name,$post_content,$parent_id =NULL){
  $Page = get_page_by_title($post_title, 'OBJECT', 'page');
  if( ! empty( $objPage ) )
  {
      return ;
  }
    $my_services = wp_insert_post(
      array(
      'post_title'    => $post_title,
      'post_status'   => 'publish',
      'post_author'   => 1,
      'post_type'     => 'page',
      'post_name'      => $post_name,
      'post_content'   => $post_content,
      'comment_status' => 'closed',
      'post_parent'    =>  $parent_id,
    )
      );
      return $my_services;
}

function render_search_template( $template ) {
  global $wp_query;
  $post_type = get_query_var( 'post_type' );

  if ( ! empty( $wp_query->is_search )) {
     return  plugin_dir_path( __FILE__ ) . 'template/pages/service_search.php';
  }

  return $template;
}
add_filter( 'template_include', 'render_search_template' ); 

?>
