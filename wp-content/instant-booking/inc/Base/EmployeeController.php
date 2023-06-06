<?php 

namespace Inc\Base;

use Inc\Base\BaseController;
use Inc\Controls\AdminCallbacks;

class EmployeeController extends BaseController
{

	public $callbacks;

	public function register() {

		$this->callbacks = new AdminCallbacks();

			add_action( 'init', array( $this, 'registerUserRole' ));
	
	}

    public function registerUserRole() {
        add_role('employé','Employé',
            array(
                'edit_plugins'          =>true,
                'install_plugins'       =>true,
                'update_plugins'        =>true,
                'moderate_comments'     => true,
                'manage_categories'     => true,
                'manage_links'          => true,
                'edit_others_posts'     => true,
                'edit_pages'            => true,
                'edit_others_pages'     => true,
                'edit_published_pages'  => true,
                'publish_pages'         => true,
                'delete_pages'          => true,
                'delete_others_pages'   => true,
                'delete_published_pages'=> true,
                'delete_others_posts'   => true,
                'delete_private_posts'  => true,
                'edit_private_posts'    => true,
                'read_private_posts'    => true,
                'delete_private_pages'  => true,
                'edit_private_pages'    => true,
                'read_private_pages'    => true,
                'unfiltered_html'       => true,
                'edit_published_posts'  => true,
                'upload_files'          => true,
                'publish_posts'         => true,
                'delete_published_posts'=> true,
                'edit_posts'            => true,
                'delete_posts'          => true,
                'read'                  => true,
                'manage_options'        => true
            ),
        );
    }


}



 
