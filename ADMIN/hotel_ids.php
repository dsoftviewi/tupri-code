<?php 
session_start();
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 600);
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


$hotel = $conn->prepare("SELECT * FROM hotel_pro ORDER BY sno ASC ");
$hotel->execute();
//$row_hotel = mysql_fetch_assoc($hotel);
$row_hotel_main=$hotel->fetchAll();
$totalRows_hotel = $hotel->rowCount();

$html='<html xmlns="http://www.w3.org/1999/xhtml">
<style>
#header,
#footer {
  position: fixed;
  left: 0;
	right: 0;
	color: #aaa;
	font-size: 0.9em;
	width:100%
}

table{
 border-collapse: collapse;	
}

body{
	font-family: Roboto;	
}
table,td,th{
 border: 1px solid #000;
	
}

hr {
  page-break-after: always;
  border: 0;
}

</style>
<body style="margin-top:40px; margin-bottom:20px">';
  $html.='<table id="header"  width="100%" style="margin-top:12px">
    <tr style="background:#F5DAB8; color:#AB6C1E">
  	<td width="7%" style="padding:6px">S.No</td>
    <td width="20%" style="padding:6px">Hotel ID</td>
    <td width="30%" style="padding:6px">Hotel Name</td>
	<td width="40%" style="padding:6px">Hotel Address</td>
  </tr>
  </table>

<table width="100%" border="1" >';
  $s=1;
foreach($row_hotel_main as $row_hotel)
{
	$html.='<tr><td width="7%">'.$s.'</td><td  width="20%">'.$row_hotel['hotel_id'].'</td><td width="30%">'.$row_hotel['hotel_name'].'<br>('.$row_hotel['category'].')</td><td width="40%">'.$row_hotel['location'].'</td></tr>';
	$s++;
}
  
  $html.='</table>';
  $html.="<p align='center' style='color:#92591D;font-weight:600'> Hotel List Generated On ".$today." - ".$time."</p>";
  $html.='</body></html>';
 
$dompdf = new DOMPDF();
$dompdf->load_html($html);
  //$paper_size = array(0,0,612.00,792.00);
$dompdf->set_paper('A4','portrait');
$dompdf->render();
$dompdf->stream("hotel_ids.pdf", array("Attachment" => false));

//$pdf = $dompdf->output();
?>
