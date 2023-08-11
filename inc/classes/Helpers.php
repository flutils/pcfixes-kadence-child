<?php

//////////////////////////
//////////////////////////

// RPECK 11/08/2023
// Helper class - provides supporting functionality to other parts of the system

//////////////////////////
//////////////////////////

// RPECK 13/07/2023 - Namespace
// This was taken from the primary Kadence system - no need to change it
namespace KadenceChild;

// RPECK 16/07/2023 - No direct access
// Maintain the security of the system by blocking anyone who tries to access the file directly
defined( 'ABSPATH' ) || exit;

// RPECK 11/08/2023 - Helpers
// Used to provide a series of static methods that can be used to support other parts of the system
// --
// No need for a constructor because we are calling the methods statically
class Helpers {

    // RPECK 11/08/2023 - Lower Brightness
    // This is used in the PostType.php class to give us the means to change the menu colour from a single declaration
	// --
	// https://stackoverflow.com/a/54393956/1143732
	/**
	* Increases or decreases the brightness of a color by a percentage of the current brightness.
	*
	* @param   string  $hexCode        Supported formats: `#FFF`, `#FFFFFF`, `FFF`, `FFFFFF`
	* @param   float   $adjustPercent  A number between -1 and 1. E.g. 0.3 = 30% lighter; -0.4 = 40% darker.
	*
	* @return  string
	*
	* @author  maliayas
	*/
	static function adjustBrightness($hexCode = '#ffffff', $adjustPercent = 0.3) {
		$hexCode = ltrim($hexCode, '#');

		if(strlen($hexCode) == 3) $hexCode = $hexCode[0] . $hexCode[0] . $hexCode[1] . $hexCode[1] . $hexCode[2] . $hexCode[2];

		$hexCode = array_map('hexdec', str_split($hexCode, 2));

		foreach ($hexCode as & $color) {
		$adjustableLimit = $adjustPercent < 0 ? $color : 255 - $color;
		$adjustAmount = ceil($adjustableLimit * $adjustPercent);
		$color = str_pad(dechex($color + $adjustAmount), 2, '0', STR_PAD_LEFT);
		}

		return '#' . implode($hexCode);
	}

}