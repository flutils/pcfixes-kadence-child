<?php

//////////////////////////
//////////////////////////

// RPECK 24/08/2023 - Announcement Bar
// Extracted from previous set up - allows us to add an announcement bar to the system

//////////////////////////
//////////////////////////

// RPECK 04/08/2023 - Namespace
// This was taken from the primary Kadence system - no need to change it
namespace KadenceChild;

// RPECK 04/08/2023 - Libraries
// Loads the various classes & functions required by the class
use KadenceChild\Redux\Section;
use DOMDocument;

// RPECK 16/07/2023 - No direct access
// Maintain the security of the system by blocking anyone who tries to access the file directly
defined( 'ABSPATH' ) || exit;

// RPECK 04/08/2023 - Class definition
// Gives us the means to manage the various parts of the admin area by extending the base Section class
class AnnouncementBar extends Section {

	// RPECK 05/08/2023 - Default Values
	// This loads the various values for this class (and parent)
	function __construct($opt_name) {

		// RPECK 05/08/2023 - Vars
		// The various items required to populate the parent class
		$args = array(

            'id'       	 => 'announcement',
            'title'    	 => 'Announcement Bar',
            'icon'     	 => 'el-icon-website',
            'heading'  	 => '<h1>⭐ Announcement Bar</h1>',
            'priority' 	 => 6,
            'subsection' => true,
            'desc'     	 => '
                --<br />
                <strong>Manage the announcement bar on the website.</strong>
                <p>This is linked to the "Kadence Element" for the announcement bar.</p>
            ',
            'fields' => array(
            
                // RPECK 21/08/2023 - Enabled?
                // Is the announcement bar enabled? Use it in the Kadence Element conditionality clause
                array(
                    'id'      				=> 'announcement_enabled',
                    'type'    				=> 'switch',
                    'title'   				=> 'Announcement Bar Enabled?',
                    'subtitle'				=> 'Should the announcement bar be enabled?',
                    'on'					=> 'Yes',
                    'off'					=> 'No',
                    'dynamic_conditional' 	=> true,
                    'load_callback'         => function($value, $opt_name) {

                        // RPECK 24/08/2023 - Global
                        // Pulls the Redux framework data into a global variable
                        global $kadence_child_theme;

                        // RPECK 24/08/2023 - If value is true, add payload to "kadence_before_wrapper" action
                        // This gives us the means to output the notification bar
                        if($value == 1 && !empty($kadence_child_theme['announcement_text'])) {

                            // RPECK 24/08/2023 - Insert HTML payload
                            // Allows us to deploy the code required into the hook for Kadence
                            add_action('kadence_before_wrapper', function() use ($kadence_child_theme) {

                                // RPECK 24/08/2023 - New DOMDocument
                                // Creates a document through which we can add various elements
                                $document = new DOMDocument();

                                // RPECK 24/08/2023 - Announcement Bar Element
                                // This will use the HTMLElement API provided by all modern browsers (JS in the ./assets/js/main.js file)
                                $bar = $document->createElement('announcement-bar');

                                // RPECK 24/08/2023 - Site container
                                // Used to give us the means to shrink the width of the close button
                                $wide = $document->createElement('div');
                                $wide->setAttribute('class', 'site-container');

                                // RPECK 24/08/2023 - Content to show in the element
                                // This is used to display the text that the announcement bar will display
                                $content = $document->createElement('span', $kadence_child_theme['announcement_text']);
                                $content->setAttribute('class', 'text');

                                // RPECK 24/08/2023 - Content to show in the element
                                // This is used to display the text that the announcement bar will display
                                $button = $document->createElement('button', '&nbsp;');
                                $button->setAttribute('class', "close-popup {$kadence_child_theme['announcement_icon']}");

                                // RPECK 24/08/2023 - Append Content
                                // Required to ensure the content is added to the DOM
                                $wide->appendChild($content);
                                $wide->appendChild($button);

                                // RPECK 24/08/2023 - Append Container
                                // Gives us the means to allocate the correct width for the close button
                                $bar->appendChild($wide);

                                // RPECK 24/08/2023 - Append Bar to page
                                // This populates the $document with the $bar element (and all of its children)
                                $document->appendChild($bar);

                                // RPECK 24/08/2023 - Return
                                // Sends the above HTML payload (CSS / Javascript in appropriate files)
                                echo $document->saveHTML(); 
                                
                            });

                        }

                    }
                ),

                // RPECK 25/08/2023 - Close Icon
                // Gives us the ability to choose the icon we want to show to close the notification bar
                array(
                    'id'      	       => 'announcement_icon',
                    'type'    	       => 'icon_select',
                    'title'   	       => 'Announcement Icon',
                    'subtitle'	       => 'The icon used for the <strong>close button</strong>.',
                    'fontawesome'      => true,
                    'dashicons'        => false,
                    'default'          => 'fas fa-xmark',
                    'enqueue_frontend' => true
                ),
                
                // RPECK 21/08/2023 - Announcement Text
                // The announcement text to display inside the bar 
                array(
                    'id'      	   => 'announcement_text',
                    'type'    	   => 'editor',
                    'title'   	   => 'Announcement Text',
                    'subtitle'	   => 'The text to display in the announcement bar.',
                    'placeholder'  => 'Announcement bar text',
                    'dynamic_text' => true
                ),

                // RPECK 25/08/2023 - Top Padding
                // Padding at the top of the notification bar
                array(
                    'id'      	       => 'announcement_padding_top',
                    'type'    	       => 'slider',
                    'title'   	       => 'Top Padding',
                    'subtitle'	       => 'Padding between the top border and text (px)'
                ),   

                // RPECK 25/08/2023 - Bottom Padding
                // Padding at the top of the notification bar
                array(
                    'id'      	       => 'announcement_padding_bottom',
                    'type'    	       => 'slider',
                    'title'   	       => 'Bottom Padding',
                    'subtitle'	       => 'Padding between the bottom border and text (px)'
                )
                
            )
			
		);

		// RPECK 05/08/2023 - Instantiate the parent class
		// This brings in the different items which
		parent::__construct($opt_name, $args);

	}

}