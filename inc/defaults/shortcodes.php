<?php

//////////////////////////
//////////////////////////

// RPECK 04/08/2023 - Redux Section Classes
// This was extracted out of the previous setup, which kept the sections defined in the constants file
// --
// Whilst this worked, it was cumbersome and not befitting an OOP setup

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
class Shortcodes extends Section {

	// RPECK 05/08/2023 - Default Values
	// This loads the various values for this class (and parent)
	function __construct($opt_name) {

		// RPECK 05/08/2023 - Vars
		// The various items required to populate the parent class
		$args = array(

			'id' 	  	 => 'shortcodes',
			'title'   	 => 'Shortcodes',
			'icon'    	 => 'el-icon-pencil',
			'heading' 	 => 'Shortcode',
            'priority'   => 2,
            'desc'       => '
                <p><strong>Add shortcodes</strong> - the system is able to provide the ability to add & manage different shortcodes.</p>
            ',
			'subsection' => true,
			'fields'     => array(

				// RPECK 04/08/2023 - Shortcode Repeater
				// The repeater which allows us to define different shortcodes inside the system
				array(
					'id'             => 'shortcodes',
					'type'           => 'repeater',
					'title'          => '🗒️ Definitions',
					'subtitle'       => '
						<p><strong>Add shortcodes to the system</strong> - defines exactly which shortcodes are to be added to the system and provides a means to copy them if needed.</p>
					',
                    'fields' => array(

                        // RPECK 04/08/2023 - Shortcode value
                        // This is the value of the shortcode (IE the actual name)
						array(
							'id'          => 'tag',
							'type'        => 'text',
							'placeholder' => 'EG shortcode_value (underscore only)',
							'title'       => 'Shortcode Tag',
							'subtitle'    => 'The shortcode tag which can be used to provide the tag'
						),

                        // RPECK 04/08/2023 - Active
                        // This is the value of the shortcode (IE the actual name)
						array(
							'id'      	=> 'active',
							'type'    	=> 'switch',
							'title'   	=> 'Active?',
							'subtitle'	=> 'Is the shortcode active?',
							'default'	=> false,
							'on'		=> 'Yes',
							'off'		=> 'No'
						),

                        // RPECK 04/08/2023 - Shortcode Content
                        // The actual content of the shortcode (IE the PHP code)
						array(
                            'id'       => 'content',
                            'type'     => 'ace_editor',
                            'title'    => 'PHP Code',
                            'subtitle' => 'The PHP for the shortcode (global $attrs and $content).',
                            'mode'     => 'php',
                            'default'  => '
<?php

    // PHP Code here
    
?>
                            '
						)

                    )
                )	

			)
			
		);

		// RPECK 05/08/2023 - Instantiate the parent class
		// This brings in the different items which
		parent::__construct($opt_name, $args);

	}

}