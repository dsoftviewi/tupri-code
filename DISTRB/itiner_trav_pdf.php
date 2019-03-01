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
  if($str =='T' || $str =='TH')
  {
	  
	  $spro = $conn->prepare("SELECT * FROM stay_sched where stay_id =? ORDER BY sno ASC ");
$spro->execute(array($_GET['planid']));
//$row_spro = mysql_fetch_assoc($spro);
$row_spro=$spro->fetch(PDO::FETCH_ASSOC);
$totalRows_spro = $spro->rowCount();
	  $scnt=1;	
	  
  $html.='<td colspan="6"><table width="100%" border="0">
      <tr >
        <td colspan="3"><font style="font-weight: bold; color:#900; font-family:sans-serif; text-align: center; font-size: 16px">Travel Details:</font></td>
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
  ';
	
	  $html.='';
  }
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
$totaltrv_future =$trv_future->rowCount();
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
$trv_cnt_1 = $totalRows_trv - 1;
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
					
									
						$html.= 'and later drive to '.$row_trv['tr_to_cityid'].', check-in and overnight stay at hotel.';
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

$trv_cnt_1--;
$totalRows_trv--;

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
        <td  colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Vehicle provided :<br><br><br><br><br></td>
      </tr>
      <tr>
        <td  colspan="2">2) Is the vehicle is on Time at the airport on your arrival?</td>
      </tr>
      <tr>
        <td  colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Vehicle Provided :<br><br><br><br><br> </td>
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
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr></table><td></tr>';

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
        <td class="hide_border" colspan="2"  height="20px;" style="text-align: left; font-weight: bold;"><span style="color:#F00">Terms & Conditions:</span></td>
        </tr>
      <tr >
        <td class="hide_border" height="1px" colspan="2">Transfers and sightseeing  By  deluxe  tourists vehicle <span style="color:#F00">(Vehicles up hill driving on the hills would be on Non AC) </span></td>
        </tr>
      <tr>
        <td colspan="2" height="1px">Toll & Parking </td>
        </tr>
      <tr>
        <td colspan="2" height="1px">Service Taxes</td>
        </tr>
		
      <tr>
        <td colspan="2" height="1px">All local sightseeing in the same vehicle, every day after breakfast till sunset.<br><br></td>
        </tr>
	  <tr>
        <td colspan="2" height="1px"> <strong>IMPORTANT:</strong> Kindly note that  vehicles  mentioned above only indicate that our rates have been based on usage of the locations and Kilometres  and it is not to be construed that the same vehicles will be provided if the vehicles are not available in the selected locations we shall provide from the different neareast availble location for the same rate may change (supplement/reduction whatever applicable). Unless until we  Dvi Holidays sends you the written confirmation from reservation the quote is not final. <br><br></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr></table></td></tr></table></body></html>';

//echo $html;
$fromnam=$row_orders['plan_id'].'.pdf';
$dompdf = new DOMPDF();
$dompdf->load_html($html);
  //$paper_size = array(0,0,612.00,792.00);
$dompdf->set_paper('A4','portrait');
$dompdf->render();
$dompdf->stream($fromnam, array("Attachment" => false));

//$pdf = $dompdf->output();
?>
