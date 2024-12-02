<?php
include_once 'views/plugins/modifier.money.php';
function smarty_function_array_total($params){

    $field = isset($params['field']) ? $params['field'] : Error('smarty_function_pager', 'param `field` required');
	$values = array_key_exists('data', $params) ? $params['data'] : Error('smarty_function_pager', 'param `value` required');

	$total = 0;

	foreach($values as $v) {
		$total += $v[$field];
	}

	return smarty_modifier_money($total);
}
?>