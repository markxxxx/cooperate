<?php
include_once 'framework/inflector.php';

function smarty_modifier_pluralize($string)
{
    return Inflector::pluralize($string);
}

?>
