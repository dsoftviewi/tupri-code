<?php 
session_start();
require_once("../assets/dompdf-master/dompdf_config.inc.php");
require_once("../Connections/divdb.php");

$timezone = new DateTimeZone("Asia/Kolkata" );
  $date = new DateTime();
  $date->setTimezone($timezone );
  $mm=$date->format('m');
  $mm1=$date->format('M');
  $yy=$date->format('Y');
  $dd=$date->format('d');
  $time=date("H:i:s");
  $today=date('d.m.Y');


$idd=explode('#',$_GET['planid']);
$str=$idd[0];
//print_r($idd);

$orders = $conn->prepare("SELECT * FROM travel_master where plan_id =?");
$orders->execute(array($_GET['planid']));
$row_orders = $orders->fetch(PDO::FETCH_ASSOC);
$totalRows_orders = $orders->rowCount();
//header("Content-type: application/vnd.ms-word");
//header("Content-Disposition: attachment;Filename=document_name.doc");

$slen=strlen($row_orders['tr_name']);

if($slen<=10)
{
	$fsize='154px';
}else if($slen<=15)
{
	$fsize='125px';	
}else if($slen<=20)
{
	$fsize='115px';	
}else if($slen<=25)
{
	$fsize='105px';	
}else if($slen<=30)
{
	$fsize='95px';	
}else{
	$fsize='55px';	
}

$html='<html xmlns="http://www.w3.org/1999/xhtml">
<body style="margin-top:30px; margin-bottom:5px; font-family:;">
	<table width="100%" border="0">
	<tr><td rowspan="2" width="40%"><img src="../images/dvi_pdf1.png" alt="DVI Logo" width="300px"; height="300px"; style="margin-top:20px; "/></td>
		<td></td></tr>
	<tr><td style="font-weight: bold; font-family:Calibri; text-align: left; font-size: 62px"> Welcome</td></tr>
	<tr><td colspan="2" style="font-weight: bold; font-family:Calibri; text-align: center; font-size: '.$fsize.'">'.strtoupper($row_orders['tr_name']).'</td></tr> 
	</table>
</body>
<html>';

$fnfile=$row_orders['tr_name']."'s_Welcome_Board.pdf";
$dompdf = new DOMPDF();
$dompdf->load_html($html);
  //$paper_size = array(0,0,612.00,792.00);
$dompdf->set_paper('A4','landscape');
$dompdf->render();
$dompdf->stream($fnfile, array("Attachment" => false));
?>