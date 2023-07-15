<?php

//////////////////////////
//////////////////////////

// RPECK 14/07/2023
// Child plugin class - used to store plugin information for each of the plugins we wish to invoke

//////////////////////////
//////////////////////////

// Namespace
namespace Kadence;

// Class
// This is the main class through which we call everything to do with the child theme
class ChildPlugin {

	// RPECK 14/07/2023
    // Public activated value
    public $activated = false;

    // RPECK 14/07/2023
    // Public installed value
    public $installed = false;

	// RPECK 14/07/2023
    // Public settings value 
    public $settings = array(
        'name'               => '',
        'slug'               => '',
        'required'           => false,
        'source'             => '',
        'version'            => '0.0.0',
        'force_activation'   => false,
        'force_deactivation' => false,
        'external_url'       => '',
        'is_callable'        => ''
    );

    // Constructor
	// Used to populate the various elements of the class (plugins, sections, cpt's, etc)
	function __construct($plugin = array()) {

		// Plugin payload
		// This is based on the 'configuration' options of the plugin
		$this->settings = array_merge($plugin, $this->settings);

	}



}

