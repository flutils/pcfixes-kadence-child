<?php

//////////////////////////
//////////////////////////

// RPECK 02/07/2023
// Child theme functions - entrypoint into the various aspects of the child theme

//////////////////////////
//////////////////////////

// Namespace
namespace Kadence;

// No access to this directly
defined( 'ABSPATH' ) || exit;

// RPECK 13/07/2023 - Includes 
// Required files to allow us to run the various classes
require_once get_stylesheet_directory() . '/inc/classes/class-child-theme.php';
require_once get_stylesheet_directory() . '/inc/classes/class-child-post-type.php';
require_once get_stylesheet_directory() . '/inc/classes/class-child-plugin.php';
require_once get_stylesheet_directory() . '/inc/classes/class-tgmpa.php';

// RPECK 15/07/2023 - Redux Framework
// Integrates the core 'redux-core' class from Redux, allowing us to add, manage, import & export options
// https://devs.redux.io/guides/advanced/embedding-redux.html
// --
// We are using Redux to give us a means to manage options without having to write a ton of code to handle it
// Crucially, it is fully supported by OCDI, allowing us to import customization options as needed without difficulty
// The Redux-Core file is added to the output build when a new release is created in Github
if(!class_exists('ReduxFramework') && file_exists(dirname(__FILE__)  . '../vendor/redux-core/framework.php')) require_once(dirname(__FILE__)  . '../vendor/redux-core/framework.php');

// RPECK 13/07/2023 - Init
// This allows us to get the child theme initialized (IE populated with content etc)
function child_init() {

	// This loads the various classes required to run the theme
	// The reason why we're using classes is because we want to instantize everything to make things work as systemically as possible
	$child_theme = new ChildTheme;

    // Initialize child theme
    $child_theme->initialize();

}

// RPECK 13/07/2023 - Remove Kadence notice(s)
// This was added to ensure were not getting any unwanted messages from Kadence
function child_remove_kadence_notices(){

    // Remove 'Starter Templates' notice
    // https://www.kadencewp.com/support-forums/topic/how-to-remove-cart-summary-title/
    if (class_exists('Kadence\Theme')) {
        $kadence_theme_class = \Kadence\Theme::instance();
        remove_action('admin_notices', array( $kadence_theme_class->components['base_support'], 'kadence_starter_templates_notice' ));
    }
    
}