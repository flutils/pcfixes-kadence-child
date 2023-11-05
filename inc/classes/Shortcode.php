<?php

//////////////////////////
//////////////////////////

// RPECK 04/08/2023 - Shortcode Class
// The class is used to create shortcodes inside the Wordpress system

//////////////////////////
//////////////////////////

// RPECK 04/08/2023 - Namespace
// Used to provide us with the means to modularize the system
namespace KadenceChild;

// RPECK 04/08/2023 - Libraries
// Used to determine which libraries and/or functions to use 
use function add_shortcode;

// RPECK 16/07/2023 - No direct access
// Maintain the security of the system by blocking anyone who tries to access the file directly
defined( 'ABSPATH' ) || exit;

// RPECK 28/07/2023 - Shortcode
// This is used to provide the means to add shortcodes to the system
class Shortcode {

	// RPECK 04/08/2023 - Name
	// (Required) The tag for the shortcode (IE what the shortcode is [shortcode_tag])
	public $name;

	// RPECK 04/08/2023 - Content
	// The actual content of the shortcode
	public $content;

	// RPECK 04/08/2023 - Active
	// Whether the shortcode is activated on the system
	public $active;

	//////////////////////////////
	//////////////////////////////

	// RPECK 04/08/2023 - Constructor
	// Populates the values required for the shortcode
	function __construct($shortcode = array()) {

		// RPECK 04/08/2023 - Populate shortcode class
		// This is required to give us the ability to determine the type of content
		foreach($shortcode as $key => $value) {

			// RPECK 04/08/2023 - Populate each value
			// This gives us the means to determine exactly which values are present
			if(is_property($this, $key)) $this->$key = $value;

		}

	}

	//////////////////////////////
	//////////////////////////////	

	// RPECK 04/08/2023 - Initialize
	// Initializes an instance of the shortcode object
	public function initialize() {

		// RPECK 04/08/2023 - Adding the add_shortcode with the payload
		// The payload is called from another function so it can be disabled
		if(!is_null($this->name) && !is_empty($this->content) && $this->active) add_shortcode($this->name, array($this, 'execute'));

	}

	// RPECK 14/08/2023 - Execute our content payload
	// This was required to ensure we don't have 
	public function execute() {

		

	} 

	//////////////////////////////
	//////////////////////////////	

    
}