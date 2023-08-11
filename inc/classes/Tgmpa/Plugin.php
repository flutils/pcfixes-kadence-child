<?php

//////////////////////////
//////////////////////////

// RPECK 18/07/2023 - TGMPA Plugin Class
// The plugins class is used to create a set of standardised plugin options for TGMPA

//////////////////////////
//////////////////////////

// RPECK 13/07/2023 - Namespace
// This was taken from the primary Kadence system - no need to change it
namespace KadenceChild\Tgmpa;

// RPECK 16/07/2023 - No direct access
// Maintain the security of the system by blocking anyone who tries to access the file directly
defined( 'ABSPATH' ) || exit;

// RPECK 18/07/2023 - TGMPA Plugin Class
// Used to give us a set of standard options for each plugin added to TGMPA
class Plugin {

    // RPECK 18/07/2023 - Name 
    // (Required) The plugin name
    public $name;

    // RPECK 18/07/2023 - Slug
    // (Required) The plugin slug (typically the folder name)
    public $slug;    

    // RPECK 18/07/2023 - Source
    // (Optional) // The plugin source (IE external or internal)
    public $source; 

    // RPECK 18/07/2023 - Required
    // (Required) If false, the plugin is only 'recommended' instead of required 
    public $required = false; 

    // RPECK 18/07/2023 - Version
    // (Optional) E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
    public $version; 

    // RPECK 18/07/2023 - Force Activation
    // (Optional) If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
    public $force_activation = false;

    // RPECK 18/07/2023 - Force Deactivation
    // (Optional) If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
    public $force_deactivation = false;  

    // RPECK 18/07/2023 - External URL
    // (Optional) If set, overrides default API URL and points to an external URL 
    public $external_url;  

    // RPECK 18/07/2023 - Is Callable?
    // (Optional) If set, this callable will be be checked for availability to determine if a plugin is active 
    public $is_callable;     
	
    // RPECK 18/07/2023 - Constructor
    // Takes $args and allows us to populate (or change) the args above
    function __construct($plugin = array()) {

		// RPECK 18/07/2023 - Plugin
		// Takes data from the $plugin array and populates the properties of the class
		if(!is_null($plugin) && is_array($plugin)) array_walk($plugin, array($this, 'create_from_array'));

	}

	// RPECK 21/07/2023 - Create From Array
	// This is the callback function for array_walk above
	public function create_from_array($value, $key) {
		if(property_exists($this, $key)) $this->$key = $value;
	}

}