
<?php
require_once('../Connections/divdb.php');
include("../COMMN/smsfunc.php");
session_start();

$timezone = new DateTimeZone("Asia/Kolkata" );
  $date = new DateTime();
  $date->setTimezone($timezone );
  $mm=$date->format('m');
  $mm1=$date->format('M');
  $yy=$date->format('Y');
  $dd=$date->format('d');
  $time=date("H:i:s");
  $today=date("Y-m-d");
?>

<?php  //Saving transport itinerary only 
if(isset($_GET['type']) && $_GET['type']==1)
{
	$mail = $conn->prepare("SELECT * FROM settings_mail order by sno DESC ");
	$mail->execute();
	$row_mail= $mail->fetch(PDO::FETCH_ASSOC);
	$totalRows_mail  = $mail->rowCount();
	
	$to_mail=trim($row_mail['mail_to']);
    $stringData=$_POST['content'];
	
	if($_SESSION['grp']=='AGENT')
	{
		$pers = $conn->prepare("SELECT * FROM agent_pro where agent_id=?");
		$pers->execute(array($_SESSION['uid']));
		$row_pers= $pers->fetch(PDO::FETCH_ASSOC);
		$totalRows_pers  = $pers->rowCount();

		$dis = $conn->prepare("SELECT * FROM distributor_pro where distr_id=?");
		$dis->execute(array($row_pers['distr_id']));
		$row_dis= $dis->fetch(PDO::FETCH_ASSOC);
		$totalRows_dis  =$dis->rowCount();

		$namee=$row_pers['agent_fname'].' '.$row_pers['agent_lname'].' from '.$row_dis['comp_name'];
	}
	else if($_SESSION['grp']=='DISTRB')
	{
		$pers = $conn->prepare("SELECT * FROM distributor_pro where distr_id=?");
		$pers->execute(array($_SESSION['uid']));
		$row_pers= $pers->fetch(PDO::FETCH_ASSOC);
		$totalRows_pers  = $pers->rowCount();
		$namee=$row_pers['distr_fname'].' '.$row_pers['distr_lname'].' from '.$row_pers['comp_name'];
	}
	
	$sub_namess="New Itinerary Created and Saved By ".$namee;
	
	$to_mail_arr=explode(',',$to_mail);
	//print_r($to_mail_arr);
	
	for($m=0;$m<count($to_mail_arr);$m++)
	{
		$to =$to_mail_arr[$m];
		$from = "SRINIVAS VEMURI - DVI HOLIDAYS, Mail : vsr@v-i.in, Mobile : 9843288844."; 
		$subject=$sub_namess;
		$str=send_mail($to,$from,$subject,$stringData);
	}
	
	$to_mail1=$row_pers['email_id'];
	$to =$to_mail1;
	$from = "SRINIVAS VEMURI - DVI HOLIDAYS, Mail : vsr@v-i.in, Mobile : 9843288844."; 
	$subject="New Itinerary Created and Saved By ".$namee;
	$str=send_mail($to,$from,$subject,$stringData);
	unset($_SESSION['com_plan_id']);
		
}
  
//Saving transport+hotel itinerary only 
if(isset($_GET['type']) && $_GET['type']==2)
{
	$mail = $conn->prepare("SELECT * FROM settings_mail order by sno DESC ");
	$mail->execute();
	$row_mail= $mail->fetch(PDO::FETCH_ASSOC);
	$totalRows_mail  = $mail->rowCount();
	
	$to_mail=trim($row_mail['mail_to']);
   	echo $stringData=$_POST['content_tvl'].'<br><br> Hotel Options <br>'.$_POST['content_htl'];
	
	if($_SESSION['grp']=='AGENT')
	{
		$pers = $conn->prepare("SELECT * FROM agent_pro where agent_id=?");
		$pers->execute(array($_SESSION['uid']));
		$row_pers= $pers->fetch(PDO::FETCH_ASSOC);
		$totalRows_pers  = $pers->rowCount();

		$dis = $conn->prepare("SELECT * FROM distributor_pro where distr_id=?");
		$dis->execute(array($row_pers['distr_id']));
		$row_dis= $dis->fetch(PDO::FETCH_ASSOC);
		$totalRows_dis  =$dis->rowCount();


		$namee=$row_pers['agent_fname'].' '.$row_pers['agent_lname'].' from '.$row_dis['comp_name'];
	}else if($_SESSION['grp']=='DISTRB')
	{
		$pers = $conn->prepare("SELECT * FROM distributor_pro where distr_id=?");
		$pers->execute(array($_SESSION['uid']));
		$row_pers= $pers->fetch(PDO::FETCH_ASSOC);
		$totalRows_pers  = $pers->rowCount();
		$namee=$row_pers['distr_fname'].' '.$row_pers['distr_lname'].' from '.$row_pers['comp_name'];
	}
	
	$sub_namess="New Itinerary Created and Saved By ".$namee;
	
	$to_mail_arr=explode(',',$to_mail);
	for($m=0;$m<count($to_mail_arr);$m++)
	{
		$to =$to_mail_arr[$m];
		$from = "SRINIVAS VEMURI - DVI HOLIDAYS, Mail : vsr@v-i.in, Mobile : 9843288844."; 
		$subject=$sub_namess;
		$str=send_mail($to,$from,$subject,$stringData);
	}
	
	$to_mail1=$row_pers['email_id'];
	$to =$to_mail1;
	$from = "SRINIVAS VEMURI - DVI HOLIDAYS, Mail : vsr@v-i.in, Mobile : 9843288844."; 
	$subject="New Itinerary Created and Saved By ".$namee;
	$str=send_mail($to,$from,$subject,$stringData);
	unset($_SESSION['com_plan_id']);
}

//Confirming transport itinerary only 
if(isset($_GET['type']) && $_GET['type']==3)
{
	$mail = $conn->prepare("SELECT * FROM settings_mail order by sno DESC ");
	$mail->execute();
	$row_mail= $mail->fetch(PDO::FETCH_ASSOC);
	$totalRows_mail  =$mail->rowCount();
	
	$to_mail=trim($row_mail['mail_to']);
    $stringData=$_POST['content'];
	
	if($_SESSION['grp']=='AGENT')
	{
		$pers = $conn->prepare("SELECT * FROM agent_pro where agent_id=?");
		$pers->execute(array($_SESSION['uid']));
		$row_pers= $pers->fetch(PDO::FETCH_ASSOC);
		$totalRows_pers  = $pers->rowCount();
		//$namee=$row_pers['agent_fname'].' '.$row_pers['agent_lname'];

		$dis = $conn->prepare("SELECT * FROM distributor_pro where distr_id=?");
		$dis->execute(array($row_pers['distr_id']));
		$row_dis= $dis->fetch(PDO::FETCH_ASSOC);
		$totalRows_dis  =$dis->rowCount();


		$namee=$row_pers['agent_fname'].' '.$row_pers['agent_lname'].' from '.$row_dis['comp_name'];

	}else if($_SESSION['grp']=='DISTRB')
	{
		$pers = $conn->prepare("SELECT * FROM distributor_pro where distr_id=?");
		$pers->execute(array($_SESSION['uid']));
		$row_pers= $pers->fetch(PDO::FETCH_ASSOC);
		$totalRows_pers  = $pers->rowCount();
		$namee=$row_pers['distr_fname'].' '.$row_pers['distr_lname'].' from '.$row_pers['comp_name'];
	}
	
	$sub_namess="New Itinerary Created & Confirmed By ".$namee;
	
	$to_mail_arr=explode(',',$to_mail);
	for($m=0;$m<count($to_mail_arr);$m++)
	{
		$to =$to_mail_arr[$m];
		//$from = "SRINIVAS VEMURI - DVI HOLIDAYS, Mail : vsr@v-i.in, Mobile : 9843288844."; 
		$from = "SRINIVAS VEMURI FROM DO VIEW HOLIDAYS INDIA PVT. LTD. <vsr@v-i.in>"; 
		$subject=$sub_namess;
		$str=send_mail($to,$from,$subject,$stringData);
	}
	
	$to_mail1=$row_pers['email_id'];
	$to =$to_mail1;
	$from = "SRINIVAS VEMURI FROM DO VIEW HOLIDAYS INDIA PVT. LTD. <vsr@v-i.in>"; 
	$subject="New Itinerary Created & Confirmed By ".$namee;
	$str=send_mail($to,$from,$subject,$stringData);
	unset($_SESSION['com_plan_id']);
}

//Cancelling transport itinerary only 
if(isset($_GET['type']) && $_GET['type']==4)
{
	$mail = $conn->prepare("SELECT * FROM settings_mail order by sno DESC ");
	$mail->execute();
	$row_mail= $mail->fetch(PDO::FETCH_ASSOC);
	$totalRows_mail  =$mail->rowCount();
	
	$to_mail=trim($row_mail['mail_to']);
    $stringData=$_POST['content'];
	
	if($_SESSION['grp']=='AGENT')
	{
		$pers = $conn->prepare("SELECT * FROM agent_pro where agent_id=?");
		$pers->execute(array($_SESSION['uid']));
		$row_pers= $pers->fetch(PDO::FETCH_ASSOC);
		$totalRows_pers  = $pers->rowCount();
		//$namee=$row_pers['agent_fname'].' '.$row_pers['agent_lname'];

		$dis = $conn->prepare("SELECT * FROM distributor_pro where distr_id=?");
		$dis->execute(array($row_pers['distr_id']));
		$row_dis= $dis->fetch(PDO::FETCH_ASSOC);
		$totalRows_dis  =$dis->rowCount();


		$namee=$row_pers['agent_fname'].' '.$row_pers['agent_lname'].' from '.$row_dis['comp_name'];
	}else if($_SESSION['grp']=='DISTRB')
	{
		$pers = $conn->prepare("SELECT * FROM distributor_pro where distr_id=?");
		$pers->execute(array($_SESSION['uid']));
		$row_pers= $pers->fetch(PDO::FETCH_ASSOC);
		$totalRows_pers  = $pers->rowCount();
		$namee=$row_pers['distr_fname'].' '.$row_pers['distr_lname'].' from '.$row_pers['comp_name'];
	}
	
	$sub_namess="Newly Created Itinerary was Cancelled By ".$namee;
	
	$to_mail_arr=explode(',',$to_mail);
	for($m=0;$m<count($to_mail_arr);$m++)
	{
		$to =$to_mail_arr[$m];
		$from = "SRINIVAS VEMURI - DVI HOLIDAYS, Mail : vsr@v-i.in, Mobile : 9843288844."; 
		$subject=$sub_namess;
		$str=send_mail($to,$from,$subject,$stringData);
	}
	
	$to_mail1=$row_pers['email_id'];
	$to =$to_mail1;
	$from = "SRINIVAS VEMURI - DVI HOLIDAYS, Mail : vsr@v-i.in, Mobile : 9843288844."; 
	$subject="Newly Created Itinerary Was Cancelled By ".$namee;
	$str=send_mail($to,$from,$subject,$stringData);
	
	unset($_SESSION['com_plan_id']);
	//echo "AFT SS".$_SESSION['com_plan_id'];
		
}

//mail send
if(isset($_GET['type']) && $_GET['type']==5)
{
	$pers = $conn->prepare("SELECT * FROM login_secure where uid=?");
	
		$pers->execute(array($_SESSION['uid']));
		$row_pers= $pers->fetch(PDO::FETCH_ASSOC);
		$totalRows_pers  = $pers->rowCount();
	
	echo $emailer=trim($_GET['emname']);
	$stringData=$_POST['content'];
	
	$to =$emailer;
	 $from = "SRINIVAS VEMURI FROM DO VIEW HOLIDAYS INDIA PVT. LTD. <".$row_pers['email_id'].">"; 
	$subject="DVI Holidays - www.dvi.co.in";
	$str=send_mail($to,$from,$subject,$stringData);
	
}

?>