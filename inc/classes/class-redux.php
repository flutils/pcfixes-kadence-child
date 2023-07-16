<?php

//////////////////////////
//////////////////////////

// RPECK 16/07/2023 - Redux Class 
// Used to initialize Redux and provide the means to interface with it (IE make the sections dynamic depending on different settings)

//////////////////////////
//////////////////////////

// RPECK 13/07/2023 - Namespace
// This was taken from the primary Kadence system - no need to change it
namespace KadenceChild;

// RPECK 16/07/2023 - No direct access
// Maintain the security of the system by blocking anyone who tries to access the file directly
defined( 'ABSPATH' ) || exit;

// RPECK 16/07/2023 - Class
// Class through which Redux Framework configured and initialized
class Redux {

    // RPECK 16/07/2023 - Opt Name
    // This is used to define the namespace of the values (defaults to KADENCE_CHILD_TEXT_DOMAIN)
    public $opt_name = KADENCE_CHILD_TEXT_DOMAIN;

    // RPECK 16/07/2023 - Theme
    // Used to populate a number of properties inside the system that are associated to the theme
    // Taken from: https://devs.redux.io/guides/basics/getting-started.html
    public $theme = null;

    // RPECK 16/07/2023 - Args
    // These are used to populate the various arguments for Redux
    public $args = array();

    // RPECK 16/07/2023 - Sections
    // This contains an array of ReduxSection objects, which can be used to populate the admin pages area
    public $sections = array();

    // RPECK 16/07/2023 - Constructor
    // This takes $args and allows us to populate (or change) the args above
    function __construct($args = array()) {

		// RPECK 16/07/2023 - Set Theme
		// This needs to be here because the class must be instantiated before it is able to function
        $this->theme = wp_get_theme();

		// RPECK 16/07/2023 - Set Args
		// Allows us to set the various arguments for Redux against a set of defaults
        $this->args = array_merge(
			array(

				'display_name'     => $this->theme->get('Name'),
				'display_version'  => $this->theme->get('Version'),

				'footer_credit'    => ' ',

				'menu_title'       => esc_html__(KADENCE_CHILD_ADMIN_MENU_LABEL, KADENCE_CHILD_TEXT_DOMAIN),
				'menu_type'        => 'submenu',

				'page_slug'		   => KADENCE_CHILD_TEXT_DOMAIN,
				'page_title'       => esc_html__(KADENCE_CHILD_ADMIN_PAGE_TITLE, KADENCE_CHILD_TEXT_DOMAIN),
				'page_parent'      => 'themes.php',

				'admin_bar'        => false,
				'customizer'       => false,
				'dev_mode'         => WP_DEBUG ?? false,

			),
            $args
		);
        
    }

    // RPECK 16/07/2023 - Initialize
    // Custom function used to invoke the class when required
    public function initialize() {

        // RPECK 16/07/2023 - Set args
        // Set the above arguments as the default for the system
        \Redux::set_args($this->opt_name, $this->args);

    }

	// RPECK 16/07/2023 - Get Args
    // Wraps the Redux::get_args & Redux::get_arg functions
	// https://devs.redux.io/configuration/api.html#redux-get-args
	public function get($arg = null) {

		// RPECK 16/07/2023 - Check if arg is present
		// If $arg is present, use get_arg else use get_args
		if(is_null($arg)) {
			\Redux::get_args(KADENCE_CHILD_TEXT_DOMAIN);
		} else {
			\Redux::get_arg(KADENCE_CHILD_TEXT_DOMAIN, $arg);
		}

	}

}