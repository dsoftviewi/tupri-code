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
 <?php
                      //breakup start 

$breakup = $conn->prepare("SELECT * FROM travel_master where plan_id =?");
$breakup->execute(array($_GET['planid']));
$row_breakup = $breakup->fetch(PDO::FETCH_ASSOC);
$totalRows_breakup = $breakup->rowCount();
$customer_name=$row_breakup['tr_name'];
$break_arr=array();
//echo "Breakup =".$row_breakup['sub_paln_id'];
if(trim($row_breakup['sub_paln_id'])!='')//not empty
{
	$row_breakup['sub_paln_id'];
	$break_arr=explode('-',$row_breakup['sub_paln_id']);
}
//print_r($break_arr);
//breakup end 
?>
<tr><td align="center">
	<table border="1" width="95%" style="border-collapse: collapse;">
	<tr><th colspan="5" style="text-align: center;background-color: rgb(39, 96, 146);
color: whitesmoke;padding: 5px;"><?php echo "Guest Name : ".$customer_name; ?></th></tr>
		<tr>
			<th style="padding:6px; font-family:Calibri; font-size: 14px;">S.No</th>
			<th style="padding:6px; font-family:Calibri; font-size: 14px;">Travelling Date</th>
			<th style="padding:6px; font-family:Calibri; font-size: 14px;">Total Pax</th>
			<th style="padding:6px; font-family:Calibri; font-size: 14px;">Vehicle Information</th>
			<th style="padding:6px; font-family:Calibri; font-size: 14px;">Cost</th>
		</tr>
		<?php 
		$rno=1;
		$whole_pakcost=0;
		foreach($break_arr as $breakup1)
		{
			
			$or = $conn->prepare("SELECT * FROM travel_master where plan_id =?");
			$or->execute(array($breakup1));
			$row_or = $or->fetch(PDO::FETCH_ASSOC);
			$totalRows_or = $or->rowCount();
		?>
		<tr>
			<th style="padding:6px; font-family:Calibri; font-size: 14px;"><?php echo "Breakup ". $rno; ?></th>
			<th style="padding:6px; font-family:Calibri; font-size: 14px;">
				<?php echo date('d-M-Y',strtotime($row_or['tr_arr_date'])); 

				$date=date_create($row_or['tr_arr_date']);
				date_add($date,date_interval_create_from_date_string($row_or['tr_days']." days"));
				echo " - ".date_format($date,"d-M-Y");?>
			</th>
			<th style="padding:6px; font-family:Calibri; font-size: 14px;">
				<?php echo $row_or['pax_cnt']."&nbsp;Person(s)"; ?>
			</th>
			<th style="padding:6px; font-family:Calibri; font-size: 14px;">
			<?php
								$vah=explode(',',$row_or['tr_vehids']);
								for($r=0;$r<count($vah);$r++)
								{
									if(trim($vah[$r]) != '')
									{
						    
							$vpro = $conn->prepare("SELECT * FROM travel_vehicle tv,vehicle_pro vp where tv.vehicle_id=vp.vehi_id and tv.travel_id = ? and tv.vehicle_id=?");
						    $vpro->execute(array($breakup1,$vah[$r]));
							$row_vpro =$vpro->fetch(PDO::FETCH_ASSOC);
							$totalRows_vpro = $vpro->rowCount();
							$travel_amount =  $row_vpro['rent_amt'] +($row_or['agnt_adm_perc'] * $row_vpro['rent_amt']/100);
							$travel_amount = 	number_format(convert_currency($travel_amount,$_GET['planid']),2);
							if(isset($vah[$r+1]) && $vah[$r+1] != '')
							{
								 echo $row_vpro['vehicle_type']."&nbsp; = ".$travel_amount."<BR/>";
							}else
							{
								echo $row_vpro['vehicle_type']."&nbsp; = ".$travel_amount;
							}
									}
								}
								  ?>
			</th>
			<th style="padding:6px; font-family:Calibri; font-size: 14px;">
					<?php echo 	convert_currency_text("Rs",$_GET['planid'])." ".number_format(convert_currency($row_or['agnt_grand_tot'],$_GET['planid']),2); 
					$whole_pakcost=$whole_pakcost+(float)$row_or['agnt_grand_tot']; ?>
			</th>
		</tr>
		<?php $rno++; } ?>
		<tr>
			<th style="padding:6px; font-family:Calibri; font-size: 14px;text-align:center" colspan="4">Total Package Cost </th>
			<th style="padding:6px; font-family:Calibri; font-size: 14px;background-color: rgb(227, 241, 254);"><?php echo convert_currency_text("Rs",$_GET['planid'])." ".number_format(convert_currency($whole_pakcost,$_GET['planid']),2)." /-"; ?></th>
		</tr>
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
	<div style="margin-left:60px">
		<p align="left" style="margin-top:5px"><strong style="font-size: 12px;color: #32648f;"> Total Cost Including Special Add-ons On : </strong></p>
		<ul style="text-align: -moz-left;">
			<?php foreach($addon_arr as $spl){ ?>
			  <li style="font-size: 12px;text-align:left"><?php //print_r($spl); 
		echo date("d-M-Y",strtotime($spl['sdate']))." - ".$spl['sname']." [ * ".$spl['sqnty']." ]";
			   ?> </li>
			<?php } ?>
		</ul></div>
	<?php  } ?>

<tr><td><hr style="border:1px dotted #039;margin-top: 10px;margin-bottom: 10px; "></td></tr>

</td></tr>
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
                      ?>
 
 
 <!-- <tr><td>
 			<table>
                 <tr><td style="font-family:Calibri font-size: 14px; font-weight:600">&nbsp;Guest Name</td><td>:</td><td style="font-family:Calibri; font-size: 14px; font-weight:600"><?php echo $customer_name; ?></td></tr>
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
 <tr><td align="center">
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
            <td style="font-family:Calibri; font-size: 12px; font-weight:600; padding:5px">&nbsp;
			<?php 
												if($row_trvscd['via_cities'] != '-'){
													$via_cities_arr = explode("-",$row_trvscd['via_cities']);
													$middleElem = floor(count($via_cities_arr) / 2);
													$via_cities = $conn->prepare("SELECT * FROM dvi_cities where id =?");
													$via_cities->execute(array($via_cities_arr[$middleElem]));
													$row_via_cities = $via_cities->fetch(PDO::FETCH_ASSOC);
													echo $row_trvscd['tr_from_cityid'].' TO '.$row_trvscd['tr_to_cityid'].' via '.$row_via_cities['name'];
													
												}else{
													 echo $row_trvscd['tr_from_cityid'].' TO '.$row_trvscd['tr_to_cityid'];
													}
												?>
			&nbsp;</td>
            <td style="font-family:Calibri; font-size: 12px; font-weight:600; padding:5px">&nbsp;<?php  if($row_trvscd['tr_dist_ess']!='0') { echo $row_trvscd['tr_dist_ess']." Kms."; }else { echo $row_trvscd['tr_dist_ss']." Kms.";}?>&nbsp;</td>
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
                                   
                                     <?php foreach($row_trv_main as $row_trv)
									 {
										
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
		 echo "<br><br><span style='font-weight:bold; color:green'>"."DAYTRIP applicable to ".$dt_arr[$row_trv['tr_from_cityid']][0]."</span>";

		 										 
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
								 }		}
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
 
 <?php }//main for loop?>
 </table>
<div style="display:none; margin-top:10px;" id="dis_play">
 <?php
  $pers1 = $conn->prepare("SELECT * FROM login_secure where uid=?");
		$pers1->execute(array($_SESSION['uid']));
		$row_pers1=$pers1->fetch(PDO::FETCH_ASSOC);
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
        <div class=" col-sm-3"><input type="email" name="mailtome" id="mailtome" class="form-control" ></div><div class="col-sm-1"><button class="btn-info btn btn-sm" name="mail_btn" id="mail_btn" onClick="mail_to_me_fun()"> Send Mail </button></div><div class="col-sm-4"></div>
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
	
	function mail_to_me_fun()
	{
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
			
			var cont=$('#mail_me').html();
			$('.loader_ax').fadeIn();
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
</script>

	