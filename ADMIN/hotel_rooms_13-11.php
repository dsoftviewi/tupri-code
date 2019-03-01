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
  $time=$date->format("h:i:s A");
  $today=$date->format('d-M-Y');

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
	font-family: calibri;	
	font-size:14px;
}
table,td,th{
 border: 1px solid #000;
	
}

hr {
  page-break-after: always;
  border: 0;
}

</style>
<body style="margin-top:40px; margin-bottom:20px;">';


$seasons = $conn->prepare("SELECT * FROM setting_season ORDER BY sno ASC ");
$seasons->execute();
//$row_seasons = mysql_fetch_assoc($seasons);
$row_seasons_main=$seasons->fetchAll();
$totalRows_seasons = $seasons->rowCount();

$from=$_GET['frm'];
$to=$_GET['to'];
$offset=($to-$from);

$html.='<p align="center" style="color:#92591D;font-weight:600"> Hotel List Generated On '.$today.' - '.$time.'</p>';
$html.='<table width="90%" align="center"><tr style="background:#E8D2BA; color:#693F12; "><td style="padding:6px">Seasons</td><td style="padding:6px">Seasons Name</td><td style="padding:6px">From Date</td><td style="padding:6px">To Date</td><td style="padding:6px">Status</td></tr>';
$html.='<p align="center" style="color:#92591D;font-weight:600"> Hotel Lists [ From : '.($from+1).' - To - '.$to.' ]</p>';
$ss=1;
foreach($row_seasons_main as $row_seasons)
{
	$html.='<tr><td style="padding:6px"> Season - '.$ss.' ( SS'.$ss.' ) </td><td style="padding:6px">'.$row_seasons['season_name'].'</td><td style="padding:6px">'.date("d-M-Y",strtotime($row_seasons['from_date'])).'</td><td style="padding:6px">'.date("d-M-Y",strtotime($row_seasons['to_date'])).'</td><td style="padding:6px">';
	if($row_seasons['lock_sts']==0){
		$html.=' Active ';
		}else{
		$html.=' Deactive';
		}
		$html.='</td></tr>';
	$ss++;
}
$html.='</table><hr>';






$hotel = $conn->prepare("SELECT * FROM hotel_pro ORDER BY sno ASC LIMIT $from,$offset");
//$query_hotel = "SELECT * FROM hotel_pro ORDER BY sno ASC LIMIT 2";
$hotel->execute();
//$row_hotel = mysql_fetch_assoc($hotel);
$row_hotel_main =$hotel->fetchAll();
$totalRows_hotel = $hotel->rowCount();
$hno=($from+1);
foreach($row_hotel_main as $row_hotel)
{
  $html.='<table width="100%" style="margin-top:20px;">
    <tr style="background:#F5DAB8; color:#AB6C1E">
  	<td width="6%" style="padding:6px">S.No</td>
    <td width="12%" style="padding:6px">Hotel Info.</td>
    <td width="16%" style="padding:6px">Room Category</td>
	<td width="6%" style="padding:6px">SS1<sub>(Rs.)</sub></td>
	<td width="6%" style="padding:6px">SS2<sub>(Rs.)</sub></td>
	<td width="6%" style="padding:6px">SS3<sub>(Rs.)</sub></td>
	<td width="6%" style="padding:6px">SS4<sub>(Rs.)</sub></td>
	<td width="6%" style="padding:6px">SS5<sub>(Rs.)</sub></td>
	<td width="6%" style="padding:6px">SS6<sub>(Rs.)</sub></td>
	<td width="6%" style="padding:6px">SS7<sub>(Rs.)</sub></td>
	<td width="6%" style="padding:6px">SS8<sub>(Rs.)</sub></td>
	<td width="6%" style="padding:6px">SS9<sub>(Rs.)</sub></td>
  	</tr>
    <tr>
  	<td width="6%" style="padding:6px">'.$hno.'</td>
    <td width="12%" style="padding:6px;">'.$row_hotel['hotel_name'].'<br> [ '.$row_hotel['hotel_id'].' ]<br>'.$row_hotel['category'].'</td>
	<td colspan="10"><table width="100%">';
	
$rooms = $conn->prepare("SELECT * FROM hotel_season where hotel_id=?");
$rooms->execute(array($row_hotel['hotel_id']));
//$row_rooms = mysql_fetch_assoc($rooms);
$row_rooms_main=$rooms->fetchAll();
$totalRows_rooms = $rooms->rowCount();
foreach($row_rooms_main as $row_rooms)
{
	$html.='<tr>
	 <td width="16%" style="padding:6px">'.$row_rooms['room_type'].'</td>
	<td width="6%" style="padding:6px">'.$row_rooms['season1_rate'].'</td>
	<td width="6%" style="padding:6px">'.$row_rooms['season2_rate'].'</td>
	<td width="6%" style="padding:6px">'.$row_rooms['season3_rate'].'</td>
	<td width="6%" style="padding:6px">'.$row_rooms['season4_rate'].'</td>
	<td width="6%" style="padding:6px">'.$row_rooms['season5_rate'].'</td>
	<td width="6%" style="padding:6px">'.$row_rooms['season6_rate'].'</td>
	<td width="6%" style="padding:6px">'.$row_rooms['season7_rate'].'</td>
	<td width="6%" style="padding:6px">'.$row_rooms['season8_rate'].'</td>
	<td width="6%" style="padding:6px">'.$row_rooms['season9_rate'].'</td>
	</tr>';


}


$food = $conn->prepare("SELECT * FROM hotel_food where hotel_id=?");
$food->execute(array($row_hotel['hotel_id']));
$row_food = $food->fetch(PDO::FETCH_ASSOC);
$totalRows_food = $food->rowCount();
if(strpos($row_food['lunch_rate'],'/') !== false)
{
	$row_food['lunch_rate']=implode("\\",explode("/", $row_food['lunch_rate']));
}
$lunch=explode('\\',$row_food['lunch_rate']);
	$html.='<tr>
	 <td width="16%" style="padding:6px">Lunch</td>';
	 for($i1=0;$i1<=8;$i1++){
	$html.='<td width="6%" style="padding:6px">'.$lunch[$i1].'</td>';
}
	$html.='</tr>';
if(strpos($row_food['dinner_rate'],'/') !== false)
{
	$row_food['dinner_rate']=implode("\\",explode("/", $row_food['dinner_rate']));
}
$dinner=explode('\\',$row_food['dinner_rate']);
	$html.='<tr>
	 <td width="16%" style="padding:6px">Dinner</td>';
	 for($i2=0;$i2<=8;$i2++){
	$html.='<td width="6%" style="padding:6px">'.$dinner[$i2].'</td>';
}
	$html.='</tr>';
if(strpos($row_food['child_with_bed'],'/') !== false)
{
	$row_food['child_with_bed']=implode("\\",explode("/", $row_food['child_with_bed']));
}
	$child_with_bed=explode('\\',$row_food['child_with_bed']);
	$html.='<tr>
	 <td width="16%" style="padding:6px">Child with bed</td>';
	 for($i3=0;$i3<=8;$i3++){
	$html.='<td width="6%" style="padding:6px">'.$child_with_bed[$i3].'</td>';
}
	$html.='</tr>';
if(strpos($row_food['child_without_bed'],'/') !== false)
{
	$row_food['child_without_bed']=implode("\\",explode("/", $row_food['child_without_bed']));
}
	$child_without_bed=explode('\\',$row_food['child_without_bed']);
	$html.='<tr>
	 <td width="16%" style="padding:6px">Child without bed</td>';
	 for($i4=0;$i4<=8;$i4++){
	$html.='<td width="6%" style="padding:6px">'.$child_without_bed[$i4].'</td>';
}
	$html.='</tr>';
if(strpos($row_food['flower_bed'],'/') !== false)
{
	$row_food['flower_bed']=implode("\\",explode("/", $row_food['flower_bed']));
}
	$flower_bed=explode('\\',$row_food['flower_bed']);
	$html.='<tr>
	 <td width="16%" style="padding:6px">Flower bed</td>';
	 for($i5=0;$i5<=8;$i5++){
	$html.='<td width="6%" style="padding:6px">'.$flower_bed[$i5].'</td>';
}
	$html.='</tr>';
if(strpos($row_food['candle_light'],'/') !== false)
{
	$row_food['candle_light']=implode("\\",explode("/", $row_food['candle_light']));
}
	$candle_light=explode('\\',$row_food['candle_light']);
	$html.='<tr>
	 <td width="16%" style="padding:6px">Candle light</td>';
	 for($i6=0;$i6<=8;$i6++){
	$html.='<td width="6%" style="padding:6px">'.$candle_light[$i6].'</td>';
}
	$html.='</tr>';
if(strpos($row_food['cake_rate'],'/') !== false)
{
	$row_food['cake_rate']=implode("\\",explode("/", $row_food['cake_rate']));
}
	$cake_rate=explode('\\',$row_food['cake_rate']);
	$html.='<tr>
	 <td width="16%" style="padding:6px">Cake rate</td>';
	 for($i7=0;$i7<=8;$i7++){
	$html.='<td width="6%" style="padding:6px">'.$cake_rate[$i7].'</td>';
}
	$html.='</tr>';
if(strpos($row_food['fruit_basket'],'/') !== false)
{
	$row_food['fruit_basket']=implode("\\",explode("/", $row_food['fruit_basket']));
}
	$fruit_basket=explode('\\',$row_food['fruit_basket']);
	$html.='<tr>
	 <td width="16%" style="padding:6px">Fruit basket</td>';
	 for($i2=0;$i2<=8;$i2++){
	$html.='<td width="6%" style="padding:6px">'.$fruit_basket[$i2].'</td>';
}
	$html.='</tr>';
	$html.='</table></td>
  </tr>
  </table>
  ';
  $hno++;
}
  $html.='</body></html>';
 
$dompdf = new DOMPDF();
$dompdf->load_html($html);
  //$paper_size = array(0,0,612.00,792.00);
$dompdf->set_paper('A4','landscape');
$dompdf->render();
$dompdf->stream("hotel_room_rent.pdf", array("Attachment" => false));

//$pdf = $dompdf->output();
?>
