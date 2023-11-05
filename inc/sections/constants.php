<?php

//////////////////////////
//////////////////////////

// RPECK 09/08/2023 - Constants
// Provides us with a basis from which to define a number of constants (such as API keys etc)
// --
// Whilst there are obvious potential security flaws with this, it's the most effective way to implement it at present

//////////////////////////
//////////////////////////

// RPECK 04/08/2023 - Namespace
// This was taken from the primary Kadence system - no need to change it
namespace KadenceChild;

// RPECK 04/08/2023 - Libraries
// Loads the various classes & functions required by the class
use KadenceChild\Redux\Section;

// RPECK 16/07/2023 - No direct access
// Maintain the security of the system by blocking anyone who tries to access the file directly
defined( 'ABSPATH' ) || exit;

// RPECK 04/08/2023 - Class definition
// Gives us the means to manage the various parts of the admin area by extending the base Section class
class Constants extends Section {

	// RPECK 05/08/2023 - Default Values
	// This loads the various values for this class (and parent)
	function __construct($opt_name) {

		// RPECK 05/08/2023 - Vars
		// The various items required to populate the parent class
		$args = array(

			'id' 	  	 => 'constants',
			'title'   	 => 'Constants',
			'icon'    	 => 'el-icon-barcode ',
			'heading' 	 => '<h1>📚 Constants</h1>',
			'permissions' => 'manage_options',
			'priority'   => 3,
			'desc'       => '
                --<br />
				<strong>Constants within the system</strong> - can be used to populate API keys etc.</p>
			',
			'subsection' => true,
			'fields'     => array(

				// RPECK 04/08/2023 - Shortcode Repeater
				// The repeater which allows us to define different shortcodes inside the system
				array(
					'id'             => 'constants',
					'type'           => 'repeater',
					'title'          => '💻 Definitions',
					'subtitle'       => '
						<p>Add the different definitions for the constants with this repeater.</p>
					',
					'group_values' => true, 
					'item_name'    => 'Constant',
					'sortable'     => true, 
					'fields' => array(

						// RPECK 13/08/2023 - Constant Name
						// The value of the constant's name (EG GOOGLE_MAPS_API_KEY)
						array(
							'id'          => 'name',
							'type'        => 'text',
							'placeholder' => 'EG GOOGLE_MAPS_API_KEY',
							'title'       => 'Name',
							'subtitle'    => 'The name of the constant (will be defined in the global scope)'
						),

						// RPECK 13/08/2023 - Active
						// Is the constant active?
						array(
							'id'      	=> 'active',
							'type'    	=> 'switch',
							'title'   	=> 'Active?',
							'subtitle'	=> 'Is the constant active?',
							'default'	=> false,
							'on'		=> 'Yes',
							'off'		=> 'No'
						),
						
						// RPECK 31/10/2023 - Shortcode
						// Whether to make the constant available to the template layer via a shortcode
						array(
							'id'      	=> 'shortcode',
							'type'    	=> 'switch',
							'title'   	=> 'Shortcode?',
							'subtitle'	=> 'Do you want the data to be available through the template system (as a [CONSTANT] shortcode)?',
							'default'	=> false,
							'on'		=> 'Yes',
							'off'		=> 'No'
						),

						// RPECK 13/08/2023 - Constant Content
						// The value of the payload that the constant should keep (text only)
						array(
							'id'       => 'content',
							'type'     => 'text',
							'title'    => 'Content',
							'subtitle' => 'The content of the constant (text only)',
							'desc'     => 'If you are looking to add anything substantive, you will likely be best using a global variable.'
						)

					),
					'save_callback' => function($value) {
					    
						// RPECK 13/08/2023 - Repeater Array
						// We need to cycle through the various items due to the repeater
						if(is_array($value) && count($value) > 0 && array_key_exists('redux_repeater_data', $value) && count($value['redux_repeater_data']) > 0) {

							// RPECK 13/08/2023 - Define the constants raw
							// There is no need to wait for Wordpress to initialize as we want to hit it immediately
							$val = Helpers::repeaterData($value);

							// RPECK 13/08/2023 - Populate constants if present
							// Gives us the means to manage the different constants we want to define
							array_walk($val, function($item) {
								
								// RPECK 01/11/2023 - Added a 'save' callback for these items
								// Allows us to bind functionality to them via the action hooks system
								do_action("KadenceChild\constants\\{$item['name']}\\save", $item);

							});

						}					    
					    
					},
					'load_callback' => function($value) {

						// RPECK 13/08/2023 - Repeater Array
						// We need to cycle through the various items due to the repeater
						if(is_array($value) && count($value) > 0 && array_key_exists('redux_repeater_data', $value) && count($value['redux_repeater_data']) > 0) {

							// RPECK 13/08/2023 - Define the constants raw
							// There is no need to wait for Wordpress to initialize as we want to hit it immediately
							$val = Helpers::repeaterData($value);

							// RPECK 13/08/2023 - Populate constants if present
							// Gives us the means to manage the different constants we want to define
							array_walk($val, function($item) {
								
								// RPECK 13/08/2023 - Define the constant
								// This only works if the constant has not been defined previously. If it has been defined previously, the user needs to change it in the code as constants are not meant to change 
								if(array_key_exists('name', $item) && $item['active']) {
								    
								    // RPECK 31/10/2023 - If the constant is not defined, define it globally
								    if(!defined($item['name'])) define($item['name'], $item['content']);
								
								    // RPECK 31/10/2023 - If the shortcode setting it active, create a shortcode for the constants
								    // This will create the shortcode [CONSTANT] 
								    if(array_key_exists('shortcode', $item) && $item['shortcode'] !== false) {
								        
								        // RPECK 31/10/2023 - Define the shortcode
								        // This is gloally accessbile, allowing for use in templates etc
								        add_shortcode($item['name'], function() use ($item) {
								            
								            // RPECK 31/10/2023 - Returns the value of the constant
								            return $item['content'];
								            
								        });
								        
								    }
								    
								    // RPECK 01/11/2023 - Added a load action hook
    								// Allows us to bind functionality to them via the action hooks system
    								do_action("KadenceChild\constants\\{$item['name']}\\load", $item);
								
								}

							});

						}

					}

				)	

			)
			
		);

		// RPECK 05/08/2023 - Instantiate the parent class
		// This brings in the different items which
		parent::__construct($opt_name, $args);

	}

}