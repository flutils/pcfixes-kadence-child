<?php

//////////////////////////
//////////////////////////

// RPECK 16/07/2023 - Redux Config
// This is used to define the various Redux options for our child theme
// We have used Redux (reluctantly) because it interfaces with OCDI and means we can iterate quickly without having to rewrite tons of code each time

//////////////////////////
//////////////////////////

// RPECK 16/07/2023 - No direct access
// Maintain the security of the system by blocking anyone who tries to access the file directly
defined( 'ABSPATH' ) || exit;

// RPECK 16/07/2023 - Only proceed if Redux is available and loaded
if(!class_exists('Redux')) return;

// RPECK 16/07/2023 - Redux settings prefix
// This is your option name where all the Redux data is stored.
$opt_name = KADENCE_CHILD_TEXT_DOMAIN; 

// RPECK 16/07/2023 - Theme name (optional)
// Taken from: https://devs.redux.io/guides/basics/getting-started.html
$theme = wp_get_theme();

// RPECK 16/07/2023 - Arguments
// I think this is used to define different parts of the Redux system
$args = array(

	'display_name'     => $theme->get('Name'),
	'display_version'  => $theme->get('Version'),

	'menu_title'       => esc_html__(KADENCE_CHILD_ADMIN_MENU_LABEL, KADENCE_CHILD_TEXT_DOMAIN),
	'menu_type'        => 'submenu',

	'page_slug'		   => KADENCE_CHILD_TEXT_DOMAIN,
	'page_title'       => esc_html__(KADENCE_CHILD_ADMIN_PAGE_TITLE, KADENCE_CHILD_TEXT_DOMAIN),
	'page_parent'      => 'themes.php',

	'admin_bar'        => false,
	'customizer'       => false,
	'dev_mode'         => false

);

// RPECK 16/07/2023 - Set args
// Set the above arguments as the default for the system
Redux::set_args($opt_name, $args);