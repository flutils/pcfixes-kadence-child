<?php

//////////////////////////
//////////////////////////

// RPECK 05/08/2023 - Default Redux Section Classes
// Extracted from the 'constants' file to give us a structured way to manage the defaults

//////////////////////////
//////////////////////////

// RPECK 04/08/2023 - Namespace
// This was taken from the primary Kadence system - no need to change it
namespace KadenceChild;

// RPECK 04/08/2023 - Libraries
// Loads the various classes & functions required by the class
use KadenceChild\Redux\Section;

// RPECK 16/07/2023 - No direct access
// Maintain the security of the system by blocking anyone who tries to access the file directly
defined( 'ABSPATH' ) || exit;

// RPECK 04/08/2023 - Class definition
// Gives us the means to manage the various parts of the admin area by extending the base Section class
class Login extends Section {

	// RPECK 05/08/2023 - Default Values
	// This loads the various values for this class (and parent)
	function __construct($opt_name) {

		// RPECK 05/08/2023 - Vars
		// The various items required to populate the parent class
		$args = array(

	        'id' 	  	 => 'login_page',
			'title'   	 => 'Login Page',
			'icon'    	 => 'el-icon-lock',
			'heading' 	 => 'General Site Settings',
            'priority'   => 1,
			'subsection' => true,
			'fields'     => array(

				// RPECK 02/08/2023 - Login Logo
				// If enabled, the login logo is changed to the site logo
				array(
					'id'      	=> 'login_logo',
					'type'    	=> 'switch',
					'title'   	=> '🖼️ Change to Site Logo?',
					'subtitle'	=> 'Change the login logo (used to be handled by Whitelabel CMS)',
					'default'	=> true,
					'on'		=> 'Yes',
					'off'		=> 'No'
				),	

				// RPECK 02/08/2023 - Text Colour
				// The colour of the text of the login page
				array(
					'id'          => 'login_text_colour',
					'type'        => 'color',
					'title'       => '🖊️ Text Colour',
					'subtitle'    => 'Set the text colour of the login page',
					'transparent' => false
				),

				// RPECK 02/08/2023 - Background Colour
				// The colour of the background of the login page
				array(
					'id'          => 'login_background',
					'type'        => 'color',
					'title'       => '➡️ Background Colour',
					'subtitle'    => 'Set the background colour for the login page',
					'transparent' => false,
					'load_callback' => function($value) {

						// RPECK 02/08/2023 - Added items
						// This customizes the login page with custom background colour and logo
						add_action('login_enqueue_scripts', function() use ($value) {

							echo '
							<style type="text/css">
								body.login { background-color: ' . $value . '; }
							</style>';

						});	

					}
				)

			)
			
		);

		// RPECK 05/08/2023 - Instantiate the parent class
		// This brings in the different items which
		parent::__construct($opt_name, $args);

	}

}