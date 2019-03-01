<?php
session_start();
$timezone = new DateTimeZone("Asia/Kolkata" );
  $date = new DateTime();
  $date->setTimezone($timezone );
  $mm=$date->format('m');
  $mm1=$date->format('M');
  $yy=$date->format('Y');
  $dd=$date->format('d');
  $time=date("H:i:s");
  $today=date('d.m.Y');
//error_reporting(0);

require_once('../Connections/divdb.php');
$idd=explode('#',$_GET['planid']);
$str=$idd[0];
//print_r($idd);

$orders = $conn->prepare("SELECT * FROM travel_master where plan_id =?");
$orders->execute(array($_GET['planid']));
$row_orders = $orders->fetch(PDO::FETCH_ASSOC);
$totalRows_orders = $orders->rowCount();

if(isset($_POST['grant_approvel']) && $_POST['grant_approvel']=="grant_approvel_val")
{

$up_approvel1=$conn->prepare("update travel_master set status='0' where plan_id =?");
$up_approvel1->execute(array($_GET['planid']));
echo "<script> parent.location.reload();parent.jQuery.fancybox.close();</script>";
}

if(isset($_POST['reject_approvel']) && $_POST['reject_approvel']=="reject_approvel_val")
{

$up_approvel1=$conn->prepare("update travel_master set status='1' where plan_id =?");
$up_approvel1->execute(array($_GET['planid']));
echo "<script> parent.location.reload();parent.jQuery.fancybox.close();</script>";
}


?>
<style>
@font-face {
    font-family: Calibri;
    src: url(Calibri.ttf);
}
body {
	
    background-position: 50% 50%;
    margin:0px;
    padding:0px !important;
	font-family:Calibri !important ;
	
	font-size: 14px !important;
}

table td{
	padding:3px;
}

table td.tdstyle{
	padding:4px;
	border:#666 solid 1px;
}
</style>
<html>
<head>
		<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="../core/assets/css/style.css" rel="stylesheet">
		<link href="../core/assets/css/style-responsive.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="../core/assets/plugins/Tags/jquery.tagsinput.css" />
        <script src="../core/assets/js/jquery.min.js"></script>
        </head>
        <body class="div-nicescroller">
					<!-- Begin page heading -->
					<!-- BEGIN INVOICE -->
					<div class="the-box full invoice">
                    
                    <div class="the-box no-border">
                        <div class="row">
                        <div class="col-sm-12">
                        	<div class="col-sm-10">
                                <h4 class="text-muted text"><?php // echo $_GET['planid']; ?></h4>
                            </div>
                            
                            
							<div class="col-sm-2 "  align="right">
                            <div class="btn-group">
								  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-download"></i> Download PDF <span class="caret"></span>
								  </button>
								  <ul class="dropdown-menu info pull-right" role="menu" style="text-align:left">
									<li><a target="_blank" href="itin_trav_hot_pdf.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&planid=<?php echo urlencode($_GET['planid']); ?>"><i class="fa  fa-hand-o-right"></i>&nbsp;Itinerary Form (Default)</a></li>
                                    <li class="divider"></li>
									<li><a target="_blank" href="itin_wel_board_pdf.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&planid=<?php echo urlencode($_GET['planid']); ?>"><i class="fa  fa-hand-o-right"></i>&nbsp;Welcome Board</a></li>
									<li><a target="_blank" href="trhot_letter_pad_pdf.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&planid=<?php echo urlencode($_GET['planid']); ?>"><i class="fa  fa-hand-o-right"></i>&nbsp;Itinerary Form (On Letter Pad)</a></li>
								  </ul>
								</div>
							</div>
                            </div>
                        </div>
					</div>

                    <div class="the-box no-border ">
                    <div class="row">
                   <img src="../images/dvi_pdf1.png" alt="DVI Logo" style="margin-left:30px; margin-top:20px;"/>
                   <div style="margin-top:-72px; margin-bottom:100px; height: 460px;">
                  <center><strong style="font-family:sans-serif; font-weight:bolder; font-size:77px; color:#000; "> Welcomes </strong><br />
                  <strong style="font-family:sans-serif; font-weight:bolder; font-size:77px;color:#000;"></strong><strong style="font-family:sans-serif; font-weight:bolder; font-size:77px;color:#000; word-wrap:break-word" ><?php echo $row_orders['tr_name']; ?> </strong></center>
                   </div>
                   <div class="col-sm-12">
                   <div class="col-sm-8">
                    <b>Arrival flight/train details&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;<?php echo $row_orders['tr_arrdet']; ?></b>
<br /><b>Departure flight/ train details&nbsp;&nbsp;: &nbsp;<?php echo $row_orders['tr_depdet']; ?></b>
                   </div>
                    <div class="col-sm-4"><br />
                    <b >Contact No.</b>&nbsp;&nbsp;<b><?php echo $row_orders['tr_mobile']."&nbsp;&nbsp;&nbsp;"; ?></b></div>
                                       </div>
                   </div>
                    </div>
                     <?php
                      //breakup start 

$breakup = $conn->prepare("SELECT * FROM travel_master where plan_id =?");
$breakup->execute(array($_GET['planid']));
$row_breakup = $breakup->fetch(PDO::FETCH_ASSOC);
$totalRows_breakup = $breakup->rowCount();

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
	if(!empty($row_orders['sub_paln_id'])){
		$guest_name = $row_orders['tr_name'];
	}
	$totalRows_orders = $orders->rowCount();
                      ?>
                    
                      <hr style="margin-top: 10px;margin-bottom: 10px;" />
                        <div class="the-box" style="vertical-align: text-middle; border:thin #666 1px;">
							<div class="row">
								<div class="col-sm-12 text-right">
									<img  src="../images/dvi_pdf.png"  height="75px" width="75px" alt="DVI Logo"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                      
                                    <hr style=" color: #443232;margin-top: 10px;margin-bottom: 10px" />
                                    <br />
								</div><!-- /.col-sm-6 -->
                               <?php 
							   if($break_chk>0)
							   { ?>
								   <center><strong style="color:#C58207">Your Itinerary will bypassing to following places</strong></center>
							  <?php  }
							  $break_chk++;
							  
							   ?>
                                <table>
                                <tr><td>&nbsp;Guest Name</td><td>:</td><td><?php echo $guest_name; ?></td></tr>
                                <tr><td>&nbsp;Pax Count</td><td>:</td><td><?php echo $row_orders['pax_cnt']."&nbsp;Person(s)"; ?></td></tr>
                                <tr><td>&nbsp;Total Traveling days</td><td>:</td><td><?php echo $row_orders['tr_days']; ?></td></tr>
                                <tr><td>&nbsp;Vehicle Infomation</td><td>:</td>
                                <td><?php
								if($row_orders['tr_vehname'] == '')
								{
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
												echo "&nbsp;".$row_vpro['vehicle_type'];
											}
										}
									}
								}
								else
								{
									echo $row_orders['tr_vehname'];
								}
								  ?></td></tr>
                                </table>
                              
                                    <?php 
									
$spro = $conn->prepare("SELECT * FROM stay_sched where stay_id =? ORDER BY sno ASC ");
$spro->execute(array($_GET['planid']));
//$row_spro = mysql_fetch_assoc($spro);
//$row_spro_main=$spro->fetchAll();
$totalRows_spro = $spro->rowCount();
									if($str =='TH' && $totalRows_spro>0 ){?>
                                    <div class="table-responsive" style="margin-left:30px; margin-right:30px;">
                                    <span style="color:#F00; margin-left:-23px;"><u>Hotel list:</u></span>
                                    <br /><br />
                                    <?php 
$scnt=1;	
									?>
                                    <table class="table table-th-block table-striped"  width='100%' border="1">
                                    <tr><th>S.No</th><th>Date</th><th>Place</th><th>Hotel</th><th>Room Category</th><th>Meal Plan</th></tr>
                                    <?php while($row_spro = $spro->fetch(PDO::FETCH_ASSOC)){ ?>
                                    <tr><td><?php echo $scnt; ?></td><td><?php
									
$spro1 = $conn->prepare("SELECT * FROM stay_sched where stay_id =? and hotel_id=? ORDER BY sno ASC ");
$spro1->execute(array($_GET['planid'],$row_spro['hotel_id']));
$row_spro1 = $spro1->fetch(PDO::FETCH_ASSOC);
$totalRows_spro1 = $spro1->rowCount();
						
						$org_date= date('d-M-Y',strtotime(substr($row_spro['sty_date'],'0','10')));
						echo $org_date;	
					 ?></td> 
                                    <td><?php

$cityy = $conn->prepare("SELECT * FROM dvi_cities where id =?");
$cityy->execute(array($row_spro['sty_city']));
$row_cityy = $cityy->fetch(PDO::FETCH_ASSOC);
$totalRows_cityy = $cityy->rowCount();
									
									 echo  $row_cityy['name'];?></td>
                                     <td>
                                     <?php 
									  
$hotell = $conn->prepare("SELECT * FROM hotel_pro where hotel_id =?");
$hotell->execute(array($row_spro['hotel_id']));
$row_hotell = $hotell->fetch(PDO::FETCH_ASSOC);
$totalRows_hotell = $hotell->rowCount();
echo $row_hotell['hotel_name'];
									 ?>
                                     </td>
                                     <td>
                                     <?php 
									$rrom=explode(',',$row_spro['sty_room_name']);
									$rrom1=array_unique($rrom);
									$rrom1=array_values($rrom1);
									$rrom2=array_count_values($rrom);
									
									for($tt=0;$tt<count($rrom1);$tt++)
									{
//									 
//$query_hroom = "SELECT * FROM hotel_season where sno = '".$rrom1[$tt]."'";
//$hroom = mysql_query($query_hroom, $divdb) or die(mysql_error());
//$row_hroom = mysql_fetch_assoc($hroom);
//$totalRows_hroom = mysql_num_rows($hroom);
if(isset($rrom1[$tt+1]) && $rrom1[$tt+1] !='')
{
	echo $rrom1[$tt]." - ".$rrom2[$rrom1[$tt]].",<br>"; 
}else
{
	echo $rrom1[$tt]." - ".$rrom2[$rrom1[$tt]]; 
}
									}?>
                                     </td><td><?php
									 //food items
									 if($row_spro['sty_food']=='dinner_rate')
									 {
										echo "Dinner"; 
									 }else if($row_spro['sty_food']=='lunch_rate')
									 {
										 echo "Lunch"; 
									 }else if($row_spro['sty_food']=='both_food')
									 {
										 echo "Lunch & Dinner"; 
									 }else{
										echo "Breakfast"; 
									 }
									  ?></td>
                                     </tr>
                                    <?php 
									$scnt++; }  ?>
                                    </table>
                                   <!-- <p align="left" style="font-size:12px; color:#900"> * Breakfast complimentory throughout your stay</p>-->
                                  
                                    </div>  <?php } // if only for hotel ?>
                                    <div>
                                    <br />
                                     <?php

$sspro = $conn->prepare("SELECT * FROM stay_sched where stay_id =? ORDER BY sno ASC ");
$sspro->execute(array($_GET['planid']));
//$row_sspro = mysql_fetch_assoc($sspro);
//$row_sspro_main=$sspro->fetchAll();
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
		
		 $dt_arr[$row_dtcity1['name']][0] = $row_dtcity2['name'];
		 $dt_arr[$row_dtcity1['name']]['id'] = $row_dtcity2['id'];

	}
	
}
//daytrip end

//my end

$sspro15 = $conn->prepare("SELECT * FROM stay_sched where stay_id =? ORDER BY sno ASC ");
$sspro15->execute(array($_GET['planid']));
//$row_sspro15 = mysql_fetch_assoc($sspro15);
$row_sspro15=$sspro15->fetch(PDO::FETCH_ASSOC);
$totalRows_sspro15 = $sspro15->rowCount();		
					            

$trv = $conn->prepare("SELECT * FROM travel_sched where travel_id =? ORDER BY sno ASC");
$trv->execute(array($_GET['planid']));
//$row_trv = mysql_fetch_assoc($trv);
//$row_trv_main =$trv->fetchAll();
$totalRows_trv = $trv->rowCount();
$chn=0; 
$hots_desc_arr=array();
								if($totalRows_trv>0){	?>
                                    <span style="color:#666; font-size:18px; text-align:center"><center><u>Tour Itinerary Plan (Program schedule)</u></center></span><span><center>Specially prepared for <?php echo $row_orders['tr_name'];?></center></span>
                                    <br />
                                    <?php }
									
									if($totalRows_sspro15>0)
									{
									?>
                                    
                                    <div class="col-sm-12">
                                     <?php while($totalRows_trv>0){
										$row_trv = $trv->fetch(PDO::FETCH_ASSOC);
										
										if($row_count>0)
										{//for stay table - aft end day calculation
										$row_sspro = $sspro->fetch(PDO::FETCH_ASSOC);
										
										
										$spot_ids='-';
										
										?>
                                    <div class="col-sm-2" style="margin-top:15px; border-top:solid #DADADA 1px">
                                   
                                    <span style="color:#000; font-weight:600;">
                                    <?php
									if($row_trv['tr_date'] == $row_sspro['sty_date'])
									{
										echo $desc_date=date('d-M-Y D',strtotime(str_replace('-','/',$row_trv['tr_date'])));
										$hots_desc_arr['ondate']=$desc_date;
									}
									?>
                                    </span>
                                    </div>
                                    <div class="col-sm-10" style="margin-top:15px; border-top:solid #DADADA 1px; text-align:justify">
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
                                    
                                    <span style="color:#000;  font-size:14px; font-weight:600"> <?php if($chn=='0'){?>Arrival - <?php }?> <?php echo $row_trv['tr_from_cityid'];if($chn=='0'){echo " [ ".$row_orders['tr_arrdet']." @".$row_orders['tr_arr_time']." ]";}
									$hots_desc_arr[$desc_date]['fcid']=$row_cityy1['id']; 
									$hots_desc_arr[$desc_date]['tcid']=$row_cityy_to['id']; 
									
									//print_r($hots_desc_arr);
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
												echo "&nbsp;&nbsp;-&nbsp;&nbsp;".$row_via_cty['name'];
												
											}
										}
									}
									$hots_desc_arr[$desc_date]['via']=$row_trv['via_cities'];
										}//no empty via
										else{
									$hots_desc_arr[$desc_date]['via']='-';		
										}
										
									//via edit end
									
									echo "&nbsp;&nbsp;-&nbsp;&nbsp;".$row_trv['tr_to_cityid'];
									if($row_trv['tr_dist_ss']>0)
									{
										if(isset($dt_arr[$row_trv['tr_from_cityid']][0]) && $chn!=0 && in_array($chn,$dt_cnt_arr)){
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
									$today_dist=$row_trv['ss_dist'];
									echo "";
									}?></span><br /><span><?php //echo $totalRows_hot; 
//hotel chng new place
$hotel2 = $conn->prepare("SELECT * FROM hotel_pro where hotel_id =?");
$hotel2->execute(array($row_sspro['hotel_id']));
$row_hotel2 = $hotel2->fetch(PDO::FETCH_ASSOC);
$totalRows_hotel2 = $hotel2->rowCount();								
									
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
	
	$time6am=date('U',strtotime($row_orders['tr_arr_date'].' 12:00 AM'));
	$time3pm=date('U',strtotime($row_orders['tr_arr_date'].' 03:00 PM'));
	$time6pm=date('U',strtotime($row_orders['tr_arr_date'].' 06:00 PM'));
	
				if($row_trv['tr_from_cityid']==$row_trv['tr_to_cityid'])
				{//next day also same city means
						if($time6am <= $arr_date_tstmp && $arr_date_tstmp <= $time3pm)
						{//between 6am to 3pm ( over night in same city)
					
							echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid'].", proceed to hotel. Check in ( 12:00 noon - standard time) at hotel, refresh and later proceed to sight-seeing including - ";
						$hots_array=array();
									$vg=0;
									$hot_with_sep='';
									foreach($row_hot_main as $row_hot){
										   $hots_array[$vg]=$row_hot['spot_name'];
										   $hots_with_id[$vg]=$row_hot['hotspot_id'];
										   $vg++;
										} 
										
										$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_from_cityid']]);
										$hot_with_sep='';
				for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<$tot_div_hot+$rem_area_cnt[$row_trv['tr_from_cityid']];$hs++)
										{
											echo $hots_array[$hs].', ';
											
											if($hot_with_sep!='')
											{
												$hot_with_sep=$hot_with_sep.','.$hots_with_id[$hs];
											}else{
												$hot_with_sep=$hots_with_id[$hs];
											}
											
										}
										
										$hots_desc_arr[$desc_date]['spot_id']=$hot_with_sep;
										$rem_area_cnt[$row_trv['tr_from_cityid']]=$rem_area_cnt[$row_trv['tr_from_cityid']]+$tot_div_hot;
										$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-1;
										
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
														echo $row_via_hspots['spot_name'];
														
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
							
							echo " and later return to ".$row_hotel2['hotel_name']." and overnight stay at hotel.";
						}else if($time3pm <= $arr_date_tstmp && $arr_date_tstmp <= $time6pm)
						{//between 6am to 3pm ( over night in same city)
							echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid']." and proceed to hotel, check-in and overnight at ".$row_hotel2['hotel_name'];//have to show sight-seeing in next day
							$show_in_next_day=2;
								$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-2;
								$hots_desc_arr[$desc_date]['spot_id']='-';
						}else if($time6pm <= $arr_date_tstmp && $arr_date_tstmp <= $arr_timenx6am)
						{//between 6am to 3pm ( over night in same city)
							echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid'].", proceed to hotel, check-in and overnight stay at ".$row_hotel2['hotel_name']." hotel.";//have to show sight-seeing in next day
							$show_in_next_day=2;
							$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-2;
							$hots_desc_arr[$desc_date]['spot_id']='-';
						}
						// daytrip not applicable for arrival
						
				}else{//next day having different city means
					if($time6am <= $arr_date_tstmp && $arr_date_tstmp <= $time3pm)
						{//between 6am to 3pm ( over night in diff city)
					echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid'].", proceed to sight-seeing including - ";
						$hots_array=array();
						$hots_with_id=array();
									$vg=0;
									
									foreach($row_hot_main as $row_hot){
										   $hots_array[$vg]=$row_hot['spot_name'];
										   $hots_with_id[$vg]=$row_hot['hotspot_id'];
										   $vg++;
										} 
										
										$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_from_cityid']]);
				for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<$tot_div_hot+$rem_area_cnt[$row_trv['tr_from_cityid']];$hs++)
										{
											  echo $hots_array[$hs].', ';
											  
											  
											   if($spot_ids!='-')
											   {
												   $spot_ids=$spot_ids.",".$hots_with_id[$hs];
											   }else{
												   $spot_ids=$hots_with_id[$hs];
											   }
										}
										$hots_desc_arr[$desc_date]['spot_id']=$spot_ids;
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
														
															if($spot_ids!='-')
										   					{
											   					$spot_ids=$spot_ids.",".$row_hot['hotspot_id'];
										  				 	}else{
											   					$spot_ids=$row_hot['hotspot_id'];
										  				 	}
													}
												}
											}
										}
									}
										}
										  $hots_desc_arr[$desc_date]['spot_id']=$spot_ids;
										  
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
								foreach($row_hot1_main as $row_hot1){
										   $hots_array[$vg]=$row_hot1['spot_name'];
										   $hots_with_id[$vg]=$row_hot1['hotspot_id'];
										   $vg++;
										} 
							
								$area_cnt[$row_trv['tr_to_cityid']]=$area_cnt[$row_trv['tr_to_cityid']]+1;
								$copy_area_arr[$row_trv['tr_to_cityid']]=$copy_area_arr[$row_trv['tr_to_cityid']]+1;
										
										$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_to_cityid']]);	
										
										$hot_with_sep='';
				for($hs1=$rem_area_cnt[$row_trv['tr_to_cityid']];$hs1<($tot_div_hot+$rem_area_cnt[$row_trv['tr_to_cityid']]);$hs1++)
										{
											echo $hots_array[$hs1].', ';
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
							//$hots_desc_arr[$desc_date]['spot_id']=$spot_ids;
							echo "and later drive to ".$row_trv['tr_to_cityid'].", check-in and overnight stay at ".$row_hotel2['hotel_name']." hotel.";
							
							
							//print_r($hots_desc_arr);
	
						}else if($time3pm <= $arr_date_tstmp && $arr_date_tstmp <= $time6pm)
						{//between 3pm to 6pm ( over night in diff city)
						echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid'].". ";
						
						if($totalRows_hot>0){ 
						echo "If time permits proceed to sight-seeing including - ";
						
						$hots_array=array();
						$hots_with_id=array();
									$vg=0;
									
									foreach($row_hot_main as $row_hot){
										   $hots_array[$vg]=$row_hot['spot_name'];
										    $hots_with_id[$vg]=$row_hot['hotspot_id'];
											$vg++;
										} 
										
										$hot_with_sep='';
										$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_from_cityid']]);
				for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<($tot_div_hot+$rem_area_cnt[$row_trv['tr_from_cityid']]);$hs++)
										{
											echo $hots_array[$hs].', ';
											
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
									
										if(trim($row_trv['via_cities'])!='' && trim($row_trv['via_cities'])!='-')
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
															
															if($spot_ids!='-')
										   					{
											   					$spot_ids=$spot_ids.",".$row_via_hspots['hotspot_id'];
										  				 	}else{
											   					$spot_ids=$row_via_hspots['hotspot_id'];
										  				 	}
													}
												}
											}
										}
									}
									$hots_desc_arr[$desc_date]['spot_id']=$hot_with_sep.','.$spot_ids;
										}
									//via edit end
						
						echo "and ";
						}//more hot spot
						echo " later drive to ".$row_trv['tr_to_cityid'].", check-in and overnight stay at ".$row_hotel2['hotel_name']." hotel.";
							//print_r($hots_desc_arr);
						}else if($time6pm <= $arr_date_tstmp && $arr_date_tstmp <= $arr_timenx6am)
						{//between 6am to 3pm ( over night in diff city)
						echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid']." and proceed to ".$row_trv['tr_to_cityid'].", check-in and Overnight stay at ".$row_hotel2['hotel_name']." hotel.";//skip sight-seeing and proceed to next day if
						
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
										$hots_desc_arr[$desc_date]['spot_id']='-';
									///	print_r($hots_desc_arr);
						}
				}
}//if end -$totalRows_trv_new count 

									}//for first day
									else // for other days
									{
											if(!empty($dt_arr) && $chn != 0 && in_array($chn,$dt_cnt_arr))
								 {
									 if(isset($dt_arr[$row_trv['tr_from_cityid']][0]))
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
									$hots_with_id=array();
									$vg=0;
									foreach($row_hot_main as $row_hot){
										   $hots_array[$vg]=$row_hot['spot_name'];
										   $hots_with_id[$vg]=$row_hot['hotspot_id'];
										   $vg++;
										} 
											
										if(isset($show_in_next_day) && $show_in_next_day==2)
										{
											$show_in_next_day=3;
											$tot_div_hot=floor(count($hots_array)/($area_cnt[$row_trv['tr_from_cityid']]-1));
										}else{
										$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_from_cityid']]);	
										}
									$hot_with_sep='';	
				for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<$tot_div_hot+$rem_area_cnt[$row_trv['tr_from_cityid']];$hs++)
										{
											if(isset($hots_array[$hs]))
											{
											echo $hots_array[$hs].', ';
											
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
								
								
							//via edit start
										if(trim($row_trv['via_cities'])!='' && trim($row_trv['via_cities'])!='-')
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
														
															if($spot_ids!='-')
										   					{
											   					$spot_ids=$spot_ids.",".$row_via_hspots['hotspot_id'];
										  				 	}else{
											   					$spot_ids=$row_via_hspots['hotspot_id'];
										  				 	}
													}
												}
											}
										}
									}
											$hots_desc_arr[$desc_date]['spot_id']=$hot_with_sep.','.$spot_ids;
										}else{
											$hots_desc_arr[$desc_date]['spot_id']=$hot_with_sep;
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
								foreach($row_hot1_main as $row_hot1){
										   $hots_array[$vg]=$row_hot1['spot_name'];
										   $hots_with_id[$vg]=$row_hot1['hotspot_id'];
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
										
										$hot_with_sep='';
				for($hs1=$rem_area_cnt[$row_trv['tr_to_cityid']];$hs1<$tot_div_hot+$rem_area_cnt[$row_trv['tr_to_cityid']];$hs1++)
										{
											echo $hots_array[$hs1].', ';
											
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
									$hot_with_sep='';
							if(($totalRows_trv ==2 && $dept_date_tstmp1<$dept_time4pm1))
							{
								for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<count($hots_array);$hs++)
								{
															echo $hots_array[$hs].', ';//for final day
															
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
										//print_r($hots_desc_arr);
										?></span>
                                      
                                        <?php
							if($row_trv['tr_from_cityid'] == $row_trv['tr_to_cityid'])
							{

								 echo "and later return to hotel. Overnight stay at ".$row_hotel2['hotel_name']." hotel.";
								 // daytrip goes here
								 if(!empty($dt_arr))
								 {

									 if(isset($dt_arr[$row_trv['tr_from_cityid']][0]) && !is_numeric($dt_arr[$row_trv['tr_from_cityid']][0]))
									 {
		 echo "<br><span style='font-weight:bold; color:green'>"."DAYTRIP applicable to ".$dt_arr[$row_trv['tr_from_cityid']][0]." :</span>";
		 							 
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
								 }
							}else{
								 echo "and later proceed to ".$row_trv['tr_to_cityid'].". Overnight stay at ".$row_hotel2['hotel_name']." hotel. ";
								 } }
								 
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
                                        <?php } 
										?>
                                    </div>
                                  
                                     <?php
									
									 $chn++;
										}//inner hotel while end
										else{?>
											<div class="col-sm-2" style="margin-top:15px; border-top:solid #DADADA 1px">
                                   
                                    <span style="color:#000; font-weight:600;">
										<?php
                                        if($row_trv['tr_date'] != '')
                                        {
                                            echo $desc_eddate=date('d-M-Y D',strtotime(str_replace('-','/',$row_trv['tr_date'])));
											$hots_desc_arr['ondate']=$desc_eddate;
                                        }
                                        ?>
                                    </span>
                                    </div>
                                    <div class="col-sm-10" style="margin-top:15px; border-top:solid #DADADA 1px; text-align:justify">
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
                                    
                                    <span style="color:#000;  font-size:14px; font-weight:600"> <?php echo $row_trv['tr_from_cityid']."&nbsp;&nbsp;";
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
												echo "&nbsp;&nbsp;-&nbsp;&nbsp;".$row_via_cty['name'];
											}
										}
									}
										}//no empty via
									//via edit end
									
									echo "-&nbsp;&nbsp;".$row_trv['tr_to_cityid']."&nbsp;( Departure )  [ ".$row_orders['tr_depdet']."&nbsp; @".$row_orders['trv_depatr_time']." ]";
									$hots_desc_arr[$desc_eddate]['fcid']=$row_cityy1['id'];
									$hots_desc_arr[$desc_eddate]['tcid']=$row_cityy_to['id'];
									$hots_desc_arr[$desc_eddate]['via']=$row_trv['via_cities'];
									if($row_trv['tr_dist_ss']>0)
									{
									echo " (".$row_trv['tr_dist_ss']." Kms)";
									$today_dist=$row_trv['tr_dist_ss'];
									}else{
$ss_dist = $conn->prepare("SELECT * FROM dvi_cities where id=?");
$ss_dist->execute(array($row_cityy_to['id']));
$row_ss_dist=$ss_dist->fetch(PDO::FETCH_ASSOC);
$totalRows_ss_dist = $ss_dist->rowCount();	
									//echo " (".$row_ss_dist['ss_dist']." Kms)";
									$today_dist=$row_trv['ss_dist'];
									echo "";
									}
									?></span><br />
                                    
                                    <?php echo "After breakfast check out hotel"; 
									//time calculation 
									
	$dept_date_time=$row_trv['tr_date'].' '.$row_orders['trv_depatr_time'];
	$dept_date_tstmp=date('U',strtotime($dept_date_time));
	$dept_time4pm=date('U',strtotime($row_trv['tr_date'].' 04:00 PM'));//for next day morning - arrival
									
									if($dept_date_tstmp>=$dept_time4pm)
									{//departure time is within 4-pm - show hot spots
									echo ", and proceed to sight-seeing including - ";
										$hots_array=array();
										$hots_with_id=array();
										$vg=0;
										foreach($row_hot_main as $row_hot){
										   $hots_array[$vg]=$row_hot['spot_name'];
										   $hots_with_id[$vg]=$row_hot['hotspot_id'];
										   $vg++;
										} 
										
										if(isset($show_in_next_day) && $show_in_next_day==2)
										{
											$show_in_next_day=3;
											$tot_div_hot=floor(count($hots_array)/($area_cnt[$row_trv['tr_from_cityid']]-1));
										}else{
											$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_from_cityid']]);	
										}
										$hot_with_sep='';
									for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<floor(count($hots_array));$hs++)
										{
											if(isset($hots_array[$hs]))
											{
												echo $hots_array[$hs].', ';
															
															if($hot_with_sep!='')
															{
																$hot_with_sep=$hot_with_sep.','.$hots_with_id[$hs];
															}else{
																$hot_with_sep=$hots_with_id[$hs];
															}
											}
										}
										$hots_desc_arr[$desc_eddate]['spot_id']=$hot_with_sep;
										
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

												$spot_ids='-';
												if($totalRows_via_hspots>0)
												{
													foreach($row_via_hspots_main as $row_via_hspots)
													{
														echo $row_via_hspots['spot_name'];
														
															if($spot_ids!='-')
										   					{
											   					$spot_ids=$spot_ids.",".$row_via_hspots['hotspot_id'];
										  				 	}else{
											   					$spot_ids=$row_via_hspots['hotspot_id'];
										  				 	}
														
													}
												}
												$hots_desc_arr[$desc_eddate]['spot_id']=$hots_desc_arr[$desc_eddate]['spot_id'].','.$spot_ids;
											}
										}
									}
									
										}
									//via edit end
										echo "finally, we transfer you to ".$row_trv['tr_to_cityid']." airport/railway station.";
										
									}else{
										//departure time is not within 4-pm - dont show hot spots
										echo " and we transfer you to ".$row_trv['tr_to_cityid']." airport/railway station.";
										$hots_desc_arr[$desc_eddate]['spot_id']='-';
									}
									
									//print_r($hots_desc_arr);
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
									
                                    </div>
										<?php }
										 
										$row_count--;
									$totalRows_trv--;
									//$row_count--;
									 }
									//print_r($rem_area_cnt); ?>
                                    </div>
                                    
                                    <?php }else{// if stay_sched having no entry ( if the itinerary was rejected before booking hotel show only transport)
										
										$chn=0; 
$trv_cnt_1 = $totalRows_trv - 1;
										?>
                                    <div class="col-sm-12">
                                    <p align="center" style="color:#900">Before hotel booking, this itinerary was rejected/Saved..</p>
                                     <?php while($totalRows_trv>0){
										$row_trv = $trv->fetch(PDO::FETCH_ASSOC);
										
										if($trv_cnt_1>0)
										{//for stay table - aft end day calculation
										
										?>
                                    <div class="col-sm-2" style="margin-top:15px; border-top:solid #DADADA 1px">
                                   
                                    <span style="color:#000; font-weight:600;">
                                    <?php
										echo $desc_date=date('d-M-Y D',strtotime(str_replace('-','/',$row_trv['tr_date'])));
										$hots_desc_arr['ondate']=$desc_date;
									?>
                                    </span>
                                    </div>
                                    <div class="col-sm-10" style="margin-top:15px; border-top:solid #DADADA 1px; text-align:justify">
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
                                    
                                    <span style="color:#000;  font-size:14px; font-weight:600"> <?php if($chn=='0'){?>Arrival - <?php }?> <?php echo $row_trv['tr_from_cityid'];if($chn=='0'){echo " [ ".$row_orders['tr_arrdet']." @".$row_orders['tr_arr_time']." ]";}
									
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
												echo "&nbsp;&nbsp;-&nbsp;&nbsp;".$row_via_cty['name'];
											}
										}
									}
										}//no empty via
									//via edit end
									
									echo "&nbsp;&nbsp;-&nbsp;&nbsp;".$row_trv['tr_to_cityid'];
									if($row_trv['tr_dist_ss']>0)
									{
									echo " (".$row_trv['tr_dist_ss']." Kms)";
									$today_dist=$row_trv['tr_dist_ss'];
									}else{
$ss_dist = $conn->prepare("SELECT * FROM dvi_cities where id=?");
$ss_dist->execute(array($row_cityy_to['id']));
$row_ss_dist=$ss_dist->fetch(PDO::FETCH_ASSOC);
$totalRows_ss_dist = $ss_dist->rowCount();	
									//echo " (".$row_ss_dist['ss_dist']." Kms)";
									echo "";
									$today_dist=$row_trv['ss_dist'];
									}?></span><br /><span><?php //echo $totalRows_hot; 
//hotel chng new place
$hots_desc_arr[$desc_date]['fcid']=$row_cityy1['id'];
$hots_desc_arr[$desc_date]['tcid']=$row_cityy_to['id'];
$hots_desc_arr[$desc_date]['via']=$row_trv['via_cities'];
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
	
	$time6am=date('U',strtotime($row_orders['tr_arr_date'].' 12:00 AM'));
	$time3pm=date('U',strtotime($row_orders['tr_arr_date'].' 03:00 PM'));
	$time6pm=date('U',strtotime($row_orders['tr_arr_date'].' 06:00 PM'));
	
				if($row_trv['tr_from_cityid']==$row_trv['tr_to_cityid'])
				{//next day also same city means
						if($time6am <= $arr_date_tstmp && $arr_date_tstmp <= $time3pm)
						{//between 6am to 3pm ( over night in same city)
					
							echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid'].". Check in ( 12:00 noon - standard time) at hotel, refresh and later proceed to sight-seeing including - ";
						$hots_array=array();
						$hots_with_id=array();
									$vg=0;
									foreach($row_hot_main as $row_hot){
										   $hots_array[$vg]=$row_hot['spot_name'];
										   $hots_with_id[$vg]=$row_hot['hotspot_id'];
										   $vg++;
										} 
										$hot_with_sep='';
										$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_from_cityid']]);
				for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<$tot_div_hot+$rem_area_cnt[$row_trv['tr_from_cityid']];$hs++)
										{
											echo $hots_array[$hs].', ';
											
												if($hot_with_sep!='')
												{
													$hot_with_sep=$hot_with_sep.','.$hots_with_id[$hs];
												}else{
													$hot_with_sep=$hots_with_id[$hs];
												}
										}
										
										$hots_desc_arr[$desc_date]['spot_id']=$hot_with_sep;
										$rem_area_cnt[$row_trv['tr_from_cityid']]=$rem_area_cnt[$row_trv['tr_from_cityid']]+$tot_div_hot;
										$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-1;
										
										$hot_with_sep='';
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
														
														if($hot_with_sep!='')
														{
															$hot_with_sep=$hot_with_sep.','.$row_via_hspots['hotspot_id'];
														}else{
															$hot_with_sep=$row_via_hspots['hotspot_id'];
														}
													}
												}
											}
										}
									}
										$hots_desc_arr[$desc_date]['spot_id']=$hots_desc_arr[$desc_date]['spot_id'].','.$hot_with_sep;
										}
									//via edit end
							
							echo " and later return to hotel and overnight stay at hotel.";
						}else if($time3pm <= $arr_date_tstmp && $arr_date_tstmp <= $time6pm)
						{//between 6am to 3pm ( over night in same city)
							echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid']." and proceed to hotel, check-in and overnight at hotel.";//have to show sight-seeing in next day
							$show_in_next_day=2;
								$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-2;
								$hots_desc_arr[$desc_date]['spot_id']='-';
						}else if($time6pm <= $arr_date_tstmp && $arr_date_tstmp <= $arr_timenx6am)
						{//between 6am to 3pm ( over night in same city)
							echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid'].", proceed to hotel, check-in and overnight stay at hotel.";//have to show sight-seeing in next day
							$show_in_next_day=2;
							$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-2;
							$hots_desc_arr[$desc_date]['spot_id']='-';
						}
						// daytrip not applicable for arrival
						
				}else{//next day having different city means
					if($time6am <= $arr_date_tstmp && $arr_date_tstmp <= $time3pm)
						{//between 6am to 3pm ( over night in diff city)
					echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid'].", proceed to sight-seeing including - ";
						$hots_array=array();
						$hots_with_id=array();
									$vg=0;
									foreach($row_hot_main as $row_hot){
										   $hots_array[$vg]=$row_hot['spot_name'];
										   $hots_with_id[$vg]=$row_hot['hotspot_id'];
										   $vg++;
										} 
										
										$hot_with_sep='';
										$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_from_cityid']]);
				for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<$tot_div_hot+$rem_area_cnt[$row_trv['tr_from_cityid']];$hs++)
										{
											echo $hots_array[$hs].', ';
											
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
														echo $row_via_hspots['spot_name'];
															
															if($spot_ids!='-')
															{
																$spot_ids=$spot_ids.",".$row_via_hspots['hotspot_id'];
															}else{
																$spot_ids=$row_via_hspots['hotspot_id'];
															}
													}
												}
											}
										}
									}
											$hots_desc_arr[$desc_date]['spot_id']=$hots_desc_arr[$desc_date]['spot_id'].','.$spot_ids;
										}
									//via edit end
									
									//for first day - in diff city within 180km means show hotspots if the arrival time inbetween 11 clock
									
								$time11am=date('U',strtotime($row_orders['tr_arr_date'].' 11:00 AM'));	
								if($time11am >= $arr_date_tstmp)//within 11:00AM arrival means
								{
							if(($row_trv['tr_from_cityid'] != $row_trv['tr_to_cityid']) && $row_distanc['dist']<=180)
							{
								
$hot1= $conn->prepare("SELECT * FROM hotspots_pro where spot_city =? ORDER BY spot_prior ASC");
$hot1->execute(array($row_cityy_to['id']));
//$row_hot1 = mysql_fetch_assoc($hot1);
$row_hot1_main=$hot1->fetchAll();
$totalRows_hot1 = $hot1->rowCount();
								$hots_array=array();
								$hots_with_id=array();
								$vg=0;
								foreach($row_hot1_main as $row_hot1){
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
											echo $hots_array[$hs1].', ';
											
												if($hot_with_sep!='')
												{
													$hot_with_sep=$hot_with_sep.','.$hots_with_id[$hs1];
												}else{
													$hot_with_sep=$hots_with_id[$hs1];
												}

										}
										$rem_area_cnt[$row_trv['tr_to_cityid']]=$rem_area_cnt[$row_trv['tr_to_cityid']]+$tot_div_hot;
										$copy_area_arr[$row_trv['tr_to_cityid']]=$copy_area_arr[$row_trv['tr_to_cityid']]-1;
										
										$hots_desc_arr[$desc_date]['spot_id']=$hot_with_sep;
							}
								}//within 11:00AM arrival means if- end
							
							echo "and later drive to ".$row_trv['tr_to_cityid'].", check-in and overnight stay at hotel.";
	
						}else if($time3pm <= $arr_date_tstmp && $arr_date_tstmp <= $time6pm)
						{//between 3pm to 6pm ( over night in diff city)
						echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid'].". ";
						
						if($totalRows_hot>0){ 
						echo "If time permits proceed to sight-seeing including - ";
						
						$hots_array=array();
						$hots_with_id=array();
									$vg=0;
									foreach($row_hot_main as $row_hot){
										   $hots_array[$vg]=$row_hot['spot_name'];
										   $hots_with_id[$vg]=$row_hot['hotspot_id'];
										   $vg++;
										} 
										
										$hot_with_sep='';
										$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_from_cityid']]);
				for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<$tot_div_hot+$rem_area_cnt[$row_trv['tr_from_cityid']];$hs++)
										{
											echo $hots_array[$hs].', ';
											
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
														echo $row_via_hspots['spot_name'];
														
														if($spot_ids!='-')
														{
															$spot_ids=$spot_ids.",".$row_via_hspots['hotspot_id'];
														}else{
															$spot_ids=$row_via_hspots['hotspot_id'];
														}
													}
												}
											}
										}
									}
									$hots_desc_arr[$desc_date]['spot_id']=$hots_desc_arr[$desc_date]['spot_id'].','.$spot_ids;
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
						$hots_with_id=array();
									$vg=0;
									foreach($row_hot_main as $row_hot){
										   $hots_array[$vg]=$row_hot['spot_name'];
										   $hots_with_id[$vg]=$row_hot['hotspot_id'];
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
										if($row_trv['tr_from_cityid'] == $row_trv['tr_to_cityid'])
										{
											echo "After breakfast ";
										}else{//different ending city means show the ending city hotspot
											echo "After breakfast check out hotel and";
										}
									 
									
									if($totalRows_hot>0){ 
									echo " proceed to sight-seeing including - ";
									$hots_array=array();
									$hots_with_id=array();
									$vg=0;
									foreach($row_hot_main as $row_hot){
										   $hots_array[$vg]=$row_hot['spot_name'];
										   $hots_with_id[$vg]=$row_hot['hotspot_id'];
										   $vg++;
										} 
										
										if(isset($show_in_next_day) && $show_in_next_day==2)
										{
											$show_in_next_day=3;
											$tot_div_hot=floor(count($hots_array)/($area_cnt[$row_trv['tr_from_cityid']]-1));
										}else{
										$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_from_cityid']]);	
										}
										
										$hot_with_sep='';
				for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<$tot_div_hot+$rem_area_cnt[$row_trv['tr_from_cityid']];$hs++)
										{
											if(isset($hots_array[$hs]))
											{
											echo $hots_array[$hs].', ';
											
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
														echo $row_via_hspots['spot_name'];
														
														if($spot_ids!='-')
														{
															$spot_ids=$spot_ids.",".$row_via_hspots['hotspot_id'];
														}else{
															$spot_ids=$row_via_hspots['hotspot_id'];
														}

													}
												}
											}
										}
									}
									$hots_desc_arr[$desc_date]['spot_id']=$hots_desc_arr[$desc_date]['spot_id'].','.$spot_ids;
										}
									//via edit end
							
							//for ending city hotspot if ending in different city
							if(($row_trv['tr_from_cityid'] != $row_trv['tr_to_cityid']) && $row_distanc['dist']<=180)
							{
								
$hot1= $conn->prepare("SELECT * FROM hotspots_pro where spot_city =? ORDER BY spot_prior ASC");
$hot1->execute(array($row_cityy_to['id']));
//$row_hot1 = mysql_fetch_assoc($hot1);
$row_hot1_main=$hot1->fetchAll();
$totalRows_hot1 = $hot1->rowCount();
								$hots_array=array();
								$hots_with_id=array();
								$vg=0;
								foreach($row_hot1_main as $row_hot1){
										   $hots_array[$vg]=$row_hot1['spot_name'];
										   $hots_with_id[$vg]=$row_hot1['hotspot_id'];
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
				$hot_with_sep='';						
				for($hs1=$rem_area_cnt[$row_trv['tr_to_cityid']];$hs1<$tot_div_hot+$rem_area_cnt[$row_trv['tr_to_cityid']];$hs1++)
										{
											echo $hots_array[$hs1].', ';
											
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
											echo $hots_array[$hs].', ';//for final day
											
											if($hot_with_sep!='')
											{
												$hot_with_sep=$hot_with_sep.','.$hots_with_id[$hs];
											}else{
												$hot_with_sep=$hots_with_id[$hs];
											}
											
				}
				$hots_desc_arr[$desc_date]['spot_id']=$hots_desc_arr[$desc_date]['spot_id'].','.$hot_with_sep;
							}
										} ?></span>
                                      
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
							}
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
                                        <?php } 
										?>
                                    </div>
                                     <?php
									 $chn++;
										}//inner hotel while end
										else{ ?>
											<div class="col-sm-2" style="margin-top:15px; border-top:solid #DADADA 1px">
                                   
                                    <span style="color:#000; font-weight:600;">
                                    <?php
									if($row_trv['tr_date'] != '')
									{
										echo $desc_date=date('d-M-Y D',strtotime(str_replace('-','/',$row_trv['tr_date'])));
										$hots_desc_arr['ondate']=$desc_date;
									}
									?>
                                    </span>
                                    </div>
                                    <div class="col-sm-10" style="margin-top:15px; border-top:solid #DADADA 1px; text-align:justify">
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





$hot= $conn->prepare("SELECT * FROM hotspots_pro where spot_city =? ORDER BY spot_prior ASC");
$hot->execute(array($row_cityy1['id']));
//$row_hot = mysql_fetch_assoc($hot);
$row_hot_main=$hot->fetchAll();
$totalRows_hot = $hot->rowCount();
									?>
                                    
                                    <span style="color:#000;  font-size:14px; font-weight:600"> <?php echo $row_trv['tr_from_cityid']."&nbsp;&nbsp;-&nbsp;&nbsp;".$row_trv['tr_to_cityid'];
									
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
												echo "&nbsp;&nbsp;-&nbsp;&nbsp;".$row_via_cty['name'];
											}
										}
									}
										}//no empty via
									//via edit end
									
									echo "&nbsp;( Departure )  [ ".$row_orders['tr_depdet']."&nbsp; @".$row_orders['trv_depatr_time']." ]";
									
									if($row_trv['tr_dist_ss']>0)
									{
									echo " (".$row_trv['tr_dist_ss']." Kms)";
									$today_dist=$row_trv['tr_dist_ss'];
									}else{
$ss_dist = $conn->prepare("SELECT * FROM dvi_cities where id=?");
$ss_dist->execute(array($row_cityy_to['id']));
$row_ss_dist=$ss_dist->fetch(PDO::FETCH_ASSOC);
$totalRows_ss_dist = $ss_dist->rowCount();	
									//echo " (".$row_ss_dist['ss_dist']." Kms)";
									$today_dist=$row_trv['ss_dist'];
									echo "";
									}
									
$hots_desc_arr[$desc_date]['fcid']=$row_cityy1['id'];
$hots_desc_arr[$desc_date]['tcid']=$row_cityy_to['id'];
$hots_desc_arr[$desc_date]['via']=$row_trv['via_cities'];
									?></span><br />
                                    
                                    <?php echo "After breakfast check out hotel"; 
									//time calculation 
									
	$dept_date_time=$row_trv['tr_date'].' '.$row_orders['trv_depatr_time'];
	$dept_date_tstmp=date('U',strtotime($dept_date_time));
	$dept_time4pm=date('U',strtotime($row_trv['tr_date'].' 04:00 PM'));//for next day morning - arrival
									
									if($dept_date_tstmp>=$dept_time4pm)
									{//departure time is within 4-pm - show hot spots
									echo ", and proceed to sight-seeing including - ";
										$hots_array=array();
										$hots_with_id=array();
										$vg=0;
									foreach($row_hot_main as $row_hot){
										   $hots_array[$vg]=$row_hot['spot_name'];
										   $hots_with_id[$vg]=$row_hot['hotspot_id'];
										   $vg++;
										} 
										
										
										if(isset($show_in_next_day) && $show_in_next_day==2)
										{
											$show_in_next_day=3;
											$tot_div_hot=floor(count($hots_array)/($area_cnt[$row_trv['tr_from_cityid']]-1));
										}else{
											$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_from_cityid']]);	
										}
									
									$hot_with_sep='';	
				for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<floor(count($hots_array));$hs++)
										{
											if(isset($hots_array[$hs]))
											{
											echo $hots_array[$hs].', ';
												
												if($hot_with_sep!='')
												{
													$hot_with_sep=$hot_with_sep.','.$hots_with_id[$hs];
												}else{
													$hot_with_sep=$hots_with_id[$hs];
												}
											}
										}
										$hots_desc_arr[$desc_date]['spot_id']=$hot_with_sep;
										$rem_area_cnt[$row_trv['tr_from_cityid']]=$rem_area_cnt[$row_trv['tr_from_cityid']]+$tot_div_hot;
							$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-1;
										
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
														echo $row_via_hspots['spot_name'];
														
														if($spot_ids!='-')
														{
															$spot_ids=$spot_ids.",".$row_via_hspots['hotspot_id'];
														}else{
															$spot_ids=$row_via_hspots['hotspot_id'];
														}
													}
												}
											}
										}
									}
										$hots_desc_arr[$desc_date]['spot_id']=$hots_desc_arr[$desc_date]['spot_id'].','.$hot_with_sep;
										}
									//via edit end
										echo "finally, we transfer you to ".$row_trv['tr_to_cityid']." airport/railway station.";
									}else{
										//departure time is not within 4-pm - dont show hot spots
										echo " and we transfer you to ".$row_trv['tr_to_cityid']." airport/railway station.";
										$hots_desc_arr[$desc_date]['spot_id']='-';
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
									
                                    </div>
										<?php }
										 
										$trv_cnt_1--;
									$totalRows_trv--;
									//$row_count--;
									 }
									// print_r($hots_desc_arr);
									 
								 ?>
                                    </div>
                                    <?php }?>
                                    </div>
							</div><!-- /.row -->
						</div>
                   <div class="jumbotron jumbotron-sm " style="background-color:rgba(225, 220, 247, 0.24); color:#8388A9;">
								<strong>Head Office : </strong><strong>#51, Vijaya Nagar, Dheeran Nagar (Extn), Karumandapam, Trichirappalli, Tamilnadu - 620009</strong><br />
                                <strong>Ph : </strong><strong>0431-2403615 </strong><strong> H Phone :</strong><strong>9843288844</strong><strong> Windows Live ID : </strong><strong> <u>vsr@dvi.co.in</u></strong><br />
                                <strong>BRANCHES :: </strong><strong>MADURAI | COCHIN | HYDERABAD</strong>
							</div>
                            
                            <!-- Voucher start in -->
                            
                            <div class="the-box" style="vertical-align: text-middle; border:thin #666 1px;">
							                                     <?php

$sspro1 = $conn->prepare("SELECT * FROM stay_sched where stay_id =? ORDER BY sno ASC ");
$sspro1->execute(array($_GET['planid']));
//$row_sspro1 = mysql_fetch_assoc($sspro1);
//$row_sspro1_main =$sspro1->fetchAll();
$totalRows_sspro1 = $sspro1->rowCount();
if($totalRows_sspro1>0)
{
	$first_day=0;
	$last_day=1;
while($row_sspro1 = $sspro1->fetch(PDO::FETCH_ASSOC))
{
?>
                            <div class="row">
								<div class="col-sm-12 text-right">
									<img  src="../images/dvi_pdf.png"  height="75px" width="75px" alt="DVI Logo"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                      
                                    <hr style=" color: #443232;margin-top: 10px;margin-bottom: 10px" />
                                    <br />
								</div><!-- /.col-sm-6 -->
                                <div class="col-sm-12">
                                <div class="col-sm-6">
                                <div class="col-sm-7">
                                <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Voucher Date :</b>&nbsp;<b><?php echo $today;?></b></div>
                                <div class="col-sm-5"></div>
                                </div><div class="col-sm-6"> <div class="col-sm-2"></div><div class="col-sm-10"><b>Voucher No :</b>&nbsp;<b><?php echo $row_sspro1['sty_date']."/DVI-HTL-".$idd[1];?></b></div>
                                </div>
                               </div>
                                <div class="col-sm-12" align="center" style="margin-top:20px;">
               <table width="90%" >
               <tr><td colspan="2" class="tdstyle"><center>Hotel Exchange Voucher</center></td></tr>
               <tr><td width="50%" class="tdstyle">&nbsp;Guest Name</td><td width="50%" class="tdstyle" >&nbsp;<?php echo $guest_name." * ".$row_orders['pax_cnt']; ?></td></tr>
               
               
               <tr><td width="50%" class="tdstyle">&nbsp;Check In Date</td>
               <td width="50%" class="tdstyle" > <?php 
			   echo $old_date= date('d-M-Y',strtotime($row_sspro1['sty_date']));
			   
			   //my edit
								$flg=true;
								$nxt_chout=1;
$ssno=($row_sspro1['sno']+1);
										while($flg)
										{

$sy_ntx1= $conn->prepare("SELECT * FROM stay_sched where stay_id =? and hotel_id=? and sno=?");
$sy_ntx1->execute(array($_GET['planid'],$row_sspro1['hotel_id'],$ssno));
$row_sy_ntx1 = $sy_ntx1->fetch(PDO::FETCH_ASSOC);
$totalRows_sy_ntx1 = $sy_ntx1->rowCount();
if($totalRows_sy_ntx1>0 )
{
		++$nxt_chout;	
		$ssno++;
}else{
	$flg=false;
}
								}

$date=date_create($row_sspro1['sty_date']);
date_add($date,date_interval_create_from_date_string($nxt_chout." days"));
$next_datt=date_format($date,"d-M-Y");	
			
			   ?></td></tr>
               <tr><td width="50%" class="tdstyle">&nbsp;Check Out Date</td><td width="50%" class="tdstyle" > <?php echo $next_datt; ?></td></tr>
               <tr><td width="50%" class="tdstyle">&nbsp;Hotel Name</td>
               <td width="50%" class="tdstyle" ><?php
									  
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

echo $row_hotell['hotel_name'];
			?>
			 </td></tr>
               <tr><td width="50%" class="tdstyle">&nbsp;Hotel Address</td>
               <td width="50%" class="tdstyle" ><?php echo $row_hotell['location'].",&nbsp;".$row_cityy1['name'].",&nbsp;".$row_stt['name'];//."<br>Phone : ".$row_hotell['hotel_phone']; ?></td></tr>
               <tr><td width="50%" class="tdstyle">&nbsp;Accomodation</td><td width="50%"class="tdstyle" >&nbsp;<?php echo $row_orders['pax_adults']."-Adults, ".$row_orders['pax_512child']."-Child(5-12), ".$row_orders['pax_child']."-Child(below 5)"; ?></td></tr>
               <tr><td width="50%" class="tdstyle">&nbsp;Room Category</td>
               <td width="50%" class="tdstyle" > <?php
			
									$rrom=explode(',',$row_sspro1['sty_room_name']);
									$rrom1=array_unique($rrom);
									$rrom1=array_values($rrom1);
									//print_r($rrom1);
									$rrom2=array_count_values($rrom);
									//print_r($rrom2);
									
									for($tt=0;$tt<count($rrom1);$tt++)
									{
									 //
//$query_hroom = "SELECT * FROM hotel_season where sno = '".$rrom1[$tt]."'";
//$hroom = mysql_query($query_hroom, $divdb) or die(mysql_error());
//$row_hroom = mysql_fetch_assoc($hroom);
//$totalRows_hroom = mysql_num_rows($hroom);
if(isset($rrom1[$tt+1]) && $rrom1[$tt+1] !='')
{
	//echo $row_hroom['room_type']; 
	echo $rrom1[$tt]." - ".$rrom2[$rrom1[$tt]].",&nbsp;"; 
	$no_of_rrr=$rrom2[$rrom1[$tt]];
}else
{
	//echo $row_hroom['room_type']; 
	echo $rrom1[$tt]." - ".$rrom2[$rrom1[$tt]]; 
	$no_of_rrr=$rrom2[$rrom1[$tt]];
}
				}
			   ?></td></tr>
               <tr><td width="50%" class="tdstyle">&nbsp;Total Rooms</td>
               <td width="50%" class="tdstyle"> <?php echo $no_of_rrr; ?></td></tr>
               <tr><td width="50%" class="tdstyle">&nbsp;Extra Bed</td>
               <td width="50%" class="tdstyle"> <?php $extra_bed=explode(',',$row_sspro1['sty_child_bed']); 
			   //print_r($extra_bed);
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
				echo  "Extra with bed - ".$with_bd_ctn;
			   }
			   if($without_bd_ctn>0)
			   {
				 echo  "<br> Extra without bed - ".$without_bd_ctn;  
			   }
			   if($without_bd_ctn==0 && $with_bd_ctn==0)
			   {
				echo "Nil";   
			   }?></td></tr>
               <tr><td width="50%" class="tdstyle">&nbsp;Meal Plan</td>
               <td width="50%"class="tdstyle" > <?php 
									 //food items
									 if($row_sspro1['sty_food']=='dinner_rate')
									 {
										echo " Breakfast & Dinner only "; 
									 }else if($row_sspro1['sty_food']=='lunch_rate')
									 {
										 echo " Breakfast & Lunch only "; 
									 }else if($row_sspro1['sty_food']=='both_food')
									 {
										 echo " Breakfast,Lunch & Dinner "; 
									 }else{
										echo "Breakfast only"; 
									 }
									  ?>
			   </td></tr>
               <?php if(trim($row_sspro1['sty_extra']) != '') { 
			   $spl_amen=explode(',',$row_sspro1['sty_extra']);
			   ?>
			  
               <tr><td width="50%" class="tdstyle">&nbsp;Special Amenities</td>
               <td width="50%" class="tdstyle" ><?php
			    for($sa=0;$sa<count($spl_amen);$sa++){
			   if($spl_amen[$sa]=='candle_light')
			   { 
			   echo "Candle Light";
				}else if($spl_amen[$sa]=='fruit_basket')
				{
					echo "Fruit Basket";
				}else if($spl_amen[$sa]=='flower_bed')
				{
					echo "Flower Bed";
				}else if($spl_amen[$sa]=='cake_rate')
				{
					echo "Special Cake";
				}
				if(isset($spl_amen[$sa+1]))
				   {
			    	echo ",&nbsp;";
				   }
				}//for end
				 ?></td></tr>
               <?php //for end
			   }?>
               
               
               <tr><td width="50%" class="tdstyle">&nbsp;Billing</td><td width="50%"class="tdstyle" ><?php echo $row_sspro1['sty_date']."/DVI-HTL-".$idd[1];?></td></tr>
               <tr><td width="50%" class="tdstyle">&nbsp;Customer Care Numbers</td><td width="50%"class="tdstyle" > <?php
			   
$agent = $conn->prepare("SELECT * FROM agent_pro where agent_id =?");
$agent->execute(array($row_orders['agent_id']));
$row_agent = $agent->fetch(PDO::FETCH_ASSOC);
$totalRows_agent = $agent->rowCount();

			    //echo "24*7 @ Mr/Mrs. ".$row_agent['agent_fname']." ".$row_agent['agent_lname']."<br>".$row_agent['mobile_no']." / ".$row_agent['land_line']; 
				echo "24*7 @ All India Customer Care - 9047776899";?></td></tr>
               <tr><td width="50%" colspan="2" class="tdstyle"><center>DVI Holidays wishes you a pleasant stay</center></td></tr>
               </table>
                                </div>
                                <div class="col-sm-12" style="margin-top:20px;">
                                <div class="col-sm-8"></div>
                                <div class="col-sm-4"><br>
                                <?php // echo $row_orders['agent_id']; 
								echo "<strong style='font-size:10px'>Computer generated voucher doesn't required signature.</strong>";
								//echo $row_agent['agent_fname']." ".$row_agent['agent_lname']."&nbsp;(&nbsp;".$row_agent['mobile_no']."&nbsp;)";
								?></div>
                                
                                </div>
                                
                                <div class="col-sm-12" style="margin-top:20px; text-align:justify">
                                <b>General Policies</b><br>
                                <b>As per Government of India rules, it is mandatory for all guests over the age of 18 years to present a valid photo identification ( ID ) on check-in.</b><br>
                                <b>Entry to the hotel is at the sole discretion of the hotel authority. If the address on the photo identification card matches the city where the hotel is located, the hotel may refuse to provide accommodation.</b><br>
                                <b>Dvi will not be responsible for any check-in denied by the hotel due to the aforesaid reasons. Due to any natural or political or local issues if there is any damage to personal or tour, DVI ma not take the responsibility.</b><br>
                                <b>If the booking includes the extra bed it is facilitated with a folding cot or a mattress as an extra bed, as per the hotel policy.</b><br>
                                </div>
                                
                                <div class="col-sm-12 " style="background-color:rgba(234, 234, 236, 0.24); color:#8388A9; border-top:#666 solid 2px; border-bottom:#000 solid 2px; margin-top:15px; margin-bottom:20px;">
                                <br>
								<b>Head Office : </b><b>#51, Vijaya Nagar, Dheeran Nagar (Extn), Karumandapam, Trichirappalli, Tamilnadu - 620009</b><br />
                                <b>Ph : </b><b>0431-2403615 </b><b> H Phone :</b><b>9843288844</b><b> Windows Live ID : </b><b> <u>vsr@dvi.co.in</u></b><br />
                                <b>BRANCHES :: </b><b>MADURAI | COCHIN | HYDERABAD</b>
							</div>
							</div><!-- /.row -->
                            <?php 
										for($rt=1;$rt<$nxt_chout;$rt++)
										{
										$row_sspro1 = $sspro1->fetch(PDO::FETCH_ASSOC);
										}
							}//while end
}?>
                            
						</div>
                
                            <!-- row end hotel voucher-- >
                            
                            <!-- hotspots history start -->
                            <div class="the-box" style="vertical-align: text-middle; border:thin #666 1px;">
                        <div class="text-right">
						<img  src="../images/dvi_pdf.png"  height="75px" width="75px" alt="DVI Logo"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                      	
                        <hr style=" color: #443232;margin-top: 10px;margin-bottom: 10px" />
						 </div>
                         <div align="center" >
                         <strong style="color:#737373"><u>Place Description With Shighseeing Spots</u></strong>
                         </div>
  <?php 

$sphist = $conn->prepare("SELECT * FROM travel_sched where travel_id =? ORDER BY sno ASC ");
$sphist->execute(array($_GET['planid']));
//$row_sphist = mysql_fetch_assoc($sphist);
$row_sphist_main=$sphist->fetchAll();
$totalRows_sphist =$sphist->rowCount();
foreach($row_sphist_main as $row_sphist)
{
	$desc_hist=date('d-M-Y D',strtotime(str_replace('-','/',$row_sphist['tr_date'])));
	//print_r($hots_desc_arr[$desc_hist]);
	//echo "<br>";
	?>
    <div style="margin-top:20px; " align="center">
    <table style="width:98% ;border:1px solid #DEDEDE">
    <tr style="background-color:#ECECEC; color:#333; font-weight:600">
        <td style="width:25%;"><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$desc_hist; ?></td>
        <td style="width:75%">
		<?php 

$dvcity1 = $conn->prepare("SELECT * FROM dvi_cities where id =?");
$dvcity1->execute(array($hots_desc_arr[$desc_hist]['fcid']));
$row_dvcity1 = $dvcity1->fetch(PDO::FETCH_ASSOC);
$totalRows_dvcity1 = $dvcity1->rowCount();


$dvcity2 = $conn->prepare("SELECT * FROM dvi_cities where id =?");
$dvcity2->execute(array($hots_desc_arr[$desc_hist]['tcid']));
$row_dvcity2 = $dvcity2->fetch(PDO::FETCH_ASSOC);
$totalRows_dvcity2 = $dvcity2->rowCount();
					echo $row_dvcity1['name']."  -  ".$row_dvcity2['name']; ?></td>
    </tr>
    <tr>
    	<td colspan="2" >
        <?php 

$dvcity_hist = $conn->prepare("SELECT * FROM  dvi_cities_history where cid =?");
$dvcity_hist->execute(array($hots_desc_arr[$desc_hist]['tcid']));
$row_dvcity_hist= $dvcity_hist->fetch(PDO::FETCH_ASSOC);
$totalRows_dvcity_hist =$dvcity_hist->rowCount();
		
		if(trim($row_dvcity_hist['cdesc'])!='' && trim($row_dvcity_hist['cdesc'])!='-')
		{
			echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>".$row_dvcity2['name']."&nbsp;&nbsp;:&nbsp;&nbsp;</strong>".$row_dvcity_hist['cdesc'];
		}else{
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Default Contant : This day, we are going to see local sight-seeing spots.";	
		}
		?>
        
        </td>
    </tr>
    <?php
	if(trim($hots_desc_arr[$desc_hist]['spot_id'])!='' && trim($hots_desc_arr[$desc_hist]['spot_id'])!='-')
	{
	?>
     <tr>
    	<td colspan="2" align="center" >
        	<table width="95%"  border="1px solid" style="margin-top:5px;">
            <tr style="background-color:#E8E8E8; font-weight:600;"><td width="42%">Visiting Spots</td><!--<td width="3%">-</td>--><td width="50%">Opening and Closing Time</td></tr>
            <?php  
			$tot_spot_arr=explode(',',$hots_desc_arr[$desc_hist]['spot_id']);
		
		for($hr=0;$hr<count($tot_spot_arr);$hr++)
		{
			if($tot_spot_arr[$hr]!='-' && $tot_spot_arr[$hr]!='')
			{
				
				$dvcity_hstime = $conn->prepare("SELECT * FROM  hotspots_pro where hotspot_id =?");
				$dvcity_hstime->execute(array($tot_spot_arr[$hr]));
				$row_dvcity_hstime = $dvcity_hstime->fetch(PDO::FETCH_ASSOC);
				$totalRows_dvcity_hstime  = $dvcity_hstime->rowCount();
				?>
                <tr><td width="42%"><?php echo $row_dvcity_hstime['spot_name']; ?></td><!--<td width="3%">-</td>--><td width="45%"><?php echo $row_dvcity_hstime['spot_timings']; ?></td></tr>
                <?php 
			}
		}
			?>
            </table>
        </td>
    </tr>
    <?php }//is hotspots available?>
    </table>
    </div>
    <?php 
}
?>                              <div >
                                </div>                                

                            </div>
                             <!-- hotspots history ecd -->
                            
                            <?php }?>
                            <!-- feedback form start -->
                            
                    <div class="the-box" style="vertical-align: text-middle; border:thin #666 1px;">
							                                     <?php

$mst = $conn->prepare("SELECT * FROM travel_master where plan_id =?");
$mst->execute(array($_GET['planid']));
$row_mst = $mst->fetch(PDO::FETCH_ASSOC);
if(!empty($row_mst['sub_paln_id'])){
		$guest_name = $row_mst['tr_name'];
	}
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

?>
                            <div class="row">
								<div class="col-sm-12 text-right">
									<img  src="../images/dvi_pdf.png"  height="75px" width="75px" alt="DVI Logo"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                      
                                    <hr style=" color: #443232;margin-top: 10px;margin-bottom: 10px" />
								</div><!-- /.col-sm-6 -->
                                
                                <div class="col-sm-12" >
                                <div class="col-sm-6">
                                <b style="margin-left: -14px;">Dear : </b>
                                <b><?php echo $guest_name." *".$row_mst['pax_cnt'];?></b>
                                </div>
                                <div class="col-sm-6">
                                <b>Tour Date : </b><b><?php echo $start_dtour." To ".$last_dtour." &nbsp;&nbsp;[ ".$totalRows_trl_scd." Days&nbsp;]";?></b>
                                </div>
                                </div>
                                
                                <div class="col-sm-12" style="margin-top:20px; text-align:justify">
                                <span>Greetings from DVI Holidays !!!</span><br><br>
                                <span>Thank you for your choice to use DVI Holidays! <br><br> The Motto of our company is to provide satisfactory services to our entire guest. In order to achieve this aim we need to know your opinion on it. Praise would be a motivation for us to continue our services. And any critic would naturally be a reason for us to improve our services according to the requirements and desires of our Guests.</span><br><br>
                                <span>Please tell YOUR FRIENDS what you like about us! <br><br> Please tell US what you dislike.<br><br></span>
                                <p style="margin-left:20px;">Tell us about the vehicles and its drivers for your whole trip?<br>Vehicle Provided :<br><br>Is the vehicle is on Time at the airport on your arrival?<br>Vehicle Provided :<br><br>How about the driver's services to you?<br>Driver Name :<br><br></p>
                                <span>Tell us about the hotels which you have been used for your whole trip.</span>
                                </div>
                                
                                <?php

$trl_scd1 = $conn->prepare("SELECT * FROM travel_sched where travel_id =? ORDER BY sno ASC");
$trl_scd1->execute(array($_GET['planid']));
//$row_trl_scd1 = mysql_fetch_assoc($trl_scd1);
//$row_trl_arr1 = mysql_fetch_array($trl_scd1);
//$row_sy_scd1 = $sy_scd1->fetch(PDO::FETCH_ASSOC);
//$row_trl_scd1_main =$trl_scd1->fetchAll();
$totalRows_trl_scd1 = $trl_scd1->rowCount();


$sy_scd1 = $conn->prepare("SELECT * FROM stay_sched where stay_id =?");
$sy_scd1->execute(array($_GET['planid']));
//$row_sy_scd1 = mysql_fetch_assoc($sy_scd1);
//$row_sy_scd1_main=$sy_scd1->fetchAll();
$totalRows_sy_scd1 =$sy_scd1->rowCount();
								
								while($totalRows_sy_scd1>0)
								{
									$row_sy_scd1 = $sy_scd1->fetch(PDO::FETCH_ASSOC);
									$row_trl_scd1 =$trl_scd1->fetch(PDO::FETCH_ASSOC);
									if($row_sy_scd1['sty_date'] == $row_trl_scd1['tr_date'])
									{
										
											  
$shot = $conn->prepare("SELECT * FROM hotel_pro where hotel_id =?");
$shot->execute(array($row_sy_scd1['hotel_id']));
$row_shot= $shot->fetch(PDO::FETCH_ASSOC);
$totalRows_shot = $shot->rowCount();
								?>
                                <div class="col-sm-12" style="margin-top:15px; margin-bottom:15px;">
                                <table> 
                                <tr><td style="padding: 12px; font-weight:600"><?php
								 echo $row_trl_scd1['tr_to_cityid']; ?></td>
                                 <td style="padding: 12px;font-weight:600"><?php
								 echo $row_shot['hotel_name']; ?></td>
                                 <td style="padding: 12px; font-weight:600">Check In :</td><td style="padding: 12px; font-weight:600"><?php
								 echo date("d-M-Y",strtotime($row_trl_scd1['tr_date'])); 
								 
//my edit
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
									
								 ?></td>
                                 <td style="padding: 12px; font-weight:600">Check Out :</td><td style="padding: 12px; font-weight:600">
								 <?php
								
								 $date=date_create($row_trl_scd1['tr_date']);
date_add($date,date_interval_create_from_date_string("1 days"));
echo $next_datt=date_format($date,"d-M-Y");
							 	?></td>
                                </tr>
                                </table>
                                <table>
                                <tr><td style="padding: 12px;">Rooms</td><td style="padding: 12px;">Poor</td><td style="padding: 12px;">Good</td><td style="padding: 12px;">Very Good</td><td style="padding: 12px;">Excellent</td></tr>
                                <tr><td style="padding: 12px;">Food</td><td style="padding: 12px;">Poor</td><td style="padding: 12px;">Good</td><td style="padding: 12px;">Very Good</td><td style="padding: 12px;">Excellent</td></tr>
                                <tr><td style="padding: 12px;">Staff</td><td style="padding: 12px;">Poor</td><td style="padding: 12px;">Good</td><td style="padding: 12px;">Very Good</td><td style="padding: 12px;">Excellent</td></tr>
                                <tr><td colspan="5" style="padding: 12px;">Anything needs to be improved, please Mention.<br><br></td></tr>
                                </table>
                                </div>
                                <?php 
								
								$totalRows_sy_scd1--; 
									}//if end
								}//while end ?>
                               
                               
                               <div class="col-sm-12" >
                               <p>Please tell us about the overall feedback on DVI Holidays for organizing your tour.</p>
                               <span>Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</span><br><br>
                               <span>EMail ID &nbsp;:</span><br><br>
                               <span>Address &nbsp;:</span><br><br><br><br>
                               </div>
                                <div class="col-sm-12 " style="background-color:rgba(234, 234, 236, 0.24); color:#8388A9; border-top:#666 solid 2px; border-bottom:#000 solid 2px; margin-top:15px; margin-bottom:20px;">
                                <br>
								<b>Head Office : </b><b>#51, Vijaya Nagar, Dheeran Nagar (Extn), Karumandapam, Trichirappalli, Tamilnadu - 620009</b><br />
                                <b>Ph : </b><b>0431-2403615 </b><b> H Phone :</b><b>9843288844</b><b> Windows Live ID : </b><b> <u>vsr@dvi.co.in</u></b><br />
                                <b>BRANCHES :: </b><b>MADURAI | COCHIN | HYDERABAD</b>
							</div>
							</div><!-- /.row -->
							</div>
                            
                            
                            
                            
                           <div class="the-box" style="vertical-align: text-middle; border:thin #666 1px;"> 
                            <div class="row">
								<div class="col-sm-12 text-right">
									<img  src="../images/dvi_pdf.png"  height="75px" width="75px" alt="DVI Logo"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                      
                                    <hr style=" color: #443232;margin-top: 10px;margin-bottom: 10px" />
								</div><!-- /.col-sm-6 -->
                                
                                <div class="col-sm-12" style="text-align:justify" >
                                	<b>Package  Includes: </b><br>
                                    Transfers and sight-seeing  by  deluxe  tourists vehicle A/C <span style="color:#F00">(Vehicles up hill driving on the hills would be on Non AC) </span> <br>
                                    Toll & Parking <br>
                                    GST<br>
                                    Daily Breakfast <br>
                                    All local sight-seeing in the same vehicle, every day after breakfast till sunset. <br><br>
                                    <span style="color:#F00">If staying in the House boat </span> <br>
                                    House Boat with all Meals and Ac In the house boat operates from 09 PM to 06 Am only.<br><br>
                                    <span style="color:#F00">If the booking includes the extra bed it is facilitated with a folding cot or a mattress as an extra bed, as per the hotel policy. </span> <br><br>
                                    
                                    
                                    <b> Package does not include </b><br><br>
									Any international / Domestic Air Fare if any quoted separately <br>
                                    English speaking guide / escort charges Airport Tax <br>
                                    Extra bed All meals (other than above mentioned ones) <br>
                                    Personal nature expenses such as telephone calls, Laundry, soft / hard drinks, lunch tipping etc., <br>
                                    Camera fee at monuments. <br>
                                    Monument / TEMPLE Entrance Fees / Boat ride<br>
                                    Insurance. <br>
                                    Any Porterage services at Airport / Railway station. <br>
                                    Any other expenses not mentioned in the above cost. <br>
									<span style="color:#F00">24th December gala dinner </span> <br>
									<span style="color:#F00">31st December gala dinner </span> <br><br>
                                                                        

									<span style="color:#F00">Cancellation policy </span><br>
                                    CANCELLATION 30% of Package cost, if the cancellation is made 30 days prior to the departure. 50% of package cost, if the cancellation is made between 30-14 days prior to the departure.    |   70% of package cost, if the cancellation is made between 17-7 days prior to the departure.     |     100% of package cost, if the cancellation is made 7 days or less prior to the departure. <br><br>
                                    
                                    <b>General  Policy</b><br>
Child cost depends upon hotels rule which may vary from one hotel to another. The most common rules are as under: <br>
Child up to 5 years is free. Child above 5 years to 12 will be charged as per hotel rule. Child above 12 years will be charged as adult. <br>
If your reservation at hotels includes an extra bed, most hotels provide a folding cot or a mattress on floor as an extra bed. <br>
Check in and check out in most of the hotels at 1200 noon in the cities, In Hill stastions check in 1400 hrs check out 11 hrs. <br>
Early check-in or late check-out is subject to availability and may be chargeable by the hotel. <br>
To request for an early check-in or late check-out, kindly contact the hotel directly or inform us prior. <br>

                                </div>
                               
                                <div class="col-sm-12 " style="background-color:rgba(234, 234, 236, 0.24); color:#8388A9; border-top:#666 solid 2px; border-bottom:#000 solid 2px; margin-top:15px; margin-bottom:20px;">
                                <br>
								<b>Head Office : </b><b>#51, Vijaya Nagar, Dheeran Nagar (Extn), Karumandapam, Trichirappalli, Tamilnadu - 620009</b><br />
                                <b>Ph : </b><b>0431-2403615 </b><b> H Phone :</b><b>9843288844</b><b> Windows Live ID : </b><b> <u>vsr@dvi.co.in</u></b><br />
                                <b>BRANCHES :: </b><b>MADURAI | COCHIN | HYDERABAD</b>
							</div>
							</div>
                            </div>
            
                        
                        <?php if(isset($_GET['topbar']) && $_GET['topbar']=="topbar") {?>
                         <div class="the-box" style="vertical-align: text-middle; border:thin #666 1px; background-color:#F2F2F2">
                          <form name="approvel_wait" id="approvel_wait" method="post">
                            <center><button  type="submit" class="btn btn-default" id="grant_approvel" name="grant_approvel" value="grant_approvel_val">Approve</button>
                            <button type="submit" class="btn btn-default" id="reject_approvel" name="reject_approvel" value="reject_approvel_val">Reject</button></center>
                         </form>
                         </div>
                         <?php }?>
                    
                    </div>
                    <!-- feedback form end -->
						<!-- /.the-box no-border bg-dark -->
					<!-- /.the-box -->
					<!-- END INVOICE -->
                    </body>
                    </html>
					
		<script src="../core/assets/js/bootstrap.min.js"></script>
		<script src="../core/assets/plugins/retina/retina.min.js"></script>
		<!--<script src="../core/assets/plugins/nicescroll/jquery.nicescroll.js"></script>
		<script src="../core/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>-->
		<script src="../core/assets/plugins/backstretch/jquery.backstretch.min.js"></script>
        
        
		<!-- PLUGINS -->
  <!--      <script type="text/javascript" src="../core/assets/plugins/Tags/jquery.tagsinput.js"></script>
		<script src="../core/assets/plugins/skycons/skycons.js"></script>
		<script src="../core/assets/plugins/prettify/prettify.js"></script>
        <script src="../core/assets/plugins/swal/sweet-alert.js"></script>
		<script src="../core/assets/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
		<script src="../core/assets/plugins/owl-carousel/owl.carousel.min.js"></script>
		<script src="../core/assets/plugins/icheck/icheck.min.js"></script>
		<script src="../core/assets/plugins/datepicker/bootstrap-datepicker.js"></script>
		<script src="../core/assets/plugins/timepicker/bootstrap-timepicker.js"></script>
		<script src="../core/assets/plugins/mask/jquery.mask.min.js"></script>
		<script src="../core/assets/plugins/validator/bootstrapValidator.min.js"></script>
		<script src="../core/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
		<script src="../core/assets/plugins/datatable/js/bootstrap.datatable.js"></script>
		<script src="../core/assets/plugins/summernote/summernote.min.js"></script>
		<script src="../core/assets/plugins/markdown/markdown.js"></script>
		<script src="../core/assets/plugins/markdown/to-markdown.js"></script>
		<script src="../core/assets/plugins/markdown/bootstrap-markdown.js"></script>
		<script src="../core/assets/plugins/slider/bootstrap-slider.js"></script>
		<script src="../core/assets/plugins/toastr/toastr.js"></script>
        <script src="../core/assets/plugins/chosen/chosen.jquery.min.js"></script>
		<script src="../core/assets/plugins/spinner/js/jquery.dpNumberPicker-1.0.1-min.js"></script>-->
        
		<script src="../core/assets/js/apps.js"></script>
		<script src="../core/assets/js/demo-panel-1.js"></script>
        <script src="../core/assets/js/moment.js"></script>
		<script>
		$(document).ready(function(e) {
			$('.datatable-example').dataTable();
        });
		
		//window.onload = get_cities;
		
		$(".div-nicescroller").niceScroll({
		cursorcolor: "#656D78",
		cursorborder: "3px solid #313940",
		cursorborderradius: "10px",
		cursorwidth: "2px"

	});
	
	$(".div-nicescroller1").niceScroll({
		cursorcolor: "#3BAFDA",
		cursorborder: "3px solid #3BAFDA",
		cursorborderradius: "10px",
		cursorwidth: "2px"

	});

</script>