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
					/*
					$query_logo = "SELECT * FROM agent_pro where agent_id = '".$_SESSION['uid']."'";
					$logo = mysql_query($query_logo, $divdb) or die(mysql_error());
					$row_logo = mysql_fetch_assoc($logo);
					$totalRows_logo = mysql_num_rows($logo);*/

					?>
                    
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
                                <h3 class="text">Itinerary - Plan Report </h3>
                                <h4 class="text-muted text"><?php echo $_GET['planid']; ?></h4>
                            </div>
                            
							<div class="col-sm-6 text-right">
								<p>Arrival Date :<strong> <?php echo date("F jS, Y",strtotime($row_orders['tr_arr_date'])).'<br>'.$row_orders['tr_arr_time']; ?></strong></p>
                                <div class="btn-group pull-right">
											<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
											  Download
											  <span class="caret"></span>
											</button>
											<ul class="dropdown-menu">
											  <li><a href="myreport_pdf.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&planid=<?php echo urlencode($row_orders['plan_id']); ?>">PDF FORMAT</a></li>
											  <!--<li><a href="#fakelink">Dropdown link</a></li>-->
											</ul>
										  </div>
							</div>
                        </div>
							<!-- /.row -->
                            <br />
                            <div class="row">
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
										foreach($row_routes_main as $row_routes)
										{
										?>
										<tr>
											<td>
											<p><strong><?php echo date("F jS, Y",strtotime($row_routes['tr_date'])); ?></strong></p>
                                             </td>
                                             <td>
												<p class="text-muted">
												<?php 
												if($row_routes['via_cities'] != '-'){
													$via_cities_arr = explode("-",$row_routes['via_cities']);
													$middleElem = floor(count($via_cities_arr) / 2);
													$via_cities = $conn->prepare("SELECT * FROM dvi_cities where id =?");
													$via_cities->execute(array($via_cities_arr[$middleElem]));
													$row_via_cities = $via_cities->fetch(PDO::FETCH_ASSOC);
													echo $row_routes['tr_from_cityid'].' TO '.$row_routes['tr_to_cityid'].' via '.$row_via_cities['name'];
													
												}else{
													 echo $row_routes['tr_from_cityid'].' TO '.$row_routes['tr_to_cityid'];
													}
												?>
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
										
										?>
									</tbody>
								</table>
							</div><!-- /.table-responsive -->
							<?php
							}
							?>
							
							<!-- /.row -->
							<?php
							if(substr($_GET['planid'],0,1) == 'T' || substr($_GET['planid'],0,2) == 'TH')
							{
							
							$trvrent = $conn->prepare("SELECT * FROM travel_vehicle where travel_id =?");
							$trvrent->execute(array($_GET['planid']));
							$row_trvrent = $trvrent->fetch(PDO::FETCH_ASSOC);
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
                                    <h3 class="text"><strong> Vehicle travel info: </strong></h3>
                                    <p style="background-color:#F6F8F9"> Number of vehicles taken: <span class="badge badge-primary"><?php echo $totalRows_trvrent; ?> </span></p>
                                    <p style="background-color:#F6F8F9"> Type of vehicle taken: <span class="label label-primary"><?php echo $vehnames; ?></span></p>
                                    
                                    
                                </div>
                        	</div>

                            <hr />
							
							<!-- /.row -->
                            <?php $grand_ttotal=$grand_ttotal+$row_orders['tr_net_amt']; ?>
                            <?php /*?><div class="row">
                                <div class="col-sm-12">
                                <div class="the-box" style=" text-align:left; background-color:#E6ECF2;"><strong  style="font-size: x-large;">Total amount chargeable for transport: &#8377; <?php echo  $row_orders['tr_net_amt'];  $grand_ttotal=$grand_ttotal+$row_orders['tr_net_amt']; ?></strong>
						        </div>
                                    
                                </div>
                        	</div><?php */?>
                            
                            <?php } //not for hotel only if end?>
                            
                            <?php 
											
$spro = $conn->prepare("SELECT * FROM stay_sched where stay_id =? ORDER BY sno ASC ");
$spro->execute(array($_GET['planid']));
//$row_spro = mysql_fetch_assoc($spro);
//$row_spro_main=$spro->fetchAll();
$totalRows_spro = $spro->rowCount();
$scnt=1;
							
							if(substr($_GET['planid'],0,2)=='TH' && $totalRows_spro>0)
							{ ?>
                            <div class="row" style="margin-top:20px">
                            <div class="col-sm-12">
                            
                            <table width="100%" class="table table-th-block table-striped">
                                    <tr><th>S.No</th><th>Date</th><th>Place</th><th>Hotel</th><th>Room Category</th><th>Meal Plan</th><th>T Nights</th></tr>
                                    <?php while($row_spro = $spro->fetch(PDO::FETCH_ASSOC)){ ?>
                                    <tr><td><?php echo $scnt; ?></td><td><?php
									
$spro1 = $conn->prepare("SELECT * FROM stay_sched where stay_id =? and hotel_id=?  ORDER BY sno ASC ");
$spro1->execute(array($_GET['planid'],$row_spro['hotel_id']));
$row_spro1 = $spro1->fetch(PDO::FETCH_ASSOC);
$totalRows_spro1 = $spro1->rowCount();
						
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
						}
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
$totalRows_hotell =$hotell->rowCount();
echo $row_hotell['hotel_name'];
									 ?>
                                     </td>
                                     <td>
                                     <?php 
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
	echo $row_hroom['room_type']." - ".$rrom2[$rrom1[$tt]].",&nbsp;"; 
}else
{
	echo $row_hroom['room_type']." - ".$rrom2[$rrom1[$tt]]; 
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
                                     <td><center><?php echo $totalRows_spro1; ?></center></td>
                                     </tr>
                                    <?php 
									if($totalRows_spro1>1)
									{
										for($rt=0;$rt<$totalRows_spro1-1;$rt++)
										{
										$row_spro = $spro->fetch(PDO::FETCH_ASSOC);	
										}
									}
									
									$scnt++; }  ?>
                                    </table>
                            
                            </div>
                            
                            </div>
                            <?php }else if(substr($_GET['planid'],0,2)=='TH' && $totalRows_spro==0){ 
							echo "<center><strong>This itinerary was cancelled / rejected,<br> Before creating hotel details..</strong></center>";
							
							}?>
                            <div class="the-box" style="background-color:#E6ECF2;"><strong  style="font-size: x-large;color: rgb(30, 36, 153);">Overall Cost Of This Plan : <?php echo  convert_currency($row_orders['agnt_grand_tot'],$_GET['planid'])." ".convert_currency_text("Rupees",$_GET['planid']); 
		?></strong>
        <br /></div>
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
		<script src="../core/assets/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
		<script src="../core/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
		<script src="../core/assets/plugins/datatable/js/bootstrap.datatable.js"></script>
		<!--<script src="../core/assets/plugins/slider/bootstrap-slider.js"></script>-->
		
		<script src="../core/assets/plugins/toastr/toastr.js"></script>
        
		<!-- PLUGINS -->
        <script type="text/javascript" src="../core/assets/plugins/Tags/jquery.tagsinput.js"></script>
        <script src="../core/assets/plugins/chosen/chosen.jquery.min.js"></script>
		<script src="../core/assets/plugins/spinner/js/jquery.dpNumberPicker-1.0.1-min.js"></script>
        
		<script src="../core/assets/js/apps.js"></script>
		<script src="../core/assets/js/demo-panel-1.js"></script>
        <script src="../core/assets/jQuery1/form-validator/spin.js"></script>
        <script src="../core/assets/js/moment.js"></script>
		<script>
		$(document).ready(function(e) {
			$('.datatable-example').dataTable();
        });
		


</script>