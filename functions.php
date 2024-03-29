<?php

/////////////////////////////
/////////////////////////////

// Namespace everything through Kadence, so we have access to all of the parent functionality
namespace KadenceChild;

// RPECK 15/07/2023 - Includes 
// Required files to ensure we are able to run the various pieces of functionality
foreach(glob(get_stylesheet_directory() . "/inc/*.php") as &$file) { require_once($file); }

// RPECK 09/02/2024 - Extra functions
// Used to give us the ability to interface with the system via a file
// --
// Primary reason for this was adding functionality which interfaced with Redux was not possible via snippets
if( file_exists(get_stylesheet_directory() . "/lib/functions.php") ) require_once(get_stylesheet_directory() . "/lib/functions.php"); 

// RPECK 13/07/2023 - Actions
// These are used to integrate with global hooks inside the system
// I would have preferred to have these loaded via the call_user_func file, but they would need to integrate into the hooks instead
add_action('init', 					'KadenceChild\change_tgmpa_load_sequence', 0); 	# => child-functions.php
add_action('init', 			  		'KadenceChild\remove_kadence_notices');  	    # => child-functions.php
add_action('admin_enqueue_scripts', 'KadenceChild\basic_css_menu_support');  	    # => child-functions.php

// RPECK 01/08/2023 - Filters
// Used to provide various filter endpoints through which to integrate
add_filter('acf/settings/save_json',  'KadenceChild\acf_json_load_point');		    # => child-functions.php
add_filter('acf/settings/load_json',  'KadenceChild\acf_json_load_point');		    # => child-functions.php
add_filter('pre_update_option',       'KadenceChild\pre_update_option', 10, 3);     # => child-functions.php
add_filter('KadenceChild\sections',   'KadenceChild\default_sections', 10, 2);      # => child-functions.php

// RPECK 28/07/2023 - Not Debug
// These trigger only when Wordpress is NOT in debug mode
if (defined('WP_DEBUG') && false === WP_DEBUG) {
  
  // RPECK 28/07/2023 - Remove Redux welcome message page
  // This is the page that Redux adds to the "Settings" menu and is not required in production
  add_action('init', 'KadenceChild\remove_redux_welcome_page');  # => child-functions.php

}

// RPECK 13/07/2023 - Init
// Lifted from Kadence parent theme - in child-functions.php
call_user_func('KadenceChild\init');

/////////////////////////////
/////////////////////////////
