<?php declare(strict_types=1)
class Message_template extends Model {

    const table = 'message_templates';

    const REGISTRATION = 1;
    const BIRTHDAY = 2;
    const TASKS = 3;
    const PROJECT_ASSIGN = 4;
    const INT_APPOINTMENT = 5;
    const EXT_APPOINTMENT = 6;
    const ADMIN_MESSAGE_NOTIFY = 7;
    const ADMIN_MESSAGE_REPLY = 8;
    const QUOTE_CREATED = 9;
    const INVOICE_CREATED = 10;
    const STATUS_NEW = 11;
    const STATUS_DECLINED = 12;
    const STATUS_ACCEPTED = 13;
    const STATUS_COMPLETE = 14;

    const CUSTOM_INVITE = 20;

    static $instance_cache = array();	

	
	public $validate = array(
        'not_null' 	=> array('name','title','message'),		
		'number' => array('id')
    );


    public static function send_custom($email, $id = 0, $variables=array()) {



        // $to = $email;
        // $from = "Administrator <admin@admin.com>";
        // $subject = "We would like you to join us for a this event";

        // $mail = SendMail::getInstance();

        // $name =  explode(' ', $variables['name']);
        // $name = $name[0];      


        // $message = "<p>


        // <p>Dear {$name}</p>

        // <p>Thank you.<br />
        // <br />
        // Please take a minute to watch this brief video on our Program following last year's event: <a href='https://www.youtube.com/watch?v=waTQGyALttg'>https://www.youtube.com/watch?v=waTQGyALttg</a><br />
        // <br />
        // Be well and prosper.<br />
        // <br />
        // Please join us for breakfast. <br />
        // <br />
        // Warm regards,<br />
        // <br />
        // Company Administrator<br />
        // <br />
        // Job title</p>


        // <a href='{$variables['event_url']}'>Please click here to RSVP to this event.</a>

        // <br /><br />

        // </p>";

        // $mail->ClearAllRecipients();
        // $mail->AddAddress($to, $variables['name']);
        // $mail->SetFrom('noreply@test.co.za', 'Test Administrator');
        // $mail->AddReplyTo($to, $variables['name']);
        // $mail->Subject = $subject;
        // $mail->AddAttachment("reminder.ics"); 
        // $mail->MsgHTML($message);
        //$mail->Send();


    }

    public static function send($email, $id = 0, $variables=array(),$attachment=null) {

        if(Message_template::CUSTOM_INVITE == $id) {

            Message_template::send_custom($email, $id = 0, $variables);
            return false;
        }
      
        if(!isset(Message_template::$instance_cache[$id])) {
            $message =  Message_template::find("id = '{$id}' ")->fetch();
            if($message) {
            	Message_template::$instance_cache[$id] = $message;
            } else {
            	$message['title'] = '{title}';
                $message['message'] ='{message}';

            }
        } else {
        	$message = Message_template::$instance_cache[$id];
        }
        
        $replacements = array();
        
        foreach($variables as $key => $value) {
            $replacements['{'.$key.'}'] = $value;
        }
        
        $subject = escape(strtr($message['title'], $replacements));
        $message = escape(strtr($message['message'], $replacements));
        

        $sql = "INSERT INTO message_cron(email,subject,body,attachment) VALUES('{$email}','{$subject}', '{$message}', '{$attachment}')";

        Database::query($sql);
        return true;
    }



}
?>