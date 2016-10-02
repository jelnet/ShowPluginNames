<?php
/*
Plugin Name: Show Plugin Names
Plugin URI: http://jelnet.uk/show-plugin-names/
Description: Shows the name of plugins in admin settings menus and screens
Version: 1.0.1
Author: Jeremy Wray
Author URI: http://jeremywray.co.uk
License: GPLv2 or later
*/

/*  Copyright 2016 Jeremy Wray

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Plugin constants
 * 
 */

define( 'JEL_SPN_VERSION', '1.0' );
define( 'JEL_SPN_SCRIPT_URL', plugin_dir_url( __FILE__).'js/' );


/**
 * 
 * The plugin base class - the root of all WP goods!
 * 
 * @author nofearinc
 *
 */
class JEL_SPN_Base {

	public $plugin_names = array();
	
	
	
	/**
	 * 
	 * Assign everything as a call from within the constructor
	 */
	public function __construct() {
				
		// add scripts and styles only available in admin
		add_action( 'admin_enqueue_scripts', array( $this, 'jel_spn_add_admin_JS' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'jel_spn_add_admin_CSS' ) );
		
	}	
	
	
	/**
	 *
	 * Adding JavaScript scripts for the admin pages only
	 *	
	 *
	 */	
	
	public function jel_spn_add_admin_JS() {
 		wp_register_script (
 		'jel_spn_tooltips',
		JEL_SPN_SCRIPT_URL . 'script.js',
	 	array( 'jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-position', 'jquery-ui-tooltip' ),
		JEL_SPN_VERSION,
		true
		);
		wp_enqueue_script('jel_spn_tooltips');
		
		$all_plugins = get_plugins();
		
		//write_log("jel - did this? ");
		
		$get_plugin_names = function ($val, $key){
			//this-> $plugin_names = array();
			//global $plugin_names;			
			preg_match("/^[a-z-_]+/", $key, $matches);	
			//$this->plugin_names[$matches[0]] = $matches[0];		
			//$this->plugin_names[$matches[0]] = array('title'=>$val['Title']);		
			$this->plugin_names[] = array('plugin_name' => $matches[0], 'title' => $val['Title']);					
		};
		
		array_walk($all_plugins, $get_plugin_names);		
		
		//$test[] = 1;
		
		
		wp_localize_script( 'jel_spn_tooltips', 'jel_spn_params', $this->plugin_names );
	 }
	 
	 /**
	 *
	 * Add admin CSS styles - available only on admin
	 *
	 */
	public function jel_spn_add_admin_CSS() {
		wp_register_style( 
		'jel_spn_tooltip-css', 
		'http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css', 
		array(), 
		JEL_SPN_VERSION,
		'screen' 
		);
		wp_enqueue_style( 'jel_spn_tooltip-css' );		
	}
	
	
} // E/end base class

// Initialize everything
$jel_spn = new JEL_SPN_Base();

/*register_activation_hook( __FILE__, 'jel_spn_myplugin_install' );*/

//function jel_spn_myplugin_install() {

//this doesn't seem to do anything
    /*if ( version_compare( get_bloginfo( 'version' ), '8.1', '<' ) ) {
        deactivate_plugins( basename( __FILE__ ) ); // Deactivate our plugin
    }*/
	//warningif doing this here on activation (not warning like php but once only message atop plugin page about unexpected outpur
	//echo "hello world";
//}

?>