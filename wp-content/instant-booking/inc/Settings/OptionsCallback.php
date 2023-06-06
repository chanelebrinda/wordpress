<?php 

namespace Inc\Settings;

use Inc\Settings\SettingsApi;
use Inc\Base\BaseController;
use Inc\Controls\AdminCallbacks;
use Inc\Settings\ManagerCallbacks;

class OptionsCallback extends BaseController
{
	public $settings;

	public $callbacks;

	public $callbacks_mngr;

	public function register() 
	{
		$this->settings = new SettingsApi();

		$this->callbacks = new AdminCallbacks();

		$this->callbacks_mngr = new ManagerCallbacks();

		$this->setSettings();
		$this->setSections();
		$this->setFields();

	}

	public function setSettings()
	{
		$args = array(
			array(
				'option_group' => 'Tentee_reservation_settings',
				'option_name' => 'Tentee_settings_name',
				'callback' => array( $this->callbacks_mngr, 'InputField' )
			),
			array(
				'option_group' => 'Tentee_reservation_entreprise',
				'option_name' => 'Entreprise_settings',
				'callback' => array( $this->callbacks_mngr, 'InputField' )
			),
			array(
				'option_group' => 'Tentee_reservation_horaire',
				'option_name' => 'Horaire_settings',
				'callback' => array( $this->callbacks_mngr, 'InputField' )
			),
			array(
				'option_group' => 'Tentee_Payments_Settings',
				'option_name' => 'Payments_Settings',
				'callback' => array( $this->callbacks_mngr, 'InputField' )
			)
		);

		$this->settings->setSettings( $args );
	}

	public function setSections()
	{
		$args = array(
			array(
				'id' => 'Parametre_general',
				'title' => __( 'General', 'plugin_reservation' ),
				'callback' => array( $this->callbacks_mngr, 'Paiment_callback' ),
			),
			array(
				'id' => 'Parametre_payement',
				'title' => __( 'Paiment', 'plugin_reservation' ),
				'callback' => array( $this->callbacks_mngr, 'Paiment_callback' ),
			)
		);

		$this->settings->setSections( $args );
	}

	public function setFields()
	{
		$args = array();

			$args[] = array(
				array('id' => 'Parametre_title',
				'title' => __( 'Nom de l\'entreprise', 'plugin_reservation'),
				'callback' => array( $this->callbacks_mngr, 'InputField' ),
				'section' => 'Parametre_general',
				'args' => array(
					'option_name' => 'Tentee_settings_name',
					'label_for' => __( 'Nom de l\'entreprise', 'plugin_reservation'),
					'class' => 'ui-settings'
				)),
				array('id' => 'Parametre_currency',
				'title' => __( 'Currency', 'plugin_reservation'),
				'callback' => array( $this->callbacks_mngr, 'TextAreaField' ),
				'section' => 'Parametre_payement',
				'args' => array(
					'option_name' => 'Tentee_settings_name',
					'label_for' => __( 'Currency', 'plugin_reservation'),
					'class' => 'ui-settings'
				))
			);

		$this->settings->setFields( $args );
	}
}