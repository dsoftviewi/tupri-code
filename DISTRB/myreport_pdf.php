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

$ttotl_pax=$row_orders['pax_cnt']-$row_orders['pax_child'];


$html='<html xmlns="http://www.w3.org/1999/xhtml">
<body style="margin-top:105px; margin-bottom:5px">
<style>


.hide_border{
border-top:#FFF;
 border-bottom:#FFF; 
 border-left:#FFF; 
border-right:#FFF	
}


table{
 border-collapse: collapse;	
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
</td>

    </tr>
  </table>
</div>

<div id="footer"  style="margin-top:-20px" > 
<strong>Head Office : </strong><strong>#51, Vijaya Nagar, Dheeran Nagar (Extn), Karumandapam, Trichirappalli, Tamilnadu - 620009</strong><br />
<strong>Ph : </strong><strong>0431-2403615 </strong>&nbsp;&nbsp;&nbsp;<strong> H Phone :</strong><strong>9843288844</strong>&nbsp;&nbsp;&nbsp;<strong> Windows Live ID : </strong><strong> <u>vsr@dvi.co.in</u></strong><br />
<strong>BRANCHES :: </strong>&nbsp;<strong>MADURAI | COCHIN | HYDERABAD</strong>
</div>

<table width="100%" border="0">
   <tr>';
  
	  
  $html.='<td colspan="6"><table width="100%" border="0">
      <tr >
        <td colspan="2"><font style="font-weight:  color:#900; font-family:sans-serif; text-align: center; font-size: 16px">Your Travel Details:</font></td>
       
		<td colspan="1" align="right"><font style="font-weight:  font-size: 16px">Booking Date:'.$row_orders['date_of_reg'].'</font>		</td>
        </tr>
      <tr>
        <td colspan="3">&nbsp;</td>
      </tr>
      <tr >
        <td width="20%"><font style="font-weight: bold; font-family:sans-serif; text-align: center; font-size: 12px">Guest Name</font></td>
        <td width="1%">:</td>
        <td width="79%"><font style="font-weight:  font-family:sans-serif; text-align: center; font-size: 12px"> '.$row_orders['tr_name'].'</font></td>
      </tr>
      <tr>
        <td><font style="font-weight: bold; font-family:sans-serif; text-align: center; font-size: 12px">Occupancy</font></td>
        <td>:</td>
        <td><font style="font-weight:  font-family:sans-serif; text-align: center; font-size: 12px">'.$row_orders['pax_cnt'].' ['.$row_orders['pax_adults'].'+'.$row_orders['pax_512child'].'+'.$row_orders['pax_child'].']'.'</font></td>
      </tr>
	  <tr>
        <td><font style="font-weight: bold; font-family:sans-serif; text-align: center; font-size: 12px">Arrival Date</font></td>
        <td>:</td>
        <td><font style="font-weight:  font-family:sans-serif; text-align: center; font-size: 12px">'.$row_orders['tr_arr_date'].' '.$row_orders['tr_arr_time'].'</font></td>
      </tr>
      <tr>
        <td><font style="font-weight: bold; font-family:sans-serif; text-align: center; font-size: 12px">Total Traveling days</font></td>
        <td>:</td>
        <td><font style="font-weight:  font-family:sans-serif; text-align: center; font-size: 12px">'.$row_orders['tr_days'].'</font></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>';
  
  if($str =='T' || $str =='TH')
  {
	
								$routes = $conn->prepare("SELECT * FROM travel_sched where travel_id =? ORDER BY sno ASC");
								$routes->execute(array($_GET['planid']));
								$row_routes_main = $routes->fetchAll();
								$totalRows_routes = $routes->rowCount();
	
	$cnt=1;
    $html.='
	<tr><td colspan="6"><font style="font-weight: bold; color:#900; font-family:sans-serif; text-align: center; font-size: 16px">Transport Details:</font></td></tr>
	<tr>
    <td colspan="6"><table width="100%" border="1">
      <tr style="font-weight: bold; text-align: left; font-family:sans-serif; font-size: 12px">
        <td style="padding:5px" width="20%">TRAVEL DATE</td>
        <td style="padding:5px" width="19%">TRAVEL DESC</td>
        <td style="padding:5px" width="20%">DISTANCE (Kms)</td>
        <td style="padding:5px" width="30%">TIME</td>
      </tr>';
	foreach($row_routes_main as $row_routes)
	{
	$html.='<tr style="text-align: left;  font-family:sans-serif; font-size: 12px">
        <td style="padding:5px">';$trv_date= date('d-M-Y',strtotime($row_routes['tr_date']));
		$html.=$trv_date;
		$html.='</td>
        <td style="padding:5px">'.$row_routes['tr_from_cityid'].' TO '.$row_routes['tr_to_cityid'].'
		</td>
        <td style="padding:5px">'.$row_routes['tr_dist_ess'].'
		</td>
        <td style="padding:5px">'.$row_routes['tr_time'].'</td>
      </tr>';
   	  $cnt++;
	} 
  }
	  $html.='</tr>
    </table>
  </tr>';


  
  if($str =='H' || $str =='TH')
  {
	
	$html.='<tr><td colspan="6">&nbsp;</td></tr>
	<tr><td colspan="6"><font style="font-weight: bold; color:#900; font-family:sans-serif; text-align: center; font-size: 16px">Hotel Details:</font></td></tr>
	<tr>
    <td colspan="6"><table width="100%" border="1">
      <tr style="font-weight: bold; text-align: left; font-family:sans-serif; font-size: 12px">
        <td style="padding:5px" width="4%">Sno</td>
        <td style="padding:5px" width="19%">Date</td>
        <td style="padding:5px" width="20%">Place</td>
        <td style="padding:5px" width="30%">Hotel</td>
        <td style="padding:5px" width="17%">Room Category</td>
        <td style="padding:5px" width="10%">Meal Plan</td>
      </tr>';
	  
	  $spro = $conn->prepare("SELECT * FROM stay_sched where stay_id =? ORDER BY sno ASC ");
$spro->execute(array($_GET['planid']));
//$row_spro = mysql_fetch_assoc($spro);
$row_spro_main=$spro->fetchAll();
$totalRows_spro = $spro->rowCount();
	  $scnt=1;	
	foreach($row_spro_main as $row_spro)
	{
	$html.='<tr style="text-align: left;  font-family:sans-serif; font-size: 12px">
        <td style="padding:5px">'.$scnt.'</td>
        <td style="padding:5px">';
		
		$spro1 = $conn->prepare("SELECT * FROM stay_sched where stay_id =? and hotel_id=?  ORDER BY sno ASC ");
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
$totalRows_hotell =$hotell->rowCount();

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
$row_hroom = $hroom->fetch(PDO::FETCH_ASSOC);
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
  

if($str =='TH')
{
  $html.='<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr><hr>';

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
$area_arr=array();
$gv=0;
$dt_cnt_arr=array();
while($row_trv_future = $trv_future->fetch(PDO::FETCH_ASSOC))
{
	$area_arr[$gv]=$row_trv_future['tr_from_cityid'];
	if($row_trv_future['tr_from_cityid']==$row_trv_future['tr_to_cityid']){
		$dt_cnt_arr[]=$gv;
	}
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
//$row_trv_main =$trv->fetchAll();
$totalRows_trv = $trv->rowCount();
$chn=0; 
$i=0;
if($totalRows_trv>0){	
$html.='<tr><td colspan="3"><font style="font-weight: bold; color:#900; font-family:sans-serif; text-align: center; font-size: 16px">Itinerary Details:</font></td>
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
while($totalRows_trv>0){
$row_trv = $trv->fetch(PDO::FETCH_ASSOC);
if($row_count>0)
{
	//for stay table - aft end day calculation
	$row_sspro = $sspro->fetch(PDO::FETCH_ASSOC);
	
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
	if(isset($dt_arr[$row_trv['tr_from_cityid']][0]) && $chn!=0 && in_array($chn,$dt_cnt_arr)){
$distanc = $conn->prepare("SELECT * FROM dvi_citydist where (from_cityid =? and to_cityid =?) or (from_cityid =? and to_cityid =?)");
$distanc->execute(array($row_cityy1['id'],$dt_arr[$row_trv['tr_from_cityid']]['id'],$dt_arr[$row_trv['tr_from_cityid']]['id'],$row_cityy1['id']));
$row_distanc= $distanc->fetch(PDO::FETCH_ASSOC);					
$totalRows_distanc = $distanc->rowCount();	
 $daytravel_dist=$row_distanc['dist']*2;
$today_dist =$daytravel_dist;
$html.= " (".$today_dist." Kms)"; 
								 
									 }
									 else{
	$html.= " (".$row_trv['tr_dist_ss']." Kms)";
	$today_dist=$row_trv['tr_dist_ss'];
}
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
			$html.= "Greet and meet on arrival at ".$row_trv['tr_from_cityid'].", proceed to hotel. Check in ( 12:00 noon - standard time) at hotel, refresh and later proceed to sight-seeing including - ";
			$hots_array=array();
			$vg=0;
			foreach($row_hot_main as $row_hot)
			{
				$hots_array[$vg]=$row_hot['spot_name'].' {'.$row_hot['spot_timings'].' }';
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
				'Greet and meet on arrival at '.$row_trv['tr_from_cityid'].' and proceed to hotel, check-in and overnight at '.$row_hotel2['hotel_name'];//have to show sight-seeing in next day
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
				$html.= 'Greet and meet on arrival at '.$row_trv['tr_from_cityid'].', proceed to sight-seeing including - ';
				$hots_array=array();
				$vg=0;
				foreach($row_hot_main as $row_hot)
				{
					$hots_array[$vg]=$row_hot['spot_name'].' {'.$row_hot['spot_timings'].' }';
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
							$hots_array[$vg]=$row_hot1['spot_name'].' {'.$row_hot1['spot_timings'].' }';
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
							$html.= 'If time permits proceed to sight-seeing including - ';
							$hots_array=array();
							
							$vg=0;
							foreach($row_hot_main as $row_hot)
							{
								$hots_array[$vg]=$row_hot['spot_name'].' {'.$row_hot['spot_timings'].' }';
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
							$hots_array[$vg]=$row_hot['spot_name'].' {'.$row_hot['spot_timings'].' }';
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
	if(!empty($dt_arr) && $chn != 0 && in_array($chn,$dt_cnt_arr))
								 {
									 if(isset($dt_arr[$row_trv['tr_from_cityid']][0]))
									 {
		$html.=  "<br><span style='font-weight:bold; color:green'>"."DAYTRIP applicable to ".$dt_arr[$row_trv['tr_from_cityid']][0]." (".$daytravel_dist." kms) : </span>";

$dayhpot= $conn->prepare("SELECT * FROM hotspots_pro where spot_city =? and status='0'");
$dayhpot->execute(array($dt_arr[$row_trv['tr_from_cityid']]['id']));
//$row_dayhpot = mysql_fetch_assoc($dayhpot);
$row_dayhpot_main=$dayhpot->fetchAll();
$totalRows_dayhpot = $dayhpot->rowCount();

foreach($row_dayhpot_main as $row_dayhpot)
{
		$html.=$row_dayhpot['spot_name'];
}
										 unset($dt_arr[$row_trv['tr_from_cityid']][0]);
										 $dt_arr[$row_trv['tr_from_cityid']] = array_values($dt_arr[$row_trv['tr_from_cityid']]);
									 }
									 
								 }else{
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
		$html.= ' proceed to sight-seeing including- ';
		$hots_array=array();
		$vg=0;
		foreach($row_hot_main as $row_hot)
		{
			$hots_array[$vg]=$row_hot['spot_name'].' {'.$row_hot['spot_timings'].' }';
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
				$hots_array[$vg]=$row_hot1['spot_name'].' {'.$row_hot1['spot_timings'].' }';
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
{if(isset($dt_arr[$row_trv['tr_from_cityid']][0]) && $chn!=0 && in_array($chn,$dt_cnt_arr)){
$distanc = $conn->prepare("SELECT * FROM dvi_citydist where (from_cityid =? and to_cityid =?) or (from_cityid =? and to_cityid =?)");
$distanc->execute(array($row_cityy1['id'],$dt_arr[$row_trv['tr_from_cityid']]['id'],$dt_arr[$row_trv['tr_from_cityid']]['id'],$row_cityy1['id']));
$row_distanc= $distanc->fetch(PDO::FETCH_ASSOC);					
$totalRows_distanc = $distanc->rowCount();	
 $daytravel_dist=$row_distanc['dist']*2;
$today_dist =$daytravel_dist;
$html.= " (".$today_dist." Kms)"; 
								 
									 }
									 else{
	$html.= " (".$row_distanc['dist']." Kms)";
}
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
	$html.= ", and proceed to sight-seeing including - ";
	$hots_array=array();
	$vg=0;
	foreach($row_hot_main as $row_hot)
	{
		$hots_array[$vg]=$row_hot['spot_name'].' {'.$row_hot['spot_timings'].' }';
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
}
else
{
	
	  $html.='<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>';
//my start


$trv_future = $conn->prepare("SELECT * FROM travel_sched where travel_id =?");
$trv_future->execute(array($_GET['planid']));
//$row_trv_future = mysql_fetch_assoc($trv_future);
$area_arr=array();
$gv=0;
$dt_cnt_arr=array();
while($row_trv_future = $trv_future->fetch(PDO::FETCH_ASSOC))
{
	$area_arr[$gv]=$row_trv_future['tr_from_cityid'];
	if($row_trv_future['tr_from_cityid']==$row_trv_future['tr_to_cityid']){
		$dt_cnt_arr[]=$gv;
	}
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
//$row_trv_main =$trv->fetchAll();
$totalRows_trv = $trv->rowCount();
$chn=0; 
$trv_cnt_1 = $totalRows_trv - 1;
if($totalRows_trv>0){	
$html.='<tr>
    <td colspan="3"><font style="font-weight: bold; color:#900; font-family:sans-serif; text-align: center; font-size: 16px">Itinerary Details:</font></td>
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
while($totalRows_trv>0){
$row_trv = $trv->fetch(PDO::FETCH_ASSOC);
if($trv_cnt_1>0)
{
	//for stay table - aft end day calculation

	$html.='<tr><td colspan="6"><table width="100%" border="0">
	
	<tr><td width="14%" rowspan="3" style="background-color:#E9E9E9"><p style="text-align:center; font-family:sans-serif; font-size: 12px;">';

$html.=date('d-M-Y D',strtotime(str_replace('-','/',$row_trv['tr_date'])));


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
if($chn==0){
$html.='Arrival - ';
}
$html.=$row_trv['tr_from_cityid'];
if($chn==0)
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
									
if($chn==0)
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
			$html.= "Greet and meet on arrival at ".$row_trv['tr_from_cityid'].", proceed to hotel. Check in ( 12:00 noon - standard time) at hotel, refresh and later proceed to sight-seeing including - ";
			$hots_array=array();
			$vg=0;
			foreach($row_hot_main as $row_hot)
			{
				$hots_array[$vg]=$row_hot['spot_name'].' {'.$row_hot['spot_timings'].' }';
				$vg++;
			}
			$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_from_cityid']]);
			
			for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<$tot_div_hot+$rem_area_cnt[$row_trv['tr_from_cityid']];$hs++)
			{
				$html.=$hots_array[$hs].',';
			}
										
			$rem_area_cnt[$row_trv['tr_from_cityid']]=$rem_area_cnt[$row_trv['tr_from_cityid']]+$tot_div_hot;
			$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-1;
			
			$html.= '. and later return to and overnight stay at hotel.';
			}
			else if($time3pm <= $arr_date_tstmp && $arr_date_tstmp <= $time6pm)
			{//between 6am to 3pm ( over night in same city)
				$html.= 'Greet and meet on arrival at '.$row_trv['tr_from_cityid'].' and proceed to hotel, check-in and overnight at hotel.';//have to show sight-seeing in next day
				$show_in_next_day=2;
				$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-2;
			}
			else if($time6pm <= $arr_date_tstmp && $arr_date_tstmp <= $arr_timenx6am)
			{//between 6am to 3pm ( over night in same city)
				$html.= 'Greet and meet on arrival at '.$row_trv['tr_from_cityid'].', proceed to hotel, check-in and overnight stay at hotel.';//have to show sight-seeing in next day
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
				$html.= 'Greet and meet on arrival at '.$row_trv['tr_from_cityid'].', proceed to sight-seeing including - ';
				$hots_array=array();
				$vg=0;
				foreach($row_hot_main as $row_hot)
				{
					$hots_array[$vg]=$row_hot['spot_name'].' {'.$row_hot['spot_timings'].' }';
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
							$hots_array[$vg]=$row_hot1['spot_name'].' {'.$row_hot1['spot_timings'].' }';
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
					
									
						$html.= 'and later drive to '.$row_trv['tr_to_cityid'].', check-in and overnight stay at hotel.';
					}
					else if($time3pm <= $arr_date_tstmp && $arr_date_tstmp <= $time6pm)
					{//between 3pm to 6pm ( over night in diff city)
						$html.= 'Greet and meet on arrival at '.$row_trv['tr_from_cityid'].'. ';
						
						if($totalRows_hot>0)
						{
							$html.= 'If time permits proceed to sight-seeing including - ';
							$hots_array=array();
							
							$vg=0;
							foreach($row_hot_main as $row_hot)
							{
								$hots_array[$vg]=$row_hot['spot_name'].' {'.$row_hot['spot_timings'].' }';
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
						$html.= ' later drive to '.$row_trv['tr_to_cityid'].', check-in and overnight stay at hotel.';
							
						}
						else if($time6pm <= $arr_date_tstmp && $arr_date_tstmp <= $arr_timenx6am)
						{
							//between 6am to 3pm ( over night in diff city)
							$html.= 'Greet and meet on arrival at '.$row_trv['tr_from_cityid'].' and proceed to '.$row_trv['tr_to_cityid'].', arrival and check-in and Overnight stay at hotel.';//skip sight-seeing and proceed to next day if
						
						//have to skip
						$hots_array=array();
						$vg=0;
						
						foreach($row_hot_main as $row_hot)
						{
							$hots_array[$vg]=$row_hot['spot_name'].' {'.$row_hot['spot_timings'].' }';
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
	if(!empty($dt_arr) && $chn != 0 && in_array($chn,$dt_cnt_arr))
								 {
									 if(isset($dt_arr[$row_trv['tr_from_cityid']][0]))
									 {
		$html.=  "<br><span style='font-weight:bold; color:green'>"."DAYTRIP applicable to ".$dt_arr[$row_trv['tr_from_cityid']][0]." (".$daytravel_dist." kms) : </span>";

$dayhpot= $conn->prepare("SELECT * FROM hotspots_pro where spot_city =? and status='0'");
$dayhpot->execute(array($dt_arr[$row_trv['tr_from_cityid']]['id']));
//$row_dayhpot = mysql_fetch_assoc($dayhpot);
$row_dayhpot_main=$dayhpot->fetchAll();
$totalRows_dayhpot = $dayhpot->rowCount();

foreach($row_dayhpot_main as $row_dayhpot)
{
		$html.=$row_dayhpot['spot_name'];
}
										 unset($dt_arr[$row_trv['tr_from_cityid']][0]);
										 $dt_arr[$row_trv['tr_from_cityid']] = array_values($dt_arr[$row_trv['tr_from_cityid']]);
									 }
									 
								 }else{
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
		$html.= ' proceed to sight-seeing including- ';
		$hots_array=array();
		$vg=0;
		foreach($row_hot_main as $row_hot)
		{
			$hots_array[$vg]=$row_hot['spot_name'].' {'.$row_hot['spot_timings'].' }';
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
				$hots_array[$vg]=$row_hot1['spot_name'].' {'.$row_hot1['spot_timings'].' }';
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
		$html.= 'and later return to hotel. Overnight stay at hotel.';
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
		$html.= 'and later proceed to '.$row_trv['tr_to_cityid'].'. Overnight stay at hotel. ';
	}
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
	$html.= ", and proceed to sight-seeing including - ";
	$hots_array=array();
	$vg=0;
	foreach($row_hot_main as $row_hot)
	{
		$hots_array[$vg]=$row_hot['spot_name'].' {'.$row_hot['spot_timings'].' }';
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

$trv_cnt_1--;
$totalRows_trv--;
$i++;

}

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
//$row_sspro1_main =$sspro1->fetchAll();
$totalRows_sspro1 = $sspro1->rowCount();

if($totalRows_sspro1>0)
{
while($row_sspro1 = $sspro1->fetch(PDO::FETCH_ASSOC))
{
  $html.='';
		
		$sp = $conn->prepare("SELECT * FROM stay_sched where stay_id =? and hotel_id=?  ORDER BY sno ASC ");
		$sp->execute(array($_GET['planid'],$row_sspro1['hotel_id']));
		$row_sp = $sp->fetch(PDO::FETCH_ASSOC);
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
		$html.='';
		
		$agent = $conn->prepare("SELECT * FROM agent_pro where agent_id =?");
$agent->execute(array($row_orders['agent_id']));
$row_agent = $agent->fetch(PDO::FETCH_ASSOC);
$totalRows_agent = $agent->rowCount();

		$html.= "";
		$html.='</td></tr></table></td></tr>';
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


if($str =='TH')
  {
  $html.='<table  border="none" ><tr ><hr>
    <td colspan="6" class="hide_border" >
	
   </td>
  </tr>
  <tr class="hide_border"> 
    <td class="hide_border" colspan="6">
	<td></tr>';
		$html.='
		
		<tr><td colspan="6" class="hide_border" style="text-align: left">
		<table width="100%"  border="0" style="font-family: sans-serif; margin-top:20px; text-align: left; font-size: 12px">
      <tr>
        <td class="hide_border" colspan="2"  height="20px;" style="text-align: left; font-weight: bold;">Package  Includes:</td>
        </tr>
      <tr >
        <td class="hide_border" height="1px" colspan="2">Transfers and sight-seeing  By  deluxe  tourists vehicle <span style="color:#F00">(Vehicles up hill driving on the hills would be on Non AC) </span></td>
        </tr>
      <tr>
        <td colspan="2" height="1px">Toll & Parking </td>
        </tr>
      <tr>
        <td colspan="2" height="1px">GST</td>
        </tr>
		
      <tr>
        <td colspan="2" height="1px">All local sight-seeing in the same vehicle, every day after breakfast till sunset.<br><br></td>
        </tr>
      <tr>
        <td class="hide_border" height="1px" colspan="2"><span style="color:#F00">If staying in the House boat </span></td>
      </tr>
      <tr>
        <td colspan="2" height="1px">House Boat with all Meals and Ac In the house boat operates from 09 PM to 06 Am only.<br><br></td>
      </tr>
      <tr>
        <td class="hide_border" height="1px" colspan="2"><span style="color:#F00">If the booking includes the extra bed it is facilitated with a folding cot or a mattress as an extra bed, as per the hotel policy. <br><br></span><br><br></td>
      </tr>
      
      <tr>
        <td colspan="2" height="1px"><b>Package does not include:</b><br><br></td>
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
        <td colspan="2" height="1px">Monument / TEMPLE Entrance Fees / Boat ride</td>
      </tr>
	  <tr>
        <td colspan="2" height="1px">Any Porterage services at Airport / Railway station</td>
      </tr>
	  <tr>
        <td colspan="2" height="1px">Any other expenses not mentioned in the above cost.</td>
      </tr>
	  <tr>
        <td class="hide_border" height="1px" colspan="2"><span style="color:#F00">24th December gala dinner</span></td>
      </tr>
	  <tr>
        <td class="hide_border" height="1px" colspan="2"><span style="color:#F00">31st December gala dinner</span><br><br></td>
      </tr>
	  
	  <tr>
        <td class="hide_border" height="1px" colspan="2"><span style="color:#F00">Cancellation policy </span><br></td>
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
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr></table>';
  }else if($str == 'T')
  {
	$html.='<table border="none" ><tr ><hr>
    <td colspan="6" class="hide_border" >
	
   </td>
  </tr>
  <tr class="hide_border"> 
    <td class="hide_border" colspan="6">
	<td></tr>';
		$html.='
		
		<tr><td colspan="6" class="hide_border" style="text-align: left">
		<b><span style="color:#F00">Terms & Conditions </span></b><br>
                                    Transfers and sight-seeing  by  deluxe  tourists vehicle  <span style="color:#F00">(Vehicles up hill driving on the hills would be on Non AC) </span> <br>
                                    Toll & Parking <br>
                                    GST <br>
                                    All local sight-seeing in the same vehicle, every day after breakfast till sunset ( 0700 AM to 08PM)<br><br>';
                                    
                                    
	  
  }
	  $html.='</td></tr></table>
	 

</body>
</html>';
//echo $html;die;
$dompdf = new DOMPDF();
$dompdf->load_html($html);
  //$paper_size = array(0,0,612.00,792.00);
$dompdf->set_paper('A4','portrait');
$dompdf->render();
$dompdf->stream("dis.pdf", array("Attachment" => false));

//$pdf = $dompdf->output();
?>
