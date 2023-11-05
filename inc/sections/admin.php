<?php

//////////////////////////
//////////////////////////

// RPECK 13/08/2023 - Admin settings
// This was designed to implement the likes of admin menus etc

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
class Admin extends Section {

	// RPECK 05/08/2023 - Default Values
	// This loads the various values for this class (and parent)
	function __construct($opt_name) {

		// RPECK 05/08/2023 - Vars
		// The various items required to populate the parent class
		$args = array(

			'id' 	  	 => 'admin',
			'title'   	 => 'Admin',
			'icon'    	 => 'el-icon-lock',
			'heading' 	 => '<h1>🎉 Admin Options</h1>',
			'permissions' => 'manage_options',
            'priority'   => 2,
            'desc'       => '
				--<br />
                <strong>Manage different elements of the administration system</strong> - primarily used for the likes of changing the admin menu etc.
            ',
			'subsection' => true,
			'fields'     => array(


				// RPECK 02/08/2023 - Disable File Editing
				// If this is enabled, it prevnts users from editing plugin or theme files
				array(
					'id'      	=> 'file_editing',
					'type'    	=> 'switch',
					'title'   	=> '💾 Disable File Editing?',
					'subtitle'	=> 'Should users be unable to edit files (may be overridden by other plugins)?',
					'default'	=> true,
					'on'		=> 'Yes',
					'off'		=> 'No',
					'load_callback' => function($value) {

						// RPECK 02/08/2023 - Check to see if true or false
						// If it's true, then create the constant to disable the file editing, else don't
						// --
						// Taken from the SiteGround SG Security plugin (./core/Editors_Service/Editors_Service.php)
						if($value != false) {

							// RPECK 02/08/2023 - Uses the "Map Meta Cap" filter to inject an obscure capability if presented
							// This ensures we are able to override the various permissions to edit files even if the SG plugin is not present
							// --
							// https://developer.wordpress.org/reference/hooks/map_meta_cap/
							add_filter('map_meta_cap', function($caps, $cap) {
								return (in_array($cap, array( 'edit_themes', 'edit_plugins', 'edit_files'), true)) ? array('sg-security') : $caps;
							}, 10, 2);

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