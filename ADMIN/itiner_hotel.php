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
body {
    background-position: 50% 50%;
    margin:0px;
    padding:0px !important;
	font-family:Georgia, "Times New Roman", Times, serif;
	font-size: 12px;
}


table td{
	padding:3px;
 	
}


table td.tdstyle{
	padding:4px;
	border:#666 solid 1px;
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
        <body class="div-nicescroller">
					<!-- Begin page heading -->
					<!-- BEGIN INVOICE -->
					<div class="the-box full invoice">
                    <div class="the-box no-border ">
                    <div class="row">
                   <img src="../images/dvi_pdf1.png" alt="DVI Logo" style="margin-left:30px; margin-top:20px;"/>
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
                        <div class="the-box" style="vertical-align: text-middle; border:thin #666 1px;">
							<div class="row">
								<div class="col-sm-12 text-right">
									<img  src="../images/dvi_pdf.png"  height="75px" width="75px" alt="DVI Logo"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                      <strong style="font-size:10px">An ISO 9001 - 2008 Company </strong>
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
$vpro->execute(array($vah[$r]));
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
                                    <?php if($str =='H'){?>
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
                                    <tr><th>S.No</th><th>Date</th><th>Place</th><th>Hotel</th><th>Room Category</th><th>Meal Plan</th><th>T Nights</th></tr>
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
									 }
									 
									  ?></td>
                                     <td><center><?php echo $totalRows_spro1; ?></center></td>
                                     </tr>
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
                                  
                                    </div>  <?php } // if only for hotel?>
							</div><!-- /.row -->
                            
						</div>
                   <div class="jumbotron jumbotron-sm " style="background-color:rgba(225, 220, 247, 0.24); color:#8388A9;">
								<strong>Head Office : </strong><strong>#51, Vijaya Nagar, Dheeran Nagar (Extn), Karumandapam, Trichirappalli, Tamilnadu - 620009</strong><br />
                                <strong>Ph : </strong><strong>0431-2403615 </strong><strong> H Phone :</strong><strong>9443164494</strong><strong> Windows Live ID : </strong><strong> <u>vsr@v-i.in</u></strong><br />
                                <strong>BRANCHES :: </strong><strong>NEW DELHI | MADURAI | COCHIN | VIJAYAWADA</strong>
							</div>
                    <!-- hotel voucher start-->
                    
                    
                    <div class="the-box" style="vertical-align: text-middle; border:thin #666 1px;">
							                                     <?php

$sspro1 = $conn->prepare("SELECT * FROM stay_sched where stay_id =? ORDER BY sno ASC ");
$sspro1->execute(array($_GET['planid']));
//$row_sspro1 = mysql_fetch_assoc($sspro1);
$row_sspro1_main=$sspro1->fetchAll();
$totalRows_sspro1 = $sspro1->rowCount();
if($totalRows_sspro1>0)
{
foreach($row_sspro1_main as $row_sspro1)
{
?>
                            <div class="row">
								<div class="col-sm-12 text-right">
								<img  src="../images/dvi_pdf.png"  height="75px" width="75px" alt="DVI Logo"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                      <strong style="font-size:10px">An ISO 9001 - 2008 Company </strong>
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
               <tr><td width="50%" class="tdstyle">&nbsp;Guest Name</td><td width="50%" class="tdstyle" ><?php echo $row_orders['tr_name']." * ".$row_orders['pax_cnt']; ?></td></tr>
               <tr><td width="50%" class="tdstyle">&nbsp;Check In Date</td>
               <td width="50%" class="tdstyle" > <?php 
			   
$sp = $conn->prepare("SELECT * FROM stay_sched where stay_id =? and hotel_id=?  ORDER BY sno ASC ");
$sp->execute(array($_GET['planid'],$row_sspro1['hotel_id']));
$row_sp = $sp->fetch(PDO::FETCH_ASSOC);
$totalRows_sp = $sp->rowCount();
						
						$old_date= date('Y-M-d',strtotime($row_sspro1['sty_date']));
						if($totalRows_sp>1)
						{			
						 $totalRows_sp2=$totalRows_sp;
						 $derf=$totalRows_sp2;
						$date=date_create($row_sspro1['sty_date']);
date_add($date,date_interval_create_from_date_string($totalRows_sp2." days"));
echo $old_date;
$next_datt=date_format($date,"Y-M-d");
						}else
						{
							$totalRows_sp2=0;
							$derf=1;
$date=date_create($row_sspro1['sty_date']);
date_add($date,date_interval_create_from_date_string("1 days"));
echo $old_date;	
$next_datt=date_format($date,"Y-M-d");
						}
					 //  echo $org_date1= date('d-M-Y',strtotime($row_sspro1['sty_date']));
			   ?></td></tr>
               <tr><td width="50%" class="tdstyle">&nbsp;Check Out Date</td><td width="50%" class="tdstyle" > <?php echo $next_datt; ?></td></tr>
               <tr><td width="50%" class="tdstyle">&nbsp;Hotel Name</td>
               <td width="50%" class="tdstyle" ><?php
									  
$hotell = $conn->prepare("SELECT * FROM hotel_pro where hotel_id =?");
$hotell->execute(array($row_sspro1['hotel_id']));
$row_hotell = $hotell->fetch(PDO::FETCH_ASSOC);
$totalRows_hotell = $hotell->rowCount();


$cityy1 = $conn->prepare("SELECT * FROM dvi_cities where id =?");
$cityy1->execute(array($row_hotell['city']));
$row_cityy1 = $cityy1->fetch(PDO::FETCH_ASSOC);
$totalRows_cityy1 = $cityy1->rowCount();


$stt = $conn->prepare("SELECT * FROM dvi_states where code =?");
$stt->execute(array($row_hotell['state']));
$row_stt = $stt->fetch(PDO::FETCH_ASSOC);
$totalRows_stt = $stt->rowCount();

echo $row_hotell['hotel_name']."&nbsp;[&nbsp;".$row_hotell['category']."&nbsp;Hotel&nbsp;]";
			?>
			 </td></tr>
               <tr><td width="50%" class="tdstyle">&nbsp;Hotel Address</td>
               <td width="50%" class="tdstyle" ><?php echo $row_hotell['location'].",&nbsp;".$row_cityy1['name'].",&nbsp;".$row_stt['name'];//."<br>Phone : ".$row_hotell['hotel_phone']; ?></td></tr>
               <tr><td width="50%" class="tdstyle">&nbsp;Room Category</td>
               <td width="50%" class="tdstyle" > <?php
			
									$rrom=explode(',',$row_sspro1['sty_room_type']);
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
	echo $row_hroom['room_type']; 
	$no_of_rrr=$rrom2[$rrom1[$tt]];
}else
{
	echo $row_hroom['room_type']; 
	$no_of_rrr=$rrom2[$rrom1[$tt]];
}
				}
			   ?></td></tr>
               <tr><td width="50%" class="tdstyle">&nbsp;Total Rooms</td>
               <td width="50%" class="tdstyle"> <?php echo $no_of_rrr; ?></td></tr>
               <tr><td width="50%" class="tdstyle">&nbsp;Meal Plan</td>
               <td width="50%"class="tdstyle" > <?php 
									 //food items
									 if($row_sspro1['sty_food']=='dinner_rate')
									 {
										echo "MAPAI ( Breakfast & Dinner only )"; 
									 }else if($row_sspro1['sty_food']=='lunch_rate')
									 {
										 echo "MAPAI ( Breakfast & Lunch only )"; 
									 }else if($row_sspro1['sty_food']=='both_food')
									 {
										 echo "MAPAI ( Breakfast,Lunch & Dinner )"; 
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
               
               
               <tr><td width="50%" class="tdstyle">&nbsp;Billing</td><td width="50%"class="tdstyle" > <?php echo "Room on Meal Plan to Dvi - Rest Direct"; ?></td></tr>
               <tr><td width="50%" class="tdstyle">&nbsp;Confirmed By</td><td width="50%"class="tdstyle" >&nbsp;</td></tr>
               <tr><td width="50%" class="tdstyle">&nbsp;Customer Care Numbers</td><td width="50%"class="tdstyle" > <?php
			   
$agent = $conn->prepare("SELECT * FROM agent_pro where agent_id =?");
$agent->execute(array($row_orders['agent_id']));
$row_agent = $agent->fetch(PDO::FETCH_ASSOC);
$totalRows_agent = $agent->rowCount();

			    echo "24*7 @ Mr/Mrs. ".$row_agent['agent_fname']." ".$row_agent['agent_lname']."<br>".$row_agent['mobile_no']." / ".$row_agent['land_line']; ?></td></tr>
               <tr><td width="50%" colspan="2" class="tdstyle"><center>DVI Holidays wishes you a pleasant stay</center></td></tr>
               </table>
                                </div>
                                <div class="col-sm-12" style="margin-top:20px;">
                                <div class="col-sm-8"></div>
                                <div class="col-sm-4"><strong>Authorised Signatory</strong><br>
                                <br><?php // echo $row_orders['agent_id']; 
								
								echo $row_agent['agent_fname']." ".$row_agent['agent_lname']."&nbsp;(&nbsp;".$row_agent['mobile_no']."&nbsp;)";
								?></div>
                                
                                </div>
                                
                                <div class="col-sm-12" style="margin-top:20px;">
                                <b>General Policies</b><br>
                                <b>As per Government of India rules, it is mandatory for all guests over the age of 18 years to present a valid photo identification ( ID ) on check-in.</b><br>
                                <b>Entry to the hotel is at the sole discretion of the hotel authority. If the address on the photo identification card matches the city where the hotel is located, the hotel may refuse to provide accommodation.</b><br>
                                <b>Dvi will not be responsible for any check-in denied by the hotel due to the aforesaid reasons. Due to any natural or political or local issues if there is any damage to personal or tour DVI ma not take the responsibility.</b><br>
                                <b>If the booking includes the extra bed it is facilitated with a folding cot or a mattress as an extra bed, as pert eh hotel policy.</b><br>
                                </div>
                                
                                <div class="col-sm-12 " style="background-color:rgba(234, 234, 236, 0.24); color:#8388A9; border-top:#666 solid 1px; border-bottom:#000 solid 1px; margin-top:15px; margin-bottom:20px;">
                                <br>
								<b>Head Office : </b><b>#51, Vijaya Nagar, Dheeran Nagar (Extn), Karumandapam, Trichirappalli, Tamilnadu - 620009</b><br />
                                <b>Ph : </b><b>0431-2403615 </b><b> H Phone :</b><b>9443164494</b><b> Windows Live ID : </b><b> <u>vsr@v-i.in</u></b><br />
                                <b>BRANCHES :: </b><b>NEW DELHI | MADURAI | COCHIN | VIJAYAWADA</b>
							</div>
							</div><!-- /.row -->
                            <?php 
							//echo "tt".$totalRows_sp2;
							if($totalRows_sp2>1)
									{
										for($rt=0;$rt<$derf-1;$rt++)
										{
										$row_sspro1 = $sspro1->fetch(PDO::FETCH_ASSOC);
										}
									}
							}//while end
}?>
                            
						</div>
                    
                    
                    
                    
                    <div class="the-box" style="vertical-align: text-middle; border:thin #666 1px;">
							                                     <?php

$mst = $conn->prepare("SELECT * FROM travel_master where plan_id =?");
$mst->execute(array($_GET['planid']));
$row_mst = $mst->fetch(PDO::FETCH_ASSOC);
$totalRows_mst = $mst->rowCount();


$trl_scd = $conn->prepare("SELECT * FROM travel_sched where travel_id =? ORDER BY sno ASC");
$trl_scd->execute(array($_GET['planid']));
$row_trl_scd =$trl_scd->fetch(PDO::FETCH_ASSOC);
//$row_trl_arr = mysql_fetch_array($trl_scd);
$totalRows_trl_scd = $trl_scd->rowCount();

$start_dtour=date("d- M- Y",strtotime($row_trl_scd['sty_date']));
for($ko=0;$ko<$totalRows_trl_scd-1;$ko++)
{
	$row_trl_scd = $trl_scd->fetch(PDO::FETCH_ASSOC);
}
$last_dtour=date("d- M- Y",strtotime($row_trl_scd['sty_date']));


$sy_scd = $conn->prepare("SELECT * FROM stay_sched where stay_id =?");
$sy_scd->execute(array($_GET['planid']));
$row_sy_scd = $sy_scd->fetch(PDO::FETCH_ASSOC);
$totalRows_sy_scd = $sy_scd->rowCount();

?>
                            <div class="row">
								<div class="col-sm-12 text-right">
									<img  src="../images/dvi_pdf.png"  height="75px" width="75px" alt="DVI Logo"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                      <strong style="font-size:10px">An ISO 9001 - 2008 Company </strong>
                                    <hr style=" color: #443232;margin-top: 10px;margin-bottom: 10px" />
								</div><!-- /.col-sm-6 -->
                                
                                <div class="col-sm-12" >
                                <div class="col-sm-6">
                                <b style="margin-left: -14px;">Dear : Mr/Mrs. </b>
                                <b><?php echo $row_mst['tr_name']." *".$row_mst['pax_cnt'];?></b>
                                </div>
                                <div class="col-sm-6">
                                <b>Tour Date : </b><b><?php echo $start_dtour." To ".$last_dtour." &nbsp;&nbsp;[ ".$totalRows_trl_scd." Days&nbsp;]";?></b>
                                </div>
                                </div>
                                
                                <div class="col-sm-12" style="margin-top:20px;">
                                <span>Greetings from DVI Holidays !!!</span><br><br>
                                <span>Thank you for your choice to use DVI Holidays! <br><br> The Motto of our company is to provide satisfactory services to our entire guest. In order to achieve this aim we need to know your opinion on it. Praise would be a motivation for us to continue our services. And any critic would naturally be a reason for us to improve our services according to the requirements and desires of our Guests.</span><br><br>
                                <span>Please tell YOUR FRIENDS what you like about us! <br><br> Please tell US what you dislike.<br><br></span>
                                <p style="margin-left:20px;">Tell us about the vehicles and its drivers for your whole trip?<br>Vehicle Provided :<br>Is the vehicle is on Time at the airport on your arrival?<br>Vehicle Provided :<br>How about the driver's services to you?<br>Driver Name :<br><br></p>
                                <span>Tell us about the hotels which you have been used for your whole trip.</span>
                                </div>
                                
                                <?php

$sy_scd1 = $conn->prepare("SELECT * FROM stay_sched where stay_id =?");
$sy_scd1->execute(array($_GET['planid']));
//$row_sy_scd1 = mysql_fetch_assoc($sy_scd1);
$row_sy_scd1_main=$sy_scd1->fetchAll();
$totalRows_sy_scd1 =$sy_scd1->rowCount();
								
								foreach($row_sy_scd1_main as $row_sy_scd1)
								{
									if($row_sy_scd1['sty_date'] != '')
									{
											  
$shot = $conn->prepare("SELECT * FROM hotel_pro where hotel_id =?");
$shot->execute(array($row_sy_scd1['hotel_id']));
$row_shot= $shot->fetch(PDO::FETCH_ASSOC);
$totalRows_shot = $shot->rowCount();
								?>
                                <div class="col-sm-12" style="margin-top:15px; margin-bottom:15px;">
                                <table> 
                                <tr><td style="padding: 12px; font-weight:600"><?php
								
								
								
$cityy1 = $conn->prepare("SELECT * FROM dvi_cities where id =?");
$cityy1->execute(array($row_sy_scd1['sty_city']));
$row_cityy1 = $cityy1->fetch(PDO::FETCH_ASSOC);
$totalRows_cityy1 = $cityy1->rowCount();
								
								
								 echo $row_cityy1['name']; ?></td>
                                 <td style="padding: 12px;font-weight:600"><?php
								 echo $row_shot['hotel_name']; ?></td>
                                 <td style="padding: 12px; font-weight:600">Check In :</td><td style="padding: 12px; font-weight:600"><?php
								 echo date("d-M-Y",strtotime($row_sy_scd1['sty_date'])); 
								 
								 
$sy_ht = $conn->prepare("SELECT * FROM stay_sched where stay_id=? and hotel_id =?");
$sy_ht->execute(array($_GET['planid'],$row_sy_scd1['hotel_id']));
$row_sy_ht = $sy_ht->fetch(PDO::FETCH_ASSOC);
$totalRows_sy_ht =$sy_ht->.rowCount();
for($bi=0;$bi<$totalRows_sy_ht-1;$bi++)
{
	$row_sy_scd1 =$sy_scd1->fetch(PDO::FETCH_ASSOC);
	//$row_trl_scd1 = mysql_fetch_assoc($trl_scd1);//work 
	$totalRows_sy_scd1--; 
}
								 ?></td>
                                 <td style="padding: 12px; font-weight:600">Check Out :</td><td style="padding: 12px; font-weight:600">
								 <?php
								 $date=date_create($row_sy_scd1['sty_date']);
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
                                <?php $totalRows_sy_scd1--; 
								}//if end
								}//while end ?>
                               
                               
                               <div class="col-sm-12">
                               <p>Please tell us about the overall feedback on DVI Holidays for organizing your tour.</p>
                               <span>Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</span><br><br>
                               <span>EMail ID &nbsp;:</span><br><br>
                               <span>Address &nbsp;:</span><br><br><br><br>
                               </div>
                                <div class="col-sm-12 " style="background-color:rgba(234, 234, 236, 0.24); color:#8388A9; border-top:#666 solid 2px; border-bottom:#000 solid 2px; margin-top:15px; margin-bottom:20px;">
                                <br>
								<b>Head Office : </b><b>#51, Vijaya Nagar, Dheeran Nagar (Extn), Karumandapam, Trichirappalli, Tamilnadu - 620009</b><br />
                                <b>Ph : </b><b>0431-2403615 </b><b> H Phone :</b><b>9443164494</b><b> Windows Live ID : </b><b> <u>vsr@v-i.in</u></b><br />
                                <b>BRANCHES :: </b><b>NEW DELHI | MADURAI | COCHIN | VIJAYAWADA</b>
							</div>
							</div><!-- /.row -->

                            
						</div>
                    <?php if(isset($_GET['topbar']) && $_GET['topbar']=="topbar") {?>
                         <div class="the-box" style="vertical-align: text-middle; border:thin #666 1px; background-color:#F2F2F2">
                          <form name="approvel_wait" id="approvel_wait" method="post">
                            <center><button  type="submit" class="btn btn-default" id="grant_approvel" name="grant_approvel" value="grant_approvel_val">Approve</button>
                            <button type="submit" class="btn btn-default" id="reject_approvel" name="reject_approvel" value="reject_approvel_val">Reject</button></center>
                         </form>
                         </div>
                         <?php }?>
					</div><!-- /.the-box -->
					<!-- END INVOICE -->
                    </body>
                    </html>
					
		<script src="../core/assets/js/bootstrap.min.js"></script>
		<script src="../core/assets/plugins/retina/retina.min.js"></script>
		<script src="../core/assets/plugins/nicescroll/jquery.nicescroll.js"></script>
		<script src="../core/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
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
        <script src="../core/assets/jQuery/form-validator/spin.js"></script>
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