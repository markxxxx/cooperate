<?php

function smarty_modifier_time_since($time)
{

      if(!is_numeric($time)) {
        $time = strtotime($time);
        //echo $time;
      }
      
      $now = time();
	  $now_day = date("j", $now);
	  $now_month = date("n", $now);
	  $now_year = date("Y", $now);
	  $time_day = date("j", $time);
	  $time_month = date("n", $time);
	  $time_year = date("Y", $time);
	  $time_since = "";
	  $lang_var = 0;

	  switch(TRUE) {
	  
	    case ($now-$time < 60):
	      // RETURNS SECONDS
	      $seconds = $now-$time;
	      $time_since = $seconds;
	      return "A few seconds ago";
	      break;
	    case ($now-$time < 3600):
	      // RETURNS MINUTES
	      $minutes = round(($now-$time)/60);
	      $time_since = $minutes;
          if($minutes == 1) {
            return "1 minute ago";
          } else {
            return "{$minutes} minutes ago";
          }
          
	      break;
	    case ($now-$time < 86400):
	      // RETURNS HOURS
	      $hours = round(($now-$time)/3600);
	      $time_since = $hours;
            if($hours == 1) {
                return "1 hour ago";
            } else {
            return "{$hours} hours ago";
            }
	      break;
	    case ($now-$time < 1209600):
	      // RETURNS DAYS
	      $days = round(($now-$time)/86400);
	      $time_since = $days;
            if($days == 1) {
                return "1 day ago";
            } else {
            return "{$days} days ago";
            }
	      break;
	    case (mktime(0, 0, 0, $now_month-1, $now_day, $now_year) < mktime(0, 0, 0, $time_month, $time_day, $time_year)):
	      // RETURNS WEEKS
	      $weeks = round(($now-$time)/604800);
	      $time_since = $weeks;
	        if($weeks == 1) {
                return "1 week ago";
            } else {
            return "{$weeks} weeks ago";
            }
	      break;
	    case (mktime(0, 0, 0, $now_month, $now_day, $now_year-1) < mktime(0, 0, 0, $time_month, $time_day, $time_year)):
	      // RETURNS MONTHS
	      if($now_year == $time_year) { $subtract = 0; } else { $subtract = 12; }
	      $months = round($now_month-$time_month+$subtract);
	      $time_since = $months;
	            
            if($months == 1) {
                return "1 month ago";
            } else {
            return "{$months} months ago";
            }
	      break;
	    default:
	      // RETURNS YEARS
	      if($now_month < $time_month) { 
	        $subtract = 1; 
	      } elseif($now_month == $time_month) {
	        if($now_day < $time_day) { $subtract = 1; } else { $subtract = 0; }
	      } else { 
	        $subtract = 0; 
	      }
	      $years = $now_year-$time_year-$subtract;
	      $time_since = $years;
	                  if($years == 1) {
                return "1 year ago";
            } else {
            return "{$years} years ago";
            }
	      if($years == 0) { $time_since = ""; $lang_var = 0; }
	      break;

	  }

}

?>