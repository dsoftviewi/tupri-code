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

?>
<style>
body {
    background-position: 50% 50%;
    margin:0px;
    padding:0px !important;
}

table td{
	padding:3px;
 	
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
					<!-- Begin page heading -->
					<!-- BEGIN INVOICE -->
					<div class="the-box full invoice">
                    <div class="the-box no-border ">
                    <div class="row">
                   <img src="../images/dvi_pdf.png" alt="DVI Logo" style="margin-left:30px; margin-top:20px;"/>
                   <div style="margin-top:-72px; margin-bottom:100px;">
                  <center><strong style="font-family:sans-serif; font-weight:bolder; font-size:77px; color:#000; "> Welcomes </strong><br />
                  <strong style="font-family:sans-serif; font-weight:bolder; font-size:77px;color:#000;"> Mr/Mrs.&nbsp;</strong><strong style="font-family:sans-serif; font-weight:bolder; font-size:77px;color:#000; word-wrap:break-word" ><?php echo $row_orders['tr_name']; ?> </strong></center>
                   </div>
                   <div >
                   <div class="col-sm-6">
                    <b>Arrival date & arrival flight/train details&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;<?php echo $row_orders['tr_arrdet']; ?></b>
<br /><b>Departure date& departure flight/ train details;&nbsp;&nbsp;: &nbsp;<?php echo $row_orders['tr_depdet']; ?></b>
                   </div>
                    <div class="col-sm-6"><br />
                    <div class="col-sm-3 pull-right"><b><?php echo $row_orders['tr_mobile']; ?></b></div><div class="col-sm-3 pull-right"><b >Contact No.&nbsp;</b></div>
                    </div>
                    </div>
                   </div>
                    </div>
                      <hr style="margin-top: 10px;margin-bottom: 10px;" />
                        <div class="the-box" style="vertical-align: text-middle; border:thin #666 1px;">
							<div class="row">
								<div class="col-sm-12 text-right">
									<img  src="../images/dvi_pdf.png"  height="100px" width="100px" alt="DVI Logo"/>
                                    <hr style=" color: #443232;margin-top: 10px;margin-bottom: 10px" />
                                    <br />
								</div><!-- /.col-sm-6 -->
                                <div>
                                <table>
                                <tr><td>&nbsp;Guest Name</td><td>:</td><td><?php echo $row_orders['tr_name']; ?></td></tr>
                                <tr><td>&nbsp;Pax Count</td><td>:</td><td><?php echo $row_orders['pax_cnt']."&nbsp;Person(s)"; ?></td></tr>
                              <?php if($str !='H'){ ?>
                                <tr><td>&nbsp;Total Traveling days</td><td>:</td><td><?php echo $row_orders['tr_days']; ?></td></tr>
                                <tr><td>&nbsp;Vehicle Infomation</td><td>:</td>
                                <td><?php
								$vah=explode(',',$row_orders['tr_vehids']);
								for($r=0;$r<count($vah);$r++)
								{
									if(trim($vah[$r]) != '')
									{
								  
$vpro = $conn->prepare("SELECT * FROM vehicle_pro where vehi_id =?");
$vpro->execute(array($vah[$r]))	
$row_vpro =$vpro->fetch(PDO::FETCH_ASSOC);
$totalRows_vpro = $vpro->rowCount();
if(isset($vah[$r+1]) && $vah[$r+1] != '')
{
	 echo $row_vpro['vehicle_type'].",&nbsp;";
}else
{
	echo "&nbsp;and&nbsp;".$row_vpro['vehicle_type'];
}
								
									}
								}
								  ?></td></tr>
                                <?php }else{?>
                                <tr><td>&nbsp;Total Staying days</td><td>:</td><td><?php echo $row_orders['tr_nights']; ?></td></tr>
                                <?php }?>
                                </table>
                                    </div>
                                    <div class="table-responsive" style="margin-left:30px; margin-right:30px;">
                                    <span style="color:#F00; margin-left:-23px;"><u>Hotel list:</u></span>
                                    <br /><br />
                                    <?php 

$spro = $conn->prepare("SELECT * FROM stay_sched where stay_id =? ORDER BY sno ASC ");
$spro->execute(array($_GET['planid']));
//$row_spro = mysql_fetch_assoc($spro);
$row_spro_main=$spro->fetchAll();
$totalRows_spro = $spro->rowCount();
$scnt=1;	



									?>
                                    <table class="table table-th-block table-striped">
                                    <tr><th>S.No</th><th>Date</th><th>Place</th><th>Hotel</th><th>Room Category</th><th>T Nights</th></tr>
                                    <?php foreach($row_spro_main as $row_spro){ ?>
                                    <tr><td><?php echo $scnt; ?></td><td><?php
									
$spro1 = $conn->prepare("SELECT * FROM stay_sched where stay_id =? and hotel_id=? ORDER BY sno ASC ");
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
$totalRows_hotell = $hotell->rowCount();
echo $row_hotell['hotel_name'];
									 ?>
                                     </td>
                                     <td>
                                     <?php 
									$rrom=explode(',',$row_spro['sty_room_type']);
									for($tt=0;$tt<count($rrom);$tt++)
									{
									 
$hroom = $conn->prepare("SELECT * FROM hotel_season where sno =?");
$hroom->execute(array($rrom[$tt]));
$row_hroom = $hroom->fetch(PDO::FETCH_ASSOC);
$totalRows_hroom = $hroom->rowCount();
if(isset($rrom[$tt+1]) && $rrom[$tt+1] !='')
{
	echo $row_hroom['room_type'].",&nbsp;"; 
}else
{
	echo $row_hroom['room_type']; 
}

									}?>
                                     </td><td><?php echo $totalRows_spro1; ?></td></tr>
                                    <?php 
									if($totalRows_spro1>1)
									{
										for($rt=0;$rt<$totalRows_spro1-1;$rt++)
										{
										$row_spro =$spro->fetch(PDO::FETCH_ASSOC);	
										}
									}
									
									$scnt++; }  ?>
                                    </table>
                                    </div>
                                    <div>
                                    <span style="color:#666; font-size:18px">Itinerary: (Program schedule)</span>
                                    <br />
                                    <br />
                                    <?php

$sspro = $conn->prepare("SELECT * FROM stay_sched where stay_id =? ORDER BY sno ASC ");
$sspro->execute(array($_GET['planid']));
//$row_sspro = mysql_fetch_assoc($sspro);
$row_sspro_main=$sspro->fetchAll();
$totalRows_sspro = $sspro->rowCount();
$row_count=$totalRows_sspro;
					
					            

$trv = $conn->prepare("SELECT * FROM travel_sched where travel_id =? ORDER BY sno ASC");
$trv->execute(array($_GET['planid']));
//$row_trv = mysql_fetch_assoc($trv);
$row_trv_main=$trv->fetchAll();
$totalRows_trv = $trv->rowCount();
$chn=0; 
$i=0;
									?>
                                    <div class="col-sm-12">
                                     <?php foreach($row_sspro_main as $row_sspro) {
										$row_trv = $row_trv_main[$i];
									?>
                                    <div class="col-sm-2" style="margin-top:15px; border-top:solid #DADADA 1px">
                                   
                                    <span style="color:#000; font-weight:600;">
                                    <?php
									if($row_trv['tr_date'] == $row_sspro['sty_date'])
									{
										echo date('Y-M-d D',strtotime(str_replace('-','/',$row_trv['tr_date'])));
									}
									?>
                                    </span>
                                    </div>
                                    <div class="col-sm-10" style="margin-top:15px; border-top:solid #DADADA 1px">
                                          <?php
									
$cityy1 = $conn->prepare("SELECT * FROM dvi_cities where name LIKE ?");
$cityy1->execute(array($row_trv['tr_from_cityid']));
$row_cityy1 = $cityy1->fetch(PDO::FETCH_ASSOC);
$totalRows_cityy1 = $cityy1->rowCount();


$hot= $conn->prepare("SELECT * FROM hotspots_pro where spot_city =? ORDER BY spot_prior ASC");
$hot->execute(array($row_cityy1['id']));
//$row_hot = mysql_fetch_assoc($hot);
$row_hot_main=$hot->fetchAll();
$totalRows_hot = $hot->rowCount();
									?>
                                    
                                    <span style="color:#000;  font-size:14px; font-weight:600"> <?php if($chn=='0'){?>Arrival– <?php }?> <?php echo $row_trv['tr_from_cityid']."&nbsp;&nbsp;-&nbsp;&nbsp;".$row_trv['tr_to_cityid'];?></span><br /><br /><span>In this day,<?php if($totalRows_hot>0){ 
									echo " We have to visit following hotspot : ";
									foreach($row_hot_main as $row_hot){
										echo $row_hot['spot_name'].",&nbsp;";
										} 
										} ?></span>
                                        <span> <?php 
										$hotel2 = $conn->prepare("SELECT * FROM hotel_pro where hotel_id =?");
$hotel2->execute(array($row_sspro['hotel_id']));
$row_hotel2 = $hotel2->fetch(PDO::FETCH_ASSOC);
$totalRows_hotel2 = $hotel2->rowCount();
										
										if($row_sspro['sty_food']=='dinner_rate')
										{
											echo " We will be having dinner at ".$row_hotel2['hotel_name']."&nbsp;(&nbsp;".$row_trv['tr_to_cityid']."&nbsp;)&nbsp;";
										}else if($row_sspro['sty_food']=='lunch_rate')
										{
											echo "In between we will be having lunch at ".$row_hotel2['hotel_name']."&nbsp;(&nbsp;".$row_trv['tr_to_cityid']."&nbsp;)&nbsp;";
										}else if($row_sspro['sty_food']=='both_food')
										{
											echo "In between we will be having lunch and dinner at ".$row_hotel2['hotel_name']."&nbsp;(&nbsp;".$row_trv['tr_to_cityid']."&nbsp;)&nbsp;";
											
										}?></span>
                                        <br />
                                        <span>Overnight at <?php echo $row_trv['tr_to_cityid'];?></span>
                                    </div>
                                  
                                     <?php
									 $chn++;
									$row_count--;
									$i++;
									 } ?>
                                    </div>
                                    
                                    </div>
                                    
                                    
							</div><!-- /.row -->
						</div>
                    
                    
                    
                    
                  
                    
                    
                    
                    
                    
                    
                    
                    
						<!-- /.the-box no-border bg-dark -->
						<!--<div class="the-box no-border">
                        <div class="row">
                        	<div class="col-sm-6">
                                <h3 class="text">Itinerary </h3>
                                <h4 class="text-muted text"><?php// echo $_GET['planid']; ?></h4>
                            </div>
                            
							<div class="col-sm-6 text-right">
								<p>Arrival Date :<strong> <?php// echo date("F jS, Y",strtotime($row_orders['tr_arr_date'])).'<br>'.$row_orders['tr_arr_time']; ?></strong></p>
                                <div class="btn-group pull-right">
											<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
											  Download
											  <span class="caret"></span>
											</button>
											<ul class="dropdown-menu">
											  <li><a href="itiner_pdf.php?mm=<?php// echo $_GET['mm'];?>&sm=<?php// echo $_GET['sm'];?>&planid=<?php// echo urlencode($row_orders['plan_id']); ?>">PDF FORMAT</a></li>
											  <!--<li><a href="#fakelink">Dropdown link</a></li>--
											</ul>
										  </div>
							</div>
                        </div>
							<!-- /.row -->
                           
							
                           
							<!-- /.row --
							
							<div class="jumbotron jumbotron-sm text-center">
								<h1>Thank you for your business</h1>
							</div><!-- /.jumbotron .jumbotron-sm --
							
						</div>--><!-- /.the-box no-border no-margin-->
                        <div class="jumbotron jumbotron-sm text-center">
								<h1>Thank you for your business</h1>
							</div>
					</div><!-- /.the-box -->
					<!-- END INVOICE -->
					
		<script src="../core/assets/js/bootstrap.min.js"></script>
		<script src="../core/assets/plugins/retina/retina.min.js"></script>
		<script src="../core/assets/plugins/nicescroll/jquery.nicescroll.js"></script>
		<script src="../core/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		<script src="../core/assets/plugins/backstretch/jquery.backstretch.min.js"></script>
        
        
		<!-- PLUGINS -->
        <script type="text/javascript" src="../core/assets/plugins/Tags/jquery.tagsinput.js"></script>
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
		<script src="../core/assets/plugins/spinner/js/jquery.dpNumberPicker-1.0.1-min.js"></script>
        
		<script src="core/assets/js/apps.js"></script>
		<script src="core/assets/js/demo-panel-1.js"></script>
        <script src="core/assets/jQuery1/form-validator/spin.js"></script>
        <script src="core/assets/js/moment.js"></script>
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