<?php
include("core/session.php");
require_once("Connections/divdb.php");
include("COMMN/smsfunc.php");

$timezone = new DateTimeZone("Asia/Kolkata" );
$date = new DateTime();
$date->setTimezone($timezone );
$mm=$date->format('m');
$yy=$date->format('Y');
$mon=$date->format('F');
$dd=$date->format('m/d/Y');

if(isset($_GET['ty']) && $_GET['ty']==1)
{ 
	/*$uname=$_GET['uname'];
	$pwd=$_GET['passwd'];
	
	mysql_select_db($database_divdb, $divdb);
	$query_user = "SELECT * FROM  login_secure where uname='$uname' and passwd= '".md5($pwd)."'";
	$user = mysql_query($query_user, $divdb) or die(mysql_error());
	$totalRows_user = mysql_num_rows($user);

	if($totalRows_user == 1)
	{
		echo "found";	
	}
	else
	{
		echo "not";
	}
	*/
	
	if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

// *** Validate request to login to this site.
/*if (!isset($_SESSION)) {
  session_start();
}
*/
/*$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}
*/
$err_msg = '';
$uname=$_GET['uname'];
$pwd=$_GET['passwd'];
$rempwd = $_GET['remember'];
//  $loginUsername=$_POST['uname'];
//  $password=$_POST['passwd'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "dashboard.php";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = false;
    
  $LoginRS=$conn->prepare("SELECT * FROM login_secure WHERE email_id=? AND passwd=?");
  $LoginRS->execute(array($uname,md5($pwd)));
  $row=$LoginRS->fetch(PDO::FETCH_ASSOC);
  $loginFoundUser = $LoginRS->rowCount();
  if ($loginFoundUser > 0) {
	  
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    //$_SESSION['MM_Username'] = $uname;
    //$_SESSION['MM_UserGroup'] = $loginStrGroup;	
	ini_set('session.gc_maxlifetime', 3600*24);
	$_SESSION['uid'] = $row['uid'];
echo $_SESSION['grp'] = $row['gcode'];
	$_SESSION['name'] = $row['nname'];
	$_SESSION['uname'] = $row['uname'];

	//setcookie("grp",$row['gcode'],time()+(3600*24));
	
	if(isset($_GET['remember']) && $_GET['remember']=='1')
	{
		setcookie("rem_user",$uname,time()+(3600*24));
		setcookie("rem_pwd",$pwd,time()+(3600*24));
	}
	else
	{
		if (isset($_COOKIE['rem_user']))
		{
			setcookie('rem_user', '', time()-3600);
		}
		if (isset($_COOKIE['rem_pwd']))
		{
			setcookie('rem_pwd', '', time()-3600);
		}
	}

    /*if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }*/
  }
  else {
	 echo "not";
  }
} 

if(isset($_GET['ty']) && $_GET['ty']==2)
{ 
	$checking;
 	$email_var=trim($_GET['email']);
	//$query_email_agt = "SELECT * FROM  agent_pro where email_id='$email_var' and status < 2";
	$email_agt = $conn->prepare("SELECT * FROM  agent_pro where email_id=?");
	$email_agt->execute(array($email_var));
	$totalRows_email_agt = $email_agt->rowCount();
	
	if($totalRows_email_agt==0)
	{
		//$query_email_dst = "SELECT * FROM  distributor_pro where email_id='$email_var' and status < 2";
		$email_dst = $conn->prepare("SELECT * FROM  distributor_pro where email_id=?");
		$email_dst->execute(array($email_var));
		$totalRows_email_dst = $email_dst->rowCount();
		if($totalRows_email_dst==0)
		{
			$checking='yes'; //allow to proceed
		}else{
			$checking='no'; //not llow to proceed
		}
	}else{
	$checking='no'; // not allow to proceed	
	}
	echo $checking;
}

if(isset($_GET['ty']) && $_GET['ty']==3)
{ 
	
	$timezone = new DateTimeZone("Asia/Kolkata" );
$date = new DateTime();
$date->setTimezone($timezone );
$mm=$date->format('m');
$yy=$date->format('Y');
$mon=$date->format('F');
$dd=$date->format('m/d/Y');

$ip_loctioan='';

$ip=$_SERVER['REMOTE_ADDR'];
$ch = curl_init("http://ipinfo.io/$ip/json");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
$output = curl_exec($ch);
$out=json_decode($output);
//print_r($out);
// echo $ip;
// echo $out->ip;
// echo $out->city;
// echo $out->region;
// echo $out->country;
if($out!=''){
$ip_loctioan=$_SERVER['REMOTE_ADDR'].' - '.$out->org.', '.$out->country.', '.$out->region.', '.$out->city;
}else {
	$ip_loctioan='Unable to get location';
}
//$ip_loctioan=$out->loc;

// $ip = $_SERVER['REMOTE_ADDR']; 
// $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
// if($query && $query['status'] == 'success') {
// $ip_loctioan=$_SERVER['REMOTE_ADDR'].' - '.$query['query'].', '.$query['isp'].', '.$query['org'].', '.$query ['country'].', '.$query['regionName'].', '.$query['city'].'!';
// } else {
// $ip_loctioan='Unable to get location';
// }
	//$ip_loctioan='Unable to get location';

	// $query = @unserialize(file_get_contents("https://geoip-db.com/json/geoip.php?jsonp=callback"));
	//print_r($query);
	// $ch = curl_init("https://timezoneapi.io/api/ip");
	// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
	// $output = curl_exec($ch);
	// $output=json_decode($output);
	// $ip_loctioan=$output->data->city.','.$output->data->state;
	
	$perc_sett = $conn->prepare("SELECT * FROM employee_setting ");
	$perc_sett->execute();
	//$row_perc_sett = mysql_fetch_assoc($perc_sett);
	$row_perc_sett_main=$perc_sett->fetchAll();
	$tot_perc_sett= $perc_sett->rowCount();
	
	if($tot_perc_sett<=3) // if employee_setting is empty
	{
	if($_POST['person'] == '0')//for agent registration 
	{
		$vehid = $conn->prepare("SELECT * FROM setting_ids  where sno =9");
		$vehid->execute();
		$row_vehid = $vehid->fetch(PDO::FETCH_ASSOC);
		$id=$row_vehid['id_name'].$row_vehid['id_number'];
		$idin=$row_vehid['id_number']+1;
	
	if($_POST['agn_state']=='nil')
	{
		$_POST['agn_state']='';
	}
	if($_POST['agn_landline']=='')
	{
		$_POST['agn_landline']=$_POST['agn_mobile'];
	}
	 foreach($row_perc_sett_main as $row_perc_sett)
	{
		if($row_perc_sett['employee']=='Agent')
		{
			$agent_def_perc=$row_perc_sett['percentage'];
		}else if($row_perc_sett['employee']=='Admin_Markup_To_AGT')
		{
			$admin_prof_perc=$row_perc_sett['percentage'];
		}
	}
	
	$profile='default.jpg';
	
		// $insertSQLupd='insert into agent_pro (agent_id, distr_id, agent_fname, agent_lname, agent_addr, comp_name, state, city, land_line, mobile_no, email_id, agent_img, my_percentage, brokerage_perc, ip_addr, status) values("'.$id.'","'.$_POST['distributor'].'","'.$_POST['agn_fname'].'", "'.$_POST['agn_lname'].'","'.$_POST['addr'].'", "'.$_POST['agn_cname'].'", "'.$_POST['agn_state'].'","'.$_POST['hotel_city'].'", "'.$_POST['agn_landline'].'", "'.$_POST['agn_mobile'].'", "'.$_POST['agn_email'].'", "'.$profile.'", "'.$agent_def_perc.'","'.$admin_prof_perc.'","'.$ip_loctioan.'","1" )';
		 $insertSQLupd=$conn->prepare('insert into agent_pro (agent_id, distr_id, agent_fname, agent_lname, agent_addr, comp_name, coun, city, land_line, mobile_no, email_id, agent_img, my_percentage, brokerage_perc, ip_addr, status) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,"1" )');
         $insertSQLupd->execute(array($id,$_POST['distributor'],$_POST['agn_fname'],$_POST['agn_lname'],$_POST['addr'],$_POST['agn_cname'],$_POST['agn_count'],' ',$_POST['agn_landline'],$_POST['agn_mobile'],$_POST['agn_email'],$profile,$agent_def_perc,$admin_prof_perc,$ip_loctioan));
		
			//Update setting ids
		$insertSQLupd=$conn->prepare('update setting_ids set id_number=? where sno=9');
		$insertSQLupd->execute(array($idin));
		$vip="AGENT";
		$vvip="Agent";
		$v_img="agent_img";
		
	}else
	{
		
		$vehid = $conn->prepare("SELECT * FROM setting_ids  where sno =10");
		$vehid->execute();
		$row_vehid = $vehid->fetch(PDO::FETCH_ASSOC);
		$id=$row_vehid['id_name'].$row_vehid['id_number'];
		$idin=$row_vehid['id_number']+1;
			
	if($_POST['agn_state']=='nil')
	{
		$_POST['agn_state']='';
	}
	
	foreach($row_perc_sett_main as $row_perc_sett)
	{
		if($row_perc_sett['employee']=='Admin_Markup_To_AGT')//'Distr'
		{
			//$dist_def_perc=$row_perc_sett['percentage'];
			$dist_def_perc=$row_perc_sett['percentage'];
		}
	}
	
	$profile='default.jpg';
	
	$insertSQLupd=$conn->prepare('insert into distributor_pro (distr_id, distr_fname, distr_lname, distr_addr, comp_name, state, city, land_line, mobile_no, email_id, distr_img,  my_percentage, ip_addr, status) values(?,?,?,?,?,?,?,?,?,?,?,?,?, "1" )');
	$insertSQLupd->execute(array($id,$_POST['agn_fname'],$_POST['agn_lname'],$_POST['addr'],$_POST['agn_cname'],$_POST['agn_state'],$_POST['hotel_city'],$_POST['agn_landline'],$_POST['agn_mobile'],$_POST['agn_email'],$profile,$dist_def_perc,$ip_loctioan));
				
		 //Update setting ids
		$insertSQLupd=$conn->prepare('update setting_ids set id_number=? where sno=10');
		$insertSQLupd->execute(array($idin));
		$vip="DISTRB";
		$vvip="Distributor";
		$v_img="distributor_img";
	}
	
	//mail config - start
	
	$stringData ="<html><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Untitled Document</title></head><body><table width='90%' border='0' align='center' cellpadding='2' cellspacing='3';>  <tr>    <td colspan='3' style='font-family: Arial, Helvetica, sans-serif;	font-size: 24px;	font-weight: bold;	color: #960;'><span style='margin-top:20px; padding-top:30px'>New ".$vvip." Request is pending!</span></td><td width='1%' rowspan='4' align='center' valign='middle'>&nbsp;</td></tr><tr align='center'><td height='4' colspan='4' style='border-bottom: solid #ccc 2px; float:left; width:100%;'> </td></tr><tr><td colspan='4'><table width='100%' border='0' cellpadding='3' cellspacing='4' style='border:1px solid #eeeeee; background-color: #FAFAFA'><tr><td colspan='3'><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;	font-weight: bold;	color: #000000;'><span style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 16px;	font-weight: bold;	color: #000000; padding-left:20px;'>Dear <span style='font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 16px;	font-weight: bold;	color: green;'>".$_POST['agn_fname'].' '.$_POST['agn_lname']."</span>,</span></p></td></tr><tr> <td width='7%'></td><td width='83%'><p><span style='color:blue'> Do View Holidays welcomes you to our family! You are now registered with us and can login to our system with below credentials... </span><br>  Please hold on until your registration gets approved.</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;color: #000000;'> With Regards,<br/>&nbsp;</p><table style='font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;'><tr><td width='244'>[DVI Administrator]</td></tr><tr><td>DoView Holidays India Pvt. Ltd.</td></tr></table>&nbsp;</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;font-size: 12px; font-weight: bold; color: '#CC6600;'>Please feel free to raise any queries on <a href='mailto:support@dvi.co.in'>support@dvi.co.in</a>.</p></td><td width='10%'>&nbsp;</td></tr><tr><td height='26'>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></table></td></tr><tr><td colspan='4'><span style='font-family: Arial, Helvetica, sans-serif;	font-size: 11px;	font-weight: normal;	color: #000000;'>Questions? Go to the Help Centre at: </span><a href='http://dvi.co.in' style='font-family: Arial, Helvetica, sans-serif;	font-size: 11px;	font-weight: normal;  color: #000000;'>DoView Holidays</a><br /><span style='font-family: Arial, Helvetica, sans-serif;	font-size: 12px; font-weight: bold;	color: #000000;'>Copyright &copy; ".$yy." DoView Holidays (India) Private Limited. All rights reserved.</span></td></tr></table></body></html>";


	//$stringData_age ="<html><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'/><title>Dvi Holidays</title></head><body><table width='90%' border='0' align='center' cellpadding='2' cellspacing='3';> <tr><td colspan='4'><table width='100%' border='0' cellpadding='3' cellspacing='4' style='border-style:solid; border-color:#01B7F2 #eeeeee #eeeeee; border-width:3px 2px 2px;background-color: #FAFAFA'><tr><td colspan='3'><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;font-size: 14px;font-weight: bold;color: #000000;'><span style='font-family: Geneva, Arial, Helvetica, sans-serif;font-size: 16px;font-weight: bold;color: #000000; padding-left:20px;'>Dear <span style='font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 16px;	font-weight: bold;	color: green;'>".$_POST['agn_fname'].' '.$_POST['agn_lname']."</span>,</span></p></p></td></tr><tr> <td width='7%'></td><td width='83%'><p style='text-align:justify;'>We welcome you to the world of difference the C Cube - Powered by <span style='color:#411957; font-weight:bold;'>Dvi Holidays!!</span></p><p style='text-align:justify; line-height:25px;'>We are pure B2B Travel agent with Expertise in travel trade in Kerala, Karnataka , Tamilnadu , Andhra Pradesh & Telangana with strong hold in Hotels , Own Fleet , Own house boat, With proprietary Software named CCUBE ( Create, Compare and confirm ) system which give you the quote with live inventory in Minutes (Live inventory expected to be online from 15th Nov 2016) which is best in the Current market, We request you to give us an opportunity to show you our good quality services in terms of costing, Itinerary, transportation, coordination etc. <p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;font-size: 14px;color: #000000;'>Best Regards,<br/>&nbsp;</p><table style='font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;'><tr><td width='244'>Srinivas Vemuri</td></tr><tr><td>Director</td></tr><tr><td>Contact No: (+91)-98-432-88-844</td></tr><tr><td><a href='mailto:vsr@v-i.in'>vsr@v-i.in</a></td></tr><tr><td><a href='http://www.dvi.co.in' target='_blank'>dvi.co.in</a></td></tr></table></td><td width='7%'></td></tr></table></td><td width='7%'></td></tr></table></body></html>";


$stringData_age ="<html><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Dvi Holidays</title></head><body><table width='90%' border='0' align='center' cellpadding='2' cellspacing='3'><tr><td colspan='4'><table width='100%' border='0' cellpadding='3' cellspacing='4' style='border-style:solid; border-color:#0081ac #eeeeee #eeeeee; border-width:3px 2px 2px;background-color:#01B7F2;padding-bottom:25px;'><tr><td colspan='3'><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;font-size: 14px;font-weight: bold;color: #000000;'><span style='font-family: Geneva, Arial, Helvetica, sans-serif;font-size: 16px;font-weight: bold;color: #000000; padding-left:20px;'>Dear <span style='font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 16px;	font-weight: bold;	color: green;'>".$_POST['agn_fname'].' '.$_POST['agn_lname']."</span>,</span></p></p></td></tr><tr><td width='1%'></td><td width='83%' style='background:#FAFAFA;padding:20px;border-radius:10px;'><p style='text-align:justify;'>We welcome you to the world of difference the C Cube - Powered by <span style='color:#411957; font-weight:bold;'>Dvi Holidays!!</span> ( Formally known as Doview Holidays India Pvt ltd)</p><p style='text-align:justify; line-height:25px;border-bottom:1px solid #ddd;padding-bottom:15px;'>We are pure B2B Travel agent with Expertise in travel trade in Kerala, Karnataka , Tamilnadu , Andhra Pradesh & Telangana with strong hold in Hotels , Own Fleet , Own house boat, With proprietary Software named CCUBE ( Create, Compare and confirm ) system which give you the quote with live inventory in Minutes (Live inventory expected to be online from 01st May 2017) which is best in the Current market.</p><p style='text-align:justify; line-height:5px;'><strong>What is C Cube</strong></p><p style='text-align:justify; line-height:25px;border-bottom:1px solid #ddd;padding-bottom:15px;'>C Cube is an online travel platform, which helps travels agents, Clients to create their own personalized itinerary costing with basic computer knowledge and Basic English, Not necessary to have in depth knowledge travel or hospitality industry. </p><p style='text-align:justify; line-height:5px;'><strong>C Cube is short form of Create, Compare & Confirm</strong></p><p style='text-align:justify; line-height:25px;'>C cube helps agents and clients to create detailed itinerary in a minute ( Itinerary Includes transportation, Hotels) in a minute in South India</p><p style='text-align:justify; line-height:5px;'>C cube helps agents and clients to compare their personalized itinerary cost with any other travel agents, online /off line.</p><p style='text-align:justify; line-height:25px;border-bottom:1px solid #ddd;padding-bottom:15px;'>With C cube Travel agents / Clients can confirm their itinerary in a minute with guaranteed availability of Road, Rail, Air, Cruise, Hotels, Guides, Monuments entrances & Airport assistance. Moreover C cube provides options to reach the local representative in one touch in case of any emergency.</p><p style='text-align:justify; line-height:5px;'><strong>Why C Cube</strong></p><p style='text-align:justify; line-height:25px;'>C cube enables Travel agents to create the optimized itinerary as per their preferences and requirements. It takes few seconds to make travel plans which is unique and first time available in Travel Industry.</p><p style='text-align:justify; line-height:5px;'>C cube make sure competitive price for both pre-planned and last minute itinerary which saves Time, Money, & Energy.</p><p style='text-align:justify; line-height:25px;'>The uniqness of C cube is providing platform to get costing for N number of combinations of different transportations, Different combination of Vehicles, Hotels, Category of Hotel rooms with Special amenities as per the requirement, Home stays, Different language guides and Assistance.</p><p style='text-align:justify; line-height:5px;'>C cube ensures 100% availability of hotel and transport requirement of agents and clients</p><p style='text-align:justify; line-height:25px;border-bottom:1px solid #ddd;padding-bottom:15px;'>Though we have expertise in Hospitality management and we do also run a hotel brand Plaza Hotels, (www.plazahotels.co.in) A 3star hotel located in the heart of Trichy town, with a total of 72 aesthetically designed, well-furnished and supremely comfortable rooms. This new venture adds one more feather to our cap.</p><p style='text-align:justify; line-height:15px;'><strong>We offer our expert services:</strong></p><p style='text-align:justify; line-height:15px;padding-left: 30px;'>Holidays In India</p><p style='text-align:justify; line-height:15px;padding-left: 30px;'>Hotel bookings India</p><p style='text-align:justify; line-height:15px;padding-left: 30px;'>Transportation services all over India with own fleet in South India</p><p style='text-align:justify; line-height:15px;padding-left: 30px;border-bottom:1px solid #ddd;padding-bottom:15px;'>Guide services all Over India </p><p style='text-align:justify; line-height:15px;'><strong>Our Web portal which is expert in creating Itinerary & costing In minutes</strong></p><p style='text-align:justify; line-height:15px;'>- C CUBE ( Create compare and confirm) helps to create detailed itinerary and quote in a minutes. </p><p style='text-align:justify; line-height:15px;'>- Agent can create quote along with detailed itinerary in minutes which helps to give best quotes to the guest on time. </p><p style='text-align:justify; line-height:15px;'>- In C cube Agent can get different options with shortest & best suggested routes.</p><p style='text-align:justify; line-height:15px;'>- In C cube Agent can create the itinerary with VIA routes & Day trips</p><p style='text-align:justify; line-height:15px;'>- C cube has option to choose different vehicle in different locations</p><p style='text-align:justify; line-height:15px;'>- In c cube for one itinerary you can get the cost for combination of different variety and number of vehicles for large groups. </p><p style='text-align:justify; line-height:15px;'>- C Cube generetes different hotel options of quotes (Standard Hotel, 03 Star hotel , 04 star , etc) </p><p style='text-align:justify; line-height:15px;'>- Agents can have freedom to compare the rates with other vendors in minutes.</p><p style='text-align:justify; line-height:15px;'>- Connected with own, Contracted Fleet & Hotels with guaranteed inventory at the back end with the cheapest prices.</p><p style='text-align:justify; line-height:15px;'>- Franchises able to make more income on creating sub agents and confirming itineraries</p><p style='text-align:justify; line-height:15px;'>- Travel agencies are not required to pay any deposits.</p><p style='text-align:justify; line-height:15px;'>- Travel agency can print vouchers & Itineraries with its own logo</p><p style='text-align:justify; line-height:15px;'>- Travel agency can define its own profit margin in the system.</p><p style='text-align:justify; line-height:15px;'>- Travel agency can open the system to their clients with pre-defined profit margin.</p><p style='text-align:justify; line-height:15px;'>- Agents can save time and money in generating the quote.</p><p style='text-align:justify; line-height:15px;'>- Marketing activities (websites, SEO, brochures) and local sales will be supported by dvi</p><p style='text-align:justify; line-height:15px;border-bottom:1px solid #ddd;padding-bottom:15px;'>Looking forward for an opportunity to show our quality services.</p><p style='text-align:justify; line-height:15px;'><strong>About C cube - The booking Engine  </strong></p><p style='text-align:justify; line-height:15px;border-bottom:1px solid #ddd;padding-bottom:15px;'>https://www.youtube.com/watch?v=j2sSojSFBxY</p><p style='text-align:justify; line-height:15px;'><strong>Awards winning (https://www.travhq.com/industry/events/c-cube-gtx-and-enrouto-shine-at-the-pune-edition-of-startup-knockdown/) </strong></p><p style='text-align:justify; line-height:15px;border-bottom:1px solid #ddd;padding-bottom:15px;'>Dvi Holidays in Travel news (http://www.travelnewsdigest.in/?p=34567)</p><p style='text-align:justify; line-height:25px;'><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;font-size: 14px;color: #000000;font-weight:bold;'>Best Regards,<br/>&nbsp;</p><table style='font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;padding-bottom:15px;'><tr><td width='244'>Srinivas Vemuri</td></tr><tr><td>Director</td></tr><tr><td>Contact No: (+91)-98-432-88-844</td></tr><tr><td><a href='mailto:vsr@v-i.in'>vsr@v-i.in</a></td></tr><tr><td><a href='http://www.dvi.co.in' target='_blank'>dvi.co.in</a></td></tr></table><table style='border-top:1px solid #ddd;padding-top:15px;'><td><table style='font-family:Verdana, Geneva, sans-serif; font-size:12px;line-height: 23px;'><tr><td width='325' style='font-weight:bold;'>Trichy   - Head Office</td></tr><tr><td>#51, Vijaya Nagar,</td></tr><tr><td> Dheeran Nagar (Extn),</td></tr><tr><td> Karumandapam,</td></tr><tr><td> Trichirappalli,</td></tr><tr><td>Tamilnadu - 620009</td></tr><tr><td><strong>Ph:</strong> 0431-2403615</td></tr><tr><td><strong>Email:</strong> <a href='mailto:vsr@v-i.in'>vsr@v-i.in</a></td></tr></table></td><td><table style='font-family:Verdana, Geneva, sans-serif; font-size:12px;line-height: 23px;'><tr><td width='415' style='font-weight:bold;'>Madurai - Tamil Nadu</td></tr><tr><td>Door No.73, Shop No S6,</td></tr><tr><td>Pon Idhayum Commercial Complex,</td></tr><tr><td>2nd Floor Bye-Pass Road,</td></tr><tr><td>Chokkalinga Nagar, Madurai.</td></tr><tr><td>Tamilnadu - 625 016</td></tr><tr><td><strong>Ph:</strong> 0452-4371607</td></tr><tr><td><strong>H Phone:</strong> +91-999-44-95-914</td></tr><tr><td><strong>Email:</strong> <a href='mailto:satheesh@v-i.in'>satheesh@v-i.in</a></td></tr></table></td><td><table style='font-family:Verdana, Geneva, sans-serif; font-size:12px;line-height: 23px;'><tr><td width='415' style='font-weight:bold;'>Cochin  - Kerala</td></tr><tr><td>KCRWA 134,Pynunkal House 1st Floor ,</td></tr><tr><td>Bhavan School Road,</td></tr><tr><td>Girinagar,</td></tr><tr><td>Kadavanthra, Cochin,</td></tr><tr><td>Kerala - 682020.</td></tr><tr><td><strong>H:</strong> +94-431-64-494</td></tr><tr><td><strong>Email:</strong> <a href='mailto:cochin@v-i.in'>cochin@v-i.in</a></td></tr></table></td></table><p style='text-align:right;'><img src='http://dvi.co.in/images/Dvi Hols.png
'></p></td><td width='1%'></td></tr></table></td></tr></table></body></html>";

	
	$to = $_POST['agn_email'];
	//$to = "elysiumservice24@gmail.com";
	$to1 = "srini@v-i.in";
	$to2 = "vsr@dvi.co.in";
	$from = "DO VIEW HOLIDAYS INDIA PVT. LTD. <vsr@v-i.in>"; 
	$subject="Welcome Message from DVI_Holidays.com";
	$str=send_mail($to,$from,$subject,$stringData_age);
	$str1=send_mail($to1,$from,$subject,$stringData);
	$str2=send_mail($to2,$from,$subject,$stringData);			
	//mail config -end
	$cn=$_POST['agn_fname'].' '.$_POST['agn_lname'];
	/*echo "<script>alert('Thankyou For Your Registration, Check your mail...');</script>";*/
	
	}else{ // if setting_employee table is empty means
		
		$stringData ="<html><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Untitled Document</title></head><body><table width='90%' border='0' align='center' cellpadding='2' cellspacing='3';>  <tr>    <td colspan='3' style='font-family: Arial, Helvetica, sans-serif;	font-size: 24px;	font-weight: bold;	color: #960;'><span style='margin-top:20px; padding-top:30px'>Please set your employee default percentage..</span></td><td width='1%' rowspan='4' align='center' valign='middle'>&nbsp;</td></tr><tr align='center'><td height='4' colspan='4' style='border-bottom: solid #ccc 2px; float:left; width:100%;'> </td></tr><tr><td colspan='4'><table width='100%' border='0' cellpadding='3' cellspacing='4' style='border:1px solid #eeeeee; background-color: #FAFAFA'><tr><td colspan='3'><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;	font-weight: bold;	color: #000000;'><span style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 16px;	font-weight: bold;	color: #000000; padding-left:20px;'>Dear <span style='font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 16px;	font-weight: bold;	color: green;'></span>,</span></p></td></tr><tr> <td width='7%'></td><td width='83%'><p><span style='color:blue'> Do View Holidays welcomes you to our family! You are now registered with us and can login to our system with below credentials... </span><br>  Please hold on until your registration gets approved.</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;color: #000000;'> With Regards,<br/>&nbsp;</p><table style='font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;'><tr><td width='244'>[DVI Administrator]</td></tr><tr><td>DoView Holidays India Pvt. Ltd.</td></tr></table>&nbsp;</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;font-size: 12px; font-weight: bold; color: '#CC6600;'>Please feel free to raise any queries on <a href='mailto:support@dvi.co.in'>support@dvi.co.in</a>.</p></td><td width='10%'>&nbsp;</td></tr><tr><td height='26'>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></table></td></tr><tr><td colspan='4'><span style='font-family: Arial, Helvetica, sans-serif;	font-size: 11px;	font-weight: normal;	color: #000000;'>Questions? Go to the Help Centre at: </span><a href='http://dvi.co.in' style='font-family: Arial, Helvetica, sans-serif;	font-size: 11px;	font-weight: normal;  color: #000000;'>DoView Holidays</a><br /><span style='font-family: Arial, Helvetica, sans-serif;	font-size: 12px; font-weight: bold;	color: #000000;'>Copyright &copy; ".$yy." DoView Holidays (India) Private Limited. All rights reserved.</span></td></tr></table></body></html>";
	
	$to2 = "vsr@dvi.co.in";
	$from = "DO VIEW HOLIDAYS INDIA PVT. LTD. <vsr@v-i.in> Website ( dvi.co.in)"; 
	$subject="Manage settings from dvi.co.in";
	$str=send_mail($to,$from,$subject,$stringData);
		
		/*echo "<script>alert('Please Try Again Later..');</script>";*/
	}
}

//forgot password from front end
if(isset($_GET['ty']) && $_GET['ty']==4)
{ 
	$checking;
	$fb_name='';
 	$email_var=trim($_GET['fb']);
	
	$email_agt = $conn->prepare("SELECT * FROM agent_pro where email_id=?");
	$email_agt->execute(array($email_var));
	$totalRows_email_agt = $email_agt->rowCount();
	
	if($totalRows_email_agt==0)
	{
		
		//$query_email_dst = "SELECT * FROM  distributor_pro where email_id='$email_var' and status < 2";
		$email_dst = $conn->prepare("SELECT * FROM distributor_pro where email_id=?");
		$email_dst->execute(array($email_var));
		$row_fbname=$email_dst->fetch(PDO::FETCH_ASSOC);
		$totalRows_email_dst = $email_dst->rowCount();
		if($totalRows_email_dst==0)
		{
			$checking='no'; //not send mail
		}else if($totalRows_email_dst==1){
			$checking='yes'; //send mail
			$fb_name=$row_fbname['distr_fname'].' '.$row_fbname['distr_lname'];
		}
	}else if($totalRows_email_agt==1){
		$checking='yes'; //send mail
		$fb_name=$row_fbname['agent_fname'].' '.$row_fbname['agent_lname'];
	}
	
	echo $checking;
	 if($checking=='yes')
	 {
		function generate_password( $length = 6 ) 
		{
			$chars = "abcdefghijklmnopqrstuvwxyz0123456789*";
			$password = substr( str_shuffle( $chars ), 0, $length );
			return $password;
		}
		$password1 = generate_password();
	
	$upfb=$conn->prepare("update login_secure set passwd=? where email_id=?");
	$upfb->execute(array($md5($password1),$email_var));
	
	$stringData ="<html><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Forgot Password From DVI Holidays Account</title></head><body><table width='90%' border='0' align='center' cellpadding='2' cellspacing='3';><tr><td colspan='3' style='font-family: Arial, Helvetica, sans-serif;	font-size: 24px;	font-weight: bold;	color: #960;'><span style='margin-top:20px; padding-top:30px'>Your request is accepted</span></td><td width='1%' rowspan='4' align='center' valign='middle'>&nbsp;</td></tr><tr align='center'><td height='4' colspan='4' style='border-bottom: solid #ccc 2px; float:left; width:100%;'> </td></tr><tr><td colspan='4'><table width='100%' border='0' cellpadding='3' cellspacing='4' style='border:1px solid #eeeeee; background-color: #FAFAFA'><tr><td colspan='3'><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;	font-weight: bold;	color: #000000;'><span style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 16px;	font-weight: bold;	color: #000000; padding-left:20px;'>Dear <span style='font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 16px;	font-weight: bold;	color: green;'>".$fb_name."</span>,</span></p></td></tr><tr> <td width='7%'></td><td width='83%'><p><span style='color:blue'> Do View Holidays welcomes you to our family! You are now registered with us and can login to our system with below credentials... </span><br> Your Login id:".$email_var." <br> Your password is ".$password1." <br> Please login and update your personal details.</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;color: #000000;'> With Regards,<br/>&nbsp;</p><table style='font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;'><tr><td width='244'>[DVI Administrator]</td></tr><tr><td>DoView Holidays India Pvt. Ltd.</td></tr></table>&nbsp;</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;font-size: 12px; font-weight: bold; color: '#CC6600;'>Please feel free to raise any queries on <a href='mailto:support@dvi.co.in'>support@dvi.co.in</a>.</p></td><td width='10%'>&nbsp;</td></tr><tr><td height='26'>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></table></td></tr><tr><td colspan='4'><br /><span style='font-family: Arial, Helvetica, sans-serif;	font-size: 12px; font-weight: bold;	color: #000000;'>Copyright &copy; 1999-".$yy." DoView Holidays Private Limited. All rights reserved.</span></td></tr></table></body></html>";
	
	$to = $email_var;
	$from = "DO VIEW HOLIDAYS INDIA PVT. LTD. <vsr@v-i.in>"; 
	$subject="New Password From DVI Holidays ( dvi.co.in) ";
	$str=send_mail($to,$from,$subject,$stringData);
	 }
}

//update packages
if(isset($_GET['ty']) && $_GET['ty']==5)
{
	$sno=$_GET['sno'];
	$packages = $conn->prepare("SELECT * FROM dvi_packages where sno=?");
	$packages->execute(array($sno));
	$row_packages= $packages->fetch(PDO::FETCH_ASSOC);
	$totalRows_packages= $packages->rowCount();
?>	
<div class="modal-dialog">
                    <form name="form_upd_sett" id="form_upd_sett" method="post" enctype="multipart/form-data" onsubmit="return upd_checkk1()">
											<div class="modal-content modal-no-shadow modal-no-border">
											  <div class="modal-header bg-info no-border">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h5 class="modal-title" style="font-family:Verdana, Geneva, sans-serif; font-weight:600;"> <i class="fa fa-briefcase"></i>&nbsp;Update - Packages </h5>
											  </div>
											  <div class="modal-body">
<input type="hidden" name="my_sno" id="my_sno" value="<?php echo $row_packages['sno']; ?>"> 
<input type="hidden" name="my_img" id="my_img" value="<?php echo $row_packages['pack_img']; ?>"> 
<input type="hidden" name="my_pdf" id="my_pdf" value="<?php echo $row_packages['pack_pdf']; ?>"> 
                                                <div class="row">
								<div class="col-sm-12">
                                   	<div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group">
										<label for="updpack_name">Pack Name</label>
										</div>
									      </div>
                                        </div>
                                        <div class="col-sm-9">
                        <input type="text" name="updpack_name" id="updpack_name" class="form-control" placeholder="Package Title" value="<?php echo $row_packages['pack_name']; ?>" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12" style="margin-top:5px;">
                                   	<div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group">
										<label for="updpack_locat">Location Name</label>
										</div>
									      </div>
                                        </div>
                                        <div class="col-sm-9">
                        <input type="text" name="updpack_locat" id="updpack_locat" class="form-control" placeholder="Place Name" value="<?php echo $row_packages['pack_location']; ?>" />
                                        </div>
                                    </div>
                                </div>
<div class="col-sm-12" style="margin-top:5px;">
                                   	<div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group">
										<label for="updpack_name">Pack Category</label>
										</div>
									      </div>
                                        </div>
                                        <div class="col-sm-9">
                        <select name="updpack_categ" id="updpack_categ" class="chosen-select">
                        	<option value="DI" <?php if(trim($row_packages['pack_grp'])=="DI"){ echo "selected"; }?>>Domestic itineraries</option>
                        	<option value="IN" <?php if(trim($row_packages['pack_grp'])=="IN"){ echo "selected"; }?>>International itineraries</option>
                        </select>
                                        </div>
                                    </div>
                                </div>

									<div class="col-sm-12" style="margin-top:5px;">
                                   	<div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group">
										<label for="updpack_desc">Pack - Short Description</label>
										</div>
									      </div>
                                        </div>
                                        <div class="col-sm-9">
                        <textarea name="updpack_desc" id="updpack_desc" style="overflow-y:scroll; height:90px; width:405px; resize:none" maxlength="250"><?php echo $row_packages['pack_desc']; ?></textarea>
                                        </div>
                                    </div>
                                </div>

							<div class="col-sm-12" style="margin-top:5px;">
                                   	<div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group">
										<label for="updpack_img">Location Img</label>
										<br><small style="color : rgb(240, 9, 9);font-size: 11px;
font-weight: 600;">[ Image file only ]</small>
										</div>
									      </div>
                                        </div>
                                        <div class="col-sm-9">
                        <input type="file" name="updpack_img" id="updpack_img" class="" placeholder="Img" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12" style="margin-top:5px;">
                                   	<div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group">
										<label for="updpack_img">Package File</label>
										<br><small style="color : rgb(240, 9, 9);font-size: 11px;
font-weight: 600;">[ 'PDF' file only ]</small>
										</div>
									      </div>
                                        </div>
                                        <div class="col-sm-9">
                       <input type="file" name="updpack_file" id="updpack_file" class="" placeholder="Img" />
                                        </div>
                                    </div>
                                </div>
                               
							  </div>
											  </div>
											  <div class="modal-footer">
				<strong id="upd_perr" class="flashit pull-left" sytle="display:none;">* Please Enter All Required Fields</strong>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="upd_pack_sett" name="upd_pack_sett" value="upd_pack_sett_val" class="btn btn-info">Submit</button>
											  </div>
											</div>                                </form>
										  </div>
										
<?php	
}
if(isset($_GET['ty']) && $_GET['ty']==6){ 

	$sno=trim($_GET['sno']);
	
	$packages = $conn->prepare("SELECT * FROM dvi_packages where sno=?");
	$packages->execute(array($sno));
	$row_packages= $packages->fetch(PDO::FETCH_ASSOC);
	
	if(trim($row_packages['pack_pdf'])!='')
	{
		unlink('packages/'.$row_packages['pack_pdf']);
		unlink('packages/images/'.$row_packages['pack_img']);
	}
	
		$deltst = $conn->prepare("DELETE FROM dvi_packages where sno=?");
		$deltst->execute(array($sno));

}
?>

		
	
	