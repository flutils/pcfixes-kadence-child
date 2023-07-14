<?php

/////////////////////////////
/////////////////////////////

// RPECK 02/07/2023
// Thematic Framework -- this is an extension to the "Kadence" theme which overrides render hooks and gives us the means to manage templates via the allocation of "sections"

/////////////////////////////
/////////////////////////////

// Namespace everything through Kadence, so we have access to all of the parent functionality
namespace Kadence;

// Includes 
require_once get_stylesheet_directory() . '/inc/child-functions.php';

// Init
// Lifted from Kadence parent theme
call_user_func('Kadence\child_init');

// Actions
// These are used to integrate with global hooks inside the system
// I would have preferred to have these loaded via the call_user_func file, but they would need to integrate into the hooks instead
add_action('init', 			 'Kadence\child_remove_kadence_notices'); 		# => child-functions.php
//add_action('tgmpa_register', 'Kadence\child_register_required_plugins');	# => child-functions.php

/////////////////////////////
/////////////////////////////