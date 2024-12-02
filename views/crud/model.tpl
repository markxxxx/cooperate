<?php
class {$meta.class} extends Model {ldelim}
	
	const table = '{$meta.table}';
	
	public $validate = array(
        'not_null' 	=> array({section name=inst loop=$relations}'{$relations[inst].lower}_id'{if $smarty.section.inst.last neq true},{/if}{/section}){if $int_validation neq false},{/if}
		
{if $int_validation neq false}
		'number' => array({$int_validation})
{/if}
    );
{rdelim}
?>