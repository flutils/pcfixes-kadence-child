<?php

//////////////////////////
//////////////////////////

// RPECK 18/07/2023 - Autoloader
// Loads our own classes within the theme (does not include vendor classes)
// --
// I originally made this myself but ended up adopting PSR-4 instead

//////////////////////////
//////////////////////////

// RPECK 05/08/2023 - PSR-4
// New set of standards to match PSR-4, ensuring we have the means to manage extended values properly
// https://www.php-fig.org/psr/psr-4/
// https://www.php-fig.org/psr/psr-4/examples/
function kadence_child_autoloader($class) {

    // RPECK 05/08/2023 - Vars
    // Values used in the system to ensure the correct class values are populated
    $namespace        = 'KadenceChild';
    $namespace_length = strlen($namespace);
    $base_directory   = __DIR__ . DIRECTORY_SEPARATOR . 'classes';

    // RPECK 05/08/2023 - Is the $class variable part of the namespace
    // We only want to work with the namespace listed above
    if(strncmp($namespace, $class, $namespace_length) !== 0) return;

    // RPECK 05/08/2023 - Get relative class name
    // This allows us to call the filename in the directory listed below
    $relative_class = substr($class, $namespace_length);

    // RPECK 05/08/2023 - Create the filename
    // It will be passed onto the require directive below
    $filename = $base_directory . str_replace('\\', '/', $relative_class) . '.php';
 
	// RPECK 18/07/2023 - Require Once
    // If a class is loaded, it is loaded here
    if(isset($filename) && file_exists($filename)) require_once($filename);

}  

// RPECK 18/07/2023 - Include
// Loads the various classes into the instantiated system
spl_autoload_register('kadence_child_autoloader');