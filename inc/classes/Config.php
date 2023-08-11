<?php

//////////////////////////
//////////////////////////

// RPECK 20/07/2023
// Child theme config class - helps us define a set of configuration options which can be accessed globally

//////////////////////////
//////////////////////////

// RPECK 13/07/2023 - Namespace
// This was taken from the primary Kadence system - no need to change it
namespace KadenceChild;

// RPECK 25/07/2023 - Libraries
// List various functions/classes that we need to call from the global scope
use function __;
use function str_replace;
use function wp_get_theme;

// RPECK 16/07/2023 - No direct access
// Maintain the security of the system by blocking anyone who tries to access the file directly
defined( 'ABSPATH' ) || exit;

// RPECK 20/07/2023 - Class
// Main class through which we call everything to do with the configuration options of the theme
class Config {

	////////////
	// General

  // RPECK 20/07/2023 - Text Domain
	// This is used to provide us with the means to manage root domain vlaue for the class
	public $text_domain = KADENCE_CHILD_TEXT_DOMAIN;

	////////////
	// Redux

  // RPECK 25/07/2023 - Display Name
  // The text at the top of the Redux Framework page (defaults to $theme->get('Name'))
  // --
  // https://devs.redux.io/configuration/global_arguments.html#display-name
  public $redux_display_name = 'Kadence Child Theme';

  // RPECK 25/07/2023 - Display Version
  // Version number of the theme as defined by the system (defaults to $theme->get('Version'))
  // --
  // https://devs.redux.io/configuration/global_arguments.html#display-version
  public $redux_display_version = null;

	// RPECK 20/07/2023 - Admin Menu Label
	// Defines the menu label for Redux
	public $redux_menu_title = '🔥 Child Theme';

	// RPECK 20/07/2023 - Admin Page Title
	// Defines the menu label for Redux
	public $redux_page_title = 'Child Theme';

	// RPECK 20/07/2023 - Page Slug
	// Default value for page slug
	public $redux_page_slug = KADENCE_CHILD_TEXT_DOMAIN;

	// RPECK 31/07/2023 - Global Variable
	// Introduced to give us the means to customize the global variable that Redux makes available
	// --
	// https://devs.redux.io/configuration/global_arguments.html#global-variable
	// Defaults to true, can use false to remove or string to replace
	public $redux_global_variable;

	// RPECK 20/07/2023 - Page Parent
	// The place which this page will inherit from in the menu system
	public $redux_page_parent = 'themes.php';

	// RPECK 20/07/2032 - Footer Credit
	// This is the bottom left setting for Redux
	public $redux_footer_credit = '🔥 <strong>Kadence Child Theme</strong> by <a href="https://www.pcfixes.com" target="_blank">PCFixes.com</a> &copy; 2023';

	// RPECK 20/07/2023 - Admin Bar
	// Determines whether the Redux settings should be displayed in the admin bar
	public $redux_admin_bar = false;

	// RPECK 20/07/2023 - Customizer
	// Checks whether Redux interfaces with the customizer of Wordpress or not 
	public $redux_customizer = false;

	// RPECK 20/07/2023 - Menu Type
	// Type of menu that Redux should use to list the items
	public $redux_menu_type = 'submenu';

	// RPECK 20/07/2023 - Redux Dev Mode
	// Determines whether the development mode should be activated for Redux (defaults to true in Redux)
	public $redux_dev_mode = WP_DEBUG ?? false;

	////////////
	// TGMPA

	// RPECK 20/07/2023 - TGMPA Admin Menu Label
	// Defines the menue label that 
	public $tgmpa_strings_menu_title = '➡️ Plugins';

	// RPECK 20/07/2023 - TGMPA Admin Page Title
	// Define the page title for the TGMPA page
	public $tgmpa_strings_page_title = 'Install Required Plugins';

	// RPECK 21/07/2023 - Default Path
	// This is where the the bundled plugins will be located
	public $tgmpa_default_path = ''; // needs to be populated on init

	// RPECK 21/07/2023 - Menu Slug
	// The slug used by the menu system to provide a means to list the page 
	public $tgmpa_menu = 'kadence-install-plugins';

	// RPECK 21/07/2023 - Parent Slug
	// This is the slug of the parent item that the sub item will be listed underneath
	public $tgmpa_parent_slug = 'themes.php';

	// RPECK 21/07/2023 - Capability
	// Determines which user role / level is able to manage the values presented by the system
	public $tgmpa_capability = 'edit_theme_options';

	// RPECK 21/07/2023 - Notices
	// This determines whether admin notices will show or not
	public $tgmpa_has_notices = true;

	// RPECK 21/07/2023 - Dismissable 
	// Whether the user is able to dismiss admin notices
	public $tgmpa_dismissable = false;

	// RPECK 21/07/2023 - Dismiss Message 
	// The message used to appear at the top of the admin notices system
	public $tgmpa_dismiss_msg = '➡️ Plugins';	

	////////////
	// Functions

    // RPECK 20/07/2023 - Constructor
    // Used to populate the values on init
    function __construct($config = array()) {

        // RPECK 20/07/2023 - Config Options
        // This takes the array passed in the constructor and allows us to define the various attribute values with it
        if(!is_null($config) && is_array($config) && count($config) > 0) {

			// RPECK 20/07/2023 - Assign values to instance properties
			// This gives us the means to specify exactly which config options are available which are not (IE we are not dependent on an array)
			foreach($config as $key => $value) {

				// RPECK 20/07/2023 - Assign properties
				// If the property exists on the class, assign it
				$this->set($key, $value);

			}

		}

		// RPECK 21/07/2023 - Set defaults
		// These may require functions that are only available during an instance of the class
		if(empty($this->tgmpa_default_path)) $this->tgmpa_default_path = get_stylesheet_directory() . '/lib/plugins';

		// RPECK 10/08/2023 - Add theme version if it is not set
		// As this depends on a function, we need to call it inside an instance of the class
		if(is_null($this->redux_display_version)) $this->redux_display_version = wp_get_theme()->get('Version');

    }

	// RPECK 20/07/2023 - Set values
	// Sets the property, allowing us to change the various properties on the fly
	public function set($key, $value) {

		// RPECK 20/07/2023 - create values
		// This uses a filter to ensure we are calling the value properly
		if(property_exists($this, $key) && !empty($value)) $this->$key = apply_filters("KadenceChild\config_set_{$key}", $value);

	}

	// RPECK 20/70/2023 - Get values
	// Gets the properties with the prefix provided to the method (EG $this->config->get('redux'))
	// --
	// This is only valid because all of the other properties of the class are static (IE $this->config->text_domain;)
	// Returns array()
	public function get($key) {

		// RPECK 20/07/2023 - Vars
		// Populates the various values required by the method
		$data = array();

		// RPECK 20/07/2023 - Check to see if key is present
		// Only proceed if the key is valid and populated
		if(!is_null($key) && !empty($key)) {

			// RPECK 20/07/2023 - Loop through instance properties of class
			// This gives us the means to identify which properties are in the class and then return 
			array_walk(get_object_vars($this), function($object_value, $object_key) use ($key, &$data) {

				// RPECK 20/07/2023 - Key starts with 
				// If object_key starts with $key then add it to data
				if(str_starts_with($object_key, $key)) {

					// RPECK 21/07/2023 - Vars
					// Variables used to populate the array
					$object_key_split = explode('_', $object_key);
					$object_key_main  = array_shift($object_key_split); 

					// RPECK 21/07/2023 - Check number of underscores
					// This is required for TGMPA, as the 'strings' thing needs its own array
					if(count($object_key_split) > 2) {

						// RPECK 21/07/2023 - Array shift
						// This is needed to get the next level from the var
						$object_key_sub = array_shift($object_key_split);

						// RPECK 21/07/2023 - Check to see if the value exists in the parent array
						// If it does not exist, invoke it
						if(!array_key_exists($object_key_sub, $data)) $data[ $object_key_sub ] = array();

						// RPECK 21/07/2023 - Define the object value in the array
						// This way, we are able to accommodate the different values
						$data[ $object_key_sub ][ implode('_', $object_key_split) ] = __($object_value, KADENCE_CHILD_TEXT_DOMAIN);

					} else {

						// RPECK 21/07/2023 - Populate TGMPA
						// This allows us to define the value in the variable
						$data[ implode('_', $object_key_split) ] = __($object_value, KADENCE_CHILD_TEXT_DOMAIN);

					}

				}

			});

		}

		// RPECK 20/07/2023 - Return
		// Returns an array to give us the means to manage the data elsewhere
		return $data;

	}

}