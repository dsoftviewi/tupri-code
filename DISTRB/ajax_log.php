<?php
require_once('../Connections/divdb.php');
include("../COMMN/smsfunc.php");
session_start();

$timezone = new DateTimeZone("Asia/Kolkata" );
  $date = new DateTime();
  $date->setTimezone($timezone );
  $mm=$date->format('m');
  $mm1=$date->format('M');
  $yy=$date->format('Y');
  $dd=$date->format('d');
  $time=date("H:i:s");
  $today=date("Y-m-d");
?>

<?php
//finding hotel
if(isset($_GET['type']) && $_GET['type']==1)
{ 
$pln_id=$_GET['pid1']."#".$_GET['pid2'];
$datt=$_GET['datt'];


$tmaster = $conn->prepare("SELECT * FROM `travel_master` WHERE status=0 and plan_id=?");
$tmaster->execute(array($pln_id));
$row_tmaster = $tmaster->fetch(PDO::FETCH_ASSOC);
$totalRows_tmaster = $tmaster->rowCount();


$trvl = $conn->prepare("SELECT * FROM `travel_sched` WHERE  travel_id=? and tr_date=?");
$trvl->execute(array($pln_id,$datt));
$row_trvl = $trvl->fetch(PDO::FETCH_ASSOC);
$totalRows_trvl = $trvl->rowCount();


$trvl_day = $conn->prepare("SELECT * FROM `travel_sched` WHERE  travel_id=? ORDER BY sno ASC");
$trvl_day->execute(array($pln_id));
$row_trvl_day_main=$trvl_day->fetchAll();
$totalRows_trvl_day = $trvl_day->rowCount();
$r=1;
$trav_via_cit='-';
foreach($row_trvl_day_main as $row_trvl_day)
{
	if($row_trvl ['tr_date']==$row_trvl_day['tr_date'])
	{
		$day_cnt=$r;
		if(trim($row_trvl_day['via_cities'])!='' && trim($row_trvl_day['via_cities'])!='-')
		{
		$trav_via_cit=trim($row_trvl_day['via_cities']);
		}
	}
	$r++;
}
$tot_days=$r-1;

					if($row_tmaster['agent_id']!='-' && trim($row_tmaster['agent_id'])!='')
					{
						
						$agent = $conn->prepare("SELECT * FROM `agent_pro` WHERE agent_id=?");
						$agent->execute(array($row_tmaster['agent_id']));
						$row_agent =$agent->fetch(PDO::FETCH_ASSOC);
						$cname=$row_agent['agent_fname'].' '.$row_agent['agent_lname'];
						$cmobile=$row_agent['mobile_no'];
					}else{
						
						$distr = $conn->prepare("SELECT * FROM `distributor_pro` WHERE distr_id=?");
						$distr->execute(array($row_tmaster['distr_id']));
						$row_distr = $distr->fetch(PDO::FETCH_ASSOC);
						$cname="you ( ".$row_distr['distr_fname'].' '.$row_distr['distr_lname']." )";
						$cmobile="";
					}
?>
 <div class="modal-header bg-info no-border">
   <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
    <h5 class="modal-title" style="font-family:Verdana, Geneva, sans-serif; font-weight:600;"> <i class="fa fa-car"></i>
    <?php echo $row_tmaster['tr_name']; ?></h5>
    <label class="pull-right" style="margin-top:-21px;"> Contact No : <?php echo $row_tmaster['tr_mobile']; ?></label>
    </div>
     <div class="modal-body">
     <div class="row">
    		<div class="col-sm-12" style="border-bottom:1px #CCCCCC solid">
            <div class="col-sm-3" style="color:#C63; font-weight:600;">Date  (<?php echo "&nbsp;Day - &nbsp;".$day_cnt; ?> ):</div>
            <div class="col-sm-3" style="color:#339; font-weight:600;"><?php echo $row_trvl['tr_date']; ?></div>
             <div class="col-sm-3" style="color:#C63; font-weight:600;">Agent/Distr. Name :</div>
             <div class="col-sm-3" style="color:#339; font-weight:600;"><?php echo $cname; if($cmobile != ''){ echo "<br><i class='fa fa-mobile'></i> ".$cmobile; } ?></div>
            </div>
            <div class="col-sm-12" style="margin-top:10px; margin-bottom:10px;">
              <div class="col-sm-3" style="color:#C63; font-weight:600;">Travel Places :</div>
              <div class="col-sm-9" style="color:#339; font-weight:600;">
			  <?php
			   echo $row_trvl['tr_from_cityid']."</span>&nbsp;<i class='fa fa-long-arrow-right'></i>&nbsp;";
			  if(trim($trav_via_cit)!='-')
			  {
				  $via_cit_arr=explode('-',$trav_via_cit);
				  
				  for($u=0;$u<count($via_cit_arr);$u++)
				  {
					  		if($u!=0 && $u!=count($via_cit_arr)-1)
					  		{
						$viacit = $conn->prepare("SELECT * FROM `dvi_cities` WHERE id=?");
						$viacit->execute(array($via_cit_arr[$u]));
						$row_viacit = $viacit->fetch(PDO::FETCH_ASSOC);
						echo " <span style='color:rgb(72, 193, 240)'>".$row_viacit['name']."</span>&nbsp;<i class='fa fa-long-arrow-right'></i>&nbsp;";
							}
				  }
			  }
			  
			  echo $row_trvl['tr_to_cityid']; ?></div>
            </div>
            <div class="col-sm-12" style="margin-top:10px;margin-bottom:10px;">
              <div class="col-sm-3" style="color:#C63; font-weight:600;">Travelling Distance :</div>
              <div class="col-sm-3" style="color:#339; font-weight:600;"><?php echo $row_trvl['tr_dist_ss']." Kms"; ?></div>
             <div class="col-sm-3" style="color:#C63; font-weight:600;">Travelling Hours :</div>
             <div class="col-sm-3" style="color:#339; font-weight:600;"><?php echo $row_trvl['tr_time']; ?></div>
            </div>
            <div class="col-sm-12" style="margin-top:10px;margin-bottom:10px; ">
             <div class="col-sm-3" style="color:#C63; font-weight:600;">Total Pax Count :</div>
             <div class="col-sm-9" style="color:#339; font-weight:600;">
			 		<?php 
					echo $row_tmaster['pax_cnt']." &nbsp;&nbsp;[ Adults - ".$row_tmaster['pax_adults'].", Child(ren) - ".$row_tmaster['pax_512child'].", Baby - ". $row_tmaster['pax_child']." ]";
					?>
              </div>
            </div>
            <div class="col-sm-12" style="margin-top:10px;margin-bottom:10px; ">
             <div class="col-sm-3" style="color:#C63; font-weight:600;">Duration :</div>
             <div class="col-sm-9" style="color:#339; font-weight:600;">
			 		<?php 
					echo  $row_tmaster['tr_days']."&nbsp;Days&nbsp;/&nbsp;".$row_tmaster['tr_nights']."&nbsp;Nights";
					?>
              </div>
            </div>
            
            <div class="col-sm-12" style="margin-top:10px;margin-bottom:10px; border-bottom:1px #CCCCCC solid">
             <div class="col-sm-3" style="color:#C63; font-weight:600;">Vehicle Taken :</div>
             <div class="col-sm-9" style="color:#339; font-weight:600;">
			 		<?php 
					$veh_arr=explode(',',$row_tmaster['tr_vehids']);
					for($v=0;$v<count($veh_arr);$v++)
					{
						if($veh_arr[$v] != '')
						{
						
						$vehi = $conn->prepare("SELECT * FROM `vehicle_pro` WHERE vehi_id=?");
						$vehi->execute(array($veh_arr[$v]));
						$row_vehi = $vehi->fetch(PDO::FETCH_ASSOC);
						echo $row_vehi['vehicle_type']." - Seats [ ".$row_vehi['vehicle_seat']."]<br>";
						}
					}
					?>
              </div>
            </div>
 <?php
 
 if($_GET['pid1']=='TH')
{
 

$tstay = $conn->prepare("SELECT * FROM `stay_sched` WHERE status=0 and stay_id=? and sty_date=?");
$tstay->execute(array($pln_id,$datt));
$row_tstay = $tstay->fetch(PDO::FETCH_ASSOC);
$totalRows_tstay = $tstay->rowCount();

if($totalRows_tstay>0)
{

$hotel = $conn->prepare("SELECT * FROM `hotel_pro` WHERE hotel_id=?");
$hotel->execute(array($row_tstay['hotel_id']));
$row_hotel = $hotel->fetch(PDO::FETCH_ASSOC);
$totalRows_hotel = $hotel->rowCount();
 ?>           
            <div class="col-sm-12" style="margin-top:10px;margin-bottom:10px; ">
            <p style="font-size:14px; font-weight:600; color:#CCC; text-align:center">Hotel Information <?php echo " [ On ". $datt ." Stay ]"; ?></p>
            	<div class="col-sm-3"  style="color:#C63; font-weight:600;"> Hotel Name :</div>
                <div class="col-sm-9" style="color:#339; font-weight:600;"><?php echo $row_hotel['hotel_name']." Hotel";?></div>
            </div>
            <div class="col-sm-12" style="margin-top:10px;margin-bottom:10px;">
            	<div class="col-sm-3"  style="color:#C63; font-weight:600;"> Hotel Category :</div>
                <div class="col-sm-9" style="color:#339; font-weight:600;"><?php echo $row_hotel['category'];?></div>
            </div>
            <div class="col-sm-12" style="margin-top:10px;margin-bottom:10px;">
            	<div class="col-sm-3"  style="color:#C63; font-weight:600;"> Hotel Address :</div>
                <div class="col-sm-9" style="color:#339; font-weight:600;"><?php echo $row_hotel['location'];?></div>
            </div>
            
            <div class="col-sm-12" style="margin-top:10px;margin-bottom:10px;">
            	<div class="col-sm-3"  style="color:#C63; font-weight:600;"> Room Details :</div>
                <div class="col-sm-9" style="color:#339; font-weight:600;">
				<?php 
				$rrom=explode(',',$row_tstay['sty_room_name']);
									$rrom1=array_unique($rrom);
									$rrom2=array_count_values($rrom);
									
									for($tt=0;$tt<count($rrom1);$tt++)
									{
								/*	 
$query_hroom = "SELECT * FROM hotel_season where sno = '".$rrom1[$tt]."'";
$hroom = mysql_query($query_hroom, $divdb) or die(mysql_error());
$row_hroom = mysql_fetch_assoc($hroom);
$totalRows_hroom = mysql_num_rows($hroom);*/
if(isset($rrom1[$tt+1]) && $rrom1[$tt+1] !='')
{
	echo $rrom1[$tt]." - ".$rrom2[$rrom1[$tt]].",&nbsp;"; 
}else
{
	echo $rrom1[$tt]." - ".$rrom2[$rrom1[$tt]]; 
}
									}//for end
				?></div>
            </div>
            <?php }else{ 
							if($tot_days==$day_cnt)
							{?>
								<center><strong style="color:#933; font-size:12px">This itinerary will finish successully today.<br />[ This is the last day - hence no stay]</strong></center>
							<?php }
						}?>
            
            <?php }else {?>
            <center><strong style="color:#933; font-size:12px">* This is travel only itinerary. Stay not taken</strong></center>
            <?php }?>
            
     </div>
     </div>

<?php
}?>

<?php
//finding hotel
if(isset($_GET['type']) && $_GET['type']==2)
{ 

			 
						$tsched = $conn->prepare("SELECT * FROM `travel_sched` WHERE `tr_date`=? and `travel_id` IN (select plan_id from travel_master where status=0 and distr_id=?)");
						$tsched->execute(array($_GET['datt'],$_SESSION['uid']));
						//$row_tsched = mysql_fetch_assoc($tsched);
						$row_tsched_main=$tsched->fetchAll();
						$totalRows_tsched = $tsched->rowCount();
			 	 if($totalRows_tsched>0) {?>
<!--					<table class="table table-striped table-hover datatable-example dataTable" width="100%"  >
-->                    <thead style="background-color: #D8E9F9;color: rgb(76, 87, 123);">
                    <th width="15%">Plan Id</th>
                    <th width="23%">Client Name</th>
                    <th width="22%">Agnt./Distr. Name</th>
                    <th width="25%">Travelling Place</th>
                    <th width="15%">Details</th>
                    </thead>
                    <?php
					foreach($row_tsched_main as $row_tsched)
					{
					
					
					
						$tmaster = $conn->prepare("SELECT * FROM `travel_master` WHERE status=0 and `plan_id`=?");
						$tmaster->execute(array($row_tsched['travel_id']));
						$row_tmaster = $tmaster->fetch(PDO::FETCH_ASSOC);
						$totalRows_tmaster = $tmaster->rowCount();
						
					$via_cit='-';
					if(trim($row_tsched['via_cities'])!='' && trim($row_tsched['via_cities'])!='-')
					{
						$via_cit=explode('-',trim($row_tsched['via_cities']));
					}
					
					 ?>
                    <tr>
                    <td style="background-color: aliceblue;"><?php echo $row_tmaster['plan_id']; ?></td>
                    <td><?php echo $row_tmaster['tr_name']; ?></td>
                    <td><?php
					$mobile='';
					if($row_tmaster['agent_id']!='-' && trim($row_tmaster['agent_id'])!='')
					{
						
						$agent = $conn->prepare("SELECT * FROM `agent_pro` WHERE agent_id=?");
						$agent->execute(array($row_tmaster['agent_id']));
						$row_agent = $agent->fetch(PDO::FETCH_ASSOC);
						$cname=$row_agent['agent_fname'].' '.$row_agent['agent_lname'];
						$mobile='<i class="fa fa-phone"></i> &nbsp;'.$row_agent['mobile_no'];
					}else{
						
						$distr = $conn->prepare("SELECT * FROM `distributor_pro` WHERE distr_id=?");
						$distr->execute(array($row_tmaster['distr_id']));
						$row_distr = $distr->fetch(PDO::FETCH_ASSOC);
						//$cname=$row_distr['distr_fname'].' '.$row_distr['distr_lname'];
						$cname =" You ( ".$row_distr['distr_fname'].' '.$row_distr['distr_lname']." )";
						$mobile='<i class="fa fa-phone"></i> &nbsp;'.$row_distr['mobile_no'];
					}
					
					echo "<span data-toggle='tooltip' data-html='true' title='".$mobile."'>".$cname."</span>" ; ?></td>
                     <td>
                     <?php
					     $via_cit_str='';
					 if($via_cit!='')
					 {
						for($u=0;$u<count($via_cit);$u++)
				  		{
							if($u!=0 && $u!=count($via_cit)-1)
					  		{
								$viacit = $conn->prepare("SELECT * FROM `dvi_cities` WHERE id=?");
								$viacit->execute(array($via_cit[$u]));
								$row_viacit =$viacit->fetch(PDO::FETCH_ASSOC);
									
								if($via_cit_str=='')
								{
										$via_cit_str=$row_viacit['name'];
								}else{
										$via_cit_str=$via_cit_str.' - '.$row_viacit['name'];
								}
							}
				  		} 
					 }
					 
					 if($via_cit_str!='')
					 {
							echo $row_tsched['tr_from_cityid']."&nbsp;<i class='fa fa-long-arrow-right' data-toggle='tooltip' title='".$via_cit_str."'></i>&nbsp;".$row_tsched['tr_to_cityid'];
					 }else{
						 echo $row_tsched['tr_from_cityid']."&nbsp;<i class='fa fa-long-arrow-right' data-toggle='tooltip' title='No via chosen'></i>&nbsp;".$row_tsched['tr_to_cityid'];
					 }
					 
           // echo $row_tsched['tr_from_cityid']."&nbsp;<i class='fa fa-long-arrow-right'></i>&nbsp;".$row_tsched['tr_to_cityid'];
                     ?>
                     </td>
                    <td>
                <?php $plan_arr=explode('#',$row_tmaster['plan_id']); ?>
                    <a href="#travel_info<?php echo $plan_arr[0]."_".$plan_arr[1]; ?>"  title="Travel status" data-toggle='modal' class="btn btn-primary active btn-sm "  onclick="travel_fun('<?php echo $plan_arr[0]; ?>','<?php echo $plan_arr[1]; ?>')" >View Details</a></td>
                   
                    </tr>
                    <?php 
						}//while end ?>
                  
                  <!--  </table>-->
                    <?php }else{?>
                   <tr><td colspan="5" width="100%">
                    <center><strong style="color:#CCC; font-weight:600">No Travel Activities For This Day</strong></center></td></tr>
                    <?php }
}

if(isset($_GET['type']) && $_GET['type']==3)
{
$checking;
 $email_var=trim($_GET['email']);
	
	//$query_email_agt = "SELECT * FROM  agent_pro where email_id='$email_var' and status < 2";
	$email_agt = $conn->prepare("SELECT * FROM  agent_pro where email_id=? ");
	$email_agt->execute(array($email_var));
	$totalRows_email_agt = $email_agt->rowCount();
	
	if($totalRows_email_agt==0)
	{
		
		// $query_email_dst = "SELECT * FROM  distributor_pro where email_id='$email_var' and status < 2";
		  $email_dst = $conn->prepare("SELECT * FROM  distributor_pro where email_id=? ");
		$email_dst->execute(array($email_var));
		$totalRows_email_dst = $email_dst->rowCount();
		if($totalRows_email_dst==0)
		{
			$checking='yes'; //allow to proceed
		}else{
			$checking='no'; //not llow to proceed
		}
	}else{
	$checking='no'; // not allow to proceed	
	}
	echo $checking;
}


if(isset($_GET['type']) && $_GET['type']==4)//removing agent details
{
	
	
$agentpro = $conn->prepare("SELECT * FROM agent_pro where distr_id =? and sno =?");
$agentpro->execute(array($_SESSION['uid'],$_GET['sno']));
$row_agentpro = $agentpro->fetch(PDO::FETCH_ASSOC);
$totalRows_agentpro =$agentpro->rowCount();
$rem_agnt=$row_agentpro['agent_fname'].' '.$row_agentpro['agent_lname'];


	
$distrpro = $conn->prepare("SELECT * FROM distributor_pro where distr_id =?");
$distrpro->execute(array($_SESSION['uid']));
$row_distrpro = $distrpro->fetch(PDO::FETCH_ASSOC);
$totalRows_distrpro = $distrpro->rowCount();

$dis=$row_distrpro['distr_fname'].' '.$row_distrpro['distr_lname'];
	//mail config - start
	
		$stringData ="<html><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Agent removed by distributor</title></head><body><table width='90%' border='0' align='center' cellpadding='2' cellspacing='3';>  <tr>    <td colspan='3' style='font-family: Arial, Helvetica, sans-serif;	font-size: 24px;	font-weight: bold;	color: #960;'><span style='margin-top:20px; padding-top:30px'>Agent removed by distributor! </span></td><td width='1%' rowspan='4' align='center' valign='middle'>&nbsp;</td></tr><tr align='center'><td height='4' colspan='4' style='border-bottom: solid #ccc 2px; float:left; width:100%;'> </td></tr><tr><td colspan='4'><table width='100%' border='0' cellpadding='3' cellspacing='4' style='border:1px solid #eeeeee; background-color: #FAFAFA'><tr><td colspan='3'><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;	font-weight: bold;	color: #000000;'><span style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 16px;	font-weight: bold;	color: #000000; padding-left:20px;'>Dear Administrator,<span style='font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 16px;	font-weight: bold;	color: green;'></span></span></p></td></tr><tr> <td width='7%'></td><td width='83%'><p><span style='color:blue'> ".$rem_agnt." (Agent) removed by ".$dis." ( distributor )</span><br> </p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;font-size: 14px;color: #000000;'> With Regards,<br/><img src='images/logo2.png'/>&nbsp;</p><table style='font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;'><tr><td width='244'>[DVI Administrator]</td></tr><tr><td>DoView Holidays India Pvt. Ltd.</td></tr></table>&nbsp;</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;font-size: 12px; font-weight: bold; color: '#CC6600;'></p></td><td width='10%'>&nbsp;</td></tr><tr><td height='26'>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></table></td></tr><tr><td colspan='4'><span style='font-family: Arial, Helvetica, sans-serif;	font-size: 11px;	font-weight: normal;	color: #000000;'>Questions? Go to the Help Centre at: </span><a href='http://dvi.co.in' style='font-family: Arial, Helvetica, sans-serif;	font-size: 11px;	font-weight: normal;  color: #000000;'>DoView Holidays</a><br /><span style='font-family: Arial, Helvetica, sans-serif;	font-size: 12px; font-weight: bold;	color: #000000;'>Copyright &copy; ".$yy." DoView Holidays (India) Private Limited. All rights reserved.</span></td></tr></table></body></html>";
	
	$to = 'vsr@v-i.in';
	$from = "DO VIEW HOLIDAYS INDIA PVT. LTD."; 
	$subject="Message from dvi.co.in";
	$str=send_mail($to,$from,$subject,$stringData);
	
	$SQL=$conn->prepare("UPDATE agent_pro set status='2' WHERE agent_id=? and  sno =?");
	$SQL->execute(array($row_agentpro['agent_id'],$_GET['sno']));
	
	/*$SQL="DELETE From agent_pro  WHERE agent_id='".$row_agentpro['agent_id']."' and  sno ='".$_GET['sno']."'";
	
	$Delete = mysql_query($SQL, $divdb) or die(mysql_error());*/
	
	$SQL1=$conn->prepare("DELETE From login_secure  WHERE uid =?");
	$SQL1->execute(array($row_agentpro['agent_id']));
	
	if(trim($_GET['pic'])!='default.jpg')
	{
	unlink('../img_upload/agent_img/'.$_GET['pic']);
	}
	
}
?>