<?php

/////////////////////////////
/////////////////////////////

// Namespace everything through Kadence, so we have access to all of the parent functionality
namespace KadenceChild;

// RPECK 19/07/2023 - Libraries / Functions
// Use specific functions / libraries for use in the namespace
use function add_action;

// RPECK 15/07/2023 - Includes 
// Required files to ensure we are able to run the various pieces of functionality
foreach(glob(get_stylesheet_directory() . "/inc/*.php") as &$file) { require_once($file); }

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