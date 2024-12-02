<?php
function smarty_modifier_money($dick_format) { 
	return number_format($dick_format, 2, ',', ' ');
}
?>