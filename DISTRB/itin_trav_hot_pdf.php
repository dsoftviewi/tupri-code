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


$html='<html xmlns="http://www.w3.org/1999/xhtml">
<body style="margin-top:105px; margin-bottom:5px">
<style>

.tag 
{
	background:url(../images/dvi_pdf1.png);
	background-position:50% 50% !important;
	background-color:#FFF;
	opacity:0.2;
	background-repeat: no-repeat;
	padding :10px;
}

.hide_border{
border-top:#FFF;
 border-bottom:#FFF; 
 border-left:#FFF; 
border-right:#FFF	
}


table{
 border-collapse: collapse;
 
}

.t1 {
 border: 1px solid #000;
 
}
table,td,th{
 border: 1px solid #000;	
}

#header,
#footer {
  position: fixed;
  left: 0;
	right: 0;
	color: #aaa;
	font-size: 0.9em;
	width:100%
}

#header {
  top: 0;

}

hr {
  page-break-after: always;
  border: 0;
}

#footer {
  bottom: 0;
  height:20px;
  border-top: 0.1pt solid #aaa;
}

#header table,
#footer table {
	width: 100%;
	
	border-collapse: collapse;
	border: none;
}

#header td,
#footer td {
  padding: 0;
	width: 50%;
}


</style>

 <div id="header">
  <table>
    <tr>
      <td style="border-bottom:1px solid #000; border-top:1px solid #FFF;border-left:1px solid #FFF;border-right:1px solid #FFF">
<span>
<img  src="../images/dvi_pdf.png"  height="65px" width="65px" alt="DVI Logo"  style="margin-left:630px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
<br><b style="margin-left:550px; font-size:12px;" >An ISO 9001 - 2008 company</b></td>

    </tr>
  </table>
</div>
<div id="footer"  style="margin-top:-20px" > 
<strong>Head Office : </strong><strong>#51, Vijaya Nagar, Dheeran Nagar (Extn), Karumandapam, Trichirappalli, Tamilnadu - 620009</strong><br />
<strong>Ph : </strong><strong>0431-2403615 </strong>&nbsp;&nbsp;&nbsp;<strong> H Phone :</strong><strong>9443164494</strong>&nbsp;&nbsp;&nbsp;<strong> Windows Live ID : </strong><strong> <u>vsr@v-i.in</u></strong><br />
<strong>BRANCHES :: </strong>&nbsp;<strong>NEW DELHI | MADURAI | COCHIN | VIJAYAWADA</strong>
</div>

<table width="100%" border="0">
  
  <tr>
    <td width="29%">&nbsp;</td>
    <td width="2%">&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="6"><center> <img src="../images/dvi_pdf1.png" alt="DVI Logo" width="300px"; height="300px"; style="margin-top:20px;"/></center></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>

  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
 
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6" style="font-weight: bold; font-family:sans-serif; text-align: center; font-size: 62px">Welcomes</td>
  </tr>
  <tr>
    <td colspan="6" style="text-align: center; font-family:sans-serif; font-weight: bold; font-size: 62px;">'.  $row_orders['tr_name'].'</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
 
    <tr>
    <td><font style="font-weight: bold; font-family:sans-serif; text-align: center; font-size: 12px">Arrival flight/Train Details</font></td>
    <td><strong>:</strong></td>
    <td width="22%"><font style="font-weight: bold; font-family:sans-serif; text-align: center; font-size: 12px">'.$row_orders['tr_arrdet'].'</font></td>
    <td width="16%"><font style="font-weight: bold; font-family:sans-serif; text-align: center; font-size: 12px">Guest Mobile No</font></td>
    <td width="1%"><strong>:  </strong></td>
    <td width="30%"><font style="font-weight: bold; font-family:sans-serif; text-align: center; font-size: 12px">'.$row_orders['tr_mobile'].'</font></td>
  </tr>
  <tr>
    <td><font style="font-weight: bold; text-align: center; font-family:sans-serif; font-size: 12px">Departure flight/ Train Details  </font></td>
    <td><strong>:</strong></td>
    <td><font style="font-weight: bold; text-align: center; font-family:sans-serif; font-size: 12px">'.$row_orders['tr_depdet'].'</font></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>';
  if($str =='H' || $str =='TH')
  {
	  
$spro = $conn->prepare("SELECT * FROM stay_sched where stay_id =? ORDER BY sno ASC ");
$spro->execute(array($_GET['planid']));
//$row_spro = mysql_fetch_assoc($spro);
$row_spro_main=$spro->fetchAll();
$totalRows_spro = $spro->rowCount();
	  $scnt=1;	
	  
  $html.='<td colspan="6"><table width="100%" border="0">
      <tr >
        <td colspan="3"><font style="font-weight: bold; color:#900; font-family:sans-serif; text-align: center; font-size: 16px">Hotel Details:</font></td>
        </tr>
      <tr>
        <td colspan="3">&nbsp;</td>
      </tr>
      <tr >
        <td width="20%"><font style="font-weight: bold; font-family:sans-serif; text-align: center; font-size: 12px">Guest Name</font></td>
        <td width="1%">:</td>
        <td width="79%"><font style="font-weight: bold; font-family:sans-serif; text-align: center; font-size: 12px"> '.$row_orders['tr_name'].'</font></td>
      </tr>
      <tr>
        <td><font style="font-weight: bold; font-family:sans-serif; text-align: center; font-size: 12px">Occupancy</font></td>
        <td>:</td>
        <td><font style="font-weight: bold; font-family:sans-serif; text-align: center; font-size: 12px">'.$row_orders['pax_cnt'].'</font></td>
      </tr>
      <tr>
        <td><font style="font-weight: bold; font-family:sans-serif; text-align: center; font-size: 12px">Total Traveling days</font></td>
        <td>:</td>
        <td><font style="font-weight: bold; font-family:sans-serif; text-align: center; font-size: 12px">'.$row_orders['tr_days'].'</font></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="6"><table width="100%" class="t1">
      <tr style="font-weight: bold; text-align: left; font-family:sans-serif; font-size: 12px">
        <td style="padding:5px" width="4%">Sno</td>
        <td style="padding:5px" width="19%">Date</td>
        <td style="padding:5px" width="20%">Place</td>
        <td style="padding:5px" width="30%">Hotel</td>
        <td style="padding:5px" width="17%">Room Category</td>
        <td style="padding:5px" width="10%">T Nights</td>
      </tr>';
	foreach($row_spro_main as $row_spro)
	{
	$html.='<tr style="text-align: left;  font-family:sans-serif; font-size: 12px">
        <td style="padding:5px">'.$scnt.'</td>
        <td style="padding:5px">';
		
		$spro1 = $conn->prepare("SELECT * FROM stay_sched where stay_id =? and hotel_id=? ORDER BY sno ASC ");
		$spro1->execute(array($_GET['planid'],$row_spro['hotel_id']));
		$row_spro1 = $spro1->fetch(PDO::FETCH_ASSOC);
		$totalRows_spro1 = $spro1->rowCount();
						
		$org_date= date('d-M-Y',strtotime(substr($row_spro['sty_date'],'0','10')));
	/*	if($totalRows_spro1>1)
		{			
			$totalRows_spro2=$totalRows_spro1-1;
			$date=date_create(substr($row_spro['sty_date'],'0','10'));
			date_add($date,date_interval_create_from_date_string($totalRows_spro2." days"));
			
			$html.=$org_date."&nbsp;<br>to&nbsp;".date_format($date,"d-M-Y");
		}
		else
		{*/
		$html.=$org_date;
		//}
		$html.='</td>
        <td style="padding:5px">';
		
		$cityy = $conn->prepare("SELECT * FROM dvi_cities where id =?");
		$cityy->execute(array($row_spro['sty_city']));
		$row_cityy = $cityy->fetch(PDO::FETCH_ASSOC);
		$totalRows_cityy = $cityy->rowCount();
									
		 $html.=$row_cityy['name'];
		 
		 $html.='</td>
        <td style="padding:5px">'; 
		
		$hotell = $conn->prepare("SELECT * FROM hotel_pro where hotel_id =?");
		$hotell->execute(array($row_spro['hotel_id']));
		$row_hotell = $hotell->fetch(PDO::FETCH_ASSOC);
		$totalRows_hotell = $hotell->rowCount();

		$html.=$row_hotell['hotel_name'].'</td>
        <td style="padding:5px">';
		$rrom=explode(',',$row_spro['sty_room_type']);
		$rrom1=array_unique($rrom);
		//print_r($rrom1);
		$rrom2=array_count_values($rrom);
		//print_r($rrom2);
		for($tt=0;$tt<count($rrom1);$tt++)
		{
			 
			$hroom = $conn->prepare("SELECT * FROM hotel_season where sno =?");
			$hroom->execute(array($rrom1[$tt]));
			$row_hroom =$hroom->fetch(PDO::FETCH_ASSOC);
			$totalRows_hroom = $hroom->rowCount();
			if(isset($rrom1[$tt+1]) && $rrom1[$tt+1] !='')
			{
				$html.=$row_hroom['room_type']." - ".$rrom2[$rrom1[$tt]].",&nbsp;"; 
			}else
			{
				$html.=$row_hroom['room_type']." - ".$rrom2[$rrom1[$tt]]; 
			}
		}
		$html.='</td>
        
		<td style="padding:5px">';
		if($row_spro['sty_food']=='dinner_rate')
									 {
										$html.="Dinner"; 
									 }else if($row_spro['sty_food']=='lunch_rate')
									 {
										 $html.="Lunch"; 
									 }else if($row_spro['sty_food']=='both_food')
									 {
										$html.="Lunch & Dinner"; 
									 }else{
										$html.="-"; 
									 };
		$html.='</td>
      </tr>';
		/*if($totalRows_spro1>1)
		{
			for($rt=0;$rt<$totalRows_spro1-1;$rt++)
			{
				$row_spro = mysql_fetch_assoc($spro);	
				
			}
		}*/
   	  $scnt++;
	} 
	  $html.='</tr>
    </table>
	<p style="font-size:12px;font-weight: bold; color:#900;" align="right">* Breakfast - complementary</p></td>
  </tr>';
  }
  $html.='<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>';

$sspro = $conn->prepare("SELECT * FROM stay_sched where stay_id =? ORDER BY sno ASC ");
$sspro->execute(array($_GET['planid']));
//$row_sspro = mysql_fetch_assoc($sspro);
$row_sspro_main=$sspro->fetchAll();
$totalRows_sspro = $sspro->rowCount();
$row_count=$totalRows_sspro;

//my start


$trv_future = $conn->prepare("SELECT * FROM travel_sched where travel_id =?");
$trv_future->execute(array($_GET['planid']));
//$row_trv_future = mysql_fetch_assoc($trv_future);
$row_trv_future_main=$trv_future->fetchAll();
$area_arr=array();
$gv=0;
foreach($row_trv_future_main as $row_trv_future)
{
	$area_arr[$gv]=$row_trv_future['tr_from_cityid'];
	$gv++;
}
$area_cnt = array_count_values($area_arr);
$area_cnt1=$area_cnt;
$copy_area_arr=$area_cnt;

$rem_area_cnt=array();
foreach($area_cnt1 as $key => $ac1)
{
	$rem_area_cnt[$key]=0;
}
$totaltrv_future = $trv_future->rowCount();
//daytrip here

 $dtrip = $conn->prepare("SELECT * FROM travel_daytrip where travel_id =? ORDER BY sno ASC");
$dtrip->execute(array($_GET['planid']));
$row_dtrip_main =$dtrip->fetchAll();
$totalRows_dtrip = $dtrip->rowCount();

$dt_arr = array(); $dt_cnt = 0;
if($totalRows_dtrip > 0)
{
	foreach($row_dtrip_main as $row_dtrip)
	{
		
		$dtcity1 = $conn->prepare("SELECT * FROM dvi_cities where id =?");
		$dtcity1->execute(array($row_dtrip['orig_cid']));
		$row_dtcity1 = $dtcity1->fetch(PDO::FETCH_ASSOC);
		$totalRows_dtcity1 = $dtcity1->rowCount();
		
		
		$dtcity2 = $conn->prepare("SELECT * FROM dvi_cities where id =?");
		$dtcity2->execute(array($row_dtrip['to_cid']));
		$row_dtcity2 = $dtcity2->fetch(PDO::FETCH_ASSOC);
		$totalRows_dtcity2 = $dtcity2->rowCount();
		
		$dt_arr[$row_dtcity1['name']][] = $row_dtcity2['name'];
	}
	
}
//daytrip end
//my end
			
					            

$trv = $conn->prepare("SELECT * FROM travel_sched where travel_id =? ORDER BY sno ASC");
$trv->execute(array($_GET['planid']));
//$row_trv = mysql_fetch_assoc($trv);
$row_trv_main =$trv->fetchAll();
$totalRows_trv = $trv->rowCount();
$chn=0; 
$i=0;
if($totalRows_trv>0){	
$html.='<tr>
    <td><font style="font-weight: bold; color:#900; font-family:sans-serif; text-align: center; font-size: 16px">Itinerary Details:</font></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><font style="font-weight: bold; color:blue; font-family:sans-serif; text-align: center; font-size: 13px">Specially prepared for '.$row_orders['tr_name'].' </font></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>';
}
foreach($row_trv_main as $row_trv){
if($row_count>0)
{
	//for stay table - aft end day calculation
	$row_sspro = $row_sspro_main[$i];
	
	$html.='<tr><td colspan="6"><table width="100%" border="0">
	
	<tr><td width="14%" rowspan="3" style="background-color:#E9E9E9"><p style="text-align:center; font-family:sans-serif; font-size: 12px;">';
if($row_trv['tr_date'] == $row_sspro['sty_date'])
{
	$html.=date('d-M-Y D',strtotime(str_replace('-','/',$row_trv['tr_date'])));
}

$cityy1 = $conn->prepare("SELECT * FROM dvi_cities where name LIKE ?");
$cityy1->execute(array($row_trv['tr_from_cityid']));
$row_cityy1 = $cityy1->fetch(PDO::FETCH_ASSOC);
$totalRows_cityy1 = $cityy1->rowCount();

									
$cityy_to = $conn->prepare("SELECT * FROM dvi_cities where name LIKE ?");
$cityy_to->execute(array($row_trv['tr_to_cityid']));
$row_cityy_to = $cityy_to->fetch(PDO::FETCH_ASSOC);
$totalRows_cityy_to = $cityy_to->rowCount();


$hot= $conn->prepare("SELECT * FROM hotspots_pro where spot_city =? ORDER BY spot_prior ASC");
$hot->execute(array($row_cityy1['id']));
//$row_hot = mysql_fetch_assoc($hot);
$row_hot_main=$hot->fetchAll();
$totalRows_hot = $hot->rowCount();
									
//calculate distance
	
$distanc = $conn->prepare("SELECT * FROM dvi_citydist where (from_cityid =? and to_cityid =?) or (from_cityid =? and to_cityid =?)");
$distanc->execute(array($row_cityy1['id'],$row_cityy_to['id'],$row_cityy_to['id'],$row_cityy1['id']));
$row_distanc= $distanc->fetch(PDO::FETCH_ASSOC);
$totalRows_distanc = $distanc->rowCount();	

$html.='</p></td>
<td><font style="font-weight: bold; font-family:sans-serif; text-align: center; font-size: 12px">';
if($chn=='0'){
$html.='Arrival - ';
}
$html.=$row_trv['tr_from_cityid'];
if($chn=='0')
{
	$html.=" [ ".$row_orders['tr_arrdet']." @".$row_orders['tr_arr_time']." ]";
	
}
$html.=" - ".$row_trv['tr_to_cityid'];
if($row_distanc['dist']>0)
{
	$html.= " (".$row_distanc['dist']." Kms)";
}
else
{
	$ss_dist = $conn->prepare("SELECT * FROM dvi_cities where id=?");
$ss_dist->execute(array($row_cityy_to['id']));
$row_ss_dist=$ss_dist->fetch(PDO::FETCH_ASSOC);
$totalRows_ss_dist = $ss_dist->rowCount();	
	$html.= "";
}
$html.='</td>
      </tr>
     
      <tr>
        <td><p style="text-align:justify; font-family:sans-serif; font-size: 12px">';
$hotel2 = $conn->prepare("SELECT * FROM hotel_pro where hotel_id =?");
$hotel2->execute(array($row_sspro['hotel_id']));
$row_hotel2 = $hotel2->fetch(PDO::FETCH_ASSOC);
$totalRows_hotel2 = $hotel2->rowCount();								
									
if($chn=='0')
{
	$next_stay=$row_trv['sno']+1;
	
	
	$trv_new = $conn->prepare("SELECT * FROM travel_sched where sno=? and travel_id =? ORDER BY sno ASC");
$trv_new->execute(array($next_stay,$_GET['planid']));
$row_trv_new = $trv_new->fetch(PDO::FETCH_ASSOC);
$totalRows_trv_new = $trv_new->rowCount();

//hotel change from this place - query

if($totalRows_trv_new>0)
{
	$arr_date_time=$row_orders['tr_arr_date'].' '.$row_orders['tr_arr_time'];//$row_orders['tr_arr_time']
	$arr_date_tstmp=date('U',strtotime($arr_date_time));
	
	$arr_timenxday=date('Y-m-d', strtotime($row_orders['tr_arr_date']. ' +1 day'));
	$arr_timenx6am=date('U',strtotime($arr_timenxday.' 06:00 AM'));//for next day morning - arrival
	
	$time6am=date('U',strtotime($row_orders['tr_arr_date'].' 06:00 AM'));
	$time3pm=date('U',strtotime($row_orders['tr_arr_date'].' 03:00 PM'));
	$time6pm=date('U',strtotime($row_orders['tr_arr_date'].' 06:00 PM'));
	
	if($row_trv['tr_from_cityid']==$row_trv['tr_to_cityid'])
	{
		//next day also same city means
		if($time6am <= $arr_date_tstmp && $arr_date_tstmp <= $time3pm)
		{//between 6am to 3pm ( over night in same city)
			$html.= "Greet and meet on arrival at ".$row_trv['tr_from_cityid'].", proceed to hotel. Check in ( 12:00 noon - standard time) at hotel, refresh and later proceed to visit the following Sight-seeing spots including - ";
			$hots_array=array();
			$vg=0;
			foreach($row_hot_main as $row_hot)
			{
				$hots_array[$vg]='<strong>'.$row_hot['spot_name'].'</strong> {'.$row_hot['spot_timings'].' }';
				$vg++;
			}
			$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_from_cityid']]);
			
			for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<$tot_div_hot+$rem_area_cnt[$row_trv['tr_from_cityid']];$hs++)
			{
				$html.=$hots_array[$hs].',';
			}
										
			$rem_area_cnt[$row_trv['tr_from_cityid']]=$rem_area_cnt[$row_trv['tr_from_cityid']]+$tot_div_hot;
			$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-1;
			
			$html.= '. and later return to '.$row_hotel2['hotel_name'].' and overnight stay at hotel.';
			}
			else if($time3pm <= $arr_date_tstmp && $arr_date_tstmp <= $time6pm)
			{//between 6am to 3pm ( over night in same city)
				$html.= 'Greet and meet on arrival at '.$row_trv['tr_from_cityid'].' and proceed to hotel, check-in and overnight at '.$row_hotel2['hotel_name'];//have to show sight-seeing in next day
				$show_in_next_day=2;
				$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-2;
			}
			else if($time6pm <= $arr_date_tstmp && $arr_date_tstmp <= $arr_timenx6am)
			{//between 6am to 3pm ( over night in same city)
				$html.= 'Greet and meet on arrival at '.$row_trv['tr_from_cityid'].', proceed to hotel, check-in and overnight stay at '.$row_hotel2['hotel_name'].' hotel.';//have to show sight-seeing in next day
				$show_in_next_day=2;
				$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-2;
			}
		}
		else
		{
			//next day having different city means
			if($time6am <= $arr_date_tstmp && $arr_date_tstmp <= $time3pm)
			{
				//between 6am to 3pm ( over night in diff city)
				$html.= 'Greet and meet on arrival at '.$row_trv['tr_from_cityid'].', proceed to visit the following Sight-seeing spots including - ';
				$hots_array=array();
				$vg=0;
				foreach($row_hot_main as $row_hot)
				{
					$hots_array[$vg]='<strong>'.$row_hot['spot_name'].'</strong> {'.$row_hot['spot_timings'].' }';
					$vg++;
				}
				$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_from_cityid']]);
				
				for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<$tot_div_hot+$rem_area_cnt[$row_trv['tr_from_cityid']];$hs++)
				{
					$html.=$hots_array[$hs].',';
				}
				
				$rem_area_cnt[$row_trv['tr_from_cityid']]=$rem_area_cnt[$row_trv['tr_from_cityid']]+$tot_div_hot;
				$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-1;

				//for first day - in diff city within 180km means show hotspots if the arrival time inbetween 11 clock
				$time11am=date('U',strtotime($row_orders['tr_arr_date'].' 11:00 AM'));	
				if($time11am >= $arr_date_tstmp)//within 11:00AM arrival means
				{
					if(($row_trv['tr_from_cityid'] != $row_trv['tr_to_cityid']) && $row_distanc['dist']<=180)
					{
						
						$hot1= $conn->prepare("SELECT * FROM hotspots_pro where spot_city =?");
$hot1->execute(array($row_cityy_to['id']));
//$row_hot1 = mysql_fetch_assoc($hot1);
$row_hot1_main=$hot1->fetchAll();
$totalRows_hot1 = $hot1->rowCount();
						
						$hots_array=array();
						$vg=0;
						foreach($row_hot1_main as $row_hot1)
						{
							$hots_array[$vg]='<strong>'.$row_hot1['spot_name'].'</strong> {'.$row_hot1['spot_timings'].' }';
							$vg++;
						} 
								
						$area_cnt[$row_trv['tr_to_cityid']]=$area_cnt[$row_trv['tr_to_cityid']]+1;
						$copy_area_arr[$row_trv['tr_to_cityid']]=$copy_area_arr[$row_trv['tr_to_cityid']]+1;
						
						$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_to_cityid']]);	
						
						for($hs1=$rem_area_cnt[$row_trv['tr_to_cityid']];$hs1<$tot_div_hot+$rem_area_cnt[$row_trv['tr_to_cityid']];$hs1++)
						{
							$html.= $hots_array[$hs1].', ';
						}
						
						$rem_area_cnt[$row_trv['tr_to_cityid']]=$rem_area_cnt[$row_trv['tr_to_cityid']]+$tot_div_hot;
						$copy_area_arr[$row_trv['tr_to_cityid']]=$copy_area_arr[$row_trv['tr_to_cityid']]-1;
						}
					}//within 11:00AM arrival means if- end
					
									
						$html.= 'and later drive to '.$row_trv['tr_to_cityid'].', check-in and overnight stay at '.$row_hotel2['hotel_name'].' hotel.';
					}
					else if($time3pm <= $arr_date_tstmp && $arr_date_tstmp <= $time6pm)
					{//between 3pm to 6pm ( over night in diff city)
						$html.= 'Greet and meet on arrival at '.$row_trv['tr_from_cityid'].'. ';
						
						if($totalRows_hot>0)
						{
							$html.= 'If time permits proceed to visit the following Sight-seeing spots - ';
							$hots_array=array();
							
							$vg=0;
							foreach($row_hot_main as $row_hot)
							{
								$hots_array[$vg]='<strong>'.$row_hot['spot_name'].'</strong> {'.$row_hot['spot_timings'].' }';
								$vg++;
							}
							
							$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_from_cityid']]);
							
							for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<$tot_div_hot+$rem_area_cnt[$row_trv['tr_from_cityid']];$hs++)
							{
								$html.= $hots_array[$hs].',';
							}
							$rem_area_cnt[$row_trv['tr_from_cityid']]=$rem_area_cnt[$row_trv['tr_from_cityid']]+$tot_div_hot;
							$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-1;
							'and ';
						}//more hot spot
						$html.= ' later drive to '.$row_trv['tr_to_cityid'].', check-in and overnight stay at '.$row_hotel2['hotel_name'].' hotel.';
							
						}
						else if($time6pm <= $arr_date_tstmp && $arr_date_tstmp <= $arr_timenx6am)
						{
							//between 6am to 3pm ( over night in diff city)
							$html.= 'Greet and meet on arrival at '.$row_trv['tr_from_cityid'].' and proceed to '.$row_trv['tr_to_cityid'].', arrival and check-in and Overnight stay at '.$row_hotel2['hotel_name'].' hotel.';//skip sight-seeing and proceed to next day if
						
						//have to skip
						$hots_array=array();
						$vg=0;
						
						foreach($row_hot_main as $row_hot)
						{
							$hots_array[$vg]='<strong>'.$row_hot['spot_name'].'</strong> {'.$row_hot['spot_timings'].' }';
							$vg++;
						}
						
						$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_from_cityid']]);
						//skip hot spot
						$rem_area_cnt[$row_trv['tr_from_cityid']]=$rem_area_cnt[$row_trv['tr_from_cityid']]+$tot_div_hot;
						$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-1;
						
						}
				}
	}//if end -$totalRows_trv_new count 

}
else
{
	if($row_trv['tr_from_cityid'] == $row_trv['tr_to_cityid'])
	{
		$html.= 'After breakfast ';
	}
	else
	{
		//different ending city means show the ending city hotspot
		$html.= 'After breakfast check out hotel and';
	}

	if($totalRows_hot>0)
	{
		$html.= ' proceed to visit the following Sight-seeing spots- ';
		$hots_array=array();
		$vg=0;
		foreach($row_hot_main as $row_hot)
		{
			$hots_array[$vg]='<strong>'.$row_hot['spot_name'].'</strong> {'.$row_hot['spot_timings'].' }';
			$vg++;
		} 
				
		if(isset($show_in_next_day) && $show_in_next_day==2)
		{
			$show_in_next_day=3;
			$tot_div_hot=floor(count($hots_array)/($area_cnt[$row_trv['tr_from_cityid']]-1));
		}
		else
		{
			$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_from_cityid']]);	
		}
		
		for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<$tot_div_hot+$rem_area_cnt[$row_trv['tr_from_cityid']];$hs++)
		{
			if(isset($hots_array[$hs]))
			{
				$html.= $hots_array[$hs].',';
			}
		}
		$rem_area_cnt[$row_trv['tr_from_cityid']]=$rem_area_cnt[$row_trv['tr_from_cityid']]+$tot_div_hot;
		$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-1;
					
							//for ending city hotspot if ending in different city
		if(($row_trv['tr_from_cityid'] != $row_trv['tr_to_cityid']) && $row_distanc['dist']<=180)
		{
			
			$hot1= $conn->prepare("SELECT * FROM hotspots_pro where spot_city =?");
$hot1->execute(array($row_cityy_to['id']));
//$row_hot1 = mysql_fetch_assoc($hot1);
$row_hot1_main=$hot1->fetchAll();
$totalRows_hot1 = $hot1->rowCount();
			
			$hots_array=array();
			$vg=0;
			foreach($row_hot1_main as $row_hot1)
			{
				$hots_array[$vg]='<strong>'.$row_hot1['spot_name'].'</strong> {'.$row_hot1['spot_timings'].' }';
				$vg++;
			} 
								
			$area_cnt[$row_trv['tr_to_cityid']]=$area_cnt[$row_trv['tr_to_cityid']]+1;
			$copy_area_arr[$row_trv['tr_to_cityid']]=$copy_area_arr[$row_trv['tr_to_cityid']]+1;
			if(isset($show_in_next_day) && $show_in_next_day==2)
			{
				$show_in_next_day=3;
				$tot_div_hot=floor(count($hots_array)/($area_cnt[$row_trv['tr_to_cityid']]-1));
			}
			else
			{
				$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_to_cityid']]);	
			}
										
			for($hs1=$rem_area_cnt[$row_trv['tr_to_cityid']];$hs1<$tot_div_hot+$rem_area_cnt[$row_trv['tr_to_cityid']];$hs1++)
			{
				$html.= $hots_array[$hs1].', ';
			}
			
			$rem_area_cnt[$row_trv['tr_to_cityid']]=$rem_area_cnt[$row_trv['tr_to_cityid']]+$tot_div_hot;
			$copy_area_arr[$row_trv['tr_to_cityid']]=$copy_area_arr[$row_trv['tr_to_cityid']]-1;
		}
							
							//calculation for last day previouslly
		$dept_date_time1=$row_trv['tr_date'].' '.$row_orders['trv_depatr_time'];
		$dept_date_tstmp1=date('U',strtotime($dept_date_time1));
		$dept_time4pm1=date('U',strtotime($row_trv['tr_date'].' 04:00 PM'));//for next day morning - arrival
							
		if(($totalRows_trv ==2 && $dept_date_tstmp1<$dept_time4pm1))
		{
			for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<count($hots_array);$hs++)
			{
				$html.= $hots_array[$hs].',';//for final day
			}
		}
		
	} 
	if($row_trv['tr_from_cityid'] == $row_trv['tr_to_cityid'])
	{
		$html.= 'and later return to hotel. Overnight stay at '.$row_hotel2['hotel_name'].' hotel.';
		//DAYTRIP code here
		if(!empty($dt_arr))
		{
			if(isset($dt_arr[$row_trv['tr_from_cityid']][0]))
			{
				$html.= "<br><span style='font-weight:bold; color:green'>"."DAYTRIP applicable to ".$dt_arr[$row_trv['tr_from_cityid']][0]."</span>";
				unset($dt_arr[$row_trv['tr_from_cityid']][0]);
				$dt_arr[$row_trv['tr_from_cityid']] = array_values($dt_arr[$row_trv['tr_from_cityid']]);
			}
		}
	}
	else
	{
		$html.= 'and later proceed to '.$row_trv['tr_to_cityid'].'. Overnight stay at '.$row_hotel2['hotel_name'].' hotel. ';
	}
}

$html.='</p></td>
</tr>
</table>
</td>
</tr>';
$chn++;
}
else
{
	$html.='<tr>
    <td colspan="6">
	
	<table width="100%" border="0">

	<tr>
        <td width="14%" rowspan="3" style="background-color:#E9E9E9"><p style="text-align:center; font-family:sans-serif; font-size: 12px;">';
	if($row_trv['tr_date'] != '')
	{
		$html.= date('d-M-Y D',strtotime(str_replace('-','/',$row_trv['tr_date'])));
	}
	
$cityy1 = $conn->prepare("SELECT * FROM dvi_cities where name LIKE ?");
$cityy1->execute(array($row_trv['tr_from_cityid']));
$row_cityy1 = $cityy1->fetch(PDO::FETCH_ASSOC);
$totalRows_cityy1 = $cityy1->rowCount();


								
$cityy_to = $conn->prepare("SELECT * FROM dvi_cities where name LIKE ?");
$cityy_to->execute(array($row_trv['tr_to_cityid']));
$row_cityy_to = $cityy_to->fetch(PDO::FETCH_ASSOC);
$totalRows_cityy_to = $cityy_to->rowCount();

			
//calculate distance
	
$distanc = $conn->prepare("SELECT * FROM dvi_citydist where (from_cityid =? and to_cityid =?) or (from_cityid =? and to_cityid =?)");
$distanc->execute(array($row_cityy1['id'],$row_cityy_to['id'],$row_cityy_to['id'],$row_cityy1['id']));
$row_distanc= $distanc->fetch(PDO::FETCH_ASSOC);
$totalRows_distanc = $distanc->rowCount();





$hot= $conn->prepare("SELECT * FROM hotspots_pro where spot_city =? ORDER BY spot_prior ASC");
$hot->execute(array($row_cityy1['id']));
//$row_hot = mysql_fetch_assoc($hot);
$row_hot_main=$hot->fetchAll();
$totalRows_hot = $hot->rowCount();
		$html.='</p></td>
<td><font style="font-weight: bold; font-family:sans-serif; text-align: center; font-size: 12px">';
$html.= $row_trv['tr_from_cityid']."&nbsp;&nbsp;-&nbsp;&nbsp;".$row_trv['tr_to_cityid']."&nbsp;( Departure )  [ ".$row_orders['tr_depdet']."&nbsp; @".$row_orders['trv_depatr_time']." ]";

if($row_distanc['dist']>0)
{
	$html.= " (".$row_distanc['dist']." Kms)";
}
else
{
	$ss_dist = $conn->prepare("SELECT * FROM dvi_cities where id=?");
$ss_dist->execute(array($row_cityy_to['id']));
$row_ss_dist=$ss_dist->fetch(PDO::FETCH_ASSOC);
$totalRows_ss_dist = $ss_dist->rowCount();	
	
	$html.= "";
}
									
$html.='</td>
      </tr>
    
      <tr>
        <td><p style="text-align:justify; font-family:sans-serif; font-size: 12px">';
$html.= "After breakfast check out hotel"; 
									//time calculation 
									
$dept_date_time=$row_trv['tr_date'].' '.$row_orders['trv_depatr_time'];
$dept_date_tstmp=date('U',strtotime($dept_date_time));
$dept_time4pm=date('U',strtotime($row_trv['tr_date'].' 04:00 PM'));//for next day morning - arrival
									
if($dept_date_tstmp>=$dept_time4pm)
{//departure time is within 4-pm - show hot spots
	$html.= ", and proceed to visit the following Sight-seeing spots - ";
	$hots_array=array();
	$vg=0;
	foreach($row_hot_main as $row_hot)
	{
		$hots_array[$vg]='<strong>'.$row_hot['spot_name'].'</strong> {'.$row_hot['spot_timings'].' }';
		$vg++;
	} 
										
	if(isset($show_in_next_day) && $show_in_next_day==2)
	{
		$show_in_next_day=3;
		$tot_div_hot=floor(count($hots_array)/($area_cnt[$row_trv['tr_from_cityid']]-1));
	}
	else
	{
		$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_from_cityid']]);	
	}
										
	for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<floor(count($hots_array));$hs++)
	{
		if(isset($hots_array[$hs]))
		{
			$html.= $hots_array[$hs].',';
		}
	}
	
	$rem_area_cnt[$row_trv['tr_from_cityid']]=$rem_area_cnt[$row_trv['tr_from_cityid']]+$tot_div_hot;
	$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-1;
	
										
	$html.= "finally, we transfer you to ".$row_trv['tr_to_cityid']." airport/railway station.";
	}
	else
	{
		//departure time is not within 4-pm - dont show hot spots
		$html.= " and we transfer you to ".$row_trv['tr_to_cityid']." airport/railway station.";
	}
	$html.='</p></td>
      </tr>
</table></td>
	</tr>';

}

$row_count--;
$totalRows_trv--;
$i++;

}
	$html.='
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr >
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr></table>';

$sspro1 = $conn->prepare("SELECT * FROM stay_sched where stay_id =? ORDER BY sno ASC ");
$sspro1->execute(array($_GET['planid']));
//$row_sspro1 = mysql_fetch_assoc($sspro1);
$row_sspro1_main =$sspro1->fetchAll();
$totalRows_sspro1 = $sspro1->rowCount();

if($totalRows_sspro1>0)
{
	$first_day=0;
	$last_day=1;
foreach($row_sspro1_main as $row_sspro1)
{

  $html.='<hr><table class="tag" style="border-top:#FFF; border-bottom:#FFF; border-left:#FFF; border-right:#FFF; margin-top:50px;" ><tr>
    <td class="hide_border" colspan="6"><center><font style="font-weight: bold; color:#900; font-family:sans-serif; text-align: center; font-size: 16px">Voucher Details</font></center></td>
  </tr>
 <tr>
    <td class="hide_border" colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td class="hide_border" colspan="6"><table width="100%" border="0">
      <tr>
        <td><font style="font-weight: bold; float:left; font-family:sans-serif; text-align: left; font-size: 12px; margin-left:5px">Voucher Date : ' .$today.'</font> </td>
        <td><font style="font-weight: bold; float:right; font-family:sans-serif; text-align: right; font-size: 12px; ">Voucher No : ' .$row_sspro1['sty_date']."/DVI-HTL-".$idd[1].'</font></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="hide_border" colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6"><table width="100%" border="1" style="font-family: sans-serif; text-align: left; font-size: 12px">
      <tr class="hide_border">
        <td colspan="2" height="25px" class="hide_border"  style="text-align: center; font-weight: bold;">Hotel Exchange Voucher</td>
        </tr>
      <tr class="hide_border">
        <td width="48%;" height="30px" >Guest Name</td>
        <td width="52%" height="30px">'.$row_orders['tr_name']." * ".$row_orders['pax_cnt'];'.</td>
      </tr>';
		
		$sp = $conn-<prepare("SELECT * FROM stay_sched where stay_id =? and hotel_id=?  ORDER BY sno ASC ");
$sp->execute(array($_GET['planid'],$row_sspro1['hotel_id']));
$row_sp =$sp->fetch(PDO::FETCH_ASSOC);
$totalRows_sp = $sp->rowCount();
								
		$old_date= date('d-M-Y',strtotime($row_sspro1['sty_date']));
		if($totalRows_sp>1)
		{			
			 $totalRows_sp2=$totalRows_sp;
			 $derf=$totalRows_sp2;
			$date=date_create($row_sspro1['sty_date']);
			date_add($date,date_interval_create_from_date_string($totalRows_sp2." days"));
			
			$next_datt=date_format($date,"d-M-Y");
		}
		else
		{
			$totalRows_sp2=0;
			$derf=1;
			$date=date_create($row_sspro1['sty_date']);
			date_add($date,date_interval_create_from_date_string("1 days"));
			
			$next_datt=date_format($date,"d-M-Y");
		}
		$html.='<tr><td width="48%;" height="30px" >Check In Date</td>
		<td width="48%;" height="30px" >'.$old_date.'</td></tr>
      <tr>
        <td height="25px">Check Out Date</td>
        <td height="25px">'.$next_datt.'</td>
      </tr>
      <tr>
        <td height="25px" >Hotel Name</td>
        <td height="25px">';

$hotell = $conn->prepare("SELECT * FROM hotel_pro where hotel_id =?");
$hotell->execute(array($row_sspro1['hotel_id']));
$row_hotell = $hotell->fetch(PDO::FETCH_ASSOC);
$totalRows_hotell =$hotell->rowCount();


$cityy1 = $conn->prepare("SELECT * FROM dvi_cities where id =?");
$cityy1->execute(array($row_hotell['city']));
$row_cityy1 =$cityy1->fetch(PDO::FETCH_ASSOC);
$totalRows_cityy1 =$cityy1->rowCount();


$stt = $conn->prepare("SELECT * FROM dvi_states where code =?");
$stt->execute(array($row_hotell['state']));
$row_stt = $stt->fetch(PDO::FETCH_ASSOC);
$totalRows_stt = $stt->rowCount();

$html.= $row_hotell['hotel_name']."&nbsp;[&nbsp;".$row_hotell['category']."&nbsp;Hotel&nbsp;]";
		$html.='</td>
      </tr>
      <tr>
        <td height="25px">Address</td>
        <td height="25px"><p>'.$row_hotell['location'].",&nbsp;".$row_cityy1['name'].",&nbsp;".$row_stt['name'].'</p></td>
      </tr>
      <tr>
        <td height="25px">Accomodation</td>
        <td height="25px">'.$row_orders['pax_adults']."-Adults, ".$row_orders['pax_512child']."-Child(5-12), ".$row_orders['pax_child']."-Child(below 5)";'</td>
      </tr>
      <tr>
        <td height="25px">Room Category</td>
        <td height="25px">';
		$rrom=explode(',',$row_sspro1['sty_room_type']);
		$rrom1=array_unique($rrom);
		$rrom2=array_count_values($rrom);
		for($tt=0;$tt<count($rrom1);$tt++)
		{
			 
			$hroom = $conn->prepare("SELECT * FROM hotel_season where sno =?");
$hroom->execute(array($rrom1[$tt]));
$row_hroom = $hroom->fetch(PDO::FETCH_ASSOC);
$totalRows_hroom = $hroom->rowCount();
			if(isset($rrom1[$tt+1]) && $rrom1[$tt+1] !='')
			{
				$html.= $row_hroom['room_type']; 
				$no_of_rrr=$rrom2[$rrom1[$tt]];
			}else
			{
				$html.= $row_hroom['room_type']; 
				$no_of_rrr=$rrom2[$rrom1[$tt]];
			}
		}
		$html.='</td>
      </tr>
      <tr>
        <td height="25px">Total Rooms</td>
        <td height="25px">'.$no_of_rrr.'</td>
      </tr>
	  <tr>
        <td height="25px">Extra Bed</td>
        <td height="25px">';
		$extra_bed=explode(',',$row_sspro1['sty_child_bed']); 
			   $with_bd_ctn=0;
			   $without_bd_ctn=0;
			   for($t=0;$t<count($extra_bed);$t++)
			   {
					if($extra_bed[$t]=='0')
					{
						$with_bd_ctn++;
					}else if($extra_bed[$t]=='1')
					{
						$without_bd_ctn++;
					}
			   }
			   if($with_bd_ctn>0)
			   {
					$html.= "Extra with bed - ".$with_bd_ctn;
			   }
			   if($without_bd_ctn>0)
			   {
				 $html.=  "<br> Extra without bed - ".$without_bd_ctn;  
			   }
			   if($without_bd_ctn==0 && $with_bd_ctn==0)
			   {
				$html.= "Nil";   
			   }'</td>
      </tr>
      <tr>
        <td height="25px">Meal Plan</td>
        <td height="25px">';
		if($row_sspro1['sty_food']=='dinner_rate')
		 {
			//$html.= "Breakfast & Dinner only "; 
			 							if($first_day==0)
										 {
											 $html.="Dinner only";
											 $first_day++;
											  
										 }else
										 {	
										 	if($totalRows_sspro1==$last_day)
											{
												$html.="Breakfast only";
											}else
											{
												$html.="Breakfast & Dinner only"; 
											}
										 }
			
		 }
		 else if($row_sspro1['sty_food']=='lunch_rate')
		 {
			// $html.= "Breakfast & Lunch only"; 
			
			 							if($first_day==0)
										 {
											 $html.="Lunch only";
											 $first_day++;
											  
										 }else
										 {
											if($totalRows_sspro1==$last_day)
											{
												$html.="Breakfast only";
											}else
											{
												$html.="Breakfast & Lunch only"; 
											}
										 }
			
		 }
		 else if($row_sspro1['sty_food']=='both_food')
		 {
			 //$html.= "Breakfast,Lunch & Dinner"; 
			 
										  if($first_day==0)
										 {
											$html.="Lunch & Dinner only";
											 $first_day++;
											  
										 }else
										 {
											if($totalRows_sspro1==$last_day)
											{
												$html.="Breakfast & Lunch only";
											}else
											{
												$html.="Breakfast,Lunch & Dinner"; 
											}
										 }
									 
			 
		 }else
		 {
			  //$html.= "Breakfast only";
			   if($first_day!=0)
										 {
											$html.="Breakfast only";
										 }else{
											$html.="No Food";
										 }
		 }
		$html.='</td>
      </tr>';
	  if(trim($row_sspro1['sty_extra']) != '') { 
	   $spl_amen=explode(',',$row_sspro1['sty_extra']);
	  $html.='<tr>
        <td height="25px">Special Amenities</td>
        <td height="25px">';
		for($sa=0;$sa<count($spl_amen);$sa++){
		if($spl_amen[$sa]=='candle_light')
		{
			$html.= "Candle Light";
		}
		else if($spl_amen[$sa]=='fruit_basket')
		{
			$html.= "Fruit Basket";
		}else if($spl_amen[$sa]=='flower_bed')
		{
			$html.= "Flower Bed";
		}else if($spl_amen[$sa]=='cake_rate')
		{
			$html.= "Special Cake";
		}
		if(isset($spl_amen[$sa+1]))
		{
			$html.= ",&nbsp;";
		}
		}
		$html.='</td>
      </tr>';
	  }
	  $html.='<tr>
        <td height="25px">Billing</td>
        <td height="25px">';
		$html.=$row_sspro1['sty_date']."/DVI-HTL-".$idd[1];
		$html.='</td>
      </tr>
      
      <tr>
        <td height="25px">Customer Care Numbers</td>
        <td height="25px">';
		
		$agent = $conn->prepare("SELECT * FROM agent_pro where agent_id =?");
$agent->execute(array($row_orders['agent_id']));
$row_agent = $agent->fetch(PDO::FETCH_ASSOC);
$totalRows_agent = $agent->rowCount();

		$html.= "24*7 @ All India Customer Care - 9843288844";
		$html.='</td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: center; font-weight: bold;border:none">&nbsp;</td>
        </tr>
		<tr>
        <td colspan="2" style="text-align: center; font-weight: bold;border:none">DVI Holidays wishes you a pleasant stay</td>
        </tr>
      <tr>
        <td style="border:none">&nbsp;</td>
        <td style="border:none"><p style="font-weight: bold; font-family:sans-serif; font-size: 12px; text-align: right; margin-right:10px;">Authorised Signatory,</p></td>
      </tr>
      <tr>
        
        <td colspan="2" style="border:none"><p style="font-family: sans-serif; text-align: right;"><strong style="font-size:10px">(System generated voucher. No signature required.)</strong></p></td>
      </tr>
      
	   
      <tr>
        <td colspan="2" style="text-align: left">';
		$html.='<b>General Policies</b><br>
                                <b>As per Government of India rules, it is mandatory for all guests over the age of 18 years to present a valid photo identification ( ID ) on check-in.</b><br>
                                <b>Entry to the hotel is at the sole discretion of the hotel authority. If the address on the photo identification card matches the city where the hotel is located, the hotel may refuse to provide accommodation.</b><br>
                                <b>Dvi will not be responsible for any check-in denied by the hotel due to the aforesaid reasons. Due to any natural or political or local issues if there is any damage to personal or tour DVI ma not take the responsibility.</b><br>
                                <b>If the booking includes the extra bed it is facilitated with a folding cot or a mattress as an extra bed, as pert eh hotel policy.</b><br>';
		$html.='</td>
      </tr>
    </table></td>
  </tr>
 </table></td></tr></table></td></tr>';
	if($totalRows_sp2>1)
	{
		for($rt=0;$rt<$derf-1;$rt++)
		{
			$row_sspro1 = $sspro1->fetch(PDO::FETCH_ASSOC);
		}
	}	
	}
}


$mst = $conn->prepare("SELECT * FROM travel_master where plan_id =?");
$mst->execute(array($_GET['planid']));
$row_mst = $mst->fetch(PDO::FETCH_ASSOC);
$totalRows_mst = $mst->rowCount();


$trl_scd = $conn->prepare("SELECT * FROM travel_sched where travel_id =? ORDER BY sno ASC");
$trl_scd->execute(array($_GET['planid']));
$row_trl_scd =$trl_scd->fetch(PDO::FETCH_ASSOC);
//$row_trl_arr = mysql_fetch_array($trl_scd);
$totalRows_trl_scd = $trl_scd->rowCount();

$start_dtour=date("d- M- Y",strtotime($row_trl_scd['tr_date']));
for($ko=0;$ko<$totalRows_trl_scd-1;$ko++)
{
	$row_trl_scd = $trl_scd->fetch(PDO::FETCH_ASSOC);
}
$last_dtour=date("d- M- Y",strtotime($row_trl_scd['tr_date']));


$sy_scd = $conn->prepare("SELECT * FROM stay_sched where stay_id =?");
$sy_scd->execute(array($_GET['planid']));
$row_sy_scd = $sy_scd->fetch(PDO::FETCH_ASSOC);
$totalRows_sy_scd = $sy_scd->rowCount();

  $html.='<hr><table  border="none" ><tr >
    <td colspan="6" class="hide_border" >
	<h3><font style="font-weight: bold; float:left; font-family:sans-serif; text-align:left; font-size: 12px; margin-left:5px">Dear : '.$row_mst['tr_name']." *".$row_mst['pax_cnt'].'</font><font style="font-weight: bold; float:left; font-family:sans-serif; text-align:right; font-size: 12px; margin-left:5px">Tour Date : '.$start_dtour." To ".$last_dtour." &nbsp;&nbsp;[ ".$totalRows_trl_scd.' days ]</font></h3>
   </td>
  </tr>
  <tr class="hide_border"> 
    <td class="hide_border" colspan="6">
	<table width="100%"  border="0" style="font-family: sans-serif; margin-top:20px; text-align: left; font-size: 12px">
      <tr>
        <td class="hide_border" colspan="2"  height="55px;" style="text-align: left; font-weight: bold;">Greetings from DVI Holidays !!!</td>
        </tr>
      <tr >
        <td class="hide_border" height="15px;" colspan="2">Thank you for your choice to use DVI Holidays</td>
        </tr>
      <tr>
        <td colspan="2" class="hide_border" ><p>The Motto of our company is to provide satisfactory servies to our entire guest. In order to achevieve this aim, we need to know your opinion on it. prasie would be a motivation for us to continue our services. And any critic would naturally be a reason for us to improve our services according to the requirements and desires of our Guests.</p></td>
        </tr>
      <tr>
        <td colspan="2" height="30px"><strong>Please tell your Friends what would you like about us!</strong></td>
        </tr>
      <tr>
        <td colspan="2" height="30px"><strong>Please tell us what you dislike.</strong></td>
        </tr>
      <tr>
        <td  colspan="2">1) Tell Us about the vehicles and its drivers for your whole trip?</td>
      </tr>
      <tr>
        <td  colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;vehicle provided :<br><br><br><br><br></td>
      </tr>
      <tr>
        <td  colspan="2">2) Is the vehicle is on Time at the airport on your arrival?</td>
      </tr>
      <tr>
        <td  colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;vehicle Provided :<br><br><br><br><br> </td>
      </tr>
      <tr>
        <td  colspan="2">3) How about the drivers services to you?</td>
      </tr>
      <tr>
        <td  colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Driver Name :<br><br><br><br><br> </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: left">Tell us about the hotels which you have been used for your whole trip.</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr></table><td></tr>';
	
	
	$trl_scd1 = $conn->prepare("SELECT * FROM travel_sched where travel_id =? ORDER BY sno ASC");
$trl_scd1->execute(array($_GET['planid']));
//$row_trl_scd1 = mysql_fetch_assoc($trl_scd1);
//$row_trl_arr1 = mysql_fetch_array($trl_scd1);
$row_trl_scd1_main =$trl_scd1->fetchAll();
$totalRows_trl_scd1 = $trl_scd1->rowCount();
	
	
	$sy_scd1 = $conn->prepare("SELECT * FROM stay_sched where stay_id =?");
$sy_scd1->execute(array($_GET['planid']));
//$row_sy_scd1 = mysql_fetch_assoc($sy_scd1);
$row_sy_scd1_main=$sy_scd1->fetchAll();
$totalRows_sy_scd1 =$sy_scd1->rowCount();
								$i=0;
								foreach($row_sy_scd1_main as $row_sy_scd1)
	{
		$row_trl_scd1 =$row_trl_scd1_main[$i];
		if($row_sy_scd1['sty_date'] == $row_trl_scd1['tr_date'])
		{
			
			$shot = $conn->prepare("SELECT * FROM hotel_pro where hotel_id =?");
$shot->execute(array($row_sy_scd1['hotel_id']));
$row_shot= $shot->fetch(PDO::FETCH_ASSOC);
$totalRows_shot = $shot->rowCount();
      
	  $html.='<tr>
        <td colspan="6" class="hide_border"  style="text-align:left; font-weight: bold;">'.$row_trl_scd1['tr_to_cityid'].' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.$row_shot['hotel_name'].' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Check-In :  '.date("d-M-Y",strtotime($row_trl_scd1['tr_date'])).'';
		
										$flag=true;
										while($flag)
										{
											
											$sy_ntx= $conn->prepare("SELECT * FROM stay_sched where stay_id =? and sno=?");
$sy_ntx->execute(array($_GET['planid'],($row_sy_scd1['sno']+1)));
$row_sy_ntx = $sy_ntx->fetch(PDO::FETCH_ASSOC);
$totalRows_sy_ntx = $sy_ntx->rowCount();
											
											if($totalRows_sy_ntx>0)
											{
												if($row_sy_scd1['hotel_id']==$row_sy_ntx['hotel_id'])
												{
													$row_sy_scd1 = $sy_scd1->fetch(PDO::FETCH_ASSOC);
													$row_trl_scd1 =$trl_scd1->fetch(PDO::FETCH_ASSOC);
													$totalRows_sy_scd1--; 
													$flag=true;
												}else{
													$flag=false;
													break;	
												}
											}else{
												$flag=false;	
												break;	
											}
										}
										$date=date_create($row_trl_scd1['tr_date']);
										date_add($date,date_interval_create_from_date_string("1 days"));
		
		 $html.='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Check-Out: '.$next_datt=date_format($date,"d-M-Y").'</td>
      </tr>
      <tr >
        <td colspan="6" class="hide_border" style="text-align: left">
		<table width="100%" border="0"  style="font-family: sans-serif; text-align: left; font-size: 12px">
          <tr>
            <td width="10%" height="25px" >Rooms</td>
            <td width="15%" height="25px" style="text-align: center">Poor</td>
            <td width="15%" height="25px" style="text-align: center">Good</td>
            <td width="15%" height="25px" style="text-align: center">Very Good</td>
            <td width="15%" height="25px" style="text-align: center">Excellent</td>
            <td width="30%" height="25px">&nbsp;</td>
            </tr>
			<tr><td colspan="6"></td></tr>
          <tr>
            <td height="25px">Food</td>
            <td height="25px" style="text-align: center">Poor</td>
            <td height="25px" style="text-align: center">Good</td>
            <td height="25px" style="text-align: center">Very Good</td>
            <td height="25px" style="text-align: center">Excellent</td>
            <td height="25px">&nbsp;</td>
            </tr>
			<tr><td colspan="6"></td></tr>
			
          <tr>
            <td>Staff</td>
            <td height="25px" style="text-align: center">Poor</td>
            <td height="25px" style="text-align: center">Good</td>
            <td height="25px" style="text-align: center">Very Good</td>
            <td height="25px" style="text-align: center">Excellent</td>
            <td height="25px">&nbsp;</td>
            </tr>
			<tr><td colspan="6"></td></tr>
			
          <tr>
            <td colspan="6">Anything needs to be improved, please mention.<br><br><br><br></td>
            </tr>
			<tr><td colspan="6"></td></tr>
			<tr><td colspan="6"></td></tr>
			<tr><td colspan="6"></td></tr>
          </table></td>
      </tr>';
	  $totalRows_sy_scd1--; 
	  $i++;
		}
	}
		$html.='<tr><td colspan="6" class="hide_border" style="text-align: left">
		<table class="hide_border">
		<tr><td colspan="2 " class="hide_border">Please tell us about the overall feedback on DVI Holidays for organizing your tour.</td></tr>
		<tr><td colspan="2" class="hide_border">&nbsp;</td></tr>
		<tr><td width="20%" class="hide_border">Name</td><td class="hide_border" width="10%">:</td><td class="hide_border" width=70%></td></tr>
		<tr><td width="20%" class="hide_border">Email ID</td><td class="hide_border" width="10%">:</td><td class="hide_border" width=70%></td></tr>
		<tr><td width="20%" class="hide_border">Address</td><td class="hide_border" width="10%">:</td><td class="hide_border" width=70%></td></tr>
		<tr><td colspan="2" class="hide_border">&nbsp;</td></tr>
		<tr><td colspan="2" class="hide_border">&nbsp;</td></tr>
		<tr><td colspan="2" class="hide_border" style="text-align:center">Thank you..</td></tr>
		</table><hr></td></tr>
		
		
		
		<tr><td colspan="6" class="hide_border" style="text-align: left">
		<table width="100%"  border="0" style="font-family: sans-serif; margin-top:20px; text-align: left; font-size: 12px">
      <tr>
        <td class="hide_border" colspan="2"  height="20px;" style="text-align: left; font-weight: bold;">Package  Includes:</td>
        </tr>
      <tr >
        <td class="hide_border" height="1px" colspan="2">Transfers and sightseeing  By  deluxe  tourists vehicle <span style="color:#F00">(Vehicles up hill driving on the hills would be on Non AC) </span></td>
        </tr>
      <tr>
        <td colspan="2" height="1px">Toll & Parking </td>
        </tr>
      <tr>
        <td colspan="2" height="1px">All Hotel Taxes & Service Taxes</td>
        </tr>
		
      <tr>
        <td colspan="2" height="1px">All local sightseeing in the same vehicle, every day after breakfast till sunset.<br><br></td>
        </tr>
      <tr>
        <td class="hide_border" height="1px" colspan="2"><span style="color:#F00">If staying IN the House boat </span></td>
      </tr>
      <tr>
        <td colspan="2" height="1px">House Boat with all Meals and Ac In the house boat operates from 09 PM to 06 Am only.<br><br></td>
      </tr>
      <tr>
        <td class="hide_border" height="1px" colspan="2"><span style="color:#F00">If the booking includes the extra bed it is facilitated with a folding cot or a mattress as an extra bed, as per the hotel policy. <br><br></span></td>
      </tr>
      <tr>
        <td class="hide_border" height="1px" colspan="2"><span style="color:#F00"><b>Hotel Check in and check out time at Hotel is 1200 Noon </b></span><br><br><br></td>
      </tr>
      <tr>
        <td colspan="2" height="1px"><b>Rate does not include</b></td>
      </tr>
      <tr>
        <td colspan="2" height="1px">Any international / Domestic Air Fare if any quoted separately</td>
      </tr>
	  <tr>
        <td colspan="2" height="1px">English speaking guide / escort charges Airport Tax</td>
      </tr>
	  <tr>
        <td colspan="2" height="1px">Extra bed All meals (other than above mentioned ones)</td>
      </tr>
	  <tr>
        <td colspan="2" height="1px">Personal nature expenses such as telephone calls, Laundry, soft / hard drinks, lunch tipping etc.,</td>
      </tr>
	  <tr>
        <td colspan="2" height="1px">Camera fee at monuments</td>
      </tr>
	  <tr>
        <td colspan="2" height="1px">Monument OR TEMPLE Entrance Fees Boat ride</td>
      </tr>
	  <tr>
        <td colspan="2" height="1px">Any Porterage services at Airport / Railway station</td>
      </tr>
	  <tr>
        <td colspan="2" height="1px">Any other expenses not mentioned in the above cost.</td>
      </tr>
	  <tr>
        <td colspan="2" height="1px">Rates are subject to change in case of inflation or tax hikes, rates based on currently applicable taxes <br><br></td>
      </tr>
	  <tr>
        <td colspan="2" height="1px">IMPORTANT: Kindly note that names of hotels mentioned above only indicate that our rates have been based on usage of these hotels and it is not to be construed that accommodation is confirmed at these hotels until and unless we convey such confirmation to you. In the event of any of the above mentioned hotels not becoming available we shall book alternate accommodation at a similar or next best available hotel and shall pass on the difference of rates (supplement/reduction whatever applicable)<br><br></td>
      </tr>
	  <tr>
        <td class="hide_border" height="1px" colspan="2"><span style="color:#F00">Cancellation policy <br></span></td>
      </tr>
	  <tr>
        <td colspan="2" height="1px">CANCELLATION 30% of Package cost, if the cancellation is made 30 days prior to the departure. 50% of package cost, if the cancellation is made between 30-14 days prior to the departure.    |   70% of package cost, if the cancellation is made between 17-7 days prior to the departure.     |     100% of package cost, if the cancellation is made 7 days or less prior to the departure.<br><br></td>
      </tr>
	  <tr>
        <td colspan="2" height="1px"><b>General  Policy</b></td>
      </tr>
      <tr>
        <td colspan="2" height="1px">Child cost depends upon hotels rule which may vary from one hotel to another. The most common rules are as under..</td>
      </tr>
	  <tr>
        <td colspan="2" height="1px">Child up to 5 years is free. Child above 5 years to 12 will be charged as per hotel rule. Child above 12 years will be charged as adult.</td>
      </tr>
	  <tr>
        <td colspan="2" height="1px">If your reservation at hotels includes an extra bed, most hotels provide a folding cot or a mattress on floor as an extra bed.</td>
      </tr>
	  <tr>
        <td colspan="2" height="1px">Check in and check out in most of the hotels at 1200 noon in the cities, In Hill stastions check in 1400 hrs check out 11 hrs, </td>
      </tr>
	  <tr>
        <td colspan="2" height="1px">Early check-in or late check-out is subject to availability and may be chargeable by the hotel.</td>
      </tr>
	  <tr>
        <td colspan="2" height="1px">To request for an early check-in or late check-out, kindly contact the hotel directly or inform us prior.</td>
      </tr>
	   
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr></table></td></tr></table></body></html>';

$fromnam=$row_orders['plan_id'].'.pdf';
$dompdf = new DOMPDF();
$dompdf->load_html($html);
  //$paper_size = array(0,0,612.00,792.00);
$dompdf->set_paper('A4','portrait');
$dompdf->render();
$dompdf->stream($fromnam, array("Attachment" => false));

//$pdf = $dompdf->output();
?>
