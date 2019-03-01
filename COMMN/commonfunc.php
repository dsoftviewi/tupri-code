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
?>