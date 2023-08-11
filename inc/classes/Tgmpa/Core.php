<?php

//////////////////////////
//////////////////////////

// RPECK 13/07/2023 - Namespace
// This was taken from the primary Kadence system - no need to change it
namespace KadenceChild\Tgmpa;

// RPECK 31/07/2023 - Libraries
// Various libraries used within the system
use KadenceChild\Tgmpa\Plugin;
use function tgmpa;

// RPECK 16/07/2023 - No direct access
// Maintain the security of the system by blocking anyone who tries to access the file directly
defined( 'ABSPATH' ) || exit;

// RPECK 18/07/2023 - TGMPA Class
// This is used to interface with the TGM-Plugin-Activation class stored in ./vendor/tgm-plugin-activation
class Core {

	// RPECK 18/07/2023 - Plugins
	// Array used to define the various plugin options that TGMPA has to manage
	public $plugins = array();

	// RPECK 18/07/2023 - Config
	// Array used to populate configuration options for the system
	public $config = array();

    // RPECK 18/07/2023 - Constructor
    // Takes $args and allows us to populate (or change) the args above
    function __construct($config = array(), $plugins = array()) {

		// RPECK 21/07/2023 - Config
		// Gives us a core set of configuration values which can be changed by altering the values in the class-child_config.php class
        $this->config = apply_filters('KadenceChild\config', $config, 'tgmpa');

		// RPECK 21/07/2023 - Plugin Values
		// If we populate the 'plugins' property of the class instance here, we can accept new plugins from the constructor
		if(!is_null($plugins) && is_array($plugins)) $this->plugins = $plugins;
		
		// RPECK 21/07/2023 - Plugins
		// Gives us the ability to add the plugins dynamically to the system
		add_filter('KadenceChild\tgmpa_plugins', array($this, 'initialize_plugins'), 10, 1);
        
    }

	// RPECK 18/07/2023 - Initialize
	// Custom function used to invoke the class when required
	public function initialize() {

		// RPECK 21/07/2023 - Plugins
		// This is used to populate the plugins with the plugin class
		$this->plugins = apply_filters('KadenceChild\tgmpa_plugins', $this->plugins);

		// RPECK 18/07/2023 - TGMPA require
		// This invokes the TGMPA class and allows us to populate it with the data we've defined elsewhere in the system
		// --
		// Needs to be called before 'init' function of Wordpress
		tgmpa($this->get_plugins(), $this->config);

	}

	// RPECK 21/07/2023 - Get Plugins
	// Populates the plugins that are presented by the system
	public function initialize_plugins($plugins) {

		// RPECK 21/07/2023 - Vars
		// These are used to determine the values the system will use in this function
		$return = array();

		// RPECK 21/07/2023 - Cycle through plugins and ensure we are populating with the TGMPA Plugin class
		// --
		// These are designed to give us the means to populate the $this->plugins attribute with instances of the tgmpa-plugin class
		// The reason for using this class is to ensure we have the means to populate a rigid set of attributes for each plugin (rather than random)
		if(is_array($plugins) && count($plugins) > 0) {

			// RPECK 18/07/2023 - Foreach plugin
			// For each plugin, create a new instance of the TGMAPlugin class 
			foreach($plugins as &$plugin) {

				// RPECK 18/07/2023 - Add a new TGMAPlugin class
				// This allows us to populate the plugins attribute of the TGMA class
				$return[] = new Plugin($plugin);

			}

		}

		// RPECK 21/07/2023 - Return Values
		// This gives us the means to populate the plugins without issues
		return $return;

	}

	// RPECK 21/07/2023 - Get Plugins
	// This returns an array with the values dumped from the instantiated Tgmpa\Plugin classes
	public function get_plugins() {

		// RPECK 21/07/2023 - Vars
		// Various pieces of data for the function
		$return = array();

		// RPECK 21/07/2023 - translate plugins from Tgmpa\Plugin class to arrays
		// The reason for doing this is so that we can keep the plugin config structure static
		if(is_array($this->plugins) && count($this->plugins) > 0) array_walk($this->plugins, function(&$plugin) use (&$return) { $return[] = (array) $plugin; });

		// RPECK 21/07/2023 - Return
		// Return the newly populated array
		return $return;
		
	}

}