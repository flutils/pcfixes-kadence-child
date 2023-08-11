<?php

//////////////////////////
//////////////////////////

// RPECK 19/07/2023 - Constants
// These are immutable constants defined at the head of the app
// --
// The main reason for this was to separate the apply_filters logic from constants

//////////////////////////
//////////////////////////

// RPECK 26/07/2023 - Namespace
// Added to give us the means to scope the constant to our KadenceChild namespace (I think the constant structure needs updating but can do that another time)
// --
// https://stackoverflow.com/a/18248018/1143732
namespace KadenceChild;

// RPECK 19/07/2023 - Values
// This is used to mass declare the different constants before defining them
$constants = array(

	// RPECK 27/07/2023 - Added here to provide a core value for the text domain 
	// Requires 'use const KADENCE_CHILD_TEXT_DOMAIN;'
	'KADENCE_CHILD_TEXT_DOMAIN' => 'kadence-child-theme'
	
);

// RPECK 19/07/2023 - Set Constants
// This will loop through the constants variable outlined above and will allow us to access these constants inside our system
// --
// Info about namespace scoping for constants: https://www.php.net/manual/en/language.namespaces.nsconstants.php
foreach($constants as $key => $value) {
   if(!defined($key)) define(__NAMESPACE__ . '\\' . $key, $value);
}