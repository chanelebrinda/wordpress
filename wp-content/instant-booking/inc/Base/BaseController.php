<?php 

namespace Inc\Base;


class BaseController
{
	public $tentee_plugin_path;

	public $tentee_plugin_url;

	public $tentee_plugin;
	public $date;


	
	public function __construct() {
		$this->tentee_plugin_path = plugin_dir_path( dirname( __FILE__, 2 ) );
		$this->tentee_plugin_url = plugin_dir_url( dirname( __FILE__, 2 ) );
		$this->tentee_plugin = plugin_basename( dirname( __FILE__, 3 ) ) . '/tentee-restaurants.php';
	}
	
}


