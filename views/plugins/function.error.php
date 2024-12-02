<?php
include_once 'framework/inflector.php';

 function smarty_function_error($params, &$smarty) {
    
    $error_template = '<font color="red">%s</font>';
    
    extract($params);

    if(isset($params['message'])) {
        printf($error_template , $params['message']);
    }
    
    if(!is_array($smarty->_tpl_vars['validation_errors']))
        return false;
    
    if(array_key_exists($field,$smarty->_tpl_vars['validation_errors'])) {

        if(!isset($message)) {
        
            $display_field = Inflector::humanize($field);
            switch($smarty->_tpl_vars['validation_errors'][$field]) {
                case 'not_null':
                    printf($error_template ,"{$display_field} cannot be empty");
                break;
                case 'url':
                    printf($error_template ,"{$display_field} is not a valid url");
                break;
                case 'email':
                    printf($error_template ,"Please provide us with a proper email");
                break;
				case 'number':
                    printf($error_template ,"{$display_field} can only be numeric");
                break;
                case 'unique':
                    printf($error_template ,"{$display_field} has to be unique");
                break;
				
				case 'length':
					if(isset($eqaul))
						printf($error_template ,"{$display_field} has to be 10 character in length");
                break;
	
            }
            
        } else {
             print_f($error_template ,$message);
        }
    }
}

?>
