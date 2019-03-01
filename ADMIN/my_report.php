<?php
session_start();
require_once('../Connections/divdb.php');




$orders = $conn->prepare("SELECT * FROM travel_master where plan_id =?");
$orders->execute(array($_GET['planid']));
$row_orders = $orders->fetch(PDO::FETCH_ASSOC);
$totalRows_orders = $orders->rowCount();

$ttotl_pax=$row_orders['pax_cnt']-$row_orders['pax_child']; 

$adl_ch152=$row_orders['pax_adults']+$row_orders['pax_512child'];
$no_of_roomss=$row_orders['stay_rooms'];


$agnt = $conn->prepare("SELECT * FROM agent_pro where agent_id =?");
$agnt->execute(array($row_orders['agent_id']));
$row_agnt = $agnt->fetch(PDO::FETCH_ASSOC);
$totalRows_agnt = $agnt->rowCount();

?>
<style>
body {
    background-position: 50% 50%;
    margin:0px;
    padding:0px !important;
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
					<div class="the-box full invoice">
						<div class="the-box no-border bg-dark" style="vertical-align: text-middle; background-color:#3EAFDB">
							<div class="row">
								<div class="col-sm-6">
									<img src="../images/logo2.png"  alt="DVI Logo"/>
								</div><!-- /.col-sm-6 -->
								<div class="col-sm-6 text-right">
									<address style="color:#FFF">
									  <strong>DoView Holidays India Pvt. Ltd.</strong><br>
									  No-51, Vijaya Nagar, Dheeran Nagar<br>
									  Tiruchirapalli - 620009, Tamilnadu<br>
									  <abbr title="Phone">Ph:</abbr><span style="color:#434A54; font-weight:bolder"> 0431 2403615 </span> &nbsp;&nbsp;</span> <abbr title="Website">web: </abbr> <span style="color:#434A54; font-weight:bolder"> www.dvi.co.in</span><br>
									</address>
								</div><!-- /.col-sm-6 -->
							</div><!-- /.row -->
						</div><!-- /.the-box no-border bg-dark -->
                        
                        
						<div class="the-box no-border">
                        <div class="row">
                        	<div class="col-sm-6">
                                <h3 class="text">Itinerary - Admin payment report </h3>
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
                            <br />



                            <?php
                      //breakup start 

$breakup = $conn->prepare("SELECT * FROM travel_master where plan_id =?");
$breakup->execute(array($_GET['planid']));
$row_breakup = $breakup->fetch(PDO::FETCH_ASSOC);
$totalRows_breakup =$breakup->rowCount();

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
if(!empty($row_orders['sub_paln_id'])){
		$Passenger_name = $row_orders['tr_name'];
	}
	$totalRows_orders = $orders->rowCount();

//print_r($convert_currency);
                      ?>
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
                            <td width="50%" style="padding:10px;"><center><strong><?php echo $Passenger_name; ?> </strong></center></td>
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
								$totalRows_routes =$routes->rowCount();

							?>
                            <h3 class="text"><strong> Tranport details </strong></h3>
							<div class="table-responsive" style="overflow-x:scroll">
								<table class="table table-th-block table-striped table-dark">
									<thead>
										<tr>
                                        	<th>TRAVEL DATE</th>
											<th>TRAVEL DESC</th>
                                            <th>DISTANCE (Kms)</th>
											<th>SIGHT-SEEING DISTANCE (Kms)</th>
                                            <th>TOTAL DISTANCE (Kms)</th>
											<th>TIME</th>
										</tr>
									</thead>
									<tbody>
                                     <?php
									 $cnt=1;
									 $tt_dist_cal=0;
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
                                             
                                             <td>
                                             <?php echo $row_routes['tr_dist_ess']; ?>
                                             </td>
											 <td><?php echo $row_routes['ss_dist']; ?></td>
											 <td><?php echo $row_routes['tr_dist_ss']; $tt_dist_cal=$tt_dist_cal+(int)$row_routes['tr_dist_ss']; ?></td>
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
								$row_dtrip_main = $dtrip->fetchAll();
								$totalRows_dtrip = $dtrip->rowCount();
								
								if($totalRows_dtrip > 0)
								{
								?>
                           			<h3 class="text"><strong> Day-Trip details </strong></h3>
                                    <div class="table-responsive" style="overflow-x:scroll">
                                        <table class="table table-th-block table-striped table-dark">
                                            <thead>
                                                <tr>
                                                    <th>FROM CITY</th>
                                                    <th>TO CITY</th>
                                                    <th>DISTANCE (Including return) (Kms)</th>
                                                    <th>SIGHT-SEEING DISTANCE (Kms)</th>
                                                    <th>TOTAL DISTANCE (Kms)</th>
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
                                                    $row_dtcity1 = $dtcity1->fetch(PDO::FETCH_ASSOC);
                                                ?>
                                                <tr>
                                                     <td><?php echo $row_dtcity['name']; ?></td>
                                                     <td><?php echo $row_dtcity1['name']; ?></td>
                                                     <td><?php echo $row_dtrip['trav_dist']." + ".$row_dtrip['trav_dist']. "= ".($row_dtrip['trav_dist'] * 2); ?></td>
                                                     <td><?php echo $row_dtrip['ss_dist']; ?></td>
                                                     <td><?php echo $row_dtrip['tot_dist']; 
													 $tt_dist_cal=$tt_dist_cal+(int)$row_dtrip['tot_dist'];
													 ?></td>
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
							$row_trvrent_main = $trvrent->fetchAll();
							$totalRows_trvrent = $trvrent->rowCount();
							
							$get_vehicl = rtrim($row_orders['tr_vehids'],',');
							$veh_name = explode(',',$get_vehicl);
							$vehnames = ''; $vcnt = 0;
							foreach($veh_name as $vehtyp)
							{
								$vcnt++;
								
								$vtyp = $conn->prepare("SELECT * FROM vehicle_pro where vehi_id =?");
								$vtyp->execute(array($vehtyp));
								$row_vtyp = $vtyp->fetch(PDO::FETCH_ASSOC);
								$totalRows_vtyp = $vtyp->rowCount();
								
								$vehnames.= $vcnt.') '.$row_vtyp['vehicle_type'].' ';
							}
							
							
							$vcity = $conn->prepare("SELECT * FROM dvi_cities where id =?");
							$vcity->execute(array($row_orders['tr_veh_cityid']));
							$row_vcity = $vcity->fetch(PDO::FETCH_ASSOC);
							
							?>
                            <div class="row" align="center">
                            <table width="80%" align="center" border="1px solid #CCC">
                            <tr><td style="padding:6px;background-color: rgb(221, 221, 221); " colspan="3" align="center"><h4 class="text"><strong> Vehicle - Travel information </strong></h4></td></tr>
                            <tr><td style="padding:6px; " width="38%">Number of vehicles taken</td>
                            <td width="4%" align="center">:</td><td width="38%">&nbsp; <?php echo $totalRows_trvrent; ?></td></tr>
                            <tr><td style="padding:6px; " width="38%">Type of vehicle taken</td>
                            <td width="4%" align="center">:</td><td width="38%">&nbsp; <?php echo $vehnames; ?></td></tr>
                            <tr><td style="padding:6px; " width="38%">Vehicle origin city</td>
                            <td width="4%" align="center">:</td><td width="38%">&nbsp; <?php echo $row_vcity['name']; ?></td></tr>
                            <tr><td style="padding:6px; " width="38%"> Onward distance </td>
                            <td width="4%" align="center">:</td><td width="38%">&nbsp; <?php echo ($row_orders['tot_tr_dist'] - 80).'  - kms'; ?></td>
                            </tr>
                            <tr><td style="padding:6px; " width="38%"> Airport/Railstation pick-up/drop distance </td>
                            <td width="4%" align="center">:</td><td width="38%">&nbsp; 80  - kms </td></tr>
                            <?php if($row_orders['dt_tot_dist'] > 0){ ?>
                            <tr><td style="padding:6px; " width="38%"> Day trip travel distance (including Sight-seeing) </td>
                            <td width="4%" align="center">:</td><td width="38%">&nbsp; <?php echo $row_orders['dt_tot_dist'].'  - kms'; ?> </td></tr>
                            <?php } ?>
                            <tr><td style="padding:6px; " width="38%"> Total distance (including pick-up/drop) </td>
                            <td width="4%" align="center">:</td><td width="38%">&nbsp; <?php echo $row_orders['tot_tr_dist'].'  - kms'; ?> </td></tr>
                            <tr><td style="padding:6px; " width="38%"> Return distance  </td>
                            <td width="4%" align="center">:</td><td width="38%">&nbsp; <?php echo $row_orders['tr_return_dist'].'  - kms'; ?></td></tr>
                            <tr><td style="padding:6px; " width="38%"> Travel days </td>
                            <td width="4%" align="center">:</td><td width="38%">&nbsp; <?php echo $row_orders['tr_days']; ?></td></tr>
                             <?php
									if ($row_orders['perm_cityid'] != '')
									{
										$each_stname = '';
										$get_st = explode(',', $row_orders['perm_cityid']);
										$get_st1 = array_unique($get_st);
										$get_st2 = array_values($get_st1);
										foreach($get_st2 as $each_st)
										{
											
											$pst = $conn->prepare("SELECT * FROM dvi_states where code =?");
											$pst->execute(array($each_st));
											$row_pst = $pst->fetch(PDO::FETCH_ASSOC);
											$totalRows_pst = $pst->rowCount();
											
											$each_stname.= ' ,'.$row_pst['name'];
										}
										$each_stname = ltrim($each_stname,' ,');
										?>
                            <tr><td style="padding:6px; " width="38%"> Permit states applicable </td>
                            <td width="4%" align="center">:</td><td width="38%">&nbsp; <?php echo $each_stname; ?></td></tr>
                             			<?php } ?>
                            </table>
                        	</div>
                            
                           <center> <h4 class="text"><strong> Vehicle rental split-up : </strong><a class="fancybox badge badge-danger tooltips" title="View rent details of vehicles from all cities" data-type="iframe" href="../ADMIN/all_veh_rpt.php?mm=<?php echo $_GET['mm']; ?>&sm=<?php echo $_GET['sm'];?>&planid=<?php echo urlencode($row_orders['plan_id']); ?>"><i class="fa fa-taxi"></i>&nbsp; Details </a></h4></center>
                            
							
							<?php $transfers=0; $transfer_rent = 0; $is_arr_transfer=check_arrival_transfer($row_orders['plan_id']); 
							                    $is_dep_transfer=check_departure_transfer($row_orders['plan_id']); 
												$transfers= $transfers+$is_arr_transfer+$is_dep_transfer; ?>
                            <div class="table-responsive" style="overflow-x:scroll; width:100%; ">
								<table class="table table-th-block  table-dark" >
									<thead>
										<tr>
                                        	<th>#</th>
                                            <th>Type</th>
                                            <th>Total driven distance (kms)</th>
											<?php if($transfers) {?>
											<th> Transfer Rental (&#8377;)</th>
											
											<th> Rental for <?php $row_orders['arr_day']= $transfers; echo $row_orders['arr_day']; ?> Transfer (&#8377;)</th> 
							<?php }; ?>
                                            <th> Per day rental (&#8377;)</th>
                                            <th> Rental for <?php $row_orders['tr_days']= $row_orders['tr_days']-$transfers;  
											     echo $row_orders['tr_days'];  ?> days (&#8377;)</th>
                                            <th> Per km rental (&#8377;)</th>
                                            <th>Max allowed kms (per day)</th>
                                            <th>Max allowed kms (journey) - <?php echo $row_orders['tr_days']; ?> day(s)</th>
                                            <th>Extra kms (journey)</th>
                                            <th>Charge for extra kms (&#8377;)</th>
                                            <th> Permit charge (&#8377;)</th>
                                            <th> Total charge (&#8377;)</th>
										</tr>
									</thead>
									<tbody>
                                    <?php
									$num = 1;
								
									foreach($row_trvrent_main as $row_trvrent)
									{
										
										$vtyp1 = $conn->prepare("SELECT * FROM vehicle_pro where vehi_id =?");
										$vtyp1->execute(array($row_trvrent['vehicle_id']));
										$row_vtyp1 = $vtyp1->fetch(PDO::FETCH_ASSOC);
										
										$extr_chrg = $row_trvrent['rent_per_km'] * $row_trvrent['exceed_km'];
										?>
										<tr>
                                            <td><?php echo $num; ?></td>
											<td style="word-wrap:break-word"><?php echo $row_vtyp1['vehicle_type']; ?></td>
                                            <td><?php  echo $row_trvrent['tot_dist'];  //echo  $tt_dist_cal;?></td>
											<?php if($transfers) {?>
											<td><?php echo $row_trvrent['rent_transfer']; ?></td>
											
											<td width="30%"><?php $transfer_rent=$row_orders['arr_day'] * $row_trvrent['rent_transfer']; echo $row_orders['arr_day'].' * ' .$row_trvrent['rent_transfer'].' = '; echo $transfer_rent; ?></td>
											<?php }; ?>
											<td><?php echo $row_trvrent['rent_day']; ?></td>
                                            <td width="30%"><?php $allday_rent = $row_orders['tr_days'] * $row_trvrent['rent_day']; echo $row_orders['tr_days'].' * '.$row_trvrent['rent_day'].' = '; echo $allday_rent; ?></td>
                                            <td><?php echo $row_trvrent['rent_per_km']; ?></td>
                                            <td><?php echo $row_trvrent['max_km_day']; ?></td>
											<td><?php echo $row_trvrent['max_allwd_km']; ?></td>
                                            <td><?php echo $row_trvrent['exceed_km']; ?></td>
                                    		<td width="30%"><?php echo $row_trvrent['rent_per_km'].' * '.$row_trvrent['exceed_km'].' = '; echo $extr_chrg; ?></td>
                                            <td><?php echo $row_trvrent['permit_amt']; ?></td>
											
											<td><?php $row_trvrent['rent_amt']=$transfer_rent+$allday_rent+$extr_chrg+$row_trvrent['permit_amt']; 
											          echo $row_trvrent['rent_amt']; ?></td>
											
										</tr>
                                        <?php
									$num++; 
									}
										?>
									</tbody>
								</table>
							</div>
							
							<!-- /.row -->
                            
                            <div class="row">
                                <div class="col-sm-12">
                                <div class="the-box" style=" text-align:left; background-color:#E6ECF2;"><strong  style="font-size: x-large;">Total amount chargeable for transport: <?php echo  convert_currency_text("&#8377;",$_GET['planid'])." ".convert_currency($row_trvrent['rent_amt'] ,$_GET['planid']);  $row_trvrent['rent_amt']; ?></strong>
						        </div>
                                    
                                </div>
                        	</div>
                            
                            <?php } //not for hotel only if end?>
                            
                            <?php
								
						$spro = $conn->prepare("SELECT * FROM stay_sched where stay_id =? GROUP BY `hotel_id` ORDER BY sno ASC");
						$spro->execute(array($_GET['planid']));
						//$row_spro = mysql_fetch_assoc($spro);
						$row_spro_main=$spro->fetchAll();
						$totalRows_spro = $spro->rowCount();
							 if(substr($_GET['planid'],0,1) == 'H' || (substr($_GET['planid'],0,2)=='TH' && $totalRows_spro>0))
							{ ?>
                            <div class="row" style="margin-top:20px">
                            <div class="col-sm-12">
                            <?php 
						$scnt=1;
							?>
                            <table width="100%" class="table table-th-block table-striped">
                            <tr>
                            <th>S.No</th>
                            <th>Date</th>
                            <th>Place</th>
                            <th>Hotel</th>
                            <th>Room Category</th>
                            <th>Meal Plan</th>
                            <th>T Nights</th>
                            </tr>
							<?php
							
							foreach($row_spro_main as $row_spro)
							{
								//print_r($row_spro);
							?>
                            <tr>
                            <td><?php echo $scnt; ?></td>
                            
                            <td>
							<?php
							
$spro1 = $conn->prepare("SELECT * FROM stay_sched where stay_id =? and hotel_id=? ORDER BY sno ASC ");
$spro1->execute(array($_GET['planid'],$row_spro['hotel_id']));
$row_spro1_main = $spro1->fetchAll();
$totalRows_spro1 = $spro1->rowCount();
							$date_mult = '';
							$org_date= date('M-d',strtotime(substr($row_spro['sty_date'],'0','10')));
							if($totalRows_spro1>1)
							{
								
								foreach($row_spro1_main as $row_spro1)
								{
								 //print_r($row_spro1);
								//$totalRows_spro2=$totalRows_spro1-1;
									$org_date= date('M-d',strtotime(substr($row_spro1['sty_date'],'0','10')));
									//date_add($date,date_interval_create_from_date_string($totalRows_spro2." days"));
									$date_mult.=','.$org_date;
									
								}
								
								$date_mult = ltrim($date_mult,',');
								$date_mult1 = explode(',',$date_mult);
								$next_row = 0; $date_mult2 = count($date_mult1);
								foreach($date_mult1 as $date_dis)
								{
									if ($next_row % 2 == 0)
									{
										echo "<br>";
										if($date_mult2 == $next_row+1)
										{
											echo $date_dis;
										}
										else
										{
											echo $date_dis.', ';
										}
									}
									else
									{
										if($date_mult2 == $next_row+1)
										{
											echo $date_dis;
										}
										else
										{
											echo $date_dis.', ';
										}
									}
									$next_row=$next_row + 1;
									
								}
							}
							else
							{
								echo $org_date;	
							}
					 		?>
                            </td>
                            
                            <td>
							<?php
							
							$cityy = $conn->prepare("SELECT * FROM dvi_cities where id =?");
							$cityy->execute(array($row_spro['sty_city']));
							$row_cityy = $cityy->fetch(PDO::FETCH_ASSOC);
							$totalRows_cityy = $cityy->rowCount();
							
							echo  $row_cityy['name'];
							?>
                            </td>
                            
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
							//print_r($rrom1);
							$rrom1=array_values($rrom1);
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
									echo $rrom1[$tt]." - ".$rrom2[$rrom1[$tt]].",<br>";
								}
								else
								{
									echo $rrom1[$tt]." - ".$rrom2[$rrom1[$tt]]; 
								}
							}
							?>
                             </td>
                             
                             <td><?php
							 //food items
							 if($row_spro['sty_food']=='dinner_rate')
							 {
								 echo "Dinner"; 
							 }
							 else if($row_spro['sty_food']=='lunch_rate')
							 {
								 echo "Lunch"; 
							 }
							 else if($row_spro['sty_food']=='both_food')
							 {
								 echo "Lunch & Dinner"; 
							 }
							 else
							 {
								 echo "Breakfast"; 
							 }
							 ?>
                             </td>
                             
                             <td><center><?php echo $totalRows_spro1; ?></center>
                             </td>
                             </tr>
                             
                             <?php 
							/*if($totalRows_spro1>1)
							{
								for($rt=0;$rt<$totalRows_spro1-1;$rt++)
								{
									$row_spro = mysql_fetch_assoc($spro);	
								}
							}*/
									
							$scnt++; 
							}  
							?>
                            </table>
                            
                            </div>
                            
                            <!-- hotel wise rent details-->
                            
                            <div class="col-sm-12" align="center" style="margin-top:20px;">
                            <?php 
							
							$sspro1 = $conn->prepare("SELECT * FROM stay_sched where stay_id =? ORDER BY sno ASC ");
							$sspro1->execute(array($_GET['planid']));
							//$row_sspro1 = mysql_fetch_assoc($sspro1);
							$row_sspro1_main=$sspro1->fetchAll();
							$totalRows_sspro1 = $sspro1->rowCount();
							
							if($totalRows_sspro1>0)
							{
								$onlyext_bed_rate=0;
								$wholeday_stay_amt=0;
								foreach($row_sspro1_main as $row_sspro1)
								{
									$this_hotel_amt=0;
									
									
									$cityy1 = $conn->prepare("SELECT * FROM dvi_cities where id =?");
									$cityy1->execute(array($row_sspro1['sty_city']));
									$row_cityy1 = $cityy1->fetch(PDO::FETCH_ASSOC);
									$totalRows_cityy1 =$cityy1->rowCount();
									
									
									$hotell = $conn->prepare("SELECT * FROM hotel_pro where hotel_id =?");
									$hotell->execute(array($row_sspro1['hotel_id']));
									$row_hotell = $hotell->fetch(PDO::FETCH_ASSOC);
									$totalRows_hotell = $hotell->rowCount();
			   						?>
									
								<table width="100%" border="solid 1px" style="margin-top:15px;">
                                	<tr  style="background-color:#E4E4E4;">
                                    	<td colspan="3" style="padding:2px;font-size:11px">Date:  <?php echo $row_sspro1['sty_date']; ?> </td>
                                        <td colspan="3" style="padding:2px;font-size:11px">City:  <?php echo $row_cityy1['name']; ?></td>
                                        <td colspan="3" style="padding:2px;font-size:11px">Hotel:  <?php echo $row_hotell['hotel_name']; ?>
                                        </td>
									</tr>
									
                                    <tr>
                                    <td style="padding:2px;font-size:11px">&nbsp;Room Categoryss/Rate</td>
                                    <td style="padding:2px;font-size:11px">&nbsp;With Extra Bed</td>
                                    <td style="padding:2px;font-size:11px">&nbsp;Without Extra Bed</td>
                                    <td style="padding:2px;font-size:11px">&nbsp;Candle Light</td>
                                    <td style="padding:2px;font-size:11px">&nbsp;Flower Bed</td>
                                    <td style="padding:2px;font-size:11px">&nbsp;Fruit Basket</td>
                                    <td style="padding:2px;font-size:11px">&nbsp;Special Cake</td>
                                    <td style="padding:2px;font-size:11px">&nbsp;Lunch</td>
                                    <td style="padding:2px;font-size:11px">&nbsp;Dinner</td>
                                    </tr>
									
									
                                    <tr>
					               <td style="padding:2px;font-size:11px">&nbsp; <?php 
								   
								  $rrom_rents=explode('-',$row_sspro1['sty_indu_rent']);
								  //print_r($row_sspro1);
								  $rrom_amounts=explode(',',$rrom_rents[0]);
								  $rrom_amounts1=array_unique($rrom_amounts);
								 // print_r($rrom_amounts1);
								  	$rrom_amounts1=array_values($rrom_amounts1);
									//print_r($rrom_amounts1);
									$rrom_amounts2=array_count_values($rrom_amounts);
								 // print_r($rrom_amounts2);
								  
								    $rrom=explode(',',$row_sspro1['sty_room_name']);
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
													echo $rrom1[$tt]." - ";
													if(isset($rrom_amounts1[$tt])){
														 echo $rrom_amounts1[$tt]; 
														 }else{
															  echo $rrom_amounts1[$tt-1]; 
															  }echo ",<br>"; 
												}else
												{
													echo $rrom1[$tt]." - ";
													if(isset($rrom_amounts1[$tt])){
														 echo $rrom_amounts1[$tt]; 
														 }else{
															  echo $rrom_amounts1[$tt-1]; 
															  } 
												}
										}
									}
								    ?>
                                    </td>
                                    <td style="padding:2px;font-size:11px"> <?php //&nbsp;Child With Bed
									$bed_det = $row_sspro1['sty_child_bed'];
								   $exp_chldbed = explode(',',$bed_det);
								   
								   $arr_indu_rates=explode('-',$row_sspro1['sty_indu_rent']);
								   $stornam =0;
								   
								   foreach($exp_chldbed as $withbd)
								   {
									   if($withbd == '0')
									   {
										   $stornam=1;
									   }
								   }
								   if($stornam==1)
								   {
								   		$wibd=explode(',',$arr_indu_rates[1]);
										echo '&nbsp;&nbsp; Rs.'.$wibd[1];
								   }else{
									   echo '&nbsp;&nbsp;&nbsp;-';	
								   }
								    ?>
                                    </td>
                                    <td style="padding:2px;font-size:11px">
                                    <?php //&nbsp;Child Without Bed
									 $stornam =0;
								   
								   foreach($exp_chldbed as $withoutbd)
								   {
									   if($withoutbd == '1')
									   {
										   $stornam=2;
									   }
								   }
								   if($stornam==2)
								   {
								   		$wioutbd=explode(',',$arr_indu_rates[1]);
										echo '&nbsp;&nbsp; Rs.'.$wioutbd[2];
								   }else{
									   echo '&nbsp;&nbsp;&nbsp;-';	
								   }
								    
									?>
                                    </td>
                                    <td style="padding:2px;font-size:11px">
                                    <?php //candle light
									
									$spl_indu_rate=explode(',',$arr_indu_rates[3]);
									//print_r($spl_indu_rate);
									//echo $row_sspro1['sty_extra'];
									if($row_sspro1['sty_extra'] != '')
									{	
									$fn_check='n';
									//$fn_cl=0;
										$spl_amni=explode(',',$row_sspro1['sty_extra']);
										//print_r($spl_amni);
										for($cl=0;$cl<count($spl_amni);$cl++)
										{
											$sa=$spl_amni[$cl];
											if($sa=='candle_light')
											{
												$fn_cl=$cl;
												$fn_check='y';
											}
										}
										if($fn_check != 'n' && isset($fn_cl))
										{
											echo "&nbsp;Rs.".$spl_indu_rate[$fn_cl+1];
										}else{
											echo '&nbsp;&nbsp;&nbsp;-';	
										}
										
									}else
									{
									echo '&nbsp;&nbsp;&nbsp;-';	
									}
									?>
                                    </td>
                                    <td style="padding:2px;font-size:11px"><?php //flower_bed
									if($row_sspro1['sty_extra'] != '')
									{	
									//$fn_cl=0;
									$fn_check='n';
										$spl_amni=explode(',',$row_sspro1['sty_extra']);
										for($cl=0;$cl<count($spl_amni);$cl++)
										{
											$sa=$spl_amni[$cl];
											if($sa=='flower_bed')
											{
												$fn_cl=$cl;
												$fn_check='y';
											}
										}
										
										if($fn_check != 'n' && isset($fn_cl))
										{
										echo "&nbsp;Rs.".$spl_indu_rate[$fn_cl+1];
										}else{
										echo '&nbsp;&nbsp;&nbsp;-';		
										}
										
									}else
									{
									echo '&nbsp;&nbsp;&nbsp;-';	
									}
									
									?>
                                    </td>
                                    <td style="padding:2px;font-size:11px">
                                   <?php //Fruit Basket
									if($row_sspro1['sty_extra'] != '')
									{	
									//$fn_cl=0;
									$fn_check='n';
									
										$spl_amni=explode(',',$row_sspro1['sty_extra']);
										for($cl=0;$cl<count($spl_amni);$cl++)
										{
											$sa=$spl_amni[$cl];
											if($sa=='fruit_basket')
											{
												$fn_cl=$cl;
												$fn_check='y';
											}
										}
										if($fn_check != 'n' && isset($fn_cl))
										{
										echo "&nbsp;Rs.".$spl_indu_rate[$fn_cl+1];
										}else{
										echo '&nbsp;&nbsp;&nbsp;-';		
										}
									}else
									{
									echo '&nbsp;&nbsp;&nbsp;-';	
									}
									?>
                                    </td>
                                    <td style="padding:2px;font-size:11px">
                                     <?php //Special Cake
									if($row_sspro1['sty_extra'] != '')
									{	
										$fn_check='n';
										//$fn_cl=0;
										$spl_amni=explode(',',$row_sspro1['sty_extra']);
										for($cl=0;$cl<count($spl_amni);$cl++)
										{
											$sa=$spl_amni[$cl];
											if($sa=='cake_rate')
											{
												$fn_cl=$cl;
												$fn_check='y';
											}
										}
										if($fn_check != 'n' && isset($fn_cl))
										{
										echo "&nbsp;Rs.".$spl_indu_rate[$fn_cl+1];
										}else{
										echo '&nbsp;&nbsp;&nbsp;-';		
										}
									}else
									{
									echo '&nbsp;&nbsp;&nbsp;-';	
									}
									?>
                                    </td>
                                    <td style="padding:2px;font-size:11px">
                                    <?php  //for lunch 
									$food_indu_rate=$arr_indu_rates[2];
									if($row_sspro1['sty_food']=='lunch_rate')
									{
										echo ' Rs.'.$food_indu_rate;
									}else if($row_sspro1['sty_food']=='both_food')
									{
										$lun=explode(',',$food_indu_rate);
										echo ' Rs.'.$lun[1];
									}else{
										echo '&nbsp;&nbsp;&nbsp;-';	
									}
									?>
                                    </td>
                                    <td style="padding:2px;font-size:11px">
                                    <?php //for dinner
									if($row_sspro1['sty_food']=='dinner_rate')
									{
										echo ' Rs.'.$food_indu_rate;
									}else if($row_sspro1['sty_food']=='both_food')
									{
										$lun=explode(',',$food_indu_rate);
										echo ' Rs.'.$lun[2];
									}else
									{
										echo '&nbsp;&nbsp;&nbsp;-';	
									}
									?>
                                    </td>
               </tr>
                  <?php //Total roomsrate
				 $total_nett_cost_thishotel=0;
				 
				 $array_indu_rates=explode('-',$row_sspro1['sty_indu_rent']);
				 $roomtyps = $row_sspro1['sty_room_name'];
								   $exp_roomtyp = explode(',',$roomtyps);
								  $uniq_rooms = array_unique($exp_roomtyp);
								$am='';
								   $uniq_rooms1 = array_values($uniq_rooms);
								//   print_r($uniq_rooms1);
								   $rrom2=array_count_values($exp_roomtyp);
								  // print_r($rrom2);
								  // print_r($exp_roomtyp);
								   $nnet_cost_rooms=0;
								   $ii=0;
								   foreach($uniq_rooms1 as $rcats)
								   {
										for($ki=0;$ki<count($exp_roomtyp);$ki++)
										{
											if($exp_roomtyp[$ki]==$rcats)
											{
												$ki1=$ki;
											}
										}
										$rate_room=explode(',',$array_indu_rates[0]);
								 $am= $rcats.' = '.'Rs.'.$rate_room[$ki1]."( <i class='fa fa-times'></i>". $rrom2[$rcats].')<br>';
										$cham=$rate_room[$ki1];
										$nnet_cost_rooms=$nnet_cost_rooms+($rate_room[$ki1]* $rrom2[$rcats]);
										$ii++;
								   }
								   //echo "<br>( For -".$no_of_roomss. "rooms)"; 
								   if($cham!="0.00"){
								    ?>
                 
                 <tr><td colspan="2" style="padding:2px;font-size:11px">Total rooms</td><td style="padding:2px;font-size:11px">Nett Cost</td><td colspan="2" style="padding:2px;font-size:11px">With Extra Bed</td><td style="padding:2px;font-size:11px">Nett Cost</td><td style="padding:2px;font-size:11px" colspan="2">Without Exra Bed</td><td style="padding:2px;font-size:11px">Nett Cost</td></tr>
                 <tr><td colspan="2" style="padding:2px;font-size:11px">
                <?php echo $am;?>
                 </td><td style="padding:2px;font-size:11px"><?php echo "&nbsp;Rs. ".$nnet_cost_rooms;
				 $total_nett_cost_thishotel=$total_nett_cost_thishotel+$nnet_cost_rooms;?></td>
                 <td colspan="2" style="padding:2px;font-size:11px">
                 <?php //&nbsp;With Extra Bed rate
									$bed_det = $row_sspro1['sty_child_bed'];
								   $exp_chldbed = explode(',',$bed_det);
								   $stornam =0;
								   $nett_cost_withextra=0;
								   foreach($exp_chldbed as $withbd)
								   {
									   if($withbd == '0')
									   {
										   $stornam++;
									   }
								   }
								   if($stornam>0)
								   {
								   		$wibd=explode(',',$array_indu_rates[1]);
										echo '&nbsp;&nbsp; Rs.'.$wibd[1]."( <i class='fa fa-times'></i> ".$stornam.")";
										$nett_cost_withextra=$wibd[1]*$stornam;
										
								   }else{
									   echo '&nbsp;&nbsp;&nbsp;-';	
									   $nett_cost_withextra=0;
								   }
								    ?>
                 </td><td style="padding:2px;font-size:11px"><?php echo " &nbsp;Rs. ".$nett_cost_withextra;
				  $total_nett_cost_thishotel=$total_nett_cost_thishotel+$nett_cost_withextra;
				  $onlyext_bed_rate= $onlyext_bed_rate+$nett_cost_withextra;
				  ?></td>
                  <td style="padding:2px;font-size:11px" colspan="2">
                    <?php //&nbsp;Without Exra Bed rate
									 $stornam =0;
								   $nett_cost_withoutextra=0;
								   foreach($exp_chldbed as $withoutbd)
								   {
									   if($withoutbd == '1')
									   {
										   $stornam++;
									   }
								   }
								   if($stornam>0)
								   {
								   		$wioutbd=explode(',',$array_indu_rates[1]);
										echo '&nbsp;&nbsp; Rs.'.$wioutbd[2]."( <i class='fa fa-times'></i> ".$stornam.")";
										$nett_cost_withoutextra=$wioutbd[2]*$stornam;
								   }else{
									   echo '&nbsp;&nbsp;&nbsp;-';
									   $nett_cost_withoutextra=0;	
								   }
									?>
                  
                  </td><td style="padding:2px;font-size:11px"><?php echo " &nbsp;Rs. ".$nett_cost_withoutextra;
				 $total_nett_cost_thishotel=$total_nett_cost_thishotel+$nett_cost_withoutextra; ?></td></tr>
                 <?php } ?>
                 <tr><td colspan="3"  style="padding:2px;font-size:11px">Lunch</td><td colspan="3"  style="padding:2px;font-size:11px">Dinner</td><td colspan="3"  style="padding:2px;font-size:11px">Nett Cost</td></tr>
                 
                 <tr><td colspan="3"  style="padding:2px;font-size:11px">
                  <?php  //for lunch Lunchrt
				  $lunch=$dinner=0;
									$food_indu_rate=$array_indu_rates[2];
									 $nett_cost_food=0;
									if($row_sspro1['sty_food']=='lunch_rate')
									{
										echo ' Rs.'.$food_indu_rate."( <i class='fa fa-times'></i> ".$adl_ch152.")";
										$nett_cost_food=$nett_cost_food+($food_indu_rate*$adl_ch152);
										
										echo "&nbsp; = ".$nett_cost_food;
										$lunch=$nett_cost_food;
										
									}else if($row_sspro1['sty_food']=='both_food')
									{
										$lun=explode(',',$food_indu_rate);
										echo ' Rs.'.$lun[1]."( <i class='fa fa-times'></i> ".$adl_ch152.")";
										$nett_cost_food=$nett_cost_food+($lun[1]*$adl_ch152);
										
										echo "&nbsp; = ".$nett_cost_food;
										$lunch=$nett_cost_food;
									}else{
										echo '&nbsp;&nbsp;&nbsp;-';	
										$lunch=0;
									}
									
									?>
                 </td><td colspan="3"  style="padding:2px;font-size:11px">
                  <?php //for dinner Dinnerrt
				   $nett_cost_food1=0;
									if($row_sspro1['sty_food']=='dinner_rate')
									{
										echo ' Rs.'.$food_indu_rate."( <i class='fa fa-times'></i> ".$adl_ch152.")";
										$nett_cost_food1=$nett_cost_food1+($food_indu_rate*$adl_ch152);
										
										echo "&nbsp; = ".$nett_cost_food1;
										$dinner=$nett_cost_food1;
									}else if($row_sspro1['sty_food']=='both_food')
									{
										$lun=explode(',',$food_indu_rate);
										echo ' Rs.'.$lun[2]."( <i class='fa fa-times'></i> ".$adl_ch152.")";
										$nett_cost_food1=$nett_cost_food1+($lun[2]*$adl_ch152);
										
										echo "&nbsp; = ".$nett_cost_food1;
										$dinner=$nett_cost_food1;
									}else
									{
										echo '&nbsp;&nbsp;&nbsp;-';	
										$dinner=0;
									}
									
									?>
                 </td><td colspan="3"  style="padding:2px;font-size:11px"><?php 
				 $tot_ffd=$lunch+$dinner;
				 echo "Rs. ".$tot_ffd;
				  $total_nett_cost_thishotel=$total_nett_cost_thishotel+$tot_ffd; 
				 ?></td></tr>
                 <tr><td colspan="2" style="padding:2px;font-size:11px"> Special Cake</td><td colspan="2" style="padding:2px;font-size:11px">Fruit Basket </td><td colspan="2" style="padding:2px;font-size:11px"> Flower Bed</td><td colspan="2" style="padding:2px;font-size:11px"> Candle Light</td><td style="padding:2px;font-size:11px">Nett Cost</td></tr>
                 
                 <tr><td colspan="2" style="padding:2px;font-size:11px">
                  <?php //Special Cake
				  $nett_cost_spl_amny=0;
				  $spl_indu_rate=explode(',',$array_indu_rates[3]);
									if($row_sspro1['sty_extra'] != '')
									{	
									$ffn_ch='n';
									//$fn_cl=0;
										$spl_amni=explode(',',$row_sspro1['sty_extra']);
										for($cl=0;$cl<count($spl_amni);$cl++)
										{
											$sa=$spl_amni[$cl];
											if($sa=='cake_rate')
											{
												$fn_cl=$cl;
												$ffn_ch='y';
											}
										}
										if($ffn_ch != 'n' && isset($fn_cl))
										{
										echo $spl_indu_rate[$fn_cl+1];
										$nett_cost_spl_amny=$nett_cost_spl_amny+$spl_indu_rate[$fn_cl+1];
										$total_nett_cost_thishotel=$total_nett_cost_thishotel+$spl_indu_rate[$fn_cl+1]; 
										}else{
										echo '&nbsp;&nbsp;&nbsp;-';		
										}
									}else
									{
									echo '&nbsp;&nbsp;&nbsp;-';	
									}
									?>
                 </td><td colspan="2" style="padding:2px;font-size:11px">
                    <?php // Flower Bedrt  Flower Bedrt
									
								 $spl_indu_rate=explode(',',$array_indu_rates[3]);
									if($row_sspro1['sty_extra'] != '')
									{	//$fn_cl=0;
									$ffc_ch='n';
										$spl_amni=explode(',',$row_sspro1['sty_extra']);
										for($cl=0;$cl<count($spl_amni);$cl++)
										{
											$sa=$spl_amni[$cl];
											if($sa=='fruit_basket')
											{
												$fn_cl=$cl;
												$ffc_ch='y';
											}
										}
										if($ffc_ch != 'n' && isset($fn_cl))
										{
											echo "Rs.".$spl_indu_rate[$fn_cl+1];
											$nett_cost_spl_amny=$nett_cost_spl_amny+$spl_indu_rate[$fn_cl+1];
											 $total_nett_cost_thishotel=$total_nett_cost_thishotel+$spl_indu_rate[$fn_cl+1]; 
											 
										}else{
											echo '&nbsp;&nbsp;&nbsp;-';	
										}
										
									}else
									{
									echo '&nbsp;&nbsp;&nbsp;-';	
									}
									?>
                 
                 </td><td colspan="2" style="padding:2px;font-size:11px"> 
                  <?php // flower_bed
									
									 $spl_indu_rate=explode(',',$array_indu_rates[3]);
									if($row_sspro1['sty_extra'] != '')
									{	
									$ffc_ch='n';
									//$fn_cl=0;
										$spl_amni=explode(',',$row_sspro1['sty_extra']);
										for($cl=0;$cl<count($spl_amni);$cl++)
										{
											$sa=$spl_amni[$cl];
											if($sa=='flower_bed')
											{
												$fn_cl=$cl;
												$ffc_ch='y';
											}
										}
										if($ffc_ch != 'n' &&  isset($fn_cl))
										{
											echo "Rs.".$spl_indu_rate[$fn_cl+1];
											$nett_cost_spl_amny=$nett_cost_spl_amny+$spl_indu_rate[$fn_cl+1];
											 $total_nett_cost_thishotel=$total_nett_cost_thishotel+$spl_indu_rate[$fn_cl+1]; 
											 
										}else{
											echo '&nbsp;&nbsp;&nbsp;-';	
										}
										
									}else
									{
									echo '&nbsp;&nbsp;&nbsp;-';	
									}
									?></td><td colspan="2" style="padding:2px;font-size:11px"> 
                  <?php //candle light Candle Lightrt
									
									 $spl_indu_rate=explode(',',$array_indu_rates[3]);
									if($row_sspro1['sty_extra'] != '')
									{	
										$ffc_ch='n';
										//$fn_cl=0;
										$spl_amni=explode(',',$row_sspro1['sty_extra']);
										for($cl=0;$cl<count($spl_amni);$cl++)
										{
											$sa=$spl_amni[$cl];
											if($sa=='candle_light')
											{
												$fn_cl=$cl;
												$ffc_ch='y';
											}
										}
										if($ffc_ch != 'n' && isset($fn_cl))
										{
											echo "Rs.".$spl_indu_rate[$fn_cl+1];
											$nett_cost_spl_amny=$nett_cost_spl_amny+$spl_indu_rate[$fn_cl+1];
											 $total_nett_cost_thishotel=$total_nett_cost_thishotel+$spl_indu_rate[$fn_cl+1]; 
											 
										}else{
											echo '&nbsp;&nbsp;&nbsp;-';	
										}
										
									}else
									{
									echo '&nbsp;&nbsp;&nbsp;-';	
									}
									?>
                 </td><td style="padding:2px;font-size:11px"><?php echo "&nbsp;&nbsp;Rs. ".$nett_cost_spl_amny;?></td></tr>
               
             	<tr><td colspan="9"  style="padding:2px;font-size:11px  background-color: antiquewhite;"><center>Amount For This Hotel : Rs. <?php echo $total_nett_cost_thishotel."&nbsp;&nbsp;/- Only";
				$wholeday_stay_amt=$wholeday_stay_amt+$total_nett_cost_thishotel; ?></center></td></tr>
               
               </table>
               <?php }//while end?>
               <br />
               
		<div class="the-box" style=" text-align:left; background-color:#E6ECF2;"><strong  style="font-size: x-large;">Total amount chargeable for hotel(s) : <?php echo  convert_currency_text("Rs",$_GET['planid'])." ".convert_currency($wholeday_stay_amt,$_GET['planid'])." &nbsp;/- "; 
		$grand_ttotal=$grand_ttotal+$wholeday_stay_amt;?></strong>
        <small><?php if($onlyext_bed_rate>0){ echo "( Incl. Extra Bed Rate : Rs. ".$onlyext_bed_rate." )"; }?></small>
        </div>	   
			   
<?php } ?>
                                </div>
                                
                            
                                
                            </div>
                            <?php }else if(substr($_GET['planid'],0,2)!='T#'){
							 echo "This itinerary was cancelled, hence hotel details unavailable.. ";	
							}
							?>
                            
                            <div class="row">
                                  <!-- Additional cost - start -->
               
    <?php
		$tmst_bef=$conn->prepare("select * from travel_sched where travel_id=? and trim(addi_cost_for)!=''");
		$tmst_bef->execute(array($_GET['planid']));
		//$row_tmst_bef = mysql_fetch_assoc($tmst_bef);
		$row_tmst_bef=$tmst_bef->fetch(PDO::FETCH_ASSOC);
		$tot_tmst_bef=$tmst_bef->rowCount();
		if($tot_tmst_bef>0)
		{	
		
			$tmst_addi=$conn->prepare("select * from travel_sched where travel_id=?");
			$tmst_addi->execute(array($_GET['planid']));
			//$row_tmst_addi= mysql_fetch_assoc($tmst_addi);
			$row_tmst_addi_main=$tmst_addi->fetchAll();
	?>
    <div class="row">
    <div class="col-sm-12">
    	<table width="95%" style="padding:2px;font-size:11px" border="1px" align="center">
        	<tr><td colspan="4" align="center" style=" color:rgb(180, 118, 72); padding:2px;font-size:11px"> Details of selected special Add-ons</td>
            </tr>
        
        	<tr style=" background-color:rgb(255, 233, 206); color:rgb(180, 118, 72)">
            	<th style="padding:2px;font-size:11px">&nbsp; Date </th>
                <th>&nbsp; Selected Cities </th>
                <th>&nbsp; Selected Add-ons </th>
                <th>&nbsp; Amount(Rs.) </th>
            </tr>
            <?php 
			$tot_addon_amt=0;
			foreach($row_tmst_addi_main as $row_tmst_addi)
			{ ?>
				<tr style="padding:2px;font-size:11px">
                	<td style="padding:2px;font-size:11px"><?php echo date('d-M-Y',strtotime($row_tmst_addi['tr_date'])); ?></td>
                	<td style="padding:2px;font-size:11px"><?php echo $row_tmst_addi['tr_from_cityid'].' <i class="fa fa-arrows-h"></i> '. $row_tmst_addi['tr_to_cityid']; ?></td>
                	<td style="padding:2px;font-size:11px"><?php 
					if(trim($row_tmst_addi['addi_cost_for'])=='')
					{
						echo "No Add-ons Added";
					}else{
						 $addi_name_arr=explode('/',$row_tmst_addi['addi_cost_for']);
						 foreach($addi_name_arr as $anam)
						 {
							echo "<i class='fa fa-check'></i> ".$anam."<br>"; 
						 }
					}?></td>
                	<td style="padding:6px;"><?php 
					if(trim($row_tmst_addi['addi_amount'])=='')
					{
						echo "Rs. 0";
					}else{
						$addi_amt_ary=explode(',',$row_tmst_addi['addi_amount']);
						foreach($addi_amt_ary as $adamt)
						{
						  echo "Rs. ".$adamt.'<br>';	
						  $tot_addon_amt=$tot_addon_amt+$adamt;
						}
					}
					?></td>
                </tr>
			<?php }
			?>
        </table>
    </div>
    
    </div>
    <div class="col-sm-12" style="margin-top:10px;">
    <div class="the-box" style=" text-align:left; background-color:#E6ECF2;" >
    	&nbsp;&nbsp;<strong style="font-size:x-large"> Total Add-ons Cost : Rs. <?php echo $tot_addon_amt.' /-'; ?></strong>
    </div>
    </div>
    
    <?php } //if end?>
               
               <!-- Additional cost - end -->

                            </div>
                            
                            <div class="the-box" style=" text-align:left; background-color:#E6ECF2;">
               <table width="100%">
               <tr><td style="padding:6px;"><strong  style="font-size: x-large;">Grand Total Of This Plan  </strong></td><td style="padding:6px;">:</td><td style="padding:6px;"><strong  style="font-size: x-large;"><?php echo convert_currency_text("<i class='fa fa-inr'></i>",$_GET['planid'])." ".convert_currency($row_orders['grand_tot'],$_GET['planid']); ?></strong></td></tr>
               <tr><td style="padding:6px;"><strong  style="font-size: x-large;">Selling cost to agent(<?php echo $row_agnt['agent_fname'].' '.$row_agnt['agent_lname']; ?>[Selling % = <?php echo $row_orders['agnt_adm_perc']; ?>])</strong></td><td style="padding:6px;">:</td><td style="padding:6px;"><strong  style="font-size: x-large;"><?php
			   $prf=$row_orders['agnt_grand_tot']-($row_orders['grand_tot']+($row_orders['grand_tot']*($row_orders['agent_perc']/100)));
			   echo convert_currency_text("<i class='fa fa-inr'></i>",$_GET['planid'])." ".convert_currency($adm_grand_amt = ($row_orders['grand_tot']+$prf),$_GET['planid']); ?></strong></td></strong></tr>
               <tr><td style="padding:6px;"><strong  style="font-size: x-large;">Profit amount to DVI </strong></td><td style="padding:6px;">:</td><td style="padding:6px;"><strong  style="font-size: x-large;"><?php echo convert_currency_text("<i class='fa fa-inr'></i>",$_GET['planid'])." ".convert_currency(($prf),$_GET['planid']) ?></strong></td></tr>
               <?php if($row_orders['agent_id']!='-' && $row_orders['agent_id']!='')
			   { 
			     $agentprf=($row_orders['grand_tot']*($row_orders['agent_perc']/100));
			   ?>
				   <tr><td style="padding:6px;"><strong  style="font-size: x-large;">Profit amount to agent(<?php echo $row_orders['agent_perc'].'%'; ?>)</strong></td><td style="padding:6px;">:</td><td style="padding:6px;"><strong  style="font-size: x-large;"><?php echo convert_currency_text("<i class='fa fa-inr'></i>",$_GET['planid'])." " .convert_currency(($agentprf),$_GET['planid']) ?></strong></td></tr>
			   <?php }
			   ?>
                <tr><td style="padding:6px;"><strong  style="font-size: x-large;">This Itinerary Cost</strong></td><td style="padding:6px;">:</td><td style="padding:6px;"><strong  style="font-size: x-large;"><?php echo convert_currency_text("<i class='fa fa-inr'></i>",$_GET['planid'])." ".convert_currency(($row_orders['agnt_grand_tot']),$_GET['planid']) ?></strong></td></tr>
               </table>
               </div>
                <?php  } //main for loop ?>        
						</div><!-- /.the-box no-border no-margin-->
					</div><!-- /.the-box -->
					<!-- END INVOICE -->
                   
		
        <script src="../core/assets/js/jquery.min.js"></script>
        <script src="../core/assets/plugins/fancybox/lib/jquery-1.8.2.min.js"></script>
        <link href="../core/assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet">
		<script src="../core/assets/plugins/fancybox/source/jquery.fancybox.js"></script>
        <script src="../core/assets/plugins/fancybox/source/jquery.fancybox.pack.js"></script>
        
        <link rel="stylesheet" type="text/css" href="../core/assets/plugins/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
		<script type="text/javascript" src="../core/assets/plugins/fancybox/source//helpers/jquery.fancybox-thumbs.js?v=1.0.7">
    </script>
     <script type="text/javascript" src="../core/assets/plugins/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.5"></script>
     
        <script type="text/javascript">
		$(document).ready(function() {
		$('.fancybox').fancybox({
				
				fitToView	: true,
				width		: '90%',
				height		: 'auto',  
				autoSize	: false,
				closeClick	: false,
				padding   :  1,
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
		<script src="../core/assets/plugins/nicescroll/jquery.nicescroll.js"></script>
		<script src="../core/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		<script src="../core/assets/plugins/backstretch/jquery.backstretch.min.js"></script>
        
        
		<!-- PLUGINS -->
        <script type="text/javascript" src="../core/assets/plugins/Tags/jquery.tagsinput.js"></script>
        <script src="../core/assets/plugins/chosen/chosen.jquery.min.js"></script>
		<script src="../core/assets/plugins/spinner/js/jquery.dpNumberPicker-1.0.1-min.js"></script>
        
		<script src="core/assets/js/apps.js"></script>
		<script src="core/assets/js/demo-panel-1.js"></script>
        <script src="core/assets/jQuery1/form-validator/spin.js"></script>
        <script src="core/assets/js/moment.js"></script>
		<script>
		$(document).ready(function(e) {
			$('.datatable-example').dataTable();
        });
		
		$('.tooltips').tooltip();

</script>
		