<?php

$timezone = new DateTimeZone("Asia/Kolkata" );
  $date = new DateTime();
  $date->setTimezone($timezone );
  $mm=$date->format('m');
  $mm1=$date->format('M');
  $yy=$date->format('Y');
  $dd=$date->format('d');
  $time=date("H:i:s");
  $today=date('d.m.Y');

session_start();
require_once('../Connections/divdb.php');
$idd=explode('#',$_GET['planid']);
$str=$idd[0];

$orders = $conn->prepare("SELECT * FROM travel_master where plan_id =?");
$orders->execute(array($_GET['planid']));
$row_orders = $orders->fetch(PDO::FETCH_ASSOC);
$totalRows_orders = $orders->rowCount();



$you = $conn->prepare("SELECT * FROM agent_pro where agent_id =?");
$you->execute(array($_SESSION['uid']));
$row_you = $you->fetch(PDO::FETCH_ASSOC);
$totalRows_you = $you->rowCount();

if(trim($row_you['comp_name'])=='' || trim($row_you['comp_name'])=='-')
{
	$comp_myname="DVI Holidays";
}else{
	$comp_myname=$row_you['comp_name'];
}
//echo $row_you['comp_logo'];

?>

<html>
<head>
		<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="../core/assets/css/style.css" rel="stylesheet">
		<link href="../core/assets/css/style-responsive.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="../core/assets/plugins/Tags/jquery.tagsinput.css" />
      <!--  <link href='https://fonts.googleapis.com/css?family=Calibri' rel='stylesheet' type='text/css'>-->
        <script src="../core/assets/js/jquery.min.js"></script>
        <style>
		
		.loader_ax{
position: fixed;
left: 0px;
top: 0px;
width: 100%;
height: 100%;
z-index: 9999;
background: url('../images/ajax_loader.gif') center no-repeat ;
background-size:120px;
background-color:rgba(0, 0, 0, 0.5);
}

.f_weight
{
	font-weight:600;
}

@font-face {
    font-family: Calibri;
   /* src: url('../ADMIN/Calibri.ttf');*/
    src: url('https://fonts.googleapis.com/css?family=Calibri');
}

body {
    background-position: 50% 50%;
    margin:0px;
    padding:0px !important;
	font-family:Calibri;
	font-size: 14px;
	color:#083B6F !important;
}

table td{
	padding:3px;
}

table td.tdstyle{
	padding:4px;
	border:#666 solid 1px;
}
</style>
        </head>
        <body class="div-nicescroller" style="font-family:Calibri;">
        <div class="loader_ax" style="display:none"></div>
        <div class="row">
        <div class="col-sm-12">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
<div id="mail_me">  
<!--<link href='https://fonts.googleapis.com/css?family=Calibri' rel='stylesheet' type='text/css'>-->
<table style="border:#60B0FF groove; padding:6px; vertical-align: text-middle; " width="100%">
 <tr><td>
           <table style="" width="100%" >
                  <tr>
                      <td width="80%" style="font-family:Calibri; font-size: 16px;">
                          <strong><?php  if(trim($row_you['comp_name'])!=''){ echo $row_you['comp_name']; }else{ echo "DVI Holidays";} ?></strong><br>
                          <strong><?php echo $row_you['agent_addr'];?></strong><br />
                          <strong>Help Line : 27 * 7@ All India Customer Care : 9047776899 </strong><br />
                      </td>
                      <td width="20%">
                      <?php if($row_you['comp_logo']!=''){?>
                           <img  src="http://dvi.co.in/img_upload/agent_img/logo/<?php echo $row_you['comp_logo']; ?>"  height="75px" width="75px" alt="Your Logo"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                           <?php }else{ ?>
                           <img  src="http://dvi.co.in/img_upload/agent_img/logo/logo.png"  height="75px" width="75px" alt="DVI Logo"/>
                           <?php } ?>
                      </td>
                   </tr>
           </table>
 </td></tr>



 <tr><td><hr style="border:1px solid #039;margin-top: 10px;margin-bottom: 10px; "></td></tr>
 
 <!-- <tr><td>
 			<table>
                 <tr><td style="font-family:Calibri; font-family:Calibri; font-size: 14px; font-weight:600">&nbsp;Guest Name</td><td>:</td><td style="font-family:Calibri; font-size: 14px; font-weight:600"><?php echo $row_orders['tr_name']; ?></td></tr>
                 <tr><td style="font-family:Calibri; font-family:Calibri; font-size: 14px; font-weight:600">&nbsp;Pax Count</td><td>:</td><td style="font-family:Calibri; font-size: 14px; font-weight:600"><?php echo $row_orders['pax_cnt']."&nbsp;Person(s)"; ?></td></tr>
                 <tr><td style="font-family:Calibri; font-size: 14px; font-weight:600">&nbsp;Total Traveling days</td><td>:</td><td style="font-family:Calibri; font-size: 14px; font-weight:600"><?php echo $row_orders['tr_days']; ?></td></tr>
                 <tr><td style="font-family:Calibri; font-size: 14px; font-weight:600">&nbsp;Vehicle Infomation</td><td>:</td>
                                <td style="font-family:Calibri; font-size: 14px; font-weight:600"><?php
								$vah=explode(',',$row_orders['tr_vehids']);
								for($r=0;$r<count($vah);$r++)
								{
									if(trim($vah[$r]) != '')
									{
								  
											$vpro = $conn->prepare("SELECT * FROM vehicle_pro where vehi_id =?");
											$vpro->execute(array($vah[$r]));
											$row_vpro =$vpro->fetch(PDO::FETCH_ASSOC);
											$totalRows_vpro = $vpro->rowCount();
if(isset($vah[$r+1]) && $vah[$r+1] != '')
{
	 echo $row_vpro['vehicle_type'].",&nbsp;";
}else
{
	echo $row_vpro['vehicle_type'];
}
								
									}
								}
								  ?></td></tr>
         </table>
 </td></tr> -->
 <tr><td>&nbsp;</td></tr>
 <tr><td>
 	<?php 
	
	$trvscd = $conn->prepare("SELECT * FROM  travel_sched where travel_id =? ORDER BY sno ASC");
	$trvscd->execute(array($_GET['planid']));
	//$row_trvscd = mysql_fetch_assoc($trvscd);
	$row_trvscd_main=$trvscd->fetchAll();
	$totalRows_trvscd = $trvscd->rowCount();
	?>
    <table border="1" width="" style="border-collapse: collapse;" >
    	<tr ><th colspan="5" style="text-align:center; padding:10px; font-family:Calibri; font-size: 14px;"> 
        		<strong style="color:#CE7708;">Travel - Information </strong></th></tr>
    	<tr><th style="padding:6px; font-family:Calibri; font-size: 14px;">&nbsp; S.No &nbsp;</th>
        <th  style="padding:6px; font-family:Calibri; font-size: 14px;">&nbsp; Date &nbsp;</th>
        <th  style="padding:6px; font-family:Calibri; font-size: 14px;">&nbsp; Travelling Cities &nbsp;</th>
        <th  style="padding:6px; font-family:Calibri; font-size: 14px;">&nbsp; Distance &nbsp;</th>
        <th  style="padding:6px; font-family:Calibri; font-size: 14px;">&nbsp; Travalling Time &nbsp;</th>
        </tr>
        <?php $ts=1; foreach($row_trvscd_main as $row_trvscd){?>
        	<tr>
            <td style="font-family:Calibri; font-size: 12px; font-weight:600; padding:5px">&nbsp;<?php echo $ts; ?>&nbsp;</td>
            <td style="font-family:Calibri; font-size: 12px; font-weight:600; padding:5px">&nbsp;<?php echo date('d-M-Y',strtotime($row_trvscd['tr_date'])); ?>&nbsp;</td>
            <td style="font-family:Calibri; font-size: 12px; font-weight:600; padding:5px">&nbsp;<?php echo $row_trvscd['tr_from_cityid'].' - '.$row_trvscd['tr_to_cityid']; ?>&nbsp;</td>
            <td style="font-family:Calibri; font-size: 12px; font-weight:600; padding:5px">&nbsp;<?php if($row_trvscd['tr_dist_ess']!='0'){ echo $row_trvscd['tr_dist_ess']." Kms.";  }else{ echo $row_trvscd['tr_dist_ss']." Kms."; }?>&nbsp;</td>
            <td style="font-family:Calibri; font-size: 12px; font-weight:600; padding:5px">&nbsp;<?php echo $row_trvscd['tr_time']; ?>&nbsp;</td>
            </tr>
        <?php $ts++; }//while end?>
    </table>
 </td></tr>
 
 <tr><td>&nbsp;  </td></tr>
 
 <tr><td>
 	      <?php
//my start

$trv_future = $conn->prepare("SELECT * FROM travel_sched where travel_id =?");
$trv_future->execute(array($_GET['planid']));
//$row_trv_future = mysql_fetch_assoc($trv_future);
//$row_trv_future_main=$trv_future->fetchAll();
$area_arr=array();
$gv=0;
$dt_cnt_arr=array();
while($row_trv_future = $trv_future->fetch(PDO::FETCH_ASSOC))
{
	if(!isset($dt_exists[$row_trv_future['tr_to_cityid']]))
	$dt_exists[$row_trv_future['tr_to_cityid']]=0;
$sql_travel_daytrip = $conn->prepare("SELECT COUNT(*) as cnt  FROM dvi_cities dc,travel_daytrip td where dc.id=td.orig_cid and name=? and travel_id = ?");
$sql_travel_daytrip->execute(array($row_trv_future['tr_to_cityid'],$_GET['planid']));
$row_sql_travel_daytrip = $sql_travel_daytrip->fetch(PDO::FETCH_ASSOC);
//print_r($row_trv_future);
	if($row_trv_future['tr_from_cityid']==$row_trv_future['tr_to_cityid'] && $row_trv_future['via_cities'] =='-' && $row_sql_travel_daytrip['cnt'] && $dt_exists[$row_trv_future['tr_to_cityid']] == 0 && $gv >0){
			$dt_exists[$row_trv_future['tr_to_cityid']]=1;
		$dt_cnt_arr[]=$gv;
	}
	else{
		
$area_arr[$gv]=$row_trv_future['tr_from_cityid'];
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
$row_trv_main =$trv->fetchAll();
$totalRows_trv = $trv->rowCount();
$chn=0; 
$trv_cnt_1 = $totalRows_trv - 1;?>
					<table width="97%">
                    <?php
                    if($totalRows_trv>0){	?>
                    <tr><td colspan="3" style="text-align:center">
                                    <strong>Tour Itinerary Plan (Program schedule)</strong>
                                    <br><small>Specially prepared for you</small>
                    </td></tr>
                                    <?php }?>
                                   
                                     <?php foreach($row_trv_main as $row_trv){
										
										?>
                                       
                                        <?php
										if($trv_cnt_1>0)
										{//for stay table - aft end day calculation
										?>
                                        <tr>
                                        <td class="f_weight" style="font-family:Calibri; font-size: 14px;  padding:5px" width="17%">
                                    <?php
										echo date('d-M-Y',strtotime(str_replace('-','/',$row_trv['tr_date'])));
										echo '<br>'.date('l',strtotime(str_replace('-','/',$row_trv['tr_date'])));
									?>
                                    	</td>
                                        <td class="f_weight" style="font-family:Calibri; font-size: 14px;  padding:5px" width="3%"></td>
                                        <td class="f_weight" style="font-family:Calibri; font-size: 14px;  padding:5px; text-align:justify" width="78%">
                                          <?php

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
									?>
                                    
                                    <font style="color:#B16505;  font-size:14px; font-weight:600"> <?php if($chn=='0'){?>Arrival - <?php }?> <?php echo $row_trv['tr_from_cityid'];if($chn=='0'){echo " [ ".$row_orders['tr_arrdet']." @".$row_orders['tr_arr_time']." ]";}
									
									//via edit start
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
												echo "&nbsp;&nbsp;-&nbsp;&nbsp;".$row_via_cty['name'];
											}
										}
									}
										}//no empty via
									//via edit end
									
									echo "&nbsp;&nbsp;-&nbsp;&nbsp;".$row_trv['tr_to_cityid'];
									if($row_trv['tr_dist_ss']>0)
									{
										$dt_city_name_int=1;
										if(isset($dt_arr[$row_trv['tr_from_cityid']][0])){
										$dt_city_name_int = (int) $dt_arr[$row_trv['tr_from_cityid']][0];
										}
										if(isset($dt_arr[$row_trv['tr_from_cityid']][0]) && $dt_city_name_int ==0 && $chn!=0 && in_array($chn,$dt_cnt_arr)){
											 $distanc = $conn->prepare("SELECT * FROM dvi_citydist where (from_cityid =? and to_cityid =?) or (from_cityid =? and to_cityid =?)");
$distanc->execute(array($row_cityy1['id'],$dt_arr[$row_trv['tr_from_cityid']]['id'],$dt_arr[$row_trv['tr_from_cityid']]['id'],$row_cityy1['id']));
$row_distanc= $distanc->fetch(PDO::FETCH_ASSOC);					
$totalRows_distanc = $distanc->rowCount();	
 $daytravel_dist=$row_distanc['dist']*2;
echo " (".$daytravel_dist." Kms)";
									 
								 
									 }
									 else{
									echo " (".$row_trv['tr_dist_ss']." Kms)";
										$today_dist=$row_trv['tr_dist_ss'];
									}
									}else{
$ss_dist = $conn->prepare("SELECT * FROM dvi_cities where id=?");
$ss_dist->execute(array($row_cityy_to['id']));
$row_ss_dist=$ss_dist->fetch(PDO::FETCH_ASSOC);
$totalRows_ss_dist = $ss_dist->rowCount();	
									//echo " (".$row_ss_dist['ss_dist']." Kms)";
									echo "";
									$today_dist=$row_trv['ss_dist'];
									}?></font><br /><br /><span><?php //echo $totalRows_hot; 
//hotel chng new place
									//echo $chn;
									if($chn=='0'){
										//new change
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
				{//next day also same city means
						if($time6am <= $arr_date_tstmp && $arr_date_tstmp <= $time3pm)
						{//between 6am to 3pm ( over night in same city)
					
							echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid'].". Check in ( 12:00 noon - standard time) at hotel, refresh and later proceed to sight-seeing including - ";
						$hots_array=array();
									$vg=0;
									foreach($row_hot_main as $row_hot){
										   $hots_array[$vg]=$row_hot['spot_name'];
										   $vg++;
										} 
										
										$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_from_cityid']]);
				for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<$tot_div_hot+$rem_area_cnt[$row_trv['tr_from_cityid']];$hs++)
										{
											echo $hots_array[$hs].', ';
										}
										
										$rem_area_cnt[$row_trv['tr_from_cityid']]=$rem_area_cnt[$row_trv['tr_from_cityid']]+$tot_div_hot;
										$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-1;
										
										//via edit start
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
														echo $row_via_hspots['spot_name'];
													}
												}
											}
										}
									}
										}
									//via edit end
										

							
							echo " and later return to hotel and overnight stay at hotel.";
						}else if($time3pm <= $arr_date_tstmp && $arr_date_tstmp <= $time6pm)
						{//between 6am to 3pm ( over night in same city)
							echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid']." and proceed to hotel, check-in and overnight at hotel.";//have to show sight-seeing in next day
							$show_in_next_day=2;
								$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-2;
						}else if($time6pm <= $arr_date_tstmp && $arr_date_tstmp <= $arr_timenx6am)
						{//between 6am to 3pm ( over night in same city)
							echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid'].", proceed to hotel, check-in and overnight stay at hotel.";//have to show sight-seeing in next day
							$show_in_next_day=2;
							$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-2;
						}
						// daytrip not applicable for arrival
						
				}else{//next day having different city means
					if($time6am <= $arr_date_tstmp && $arr_date_tstmp <= $time3pm)
						{//between 6am to 3pm ( over night in diff city)
					echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid'].", proceed to sight-seeing including - ";
						$hots_array=array();
									$vg=0;
									foreach($row_hot_main as $row_hot){
										   $hots_array[$vg]=$row_hot['spot_name'];
										   $vg++;
										} 
										
										$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_from_cityid']]);
				for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<$tot_div_hot+$rem_area_cnt[$row_trv['tr_from_cityid']];$hs++)
										{
											echo $hots_array[$hs].', ';
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
								foreach($row_hot1_main as $row_hot1){
										   $hots_array[$vg]=$row_hot1['spot_name'];
										   $vg++;
										} 
								
								$area_cnt[$row_trv['tr_to_cityid']]=$area_cnt[$row_trv['tr_to_cityid']]+1;
								$copy_area_arr[$row_trv['tr_to_cityid']]=$copy_area_arr[$row_trv['tr_to_cityid']]+1;
										
										$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_to_cityid']]);	
										
				for($hs1=$rem_area_cnt[$row_trv['tr_to_cityid']];$hs1<$tot_div_hot+$rem_area_cnt[$row_trv['tr_to_cityid']];$hs1++)
										{
											echo $hots_array[$hs1].', ';
										}
										$rem_area_cnt[$row_trv['tr_to_cityid']]=$rem_area_cnt[$row_trv['tr_to_cityid']]+$tot_div_hot;
										$copy_area_arr[$row_trv['tr_to_cityid']]=$copy_area_arr[$row_trv['tr_to_cityid']]-1;
							}
								}//within 11:00AM arrival means if- end
									
									//via edit start
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
														echo $row_via_hspots['spot_name'];
													}
												}
											}
										}
									}
										}
									//via edit end
									
							echo "and later drive to ".$row_trv['tr_to_cityid'].", check-in and overnight stay at hotel.";
	
						}else if($time3pm <= $arr_date_tstmp && $arr_date_tstmp <= $time6pm)
						{//between 3pm to 6pm ( over night in diff city)
						echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid'].". ";
						
						if($totalRows_hot>0){ 
						echo "If time permits proceed to sight-seeing including - ";
						
						$hots_array=array();
									$vg=0;
									foreach($row_hot_main as $row_hot){
										   $hots_array[$vg]=$row_hot['spot_name'];
										   $vg++;
										} 
										
										$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_from_cityid']]);
				for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<$tot_div_hot+$rem_area_cnt[$row_trv['tr_from_cityid']];$hs++)
										{
											echo $hots_array[$hs].', ';
										}
										$rem_area_cnt[$row_trv['tr_from_cityid']]=$rem_area_cnt[$row_trv['tr_from_cityid']]+$tot_div_hot;
										$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-1;
										
										//via edit start
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
														echo $row_via_hspots['spot_name'];
													}
												}
											}
										}
									}
										}
									//via edit end
						
						echo "and ";
						}//more hot spot
						echo " later drive to ".$row_trv['tr_to_cityid'].", check-in and overnight stay at hotel.";
							
						}else if($time6pm <= $arr_date_tstmp && $arr_date_tstmp <= $arr_timenx6am)
						{//between 6am to 3pm ( over night in diff city)
						echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid']." and proceed to ".$row_trv['tr_to_cityid'].", arrival and check-in and Overnight stay at hotel.";//skip sight-seeing and proceed to next day if
						
						//have to skip
						$hots_array=array();
									$vg=0;
									foreach($row_hot_main as $row_hot){
										   $hots_array[$vg]=$row_hot['spot_name'];
										   $vg++;
										} 
										
										$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_from_cityid']]);
										//skip hot spot
										$rem_area_cnt[$row_trv['tr_from_cityid']]=$rem_area_cnt[$row_trv['tr_from_cityid']]+$tot_div_hot;
										$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-1;
						}
				}
}//if end -$totalRows_trv_new count 

									}//for first day
									else // for other days
									{
										if(!empty($dt_arr) && $chn != 0 && in_array($chn,$dt_cnt_arr))
								 {
									 //print "DT";

									$dt_city_name_int = (int) $dt_arr[$row_trv['tr_from_cityid']][0];
									 if(isset($dt_arr[$row_trv['tr_from_cityid']][0]) && $dt_city_name_int == 0)
									 {
										



			echo "<br><span style='font-weight:bold; color:green'>"."DAYTRIP applicable to ".$dt_arr[$row_trv['tr_from_cityid']][0]." (".$daytravel_dist." kms) : </span>";


$dayhpot= $conn->prepare("SELECT * FROM hotspots_pro where spot_city =? and status='0'");
$dayhpot->execute(array($dt_arr[$row_trv['tr_from_cityid']]['id']));
//$row_dayhpot = mysql_fetch_assoc($dayhpot);
$row_dayhpot_main=$dayhpot->fetchAll();
$totalRows_dayhpot = $dayhpot->rowCount();

foreach($row_dayhpot_main as $row_dayhpot)
{
		echo  $row_dayhpot['spot_name'];
}
										 unset($dt_arr[$row_trv['tr_from_cityid']][0]);
										 $dt_arr[$row_trv['tr_from_cityid']] = array_values($dt_arr[$row_trv['tr_from_cityid']]);
									 }
									 
								 }else{
										if($row_trv['tr_from_cityid'] == $row_trv['tr_to_cityid'])
										{
											echo "After breakfast ";
										}else{//different ending city means show the ending city hotspot
											echo "After breakfast check out hotel and";
										}
									
									if($totalRows_hot>0){ 
									echo " proceed to sight-seeing including - ";
									$hots_array=array();
									$vg=0;
									foreach($row_hot_main as $row_hot){
										   $hots_array[$vg]=$row_hot['spot_name'];
										   $vg++;
										} 
										
										if(isset($show_in_next_day) && $show_in_next_day==2)
										{
											$show_in_next_day=3;
											$tot_div_hot=floor(count($hots_array)/($area_cnt[$row_trv['tr_from_cityid']]-1));
										}else{
										$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_from_cityid']]);	
										}
										
				for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<$tot_div_hot+$rem_area_cnt[$row_trv['tr_from_cityid']];$hs++)
										{
											if(isset($hots_array[$hs]))
											{
											echo $hots_array[$hs].', ';
											}
										}
										$rem_area_cnt[$row_trv['tr_from_cityid']]=$rem_area_cnt[$row_trv['tr_from_cityid']]+$tot_div_hot;
							$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-1;
							
							//via edit start
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
														echo $row_via_hspots['spot_name'];
													}
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
								$vg=0;
								foreach($row_hot1_main as $row_hot1){
										   $hots_array[$vg]=$row_hot1['spot_name'];
										   $vg++;
										} 
								
								
								$area_cnt[$row_trv['tr_to_cityid']]=$area_cnt[$row_trv['tr_to_cityid']]+1;
								$copy_area_arr[$row_trv['tr_to_cityid']]=$copy_area_arr[$row_trv['tr_to_cityid']]+1;
										if(isset($show_in_next_day) && $show_in_next_day==2)
										{  $show_in_next_day=3;
											$tot_div_hot=floor(count($hots_array)/($area_cnt[$row_trv['tr_to_cityid']]-1));
										}else{
										$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_to_cityid']]);	
										}
										
				for($hs1=$rem_area_cnt[$row_trv['tr_to_cityid']];$hs1<$tot_div_hot+$rem_area_cnt[$row_trv['tr_to_cityid']];$hs1++)
										{
											echo $hots_array[$hs1].', ';
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
											echo $hots_array[$hs].', ';//for final day
				}
							}
										}else{
										echo " spending day to shopping ";	
										}?></span>
                                      
                                        <?php
							if($row_trv['tr_from_cityid'] == $row_trv['tr_to_cityid'])
							{
								 echo "and later return to hotel. Overnight stay at hotel.";
								 // daytrip goes here
if(!empty($dt_arr))
								 {
									 if(isset($dt_arr[$row_trv['tr_from_cityid']][0]) && !is_numeric($dt_arr[$row_trv['tr_from_cityid']][0]))
									 {
										 echo "<br><span style='font-weight:bold; color:green'>"."DAYTRIP applicable to ".$dt_arr[$row_trv['tr_from_cityid']][0]."</span>";
										 unset($dt_arr[$row_trv['tr_from_cityid']][0]);
										 $dt_arr[$row_trv['tr_from_cityid']] = array_values($dt_arr[$row_trv['tr_from_cityid']]);
									 }
								 }
								 
							}else{
								 echo "and later proceed to ".$row_trv['tr_to_cityid'].". Overnight stay at hotel. ";
								 }}
										?>
                                        <?php }//fot other days else end
										
										//additional cost - addons
										if(trim($row_trv['addi_cost_for'])!='')
										{
											$addi_cost_name=explode('/',$row_trv['addi_cost_for']);
										?>
                                        <div class="col-sm-12" style="color: #7A7FA2; margin-top:10px; border: 1px dashed #5F83DE; padding:5px;" >
                                        <strong style="color:#AB5B14;" >* Special Add-ons to this date: </strong>
                                        <small style="color:#900; font-weight:600">( Additional cost added for this add-ons )</small>
                                        <ul style=" list-style-type:circle; ">
                                        <?php foreach($addi_cost_name as $acnam)
										{ ?>
                                        <li style="font-weight:500"><?php echo $acnam; ?></li>
                                        <?php }?>
                                        </ul>
                                        </div>
                                        <?php } ?>
                               </td>
                               </tr>
                               <tr><td colspan="3"><hr style="margin-top: 10px;margin-bottom: 10px;"></td></tr>
                                     <?php
									 $chn++;
										}//inner hotel while end
										else{ ?>
                                        <tr><td  class="f_weight" style="font-family:Calibri; font-size: 14px;  padding:5px;" width="17%">
                                    <?php
									if($row_trv['tr_date'] != '')
									{
										echo date('d-M-Y',strtotime(str_replace('-','/',$row_trv['tr_date'])));
										echo '<br>'.date('l',strtotime(str_replace('-','/',$row_trv['tr_date'])));
									}
									?>
                                    </td>
                                    <td class="f_weight" style="font-family:Calibri; font-size: 14px;  padding:5px;" width="3%"></td>
                                    <td  class="f_weight" style="font-family:Calibri; font-size: 14px;  padding:5px; text-align:justify" width="78%">
                                          <?php

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
									?>
                                    
                                    <span style="color:#B16505;  font-size:14px; font-weight:600"> <?php echo $row_trv['tr_from_cityid']."&nbsp;&nbsp;-&nbsp;&nbsp;".$row_trv['tr_to_cityid'];
									
									//via edit start
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
												echo "&nbsp;&nbsp;-&nbsp;&nbsp;".$row_via_cty['name'];
											}
										}
									}
										}//no empty via
									//via edit end
									echo "&nbsp;( Departure )  [ ".$row_orders['tr_depdet']."&nbsp; @".$row_orders['trv_depatr_time']." ]";
									
									if($row_trv['tr_dist_ss']>0)
									{
									//echo " (".$row_trv['tr_dist_ss']." Kms)";
									$today_dist=$row_trv['tr_dist_ss'];
									}else{
$ss_dist = $conn->prepare("SELECT * FROM dvi_cities where id=?");
$ss_dist->execute(array($row_cityy_to['id']));
$row_ss_dist= $ss_dist->fetch(PDO::FETCH_ASSOC);
$totalRows_ss_dist = $ss_dist->rowCount();	
									//echo " (".$row_ss_dist['ss_dist']." Kms)";
									echo "";
									$today_dist=$row_trv['ss_dist'];
									}
									?></span><br /><br />
                                    
                                    <?php echo "After breakfast check out hotel"; 
									//time calculation 
									
	$dept_date_time=$row_trv['tr_date'].' '.$row_orders['trv_depatr_time'];
	$dept_date_tstmp=date('U',strtotime($dept_date_time));
	$dept_time4pm=date('U',strtotime($row_trv['tr_date'].' 04:00 PM'));//for next day morning - arrival
									
									if($dept_date_tstmp>=$dept_time4pm)
									{//departure time is within 4-pm - show hot spots
									echo ", and proceed to sight-seeing including - ";
										$hots_array=array();
										$vg=0;
									foreach($row_hot_main as $row_hot){
										   $hots_array[$vg]=$row_hot['spot_name'];
										   $vg++;
										} 
										
										
										if(isset($show_in_next_day) && $show_in_next_day==2)
										{
											$show_in_next_day=3;
											$tot_div_hot=floor(count($hots_array)/($area_cnt[$row_trv['tr_from_cityid']]-1));
										}else{
										$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_from_cityid']]);	
										}
										
				for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<floor(count($hots_array));$hs++)
										{
											if(isset($hots_array[$hs]))
											{
											echo $hots_array[$hs].', ';
											}
										}
										$rem_area_cnt[$row_trv['tr_from_cityid']]=$rem_area_cnt[$row_trv['tr_from_cityid']]+$tot_div_hot;
							$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-1;
							
							//via edit start
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
														echo $row_via_hspots['spot_name'];
													}
												}
											}
										}
									}
										}
									//via edit end
										
										echo "finally, we transfer you to ".$row_trv['tr_to_cityid']." airport/railway station.";
										
									}else{
										//departure time is not within 4-pm - dont show hot spots
										echo " and we transfer you to ".$row_trv['tr_to_cityid']." airport/railway station.";
									}
									
									//additional cost - addons
										if(trim($row_trv['addi_cost_for'])!='')
										{
											$addi_cost_name=explode('/',$row_trv['addi_cost_for']);
										?>
                                        <div class="col-sm-12" style="color: #7A7FA2; margin-top:10px; border: 1px dashed #5F83DE; padding:5px;" >
                                        <strong style="color:#AB5B14;" >* Special Add-ons to this date: </strong>
                                        <small style="color:#900; font-weight:600">( Additional cost added for this add-ons )</small>
                                        <ul style=" list-style-type:circle; ">
                                        <?php foreach($addi_cost_name as $acnam)
										{ ?>
                                        <li style="font-weight:500"><?php echo $acnam; ?></li>
                                        <?php }?>
                                        </ul>
                                        </div>
                                        <?php } 
										?>
                                   </td></tr>
                                   <tr><td colspan="3"><hr style="margin-top: 10px;margin-bottom: 10px;"></td></tr>
										<?php }
										 
										$trv_cnt_1--;
									$totalRows_trv--;
									//$row_count--;
									?>
                                    <?php
									 } ?>
                    
                    </table>
 </td></tr>
 
 <!-- suggested hotel option start -->
 <tr id="mouse_move_div" onMouseMove="func_onblur()"><td>
 <?php 
$plan_id=$_GET['planid'];
 

$resume = $conn->prepare("SELECT * FROM travel_master where plan_id=? and status='5'");
$resume->execute(array($_GET['planid']));
$row_resume =$resume->fetch(PDO::FETCH_ASSOC);
$totalRows_resume = $resume->rowCount();

$transport_only=$row_resume['tr_net_amt'];
$agent_perc=$row_resume['agent_perc'];
$admin_perc=$row_resume['agnt_adm_perc'];


$retrav = $conn->prepare("SELECT * FROM travel_sched where travel_id=? ORDER BY sno ASC");
$retrav->execute(array($plan_id));
//$row_retrav = mysql_fetch_assoc($retrav);
$row_retrav_main=$retrav->fetchAll();
$totalRows_retrav = $retrav->rowCount();

$t=0;
$ccid='';
$ccid_names='';
foreach($row_retrav_main as $row_retrav)
{
	if($t!=$totalRows_retrav-1)
	{
		
		$cid = $conn->prepare("SELECT * FROM dvi_cities where name=?");
		$cid->execute(array($row_retrav['tr_to_cityid']));
		$row_cid = $cid->fetch(PDO::FETCH_ASSOC);
		$totalRows_cid = $cid->rowCount();
		
		if($ccid=='')
		{
			$ccid=$row_cid['id'];
			$ccid_names=$row_cid['name'];
		}else
		{
			$ccid=$ccid.','.$row_cid['id'];
			$ccid_names=$ccid_names.','.$row_cid['name'];
		}
	}
	$t++;
}

$timezone = new DateTimeZone("Asia/Kolkata" );
  $date = new DateTime();
  $date->setTimezone($timezone );
  $mm=$date->format('m');
  $mm1=$date->format('M');
  $yy=$date->format('Y');
  $dd=$date->format('d');
  $time=date("H:i:s");
  $ttoday=$date->format('Y-m-d');
  
$stdate=$row_resume['tr_arr_date'];  
//$stay_cnt=$_GET['stay_cntt'];  
$cities_arr=explode(',',$ccid);
$troom=trim($row_resume['stay_rooms']);
$tot_fpax=(int)$row_resume['pax_adults']+(int)$row_resume['pax_512child'];
$tot_pax=trim($row_resume['pax_cnt']);
$extbed=array();
$food_catd="";
$choose_food='Breakfast';
if(!empty($row_resume['room_info']))
{
	$room_info_arr=explode('/',$row_resume['room_info']);

$food_catd=$room_info_arr[4];

$exbd=$room_info_arr[3];
$extbed=explode(',',$exbd);
}

//print_r($cities_arr);

	$hot_cag=$conn->prepare("select category from hotel_pro where status='0' GROUP BY category");
	$hot_cag->execute();
	//$row_hot_cag = mysql_fetch_assoc($hot_cag);
	$row_hot_cag_main=$hot_cag->fetchAll();
	$tot_hot_cag=$hot_cag->rowCount();

$cg=1;$hide5star=0;
foreach($row_hot_cag_main as $row_hot_cag)
{
	if($row_hot_cag['category']!='HOUSEBOAT')
	{
		$categ=str_replace(' ', '', $row_hot_cag['category']);
		$total_amount=0;
	?>
    <table  id="div_catg_<?php echo $categ; ?>">
    <tr><td colspan="6" style="text-align:center ;color: #B16505; font-family:Calibri; font-size: 14px; font-weight: 600;"><?php echo "Option - ".$cg." : ".$row_hot_cag['category']." Hotels"; ?></td></tr>
    <tr><td colspan="6">
    <center>
        <table class="f_weight" border="1" style="width:100%; border-collapse: collapse" >
        <tr class="f_weight"><th style="font-family:Calibri; font-size:14px"> &nbsp;S.No</th>
        <th  class="f_weight" style="font-family:Calibri; font-size:14px"> &nbsp;Date</th>
        <th  class="f_weight" style="font-family:Calibri; font-size:14px"> &nbsp;Place</th>
        <th  class="f_weight" style="font-family:Calibri; font-size:14px"> &nbsp;Hotel</th>
        <th  class="f_weight" style="font-family:Calibri; font-size:14px"> &nbsp;Room Category </th>
        <th  class="f_weight" style="font-family:Calibri; font-size:14px"> &nbsp;T Nights</th></tr>
        <?php for($ct=0;$ct<count($cities_arr);$ct++)
        {?>
            <tr ><td class="f_weight" style="font-family:Calibri; font-size:12px; padding:6px;"><?php echo $ct+1; ?></td>
            <td class="f_weight" style="font-family:Calibri; font-size:12px; padding:6px;"><?php
                echo date("d-M-Y",strtotime($stdate));
                $stay_date=date("Y-m-d",strtotime($stdate));
            ?>
 <input type="hidden" value="<?php echo $stay_date; ?>" name="<?php echo 'sdate_'.$categ.'_'.$ct; ?>" id="<?php echo 'sdate_'.$categ.'_'.$ct; ?>"  />
            </td>
            <td class="f_weight" style="font-family:Calibri; font-size:12px; padding:6px;"><?php
                $hot_city=$conn->prepare("select * from dvi_cities where status='0' and id=?");
                $hot_city->execute(array($cities_arr[$ct]));
                $row_hot_city = $hot_city->fetch(PDO::FETCH_ASSOC);
                echo $row_hot_city['name']; 
            ?>
        <input type="hidden" value="<?php echo $cities_arr[$ct]; ?>" name="<?php echo 'cyid_'.$categ.'_'.$ct; ?>" id="<?php echo 'cyid_'.$categ.'_'.$ct; ?>"  />
            </td>
            <td class="f_weight" style="font-family:Calibri; font-size:12px; padding:6px;"><?php
            $check='-';
                $tdate=date("Y-m-d",strtotime($stdate));
                $season=$conn->prepare("SELECT * FROM setting_season WHERE lock_sts != '1' and ('$tdate' BETWEEN from_date AND to_date)");
                $season->execute();
                $row_season = $season->fetch(PDO::FETCH_ASSOC);
                $tot_season= $season->rowCount();
            
            if($tot_season>0)
            {
                // $sel_hotel="select * from hotel_pro where status='0' and (category='House Boat' or category='".$row_hot_cag['category']."') and city='".$cities_arr[$ct]."' and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock) ORDER BY hotel_prior ASC ";
                $hotel=$conn->prepare("select * from hotel_pro where status='0' and  category=? and city=? and (? NOT BETWEEN hotel_slock AND hotel_elock) ORDER BY hotel_prior ASC");
                $hotel->execute(array($row_hot_cag['category'],$cities_arr[$ct],$tdate));
                $row_hotel =$hotel->fetch(PDO::FETCH_ASSOC);
                $tot_hotel= $hotel->rowCount();
                
                $ses_id=$row_season['sno'];
                if($tot_hotel>0)
                {
                echo $row_hotel['hotel_name'];
                
                   /* $sel_hotel_edit="select * from hotel_pro where status='0' and category='HOUSEBOAT' and city='".$cities_arr[$ct]."' and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock)";
                    
                    $hotel_edit = mysql_query($sel_hotel_edit, $divdb) or die(mysql_error());
                    //$row_hotel_edit = mysql_fetch_assoc($hotel_edit);
                    $tot_hotel_edit= mysql_num_rows($hotel_edit);
                    
                    if($tot_hotel_edit>0)
                    {
                        ?>
                        <select class="form-control chosen-select" onchange="houseboat_editable(this.value,'<?php echo $categ; ?>','<?php echo $ct; ?>')">
                            <option selected="selected" value="<?php echo $row_hotel['hotel_id']; ?>"><?php echo $row_hotel['hotel_name'];?></option>
                            <?php
                            while($row_hotel_edit = mysql_fetch_assoc($hotel_edit))
                            {?>
                                <option value="<?php echo $row_hotel_edit['hotel_id']; ?>"><?php echo $row_hotel_edit['hotel_name']; ?></option>
                            <?php } ?>
                        </select>
                         <?php
                    }else{
                        echo $row_hotel['hotel_name'];
                    }*/
                
                /*	if($row_hotel['category']=='House Boat')
                    {
                        echo "HOUSE";
                        echo $tot_fpax;
                        $check='HB';
                    }*/
                
                $hotl_id=$row_hotel['hotel_id'];
                
                $hfood=$conn->prepare("select * from hotel_food where status='0' and hotel_id=?");
                $hfood->execute(array($row_hotel['hotel_id']));
                $row_hfood =$hfood->fetch(PDO::FETCH_ASSOC);
                
                                        $ss=$ses_id+1;
                                        $lunchrate_arr=decode_unserialize($row_hfood['lunch_rate']);
									//print_r($lunchrate_arr);
									if(isset($lunchrate_arr[$ss-1]))
									$lunchrate=$lunchrate_arr[$ss-1];
									else
									$lunchrate=$lunchrate_arr[0];
									
									$dinnerrate_arr=decode_unserialize($row_hfood['dinner_rate']);
									if(isset($dinnerrate_arr[$ss-1]))
									$dinnerrate=$dinnerrate_arr[$ss-1];
									else
									$dinnerrate=$dinnerrate_arr[0];
									
									$chwithbed_arr=decode_unserialize($row_hfood['child_with_bed']);
										if(isset($chwithbed_arr[$ss-1]))
									$chwithbedrate=$chwithbed_arr[$ss-1];
									else
									$chwithbedrate=$chwithbed_arr[0];
									
									$chwithoutbed_arr=decode_unserialize($row_hfood['child_without_bed']);
										if(isset($chwithoutbed_arr[$ss-1]))
									$chwithoutbedrate=$chwithoutbed_arr[$ss-1];
									else
									$chwithoutbedrate=$chwithoutbed_arr[0];
									
									$flowerbed_arr=decode_unserialize($row_hfood['flower_bed']);
										if(isset($flowerbed_arr[$ss-1]))
									$flowerbedrate=$flowerbed_arr[$ss-1];
									else
									$flowerbedrate=$flowerbed_arr[0];
									
									$candle_arr=decode_unserialize($row_hfood['candle_light']);
										if(isset($candle_arr[$ss-1]))
									$candlerate=$candle_arr[$ss-1];
									else
									$candlerate=$candle_arr[0];
									
									$cake_arr=decode_unserialize($row_hfood['cake_rate']);
										if(isset($cake_arr[$ss-1]))
									$cakerate=$cake_arr[$ss-1];
									else
									$cakerate=$cake_arr[0];
									
									$fruit_arr=decode_unserialize($row_hfood['fruit_basket']);
										if(isset($fruit_arr[$ss-1]))
									$fruitrate=$fruit_arr[$ss-1];
									else
									$fruitrate=$fruit_arr[0];
                                        ?>
    <input type="hidden" value="<?php echo $chwithbedrate; ?>" name="<?php echo 'chwithbed_'.$categ.'_'.$ct; ?>" id="<?php echo 'chwithbed_'.$categ.'_'.$ct; ?>"/>
    <input type="hidden" value="<?php echo $chwithoutbedrate; ?>" name="<?php echo 'chwithoutbed_'.$categ.'_'.$ct; ?>" id="<?php echo 'chwithoutbed_'.$categ.'_'.$ct; ?>"/>
    
    <input type="hidden" value="<?php echo $dinnerrate; ?>" name="<?php echo 'dinnerrate_'.$categ.'_'.$ct; ?>" id="<?php echo 'dinnerrate_'.$categ.'_'.$ct; ?>"/>
    <input type="hidden" value="<?php echo $lunchrate; ?>" name="<?php echo 'lunchrate_'.$categ.'_'.$ct; ?>" id="<?php echo 'lunchrate_'.$categ.'_'.$ct; ?>"/>
                                        <?php
                                        if($food_catd=='lunch_rate')
                                        {
                                            $total_amount=$total_amount+($lunchrate*$tot_fpax);
                                            $choose_food="Breakfast & Lunch";
                                        }else if($food_catd=='dinner_rate')
                                        {
                                            $total_amount=$total_amount+($dinnerrate*$tot_fpax);
                                            $choose_food="Breakfast & Dinner";
                                        }else if($food_catd=='both_food')
                                        {
                                            $boths=$dinnerrate+$lunchrate;
                                            $total_amount=$total_amount+($boths*$tot_fpax);
                                            $choose_food="Breakfast, Lunch & Dinner";
                                        }else{
                                        $choose_food='Breakfast';	
                                        }
                                        
                                        $ext_bed='';
                                        //if($check!='HB')//extra bed calc to only without house boating/ because extra bed calculated below - room category
                                        //{
                                        for($e=0;$e<count($extbed);$e++)
                                        {
                                            if($extbed[$e]=='0'){
                                                $total_amount=$total_amount+$chwithbedrate;
                                                //echo "f".$check;
                                            }else if($extbed[$e]=='1'){
                                                $total_amount=$total_amount+$chwithoutbedrate;
                                            }
                                        }
                                        //}
                }else if(trim($row_hot_cag['category'])!='5 Star' && trim($row_hot_cag['category'])!='5STAR' && trim($row_hot_cag['category'])!='5star'){// if unavailable hotel for particular hotel_categories - without 5 star category
                $hotel1=$conn->prepare("select * from hotel_pro where status='0' and city=? and (? NOT BETWEEN hotel_slock AND hotel_elock)  ORDER BY hotel_prior ASC ");
                $hotel1->execute(array($cities_arr[$ct],$tdate));
                $row_hotel1 =$hotel1->fetch(PDO::FETCH_ASSOC);
                $tot_hotel1= $hotel1->rowCount();
                
                echo $row_hotel1['hotel_name']." ( ".$row_hotel1['category']." )";
                $hotl_id=$row_hotel1['hotel_id'];
                
                $hfood=$conn->prepare("select * from hotel_food where status='0' and hotel_id=?");
                $hfood->execute(array($row_hotel1['hotel_id']));
                $row_hfood = $hfood->fetch(PDO::FETCH_ASSOC);
                if(isset($lunchrate_arr)){
                                        $ss=$ses_id+1;
                                        $lunchrate_arr=decode_unserialize($row_hfood['lunch_rate']);
									//print_r($lunchrate_arr);
									if(isset($lunchrate_arr[$ss-1]))
									$lunchrate=$lunchrate_arr[$ss-1];
									else
									$lunchrate=$lunchrate_arr[0];
									
									$dinnerrate_arr=decode_unserialize($row_hfood['dinner_rate']);
									if(isset($dinnerrate_arr[$ss-1]))
									$dinnerrate=$dinnerrate_arr[$ss-1];
									else
									$dinnerrate=$dinnerrate_arr[0];
									
									$chwithbed_arr=decode_unserialize($row_hfood['child_with_bed']);
										if(isset($chwithbed_arr[$ss-1]))
									$chwithbedrate=$chwithbed_arr[$ss-1];
									else
									$chwithbedrate=$chwithbed_arr[0];
									
									$chwithoutbed_arr=decode_unserialize($row_hfood['child_without_bed']);
										if(isset($chwithoutbed_arr[$ss-1]))
									$chwithoutbedrate=$chwithoutbed_arr[$ss-1];
									else
									$chwithoutbedrate=$chwithoutbed_arr[0];
									
									$flowerbed_arr=decode_unserialize($row_hfood['flower_bed']);
										if(isset($flowerbed_arr[$ss-1]))
									$flowerbedrate=$flowerbed_arr[$ss-1];
									else
									$flowerbedrate=$flowerbed_arr[0];
									
									$candle_arr=decode_unserialize($row_hfood['candle_light']);
										if(isset($candle_arr[$ss-1]))
									$candlerate=$candle_arr[$ss-1];
									else
									$candlerate=$candle_arr[0];
									
									$cake_arr=decode_unserialize($row_hfood['cake_rate']);
										if(isset($cake_arr[$ss-1]))
									$cakerate=$cake_arr[$ss-1];
									else
									$cakerate=$cake_arr[0];
									
									$fruit_arr=decode_unserialize($row_hfood['fruit_basket']);
										if(isset($fruit_arr[$ss-1]))
									$fruitrate=$fruit_arr[$ss-1];
									else
									$fruitrate=$fruit_arr[0];
				}
                                        ?>
    <input type="hidden" value="<?php echo $chwithbedrate; ?>" name="<?php echo 'chwithbed_'.$categ.'_'.$ct; ?>" id="<?php echo 'chwithbed_'.$categ.'_'.$ct; ?>"/>
    <input type="hidden" value="<?php echo $chwithoutbedrate; ?>" name="<?php echo 'chwithoutbed_'.$categ.'_'.$ct; ?>" id="<?php echo 'chwithoutbed_'.$categ.'_'.$ct; ?>"/>
    
    <input type="hidden" value="<?php echo $dinnerrate; ?>" name="<?php echo 'dinnerrate_'.$categ.'_'.$ct; ?>" id="<?php echo 'dinnerrate_'.$categ.'_'.$ct; ?>"/>
    <input type="hidden" value="<?php echo $lunchrate; ?>" name="<?php echo 'lunchrate_'.$categ.'_'.$ct; ?>" id="<?php echo 'lunchrate_'.$categ.'_'.$ct; ?>"/>
                                        <?php
                                        if($food_catd=='lunch_rate')
                                        {
                                            $total_amount=$total_amount+($lunchrate*$tot_fpax);
                                            $choose_food="Breakfast & Lunch";
                                        }else if($food_catd=='dinner_rate')
                                        {
                                            $total_amount=$total_amount+($dinnerrate*$tot_fpax);
                                            $choose_food="Breakfast & Dinner";
                                        }else if($food_catd=='both_food')
                                        {
                                            $boths=$dinnerrate+$lunchrate;
                                            $total_amount=$total_amount+($boths*$tot_fpax);
                                            $choose_food="Breakfast, Lunch & Dinner";
                                        }else if($food_catd=='no'){
                                        $choose_food='Breakfast';	
                                        }
                                        
                                        $ext_bed='';
                                        for($e=0;$e<count($extbed);$e++)
                                        {
                                            if($extbed[$e]=='0'){
                                                $total_amount=$total_amount+$chwithbedrate;
                                            }else if($extbed[$e]=='1'){
                                                $total_amount=$total_amount+$chwithoutbedrate;
                                            }
                                        }
                }else{
                    echo "-";
                    $hotl_id='-';
                }
                
            }else{
                echo " Locked ";	//season lock
                $hotl_id='-';
            }
            
            if(trim($row_hot_cag['category'])=='5 Star' || trim($row_hot_cag['category'])=='5STAR' || trim($row_hot_cag['category'])=='5star')
            {
                if($hotl_id=='-' && $hide5star==0)
                {?>
                        <input type="text" value="<?php echo $categ; ?>" id="hide_5star" name="hide_5star" />
                <?php 
                $hide5star++;
                $cg--;
                }
            }
            ?>
    <input type="hidden" value="<?php echo $hotl_id; ?>" name="<?php echo 'hid_'.$categ.'_'.$ct; ?>" id="<?php echo 'hid_'.$categ.'_'.$ct; ?>"  />
    
            </td>
            <td class="f_weight" style="font-family:Calibri; font-size:12px; padding:6px;"><?php
                if($hotl_id != '-')
                {
                    if($check=='HB')//HB means House Boating
                    {
                        //$tot_fpax=5;
                            $num_fpaxs=$tot_fpax;
                            if($num_fpaxs==2)
                            {
                                $hrooom=$conn->prepare("select * from hotel_season where status='0' and hotel_id=? and room_type='01 Bed Room - Premium' and season_sno = ?  ORDER by season_rate ASC");
								$hrooom->execute(array($hotl_id,$ses_id));
                                $row_hrooom = $hrooom->fetch(PDO::FETCH_ASSOC);
                                $tot_hrooom= $hrooom->rowCount();
                                        //echo $row_hrooom['room_type'].'- With extra bed';
                                        echo $row_hrooom['room_type'];
                                        $room_sno=$row_hrooom['sno'];
                                        $room_rent=$row_hrooom['season_rate'];
                                        $total_amount=$total_amount+($room_rent);
                                        //echo "01 Bed Room - Premium";
                                
                            }else if($num_fpaxs==3)
                            {
                                $hrooom=$conn->prepare("select * from hotel_season where status='0' and hotel_id=? and room_type='01 Bed Room - Premium' and season_sno = ?  ORDER by season_rate ASC");
								$hrooom->execute(array($hotl_id,$ses_id));
                                $row_hrooom = $hrooom->fetch(PDO::FETCH_ASSOC);
                                $tot_hrooom= $hrooom->rowCount();
                                        echo $row_hrooom['room_type'].'- With extra bed';
                                        $room_sno=$row_hrooom['sno'];
                                        $room_rent=$row_hrooom['season_rate'];
                                        echo "LOLO=".$total_amount;
                                        echo "BT=".$total_amount=$total_amount+$room_rent;
                                    echo "chbed=".$chwithbedrate;
                                    echo "TTT".$room_rent=$room_rent+$chwithbedrate;
                                    echo "AT=".$total_amount=$total_amount+$chwithbedrate;//for one extra bed
                                                                        
                                //echo "01 Bed Room - Premium+ extra bed";
                            }else if($num_fpaxs>=4)
                            {
                                 $no_rrs=floor($num_fpaxs / 2);
                                 $tempMod = (float)($num_fpaxs / 2);
                                 $tempMod = ($tempMod - (int)$tempMod)*2;
                                
                                $hrooom=$conn->prepare("select * from hotel_season where status='0' and hotel_id=? and room_type='01 Bed Room - Premium' and season_sno = ?  ORDER by season_rate ASC");
								$hrooom->execute(array($hotl_id,$ses_id));
                                $row_hrooom = $hrooom->fetch(PDO::FETCH_ASSOC);
                                $tot_hrooom= $hrooom->rowCount();
                                        //echo $row_hrooom['room_type'].'- With extra bed';
                                        $room_sno=$row_hrooom['sno'];
                                        $room_rent=$row_hrooom['season_rate'];
                                        $total_amount=$total_amount+($room_rent*$no_rrs);
                                        $rom_rent_tt=$room_rent*$no_rrs;
                                        //to input below
                                        $room_rent=$rom_rent_tt;
                                        
                                echo $no_rrs."-02 Bed Room - Premium";
                                if($tempMod==1)
                                {
                                echo "+one extra bed";	
                                $room_rent=$room_rent+$chwithbedrate;
                                $total_amount=$total_amount+$chwithbedrate;
                                }
                                
                            }
                    }else{
                        $hrooom=$conn->prepare("select * from hotel_season where status='0' and hotel_id=? and room_type='01 Bed Room - Premium' and season_sno = ?  ORDER by season_rate ASC");
						$hrooom->execute(array($hotl_id,$ses_id));
                        $row_hrooom = $hrooom->fetch(PDO::FETCH_ASSOC);
                        $tot_hrooom= $hrooom->rowCount();
                        echo $row_hrooom['room_type'];
                        $room_sno=$row_hrooom['sno'];
                        $room_rent=$row_hrooom['season_rate'];
                        $total_amount=$total_amount+($room_rent*$troom);
                    }
                }else{
                    echo " - ";	
                    $room_sno='-';
                    $room_rent='-';
                }
            ?>
            <input type="hidden" value="<?php echo $room_sno; ?>" name="<?php echo 'rmid_'.$categ.'_'.$ct; ?>" id="<?php echo 'rmid_'.$categ.'_'.$ct; ?>"  />
            <input type="hidden" value="<?php echo $room_rent; ?>" name="<?php echo 'rent_'.$categ.'_'.$ct; ?>" id="<?php echo 'rent_'.$categ.'_'.$ct; ?>"  />
            </td>
            <td class="f_weight" style="font-family:Calibri; font-size:12px; padding:6px;"><?php echo "1"; ?></td></tr>
        <?php
                $date=date_create($stdate);
                date_add($date,date_interval_create_from_date_string("1 days"));
                $stdate= date_format($date,"d-M-Y");
        //echo $hotl_id."-".$total_amount;
         }//for end?>
        </table>
    </center>
    </td></tr>
    <tr><td colspan="6">
    <table width="100%"><tr><td width="48%" class="f_weight" style="font-family:Calibri; font-size:12px; padding:6px;">
    <?php //echo "No. of Rooms - ".$troom." ( Pax : ".$tot_pax." )";
	echo "[ No. of Rooms - ".$troom." ] ";
								
								$rrom=$extbed;
	$rrom1=array_unique($rrom);
	//print_r($rrom1);
	$rrom1=array_values($rrom1);
	$rrom2=array_count_values($rrom);
	//print_r($rrom2);
	
	for($tt=0;$tt<count($rrom1);$tt++)
	{
		if(isset($rrom1[$tt+1]) && $rrom1[$tt+1] !='' && $rrom1[$tt+1] !='-')
		{
			if($rrom1[$tt]=='0')
			{
				$rg="With Extra Bed";
			}else if($rrom1[$tt]=='1'){
				$rg="Without Extra Bed";
			}
			if($rrom1[$tt]!='-')
			{
			echo "&nbsp; ".$rrom2[$rrom1[$tt]]."-".$rg.",&nbsp;"; 
			}
		}else
		{
			if($rrom1[$tt]=='0')
			{
				$rg="With Extra Bed";
			}else if($rrom1[$tt]=='1'){
				$rg="Without Extra Bed";
			}
			if($rrom1[$tt]!='-')
			{
			echo "&nbsp; ".$rrom2[$rrom1[$tt]]."-".$rg; 
			}
		}
	}

	?>
    </td><td width="2%"></td><td width="50%" class="f_weight" style="font-family:Calibri; font-size:12px; padding:6px;" align="right">
     <?php 
	//echo "hotel only ".$total_amount;
	//echo "<br>trans".$transport_only; 
	$itin_amt=($total_amount+$transport_only);
	//echo "AGENT =".$agent_perc;
	//echo "ADMIN =".$admin_perc;
	$agnt_itin_amt=$itin_amt+($itin_amt*($agent_perc/100));
	$admin_itin_amt=$agnt_itin_amt+($agnt_itin_amt*($admin_perc/100));

	?>
    [ including <?php echo $choose_food; ?> ]
    </td></tr>
    <tr><td colspan="3" align="center">
    	<strong style="color:#F00; font-family:Calibri; font-size:14px;">Overall Itinerary Cost : <?php echo convert_currency_text("RS")." ".number_format(convert_currency(round($admin_itin_amt)))."/- Only";?> </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="check_class" type="checkbox" name="chbox_<?php echo $categ; ?>" id="chbox_<?php echo $categ; ?>" checked value="<?php echo $categ; ?>">
       </td></tr></table>
    </td></tr>
    <tr><td colspan="6">  <hr style="margin-top:10px; margin-bottom:10px;" /></td></tr>
    </table>
<?php 
$cg++;
$stdate=$row_resume['tr_arr_date'];
	}//if for house boat
}//while end
//combination of 2star and 3 star hotels

//combination of HOUSEBOAT hotels
$check_city=explode(',',$ccid);//to find houseboating is available in any cities
$house_avail='no';
for($hh=0;$hh<count($check_city);$hh++)
{
	$hotel_avail=$conn->prepare("select * from hotel_pro where status='0' and category='HOUSEBOAT' and city=? and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock)  ORDER BY hotel_prior ASC ");
	$hotel_avail->execute(array($check_city[$hh]));
	$row_hotel_avail = $hotel_avail->fetch(PDO::FETCH_ASSOC);
	$tot_hotel_avail= $hotel_avail->rowCount();
			if($tot_hotel_avail>0)
			{
				$house_avail='yes';
			}
}
//echo "HOU AVA=".$house_avail;

if($house_avail=='yes')
{
$check='-';
$categ="HOUSEBOAT"; 
$total_amount=0;
$same_city=0;
?>
	<table id="div_catg_<?php echo $categ; ?>">
    <tr>
  	<td colspan="6" style="text-align:center ;color: #B16505; font-family:Calibri; font-size: 14px; font-weight: 600;">
    <?php echo "Option - ".$cg." : "."HOUSE BOAT"; $cg++;?>
    </td>
    </tr>
	<tr><td class="6">  
    <center>
    <table  border="1" style="border-collapse:collapse" width="100%">
    <tr><th style=" font-family:Calibri; font-size: 14px; font-weight: 600;" > &nbsp;S.No</th>
    <th style=" font-family:Calibri; font-size: 14px; font-weight: 600;"> &nbsp;Date</th>
    <th style=" font-family:Calibri; font-size: 14px; font-weight: 600;"> &nbsp;Place</th>
    <th style=" font-family:Calibri; font-size: 14px; font-weight: 600;"> &nbsp;Hotel</th>
    <th style=" font-family:Calibri; font-size: 14px; font-weight: 600;"> &nbsp;Room Category </th>
    <th style="font-family:Calibri; font-size: 14px; font-weight: 600;"> &nbsp;T Nights</th></tr>
    <?php 
	$flag=0;
	for($ct=0;$ct<count($cities_arr);$ct++)
	{
		$check='-';
		?>
		<tr ><td class="f_weight" style=" font-family:Calibri; font-size: 12px;padding:6px;"><?php echo $ct+1; ?></td>
        <td  class="f_weight" style=" font-family:Calibri; font-size: 12px; padding:6px;"><?php
			echo date("d-M-Y",strtotime($stdate)); 
			$stay_date=date("Y-m-d",strtotime($stdate));
		?>
        <input type="hidden" value="<?php echo $stay_date; ?>" name="<?php echo 'sdate_'.$categ.'_'.$ct; ?>" id="<?php echo 'sdate_'.$categ.'_'.$ct; ?>"  />
        </td>
        <td class="f_weight" style=" font-family:Calibri; font-size: 12px; padding:6px;"><?php
			$hot_city=$conn->prepare("select * from dvi_cities where status='0' and id=?");
            $hot_city->execute(array($cities_arr[$ct]));
            $row_hot_city = $hot_city->fetch(PDO::FETCH_ASSOC);
		 	echo $row_hot_city['name']; 
		?>
      <input type="hidden" value="<?php echo $cities_arr[$ct]; ?>" name="<?php echo 'cyid_'.$categ.'_'.$ct; ?>" id="<?php echo 'cyid_'.$categ.'_'.$ct; ?>"/>
        </td>
        <td class="f_weight" style=" font-family:Calibri; font-size: 12px; padding:6px;"><?php
			$tdate=date("Y-m-d",strtotime($stdate));
			$season=$conn->prepare("SELECT * FROM setting_season WHERE lock_sts != '1' and ('$tdate' BETWEEN from_date AND to_date)");
			$season->execute();
			$row_season = $season->fetch(PDO::FETCH_ASSOC);
			$tot_season= $season->rowCount();
			$ses_id=$row_season['sno'];
		if($tot_season>0)
		{
			if($flag==0)
			{
			$hotel1=$conn->prepare("select * from hotel_pro where status='0' and city=? and (? NOT BETWEEN hotel_slock AND hotel_elock)  ORDER BY hotel_prior ASC ");
                $hotel1->execute(array($cities_arr[$ct],$tdate));
                $row_hotel1 =$hotel1->fetch(PDO::FETCH_ASSOC);
                $tot_hotel1= $hotel1->rowCount();
			
			}else{//this is for next day having same city - choose hotel - not houseboat
				
			$hotel1=$conn->prepare("select * from hotel_pro where status='0' and city=? and (? NOT BETWEEN hotel_slock AND hotel_elock)  ORDER BY hotel_prior ASC ");
                $hotel1->execute(array($cities_arr[$ct],$tdate));
                $row_hotel1 =$hotel1->fetch(PDO::FETCH_ASSOC);
                $tot_hotel1= $hotel1->rowCount();
			
			}
			
					if(isset($cities_arr[$ct+1]) && $cities_arr[$ct+1]==$cities_arr[$ct])//for next day having same city
					{
						$flag=1;//same
					}else
					{
						$flag=0;
					}
					
			if($tot_hotel>0)
			{
				
				if($row_hotel['category']=='HOUSEBOAT')
				{
					//echo "HOUSE";
					//echo $tot_fpax;
					$check='HB';
				}
			echo $row_hotel['hotel_name']." ( ".$row_hotel['category']." )";
			$hotl_id=$row_hotel['hotel_id'];
			
			    $hfood=$conn->prepare("select * from hotel_food where status='0' and hotel_id=?");
                $hfood->execute(array($row_hotel1['hotel_id']));
                $row_hfood = $hfood->fetch(PDO::FETCH_ASSOC);
			
									$ss=$ses_id+1;
									$lunchrate_arr=decode_unserialize($row_hfood['lunch_rate']);
									//print_r($lunchrate_arr);
									if(isset($lunchrate_arr[$ss-1]))
									$lunchrate=$lunchrate_arr[$ss-1];
									else
									$lunchrate=$lunchrate_arr[0];
									
									$dinnerrate_arr=decode_unserialize($row_hfood['dinner_rate']);
									if(isset($dinnerrate_arr[$ss-1]))
									$dinnerrate=$dinnerrate_arr[$ss-1];
									else
									$dinnerrate=$dinnerrate_arr[0];
									
									$chwithbed_arr=decode_unserialize($row_hfood['child_with_bed']);
										if(isset($chwithbed_arr[$ss-1]))
									$chwithbedrate=$chwithbed_arr[$ss-1];
									else
									$chwithbedrate=$chwithbed_arr[0];
									
									$chwithoutbed_arr=decode_unserialize($row_hfood['child_without_bed']);
										if(isset($chwithoutbed_arr[$ss-1]))
									$chwithoutbedrate=$chwithoutbed_arr[$ss-1];
									else
									$chwithoutbedrate=$chwithoutbed_arr[0];
									
									$flowerbed_arr=decode_unserialize($row_hfood['flower_bed']);
										if(isset($flowerbed_arr[$ss-1]))
									$flowerbedrate=$flowerbed_arr[$ss-1];
									else
									$flowerbedrate=$flowerbed_arr[0];
									
									$candle_arr=decode_unserialize($row_hfood['candle_light']);
										if(isset($candle_arr[$ss-1]))
									$candlerate=$candle_arr[$ss-1];
									else
									$candlerate=$candle_arr[0];
									
									$cake_arr=decode_unserialize($row_hfood['cake_rate']);
										if(isset($cake_arr[$ss-1]))
									$cakerate=$cake_arr[$ss-1];
									else
									$cakerate=$cake_arr[0];
									
									$fruit_arr=decode_unserialize($row_hfood['fruit_basket']);
										if(isset($fruit_arr[$ss-1]))
									$fruitrate=$fruit_arr[$ss-1];
									else
									$fruitrate=$fruit_arr[0];
									?>
<input type="hidden" value="<?php echo $chwithbedrate; ?>" name="<?php echo 'chwithbed_'.$categ.'_'.$ct; ?>" id="<?php echo 'chwithbed_'.$categ.'_'.$ct; ?>"/>
<input type="hidden" value="<?php echo $chwithoutbedrate; ?>" name="<?php echo 'chwithoutbed_'.$categ.'_'.$ct; ?>" id="<?php echo 'chwithoutbed_'.$categ.'_'.$ct; ?>"/>

<input type="hidden" value="<?php echo $dinnerrate; ?>" name="<?php echo 'dinnerrate_'.$categ.'_'.$ct; ?>" id="<?php echo 'dinnerrate_'.$categ.'_'.$ct; ?>"/>
<input type="hidden" value="<?php echo $lunchrate; ?>" name="<?php echo 'lunchrate_'.$categ.'_'.$ct; ?>" id="<?php echo 'lunchrate_'.$categ.'_'.$ct; ?>"/>
                                    <?php
									if($food_catd=='lunch_rate')
									{
										$total_amount=$total_amount+($lunchrate*$tot_fpax);
										$choose_food="Breakfast & Lunch";
									}else if($food_catd=='dinner_rate')
									{
										$total_amount=$total_amount+($dinnerrate*$tot_fpax);
										$choose_food="Breakfast & Dinner";
									}else if($food_catd=='both_food')
									{
										$boths=$dinnerrate+$lunchrate;
										$total_amount=$total_amount+($boths*$tot_fpax);
										$choose_food="Breakfast, Lunch & Dinner";
									}else{
									$choose_food='Breakfast';	
									}
									
									$ext_bed='';
									if($check!='HB')//extra bed calc to only without house boating/ because extra bed calculated below - room category
									{
									for($e=0;$e<count($extbed);$e++)
									{
										if($extbed[$e]=='0'){
											$total_amount=$total_amount+$chwithbedrate;
										}else if($extbed[$e]=='1'){
											$total_amount=$total_amount+$chwithoutbedrate;
										}
									}
									}
				
			}else{ //if the hotels unavailable in HouseBoating pick any hotel from any category by priority
			$hotel2=$conn->prepare("select * from hotel_pro where status='0' and city=? and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock) ORDER BY hotel_prior ASC ");
			$hotel2->execute(array($cities_arr[$ct]));
			$row_hotel2 =$hotel2->fetch(PDO::FETCH_ASSOC);
			$tot_hotel2= $hotel2->rowCount();
			
			echo $row_hotel2['hotel_name']." ( ".$row_hotel2['category']." )";
			$hotl_id=$row_hotel2['hotel_id'];
			
				$hfood=$conn->prepare("select * from hotel_food where status='0' and hotel_id=?");
                $hfood->execute(array($row_hotel2['hotel_id']));
                $row_hfood = $hfood->fetch(PDO::FETCH_ASSOC);
			
									$ss=$ses_id+1;
									$lunchrate_arr=decode_unserialize($row_hfood['lunch_rate']);
									//print_r($lunchrate_arr);
									if(isset($lunchrate_arr[$ss-1]))
									$lunchrate=$lunchrate_arr[$ss-1];
									else
									$lunchrate=$lunchrate_arr[0];
									
									$dinnerrate_arr=decode_unserialize($row_hfood['dinner_rate']);
									if(isset($dinnerrate_arr[$ss-1]))
									$dinnerrate=$dinnerrate_arr[$ss-1];
									else
									$dinnerrate=$dinnerrate_arr[0];
									
									$chwithbed_arr=decode_unserialize($row_hfood['child_with_bed']);
										if(isset($chwithbed_arr[$ss-1]))
									$chwithbedrate=$chwithbed_arr[$ss-1];
									else
									$chwithbedrate=$chwithbed_arr[0];
									
									$chwithoutbed_arr=decode_unserialize($row_hfood['child_without_bed']);
										if(isset($chwithoutbed_arr[$ss-1]))
									$chwithoutbedrate=$chwithoutbed_arr[$ss-1];
									else
									$chwithoutbedrate=$chwithoutbed_arr[0];
									
									$flowerbed_arr=decode_unserialize($row_hfood['flower_bed']);
										if(isset($flowerbed_arr[$ss-1]))
									$flowerbedrate=$flowerbed_arr[$ss-1];
									else
									$flowerbedrate=$flowerbed_arr[0];
									
									$candle_arr=decode_unserialize($row_hfood['candle_light']);
										if(isset($candle_arr[$ss-1]))
									$candlerate=$candle_arr[$ss-1];
									else
									$candlerate=$candle_arr[0];
									
									$cake_arr=decode_unserialize($row_hfood['cake_rate']);
										if(isset($cake_arr[$ss-1]))
									$cakerate=$cake_arr[$ss-1];
									else
									$cakerate=$cake_arr[0];
									
									$fruit_arr=decode_unserialize($row_hfood['fruit_basket']);
										if(isset($fruit_arr[$ss-1]))
									$fruitrate=$fruit_arr[$ss-1];
									else
									$fruitrate=$fruit_arr[0];
									?>
<input type="hidden" value="<?php echo $chwithbedrate; ?>" name="<?php echo 'chwithbed_'.$categ.'_'.$ct; ?>" id="<?php echo 'chwithbed_'.$categ.'_'.$ct; ?>"/>
<input type="hidden" value="<?php echo $chwithoutbedrate; ?>" name="<?php echo 'chwithoutbed_'.$categ.'_'.$ct; ?>" id="<?php echo 'chwithoutbed_'.$categ.'_'.$ct; ?>"/>

<input type="hidden" value="<?php echo $dinnerrate; ?>" name="<?php echo 'dinnerrate_'.$categ.'_'.$ct; ?>" id="<?php echo 'dinnerrate_'.$categ.'_'.$ct; ?>"/>
<input type="hidden" value="<?php echo $lunchrate; ?>" name="<?php echo 'lunchrate_'.$categ.'_'.$ct; ?>" id="<?php echo 'lunchrate_'.$categ.'_'.$ct; ?>"/>
                                    <?php
									if($food_catd=='lunch_rate')
									{
										$total_amount=$total_amount+($lunchrate*$tot_fpax);
										$choose_food="Breakfast & Lunch";
									}else if($food_catd=='dinner_rate')
									{
										$total_amount=$total_amount+($dinnerrate*$tot_fpax);
										$choose_food="Breakfast & Dinner";
									}else if($food_catd=='both_food')
									{
										$boths=$dinnerrate+$lunchrate;
										$total_amount=$total_amount+($boths*$tot_fpax);
										$choose_food="Breakfast, Lunch & Dinner";
									}else{
									$choose_food='Breakfast';	
									}
									
									$ext_bed='';
									if($check!='HB')//extra bed calc to only without house boating/ because extra bed calculated below - room category
									{
									for($e=0;$e<count($extbed);$e++)
									{
										if($extbed[$e]=='0'){
											$total_amount=$total_amount+$chwithbedrate;
										}else if($extbed[$e]=='1'){
											$total_amount=$total_amount+$chwithoutbedrate;
										}
									}
									}
			}
			
		}else{
			echo " Locked ";	//season lock
			$hotl_id='-';
		}
		?>
        <input type="hidden" value="<?php echo $hotl_id; ?>" name="<?php echo 'hid_'.$categ.'_'.$ct; ?>" id="<?php echo 'hid_'.$categ.'_'.$ct; ?>"  />
        </td>
        <td class="f_weight" style="font-family:Calibri; font-size: 12px; padding:6px;"><?php
			if($hotl_id != '-')
			{
				//echo $check;
				$bed_cn=1;
				if($check=='HB')
				{
					$dvn=0;
					$remd=0;
					$rm_sel_name1='-';
					$rm_sel_name2='-';
					$with_extra='-';
					$bet='';
						 $num_fpaxs=$tot_fpax;
						 
						 $dvn=floor($num_fpaxs/6);
						 $remd=floor($num_fpaxs%6);
						 
						 if($remd==0)
						 {
							// $rm_sel_name="  $dvn  - Trible";
							 	$rm_sel_name1='Three Cabin';
								$rm_sel_name2='-';
								$with_extra='';
						 }else if($remd==1)
						 {
							if($dvn==0)
							{
								//echo "single bed";
								$rm_sel_name1='One Cabin';
								$rm_sel_name2='-';
								$with_extra='';
								
							}else if($dvn>0)
							{
								$rm_sel_name1='Three Cabin';
								$rm_sel_name2='-';
								$with_extra='yes';
								//echo "$dvn - trible +1ext";	
							}
						 }else if($remd==2)
						 {
							if($dvn==0)
							{
								//$rm_sel_name="single bed";
								$rm_sel_name1='One Cabin';
								$rm_sel_name2='-';
								$with_extra='';
									
							}else if($dvn>=$remd){
								//$rm_sel_name=" $dvn  - Trible + $remd extrabed";
								$rm_sel_name1='Three Cabin';
								$rm_sel_name2='-';
								$with_extra='yes';
								$bed_cn=$remd;
							}else{
								//$rm_sel_name=" $dvn  - Trible + single bed";
								$rm_sel_name1='Three Cabin';
								$rm_sel_name2='One Cabin';
								$with_extra='';
							}
						 }
						 else if($remd==3)
						 {
							 if($dvn==0)
							 {
								// $rm_sel_name="single bed + extra";
								 $rm_sel_name1='One Cabin';
								 $rm_sel_name2='-';
								 $with_extra='yes';
							 }else if($dvn>=$remd)
							 {
								//$rm_sel_name=" $dvn  - Trible + $remd extrabed"; 
								$rm_sel_name1='Three Cabin';
								 $rm_sel_name2='-';
								 $with_extra='yes';
								 $bed_cn=$remd;
							 }else{
								 //$rm_sel_name="$dvn - Trible + single + extra";
								 $rm_sel_name1='Three Cabin';
								 $rm_sel_name2='One Cabin';
								 $with_extra='yes';
							 }
							
						 }else if($remd==4)
						 {
							 if($dvn==0)
							 {
								//$rm_sel_name="Double";
								 $rm_sel_name1='Two Cabin';
								 $rm_sel_name2='-';
								 $with_extra='';
							 }else 
							 {
								// $rm_sel_name=" $dvn  - Trible + Double"; 
								 $rm_sel_name1='Three Cabin';
								 $rm_sel_name2='Two Cabin';
								 $with_extra='';
							 }
							
						 }else if($remd==5)
						 {
							  if($dvn==0)
							  {
								//$rm_sel_name="Double + extra";  
								$rm_sel_name1='Two Cabin';
								 $rm_sel_name2='-';
								 $with_extra='yes';
							  }else{
								  //$rm_sel_name="$dvn  - Trible + Double + 1extra"; 
								 $rm_sel_name1='Three Cabin';
								 $rm_sel_name2='Two Cabin';
								 $with_extra='yes'; 
							  }
						 }
						 //logic 
						if($rm_sel_name1!='-')
						{
							
							$hrooom=$conn->prepare("select * from hotel_season where status='0' and hotel_id=? and room_type=? and season_sno = ? ORDER by season_rate ASC");
							$hrooom->execute(array($hotl_id,$rm_sel_name1,$ses_id));
							$row_hrooom = $hrooom->fetch(PDO::FETCH_ASSOC);
							$tot_hrooom= $hrooom->rowCount();
									//echo $row_hrooom['room_type'].'- With extra bed';
									
									if($tot_hrooom==0)
									{//if trible bedroom unavailable means
									$num_fpaxs=$tot_fpax;
						 			$dvn=floor($num_fpaxs/4);
									$remd=floor($num_fpaxs%4);
									
									if($remd==0)
									{
										//only counted Two Cabin
										$rm_sel_name1='Two Cabin';
								 		$rm_sel_name2='-';
								 		$with_extra='';
										
									}else if($remd==1)
									{
										//only counted Two Cabin + extra
										if($dvn==0)
										{
											$rm_sel_name1='One Cabin';
								 			$rm_sel_name2='-';
								 			$with_extra='';
										}else if($dvn>0){
											$rm_sel_name1='Two Cabin';
								 			$rm_sel_name2='-';
								 			$with_extra='yes';
											$bed_cn=$remd;
										}
									}else if($remd==2)
									{
										if($dvn==0)
										{
											$rm_sel_name1='One Cabin';
								 			$rm_sel_name2='-';
								 			$with_extra='';
										}else if($dvn>=$remd){
											$rm_sel_name1='Two Cabin';
								 			$rm_sel_name2='One Cabin';
								 			$with_extra='';
											$bed_cn=$remd;
										}else{
											$rm_sel_name1='Two Cabin';
								 			$rm_sel_name2='One Cabin';
								 			$with_extra='';
										}
									}else if($remd==3)
									{
										if($dvn==0)
										{
											$rm_sel_name1='One Cabin';
								 			$rm_sel_name2='-';
								 			$with_extra='yes';
										}else if($dvn>=$remd){
											$rm_sel_name1='Two Cabin';
								 			$rm_sel_name2='One Cabin';
								 			$with_extra='yes';
											$bed_cn=$remd;
										}else{
											$rm_sel_name1='Two Cabin';
								 			$rm_sel_name2='One Cabin';
								 			$with_extra='yes';
										}
									}
							$hrooom=$conn->prepare("select * from hotel_season where status='0' and hotel_id=? and room_type=? and season_sno = ? ORDER by season_rate ASC");
							$hrooom->execute(array($hotl_id,$rm_sel_name1,$ses_id));
							$row_hrooom = $hrooom->fetch(PDO::FETCH_ASSOC);
							$tot_hrooom= $hrooom->rowCount();
									
									}//if trible bedroom is unavailable
									
									$room_sno=$row_hrooom['sno'];
									$room_rent=$row_hrooom['season_rate'];
									if($dvn==0)
									{
										
										$total_amount=$total_amount+($room_rent);
										echo $row_hrooom['room_type'];
										$bet='-';
									}else{
										$bet='-';
										$total_amount=$total_amount+($dvn*$room_rent);
										for($d=0;$d<$dvn-1;$d++)
										{
											$room_sno=$room_sno.','.$row_hrooom['sno'];
											$room_rent=$room_rent.','.$room_rent;
											$bet=$bet.',-';
										}
										echo $dvn."-".$row_hrooom['room_type'];
									}
						}
						if($rm_sel_name2!='-')
						{
							$hrooom=$conn->prepare("select * from hotel_season where status='0' and hotel_id=? and room_type=? and season_sno = ? ORDER by season_rate ASC");
									$hrooom->execute(array($hotl_id,$rm_sel_name2,$ses_id));
							$row_hrooom = $hrooom->fetch(PDO::FETCH_ASSOC);
							$tot_hrooom= $hrooom->rowCount();
									echo ", ".$row_hrooom['room_type'];
									$room_snoo=$row_hrooom['sno'];
									$room_sno=$room_sno.','.$room_snoo;
									
									$room_rento=$row_hrooom['season_rate'];
									$room_rent=$room_rent.','.$room_rento;
									$total_amount=$total_amount+$room_rento;
						}
						
						if($with_extra=='yes')
						{
							$bet='';
							if($dvn==1 && $bed_cn==1)
							{
								$bet="0";
							}else if($dvn>0)
							{
								$bcn=$bed_cn;
								if($dvn>=$bed_cn)
								{
									for($nu=0;$nu<$dvn;$nu++)
									{  
									 if($bcn!=0)
										{	
											if($bet=='')
											{
												$bet="0";
											}else{
												$bet=$bet.",0";
											}
									 	$bcn--;
										}
									}
								}
							}else{
								$bet='0';
							}
							    echo ", ".$bed_cn."-Extra Bed";
								//echo "chbed=".$chwithbedrate;
								$total_amount=$total_amount+($bed_cn*$chwithbedrate);//for one extra bed
						}
						if($rm_sel_name2!='-')
							{
								$bet=$bet.",-";
							}
						?>
                        <input type="hidden" value="<?php echo $bet; ?>" name="<?php echo 'rmextr_'.$categ.'_'.$ct; ?>" id="<?php echo 'rmextr_'.$categ.'_'.$ct; ?>"  />
                        <?php
				}else{
					$hrooom=$conn->prepare("select * from hotel_season where status='0' and hotel_id=? and season_sno = ?  ORDER by season_rate ASC");
					$room->execute(array($hotl_id,$ses_id));
					$row_hrooom = $hrooom->fetch(PDO::FETCH_ASSOC);
					$tot_hrooom= $hrooom->rowCount();
					echo $row_hrooom['room_type'];
					$room_sno=$row_hrooom['sno'];
					$room_rent=$row_hrooom['season_rate'];
					$total_amount=$total_amount+($room_rent*$troom);
				}
			}else{
			echo " - ";	
			$room_sno='-';
			$room_rent='-';
			}
			
		?>
        
        <input type="hidden" value="<?php echo $room_sno; ?>" name="<?php echo 'rmid_'.$categ.'_'.$ct; ?>" id="<?php echo 'rmid_'.$categ.'_'.$ct; ?>"  />
        <input type="hidden" value="<?php echo $room_rent; ?>" name="<?php echo 'rent_'.$categ.'_'.$ct; ?>" id="<?php echo 'rent_'.$categ.'_'.$ct; ?>"  />
        
        </td>
        <td  class="f_weight" style="font-family:Calibri; font-size: 12px; padding:6px;"><?php echo "1"; ?></td></tr>
	<?php
			$date=date_create($stdate);
			date_add($date,date_interval_create_from_date_string("1 days"));
			$stdate= date_format($date,"d-M-Y");
	
	 }//for end?>
    </table>
    <table width="100%">
    	<tr><td width="48%" class="f_weight" style="font-family:Calibri; font-size: 12px; padding:6px;">
        <?php echo " [ No. of Rooms - ".$troom." ] ";
							
							$rrom=$extbed;
	$rrom1=array_unique($rrom);
	$rrom1=array_values($rrom1);
	//print_r($rrom1);
	$rrom2=array_count_values($rrom);
	//print_r($rrom2);
	
	for($tt=0;$tt<count($rrom1);$tt++)
	{
		if(isset($rrom1[$tt+1]) && $rrom1[$tt+1] !='' && $rrom1[$tt+1] !='-')
		{
			if($rrom1[$tt]=='0')
			{
				$rg="With Extra Bed";
			}else if($rrom1[$tt]=='1'){
				$rg="Without Extra Bed";
			}
			if($rrom1[$tt]!='-')
			{
				echo "&nbsp; ".$rrom2[$rrom1[$tt]]."-".$rg.",&nbsp;"; 
			}
		}else
		{
			if($rrom1[$tt]=='0')
			{
				$rg="With Extra Bed";
			}else if($rrom1[$tt]=='1'){
				$rg="Without Extra Bed";
			}
			if($rrom1[$tt]!='-')
			{
				echo "&nbsp; ".$rrom2[$rrom1[$tt]]."-".$rg; 
			}
		}
	}
	?>
        </td><td width="2%"></td>
        <td width="50%" class="f_weight" style="font-family:Calibri; font-size: 12px; padding:6px;" align="right">
        <?php // echo "hotel only ".$total_amount; 
	// echo "hotel only ".$total_amount;
	//echo "<br>trans".$transport_only; 
	$itin_amt=($total_amount+$transport_only);
	//echo "AGENT =".$agent_perc;
	//echo "ADMIN =".$admin_perc;
	$itin_amt=($total_amount+$transport_only);
	$agnt_itin_amt=$itin_amt+($itin_amt*($agent_perc/100));
	$admin_itin_amt=$agnt_itin_amt+($agnt_itin_amt*($admin_perc/100));
	?>
    [ including <?php echo $choose_food; ?> ]
        </td></tr>
        <tr><td colspan="3" align="center">
    	<strong style="color:#F00; font-family:Calibri; font-size:14px;">Overall Itinerary Cost : <?php echo convert_currency_text("RS")." ".number_format(convert_currency(round($admin_itin_amt)))."/- Only";?> </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="check_class" type="checkbox" name="chbox_<?php echo $categ; ?>" id="chbox_<?php echo $categ; ?>" checked value="<?php echo $categ; ?>">
       </td></tr>
    </table>
    </center>
    </td></tr>
    <tr><td colspan="6"> <hr style="margin-top:10px; margin-bottom:10px;" /></td></tr>
    </table>
	<!--</div>-->
<!--- combination of houseboat hotels end -->

<?php
}//if houseboat available means else dont display houseboat option


//combination of 2star and 3 star hotels

$categ="2star3star"; 
$total_amount=0;
$same_city=0;
$stdate=$row_resume['tr_arr_date']; 

?>
<table id="div_catg_<?php echo $categ; ?>">
<tr><td colspan="6" style="text-align: center; color: #B16505; font-family: Calibri; font-size: 14px; font-weight: 600;">
<?php echo "Option - ".$cg." : "."Combination of 2 star & 3 star Hotels"; $cg++;?></td></tr>
<tr><td colspan="6">
    <center>
    <table class="f_weight" width="100%" style=" padding:6px; border-collapse:collapse; " border="1">
    <tr ><th class="f_weight" style="font-family: Calibri; font-size: 14px; " > &nbsp;S.No</th>
    <th style="font-family: Calibri; font-size: 14px; " class="f_weight"> &nbsp;Date</th>
    <th style="font-family: Calibri; font-size: 14px; " class="f_weight"> &nbsp;Place</th>
    <th style="font-family: Calibri; font-size: 14px; " class="f_weight"> &nbsp;Hotel</th>
    <th style="font-family: Calibri; font-size: 14px; " class="f_weight"> &nbsp;Room Category </th>
    <th style="font-family: Calibri; font-size: 14px; " class="f_weight"> &nbsp;T Nights</th></tr>
    <?php 
	$flag=0;
	for($ct=0;$ct<count($cities_arr);$ct++)
	{?>
		<tr><td class="f_weight" style="font-family: Calibri; font-size: 12px; padding:6px;"><?php echo $ct+1; ?></td>
        <td class="f_weight" style="font-family: Calibri; font-size: 12px; padding:6px; "><?php
			echo date("d-M-Y",strtotime($stdate)); 
			$stay_date=date("Y-m-d",strtotime($stdate));
		?>
        <input type="hidden" value="<?php echo $stay_date; ?>" name="<?php echo 'sdate_'.$categ.'_'.$ct; ?>" id="<?php echo 'sdate_'.$categ.'_'.$ct; ?>"  />
        </td>
        <td class="f_weight" style="font-family: Calibri; font-size: 12px; padding:6px; "><?php
			$hot_city=$conn->prepare("select * from dvi_cities where status='0' and id=?");
			$hot_city->execute(array($cities_arr[$ct]));
			$row_hot_city = $hot_city->fetch(PDO::FETCH_ASSOC);
		 	echo $row_hot_city['name']; 
		?>
      <input type="hidden" value="<?php echo $cities_arr[$ct]; ?>" name="<?php echo 'cyid_'.$categ.'_'.$ct; ?>" id="<?php echo 'cyid_'.$categ.'_'.$ct; ?>"/>
        </td>
        <td class="f_weight" style="font-family: Calibri; font-size: 12px; padding:6px;"><?php
			$tdate=date("Y-m-d",strtotime($stdate));
			$season=$conn->prepare("SELECT * FROM setting_season WHERE lock_sts != '1' and ('$tdate' BETWEEN from_date AND to_date)");
			$season->execute();
			$row_season = $season->fetch(PDO::FETCH_ASSOC);
			$tot_season=$season->rowCount();
			$ses_id=$row_season['sno'];
		if($tot_season>0)
		{
			if($flag==0)
			{
			$hotel=$conn->prepare("select * from hotel_pro where status='0' and category='2STAR' and city=? and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock) ORDER BY hotel_prior ASC ");
			//myedit
									if(isset($cities_arr[$ct+1]) && $cities_arr[$ct+1]==$cities_arr[$ct])//for next day having same city
									{
									///echo "same";
									$flag=0;
									}else
									{
										$flag=1;
									}
			//$flag=1;
			}else{
			$hotel=$conn->prepare("select * from hotel_pro where status='0' and category='3STAR' and city=? and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock) ORDER BY hotel_prior ASC ");	
									//myedit
									if(isset($cities_arr[$ct+1]) && $cities_arr[$ct+1]==$cities_arr[$ct])//for next day having same city
									{
									//echo "same";
									$flag=1;
									}else
									{
										$flag=0;
									}
					
			//$flag=0;
			}
			
			$hotel->execute(array($cities_arr[$ct]));
			$row_hotel =$hotel->fetch(PDO::FETCH_ASSOC);
			$tot_hotel= $hotel->rowCount();
			
			if($tot_hotel>0)
			{
			echo $row_hotel['hotel_name']." ( ".$row_hotel['category']." )";
			$hotl_id=$row_hotel['hotel_id'];
			
						$hfood=$conn->prepare("select * from hotel_food where status='0' and hotel_id=?");
						$hfood->execute(array($row_hotel['hotel_id']));
						$row_hfood = $hfood->fetch(PDO::FETCH_ASSOC);
			
									$ss=$ses_id+1;
									$lunchrate_arr=decode_unserialize($row_hfood['lunch_rate']);
									//print_r($lunchrate_arr);
									if(isset($lunchrate_arr[$ss-1]))
									$lunchrate=$lunchrate_arr[$ss-1];
									else
									$lunchrate=$lunchrate_arr[0];
									
									$dinnerrate_arr=decode_unserialize($row_hfood['dinner_rate']);
									if(isset($dinnerrate_arr[$ss-1]))
									$dinnerrate=$dinnerrate_arr[$ss-1];
									else
									$dinnerrate=$dinnerrate_arr[0];
									
									$chwithbed_arr=decode_unserialize($row_hfood['child_with_bed']);
										if(isset($chwithbed_arr[$ss-1]))
									$chwithbedrate=$chwithbed_arr[$ss-1];
									else
									$chwithbedrate=$chwithbed_arr[0];
									
									$chwithoutbed_arr=decode_unserialize($row_hfood['child_without_bed']);
										if(isset($chwithoutbed_arr[$ss-1]))
									$chwithoutbedrate=$chwithoutbed_arr[$ss-1];
									else
									$chwithoutbedrate=$chwithoutbed_arr[0];
									
									$flowerbed_arr=decode_unserialize($row_hfood['flower_bed']);
										if(isset($flowerbed_arr[$ss-1]))
									$flowerbedrate=$flowerbed_arr[$ss-1];
									else
									$flowerbedrate=$flowerbed_arr[0];
									
									$candle_arr=decode_unserialize($row_hfood['candle_light']);
										if(isset($candle_arr[$ss-1]))
									$candlerate=$candle_arr[$ss-1];
									else
									$candlerate=$candle_arr[0];
									
									$cake_arr=decode_unserialize($row_hfood['cake_rate']);
										if(isset($cake_arr[$ss-1]))
									$cakerate=$cake_arr[$ss-1];
									else
									$cakerate=$cake_arr[0];
									
									$fruit_arr=decode_unserialize($row_hfood['fruit_basket']);
										if(isset($fruit_arr[$ss-1]))
									$fruitrate=$fruit_arr[$ss-1];
									else
									$fruitrate=$fruit_arr[0];
									?>
<input type="hidden" value="<?php echo $chwithbedrate; ?>" name="<?php echo 'chwithbed_'.$categ.'_'.$ct; ?>" id="<?php echo 'chwithbed_'.$categ.'_'.$ct; ?>"/>
<input type="hidden" value="<?php echo $chwithoutbedrate; ?>" name="<?php echo 'chwithoutbed_'.$categ.'_'.$ct; ?>" id="<?php echo 'chwithoutbed_'.$categ.'_'.$ct; ?>"/>

<input type="hidden" value="<?php echo $dinnerrate; ?>" name="<?php echo 'dinnerrate_'.$categ.'_'.$ct; ?>" id="<?php echo 'dinnerrate_'.$categ.'_'.$ct; ?>"/>
<input type="hidden" value="<?php echo $lunchrate; ?>" name="<?php echo 'lunchrate_'.$categ.'_'.$ct; ?>" id="<?php echo 'lunchrate_'.$categ.'_'.$ct; ?>"/>
                                    <?php
									if($food_catd=='lunch_rate')
									{
										$total_amount=$total_amount+($lunchrate*$tot_fpax);
										$choose_food="Breakfast & Lunch";
									}else if($food_catd=='dinner_rate')
									{
										$total_amount=$total_amount+($dinnerrate*$tot_fpax);
										$choose_food="Breakfast & Dinner";
									}else if($food_catd=='both_food')
									{
										$boths=$dinnerrate+$lunchrate;
										$total_amount=$total_amount+($boths*$tot_fpax);
										$choose_food="Breakfast, Lunch & Dinner";
									}else{
									$choose_food='Breakfast';	
									}
									
									$ext_bed='';
									for($e=0;$e<count($extbed);$e++)
									{
										if($extbed[$e]=='0'){
											$total_amount=$total_amount+$chwithbedrate;
										}else if($extbed[$e]=='1'){
											$total_amount=$total_amount+$chwithoutbedrate;
										}
									}
				
			}else{ //if the hotels unavailable in 2star and 3star pick any hotel from any category by priority
			$hotel2=$conn->prepare("select * from hotel_pro where status='0' and city=? and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock) ORDER BY hotel_prior ASC ");
			$hotel2->execute(array($cities_arr[$ct]));
			$row_hotel2 = $hotel2->fetch(PDO::FETCH_ASSOC);
			$tot_hotel2= $hotel2->rowCount();
			
			echo $row_hotel2['hotel_name']." ( ".$row_hotel2['category']." )";
			$hotl_id=$row_hotel2['hotel_id'];
			
						$hfood=$conn->prepare("select * from hotel_food where status='0' and hotel_id=?");
						$hfood->execute(array($row_hotel2['hotel_id']));
						$row_hfood = $hfood->fetch(PDO::FETCH_ASSOC);
			 if(isset($lunchrate_arr)){
									$ss=$ses_id+1;
									$lunchrate_arr=decode_unserialize($row_hfood['lunch_rate']);
									//print_r($lunchrate_arr);
									if(isset($lunchrate_arr[$ss-1]))
									$lunchrate=$lunchrate_arr[$ss-1];
									else
									$lunchrate=$lunchrate_arr[0];
									
									$dinnerrate_arr=decode_unserialize($row_hfood['dinner_rate']);
									if(isset($dinnerrate_arr[$ss-1]))
									$dinnerrate=$dinnerrate_arr[$ss-1];
									else
									$dinnerrate=$dinnerrate_arr[0];
									
									$chwithbed_arr=decode_unserialize($row_hfood['child_with_bed']);
										if(isset($chwithbed_arr[$ss-1]))
									$chwithbedrate=$chwithbed_arr[$ss-1];
									else
									$chwithbedrate=$chwithbed_arr[0];
									
									$chwithoutbed_arr=decode_unserialize($row_hfood['child_without_bed']);
										if(isset($chwithoutbed_arr[$ss-1]))
									$chwithoutbedrate=$chwithoutbed_arr[$ss-1];
									else
									$chwithoutbedrate=$chwithoutbed_arr[0];
									
									$flowerbed_arr=decode_unserialize($row_hfood['flower_bed']);
										if(isset($flowerbed_arr[$ss-1]))
									$flowerbedrate=$flowerbed_arr[$ss-1];
									else
									$flowerbedrate=$flowerbed_arr[0];
									
									$candle_arr=decode_unserialize($row_hfood['candle_light']);
										if(isset($candle_arr[$ss-1]))
									$candlerate=$candle_arr[$ss-1];
									else
									$candlerate=$candle_arr[0];
									
									$cake_arr=decode_unserialize($row_hfood['cake_rate']);
										if(isset($cake_arr[$ss-1]))
									$cakerate=$cake_arr[$ss-1];
									else
									$cakerate=$cake_arr[0];
									
									$fruit_arr=decode_unserialize($row_hfood['fruit_basket']);
										if(isset($fruit_arr[$ss-1]))
									$fruitrate=$fruit_arr[$ss-1];
									else
									$fruitrate=$fruit_arr[0];
			 }	?>
<input type="hidden" value="<?php echo $chwithbedrate; ?>" name="<?php echo 'chwithbed_'.$categ.'_'.$ct; ?>" id="<?php echo 'chwithbed_'.$categ.'_'.$ct; ?>"/>
<input type="hidden" value="<?php echo $chwithoutbedrate; ?>" name="<?php echo 'chwithoutbed_'.$categ.'_'.$ct; ?>" id="<?php echo 'chwithoutbed_'.$categ.'_'.$ct; ?>"/>

<input type="hidden" value="<?php echo $dinnerrate; ?>" name="<?php echo 'dinnerrate_'.$categ.'_'.$ct; ?>" id="<?php echo 'dinnerrate_'.$categ.'_'.$ct; ?>"/>
<input type="hidden" value="<?php echo $lunchrate; ?>" name="<?php echo 'lunchrate_'.$categ.'_'.$ct; ?>" id="<?php echo 'lunchrate_'.$categ.'_'.$ct; ?>"/>
                                    <?php
									if($food_catd=='lunch_rate')
									{
										$total_amount=$total_amount+($lunchrate*$tot_fpax);
										$choose_food="Breakfast & Lunch";
									}else if($food_catd=='dinner_rate')
									{
										$total_amount=$total_amount+($dinnerrate*$tot_fpax);
										$choose_food="Breakfast & Dinner";
									}else if($food_catd=='both_food')
									{
										$boths=$dinnerrate+$lunchrate;
										$total_amount=$total_amount+($boths*$tot_fpax);
										$choose_food="Breakfast, Lunch & Dinner";
									}else{
									$choose_food='Breakfast';	
									}
									
									$ext_bed='';
									for($e=0;$e<count($extbed);$e++)
									{
										if($extbed[$e]=='0'){
											$total_amount=$total_amount+$chwithbedrate;
										}else if($extbed[$e]=='1'){
											$total_amount=$total_amount+$chwithoutbedrate;
										}
									}
			}
			
		}else{
			echo " Locked ";	//season lock
			$hotl_id='-';
		}
		?>
        <input type="hidden" value="<?php echo $hotl_id; ?>" name="<?php echo 'hid_'.$categ.'_'.$ct; ?>" id="<?php echo 'hid_'.$categ.'_'.$ct; ?>"  />
        </td>
        <td class="f_weight" style="font-family: Calibri; font-size: 12px;padding:6px; "><?php
			if($hotl_id != '-')
			{
			$hrooom=$conn->prepare("select * from hotel_season where status='0' and hotel_id=? and season_sno = ?  ORDER by season_rate ASC");
			$room->execute(array($hotl_id,$ses_id));
			$row_hrooom = $hrooom->fetch(PDO::FETCH_ASSOC);
			$tot_hrooom= $hrooom->rowCount();
			echo $row_hrooom['room_type'];
			$room_sno=$row_hrooom['sno'];
			$room_rent=$row_hrooom['season_rate'];
			$total_amount=$total_amount+($room_rent*$troom);
			}else{
			echo " - ";	
			$room_sno='-';
			$room_rent='-';
			}
		?>
        <input type="hidden" value="<?php echo $room_sno; ?>" name="<?php echo 'rmid_'.$categ.'_'.$ct; ?>" id="<?php echo 'rmid_'.$categ.'_'.$ct; ?>"  />
        <input type="hidden" value="<?php echo $room_rent; ?>" name="<?php echo 'rent_'.$categ.'_'.$ct; ?>" id="<?php echo 'rent_'.$categ.'_'.$ct; ?>"  />
        </td>
        <td class="f_weight" style="font-family: Calibri; font-size: 12px; padding:6px;"><?php echo "1"; ?></td></tr>
	<?php
			$date=date_create($stdate);
			date_add($date,date_interval_create_from_date_string("1 days"));
			$stdate= date_format($date,"d-M-Y");
	
	 }//for end?>
    </table>
    <table width="100%">
    <tr>
    	<td width="48%" class="f_weight" style="font-family: Calibri; font-size: 12px; padding:6px; ">
        
        <?php echo "[ No. of Rooms - ".$troom." ] ";
								
								$rrom=$extbed;
	$rrom1=array_unique($rrom);
	$rrom1=array_values($rrom1);
	//print_r($rrom1);
	$rrom2=array_count_values($rrom);
	//print_r($rrom2);
	
	for($tt=0;$tt<count($rrom1);$tt++)
	{
		if(isset($rrom1[$tt+1]) && $rrom1[$tt+1] !='' && $rrom1[$tt+1] !='-')
		{
			if($rrom1[$tt]=='0')
			{
				$rg="With Extra Bed";
			}else if($rrom1[$tt]=='1'){
				$rg="Without Extra Bed";
			}
			if($rrom1[$tt]=='-')
			{
			echo "&nbsp; ".$rrom2[$rrom1[$tt]]."-".$rg.",&nbsp;"; 
			}
		}else
		{
			if($rrom1[$tt]=='0')
			{
				$rg="With Extra Bed";
			}else if($rrom1[$tt]=='1'){
				$rg="Without Extra Bed";
			}
			if($rrom1[$tt]!='-')
			{
			echo "&nbsp; ".$rrom2[$rrom1[$tt]]."-".$rg; 
			}
		}
	}
	?>
        </td><td width="2%"></td>
        <td width="50%"  class="f_weight" style="font-family: Calibri; font-size: 12px; padding:6px;" align="right">
         <?php //echo "hotel only ".$total_amount; 
	$itin_amt=($total_amount+$transport_only);
	$agnt_itin_amt=$itin_amt+($itin_amt*($agent_perc/100));
	$admin_itin_amt=$agnt_itin_amt+($agnt_itin_amt*($admin_perc/100));
	?>
        [ including <?php echo $choose_food; ?> ]
        </td>
    </tr>
    <tr><td colspan="3" align="center">
    	<strong style="color:#F00;  font-family:Calibri; font-size:14px;">Overall Itinerary Cost : <?php echo convert_currency_text("RS")." ".number_format(convert_currency(round($admin_itin_amt)))."/- Only";?> </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="check_class" type="checkbox" name="chbox_<?php echo $categ; ?>" id="chbox_<?php echo $categ; ?>" checked value="<?php echo $categ; ?>">
       </td></tr>
    
    </table>
    </center>
    <tr><td colspan="6"> <hr style="margin-top:10px; margin-bottom:10px;" /></td></tr>
    </td></tr>
    </table>
<!--- combination of 2 star and 3 star hotels end -->
<!-- combination of 3 star and 4 star hotels start -->
<?php
$stdate=$row_resume['tr_arr_date']; 
 $categ="3star4star"; 
$total_amount=0;
?>
<table id="div_catg_<?php echo $categ; ?>">
<tr><td colspan="6" style="text-align: center; color: #B16505; font-family: Calibri; font-size: 14px; font-weight: 600;">
<?php echo "Option - ".$cg." : "."Combination of 3 star & 4 star Hotels"; ?></td></tr>
<tr><td class="6">    
    <center>
    <table style="width:100%" border="1" style="border-collapse:collapse">
    <tr> <th style="font-family: Calibri; font-size: 14px; font-weight: 600;"> &nbsp;S.No</th>
    <th style="font-family: Calibri; font-size: 14px; font-weight: 600;"> &nbsp;Date</th>
    <th style="font-family: Calibri; font-size: 14px; font-weight: 600;"> &nbsp;Place</th>
    <th style="font-family: Calibri; font-size: 14px; font-weight: 600;"> &nbsp;Hotel</th>
    <th style="font-family: Calibri; font-size: 14px; font-weight: 600;"> &nbsp;Room Category </th>
    <th style="font-family: Calibri; font-size: 14px; font-weight: 600;"> &nbsp;T Nights</th></tr>
    <?php 
	$flag=0;
	for($ct=0;$ct<count($cities_arr);$ct++)
	{?>
		<tr><td style="font-family: Calibri; font-size: 12px; padding:6px; " class="f_weight"><?php echo $ct+1; ?></td>
        <td style="font-family: Calibri; font-size: 12px; padding:6px; " class="f_weight"><?php
			$stay_date=date("Y-m-d",strtotime($stdate));
			echo date("d-M-Y",strtotime($stdate)); 
			
		?>
        <input type="hidden" value="<?php echo $stay_date; ?>" name="<?php echo 'sdate_'.$categ.'_'.$ct; ?>" id="<?php echo 'sdate_'.$categ.'_'.$ct; ?>"  />
        </td>
        <td style="font-family: Calibri; font-size: 12px; padding:6px;" class="f_weight"><?php
			$hot_city=$conn->prepare("select * from dvi_cities where status='0' and id=?");
			$hot_city->execute(array($cities_arr[$ct]));
			$row_hot_city =$hot_city->fetch(PDO::FETCH_ASSOC);
		 	echo $row_hot_city['name']; 
		?>
      <input type="hidden" value="<?php echo $cities_arr[$ct]; ?>" name="<?php echo 'cyid_'.$categ.'_'.$ct; ?>" id="<?php echo 'cyid_'.$categ.'_'.$ct; ?>"/>
        </td>
        <td style="font-family: Calibri; font-size: 12px;padding:6px; " class="f_weight"><?php
			$tdate=date("Y-m-d",strtotime($stdate));
			$season=$conn->prepare("SELECT * FROM setting_season WHERE lock_sts != '1' and ('$tdate' BETWEEN from_date AND to_date)");
			$season->execute();
			$row_season = $season->fetch(PDO::FETCH_ASSOC);
			$tot_season= $season->rowCount();
		
		if($tot_season>0)
		{
			if($flag==0)
			{
			$hotel=$conn->prepare("select * from hotel_pro where status='0' and category='3STAR' and city=? and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock) ORDER BY hotel_prior ASC ");
									//myedit
									if(isset($cities_arr[$ct+1]) && $cities_arr[$ct+1]==$cities_arr[$ct])//for next day having same city
									{
									///echo "same";
									$flag=0;
									}else
									{
										$flag=1;
									}
			//$flag=1;
			}else{
			$hotel=$conn->prepare("select * from hotel_pro where status='0' and category='4STAR' and city=? and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock) ORDER BY hotel_prior ASC ");	
			
									//myedit
									if(isset($cities_arr[$ct+1]) && $cities_arr[$ct+1]==$cities_arr[$ct])//for next day having same city
									{
									///echo "same";
									$flag=1;
									}else
									{
										$flag=0;
									}
			//$flag=0;
			}
			
			$hotel->execute(array($cities_arr[$ct]));
			$row_hotel = $hotel->fetch(PDO::FETCH_ASSOC);
			$tot_hotel= $hotel->rowCount();
			
			if($tot_hotel>0)
			{
			echo $row_hotel['hotel_name']." ( ".$row_hotel['category']." )";
			$hotl_id=$row_hotel['hotel_id'];
			
						$hfood=$conn->prepare("select * from hotel_food where status='0' and hotel_id=?");
						$hfood->execute(array($row_hotel['hotel_id']));
						$row_hfood = $hfood->fetch(PDO::FETCH_ASSOC);
			
									$ss=$ses_id+1;
									$lunchrate_arr=decode_unserialize($row_hfood['lunch_rate']);
									//print_r($lunchrate_arr);
									if(isset($lunchrate_arr[$ss-1]))
									$lunchrate=$lunchrate_arr[$ss-1];
									else
									$lunchrate=$lunchrate_arr[0];
									
									$dinnerrate_arr=decode_unserialize($row_hfood['dinner_rate']);
									if(isset($dinnerrate_arr[$ss-1]))
									$dinnerrate=$dinnerrate_arr[$ss-1];
									else
									$dinnerrate=$dinnerrate_arr[0];
									
									$chwithbed_arr=decode_unserialize($row_hfood['child_with_bed']);
										if(isset($chwithbed_arr[$ss-1]))
									$chwithbedrate=$chwithbed_arr[$ss-1];
									else
									$chwithbedrate=$chwithbed_arr[0];
									
									$chwithoutbed_arr=decode_unserialize($row_hfood['child_without_bed']);
										if(isset($chwithoutbed_arr[$ss-1]))
									$chwithoutbedrate=$chwithoutbed_arr[$ss-1];
									else
									$chwithoutbedrate=$chwithoutbed_arr[0];
									
									$flowerbed_arr=decode_unserialize($row_hfood['flower_bed']);
										if(isset($flowerbed_arr[$ss-1]))
									$flowerbedrate=$flowerbed_arr[$ss-1];
									else
									$flowerbedrate=$flowerbed_arr[0];
									
									$candle_arr=decode_unserialize($row_hfood['candle_light']);
										if(isset($candle_arr[$ss-1]))
									$candlerate=$candle_arr[$ss-1];
									else
									$candlerate=$candle_arr[0];
									
									$cake_arr=decode_unserialize($row_hfood['cake_rate']);
										if(isset($cake_arr[$ss-1]))
									$cakerate=$cake_arr[$ss-1];
									else
									$cakerate=$cake_arr[0];
									
									$fruit_arr=decode_unserialize($row_hfood['fruit_basket']);
										if(isset($fruit_arr[$ss-1]))
									$fruitrate=$fruit_arr[$ss-1];
									else
									$fruitrate=$fruit_arr[0];
									?>
<input type="hidden" value="<?php echo $chwithbedrate; ?>" name="<?php echo 'chwithbed_'.$categ.'_'.$ct; ?>" id="<?php echo 'chwithbed_'.$categ.'_'.$ct; ?>"/>
<input type="hidden" value="<?php echo $chwithoutbedrate; ?>" name="<?php echo 'chwithoutbed_'.$categ.'_'.$ct; ?>" id="<?php echo 'chwithoutbed_'.$categ.'_'.$ct; ?>"/>

<input type="hidden" value="<?php echo $dinnerrate; ?>" name="<?php echo 'dinnerrate_'.$categ.'_'.$ct; ?>" id="<?php echo 'dinnerrate_'.$categ.'_'.$ct; ?>"/>
<input type="hidden" value="<?php echo $lunchrate; ?>" name="<?php echo 'lunchrate_'.$categ.'_'.$ct; ?>" id="<?php echo 'lunchrate_'.$categ.'_'.$ct; ?>"/>
                                    <?php
									if($food_catd=='lunch_rate')
									{
										$total_amount=$total_amount+($lunchrate*$tot_fpax);
										$choose_food="Breakfast & Lunch";
									}else if($food_catd=='dinner_rate')
									{
										$total_amount=$total_amount+($dinnerrate*$tot_fpax);
										$choose_food="Breakfast & Dinner";
									}else if($food_catd=='both_food')
									{
										$boths=$dinnerrate+$lunchrate;
										$total_amount=$total_amount+($boths*$tot_fpax);
										$choose_food="Breakfast, Lunch & Dinner";
									}else{
									$choose_food='Breakfast';	
									}
									
									$ext_bed='';
									for($e=0;$e<count($extbed);$e++)
									{
										if($extbed[$e]=='0'){
											$total_amount=$total_amount+$chwithbedrate;
										}else if($extbed[$e]=='1'){
											$total_amount=$total_amount+$chwithoutbedrate;
										}
									}
			}else{
			$hotel3=$conn->prepare("select * from hotel_pro where status='0' and city=? and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock) ORDER BY hotel_prior ASC ");
			$hotel3->execute(array($cities_arr[$ct]));
			$row_hotel3 = $hotel3->fetch(PDO::FETCH_ASSOC);
			$tot_hotel3= $hotel3->rowCount();
			
					echo $row_hotel3['hotel_name']." ( ".$row_hotel3['category']." )";
					$hotl_id=$row_hotel3['hotel_id'];
			
						$hfood=$conn->prepare("select * from hotel_food where status='0' and hotel_id=?");
						$hfood->execute(array($row_hotel3['hotel_id']));
						$row_hfood = $hfood->fetch(PDO::FETCH_ASSOC);
			 if(isset($lunchrate_arr)){
									$ss=$ses_id+1;
									$lunchrate_arr=decode_unserialize($row_hfood['lunch_rate']);
									//print_r($lunchrate_arr);
									if(isset($lunchrate_arr[$ss-1]))
									$lunchrate=$lunchrate_arr[$ss-1];
									else
									$lunchrate=$lunchrate_arr[0];
									
									$dinnerrate_arr=decode_unserialize($row_hfood['dinner_rate']);
									if(isset($dinnerrate_arr[$ss-1]))
									$dinnerrate=$dinnerrate_arr[$ss-1];
									else
									$dinnerrate=$dinnerrate_arr[0];
									
									$chwithbed_arr=decode_unserialize($row_hfood['child_with_bed']);
										if(isset($chwithbed_arr[$ss-1]))
									$chwithbedrate=$chwithbed_arr[$ss-1];
									else
									$chwithbedrate=$chwithbed_arr[0];
									
									$chwithoutbed_arr=decode_unserialize($row_hfood['child_without_bed']);
										if(isset($chwithoutbed_arr[$ss-1]))
									$chwithoutbedrate=$chwithoutbed_arr[$ss-1];
									else
									$chwithoutbedrate=$chwithoutbed_arr[0];
									
									$flowerbed_arr=decode_unserialize($row_hfood['flower_bed']);
										if(isset($flowerbed_arr[$ss-1]))
									$flowerbedrate=$flowerbed_arr[$ss-1];
									else
									$flowerbedrate=$flowerbed_arr[0];
									
									$candle_arr=decode_unserialize($row_hfood['candle_light']);
										if(isset($candle_arr[$ss-1]))
									$candlerate=$candle_arr[$ss-1];
									else
									$candlerate=$candle_arr[0];
									
									$cake_arr=decode_unserialize($row_hfood['cake_rate']);
										if(isset($cake_arr[$ss-1]))
									$cakerate=$cake_arr[$ss-1];
									else
									$cakerate=$cake_arr[0];
									
									$fruit_arr=decode_unserialize($row_hfood['fruit_basket']);
										if(isset($fruit_arr[$ss-1]))
									$fruitrate=$fruit_arr[$ss-1];
									else
									$fruitrate=$fruit_arr[0];
			 }			?>
<input type="hidden" value="<?php echo $chwithbedrate; ?>" name="<?php echo 'chwithbed_'.$categ.'_'.$ct; ?>" id="<?php echo 'chwithbed_'.$categ.'_'.$ct; ?>"/>
<input type="hidden" value="<?php echo $chwithoutbedrate; ?>" name="<?php echo 'chwithoutbed_'.$categ.'_'.$ct; ?>" id="<?php echo 'chwithoutbed_'.$categ.'_'.$ct; ?>"/>

<input type="hidden" value="<?php echo $dinnerrate; ?>" name="<?php echo 'dinnerrate_'.$categ.'_'.$ct; ?>" id="<?php echo 'dinnerrate_'.$categ.'_'.$ct; ?>"/>
<input type="hidden" value="<?php echo $lunchrate; ?>" name="<?php echo 'lunchrate_'.$categ.'_'.$ct; ?>" id="<?php echo 'lunchrate_'.$categ.'_'.$ct; ?>"/>
                                    <?php
									if($food_catd=='lunch_rate')
									{
										$total_amount=$total_amount+($lunchrate*$tot_fpax);
										$choose_food="Breakfast & Lunch";
									}else if($food_catd=='dinner_rate')
									{
										$total_amount=$total_amount+($dinnerrate*$tot_fpax);
										$choose_food="Breakfast & Dinner";
									}else if($food_catd=='both_food')
									{
										$boths=$dinnerrate+$lunchrate;
										$total_amount=$total_amount+($boths*$tot_fpax);
										$choose_food="Breakfast, Lunch & Dinner";
									}else{
									$choose_food='Breakfast';	
									}
									
									$ext_bed='';
									for($e=0;$e<count($extbed);$e++)
									{
										if($extbed[$e]=='0'){
											$total_amount=$total_amount+$chwithbedrate;
										}else if($extbed[$e]=='1'){
											$total_amount=$total_amount+$chwithoutbedrate;
										}
									}
			
			
			}
			$ses_id=$row_season['sno'];
		}else{
			echo " Locked ";	//season lock
			$hotl_id='-';
		}
		?>
        <input type="hidden" value="<?php echo $hotl_id; ?>" name="<?php echo 'hid_'.$categ.'_'.$ct; ?>" id="<?php echo 'hid_'.$categ.'_'.$ct; ?>"  />
        </td>
        <td style="font-family: Calibri; font-size: 12px; padding:6px; " class="f_weight"><?php
			if($hotl_id != '-')
			{
			$hroom=$conn->prepare("select * from hotel_season where status='0' and hotel_id=? and season_sno = ?  ORDER by season_rate ASC");
			$room->execute(array($hotl_id,$ses_id));
			$row_hrooom = $hrooom->fetch(PDO::FETCH_ASSOC);
			$tot_hrooom=$hrooom->rowCount();
			echo $row_hrooom['room_type'];
			$room_sno=$row_hrooom['sno'];
			$room_rent=$row_hrooom['season_rate'];
			$total_amount=$total_amount+($room_rent*$troom);
			}else{
			echo " - ";	
			$room_sno='-';
			$room_rent='-';
			}
		?>
        <input type="hidden" value="<?php echo $room_sno; ?>" name="<?php echo 'rmid_'.$categ.'_'.$ct; ?>" id="<?php echo 'rmid_'.$categ.'_'.$ct; ?>"  />
        <input type="hidden" value="<?php echo $room_rent; ?>" name="<?php echo 'rent_'.$categ.'_'.$ct; ?>" id="<?php echo 'rent_'.$categ.'_'.$ct; ?>"  />
        </td>
        <td style="font-family: Calibri; font-size: 12px; padding:6px;" class="f_weight"><?php echo "1"; ?></td></tr>
	<?php
			$date=date_create($stdate);
			date_add($date,date_interval_create_from_date_string("1 days"));
			$stdate= date_format($date,"d-M-Y");
	
	 }//for end?>
    </table>
    <table width="100%">
    <tr><td width="48%" style="font-family: Calibri; font-size: 12px; padding:6px; " class="f_weight">
    <?php echo "[ No. of Rooms - ".$troom." ] ";
							
	$rrom=$extbed;
	$rrom1=array_unique($rrom);
	$rrom1=array_values($rrom1);
	//print_r($rrom1);
	$rrom2=array_count_values($rrom);
	//print_r($rrom2);
	
	for($tt=0;$tt<count($rrom1);$tt++)
	{
		if(isset($rrom1[$tt+1]) && $rrom1[$tt+1] !='' && $rrom1[$tt+1] !='-')
		{
			if($rrom1[$tt]=='0')
			{
				$rg="With Extra Bed";
			}else if($rrom1[$tt]=='1'){
				$rg="Without Extra Bed";
			}
			if($rrom1[$tt]!='-')
			{
			echo "&nbsp; ".$rrom2[$rrom1[$tt]]."-".$rg.",&nbsp;";
			}
		}else
		{
			if($rrom1[$tt]=='0')
			{
				$rg="With Extra Bed";
			}else if($rrom1[$tt]=='1'){
				$rg="Without Extra Bed";
			}
			if($rrom1[$tt]!='-')
			{
			echo "&nbsp; ".$rrom2[$rrom1[$tt]]."-".$rg; 
			}
		}
	}
	?>
    </td><td width="2%"></td>
    <td width="50%" style="font-family: Calibri; font-size: 12px; padding:6px;" class="f_weight" align="right">
     <?php //echo "hotel only ".$total_amount; 
	$itin_amt=($total_amount+$transport_only);
	$agnt_itin_amt=$itin_amt+($itin_amt*($agent_perc/100));
	$admin_itin_amt=$agnt_itin_amt+($agnt_itin_amt*($admin_perc/100));
	?>
   [ including <?php echo $choose_food; ?> ]
    </td></tr>
    <tr><td colspan="3" align="center">
    	<strong style="color:#F00;  font-family:Calibri; font-size:14px;">Overall Itinerary Cost : <?php echo convert_currency_text("RS")." ".number_format(convert_currency(round($admin_itin_amt)))."/- Only";?> </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="check_class" type="checkbox" name="chbox_<?php echo $categ; ?>" id="chbox_<?php echo $categ; ?>" checked value="<?php echo $categ; ?>">
       </td></tr>
    </table>
    </center>
   
     </td></tr>
     <tr><td colspan="6"><hr style="margin-top:10px; margin-bottom:10px;" /></td></tr>
    </table>
<!-- combination of 3star and 4 star hotels end --->
 
 </td></tr>
 <!-- suggested hotel option end -->
 
 </table>
 <div style="display:none; margin-top:10px;" id="dis_play">
 <?php
        $pers1 =$conn->prepare( "SELECT * FROM login_secure where uid=?");
		$pers1->execute(array($_SESSION['uid']));
		$row_pers1= $pers1->fetch(PDO::FETCH_ASSOC);
		$totalRows_pers1  = $pers1->rowCount();
 ?>
 
 <strong> Suggestion From DVI Holidays ( <?php echo $row_pers1['email_id']; ?> ) </strong><br>
     <div id="text_res_ar_div" style="margin-top:10px;">
     
     </div>
 </div>
 </div><!-- mail me div -->
  <?php if($_SESSION['grp']=="ADMIN" || $_SESSION['grp']=="DISTRB") {
	 
	    $pers = $conn->prepare("SELECT * FROM login_secure where uid=?");
		$pers->execute(array($_SESSION['uid']));
		$row_pers= $pers->fetch(PDO::FETCH_ASSOC);
		$totalRows_pers  = $pers->rowCount();
	 ?>
     <div align="center" id="hi_de">
      <strong> Suggestion From DVI Holidays ( <?php echo $row_pers['email_id']; ?> ) </strong>
 <div align="center" style=" margin-top:10px" id="text_ar_div">
     <textarea id="text_ar" style="border:#06C solid 2px; resize:vertical; min-height:100px; max-height:300px" 
     cols="120" rows="8" data-placeholder="Give some suggestion">
     Give Some Suggestion...
     </textarea>
 </div>
 
 </div>
 <?php }?>
 
 </div>
 <div class="col-sm-2"></div>
 </div>
 </div>
 <div class="row " style="margin-top:20px; margin-bottom:20px;">
 	<div class="col-sm-12" style="text-align:center">
 		<div class="col-sm-4"></div>
        <div class=" col-sm-3"><input type="email" name="mailtome" id="mailtome" class="form-control" ></div>
        <div class="col-sm-1"><button class="btn-info btn btn-sm" name="mail_btn" id="mail_btn" onClick="mail_to_me_fun()"><i class="fa fa-envelope"></i>&nbsp; Send Mail </button></div>
        <div class="col-sm-1"><button class="btn-info btn btn-sm" name="ref_btn" id="ref_btn" onClick="refresh_fun()"><i class="fa fa-refresh"></i>&nbsp; Refresh </button></div>
        <div class="col-sm-3"></div>
 	</div>
 </div>

                    </body>
                    </html>
					
		<script src="../core/assets/js/bootstrap.min.js"></script>
		<script src="../core/assets/plugins/retina/retina.min.js"></script>
		<script src="../core/assets/plugins/backstretch/jquery.backstretch.min.js"></script>
        
		<script src="../core/assets/js/apps.js"></script>
		<script src="../core/assets/js/demo-panel-1.js"></script>
        <script src="../core/assets/js/moment.js"></script>
		<script>
	
	function refresh_fun()
	{
		window.location.reload();
	}
	
	function mail_to_me_fun()
	{
		var rem;
		var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

		var mailtome=$('#mailtome').val().trim();
		if(mailtome=='')
		{
			alert('Mail Id cannot be empty !');
			$('#mailtome').focus();
		}else if(!expr.test(mailtome)){
			alert('Please Enter Valid Mail ID !');
			$('#mailtome').focus();
		}else{
			
			if($('#text_ar').length>0)
			{
				var tx=$('#text_ar').val();
				$('#text_res_ar_div').empty().text(tx);
				$('#dis_play').show();
				$('#hi_de').hide();
			}
			
			if($('#hide_5star').length>0)
			{
				$('#div_catg_5STAR').remove();
			}
			
			$('.loader_ax').fadeIn();
			$(".check_class").each(function(){
				if(!$(this).is(":checked"))
				{
					rem=$(this).val().trim();
					$('#div_catg_'+rem).remove();
				}
				$(this).remove();
			});
			
			var cont=$('#mail_me').html();
			$.post('ajax_mail.php?type=5&emname='+mailtome,{ content : cont },function(con){ 
					$('.loader_ax').fadeOut(); 
					alert('Mail sent successfully to '+con.trim()); 
					
					if($('#text_ar').length>0)
					{
						$('#dis_play').hide();
						$('#hi_de').show();
					}
					
				});
		}
	}
	
	function func_onblur()
	{
		if($('#hide_5star').length>0)
		{
			$('#div_catg_5Star').remove();
		}
		$('#mouse_move_div').attr('onMouseMove','');
	}
</script>

	