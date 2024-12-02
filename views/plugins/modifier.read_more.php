<?php
function smarty_modifier_read_more($string,$limit=100)
{
    $string = strip_tags($string);
    
    $len = strlen($string);
    
    if(($len) < $limit+20) {
        echo $string;
        return ;
    }
    
    for($i = $limit; $i < $len; $i++) {
        if($string[$i] == ' ') {
            break;
        }
    }
    
    $newstring=substr_replace($string, " <a href='#' class='read_more'>More...</a><span style='display:none'> ", $i, 0);
    echo $newstring . '</span>';
    
}
?>
