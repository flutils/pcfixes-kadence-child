<?php

//////////////////////////
//////////////////////////

// RPECK 13/07/2023
// Child theme class - used to provide base functionality for the child theme

//////////////////////////
//////////////////////////

// Namespace
namespace Kadence;

// Class Definition
class ChildTheme {

    //////////////////////////////
    //////////////////////////////

    // This is the primary ingress point into the system
    // The point is to take the various settings (CPT's etc) and have them loaded here

    //////////////////////////////
    //////////////////////////////   

    // Constructor
	function __construct() {}

	// Initialize
	// Public function which is invoked by the constructor
	public function initialize() {

        // Filters
        add_filter('manage_section_posts_columns', array($this, 'kadence_child_theme_admin_columns'));

        // Action
        add_action('manage_section_posts_custom_column', array($this, 'kadence_child_theme_admin_custom_columns'), 10, 2); 

	}

    // Admin Column Labels
    // For CPT's inside the theme, these are the labels for the columns
    public function kadence_child_theme_admin_columns($columns) {

        // Remove default columns
        foreach(['date', 'author'] as &$item) {
            unset($columns[$item]);
        }

        // Add custom columns
        $columns['enabled_on']  = '✔️ Enabled On';
        $columns['status']      = '🚨 Status';
        $columns['date']        = '📅 Date';

        // Return
        return $columns;

    }

    // Admin Custom Columns
    // The system facilitates CPT custom columns 
    public function kadence_child_theme_admin_custom_columns($column, $post_id) {
        switch ($column) {
            case 'status':
                echo get_post_status($post_id);
                break;
            case 'allocation':
                echo implode(', ', get_post_meta($post_id, '_section_allocation')) ?? 'All';
                break;
        }
    }


    /*

// Init
// This allows us to get the 
function child_init() {

    // Reister post type
    // This registers any of the post types we require internally (IE not for public consumption on their own)
    add_action('init', function(){

        // Var
        $singular = 'Section';
        $plural   = 'Sections';

        // Labels
        $labels = array(
            'name'               => __( $plural ),
            'singular_name'      => __( $singular ),
            'add_new'            => __( 'Add New ' . $singular ),
            'add_new_item'       => __( 'Add New ' . $singular ),
            'edit_item'          => __( 'Edit ' . $singular ),
            'new_item'           => __( 'New ' . $singular ),
            'all_items'          => __( 'All ' . $plural ),
            'view_item'          => __( 'View ' . $singular ),
            'search_items'       => __( 'Search ' . $plural )
        );
        
        // The arguments for our post type, to be entered as parameter 2 of register_post_type()
        $args = array(
			'labels'             => $labels,
			'description'        => __( 'Custom sections for CPTs and Taxonomies.', 'kadence' ),
			'public'             => false,
			'publicly_queryable' => false,
			'has_archive'        => false,
			'exclude_from_search'=> true,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'show_in_nav_menus'  => false,
			'show_in_admin_bar'  => false,
			'can_export'         => true,
			'show_in_rest'       => true,
			'rewrite'            => false,
			'rest_base'          => 'kadence_section',
			'capability_type'    => array( 'kadence_elements', 'kadence_elements' ),
			'map_meta_cap'       => true,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt')

        );
        
        // Call the actual WordPress function
        // Parameter 1 is a name for the post type
        // Parameter 2 is the $args array
        register_post_type(strtolower($singular), $args);

    });

    // Remove the various hooks that are inside Kadence already
    add_action('pre_get_posts', function($query){

      // The aim of this is to get the *sections* for the template and display them
      if($query->is_main_query() && !is_admin() && ($query->is_archive || $query->is_home || $query->is_singular)) {

        // Sections will display as a loop with the "$post" being a global variable inside each section
        // The sections will be pulled from the CPT itself (IE artists and then the specific page)
        $sections = new WP_Query(array(
            "post_type"      => "section",
            "posts_per_page" => -1,
            'no_found_posts' => true,
            "meta_query"     => array(
                array(
                    "key"     => "_section_cpt",
                    "value"   => $query->get('post_type'),
                    "compare" => "IN"
                )
            )
        ));

        if($query->is_singular) {
            $query->set('post_type', 'section');
            $query->set('posts_per_page', -1);
        }

      }

    });

    */
    
}