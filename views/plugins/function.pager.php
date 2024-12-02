<?php
function smarty_function_pager($params) {
    
    $url = isset($params['url']) ? $params['url'] : Error('smarty_function_pager','param `url` Required');
    $total_rows = isset($params['total_rows']) ? $params['total_rows'] : Error('smarty_function_pager', 'param `total_rows` required');
    $per_page = isset($params['per_page']) ? $params['per_page'] : Error('smarty_function_pager', 'param `per_page` required');
    $current_page = isset($params['current_page']) ? $params['current_page'] : Error('smarty_function_pager', 'current_page `per_page` required');
    
    $get_url = '?';
    foreach($_GET as $key => $value) {
        if(is_string($value)) {
            if(strlen($key) && strlen($value)) {
                $get_url .= "{$key}={$value}&";
            }
        }
    }
    
    if(strlen($get_url) == 1) {
        $get_url = '';
    } else {
        $get_url = rtrim($get_url, '&');
    }
    
    $next = false;
    
    if( (($current_page + 1) * $per_page)  < $total_rows) {
        $next = true;
    } else {
        
    }
	
	if($current_page == 0 && $next == false) {
		return false;
	}
    
    $last = true;
    
    if($current_page ==  0) {
        $last = false;
    }
    
    $prev_page = $current_page - 1;
    $next_page = $current_page + 1;
    
    echo "<div class='small' style='text-align: center; padding-bottom: 10px;'>";
    
    if($last) {
        echo "<a class='pager' style='display:inline' href='/{$url}/{$prev_page}{$get_url}'>&#171; Last Page</a>";
    } else {
        echo "&#171; Last Page ";
    }
    
    if($next) {
        $showing = ($per_page * $current_page) . '-' .($per_page * $next_page) ;
    } else {
        $showing = ($per_page * $current_page) . '-' .$total_rows ;
    }
    
    
    echo " &nbsp;|&nbsp;&nbsp;";
    echo " viewing {$showing} of {$total_rows}";
    echo " &nbsp;&nbsp;|&nbsp;";
    
    if($next) {
        echo "<a class='pager' style='display:inline' href='/{$url}/{$next_page}{$get_url}'>Next Page &#187</a>";
    } else {
        echo "Next Page &#187";
    }
    
    echo "</div>";
}
?>