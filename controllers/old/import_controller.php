<?php declare(strict_types=1)

class ImportController extends AppController {

	public function stats() {
		
		$not_registered = array(
			'account_type' => 'bursar',
			'limit' => false,
			'where' => ' AND u.registered = 0 '
		);

		$users = User::search($not_registered);


		unset($not_registered['where']);

		$sql = 'SELECT count(*) as total_users, d.domain ' . User::get_search_from_clause($filters) . ', domains d ';
		$sql .= User::get_search_where_clause($filters) . ' AND d.id = u.domain_id GROUP BY d.id' ;

		$user_stats = Database::query($sql)->fetch_all();


		$this->set('users', $users);
		$this->set('stats', $user_stats);


        $domains = $this->user->get_domains();
        $groups = $this->user->get_groups();

        $this->set(array(
            'domains' => array_values($domains),
            'groups' => array_values($groups)
        ));

	}

	public function resend_registration_letters() {

		$not_registered = array(
			'account_type' => 'bursar',
			'limit' => false,
			'where' => ' AND u.registered = 0 '
		);

		$users = User::search($filters);


		foreach($users as $u) {

            $mail_vars = array(
                'name' => $u['name'] .' '.$u['surname'],
                'email' => $u['email'], 
                'password' => strtolower($u['email'])
            );

            Message_template::send($u['email'], Message_template::REGISTRATION, $mail_vars);
        }

        $this->redirect('import/stats?confirmation=Invitations resent');

	}


	public function importContact() {
		//echo "doing it";

		//$databasehost = "localhost";
		//$databasename = "test";
		$databasetable1 = "contacts";
		$databasetable2 = "contact_event";
		//$databaseusername ="test";
		//$databasepassword = "";
		
		$fieldseparator = ";";
		$lineseparator = "\n";
		$csvfile = "event_guest_list_June.csv";
		/********************************/
		/* Would you like to add an ampty field at the beginning of these records?
		/* This is useful if you have a table with the first field being an auto_increment integer
		/* and the csv file does not have such as empty field before the records.
		/* Set 1 for yes and 0 for no. ATTENTION: don't set to 1 if you are not sure.
		/* This can dump data in the wrong fields if this extra field does not exist in the table
		/********************************/
		$addauto = 0;
		/********************************/
		/* Would you like to save the mysql queries in a file? If yes set $save to 1.
		/* Permission on the file should be set to 777. Either upload a sample file through ftp and
		/* change the permissions, or execute at the prompt: touch output.sql && chmod 777 output.sql
		/********************************/
		$save = 0;
		$outputfile = "output.sql";
		/********************************/


		if(!file_exists($csvfile)) {
			echo "File not found. Make sure you specified the correct path.\n";
			exit;
		}

		$file = fopen($csvfile,"r");

		if(!$file) {
			echo "Error opening data file.\n";
			exit;
		}

		$size = filesize($csvfile);

		if(!$size) {
			echo "File is empty.\n";
			exit;
		}

		$csvcontent = fread($file,$size);

		fclose($file);

		//$con = @mysqli_connect($databasehost,$databaseusername,$databasepassword) or die(mysqli_error());
		//@mysqli_select_db($databasename) or die(mysqli_error());

		$lines = 0;
		$queries = "";
		$linearray = array();

		foreach(explode($lineseparator,$csvcontent) as $line) {

			$lines++;

			$line = trim($line," \t");
			
			$line = str_replace("\r","",$line);

			
			/************************************
			This line escapes the special character. remove it if entries are already escaped in the csv file
			************************************/
			$line = str_replace("'","\'",$line);
			/*************************************/
			
			$linearray = explode($fieldseparator,$line);
			
			$fullname=$linearray[0];
			//$course=$linearray[1];
			//$institution=ucwords($linearray[2]);
			//$year=$linearray[3];
			//$donourname=ucwords($linearray[4]);
			//$donour=Database::query("SELECT id FROM donours where donour='$donourname'")->fetch() ;
			//if ($donour){
				 //echo "Donour-";
			//	 $donourid=$donour['id'] ;
			//}
			//else{
				//echo "Donour Does not exist, inserted...";
			//	$count=Database::query("SELECT count(*) FROM donours")->fetch() ;
			//	$id=$count['count(*)']+2;
		//		$insert=Database::query("insert into donours values($id,'$donourname',now(),now() )")->insert_id();
		//		if($insert){ echo $donourid=$id;}
		//	}


			$email=$linearray[1];
		//	$password=md5($email);


			$linemysql = implode("','",$linearray);
			
			if($email=="")
				//$query = "insert into $databasetable values('','$linemysql');";
				continue;
			else
				 echo $first = "insert into $databasetable1 
							values(	'',
									'1',
									'12',
									'',
									'$fullname',
									'$email',
									'',
									'',
									'',
									'',
									'0',
									'0',
									'0',
									'0',
									'',
									'',
									''
								 );";
				echo "<br>";
				
				echo $second = "insert into $databasetable2 
							values(	LAST_INSERT_ID(),
									'11',
									'',
									'',
									'',
									now(),
									'0',
									'Pending'
								 );";
				echo "<br>";
			//$queries .= $query . "\n";

			//$query="START TRANSACTION;".$first.$second."COMMIT;";
					
			//@mysqli_query($query);
			Database::query($first)->insert_id();
			Database::query($second)->insert_id();
		}

		//@mysqli_close($con);

		if($save) {
			
			if(!is_writable($outputfile)) {
				echo "File is not writable, check permissions.\n";
			}
			
			else {
				$file2 = fopen($outputfile,"w");
				
				if(!$file2) {
					echo "Error writing to the output file.\n";
				}
				else {
					fwrite($file2,$queries);
					fclose($file2);
				}
			}
			
		}

		echo "Found a total of $lines records in this csv file.\n";

		die();
	}




}


?>