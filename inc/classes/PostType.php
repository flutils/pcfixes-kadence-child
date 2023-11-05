<?php

//////////////////////////
//////////////////////////

// RPECK 28/07/2023
// Child theme Post Type class - gives us the means to populate CPT's depending on inputted values via Redux
// --
// https://developer.wordpress.org/reference/functions/register_post_type/#parameters

//////////////////////////
//////////////////////////

// RPECK 13/07/2023 - Namespace
// This was taken from the primary Kadence system - no need to change it
namespace KadenceChild;

// RPECK 02/08/2023 - Libraries
// These are used to load up the various files & functions the class will use
use function __;
use function register_post_type;
use function post_type_exists;
use KadenceChild\Helpers;

// RPECK 11/08/2023 - Constants
// Used to provide static data for the system
use const KadenceChild\KADENCE_CHILD_TEXT_DOMAIN;

// RPECK 16/07/2023 - No direct access
// Maintain the security of the system by blocking anyone who tries to access the file directly
defined( 'ABSPATH' ) || exit;

// RPECK 28/07/2023 - Post Type
// This gives us the ability to manage the various post types we are looking to load inside our theme engine
class PostType {

	// RPECK 28/07/2023 - Slug
	// (Required) Key which is used to manage the CPT's reference in the database
	public $slug;

	// RPECK 09/08/2023 - Colour
	// This allows us to define the colour for the CPT (if needed)
	public $colour = '#FFFFFF';

	// RPECK 03/08/2023 - Label
	// (Required) The "Name" of the CPT, used to populate menus etc
	public $name = '';

	// RPECK 03/08/2023 - Description
	// (Optional) Adds the ability to describe the CPT (available on the archive page)
	public $description;

	// RPECK 03/08/2023 - Menu Icon
	// (Required) The icon for the menu icon in the CPT
	public $menu_icon = 'dashicons-admin-post';

	// RPECK 03/08/2023 - Hierarchical
	// (Optional) Whether the CPT supports hierachacle content (IE parent/child relations)
	// --
	// Defaults to false
	public $hierarchical;

	// RPECK 03/08/2023 - Public
	// (Optional) Whether the CPT is publicly available or not
	public $is_public;

	// RPECK 09/08/2023 - Archive
	// Should the post type have an archive? This defaults to false inside Wordpress, but we want true
	public $has_archive;

	// RPECK 03/08/2023 - Exclude From Search
	// (Optional) Whether to exclude the CPT from the search query performed by Wordpress
	// --
	// Default is opposite of $this->public
	public $exclude_from_search;

	// RPECK 03/08/2023 - Publicly Queryable
	// (Optional) Should the CPT be available publicly (IE direct access via querystrings)?
	// --
	// Default is $this->public
	public $publicly_queryable;

	// RPECK 03/08/2023 - Show in UI?
	// (Optional) Whether to show the CPT in the UI of the admin area? 
	// --
	// Default is the same as $this->public
	public $show_ui;

	// RPECK 03/08/2023 - Show in Menu?
	// (Optional) The place to show the CPT in the admin menu. This accepts either a bool or string.
	// --
	// Default is the same as $public
	public $show_in_menu;

	// RPECK 03/08/2023 - Show in nav menus
	// Whether to show the CPT in navigation menus (defaults to true)
	public $show_in_nav_menus;

	// RPECK 03/08/2023 - Show in the admin bar
	// (Optional) Shows the CPT in the "New +" dropdown which allows the admin to determine whether they are 
	// --
	// Defaults to $show_in_menu
	public $show_in_admin_bar;

	// RPECK 03/08/2023 - Show in REST
	// (Optional) Allows the CPT to be present in the REST API
	public $show_in_rest;

	// RPECK 22/08/2023 - Taxonomies
	// Allocates different taxonomies to the CPT, allowing us to differentiate between different objects 
	public $taxonomies;

	// RPECK 05/09/2023 - Supports
	// Ensures the CPT is able to perform certain tasks
	public $supports;

	//////////////////////////////
	//////////////////////////////

	// RPECK 13/07/2023 - Constructor
	// Populates the values required for the CPT (including customization options such as colour)
	function __construct($values = array()) {

		// RPECK 26/07/2023 - Allocate a value to a property in the class
		// This populates the instance of the class with the various properties passed through from the parent class
		foreach($values as $key => $value) {

			// RPECK 26/07/2023 - Allocate value
			// Can only be done if the property exists on the class
			if(property_exists($this, $key) && !empty($value)) $this->$key = $value;

		}

		// RPECK 09/08/2023 - Menu Icon
		// Due to Redux passing through the entire string for the menu icon, we need to fix it here if it is present
		if(!empty($this->menu_icon)) $this->menu_icon = str_replace('dashicons ', '', $this->menu_icon); 

		// RPECK 11/08/2023 - Name
		// If the name is not present, use slug instead
		if(empty($this->name)) $this->name = $this->slug;

	}

	//////////////////////////////
	//////////////////////////////

	/////////////
	// Public

	// RPECK 28/07/2023 - Initialize
	// This wraps the register_post_type function inside Wordpress to provide the means to register the item 
	public function initialize() {

		// RPECK 13/08/2023 - Only proceed if post type is not registered
		// Allows us to cut back on conflicts with the likes of ACF
		if(!post_type_exists($this->slug)) {

			// RPECK 28/07/2023 - Register Post Type
			// This is called to give us the means to manage the post type we want to show
			register_post_type($this->slug,
			
				array(
					'labels' => array(
						'name' => 			__($this->name, KADENCE_CHILD_TEXT_DOMAIN),
						'singular_name' =>	__($this->name, KADENCE_CHILD_TEXT_DOMAIN),
					),

					'public' 			=> boolval($this->is_public),
					'has_archive' 		=> boolval($this->has_archive),
					'show_in_rest' 		=> $this->show_in_rest,
					'description'		=> $this->description,
					'menu_icon'			=> $this->menu_icon,
					'show_in_nav_menus' => $this->show_in_nav_menus,
					'show_in_menu'      => boolval($this->show_in_menu),
					'show_ui'           => boolval($this->show_ui),
					'description'		=> $this->description,
					'supports'			=> $this->supports,
					'rewrite' 			=> array('slug' => $this->slug)

				)

			);

		}

		// RPECK 22/08/2023 - Taxonomies
		// Ensures we can add the various taxonomies to the system
		if(!is_null($this->taxonomies) && is_array($this->taxonomies)) {

			// RPECK 22/08/2023 - Loop through taxonomies
			// This will allow us to allocate multiple as needed
			foreach($this->taxonomies as &$taxonomy) {

				// RPECK 22/08/2023 - Register taxonomy for CPT
				// Ensures the taxonomy can be allocated properly
				// --
				// https://wpshout.com/add-existing-taxonomies-wordpress-custom-post-types/
				register_taxonomy_for_object_type($taxonomy, $this->slug);

			}


		}

	}

	// RPECK 11/08/2023 - Admin payload
	// Used to populate the admin menus -- I wanted to add these as individual items but I think that would just add too much bloat
	public function admin_styling() {

        // RPECK 13/08/2023 - Check to see if the various values are present
        // This was introduced to ensure we don't get errors if no CPT's are defined
        if(!empty($this->colour)) {

            // RPECK 13/08/2023 - Return the admin styling for the CPT
            // We've done it this was to get rid of the need to add many different hooks
            return '
                #adminmenu li.menu-top#menu-posts-' . $this->slug . ' {
                    --background-color: ' . $this->colour . ';
                    --menu-color: ' . (Helpers::isBright($this->colour) ? "#000" : "#fff") . ';
                }
            ';

        }

	}
	
	// RPECK 04/11/2023 - Menu Styles
	// This was added as a static function to give us a central way to manage the admin styles (basically because the previous way we set it up was not fully compatible with how Wordpress worsk)
	public static function admin_menu_styling($post_types = array()) {
	    
	    // RPECK 04/11/2023 - Only proceed if the $post_types variable is populated
	    // This expects an array of post type slugs, which will allow us to populate the CSS properly
	    if($post_types && is_array($post_types) && sizeof($post_types) > 0) {
	        
            // RPECK 04/11/2023 - Output the standard items here
            // This allows us to identify the post types whilst ensuring the styles are respected
            return '
                /*
                  RPECK 28/07/2023 - Admin menu colours
                  This was added to give us a standard way to manage the colours of CPT\'s in the admin menu
                  --
                  RPECK 13/08/2023 - Added the color-mix items as a means to dynamically change the colours without any further computation at the logic level
                  color-mix source: https://stackoverflow.com/a/71098929/1143732
                */
                #adminmenu li.menu-top:is(#menu-posts-' . implode(',#menu-posts-', $post_types) . ') > a > .wp-menu-name,
                #adminmenu li.menu-top:is(#menu-posts-' . implode(',#menu-posts-', $post_types) . ') > .wp-submenu,
                #adminmenu li.menu-top:is(#menu-posts-' . implode(',#menu-posts-', $post_types) . ') > .wp-menu-arrow,
                #adminmenu li.menu-top:is(#menu-posts-' . implode(',#menu-posts-', $post_types) . '):is(:hover, :active, :focus) > a {
                	background-color: var(--background-color, inherit);
                	color: var(--menu-color, #fff);
                }
                #adminmenu li.menu-top:is(#menu-posts-' . implode(',#menu-posts-', $post_types) . ') a:is(:hover, :active, :focus),
                #adminmenu li.menu-top:is(#menu-posts-' . implode(',#menu-posts-', $post_types) . ').wp-has-current-submenu div.wp-menu-image:before,
                #adminmenu li.menu-top:is(#menu-posts-' . implode(',#menu-posts-', $post_types) . '):is(:hover, :active, :focus) div.wp-menu-image:before {
                	color: var(--menu-color, #fff) !important;
                }
                #adminmenu li:is(#menu-posts-' . implode(',#menu-posts-', $post_types) . ') a:focus div.wp-menu-image:before,
                #adminmenu li:is(#menu-posts-' . implode(',#menu-posts-', $post_types) . ').opensub div.wp-menu-image:before,
                #adminmenu li:is(#menu-posts-' . implode(',#menu-posts-', $post_types) . '):hover div.wp-menu-image:before {
                    color: unset;
                }
                #adminmenu li.menu-top:is(#menu-posts-' . implode(',#menu-posts-', $post_types) . '):not(:hover, :active, :focus) div.wp-menu-image:before {
                	color: color-mix(in srgb, var(--menu-color, inherit) 50%, transparent); 
                }
                #adminmenu li.menu-top:is(#menu-posts-' . implode(',#menu-posts-', $post_types) . ') > .wp-submenu a:not(:hover, :active, :focus) {
                    color: color-mix(in srgb, var(--menu-color, inherit) 65%, transparent); 
                }
                #adminmenu li:is(#menu-posts-' . implode(',#menu-posts-', $post_types) . ').wp-has-submenu.wp-not-current-submenu.opensub:hover:after,
                #adminmenu li:is(#menu-posts-' . implode(',#menu-posts-', $post_types) . ').wp-has-submenu.wp-not-current-submenu:focus-within:after {
                	border-right-color: color-mix(in srgb, var(--background-color, inherit) 85%, black) !important;
                } 
                #adminmenu li.menu-top:is(#menu-posts-' . implode(',#menu-posts-', $post_types) . ') > .wp-submenu {
                    background-color: color-mix(in srgb, var(--background-color, inherit) 85%, black); 
                }
            ';
	        
	    }

	}
    
}