<?php

//////////////////////////
//////////////////////////

/*

	// RPECK 18/07/2023 - TGMPA Plugins
	// This is the standard set of TGMPA plugin values to be used
	$plugins[] = array(
		array(
			'name'               => 'TGM Example Plugin', // The plugin name.
			'slug'               => 'tgm-example-plugin', // The plugin slug (typically the folder name).
			'source'             => get_stylesheet_directory() . '/lib/plugins/tgm-example-plugin.zip', // The plugin source.
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		)
	);

*/

//////////////////////////
//////////////////////////

// RPECK 13/07/2023 - Namespace
// This was taken from the primary Kadence system - no need to change it
namespace KadenceChild;

// RPECK 16/07/2023 - No direct access
// Maintain the security of the system by blocking anyone who tries to access the file directly
defined( 'ABSPATH' ) || exit;

// RPECK 18/07/2023 - TGMPA Class
// This is used to interface with the TGM-Plugin-Activation class stored in ./vendor/tgm-plugin-activation
class TgmpaCore {

	// RPECK 18/07/2023 - Plugins
	// Array used to define the various plugin options that TGMPA has to manage
	public $plugins = array();

	// RPECK 18/07/2023 - Config
	// Array used to populate configuration options for the system
	public $config = array(
		'id'           => KADENCE_CHILD_TEXT_DOMAIN,  // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      	  // Default absolute path to bundled plugins.
		'menu'         => 'kadence-install-plugins',  // Menu slug.
		'parent_slug'  => 'themes.php',               // Parent menu slug.
		'capability'   => 'edit_theme_options',       // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                       // Show admin notices or not.
		'dismissable'  => false,                      // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '🔥 Framework Plugins',     // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                       // Automatically activate plugins after installation or not.
		'message'      => ''                          // Message to output right before the plugins table.
				
		/*'strings'      => array(
			'page_title'  => __( 'test2', KADENCE_CHILD_TEXT_DOMAIN ),
			'menu_title'  => __( 'test3', KADENCE_CHILD_TEXT_DOMAIN )
		)*/
	);

    // RPECK 18/07/2023 - Constructor
    // Takes $args and allows us to populate (or change) the args above
    function __construct($plugins = array(), $config = array()) {

		// RPECK 18/07/2023 - Config
		// This merges any configuration options that have been passed to the system
		if(is_array($config)) $this->config = array_merge($this->config, $config);

		// RPECK 18/07/2023 - Plugins
		// These are designed to give us the means to populate the $this->plugins attribute with instances of the tgmpa-plugin class
		// The reason for using this class is to ensure we have the means to populate a rigid set of attributes for each plugin (rather than random)
		if(is_array($plugins) && count($plugins) > 0) {

			// RPECK 18/07/2023 - Foreach plugin
			// For each plugin, create a new instance of the TGMAPlugin class 
			foreach($plugins as &$plugin) {

				// RPECK 18/07/2023 - Add a new TGMAPlugin class
				// This allows us to populate the plugins attribute of the TGMA class
				$this->plugins[] = new TgmpaPlugin($plugin);

			}

		}

		$this->plugins[] = 		array(
			'name'               => 'TGM Example Plugin', // The plugin name.
			'slug'               => 'tgm-example-plugin', // The plugin slug (typically the folder name).
			'source'             => get_stylesheet_directory() . '/lib/plugins/tgm-example-plugin.zip', // The plugin source.
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		);
        
    }

	// RPECK 18/07/2023 - Initialize
	// Custom function used to invoke the class when required
	public function initialize() {

		// RPECK 18/07/2023 - TGMPA require
		// This invokes the TGMPA class and allows us to populate it with the data we've defined elsewhere in the system
		add_action('tgmpa_register', array($this, 'tgmpa_register_plugins'));

	}

	// RPECK 18/07/2023 - TGMPA Register Plugins
	// This is used to populate the various values that TGMPA requires to function
	public function tgmpa_register_plugins() {

		// RPECK 18/07/2023 - TGMPA
		// Initialize the values for TGMPA
		tgmpa($this->plugins, $this->config);

	}

}