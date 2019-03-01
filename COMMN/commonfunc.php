<?php
if(!function_exists('is_conver_currency')){
	function is_conver_currency(){
		global $conn;	 

		$convert_currency = 0;
	if(isset($_SESSION['uname'])){
	$logindb = $conn->prepare("SELECT * FROM `login_secure` WHERE uname = ?");
	$logindb->execute(array($_SESSION['uname']));
	$row_logindb = $logindb->fetch(PDO::FETCH_ASSOC);
	if($row_logindb['gcode'] != 'ADMIN'){
	if($row_logindb['gcode'] == 'DISTRB'){
	$table = "distributor_pro";
	$id='distr_id';
	}
	elseif($row_logindb['gcode'] == 'AGENT'){
		$table = "agent_pro";
		$id='agent_id';
	}
		
				$login_country_db = $conn->prepare("SELECT * FROM `".$table."` WHERE ".$id." = ?");
				$login_country_db->execute(array($_SESSION['uname']));
				$row_login_country_db = $login_country_db->fetch(PDO::FETCH_ASSOC);
				
				if(!(empty($row_login_country_db['coun'])  || $row_login_country_db['coun'] == "IN")){
					
					$convert_currency = 1;
					}
			}
			else{
				$convert_currency = 1;
			}
		}
		return $convert_currency;
	}
}

if(!function_exists('convert_currency')){

	function convert_currency($price,$plan_id=""){
		
	global $conn;	 
		$convert_currency = is_conver_currency();
		if($convert_currency){
			if(!empty($plan_id)){
				$currencydb = $conn->prepare("SELECT currency_rate FROM travel_master WHERE plan_id =?");
		$currencydb->execute(array($plan_id));
			}
			else{
		$currencydb = $conn->prepare("SELECT currency_rate FROM dvi_front_settings WHERE sno =1");
		$currencydb->execute();
		}

		$row_currencydb = $currencydb->fetch(PDO::FETCH_ASSOC);

		if($row_currencydb['currency_rate']){
		return ceil($price/$row_currencydb['currency_rate']); 
		}
		return $price;
		}
	return $price;
	}
}
if(!function_exists('convert_currency_text')){
	function convert_currency_text($priceText,$plan_id=""){
		global $conn;
		$convert_currency = is_conver_currency();
		if(!empty($plan_id)){
			$currencydb = $conn->prepare("SELECT currency_rate FROM travel_master WHERE plan_id =?");
	$currencydb->execute(array($plan_id));
	$row_currencydb = $currencydb->fetch(PDO::FETCH_ASSOC);
	if(!$row_currencydb['currency_rate'])
		$convert_currency=0;
		}
		if($convert_currency){
			if(strtolower($priceText) == "rs")
			return "$";
			if(strtolower($priceText) == "rupees")
				return "Dollars";
			if(strtolower($priceText) == "&#8377;")
				return "$";
			if(strtolower($priceText) == "<i class='fa fa-inr'></i>")
				return "$";
		}
		return $priceText;
	}
}
if(!function_exists('get_timings')){
	function get_timings(){
		global $conn;
		$timing_settings = $conn->prepare("SELECT arr_time,dep_time  FROM dvi_front_settings WHERE sno =1");
		$timing_settings->execute();
		$row_timing_settings = $timing_settings->fetch(PDO::FETCH_ASSOC);
		return $row_timing_settings;
		
	}
}

if(!function_exists('check_arrival_transfer')){
	function check_arrival_transfer($plan_id){
		global $conn;
		$row_timing_settings = get_timings();
		$arr_trns = $conn->prepare("SELECT *  FROM travel_master WHERE substring_index(STR_TO_DATE(tr_arr_time, '%l:%i %p'),':',1) >= ? and plan_id = ? ORDER BY sno DESC");
		$arr_trns->execute(array($row_timing_settings['arr_time'],$plan_id));
		$row_arr_trns = $arr_trns->fetch(PDO::FETCH_ASSOC);
		$total_arr_trns = $arr_trns->rowCount();
		return ($total_arr_trns);
		
	}
}

if(!function_exists('check_departure_transfer')){
	function check_departure_transfer($plan_id){
		global $conn;
		$row_timing_settings = get_timings();
		$dep_trns = $conn->prepare("SELECT *  FROM travel_master WHERE substring_index(STR_TO_DATE(trv_depatr_time, '%l:%i %p'),':',1) <= ? and plan_id = ? ORDER BY sno DESC");
		$dep_trns->execute(array($row_timing_settings['dep_time'],$plan_id));
		$row_dep_trns = $dep_trns->fetch(PDO::FETCH_ASSOC);
		$total_dep_trns = $dep_trns->rowCount();
		return ($total_dep_trns);
		
	}
}



if(!function_exists('decode_unserialize')){
	function decode_unserialize($str){
		return unserialize(base64_decode($str));
		
	}
}
?>