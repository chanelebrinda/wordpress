<?php 

namespace Inc\Settings;

use Inc\Base\BaseController;

class ManagerCallbacks extends BaseController
{

	public function Paiment_callback() {
		echo "<hr>";
		  esc_html_e( 'Plugin de reseervation', 'plugin_reservation' );
		}

	public function checkboxField( $args )
	{
		$name = $args['label_for'];
		$classes = $args['class'];
		$option_name = $args['option_name'];
		$checkbox = get_option( $option_name );
		$checked = isset($checkbox[$name]) ? ($checkbox[$name] ? true : false) : false;

		echo '<div class="' . $classes . '"><input type="checkbox" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="1" class="" ' . ( $checked ? 'checked' : '') . '><label for="' . $name . '"><div></div></label></div>';
	}
	public function InputField( $args )
	{
		$name = $args['label_for'];
		$classes = $args['class'];
		$option_name = $args['option_name'];
		$input = get_option( $option_name );
		$value = isset($input[$name]) ? esc_html($input[$name]) : '';

		echo '<div class="' . $classes . '"><input type="text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="'.$value.'" class="" ' . ( $checked ? 'checked' : '') . '><label for="' . $name . '"><div></div></label></div>';
	}

	public function TextAreaField( $args )
	{
		$name = $args['label_for'];
		$classes = $args['class'];
		$option_name = $args['option_name'];
		$checkbox = get_option( $option_name );
		$input = get_option( $option_name );
		$value = isset($input[$name]) ? esc_html($input[$name]) : '';

		echo '<div class="' . $classes . '"><textarea type="checkbox" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="'.$value.'" class="" ' . ( $checked ? 'checked' : '') . '></textarea><label for="' . $name . '"><div></div></label></div>';
	}
}