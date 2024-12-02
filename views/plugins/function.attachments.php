<?php

include_once "views/plugins/function.mime_type.php";

function smarty_function_attachments($params, &$smarty) {

	$message_id = isset($params['message_id']) ? $params['message_id'] : 0;
	$attachments = Message::attachments($message_id);
	echo "<div class='attachments'>";
	foreach($attachments as $key => $value) {

		$id = md5($value['id']);
		echo "<div class='attachment'>";
			echo  smarty_function_mime_type(array('filename'=> $value['filename'],'size'=>'16'));
			echo "<a href='/message/download_attachment/{$id}'>{$value['filename']}</a>";
		echo "</div>";
	}
	echo "</div>";

}
?>