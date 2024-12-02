<?php

class Filter {

	private $filters = array();

	public function __construct() {
		if(isset($_SESSION['dashboard_filters'])) {
			$this->filters = $_SESSION['dashboard_filters']; 
		}
	}

	public static function getInstance() {
		static $instant = null;
		if(!is_object($instant)) {
			$instant = new Filter();
		}
		return $instant;
	}

	static public function clear() {
		$_this = Filter::getInstance();
		$_this->filters = $_SESSION['dashboard_filters'] = array();
	}

	static public function count() {
		$_this = Filter::getInstance();
		return $_this->filters;
	}

	static public function set($key = false , $value = false) {
		$_this = Filter::getInstance();
		if(is_array($key)) {
			foreach($key as $k => $v) {
				if(is_array($v)) {
					$_this->filters[$k] = $v;
				} elseif(strlen($v)) {
					$_this->filters[$k] = $v;
				}
			}
		} else {
			$_this->filters[$key] = $value;
		}
		$_SESSION['dashboard_filters'] = $_this->filters;
	}

	static public function get($key = false) {

		$_this = Filter::getInstance();

		if(!$key) {
			return $_this->filters;
		}

		if(isset($_this->filters[$key])) {
			return $_this->filters[$key];
		}
		return array();

	}

	static public function remove($key = false , $option = false) {
		
		$_this = Filter::getInstance();

		if(!$option || !is_array($_this->filter[$key])) {
			unset($_this->filters[$key]);
		} else {

			if(($index = array_search($option,$_this->filters[$key])) !== false) {
				unset($_this->filters[$key][$index]);
				$_this->filters[$key] = array_values($_this->filters[$key]);
				if(!count($_this->filters[$key])) {
					unset($_this->filters[$key]);
				}


			}

		}
		$_SESSION['dashboard_filters'] = $_this->filters;

	}

}
?>