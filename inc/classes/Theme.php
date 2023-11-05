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

// RPECK 09/08/2023 - Functions
// Used to provide us with the ability to manage the different libraries we want to call
use function is_admin;
use function is_customize_preview;

// RPECK 16/07/2023 - No direct access
// Maintain the security of the system by blocking anyone who tries to access the file directly
defined( 'ABSPATH' ) || exit;

// RPECK 12/07/2023 - Class
// Main class through which we call everything to do with the child theme
// --
// Final keyword from GiveWP - https://www.php.net/manual/en/language.oop5.final.php
final class Theme {

	//////////////////////////////
	//////////////////////////////

	// RPECK 16/07/2023 - Redux
	// This is the main entrypoint for the various settings of a theme (plugins, sections, etc)
	public $redux;

	// RPECK 18/07/2023 - TGMPA
	// Entrypoint for any of the TGMPACore class - allows us to define different plugins to be installed for the theme (handled by Redux)
	public $tgmpa;

	// RPECK 18/07/2023 - Config Options
	// This is used to give us the means to populate a set of configuration options for the class
	public $config = array();

	// RPECK 14/07/2023
	// Taken from the main Kadence theme
	private static $instance = null;

	//////////////////////////////
	//////////////////////////////

	// RPECK 14/07/2023 
	// Pulled from the main Kadence theme
	// Allows us to call the instance of the class without having to reload global variables everywhere
	public static function instance() {

		// RPECK 20/07/2023 - Create Instance
		// Return if already instantiated.
		if(self::is_instantiated()) return self::$instance;

		// RPECK 20/07/2023 - Set up the instance of the class
		// Setup the singleton.
		self::setup_instance();

		// RPECK 20/07/2023 - Initialize the instance
		// Allows us to set up the system
		self::$instance->initialize();

		// RPECK 20/07/2023 - Instance
		// Return the instance.
		return self::$instance;

	}

	// RPECK 14/07/2023
	// Set up a new instance of Theme
	private static function setup_instance() {
		self::$instance = new self();
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
	function __construct($config = array()) {

		// RPECK 19/07/2023 - Config values
		// Added a class so that we could restrict the way in which we are calling the different options ($this->config->admin_page_menu_title)
		$this->config = new \KadenceChild\Config(apply_filters('KadenceChild\config', $config));
		
		// RPECK 16/07/2023 - Redux
		// This populates the various sections on the site with the Redux theme framework included in functions.php
		if(class_exists('\KadenceChild\Redux\Core')) $this->redux = new \KadenceChild\Redux\Core($this->config->get('redux'));

		// RPECK 31/07/2023 - TGMPA
		// Populates the TGMPA class with configuration options (we populate the plugins after we initialize the class)
		if(class_exists('\KadenceChild\Tgmpa\Core')) $this->tgmpa = new \KadenceChild\Tgmpa\Core($this->config->get('tgmpa'));

		// RPECK 28/07/2023 - Enqueue Admin Styles
		// This is required for a number of JS/CSS files that are included with the theme as a means to improve performance etc
		add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));

		// RPECK 14/08/2023 - Enqueue Styles
		// Required for front-end scripts/styles
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));

	}

	// RPECK 28/07/2023 - Enqueue Admin Scripts
	// This gives us an extensible place from which to enqueue the various stylesheets / Javascript files required to run in the admin area
	public function enqueue_admin_scripts(){

		// RPECK 28/07/2023 - Stylesheets
		// Various stylesheets required to help us improve different aspects of the admin area
		wp_enqueue_style('kadence_child_admin_styles', get_stylesheet_directory_uri().'/assets/admin/css/main.css');

	}

	// RPECK 14/08/2023 - Enqueue Scripts
	// This gives us an extensible place from which to enqueue the various stylesheets / Javascript files required to run in the admin area
	public function enqueue_scripts(){

		// RPECK 28/07/2023 - Stylesheets
		// Various stylesheets required to help us improve different aspects of the admin area
		wp_enqueue_style('kadence_child_styles', get_stylesheet_directory_uri().'/assets/main/css/main.css');

		// RPECK 28/07/2023 - Scripts
		// Extra javascript added to the front-end to facilitate various functionality
		wp_enqueue_script('kadence_child_scripts', get_stylesheet_directory_uri().'/assets/main/js/main.js');

	}

	// RPECK 14/07/2023 - Initialize
	// Public function which is invoked by the constructor
	// --
	// This should hook into different Wordpress actions/filters to ensure the theme is able to run within the scope of Wordpress
	public function initialize() {

		// RPECK 16/07/2023 - Initialize
		// This is our own system but allows us to initialize the class whenever we require
		// --
		// Requires to have a priority below 10
		add_action('init', array($this->redux, 'initialize'), 0);

		// RPECK 31/07/2023 - TGMPA
		// Triggers the 'initialize' hook on our TGMPA Core class after the redux_loaded hook has had a chance to work
		if($this->tgmpa instanceof \KadenceChild\Tgmpa\Core) add_action('tgmpa_register', array($this->tgmpa, 'initialize'));

	}

	//////////////////////////////
	//////////////////////////////
    
}