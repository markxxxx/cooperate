<?php
class SettingController extends AppController {

	private $per_page = 100;

	public function test() {

		$error = false;
    	$setting = new Setting();

    	if(!strlen($_POST['data']['password'])) {
    		unset($_POST['data']['password']);
    	}

    	$setting->update_map($_POST['data']);

		$mbox = @imap_open(Setting::inbox_email_connection_url($setting->imap_server), $setting->email, $setting->password)
		or ($error = true);
		echo json_encode($error);
		die();
	}

	public function delete($setting_id) {

		$setting = new setting($setting_id);
		if(!$setting->id && $setting_id) {
			$this->redirect("setting");
		}

		if($setting->user_id != $this->user->id) {
			$this->redirect("setting?permission=owner");
		}

		$setting->destroy();

		$this->redirect("setting?confirmation=The email sync setting has been removed");



	}

	public function index() {
		$this->set('settings', Setting::find(" user_id = {$this->user->id}")->fetch_all());
	}
	
	public function add($setting_id = 0) {

		$setting = new setting($setting_id);
		if(!$setting->id && $setting_id) {
			$this->redirect("setting");
		}
       
        if(array_key_exists('data', $_POST)) {

			if(md5($_POST['data']['site_password']) != $this->user->password) {
				$this->redirect('setting/add?error=1');
			}

            $setting->update_map($_POST['data']);
            
            $setting->user_id = $this->user->id;

            if( $setting->validate() ) {
				if(!$setting->id) {
					$setting->insert();
				} else {
					$setting->update();
				}

                $this->redirect('setting/index?success=1');
            } else {
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);
            }

        } else {
            $this->set('data', $setting->to_array());
        }
	}
	


}
?>