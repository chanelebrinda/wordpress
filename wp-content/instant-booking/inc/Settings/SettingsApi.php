<?php 

namespace Inc\Settings;

class SettingsApi
{
	public $settings = array();

	public $sections = array();

	public $fields = array();

	public function register()
	{
		if ( !empty($this->settings) ) {
			add_action( 'admin_init', array( $this, 'registerCustomFields' ) );
		}
	}


	public function setSettings( array $settings )
	{
		$this->settings = $settings;

		return $this;
	}

	public function setSections( array $sections )
	{
		$this->sections = $sections;

		return $this;
	}

	public function setFields( array $fields )
	{
		$this->fields = $fields;

		return $this;
	}

	public function registerCustomFields()
	{
		// register setting
		foreach ( $this->settings as $setting ) {
			register_setting( $setting["option_group"], $setting["option_name"], ( isset( $setting["callback"] ) ? $setting["callback"] : '' ) );
		}

		// add settings section
		foreach ( $this->sections as $section ) {
			add_settings_section( $section["id"], $section["title"], ( isset( $section["callback"] ) ? $section["callback"] : '' ),'plugin_reservation' );
		}

		// add settings field
		foreach ( $this->fields as $field ) {
			add_settings_field( $field["id"], $field["title"], ( isset( $field["callback"] ) ? $field["callback"] : '' ), 'plugin_reservation', $field["section"], ( isset( $field["args"] ) ? $field["args"] : '' ) );
		}
	}
}