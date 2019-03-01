<?php
session_start();
require_once('../Connections/divdb.php');

$orders = $conn->prepare("SELECT * FROM travel_master where plan_id =?");
$orders ->execute(array($_GET['planid']));
$row_orders = $orders->fetch(PDO::FETCH_ASSOC);
$totalRows_orders = $orders->rowCount();

$ttotl_pax=$row_orders['pax_cnt']-$row_orders['pax_child']; 

$adl_ch152=$row_orders['pax_adults']+$row_orders['pax_512child'];
$no_of_roomss=$row_orders['stay_rooms'];
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
                    <div class="col-sm-12">
					<div class="the-box full invoice">
						<div class="the-box no-border">
                        <div class="row">
                        	<div class="col-sm-12">
                                <h3 class="text">Admin - Detailed Transport Report </h3>
                                <h4 class="text-muted text"><?php echo $_GET['planid']; ?></h4>
                            </div>
                        </div>
                            <?php
							
							$routes = $conn->prepare("SELECT * FROM travel_sched where travel_id =? ORDER BY sno ASC");
							$routes->execute(array($_GET['planid']));
							$row_routes = $routes->fetch(PDO::FETCH_ASSOC);
							$totalRows_routes = $routes->rowCount();

							?>
                            <!--<h3 class="text"><strong> Journey details </strong></h3>-->
							<?php /*?><div class="table-responsive">
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
										do
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
											 <td><?php echo $row_routes['tr_dist_ss']; ?></td>
                                             <td><?php echo $row_routes['tr_time']; ?></td>
										</tr>
										<?php
										$cnt++;
										}
										while($row_routes = mysql_fetch_assoc($routes));
										?>
									</tbody>
								</table>
							</div><?php */?><!-- /.table-responsive -->
							
							<!-- /.row -->
							<?php
							if(substr($_GET['planid'],0,1) == 'T' || substr($_GET['planid'],0,2) == 'TH')
							{
							
							$trvrent = $conn->prepare("SELECT * FROM dvi_trans_rpt where travel_id =? GROUP BY city_id");
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
                            <div class="row">
                                <div class="col-sm-12">
                                    <h3 class="text"><strong> Journey info: </strong></h3>
                                    <p style="background-color:#F6F8F9"> Cities available with vehicles: <span class="badge badge-primary"><?php echo $totalRows_trvrent; ?> </span></p>
                                    <p style="background-color:#F6F8F9"> Type of vehicle taken: <span class="label label-primary"><?php echo $vehnames; ?></span></p>
                                    <?php /*?><p style="background-color:#F6F8F9"> Vehicle origin city: <span class="label label-primary"><?php echo $row_vcity['name']; ?></span></p><?php */?>
                                    <p style="background-color:#F6F8F9"> Onward distance (kms): <span class="badge badge-primary"><?php echo $row_orders['tot_tr_dist'] - 80; ?></span></p>
                                    <p style="background-color:#F6F8F9"> Airport/Railstation pick-up/drop distance (kms): <span class="badge badge-primary">80</span></p>
                                    <p style="background-color:#F6F8F9"> Total distance (including pick-up/drop) (kms): <span class="badge badge-primary"><?php echo $row_orders['tot_tr_dist']; ?></span></p>
                                    <p style="background-color:#F6F8F9"> Return distance (kms): <span class="badge badge-primary"><?php echo $row_orders['tr_return_dist']; ?></span></p>
                                    <p style="background-color:#F6F8F9"> Travel days: <span class="badge badge-primary"><?php echo $row_orders['tr_days']; ?></span></p>
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
                                        <p style="background-color:#F6F8F9"> Permit states applicable: <span class="badge badge-primary"><?php
							
										
							 echo $each_stname; 
						?></span></p>
                                        <?php
									}
									?>
                                </div>
                        	</div>
                            
                            <h3 class="text"><strong> Vehicle rental split-up (City-wise): </strong></h3>
                                                        

                            <?php
							$colrnum=0; $veh_citycost = 0;
							foreach($row_trvrent_main as $row_trvrent)
							{
								$num = 1;
								
								$citywise = $conn->prepare("SELECT * FROM dvi_trans_rpt where travel_id =? and city_id =?");
								$citywise->execute(array($_GET['planid'],$row_trvrent['city_id']));;
								$row_citywise_main = $citywise->fetchAll();
								$totalRows_citywise = $citywise->rowCount();
								
								
								$vocity = $conn->prepare("SELECT * FROM dvi_cities where id =?");
								$vocity->execute(array($row_citywise_main[0]['city_id']));
								$row_vocity = $vocity->fetch(PDO::FETCH_ASSOC);
								
								$this_city = $row_vocity['name'];
							?>
                            <p style="background-color:#F6F8F9"> Return distance (kms): <span class="badge badge-primary"><?php echo $row_citywise_main[0]['return_dist']; ?></span></p>
                            <div class="table-responsive" style="overflow-x:scroll; width:100%;">
								<table  class="table table-bordered table-th-block table-<?php if($colrnum == 0) { echo 'warning'; } elseif($colrnum == 1) { echo 'info'; }  elseif($colrnum == 2) { echo 'primary'; } elseif($colrnum == 3) { echo 'danger'; } elseif($colrnum == 4) { echo 'success'; } ?>">
									<thead>
										<tr>
                                        	<th>From city</th>
                                            <th>Type</th>
                                            <th>Total driven distance (kms)</th>
                                            <th> Per day rental (&#8377;)</th>
                                            <th> Rental for <?php echo $row_orders['tr_days']; ?> days (&#8377;)</th>
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
									
									foreach($row_citywise_main as $row_citywise)
									{
										
										$vtyp1 = $conn->prepare("SELECT * FROM vehicle_pro where vehi_id =?");
										$vtyp1->execute(array($row_citywise['vehicle_id']));
										$row_vtyp1 = $vtyp1->fetch(PDO::FETCH_ASSOC);
										$extr_chrg = $row_citywise['rent_per_km'] * $row_citywise['exceed_km'];
										?>
										<tr>
                                             <?php if ($num == 1) { ?> <td rowspan="3"  style="transform:rotate(-90deg); font-weight:bold; color:#000"><?php echo $row_vocity['name']; ?></td> <?php } ?>
											<td style="word-wrap:break-word;"><?php echo $row_vtyp1['vehicle_type']; ?></td>
                                            <td><?php echo $row_citywise['tot_dist']; ?></td>
											<td><?php echo $row_citywise['rent_day']; ?></td>
                                            <td width="30%"><?php $allday_rent = $row_orders['tr_days'] * $row_citywise['rent_day']; echo $row_orders['tr_days'].' * '.$row_citywise['rent_day'].' = '; echo $allday_rent; ?></td>
                                            <td><?php echo $row_citywise['rent_per_km']; ?></td>
                                            <td><?php echo $row_citywise['max_km_day']; ?></td>
											<td><?php echo $row_citywise['max_allwd_km']; ?></td>
                                            <td><?php echo $row_citywise['exceed_km']; ?></td>
                                            <td width="30%"><?php echo $row_citywise['rent_per_km'].' * '.$row_citywise['exceed_km'].' = '; echo $extr_chrg; ?></td>
                                            <td><?php echo $row_citywise['permit_amt']; ?></td>
											<td><?php echo $row_citywise['rent_amt']; ?></td>
										</tr>
                                        <?php
										$veh_citycost+= $row_citywise['rent_amt'];
									$num++; 
									} 
										?>
									</tbody>
								</table>
                                </div>
                                <div class="row">
                                	<div class="col-sm-12">
                                		<div class="the-box" style=" text-align:left; background-color:#E6ECF2;"><strong  style="font-size: large">Total amount chargeable for vehicle from <?php echo $this_city; ?>:  <?php echo  convert_currency_text("&#8377;",$_GET['planid'])." ".convert_currency($veh_citycost,$_GET['planid']); ?></strong>
						        		</div>
                        		</div>
							</div>
                            
                            <?php
							$num == 1; $colrnum++; if ($colrnum == 5) { $colrnum = 0; } $veh_citycost = 0;
							}
							
							 } //not for hotel only if end?>
					        <br />
							<!-- /.jumbotron .jumbotron-sm -->
							
					</div><!-- /.the-box -->
                    </div>
                    </div>
					<!-- END INVOICE -->
                   
		
        <script src="../core/assets/js/jquery.min.js"></script>
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
		


</script>