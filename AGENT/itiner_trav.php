<?php
session_start();
require_once('../Connections/divdb.php');
$idd=explode('#',$_GET['planid']);
$str=$idd[0];
//print_r($idd);

$orders = $conn->prepare("SELECT * FROM travel_master where plan_id =?");
$orders->execute(array($_GET['planid']));
$row_orders = $orders->fetch(PDO::FETCH_ASSOC);
$totalRows_orders = $orders->rowCount();
$customer_name=$row_orders['tr_name'];

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
?>
<style>
body {
    background-position: 50% 50%;
    margin:0px;
    padding:0px !important;
	font-family:Calibri;
	font-size: 12px;
}

table td{
	padding:3px;
}
</style>
<html><head>
		<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
		<!-- PLUGINS CSS -->
		<link href="../core/assets/plugins/prettify/prettify.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/magnific-popup/magnific-popup.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/chosen/chosen.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/icheck/skins/all.css" rel="stylesheet">
		<link href="../core/assets/plugins/datepicker/datepicker.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/validator/bootstrapValidator.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/datatable/css/bootstrap.datatable.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/slider/slider.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/salvattore/salvattore.css" rel="stylesheet">
		<link href="../core/assets/plugins/toastr/toastr.css" rel="stylesheet">
		<link href="../core/assets/plugins/toastr/toastr.css" rel="stylesheet">
        <link href="../core/assets/plugins/swal/sweet-alert.css" rel="stylesheet" type="text/css"/>
        <link href="../core/assets/plugins/spinner/css/jquery.dpNumberPicker-holoLight-1.0.1-min.css" rel="stylesheet">
		<!-- MAIN CSS (REQUIRED ALL PAGE)-->
		<link href="../core/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="../core/assets/css/style.css" rel="stylesheet">
		<link href="../core/assets/css/style-responsive.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="../core/assets/plugins/Tags/jquery.tagsinput.css" />
        <script src="../core/assets/js/jquery.min.js"></script>
        </head>
        <body class="div-nicescroller" style="font-family:Calibri;">
					<!-- Begin page heading -->
					<!-- BEGIN INVOICE -->
					<div class="the-box full invoice">
                    
                    <div class="the-box no-border">
                        <div class="row">
                        	<div class="col-sm-9">
                                <h4 class="text-muted text"><?php // echo $_GET['planid']; ?></h4>
                            </div>
                            
                            <div class="col-sm-3 "  align="right">
                            <div class="btn-group">
								  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-download"></i> Download PDF <span class="caret"></span>
								  </button>
								  <ul class="dropdown-menu info pull-right" role="menu" style="text-align:left">
									<li>
                                    <a target="_blank" href="itiner_trav_pdf.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&planid=<?php echo urlencode($_GET['planid']); ?>"><i class="fa fa-hand-o-right"></i>&nbsp;Itinerary Form (Default)</a>
                                    </li>
                                    <li class="divider"></li>
									<li><a target="_blank" href="itin_wel_board_pdf.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&planid=<?php echo urlencode($_GET['planid']); ?>"><i class="fa  fa-hand-o-right"></i>&nbsp;Welcome Board</a></li>
									<li><a target="_blank" href="itin_trav_letter_pad_pdf.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&planid=<?php echo urlencode($_GET['planid']); ?>"><i class="fa  fa-hand-o-right"></i>&nbsp;Itinerary Form (On Letter Pad)</a></li>
								  </ul>
								</div>&nbsp;&nbsp;
							</div>
							
                        </div>
					</div>
                    
                    <div class="the-box no-border ">
                    <div class="row">
                   <img  src="../img_upload/agent_img/logo/<?php echo $row_you['comp_logo']; ?>" height="250px" width="250px" alt="DVI Logo" style="margin-left:30px; margin-top:20px;"/>
                   <div style="margin-top:-72px; margin-bottom:100px;">
                  <center><strong style="font-family:sans-serif; font-weight:bolder; font-size:77px; color:#000; "> Welcomes </strong><br />
                  <strong style="font-family:sans-serif; font-weight:bolder; font-size:77px;color:#000;"></strong><strong style="font-family:sans-serif; font-weight:bolder; font-size:77px;color:#000; word-wrap:break-word" ><?php echo $row_orders['tr_name']; ?> </strong></center>
                   </div>
                   <div class="col-sm-12">
                   <div class="col-sm-8">
                    <b >Arrival flight/train details&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;<?php echo $row_orders['tr_arrdet']; ?></b>
<br /><b>Departure flight/ train details&nbsp;&nbsp;: &nbsp;<?php echo $row_orders['tr_depdet']; ?></b>
                   </div>
                    <div class="col-sm-4"><br />
                    <b >Contact No.</b>&nbsp;&nbsp;<b><?php echo $row_orders['tr_mobile']."&nbsp;&nbsp;&nbsp;"; ?></b></div>
                                       </div>
                   </div>
                    </div>
                      <hr style="margin-top: 10px;margin-bottom: 10px;" />
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
	$totalRows_orders = $orders->rowCount();
                      ?>
                      
                        <div class="the-box" style="vertical-align: text-middle; border:thin #666 1px;">
							<div class="row">
								<div class="col-sm-12 text-right">
									<img src="../img_upload/agent_img/logo/<?php echo $row_you['comp_logo']; ?>"  height="75px" width="75px" alt="DVI Logo"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                      <strong style="font-size:10px">An ISO 9001 - 2008 Company </strong>
                                    <hr style=" color: #443232;margin-top: 10px;margin-bottom: 10px" />
                                    <br />
								</div><!-- /.col-sm-6 -->
<?php 
	if($break_chk!=0)
	{?>
	<center><strong style="color:#C58207">Your Itinerary will bypassing to following places</strong></center>	
	<?php }$break_chk++;
?>
                                <table>
                                <tr><td>&nbsp;Guest Name</td><td>:</td><td><?php echo $customer_name; ?></td></tr>
                                <tr><td>&nbsp;Pax Count</td><td>:</td><td><?php echo $row_orders['pax_cnt']."&nbsp;Person(s)"; ?></td></tr>
                              <?php if($str !='H'){ ?>
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
                                <?php }?>
                                </table>
                                    <!--New code for itinerary -->
                                    <div>
                                    <br />
                                     <?php
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
								if($totalRows_trv>0){	?>
                                    <span style="color:#666; font-size:18px; text-align:center"><center><u>Tour Itinerary Plan (Program schedule)</u></center></span><span><center>Specially prepared for <?php echo $customer_name;?></center></span>
                                    <br />
                                    <?php }?>
                                   
                                     <?php foreach($row_trv_main as $row_trv){
										
										if($trv_cnt_1>0)
										{//for stay table - aft end day calculation
										
										?>
                                         <div class="col-sm-12">
                                    <div class="col-sm-2" style="margin-top:15px; border-top:solid #DADADA 1px">
                                   
                                    <span style="color:#000; font-weight:600;">
                                    <?php
										echo $desc_date=date('d-M-Y D',strtotime(str_replace('-','/',$row_trv['tr_date'])));
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

$hots_desc_arr[$desc_date]['fcid']=$row_cityy1['id'];
$hots_desc_arr[$desc_date]['tcid']=$row_cityy_to['id'];
$hots_desc_arr[$desc_date]['via']=$row_trv['via_cities'];
$hots_desc_arr[$desc_date]['spot_id']='-';									
									?>
                                    
                                    <span style="color:#000;  font-size:14px; font-weight:600"> <?php if($chn=='0'){?>Arrival - <?php }?> <?php echo $row_trv['tr_from_cityid'];if($chn=='0'){echo " [ ".$row_orders['tr_arrdet']." @".$row_orders['tr_arr_time']." ]";}
									
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
									//echo " (".$row_trv['tr_dist_ss']." Kms)";
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
					
							echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid'].". Check in ( 12:00 noon - standard time) at hotel, refresh and later proceed to seeing sightseeing including - ";
						$hots_array=array();
						$hots_with_id=array();
									$vg=0;
									foreach($row_hot_main as $row_hot){
										   $hots_array[$vg]='<strong>'.$row_hot['spot_name'].'</strong>';
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
														echo $row_via_hspots['spot_name'].'</strong>, ';
														
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
					echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid'].", proceed to seeing sightseeing including - ";
						$hots_array=array();
						$hots_with_id=array();
									$vg=0;
									foreach($row_hot_main as $row_hot){
										   $hots_array[$vg]='<strong>'.$row_hot['spot_name'].'</strong>';
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
										$rem_area_cnt[$row_trv['tr_from_cityid']]=$rem_area_cnt[$row_trv['tr_from_cityid']]+$tot_div_hot;
										$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-1;
										$hots_desc_arr[$desc_date]['spot_id']=$hot_with_sep;
										
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
										   $hots_array[$vg]='<strong>'.$row_hot1['spot_name'].'</strong>';
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
										$hots_desc_arr[$desc_date]['spot_id']=$hots_desc_arr[$desc_date]['spot_id'].','.$hot_with_sep;
							}
								}//within 11:00AM arrival means if- end
									
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
														echo $row_via_hspots['spot_name'].'</strong>, ';
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
									
							echo "and later drive to ".$row_trv['tr_to_cityid'].", check-in and overnight stay at hotel.";
	
						}else if($time3pm <= $arr_date_tstmp && $arr_date_tstmp <= $time6pm)
						{//between 3pm to 6pm ( over night in diff city)
						echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid'].". ";
						
						if($totalRows_hot>0){ 
						echo "If time permits proceed to seeing sightseeing including - ";
						
						$hots_array=array();
						$hots_with_id=array();
									$vg=0;
									foreach($row_hot_main as $row_hot){
										   $hots_array[$vg]='<strong>'.$row_hot['spot_name'].'</strong>';
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
										$rem_area_cnt[$row_trv['tr_from_cityid']]=$rem_area_cnt[$row_trv['tr_from_cityid']]+$tot_div_hot;
										$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-1;
										$hots_desc_arr[$desc_date]['spot_id']=$hot_with_sep;
										
										//via edit start
										$spot_id='-';
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
														echo $row_via_hspots['spot_name'].'</strong>, ';
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
										   $hots_array[$vg]='<strong>'.$row_hot['spot_name'].'</strong>';
										   $vg++;
										} 
										
										$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_from_cityid']]);
										//skip hot spot
										$rem_area_cnt[$row_trv['tr_from_cityid']]=$rem_area_cnt[$row_trv['tr_from_cityid']]+$tot_div_hot;
										$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-1;
										$hots_desc_arr[$desc_date]['spot_id']='-';
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
									echo " proceed to seeing sightseeing including - ";
									$hots_array=array();
									$hots_with_id=array();
									$vg=0;
									foreach($row_hot_main as $row_hot){
										   $hots_array[$vg]='<strong>'.$row_hot['spot_name'].'</strong>';
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
														echo $row_via_hspots['spot_name'].'</strong>, ';
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
								foreach($row_hot1_main as $row_hot1){
										   $hots_array[$vg]='<strong>'.$row_hot1['spot_name'].'</strong>';
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
									 if(isset($dt_arr[$row_trv['tr_from_cityid']][0]))
									 {
		 echo "<br><span style='font-weight:bold; color:green'>"."DAYTRIP applicable to ".$dt_arr[$row_trv['tr_from_cityid']][0]."</span>";

		  
$dayhpot= $conn->prepare("SELECT * FROM hotspots_pro where spot_city =? and status='0'");
$dayhpot->execute(array($dt_arr[$row_trv['tr_from_cityid']]['id']));
//$row_dayhpot = mysql_fetch_assoc($dayhpot);
$row_dayhpot_main=$dayhpot->fetchAll();
$totalRows_dayhpot = $dayhpot->rowCount();

foreach($row_dayhpot_main as $row_dayhpot)
{
		echo  " - <strong>".$row_dayhpot['spot_name']."</strong>";
}
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
                                  </div>
                                     <?php
									
									 $chn++;
										}//inner hotel while end
										else{ ?>
                                        <div class="col-sm-12">
											<div class="col-sm-2" style="margin-top:15px; border-top:solid #DADADA 1px">
                                   
                                    <span style="color:#000; font-weight:600;">
                                    <?php
									if($row_trv['tr_date'] != '')
									{
										echo $desc_date=$desc_date=date('d-M-Y D',strtotime(str_replace('-','/',$row_trv['tr_date'])));
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

$hots_desc_arr[$desc_date]['fcid']=$row_cityy1['id'];
$hots_desc_arr[$desc_date]['tcid']=$row_cityy_to['id'];
$hots_desc_arr[$desc_date]['via']=$row_trv['via_cities'];
$hots_desc_arr[$desc_date]['spot_id']='-';
									?>
                                    
                                    <span style="color:#000;  font-size:14px; font-weight:600"> <?php echo $row_trv['tr_from_cityid']."&nbsp;&nbsp;-&nbsp;&nbsp;".$row_trv['tr_to_cityid'];
									
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
$row_ss_dist=$ss_dist->fetch(PDO::FETCH_ASSOC);
$totalRows_ss_dist = $ss_dist->rowCount();	
									//echo " (".$row_ss_dist['ss_dist']." Kms)";
									echo "";
									$today_dist=$row_trv['ss_dist'];
									}
									?></span><br />
                                    
                                    <?php echo "After breakfast check out hotel"; 
									//time calculation 
									
	$dept_date_time=$row_trv['tr_date'].' '.$row_orders['trv_depatr_time'];
	$dept_date_tstmp=date('U',strtotime($dept_date_time));
	$dept_time4pm=date('U',strtotime($row_trv['tr_date'].' 04:00 PM'));//for next day morning - arrival
									
									if($dept_date_tstmp>=$dept_time4pm)
									{//departure time is within 4-pm - show hot spots
									echo ", and proceed to seeing sightseeing including - ";
										$hots_array=array();
										$hots_with_id=array();
										$vg=0;
									foreach($row_hot_main as $row_hot){
										   $hots_array[$vg]='<strong>'.$row_hot['spot_name'].'</strong>';
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
														echo $row_via_hspots['spot_name'].'</strong>, ';
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
                                    </div>
										<?php }
										 
										$trv_cnt_1--;
									$totalRows_trv--;
									//$row_count--;
									?>
                                      
                                    <?php
									 }
									//print_r($rem_area_cnt); ?>
                                  
                                    </div>
                                    
							</div><!-- /.row -->
                            
						</div>
                        
                     <div class="jumbotron jumbotron-sm " style="background-color:rgba(225, 220, 247, 0.24); color:#8388A9;">
								<strong>Address: </strong><strong style="color:#F00;"><?php echo $row_you['comp_name']; ?></strong><strong><?php echo " - ".$row_you['agent_addr'];?></strong><br />
                              <strong>Help Line : 27 * 7@ All India Customer Care : 9843288844 </strong><br />
							</div>
                            
                            
                              <!-- hotspots history start -->
                            <div class="the-box" style="vertical-align: text-middle; border:thin #666 1px;">
                        <div class="text-right">
						<img  src="../images/dvi_pdf.png"  height="75px" width="75px" alt="DVI Logo"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                      	<strong style="font-size:10px">An ISO 9001 - 2008 Company </strong>
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
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Default Contant : This day, we are going to see local sightseeing spots.";	
		}
		?>
        
        </td>
    </tr>
    </table>
    <?php
	if(trim($hots_desc_arr[$desc_hist]['spot_id'])!='' && trim($hots_desc_arr[$desc_hist]['spot_id'])!='-')
	{
	?>
     
        	<table width="98%"  border="1px solid" style="margin-top:5px;">
            <tr style="background-color:; font-weight:600;"><td width="42%">Visiting Spots</td><!--<td width="3%">-</td>--><td width="50%">Opening and Closing Time</td></tr>
            <?php  
			$tot_spot_arr=explode(',',$hots_desc_arr[$desc_hist]['spot_id']);
		
		for($hr=0;$hr<count($tot_spot_arr);$hr++)
		{
			if($tot_spot_arr[$hr]!='-' && $tot_spot_arr[$hr]!='')
			{
				
				$dvcity_hstime = $conn->prepare("SELECT * FROM  hotspots_pro where hotspot_id =?");
				$dvcity_hstime->execute(array($tot_spot_arr[$hr]));
				$row_hstime = $dvcity_hstime->fetch(PDO::FETCH_ASSOC);
				$totalRows_hstime  = $dvcity_hstime->rowCount();
				?>
                <tr><td width="42%"><?php echo $row_hstime['spot_name']; ?></td><td width="45%"><?php echo $row_hstime['spot_timings']; ?></td></tr>
                <?php 
			}
		}
			?>
            </table>
       
    <?php }//is hotspots available?>
    </table>
    </div>
    <?php 
}
?>                              <div >
                                </div>                                

                            </div>
                             <!-- hotspots history ecd -->
                         <?php } //main loop ?>   
                    
                    <div class="the-box" style="vertical-align: text-middle; border:thin #666 1px;"> 
                            <div class="row">
								<div class="col-sm-12 text-right">
									<img src="../img_upload/agent_img/logo/<?php echo $row_you['comp_logo']; ?>" height="75px" width="75px" alt="Your Logo"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                      <strong style="font-size:10px">An ISO 9001 - 2008 Company </strong>
                                    <hr style=" color: #443232;margin-top: 10px;margin-bottom: 10px" />
								</div><!-- /.col-sm-6 -->
                                
                                <div class="col-sm-12" style="text-align:justify" >
                                	<b><span style="color:#F00">Terms & Conditions </span></b><br>
                                    Transfers and sightseeing  by  deluxe  tourists vehicle A/C <span style="color:#F00">(Vehicles up hill driving on the hills would be on Non AC) </span> <br>
                                    Toll & Parking <br>
                                    Service Taxes <br>
                                    All local sightseeing in the same vehicle, every day after breakfast till sunset ( 0700 AM to 08PM)<br><br>
                                    
                                    <b>IMPORTANT: </b> Kindly note that  vehicles  mentioned above only indicate that our rates have been based on usage of the locations and Kilometres  and it is not to be construed that the same vehicles will be provided if the vehicles are not available in the selected locations we shall provide from the different neareast availble location for the same rate may change (supplement/reduction whatever applicable). Unless until we <?php echo $comp_myname; ?> sends you the written confirmation from reservation the quote is not final. <br><br>
									
                                </div>
                                
							</div>
                            
                            </div>
                  
                    <div class="jumbotron jumbotron-sm " style="background-color:rgba(225, 220, 247, 0.24); color:#8388A9;">
								<strong>Address: </strong><strong style="color:#F00;"><?php echo $row_you['comp_name']; ?></strong><strong><?php echo " - ".$row_you['agent_addr'];?></strong><br />
                              <strong>Help Line : 27 * 7@ All India Customer Care : 9843288844 </strong><br />
							</div>
                        
					</div><!-- /.the-box -->
					<!-- END INVOICE -->
                    </body>
                    </html>
					
		<script src="../core/assets/js/bootstrap.min.js"></script>
		<script src="../core/assets/plugins/retina/retina.min.js"></script>
		<script src="../core/assets/plugins/backstretch/jquery.backstretch.min.js"></script>
        
		<script src="../core/assets/js/apps.js"></script>
		<script src="../core/assets/js/demo-panel-1.js"></script>
        <script src="../core/assets/jQuery/form-validator/spin.js"></script>
        <script src="../core/assets/js/moment.js"></script>
		<script>
		$(document).ready(function(e) {
			$('.datatable-example').dataTable();
        });
		
		//window.onload = get_cities;

</script>