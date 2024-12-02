<?php

function smarty_modifier_seconds_to_time($seconds) {
    $hours = floor($seconds / (60 * 60));
 
    // extract minutes
    $divisor_for_minutes = $seconds % (60 * 60);
    $minutes = floor($divisor_for_minutes / 60);
 
    // extract the remaining seconds
    $divisor_for_seconds = $divisor_for_minutes % 60;
    $seconds = ceil($divisor_for_seconds);
 
    // return the final array
    $obj = array(
        "h" => (int) $hours,
        "m" => (int) $minutes,
        "s" => (int) $seconds,
    );

    $return = '';

    if($obj['h'] != 0) {
        $return .= $obj['h'] .' Hours';
    } 

    if($obj['m'] != 0) {
        $return .= $obj['m'] .' Minutes';
    }

    if($obj['s'] != 0) {
        $return .= $obj['s'] .' Seconds';
    }



    return $return;
}
?>