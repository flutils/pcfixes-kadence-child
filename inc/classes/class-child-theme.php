<?php

//////////////////////////
//////////////////////////

// RPECK 13/07/2023
// Child theme class - used to provide base functionality for the child theme

//////////////////////////
//////////////////////////

// RPECK 13/07/2023 - Namespace
// This was taken from the primary Kadence system - no need to change it
namespace KadenceChild;

// RPECK 16/07/2023 - No direct access
// Maintain the security of the system by blocking anyone who tries to access the file directly
defined( 'ABSPATH' ) || exit;

// RPECK 12/07/2023 - Class
// Main class through which we call everything to do with the child theme
class ChildTheme {

    //////////////////////////////
    //////////////////////////////

	// RPECK 16/07/2023 - Redux
	// This is the main entrypoint for the various settings of a theme (plugins, sections, etc)
	public $redux;

	// RPECK 14/07/2023
	// Taken from the main Kadence theme
	private static $instance = null;

    //////////////////////////////
    //////////////////////////////

	// RPECK 14/07/2023 
	// Pulled from the main Kadence theme
	// Allows us to call the instance of the class without having to reload global variables everywhere
	public static function instance() {

		// Return if already instantiated.
		if(self::is_instantiated()) return self::$instance;

		// Setup the singleton.
		self::setup_instance();

		self::$instance->initialize();

		// Return the instance.
		return self::$instance;

	}

	// RPECK 14/07/2023
	// Set up a new instance of ChildTheme
	private static function setup_instance() {
		self::$instance = new ChildTheme();
	}

	// RPECK 14/07/2023
	// Return whether child theme is instantiated
	private static function is_instantiated() {

		// Return true if instance is correct class.
		if(!empty(self::$instance) && (self::$instance instanceof Theme)) return true;

		// Return false if not instantiated correctly.
		return false;
	}

    //////////////////////////////
    //////////////////////////////

    // RPECK 13/07/2023 - Constructor
	// Used to populate the various elements of the class (plugins, sections, cpt's, etc)
	function __construct() {}

	// RPECK 14/07/2023 - Initialize
	// Public function which is invoked by the constructor
	public function initialize() {

		// RPECK 16/07/2023 - Redux
		// This populates the various sections on the site with the Redux theme framework included in functions.php
		if(class_exists('Redux')) {
            
			// RPECK 16/07/2023 - New Redux
			// Set up new Redux instance (accepts arguments passed as array)
            $this->redux = new Redux();

			// RPECK 16/07/2023 - Initialize
			// This is our own system but allows us to initialize the class whenever we require
            $this->redux->initialize();

        }

	}
    
}