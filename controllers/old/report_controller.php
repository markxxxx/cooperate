<?php

class ReportController extends AppController {

    private $domain_id = 0,
    		$domain_id_guess = 0;

    public function index() {

        $this->set(array(
            'domains'       => array_values($this->user->get_domains()),
            'universities'  => Field::get('university'),
            'study_years'   => Field::get('year_of_study'),
            'user_count'    => User::search_count(),
            'groups'        => array_values($this->user->get_group_bursars()),
            'years'         => Payment::get_years()
        ));
    }

    public function letter($fake_post = false) {

        $this->set(array(
            'domains'       => array_values($this->user->get_domains()),
            'universities'  => Field::get('university'),
            'study_years'   => Field::get('year_of_study'),
            'user_count'    => User::search_count(),
            'groups'        => array_values($this->user->get_group_bursars()),
            'years'         => Letter::get_years(),
            'user_count'    => Letter::search_count()
        ));

        if($fake_post) {
            
            header("Content-type: application/vnd.ms-word");
            header("Content-Disposition: attachment;Filename=Letters to Martin.doc");
            echo "<html>";
            echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\"><body>";

            if($_POST['year'] <> '-1') {
                $_POST['where'] = " l.letter_date = {$_POST['year']} ";
            }

            $letters = Letter::search($_POST);

            foreach($letters as $letter) {

                echo "<h1>{$letter['letter_date']}:{$letter['name']} {$letter['suname']}</h1>";
                echo "<p>{$letter['letter']}</p><br /><br />";

            }
            echo "</body>";
            exit();
        }
    }


    public function letter_count() {
        

        $_POST['account_type'] = 'bursar';
        $_POST['limit'] = false;


        echo json_encode(array(
            'total_users' => Letter::search_count($_POST)
        ));


        exit();
    }


    public function supplier($supplier_id=0) {


        $supplier = new Supplier($supplier_id);
        if(!$supplier->id ) {
            exit('no - supplier');
        }
        
        $year_text = "";


        $where = Payment::get_search_where_clause();

        $sql = "SELECT u.id, concat(u.name,' ',u.surname) as full_name , u.last_seen
                FROM users u
                    LEFT JOIN 
                scholarships s ON u.id = s.user_id, groups g , payments p,  user_payment up 
                {$where}
                AND u.id = up.user_id
                AND p.id = up.payment_id
                AND up.supplier_id = '{$supplier_id}'
                GROUP BY u.id";

        $raw_users = Database::query($sql)->fetch_all();

        $references = array();
        $payment_names = array();
        
        foreach($raw_users as &$u) {
            
            $payments = Payment::user_log($u['id'], -1, $supplier_id);
            foreach($payments as $p) {
            
                $ref_name = $p['reference2'] ? $p['reference']. '-'.$p['reference2'] : $p['reference'];
                //$payment_name = $p['name'].' '.date('j,M', strtotime($p['created_on']));
                $payment_name = date('F , j', strtotime($p['created_on']));
                
                if(!in_array($ref_name , $references)) {
                    $references[] = $ref_name;
                }
                
                if(!in_array($payment_name , $payment_names)) {
                    $payment_names[] = $payment_name;
                }
            }
            
            $u['payments'] = $payments;
            $u['payment_names'] = $payment_names;
        }
        
        foreach($raw_users as &$u) {
            
            $years = array(); 
            
            foreach($u['payments'] as $p) {
                if(!in_array($p['year'] , $years)) {
                    $years[] = $p['year'];
                }
            }
           
            $formated_step_2 = array();
            
            foreach($years as $y)  {
                foreach($references as $r) {
                    $formated_step_2[$y]['payment_ref'][$r] = 0;
                }
                foreach($payment_names as $p) {
                    $formated_step_2[$y]['payment_name'][$p] = 0;
                }
            }
            
            
            foreach($u['payments'] as $p)  {
                $payment_name = date('F , j', strtotime($p['created_on']));
                $formated_step_2[$p['year']]['payment_name'][$payment_name] += $p['amount'];
            }
            
            foreach($u['payments'] as $p)  {
                $ref_name = $p['reference2'] ? $p['reference']. '-'.$p['reference2'] : $p['reference'];
                $formated_step_2[$p['year']]['payment_ref'][$ref_name] += $p['amount'];
            }
            

            $u['payments'] = $formated_step_2;
            $u['scholarship'] = User::get_scholarship_info($u['id']);
            $u['payment_logs'] = array();
        }

        function to_co_ord($row,$col) {
            return chr($col+65).$row;
        }

        $domain = new Domain($this->user->current_domain());

        
        include('include/PHPExcel.php');

        $objPHPExcel = new PHPExcel;
        
        $objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
        $objPHPExcel->getDefaultStyle()->getFont()->setSize(9);
        //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
        
        $currencyFormat = '#,#0.## \R;[Red]-#,#0.## \R';
        $numberFormat = '#,#0.##;[Red]-#,#0.##';
        
        $objSheet = $objPHPExcel->getActiveSheet();
        
        $objSheet->getCell("A7")->setValue($supplier->supplier. ' Report');
        $objSheet->getStyle("A7")->applyFromArray(array('font' => array( 'size'  => 13, 'bold' => true )));
        
        
        $objSheet->getCell("A8")->setValue( $year_text );
        $objSheet->getStyle("A8")->applyFromArray(array('font' => array( 'size'  => 13, 'bold' => true )));
        
       
        
        /*
         'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb'=>'bfbfbf'),
         ),*/
        
       /* 
        $logo = new PHPExcel_Worksheet_Drawing();
        $logo->setName('test_img');
        $logo->setDescription('test_img');
        $logo->setPath('./media/logo.jpg');
        $logo->setCoordinates('F2');
        $logo->setWorksheet($objPHPExcel->getActiveSheet());
        
        if(strlen($domain->image)) {
            $logo = new PHPExcel_Worksheet_Drawing();
            $logo->setName($domain->domain);
            $logo->setDescription($domain->domain);
            $logo->setPath('./media/domains/'.$domain->image);
            $logo->setCoordinates('A2');
            $logo->setWorksheet($objPHPExcel->getActiveSheet());
        }*/
        
        
        
        $objSheet->setTitle($domain->domain . ' Report');
        
        
        $col = 3;
        $row = 12;
        
        $header_index_left = 3;
        $header_index_right = count($payment_names);
        
        $default_border = array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb'=>'000000')
        );
        
        $thick_border = array(
                'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                'color' => array('rgb'=>'000000')
        );
        
        
        $style_header = array(        
                /*          
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb'=>'bfbfbf'),
            ),*/
           
            'font' => array(
                'bold' => true,
                'size'  => 10.5,

            ),
            'borders' => array( 'bottom' => $thick_border, 'left' => $default_border, 'top' => $thick_border, 'right' =>  $thick_border ),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
        );
        
        $body_style = array(
            'font' => array( 'size'  => 11),
            'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb'=>'dce6f1'))
        );
        
        $footer_style = array(
            'font' => array( 'size'  => 11, 'bold' => true ),
            'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb'=>'EFEFEF')),
            'borders' => array( 'bottom' => $default_border, 'left' => $default_border, 'top' => $default_border, 'right' => $default_border )
        );
        
        $payment_style = array(
            'font' => array( 'size'  => 11, 'bold' => true , 'color' => array('rgb' => 'FFFFFF')),
            'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb'=>'ec6d1c')),
            'borders' => array( 'bottom' => $default_border, 'left' => $default_border, 'top' => $default_border, 'right' => $default_border )
        );
        
        
        $header = $objSheet->getStyle(to_co_ord($row ,$col - $header_index_left).':'.to_co_ord($row,$col+count($references)+$header_index_right));
        $header->applyFromArray($style_header);
        
        for($i = 65;$i < 85; $i++) {
            $char = chr($i);
            $objPHPExcel->getActiveSheet()->getColumnDimension($char)->setWidth(23);
        }
        
        $objSheet->getCell(to_co_ord($row  , $col - 1 ))->setValue('Student');
        $objSheet->getCell(to_co_ord($row  , $col - 2 ))->setValue('Financial year');
        $objSheet->getCell(to_co_ord($row  , $col - 3 ))->setValue('Institute');

        
        $objSheet->getCell(to_co_ord($row  , $col+count($references) ))->setValue('Total');
        
        for($i = 0,$cnt = count($references); $i < $cnt; $i++) {
            $objSheet->getCell(to_co_ord($row  , $col +$i ))->setValue($references[$i]);
            

        }
        
        for($b = 0 , $index = $i + 1; $b < count($payment_names); $b++ ) {
            $objSheet->getCell(to_co_ord($row  , $col + $index+$b ))->setValue($payment_names[$b]);
        }

       // ++$row;
        
        $header = $objSheet->getStyle(to_co_ord($row ,$col - $header_index_left).':'.to_co_ord($row,$col+count($references)+$header_index_right));
       
        
       // $header->applyFromArray(array( 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb'=>'dce6f1'))));
        
        ++$row;
        
        $start_row = $row;
        
        $v_total = array();
        foreach($raw_users as $user) {
            foreach($user['payments'] as $actual_year => $year) {
                
                $i=0;
                $h_total = 0;
                
                foreach($year['payment_ref'] as $key => $values) {
                    $objSheet->getCell(to_co_ord($row  , $col + $i  ))->setValue($values);
                    
                    if($values) {
                        $objSheet->getStyle(to_co_ord($row  , $col + $i ))->getNumberFormat()->setFormatCode("R #.##00");
                    }
                    
                    $v_total[$i] += $values;
                    $i++;
                    $h_total += $values;
                }
                $objSheet->getCell(to_co_ord($row  , $col + $i  ))->setValue($h_total );
                
                $h_total = 0;
                $b = 0;
                foreach($year['payment_name'] as $key => $values) {
                    $objSheet->getCell(to_co_ord($row  , $col + $i  + 1 ))->setValue($values);
                    if($values) {
                        $objSheet->getStyle(to_co_ord($row  , $col + $i  + 1 ))->getNumberFormat()->setFormatCode("R #.##00");
                    }
                    $p_total[$b] += $values;
                    $i++;
                    $b++;
                    //$h_total += $values;
                }
                //$objSheet->getCell(to_co_ord($row  , $col + $i   ))->setValue($h_total );

                $objSheet->getCell(to_co_ord($row  , $col -1  ))->setValue($user['full_name'] );
                $objSheet->getCell(to_co_ord($row  , $col -2  ))->setValue($actual_year );
                $objSheet->getCell(to_co_ord($row  , $col -3  ))->setValue($user['scholarship']['university']);
                
                ++$row;
                
            }
        }
        
        $objSheet->getCell(to_co_ord($start_row - 2  , $header_index_left + count($references) + 1))->setValue('Payments');
        
        $objSheet->getStyle(to_co_ord($start_row - 2  , $header_index_left + count($references)  + 1))
                    ->applyFromArray($payment_style)
                    ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        
        if(count($payment_names) != 1) {
            //echo to_co_ord($start_row - 3  , $header_index_left + count($references) + 1) , to_co_ord($start_row - 1  , $header_index_left + count($references)) + count($payment_names)+1)
            //echo to_co_ord($start_row - 3  , $header_index_left + count($references) + 1) .':'. to_co_ord($start_row - 1  , $header_index_left + count($references) + count($payment_names)+1);
            //$objSheet->mergeCells(to_co_ord($start_row - 3  , $header_index_left + count($references) + 1) .':'. to_co_ord($start_row - 1  , $header_index_left + count($references) + count($payment_names)+1));
        }
        
        for($i = $start_row; $i < $row; $i++) {
            $objSheet->getStyle(to_co_ord($i  , $col -$header_index_left   ).':'. to_co_ord($i  , $col+count($references)+$header_index_right  ))->applyFromArray( $body_style);
            //$objSheet->getStyle(to_co_ord($i  , $col -$header_index_left   ).':'. to_co_ord($i  , $col+count($references)+$header_index_right  ))->getNumberFormat()->setFormatCode("R #.##00");
            
        }
        
        $objSheet->getCell(to_co_ord($row  , $col - 1  ))->setValue('Total');
        
        for($i = 0,$cnt = count($v_total); $i < $cnt; $i++) {
            $objSheet->getCell(to_co_ord($row  , $col + $i  ))->setValue($v_total[$i]);
            $objSheet->getStyle(to_co_ord($row  , $col + $i ))->getNumberFormat()->setFormatCode("R #.##00");
        }

        $objSheet->getStyle(to_co_ord($row  , $col -$header_index_left   ).':'. to_co_ord($row  , $col+count($references)+$header_index_right  ))->applyFromArray( $footer_style );
      
        $objSheet->getCell(to_co_ord($row  , $col + $i  ))->setValue(array_sum($v_total));
        $objSheet->getStyle(to_co_ord($row  , $col + $i ))->getNumberFormat()->setFormatCode("R #.##00");
        $i++;
        
        for($b = 0,$cnt = count($p_total); $b < $cnt; $b++) {
            $objSheet->getCell(to_co_ord($row  , $col + $i + $b  ))->setValue($p_total[$b]);
            $objSheet->getStyle(to_co_ord($row  ,  $col + $i + $b ))->getNumberFormat()->setFormatCode("R #.##00");
        }


        $objWriter = new PHPExcel_Writer_Excel2007 ($objPHPExcel);

        $objWriter->save("media/{$supplier->supplier}.xls");
        header("location: /media/{$supplier->supplier}.xls");
        
        exit();

                
    }
    
    public function generate() {
        
        ini_set("memory_limit","1024M");
        $where = "AND 1 = 1 ";
        
        if(isset($_POST['users'])) {
            foreach($_POST['users'] as $u) {
                $users .= "'{$u}',";
            }
            $users = rtrim($users, ',');
            $where = " AND u.id in ($users)";
            
        } else {
            $where = ' AND '. ltrim(Payment::get_search_where_clause($_POST),' WHERE');
        }

        $year_text = "All years";
        if($_POST['year'] != '-1') {
            $where .= " AND YEAR(p.created_on) = '{$_POST['year']}'";
            $year_text = $_POST['year'];
        }
        
        $year_text = "Time frame: ". $year_text;

        
        
        $sql = "SELECT u.id, concat(u.name,' ',u.surname) as full_name , u.last_seen
                FROM users u
                    LEFT JOIN 
                scholarships s ON u.id = s.user_id, groups g , payments p,  user_payment up 
                WHERE u.id = up.user_id
                AND p.id = up.payment_id
                {$where}
                GROUP BY u.id";
                
        
        $raw_users = Database::query($sql)->fetch_all();

        
        $references = array();
        $payment_names = array();
        
        foreach($raw_users as &$u) {
            
            $payments = Payment::user_log($u['id'],$_POST['year']);

            foreach($payments as $p) {
            
                $ref_name = $p['reference2'] ? $p['reference']. '-'.$p['reference2'] : $p['reference'];
                //$payment_name = $p['name'].' '.date('j,M', strtotime($p['created_on']));
                $payment_name = date('F , j', strtotime($p['created_on']));
                
                if(!in_array($ref_name , $references)) {
                    $references[] = $ref_name;
                }
                
                if(!in_array($payment_name , $payment_names)) {
                    $payment_names[] = $payment_name;
                }
            }
            
            $u['payments'] = $payments;
            $u['payment_names'] = $payment_names;
        }
        
        foreach($raw_users as &$u) {
            
            $years = array(); 
            
            foreach($u['payments'] as $p) {
                if(!in_array($p['year'] , $years)) {
                    $years[] = $p['year'];
                }
            }
           
            $formated_step_2 = array();
            
            foreach($years as $y)  {
                foreach($references as $r) {
                    $formated_step_2[$y]['payment_ref'][$r] = 0;
                }
                foreach($payment_names as $p) {
                    $formated_step_2[$y]['payment_name'][$p] = 0;
                }
            }
            
            
            foreach($u['payments'] as $p)  {
                $payment_name = date('F , j', strtotime($p['created_on']));
                $formated_step_2[$p['year']]['payment_name'][$payment_name] += $p['amount'];
            }
            
            foreach($u['payments'] as $p)  {
                $ref_name = $p['reference2'] ? $p['reference']. '-'.$p['reference2'] : $p['reference'];
                $formated_step_2[$p['year']]['payment_ref'][$ref_name] += $p['amount'];
            }
            

            $u['payments'] = $formated_step_2;
            $u['scholarship'] = User::get_scholarship_info($u['id']);
            $u['payment_logs'] = array();
        }

        function to_co_ord($row,$col) {
            return chr($col+65).$row;
        }

        $domain = new Domain($this->user->current_domain());

        
        include('include/PHPExcel.php');

        $objPHPExcel = new PHPExcel;
        
        $objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
        $objPHPExcel->getDefaultStyle()->getFont()->setSize(9);
        //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
        
        $currencyFormat = '#,#0.## \R;[Red]-#,#0.## \R';
        $numberFormat = '#,#0.##;[Red]-#,#0.##';
        
        $objSheet = $objPHPExcel->getActiveSheet();
        
        $objSheet->getCell("A7")->setValue($domain->domain.' Financial report');
        $objSheet->getStyle("A7")->applyFromArray(array('font' => array( 'size'  => 13, 'bold' => true )));
        
        
        $objSheet->getCell("A8")->setValue( $year_text );
        $objSheet->getStyle("A8")->applyFromArray(array('font' => array( 'size'  => 13, 'bold' => true )));
        
       
        
        /*
         'fill' => array(
         		'type' => PHPExcel_Style_Fill::FILL_SOLID,
         		'color' => array('rgb'=>'bfbfbf'),
         ),*/
        
         /*
        $logo = new PHPExcel_Worksheet_Drawing();
        $logo->setName('test_img');
        $logo->setDescription('test_img');
        $logo->setPath('./media/logo.jpg');
        $logo->setCoordinates('F2');
        $logo->setWorksheet($objPHPExcel->getActiveSheet());
       
        if(strlen($domain->image)) {
        	$logo = new PHPExcel_Worksheet_Drawing();
        	$logo->setName($domain->domain);
        	$logo->setDescription($domain->domain);
        	$logo->setPath('./media/domains/'.$domain->image);
        	$logo->setCoordinates('A2');
        	$logo->setWorksheet($objPHPExcel->getActiveSheet());
        }
        */
        
        
        
        $objSheet->setTitle($domain->domain . ' Report');
        
        
        $col = 3;
        $row = 12;
        
        $header_index_left = 3;
        $header_index_right = count($payment_names);
        
        $default_border = array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb'=>'000000')
        );
        
        $thick_border = array(
        		'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
        		'color' => array('rgb'=>'000000')
        );
        
        
        $style_header = array(        
        		/*          
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb'=>'bfbfbf'),
            ),*/
           
            'font' => array(
                'bold' => true,
                'size'  => 10.5,

            ),
            'borders' => array( 'bottom' => $thick_border, 'left' => $default_border, 'top' => $thick_border, 'right' =>  $thick_border ),
        	'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
        );
        
        $body_style = array(
            'font' => array( 'size'  => 11),
            'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb'=>'dce6f1'))
        );
        
        $footer_style = array(
            'font' => array( 'size'  => 11, 'bold' => true ),
            'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb'=>'EFEFEF')),
            'borders' => array( 'bottom' => $default_border, 'left' => $default_border, 'top' => $default_border, 'right' => $default_border )
        );
        
        $payment_style = array(
            'font' => array( 'size'  => 11, 'bold' => true , 'color' => array('rgb' => 'FFFFFF')),
            'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb'=>'ec6d1c')),
            'borders' => array( 'bottom' => $default_border, 'left' => $default_border, 'top' => $default_border, 'right' => $default_border )
        );
        
        
        $header = $objSheet->getStyle(to_co_ord($row ,$col - $header_index_left).':'.to_co_ord($row,$col+count($references)+$header_index_right));
        $header->applyFromArray($style_header);
        
        for($i = 65;$i < 85; $i++) {
            $char = chr($i);
            $objPHPExcel->getActiveSheet()->getColumnDimension($char)->setWidth(23);
        }
        
        $objSheet->getCell(to_co_ord($row  , $col - 1 ))->setValue('Student');
        $objSheet->getCell(to_co_ord($row  , $col - 2 ))->setValue('Financial year');
        $objSheet->getCell(to_co_ord($row  , $col - 3 ))->setValue('Institute');

        
        $objSheet->getCell(to_co_ord($row  , $col+count($references) ))->setValue('Total');
        
        for($i = 0,$cnt = count($references); $i < $cnt; $i++) {
            $objSheet->getCell(to_co_ord($row  , $col +$i ))->setValue($references[$i]);
            

        }
        
        for($b = 0 , $index = $i + 1; $b < count($payment_names); $b++ ) {
            $objSheet->getCell(to_co_ord($row  , $col + $index+$b ))->setValue($payment_names[$b]);
        }

       // ++$row;
        
        $header = $objSheet->getStyle(to_co_ord($row ,$col - $header_index_left).':'.to_co_ord($row,$col+count($references)+$header_index_right));
       
        
       // $header->applyFromArray(array( 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb'=>'dce6f1'))));
        
        ++$row;
        
        $start_row = $row;
        
        $v_total = array();
        foreach($raw_users as $user) {
            foreach($user['payments'] as $actual_year => $year) {
                
                $i=0;
                $h_total = 0;
                
                foreach($year['payment_ref'] as $key => $values) {
                    $objSheet->getCell(to_co_ord($row  , $col + $i  ))->setValue($values);
                    
            		if($values) {
                    	$objSheet->getStyle(to_co_ord($row  , $col + $i ))->getNumberFormat()->setFormatCode("R #.##00");
            		}
                    
                    $v_total[$i] += $values;
                    $i++;
                    $h_total += $values;
                }
                $objSheet->getCell(to_co_ord($row  , $col + $i  ))->setValue($h_total );
                
                $h_total = 0;
                $b = 0;
                foreach($year['payment_name'] as $key => $values) {
                    $objSheet->getCell(to_co_ord($row  , $col + $i  + 1 ))->setValue($values);
                    if($values) {
                    	$objSheet->getStyle(to_co_ord($row  , $col + $i  + 1 ))->getNumberFormat()->setFormatCode("R #.##00");
                    }
                    $p_total[$b] += $values;
                    $i++;
                    $b++;
                    //$h_total += $values;
                }
                //$objSheet->getCell(to_co_ord($row  , $col + $i   ))->setValue($h_total );

                $objSheet->getCell(to_co_ord($row  , $col -1  ))->setValue($user['full_name'] );
                $objSheet->getCell(to_co_ord($row  , $col -2  ))->setValue($actual_year );
                $objSheet->getCell(to_co_ord($row  , $col -3  ))->setValue($user['scholarship']['university']);
                
                ++$row;
                
            }
        }
        
        $objSheet->getCell(to_co_ord($start_row - 2  , $header_index_left + count($references) + 1))->setValue('Payments');
        
        $objSheet->getStyle(to_co_ord($start_row - 2  , $header_index_left + count($references)  + 1))
                    ->applyFromArray($payment_style)
                    ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        
        if(count($payment_names) != 1) {
            //echo to_co_ord($start_row - 3  , $header_index_left + count($references) + 1) , to_co_ord($start_row - 1  , $header_index_left + count($references)) + count($payment_names)+1)
            //echo to_co_ord($start_row - 3  , $header_index_left + count($references) + 1) .':'. to_co_ord($start_row - 1  , $header_index_left + count($references) + count($payment_names)+1);
            //$objSheet->mergeCells(to_co_ord($start_row - 3  , $header_index_left + count($references) + 1) .':'. to_co_ord($start_row - 1  , $header_index_left + count($references) + count($payment_names)+1));
        }
        
        for($i = $start_row; $i < $row; $i++) {
            $objSheet->getStyle(to_co_ord($i  , $col -$header_index_left   ).':'. to_co_ord($i  , $col+count($references)+$header_index_right  ))->applyFromArray( $body_style);
            //$objSheet->getStyle(to_co_ord($i  , $col -$header_index_left   ).':'. to_co_ord($i  , $col+count($references)+$header_index_right  ))->getNumberFormat()->setFormatCode("R #.##00");
            
        }
        
        $objSheet->getCell(to_co_ord($row  , $col - 1  ))->setValue('Total');
        
        for($i = 0,$cnt = count($v_total); $i < $cnt; $i++) {
            $objSheet->getCell(to_co_ord($row  , $col + $i  ))->setValue($v_total[$i]);
            $objSheet->getStyle(to_co_ord($row  , $col + $i ))->getNumberFormat()->setFormatCode("R #.##00");
        }

        $objSheet->getStyle(to_co_ord($row  , $col -$header_index_left   ).':'. to_co_ord($row  , $col+count($references)+$header_index_right  ))->applyFromArray( $footer_style );
      
        $objSheet->getCell(to_co_ord($row  , $col + $i  ))->setValue(array_sum($v_total));
        $objSheet->getStyle(to_co_ord($row  , $col + $i ))->getNumberFormat()->setFormatCode("R #.##00");
        $i++;
        
        for($b = 0,$cnt = count($p_total); $b < $cnt; $b++) {
            $objSheet->getCell(to_co_ord($row  , $col + $i + $b  ))->setValue($p_total[$b]);
            $objSheet->getStyle(to_co_ord($row  ,  $col + $i + $b ))->getNumberFormat()->setFormatCode("R #.##00");
        }
        
        $objWriter = new PHPExcel_Writer_Excel2007 ($objPHPExcel);

        $objWriter->save("media/report.xls");
        header("location: /media/report.xls");
        
        exit();

        
            
    }
    

}

?>