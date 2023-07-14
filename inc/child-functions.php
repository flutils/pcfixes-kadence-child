<?php

//////////////////////////
//////////////////////////

// RPECK 02/07/2023
// Child theme functions - entrypoint into the various aspects of the theme

//////////////////////////
//////////////////////////

// Namespace
namespace Kadence;

// No access to this directly
defined( 'ABSPATH' ) || exit;

// Includes 
// Required files to allow us to run the various classes
require get_stylesheet_directory() . '/inc/classes/class-child-theme.php';
require get_stylesheet_directory() . '/inc/classes/class-child-post-types.php';
require get_stylesheet_directory() . '/inc/classes/class-child-plugins.php';
require get_stylesheet_directory() . '/inc/classes/class-tgm-plugin-activation.php';

// Init
// This allows us to get the child theme initialized (IE populated with content etc)
function child_init() {

	// This loads the various classes required to run the theme
	// The reason why we're using classes is because we want to instantize everything to make things work as systemically as possible
	$child_theme = new ChildTheme;

    // Initialize child theme
    $child_theme->initialize();

}

// RPECK 13/07/2023
// Remove Kadence notice(s)
// This was added to ensure were not getting any unwanted messages from Kadence
function child_remove_kadence_notices(){

    // Remove 'Starter Templates' notice
    // https://www.kadencewp.com/support-forums/topic/how-to-remove-cart-summary-title/
    if (class_exists('Kadence\Theme')) {
        $kadence_theme_class = \Kadence\Theme::instance();
        remove_action('admin_notices', array( $kadence_theme_class->components['base_support'], 'kadence_starter_templates_notice' ));
    }
    
}