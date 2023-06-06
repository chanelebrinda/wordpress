<?php 

namespace Inc\Base;

use Inc\Base\BaseController;
use Inc\Controls\AdminCallbacks;

class TaxonomyController extends BaseController
{

	public $callbacks;

	public $taxonomies = array();

	public function register() {

		$this->callbacks = new AdminCallbacks();

		$this->storeCustomTaxonomies();

		if ( ! empty( $this->taxonomies ) ) {
			add_action( 'init', array( $this, 'registerCustomTaxonomy' ));
		//	add_action( 'add_meta_boxes', array( $this, 'ExtrarMeta_boxes' ) );
			add_action( 'extra_add_form_fields',array( $this,  'extra_add_term_price' ));
			add_action( 'categorie_add_form_fields',array( $this,  'categorie_add_term_price' ));
			
			add_action( 'extra_edit_form_fields',array( $this,  'extra_edit_term_price'), 10, 2 ); 
			add_action( 'categorie_edit_form_fields',array( $this,  'categorie_edit_term_price'), 10, 2 );  

            add_action( 'created_extra', array( $this, 'extra_save_taxonomy'), 10, 2 );
			add_action( 'edited_extra', array( $this, 'extra_save_taxonomy'), 10, 2 );
			add_action( 'created_categorie', array( $this, 'categorie_save_taxonomy'), 10, 2 );
			add_action( 'edited_categorie', array( $this, 'categorie_save_taxonomy'), 10, 2 );
			
	}
  }
	
	public function extra_add_term_price($term) {
		?>
		<div class="form-field">
			<label for="extraPrice"><?php _e( 'Prix', 'instant_booking' ); ?></label>
			<input type="text" name="extraPrice" id="extraPrice"value="">
			 
		</div>
	<?php
	}
	public function categorie_add_term_price($term) {
		?>
		<div class="form-field">
			<label for="categoriePrice"><?php _e( 'Prix', 'instant_booking' ); ?></label>
			<input type="text" name="categoriePrice" id="categoriePrice"value="">
			 
		</div>
	<?php
	}
	public function extra_edit_term_price($term) {
		?>
		<tr class="form-field">
			<th><label for="extraPrice"><?php _e( 'Prix', 'instant_booking' ); ?></label></th>
			<td>
				<input name="extraPrice" id="extraPrice" type="text" value="<?php echo esc_attr( get_term_meta( $term->term_id, 'extraPrice',true) );?>" />
				<p class="description"><?php _e( 'le prix peut aller ici', 'instant_booking' ); ?>.</p>
			</td>
		</tr>
    	<?php
	}
	public function categorie_edit_term_price($term) {
		?>
		<tr class="form-field">
			<th><label for="categoriePrice"><?php _e( 'Prix', 'instant_booking' ); ?></label></th>
			<td>
				<input name="categoriePrice" id="categoriePrice" type="text" value="<?php echo esc_attr( get_term_meta( $term->term_id, 'categoriePrice',true) );?>" />
				<p class="description"><?php _e( 'le prix peut aller ici', 'instant_booking' ); ?>.</p>
			</td>
		</tr>
    	<?php
	}

	public function extra_save_taxonomy( $term_id ) {

		$is_valid_nonce = ( isset( $_POST[ 'pr_evenement_box_nonce' ] ) && wp_verify_nonce( $_POST[ 'pr_evenement_box_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

		if( isset( $_POST[ 'extraPrice' ]) ) {
			update_term_meta( $term_id, 'extraPrice', sanitize_text_field( $_POST[ 'extraPrice' ] ) );
		}

	}  
	public function categorie_save_taxonomy( $term_id ) {

		$is_valid_nonce = ( isset( $_POST[ 'pr_evenement_box_nonce' ] ) && wp_verify_nonce( $_POST[ 'pr_evenement_box_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

		if( isset( $_POST[ 'categoriePrice' ]) ) {
			update_term_meta( $term_id, 'categoriePrice', sanitize_text_field( $_POST[ 'categoriePrice' ] ) );
		}

	}



	

	public function storeCustomTaxonomies()
	{
	
			$labels = array(
				'name'              => 'Extras',
				'singular_name'     => 'extra',
				'search_items'      => 'Rechercher un extra',
				'all_items'         => 'Tous les extras',
				'parent_item'       => 'Parent extra',
				'parent_item_colon' => 'Parent extra :',
				'edit_item'         => 'Edit extra',
				'update_item'       => 'Mettre à jour extra',
				'add_new_item'      => 'Ajouter un nouvelle extra',
				'new_item_name'     => 'Nom du Nouvelle extra',
				'menu_name'         => 'Extras',
			);
			$labels2 = array(
				'name'              => 'Categories',
				'singular_name'     => 'categorie',
				'search_items'      => 'Rechercher un categorie',
				'all_items'         => 'Tous les categories',
				'parent_item'       => 'Parent categorie',
				'parent_item_colon' => 'Parent categorie :',
				'edit_item'         => 'Edit categorie',
				'update_item'       => 'Mettre à jour categorie',
				'add_new_item'      => 'Ajouter un nouvelle categorie',
				'new_item_name'     => 'Nom du Nouvelle categorie',
				'menu_name'         => 'Categories',
			);

			$this->taxonomies = array(

				array(
					'tax_name'          => 'categorie',
					'objects'           => 'service',
					'labels'            => $labels2,
					'hierarchical'      => true,
					'show_ui'           => true,
					'show_in_menu'      => true,
					'show_admin_column' => true,
					'rewrite'           => array( 'slug' => 'categorie'),

					),

				array(
					'tax_name'          => 'extra',
					'hierarchical'      => true,
					'labels'            => $labels,
					'show_ui'           => true,
					'show_admin_column' => true,
					'show_in_menu'      => true,
					'rewrite'           => array( 'slug' => 'extra' ),
					'objects'           => 'service'
				),
					
			);


	}

	public function registerCustomTaxonomy()
	{
		foreach ($this->taxonomies as $taxonomy) {
			
			register_taxonomy( $taxonomy['tax_name'], $taxonomy['objects'], $taxonomy );
		}
	}
	 
	function save_taxonomy_metadata( $term_id ) {
		if ( isset($_POST['meta_title']) )
		  update_term_meta( $term_id, 'meta_title', esc_attr($_POST['meta_title']) );
	  
		if ( isset($_POST['meta_description']) )
		  update_term_meta( $term_id, 'meta_description', esc_attr($_POST['meta_description']) );
	  }
	 


}

