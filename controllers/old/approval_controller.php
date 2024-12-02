<?php declare(strict_types=1)
class ApprovalController extends AppController {

	private function can_approve($approval_id) {

		if(!$this->user->can_approve()) {
			$this->redirect();
		}

		if(!$approval_id) {
			$this->redirect();
		}

		$approval = new Approval($approval_id);

		if(!$approval->id) {
			$this->redirect();
		}

		if($approval->domain_id <> 0) {
			if(!in_array($approval->domain_id, array_keys($this->user->get_domains()))) {
				$this->redirect();
			}
		}

		return $approval;
	}

	public function reason($approval_id = 0) {

		$approval = new Approval($approval_id);

		if(!$approval->id) {
			$this->redirect();
		}

		$this->set('data', $approval->to_array());
		$this->set('approval_title', $approval->get_object()->get_title());
		
		//users who can approve the changes
		if($approval->domain_id <> 0) {

			$admins = Domain::getInstance($approval->domain_id)->get_admins(
				" AND g.approve_changes = 1 "
			);

		} else {
			$sql = "SELECT u.* FROM users u, groups g 
					WHERE u.group_id = g.id
					AND g.approve_changes = 1";
			
			$admins = Database::query($sql)->fetch_all();
		}

		$this->set('admins', $admins);


		if(isset($_POST['reason'])) {
			
			if(strlen($_POST['reason'])) {
				$approval->update_attributes(array(
					'reason' => $_POST['reason']
				));

				unset($_SESSION['approve']);

				if(isset($_GET['redirect']) && strlen(trim($_GET['redirect']))) {
					$this->redirect(urldecode($_GET['redirect']));
				}
			} else {
				$this->template->error('reason', 'not_null');
			}
		}

	}

	public function approve($approval_id , $approve = 0) {

		$approval = $this->can_approve($approval_id);

		$updates = array();
		if($approve) {
			$updates['status'] = 'approved';
		} else {
			$updates['status'] = 'not_approved';
			$updates['not_approved_reason'] = $_POST['reason'];
		}

		$approval->update_attributes($updates);
		$this->redirect("/user/home?success=Approval changes made!");

	}

	public function view($approval_id) {

		$approval = $this->can_approve($approval_id);
 
		//users who can approve the changes
		if($approval->domain_id <> 0) {

			$admins = Domain::getInstance($approval->domain_id)->get_admins(
				" AND g.approve_changes = 1 "
			);

		} else {
			$sql = "SELECT u.* FROM users u, groups g 
					WHERE u.group_id = g.id
					AND g.approve_changes = 1";
			
			$admins = Database::query($sql)->fetch_all();
		}

		$owner = new User($approval->created_by);
		$approval->changes = unserialize(strip($approval->changes));

		$this->set('owner', $owner);
		$this->set('admins', $admins);
		$this->set('object', $approval->get_object()->to_array());
		$this->set('approval', $approval->to_array());

	}
	
}
?>