<?php
/**
 * Plugin Name: Last Time Login Admin Footer.
 * Description: Adds a simple notifications about how long you've been hanging out on your WordPress site.
 * Author: Nikhil Vimal
 * Author URI: http://nik.techvoltz.com
 * Version: 1.0
 * Plugin URI:
 * License: GNU GPLv2+
 */

class How_Long_Logged_In {

	public function __construct() {
		add_action( 'wp_login', array( $this, 'last_user_login_time' ));
		add_filter( 'admin_footer_text', array( $this, 'logged_in_time_footer' ));


	}

	//update_user_meta
	public function last_user_login_time() {
		$current_user = wp_get_current_user();
		update_user_meta( $current_user->ID, 'user_last_login', time() );
	}

	//Adding on to admin footer
	public function logged_in_time_footer( $footer_text ) {
		$current_user = wp_get_current_user();

		$meta = get_user_meta( $current_user->ID, 'user_last_login', time() );
		$time = sprintf( __( human_time_diff( $meta ) ) );

		if ( is_admin() ) {
			return str_replace( '</span>', '', $footer_text ) . ' | Hi '. $current_user->display_name .'! You&#39;ve been logged in for ' . $time . '</span>';
		} else {
			return str_replace( '</span>', '', $footer_text ) . ' | Hi User! You&#39;ve been logged in for ' . $time . '</span>';

		}


	}
}
new How_Long_Logged_in();

