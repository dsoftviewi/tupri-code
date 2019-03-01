<?php
require_once('../Connections/divdb.php');
include("../COMMN/smsfunc.php");
session_start();


$timezone = new DateTimeZone("Asia/Kolkata" );
$date = new DateTime();
$date->setTimezone($timezone );
$mm=$date->format('m');
$yy=$date->format('Y');
$mon=$date->format('F');
$dd=$date->format('m/d/Y');
?>

<?php
//for approval from admin to agent
if(isset($_GET['type']) && $_GET['type']==1)
{ 	$aid=$_GET['id'];
	$sts=$_GET['sts'];

	$up_agent=$conn->prepare("UPDATE agent_pro set status=? where agent_id=?");
	$up_agent->execute(array($sts,$aid));
	
$agt = $conn->prepare("SELECT * FROM agent_pro where agent_id=?");
$agt->execute(array($aid));
$row_agt= $agt->fetch(PDO::FETCH_ASSOC);
$totalRows_agt  = $agt->rowCount();
	
	if($sts=='0')
	{
		function generate_password( $length = 6 ) 
		{
			$chars = "abcdefghijklmnopqrstuvwxyz0123456789*";
			$password = substr( str_shuffle( $chars ), 0, $length );
			return $password;
		}
		$password1 = generate_password();
	
	$insertSQL_log=$conn->prepare('insert into login_secure (uid, uname, email_id, passwd, nname, gcode, status) values(?,?,?,?,"-","AGENT", 0 )');
	$insertSQL_log->execute(array($row_agt['agent_id'],$row_agt['agent_id'],$row_agt['email_id'],md5($password1)));
	
	$stringData ="<html><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Registration status</title></head><body><table width='90%' border='0' align='center' cellpadding='2' cellspacing='3';><tr><td colspan='3' style='font-family: Arial, Helvetica, sans-serif;	font-size: 24px;	font-weight: bold;	color: #960;'><span style='margin-top:20px; padding-top:30px'>Your request is accepted</span></td><td width='1%' rowspan='4' align='center' valign='middle'>&nbsp;</td></tr><tr align='center'><td height='4' colspan='4' style='border-bottom: solid #ccc 2px; float:left; width:100%;'> </td></tr><tr><td colspan='4'><table width='100%' border='0' cellpadding='3' cellspacing='4' style='border:1px solid #eeeeee; background-color: #FAFAFA'><tr><td colspan='3'><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;	font-weight: bold;	color: #000000;'><span style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 16px;	font-weight: bold;	color: #000000; padding-left:20px;'>Dear <span style='font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 16px;	font-weight: bold;	color: green;'>".$row_agt['agent_fname'].' '.$row_agt['agent_lname']."</span>,</span></p></td></tr><tr> <td width='7%'></td><td width='83%'><p><span style='color:blue'> Happy to welcome you to the different world of making an itinerary. Please find your credentials below.<br> </span><br><br> Your Login id:".$row_agt['email_id']." <br>Your password is ".$password1." <br> Please login and update your personal details.<br><br>Note: Please type your password while loging in.</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;color: #000000;'> Best Regards,<br/>&nbsp;</p><table style='font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;'><tr><td width='244'>SRINIVAS VEMURI</td></tr><tr><td>9843288844</td></tr></table>&nbsp;</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;font-size: 12px; font-weight: bold; color: '#CC6600;'>Please feel free to raise any queries on <a href='mailto:vsr@dvi.co.in'>vsr@dvi.co.in</a>.</p></td><td width='10%'>&nbsp;</td></tr><tr><td height='26'>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></table></td></tr><tr><td colspan='4'><br /><span style='font-family: Arial, Helvetica, sans-serif;	font-size: 12px; font-weight: bold;	color: #000000;'>Copyright &copy; 1999-".$yy." DVI Holidays. All rights reserved.</span></td></tr></table></body></html>";
	
	$to = $row_agt['email_id'];
	$from = "SRINIVAS VEMURI<vsr@dvi.co.in>"; 
	$subject="Welcome Message from DVI_Holidays.com";
	$str=send_mail($to,$from,$subject,$stringData);
	
	}//accepted 
	else{//rejected
		$stringData ="<html><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Untitled Document</title></head><body><table width='90%' border='0' align='center' cellpadding='2' cellspacing='3';>  <tr><td colspan='3' style='font-family: Arial, Helvetica, sans-serif;	font-size: 24px;	font-weight: bold;	color: #960;'><span style='margin-top:20px; padding-top:30px'>Your request was rejected</span></td><td width='1%' rowspan='4' align='center' valign='middle'>&nbsp;</td></tr><tr align='center'><td height='4' colspan='4' style='border-bottom: solid #ccc 2px; float:left; width:100%;'> </td></tr><tr><td colspan='4'><table width='100%' border='0' cellpadding='3' cellspacing='4' style='border:1px solid #eeeeee; background-color: #FAFAFA'><tr><td colspan='3'><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;	font-weight: bold;	color: #000000;'><span style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 16px;	font-weight: bold;	color: #000000; padding-left:20px;'>Dear <span style='font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 16px;	font-weight: bold;	color: green;'>".$row_agt['agent_fname'].' '.$row_agt['agent_lname']."</span>,</span></p></td></tr><tr><td>Greetings from Dvi Holidays!! </td></tr><tr> <td width='83%'><p><span style='color:blue'> Thank you for your interest shown in DVI, We regret to inform you that we are unable to confirm your request as an Agent/Distributor. May be the below reasons. </span><br><br> 1) Different country of stay. <br> 2) Out of the travel industry. <br> 3) Any other reasons @ admin.</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;color: #000000;'> <br/>&nbsp;</p><table style='font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;'><tr><td width='244'>Best Regards,</td></tr><tr><td>DVI Team. Ltd.</td></tr></table>&nbsp;</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;font-size: 12px; font-weight: bold; color: '#CC6600;'>Please feel free to raise any queries on <a href='mailto:support@dvi.co.in'>support@dvi.co.in</a>.</p></td><td width='10%'>&nbsp;</td></tr><tr><td height='26'>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></table></td></tr><tr><td colspan='4'><br /><span style='font-family: Arial, Helvetica, sans-serif;	font-size: 12px; font-weight: bold;	color: #000000;'>Copyright &copy; 1999-".$yy." DVI Holidays. All rights reserved.</span></td>  </tr></table></body></html>";
	
	$to = $row_agt['email_id'];
	$from = "DVI HOLIDAYS  <vsr@dvi.co.in>"; 
	$subject="Welcome Message from DVI_Holidays.com";
	$str=send_mail($to,$from,$subject,$stringData);
	}
	
}

//for approval from admin to distributor
if(isset($_GET['type']) && $_GET['type']==2)
{ 	$did=$_GET['id'];
	$sts=$_GET['sts'];

	echo $up_distr=$conn->prepare("UPDATE distributor_pro set status=? where distr_id=?");
	$up_distr->execute(array($sts,$did));
	
$distr = $conn->prepare("SELECT * FROM distributor_pro where distr_id=?");
$distr->execute(array($did));
$row_distr= $distr->fetch(PDO::FETCH_ASSOC);
$totalRows_distr  = $distr->rowCount();
	
	if($sts=='0')
	{
function generate_password( $length = 6 ) 
	{
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789*";
		$password = substr( str_shuffle( $chars ), 0, $length );
		return $password;
	}
	
	$password1 = generate_password();
	
	echo $insertSQL_log=$conn->prepare('insert into login_secure (uid, uname, email_id, passwd, nname, gcode, status) values(?,?,?,?, "-", "DISTRB", 0 )');
		$insertSQL_log->execute(array($row_distr['distr_id'],$row_distr['distr_id'],$row_distr['email_id'],md5($password1)));
	
	$stringData ="<html><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Registration status</title></head><body><table width='90%' border='0' align='center' cellpadding='2' cellspacing='3';>  <tr><td colspan='3' style='font-family: Arial, Helvetica, sans-serif;	font-size: 24px;	font-weight: bold;	color: #960;'><span style='margin-top:20px; padding-top:30px'>Your request is accepted</span></td><td width='1%' rowspan='4' align='center' valign='middle'>&nbsp;</td></tr><tr align='center'><td height='4' colspan='4' style='border-bottom: solid #ccc 2px; float:left; width:100%;'> </td></tr><tr><td colspan='4'><table width='100%' border='0' cellpadding='3' cellspacing='4' style='border:1px solid #eeeeee; background-color: #FAFAFA'><tr><td colspan='3'><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;	font-weight: bold;	color: #000000;'><span style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 16px;	font-weight: bold;	color: #000000; padding-left:20px;'>Dear <span style='font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 16px;	font-weight: bold;	color: green;'>".$row_distr['distr_fname'].' '.$row_distr['distr_lname']."</span>,</span></p></td></tr><tr> <td width='7%'></td><td width='83%'><p><span style='color:blue'> Happy to welcome you to the different world of making an itinerary. Please find your credentials below.<br> </span><br> Your Login id:".$row_distr['email_id']." <br> Your password is ".$password1." <br> Please login and update your personal details.</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;color: #000000;'> Best Regards,<br/><img src='../images/logo2.png'/>&nbsp;</p><table style='font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;'><tr><td width='244'>SRINIVAS VEMURI</td></tr><tr><td>9843288844</td></tr></table>&nbsp;</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;font-size: 12px; font-weight: bold; color: '#CC6600;'>Please feel free to raise any queries on <a href='mailto:vsr@dvi.co.in'>vsr@dvi.co.in</a></p></td><td width='10%'>&nbsp;</td></tr><tr><td height='26'>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></table></td></tr><tr><td colspan='4'><br /><span style='font-family: Arial, Helvetica, sans-serif;	font-size: 12px; font-weight: bold;	color: #000000;'>Copyright &copy; 1999-".$yy." DVI Holidays. All rights reserved.</span></td>  </tr></table></body></html>";
	
	$to = $row_distr['email_id'];
	$from = "SRINIVAS VEMURI <vsr@dvi.co.in>"; 
	$subject="Welcome Message from DVI_Holidays.com";
	$str=send_mail($to,$from,$subject,$stringData);
	
	}else{//rejected
		$stringData ="<html><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Registration status</title></head><body><table width='90%' border='0' align='center' cellpadding='2' cellspacing='3';>  <tr><td colspan='3' style='font-family: Arial, Helvetica, sans-serif;	font-size: 24px;	font-weight: bold;	color: #960;'><span style='margin-top:20px; padding-top:30px'>Your request was rejected</span></td><td width='1%' rowspan='4' align='center' valign='middle'>&nbsp;</td></tr><tr align='center'><td height='4' colspan='4' style='border-bottom: solid #ccc 2px; float:left; width:100%;'> </td></tr><tr><td colspan='4'><table width='100%' border='0' cellpadding='3' cellspacing='4' style='border:1px solid #eeeeee; background-color: #FAFAFA'><tr><td colspan='3'><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;	font-weight: bold;	color: #000000;'><span style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 16px;	font-weight: bold;	color: #000000; padding-left:20px;'>Dear <span style='font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 16px;	font-weight: bold;	color: green;'>".$row_distr['distr_fname'].' '.$row_distr['distr_lname']."</span>,</span></p></td></tr><tr> <td width='7%'></td><td width='83%'><p><span style='color:blue'> Do View Holidays welcomes you to our family! You are now registered with us and can login to our system with below credentials... </span><br> your request was rejected.</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;color: #000000;'> With Regards,<br/>&nbsp;</p><table style='font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;'><tr><td width='244'>[DVI Administrator]</td></tr><tr><td>DVI Holidays India Pvt. Ltd.</td></tr></table>&nbsp;</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;font-size: 12px; font-weight: bold; color: '#CC6600;'>Please feel free to raise any queries on <a href='mailto:support@dvi.co.in'>support@dvi.co.in</a></p></td><td width='10%'>&nbsp;</td></tr><tr><td height='26'>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></table></td></tr><tr><td colspan='4'><br /><span style='font-family: Arial, Helvetica, sans-serif;	font-size: 12px; font-weight: bold;	color: #000000;'>Copyright &copy; 1999-".$yy." DVI Holidays. All rights reserved.</span></td>  </tr></table></body></html>";
	
	$to = $row_distr['email_id'];
	$from = "DVI HOLIDAYS <vsr@dvi.co.in>"; 
	$subject="Welcome Message from DVI_Holidays.com";
	$str=send_mail($to,$from,$subject,$stringData);
	}
	
	
}
// for apporval from admin to all distr and agent
if(isset($_GET['type']) && $_GET['type']==3)
{ 
$distr = $conn->prepare("SELECT * FROM distributor_pro where status='1'");
$distr->execute();
//$row_distr= mysql_fetch_assoc($distr);
$row_distr_main=$distr->fetchAll();
$totalRows_distr  = $distr->rowCount();

	foreach($row_distr_main as $row_distr)
	{
	$up_distr=$conn->prepare("UPDATE distributor_pro set status='0' where distr_id=?");
	$up_distr->execute(array($row_distr['distr_id']));
		
		
function generate_password( $length = 6 ) 
	{
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789*";
		$password = substr( str_shuffle( $chars ), 0, $length );
		return $password;
	}
	
	$password1 = generate_password();
	
	$insertSQL_log=$conn->prepare('insert into login_secure (uid, uname, email_id, passwd, nname, gcode, status) values(?,?,?,?, "-", "DISTRB", 0 )');
	$insertSQL_log->execute(array($row_distr['distr_id'],$row_distr['distr_id'],$row_distr['email_id'],md5($password1)));
	
	$stringData ="<html><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Registration status</title></head><body><table width='90%' border='0' align='center' cellpadding='2' cellspacing='3';>  <tr><td colspan='3' style='font-family: Arial, Helvetica, sans-serif;	font-size: 24px;	font-weight: bold;	color: #960;'><span style='margin-top:20px; padding-top:30px'>Your request is accepted</span></td><td width='1%' rowspan='4' align='center' valign='middle'>&nbsp;</td></tr><tr align='center'><td height='4' colspan='4' style='border-bottom: solid #ccc 2px; float:left; width:100%;'> </td></tr><tr><td colspan='4'><table width='100%' border='0' cellpadding='3' cellspacing='4' style='border:1px solid #eeeeee; background-color: #FAFAFA'><tr><td colspan='3'><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;	font-weight: bold;	color: #000000;'><span style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 16px;	font-weight: bold;	color: #000000; padding-left:20px;'>Dear <span style='font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 16px;	font-weight: bold;	color: green;'>".$row_distr['distr_fname'].' '.$row_distr['distr_lname']."</span>,</span></p></td></tr><tr> <td width='7%'></td><td width='83%'><p><span style='color:blue'> Do View Holidays welcomes you to our family! You are now registered with us and can login to our system with below credentials... </span><br> Your Login id:".$row_distr['email_id']." <br> Your password is ".$password1." <br> Please login and update your personal details.</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;color: #000000;'> With Regards,<br/><img src='../images/logo2.png'/>&nbsp;</p><table style='font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;'><tr><td width='244'>[DVI Administrator]</td></tr><tr><td>DVI Holidays India Pvt. Ltd.</td></tr></table>&nbsp;</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;font-size: 12px; font-weight: bold; color: '#CC6600;'>Please feel free to raise any queries on <a href='mailto:support@dvi.co.in'>support@dvi.co.in</a></p></td><td width='10%'>&nbsp;</td></tr><tr><td height='26'>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></table></td></tr><tr><td colspan='4'><br /><span style='font-family: Arial, Helvetica, sans-serif;	font-size: 12px; font-weight: bold;	color: #000000;'>Copyright &copy; 1999-".$yy." DVI Holidays. All rights reserved.</span></td>  </tr></table></body></html>";
	
	$to = $row_distr['email_id'];
	$from = "DO VIEW HOLIDAYS INDIA PVT. LTD. <vsr@v-i.in>"; 
	$subject="Welcome Message from DVI_Holidays.com";
	$str=send_mail($to,$from,$subject,$stringData);
		
	}


$agt = $conn->prepare("SELECT * FROM agent_pro where status='1'");
$agt->execute();
//$row_agt= mysql_fetch_assoc($agt);
$row_agt_main=$agt-fetchAll();
$totalRows_agt  = $agt->rowCount();

foreach($row_agt_main as $row_agt)
	{
	$up_agent=$conn->prepare("UPDATE agent_pro set status='0' where agent_id=?");
	$up_agent->execute(array($row_agt['agent_id']));
		
function generate_password( $length = 6 ) 
	{
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789*";
		$password = substr( str_shuffle( $chars ), 0, $length );
		return $password;
	}
	
	$password1 = generate_password();
	
	$insertSQL_log=$conn->prepare('insert into login_secure (uid, uname, email_id, passwd, nname, gcode, status) values(?,?,?,?,"-", "AGENT", 0 )');
	$insertSQL_log->execute(array($row_agt['agent_id'],$row_agt['agent_id'],$row_agt['email_id'],md5($password1)));
		
	$stringData ="<html><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Registration status</title></head><body><table width='90%' border='0' align='center' cellpadding='2' cellspacing='3';>  <tr><td colspan='3' style='font-family: Arial, Helvetica, sans-serif;	font-size: 24px;	font-weight: bold;	color: #960;'><span style='margin-top:20px; padding-top:30px'>Your request is accepted</span></td><td width='1%' rowspan='4' align='center' valign='middle'>&nbsp;</td></tr><tr align='center'><td height='4' colspan='4' style='border-bottom: solid #ccc 2px; float:left; width:100%;'> </td></tr><tr><td colspan='4'><table width='100%' border='0' cellpadding='3' cellspacing='4' style='border:1px solid #eeeeee; background-color: #FAFAFA'><tr><td colspan='3'><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;	font-weight: bold;	color: #000000;'><span style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 16px;	font-weight: bold;	color: #000000; padding-left:20px;'>Dear <span style='font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 16px;	font-weight: bold;	color: green;'>".$row_agt['agent_fname'].' '.$row_agt['agent_lname']."</span>,</span></p></td></tr><tr> <td width='7%'></td><td width='83%'><p><span style='color:blue'> Do View Holidays welcomes you to our family! You are now registered with us and can login to our system with below credentials... </span><br> Your Login id:".$row_agt['email_id']." <br> Your password is ".$password1." <br> Please login and update your personal details.</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;color: #000000;'> With Regards,<br/>&nbsp;</p><table style='font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;'><tr><td width='244'>[DVI Administrator]</td></tr><tr><td>DVI Holidays India Pvt. Ltd.</td></tr></table>&nbsp;</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;font-size: 12px; font-weight: bold; color: '#CC6600;'>Please feel free to raise any queries on <a href='mailto:support@dvi.co.in'>support@dvi.co.in</a></p></td><td width='10%'>&nbsp;</td></tr><tr><td height='26'>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></table></td></tr><tr><td colspan='4'><br /><span style='font-family: Arial, Helvetica, sans-serif;	font-size: 12px; font-weight: bold;	color: #000000;'>Copyright &copy; 1999-".$yy." DVI Holidays. All rights reserved.</span></td>  </tr></table></body></html>";
	
	$to = $row_agt['email_id'];
	$from = "DVI HOLIDAYS <vsr@dvi.co.in>"; 
	$subject="Welcome Message from DVI_Holidays.com";
	$str=send_mail($to,$from,$subject,$stringData);

	}

/*	mysql_select_db($database_divdb, $divdb);
	$up_distr="UPDATE distributor_pro set status='0' where status='1'";
	$Re_distr = mysql_query($up_distr, $divdb) or die(mysql_error());
	
	mysql_select_db($database_divdb, $divdb);
	$up_agent="UPDATE agent_pro set status='0' where status='1'";
	$Re_agent = mysql_query($up_agent, $divdb) or die(mysql_error());*/
}

// for reject from admin to all distr and agent
if(isset($_GET['type']) && $_GET['type']==4)
{ 

$distr = $conn->prepare("SELECT * FROM distributor_pro where status='1'");
$distr->execute();
//$row_distr= mysql_fetch_assoc($distr);
$row_distr_main=$distr->fetchAll();
$totalRows_distr  = $distr->rowCount();

foreach($row_distr_main as $row_distr)
{
	$up_distr=$conn->prepare("UPDATE distributor_pro set status='2' where distr_id=?");
	$up_distr->execute(array($row_distr['distr_id']));
	
	//rejected all distr
		$stringData ="<html><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Registration status</title></head><body><table width='90%' border='0' align='center' cellpadding='2' cellspacing='3';>  <tr><td colspan='3' style='font-family: Arial, Helvetica, sans-serif;	font-size: 24px;	font-weight: bold;	color: #960;'><span style='margin-top:20px; padding-top:30px'>Your request was rejected</span></td><td width='1%' rowspan='4' align='center' valign='middle'>&nbsp;</td></tr><tr align='center'><td height='4' colspan='4' style='border-bottom: solid #ccc 2px; float:left; width:100%;'> </td></tr><tr><td colspan='4'><table width='100%' border='0' cellpadding='3' cellspacing='4' style='border:1px solid #eeeeee; background-color: #FAFAFA'><tr><td colspan='3'><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;	font-weight: bold;	color: #000000;'><span style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 16px;	font-weight: bold;	color: #000000; padding-left:20px;'>Dear <span style='font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 16px;	font-weight: bold;	color: green;'>".$row_distr['distr_fname'].' '.$row_distr['distr_lname']."</span>,</span></p></td></tr><tr> <td width='7%'></td><td width='83%'><p><span style='color:blue'> Do View Holidays welcomes you to our family! You are now registered with us and can login to our system with below credentials... </span><br> your request was rejected.</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;color: #000000;'> With Regards,<br/>&nbsp;</p><table style='font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;'><tr><td width='244'>[DVI Administrator]</td></tr><tr><td>DVI Holidays India Pvt. Ltd.</td></tr></table>&nbsp;</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;font-size: 12px; font-weight: bold; color: '#CC6600;'>Please feel free to raise any queries on <a href='mailto:support@dvi.co.in'>support@dvi.co.in</a></p></td><td width='10%'>&nbsp;</td></tr><tr><td height='26'>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></table></td></tr><tr><td colspan='4'><br /><span style='font-family: Arial, Helvetica, sans-serif;	font-size: 12px; font-weight: bold;	color: #000000;'>Copyright &copy; 1999-".$yy." DVI Holidays. All rights reserved.</span></td>  </tr></table></body></html>";
	
	$to = $row_distr['email_id'];
	$from = "DVI HOLIDAYS <vsr@dvi.co.in>"; 
	$subject="Welcome Message from DVI_Holidays.com";
	$str=send_mail($to,$from,$subject,$stringData);
	
}

$agt = $conn->prepare("SELECT * FROM agent_pro where status='1'");
$agt->execute();
//$row_agt= mysql_fetch_assoc($agt);
$row_agt_main=$agt->fetchAll();
$totalRows_agt  = $agt->rowCount();
foreach($row_agt_main as $row_agt)
{
	$up_agent=$conn->prepare("UPDATE agent_pro set status='2' where agent_id=?");
	$up_agent->execute(array($row_agt['agent_id']));
	
	//rejected agent all
		$stringData ="<html><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Registration status</title></head><body><table width='90%' border='0' align='center' cellpadding='2' cellspacing='3';>  <tr><td colspan='3' style='font-family: Arial, Helvetica, sans-serif;	font-size: 24px;	font-weight: bold;	color: #960;'><span style='margin-top:20px; padding-top:30px'>Your request was rejected</span></td><td width='1%' rowspan='4' align='center' valign='middle'>&nbsp;</td></tr><tr align='center'><td height='4' colspan='4' style='border-bottom: solid #ccc 2px; float:left; width:100%;'> </td></tr><tr><td colspan='4'><table width='100%' border='0' cellpadding='3' cellspacing='4' style='border:1px solid #eeeeee; background-color: #FAFAFA'><tr><td colspan='3'><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;	font-weight: bold;	color: #000000;'><span style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 16px;	font-weight: bold;	color: #000000; padding-left:20px;'>Dear <span style='font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 16px;	font-weight: bold;	color: green;'>".$row_agt['agent_fname'].' '.$row_agt['agent_lname']."</span>,</span></p></td></tr><tr> <td width='7%'></td><td width='83%'><p><span style='color:blue'> Do View Holidays welcomes you to our family! You are now registered with us and can login to our system with below credentials... </span><br> your request was rejected.</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;color: #000000;'> With Regards,<br/>&nbsp;</p><table style='font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;'><tr><td width='244'>[DVI Administrator]</td></tr><tr><td>DVI Holidays India Pvt. Ltd.</td></tr></table>&nbsp;</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;font-size: 12px; font-weight: bold; color: '#CC6600;'>Please feel free to raise any queries on <a href='mailto:support@dvi.co.in'>support@dvi.co.in</a></p></td><td width='10%'>&nbsp;</td></tr><tr><td height='26'>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></table></td></tr><tr><td colspan='4'><br /><span style='font-family: Arial, Helvetica, sans-serif;	font-size: 12px; font-weight: bold;	color: #000000;'>Copyright &copy; 1999-".$yy." DVI Holidays. All rights reserved.</span></td>  </tr></table></body></html>";
	
	$to = $row_agt['email_id'];
	$from = "DVI HOLIDAYS <vsr@dvi.co.in>"; 
	$subject="Welcome Message from DVI_Holidays.com";
	$str=send_mail($to,$from,$subject,$stringData);
	
}


/*	mysql_select_db($database_divdb, $divdb);
	$up_distr="UPDATE distributor_pro set status='2' where status='1'";
	$Re_distr = mysql_query($up_distr, $divdb) or die(mysql_error());
	
	mysql_select_db($database_divdb, $divdb);
	$up_agent="UPDATE agent_pro set status='2' where status='1'";
	$Re_agent = mysql_query($up_agent, $divdb) or die(mysql_error());*/
}

if(isset($_GET['type']) && $_GET['type']==5)//for update distance city 
{ 

$dist=$_GET['dist'];
$sno=$_GET['sno'];
	$up_dist=$conn->prepare("UPDATE dvi_citydist set dist=>? where sno=?");
	$up_dist->execute(array($dist,$sno));
}

if(isset($_GET['type']) && $_GET['type']==6)//for finding dist. city  row
{ 

 $id1=$_GET['sno1'];
 $id2=$_GET['sno2'];
	$up_dist=$conn->prepare("select * from dvi_citydist where (from_cityid=? and to_cityid=?) or (from_cityid=? and to_cityid=?)");
	$up_dist->execute(array($id1,$id2,$id2,$id1));
	$row_sno= $up_dist->fetch(PDO::FETCH_ASSOC);
	echo $row_sno['sno'];
}


if(isset($_GET['type']) && $_GET['type']==7)//for approvel plan from admin side
{ 

 $id=$_GET['id'];
 $sts=$_GET['sts'];
$up_approvel1=$conn->prepare("update travel_master set status=? where sno =?");
$up_approvel1->execute(array($sts,$id));
}


?>

<?php
//finding hotel
if(isset($_GET['type']) && $_GET['type']==8)
{
	$cpass=$_GET['cpass'];
$pass = $conn->prepare("SELECT * FROM login_secure where passwd=? and uid=?");
$pass->execute(array(md5($cpass),$_SESSION['uid']));
$row_pass= $pass->fetch(PDO::FETCH_ASSOC);
$tt= $pass->rowCount();
if($tt>0)
{
	echo "yes";
}else{
echo "no";
}
 }
 
if(isset($_GET['type']) && $_GET['type']==9)
{ 
$tmast1 = $conn->prepare("SELECT * FROM travel_master where status='2'");
$tmast1->execute();
//$row_tmast1= mysql_fetch_assoc($tmast1);
$row_tmast1=$tmast1->fetch(PDO::FETCH_ASSOC);
echo $tot_tmast1= $tmast1->rowCount();
}

if(isset($_GET['type']) && $_GET['type']==10)
{ 
$tmast = $conn->prepare("SELECT * FROM travel_master where status='2'");
$tmast->execute();
//$row_tmast= mysql_fetch_assoc($tmast);
$row_tmast_main=$tmast->fetchAll();
$tot_tmast= $tmast->rowCount();

if($tot_tmast>0){
?>
                                           <div class="nav-dropdown-content static-list scroll-nav-dropdown" style="overflow-y: scroll; width: auto; height: 350px;">
												<ul>
                                                 <?php foreach($row_tmast_main as $row_tmast) { ?>
													<li id="sno<?php echo $row_tmast['sno'];?>">
															<img src="images/agent_accept.jpg" class="absolute-left-content img-circle" alt="Avatar">
														<div class="row">
															<div class="col-xs-6 ">
															<strong >
                                                            <?php 
														//	echo substr($row_tmast['plan_id'],0,2);
															
															if(substr($row_tmast['plan_id'],0,2)=="TH"){?>
                                                            <a class="show_pdf" style="padding-left: 0px;padding-right: 0px; padding-top: 0px;padding-bottom: 0px;" href="<?php echo $_SESSION['grp'];?>/itiner_trav_hotel.php?topbar=<?php echo "topbar";?>&planid=<?php echo urlencode($row_tmast['plan_id']); ?>"><?php echo $row_tmast['plan_id'];?><br /><span class="small-caps">Waiting</span></a>
                                                            <?php }else if(substr($row_tmast['plan_id'],0,2)=="T#"){?>
                                                            <a class="show_pdf" style="padding-left: 0px;padding-right: 0px; padding-top: 0px;padding-bottom: 0px;" href="<?php echo $_SESSION['grp'];?>/itiner_trav.php?topbar=<?php echo "topbar";?>&planid=<?php echo urlencode($row_tmast['plan_id']); ?>"><?php echo $row_tmast['plan_id'];?><br /><span class="small-caps">Waiting</span></a>
                                                            <?php }else if(substr($row_tmast['plan_id'],0,2)=="H#"){?>
                                                            <a class="show_pdf" style="padding-left: 0px;padding-right: 0px; padding-top: 0px;padding-bottom: 0px;" href="<?php echo $_SESSION['grp'];?>/itiner_hotel.php?topbar=<?php echo "topbar";?>&planid=<?php echo urlencode($row_tmast['plan_id']); ?>"><?php echo $row_tmast['plan_id'];?><br /><span class="small-caps">Waiting</span></a>
                                                            <?php }?>
                                                            </strong>
																
															</div>
															<div class="col-xs-6 text-right btn-action">
																<button class="btn btn-success btn-xs" onclick="cal_wait_approvel('<?php echo $row_tmast['sno']; ?>','0')">Accept</button>
                                                                <button class="btn btn-danger btn-xs"  onclick="cal_wait_approvel('<?php echo $row_tmast['sno']; ?>','1')">Reject</button>
															</div><!-- /.col-xs-5 text-right btn-cation -->
														</div><!-- /.row -->
													</li>
                                                    <?php }?>
												</ul>
											</div><div class="slimScrollBar" style="width: 4px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 340.277777777778px; background: rgb(0, 0, 0);"></div><div class="slimScrollRail" style="width: 4px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.3; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div>
                                            <?php }else {?>
									
                                            <div class="slimScrollBar" style="width: 4px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 340.277777777778px; background: rgb(0, 0, 0);"></div>
                                           <br /><br /><center> Unavailable </center>
                                            
                                            <div class="slimScrollRail" style="width: 4px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.3; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div>
									
									
<?php } 
} ?>

<?php 
if(isset($_GET['type']) && $_GET['type']==11){ //model to lock hotel 
$htl_id=trim($_GET['hid']);

$htl = $conn->prepare("SELECT * FROM hotel_pro where hotel_id=? and status='0'");
$htl->execute(array($htl_id));
$row_htl= $htl->fetch(PDO::FETCH_ASSOC);
$tot_htl= $htl->rowCount();

$ffdate='';
$eedate='';
if(trim($row_htl['hotel_slock'])!='0000-00-00' && trim($row_htl['hotel_elock'])!='0000-00-00')
{
	//$lck_arr=explode("=",$row_htl['hotel_lock']);
	$ffdate=$row_htl['hotel_slock'];
	$eedate=$row_htl['hotel_elock'];
}
?>
<div class="modal fade" id="hotel_lock_<?php echo $htl_id; ?>" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop='static'>
										  <div class="modal-dialog" >
											<div class="modal-content modal-no-shadow modal-no-border" >
											  <div class="modal-header bg-info no-border">
												<!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
								<h5 class="modal-title" style="font-family:Verdana, Geneva, sans-serif; font-weight:600;"> <i class="fa fa-lock"></i>&nbsp;<?php echo $row_htl['hotel_name']; ?> - Lock </h5>
											  </div>
											  <div class="modal-body">
                                                <div class="row" id="deft_lock">
                                                <div class="col-sm-12" align="center"><p id="err_<?php echo $htl_id; ?>" style=" font-size:12px; font-weight:600; color:#930; display:none; text-align:center">Enter Both The Date Correctly</p></div>
                                                <div class="col-sm-12">
                                                <div class="col-sm-6">From Date</div>
                                                <div class="col-sm-6"><input class="date_pick" type="text" name="from_dt_<?php echo $htl_id; ?>" data-date-format="yyyy-mm-dd" id="from_dt_<?php echo $htl_id; ?>" value="<?php echo $ffdate; ?>"  readonly="readonly"/></div>
                                                </div>
                                                <div class="col-sm-12" style="margin-top:20px">
                                                <div class="col-sm-6">End Date</div>
                                                <div class="col-sm-6"><input class="date_pick" type="text"  data-date-format="yyyy-mm-dd" name="end_dt_<?php echo $htl_id; ?>" id="end_dt_<?php echo $htl_id; ?>"  value="<?php echo $eedate; ?>" readonly="readonly"/></div>
                                                </div>
                                                </div>
											  </div>
											  <div class="modal-footer">
                                              
                    <button type="button" id="unlck_<?php echo $htl_id; ?>" class="btn btn-danger tooltips pull-left" date-original-title='Remove Date' onclick="unlock_hotel_fun('<?php echo $htl_id; ?>')" <?php if($ffdate==''){?> style="display:none" <?php }?>>Unlock</button>       
                                              
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit"  class="btn btn-info" onclick="submit_lock('<?php echo $htl_id; ?>')" >Lock</button>
											  </div>
											</div>                               
										  </div>
                                          </div>	
<?php 										
}
?>

<?php 
if(isset($_GET['type']) && $_GET['type']==12){ //model to lock hotel 
		$ht1_id1=trim($_GET['hid']);
		//$lockdate=trim($_GET['fdate']).'='.trim($_GET['edate']);

$uphtl = $conn->prepare("update hotel_pro set hotel_slock=?, hotel_elock=? where hotel_id=?");
$uphtl->execute(array(trim($_GET['fdate']),trim($_GET['edate']),$ht1_id1));

}?>

<?php 
if(isset($_GET['type']) && $_GET['type']==13){ //model to lock hotel 
		$ht1_id1=trim($_GET['hid']);

$uphtl = $conn->prepare("update hotel_pro set hotel_slock='', hotel_elock='' where hotel_id=?");
$uphtl->execute(array($ht1_id1));

}

if(isset($_GET['type']) && $_GET['type']==14){ 

	$sno=trim($_GET['sno']);
	
	$news = $conn->prepare("SELECT * FROM news_scroller where sno=?");
	$news->execute(array($sno));
	$row_news= $news->fetch(PDO::FETCH_ASSOC);
	
	if(trim($row_news['images'])!='default_img.png')
	{
	unlink('../ADMIN/img_upload/news_img/'.$row_news['images']);
	}
	
		$delt = $conn->prepare("DELETE FROM news_scroller where sno=?");
		$delt->execute(array($sno));

}

if(isset($_GET['type']) && $_GET['type']==15)
{
	$sno=$_GET['sno'];
	$news = $conn->prepare("SELECT * FROM news_scroller where sno=?");
	$news->execute(array($sno));
	$row_news= $news->fetch(PDO::FETCH_ASSOC);
	$totalRows_news= $news->rowCount();
	
	
	$news2 = $conn->prepare("SELECT * FROM news_scroller");
	$news2->execute();
	//$row_news2= mysql_fetch_assoc($news2);
	$row_news2=$news2->fetch(PDO::FETCH_ASSOC);
	$totalRows_news2= $news2->rowCount();
?>	
<div class="modal-dialog">
                    <form name="form_newsupd_sett" id="form_newsupd_sett" method="post" enctype="multipart/form-data" onsubmit="return checkk2()">
											<div class="modal-content modal-no-shadow modal-no-border">
											  <div class="modal-header bg-info no-border">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">*</button>
								<h5 class="modal-title" style="font-family:Verdana, Geneva, sans-serif; font-weight:600;"> <i class="fa fa-cogs"></i>&nbsp;Update - News </h5>
											  </div>
											  <div class="modal-body">
                                              <input type="hidden" value="<?php echo $row_news['sno'];  ?>" name="ssno" id="ssno" />
                                                <div class="row">
									<div class="col-sm-12">
                                   	<div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group">
										<label for="updnews">News Content</label>
										</div>
									      </div>
                                        </div>
                                        <div class="col-sm-9">
                                    <div class="form-group">
                                    <div class="input-group">
                        <textarea name="updnews" id="updnews" style="overflow-y:scroll; height:70px; width:400px; resize:none" maxlength="250"><?php echo $row_news['news']; ?></textarea>
										</div>
									      </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                   	<div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group">
										<label for="updnews_attach">Attachment<br><small>(Optional)</small></label>
										</div>
									      </div>
                                        </div>
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
                       					<input type="file" name="updnews_attach" id="updnews_attach" >
										</div>
									      </div>
                                        </div>
                                        <div class="col-sm-3" align="center" >
                                        <table><tr><td>
                                        <?php
										$FileType = pathinfo($row_news['images'],PATHINFO_EXTENSION);
							if($FileType=='jpg' || $FileType=='png' || $FileType=='jpeg')
							{ 
								$upimg=$row_news['images'];
							}else{
								$upimg="attach_pin.jpg";
							}
							?>
                                        <img id="upimg_id" src="ADMIN/img_upload/news_img/<?php echo $upimg; ?>" alt="attachment"  style="height:35px ; width:50px;" />
                                        </td><td>&nbsp;&nbsp;&nbsp;<i class="fa fa-trash-o" onclick="check_img('<?php echo $row_news['images']; ?>')"></i><input type="hidden" name="rem_upd_img" id="rem_upd_img" /></td></tr>
                                        </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                   	<div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group">
                       						<label for="updorders">Priority</label>
									</div>
									</div>
                                    </div>
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group">
                                           <select class=" form-control" style="width:100%" name="udporders" id="updorders">
                                           <?php for($t=1; $t<=$totalRows_news2; $t++){
											   if($row_news['priority']==$t)
											   {
												   ?>
                                           			<option selected="selected" value="<?php echo $t; ?>"><?php echo $t; ?></option>
                                          			<?php 
											   }else{?>
												   <option value="<?php echo $t; ?>"><?php echo $t; ?></option>
											   <?php }
											   }?>
                                           </select>
									</div>
									</div>
                                    </div>
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group">
										<label for="updlimits">Behaviours</label>
									</div>
									</div>
                                    </div>
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group">
									<select class="form-control" name="updlimits" id="updlimits" onChange="fun_updates(this.value)">
                                    <?php 
									$pp='no';
									if($row_news['from_date']!='' && $row_news['from_date']!='')
									{
										$pp='yes';
									?>
                                    <option selected="selected" value="limit">Limits</option>
                                    <option value="default" >Default</option>
                                    <?php }else{?>
                       				<option selected="selected" value="default">Default</option>
                                    <option value="limit">Limits</option>
                                    <?php }?>
                     				</select>
										</div>
									      </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-12 " style="border-top:1px solid #C3BFBF; background-color:#EAEAEA; <?php if($pp!='yes'){?>display:none;<?php } ?>" id="updates" >
                                   	<div class="row" style="margin-top:10px;">
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group">
										<label for="updfrom_date">From Date</label>
										</div>
									      </div>
                                        </div>
                                        <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group">
                      <input type="text" class=" form-control datepickerrr" name="updfrom_date" id="updfrom_date" data-date-format="dd-mm-yyyy" data-placeholder="From Date" value="<?php echo $row_news['from_date']; ?>" readonly="readonly">
										</div>
									      </div>
                                        </div>
                                        <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group">
										<label for="end_date">End Date</label>
										</div>
									      </div>
                                        </div>
                                        <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group">
                       <input type="text" class="form-control  datepickerrr" name="updend_date" data-date-format="dd-mm-yyyy" id="updend_date" data-placeholder="End Date" value="<?php echo $row_news['to_date']; ?>" readonly="readonly">
										</div>
									      </div>
                                        </div>
                                    </div>
                                </div>
							  </div>
											  </div>
											  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="updnews_sett" name="updnews_sett" value="updnews_sett_val" class="btn btn-success">Update</button>
											  </div>
											</div>                                </form>
										  </div>
<?php	
}

?>