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
require get_stylesheet_directory() . '/inc/child-functions.php';

// Init
// Lifted from Kadence parent theme
call_user_func('Kadence\child_init');
call_user_func('Kadence\child_remove_kadence_notices');

/////////////////////////////
/////////////////////////////