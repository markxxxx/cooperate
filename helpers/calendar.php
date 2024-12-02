<?php

class calendar{
	var $date;
	var $year;
	var $month;
	var $day;

	var $week_start_on = FALSE;
	var $week_start = 7;// sunday

	var $link_days = 2;
	var $link_to;
	var $formatted_link_to;

	var $mark_today = TRUE;
	var $today_date_class = 'today';

	var $mark_selected = TRUE;
	var $selected_date_class = '';

	var $mark_passed = FALSE;
	var $passed_date_class = 'passed';

	var $highlighted_dates;
	var $default_highlighted_class = 'highlighted';

	
	function getInstance() {
		static $instant;
		if(!is_object($instant)) {
			$instant = new calendar(date('Y-m-d'));
		}
		return $instant;
	}
	
	/* CONSTRUCTOR */
	function Calendar($date = NULL, $year = NULL, $month = NULL){
		$self = htmlspecialchars($_SERVER['PHP_SELF']);
		$this->link_to = $self;

		if( is_null($year) || is_null($month) ){
			if( !is_null($date) ){
				$this->date = date("Y-m-d", strtotime($date));
			} else {
				$this->date = date("Y-m-d");
			}
			$this->set_date_parts_from_date($this->date);
		} else {
			$this->year		= $year;
			$this->month	= str_pad($month, 2, '0', STR_PAD_LEFT);
		}
	}
	
	function set_events($events) {
		
		$i = 0;
		$highlight = array();

		foreach($events as $e) {
            $highlight[$i]['id'] = $e['id'];
            $highlight[$i]['date'] = $e['event_date'];
			$highlight[$i]['event'] = $e['name'];
			++$i;
			
		}
		
		$this->highlighted_dates = $highlight;
	}
	
	function set_date_parts_from_date($date){
		$this->year		= date("Y", strtotime($date));
		$this->month	= date("m", strtotime($date));
		$this->day		= date("d", strtotime($date));
	}

	function output_calendar($year = NULL, $month = NULL, $calendar_class = 'calendar'){

		if( $this->week_start_on !== FALSE ){
			echo "The property week_start_on is replaced due to a bug present in version before 2.6. of this class! Use the property week_start instead!";
			exit;
		}

		$year = ( is_null($year) )? $this->year : $year;
		$month = ( is_null($month) )? $this->month : str_pad($month, 2, '0', STR_PAD_LEFT);
		$prev_month = ucfirst(strftime("%B ",strtotime($year . "-" . ($month - 1) . "-01")));
		$next_month = ucfirst(strftime("%B ",strtotime($year . "-" . ($month +1) . "-01")));

		$short_pre_month = substr($prev_month,0,3);
		$short_next_month = substr($next_month,0,3);
		$month_start_date = strtotime($year . "-" . $month . "-01");

		if($month == 1) {
			$link_pre = ($year - 1) . "-12-01";
			$short_pre_month = 'Dec';

		}
		else
			$link_pre = $year . "-" . ($month - 1) . "-01";

		if($month == 12) {
			$link_next = ($year + 1) . "-01-01";
			$short_next_month ='Jan';
		}
		else
			$link_next = $year . "-" . ($month + 1) . "-01";


		$first_day_falls_on = date("N", $month_start_date);

		$days_in_month = date("t", $month_start_date);

		$month_end_date = strtotime($year . "-" . $month . "-" . $days_in_month);

		$start_week_offset = $first_day_falls_on - $this->week_start;
		$prepend = ( $start_week_offset < 0 )? 7 - abs($start_week_offset) : $first_day_falls_on - $this->week_start;

		$last_day_falls_on = date("N", $month_end_date);

		$output='
		<table width=100% id="the_cal_header" >
			<tr>
				<td align=left><a id="prev" rel="nofollow" href="?date='.$link_pre.'" title="'.$short_pre_month.'">Prev</a></td>
				<td align=center><center><b>'. ucfirst(strftime("%B ", $month_start_date)) .' '.$year.'</b><center></td>
				<td align="right" style="text-align:right"><a id="next" rel="nofollow" href="?date='.$link_next.'" title="'.$short_next_month.'">Next</a></td>
			</tr>
		</table>';
						
		
		$output .= '
						<table summary="Calendar" width=100% id="the_cal">';
		$output .=		'
						<thead >
							<tr >
                                <th abbr="Sunday" scope="col" title="Sunday">Su</th>
								<th abbr="Monday" scope="col"  title="Monday">Mo</th>
								<th abbr="Tuesday" scope="col" title="Tuesday">Tu</th>
								<th abbr="Wednesday" scope="col" title="Wednesday">We</th>
								<th abbr="Thursday" scope="col" title="Thursday">Th</th>
								<th abbr="Friday" scope="col" title="Friday">Fr</th>
								<th abbr="Saturday" scope="col" title="Saturday">Sa</th>

							</tr>';
        
        $output .= "<thead>\n";
		
        $col = '';
		$th = '';
		for( $i=1,$j=$this->week_start,$t=(3+$this->week_start)*86400; $i<=7; $i++,$j++,$t+=86400 ){
			$localized_day_name = gmstrftime('%A',$t);
			$col .= "<col class=\"" . strtolower($localized_day_name) ."\" />\n";
			$j = ( $j == 7 )? 0 : $j;
		}
		$tfoot ="
			";

		$output .= $col;


		
		$output .= "<tr>\n";

		$output .= $th;

		$output .= "</tr>\n";
		$output .= "</thead>\n";
		$output .= $tfoot;

		$output .= "<tbody style='background:#F2F2F2;padding:5'>\n";
		$output .= "<tr>\n";

		$weeks = 1;

		for($i=1;$i<=$prepend;$i++){
			$output .= "\t<td class=\"pad\">&nbsp;</td>\n";
		}


		for($day=1,$cell=$prepend+1; $day<=$days_in_month; $day++,$cell++){


			if( $cell == 1 && $day != 1 ){
				$output .= "<tr>\n";
			}


			$day = str_pad($day, 2, '0', STR_PAD_LEFT);
			$day_date = $year . "-" . $month . "-" . $day;


			if( $this->mark_today == TRUE && $day_date == date("Y-m-d") ){
				$classes[] = $this->today_date_class;
			}

			if( $this->mark_selected == TRUE && $day_date == $this->date ){
				$classes[] = $this->selected_date_class;
			}

			if( $this->mark_passed == TRUE && $day_date < date("Y-m-d") ){
				$classes[] = $this->passed_date_class;
			}

			if( is_array($this->highlighted_dates) ){
				if( in_array($day_date, $this->highlighted_dates) ){
					$classes[] = $this->default_highlighted_class;
				}
			}


			if( isset($classes) ){
				$day_class = ' class="';
				foreach( $classes AS $value ){
					$day_class .= $value . " ";
				}
				$day_class = substr($day_class, 0, -1) . '"';
			} else {
				$day_class = '';
			}


			$output .= "\t<td" . $day_class . " title=\"" . ''./*ucwords(strftime("%A, %B %e, %Y", strtotime($day_date)))*/  "\">";


			unset($day_class, $classes);
			$day = (int) $day;

			switch( $this->link_days ){
				case 0 :
					$output .= $day;
				break;

				case 1 :
					if( empty($this->formatted_link_to) ){
						$output .= "<a href=\"" . $this->link_to . "/event/?date=" . $day_date . "\">" . $day . "</a>";
					} else {
						$output .= "<a href=\"" . strftime($this->formatted_link_to, strtotime($day_date)) . "\">" . $day . "</a>";
					}
				break;

				case 2 :
					if( is_array($this->highlighted_dates)) {
						$index = 0;
						$events = '<small><b>Event dates</b> <br>';
                        $date_links = array();
                        $final_date = array();
						for($i =0,$count = count($this->highlighted_dates); $i <= $count;$i++) {
							if($i != 0)
							if($day_date ==  $this->highlighted_dates[$i-1]['date']) {
                                //$final_date[] = $this->highlighted_dates[$i-1]['end_date'];

								$index = $i;
								//*** MUTILPLE EVENTS PER DAY HACK
									$events .= $this->highlighted_dates[$i-1]['event'] .'<br />'. $this->highlighted_dates[$i-1]['event'] .'<br><i>'.$this->highlighted_dates[$i-1]['date'].'</i><br><hr>' ;
								//***
							}
						}
                        $multi_links = implode(',',$date_links);


						if( $index ){


							if( empty($this->formatted_link_to) ) {
                                $output .= "<a  class='selected' title='{$events}'\" href=\"#" . $multi_links . "\">";
							
                            } else {
								$output .= "<a href=\"#" . strftime($this->formatted_link_to, strtotime($day_date)) . "\">";
							}
						}
					}


					$output .= $day;

					if( is_array($this->highlighted_dates) ){
						if( in_array($day_date, $this->highlighted_dates) ){
							if( empty($this->formatted_link_to) ){
								$output .= "</a>";
							} else {
								$output .= "</a>";
							}
						}
					}
				break;
			}


			$output .= "</td>\n";

			if( $cell == 7 ){
				$output .= "</tr>\n";
				$cell = 0;
			}

		}


		if( $cell > 1 ){
			for($i=$cell;$i<=7;$i++){
				$output .= "\t<td class=\"pad\">&nbsp;</td>\n";
			}
			$output .= "</tr>\n";
		}


		$output .= "</tbody>\n";
		$output .= "</table><br />\n";


		return $output;

	}

}
?>