 <?php 
session_start();
// echo "good".$_GET['planid']; 
require_once('../Connections/divdb.php');

//$_GET['planid']=$_GET['planid1'].'#'.$_GET['planid2'];
$_GET['planid']=$_SESSION['com_plan_id'];

$idd=explode('#',$_GET['planid']);
$str=$idd[0];
//print_r($idd);

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

$addi_addons_check=0;
foreach($break_arr as $breakup_cal)
{
	
	$totcal_trav = $conn->prepare("SELECT * FROM travel_sched where travel_id =? and addi_cost_for!='' and addi_amount!=''");
	$totcal_trav->execute(array($breakup_cal));
	$totalrows_totcal_trav =$totcal_trav->rowCount();
	if($totalrows_totcal_trav>0)
	{
		$addi_addons_check=1;
	}
}



$orders = $conn->prepare("SELECT * FROM travel_master where plan_id =?");
$orders->execute(array($_GET['planid']));
$row_orders = $orders->fetch(PDO::FETCH_ASSOC);
$totalRows_orders = $orders->rowCount();


$you = $conn->prepare("SELECT * FROM agent_pro where agent_id =?");
$you->execute(array($_SESSION['uid']));
$row_you = $you->fetch(PDO::FETCH_ASSOC);
$totalRows_you = $you->rowCount();
?>
<style>
body {
    background-position: 50% 50%;
    margin:0px;
    padding:0px !important;
	font-family:Roboto;
}

table td{
	padding:3px;
}
</style>
             <?php if($addi_addons_check==0){ ?>      
       <div id="addi_cost_toggle"  onclick="addi_cost_toggle_click()" style="border:1px solid #666; padding:6px; background-color:#205c82; text-align:center; color:#FFF; cursor:pointer;text-decoration: underline;" > <i class="fa fa-hand-o-right" style="color:#FFF"></i>&nbsp;&nbsp;&nbsp;Click here to adding special add-ons to this itinerary</div>
                     <div id="addi_cost_load_div" style="display:none; background-color:rgb(255, 252, 247); border:1px solid #CCC"> addi_cost_load_div </div>
                     <br />
			<?php }?>

                        <div style="vertical-align: text-middle; ">
                        <?php
						//main break stay for
$break_chk=0;
foreach($break_arr as $breakup)
{
							$_GET['planid']=$breakup;
							
							$orders = $conn->prepare("SELECT * FROM travel_master where plan_id =?");
							$orders->execute(array($_GET['planid']));
							$row_orders = $orders->fetch(PDO::FETCH_ASSOC);
							$totalRows_orders = $orders->rowCount();

							//////////
							if($break_chk!=0)
							{?>
								<div class="row" style="padding:6px; text-align:center; border-top: 2px solid #EFB662;">
                                	<strong style="color:#C75A18"> Your Itinerary - will bypassing to below mentioned days [ Break-Stay ] </strong>
                                </div>
							<?php }
							//////////
							?>
                        
							<div class="row">


<?php if($break_chk==0)
								{ ?>
	<div class="col-sm-12" style="padding:6px">
			<!--<center><strong style="color:#6B4D1E; font-size: 22px;">
					Overall Package Cost : <?php echo $whole_itin_amt."/- Only"; ?>
			</strong></center>-->
		<center>
			<table style='width:94%; border:1px solid #256582;' border='1'>
				<tr style='background-color: #2369A0; color:#FFF'>
					<th style='padding:6px; width:3%'>Sno</th>
					<th style='padding:6px; width:15%; text-align:center'>Date of Travel</th>
					<th style='padding:6px; width:4%; text-align:center'>Pax</th>
					<th style='padding:6px; width:22%; text-align:center'>Vehicle Taken</th>
					<th style='padding:6px; width:8%; text-align:center'>Kms</th>
				</tr>
				<?php 
				$iv=1;
				foreach($break_arr as $inv)
				{
							
							$invoice = $conn->prepare("SELECT * FROM travel_master where plan_id =?");
							$invoice->execute(array($inv));
							$row_invoice = $invoice->fetch(PDO::FETCH_ASSOC);
							$totalRows_invoice = $invoice->rowCount();
					?>
				<tr>
					<th style='padding:6px;'><?php echo $iv++; ?></th>
					<th style='padding:6px; text-align:center'>
						<?php 
						echo date("d-M-Y", strtotime($row_invoice['tr_arr_date']))." - ";
 
$date=date_create($row_invoice['tr_arr_date']);
date_add($date,date_interval_create_from_date_string(($row_invoice['tr_days']-1)." days"));
echo date_format($date,"d-M-Y");	
						?>
					</th>
					<th style='padding:6px; text-align:center'>
						<?php
						echo $row_invoice['pax_cnt'];
						?>
						</th>
					<th style='padding:6px; text-align:center'>
						<?php
						$vegh_arr=explode(',',$row_invoice['tr_vehname']);
						foreach($vegh_arr as $vha)
						{
							echo $vha."<br>";
						}
						?>
						</th>
					<th style='padding:6px; text-align:center'>
						<?php echo $row_invoice['tot_tr_dist']; ?>
					</th>
					</tr>
				<?php } ?>
				
			</table>
			<?php 
	$addon_arr=array();
	$addon_det=array();
		foreach($break_arr as $breakup2)
		{
			
			$shd = $conn->prepare("SELECT * FROM travel_sched where travel_id =? and addi_cost_for!='' and addi_amount!=''");
			$shd->execute(array($breakup2));
			//$row_shd = mysql_fetch_assoc($shd);
			$row_shd_main=$shd->fetchAll();
			$totalRows_shd = $shd->rowCount();

				foreach($row_shd_main as $row_shd)
				{
					$addon_det['sdate']=$row_shd['tr_date'];
					$addon_det['sname']=$row_shd['addi_cost_for'];
					$addon_det['samt']=$row_shd['addi_amount'];
					$addon_det['sqnty']=$row_shd['num_person'];
					array_push($addon_arr,$addon_det);
				}
		}

        //print_r($addon_arr);
		if(count($addon_arr)>0)
		{
		?>
	    <div style="margin-left:30px;border-bottom: 2px dotted;">
		<p align="left" style="margin-top:5px"><strong style="font-size: 12px;color: #0700;"> Including Special Add-ons On : </strong></p>
		<ul style="text-align: -moz-left;">
			<?php foreach($addon_arr as $spl){ ?>
			  <li style="font-size: 12px;"><?php //print_r($spl); 
		echo date("d-M-Y",strtotime($spl['sdate']))." - ".$spl['sname']." [ * ".$spl['sqnty']." ]";
			   ?> </li>
			<?php } ?>
		</ul></div>
	    <?php  } ?>

		</center>
	</div>
								<?php } ?>



                  <?php if($break_chk==0){?><input type="hidden" value="<?php echo $_GET['planid']; ?>" id='sub_planid' name="sub_planid" /><?php }
				   $break_chk++;?>

                               <?php /* <center><table style="width:95%; border:#DA832D 2px solid; background-color:#FFF7E9; color:#6B4D1E" class="table">
                                <tr><td width="18%">&nbsp;Guest Name</td><td width="3%">:</td><td width="25%"><?php echo $row_orders['tr_name']; ?></td>
                                <td width="20%">&nbsp;Pax Count</td><td width="3%">:</td><td width="20%"><?php echo $row_orders['pax_cnt']."&nbsp;Person(s)"; ?></td></tr>
                                <tr><td width="18%" >&nbsp;Total Traveling Days</td><td width="3%">:</td><td width="25%"><?php echo $row_orders['tr_days']; ?></td>			<td width="18%">&nbsp;Vehicle Infomation</td><td width="3%">:</td>
                                <td width="25%"><?php
								if($row_orders['tr_vehname'] == '')
								{
									$vah=explode(',',$row_orders['tr_vehids']);
									for($r=0;$r<count($vah);$r++)
									{
										if(trim($vah[$r]) != '')
										{
									  		
											$query_vpro = "SELECT * FROM vehicle_pro where vehi_id = '".$vah[$r]."'";
											$vpro = mysql_query($query_vpro, $divdb) or die(mysql_error());
											$row_vpro = mysql_fetch_assoc($vpro);
											$totalRows_vpro = mysql_num_rows($vpro);
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
									$veh_arrs=explode(',',$row_orders['tr_vehname']);
									for($v=0;$v<count($veh_arrs);$v++)
									{
										echo $veh_arrs[$v];
											if(isset($veh_arrs[$v+1]))
											{
												echo "<br>";
											}
									}
								}
								  ?></td></tr>
                                  <tr>
                                  <td> Total Travel Distance</td><td>:</td><td><?php echo $row_orders['tot_tr_dist']." Kms"; ?></td>
                                  <td> <!--Transport Charge--></td><td><!--:--></td><td><?php echo $row_orders['agnt_grand_tot']."/- Rupees"; ?></td></tr>
                                </table></center> 
                                    <!--New code for itinerary --><?php */ ?>
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
		$dt_arr[$row_dtcity1['name']]['id'] = $row_dtcity2['id'];
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
								if($totalRows_trv>0){	?>
                             <span style="color:#005598; font-weight:600; font-size:18px; text-align:center"><center><u>Tour Itinerary Plan (Program schedule)</u></center></span><span><center>Specially prepared for <?php echo $row_orders['tr_name'];?></center></span>
                                    <br />
                                    <?php  }?>
                                    <div class="col-sm-12">
                                     <?php foreach($row_trv_main as $row_trv){
										
										
										if($trv_cnt_1>0)
										{//for stay table - aft end day calculation
										
										?>
                                    <div class="col-sm-2" style="margin-top:15px; border-top:solid #DADADA 1px">
                                   
                                    <span style="color:#005598; font-weight:600;">
                                    <?php
										echo date('d-M-Y D',strtotime(str_replace('-','/',$row_trv['tr_date'])));
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
                                    
                                    <span style="color:#005598;  font-size:14px; font-weight:600"> <?php if($chn=='0'){?>Arrival - <?php }?> <?php echo $row_trv['tr_from_cityid'];if($chn=='0'){echo " [ ".$row_orders['tr_arrdet']." @".$row_orders['tr_arr_time']." ]";}
									
									//via edit start
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
					
							echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid'].". Check in ( 12:00 noon - standard time) at hotel, refresh and later proceed to Sight-seeing including - ";
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
										//print_r($dt_cnt_arr);
										if(!empty($dt_arr) && $chn != 0 && in_array($chn,$dt_cnt_arr) && isset($dt_arr[$row_trv['tr_from_cityid']][0]))
								 {
									// print "KIRAN";
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
										} ?></span>
                                      
                                        <?php
							if($row_trv['tr_from_cityid'] == $row_trv['tr_to_cityid'])
							{
								 echo "and later return to hotel. Overnight stay at hotel.";
								 // daytrip goes here
								 if(!empty($dt_arr))
								 {
									 if(isset($dt_arr[$row_trv['tr_from_cityid']][0]))
									 {
			echo "<br><span style='font-weight:bold; color:green'>"."DAYTRIP applicable to ".$dt_arr[$row_trv['tr_from_cityid']][0]." : </span>";


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
								 echo "and later proceed to ".$row_trv['tr_to_cityid'].". Overnight stay at hotel. ";
							}
								 }		?>
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
                                   
                                    <span style="color:#005598; font-weight:600;">
                                    <?php
									if($row_trv['tr_date'] != '')
									{
										echo date('d-M-Y D',strtotime(str_replace('-','/',$row_trv['tr_date'])));
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
                                    
                                    <span style="color:#005598; font-size:14px; font-weight:600"> <?php echo $row_trv['tr_from_cityid']."&nbsp;&nbsp;";
									
									//via edit start
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
									//via edit end
									
									echo "-&nbsp;&nbsp;".$row_trv['tr_to_cityid']."&nbsp;( Departure )  [ ".$row_orders['tr_depdet']."&nbsp; @".$row_orders['trv_depatr_time']." ]";
									
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
                                        <style="color:#AB5B14;" >* Special Add-ons to this date: 
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
									//print_r($rem_area_cnt); ?>
                                    </div>
                                    
                                    </div>
							</div><!-- /.row -->
                             <hr />
                            <?php } //main for loop?>
                            
                            <div  style="border-top:#999 solid 1px; margin-top:20px; text-align:justify" >
                            <br>
                                	<p style="color:#F00; font-weight:600; text-align:justify">Package Includes: </p>
                                    Transfers and sight-seeing  by  deluxe  tourists vehicle A/C <span style="color:#F00">(Vehicles up hill driving on the hills would be on Non AC) </span> <br>
                                    Toll & Parking <br>
                                    GST <br>
                                    All local sight-seeing in the same vehicle, every day after breakfast till sunset ( 0700 AM to 08PM)<br><br>
									
									                                   
                                    
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
                                    
                                    <b>IMPORTANT: </b> Kindly note that  vehicles  mentioned above only indicate that our rates have been based on usage of the locations and Kilometres  and it is not to be construed that the same vehicles will be provided if the vehicles are not available in the selected locations we shall provide from the different neareast availble location for the same rate may change (supplement/reduction whatever applicable). Unless until we  Dvi Holidays sends you the written confirmation from reservation the quote is not final. <br><br>
									
									<hr style="margin-top:10px; margin-bottom:10px;">
									<p style="color:#F00; ">Cancellation policy </p>
                                    CANCELLATION 30% of Package cost, if the cancellation is made 30 days prior to the departure. 50% of package cost, if the cancellation is made between 30-14 days prior to the departure.    |   70% of package cost, if the cancellation is made between 17-7 days prior to the departure.     |     100% of package cost, if the cancellation is made 7 days or less prior to the departure. <br><br>
                                    
                                    <b>General  Policy</b><br>
Child cost depends upon hotels rule which may vary from one hotel to another. The most common rules are as under: <br>
Child up to 5 years is free. Child above 5 years to 12 will be charged as per hotel rule. Child above 12 years will be charged as adult. <br>
If your reservation at hotels includes an extra bed, most hotels provide a folding cot or a mattress on floor as an extra bed. <br>
Check in and check out in most of the hotels at 1200 noon in the cities, In Hill stastions check in 1400 hrs check out 11 hrs. <br>
Early check-in or late check-out is subject to availability and may be chargeable by the hotel. <br>
To request for an early check-in or late check-out, kindly contact the hotel directly or inform us prior. <br>
									
                                    
                                </div>
                            
						</div>
