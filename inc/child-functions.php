<?php

//////////////////////////
//////////////////////////

// RPECK 02/07/2023 - Child Theme Functions
// Entrypoint into the various aspects of the child theme

//////////////////////////
//////////////////////////

// Namespace
namespace KadenceChild;

// No access to this directly
defined( 'ABSPATH' ) || exit;

// RPECK 13/07/2023 - Includes 
// Required files to allow us to run the various classes
$files = array(
	'/inc/classes/class-child-theme.php', 		// RPECK 15/07/2023 - Child base class
	'/inc/classes/class-redux.php',				// RPECK 16/07/2023 - Base Redux class (used to pull out data)
	'/inc/classes/class-redux-section.php',		// RPECK 16/07/2023 - Section of Redux framework (used to populate each part of Redux page)
	'/inc/classes/class-tgmpa.php',				// RPECK 18/07/2023 - Base TGMPA class (pulls in plugins defined inside Redux)
	'/inc/classes/class-tgmpa-plugin.php'		// RPECK 18/07/2023 - TGMPA plugin class (gives us a standard set of attributes for plugins loaded into tgmpa)
);

// RPECK 17/07/2023 - Includes
// Allows us to populate the include files without having to repeat ourselves constantly
foreach($files as &$file) {
	require_once get_stylesheet_directory() . $file;
}     

// RPECK 15/07/2023 - Redux Framework
// Integrates the core 'redux-core' class from Redux, allowing us to add, manage, import & export options
// https://devs.redux.io/guides/advanced/embedding-redux.html
// --
// We are using Redux to give us a means to manage options without having to write a ton of code to handle it
// Crucially, it is fully supported by OCDI, allowing us to import customization options as needed without difficulty
// The Redux-Core file is added to the output build when a new release is created in Github
if(!class_exists('ReduxFramework') && file_exists(get_stylesheet_directory()  . '/vendor/redux-core/framework.php')) require_once(get_stylesheet_directory()  . '/vendor/redux-core/framework.php');

// RPECK 18/07/2023 - TGMPA
// Imports the core TGMPA class from the vendor directory
// http://tgmpluginactivation.com/configuration/
// --
// We are using TGMPA as a means to validate the plugins added through OCDI
// This means that if you import a template through OCDI, and there are certain plugins that it has installed but you disabled, it will remind you to install them
// Whilst the system is not absolutely necessary, it's a good way to ensure continuity through the framework
if(!class_exists('TGM_Plugin_Activation') && file_exists(get_stylesheet_directory()  . '/vendor/tgm-plugin-activation/class-tgm-plugin-activation.php')) require_once(get_stylesheet_directory()  . '/vendor/tgm-plugin-activation/class-tgm-plugin-activation.php');

// RPECK 13/07/2023 - Init
// This allows us to get the child theme initialized (IE populated with content etc)
function init() {

	// This loads the various classes required to run the theme
	// The reason why we're using classes is because we want to instantize everything to make things work as systemically as possible
	$child_theme = new ChildTheme();

    // Initialize child theme
    $child_theme->initialize();

}

//////////////////////////
//////////////////////////

/*
	'Global' Functions
	These are called by the initial functions.php file for the child theme (primarily so they can be disabled as they aren't buried in a class)
*/

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