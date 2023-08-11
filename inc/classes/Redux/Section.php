<?php

//////////////////////////
//////////////////////////

// RPECK 16/07/2023 - Redux Section Class 
// Gives us the means to instantiate the various sections we need from Redux
// -- 
// Used to provide the means to instantiate different sections from a provided array payload
// https://devs.redux.io/configuration/objects/section.html#arguments

// The aim of this is to have an array of section data which we can populate via a hook
// This data will allow us to append the different sections and manage them based on the properties outlined here

//////////////////////////
//////////////////////////

// RPECK 13/07/2023 - Namespace
// This was taken from the primary Kadence system - no need to change it
namespace KadenceChild\Redux;

// RPECK 25/07/2023 - Libraries
// Allows us to define the various functions/classes we use from other parts of the app
use function __;
use const KadenceChild\KADENCE_CHILD_TEXT_DOMAIN;

// RPECK 16/07/2023 - No direct access
// Maintain the security of the system by blocking anyone who tries to access the file directly
defined( 'ABSPATH' ) || exit;

// RPECK 16/07/2023 - Class
// Class through which Redux Framework configured and initialized
class Section {

	// RPECK 24/07/2023 - ID
	// (Required) Used to provide the means to identify the section. If not provided, the title is used instead
	public $id;

	// RPECK 24/07/2023 - Replace
	// (Optional) This is a variable passed to set_section which is used to determine whether the section will replace any others that have a similar name (defaults to false)
	// --
	// This seems to be for if you want to create a new section to overwrite a previously-delcared one
	// https://devs.redux.io/configuration/objects/section.html#updating-an-existing-section
	public $replace = false;

	// RPECK 24/07/2023 - Title
	// (Required) The title of the section, used to define various other attributes within the system
	public $title = '';

	// RPECK 24/07/2023 - Heading
	// (Optional) The heading title of the section, which is used to output its name. If not present, title is used
	public $heading;

	// RPECK 24/07/2023 - Description
	// (Optional) Description under the heading. This can be populated with HTML
	public $desc;

	// RPECK 24/07/2023 - CSS Classes
	// (Optional) Allows us to add class names to the section's class HTML attribute
	public $class;

	// RPECK 24/07/2023 - Icon
	// (Optional) The icon used in the menu panel of Redux (either raw URL or Elusive icon)
	// --
	// http://elusiveicons.com/icons/
	public $icon;

	// RPECK 24/07/2023 - Icon Type
	// (Optional) If the icon is not one of the Elusive icons, set to "image"
	public $icon_type;

	// RPECK 24/07/2023 - Permissions
	// (Optional) Permission level required of users to make changes to the section (defaults to 5)
	public $permissions;

	// RPECK 05/08/2023 - Priority
	// This is used to sort the sections when stored in an array
	public $priority = 10;

	// RPECK 25/07/2023 - Fields
	// This is an array of data which is used to populate the fields array of the endpoint
	// Whilst I wanted to leave this off, I felt it best to include it to so we could have the means to define/refine the fields as needed
	public $fields = array();

	// RPECK 24/07/2023 - Customizer Only
	// (Optional) Whether the section should appear in the theme customizer only
	public $customizer_only = false;

	// RPECK 24/07/2023 - Subsection
	// (Optional) Whether the section should be a subsection of the preceding section
	public $subsection = false;

	// RPECK 24/07/2023 - Disabled
	// (Optional) If the section is disabled or not
	public $disabled = false;
 
	// RPECK 24/07/2023 - Constructor
	// Accepts arguments used to populate the section
	function __construct($opt_name, $args = array()) {

		// RPECK 25/07/2023 - Opt Name
		// This is used to provide us with the means to manage how the ID of the section is allocated
		// --
		// Despite being set in the \KadenceChild\Redux\Core class, I could not find a way to inheret the value
		$this->opt_name = $opt_name;

		// RPECK 24/07/2023 - Populate the class with arguments
		// This is required to give us the means to pull in data from the system
		if(!is_null($args) && is_array($args)) array_walk($args, function($value, $key) {

			// RPECK 24/07/2023 - Set properties
			// This takes the values passed by $args and allows us to allocate them
			if(property_exists($this, $key)) {
				
				// RPECK 25/07/2023 - Check to see if the value needs to be handled differently
				// This was added to give us the means to populate the fields property
				switch ($key) {
					case 'fields':

						// RPECK 26/07/2023 - Fields
						// Because we are passing an array of arrays, we need to loop over them, instantiate each as a class and then pass them back to the $this->fields array
						// --
						// To do this, I used array_walk to populate the values of $this->$key
						if(is_array($value)) {

							// RPECK 06/08/2023 - Fields Hook
							// Added here to ensure we have the means to identify exactly 
							$value = apply_filters("KadenceChild\section_{$this->id}_fields", $value);
							
							// RPECK 26/07/2023 - Populate array if it is an array
							// This takes the inputted $value array, walks through it and uses the result to append to the $this->key value
							array_walk($value, function($object_value, $object_key) use ($key) {

								// RPECK 26/07/2023 - Update the fields property on this class
								// Allows us to ensure we are building the structure correctly
								array_push($this->$key, new Field($object_value));

							});

						} else {

							// RPECK 26/07/2023 - Populate a new Field class if the values are not an array
							// This is only if someone passes a single field, which shouldn't happen but probably will
							$this->$key = new Field($value);

						}

						// RPECK 29/07/2023 - Break
						// Exits the swtich/case loop
						break;

					default:
						$this->$key = $value;
				}

			}

		});

	}	

    // RPECK 24/07/2023 - Set Section
    // Creates the section inside Redux - instantiating this class and ensuring we are able to access its methods from memory
    public function set_section($set_fields = true) {

		// RPECK 24/07/2023 - Set Section
		// This is the primary Redux method for adding a section
		// --
		// https://devs.redux.io/configuration/objects/section.html
		\Redux::set_section($this->opt_name,
			array(
			'id'      	 => $this->id,
			'title'   	 => __($this->title,   KADENCE_CHILD_TEXT_DOMAIN),
			'icon'    	 => __($this->icon,    KADENCE_CHILD_TEXT_DOMAIN),
			'heading' 	 => __($this->heading, KADENCE_CHILD_TEXT_DOMAIN),
			'desc'    	 => __($this->desc,    KADENCE_CHILD_TEXT_DOMAIN),
			'subsection' => $this->subsection
			),
			$this->replace
		);

		// RPECK 26/07/2023 - Set Fields
		// If the fields are true, it means we are going to set the section's fields at the same time as the section itself 
		if($set_fields) $this->set_fields();

		// RPECK 29/07/2023 - On Save
		// Hooks into the "save" process of the fields
		add_action("redux/options/{$this->opt_name}/saved", array($this, 'on_save'), 0);

		// RPECK 06/08/2023 - On Load
		// This loads the various settings at initialization of the system
		add_action('redux/loaded', array($this, 'on_load'), 0);

    }

	// RPECK 26/07/2023 - Set Fields
	// Removed fields definition from here - added it separately due to being able to use "set_fields"
	// https://devs.redux.io/configuration/objects/field.html#redux-set-fields
	public function set_fields() {
		
		// RPECK 26/07/2023 - Set fields
		// This initializes the field values from within the field
		if(!is_null($this->fields) && is_array($this->fields)) {

			// RPECK 26/07/2023 - Loop through the array of field objects
			// This will give us the means to initialize each of them
			array_map(function($field) {

				// RPECK 26/07/2023 - Initialize field
				// This will populate the field using the initialize method on the Field class
				if($field instanceof Field) $field->initialize($this->opt_name, $this->id);

			}, $this->fields);

		}

	}

	// RPECK 04/08/2023 - On Save
	// Triggered when Redux is saved. Extracted to the Section class so we can systemetize it all
	public function on_save($options) {

		// RPECK 05/08/2023 - Trigger save function of fields
		// This will run whatever is attached to the field
		foreach($this->fields as &$field) {

			// RPECK 06/08/2023 - Field run save callback whilst passing the option value
			// This slims down the functionality massively
			if(!empty($options[ $field->id ])) $field->trigger('save', $options[ $field->id ] );

		}
		
	}

	// RPECK 06/08/2023 - On Load
	// Triggered when Redux is loaded. It does not pass any values
	public function on_load() {
	
		// RPECK 31/07/2023 - Global Var
		// Since our default opt_name uses hyphens, we need a way to convert them to underscores for the purpose of accessing the global var
		// -
		// Redux seems to do this already
		// https://github.com/reduxframework/redux-framework/blob/2afae012aa4cc2bdde80680b8a03c4850b369df9/redux-core/inc/classes/class-redux-args.php#L371
		$global_variable_name = str_replace('-', '_', $this->opt_name);

		// RPECK 31/07/2023 - Global Variable
		// Loads the global variable of Redux, allowing us to gain access to the various values it contains
		global ${$global_variable_name};

		// RPECK 05/08/2023 - Trigger save function of fields
		// This will run whatever is attached to the field
		foreach($this->fields as &$field) {

			// RPECK 06/08/2023 - Field run save callback whilst passing the option value
			// This slims down the functionality massively
			if(array_key_exists($field->id, ${$global_variable_name}) && !is_null(${$global_variable_name}[ $field->id ])) $field->trigger('load', ${$global_variable_name}[ $field->id ] );

		}
		
	}

}