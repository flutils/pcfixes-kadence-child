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

/////////////////////////////
/////////////////////////////

// Namespace everything through Kadence, so we have access to all of the parent functionality
namespace KadenceChild;

// RPECK 16/07/2023 - Declarations
// These are called to give us the means to define various parts of the system without having to change code all the time
$constants = array(
	'KADENCE_CHILD_TEXT_DOMAIN' 	 => 'kadence-child-theme',
	'KADENCE_CHILD_ADMIN_MENU_LABEL' => '🔥 Child Theme',
	'KADENCE_CHILD_ADMIN_PAGE_TITLE' => 'Kadence Child Import Management'
);

// RPECK 16/07/2023 - Define each constant
// Loops through above array and allows us to populate constants as required
foreach($constants as $key => $value) {
	if(!defined($key)) define($key, $value);
}

// RPECK 15/07/2023 - Includes 
// Required files to ensure we are able to run the various pieces of functionality
require_once get_stylesheet_directory() . '/inc/child-functions.php';

// RPECK 13/07/2023 - Init
// Lifted from Kadence parent theme
call_user_func('KadenceChild\init');

// RPECK 13/07/2023 - Actions
// These are used to integrate with global hooks inside the system
// I would have preferred to have these loaded via the call_user_func file, but they would need to integrate into the hooks instead
add_action('init', 			 		'KadenceChild\remove_kadence_notices');     # => child-functions.php
add_action('init',					'KadenceChild\remove_redux_welcome_page');  # => child-functions.php
add_action('admin_enqueue_scripts', 'KadenceChild\basic_css_menu_support');     # => child-functions.php

/////////////////////////////
/////////////////////////////