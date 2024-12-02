<?php declare(strict_types=1)

include_once 'include/pivot.php';

class StatsController extends AppController {


    public function index($year = false) {

        $this->set('domains', Domain::find()->fetch_all());
        $this->set('stats', $stats = new Stats());

        $this->set('currency', Currency::getInstance());

    }

    public function compare($compare, $method = '' ,$domain_id) {


        $allowed_methods = array('total','average','supplier');

        if(!in_array($method, $allowed_methods)) {
            return false;
        }

        $method_name = 'cost_'.$method;

        $stats = new Stats();

        switch($compare) {

            case 'degree':
                $method_name .= '_yearly_degree';
            break;

            case 'reference':
                $method_name .= '_yearly_reference';
            break;

            case 'supplier':
                $method_name .= '_yearly_supplier';
            break;

            case 'uni':
                $method_name .= '_yearly_uni';
            break;
        }
        echo "<div style='width:600px'>".$stats->$method_name($domain_id)."</div>";
        die();

    }

    public function set_currency($currency='') {

        if(!strlen($currency)) {
            Currency::convert_to(false);
        } else {
            Currency::convert_to($currency);
        }

        $this->redirect('stats');

    }


    public function test() {

        Currency::convert_to('USD');

        $test = array(
            array('test'=>300),
            array('test'=>600),
            array('test'=>500),
            array('test'=>1000),
            array('test'=>300)
        );

        d(
            Currency::convert_array(9 , $test, 'test' )
            

        );

    }

    

    public function export() {

        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=raw_data.csv");
        header("Pragma: no-cache");
        header("Expires: 0");

        $filters['account_type'] = 'bursar';
        $filters['send_message'] = '1';
        $filters['limit'] = false;

        $sql = 'SELECT u.*,s.*,p.* FROM users u LEFT JOIN scholarships s ON u.id = s.user_id LEFT JOIN profiles p ON u.id = p.user_id,groups g';
        $sql .= User::get_search_where_clause($filters) . User::get_search_order_clause($filters);

        $rs = Database::query($sql);
        $rows = array();


 $rows = array();

        $last = array();


                $col = 3;
        $row = 12;
        

        function to_co_ord($row,$col) {

           // d($col);
            if($col > 76) {
                return 'C'.chr($col+65 - 77) . $row;
            } elseif($col > 50) {
                return 'B'.chr($col+65 - 51) . $row;
            } elseif($col > 24) {
                return 'A'.chr($col+65 - 25) . $row;
            }
            return chr($col+65).$row;
        }


        include('include/PHPExcel.php');



        $objPHPExcel = new PHPExcel;
        
        $objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
        $objPHPExcel->getDefaultStyle()->getFont()->setSize(9);

        $work_sheet_cnt = 0;

        $objSheet = new PHPExcel_Worksheet($objPHPExcel, 'Data');

        $rows = $rs->fetch_all();


        for($i = 65;$i < 85; $i++) {
            $char = chr($i);
            $objSheet->getColumnDimension($char)->setWidth(23);


        }
 
        $headers = array_keys($rows[0]);

        unset($headers[2]);

        $heading_cnt = 0;
        foreach($headers as $heading) {

            $coord = to_co_ord(1 , $heading_cnt++ );
            $objSheet->getCell($coord)->setValue(ucfirst(str_replace('_', ' ', $heading)));
        }


        $row = 2;
        foreach($rows as $details) {
            $row++;
            $col=0;
            foreach($details as $key => $field) {

                if($key != 'password') {

                    $objSheet->getCell(to_co_ord($row  , $col++))->setValue($field);

                } 
            }

        }






/*
        $row = 1;
        foreach($rows as $rsvp) {
            $row++;
            $col=0;
            foreach($rsvp as $field) {
                $objSheet->getCell(to_co_ord($row  , $col++))->setValue($field);
            }
        }



        }
  */      

        $objPHPExcel->addSheet($objSheet, 1);


        $objPHPExcel->setActiveSheetIndex(1);


        $objWriter = new PHPExcel_Writer_Excel2007 ($objPHPExcel);



        $filename = time().'event.xls';


        $objWriter->save("media/{$filename}");
        header("location: /media/{$filename}");

    
        

   





        exit();

    }


  
/*
    private function kpi() {

        //% of student's who give back

        $sql = "SELECT COUNT(*) as cnt FROM alumni WHERE have_contributed = 'Yes'";
        $contribution = Database::query($sql)->fetch('object')->cnt;

        $sql = "SELECT count(*) as total_alumni
                FROM users u , alumni a
                WHERE u.id = a.user_id
                AND  u.group_id in (SELECT id FROM groups WHERE account = 'bursar' AND is_alumni = '1')
            ";

        $total_alumni = Database::query($sql)->fetch('object')->total_students;

        $return ='';

        $sql = "SELECT COUNT(*) as cnt FROM alumni WHERE contributed_moshal = 'Yes'";
        $contribution_moshal = Database::query($sql)->fetch('object')->cnt;
        

        $year = Date('Y');

        $sql = "SELECT count(*) as total_alumni
                FROM users u , alumni a
                WHERE u.id = a.user_id
                AND  u.group_id in (SELECT id FROM groups WHERE account = 'bursar' AND is_alumni = '1')
                AND YEAR(u.last_seen) = '{$year}'
            ";

        $last_seen = Database::query($sql)->fetch('object')->total_alumni;

        $sql = "SELECT count(*) as total_alumni,hired_after
                FROM users u , alumni a
                WHERE u.id = a.user_id
                AND  u.group_id in (SELECT id FROM groups WHERE account = 'bursar' AND is_alumni = '1')
                AND YEAR(u.last_seen) = '{$year}'
                GROUP by a.hired_after
            ";


        $return .= @round(( $last_seen / $total_alumni) * 100) . " % students who remain in contact as alumnae (attend at least one function p.a. and keep contact details updated)<br />";
        $return .= @round(( $contribution / $total_alumni) * 100)  ." % students who give to charity in kind or financially<br />";
        $return .= @round(( $contribution_moshal / $total_alumni) * 100).  "% students who give to Moshal in kind or financially<br />";
        return $return."<br /><br /><br />".$this->detailed()."<br /><br /><br />".$this->kpi_faculty_inst()."<br /><br /><br />".$this->kpi_inst_year();
     

    }

 */   


}

?>