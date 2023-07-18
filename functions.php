<?php

/////////////////////////////
/////////////////////////////

// RPECK 02/07/2023 - Thematic Framework
// Extension to the "Kadence" theme which overrides render hooks and gives us the means to manage templates via the allocation of "sections"

/* -- NOTES -- */

// RPECK 16/07/2023 - Folder Name
// The original folder name was meant to be "kadence-child-theme"
// Unfortunately, this caused a conflict with how redux framework was identifying if a file was present in a theme 
// --
// The problem was that file class-redux-functions-ex.php line 393 was testing whether the directory structure of a file was present in a theme
// If the theme *started* with the folder structure of the file (IE /kadence), then it would return true
// This meant that we were getting conflicting values and a lot of errors (it was essentially trying to load the files from Kadence's theme directory, not the child)

/* -- */

// RPECK 16/07/2023 - Redux Embed
// Current redux is embedded in the /vendor folder (redux-core)
// Having thought about it, this should be the correct pattern as it means that the version of redux that ships with the theme is static
// Of course, it's preferrable to update it, but that can be done with new theme releases
// --
// https://devs.redux.io/guides/advanced/embedding-redux.html

/* -- */

// RPECK 18/07/2023 - Extensibility
// The point of this child theme is to provide a framework through which *types* of site can be added
// --
// If you want to customize any part of this process, it should look to use the various hooks available through this theme and Kadence
// Ideally, you would NOT touch any of the code inside this child theme and, instead, should add various options to Redux through hooks
// This not only ensures the veracity of our code but - crucially - means we can continue to develop the child theme without running into major problems

/////////////////////////////
/////////////////////////////

// Namespace everything through Kadence, so we have access to all of the parent functionality
namespace KadenceChild;

// RPECK 15/07/2023 - Includes 
// Required files to ensure we are able to run the various pieces of functionality
require_once get_stylesheet_directory() . '/inc/autoload.php';          // RPECK 18/07/2023 - autoload classes 
require_once get_stylesheet_directory() . '/inc/child-functions.php';   // RPECK 18/07/2023 - global functions etc

// RPECK 13/07/2023 - Init
// Lifted from Kadence parent theme
call_user_func('KadenceChild\init');

// RPECK 13/07/2023 - Actions
// These are used to integrate with global hooks inside the system
// I would have preferred to have these loaded via the call_user_func file, but they would need to integrate into the hooks instead
add_action('init', 			 		 'KadenceChild\remove_kadence_notices');     # => child-functions.php
add_action('init',					 'KadenceChild\remove_redux_welcome_page');  # => child-functions.php
add_action('admin_enqueue_scripts',  'KadenceChild\basic_css_menu_support');     # => child-functions.php
add_action('acf/settings/load_json', 'KadenceChild\acf_json_load_point');		 # => child-functions.php

/////////////////////////////
/////////////////////////////