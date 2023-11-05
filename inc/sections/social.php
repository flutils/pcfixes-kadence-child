<?php

//////////////////////////
//////////////////////////

// RPECK 20/08/2023 - Social Settings
// Added here to extract it from the general section

//////////////////////////
//////////////////////////

// RPECK 04/08/2023 - Namespace
// This was taken from the primary Kadence system - no need to change it
namespace KadenceChild;

// RPECK 04/08/2023 - Libraries & functions
// Loads the various classes & functions required by the class
use KadenceChild\Redux\Section;
use function set_theme_mod;

// RPECK 06/08/2023 - Constants
// Used to provide us with the means to manage the underlying constants within the class
use const KadenceChild\KADENCE_CHILD_TEXT_DOMAIN;

// RPECK 16/07/2023 - No direct access
// Maintain the security of the system by blocking anyone who tries to access the file directly
defined( 'ABSPATH' ) || exit;

// RPECK 04/08/2023 - Class definition
// Gives us the means to manage the various parts of the admin area by extending the base Section class
class Social extends Section {

	// RPECK 05/08/2023 - Default Values
	// This loads the various values for this class (and parent)
	function __construct($opt_name) {

		// RPECK 05/08/2023 - Vars
		// The various items required to populate the parent class
		$args = array(

			'id'         => 'social',
            'title'      => 'Socials',
			'icon'       => 'el-icon-facebook',
			'heading'    => '<h1><strong>📣 Socials</strong></h1>',
            'priority'   => 3,
            'subsection' => true,
			'desc'       => '
                --<br/>
                <p><strong>Manage "social" links for the site (changes Kadence settings).</strong></p>
                <p>Ensures we are able to allocate the different URLs for the various social services inside Kadence.</p>
			',
			'fields'  => array(

				// RPECK 14/08/2023 - Social (Facebook)
				// The social media URL for Facebook (hooks into Kadence)
				array(
					'id'          	=> 'facebook_link',
					'type'        	=> 'text',
					'title'         => 'Facebook',
					'placeholder' 	=> 'https://www.facebook.com/site_name',
					'subtitle'    	=> 'Gives us the means to manage the Facebook address',
					'dynamic_link'	=> true,
					'save_callback' => function($value) {

						// RPECK 15/08/2023 - Gives us the means to change the theme mod value
						// This sets the theme mod value, allowing us to use the various aspects of Kadence without having to manually change the options
						set_theme_mod('facebook_link', $value);

					},
					'load_callback' => function($value, $opt_name) {

						// RPECK 16/08/2023 - Update setting when customizer changes
						// Gives us the ability to ensure this is kept up to date
						add_action('customize_save_after', function($customizer) use ($opt_name, $value) {

							// RPECK 16/08/2023 - Title
							// Store as variable so we don't need to keep accessing it from the database
							$title = $customizer->get_setting('facebook_link')->value();

							// RPECK 16/08/2023 - Check if $title is the same as $value
							// If not, then, proceed to add the filter
							if($title != $value) {

								// RPECK 16/08/2023 - Get the custom_logo setting
								// Due to an instance of the customizer class being passed to the function, we need to use get_setting
								// -- 
								// https://devs.redux.io/guides/advanced/updating-an-option-manually.html
								// https://devs.redux.io/configuration/api.html#available-methods
								\Redux::set_option($opt_name, 'facebook_link', $title);

							}

						});

					}

				),

				// RPECK 14/08/2023 - Social (Twitter)
				// The social media URL for Twitter (hooks into Kadence)
				array(
					'id'          	=> 'twitter_link',
					'type'        	=> 'text',
					'title'         => 'Twitter',
					'placeholder' 	=> 'https://www.twitter.com/social_name',
					'subtitle'    	=> 'Gives us the means to manage the Twitter address',
					'dynamic_link'	=> true,
					'save_callback' => function($value) {

						// RPECK 15/08/2023 - Gives us the means to change the theme mod value
						// This sets the theme mod value, allowing us to use the various aspects of Kadence without having to manually change the options
						set_theme_mod('twitter_link', $value);

					},
					'load_callback' => function($value, $opt_name) {

						// RPECK 16/08/2023 - Update setting when customizer changes
						// Gives us the ability to ensure this is kept up to date
						add_action('customize_save_after', function($customizer) use ($opt_name, $value) {

							// RPECK 16/08/2023 - Title
							// Store as variable so we don't need to keep accessing it from the database
							$title = $customizer->get_setting('twitter_link')->value();

							// RPECK 16/08/2023 - Check if $title is the same as $value
							// If not, then, proceed to add the filter
							if($title != $value) {

								// RPECK 16/08/2023 - Get the custom_logo setting
								// Due to an instance of the customizer class being passed to the function, we need to use get_setting
								// -- 
								// https://devs.redux.io/guides/advanced/updating-an-option-manually.html
								// https://devs.redux.io/configuration/api.html#available-methods
								\Redux::set_option($opt_name, 'twitter_link', $title);

							}

						});

					}
				),

				// RPECK 14/08/2023 - Social (Instagram)
				// The social media URL for Instagram (hooks into Kadence)
				array(
					'id'          	=> 'instagram_link',
					'type'        	=> 'text',
					'title'         => 'Instagram',
					'placeholder' 	=> 'https://www.instagram.com/social_name',
					'subtitle'    	=> 'Gives us the means to manage the Instagram address',
					'dynamic_link' 	=> true,
					'save_callback' => function($value) {

						// RPECK 15/08/2023 - Gives us the means to change the theme mod value
						// This sets the theme mod value, allowing us to use the various aspects of Kadence without having to manually change the options
						set_theme_mod('instagram_link', $value);

					},
					'load_callback' => function($value, $opt_name) {

						// RPECK 16/08/2023 - Update setting when customizer changes
						// Gives us the ability to ensure this is kept up to date
						add_action('customize_save_after', function($customizer) use ($opt_name, $value) {

							// RPECK 16/08/2023 - Title
							// Store as variable so we don't need to keep accessing it from the database
							$title = $customizer->get_setting('instagram_link')->value();

							// RPECK 16/08/2023 - Check if $title is the same as $value
							// If not, then, proceed to add the filter
							if($title != $value) {

								// RPECK 16/08/2023 - Get the custom_logo setting
								// Due to an instance of the customizer class being passed to the function, we need to use get_setting
								// -- 
								// https://devs.redux.io/guides/advanced/updating-an-option-manually.html
								// https://devs.redux.io/configuration/api.html#available-methods
								\Redux::set_option($opt_name, 'instagram_link', $title);

							}

						});

					}
				),

				// RPECK 14/08/2023 - Social (YouTube)
				// The social media URL for YouTube (hooks into Kadence)
				array(
					'id'          	=> 'youtube_link',
					'type'        	=> 'text',
					'title'         => 'YouTube',
					'placeholder' 	=> 'https://www.youtube.com/social_name',
					'dynamic_link'	=> true,
					'subtitle'    	=> 'Gives us the means to manage the YouTube address',
					'save_callback' => function($value) {

						// RPECK 15/08/2023 - Gives us the means to change the theme mod value
						// This sets the theme mod value, allowing us to use the various aspects of Kadence without having to manually change the options
						set_theme_mod('youtube_link', $value);

					},
					'load_callback' => function($value, $opt_name) {

						// RPECK 16/08/2023 - Update setting when customizer changes
						// Gives us the ability to ensure this is kept up to date
						add_action('customize_save_after', function($customizer) use ($opt_name, $value) {

							// RPECK 16/08/2023 - Title
							// Store as variable so we don't need to keep accessing it from the database
							$title = $customizer->get_setting('youtube_link')->value();

							// RPECK 16/08/2023 - Check if $title is the same as $value
							// If not, then, proceed to add the filter
							if($title != $value) {

								// RPECK 16/08/2023 - Get the custom_logo setting
								// Due to an instance of the customizer class being passed to the function, we need to use get_setting
								// -- 
								// https://devs.redux.io/guides/advanced/updating-an-option-manually.html
								// https://devs.redux.io/configuration/api.html#available-methods
								\Redux::set_option($opt_name, 'youtube_link', $title);

							}

						});

					}
				)

			) 
			
		);

		// RPECK 05/08/2023 - Instantiate the parent class
		// This brings in the different items which
		parent::__construct($opt_name, $args);

	}

}