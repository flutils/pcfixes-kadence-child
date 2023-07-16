<?php

//////////////////////////
//////////////////////////

// RPECK 16/07/2023 - Redux Class 
// Used to initialize Redux and provide the means to interface with it (IE make the sections dynamic depending on different settings)

//////////////////////////
//////////////////////////

// RPECK 13/07/2023 - Namespace
// This was taken from the primary Kadence system - no need to change it
namespace Kadence;

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

    // RPECK 16/07/2023 - Constructor
    // This takes $args and allows us to populate (or change) the args above
    function __construct($args = array()) {

		// RPECK 16/07/2023 - Set Theme
		// This needs to be here because the class must be instantiated before it is able to function
        $this->theme = wp_get_theme();

		// RPECK 16/07/2023 - Set Args
		// Allows us to set the various arguments for Redux against a set of defaults
        $this->args = array_merge(
			$args,
			array(

				'display_name'     => $this->theme->get('Name'),
				'display_version'  => $this->theme->get('Version'),

				'menu_title'       => esc_html__(KADENCE_CHILD_ADMIN_MENU_LABEL, KADENCE_CHILD_TEXT_DOMAIN),
				'menu_type'        => 'submenu',

				'page_slug'		   => KADENCE_CHILD_TEXT_DOMAIN,
				'page_title'       => esc_html__(KADENCE_CHILD_ADMIN_PAGE_TITLE, KADENCE_CHILD_TEXT_DOMAIN),
				'page_parent'      => 'themes.php',

				'admin_bar'        => false,
				'customizer'       => false,
				'dev_mode'         => WP_DEBUG ?? false

			)
		);
        
    }

    // RPECK 16/07/2023 - Initialize
    // Custom function used to invoke the class when required
    public function initialize() {

        // RPECK 16/07/2023 - Set args
        // Set the above arguments as the default for the system
        \Redux::set_args($this->opt_name, $this->args);

    }

	// RPECK 16/07/2023 - Set Section
	// Allows us to set a new section
	public function set_section(){

		\Redux::set_section( $this->opt_name, array(
        'title'  => esc_html__( 'Basic Field', 'your-textdomain-here' ),
        'id'     => 'basic',
        'desc'   => esc_html__( 'Basic field with no subsections.', 'your-textdomain-here' ),
        'icon'   => 'el el-home',
        'fields' => array(
            array(
                'id'       => 'opt-text',
                'type'     => 'text',
                'title'    => esc_html__( 'Example Text', 'your-textdomain-here' ),
                'desc'     => esc_html__( 'Example description.', 'your-textdomain-here' ),
                'subtitle' => esc_html__( 'Example subtitle.', 'your-textdomain-here' ),
                'hint'     => array(
                    'content' => 'This is a <b>hint</b> tool-tip for the text field.<br/><br/>Add any HTML based text you like here.',
                )
            )
        )
    ) );

	}

}