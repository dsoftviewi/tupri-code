<?php 
ini_set('max_execution_time', 300);
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

if($slen<=10){
	$fsize='105px';
}
else if($slen<=15)
{
	$fsize='75px';
}else if($slen<25)
{
	$fsize='65px';
}else if($slen<35)
{
	$fsize='55px';
}else{
	$fsize='26px';
}


$html='<html xmlns="http://www.w3.org/1999/xhtml">

<body style="margin-top:105px; margin-bottom:5px; font-family:;">
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
</style>';
 
                      //breakup start 

$breakup = $conn->prepare("SELECT * FROM travel_master where plan_id =?");
$breakup->execute(array($_GET['planid']));
$row_breakup = $breakup->fetch(PDO::FETCH_ASSOC);
$totalRows_breakup = $breakup->rowCount();
 $customer_name=$row_orders['tr_name'];
$break_arr=array();
//echo "Breakup =".$row_breakup['sub_paln_id'];
if(trim($row_breakup['sub_paln_id'])!='')//not empty
{
	$row_breakup['sub_paln_id'];
	$break_arr=explode('-',$row_breakup['sub_paln_id']);
}
//print_r($break_arr);
//breakup end 

						//main break stay for
$break_chk=0;
foreach($break_arr as $breakup)
{
	$_GET['planid']=$breakup;
	
	
	$orders = $conn->prepare("SELECT * FROM travel_master where plan_id =?");
	$orders->execute(array($_GET['planid']));
	$row_orders = $orders->fetch(PDO::FETCH_ASSOC);
	$totalRows_orders = $orders->rowCount();
     
	$idd=explode('#',$_GET['planid']);
	$str=$idd[0];  
 
$html.='<table width="100%" border="0" >';
  if($break_chk==0)
 {
	
  $html.='<tr>
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
    <td colspan="6" style="font-weight: bold; font-family:; text-align: center; font-size: 62px">Welcomes</td>
  </tr>
  <tr>
    <td colspan="6" style="text-align: center; font-family:; font-weight: bold; font-size: '.$fsize.';">'.$row_orders['tr_name'].'</td>
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
    <td><font style="font-weight: bold; font-family:; text-align: center; font-size: 14px">Arrival flight/Train Details</font></td>
    <td><strong>:</strong></td>
    <td width="22%"><font style="font-weight: bold; font-family:; text-align: center; font-size: 14px">'.$row_orders['tr_arrdet'].'</font></td>
    <td width="16%"><font style="font-weight:  font-family:; text-align: center; font-size: 14px">Guest Mobile No</font></td>
    <td width="1%"><strong>:  </strong></td>
    <td width="30%"><font style="font-weight: bold; font-family:; text-align: center; font-size: 14px">'.$row_orders['tr_mobile'].'</font></td>
  </tr>
  <tr>
    <td><font style="font-weight: bold; text-align: center; font-family:; font-size: 14px">Departure flight/ Train Details  </font></td>
    <td><strong>:</strong></td>
    <td><font style="font-weight: bold; text-align: center; font-family:; font-size: 14px">'.$row_orders['tr_depdet'].'</font></td>
	<td colspan="3"></td>
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
  </tr>';
  
 }
 
  if($str =='T' || $str =='TH')
  {
	  
	 $spro = $conn->prepare("SELECT * FROM stay_sched where stay_id =? ORDER BY sno ASC ");
$spro->execute(array($_GET['planid']));
//$row_spro = mysql_fetch_assoc($spro);
$row_spro=$spro->fetch(PDO::FETCH_ASSOC);
$totalRows_spro = $spro->rowCount();
	  $scnt=1;	
	  
  $html.=' <tr><td colspan="6"><table width="100%" border="0">
      <tr >
        <td colspan="3">';
		if($break_chk>0)
		{
		$html.='<center><strong style="color:#C58207">Your Itinerary will bypassing to following places</strong></center>';
		}
		 $break_chk++;
		$html.='<font style="font-weight: bold; color:#900; font-family:; text-align: center; font-size: 16px">Travel Details:</font></td>
        </tr>
      <tr>
        <td colspan="3">&nbsp;</td>
      </tr>
      <tr >
        <td width="20%"><font style="font-weight: bold; font-family:; text-align: center; font-size: 14px">Guest Name</font></td>
        <td width="1%">:</td>
        <td width="79%"><font style="font-weight: bold; font-family:; text-align: center; font-size: 14px"> '.$row_orders['tr_name'].'</font></td>
      </tr>
      <tr>
        <td><font style="font-weight: bold; font-family:; text-align: center; font-size: 14px">Occupancy</font></td>
        <td>:</td>
        <td><font style="font-weight: bold; font-family:; text-align: center; font-size: 14px">'.$row_orders['pax_cnt'].'</font></td>
      </tr>
      <tr>
        <td><font style="font-weight: bold; font-family:; text-align: center; font-size: 14px">Total Traveling days</font></td>
        <td>:</td>
        <td><font style="font-weight: bold; font-family:; text-align: center; font-size: 14px">'.$row_orders['tr_days'].'</font></td>
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
$dt_cnt_arr=array();
foreach($row_trv_future_main as $row_trv_future)
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
$totaltrv_future =$trv_future->rowCount();
//daytrip here

$dtrip = $conn->prepare("SELECT * FROM travel_daytrip where travel_id =? ORDER BY sno ASC");
$dtrip->execute(array($_GET['planid']));
$row_dtrip_main =$dtrip->fetchAll();
$totalRows_dtrip = $dtrip->rowCount();;

$dt_arr = array(); 
$dt_cnt = 0;

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
		
		$dt_arr[$row_dtcity1['name']][0] = $row_dtcity2['name'];
    $dt_arr[$row_dtcity1['name']]['id'] = $row_dtcity2['id'];
	}
	
}
//daytrip end
//my end
			
$hots_desc_arr=array();					            

$trv = $conn->prepare("SELECT * FROM travel_sched where travel_id =? ORDER BY sno ASC");
$trv->execute(array($_GET['planid']));
//$row_trv = mysql_fetch_assoc($trv);
$row_trv_main =$trv->fetchAll();
$totalRows_trv = $trv->rowCount();
$chn=0; 
$trv_cnt_1 = $totalRows_trv - 1;
if($totalRows_trv>0){	
$html.='<tr>
    <td><font style="font-weight: bold; color:#900; font-family:; text-align: center; font-size: 16px">Itinerary Details:</font></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><font style="font-weight: bold; color:blue; font-family:; text-align: center; font-size: 13px">Specially prepared for '.$row_orders['tr_name'].' </font></td>
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
foreach($row_trv_main as $row_trv)
{
if($trv_cnt_1>0)
{
	//for stay table - aft end day calculation

	$html.='<tr><td colspan="6"><table width="100%" border="0">
	
	<tr><td width="14%" rowspan="2" style="background-color:#F5F5F5"><p style="text-align:center; font-family:; font-size: 14px;">';

$html.=date('d-M-Y D',strtotime(str_replace('-','/',$row_trv['tr_date']))).' &nbsp;';
$desc_date=date('d-M-Y D',strtotime(str_replace('-','/',$row_trv['tr_date'])));


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


$hots_desc_arr[$desc_date]['fcid']=$row_cityy1['id'];
$hots_desc_arr[$desc_date]['tcid']=$row_cityy_to['id'];
$hots_desc_arr[$desc_date]['via']=$row_trv['via_cities'];
$hots_desc_arr[$desc_date]['spot_id']='-';

$html.='</p></td>
<td style="background-color:#E2E2E2"><font style="font-weight: bold; font-family:; text-align: center; font-size: 14px">';
if($chn==0){
$html.='Arrival - ';
}
$html.=$row_trv['tr_from_cityid'];
if($chn==0)
{
	$html.=" [ ".$row_orders['tr_arrdet']." @".$row_orders['tr_arr_time']." ]";
}

//travel via start
										if(trim($row_trv['via_cities'])!='')
										{
									$via_cities_arr=explode('-',$row_trv['via_cities']);
									for($ci=0;$ci<count($via_cities_arr);$ci++)
									{
										if($ci != 0 && ($ci != count($via_cities_arr)-1))
										{
											if(trim($via_cities_arr[$ci])!='-')
											{
												$via_cty = $conn->prepare("SELECT * FROM dvi_cities where id=?");
$via_cty->execute(array($via_cities_arr[$ci]));
$row_via_cty= $via_cty->fetch(PDO::FETCH_ASSOC);
$totalRows_via_cty = $via_cty->rowCount();	
												$html.="&nbsp;&nbsp;-&nbsp;&nbsp;".$row_via_cty['name'];
											}
										}
									}
										}//no empty via
									//via edit end

$html.=" - ".$row_trv['tr_to_cityid'];
if($row_trv['tr_dist_ss']>0)
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
	$today_dist=$row_trv['ss_dist'];
}
$html.='</td>
      </tr>
     
      <tr>
        <td style="background-color:#F5F5F5"><p style="text-align:justify; font-family:;color:#2D2A2A; font-size: 14px">';
									
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
			$hots_with_id=array();
			$vg=0;
			foreach($row_hot_main as $row_hot)
			{
				$hots_array[$vg]=$row_hot['spot_name'];
				$hots_with_id[$vg]=$row_hot['hotspot_id'];
				$vg++;
			}
			$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_from_cityid']]);
			
			$hot_with_sep='';
			for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<$tot_div_hot+$rem_area_cnt[$row_trv['tr_from_cityid']];$hs++)
			{
				$html.=$hots_array[$hs].', ';
					if($hot_with_sep!='')
					{
						$hot_with_sep=$hot_with_sep.','.$hots_with_id[$hs];
					}else{
						$hot_with_sep=$hots_with_id[$hs];
					}
			}
										
			$rem_area_cnt[$row_trv['tr_from_cityid']]=$rem_area_cnt[$row_trv['tr_from_cityid']]+$tot_div_hot;
			$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-1;
			$hots_desc_arr[$desc_date]['spot_id']=$hot_with_sep;
			
			//via edit start
			$spot_ids='-';
										if(trim($row_trv['via_cities'])!='')
										{
									$via_cities_arr=explode('-',$row_trv['via_cities']);
									for($ci=0;$ci<count($via_cities_arr);$ci++)
									{
										if($ci != 0 && ($ci != count($via_cities_arr)-1))
										{
											if(trim($via_cities_arr[$ci])!='-')
											{
												if($today_dist>=250)//if total dist >250 means show hotspots prior 1 and 2 only
												{
$via_hspots = $conn->prepare("SELECT * FROM hotspots_pro where spot_city=? and (spot_prior='1' || spot_prior='2')");
												}else{//if total dist <250 means show hotspots prior 1,2,3 & 4 only
$via_hspots = $conn->prepare("SELECT * FROM hotspots_pro where spot_city=? and (spot_prior='1' || spot_prior='2' || spot_prior='3' || spot_prior='4')");
												}
$via_hspots->execute(array($via_cities_arr[$ci]));
//$row_via_hspots= mysql_fetch_assoc($via_hspots);
$row_via_hspots_main=$via_hspots->fetchAll();
$totalRows_via_hspots =$via_hspots->rowCount();	

												if($totalRows_via_hspots>0)
												{
													foreach($row_via_hspots_main as $row_via_hspots)
													{
														$html.=$row_via_hspots['spot_name'];
														if($spot_ids!='-')
														{
															$spot_ids=$spot_ids.",".$row_via_hspots['hotspot_id'];
														}else{
															$spot_ids=$row_via_hspots['hotspot_id'];
														}
													}
												$hots_desc_arr[$desc_date]['spot_id']=$hots_desc_arr[$desc_date]['spot_id'].','.$spot_ids;
												}
											}
										}
									}
										}
									//via edit end
			
			$html.= '. and later return to and overnight stay at hotel.';
			}
			else if($time3pm <= $arr_date_tstmp && $arr_date_tstmp <= $time6pm)
			{//between 6am to 3pm ( over night in same city)
				$html.= 'Greet and meet on arrival at '.$row_trv['tr_from_cityid'].' and proceed to hotel, check-in and overnight at hotel.';//have to show sight-seeing in next day
				$show_in_next_day=2;
				$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-2;
				$hots_desc_arr[$desc_date]['spot_id']='-';
			}
			else if($time6pm <= $arr_date_tstmp && $arr_date_tstmp <= $arr_timenx6am)
			{//between 6am to 3pm ( over night in same city)
				$html.= 'Greet and meet on arrival at '.$row_trv['tr_from_cityid'].', proceed to hotel, check-in and overnight stay at hotel.';//have to show sight-seeing in next day
				$show_in_next_day=2;
				$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-2;
				$hots_desc_arr[$desc_date]['spot_id']='-';
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
				$hots_with_id=array();
				$vg=0;
				foreach($row_hot_main as $row_hot)
				{
					$hots_array[$vg]=$row_hot['spot_name'];
					$hots_with_id[$vg]=$row_hot['hotspot_id'];
					$vg++;
				}
				$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_from_cityid']]);
				
				$hot_with_sep='';
				for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<$tot_div_hot+$rem_area_cnt[$row_trv['tr_from_cityid']];$hs++)
				{
					$html.=$hots_array[$hs].',';
							if($hot_with_sep!='')
							{
								$hot_with_sep=$hot_with_sep.','.$hots_with_id[$hs];
							}else{
								$hot_with_sep=$hots_with_id[$hs];
							}
				}
				
				$rem_area_cnt[$row_trv['tr_from_cityid']]=$rem_area_cnt[$row_trv['tr_from_cityid']]+$tot_div_hot;
				$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-1;
				$hots_desc_arr[$desc_date]['spot_id']=$hot_with_sep;
				
				//via edit start
				$spot_ids='-';
										if(trim($row_trv['via_cities'])!='')
										{
									$via_cities_arr=explode('-',$row_trv['via_cities']);
									for($ci=0;$ci<count($via_cities_arr);$ci++)
									{
										if($ci != 0 && ($ci != count($via_cities_arr)-1))
										{
											if(trim($via_cities_arr[$ci])!='-')
											{
												if($today_dist>=250)//if total dist >250 means show hotspots prior 1 and 2 only
												{
$via_hspots = $conn->prepare("SELECT * FROM hotspots_pro where spot_city=? and (spot_prior='1' || spot_prior='2')");
												}else{//if total dist <250 means show hotspots prior 1,2,3 & 4 only
$via_hspots = $conn->prepare("SELECT * FROM hotspots_pro where spot_city=? and (spot_prior='1' || spot_prior='2' || spot_prior='3' || spot_prior='4')");
												}
$via_hspots->execute(array($via_cities_arr[$ci]));
//$row_via_hspots= mysql_fetch_assoc($via_hspots);
$row_via_hspots_main=$via_hspots->fetchAll();
$totalRows_via_hspots =$via_hspots->rowCount();	

												if($totalRows_via_hspots>0)
												{
													foreach($row_via_hspots_main as $row_via_hspots)
													{
														$html.=$row_via_hspots['spot_name'];
														
														if($spot_ids!='-')
														{
															$spot_ids=$spot_ids.",".$row_via_hspots['hotspot_id'];
														}else{
															$spot_ids=$row_via_hspots['hotspot_id'];
														}
													}
													$hots_desc_arr[$desc_date]['spot_id']=$hots_desc_arr[$desc_date]['spot_id'].','.$hot_with_sep;
												}
											}
										}
									}
										}
									//via edit end

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
						$hots_with_id=array();
						$vg=0;
						foreach($row_hot1_main as $row_hot1)
						{
							$hots_array[$vg]=$row_hot1['spot_name'];
							$hots_with_id[$vg]=$row_hot1['hotspot_id'];
							$vg++;
						} 
								
						$area_cnt[$row_trv['tr_to_cityid']]=$area_cnt[$row_trv['tr_to_cityid']]+1;
						$copy_area_arr[$row_trv['tr_to_cityid']]=$copy_area_arr[$row_trv['tr_to_cityid']]+1;
						
						
						$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_to_cityid']]);	
						
						$hot_with_sep='';
						for($hs1=$rem_area_cnt[$row_trv['tr_to_cityid']];$hs1<$tot_div_hot+$rem_area_cnt[$row_trv['tr_to_cityid']];$hs1++)
						{
							$html.= $hots_array[$hs1].', ';
													if($hot_with_sep!='')
													{
														$hot_with_sep=$hot_with_sep.','.$hots_with_id[$hs1];
													}else{
														$hot_with_sep=$hots_with_id[$hs1];
													}
							
						}
						$hots_desc_arr[$desc_date]['spot_id']=$hots_desc_arr[$desc_date]['spot_id'].','.$hot_with_sep;
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
							$hots_with_id=array();
							$vg=0;
							foreach($row_hot_main as $row_hot)
							{
								$hots_array[$vg]=$row_hot['spot_name'];
								$hots_with_id[$vg]=$row_hot['hotspot_id'];
								$vg++;
							}
							
							$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_from_cityid']]);
							
							$hot_with_sep='';
							for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<$tot_div_hot+$rem_area_cnt[$row_trv['tr_from_cityid']];$hs++)
							{
								$html.= $hots_array[$hs].',';
									if($hot_with_sep!='')
									{
										$hot_with_sep=$hot_with_sep.','.$hots_with_id[$hs];
									}else{
										$hot_with_sep=$hots_with_id[$hs];
									}
								
							}
							$rem_area_cnt[$row_trv['tr_from_cityid']]=$rem_area_cnt[$row_trv['tr_from_cityid']]+$tot_div_hot;
							$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-1;
							$hots_desc_arr[$desc_date]['spot_id']=$hot_with_sep;
							//via edit start
							$spot_ids='-';
										if(trim($row_trv['via_cities'])!='')
										{
									$via_cities_arr=explode('-',$row_trv['via_cities']);
									for($ci=0;$ci<count($via_cities_arr);$ci++)
									{
										if($ci != 0 && ($ci != count($via_cities_arr)-1))
										{
											if(trim($via_cities_arr[$ci])!='-')
											{
												if($today_dist>=250)//if total dist >250 means show hotspots prior 1 and 2 only
												{
$via_hspots = $conn->prepare("SELECT * FROM hotspots_pro where spot_city=? and (spot_prior='1' || spot_prior='2')");
												}else{//if total dist <250 means show hotspots prior 1,2,3 & 4 only
$via_hspots = $conn->prepare("SELECT * FROM hotspots_pro where spot_city=? and (spot_prior='1' || spot_prior='2' || spot_prior='3' || spot_prior='4')");
												}
$via_hspots->execute(array($via_cities_arr[$ci]));
//$row_via_hspots= mysql_fetch_assoc($via_hspots);
$row_via_hspots_main=$via_hspots->fetchAll();
$totalRows_via_hspots =$via_hspots->rowCount();	

												if($totalRows_via_hspots>0)
												{
													foreach($row_via_hspots_main as $row_via_hspots)
													{
														$html.=$row_via_hspots['spot_name'];
																	if($spot_ids!='-')
																	{
																		$spot_ids=$spot_ids.",".$row_via_hspots['hotspot_id'];
																	}else{
																		$spot_ids=$row_via_hspots['hotspot_id'];
																	}
														
													}
													$hots_desc_arr[$desc_date]['spot_id']=$hots_desc_arr[$desc_date]['spot_id'].','.$spot_ids;
												}
											}
										}
									}
										}
									//via edit end
							
							$html.='and ';
						}//more hot spot
						$html.= ' later drive to '.$row_trv['tr_to_cityid'].', check-in and overnight stay at hotel.';
							
						}
						else if($time6pm <= $arr_date_tstmp && $arr_date_tstmp <= $arr_timenx6am)
						{
							//between 6am to 3pm ( over night in diff city)
							$html.= 'Greet and meet on arrival at '.$row_trv['tr_from_cityid'].' and proceed to '.$row_trv['tr_to_cityid'].', arrival and check-in and Overnight stay at hotel.';//skip sight-seeing and proceed to next day if
						
						//have to skip
						$hots_array=array();
						$hots_with_id=array();
						$vg=0;
						
						foreach($row_hot_main as $row_hot)
						{
							$hots_array[$vg]=$row_hot['spot_name'];
							$hots_with_id[$vg]=$row_hot['hotspot_id'];
							$vg++;
						}
						
						$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_from_cityid']]);
						//skip hot spot
						$rem_area_cnt[$row_trv['tr_from_cityid']]=$rem_area_cnt[$row_trv['tr_from_cityid']]+$tot_div_hot;
						$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-1;
						$hots_desc_arr[$desc_date]['spot_id']='-';
						
						}
				}
				
				//additional cost - addons
										if(trim($row_trv['addi_cost_for'])!='')
										{
											$addi_cost_name=explode('/',$row_trv['addi_cost_for']);
                                    $html.='<div class="col-sm-12" style="color: #383634; margin-top:10px; border: 1px dashed #5F83DE; padding:3px; " >
                                        <strong style="color:#AB5B14; font-family:; font-size: 14px" >* Special Add-ons to this date: </strong>
                                        <small style="color:#900; font-weight:600; font-family:; font-size: 13px">( Additional cost added for this add-ons )</small>
                                        <ul style=" list-style-type:circle; ">';
                                        foreach($addi_cost_name as $acnam)
										{ 
                                        $html.='<li style="font-weight:500; color:#383634; font-family:; font-size: 14px">'.$acnam.'</li>';
                                       }
                                       $html.=' </ul>
                                        </div>';
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
		$hots_with_id=array();
		$vg=0;
		foreach($row_hot_main as $row_hot)
		{
			$hots_array[$vg]=$row_hot['spot_name'];
			$hots_with_id[$vg]=$row_hot['hotspot_id'];
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
		
		$hot_with_sep='';
		for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<$tot_div_hot+$rem_area_cnt[$row_trv['tr_from_cityid']];$hs++)
		{
			if(isset($hots_array[$hs]))
			{
				$html.= $hots_array[$hs].', ';
					if($hot_with_sep!='')
					{
						$hot_with_sep=$hot_with_sep.','.$hots_with_id[$hs];
					}else{
						$hot_with_sep=$hots_with_id[$hs];
					}
			}
		}
		$rem_area_cnt[$row_trv['tr_from_cityid']]=$rem_area_cnt[$row_trv['tr_from_cityid']]+$tot_div_hot;
		$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-1;
		$hots_desc_arr[$desc_date]['spot_id']=$hot_with_sep;
		//via edit start
		$spot_ids='-';
										if(trim($row_trv['via_cities'])!='')
										{
									$via_cities_arr=explode('-',$row_trv['via_cities']);
									for($ci=0;$ci<count($via_cities_arr);$ci++)
									{
										if($ci != 0 && ($ci != count($via_cities_arr)-1))
										{
											if(trim($via_cities_arr[$ci])!='-')
											{
												if($today_dist>=250)//if total dist >250 means show hotspots prior 1 and 2 only
												{
$via_hspots = $conn->prepare("SELECT * FROM hotspots_pro where spot_city=? and (spot_prior='1' || spot_prior='2')");
												}else{//if total dist <250 means show hotspots prior 1,2,3 & 4 only
$via_hspots = $conn->prepare("SELECT * FROM hotspots_pro where spot_city=? and (spot_prior='1' || spot_prior='2' || spot_prior='3' || spot_prior='4')");
												}
$via_hspots->execute(array($via_cities_arr[$ci]));
//$row_via_hspots= mysql_fetch_assoc($via_hspots);
$row_via_hspots_main=$via_hspots->fetchAll();
$totalRows_via_hspots =$via_hspots->rowCount();	

												if($totalRows_via_hspots>0)
												{
													foreach($row_via_hspots_main as $row_via_hspots)
													{
														$html.=$row_via_hspots['spot_name'];
														
														if($spot_ids!='-')
														{
															$spot_ids=$spot_ids.",".$row_via_hspots['hotspot_id'];
														}else{
															$spot_ids=$row_via_hspots['hotspot_id'];
														}
													}
													$hots_desc_arr[$desc_date]['spot_id']=$hots_desc_arr[$desc_date]['spot_id'].','.$spot_ids;
												}
											}
										}
									}
										}
									//via edit end
					
							//for ending city hotspot if ending in different city
		if(($row_trv['tr_from_cityid'] != $row_trv['tr_to_cityid']) && $row_distanc['dist']<=180)
		{
			
			$hot1= $conn->prepare("SELECT * FROM hotspots_pro where spot_city =?");
$hot1->execute(array($row_cityy_to['id']));
//$row_hot1 = mysql_fetch_assoc($hot1);
$row_hot1_main=$hot1->fetchAll();
$totalRows_hot1 = $hot1->rowCount();
			
			$hots_array=array();
			$hots_with_id=array();
			$vg=0;
			foreach($row_hot1_main as $row_hot1)
			{
				$hots_array[$vg]=$row_hot1['spot_name'];
				$hots_with_id[$vg]=$row_hot1['hotspot_id'];
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
				
				$hot_with_sep='';						
			for($hs1=$rem_area_cnt[$row_trv['tr_to_cityid']];$hs1<$tot_div_hot+$rem_area_cnt[$row_trv['tr_to_cityid']];$hs1++)
			{
				$html.= $hots_array[$hs1].', ';
				
					if($hot_with_sep!='')
					{
						$hot_with_sep=$hot_with_sep.','.$hots_with_id[$hs1];
					}else{
						$hot_with_sep=$hots_with_id[$hs1];
					}
			}
			
			$rem_area_cnt[$row_trv['tr_to_cityid']]=$rem_area_cnt[$row_trv['tr_to_cityid']]+$tot_div_hot;
			$copy_area_arr[$row_trv['tr_to_cityid']]=$copy_area_arr[$row_trv['tr_to_cityid']]-1;
			$hots_desc_arr[$desc_date]['spot_id']=$hots_desc_arr[$desc_date]['spot_id'].','.$hot_with_sep;
		}
							
							//calculation for last day previouslly
		$dept_date_time1=$row_trv['tr_date'].' '.$row_orders['trv_depatr_time'];
		$dept_date_tstmp1=date('U',strtotime($dept_date_time1));
		$dept_time4pm1=date('U',strtotime($row_trv['tr_date'].' 04:00 PM'));//for next day morning - arrival
		
		if(($totalRows_trv ==2 && $dept_date_tstmp1<$dept_time4pm1))
		{
			$hot_with_sep='';
			for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<count($hots_array);$hs++)
			{
				$html.= $hots_array[$hs].', ';//for final day
				
				if($hot_with_sep!='')
				{
					$hot_with_sep=$hot_with_sep.','.$hots_with_id[$hs];
				}else{
					$hot_with_sep=$hots_with_id[$hs];
				}
			}
			$hots_desc_arr[$desc_date]['spot_id']=$hots_desc_arr[$desc_date]['spot_id'].','.$hot_with_sep;
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
				$html.= "<br><br><span style='font-weight:bold; color:green'>"."DAYTRIP applicable to ".$dt_arr[$row_trv['tr_from_cityid']][0]." : </span>";

                       
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
		}
	}
	else
	{
		$html.= 'and later proceed to '.$row_trv['tr_to_cityid'].'. Overnight stay at hotel. ';
	}
								 }
	
	//additional cost - addons
										if(trim($row_trv['addi_cost_for'])!='')
										{
											$addi_cost_name=explode('/',$row_trv['addi_cost_for']);
                                    $html.='<div class="col-sm-12" style="color: #383634; margin-top:10px; border: 1px dashed #5F83DE; padding:3px; " >
                                        <strong style="color:#AB5B14; font-family:; font-size: 14px" >* Special Add-ons to this date: </strong>
                                        <small style="color:#900; font-weight:600; font-family:; font-size: 13px">( Additional cost added for this add-ons )</small>
                                        <ul style=" list-style-type:circle; ">';
                                        foreach($addi_cost_name as $acnam)
										{ 
                                        $html.='<li style="font-weight:500; color:#383634; font-family:; font-size: 14px">'.$acnam.'</li>';
                                       }
                                       $html.=' </ul>
                                        </div>';
                                       } 
}

$html.='</p></td>
</tr>
<tr><td style="color:#FFF;">--</td><td style="color:#FFF;">---</td></tr>
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
        <td width="14%" rowspan="2" style="background-color:#F5F5F5"><p style="text-align:center; font-family:; font-size: 14px;">';
	if($row_trv['tr_date'] != '')
	{
		$html.= date('d-M-Y D',strtotime(str_replace('-','/',$row_trv['tr_date']))).' &nbsp;';
		$desc_date=date('d-M-Y D',strtotime(str_replace('-','/',$row_trv['tr_date'])));
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


$hot= $conn->prepare("SELECT * FROM hotspots_pro where spot_city =?");
$hot->execute(array($row_cityy1['id']));
//$row_hot = mysql_fetch_assoc($hot);
$row_hot_main=$hot->fetchAll();
$totalRows_hot = $hot->rowCount();


$hots_desc_arr[$desc_date]['fcid']=$row_cityy1['id'];
$hots_desc_arr[$desc_date]['tcid']=$row_cityy_to['id'];
$hots_desc_arr[$desc_date]['via']=$row_trv['via_cities'];
$hots_desc_arr[$desc_date]['spot_id']='-';
		$html.='</p></td>
<td style="background-color:#E2E2E2"><font style="font-weight: bold; font-family:; text-align: center; font-size: 14px">';
$html.= $row_trv['tr_from_cityid'];

//travel via start
										if(trim($row_trv['via_cities'])!='')
										{
									$via_cities_arr=explode('-',$row_trv['via_cities']);
									for($ci=0;$ci<count($via_cities_arr);$ci++)
									{
										if($ci != 0 && ($ci != count($via_cities_arr)-1))
										{
											if(trim($via_cities_arr[$ci])!='-')
											{
												$via_cty = $conn->prepare("SELECT * FROM dvi_cities where id=?");
$via_cty->execute(array($via_cities_arr[$ci]));
$row_via_cty= $via_cty->fetch(PDO::FETCH_ASSOC);
$totalRows_via_cty = $via_cty->rowCount();	
												$html.="&nbsp;&nbsp;-&nbsp;&nbsp;".$row_via_cty['name'];
											}
										}
									}
										}//no empty via
									//via edit end

$html.="&nbsp;&nbsp;-&nbsp;&nbsp;".$row_trv['tr_to_cityid']."&nbsp;( Departure )  [ ".$row_orders['tr_depdet']."&nbsp; @".$row_orders['trv_depatr_time']." ]";

if($row_trv['tr_dist_ss']>0)
{
	$html.= " (".$row_trv['tr_dist_ss']." Kms)";
	$today_dist=$row_trv['tr_dist_ss'];
}
else
{
	$ss_dist = $conn->prepare("SELECT * FROM dvi_cities where id=?");
$ss_dist->execute(array($row_cityy_to['id']));
$row_ss_dist= $ss_dist->fetch(PDO::FETCH_ASSOC);
$totalRows_ss_dist = $ss_dist->rowCount();	
	
	$today_dist=$row_trv['ss_dist'];
	$html.= "";
}
									
$html.='</td>
      </tr>
    
      <tr>
        <td style="background-color:#F5F5F5"><p style="text-align:justify; font-family:; font-size: 14px">';
$html.= "After breakfast check out hotel"; 
									//time calculation 
									
$dept_date_time=$row_trv['tr_date'].' '.$row_orders['trv_depatr_time'];
$dept_date_tstmp=date('U',strtotime($dept_date_time));
$dept_time4pm=date('U',strtotime($row_trv['tr_date'].' 04:00 PM'));//for next day morning - arrival
									
if($dept_date_tstmp>=$dept_time4pm)
{//departure time is within 4-pm - show hot spots
	$html.= ", and proceed to sight-seeing including - ";
	$hots_array=array();
	$hots_with_id=array();
	$vg=0;
	foreach($row_hot_main as $row_hot)
	{
		$hots_array[$vg]=$row_hot['spot_name'];
		$hots_with_id[$vg]=$row_hot['hotspot_id'];
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
		
		$hot_with_sep='';								
	for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<floor(count($hots_array));$hs++)
	{
		if(isset($hots_array[$hs]))
		{
			$html.= $hots_array[$hs].', ';
				if($hot_with_sep!='')
				{
					$hot_with_sep=$hot_with_sep.','.$hots_with_id[$hs];
				}else{
					$hot_with_sep=$hots_with_id[$hs];
				}
		}
	}
	
	$rem_area_cnt[$row_trv['tr_from_cityid']]=$rem_area_cnt[$row_trv['tr_from_cityid']]+$tot_div_hot;
	$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-1;
	$hots_desc_arr[$desc_date]['spot_id']=$hot_with_sep;
	//via edit start
	$spot_ids='-';
										if(trim($row_trv['via_cities'])!='')
										{
									$via_cities_arr=explode('-',$row_trv['via_cities']);
									for($ci=0;$ci<count($via_cities_arr);$ci++)
									{
										if($ci != 0 && ($ci != count($via_cities_arr)-1))
										{
											if(trim($via_cities_arr[$ci])!='-')
											{
												if($today_dist>=250)//if total dist >250 means show hotspots prior 1 and 2 only
												{
$via_hspots = $conn->prepare("SELECT * FROM hotspots_pro where spot_city=? and (spot_prior='1' || spot_prior='2')");
												}else{//if total dist <250 means show hotspots prior 1,2,3 & 4 only
$via_hspots = $conn->prepare("SELECT * FROM hotspots_pro where spot_city=? and (spot_prior='1' || spot_prior='2' || spot_prior='3' || spot_prior='4')");
												}
$via_hspots->execute(array($via_cities_arr[$ci]));
//$row_via_hspots= mysql_fetch_assoc($via_hspots);
$row_via_hspots_main=$via_hspots->fetchAll();
$totalRows_via_hspots =$via_hspots->rowCount();	

												if($totalRows_via_hspots>0)
												{
													foreach($row_via_hspots_main as $row_via_hspots)
													{
														$html.=$row_via_hspots['spot_name'];
														if($spot_ids!='-')
														{
															$spot_ids=$spot_ids.",".$row_via_hspots['hotspot_id'];
														}else{
															$spot_ids=$row_via_hspots['hotspot_id'];
														}
													}
													$hots_desc_arr[$desc_date]['spot_id']=$hots_desc_arr[$desc_date]['spot_id'].','.$spot_ids;
												}
											}
										}
									}
										}
									//via edit end
										
	$html.= "finally, we transfer you to ".$row_trv['tr_to_cityid']." airport/railway station.";
	}
	else
	{
		//departure time is not within 4-pm - dont show hot spots
		$html.= " and we transfer you to ".$row_trv['tr_to_cityid']." airport/railway station.";
		$hots_desc_arr[$desc_date]['spot_id']='-';
	}
	
	//additional cost - addons
										if(trim($row_trv['addi_cost_for'])!='')
										{
											$addi_cost_name=explode('/',$row_trv['addi_cost_for']);
                                    $html.='<div class="col-sm-12" style="color: #383634; margin-top:10px; border: 1px dashed #5F83DE; padding:3px; " >
                                        <strong style="color:#AB5B14; font-family:; font-size: 14px" >* Special Add-ons to this date: </strong>
                                        <small style="color:#900; font-weight:600; font-family:; font-size: 13px">( Additional cost added for this add-ons )</small>
                                        <ul style=" list-style-type:circle; ">';
                                        foreach($addi_cost_name as $acnam)
										{ 
                                        $html.='<li style="font-weight:500; color:#383634; font-family:; font-size: 14px">'.$acnam.'</li>';
                                       }
                                       $html.=' </ul>
                                        </div>';
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
  </tr>';
  
  $html.='<hr>
  <tr >
    <td colspan="6"  class="hide_border" style="text-align:center" ><strong style="color:#737373"><u>Place Description With Shighseeing Spots</u></strong></td></tr>
	 <tr ><td style="text-align:center" colspan="6">';
	 
$sphist = $conn->prepare("SELECT * FROM travel_sched where travel_id =? ORDER BY sno ASC ");
$sphist->execute(array($_GET['planid']));
$row_sphist_main=$sphist->fetchAll();
$totalRows_sphist =$sphist->rowCount();

foreach($row_sphist_main as $row_sphist)
{
	$desc_hist=date('d-M-Y D',strtotime(str_replace('-','/',$row_sphist['tr_date'])));

    $html.='
	<table style="width:100%;border:1px solid #DEDEDE;margin-top:20px;">
	<tr style="background-color:#ECECEC; color:#333; font-weight:600">
        <td style="width:23%">';
		$html.='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$desc_hist;
		$html.='</td>
        <td style="width:77%">';

$dvcity1 = $conn->prepare("SELECT * FROM dvi_cities where id =?");
$dvcity1->execute(array($hots_desc_arr[$desc_hist]['fcid']));
$row_dvcity1 = $dvcity1->fetch(PDO::FETCH_ASSOC);
$totalRows_dvcity1 = $dvcity1->rowCount();


$dvcity2 = $conn->prepare("SELECT * FROM dvi_cities where id =?");
$dvcity2->execute(array($hots_desc_arr[$desc_hist]['tcid']));
$row_dvcity2 = $dvcity2->fetch(PDO::FETCH_ASSOC);
$totalRows_dvcity2 = $dvcity2->rowCount();

					 $html.=$row_dvcity1['name']."  -  ".$row_dvcity2['name']; 
					  $html.='</td>
    </tr>
	 <tr>
    	<td colspan="2">';

$dvcity_hist = $conn->prepare("SELECT * FROM  dvi_cities_history where cid =?");
$dvcity_hist->execute(array($hots_desc_arr[$desc_hist]['tcid']));
$row_dvcity_hist= $dvcity_hist->fetch(PDO::FETCH_ASSOC);
$totalRows_dvcity_hist =$dvcity_hist->rowCount();
		
		if(trim($row_dvcity_hist['cdesc'])!='' && trim($row_dvcity_hist['cdesc'])!='-')
		{
		   $html.='<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>'.$row_dvcity2["name"].'&nbsp;&nbsp;:&nbsp;&nbsp;</strong>'.$row_dvcity_hist['cdesc'];
		}else{
			$html.='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Default Contant : This day, we are going to see local sight-seeing spots.';	
		}
        $html.='</td>
    </tr>';
   
	if(trim($hots_desc_arr[$desc_hist]['spot_id'])!='' && trim($hots_desc_arr[$desc_hist]['spot_id'])!='-')
	{
     $html.='<tr style="background-color:; font-weight:600;"><td width="35%">Visiting Spots</td><td width="65%">Opening and Closing Time</td></tr>';
			$tot_spot_arr=explode(',',$hots_desc_arr[$desc_hist]['spot_id']);
		for($hr=0;$hr<count($tot_spot_arr);$hr++)
		{
			if($tot_spot_arr[$hr]!='-' && $tot_spot_arr[$hr]!='')
			{
				
				$dvcity_hstime = $conn->prepare("SELECT * FROM  hotspots_pro where hotspot_id =?");
				$dvcity_hstime->execute(array($tot_spot_arr[$hr]));
				$row_hstime = $dvcity_hstime->fetch(PDO::FETCH_ASSOC);
				$totalRows_hstime  = $dvcity_hstime->rowCount();
				$html.='<tr><td>'.$row_hstime['spot_name'].'</td><td>'.$row_hstime['spot_timings'].'</td></tr>';
			}
		}
   }
     $html.='</table>';
}
	 $html.='</td></tr></table>'; 
  
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
	<h3><font style="font-weight: bold; float:left; font-family:; text-align:left; font-size: 14px; margin-left:5px">Dear : '.$row_mst['tr_name']." *".$row_mst['pax_cnt'].'</font><font style="font-weight: bold; float:left; font-family:; text-align:right; font-size: 14px; margin-left:5px">Tour Date : '.$start_dtour." To ".$last_dtour." &nbsp;&nbsp;[ ".$totalRows_trl_scd.' days ]</font></h3>
   </td>
  </tr>
  <tr class="hide_border"> 
    <td class="hide_border" colspan="6">
	<table width="100%"  border="0" style="font-family: ; margin-top:20px; text-align: left; font-size: 14px">
      <tr>
        <td class="hide_border" colspan="2"  height="55px;" style="text-align: left; font-weight: bold;">Greetings from DVI Holidays !!!</td>
        </tr>
      <tr >
        <td class="hide_border" height="15px;" colspan="2">Thank you for your choice to use DVI Holidays</td>
        </tr>
      <tr>
        <td colspan="2" class="hide_border" ><p>The Motto of our company is to provide satisfactory servies to our entire guest. In order to achevieve this aim, we need to know your opinion on it. praise would be a motivation for us to continue our services. And any critic would naturally be a reason for us to improve our services according to the requirements and desires of our Guests.</p></td>
        </tr>
      <tr>
        <td colspan="2" height="30px">Please tell your Friends what would you like about us!</td>
        </tr>
      <tr>
        <td colspan="2" height="30px">Please tell us what you dislike.<br><br></td>
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
		<table width="100%"  border="0" style="font-family: ; margin-top:20px; text-align: left; font-size: 14px">
      <tr>
        <td class="hide_border" colspan="2"  height="20px;" style="text-align: left; font-weight: bold;"><span style="color:#F00">Terms & Conditions:</span></td>
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
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr></table></td></tr></table>';
}//main for loop
	  $html.='</body></html>';

	  
//echo $html; die;
$fnfile=$row_orders['plan_id'].'_'.$row_orders['tr_name'].'.pdf';
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper('A4','portrait');
$dompdf->render();
$dompdf->stream($fnfile, array("Attachment" => false));

//$pdf = $dompdf->output();
?>
