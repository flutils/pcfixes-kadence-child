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
	public $colour;

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
	public $has_archive = true;

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
	public $show_in_ui;

	// RPECK 03/08/2023 - Show in Menu?
	// (Optional) The place to show the CPT in the admin menu. This accepts either a bool or string.
	// --
	// Default is the same as $public
	public $show_in_menu;

	// RPECK 03/08/2023 - Show in nav menus
	// (Optional) Whether to show the CPT in navigation menus
	public $show_in_nav_menus;

	// RPECK 03/08/2023 - Show in the admin bar
	// (Optional) Shows the CPT in the "New +" dropdown which allows the admin to determine whether they are 
	// --
	// Defaults to $show_in_menu
	public $show_in_admin_bar;

	// RPECK 03/08/2023 - Show in REST
	// (Optional) Allows the CPT to be present in the REST API
	public $show_in_rest;

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

		// RPECK 09/08/2023 - Submenu Colours
		// This gives us the means to manage the submenu colours 
		if(!empty($this->colour)) $this->submenu_colour = Helpers::adjustBrightness($this->colour, -0.15);

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

		// RPECK 28/07/2023 - Register Post Type
		// This is called to give us the means to manage the post type we want to show
		register_post_type($this->slug,
		
			array(
				'labels' => array(
					'name' => 			__($this->name, KADENCE_CHILD_TEXT_DOMAIN),
					'singular_name' =>	__($this->name, KADENCE_CHILD_TEXT_DOMAIN),
				),

				'public' 		=> true,//$this->is_public,
				'has_archive' 	=> $this->has_archive,
				'show_in_rest' 	=> $this->show_in_rest,
				'description'	=> $this->description,
				'menu_icon'		=> $this->menu_icon,

				'rewrite' => array('slug' => 'results ')

			)

		);

	}
    
}