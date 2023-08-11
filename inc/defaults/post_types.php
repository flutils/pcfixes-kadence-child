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
use Redux_Helpers;

// RPECK 16/07/2023 - No direct access
// Maintain the security of the system by blocking anyone who tries to access the file directly
defined( 'ABSPATH' ) || exit;

// RPECK 04/08/2023 - Class definition
// Gives us the means to manage the various parts of the admin area by extending the base Section class
class PostTypes extends Section {

	// RPECK 05/08/2023 - Default Values
	// This loads the various values for this class (and parent)
	function __construct($opt_name) {

		// RPECK 05/08/2023 - Vars
		// The various items required to populate the parent class
		$args = array(

			'id'      => 'post_types',
			'title'   => 'CPT\'s',
			'icon'    => 'el-icon-bullhorn',
			'heading' => 'Post Types',
			'desc'    => '
				<strong>CPT\'s created by the theme. This is handled via a repeater block with a strict structure for the fields.</strong>
				<p>These are registered in Wordpress with the <a href="https://developer.wordpress.org/reference/functions/register_post_type/#parameters" target="_blank">register_post_type()</a> function.</p>
			',
			'fields'  => array(

				// RPECK 27/07/2023 - Post Types repeater
				// This allows us to define different post types and have them populated by our theme/plugin
				array(
					'id'             => 'post_types',
					'type'           => 'repeater',
					'title'          => '💻 Definitions',
					'subtitle'       => '
						<p>Define post types (CPT\'s) within the system</p>
						<p>--</p>
						<p>This should not conflict with ACF and allows us to determine exactly which CPT\'s we wish to carry over with the theme.</p>
					',
					'group_values' => true, 
					'item_name'    => 'Post Type',
					'sortable'     => true, 
					'fields' => array(

						// RPECK 28/07/2023 - Label
						// Name of the CPT to give us the ability to identify the type of post
						array(
							'id'          => 'name',
							'type'        => 'text',
							'placeholder' => 'CPT Name',
							'title'       => 'Name',
							'subtitle'    => 'Name of the post type shown in the menu. Usually plural.'
						),

						// RPECK 28/07/2023 - Post type slug
						// This is used to populate the post type on a fundamental level
						array(
							'id'          => 'slug',
							'type'        => 'text',
							'placeholder' => 'post-slug (downcase and underscore or hyphens only)',
							'title'       => 'Slug',
							'subtitle'    => 'The key value of the CPT (this should not be changed once set)'
						),

						// RPECK 03/08/2023 - Description
						// What to show on the likes of the CPT archive page etc
						array(
							'id'          => 'Description',
							'type'        => 'textarea',
							'placeholder' => 'Type the description here (optional)',
							'title'       => 'Description',
							'subtitle'    => 'A short descriptive summary of what the post type is.'
						),

						// RPECK 28/07/2023 - Admin Menu Icon
						// Uses the icons selector from Redux to give us the ability to change the menu icon for the CPT
						// --
						// https://devs.redux.io/core-extensions/icon-select.html#example-usage
						array(
							'id'       	=> 'menu_icon',
							'type'     	=> 'icon_select',
							'title'    	=> 'Icon',
							'subtitle' 	=> 'Admin menu icon'
						),

						// RPECK 28/07/2023 - Admin Menu Colour
						// This is determined with a single input and we can then use various methods in the class to tweak it
						// --
						// https://devs.redux.io/core-fields/color-palette.html
						array(
							'id'       => 'colour',
							'type'     => 'color_palette',
							'title'    => 'Colour',
							'subtitle' => 'Used in the admin menu to differentiate between different CPT\'s',
							'options'  => array(
								'colors' => Redux_Helpers::get_material_design_colors('primary'),
								'style'  => 'round',
								'size'   => 48
							)
						),

						// RPECK 03/08/2023 - Public
						// Whether the CPT is considered 'public'?
						array(
							'id'      	=> 'public',
							'type'    	=> 'switch',
							'title'   	=> 'Public?',
							'subtitle'	=> 'Should the CPT be publicly visible?',
							'default'	=> true,
							'on'		=> 'Yes',
							'off'		=> 'No'
						),	

						// RPECK 03/08/2023 - Hierarchy
						// Does the CPT accept parent/child arguments?
						array(
							'id'      	=> 'hierarchical',
							'type'    	=> 'switch',
							'title'   	=> 'Hierarchical?',
							'subtitle'	=> 'Whether the post type is hierarchical (e.g. page).',
							'default'	=> true,
							'on'		=> 'Yes',
							'off'		=> 'No'
						),

						// RPECK 09/08/2023 - Archive
						// Should the post have an archive in the front end?
						array(
							'id'      	=> 'hierarchical',
							'type'    	=> 'switch',
							'title'   	=> 'Hierarchical?',
							'subtitle'	=> 'Whether the post type is hierarchical (e.g. page).',
							'default'	=> true,
							'on'		=> 'Yes',
							'off'		=> 'No'
						),

						// RPECK 03/08/2023 - Exclude From Search?
						// Should the CPT be excluded from the search system of Wordpress?
						array(
							'id'      	=> 'exclude_from_search',
							'type'    	=> 'switch',
							'title'   	=> 'Exclude From Search?',
							'subtitle'	=> 'Whether to exclude posts with this post type from front end search results.',
							'default'	=> false,
							'on'		=> 'Yes',
							'off'		=> 'No'
						),

						// RPECK 03/08/2023 - Publicly Queryable?
						// Is the CPT accessible via a querystring in Wordpress?
						array(
							'id'      	=> 'publicly_queryable',
							'type'    	=> 'switch',
							'title'   	=> 'Publicly Queryable?',
							'subtitle'	=> 'Whether queries can be performed on the front end for the post type as part of parse_request(). <Br /> Endpoints would include: * ?post_type={post_type_key} * ?{post_type_key}={single_post_slug} * ?{post_type_query_var}={single_post_slug} If not set, the default is inherited from $public.
',
							'default'	=> false,
							'on'		=> 'Yes',
							'off'		=> 'No'
						),

						// RPECK 03/08/2023 - Show UI?
						// Show the CPT in the context of the admin UI?
						array(
							'id'      	=> 'show_ui',
							'type'    	=> 'switch',
							'title'   	=> 'Show UI?',
							'subtitle'	=> 'Whether to generate and allow a UI for managing this post type in the admin.',
							'default'	=> true,
							'on'		=> 'Yes',
							'off'		=> 'No'
						),

						// RPECK 03/08/2023 - Show In Menu?
						// Show the CPT in the context of the admin UI?
						array(
							'id'      	=> 'show_in_menu',
							'type'    	=> 'switch',
							'title'   	=> 'Show In Admin Menu?',
							'subtitle'	=> 'Where to show the post type in the admin menu. To work, $show_ui must be true. If true, the post type is shown in its own top level menu. If false, no menu is shown. If a string of an existing top level menu (\'tools.php\' or \'edit.php?post_type=page\', for example), the post type will be placed as a sub-menu of that.',
							'default'	=> true,
							'on'		=> 'Yes',
							'off'		=> 'No'
						),

						// RPECK 03/08/2023 - Show In Nav Menus
						// Show the CPT in the context of the admin UI?
						array(
							'id'      	=> 'show_in_nav_menus',
							'type'    	=> 'switch',
							'title'   	=> 'Show In Nav Menus?',
							'subtitle'	=> 'Makes this post type available for selection in navigation menus.',
							'default'	=> true,
							'on'		=> 'Yes',
							'off'		=> 'No'
						),

						// RPECK 03/08/2023 - Show In Admin Bar
						// Whether the CPT will show in the admin bar
						array(
							'id'      	=> 'show_in_admin_bar',
							'type'    	=> 'switch',
							'title'   	=> 'Show In Admin Bar?',
							'subtitle'	=> 'Makes this post type available via the admin bar.',
							'default'	=> true,
							'on'		=> 'Yes',
							'off'		=> 'No'
						),				

						// RPECK 03/08/2023 - Show in REST
						// Whether the CPT will show in the admin bar
						array(
							'id'      	=> 'show_in_rest',
							'type'    	=> 'switch',
							'title'   	=> 'Show In REST?',
							'subtitle'	=> 'Whether to include the post type in the REST API. Set this to true for the post type to be available in the block editor.',
							'default'	=> true,
							'on'		=> 'Yes',
							'off'		=> 'No'
						)	

					),
                    'load_callback' => function($value) {
                        
                        // RPECK 08/08/2023 - Loop through the Post Types repeater and get the values that are present therein
                        // The $value variable is going to be populated with an array of data which needs to be validated
                        if( is_array($value) && array_key_exists('redux_repeater_data', $value) ) {

							// RPECK 09/08/2023 - Pass data to the CPT filter
							// Likely needs to change but should give us the ability to manage exactly how it works	
							add_filter('KadenceChild\post_types', function($post_types) use ($value) {

								// RPECK 08/08/2023 - Vars
								// This allows us to ensure we can store the values required inside the system properly
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

										}

									}

								}

								// RPECK 09/08/2023 - Merge 
								// Combines the values we've just added to provide the means to pass the data to TGMPA
								if(!empty($val)) $post_types = array_merge($val, $post_types);

								// RPECK 09/08/2023 - Return the new $plugins variable to TGMPA
								// This is needed to ensure we are populating the plugins correctly
								return $post_types;

							});

                        }

                    },
				)
			)
			
		);

		// RPECK 05/08/2023 - Instantiate the parent class
		// This brings in the different items which
		parent::__construct($opt_name, $args);

	}

}