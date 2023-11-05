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
use KadenceChild\PostType;
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
			'heading' => '<h1><strong>🖊️ CPT\'s</strong></h1>',
			'desc'    => '
				--<br />
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
							'id'          => 'description',
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
							'default'  => '#FFFFFF',
							'options'  => array(
								'colors' => Redux_Helpers::get_material_design_colors('primary'),
								'style'  => 'round',
								'size'   => 48
							)
						),

						// RPECK 22/08/2023 - Taxonomies
						// Used to populate the various taxonomies that the CPT can be associated with
						// --
						// https://wpshout.com/add-existing-taxonomies-wordpress-custom-post-types/
						array(
							'id'    	=> 'taxonomies',
							'type'  	=> 'button_set',
							'title' 	=> 'Taxonomies', 
							'subtitle' 	=> 'Allocate different taxonomical structures to the CPT',
							'data'  	=> 'taxonomies',
							'multi' 	=> true,
							'args'  	=> array(
								'hide_empty' => false
							)
						),

						// RPECK 03/08/2023 - Public
						// Whether the CPT is considered 'public'?
						array(
							'id'      	=> 'is_public',
							'type'    	=> 'switch',
							'title'   	=> 'Public?',
							'subtitle'	=> 'Should the CPT be publicly visible?',
							'default'	=> false,
							'on'		=> 'Yes',
							'off'		=> 'No'
						),	

						// RPECK 09/08/2023 - Archive
						// Should the post have an archive in the front end?
						array(
							'id'      	=> 'has_archive',
							'type'    	=> 'switch',
							'title'   	=> 'Has Archive?',
							'subtitle'	=> 'Should the CPT have an archive page?',
							'default'	=> false,
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
							'default'	=> false,
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
						),

						// RPECK 05/09/2023 - Supports
						// Various functionality the CPT is able to support
						array(
							'id'      	=> 'supports',
							'type'    	=> 'button_set',
							'title'   	=> 'Supports',
							'subtitle'	=> 'Which options the CPT supports',
							'multi'		=> true,
							'default'	=> array('title', 'editor', 'comments', 'revisions', 'trackbacks', 'author', 'excerpt', 'page-attributes', 'thumbnail', 'custom-fields', 'post-formats'),
							'options'	=> array(
								'title' 			=> 'Title',
								'editor'			=> 'Editor',
								'comments'			=> 'Comments',
								'revisions'			=> 'Revisions',
								'trackbacks' 		=> 'Trackbacks',
								'author'			=> 'Author',
								'excerpt'			=> 'Excerpt',
								'page-attributes' 	=> 'Page Attributes',
								'thumbnail'	  		=> 'Featured Image',
								'custom-fields'	  	=> 'Custom Fields',
								'post-formats'    	=> 'Post Formats'
							)
						)	

					),
					'save_callback' => function($value) {

						// RPECK 20/08/2023 - Refresh Permalinks
						// This is required if you change the registered CPT's or Taxonomies
						// --
						// https://wordpress.stackexchange.com/questions/36306/how-do-i-programmatically-force-custom-permalinks-with-my-theme
						global $wp_rewrite; 

						//Flush the rules and tell it to write htaccess
						$wp_rewrite->flush_rules( true );

					},
                    'load_callback' => function($value) {
                        
                        // RPECK 08/08/2023 - Loop through the Post Types repeater and get the values that are present therein
                        // The $value variable is going to be populated with an array of data which needs to be validated
                        if(is_array($value) && array_key_exists('redux_repeater_data', $value)) {

							// RPECK 25/08/2023 - Set $val 
							// Will be populated with the different values from the $value variable
							$val = Helpers::repeaterData($value);

							// RPECK 09/08/2023 - Take the above array and turn it into an array of PostType classes, which can then be initialized (IE registered)
							// This will set up the various CPT's for use inside our engine
							if(is_array($val) && count($val) > 0) {

								// RPECK 09/08/2023 - Vars
								// Various values used within the system
								$colours = array();

								// RPECK 09/08/2023 - Post Types
								// Goes through the predefined posts and allows us to register them as needed
								array_walk($val, function(&$post_type) use (&$colours, &$slugs) {

									// RPECK 09/08/2023 - Check to see if the post type is an array or instance of PostType
									// If it is an instance, don't do anything
									if(!($post_type instanceof \KadenceChild\PostType)) $post_type = new PostType($post_type);

									// RPECK 09/08/2023 - Initialize 
									// Every post type needs to be initialized if the type has not been registered previously
									if(property_exists($post_type, 'slug') && !post_type_exists($post_type->slug)) {
										
										// RPECK 25/08/2023 - Initialize
										// This calls the init function on the PostType class, allowing us to register the post
										$post_type->initialize();

										// RPECK 25/08/2023 - Colours
										// Gives us the ability to populate the colours array with payload data, which can then be outputted as CSS
										$colours[ $post_type->slug ] = $post_type->admin_styling();

									}

								});

								// RPECK 09/08/2023 - Menu Colours
								// This gives us the ability to change the different colours for the admin menu items assigned to a CPT
								if(!is_customize_preview() && is_admin()) {
									
									// RPECK 16/08/2023 - Enqueue the scripts as required to populate the CSS
									// This is the cleanest way to do it
									add_action('admin_enqueue_scripts', function() use ($colours) {

										// RPECK 16/08/2023 - Create inline styles
										// This was added so we would not get any header notifications in the customizer
										// --
										// https://wordpress.stackexchange.com/a/282868
										wp_register_style('admin_menu_values', false);
										wp_enqueue_style('admin_menu_values');

										// RPECK 11/08/2023 - Return
										// Allows us to return the menu object
										wp_add_inline_style('admin_menu_values', implode('', array_values($colours)));
										
										// RPECK 04/11/2023 - Add custom styling only for the CPT's
										// This was added because our old method was not able to identify the CPT's we have added vs other CPT's (possibly added by plugins)
										wp_add_inline_style('admin_menu_values', PostType::admin_menu_styling( array_keys($colours) ));

									});

								}

							}	

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