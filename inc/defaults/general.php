<?php

//////////////////////////
//////////////////////////

// RPECK 08/08/2023 - Changed directory structure & file names
// Moved the defaults to ./inc/defaults rather than keeping them in the classes directory
// --
// The reason for doing this was mainly aesthetic. 
// Classes should contain the logic for the system, not default files that are not part of the system logic
// Originally wanted to make them JSON files, but that would prevent us using the callback functions

//////////////////////////
//////////////////////////

// RPECK 04/08/2023 - Namespace
// This was taken from the primary Kadence system - no need to change it
namespace KadenceChild;

// RPECK 04/08/2023 - Libraries & functions
// Loads the various classes & functions required by the class
use KadenceChild\Redux\Section;
use update_option;

// RPECK 06/08/2023 - Constants
// Used to provide us with the means to manage the underlying constants within the class
use const KadenceChild\KADENCE_CHILD_TEXT_DOMAIN;

// RPECK 16/07/2023 - No direct access
// Maintain the security of the system by blocking anyone who tries to access the file directly
defined( 'ABSPATH' ) || exit;

// RPECK 04/08/2023 - Class definition
// Gives us the means to manage the various parts of the admin area by extending the base Section class
class General extends Section {

	// RPECK 05/08/2023 - Default Values
	// This loads the various values for this class (and parent)
	function __construct($opt_name) {

		// RPECK 05/08/2023 - Vars
		// The various items required to populate the parent class
		$args = array(

			'id'       => 'general',
			'title'    => 'General',
			'icon'     => 'el-icon-globe',
			'heading'  => 'General Settings',
            'priority' => 1,
			'desc'     => '
				<strong>Generalized settings for the website.</strong>
				<p>This includes the favicon, title and several other things.</p>
			',
			'fields'  => array(

				// RPECK 29/07/2023 - Title
				// Populates the title of Wordpress
				array(
					'id'    	  	=> 'title',
					'type'  	  	=> 'text',
					'title' 	  	=> '📜 Title',
					'placeholder' 	=> get_bloginfo('name'),
					'subtitle'    	=> 'Child theme title - used to differentiate between themes as well as updated the core site title in Kadence & Wordpress.',
					'desc'		  	=> 'Populates site title in Kadence/Wordpress.',
					'save_callback' => function($value) {

						// RPECK 29/07/2023 - Send the title to Wordpress
						// This is a standard process which can be used to populate parts of the site
						// -- 
						// The callback should only be triggered if the $value is present anyway
						update_option('blogname', __($value, KADENCE_CHILD_TEXT_DOMAIN));

					}
				),

				// RPECK 29/07/2023 - Title
				// Populates the title of Wordpress
				array(
					'id'    	  => 'tagline',
					'type'  	  => 'text',
					'title' 	  => '✔️ Tagline',
					'placeholder' => get_bloginfo('description'),
					'subtitle'    => 'This populates the tagline of the site',
					'desc'		  => 'Same as Kadence / Wordpress.',
					'save_callback' => function($value) {

						// RPECK 29/07/2023 - Send the description to Wordpress
						// This is a standard process which can be used to populate parts of the site
						update_option('blogdescription', __($value, KADENCE_CHILD_TEXT_DOMAIN));

					}
				),

				// RPECK 29/07/2023 - Favicon
				// Allows us to change the favicon of the site (integrates with Kadence)
				array(
					'id'    	=> 'favicon',
					'type'  	=> 'media',
					'title' 	=> '🎨 Favicon',
					'subtitle'  => 'Favicon / Site Logo for the child theme.'
				),

				// RPECK 02/08/2023 - Disable File Editing
				// If this is enabled, it prevnts users from editing plugin or theme files
				array(
					'id'      	=> 'file_editing',
					'type'    	=> 'switch',
					'title'   	=> '💾 Allow File Editing?',
					'subtitle'	=> 'Should users be able to edit files (may be overridden by other plugins)?',
					'default'	=> false,
					'on'		=> 'Yes',
					'off'		=> 'No',
					'load_callback' => function($value) {

						// RPECK 02/08/2023 - Check to see if true or false
						// If it's true, then create the constant to disable the file editing, else don't
						// --
						// Taken from the SiteGround SG Security plugin (./core/Editors_Service/Editors_Service.php)
						if($value == false) {

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