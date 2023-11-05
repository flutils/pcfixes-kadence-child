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
			'heading'  => '<h1>🚀 General Settings</h1>',
            'priority' => 1,
			'desc'     => '
				--<br />
				<strong>Generalized settings for the website.</strong>
				<p>This includes the favicon, title and several other things.</p>
			',
			'fields'  => array(

				// RPECK 29/07/2023 - Title
				// Populates the title of Wordpress
				array(
					'id'    	  	=> 'title',
					'type'  	  	=> 'text',
					'title' 	  	=> '📜 Site Title',
					'placeholder' 	=> get_bloginfo('name'),
					'subtitle'    	=> 'Child theme title - used to differentiate between themes as well as updated the core site title in Kadence & Wordpress.',
					'desc'		  	=> 'Populates site title in Kadence/Wordpress.',
					'save_callback' => function($value) {

						// RPECK 29/07/2023 - Send the title to Wordpress
						// This is a standard process which can be used to populate parts of the site
						// -- 
						// The callback should only be triggered if the $value is present anyway
						update_option('blogname', __($value, KADENCE_CHILD_TEXT_DOMAIN));

					},
					'load_callback' => function($value, $opt_name) {

						// RPECK 16/08/2023 - Update setting when customizer changes
						// Gives us the ability to ensure this is kept up to date
						add_action('customize_save_after', function($customizer) use ($opt_name, $value) {

							// RPECK 16/08/2023 - Title
							// Store as variable so we don't need to keep accessing it from the database
							$title = $customizer->get_setting('blogname')->value();

							// RPECK 16/08/2023 - Check if $title is the same as $value
							// If not, then, proceed to add the filter
							if($title != $value) {

								// RPECK 16/08/2023 - Get the custom_logo setting
								// Due to an instance of the customizer class being passed to the function, we need to use get_setting
								// -- 
								// https://devs.redux.io/guides/advanced/updating-an-option-manually.html
								// https://devs.redux.io/configuration/api.html#available-methods
								\Redux::set_option($opt_name, 'title', $title);

							}

						});

					}
				),

				// RPECK 29/07/2023 - Title
				// Populates the title of Wordpress
				array(
					'id'    	  => 'tagline',
					'type'  	  => 'text',
					'title' 	  => '✔️ Site Tagline',
					'placeholder' => get_bloginfo('description'),
					'subtitle'    => 'This populates the tagline of the site',
					'desc'		  => 'Same as Kadence / Wordpress.',
					'save_callback' => function($value) {

						// RPECK 29/07/2023 - Send the description to Wordpress
						// This is a standard process which can be used to populate parts of the site
						update_option('blogdescription', __($value, KADENCE_CHILD_TEXT_DOMAIN));

					},
					'load_callback' => function($value, $opt_name) {

						// RPECK 16/08/2023 - Update setting when customizer changes
						// Gives us the ability to ensure this is kept up to date
						add_action('customize_save_after', function($customizer) use ($opt_name, $value) {

							// RPECK 16/08/2023 - Description
							// Store as variable so we don't need to keep accessing it from the database
							$description = $customizer->get_setting('blogdescription')->value();

							// RPECK 16/08/2023 - Check if $title is the same as $value
							// If not, then, proceed to add the filter
							if($description != $value) {

								// RPECK 16/08/2023 - Get the custom_logo setting
								// Due to an instance of the customizer class being passed to the function, we need to use get_setting
								// -- 
								// https://devs.redux.io/guides/advanced/updating-an-option-manually.html
								// https://devs.redux.io/configuration/api.html#available-methods
								\Redux::set_option($opt_name, 'tagline', $description);

							}

						});
						
					}
				),

				// RPECK 29/07/2023 - Site Logo
				// Allows us to change the favicon of the site (integrates with Kadence)
				array(
					'id'    	=> 'logo',
					'type'  	=> 'media',
					'title' 	=> '🌌 Site Logo',
					'subtitle'  => 'Site logo for the top header area of Kadence.',
					'save_callback' => function($value) {

                        // RPECK 15/08/2023 - Save the logo value in the database
                        // This allows us to update the theme mods to ensure we have the correct value in the db
                        if(is_array($value) || is_null($value)) set_theme_mod('custom_logo', $value['id']);

                    },
                    'load_callback' => function($value, $opt_name) {

                        // RPECK 16/08/2023 - Update setting when customizer changes
                        // Gives us the ability to ensure this is kept up to date
                        add_action('customize_save_after', function($customizer) use ($opt_name) {

                            // RPECK 16/08/2023 - Store the returned value in a variable
                            // Sets the $id var for use further in the function
                            $id = $customizer->get_setting('custom_logo')->value(); //get_theme_mod('custom_logo');

                            // RPECK 16/08/2023 - Set data as null in the case of the 
                            // This ensures we are able to populate the value without any error messages 
                            $data = null;

                            // RPECK 16/08/2023 - Check ID to ensure it is present
                            // If it is present, allocate $data to an array, else pass the value as null
                            if(!empty($id)) {

                                // RPECK 16/08/2023 - Get attachment metadata
                                // This gives us the means to update the 'media' value of Redux (which requires URL etc)
                                $values = wp_get_attachment_metadata($id);

                                // RPECK 16/08/2023 - Compile the provided value 
                                // This allows us to populate the Redux Framework 'media' field, which has the following keys
                                $data = array(
                                    'url'       => wp_get_attachment_image_url($id, 'full'),
                                    'id'        => $id,
                                    'height'    => $values['height'],
                                    'width'     => $values['width'],
                                    'thumbnail' => wp_get_attachment_image_url($id)
                                );

                            }

                            // RPECK 16/08/2023 - Get the custom_logo setting
                            // Due to an instance of the customizer class being passed to the function, we need to use get_setting
							// -- 
							// https://devs.redux.io/guides/advanced/updating-an-option-manually.html
							// https://devs.redux.io/configuration/api.html#available-methods
                            \Redux::set_option($opt_name, 'logo', $data);

                        });

                    }
				),

				// RPECK 29/07/2023 - Favicon
				// Allows us to change the favicon of the site (integrates with Kadence)
				array(
					'id'    	=> 'favicon',
					'type'  	=> 'media',
					'title' 	=> '🎨 Favicon',
					'subtitle'  => 'Favicon for the child theme (interfaces with Kadence).',
					'save_callback' => function($value) {

						// RPECK 15/08/2023 - Save the logo value in the database
						// This allows us to update the theme mods to ensure we have the correct value in the db
						update_option('site_icon', $value['id']);

					},
                    'load_callback' => function($value, $opt_name) {

                        // RPECK 16/08/2023 - Update setting when customizer changes
                        // Gives us the ability to ensure this is kept up to date
                        add_action('customize_save_after', function($customizer) use ($opt_name) {

                            // RPECK 16/08/2023 - Store the returned value in a variable
                            // Sets the $id var for use further in the function
                            $id = $customizer->get_setting('site_icon')->value(); //get_theme_mod('custom_logo');

                            // RPECK 16/08/2023 - Set data as null in the case of the 
                            // This ensures we are able to populate the value without any error messages 
                            $data = null;

                            // RPECK 16/08/2023 - Check ID to ensure it is present
                            // If it is present, allocate $data to an array, else pass the value as null
                            if(!empty($id)) {

                                // RPECK 16/08/2023 - Get attachment metadata
                                // This gives us the means to update the 'media' value of Redux (which requires URL etc)
                                $values = wp_get_attachment_metadata($id);

                                // RPECK 16/08/2023 - Compile the provided value 
                                // This allows us to populate the Redux Framework 'media' field, which has the following keys
                                $data = array(
                                    'url'       => wp_get_attachment_image_url($id, 'full'),
                                    'id'        => $id,
                                    'height'    => $values['height'],
                                    'width'     => $values['width'],
                                    'thumbnail' => wp_get_attachment_image_url($id)
                                );

                            }

                            // RPECK 16/08/2023 - Get the custom_logo setting
                            // Due to an instance of the customizer class being passed to the function, we need to use get_setting
							// -- 
							// https://devs.redux.io/guides/advanced/updating-an-option-manually.html
							// https://devs.redux.io/configuration/api.html#available-methods
                            \Redux::set_option($opt_name, 'favicon', $data);

                        });

                    }
				),

				// RPECK 14/08/2023 - Search Engine Visibility
				// May as well put it here in case we want to copy the settings between sites
				array(
					'id'      	=> 'seo_visibility',
					'type'    	=> 'switch',
					'title'   	=> '🕷️ Search Visibility',
					'subtitle'	=> 'Should the site be accessible to search engine bots?',
					'default'	=> get_option('blog_public'),
					'on'		=> 'Yes',
					'off'		=> 'No',
					'save_callback' => function ($value) {

						// RPECK 14/08/2023 - Update the option
						// This gives us the means to make the blog visible or not 
						// --
						// Due to our child-functions.php file including pre_update_option, this should only trigger if it has changed
						update_option('blog_public', $value);

					}

				),
			
				// RPECK 11/08/2023 - Divider
				// Gives us the means to separate the different elements
				array(
					'id'	=> 'author_title',
					'type'  => 'divide',
					'title' => '<h1><strong>🧑 Author / Company Information</strong></h1>',
					'subtitle'	=> '
								--<br/>
								<p><strong>Details about the author of the website.</strong></p>
								<p>Gives us the ability to define everything from name to description.</p>
							'
				),

				// RPECK 18/08/2023 - Author Name
				// Information about the author, required to give us the means to manage exactly what's 
				array(
					'id'          	  => 'author_name',
					'type'        	  => 'text',
					'title'       	  => '📛 Author Name',
					'placeholder' 	  => 'Author Name',
					'subtitle'    	  => 'The name of the author, allowing us to reference it throughout the site if needed.',
					'dynamic_text' => true
				),

				// RPECK 14/08/2023 - Author Address
				// This is used to provide the values for the underlying Parish information in the header / footer etc
				array(
					'id'          	  => 'author_description',
					'type'        	  => 'text',
					'title'           => '📔 Author Description',
					'placeholder' 	  => 'Author description',
					'subtitle'    	  => 'Information about the author.',
					'dynamic_text' => true
				),

				// RPECK 14/08/2023 - Author Website
				// Provides the ability to input the website of the author
				array(
					'id'          	  => 'author_url',
					'type'        	  => 'text',
					'title'           => '🌍 Author URL',
					'placeholder' 	  => 'Author URL',
					'subtitle'    	  => 'Website of the author (if appropriate).',
					'dynamic_link' 	  => true
				)

			) 
			
		);

		// RPECK 05/08/2023 - Instantiate the parent class
		// This brings in the different items which
		parent::__construct($opt_name, $args);

	}

}