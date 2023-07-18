<?php

//////////////////////////
//////////////////////////

// RPECK 18/07/2023 - TGMPA Class 
// This pulls in the various plugins defined by a theme (via Redux) and highlights if any are not installed

/*

	// RPECK 18/07/2023 - TGMPA Plugins
	// This is the standard set of TGMPA plugin values to be used
	$plugins = array(
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

// RPECK 18/07/2023 - Libraries
// Pulls in the various libraries we need to use within the class
use function tgmpa;

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
	public $config = array();

    // RPECK 18/07/2023 - Constructor
    // Takes $args and allows us to populate (or change) the args above
    function __construct($plugins = array(), $config = array()) {

		// RPECK 18/07/2023 - Config Defaults
		// This allows us to identify exactly what is being used
		$this->config = array(
			'id'           => KADENCE_CHILD_TEXT_DOMAIN,  // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      	  // Default absolute path to bundled plugins.
			'menu'         => 'kadence-install-plugins',  // Menu slug.
			'parent_slug'  => 'themes.php',               // Parent menu slug.
			'capability'   => 'edit_theme_options',       // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,                       // Show admin notices or not.
			'dismissable'  => false,                      // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '🔥 Framework Plugins',     // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => true,                       // Automatically activate plugins after installation or not.
			'message'      => '',                         // Message to output right before the plugins table.

			
			'strings'      => array(
				'page_title'                      => __( KADENCE_CHILD_TGMPA_PAGE_TITLE, KADENCE_CHILD_TEXT_DOMAIN ),
				'menu_title'                      => __( KADENCE_CHILD_TGMPA_MENU_TITLE, KADENCE_CHILD_TEXT_DOMAIN ),
			),
				/* translators: %s: plugin name. * /
				'installing'                      => __( 'Installing Plugin: %s', 'kadence-child-theme' ),
				/* translators: %s: plugin name. * /
				'updating'                        => __( 'Updating Plugin: %s', 'kadence-child-theme' ),
				'oops'                            => __( 'Something went wrong with the plugin API.', 'kadence-child-theme' ),
				'notice_can_install_required'     => _n_noop(
					/* translators: 1: plugin name(s). * /
					'This theme requires the following plugin: %1$s.',
					'This theme requires the following plugins: %1$s.',
					'kadence-child-theme'
				),
				'notice_can_install_recommended'  => _n_noop(
					/* translators: 1: plugin name(s). * /
					'This theme recommends the following plugin: %1$s.',
					'This theme recommends the following plugins: %1$s.',
					'kadence-child-theme'
				),
				'notice_ask_to_update'            => _n_noop(
					/* translators: 1: plugin name(s). * /
					'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
					'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
					'kadence-child-theme'
				),
				'notice_ask_to_update_maybe'      => _n_noop(
					/* translators: 1: plugin name(s). * /
					'There is an update available for: %1$s.',
					'There are updates available for the following plugins: %1$s.',
					'kadence-child-theme'
				),
				'notice_can_activate_required'    => _n_noop(
					/* translators: 1: plugin name(s). * /
					'The following required plugin is currently inactive: %1$s.',
					'The following required plugins are currently inactive: %1$s.',
					'kadence-child-theme'
				),
				'notice_can_activate_recommended' => _n_noop(
					/* translators: 1: plugin name(s). * /
					'The following recommended plugin is currently inactive: %1$s.',
					'The following recommended plugins are currently inactive: %1$s.',
					'kadence-child-theme'
				),
				'install_link'                    => _n_noop(
					'Begin installing plugin',
					'Begin installing plugins',
					'kadence-child-theme'
				),
				'update_link' 					  => _n_noop(
					'Begin updating plugin',
					'Begin updating plugins',
					'kadence-child-theme'
				),
				'activate_link'                   => _n_noop(
					'Begin activating plugin',
					'Begin activating plugins',
					'kadence-child-theme'
				),
				'return'                          => __( 'Return to Required Plugins Installer', 'kadence-child-theme' ),
				'plugin_activated'                => __( 'Plugin activated successfully.', 'kadence-child-theme' ),
				'activated_successfully'          => __( 'The following plugin was activated successfully:', 'kadence-child-theme' ),
				/* translators: 1: plugin name. * /
				'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'kadence-child-theme' ),
				/* translators: 1: plugin name. * /
				'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'kadence-child-theme' ),
				/* translators: 1: dashboard link. * /
				'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'kadence-child-theme' ),
				'dismiss'                         => __( 'Dismiss this notice', 'kadence-child-theme' ),
				'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'kadence-child-theme' ),
				'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'kadence-child-theme' ),

				'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
			),
			*/
		);

		// RPECK 18/07/2023 - Config
		// This merges any configuration options that have been passed to the system
		if(is_array($config)) $this->config = array_merge($this->config, $config);

// Temp
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
        
    }

	// RPECK 18/07/2023 - Initialize
	// Custom function used to invoke the class when required
	public function initialize() {

		// RPECK 18/07/2023 - TGMPA require
		// This invokes the TGMPA class and allows us to populate it with the data we've defined elsewhere in the system
		add_filter('tgmpa_register', array($this, 'tgmpa_register_plugins'));

	}

	// RPECK 18/07/2023 - TGMPA Register Plugins
	// This is used to populate the various values that TGMPA requires to function
	public function tgmpa_register_plugins() {

		// RPECK 18/07/2023 - TGMPA
		// Initialize the values for TGMPA
		tgmpa($this->plugins, $this->config);

	}

}