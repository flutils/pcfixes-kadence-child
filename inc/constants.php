<?php

//////////////////////////
//////////////////////////

// RPECK 19/07/2023 - Constants
// These are immutable constants defined at the head of the app
// --
// The main reason for this was to separate the apply_filters logic from constants

//////////////////////////
//////////////////////////

// RPECK 19/07/2023 - Var
// This is used to mass declare the different constants before defining them
$constants = array(
    'KADENCE_CHILD_TEXT_DOMAIN' => 'kadence-child-theme'
);

// RPECK 19/07/2023 - ForEach
// This will loop through the constants variable outlined above and will allow us to access these constants inside our system
foreach($constants as $key => $value) {
    if(!defined($key)) define($key, $value);
}