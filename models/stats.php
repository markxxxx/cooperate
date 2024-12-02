<?php declare(strict_types=1)

include_once 'helpers/chart.php';

class Stats {

	private $chart;
    private $active="AND u.account_status='Active'";

	public function __construct() {
		$this->chart = new chart();
	}
    
    private function create_2d_bar($title,$rows,$key='',$value = 'cnt') {


    	if(!$rows || !count($rows)) {
    		return;
    	} 

        $chart = "<chart yAxisName='' caption='{$title}' numberPrefix='' showToolTip='1'>";
        
        $chart_xml = '';

        $total = 0;
        foreach($rows as $row) {
            $total += $row[$key];
        }


        foreach($rows as $row) {

            if($row[$value] == '') {
                $row[$value] = 'Not specified';
            }

            $percentage = 0;

            if($row[$key] == 0) {
                $percentage = 0;
            }

            if($total > 0) {
                $percentage = round(($row[$key] / $total) *100,2);
            } else {
                $percentage = 0;
            }

            $percentage = $row[$value] .', ' .$percentage. ' Percent';

            $chart_xml .= "<set label='{$row[$value]}' value='{$row[$key]}' toolText='{$percentage}' />";
        }

        return $this->chart->render("Column3D.swf", $chart.$chart_xml.'</chart>', "as", 930, 200, false, false);
    }


    private function pivot($rows, $col , $row , $value , $callback = null) {

        if(!$rows) {
            return false;
        }


        $format = array();
        $cols = array();

        foreach($rows as $r) {

            if(!in_array($r[$col], $cols)) {
                $cols[] = $r[$col];
            }

        }

        foreach($rows as $r) {
            foreach($cols as $u) {
                $format[$r[$row]][$u] = 0;
            }
        }

        foreach($rows as $r) {
            $format[$r[$row]][$r[$col]] = $r[$value];
        }
        unset($format['']);

        $return = "<table id='hor-minimalist-a' width='100%'><thead>
                    <tr><th></th>";

        foreach($cols as $u) {
            $return .= "<th >{$u}</th>";
        }
        if(is_callable($callback)) {
            $return .= $callback(null,'header');
        }
                    $return .= "</tr ></thead><tbody>";



        foreach($format as $discipline => $values) {
            $return .= "<tr><td>{$discipline}</td>";
            foreach($values as $key => $v) {


                $return .= "<td>{$v}</td>";
 
 
            }
            if(is_callable($callback)) {
                $return .= $callback($values);
            }
            $return .="</tr></tbody>";
        } 
        $return .="</table>";

        return $return;
    }


	public function total_scholars() {
		$sql = "SELECT count(*) as cnt FROM users WHERE group_id in (SELECT id FROM groups WHERE account = 'bursar' AND is_alumni = '0')";
		return Database::query($sql)->fetch('object')->cnt;
	}

	public function total_grads() {
		$sql = "SELECT count(*) as cnt FROM users WHERE group_id in (SELECT id FROM groups WHERE account = 'bursar' AND is_alumni = '1')";
		return Database::query($sql)->fetch('object')->cnt;
	}


	public function bursar_gender_graph($domain_id=0) {

		$where = '';
		if($domain_id) {
			$where = " AND u.domain_id = '{$domain_id}' ";
		}

        $sql = "SELECT p.gender , count(*) as cnt
            FROM users u , scholarships s , profiles p
            WHERE u.id = s.user_id 
            AND p.user_id = u.id
            AND u.group_id in (SELECT id FROM groups WHERE account = 'bursar' AND is_alumni = '0')
            {$where}
            {$active}
            GROUP BY p.gender";

        $rows = Database::query($sql)->fetch_all();

        return $this->create_2d_bar('Gender', $rows, 'cnt', 'gender');

	}

	public function bursar_ethnic_graph($domain_id=0) {

		$where = '';
		if($domain_id) {
			$where = " AND u.domain_id = '{$domain_id}' ";
		}

	    $sql = "SELECT p.ethnic_group , count(*) as cnt
            FROM users u , scholarships s , profiles p
            WHERE u.id = s.user_id 
            AND p.user_id = u.id
            {$where}
            {$active}
             AND u.group_id in (SELECT id FROM groups WHERE account = 'bursar' AND is_alumni = '0')

            GROUP BY p.ethnic_group
        ";

        $rows = Database::query($sql)->fetch_all();

        return $this->create_2d_bar('Ethnic', $rows, 'cnt', 'ethnic_group');

	}

	public function grad_ethnic_graph($domain_id=0) {

		$where = '';
		if($domain_id) {
			$where = " AND u.domain_id = '{$domain_id}' ";
		}

	    $sql = "SELECT p.ethnic_group , count(*) as cnt
            FROM users u , scholarships s , profiles p
            WHERE u.id = s.user_id 
            AND p.user_id = u.id
            {$where}
            {$active}
            AND u.group_id in (SELECT id FROM groups WHERE account = 'bursar' AND is_alumni = '1')
            GROUP BY p.ethnic_group
        ";

        $rows = Database::query($sql)->fetch_all();

        return $this->create_2d_bar('Ethnic', $rows, 'cnt', 'ethnic_group');

	}


    public function bursar_status_graph($domain_id=0) {

        $where = '';
        if($domain_id) {
            $where = " WHERE domain_id = '{$domain_id}' ";
        }

        $sql = "SELECT count(*) as cnt, account_status
            FROM users 
            {$where}
            GROUP BY account_status
        ";

        $rows = Database::query($sql)->fetch_all();

        return $this->create_2d_bar('User Status - Students and Alumni', $rows, 'cnt', 'account_status');

    }

    public function bursar_gender_graph2($domain_id=0) {

        $sql = "SELECT p.gender, count(*) as cnt 
                FROM users u 
                LEFT JOIN profiles p on (p.user_id=u.id)
                WHERE group_id in (SELECT id FROM groups WHERE account = 'bursar' AND is_alumni = '0')
                GROUP BY p.gender
        ";

        $rows = Database::query($sql)->fetch_all();

        return $this->create_2d_bar('Students Gender', $rows, 'cnt', 'gender');

    }

    public function bursar_final_year($domain_id=0) {

        $sql = "SELECT d.domain as domain, s.years_to_complete, s.grad_date, count(*) as cnt 
                FROM users u 
                LEFT JOIN scholarships s on (s.user_id=u.id)
                LEFT JOIN domains d on (d.id=u.domain_id)
                WHERE group_id in (SELECT id FROM groups WHERE account = 'bursar' AND is_alumni = '0')
                AND s.years_to_complete=0
                AND SUBSTR( s.grad_date,1,4)=YEAR(CURDATE() )+1 
                group by u.domain_id
        ";

        $rows = Database::query($sql)->fetch_all();

        return $this->create_2d_bar('Final year of moshal support', $rows, 'cnt', 'domain');

    }

	public function grad_race_graph($domain_id=0) {

		$where = '';
		if($domain_id) {
			$where = " AND u.domain_id = '{$domain_id}' ";
		}

	    $sql = "SELECT p.race , count(*) as cnt
            FROM users u , scholarships s , profiles p
            WHERE u.id = s.user_id 
            AND p.user_id = u.id
            AND u.group_id in (SELECT id FROM groups WHERE account = 'bursar' AND is_alumni = '0')
            {$where}
            {$active}
            GROUP BY p.race
        ";

        $rows = Database::query($sql)->fetch_all();

        return $this->create_2d_bar('Race', $rows, 'cnt', 'race');

	}

	public function bursar_race_graph($domain_id=0) {

		$where = '';
		if($domain_id) {
			$where = " AND u.domain_id = '{$domain_id}' ";
		}

	    $sql = "SELECT p.race , count(*) as cnt
            FROM users u , scholarships s , profiles p
            WHERE u.id = s.user_id 
            AND p.user_id = u.id
            {$where}
            {$active}
            AND u.group_id in (SELECT id FROM groups WHERE account = 'bursar' AND is_alumni = '0')
            GROUP BY p.race
        ";

        $rows = Database::query($sql)->fetch_all();

        return $this->create_2d_bar('Race', $rows, 'cnt', 'race');

	}


	public function grad_gender_graph($domain_id=0) {

		$where = '';
		if($domain_id) {
			$where = " AND u.domain_id = '{$domain_id}' ";
		}

        $sql = "SELECT p.gender , count(*) as cnt
            FROM users u , scholarships s , profiles p
            WHERE u.id = s.user_id 
            AND p.user_id = u.id
            AND u.group_id in (SELECT id FROM groups WHERE account = 'bursar' AND is_alumni = '1')
            {$where}
            {$active}
            GROUP BY p.gender";

        $rows = Database::query($sql)->fetch_all();

        return $this->create_2d_bar('Gender', $rows, 'cnt', 'gender');

	}

    public function employer_graph($domain_id=0) {

        $where = '';
        if($domain_id) {
            $where = " AND u.domain_id = '{$domain_id}' ";
        }

        $sql = "SELECT a.work_for , count(*) as cnt
            FROM users u , alumni a , profiles p
            WHERE u.id = a.user_id 
            AND p.user_id = u.id
            AND u.group_id in (SELECT id FROM groups WHERE account = 'bursar' AND is_alumni = '1')
            {$where}
            {$active}
            GROUP BY a.work_for";

        $rows = Database::query($sql)->fetch_all();

        return $this->create_2d_bar('Employer', $rows, 'cnt', 'work_for');

    }

	public function bursar_domain_graph() {

		$sql = "SELECT d.country, count(*) as cnt 
		        FROM users u, domains d 
		        WHERE u.domain_id = d.id 
		        AND  u.group_id in (SELECT id FROM groups WHERE account = 'bursar' AND is_alumni = '0')
                {$active}
		        GROUP BY d.country";

		$result = Database::query($sql)->fetch_all();

		return $this->create_2d_bar('Student per country', $result, 'cnt', 'country');

	}

	public function bursar_university_graph($domain_id=0) {

		$where = '';
		if($domain_id) {
			$where = " AND u.domain_id = '{$domain_id}' ";
		}

        $sql = "SELECT s.university, count(*) as cnt 
                FROM users u LEFT JOIN scholarships s ON u.id = s.user_id
                WHERE u.group_id in (SELECT id FROM groups WHERE account = 'bursar' AND is_alumni = '0')
                {$where}
                {$active}
                GROUP BY s.university";

        $by_university = Database::query($sql)->fetch_all();

        return $this->create_2d_bar('Student by university', $by_university, 'cnt', 'university');

	}

	public function bursar_study_field_graph($domain_id=0) {

		$where = '';
		if($domain_id) {
			$where = " AND u.domain_id = '{$domain_id}' ";
		}

        $sql = "SELECT s.year_of_study, count(*) as cnt 
                FROM users u LEFT JOIN scholarships s ON u.id = s.user_id
                WHERE u.group_id in (SELECT id FROM groups WHERE account = 'bursar' AND is_alumni = '0')
                {$where}
                {$active}
                GROUP BY s.year_of_study";

        $by_year = Database::query($sql)->fetch_all();

        return $this->create_2d_bar('Student By Year', $by_year, 'cnt', 'year_of_study');

	}



	public function grad_domain_graph() {

		$sql = "SELECT d.country, count(*) as cnt 
		        FROM users u, domains d 
		        WHERE u.domain_id = d.id 
		        AND  u.group_id in (SELECT id FROM groups WHERE account = 'bursar' AND is_alumni = '1')

		        GROUP BY d.country";

		$result = Database::query($sql)->fetch_all();

		return $this->create_2d_bar('Student per country', $result, 'cnt', 'country');

	}

	public function grad_university_graph($domain_id=0) {

		$where = '';
		if($domain_id) {
			$where = " AND u.domain_id = '{$domain_id}' ";
		}

        $sql = "SELECT s.university, count(*) as cnt 
                FROM users u LEFT JOIN scholarships s ON u.id = s.user_id
                WHERE u.group_id in (SELECT id FROM groups WHERE account = 'bursar' AND is_alumni = '1')
                {$where}
                {$active}
                GROUP BY s.university";

        $by_university = Database::query($sql)->fetch_all();

        return $this->create_2d_bar('Student by university', $by_university, 'cnt', 'university');

	}

	public function grad_study_field_graph($domain_id=0) {

		$where = '';
		if($domain_id) {
			$where = " AND u.domain_id = '{$domain_id}' ";
		}

        $sql = "SELECT s.year_of_study, count(*) as cnt 
                FROM users u LEFT JOIN scholarships s ON u.id = s.user_id
                WHERE u.group_id in (SELECT id FROM groups WHERE account = 'bursar' AND is_alumni = '1')
                {$where}
                {$active}
                GROUP BY s.year_of_study";

        $by_year = Database::query($sql)->fetch_all();

        return $this->create_2d_bar('Student By Year', $by_year, 'cnt', 'year_of_study');

	}

	public function future_bursar_graph($domain_id=0) {

		$where = '';
		if($domain_id) {
			$where = " AND u.domain_id = '{$domain_id}' ";
		}

        $sql =" SELECT YEAR(s.grad_date) AS grad_date , count(*) as cnt 
            FROM users u LEFT JOIN scholarships s ON u.id = s.user_id
            WHERE u.group_id in (SELECT id FROM groups WHERE account = 'bursar' AND is_alumni = '0')
            AND YEAR(s.grad_date) <> 0
            {$where}
            {$active}
            GROUP BY YEAR(s.grad_date)";

   		$future_stats = Database::query($sql)->fetch_all();

        return $this->create_2d_bar('Expected Graduates by Year', $future_stats, 'cnt', 'grad_date');
    }


    public function cost_average($domain_id=0, $year = 0) {

		$where = '';
		if($domain_id) {
			$where = " AND d.id = '{$domain_id}' ";
		}

        $sql = "SELECT d.country, ROUND(SUM(up.amount) / COUNT(DISTINCT u.id),2) as average_spend , SUBSTR(p.created_on,1,4) as year_s
                FROM user_payment up , users u, payments p, domains d 
                WHERE up.user_id =  u.id
                {$where}
                {$active}
                AND u.domain_id = d.id
                AND p.id = up.payment_id
                GROUP by d.country,year_s";

        $rows = Database::query($sql)->fetch_all();

        $rows = Currency::convert_array($domain_id, $rows, 'average_spend');

        return $rows;
    }

    public function cost_average_degree($domain_id=0, $year = 0) {

    	$where = '';
		
		if($domain_id) {
			$where = " AND u.domain_id = '{$domain_id}' ";
		}

        $sql = "SELECT s.discipline, ROUND(AVG(up.amount),2) as total_expenditure, count(*) as cnt
                FROM users u , scholarships s ,user_payment up 
                WHERE u.id = s.user_id 
                AND up.user_id = u.id
                {$where}
                {$active}
                AND up.reference != ''
                GROUP BY s.discipline
               ";

        $rows = Database::query($sql)->fetch_all();
        $rows = Currency::convert_array($domain_id, $rows, 'total_expenditure');


        return $rows;

    }

    public function cost_average_reference($domain_id=0, $year = 0) {

    	$where = '';
		
		if($domain_id) {
			$where = " AND u.domain_id = '{$domain_id}' ";
		}


       $sql = "SELECT SUBSTR(p.created_on,1,4) as month_s, ROUND(AVG(up.amount),2) as total_expenditure,up.reference
                FROM user_payment up INNER JOIN users u ON up.user_id = u.id
                INNER JOIN payments p
                    ON p.id = up.payment_id
                WHERE 
                 up.reference != ''
                {$where}
                {$active}
                AND SUBSTR(p.created_on,1,4)=YEAR(CURRENT_TIMESTAMP)
                GROUP BY up.reference";

        $rows = Database::query($sql)->fetch_all();

        $rows = Currency::convert_array($domain_id, $rows, 'total_expenditure');


        return $rows;

    }


    public function cost_total($domain_id=0, $year = 0) {

		$where = '';
		if($domain_id) {
			$where = " AND d.id = '{$domain_id}' ";
		}

        $sql = "SELECT d.country, ROUND(SUM(up.amount),2) as average_spend, SUBSTR(p.created_on,1,4) as year_s
                    FROM user_payment up, users u, payments p, domains d 
                    WHERE up.user_id =  u.id
                    {$where}
                    {$active}
                    AND u.domain_id = d.id
                    AND p.id = up.payment_id
                    GROUP by d.country,year_s";

        $rows = Database::query($sql)->fetch_all();

        $rows = Currency::convert_array($domain_id, $rows, 'average_spend');


        return $rows;
    }

    public function cost_total_degree($domain_id=0, $year = 0) {

    	$where = '';
		
		if($domain_id) {
			$where = " AND u.domain_id = '{$domain_id}' ";
		}

        $sql = "SELECT s.discipline, ROUND(SUM(up.amount),2) as total_expenditure, count(*) as cnt
                FROM users u , scholarships s ,user_payment up
                LEFT JOIN payments p ON (p.id = up.payment_id)
                WHERE u.id = s.user_id 
                AND up.user_id = u.id
                AND SUBSTR(p.created_on,1,4)=YEAR(CURRENT_TIMESTAMP)
                {$where}
                {$active}
                AND up.reference != ''
                GROUP BY s.discipline
               ";

        $rows = Database::query($sql)->fetch_all();

        $rows = Currency::convert_array($domain_id, $rows, 'total_expenditure');


        return $rows;

    }

    public function cost_total_uni($domain_id=0, $year = 0) {

        $where = '';
        
        if($domain_id) {
            $where = " AND u.domain_id = '{$domain_id}' ";
        }

        $sql = "SELECT s.university, ROUND(SUM(up.amount),2) as total_expenditure, count(*) as cnt
                FROM users u , scholarships s ,user_payment up
                LEFT JOIN payments p ON (p.id = up.payment_id)
                WHERE u.id = s.user_id 
                AND up.user_id = u.id
                AND SUBSTR(p.created_on,1,4)=YEAR(CURRENT_TIMESTAMP) 
                {$where}
                {$active}
                AND up.reference != ''
                GROUP BY s.university
               ";

        $rows = Database::query($sql)->fetch_all();

        $rows = Currency::convert_array($domain_id, $rows, 'total_expenditure');


        return $rows;

    }

    public function cost_average_uni($domain_id=0, $year = 0) {

        $where = '';
        
        if($domain_id) {
            $where = " AND u.domain_id = '{$domain_id}' ";
        }

        $sql = "SELECT s.university, ROUND(AVG(up.amount),2) as total_expenditure, count(*) as cnt
                FROM users u , scholarships s ,user_payment up
                WHERE u.id = s.user_id 
                AND up.user_id = u.id
                {$where}
                {$active}
                AND up.reference != ''
                GROUP BY s.university
               ";

        $rows = Database::query($sql)->fetch_all();

        $rows = Currency::convert_array($domain_id, $rows, 'total_expenditure');


        return $rows;

    }



    public function cost_total_reference($domain_id=0, $year = 0) {

    	$where = '';
		
		if($domain_id) {
			$where = " AND u.domain_id = '{$domain_id}' ";
		}

        
       $sql = "SELECT SUBSTR(p.created_on,1,4) as month_s, ROUND(SUM(up.amount),2) as total_expenditure,up.reference
                FROM user_payment up INNER JOIN users u
                    ON up.user_id = u.id
                INNER JOIN payments p
                    ON p.id = up.payment_id
               WHERE 
                 up.reference != ''
               AND SUBSTR(p.created_on,1,4)=YEAR(CURRENT_TIMESTAMP)   
                {$where}
                {$active}
                GROUP BY up.reference";

        $rows = Database::query($sql)->fetch_all();

        $rows = Currency::convert_array($domain_id, $rows, 'total_expenditure');


        return $rows;

    }


    public function cost_total_supplier($domain_id=0, $year = 0) {

    	$where = '';
		
		if($domain_id) {
			$where = " AND u.domain_id = '{$domain_id}' ";
		}


       $sql = "SELECT sum(up.amount) as total_expenditure,s.supplier
                    FROM user_payment up INNER JOIN users u
                        ON up.user_id = u.id
                    INNER JOIN payments p
                        ON p.id = up.payment_id
                    LEFT JOIN suppliers s
                        ON s.id = up.supplier_id
                    WHERE
                    up.supplier_id <> 0 
                    {$where}
                    {$active}
                    AND up.reference != ''
                    GROUP BY s.supplier";

        $rows = Database::query($sql)->fetch_all();

        $rows = Currency::convert_array($domain_id, $rows, 'total_expenditure');


        return $rows;

    }




    public function cost_average_supplier($domain_id=0, $year = 0) {

    	$where = '';
		
		if($domain_id) {
			$where = " AND u.domain_id = '{$domain_id}' ";
		}


       $sql = "SELECT AVG(up.amount) as total_expenditure,s.supplier
                    FROM user_payment up INNER JOIN users u
                        ON up.user_id = u.id
                    INNER JOIN payments p
                        ON p.id = up.payment_id
                    LEFT JOIN suppliers s
                        ON s.id = up.supplier_id
                    WHERE
                    up.supplier_id <> 0 
                    {$where}
                    {$active}
                    AND up.reference != ''
                    GROUP BY s.supplier";

        $rows = Database::query($sql)->fetch_all();
        

        $rows = Currency::convert_array($domain_id, $rows, 'total_expenditure');



        return $rows;

    }

    public function cost_total_yearly_reference($domain_id) {
        
        $where = '';
        
        if($domain_id) {
            $where = " AND u.domain_id = '{$domain_id}' ";
        }


       $sql = "SELECT SUBSTR(p.created_on,1,4) as month_s, ROUND(SUM(up.amount),2) as total_expenditure,up.reference
                FROM user_payment up INNER JOIN users u
                    ON up.user_id = u.id
                INNER JOIN payments p
                    ON p.id = up.payment_id
               WHERE 
                 up.reference != ''
                {$where}
                {$active}
                GROUP BY up.reference, month_s";

        $rows = Database::query($sql)->fetch_all();

        $rows = Currency::convert_array($domain_id, $rows, 'total_expenditure');


        return $this->pivot($rows, 'month_s', 'reference','total_expenditure');

    }


    public function cost_average_yearly_reference($domain_id) {
        
        $where = '';
        
        if($domain_id) {
            $where = " AND u.domain_id = '{$domain_id}' ";
        }


       $sql = "SELECT SUBSTR(p.created_on,1,4) as month_s, ROUND(AVG(up.amount),2) as total_expenditure,up.reference
                FROM user_payment up INNER JOIN users u
                    ON up.user_id = u.id
                INNER JOIN payments p
                    ON p.id = up.payment_id
               WHERE 
                 up.reference != ''
                {$where}
                {$active}
                GROUP BY up.reference, month_s";

        $rows = Database::query($sql)->fetch_all();

        $rows = Currency::convert_array($domain_id, $rows, 'total_expenditure');


        return $this->pivot($rows, 'month_s', 'reference','total_expenditure');
    }


    public function cost_average_yearly_supplier($domain_id) {
        
        $where = '';
        
        if($domain_id) {
            $where = " AND u.domain_id = '{$domain_id}' ";
        }


       $sql = "SELECT AVG(up.amount) as total_expenditure,s.supplier,SUBSTR(p.created_on,1,4) as month_s
                    FROM user_payment up INNER JOIN users u
                        ON up.user_id = u.id
                    INNER JOIN payments p
                        ON p.id = up.payment_id
                    LEFT JOIN suppliers s
                        ON s.id = up.supplier_id
                    WHERE
                    up.supplier_id <> 0 
                    {$where}
                    {$active}
                    AND up.reference != ''
                    GROUP BY s.supplier, month_s";

        $rows = Database::query($sql)->fetch_all();


        $rows = Currency::convert_array($domain_id, $rows, 'total_expenditure');


        return $this->pivot($rows, 'month_s', 'supplier','total_expenditure');
    }


    public function cost_total_yearly_supplier($domain_id) {
        
        $where = '';
        
        if($domain_id) {
            $where = " AND u.domain_id = '{$domain_id}' ";
        }



       $sql = "SELECT SUM(up.amount) as total_expenditure,s.supplier,SUBSTR(p.created_on,1,4) as month_s
                    FROM user_payment up INNER JOIN users u
                        ON up.user_id = u.id
                    INNER JOIN payments p
                        ON p.id = up.payment_id
                    LEFT JOIN suppliers s
                        ON s.id = up.supplier_id
                    WHERE
                    up.supplier_id <> 0 
                    {$where}
                    {$active}
                    AND up.reference != ''
                    GROUP BY s.supplier, month_s";

        $rows = Database::query($sql)->fetch_all();

        $rows = Currency::convert_array($domain_id, $rows, 'total_expenditure');


        return $this->pivot($rows, 'month_s', 'supplier','total_expenditure');
    }


    public function cost_average_yearly_degree($domain_id) {
        
        $where = '';
        
        if($domain_id) {
            $where = " AND u.domain_id = '{$domain_id}' ";
        }

       $sql = "SELECT s.discipline, SUBSTR(p.created_on,1,4) as month_s,  ROUND(AVG(up.amount),2) as total_expenditure
                FROM users u , scholarships s ,user_payment up, payments p
                WHERE u.id = s.user_id 
                AND up.user_id = u.id
                AND p.id = up.payment_id
                {$where}
                {$active}
                AND up.reference != ''
                GROUP BY s.discipline";

        $rows = Database::query($sql)->fetch_all();

        $rows = Currency::convert_array($domain_id, $rows, 'total_expenditure');


        return $this->pivot($rows, 'month_s', 'discipline','total_expenditure');
    }

    public function cost_total_yearly_degree($domain_id) {
        
        $where = '';
        
        if($domain_id) {
            $where = " AND u.domain_id = '{$domain_id}' ";
        }

       // $sql = "SELECT s.discipline, SUBSTR(p.created_on,1,4) as month_s,  ROUND(SUM(up.amount),2) as total_expenditure
       //          FROM users u , scholarships s ,user_payment up, payments p
       //          WHERE u.id = s.user_id 
       //          AND up.user_id = u.id
       //          AND p.id = up.payment_id
       //          AND SUBSTR(p.created_on,1,4)=YEAR(CURRENT_TIMESTAMP)
       //          {$where}
       //          {$active}
       //          AND up.reference != ''
       //          GROUP BY s.discipline";

        $sql = "SELECT s.discipline, SUBSTR(p.created_on,1,4) as month_s, ROUND(SUM(up.amount),2) as total_expenditure,up.reference
                FROM user_payment up  INNER JOIN users u
                    ON up.user_id = u.id 
                INNER JOIN payments p
                    ON p.id = up.payment_id, scholarships s
               WHERE u.id = s.user_id 
               AND up.reference != ''
                {$where}
                {$active}
                GROUP BY s.discipline, month_s";

        $rows = Database::query($sql)->fetch_all();

        $rows = Currency::convert_array($domain_id, $rows, 'total_expenditure');


        return $this->pivot($rows, 'month_s', 'discipline','total_expenditure');
    }


    public function cost_total_yearly_uni($domain_id) {
        
        $where = '';
        
        if($domain_id) {
            $where = " AND u.domain_id = '{$domain_id}' ";
        }



       $sql = "SELECT s.university, SUBSTR(p.created_on,1,4) as month_s,  ROUND(SUM(up.amount),2) as total_expenditure
                FROM users u , scholarships s ,user_payment up, payments p
                WHERE u.id = s.user_id 
                AND up.user_id = u.id
                AND p.id = up.payment_id
                {$where}
                {$active}
                AND up.reference != ''
                GROUP BY s.university";


        $rows = Database::query($sql)->fetch_all();

        $rows = Currency::convert_array($domain_id, $rows, 'total_expenditure');


        return $this->pivot($rows, 'month_s', 'university','total_expenditure');
    }


    public function cost_average_yearly_uni($domain_id) {
        
        $where = '';
        
        if($domain_id) {
            $where = " AND u.domain_id = '{$domain_id}' ";
        }

       $sql = "SELECT s.university, SUBSTR(p.created_on,1,4) as month_s,  ROUND(AVG(up.amount),2) as total_expenditure
                FROM users u , scholarships s ,user_payment up, payments p
                WHERE u.id = s.user_id 
                AND up.user_id = u.id
                AND p.id = up.payment_id

                {$where}
                {$active}
                AND up.reference != ''
                GROUP BY s.university";

        $rows = Database::query($sql)->fetch_all();

        $rows = Currency::convert_array($domain_id, $rows, 'total_expenditure');


        return $this->pivot($rows, 'month_s', 'university','total_expenditure');
    }






    public function bursar_kpi_inst_year_table($domain_id) {

    	if($domain_id) {
			$where = " AND u.domain_id = '{$domain_id}' ";
		}
        
        $sql = "SELECT YEAR(s.award_date) as ayear,s.university, count(*) as cnt
            FROM users u , scholarships s 
            WHERE u.id = s.user_id 
            AND u.group_id in (SELECT id FROM groups WHERE account = 'bursar' AND is_alumni = '0')

            {$where}
            {$active}
            GROUP BY ayear,s.university
           ";

        $rows = Database::query($sql)->fetch_all();

        return $this->pivot($rows, 'ayear', 'university', 'cnt');

    }

    public function bursar_kpi_faculty_inst_table($domain_id) {

    	if($domain_id) {
			$where = " AND u.domain_id = '{$domain_id}' ";
		}

    	 $sql = "SELECT s.discipline,s.university, count(*) as cnt

            FROM users u , scholarships s 
            WHERE u.id = s.user_id 
            {$where}
            {$active}
            AND u.group_id in (SELECT id FROM groups WHERE account = 'bursar' AND is_alumni = '0')
            GROUP BY s.discipline,s.university

           ";

        $rows = Database::query($sql)->fetch_all();
        return $this->pivot($rows, 'university', 'discipline', 'cnt');


    }


    public function grad_kpi_inst_year_table($domain_id) {

    	if($domain_id) {
			$where = " AND u.domain_id = '{$domain_id}' ";
		}
        
        $sql = "SELECT YEAR(s.award_date) as ayear,s.university, count(*) as cnt
            FROM users u , scholarships s 
            WHERE u.id = s.user_id
            AND u.group_id in (SELECT id FROM groups WHERE account = 'bursar' AND is_alumni = '1')

            {$where}
            {$active}
            GROUP BY ayear,s.university
           ";

        $rows = Database::query($sql)->fetch_all();

        return $this->pivot($rows, 'ayear', 'university', 'cnt');

    }

    public function grad_kpi_faculty_inst_table($domain_id) {

    	if($domain_id) {
			$where = " AND u.domain_id = '{$domain_id}' ";
		}

    	 $sql = "SELECT s.discipline,s.university, count(*) as cnt

            FROM users u , scholarships s 
            WHERE u.id = s.user_id 
            {$where}
            {$active}
            AND u.group_id in (SELECT id FROM groups WHERE account = 'bursar' AND is_alumni = '1')
            GROUP BY s.discipline,s.university

           ";

        $rows = Database::query($sql)->fetch_all();

        return $this->pivot($rows, 'university', 'discipline', 'cnt');
        
    }


    public function pass_rate_yearly($domain_id) {

        if($domain_id) {
            $where = " AND u.domain_id = '{$domain_id}' ";
        }

        $sql = "SELECT IF(r.result = 'YES', 'Passed', 'Failed') as r_result , YEAR(r.created_on) as s_year, count(*) as cnt

        FROM users u , results r
        WHERE u.id = r.user_id 
        {$where}
        {$active}
        GROUP BY r.result, s_year, r.user_id

       ";  

        $rows = Database::query($sql)->fetch_all();

        $callback = function($values, $is_header=false){

            if($is_header) {
                return '<th>Pass Rate</th>';
            }
            if($values['Passed'] + $values['Failed'] == 0) {
                return '<td>0%</td>';
            }

            $perc = ($values['Passed'] / ($values['Passed'] + $values['Failed']))*100;
            return '<td>'.round($perc ,2).'%</td>';
        };

        return $this->pivot($rows, 'r_result', 's_year', 'cnt', $callback);

    }

    public function graduate_contributed($domain_id = 0) {
        
        if($domain_id) {
            $where = " AND u.domain_id = '{$domain_id}' ";
        }
 

        $sql = "SELECT YEAR(a.graduation_date) as s_year, a.have_contributed , count(*) as cnt
                FROM users u, alumni a
                WHERE u.id = a.user_id
                {$where}
                {$active}
                GROUP BY  s_year, a.have_contributed";

        $rows = Database::query($sql)->fetch_all();

        if(!$rows) {
            return false;
        }  

        $callback = function($values, $is_header=false){

            if($is_header) {
                return '<th>Percetage who have contributed</th>';
            }
            if($values['Yes'] + $values['No'] == 0) {
                return '<td>0%</td>';
            }

            $perc = ($values['Yes'] / ($values['No'] + $values['Yes']))*100;
            return '<td>'.round($perc ,2).'%</td>';
        };

        return '<h3 class="green">Have contributed to moshal</h3><br />'.$this->pivot($rows, 'have_contributed', 's_year', 'cnt',  $callback);

    }


    public function graduate_jobs($domain_id = 0) {
        
        if($domain_id) {
            $where = " AND u.domain_id = '{$domain_id}' ";
        }
 

        $sql = "SELECT YEAR(a.graduation_date) as s_year, a.hired_after , count(*) as cnt
                FROM users u, alumni a
                WHERE u.id = a.user_id
                AND a.are_you_working = 'Yes'
                {$where}
                {$active}
                GROUP BY  s_year, a.hired_after";

        $rows = Database::query($sql)->fetch_all();

        if(!$rows) {
            return false;
        }  

        return '<h3 class="green">Got jobs after graduating</h3><br />'.$this->pivot($rows, 'hired_after', 's_year', 'cnt');

    }


    public function graduate_ontime($domain_id = 0) {
        
        if($domain_id) {
            $where = " AND u.domain_id = '{$domain_id}' ";
        }
 

        $sql = "SELECT YEAR(a.graduation_date) as s_year, 
                        IF( (YEAR(a.graduation_date) = YEAR(s.grad_date)) OR 
                            (YEAR(a.graduation_date) < YEAR(s.grad_date))
                            , 'Yes', 'No')  as on_time , count(*) as cnt 
                FROM users u, alumni a, scholarships s
                WHERE u.id = a.user_id
                AND s.user_id = u.id
                {$where}
                {$active}
                GROUP BY  s_year, on_time";

        $rows = Database::query($sql)->fetch_all();

        if(!$rows) {
            return false;
        }  

        return '<h3 class="green">Graduated on time</h3><br />'.$this->pivot($rows, 'on_time', 's_year', 'cnt');

    }

    public function graduate_contact($domain_id = 0) {
        
        $sql = "SELECT count(*) as total_alumni FROM users  WHERE group_id in (SELECT id FROM groups WHERE account = 'bursar' AND is_alumni = '1')";

        $total_alumni = Database::query($sql)->fetch('object')->total_alumni;

        $year = date('Y');

        $sql = "SELECT count(*) as contacted
                FROM users u
                WHERE YEAR(u.last_seen) = '{$year}'
                {$active}
                AND group_id in (SELECT id FROM groups WHERE account = 'bursar' AND is_alumni = '1') ";


        $total_users = Database::query($sql)->fetch('object')->contacted;

        if(!$total_users) {
            return 0;
        }
        
        return round(($total_users / $total_alumni) * 100) .'%' ;

    }


}

?>