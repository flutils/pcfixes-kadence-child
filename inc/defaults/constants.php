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
			'heading' 	 => 'Constants',
            'priority'   => 2,
            'desc'       => '
                <p>Constants within the system which can be used to populate the likes of ACF\'s license key.</p>
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