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
require get_stylesheet_directory() . '/inc/classes/child-theme.php';

// Init
// This allows us to get the 
function child_init() {

	// This loads the various classes required to run the theme
	// The reason why we're using classes is because we want to instantize everything to make things work as systemically as possible
	$child_theme = new ChildTheme;

    // Initialize child theme
    $child_theme->initialize();

}