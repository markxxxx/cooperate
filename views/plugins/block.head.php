<?php

function smarty_block_head($params, $content, &$smarty, &$repeat){
    if ( empty($content) ) {
        return;
    }
    return '@@@SMARTY:HEAD:BEGIN@@@'.trim($content).'@@@SMARTY:HEAD:END@@@';
}
?>