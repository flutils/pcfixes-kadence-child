<?php

//////////////////////////
//////////////////////////

// RPECK 04/08/2023 - Redux Section Classes
// This was extracted out of the previous setup, which kept the sections defined in the constants file
// --
// Whilst this worked, it was cumbersome and not befitting an OOP setup

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
class Intro extends Section {

	// RPECK 05/08/2023 - Default Values
	// This loads the various values for this class (and parent)
	function __construct($opt_name) {

		// RPECK 05/08/2023 - Vars
		// The various items required to populate the parent class
		$args = array(

			'id'		=> 'intro',
			'title' 	=> 'Introduction',
			'icon'  	=> 'el-icon-info-circle',
			'heading' 	=> '<h1>ℹ️ Info</h1>',
			'priority'	=> 0,
			'desc'  	=> '
				<p><strong>Information about how the framework works and is built/designed</strong></p>
				<p>Theme was designed to provide a standard set of options/functionality through which to populate Kadence.</p>
				<p>It works by providing a central options system (built with <a href="https://www.redux.io">Redux Framework</a>) which can be extended and managed as required.</p>
			',

			'fields' => array(

				// RPECK 11/08/2023 - Divider
				// Gives us the means to separate the different elements
				array(
					'id'	=> 'info_introduction',
					'type'  => 'info',
					'title' => '<h1><strong>✅ Overview</strong></h1>',
					'subtitle'	=> '
						<strong>Built to provide a framework through which to edit and manipulate the theme in a structured and robust way.</strong>
						<p>The primary feature of the theme is the integration of Redux to act as an API for our inputs.</p>
					'
				),

			) 
			
		);

		// RPECK 05/08/2023 - Instantiate the parent class
		// This brings in the different items which
		parent::__construct($opt_name, $args);

	}

}