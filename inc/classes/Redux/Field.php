<?php

//////////////////////////
//////////////////////////

// RPECK 25/07/2023 - Redux Field
// This is a class which gives us the ability to invoke new fields depending on presented criteria

//////////////////////////
//////////////////////////

// RPECK 13/07/2023 - Namespace
// This was taken from the primary Kadence system - no need to change it
namespace KadenceChild\Redux;

// RPECK 17/08/2023 - Constants
// Used to provide us with the means to manage the underlying constants within the class
use const KadenceChild\KADENCE_CHILD_TEXT_DOMAIN;

// RPECK 16/07/2023 - No direct access
// Maintain the security of the system by blocking anyone who tries to access the file directly
defined( 'ABSPATH' ) || exit;

// RPECK 24/07/2023 - Field
// This is used to populate fields inside Redux - can be used for various fields
// --
// https://devs.redux.io/configuration/objects/field.html
class Field {   

	// RPECK 26/07/2023 - ID
	// (Required) string to determine the ID of the field
	// https://devs.redux.io/configuration/objects/field.html#default-arguments
	public $id = '';

	// RPECK 26/07/2023 - Type
	// (Required) This is the primary setting for the field - allows us to manage which one will be used
	public $type = '';

	// RPECK 26/07/2023 - Title
	// (Optional) The text that displays alongside the field to give it the means to 
	public $title;

	// RPECK 26/07/2023 - Subtitle
	// (Optional) Used to provide a subtitle underneath the main title for each field
	public $subtitle;

	// RPECK 26/07/2023 - Description
	// (Optional) Gives us the ability to define different descriptive text with HTML if necessary
	public $desc;

	// RPECK 27/07/2023 - Placeholder
	// (Optional) Gives us the means to define a placeholder for the system 
	public $placeholder;

	// RPECK 26/07/2023 - Default Value
	// (Optional) Default value for the field if needed
	public $default;

	// RPECK 26/07/2023 - CSS Classes
	// (Optional) Any extra classes required to append to the "class" attribute of the field
	public $class;

	// RPECK 26/07/2023 - Customizer Only
	// (Optional) Whether the field should only appear in the customizer or not
	public $customizer_only;

	// RPECK 26/07/2023 - Output
	// (Optional) Output part of field -- whether it should be included or not 
	public $output;

	// RPECK 26/07/2023 - Fields
	// (Optional) These are required for repeater fields
	public $fields;

    // RPECK 27/07/2023 - Group Values
    // (Optional) Used for the 'repeater' field type - allows us to group the field values into an associative array
    public $group_values;

    // RPECK 27/07/2023 - Item Name
    // (Optional) Used for the 'repeater' title and button label
    public $item_name;

	// RPECK 27/07/2023 - Validate
	// (Optional) Accepts string or array to allow us to validate inputs on the field 
	// --
	// https://devs.redux.io/configuration/fields/validate.html#using-the-validate-argument
	public $validate;

	// RPECK 27/07/2023 - On
	// (Optional) Allows us to change the on/off text for a "switch" (boolean) field
	// --
	// https://devs.redux.io/core-fields/switch.html
	public $on;

	// RPECK 27/07/2023 - Off
	// (Optional) Allows us to change the on/off text for a "switch" (boolean) field
	// --
	// https://devs.redux.io/core-fields/switch.html
	public $off;

	// RPECK 27/07/2023 - Sortable
	// (Optional) Used by Repeater fields to permit functionality
	public $sortable;

	// RPECK 27/07/2023 - Required
	// (Optional) Allows us to determine whether a field is dependent on another field
	public $required;

	// RPECK 28/07/2023 - Options
	// (Optional) Used to provide the ability to interface with different options for a particular field
	public $options;

	// RPECK 26/07/2023 - Disabled
	// (Optional) Whether the field is disabled or not in the viewport
	public $disabled;

	// RPECK 26/07/2023 - Fonticons
	// (Optional) This is one of the options on the 'icon-select' extension. As it defaults to true, we need to explicitly define it as false to disable
	public $fontawesome = false;

	// RPECK 25/08/2023 - Dashicons
	// (Optional) Used by the icon-select field to filter the type of library used for the icons. Defaults to true
	public $dashicons = true;

	// RPECK 26/07/2023 - Elusive Icons
	// (Optional) Used in the 'icon-select' extension. Need to disable explicitly
	public $elusive = false;

	// RPECK 28/07/2023 - Data
	// (Optional) Allows us to populate the value of the field with dynamic data from Wordpress (really powerful)
	// -- 
	// https://devs.redux.io/configuration/fields/data.html#built-in-values
	public $data;

	// RPECK 01/08/2023 - Library filter
	// (Optional) This is used by the media field to provide the means to determine which filetypes can be uploaded with it
	public $library_filter;

	// RPECK 02/08/2023 - Transparent
	// (Optional) For the color field type - allows us to show or hide whether the "transparent" checkbox shows
	public $transparent = false;

	// RPECK 29/07/2023 - Compiler
	// Added to give us a means to hook into the save action of the field (defaults to true)
	// --
	// https://devs.redux.io/configuration/fields/compiler.html
	public $compiler = true;

	// RPECK 06/08/2023 - Permissions
	// (Optional) Allows us to determine the level of permission required to change/edit the field
	public $permissions;

	// RPECK 03/08/2023 - Limit
	// This is used in the repeater field to get around the default limit of 10
	public $limit = 100;

    // RPECK 04/08/2023 - Mode
    // (Optional) Used in the ACE Editor field type to define what type of code is being used (EG CSS, PHP etc)
    // --
    // https://devs.redux.io/core-fields/ace-editor.html#arguments
    public $mode;

	// RPECK 14/08/2023 - Init Empty
	// (Optional) allows the repeater field to load up empty (defaults to true)
	public $init_empty = true;

	// RPECK 16/08/2023 - Save Callback
	// Used to populate dynamic callback functions, can ignore
	public $save_callback;

	// RPECK 16/08/2023 - Load Callback
	// Used to populate dynamic callback functions, can ignore
	public $load_callback;

	// RPECK 17/08/2023 - Dynamic text
	// Hook used to provide the means to output the field's TEXT content to Kadence Blocks
	// --
	// Defaults to false - if true, we need to add a filter to allow Kadence to dynamically allocate different pieces of content
	public $dynamic_text = false;
	
	// RPECK 18/08/2023 - Dynamic Link
	// Hook used to provide the means to output the field's URL content to Kadence Blocks
	// --
	// Defaults to false - if true, we need to add a filter to allow Kadence to dynamically allocate different pieces of content
	public $dynamic_link = false;

	// RPECK 21/08/2023 - Dynamic Conditional
	// Used to provide the means to allocate different conditional items in dynamic blocks
	public $dynamic_conditional = false;

	// RPECK 22/08/2023 - Multi
	// Used in the select field to provide the means to allocate multiple items per field 
	public $multi = false;

	// RPECK 27/08/2023 - Args
	// Allows us to change the various details required for the multi field types
	public $args;

    // RPECK 10/09/2023 - Show
    // Used in the slides field
    public $show;

	// RPECK 24/07/2023 - Constructor
	// Accepts arguments used to populate the section
	function __construct($values = array()) {

		// RPECK 26/07/2023 - Values
		// This allows us to allocate different values to the properties listed above
		if(!is_null($values) && is_array($values)) {

			// RPECK 26/07/2023 - Allocate a value to a property in the class
			// This populates the instance of the class with the various properties passed through from the parent class
			foreach($values as $key => $value) {

				// RPECK 26/07/2023 - Allocate value
        		// Can only be done if the property exists on the class
				if(property_exists($this, $key) || in_array($key, array('load_callback', 'save_callback'))) {
                    
					// RPECK 27/07/2023 - Check to see which key is being used and perform necessary actions
					// This is mainly to accommodate the "fields" property
					switch($key) {
						case('fields'):

							// RPECK 27/07/2023 - Return array
							// Provides the ability to return the entire payload to the $this->$key property
							$return = array();

							// RPECK 27/07/2023 - Fields
							// This was put in place because the likes of the repeater field had sub fields which also need to be accommodated
							foreach($value as &$field) {

								// RPECK 27/07/2023 - Allocate a new instance of this class to the field
								// Should give us the means to apply the functionality recursively
								array_push($return, new self($field));

							}

							// RPECK 27/07/2023 - Return values
							// If the return value is populated, apply it to the system
							if(!is_null($return) && is_array($return)) $this->$key = $return;

							// RPECK 06/08/2023 - Break
							// Breaks out of the loop created by the switch statement
							break;

						default: 
							$this->$key = $value;

					}

				}

			}

		}

	}	

	// RPECK 26/07/2023 - Initialize
	// This initializes the field, allowing us to set its value in the 
	public function initialize($opt_name, $section_id) {

		// RPECK 26/07/2023 - Set fields for section
		// This was extracted to ensure we are able to manage this sort of thing in a modular way
		// --
		// https://devs.redux.io/configuration/objects/field.html#setting-fields-s
		\Redux::set_field( 
			$opt_name, 
			$section_id, 
			$this->get_array()   
		);

		// RPECK 17/08/2023 - If the dynamic content property is true / present, we need to allocate the various items 
		// We've added this per field, which may create a lot of unwanted filter values, but we'll see
		if($this->dynamic_text != false || $this->dynamic_link != false || $this->dynamic_conditional != false) add_filter('kadence_dynamic_content_render', array($this, 'dynamic_content_render'), 10, 9);

	}

	// RPECK 17/08/2023 - Dynamic Content Render
	// Gives us the ability to outline exactly what response should be provided per field
	// --
	// ./wp-content/kadence-blocks-pro/includes/dynamic-content/class-kadence-blocks-pro-dynamic-content.php#3036
	public function dynamic_content_render($output, $item_id, $origin, $group, $field, $para, $custom, $relate, $relcustom) {

		// RPECK 17/08/2023 - Check to see if we're dealing with Redux
		// Because the other groups have been hard-coded by the plugin, we need to populate this ourselves
		if(str_starts_with($group, 'redux') && $field == $this->id) {
			
			// RPECK 17/08/2023 - Global
			// Get the global redux variable
			global $kadence_child_theme;
			
			// RPECK 18/08/2023 - Dynamic property
			// This is required to give us the means to get the various properties depending on which group is used
			preg_match('/redux_(.*)/', $group, $matches);
			
			// RPECK 18/08/2023 - If matches are populated
			// Gives us the means to manage what code is run as a result of the matches being loaded
			if(is_array($matches) && isset($matches[1])) {
				
				// RPECK 17/08/2023 - Set dynamic property
				// This is a variable we can use to call the right data
				$dynamic_property = "dynamic_{$matches[1]}";
	
				// RPECK 17/08/2023 - Check if closure
				// Closure is an anonymous function, which is one of the values we can pass to dynamic_content
				// --
				// If the value of dynamic_content is a Closure, we need to get the value of $output by executing it
				$value = ($this->$dynamic_property instanceof \Closure) ? call_user_func($this->$dynamic_property, $kadence_child_theme[ $this->id ]) : $kadence_child_theme[ $this->id ];

				// RPECK 17/08/2023 - Output the field value (no need for loop because this is per field)
				// This needs to be coded to co-incide with the original setting of these (probably with a class)
				$output = apply_filters('KadenceChild\redux_dynamic_render_{$this->id}', $value);
				
			}
			
		}
		
		// RPECK 17/08/2023 - Return the generated output
		// Because this filter is used by all of the dynamic content, we need to pass the $output through regardless
		return $output;

	}

	// RPECK 26/07/2023 - Value Array
	// Outputs an array of the values stored in the class properties
	public function get_array() {

		// RPECK 26/07/2023 - Vars
		// Define the various variables for use within the system
		$return = array();

		// RPECK 26/07/2023 - Loops through properties and returns an array of values
		// This uses array_walk to traverse the object vars of the system
		foreach(get_object_vars($this) as $key => $value) {

			// RPECK 27/07/2023 - Only proceed if the $value is populated
			if(!is_null($value)) {

				// RPECK 27/07/2023 - Set the return value as an array
				// Gives us the means to populate the array as needed
				// --
				// https://stackoverflow.com/a/67898815/1143732
				$return[ $key ] = is_array($value) ? array() : $value;

				// RPECK 26/07/2023 - Allocate the item to the return array
				// No conditions required at the moment
				if(is_array($value) && count($value) > 0) {

					// RPECK 27/07/2023 - Loop through array (EG fields) and populate values as needed
					// This allows us to perform tasks on the item
					foreach($value as $item_key => $item) {

						// RPECK 27/07/2023 - Work with the items
						// At the moment, this is only fields but it may change
						// --
						// RPECK 28/07/2023 - Added instanceof conditional check to only trigger event if it's an instantiated Field class
						$return[ $key ][ $item_key ] = $item instanceof self ? $item->get_array() : $item;

					}

				}

			}

		}

		// RPECK 26/07/2023 - Return
		// This gives us the ability to return the data to the function which called it
		return $return;

	}

	// RPECK 06/08/2023 - Actions
	// This used to be a single callback, but I found the "save" hook was generic (IE passed through values, not just changed)
	public function trigger($action, $value, $opt_name) {

		// RPECK 07/08/2023 - Get the $action value
		// Because we're passing 'load' or 'save' as the action, we need to create a variable with the actual callback name
		$callback = "{$action}_callback";

		// RPECK 06/08/2023 - Callback function
		// Introduced to give us the means to manage specific functionality bound to the field itself (IE create a callback and have it acccessed at runtime)
		// --
		// https://stackoverflow.com/a/1499867/1143732
		// https://stackoverflow.com/a/12196632/1143732
		if(property_exists($this, $callback) && !is_null($this->$callback)) call_user_func($this->$callback, $value, $opt_name);

	}

}