<?php

namespace Inc\Base;

use Inc\Base\BaseController;

class SettingsLinks extends BaseController
{

	public function register() 
	{
		add_filter( "plugin_action_links_$this->tentee_plugin ", array( $this, 'settings_link' ) );
	}

	public function settings_link( $links ) 
	{
		$settings_link = '<a href="admin.php?page=tentee-restaurants">' . __( 'Settings', 'plugin_reservation' ) . '</a>';
		array_push( $links, $settings_link );
		return $links;
	}
}
