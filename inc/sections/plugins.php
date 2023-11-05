<?php

//////////////////////////
//////////////////////////

// RPECK 05/08/2023 - Default Redux Section Classes
// Extracted from the 'constants' file to give us a structured way to manage the defaults

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
class Plugins extends Section {

	// RPECK 05/08/2023 - Default Values
	// This loads the various values for this class (and parent)
	function __construct($opt_name) {

		// RPECK 05/08/2023 - Vars
		// The various items required to populate the parent class
		$args = array(

			'id'      	  => 'plugins',
			'title'   	  => 'Plugins',
			'icon'    	  => 'el-icon-plus-sign',
			'heading' 	  => '<h1>🔌 Plugins</h1>',
			'permissions' => 'install_plugins',
			'desc'    	  => '
				--<br/>
				<strong>Plugins defined by the theme. Used to populate TGMPA.</strong>
				<p>Each plugin is defined inside TGMPA to ensure they are installed. No bearing on functionality beyond that.</p>
			',
			'fields'  => array(

				// RPECK 28/07/2023 - Plugins Repeater
				// Repeater used to give us the means to populate the system with different plugins that are required etc
				// -- 
				// The point of this is to give us the means to identify the plugins that a child theme will use, allowing them to be used
				// https://tgmpluginactivation.com/configuration#h-plugin-parameters
				array(
					'id'             => 'plugins',
					'type'           => 'repeater',
					'title'          => '⚙️ Definitions',
					'subtitle'       => '
						<p>Choose which plugins should be available in the theme.</p>
						<p>--</p>
						<p>Works by storing the plugin definitions in the Wordpress database and then passing them to the TGMPA class that is bundled with this child theme.</p>
						<p>It means we have a robust backend through which to manage the various plugins each instance of our theme will handle.</p>
					',
					'group_values' => true, 
					'item_name'    => 'Plugin',
					'sortable'     => true, 
					'fields'       => array(

						// RPECK 27/07/2023 - Name
						// Name displayed inside TGMPA
						array(
							'id'          => 'name',
							'type'        => 'text',
							'placeholder' => 'Plugin Name',
							'title' 	  => 'Plugin Name (Required)',
							'desc'		  => '(For reference inside TGMPA - does not affect the actual plugin)',
							'validate' 	  => 'not_empty'
						),

						// RPECK 27/07/2023 - Slug
						// Slug used by TGMPA (typically the name of the folder that holds the plugin)
						array(
							'id'          	=> 'slug',
							'type'        	=> 'text',
							'placeholder' 	=> 'EG advanced-custom-fields',
							'title' 	    => 'Slug (Required)',
							'desc'		    => 'This is mainly for interacting with the Wordpress plugin repository and also download',
							'validate' 	  	=> 'not_empty'
						),

						// RPECK 01/08/2023 - Version
						// Minimum version for the plugin
						array(
							'id'          	=> 'version',
							'type'        	=> 'text',
							'placeholder' 	=> '1.0.0',
							'title' 	    => 'Version (Optional)',
							'desc'		    => 'Adds version specifity if you want to define a minimum version.'
						),

						// RPECK 27/07/2023 - Notes
						// Means to keep notes for a particular plugin (just a reference for end users)
						array(
							'id'          => 'notes',
							'type'        => 'textarea',
							'placeholder' => 'Any notes you may wish to enter here',
							'title' 	  => 'Notes (Optional)',
							'desc'		  => 'Purely for referential purposes - zero bearing on functionality.'
						),

						// RPECK 27/07/2023 - Required
						// Whether the plugin is required by the theme. Has limited funtional value apart from labelling plugin as such in TGMPA
						array(
							'id'      	=> 'required',
							'type'    	=> 'switch',
							'title'   	=> 'Required?',
							'desc'		=> 'Whether the plugin is needed for the theme to run?',
							'default'	=> true,
							'on'		=> 'Yes',
							'off'		=> 'No'
						),

						// RPECK 27/07/2023 - Force Activation
						// Determines if the plugin should be forcibly activated whilst installed
						array(
							'id'      	=> 'force_activation',
							'type'    	=> 'switch',
							'title' 	=> 'Force Activation?',
							'desc'		=> 'Removes the activation option on the plugin, meaning that it stays activated no matter what.',
							'default'	=> false,
							'on'		=> 'Yes',
							'off'		=> 'No'
						),

						// RPECK 27/07/2023 - Force Deactivation
						// Determines if the plugin should be forcibly activated whilst installed
						array(
							'id'     	  => 'force_deactivation',
							'type'    	  => 'switch',
							'title' 	  => 'Deactivate on Theme Change?',
							'desc'		  => 'If the theme is switched, this forces deactivation of the plugin.',
							'default'	  => false,
							'on'		  => 'Yes',
							'off'		  => 'No'
						),

						// RPECK 01/08/2023 - Uploaded file
						// This is a hack to give us the means to upload a file 
						array(
							'id'             	=> 'source',
							'type'           	=> 'media',
							'placeholder'    	=> 'EG advanced-custom-fields-pro.zip',
							'title' 	       	=> 'ZIP File (Optional)',
							'desc'		       	=> 'Populates the ./lib/plugin folder of the child theme with a local payload',
              				'library_filter' 	=> array( 'zip' )
						),

						// RPECK 03/08/2023 - External URL
						// The URL of the website for the plugin (if it's external)
						array(
							'id'             	=> 'external_url',
							'type'           	=> 'text',
							'placeholder'    	=> 'https://www.domain.com/path/to/plugin',
							'title' 	       	=> 'External URL (Optional)',
							'desc'		       	=> 'The URL for information about the plugin IF not using the Wordpress repository',
							'required' 			=> array( 'source', 'not', null )
						)

					), 
					'load_callback' => function($value) {

						// RPECK 31/07/2023 - Array
						// This allows us to loop through the plugins and populate TGMPA with them
						if(is_array($value) && count($value) > 0 && array_key_exists('redux_repeater_data', $value) && count($value['redux_repeater_data']) > 0) {

							// RPECK 31/07/2023 - Allocate the various aspects to TGMPA
							// Because we can simply pass an array, we just need to do this via the data stored in Redux
							// --
							// Should extract this to external class
							add_filter('KadenceChild\tgmpa_plugins', function($plugins) use ($value) {

								// RPECK 31/07/2023 - Vars
								// These are values defined within the scope of this function
								$val = array();

								// RPECK 31/07/2023 - Loop through values presented to the function
								// The structure of Redux repeater fields seems to be a block of data called 'repeater_field_data' and then associative arrays off the back of it
								foreach($value as $key => $v) {

									// RPECK 31/07/2023 - Loop through the recursive array elements
									// This is needed to ensure we are able to catch all of the provided plugins (IE 0, 1, 2 etc)
									foreach($v as $index => $item) {

										// RPECK 31/07/2023 - If the value is not an array, add it to our $val variable defined above
										// This builds the various values we require to ensure TGMPA has the appropriate values
										if(!is_array($item)) {
											
											// RPECK 01/08/2023 - Add the item if it is not an array
											// This is required to ensure we have the correct set up for the various settings to be passed to the TGMPA plugin
											$val[ $index ][ $key ] = $item;

										} elseif( array_key_exists('url', $item) ) {

											// RPECK 01/08/2023 - Add URL if attachment
											// Attachments have an array with a URL that needs to be captured
											$val[ $index ][ $key ] = $item['url'];

										}

									}

								}
								
								// RPECK 31/07/2023 - Merge 
								// Combines the values we've just added to provide the means to pass the data to TGMPA
								if(!empty($val)) $plugins = array_merge($val, $plugins);

								// RPECK 31/07/2023 - Return the new $plugins variable to TGMPA
								// This is needed to ensure we are populating the plugins correctly
								return $plugins;

							}, 0);

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