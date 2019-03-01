
<?php
include("core/session.php");
require_once("Connections/divdb.php");
include("COMMN/smsfunc.php");
//mysql_select_db($database_divdb, $divdb);

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

	$mail = $conn->prepare("SELECT * FROM settings_mail order by sno DESC ");
	$mail->execute();
	$row_mail=$mail->fetch(PDO::FETCH_ASSOC);
	$totalRows_mail  = $mail->rowCount();


	
	$lname=$_POST['lname'];
	$mble=$_POST['mble'];
	$desc=$_POST['desc'];
	$fname=$_POST['fname'];
	$pack_name=$_POST['pack_name'];
	$title=$_POST['title'];
	$to_mail1=$row_mail['mail_to'];
	$to ="elysiumservice24@gmail.com";
	$from = "DO VIEW HOLIDAYS INDIA PVT. LTD."; 
	$subject=$title.' - '.$pack_name;
	
$stringData='<html><body><table border="1" align="center" width="300" style="border-collapse: collapse;border-color:#FDFEFF;"><tr style="border-color:#EEEEEE;background:#1B4599; text-transform:uppercase; text-align:center; font-weight:bold; color:#fff;"><td colspan="2" style="padding:7px;">Enquiry</td></tr>
<tr><td style="padding:7px; font-weight:bold; width:150px;border:none;">Name</td><td style="padding:7px; width:150px;border:none;">'.$fname.'&nbsp;'.$lname.'</td></tr><tr style="background:#EBEBEB;"><td style="padding:7px; font-weight:bold; width:150px;border:none;">E-Mail</td><td style="padding:7px; width:150px;border:none;">'.$to_mail1.'</td></tr><tr><td style="border:none;padding:7px; font-weight:bold;width:150px;">Mobile</td><td style="border:none;padding:7px;width:150px;">'.$mble.'</td></tr><tr><td style="border:none;padding:7px; font-weight:bold">Description</td><td style="border:none;padding:7px;">'.$desc.'</td></tr></table></body></html>';


	 $str=send_mail($to,$from,$subject,$stringData);

?>