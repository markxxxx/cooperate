<?php

class MiscController extends AppController {


    public function download_csv() {
    
        ini_set('memory_limit', '300M');
        $fields = array('name', 'surname', 'email', 'cellnumber', 'institute', 'status');
        $_GET['show_all'] = 1;
        $users =  User::search($_GET);
        $users = $users['users'];

        foreach($users as $user) {
            foreach($user as $field => $value) {

                if(in_array($field, $fields)) {
                    $csv .= "{$value},";
                }
            }
            $csv = rtrim($csv, ',');
            $csv .="\n";
        }

        array_walk($fields, function(&$field) {  $field = ucfirst($field);} );
        
        $csv = implode(',', $fields)."\n" . $csv;

        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=cv_application_database_users.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo $csv;
        exit();
        
    }

    public function download_application($id_string = false ) {
        
        if($id_string == false) {
            echo "No users were selected";
            exit();
        }
        
        if(is_numeric($id_string)) {
            $id_array = array($id_string);
        } else {
            $id_array = explode(',', $id_string);
        }     
        
        include_once 'controllers/user_controller.php';
        $user_controller = new UserController();
        $user_controller->before_action();
        
        
        $zip = new ZipArchive;
    
        $filename = "media/applications.zip";
        $zip->open($filename, ZipArchive::OVERWRITE);
        
        $files_to_delete = array();

        foreach($id_array as $id) {
        
            $temp_user = new User($id);

            $folder_name = strtolower($temp_user->name . '-'. $temp_user->surname);
            $temp_filename = '/tmp/'.$folder_name.'.docx';
            
            $user_controller->export($id, 'word');
            file_put_contents($temp_filename, parse_template('app','user_export',array()));
            
            $files_to_delete[] = $temp_filename;
            
            $zip->addEmptyDir($folder_name);
            $zip->addFile($temp_filename, $folder_name.'/application.doc');
            //unlink($temp_filename);
            
            $rs = Document::find("user_id = {$temp_user->id}");
            
            while($row = $rs->fetch()) {
            
                $ext = array_pop(explode('.',$row['file']));
                $to_add = 'media/documents/'.$row['file'];
                if(file_exists($to_add)) {
                    $zip->addFile($to_add, $folder_name.'/'.slug($row['description']).'.'.$ext);
                }
            }
        }
        $zip->close();
        
        foreach($files_to_delete as $file) {
            unlink($file);
        }
        
        header("location: /{$filename}");
   
    }
}

?>