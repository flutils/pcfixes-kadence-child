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
use KadenceChild\Helpers;
use Kadence_Blocks_Pro_Dynamic_Content;

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

		// RPECK 11/08/2023 - Global shortcode
		// This is a shortcode which wraps the Redux global var in a shortcode we can access throughout the site
		add_shortcode(apply_filters('KadenceChild\global_shortcode', 'kadence_child'), array($this, 'global_shortcode'));

		// RPECK 17/08/2023 - Create the "Redux" Dynamic Content option inside Kadence Blocks Pro
		// This is required to give us the means to manage exactly what content is available in the dynamic thing
		if(class_exists('Kadence_Blocks_Pro_Dynamic_Content')) {
			
			// RPECK 17/08/2023 - Options
			// Allows us to loop through the different filters we require and ensure they loaded properly
			// --
			// Correspond to different filtrs defined in the Kadence Blocks Pro plugin (./wp-content/kadence-blocks-pro/includes/dynamic-content/class-kadence-blocks-pro-dynamic-content.php)
			$options = array('text', 'link', 'conditional');
			
			// RPECK 18/08/2023 - Loop
			// Loop for the system which allows us to populate the various filters
			foreach($options as &$option) {

				// RPECK 17/08/2023 - Fields
				// Based on the above, allows us to get the filter applied without having to redeclare everything
				add_filter("kadence_block_pro_dynamic_{$option}_fields_options", array($this, 'dynamic_content_options'));
				
			}
			
		}

	}

	// RPECK 17/08/2023 - Dynamic Content Options
	// This gives us the ability to hook into the core Kadence Blocks filter, which works to pull in the different "dynamic content" options
	// --
	// Use it here and allows us to call the various sections/fields required to populate it
	public function dynamic_content_options($options) {
		
		// RPECK 18/08/2023 - Filter
		// Defines the $filter variable with a regex match on the filter name
		preg_match('/kadence_block_pro_dynamic_(.*)_fields_options/', current_filter(), $matches);
		
		// RPECK 18/08/2023 - Check if filter exists
		// If it does, process everything required to make it work
		if(is_array($matches) && isset($matches[1])) {
			
			// RPECK 17/08/2023 - Compile the various option names from our fields
			// This has to cycle through all of the fields and pull out the ones which have "dynamic_content" populated
			$property_name = "dynamic_{$matches[1]}";
			$option_names  = array();
			$fields        = array_column($this->sections, 'fields');

			// RPECK 17/08/2023 - Loop through the sections/fields and pull out the various items that we need
			// Would have preferred a fancy way to do this, but the loop gives us robustness
			foreach(array_merge(...$fields) as &$field) {

				// RPECK 17/08/2023 - Check if dynamic content is false
				// If it's false, then don't do anything
				if($field->$property_name != false && !is_null($field->$property_name)) {
					
					// RPECK 18/08/2023 - Global Variable
					// Used to access the redux framework data so we don't need to call the database
					global $kadence_child_theme;
					
					// RPECK 17/08/2023 - Push the field's values
					// This is required if the field has its value already populated
					array_push($option_names, array(
						'value' => "redux_{$matches[1]}|{$field->id}",
						'label' => esc_attr__(Helpers::removeEmojis($field->title), $this->opt_name)
						)
					);

				}

			}

			// RPECK 17/08/2023 - Insert the various Redux options we have defined
			// This is rudamentary at present but can be fleshed out as required
			// --
			// ./wp-content/kadence-blocks-pro/includes/dynamic-content/class-kadence-blocks-pro-dynamic-content.php#1528
			$redux_options = array(
				array(
					'label'   => __('Redux', $this->opt_name),
					'options' => apply_filters("KadenceChild\kadence_dynamic_{$matches[1]}_field_options", $option_names)
				)
			);
			
			// RPECK 18/08/2023 - Array Merge
			// Merges the options with $redux_options to give us the required information
			$options = array_merge($redux_options, $options);
			
		}
		
		// RPECK 17/08/2023 - Return the options
		// Gives us the ability to update the options of the filter
		return $options;

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

	// RPECK 11/08/2023 - Global Shortcode
	// Allows us to access the Redux global variable data from the templating engine
	public function global_shortcode($atts, $content = '') {

		// RPECK 11/08/2023 - Shortcode Attributes
		// Pulls in any attributes we've passed through to the shortcode, allowing us to use them as needed
		extract(shortcode_atts( array(
			'field'	=> ''
		), $atts));

		// RPECK 17/08/2023 - Global Variable Name
		// Need to extract this functionality out into something more robust
		$global_variable_name = Helpers::getGlobalVariableName($this->opt_name);

		// RPECK 31/07/2023 - Global Variable
		// Loads the global variable of Redux, allowing us to gain access to the various values it contains
		global ${$global_variable_name};

		// RPECK 25/08/2023 - Field
		// Required as field was being provided with quotes
		// --
		// https://stackoverflow.com/a/657670/1143732
		$field = preg_replace("/&#?[a-z0-9]{2,8};/i","", $field);

		// RPECK 11/08/2023 - Return the values 
		if(array_key_exists($field, ${$global_variable_name})) return ${$global_variable_name}[$field];

	}

}