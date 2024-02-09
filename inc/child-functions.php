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

	// RPECK 13/07/2023 - ChildTheme
	// This loads the various classes required to run the theme
	// The reason why we're using classes is because we want to instantize everything to make things work as systemically as possible
	$child_theme = new \KadenceChild\Theme;

	// RPECK 19/07/2023 - Initialize Child Theme
	// This needs to be added through the Wordpress system so that we can use filters etc
	$child_theme->initialize();

}

//////////////////////////
//////////////////////////

// RPECK 08/08/2023 - Section Defaults
// Extracted from the core Theme class files into a separate set of child functions (to keep the core theme code lean)
function default_sections($sections, $redux) {

    // RPECK 08/02/2024 - Added ability to the ./lib/redux/sections directory 
    // Required to give us the means to access the various sections defined in a set of files in the lib directory
    $default_sections = [
        array(get_stylesheet_directory(), 'inc', 'sections', '*.php'),
        array(get_stylesheet_directory(), 'lib', 'redux', 'sections', '*.php')
    ];
    
    // RPECK 08/02/2024 - Implode each of the array elements
    // Gives us the means to perform an action on each of the array elements (namely to implode them)
    array_walk($default_sections, function(&$value){
        
        // RPECK 08/02/2024 - Implode the path
        // This could probably be done above but for the sake of ensuring things are done properly, doing it here
        if(is_array($value)) $value = implode(DIRECTORY_SEPARATOR, $value);
        
    });
    
    // RPECK 05/08/2023 - Initialize Classes
    // Loops through the files in the globbed folder, allowing us to invoke the classes as needed
    // --
    // Ref: https://stackoverflow.com/a/10664000/1143732
    foreach(glob('{' . implode(',', $default_sections) . '}', GLOB_BRACE) as &$file) {

        // RPECK 08/08/2023 - Require files
        // This should really go in the autoloader but because we've changed the file structure, we can put it here
        require_once($file);

        // RPECK 05/08/2023 - Get class name from path
        // This takes a full path and allows us to extract the filename from it
        $path = explode('/', str_replace('.php', '', $file));

        // RPECK 08/08/2023 - CamelCase
        // The default for this will be snake_case, which needs to be made into CamelCase to call the class
        $filename = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', end($path)))));

        // RPECK 05/08/2023 - Create Instance of Class
        // Gives us the ability to get the functionality working
        $class = '\KadenceChild\\' . $filename;

        // RPECK 05/08/2023 - New Class
        // Sets up the class using the values inside it to get defaults
        $klass = new $class($redux::$opt_name);

        // RPECK 05/08/2023 - Add the new element to the start of the sections array
        // Gives us the ability to manage the system properly
        if(is_array($sections)) array_unshift($sections, $klass);

    }

    // RPECK 08/08/2023 - Return sections
    // This allows us to get the most value set up
    return $sections;

}

// RPECK 01/08/2023 - Pre Update Option
// This used to be in the theme's main class, but decided to extract it to keep that clean
// --
// It allows us to only update options if the values are different
// https://developer.wordpress.org/reference/hooks/pre_update_option/
function pre_update_option($new_value, $option, $old_value) {

    // RPECK 29/07/2023 - Check if the new value is the same as the old
    // If it is, return the new value, else the old 
    return $new_value != $old_value ? $new_value : $old_value;

}

// RPECK 31/07/2023 - Change TGMPA Load Sequence
// This removes the tgmpa 'init' action and replaces it at a higher priority (was messing up our load order with Redux)
// --
// https://github.com/TGMPA/TGM-Plugin-Activation/blob/2d34264f4fdcfcc60261d490ff2e689f0c33730c/class-tgm-plugin-activation.php#L277
function change_tgmpa_load_sequence(){
	
	// RPECK 31/07/2023 - Only trigger if the TGMPA class is loaded
	// This is needed to ensure we are able to call the class properly
	if(class_exists('TGM_Plugin_Activation')) {

		// RPECK 31/07/2023 - Added an instance of the class
		// This is called here: https://github.com/TGMPA/TGM-Plugin-Activation/blob/2d34264f4fdcfcc60261d490ff2e689f0c33730c/class-tgm-plugin-activation.php#L2144
		$tgmpa_theme_class = \TGM_Plugin_Activation::get_instance();

		// RPECK 31/07/2023 - Remove 'init' action
		// This needs a priority which was not being set inside TGMPA
		remove_action('init', array( $tgmpa_theme_class, 'init' ));

		// RPECK 31/07/2023 - Add the class again with priority
		// Exactly the same functionality except we have added a priority this time
		add_action('init', array( $tgmpa_theme_class, 'init' ), 100);
		
	}

}

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

// RPECK 18/07/2023 - ACF JSON Load
// The ACF JSON local directory location (./lib/acf-json)
// https://www.advancedcustomfields.com/resources/local-json/
// --
// This populates the location of the JSON directory that ACF uses to save and load different field groups
function acf_json_load_point($paths) {
    
    // RPECK 30/10/2023 - Vars
    // Determines the different vars for the system
    $current_filter = current_filter();
    $path           = get_stylesheet_directory() . '/lib/acf-json';
    
    // RPECK 30/10/2023 - Current Filter
    // Used to determine how we should respond to the request (IE we are using this function for both load and save)
    // --
    // Save path expects string return - https://www.advancedcustomfields.com/resources/local-json/#saving-explained
    if($current_filter == 'acf/settings/save_json') {
        
        // Override the variable with our string
        $paths = $path;
        
    // Load path expects array return - https://www.advancedcustomfields.com/resources/local-json/#loading-explained
    } else {
    
        // Remove original path (optional)
        unset($paths[0]);
        
        // Append path
        $paths[] = $path;
    
    }
    
    // Return
    return $paths;
    
}

// RPECK 21/10/2023 - WooCommerce Template Path Change
// Used to change the default template path for WooCommerce templates
add_filter('woocommerce_template_path', function($path){
    $my_path = get_stylesheet_directory() . '/lib/woocommerce/';
    return file_exists($my_path) ? '/lib/woocommerce/' : $path;
});

// RPECK 22/10/2023 - Relevanssi Live Search Template Path
// Allows us to override the default path for the template that Relevanssi expexects in the ./relevanssi-live-ajax-search folder
// --
// Filter used at ./plugins/relevanssi-live-ajax-search/includes/class-relevanssi-live-search-template.php#101
add_filter('relevanssi_live_search_template_dir', function($path) {
    $my_path = get_stylesheet_directory() . '/lib/relevanssi-live-ajax-search';
    return file_exists($my_path) ? '/lib/relevanssi-live-ajax-search' : $path;
});

//////////////////////////
//////////////////////////
