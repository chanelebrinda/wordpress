<?php 

namespace Inc\Base;

use Inc\Base\BaseController;
use Inc\Controls\AdminCallbacks;
use Inc\Database\Tentee_reservation_select;

class CPTController extends BaseController
{
    
	public $custom_post_types = array();
	public $meta_boxes = array();
	public $meta_register = array();
	
	

	public function register() {

		$this->callbacks = new AdminCallbacks();
		$this->sendhistorique = new Tentee_reservation_select();
        $this->storeCustomPostTypes();
		$this->storeMeta_boxes();
		

       // add_action( 'init', 'evenement_cpt' );
        if ( ! empty( $this->custom_post_types ) ) {
			add_action( 'init', array( $this, 'registerCustomPostTypes' ) );
		}
		if ( ! empty( $this->meta_boxes ) ) {
			add_action( 'add_meta_boxes', array( $this, 'registerMeta_boxes' ) );
			add_action( 'save_post',  array( $this, 'client_save_postdata') );		
			add_action( 'save_post',  array( $this, 'evenement_save_postdata') );
			add_action( 'save_post',  array( $this, 'Services_save_postdata') );
			add_action( 'delete_post',array($this ,'tentee_reservation_historique_delete'));
			add_action( 'edit_post',array($this , 'tentee_reservation_historique_update'));
			//add_action( 'edit_post',array($this , 'tentee_reservation_historique_add'));
			
			add_filter( 'manage_service_posts_columns', array( $this,'smashing_custum_admin_columns_service') );
			//add_filter( 'manage_evenement_posts_columns', array( $this,'smashing_custum_admin_columns_evenement') );	
			add_filter( 'manage_client_posts_columns', array( $this,'smashing_custum_admin_columns_client' ));
		
			//add_action( 'manage_evenement_posts_custom_column', array( $this,'smashing_custum_admin_evenement'), 10, 2);
			add_action( 'manage_client_posts_custom_column', array( $this,'smashing_custum_admin_client'), 10, 2);	
			add_action( 'manage_service_posts_custom_column', array( $this,'smashing_custum_admin_services'), 10, 2);
	
		 	add_filter( 'single_template',array( $this, 'Instant_Booking_single_template') );
	
		}

		if(! empty( $this->meta_register ) ){
			add_action( 'init',  array( $this, 'myguten_register_user_meta' ));
		}
	
	}

	public function myguten_register_post_meta() {
        register_meta( 'user', 'user_phone', array(
            'type' => 'string',
            'description' => 'user phone',
            'single' => true,
            'show_in_rest' => 'true',
        ) );
    }

	public function Instant_Booking_single_template( $single_template ){
		global $post;

		$file = dirname(__FILE__) .'/template/pages/single-'. $post->post_type .'.php';

		if( file_exists( $file ) ) $single_template = $file;

		return $single_template;
	}

    public function storeCustomPostTypes()
	{
		$this->custom_post_types = array(
		// 	array('post_type'             => 'evenement',
		// 	'name'                  => 'Evenements',
		// 	'singular_name'         => 'Evenement',
		// 	'add_new_item'          => 'Ajouter un evenement',
		// 	'add_new'               => 'Ajouter evenement',
		// 	'new_item'              => 'Nouveau evenement',
		// 	'edit_item'             => 'Éditer le evenement',
		// 	'update_item'           => 'Mettre à jour',
		// 	'view_item'             => 'Afficher le evenement',
		// 	'view_items'            => 'Afficher les evenements',
		// 	'search_items'          => 'Rechercher parmi les evenements',
		// 	'not_found'             => 'Pas de evenement trouvé',
		// 	'not_found_in_trash'    => 'Pas de evenement dans la corbeille',

		// 	'label'                 => 'Evenement',
		// 	'description'           => "",
		// 	'supports'              => array( 'title', 'editor' ,'thumbnail' ),
		// 	'taxonomies'            => array(),
		// 	'hierarchical'          => true,
		// 	'public'                => true,
		// 	'show_ui'               => true,
		// 	'show_in_menu'          => 'plugin_reservation',
		// 	'show_in_admin_bar'     => true,
		// 	'show_in_nav_menus'     => true,
		// 	'can_export'            => true,
		// 	'has_archive'           => true,
		// 	'exclude_from_search'   => false,
		// 	'publicly_queryable'    => true,
		// 	'capability_type'       => 'post'
		// ),
		
			array('post_type'       => 'client',
			'name'                  => __('Clients','instant_booking'),
			'singular_name'         => __('Client','instant_booking'),
			'all_items'             => __('Tous les clients','instant_booking'),
			'add_new_item'          => __('Ajouter un client','instant_booking'),
			'add_new'               => __('Ajouter un client','instant_booking'),
			'new_item'              => __('Nouvelles client','instant_booking'),
			'edit_item'             => __('Éditer le client','instant_booking'),
			'update_item'           => __('Mettre à jour le client','instant_booking'),
			'view_item'             => __('Afficher le client','instant_booking'),
			'view_items'            => __('Afficher les clients','instant_booking'),
			'search_items'          => __('Rechercher parmi les clients','instant_booking'),
			'not_found'             => __('Pas de client trouvé','instant_booking'),
			'not_found_in_trash'    => __('Pas de client dans la corbeille','instant_booking'),

			'label'                 =>  __('Client','instant_booking'),
			'description'           => "",
			'supports'              => array(''),	
			'taxonomies'            => array(),
			'hierarchical'          => true,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => 'plugin_reservation',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'post'
		),

			array('post_type'       => 'service',
			'name'                  => 'Services',
			'singular_name'         => 'Service',
			'all_items'             => 'Tous les services',
			'add_new_item'          => 'Ajouter un service',
			'add_new'               => 'Ajouter un service',
			'new_item'              => 'Nouvelles service',
			'edit_item'             => 'Éditer la service',
			'update_item'           => 'Mettre a jour la service',
			'view_item'             => 'Afficher le service',
			'view_items'            => 'Afficher les services',
			'search_items'          => 'Rechercher parmi les services',
			'not_found'             => 'Pas de service trouvé',
			'not_found_in_trash'    => 'Pas de service dans la corbeille',

			'label'                 => 'Service',
			'description'           => "",
			'supports'              => array( 'title', 'editor', 'thumbnail','post-formats' ),
			'taxonomies'            => array('extra','categorie'),
			'hierarchical'          => true,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => 'plugin_reservation',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'post'
			)
		);
		
	}


    public function registerCustomPostTypes()
	{

		foreach ($this->custom_post_types as $post_type) {
			register_post_type( $post_type['post_type'],
				array(
					'labels' => array(
						'name'                  => $post_type['name'],
						'singular_name'         => $post_type['singular_name'],
					    'add_new_item'          => $post_type['add_new_item'],
						'add_new'               => $post_type['add_new'],
						'new_item'              => $post_type['new_item'],
						'edit_item'             => $post_type['edit_item'],
						'update_item'           => $post_type['update_item'],
						'view_item'             => $post_type['view_item'],
						'view_items'            => $post_type['view_items'],
						'search_items'          => $post_type['search_items'],
						'not_found'             => $post_type['not_found'],
						'not_found_in_trash'    => $post_type['not_found_in_trash'],
					),
					'label'                     => $post_type['label'],
					'description'               => $post_type['description'],
					'supports'                  => $post_type['supports'],
					'taxonomies'                => $post_type['taxonomies'],
					'hierarchical'              => $post_type['hierarchical'],
					'public'                    => $post_type['public'],
					'show_ui'                   => $post_type['show_ui'],
					'show_in_menu'              => $post_type['show_in_menu'],
					'show_in_admin_bar'         => $post_type['show_in_admin_bar'],
					'show_in_nav_menus'         => $post_type['show_in_nav_menus'],
					'can_export'                => $post_type['can_export'],
					'has_archive'               => $post_type['has_archive'],
					'exclude_from_search'       => $post_type['exclude_from_search'],
					'publicly_queryable'        => $post_type['publicly_queryable'],
					'capability_type'           => $post_type['capability_type'],
				)
			);
		}
	}
/*********************************services*************************** */
	
	Public function smashing_custum_admin_columns_service( $columns ) {
	
		$columns = array(
			'cb' => $columns['cb'],
			'image' => __( 'Image' ),
			'title' => __( 'Titre' ),
			'prix' => __( 'Prix', 'smashing' ),
			'extra' => __( 'Extra', 'smashing' ),
			'Categorie' => __( 'Categorie', 'smashing' ),
		  );

     	return $columns;
	}


	Public function smashing_custum_admin_services( $column, $post_id ) {
	// Image column
    $devise = '';
    if( isset( get_option('Payments_Settings')['Parametre_devise'] ) || isset( get_option('reservation_settings')['Parametre_mode_reservation'] ) ) {
      $devise = esc_html( get_option('Payments_Settings')['Parametre_devise']  );
	  $mode = esc_html(get_option('reservation_settings')['Parametre_mode_reservation']);
    }else{
	  $devise = esc_html( get_option( '$' ));
	  $mode = esc_html('/jour');
    }

		if ( 'image' === $column ) {
			echo get_the_post_thumbnail( $post_id, array(100, 100) );
		}

		if ( 'prix' === $column ) {
			$prix = get_post_meta( $post_id, 'serv_prix', true );
		
			if ( ! $prix ) {
			  _e( 'n/a' );  
			} else {
			  echo  number_format( $prix, 0, '.', ',' ).$devise . $mode;
			}
		}

		if ( 'extra' === $column ) {
		$termsString = ""; 
		$extras = get_the_terms( $post_id, 'extra' );
		if ( ! $extras ) {
			_e( 'n/a' );  
		}else{
	    	foreach ( $extras as $extra ) { 
			   $termsString .= $extra->name.' </br>'; 
			}
			echo  $termsString;
		  }
		}
		
		if ( 'Categorie' === $column ) {
			$terms = ""; 
			$categories = get_the_terms( $post_id, 'categorie' );
			if ( ! $categories ) {
				_e( 'n/a' );  
			}else{
			  foreach ( $categories as $categorie ) { 
				$terms .= $categorie->name.' , '; 
				
		    	}
				echo  $terms;
			}
		}
		
	}

	/******************************evenement************** */

	Public function smashing_custum_admin_columns_evenement( $columns ) {
	
		$columns = array(
			'cb' => $columns['cb'],
			'image' => __( 'Image' ),
			'title' => __( 'Titre' ),
			'prix' => __( 'Prix', 'smashing' ),
			'Date_debut' => __( 'Debut', 'smashing' ),
			'Date_fin' => __( 'Fin', 'smashing' ),
			'place' => __( 'plase(s)', 'smashing' ),
		  );

     	return $columns;
	}

	Public function smashing_custum_admin_evenement( $column, $post_id ) {
		// Image column
		$devise = '';
		if( isset( get_option('Payments_Settings')['Parametre_devise'] )) {
		  $devise = esc_html( get_option('Payments_Settings')['Parametre_devise']  );
		}else{
		  $devise = esc_html( get_option( '$' ));
		}
	
			if ( 'image' === $column ) {
				echo get_the_post_thumbnail( $post_id, array(100, 100) );
			}
	
			if ( 'prix' === $column ) {
				$prix = get_post_meta( $post_id, 'pr_price', true );
			
				if ( ! $prix ) {
				  _e( 'n/a' );  
				} else {
				  echo  number_format( $prix, 0, '.', ',' ).$devise;
				}
			}
			
			if ( 'place' === $column ) {
				$place = get_post_meta( $post_id, 'pr_places', true );


			
				if ( ! $place ) {
				  _e( 'n/a' );  
				} else {
				  echo  $place;
				}
			}

			if ( 'Date_debut' === $column ) {
				$Date_debut = get_post_meta( $post_id, 'pr_datetime_start', true );
		    	$daten=date_create($Date_debut);
				if ( ! $Date_debut ) {
				  _e( 'n/a' );  
				} else {
				  echo date_format($daten,"F d, Y");
				}
			}
			if ( 'Date_fin' === $column ) {
				$Date_fin = get_post_meta( $post_id, 'pr_datetime_end', true );
				$daten=date_create($Date_fin);
				if ( ! $Date_fin ) {
				  _e( 'n/a' );  
				} else {
				  echo   date_format($daten,"F d, Y");
				}
			}

			
			
		}
	/******************************clients********************* */

	Public function smashing_custum_admin_columns_client( $columns ) {
	
		$columns = array(
			'cb' => $columns['cb'],
			'nom_prenom' => __( 'Nom et Prenom' ),
			'email' => __( 'Email' ),
			'telephone' => __( 'Telephone', 'smashing' ),
			'adresse' => __( 'Adresse', 'smashing' ),
		  );

     	return $columns;
	}

	Public function smashing_custum_admin_client( $column, $post_id ) {
	
			if ( 'nom_prenom' === $column ) {
				$nom = get_post_meta( $post_id, 'pr_nom', true );
				$prenom = get_post_meta( $post_id, 'pr_prenom', true );
			
				if ( ! $nom || !$prenom ) {
				  _e( 'n/a' );  
				} else {
				  echo $nom .' '. $prenom ;
				}
			}

			if ( 'email' === $column ) {
				$email = get_post_meta( $post_id, 'pr_mail', true );
			
				if ( ! $email ) {
				  _e( 'n/a' );  
				} else {
				  echo $email ;
				}
			}

			if ( 'telephone' === $column ) {
				$telephone = get_post_meta( $post_id, 'pr_tel', true );
			
				if ( ! $telephone ) {
				  _e( 'n/a' );  
				} else {
				  echo $telephone ;
				}
			}

			if ( 'adresse' === $column ) {
				$adresse = get_post_meta( $post_id, 'pr_adresse', true );
			
				if ( ! $adresse ) {
				  _e( 'n/a' );  
				} else {
				  echo $adresse ;
				}
			}

		}

/************************************meta box******************************** */	
	
	
	public function storeMeta_boxes()
	{
		$this->meta_boxes = array(
			array(
				'Unique_ID'             => 'evenement_box_id',
				'Box_title'             =>  'evenements',
				'callback'              => array( $this->callbacks,'evenemements_box_html'),
				'post_type'             => 'evenement',
				'section_page'          => 'normal',
				'ordre_section'        => 'low'
		
			),
			array(
				'Unique_ID'             => 'service_box_id',
				'Box_title'             =>  'services',
				'callback'              => array( $this->callbacks,'services_box_html'),
				'post_type'             => 'service',
				'section_page'          => 'normal',
				'ordre_section'        => 'low'
		
			),
			array(
				'Unique_ID'             => 'client_box_id',
				'Box_title'             =>  'clients',
				'callback'              => array( $this->callbacks,'client_box_html'),
				'post_type'             => 'client',
				'section_page'          => 'normal',
				'ordre_section'        => 'low'
			)
		);
	}

	public function registerMeta_boxes()
	{
		foreach ($this->meta_boxes as $meta) {
			add_meta_box(  $meta['Unique_ID'], $meta['Box_title'],$meta['callback'],$meta['post_type'],$meta['section_page'],$meta['ordre_section']);
		}
	}

	 

	public function evenement_save_postdata( $post_id ) {
	  
		 // Checks save status
		 $is_autosave = wp_is_post_autosave( $post_id );
		 $is_revision = wp_is_post_revision( $post_id );
		 $is_valid_nonce = ( isset( $_POST[ 'pr_evenement_box_nonce' ] ) && wp_verify_nonce( $_POST[ 'pr_evenement_box_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
	  
		 // Exits script depending on save status
		 if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
			 return;
		 }
	  
		 // Checks for input and sanitizes/saves if needed
		  if( isset( $_POST[ 'pr_datetime_start' ]) ) {
			update_post_meta( $post_id, 'pr_datetime_start', sanitize_text_field( $_POST[ 'pr_datetime_start' ] ) );
		  }
		  if( isset( $_POST[ 'pr_datetime_end' ]) ) {
			update_post_meta( $post_id, 'pr_datetime_end', sanitize_text_field( $_POST[ 'pr_datetime_end' ] ) );
		  }
		  if( isset( $_POST[ 'pr_lieu' ]) ) {
			update_post_meta( $post_id, 'pr_lieu', sanitize_text_field( $_POST[ 'pr_lieu' ] ) );
		  }
		
		   if( isset( $_POST[ 'pr_price' ] ) ) {
			update_post_meta( $post_id, 'pr_price', sanitize_text_field( $_POST[ 'pr_price' ] ) );
		   }
		   if( isset( $_POST[ 'pr_symbole' ]) ) {
			update_post_meta( $post_id, 'pr_symbol', sanitize_text_field( $_POST[ 'pr_symbol' ] ) );
		   }
		   if( isset( $_POST[ 'pr_places' ]) ) {
			update_post_meta( $post_id, 'pr_places', sanitize_text_field( $_POST[ 'pr_places' ] ) );
		  }
	  
	  }
	  
	public function tentee_reservation_historique_delete($post_id) {
		$d = ['service' , 'client' , 'evenement'];

		if(in_array(get_post_type($post_id) , $d)){
			global $wpdb;
			$id_em = get_current_user_id();
			$created_on = date('Y-m-d H:i:s');
			$actions = 'Suppression';
			$type_r= get_post($post_id)->post_type ;
			$sql = "INSERT INTO IB_tentee_historique (id_employe,id_element,actions,type_r,created_on) VALUES ('$id_em',$post_id,'$actions','$type_r','$created_on')";
			$result = $wpdb->get_results ($sql);
			return $result; // display data
	   }
	}
	public function tentee_reservation_historique_update($post_id) {
		$d = ['service' , 'client' , 'evenement'];
		
		if(in_array(get_post_type($post_id) , $d)){
			global $wpdb;
			$id_em = get_current_user_id();
			$created_on = date('Y-m-d H:i:s');
			$actions = 'Création ou Mise à jour ';
			$type_r= get_post($post_id)->post_type ;
			$sql = "INSERT INTO IB_tentee_historique (id_employe,id_element,actions,type_r,created_on) VALUES ('$id_em',$post_id,'$actions','$type_r','$created_on')";
			$result = $wpdb->get_results ($sql);
			return $result; // display data
		}
	}

	  public function Services_save_postdata( $post_id) {
		// Checks save status
		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );
		$is_valid_nonce = ( isset( $_POST[ 'pr_services_box_nonce' ] ) && wp_verify_nonce( $_POST[ 'pr_services_box_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
		
		// Exits script depending on save status
		if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
			return;
		}
		
	
		// Checks for input and sanitizes/saves if needed
		if( isset( $_POST[ 'serv_prix' ] ) ) {
			update_post_meta( $post_id, 'serv_prix', sanitize_text_field( $_POST[ 'serv_prix' ] ) );
		   }

	 }

	  public function client_save_postdata( $post_id) {
		// Checks save status
		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );
		$is_valid_nonce = ( isset( $_POST[ 'pr_client_box_nonce' ] ) && wp_verify_nonce( $_POST[ 'pr_client_box_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
	 
		// Exits script depending on save status
		if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
			
			return;
		}

		if( isset( $email ) && !is_email( $email )) {



			update_post_meta( $post_id, 'pr_mail', sanitize_text_field( $_POST[ 'pr_mail' ] ) );
		
			$cpt = 1;
	   
			// Checks for input and sanitizes/saves if needed
			if( isset( $_POST[ 'pr_nom' ]) ) {
			update_post_meta( $post_id, 'pr_nom', sanitize_text_field( $_POST[ 'pr_nom' ] ) );
			}
			if( isset( $_POST[ 'pr_prenom' ] )) {
			update_post_meta( $post_id, 'pr_prenom', sanitize_text_field( $_POST[ 'pr_prenom' ] ) );
			}
			if( isset( $_POST[ 'pr_mail' ] ) ) {
			update_post_meta( $post_id, 'pr_mail', sanitize_text_field( $_POST[ 'pr_mail' ] ) );
			}
			if( isset( $_POST[ 'pr_tel' ]) ) {
			update_post_meta( $post_id, 'pr_tel', sanitize_text_field( $_POST[ 'pr_tel' ] ) );
			}
			if( isset( $_POST[ 'pr_adresse' ]) ) {
				update_post_meta( $post_id, 'pr_adresse', sanitize_text_field( $_POST[ 'pr_adresse' ] ) );
			}
			if( isset( $_POST[ 'pr_pays' ]) ) {
				update_post_meta( $post_id, 'pr_pays', sanitize_text_field( $_POST[ 'pr_pays' ] ) );
			}
			if( isset( $_POST[ 'pr_ville' ]) ) {
				update_post_meta( $post_id, 'pr_ville', sanitize_text_field( $_POST[ 'pr_ville' ] ) );
			}
			if( isset( $_POST[ 'pr_zip' ]) ) {
				update_post_meta( $post_id, 'pr_zip', sanitize_text_field( $_POST[ 'pr_zip' ] ) );
			}
			
			if( isset( $_POST[ 'pr_note' ]) ) {
				update_post_meta( $post_id, 'pr_note', sanitize_text_field( $_POST[ 'pr_note' ] ) );
			}

			$found= get_post($post_id)->ID; 
			if($found == Null ){
				update_post_meta( $post_id, 'pr_compteur', 1);
			  }
	   }
	 }
	

	 


}

