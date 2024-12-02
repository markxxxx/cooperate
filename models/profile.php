<?php declare(strict_types=1)
class Profile extends AppModel {
	
	const table = 'profiles';
	
	public $validate = array(
        'not_null' 	=> array('salutation', 'title', 'id_num', 'id_type', 'race', 'nationality', 'marital_status', 'gender', 'first_language', 'uni_address', 'home_address', 'address_to_use','bank', 'bank_acc', 'bank_branch','bank_branch_name','passport','hobbies','awards','account_type'),
		'email' => array('uni_email'),
		'length' => array(
			'uni_cell'=> array('equal' => 10),
			'home_landline' => array('equal' => 10)			
		),
		'number' => array('uni_cell', 'home_landline'),

    );

    public function get_title() {
    	if(!$this->id) {return false;}
    	return User::getInstance($this->user_id)->get_title();
    }
	
	public function validate($form = false) {
		
		if($form === false) {
			return parent::validate();
		}
		
		switch($form) {
			case '0': #personal
				$remove = array('not_null' => array(
					'bank', 'bank_acc', 'bank_branch_name', 'bank_branch','account_type',
					'uni_address', 'uni_cell', 'home_address', 'bank', 'address_to_use',
					'hobbies','activities','awards'
					)
				);
				unset($this->validate['length'], $this->validate['number'], $this->validate['email']);
				$this->validate['number'] = array('cell_number');
				$this->validate['length'] = array('cell_number' => array('equal' => 10));
				
			break;
			case '1': #contact
				$remove = array('not_null' => array(
					'initial', 'salutation', 'title', 'id_num', 'id_type', 
					'race', 'nationality', 'marital_status', 'gender', 'first_language',
					'bank', 'bank_acc', 'bank_branch_name','bank_branch','drivers','passport','bank_branch','account_type',
					'hobbies','activities','awards'
					)
				);
						
			break;
			case '2':#banking
				$remove = array('not_null' => array(
					'initial', 'salutation', 'title', 'id_num', 'id_type', 
					'race', 'nationality', 'marital_status', 'gender', 'first_language',
					'uni_address', 'uni_cell', 'home_address', 'address_to_use','drivers','passport',
					'hobbies','activities','awards'
					)
				);
				unset($this->validate['length'], $this->validate['number'], $this->validate['email']);
			break;
			case '3':#more about yourself
				$remove = array('not_null' => array(
					'initial', 'salutation', 'title', 'id_num', 'id_type', 
					'race', 'nationality', 'marital_status', 'gender', 'first_language',
					'uni_address', 'uni_cell', 'home_address', 'address_to_use','drivers','passport',
					'bank', 'bank_acc', 'bank_branch_name', 'bank_branch','account_type'
					)
				);
				
				$this->add_validation('family_background','not_null');
				$this->add_validation('volunteer','not_null');
				$this->add_validation('medical','not_null');

				

				unset($this->validate['length'], $this->validate['number'], $this->validate['email']);
			break;
			case '4':#social
				$this->validate = array();
				$this->validate['url'] = array('facebook_url','twitter_url','linkedin_url');
			break;
		}
		
		if(isset($remove)) {
			foreach($remove as $vaidation_type => $values) {
				foreach($values as $field) {
					$this->remove_validation($field, $vaidation_type);
				}
			}
		}

		return parent::validate();
	
	}
	
}
?>

