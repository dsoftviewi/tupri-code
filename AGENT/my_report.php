<?php
session_start();
require_once('../Connections/divdb.php');


$orders = $conn->prepare("SELECT * FROM travel_master where plan_id =?");
$orders->execute(array($_GET['planid']));
$row_orders = $orders->fetch(PDO::FETCH_ASSOC);
$totalRows_orders = $orders->rowCount();

$ttotl_pax=$row_orders['pax_cnt']-$row_orders['pax_child'];

?>
<style>
body {
    background-position: 50% 50%;
    margin:0px;
    padding:0px !important;
	font-family:calibri !important;
}
</style>
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
		
		<!-- MAIN CSS (REQUIRED ALL PAGE)-->
		<link href="../core/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="../core/assets/css/style.css" rel="stylesheet">
		<link href="../core/assets/css/style-responsive.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="../core/assets/plugins/Tags/jquery.tagsinput.css" />
        <script src="../core/assets/js/jquery.min.js"></script>
					<!-- Begin page heading -->
					<!-- BEGIN INVOICE -->
                    <?php
					
					$logo = $conn->prepare("SELECT * FROM agent_pro where agent_id =?");
					$logo->execute(array($_SESSION['uid']));
					$row_logo = $logo->fetch(PDO::FETCH_ASSOC);
					$totalRows_logo = $logo->rowCount();

					?>
                    
					<div class="the-box full invoice">
						<div class="the-box no-border bg-dark" style="vertical-align: text-middle; background-color:#3EAFDB">
							<div class="row">
								<div class="col-sm-6">
                                
									<img src="../img_upload/agent_img/logo/<?php echo $row_logo['comp_logo']; ?>"  alt="DVI Logo"/>
								</div><!-- /.col-sm-6 -->
								<div class="col-sm-6 text-right">
									<address style="color:#FFF">
									  <strong><?php echo $row_logo['agent_addr']; ?></strong><br>
									  <abbr title="Phone">Ph:</abbr><span style="color:#434A54; font-weight:bolder"> <?php if($row_logo['land_line'] != '') { echo $row_logo['land_line']; } elseif($row_logo['mobile_no'] != '') { echo $row_logo['mobile_no']; } else { echo 'N/A'; } ?> </span> &nbsp;&nbsp;</span> <abbr title="Website">Email: </abbr> <span style="color:#434A54; font-weight:bolder"> <?php echo $row_logo['email_id']; ?></span><br>
									</address>
								</div><!-- /.col-sm-6 -->
							</div><!-- /.row -->
						</div><!-- /.the-box no-border bg-dark -->
                        
                        
						<div class="the-box no-border">
                        <div class="row">
                        	<div class="col-sm-6">
                                <h3 class="text">Itinerary - Plan Report </h3>
                                <h4 class="text-muted text"><?php echo $_GET['planid']; ?></h4>
                            </div>
                            
							<div class="col-sm-6 text-right">
								<p>Arrival Date :<strong> <?php echo date("F jS, Y",strtotime($row_orders['tr_arr_date'])).'<br>'.$row_orders['tr_arr_time']; ?></strong></p>
                               <!-- <div class="btn-group pull-right">
											<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
											  Download
											  <span class="caret"></span>
											</button>
											<ul class="dropdown-menu">
											  <li><a href="myreport_pdf.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&planid=<?php echo urlencode($row_orders['plan_id']); ?>">PDF FORMAT</a></li>
											 
											</ul>
										  </div>-->
							</div>
                        </div>
							<!-- /.row -->
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

//total collection start 
$whole_itin_amt=0;
foreach($break_arr as $breakup_cal)
{
	
	$totcal = $conn->prepare("SELECT * FROM travel_master where plan_id =?");
	$totcal->execute(array($breakup_cal));
	$row_totcal= $totcal->fetch(PDO::FETCH_ASSOC);
	$whole_itin_amt=$whole_itin_amt+$row_totcal['agnt_grand_tot'];
}
//total collection end

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

                            <br />
                            <div class="row">

<?php if($break_chk==0)
								{ ?>
									<div class="col-sm-12" style="padding:6px">
											<center><strong style="color:#6B4D1E; font-size: 22px;">Overall Package Cost : 
												<?php echo convert_currency_text("RS",$_GET['planid'])." ".convert_currency($whole_itin_amt,$_GET['planid'])."/- Only"; ?></strong></center>
									</div>
								<?php } $break_chk++;?>

                            <div class="col-sm-12">
                            <table width="100%">
                            <tr height="30px" style="background-color:#434A54; color:#FFFFFF; font-size:16px; font-weight:600"><td  style="padding:10px;"colspan="3"><center><strong> Passenger information </strong></center></td></tr>
                            <tr>
                            <td width="40%" style="padding:10px;"><center><strong> Passenger name </strong></center></td><td width="10%" style="padding:10px;"> : </td>
                            <td width="50%" style="padding:10px;"><center><strong><?php echo $row_orders['tr_name']; ?> </strong></center></td>
                            </tr>
                            <tr>
                            <td width="40%" style="padding:10px;"><center><strong> Date of booking </strong></center></td><td width="10%" style="padding:10px;"> : </td>
                            <td width="50%" style="padding:10px;"><center><strong><?php echo $row_orders['date_of_reg']; ?> </strong></center></td>
                            </tr>
                            
                            <tr>
                            <td width="40%" style="padding:10px;"><center><strong> Total passenger </strong><br /><b style="font-size:12px">( Adult + Child[5-12] + Child[<5] )</b></center></td><td width="10%" style="padding:10px;"> : </td>
                            <td width="50%" style="padding:10px;"><center><strong><?php echo $row_orders['pax_cnt']." Person(s)"; ?> <br /><?php echo "(&nbsp;".$row_orders['pax_adults']."&nbsp;+&nbsp;".$row_orders['pax_512child']."&nbsp;+&nbsp;".$row_orders['pax_child']."&nbsp;)";?></strong></center></td>
                            </tr>
                            </table>
                            </div>
                        	</div>
                            
                            <?php
							$grand_ttotal=0;
							
							if(substr($row_orders['plan_id'],0,1) != 'H')
							{
								
								$routes = $conn->prepare("SELECT * FROM travel_sched where travel_id =? ORDER BY sno ASC");
	$routes->execute(array($_GET['planid']));
	$row_routes_main = $routes->fetchAll();
	$totalRows_routes = $routes->rowCount();

							?>
                            <h3 class="text"><strong> Tranport details </strong></h3>
							<div class="table-responsive">
								<table class="table table-th-block table-bordered table-striped table-dark">
									<thead>
										<tr>
                                        	<th>TRAVEL DATE</th>
											<th>TRAVEL DESC</th>
                                           <!-- <th>DISTANCE (Kms)</th>-->
											<!--<th>sightseeing DISTANCE (Kms)</th>-->
                                            <!--<th>TOTAL DISTANCE (Kms)</th>-->
											<th>TIME</th>
										</tr>
									</thead>
									<tbody>
                                     <?php
									 $cnt=1;
										foreach($row_routes_main as $row_routes)
										{
										?>
										<tr>
											<td>
											<p><strong><?php echo date("F jS, Y",strtotime($row_routes['tr_date'])); ?></strong></p>
                                             </td>
                                             <td>
												<p class="text-muted">
												<?php echo $row_routes['tr_from_cityid'].' TO '.$row_routes['tr_to_cityid']; ?>
												</p>
                                             </td>
                                             
                                             <!--<td>
                                             <?php // echo $row_routes['tr_dist_ss']; ?>
                                             </td>-->
											 <?php /*?><td><?php echo $row_routes['ss_dist']; ?></td>
											 <td><?php echo $row_routes['tr_dist_ss']; ?></td><?php */?>
                                             <td><?php echo $row_routes['tr_time']; ?></td>
										</tr>
										<?php
										$cnt++;
										}
										
										?>
									</tbody>
								</table>
							</div><!-- /.table-responsive -->
							<?php
							}
							?>
							
							<!-- /.row -->
                            
                            <!-- Day trip table if applicable -->
                            <?php
							if(substr($row_orders['plan_id'],0,1) != 'H')
							{
								
								 $dtrip = $conn->prepare("SELECT * FROM travel_daytrip where travel_id =? ORDER BY sno ASC");
$dtrip->execute(array($_GET['planid']));
$row_dtrip_main =$dtrip->fetchAll();
$totalRows_dtrip = $dtrip->rowCount();
								
								if($totalRows_dtrip > 0)
								{
								?>
                           			<h3 class="text"><strong> Day-Trip details </strong></h3>
                                    <div class="table-responsive">
                                        <table class="table table-th-block table-bordered table-striped table-dark">
                                            <thead>
                                                <tr>
                                                    <th>FROM CITY</th>
                                                    <th>TO CITY</th>
                                                    <th width="30%">DISTANCE (Including return)(Kms)</th>
                                                    <!--<th>sightseeing DISTANCE (Kms)</th>
                                                    <th>TOTAL DISTANCE (Kms)</th>-->
                                                </tr>
                                            </thead>
                                            <tbody>
                                             <?php
                                             $cnt=1;
                                                foreach($row_dtrip_main as $row_dtrip)
                                                {
                                                    
                                                    $dtcity = $conn->prepare("SELECT * FROM dvi_cities where id =?");
                                                    $dtcity->execute(array($row_dtrip['orig_cid']));
                                                    $row_dtcity = $dtcity->fetch(PDO::FETCH_ASSOC);
													
													
                                                    $dtcity1 = $conn->prepare("SELECT * FROM dvi_cities where id =?");
                                                    $dtcity1->execute(array($row_dtrip['to_cid']));
                                                    $row_dtcity1 =$dtcity1->fetch(PDO::FETCH_ASSOC);
                                                ?>
                                                <tr>
                                                     <td><?php echo $row_dtcity['name']; ?></td>
                                                     <td><?php echo $row_dtcity1['name']; ?></td>
                                                     <td width="30%"><?php echo $row_dtrip['trav_dist']." + ".$row_dtrip['trav_dist']. "= ".($row_dtrip['trav_dist'] * 2); ?></td>
                                                     <?php /*?><td><?php echo $row_dtrip['ss_dist']; ?></td>
                                                     <td><?php echo $row_dtrip['tot_dist']; ?></td><?php */?>
                                                </tr>
                                                <?php
                                                $cnt++;
                                                }
                                                
                                                ?>
                                            </tbody>
                                        </table>
                                    </div><!-- /.table-responsive -->
							<?php
								}
							}
							?>
                            
							<?php
							if(substr($_GET['planid'],0,1) == 'T' || substr($_GET['planid'],0,2) == 'TH')
							{
								
								$trvrent = $conn->prepare("SELECT * FROM travel_vehicle where travel_id =?");
								$trvrent->execute(array($_GET['planid']));
								$row_trvrent = $trvrent->fetch(PDO::FETCH_ASSOC);
								$totalRows_trvrent =$trvrent->rowCount();
								
								$get_vehicl = rtrim($row_orders['tr_vehids'],',');
								$veh_name = explode(',',$get_vehicl);
								$vehnames = ''; $vcnt = 0;
								
								foreach($veh_name as $vehtyp) 
								{
									$vcnt++;
									
									$vtyp = $conn->prepare("SELECT * FROM vehicle_pro where vehi_id =?");
									$vtyp->execute(array($vehtyp));
									$row_vtyp = $vtyp->fetch(PDO::FETCH_ASSOC);
									$totalRows_vtyp =$vtyp->rowCount();

									$vehnames.= $vcnt.' - '.$row_vtyp['vehicle_type'].' ';
								}
								
								
								
								$vcity = $conn->prepare("SELECT * FROM dvi_cities where id =?");
								$vcity->execute(array($row_orders['tr_veh_cityid']));
								$row_vcity = $vcity->fetch(PDO::FETCH_ASSOC);
							
							?>
                                <div class="row">
                                <div class="col-sm-12" align="center" > <h3 class="text"><strong> Vehicle - travel information </strong></h3></div>
                                    <div class="col-sm-12" style="margin-top:10px;"> 
                                    <div class="col-sm-2"></div>
                                       <div class="col-sm-3">Number of vehicles taken</div>
                                       <div class="col-sm-1">:</div>
                                       <div class="col-sm-6"><?php echo $totalRows_trvrent; ?></div>
                                       </div>
                                       <div class="col-sm-12"  style="margin-top:10px;">
                                        <div class="col-sm-2"></div>
                                       <div class="col-sm-3">Type of vehicle taken</div>
                                       <div class="col-sm-1">:</div>
                                       <div class="col-sm-6"><?php echo $vehnames; ?></div>
                                       </div>
                                </div>

							<!-- /.row -->
                            <?php $grand_ttotal=$grand_ttotal+$row_orders['tr_net_amt'];
							}
							?>
                            
                            
                            <br />
                            <?php
							if(substr($_GET['planid'],0,2) == 'TH')
							{
								
								
$sspro = $conn->prepare("SELECT * FROM stay_sched where stay_id =? ORDER BY sno ASC ");
$sspro->execute(array($_GET['planid']));
//$row_sspro = mysql_fetch_assoc($sspro);
$row_sspro_main=$sspro->fetchAll();
$totalRows_sspro = $sspro->rowCount();
 $row_count=$totalRows_sspro;	
 if($row_count>0){
							?>
                            <div class="row">
                            <div class="col-sm-12">
                            <h3 class="text"><strong> Tour Itinerary Plan (Program schedule): </strong></h3>
                            <p style="font-size:18px">Specially prepared for <?php echo $row_orders['tr_name'];?></p>
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
$i=0; 
								if($totalRows_trv>0){	?>
                                    <?php /*?><span style="color:#666; font-size:18px; text-align:center"><center><u>Tour Itinerary Plan (Program schedule)</u></center></span><span><center>Specially prepared for <?php echo $row_orders['tr_name'];?></center></span><?php */?>
                                    <?php }?>
                                    <div class="col-sm-12">
                                     <?php foreach($row_trv_main as $row_trv){
										
										if($row_count>0)
										{//for stay table - aft end day calculation
										$row_sspro = $row_sspro_main[$i];
										?>
                                    <div class="col-sm-2" style="margin-top:15px; border-top:solid #DADADA 1px">
                                   
                                    <span style="color:#000; font-weight:600;">
                                    <?php
									if($row_trv['tr_date'] == $row_sspro['sty_date'])
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
									//echo " (".$row_trv['tr_dist_ss']." Kms)";
									$today_dist=$row_trv['tr_dist_ss'];
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
	
	$time6am=date('U',strtotime($row_orders['tr_arr_date'].' 06:00 AM'));
	$time3pm=date('U',strtotime($row_orders['tr_arr_date'].' 03:00 PM'));
	$time6pm=date('U',strtotime($row_orders['tr_arr_date'].' 06:00 PM'));
	
				if($row_trv['tr_from_cityid']==$row_trv['tr_to_cityid'])
				{//next day also same city means
						if($time6am <= $arr_date_tstmp && $arr_date_tstmp <= $time3pm)
						{//between 6am to 3pm ( over night in same city)
					
							echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid'].", proceed to hotel. Check in ( 12:00 noon - standard time) at hotel, refresh and later proceed to sight-seeing including - ";
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
							
							echo " and later return to ".$row_hotel2['hotel_name']." and overnight stay at hotel.";
						}else if($time3pm <= $arr_date_tstmp && $arr_date_tstmp <= $time6pm)
						{//between 6am to 3pm ( over night in same city)
							echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid']." and proceed to hotel, check-in and overnight at ".$row_hotel2['hotel_name'];//have to show sightseeing in next day
							$show_in_next_day=2;
								$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-2;
						}else if($time6pm <= $arr_date_tstmp && $arr_date_tstmp <= $arr_timenx6am)
						{//between 6am to 3pm ( over night in same city)
							echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid'].", proceed to hotel, check-in and overnight stay at ".$row_hotel2['hotel_name']." hotel.";//have to show sightseeing in next day
							$show_in_next_day=2;
							$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-2;
						}
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
									
							echo "and later drive to ".$row_trv['tr_to_cityid'].", check-in and overnight stay at ".$row_hotel2['hotel_name']." hotel.";
	
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
						echo " later drive to ".$row_trv['tr_to_cityid'].", check-in and overnight stay at ".$row_hotel2['hotel_name']." hotel.";
							
						}else if($time6pm <= $arr_date_tstmp && $arr_date_tstmp <= $arr_timenx6am)
						{//between 6am to 3pm ( over night in diff city)
						echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid']." and proceed to ".$row_trv['tr_to_cityid'].", arrival and check-in and Overnight stay at ".$row_hotel2['hotel_name']." hotel.";//skip sightseeing and proceed to next day if
						
						//have to skip
						$hots_array=array();
									$vg=0;
									foreach($row_hot_main as $row_hot){
										   $hots_array[$vg]='<strong>'.$row_hot['spot_name'];
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
								 echo "and later return to hotel. Overnight stay at ".$row_hotel2['hotel_name']." hotel.";
								 // daytrip goes here
								 if(!empty($dt_arr))
								 {
									 if(isset($dt_arr[$row_trv['tr_from_cityid']][0]) && !is_numeric($dt_arr[$row_trv['tr_from_cityid']][0]))
									 {
 echo "<br><span style='font-weight:bold; color:green'>"."DAYTRIP applicable to ".$dt_arr[$row_trv['tr_from_cityid']][0]."</span>";

 							 
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
										else{?>
											<div class="col-sm-2" style="margin-top:15px; border-top:solid #DADADA 1px">
                                   
                                    <span style="color:#000; font-weight:600;">
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
                                    
                                    <span style="color:#000;  font-size:14px; font-weight:600"> <?php echo $row_trv['tr_from_cityid']."&nbsp;&nbsp;-&nbsp;&nbsp;".$row_trv['tr_to_cityid'];
									
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
                                    </div>
                                    
										<?php }
										 
										$row_count--;
									$totalRows_trv--;
									$i++;
									//$row_count--;
									 }
									//print_r($rem_area_cnt); ?>
                                    </div>
                                    </div>
                                    </div>
                                    <?php
 }//if hotel table having detail to this itinerary
 else{//if hotel itinerary cancel before booking hotel
	 //echo "Hotel Cancelled..";
	 ?>
	 <div class="row">
                            <div class="col-sm-12">
                            <h3 class="text"><strong> Tour Itinerary Plan (Program schedule): </strong> <strong style="font-size:12px; color:#930">But Staying details are not created.</strong></h3>
                            <p style="font-size:18px">Specially prepared for <?php echo $row_orders['tr_name'];?></p>
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
			
					            

$trv = $conn->prepare("SELECT * FROM travel_sched where travel_id =? ORDER BY sno ASC");
$trv->execute(array($_GET['planid']));
//$row_trv = mysql_fetch_assoc($trv);
$row_trv_main =$trv->fetchAll();
$totalRows_trv = $trv->rowCount();
$chn=0; 
$trv_cnt_1 = $totalRows_trv - 1;
								if($totalRows_trv>0){	?>
                                    <?php /*?><span style="color:#666; font-size:18px; text-align:center"><center><u>Tour Itinerary Plan (Program schedule)</u></center></span><span><center>Specially prepared for <?php echo $row_orders['tr_name'];?></center></span><?php */?>
                                    <?php }?>
                                
                                     <?php foreach($row_trv_main as $row_trv) {
										 ?>
                                             <div class="col-sm-12">
                                         <?php 
																				
										if($trv_cnt_1>0)
										{//for stay table - aft end day calculation
										
										?>
                                    <div class="col-sm-2" style="margin-top:15px; border-top:solid #DADADA 1px">
                                   
                                    <span style="color:#000; font-weight:600;">
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
                                    
                                    <span style="color:#000;  font-size:14px; font-weight:600"> <?php if($chn=='0'){?>Arrival - <?php }?> <?php echo $row_trv['tr_from_cityid'];if($chn=='0'){echo " [ ".$row_orders['tr_arrdet']." @".$row_orders['tr_arr_time']." ]";}
									
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
							echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid']." and proceed to hotel, check-in and overnight at hotel.";//have to show sightseeing in next day
							$show_in_next_day=2;
								$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-2;
						}else if($time6pm <= $arr_date_tstmp && $arr_date_tstmp <= $arr_timenx6am)
						{//between 6am to 3pm ( over night in same city)
							echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid'].", proceed to hotel, check-in and overnight stay at hotel.";//have to show sightseeing in next day
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
						echo "If time permits proceed to sight-seeing include - ";
						
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
						echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid']." and proceed to ".$row_trv['tr_to_cityid'].", arrival and check-in and Overnight stay at hotel.";//skip sightseeing and proceed to next day if
						
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
									 if(isset($dt_arr[$row_trv['tr_from_cityid']][0]) && !is_numeric($dt_arr[$row_trv['tr_from_cityid']][0]))
									 {
					echo "<br><span style='font-weight:bold; color:green'>"."DAYTRIP applicable to ".$dt_arr[$row_trv['tr_from_cityid']][0]."</span>";
							 
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
                                    
                                    <span style="color:#000;  font-size:14px; font-weight:600"> <?php echo $row_trv['tr_from_cityid']."&nbsp;&nbsp;-&nbsp;&nbsp;".$row_trv['tr_to_cityid'];
									
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
									
                                    </div>
										<?php }
										 
										$trv_cnt_1--;
									$totalRows_trv--;
									//$row_count--;
									?>
                                    </div> <?php 
									 }
									//print_r($rem_area_cnt); ?>
                                    
                                    </div>
                                    </div>
                                    <?php
	 
 }
							}
							elseif(substr($_GET['planid'],0,2) == 'T#')
							{
								//Intinerary for travel only customers
								?>
                                <div class="row">
                            <div class="col-sm-12">
                            <h3 class="text"><strong> Tour Itinerary Plan (Program schedule): </strong></h3>
                            <p style="font-size:18px">Specially prepared for <?php echo $row_orders['tr_name'];?></p>
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
                                    <?php /*?><span style="color:#666; font-size:18px; text-align:center"><center><u>Tour Itinerary Plan (Program schedule)</u></center></span><span><center>Specially prepared for <?php echo $row_orders['tr_name'];?></center></span><?php */?>
                                    <?php }?>
                                
                                     <?php foreach($row_trv_main as $row_trv){
										 ?>
                                             <div class="col-sm-12">
                                         <?php 
										
										
										if($trv_cnt_1>0)
										{//for stay table - aft end day calculation
										
										?>
                                    <div class="col-sm-2" style="margin-top:15px; border-top:solid #DADADA 1px">
                                   
                                    <span style="color:#000; font-weight:600;">
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
                                    
                                    <span style="color:#000;  font-size:14px; font-weight:600"> <?php if($chn=='0'){?>Arrival - <?php }?> <?php echo $row_trv['tr_from_cityid'];if($chn=='0'){echo " [ ".$row_orders['tr_arrdet']." @".$row_orders['tr_arr_time']." ]";}
									
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
									//echo " (".$row_trv['tr_dist_ss']." Kms)";
									$today_dist=$row_trv['tr_dist_ss'];
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
							echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid']." and proceed to hotel, check-in and overnight at hotel.";//have to show sightseeing in next day
							$show_in_next_day=2;
								$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-2;
						}else if($time6pm <= $arr_date_tstmp && $arr_date_tstmp <= $arr_timenx6am)
						{//between 6am to 3pm ( over night in same city)
							echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid'].", proceed to hotel, check-in and overnight stay at hotel.";//have to show sightseeing in next day
							$show_in_next_day=2;
							$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-2;
						}
						// daytrip not applicable for arrival
						
				}else{//next day having different city means
					if($time6am <= $arr_date_tstmp && $arr_date_tstmp <= $time3pm)
						{//between 6am to 3pm ( over night in diff city)
					echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid'].", proceed to visit the following sight-seeing spots including - ";
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
						echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid']." and proceed to ".$row_trv['tr_to_cityid'].", arrival and check-in and Overnight stay at hotel.";//skip sightseeing and proceed to next day if
						
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
									 if(isset($dt_arr[$row_trv['tr_from_cityid']][0]) && !is_numeric($dt_arr[$row_trv['tr_from_cityid']][0]))
									 {
					echo "<br><span style='font-weight:bold; color:green'>"."DAYTRIP applicable to ".$dt_arr[$row_trv['tr_from_cityid']][0]."</span>";

												 
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
                                    
                                    <span style="color:#000;  font-size:14px; font-weight:600"> <?php echo $row_trv['tr_from_cityid']."&nbsp;&nbsp;";
									
									//via edit start
									$via_cities_arr=explode('-',$row_trv['via_cities']);
									//print_r($via_cities_arr);
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
									//echo " (".$row_trv['tr_dist_ss']." Kms)";
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
									
									?>
                                    </div>
										<?php }
										 
										$trv_cnt_1--;
									$totalRows_trv--;
									//$row_count--;
									?>
                                    </div> <?php 
									 }
									//print_r($rem_area_cnt); ?>
                                    
                                    </div>
                                    </div>
                                <?php
							}
							?>
                            <hr />
                            
                            
                            <?php 
												
					
$spro = $conn->prepare("SELECT * FROM stay_sched where stay_id =? ORDER BY sno ASC ");
$spro->execute(array($_GET['planid']));
//$row_spro = mysql_fetch_assoc($spro);
$row_spro_main=$spro->fetchAll();
$totalRows_spro = $spro->rowCount();
							if(substr($_GET['planid'],0,1) == 'H' || (substr($_GET['planid'],0,2)=='TH' && $totalRows_spro>0))
							{ ?>
                            <div class="row" style="margin-top:20px">
                            <h3 class="text"><strong> Hotel Accomodation details: </strong></h3>
                            <div class="col-sm-12">
                            <?php 
		
$scnt=1;
							?>
                            <table width="100%" class="table table-bordered table-th-block table-striped">
                                    <tr><th>S.No</th><th>Date</th><th>Place</th><th>Hotel</th><th>Room Category</th><th>Meal Plan</th><th>T Nights</th></tr>
                                    <?php foreach($row_spro_main as $row_spro){ ?>
                                    <tr><td><?php echo $scnt; ?></td><td><?php
									echo date("d-M-Y",strtotime(substr($row_spro['sty_date'],'0','10')));
					/*				
$query_spro1 = "SELECT * FROM stay_sched where stay_id = '".$_GET['planid']."' and hotel_id='".$row_spro['hotel_id']."'  ORDER BY sno ASC ";
$spro1 = mysql_query($query_spro1, $divdb) or die(mysql_error());
$row_spro1 = mysql_fetch_assoc($spro1);
$totalRows_spro1 = mysql_num_rows($spro1);
						
						$org_date= date('Y-M-d',strtotime(substr($row_spro['sty_date'],'0','10')));
						if($totalRows_spro1>1)
						{			
						$totalRows_spro2=$totalRows_spro1-1;
						$date=date_create(substr($row_spro['sty_date'],'0','10'));
date_add($date,date_interval_create_from_date_string($totalRows_spro2." days"));
echo $org_date."&nbsp;to&nbsp;".date_format($date,"Y-M-d");
						}else
						{
echo $org_date;	
						}*/
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
$row_hotell =$hotell->fetch(PDO::FETCH_ASSOC);
$totalRows_hotell = $hotell->rowCount();
echo $row_hotell['hotel_name'];
									 ?>
                                     </td>
                                     <td>
                                     <?php 
									// echo $row_spro['sty_room_name'];
									$rrom=explode(',',$row_spro['sty_room_name']);
									$rrom1=array_unique($rrom);
									//print_r($rrom1);
									$rrom1=array_values($rrom1);
									//print_r($rrom1);
									
									$rrom2=array_count_values($rrom);
									//print_r($rrom2);
									
									for($tt=0;$tt<count($rrom1);$tt++)
									{
										if(isset($rrom1[$tt])&& $rrom1[$tt]!='')
										{
												if(isset($rrom1[$tt+1]) && $rrom1[$tt+1] !='')
												{
													echo $rrom1[$tt]." - ".$rrom2[$rrom1[$tt]].",<br>"; 
												}else
												{
													echo $rrom1[$tt]." - ".$rrom2[$rrom1[$tt]]; 
												}
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
                                     <td><center><?php echo "1";//echo $totalRows_spro1; ?></center></td>
                                     </tr>
                                    <?php 
									/*if($totalRows_spro1>1)
									{
										for($rt=0;$rt<$totalRows_spro1-1;$rt++)
										{
										$row_spro = mysql_fetch_assoc($spro);	
										}
									}*/
									
									$scnt++; }  ?>
                                    </table>
                            
                            </div>
                            
                            </div>
                            <?php }?>
                            
                            
                            
                            <div class="the-box" style="background-color:#E6ECF2;">
                           <!-- <p><strong style="font-size: x-large;color: rgb(30, 36, 153);">Amount payable to DVI&nbsp;&nbsp;: &#8377;&nbsp;<?php $dvi_amt = $row_orders['grand_tot'] * ((100+$row_orders['agnt_adm_perc']) / 100);  echo floor($dvi_amt * 100) / 100; ?></strong></p>
        <p><strong style="font-size: x-large;color: rgb(30, 36, 153);">Your Profit %&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $row_orders['agent_perc']; ?></strong></p>-->
                            <strong  style="font-size: x-large;color: rgb(30, 36, 153);">Grand Total Of This Plan : &nbsp;<?php echo  convert_currency_text("&#8377;",$_GET['planid'])." ".convert_currency($row_orders['agnt_grand_tot'],$_GET['planid']);
							if((substr($_GET['planid'],0,2)=='TH' && $totalRows_spro==0))
							{
								echo "<strong style='color:#690; font-size:15px' > - But Cancelled Itinerary</strong>";
							}
		?></strong>
        <br /></div>

        <?php } //main for loop?>
        <br />
							<!-- /.jumbotron .jumbotron-sm -->
							
						</div><!-- /.the-box no-border no-margin-->
					</div><!-- /.the-box -->
					<!-- END INVOICE -->
		
        <script src="../core/assets/js/jquery.min.js"></script>
        <script src="../core/assets/plugins/fancybox/lib/jquery-1.8.2.min.js"></script>
        <link href="../core/assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet">
<script src="../core/assets/plugins/fancybox/source/jquery.fancybox.js"></script>
        <script src="../core/assets/plugins/fancybox/source/jquery.fancybox.pack.js"></script>
        <script type="text/javascript">
$(document).ready(function() {
$('.fancybox').fancybox({
		
		fitToView	: true,
		width		: '800px',
		height		: '600px',  
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'fade',
		closeEffect	: 'none',
		type		: 'iframe',
        afterClose : function() {
    /*parent.location.reload("index.php");*/
  },

});
});
$(document).ready(function() {
$('.fancybox1').fancybox({
		
		fitToView	: true,
		width		: '600px',
		height		: '250px',  
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'fade',
		closeEffect	: 'none',
		type		: 'iframe',
        afterClose : function() {
    /*parent.location.reload("index.php");*/
  },

});
});
</script>
        
        
		<script src="../core/assets/js/bootstrap.min.js"></script>
		<script src="../core/assets/plugins/retina/retina.min.js"></script>
        <script src="../core/assets/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
		<script src="../core/assets/plugins/nicescroll/jquery.nicescroll.js"></script>
		<script src="../core/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		<script src="../core/assets/plugins/backstretch/jquery.backstretch.min.js"></script>
        
		<script src="../core/assets/plugins/skycons/skycons.js"></script>
		<script src="../core/assets/plugins/prettify/prettify.js"></script>
<!--		<script src="../core/assets/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>-->
		<script src="../core/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
		<script src="../core/assets/plugins/datatable/js/bootstrap.datatable.js"></script>
	<!--	<script src="../core/assets/plugins/slider/bootstrap-slider.js"></script>-->
		
		<script src="../core/assets/plugins/toastr/toastr.js"></script>
        
		<!-- PLUGINS -->
      <!--  <script type="text/javascript" src="../core/assets/plugins/Tags/jquery.tagsinput.js"></script>
        <script src="../core/assets/plugins/chosen/chosen.jquery.min.js"></script>
		<script src="../core/assets/plugins/spinner/js/jquery.dpNumberPicker-1.0.1-min.js"></script>-->
        
		<script src="../core/assets/js/apps.js"></script>
		<script src="../core/assets/js/demo-panel-1.js"></script>
        <script src="../core/assets/jQuery1/form-validator/spin.js"></script>
        <script src="../core/assets/js/moment.js"></script>
		<script>
		$(document).ready(function(e) {
			$('.datatable-example').dataTable();
        });

</script>