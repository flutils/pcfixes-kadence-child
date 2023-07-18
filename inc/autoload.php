<?php

//////////////////////////
//////////////////////////

// RPECK 18/07/2023 - Autoloader
// Loads the various classes we use within the theme

//////////////////////////
//////////////////////////

// RPECK 18/07/2023 - Autoload values
// This brings in the values required to make the system work
function kadence_child_autoloader($class) {

    // RPECK 18/07/2023 - Namespace
    // Defines the namespace from which the autoloader infers classes
	$namespace = 'KadenceChild';

    // RPECK 18/07/2023 - Namespace classed
    // This means that we don't need to load our files if the autoloader is not pulling in the class
    if(strpos($class, $namespace) == 0) {

        // RPECK 18/07/2023 - Snake Case
        // Because the class name itself is going to come in as KadenceChild\ClassName, we need to get rid of the namespace and snake case the class name
        $class_snake_case = str_replace($namespace . '\\','', $class);
        $class_snake_case = strtolower(preg_replace("/([a-z])([A-Z])/", "$1_$2", $class_snake_case));

        // RPECK 18/07/2023 - Filename
        // Variable used to test against
        $filename = get_stylesheet_directory() . '/inc/classes/class-' . $class_snake_case . '.php';

    }
 
	// RPECK 18/07/2023 - Require Once
    // If a class is loaded, it is loaded here
    if(isset($filename) && file_exists($filename)) require_once($filename);
}  

// RPECK 18/07/2023 - Include
// Loads the various classes into the instantiated system
spl_autoload_register('kadence_child_autoloader');