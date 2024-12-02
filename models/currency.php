<?php 
class Currency {

	private $cahce = array();
	public $convert_to = false;

	public function __construct() {
		
		$exchange_rate = Cache::get('exchange_rates');

		$this->cache = is_array($exchange_rate) ? $exchange_rate : array(); 

		if(isset($_SESSION['convert_to'])) {
			$this->convert_to = $_SESSION['convert_to'];
		}
	}
    
    public function getInstance() {
    	
    	static $instant;
    	if(!is_object($instant)) {
    		$instant = new Currency();
    	}
    	return $instant;

    }

    public static function exchange_rate($to = 'USD', $from = 'ZAR') {

    	$_this = Currency::getInstance();

    	if(isset($_this->cache[$to][$from])) {

    		return $_this->cache[$to][$from];

    	} else {
    		$_this->cache[$to][$from] = json_decode(file_get_contents("http://rate-exchange.appspot.com/currency?from={$from}&to={$to}"));
    		Cache::set('exchange_rates', $_this->cache, 5 * HOURS);
    		return $_this->cache;
    	}

    }

    public static function convert_to($currency) {
    	$_this = Currency::getInstance();
    	$_this->convert_to = $currency;
    	$_SESSION['convert_to'] = $currency;
    }


    public static function is_set() {

        if($_this->convert_to === false) {
            return false;
        } else {
            return true;
        }

    }

    public  function get() {
        return Currency::getInstance()->convert_to;
    }

    public static function convert_array($domain_id, $array_to_convert, $key) {


    	$_this = Currency::getInstance();

    	if($_this->convert_to !== false)
    	$domain = Domain::getInstance($domain_id);

    	if($domain->currency == $_this->convert_to) {
    		return $array_to_convert;
    	} else {
    		
    		$rates = Currency::exchange_rate($_this->convert_to ,$domain->currency);


    		foreach($array_to_convert as &$values) {
    			$values[$key] = $rates->rate * $values[$key];
    		}

    		
    	}

    	return $array_to_convert;

    }

    public static function convert($domain_id, $value) {

    	$_this = Currency::getInstance();
    	if($_this->convert_to === false) {
    		return $value;
    	}
    	
    	$domain = Domain::getInstance($domain_id);

    	if($domain->currency == $_this->convert_to) {
    		return $value;
    	} else {
    		$rates = Currency::exchange_rate($_this->convert_to ,$domain->currency);
    		return $rates->rate * $value;
    	}

    }



}







?>