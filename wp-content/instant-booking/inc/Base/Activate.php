<?php

namespace Inc\Base;

class Activate
{
	public static function activate() {
		flush_rewrite_rules();
	//	add_my_custom_page();
		tentee_reservation();
	}
}