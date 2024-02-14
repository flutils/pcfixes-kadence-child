<?php

//////////////////////////
//////////////////////////

// RPECK 11/08/2023 - Branding
// This allows us to change various aspects of the Wordpress branding inside the system (mostly taken from WhileLabel CMS)

//////////////////////////
//////////////////////////

// RPECK 04/08/2023 - Namespace
// This was taken from the primary Kadence system - no need to change it
namespace KadenceChild;

// RPECK 04/08/2023 - Libraries & functions
// Loads the various classes & functions required by the class
use KadenceChild\Redux\Section;

// RPECK 16/07/2023 - No direct access
// Maintain the security of the system by blocking anyone who tries to access the file directly
defined( 'ABSPATH' ) || exit;

// RPECK 04/08/2023 - Class definition
// Gives us the means to manage the various parts of the admin area by extending the base Section class
class Branding extends Section {

	// RPECK 05/08/2023 - Default Values
	// This loads the various values for this class (and parent)
	function __construct($opt_name) {

		// RPECK 05/08/2023 - Vars
		// The various items required to populate the parent class
		$args = array(

	        'id' 	  	 => 'branding',
			'title'   	 => 'Branding',
			'desc'	 	 => '
				--<br/>
				<p><strong>Various settings to change branded attributes inside the Wordpress system.</strong></p>
				<p>These may include things such as the Wordpress version, login page and others.</p>
			',
			'icon'    	 => 'el-icon-wordpress',
			'heading' 	 => '<h1><strong>🖥️ Branding</strong></h1>',
            'priority'   => 2,
			'subsection' => true,
			'fields'     => array(

				// RPECK 11/08/2023 - Divider
				// Gives us the means to separate the different elements
				array(
					'type' => 'divide'
				),

				// RPECK 11/08/2023 - Wordpress Version
				// Removes the Wordpress version information
				array(
					'id'      	=> 'disable_wordpress_branding',
					'type'    	=> 'switch',
					'title'   	=> '💀 Remove Wordpress Branding?',
					'subtitle'	=> 'Remove various traces of Wordpress from the admin area - admin bar logo and several others.',
					'default'	=> true,
					'on'		=> 'Yes',
					'off'		=> 'No',
                    'load_callback' => function($value) {

                        // RPECK 14/08/2023 - If true, change the underlying values
                        // This gives us the ability to manage how the system works
                        if($value == true) {

                            // RPECK 14/08/2023 - Add function
                            // This gives us the ability to call the same functionality with two filters (for admin + normal)
                            function wp_remove_body_class($classes) {

                                // RPECK 14/08/2023 - Split classes into array
                                // This gives us the means to ensure we can append a class as needed
                                if(!is_array($classes)) $classes = explode(' ', $classes);

                                // RPECK 14/08/2023 - Add the 'wp_removed' value
                                // Added as an array element to avoid having to manually change the string
                                array_push($classes, 'wp_removed');
                                
                                // RPECK 14/08/2023 - Return
                                // Returns the classes for the body tag in the admin area
                                // --
                                // Admin requires a string, normal requires array
                                return is_admin() ? implode(' ', $classes) : $classes;

                            }

                            // RPECK 14/08/2023 - Update the CSS to hide the Wordpress logo
                            // Extracted from White Label CMS (to cut down on bloat)
                            add_filter('body_class',        'KadenceChild\wp_remove_body_class');
                            add_filter('admin_body_class',  'KadenceChild\wp_remove_body_class');

                        }
                    }

				),

				// RPECK 11/08/2023 - Wordpress Version
				// Removes the Wordpress version information
				array(
					'id'      	=> 'disable_wordpress_version',
					'type'    	=> 'switch',
					'title'   	=> '🚨 Remove Wordpress Version?',
					'subtitle'	=> 'Removes the Wordpress version from the admin footer - similar functionality to WhiteLabel CMS.',
					'default'	=> true,
					'on'		=> 'Yes',
					'off'		=> 'No',
					'load_callback' => function($value) {

						// RPECK 11/08/2023 - Only proceed if the value is true
						// If true, it means we don't want the Wordpress version information to show
						if($value) add_filter('update_footer', '__return_false', 11);

					}
				),

				// RPECK 11/08/2023 - Divider
				// Gives us the means to separate the different elements
				array(
					'type'  => 'divide',
					'title' => '<h1><strong>🔒 Login Page</strong></h1>',
					'subtitle'	=> '
						--<br/>
						<p><strong>Manage how the login page looks (functionality extracted from White Label CMS).</strong></p>
						<p>The login page may not be a huge part of the Wordpress experience, but it does provide us with the ability to customize an important part of the system.</p>
					'
				),

				// RPECK 02/08/2023 - Login Logo
				// If enabled, the login logo is changed to the site logo
				array(
					'id'      	=> 'login_logo',
					'type'    	=> 'select',
					'title'   	=> '🖼️ Change Login Logo?',
					'subtitle'	=> 'Change the login logo (used to be handled by Whitelabel CMS) to the one set in Kadence (or remove it completely)?',
					'default'	=> true,
                    'options'  => array(
                        'default' => 'Wordpress default',
                        'kadence' => 'Kadence (theme) logo',
                        'remove'  => 'Remove entirely'
                    ),
                    'load_callback' => function($value) {

                        // RPECK 16/08/2023 - Change login logo to the one we've added to the site
                        // The reason for doing this is to give more control over the login page without having to rely on WhiteLabel CMS
                        if(!is_null($value) && $value != 'default' && is_login()) {

                            // RPECK 16/08/2023 - Use the $site_logo defined above to populate the system
                            // This will give us the ability to use the image defined as the site logo in the login page
							// --
							// https://codex.wordpress.org/Customizing_the_Login_Form
							add_action('login_enqueue_scripts', function() use ($value) {

                                // RPECK 16/08/2023 - Check to see which type of logo we wish to show
                                // This was adapted to use the new select dropdown (IE a value will always be present)
                                if($value == 'kadence') {

                                    // RPECK 16/08/2023 - Site Logo
                                    $site_logo = get_theme_mod('custom_logo'); 

                                    // RPECK 16/08/2023 - Output logo
                                    // Used to provide the means to manage how the login logo appears
                                    echo '
                                        <style type="text/css">
                                            #login h1 a, .login h1 a {
                                                background-image: url("' . wp_get_attachment_url($site_logo) . '");
                                                height:65px;
                                                width:320px;
                                                background-size: 320px 65px;
                                                background-repeat: no-repeat;
                                                background-size: contain;
                                                background-position: center center;
                                                padding-bottom: 30px;
                                            }
                                            #loginform  { border-radius: 5px; }
                                            #backtoblog { display: none; }
                                            #nav {
                                            	display: flex;
                                            	justify-content: center; 
                                            	align-items: center; 
                                            	column-gap: 0.5em;
                                            }
                                            .privacy-policy-page-link {
                                                margin-top: 1em !important;
                                                margin-bottom: 1em !important;
                                            }
                                        </style>
                                    ';

                                } elseif($value == 'remove') {

                                    // RPECK 16/08/2023 - Remove logo
                                    // Blocks the logo from showing
                                    echo'
                                        <style type="text/css">
                                            #login h1 { display: none; }
                                        </style>
                                    ';

                                }

							});

                        }

                    }
				),	

				// RPECK 02/08/2023 - Text Colour
				// The colour of the text of the login page
				array(
					'id'          => 'login_text_colour',
					'type'        => 'color',
					'title'       => '🖊️ Text Colour',
					'subtitle'    => 'Set the text colour of the login page',
					'transparent' => false,
					'load_callback' => function($value) {

						// RPECK 02/08/2023 - Check for login
						// Fires the action only if the user is viewing the login page
                        if(is_login() && !is_null($value)) {

                            // RPECK 16/08/2023 - Login Script
                            // Action to import the login script using the following options
                            add_action('login_enqueue_scripts', function() use ($value) {

                                echo '
                                    <style type="text/css">
                                        .login a { color: ' . $value . ' !important; }
                                    </style>
                                ';

                            });

                        }

					}
				),

				// RPECK 02/08/2023 - Background Colour
				// The colour of the background of the login page
				array(
					'id'          => 'login_background',
					'type'        => 'color',
					'title'       => '➡️ Background Colour',
					'subtitle'    => 'Set the background colour for the login page',
					'transparent' => false,
					'load_callback' => function($value) {

						// RPECK 02/08/2023 - Check for login
						// Fires the action only if the user is viewing the login page
                        if(is_login()) {

                            // RPECK 16/08/2023 - Login Script
                            // Action to import the login script using the following options
                            add_action('login_enqueue_scripts', function() use ($value) {

                                echo '
                                    <style type="text/css">
                                        body.login { background-color: ' . $value . '; }
                                    </style>
                                ';

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
