<?php

function smarty_modifier_php_strip($string, $tags = '<br><a><p>')
{
    return strip_tags($string, $tags);
}

?>
