<?php

//////////////////////////
//////////////////////////

// RPECK 16/07/2023 - Redux Class 
// Used to initialize Redux and provide the means to interface with it (IE make the sections dynamic depending on different settings)

//////////////////////////
//////////////////////////

// RPECK 13/07/2023 - Namespace (Redux)
// This was taken from the primary Kadence system - no need to change it
namespace KadenceChild\Redux;

// RPECK 27/07/2023 - Libraries
// Used to provide various imported files / libraries from the global namespace
use KadenceChild\Redux\Section;

// RPECK 05/08/2023 - Constants
// These are used to define the different constants used by the class
use const KadenceChild\KADENCE_CHILD_TEXT_DOMAIN;

// RPECK 16/07/2023 - No direct access
// Maintain the security of the system by blocking anyone who tries to access the file directly
defined( 'ABSPATH' ) || exit;

// RPECK 16/07/2023 - Class
// Class through which Redux Framework configured and initialized
class Core {

	// RPECK 16/07/2023 - Opt Name
	// This is used to define the namespace of the values (defaults to KADENCE_CHILD_TEXT_DOMAIN)
	public $opt_name = KADENCE_CHILD_TEXT_DOMAIN;

	// RPECK 16/07/2023 - Args
	// Used to populate the various arguments for Redux
	public $args = array();

	// RPECK 16/07/2023 - Sections
	// This contains an array of ReduxSection objects, which can be used to populate the admin pages area
	public $sections = array();

	// RPECK 16/07/2023 - Constructor
	// Takes $args and allows us to populate (or change) the args above
	function __construct($args = array(), $sections = array()) {

		// RPECK 16/07/2023 - Set Args
		// Allows us to set the various arguments for Redux against a set of defaults
		$this->args = apply_filters('KadenceChild\config', $args, 'redux');

		// RPECK 16/07/2023 - Sections
		// Creates an array of Section classes from class-redux_section.php
		$sections = apply_filters('KadenceChild\sections', $sections, $this);

		// RPECK 06/08/2023 - Only proceed if $sections is an array
		// This ensures we can make mistakes with the sections filter and not cause fatal errors
		if(is_array($sections)) {

			// RPECK 25/07/2023 - Populate Sections
			// This allows us to populate the sections property of the class with instances of Redux\Section
			$this->sections = array_map(function($section) {

				// RPECK 25/07/2023 - Define section
				// Take the values attributed to our $section variables and make them work with the classes
				return ($section instanceof Section) ? $section : new Section($this->opt_name, $section);

			}, $sections);

			// RPECK 05/08/2023 - Sort Array
			// Takes the priority of each instance of Section and allows us to sort them
			array_multisort(array_column($this->sections, 'priority'), $this->sections);

		}

	}

	// RPECK 16/07/2023 - Initialize
	// Custom function used to invoke the class when required
	public function initialize() {
		
		// RPECK 16/07/2023 - Set args
		// Set the above arguments as the default for the system
		\Redux::set_args($this->opt_name, $this->args);

		// RPECK 24/07/2023 - Sections
		// Gives us the ability to set the various sections for the theme
		if(is_array($this->sections) && count($this->sections) > 0) {

			// RPECK 24/07/2023 - Loop through the sections
			// This was done to keep everything as clean as possible
			array_map(function($section) {

				// RPECK 06/08/2023 - Set Section
				// If this is a valid instance, set the section
				if($section instanceof Section) $section->set_section();

			}, $this->sections);

		}

	}

	// RPECK 16/07/2023 - Get Args
	// Wraps the Redux::get_args & Redux::get_arg functions
	// https://devs.redux.io/configuration/api.html#redux-get-args
	public function get($arg) {

		// RPECK 16/07/2023 - Check if arg is present
		// If $arg is present, use get_arg else use get_args
		return \Redux::get_option($this->opt_name, $arg);

	}

	// RPECK 28/07/2023 - Get Sections
	// Get the various sections from the system
	public function get_sections($section_id = null) {

		// RPECK 28/07/2023 - Get Sections
		// Passes the $section_id value onto get_option if present
		return \Redux::get_sections($this->opt_name, $section_id);

	}

}