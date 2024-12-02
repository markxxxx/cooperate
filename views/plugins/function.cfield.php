<?php
include_once 'framework/inflector.php';
function smarty_function_cfield($params){

    $field = isset($params['field']) ? $params['field'] : Error('smarty_function_pager', 'param `field` required');
	$value = array_key_exists('value', $params) ? $params['value'] : Error('smarty_function_pager', 'param `value` required');
    $title = array_key_exists('title', $params) ? $params['title'] : '';
    $name = array_key_exists('name', $params) ? "name='{$params['name']}'" : "name='data[{$field}]'";


	if(($values = Field::get($field)) !== false) {
		$human_field = strlen($title) ? $title : Inflector::humanize($field);
		echo "<select id='field-{$field}' {$name} ><option value=''>Select:</option>";
		foreach($values as $v) {

			if($v == $value) {
				$selected = 'selected';
			} else {
				$selected = '';
			}
			echo "<option {$selected} value='{$v}'>{$v}</option>";
		}
		echo "</select>";
		
	} else {
		Error('smarty_function_pager', "Custom field: {$field} not found");
	}
}
?>