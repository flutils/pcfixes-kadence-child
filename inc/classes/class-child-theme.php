<?php

//////////////////////////
//////////////////////////

// RPECK 13/07/2023
// Child theme class - used to provide base functionality for the child theme

//////////////////////////
//////////////////////////

// Namespace
namespace Kadence;

// Class
// This is the main class through which we call everything to do with the child theme
class ChildTheme {

    //////////////////////////////
    //////////////////////////////

    /*
    *
     *  $child_theme = ChildTheme.new;
     *  $child_theme->plugins['give'];
     *  $child_theme->post_types['section'];
     *  $child_theme->sections['X'];
     *  $child_theme->settings['Y'];
     *
    */

    // RPECK 14/07/2023
    // Public plugins endpoint
    public $plugins = array();

    // RPECK 14/07/2023
    // Public post_types endpoint (used for CPT definitions)
    public $post_types = array();

    // RPECK 14/07/2023
    // Public sections endpoint
    public $sections = array();

    // RPECK 14/07/2023
    // Public settings endpoint
    protected $settings = array();

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

    // Constructor
	// Used to populate the various elements of the class (plugins, sections, cpt's, etc)
	function __construct() {

		// Settings
		// These are the root configuration options inside the child theme
		// They allow us to populate the various attributes of the system via a JSON file (or some other data payload)
        //$this->settings = x;

	}

	// Initialize
	// Public function which is invoked by the constructor
	public function initialize() {

        // Plugins
		// Populates an array of plugins that are pulled from the theme customization options
		$this->plugins = $this->get('plugins', $this->settings['plugins']);

        // Plugins
		// Populates an array of plugins that are pulled from the theme customization options
		$this->post_types = $this->get('post_types', $this->settings['post_types']);


	}

    // Get
    // Used to populate the various parts of the class that we require to run the system
    protected function get($type, $payload) {

        // Input variables
        if(isset($type) && isset($payload)) {

            // Vars
            $return = array();

            // forEach plugins, create a new class instance
            forEach($payload as &$item) {

                // Vars
                $class_name = str_replace("_", "", ucwords($type, " /_"));

                // Data
                // This is meant to populate the instance of an object with the various bits of data required to build the functionality
                $return[] = new $class_name($item);

            }

        // Return
        return $return;
        
        }

    }

    
}