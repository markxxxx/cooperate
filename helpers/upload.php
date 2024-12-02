<?php


class Upload {

    private $files = array();
	public $last_error = '';
    
    public function __construct($file) {
        $this->files = $file;
    }
    
    
    public function do_upload($uploadpath='media/temp/',$newname=false,$allowed=array(), $maxsize=0) {

        if($this->files['name'] == '') return false;

        $ext = strtolower(substr(strrchr($this->files['name'], '.'), 1));
        if(!in_array($ext,$allowed) && count($allowed) ) {
			$this->last_error = 'File not allowed expected('.implode(',',$allowed) .')';
            return false;
        }
        
        if(count($this->files) > 1) {
			if($this->files['size'] != 0) {
                if($maxsize) {
                    if($this->files['size'] > $maxsize * 1000 * 1024) {
						$this->last_error = 'Uploaded file exceed max upload size('. $maxsize .')';
                        return false;
					}
                }
                if(!is_dir($uploadpath))
                    mkdir($uploadpath);
                if($newname)
                    $uploadto = $uploadpath.$newname.'.'.$ext;
                else
                    $uploadto = $uploadpath.$this->files['name'];
                $uploadto = strtolower($uploadto);

                if(move_uploaded_file($this->files['tmp_name'], $uploadto)) {
                    return $uploadto;
                } else {
					$this->last_error = 'Permission Denied in'. $uploadto;
					return false;
                }
            }
        }
    }
    
}




?>