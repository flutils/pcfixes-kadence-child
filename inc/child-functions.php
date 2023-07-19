<?php

//////////////////////////
//////////////////////////

// Namespace
namespace KadenceChild;

// No access to this directly
defined( 'ABSPATH' ) || exit;

// RPECK 15/07/2023 - Redux Framework
// Integrates the core 'redux-core' class from Redux, allowing us to add, manage, import & export options
// https://devs.redux.io/guides/advanced/embedding-redux.html
if(!class_exists('ReduxFramework') && file_exists(get_stylesheet_directory()  . '/vendor/redux-core/framework.php')) require_once(get_stylesheet_directory()  . '/vendor/redux-core/framework.php');

// RPECK 18/07/2023 - TGMPA
// Imports the core TGMPA class from the vendor directory
// http://tgmpluginactivation.com/configuration/
if(!class_exists('TGM_Plugin_Activation') && file_exists(get_stylesheet_directory()  . '/vendor/tgm-plugin-activation/class-tgm-plugin-activation.php')) require_once(get_stylesheet_directory()  . '/vendor/tgm-plugin-activation/class-tgm-plugin-activation.php');

//////////////////////////
//////////////////////////

// RPECK 13/07/2023 - Init
// This allows us to get the child theme initialized (IE populated with content etc)
function init() {

	// RPECK 19/07/2023 - Config
	// Filter that allows us to define the config options that the class requires
	add_filter('KadenceChild\config', 'KadenceChild\set_config_defaults');

	// RPECK 13/07/2023 - ChildTheme
	// This loads the various classes required to run the theme
	// The reason why we're using classes is because we want to instantize everything to make things work as systemically as possible
	$child_theme = new ChildTheme;

	// RPECK 19/07/2023 - Initialize Child Theme
    // This needs to be added through the Wordpress system so that we can use filters etc
    $child_theme->initialize();

}

//////////////////////////
//////////////////////////

// RPECK 19/07/2023 - Config Default
// This is loaded via the functions.php file and is used to provide a means to filter the configuration options for the theme
function set_config_defaults($config) {

	// RPECK 19/07/2023 - Provide array to the filter
	// This may change in structure but the following should suffice for now
	$defaults = array(
			
		'KADENCE_CHILD_TEXT_DOMAIN' 	 => KADENCE_CHILD_TEXT_DOMAIN,

		'KADENCE_CHILD_ADMIN_MENU_LABEL' => '🔥 Child Theme',
		'KADENCE_CHILD_ADMIN_PAGE_TITLE' => 'Kadence Child Import Management',

		'KADENCE_CHILD_TGMPA_MENU_TITLE' => '➡️ Plugins',
		'KADENCE_CHILD_TGMPA_PAGE_TITLE' => 'Install Required Plugins',

		'KADENCE_CHILD_REDUX_SECTIONS'	 => array('site', 'plugins', 'post_types')

	);

	// RPECK 19/07/2023 - Return
	// Return the value of the filter
	return array_merge($defaults, $config);

}

//////////////////////////
//////////////////////////

// RPECK 13/07/2023 - Remove Kadence notice(s)
// This was added to ensure were not getting any unwanted messages from Kadence
function remove_kadence_notices(){

    // Remove 'Starter Templates' notice
    // https://www.kadencewp.com/support-forums/topic/how-to-remove-cart-summary-title/
    if (class_exists('Kadence\Theme')) {
        $kadence_theme_class = \Kadence\Theme::instance();
        remove_action('admin_notices', array( $kadence_theme_class->components['base_support'], 'kadence_starter_templates_notice' ));
    }
    
}

// RPECK 15/07/2023 - Admin Menu Arrow Thing
// Taken from the Kadence Starter Themes plugin (./wp-content/plugins/kadence-starter-templates/class-kadence-starter-templates.php)
function basic_css_menu_support() {

	// Check if Kadence exists 
	if (class_exists('Kadence\Theme')) {
		wp_register_style('kadence-import-admin', false );
		wp_enqueue_style('kadence-import-admin' );
		$css = '#menu-appearance .wp-submenu a[href^="themes.php?page=kadence-"]:before {content: "\21B3";margin-right: 0.5em;opacity: 0.5;}';
		wp_add_inline_style('kadence-import-admin', $css);
	}
}

// RPECK 16/07/2023 - Remove Redux welcome page
// Removes the 'Settings -> Redux' page that appears with Redux (./wp-content/themes/pcfixes-kadence-child/vendor/redux-core/inc/welcome/class-redux-welcome.php)
function remove_redux_welcome_page() {

	// Check if ReduxFramework exists
	if(class_exists('ReduxFramework')) {
		$redux_instance = \Redux_Core::instance();
		remove_action('init', array($redux_instance::$welcome, 'init'), 999);
	}

}

// RPECK 18/07/2023 - ACF JSON
// The ACF JSON local directory location (./lib/acf-json)
// https://www.advancedcustomfields.com/resources/local-json/
// --
// This ensures we have a place to allocate 
function acf_json_load_point($paths) {
    
    // Remove original path (optional)
    unset($paths[0]);
    
    // Append path
    $paths[] = get_stylesheet_directory() . '/lib/acf-json';
    
    // Return
    return $paths;
    
}

//////////////////////////
//////////////////////////