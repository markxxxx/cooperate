<?php declare(strict_types=1)

class Attachment extends AppModel {

	const table = 'attachments';

	private $attachments = array();

	public static function getInstance($id=0) {

		$obj = parent::getInstance($id);

		if(isset($_SESSION['attachments'])) {
			$obj->attachments = $_SESSION['attachments']; 
		}
		return $obj;
	}

	public static function add_attachment($attachment_id) {
		$_this = Attachment::getInstance(0);
		$_this->attachments[] = $attachment_id;
		$_SESSION['attachments'] = $_this->attachments;

	}

	public static function attachments_count() {
		$_this = Attachment::getInstance(0);
		return count($_this->attachments);
	}

	public static function reset() {
		$_this = Attachment::getInstance(0);
		$_this->attachments = array();
		$_SESSION['attachments'] = $_this->attachments;
	}

	public static function add_to_message($message_id) {
		$_this = Attachment::getInstance(0);

		if(!Attachment::attachments_count()) {
			return false;
		}
		foreach($_this->attachments as $a) {
			$sql = "INSERT INTO message_attachment(message_id,attachment_id) VALUES('{$message_id}','{$a}')";
			Database::query($sql);

		}
	}

	public function instant_by_hash($hash) {

		$sql = "SELECT * FROM attachments WHERE md5(id) = '{$hash}'";
		$rs = Database::query($sql)->fetch();

		if($rs !== false) {
			return Attachment::map($rs);
		} else {
			return new Attachment(0);
		}
	}

	public static function received_attachments($user_id) {

		$sql = "SELECT a.filename, m.created_on , a.id
				FROM messages m, attachments a , message_attachment ma
				WHERE m.id = ma.message_id 
				AND a.id = ma.attachment_id
				AND m.recipient_id = '{$user_id}' ";

		return Database::query($sql)->fetch_all();
	}

	public static function send_attachments($user_id) {
		
		$sql = "SELECT a.filename, m.created_on , a.id
				FROM messages m, attachments a , message_attachment ma
				WHERE m.id = ma.message_id 
				AND a.id = ma.attachment_id
				AND m.sender_id = '{$user_id}' ";

		return Database::query($sql)->fetch_all();

	}

}

