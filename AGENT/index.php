<?php
require_once('Connections/divdb.php');


				$foryou = $conn->prepare("SELECT * FROM agent_pro where agent_id=?");
				$foryou->execute(array($_SESSION['uid']));
				$row_foryou = $foryou->fetch(PDO::FETCH_ASSOC);
				$totalRows_foryou = $foryou->rowCount();

$timezone = new DateTimeZone("Asia/Kolkata" );
  $date = new DateTime();
  $date->setTimezone($timezone );
  $mm=$date->format('m');
  $mm1=$date->format('M');
  $yy=$date->format('Y');
  $dd=$date->format('d');
  $time=date("H:i:s");
  $today=date("d-M-Y");
  $ctoday=date("Y-m-d");
?>
<style>
.loader_ax{
position: fixed;
left: 0px;
top: 0px;
width: 100%;
height: 100%;
z-index: 9999;
background: url('images/ajax_loader.gif') center no-repeat ;
background-size:120px;
background-color:rgba(0, 0, 0, 0.5);
}
</style>

<div class="page-content">
				<div class="container-fluid">
				
                
 <div class="modal fade travel_mod"  tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog" style="width:65%">
<div class="modal-content modal-no-shadow modal-no-border" id="model_travel_ajax">
   
<!-- update - model -->
</div> 
</div> 
</div>
                
				<!-- Begin page heading -->
				<h1 class="page-heading">DASHBOARD</h1>
				<!-- End page heading -->
                <?php if(trim($row_foryou['bank_addr'])=='' || trim($row_foryou['bank_acc_no'])=='' || trim($row_foryou['bank_ifsc_code'])=='')
				{?>
				<div class="alert alert-warning fade in alert-dismissable">
								  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								  <strong>Warning!</strong> Your banking details need to be update for your future use..
								  &nbsp;&nbsp;&nbsp;&nbsp;<a  class="profile_edit" href="<?php echo $_SESSION['grp']; ?>/profile.php?uid=<?php echo $row_foryou['agent_id']; ?>&group=AGENT" >Click To Update</a>
                                  
				</div>
                <?php }else if(trim($row_foryou['comp_logo'])=='' || trim($row_foryou['busi_volume'])=='')
				{?>
				<div class="alert alert-warning fade in alert-dismissable">
								  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								  <strong>Warning!</strong> Your company logo and business-volume need to be update for your future use..
								  &nbsp;&nbsp;&nbsp;&nbsp;<a href="agent_mysetting.php?mm=f4f70727dc34561dfde1a3c529b6205c&sm=cd644c5acaeb439cd313f9a46b3e0dc6" >Click To Update</a>
                                  
				</div>
                <?php } ?> 
					<!-- BEGIN EXAMPLE ALERT -->
					<div class="alert alert-warning alert-bold-border fade in alert-dismissable">
					  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					  <p><strong>Welcome! <?php // echo $_SESSION['grp'];?></strong></p>
					  <p class="text-muted">You probably can view all your quick reports below! <i class="fa fa-smile-o"></i></p>
					</div>
					<!-- END EXAMPLE ALERT -->
				<?php
				
				$itins = $conn->prepare("SELECT * FROM travel_master where agent_id=?");
				$itins->execute(array($_SESSION['uid']));
				$row_itins = $itins->fetch(PDO::FETCH_ASSOC);
				$totalRows_itins = $itins->rowCount();
				
				
				$aitins = $conn->prepare("SELECT * FROM travel_master where agent_id=? and status = 0");
				$aitins->execute(array($_SESSION['uid']));
				$row_aitins = $aitins->fetch(PDO::FETCH_ASSOC);
				$totalRows_aitins =$aitins->rowCount();
				
				
				$ritins = $conn->prepare("SELECT * FROM travel_master where agent_id=? and status = 1");
				$ritins->execute(array($_SESSION['uid']));
				$row_ritins = $ritins->fetch(PDO::FETCH_ASSOC);
				$totalRows_ritins = $ritins->rowCount();
				
				
				$witins = $conn->prepare("SELECT * FROM travel_master where agent_id=? and status = 2");
				$witins->execute(array($_SESSION['uid']));
				$row_witins = $witins->fetch(PDO::FETCH_ASSOC);
				$totalRows_witins =$witins->rowCount();
				
				
				$mpitins = $conn->prepare("SELECT * FROM travel_master where agent_id=? and status = 4");
				$mpitins->execute(array($_SESSION['uid']));
				$row_mpitins = $mpitins->fetch(PDO::FETCH_ASSOC);
				$totalRows_mpitins = $mpitins->rowCount();
				?>
					
					<!-- BEGIN SiTE INFORMATIONS -->
					<div class="row">
						<div class="col-sm-3">
							<div class="the-box no-border bg-success tiles-information" style="background-color:#A0BB92">
								<i class="fa fa-users icon-bg"></i>
								<div class="tiles-inner text-center">
									<p style="color:#000">MY TOTAL ITINERARIES</p>
									<h3 class="bolded"><strong><?php echo $totalRows_itins; ?></strong></h3> 
									<div class="progress no-rounded progress-xs">
									  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
									  </div><!-- /.progress-bar .progress-bar-success -->
									</div><!-- /.progress .no-rounded -->
									
								</div><!-- /.tiles-inner -->
                                <div class="row" style="background-color:transparent" align="center">
                                <div class="col-sm-3">
                                    <i data-toggle="tooltip" data-html="true" title="My pending approval(s) - <?php echo $totalRows_mpitins; ?>" class="fa fa-dashboard fa-fw icon-circle icon-bordered icon-xs icon-dark" style=" color: #00F"></i>
                                    </div>
                                    
                                <div class="col-sm-3">
									<i data-toggle="tooltip" data-html="true" title="Admin approved - <?php echo $totalRows_aitins; ?>" class="fa fa-thumbs-o-up fa-fw icon-circle icon-bordered icon-xs icon-dark" style=" color:#434A54"></i>
                                    </div>
                                    <div class="col-sm-3">
                                    <i data-toggle="tooltip" data-html="true" title="Admin pending approval - <?php echo $totalRows_witins; ?>" class="fa fa-clock-o fa-fw icon-circle icon-bordered icon-xs icon-dark" style=" color: #00F"></i>
                                    </div>
                                    
                                    <div class="col-sm-3">
									<i data-toggle="tooltip" data-html="true" title="Admin rejected - <?php echo $totalRows_ritins; ?>" class="fa fa-thumbs-o-down fa-fw icon-circle icon-bordered icon-xs icon-dark" style=" color:#F00"></i>
                                    </div>
								</div>
							</div><!-- /.the-box no-border -->
						</div><!-- /.col-sm-3 -->
                        
                         <?php
					
					$colls = $conn->prepare("SELECT SUM(agnt_grand_tot) as gr_tot FROM travel_master where agent_id=? and status = 0");
					$colls->execute(array($_SESSION['uid']));
					$row_colls = $colls->fetch(PDO::FETCH_ASSOC);
					$totalRows_colls = $colls->rowCount();
					
					$cur_mnth = date('m');
					$cur_yr = date('Y');
					
					$mcolls = $conn->prepare("SELECT SUM(agnt_grand_tot) as gr_tot FROM travel_master where agent_id=? and SUBSTR(date_of_reg,6,2) =? and status = 0");
					$mcolls->execute(array($_SESSION['uid'],$cur_mnth));
					$row_mcolls = $mcolls->fetch(PDO::FETCH_ASSOC);
					$totalRows_mcolls = $mcolls->rowCount();
					
					
					$ycolls = $conn->prepare("SELECT SUM(agnt_grand_tot) as gr_tot FROM travel_master where agent_id=? and SUBSTR(date_of_reg,1,4) =? and status = 0");
					$ycolls->execute(array($_SESSION['uid'],$cur_yr));
					$row_ycolls = $ycolls->fetch(PDO::FETCH_ASSOC);
					$totalRows_ycolls = $ycolls->rowCount();
					
					if ($row_colls['gr_tot'] > 10000000)
					{
						$gtot_k = (float)(round($row_colls['gr_tot']) / 10000000);
						$gtot_k1 = number_format($gtot_k, 2, '.', '').'Cr';
					}else if ($row_colls['gr_tot'] > 100000)
					{
						$gtot_k = (float)(round($row_colls['gr_tot']) / 100000);
						$gtot_k1 = number_format($gtot_k, 2, '.', '').'L';
					}else if($row_colls['gr_tot'] > 1000)
					{
						$gtot_k = (float)(round($row_colls['gr_tot']) / 1000);
						$gtot_k1 = number_format($gtot_k, 2, '.', '').'K';
					}
					else
					{
						$gtot_k = $row_colls['gr_tot'];
						$gtot_k1 = number_format($row_colls['gr_tot'], 2, '.', '');
					}
					?>
						<div class="col-sm-3">
							<div class="the-box no-border bg-info tiles-information" style="background-color:#69ACC5">
								<i class="fa fa-shopping-cart icon-bg"></i>
								<div class="tiles-inner text-center">
									<p style="color:#000">TOTAL COLLECTION</p>
									<h3 class="bolded">&#8377 <?php if ($row_colls['gr_tot'] == '') echo '0'; else echo $gtot_k1; //echo round($row_colls['gr_tot']); ?></h3> 
									<div class="progress no-rounded progress-xs">
									  <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
									  </div><!-- /.progress-bar .progress-bar-primary -->
									</div><!-- /.progress .no-rounded -->
									
								</div><!-- /.tiles-inner -->
                                
                                <div class="row" style="background-color:transparent" align="center">
                                <div class="col-sm-6">
                                    <i data-toggle="tooltip" data-html="true" title="This month - &#8377 <?php if ($row_mcolls['gr_tot'] == '') echo '0'; else echo $row_mcolls['gr_tot']; ?>" class="fa fa-money fa-fw icon-circle icon-bordered icon-xs icon-dark" style=" color:#C96"></i>
                                    </div>
                                
                                    <div class="col-sm-6">
                                    <i data-toggle="tooltip" data-html="true" title="This year - &#8377 <?php if ($row_ycolls['gr_tot'] == '') echo '0'; else echo $row_ycolls['gr_tot']; ?>" class="fa fa-inr fa-fw icon-circle icon-bordered icon-xs icon-dark" style=" color: #00F"></i>
                                    </div>
								</div>
                                
							</div><!-- /.the-box no-border -->
						</div><!-- /.col-sm-3 -->
                        
                        <?php
						
						//$query_prof = "SELECT SUM((agent_perc/100)*(grand_tot+((agnt_adm_perc/100)*grand_tot))) as agr_tot FROM travel_master where agent_id='".$_SESSION['uid']."' and status = 0";
						$prof = $conn->prepare("SELECT sum((agent_perc/100)*(grand_tot)) as agr_tot FROM travel_master where agent_id=? and status = '0' " );
						$prof->execute(array($_SESSION['uid']));
						$row_prof = $prof->fetch(PDO::FETCH_ASSOC);
						$totalRows_prof = $prof->rowCount();

						
						//$query_mprof = "SELECT SUM((agent_perc/100)*(grand_tot+((agnt_adm_perc/100)*grand_tot))) as agr_tot FROM travel_master where agent_id='".$_SESSION['uid']."' and SUBSTR(date_of_reg,6,2) = '$cur_mnth' and status = 0";
						$mprof = $conn->prepare("SELECT SUM((agent_perc/100)*(grand_tot)) as agr_tot FROM travel_master where agent_id=? and SUBSTR(date_of_reg,6,2) =? and status = '0'");
						$mprof->execute(array($_SESSION['uid'],$cur_mnth));
						$row_mprof = $mprof->fetch(PDO::FETCH_ASSOC);
						$totalRows_mprof =$mprof->rowCount();
						
						
						//$query_yprof = "SELECT SUM((agent_perc/100)*(grand_tot+((agnt_adm_perc/100)*grand_tot))) as agr_tot FROM travel_master where agent_id='".$_SESSION['uid']."' and SUBSTR(date_of_reg,1,4) = '$cur_yr' and status = 0";
						$yprof = $conn->prepare("SELECT SUM((agent_perc/100)*(grand_tot)) as agr_tot FROM travel_master where agent_id=? and SUBSTR(date_of_reg,1,4) =? and status = '0'");
						$yprof->execute(array($_SESSION['uid'],$cur_yr));
						$row_yprof = $yprof->fetch(PDO::FETCH_ASSOC);
						$totalRows_yprof = $yprof->rowCount();
						
						
					if ($row_prof['agr_tot'] > 10000000)
					{
						$gtot_pfk = (float)(round($row_prof['agr_tot']) / 10000000);
						$gtot_pfk1 = number_format($gtot_pfk, 2, '.', '').'Cr';
					}else if ($row_prof['agr_tot'] > 100000)
					{
						$gtot_pfk = (float)(round($row_prof['agr_tot']) / 100000);
						$gtot_pfk1 = number_format($gtot_pfk, 2, '.', '').'L';
					}else if($row_prof['agr_tot'] > 1000)
					{
						$gtot_pfk = (float)(round($row_prof['agr_tot']) / 1000);
						$gtot_pfk1 = number_format($gtot_pfk, 2, '.', '').'K';
					}
					else
					{
						$gtot_pfk = $row_prof['agr_tot'];
						$gtot_pfk1 = number_format($row_prof['agr_tot'], 2, '.', '');
					}
						?>
						<div class="col-sm-3">
							<div class="the-box no-border bg-primary tiles-information" style="background-color:#66BBA6">
								<i class="fa fa-comments icon-bg"></i>
								<div class="tiles-inner text-center">
									<p style="color:#000">PROFIT</p>
									<h3 class="bolded">&#8377 <?php echo $gtot_pfk1; //echo round($row_prof['agr_tot']); ?></h3> 
									<div class="progress no-rounded progress-xs">
									  <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
									  </div><!-- /.progress-bar .progress-bar-danger -->
									</div><!-- /.progress .no-rounded -->
									
								</div><!-- /.tiles-inner -->
                                <div class="row" style="background-color:transparent" align="center">
                                <div class="col-sm-6">
                                    <i data-toggle="tooltip" data-html="true" title="This month - &#8377 <?php if ($row_mprof['agr_tot'] == '') echo '0'; else echo round($row_mprof['agr_tot']); ?>" class="fa fa-money fa-fw icon-circle icon-bordered icon-xs icon-dark" style=" color:#C96"></i>
                                    </div>
                                
                                    <div class="col-sm-6">
                                    <i data-toggle="tooltip" data-html="true" title="This year - &#8377 <?php if ($row_yprof['agr_tot'] == '') echo '0'; else echo round($row_yprof['agr_tot']); ?>" class="fa fa-inr fa-fw icon-circle icon-bordered icon-xs icon-dark" style=" color: #00F"></i>
                                    </div>
								</div>
							</div><!-- /.the-box no-border -->
						</div><!-- /.col-sm-3 -->
                        <?php
						
						$spots = $conn->prepare("SELECT * FROM hotspots_pro where status = '0'");
						$spots->execute();
						//$row_spots = mysql_fetch_assoc($spots);
						$totalRows_spots =$spots->rowCount();
						
						
						$spotsgrp = $conn->prepare("SELECT * FROM hotspots_pro where status = '0' and trim(spot_city)!='' GROUP BY spot_city");
						$spotsgrp->execute();
						//$row_spotsgrp = mysql_fetch_assoc($spotsgrp);
						$row_spotsgrp_main=$spotsgrp->fetchAll();
						$totalRows_spotsgrp = $spotsgrp->rowCount();
						?>
						<div class="col-sm-3">
							<div class="the-box no-border bg-warning tiles-information" style="background-color:#E6C37A">
								<i class="fa fa-money icon-bg"></i>
								<div class="tiles-inner text-center">
									<p>HOT SPOTS</p>
									<h3 class="bolded"><?php echo $totalRows_spots; ?></h3> 
									<div class="progress no-rounded progress-xs">
									  <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
									  </div><!-- /.progress-bar .progress-bar-warning -->
									</div><!-- /.progress .no-rounded -->
									<table width="100%">
                                    <tr>
                                    <td width="80%"><select name="city_selt" id="city_selt" class="form-control" style="background-color:#F9E6BD; color:#6D4106; font-weight:600" >
                                    <option value="-" selected="selected">Select City</option>
                                    <?php foreach($row_spotsgrp_main as $row_spotsgrp)
									{
										
										$spotsgrpct = $conn->prepare("SELECT * FROM dvi_cities where id =?");
										$spotsgrpct->execute(array($row_spotsgrp['spot_city']));
										$row_spotsgrpct =$spotsgrpct->fetch(PDO::FETCH_ASSOC);
										?>
                                    <option value="<?php echo $row_spotsgrpct['id']; ?>"><?php echo $row_spotsgrpct['name']; ?></option>
                                    <?php } ?>
                                    </select></td>
                                    <td width="20%">
                                    <a id="hotspot_city" class=" btn  btn-warning" onclick="fn_city()" ><i class="fa fa-search"></i></a>
                                    </td></tr>
                                    </table>
                                    
								</div><!-- /.tiles-inner -->
							</div><!-- /.the-box no-border -->
						</div><!-- /.col-sm-3 -->
					</div><!-- /.row -->
					<!-- END SITE INFORMATIONS -->
				
					
					<div class="row">
						<div class="col-lg-12">
							
							<!-- BEGIN CHART WIDGET 1 -->
							<div class="panel panel-info panel-no-border panel-square">
							  <div class="panel-heading" style=" background-color:#CEAE7E; border-color:#694B27">
								<!--<div class="right-content">
									<div class="btn-group">
										<button class="btn btn-info btn-sm active">
										Lifetime
										</button>
										<button class="btn btn-info btn-sm">
										This year
										</button>
									</div>
								</div>-->
								<h3 class="panel-title" style="text-align:center; color:#4E3D1C; font-weight:600">Total Collection </h3>
							  </div><!-- /.panel-heading -->
                              
                                             <?php 
   
   
 $years = $conn->prepare("select * from travel_master where status=0 and agent_id=? GROUP BY substr(date_of_reg,1,4) ORDER BY sno DESC");
$years->execute(array($_SESSION['uid']));
//$row_years = mysql_fetch_assoc($years);
$totalRows_years = $years->rowCount(); 

//$yearcoll='';
$yearcoll=array();;
$all_years=array();
for($y=0;$y<$totalRows_years;$y++)  
{ 
$row_years = $years->fetch(PDO::FETCH_ASSOC);

$collection = $conn->prepare("SELECT SUM(grand_tot) AS sum_gt FROM `travel_master` WHERE status='0' and substr(date_of_reg,1,4)=?,0,4) and agent_id=?");
$collection->execute(array(substr($row_years['date_of_reg'],$_SESSION['uid'])));
$row_collection = $collection->fetch(PDO::FETCH_ASSOC);

		$yearcoll[$y]=round($row_collection['sum_gt']);
		$all_years[$y]=substr($row_years['date_of_reg'],0,4);
}

//print_r($yearcoll);
//print_r($all_years);
   ?>
                              
								<div class="the-box no-border full no-margin">
									<div class="the-box no-border bg-info no-margin full" style="background-color:#FBF1E7">
										<!--<div id="morris-widget-1" style="height: 250px;"></div>-->
                                        <div id="morris-widget-22" style="height: 250px;color:#FFF"></div>
									</div><!-- the-box no-border bg-info no-margin full -->
									<div class="the-box no-border  no-margin chart-des">
										<div class="row">
											<div class="col-xs-7">
												<h4 class="bolded" style="color:#967C5A">THIS YEAR COLLECTION</h4>
												<p>Today <?php echo $today; ?></p>
											</div><!-- /.col-xs-7 -->
											<div class="col-xs-5 text-right">
												<h4 class="bolded text-success" style="color:#967C5A">Rs.<?php if(isset($yearcoll[0])){ echo number_format($yearcoll[0]); }else { echo "0"; } ?></h4>
												
											</div><!-- /.col-xs-5 -->
										</div><!-- /.row -->
									</div><!-- the-box no-border bg-dark no-margin -->
								</div><!-- /.the-box no-border .full -->
							</div><!-- /.the-box no-border .full -->
						</div><!-- /.col-sm-8 -->
					</div><!-- /.row -->
			
            <!-- log start -->
	         <div class="the-box no-border" id="log_active">
             <?php
			 			
					 	$tsched = $conn->prepare("SELECT * FROM `travel_sched` WHERE `tr_date`=CURDATE() and `travel_id` IN (select plan_id from travel_master where status=0 and agent_id=?)");
						$tsched->execute(array($_SESSION['uid']));
						//$row_tsched = mysql_fetch_assoc($tsched);
						$row_tsched_main=$tsched->fetchAll();
						$totalRows_tsched = $tsched->rowCount();
			 	
					?>   
           <table width="100%"><tr>
           <td width="35%" align="left"><label class="btn btn-warning"><span id="tdate" ><?php echo $today." [ Today ]"; ?></span>
           <input type="hidden" id="cdate" name="cdate" value="<?php echo $ctoday; ?>"/></label></td>
           <td width="30%" align="center"><strong style="color:#999; font-size:16px; font-weight:600">Activity Log</strong></td>
           <td width="35%" align="right">
          <input type="text" class="dp" placeholder="click to see status" id="example1"></td></tr></table>
           <br />
           <?php if($totalRows_tsched>0) {?>
					<table class="table table-striped table-hover datatable-example dataTable" width="100%" id="log_table">
                    <thead style="background-color: #D8E9F9;color: rgb(76, 87, 123);">
                    <th width="15%">Plan Id</th>
                    <th width="33%">Client Name</th>
                    <th width="35%">Travelling Place</th>
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
								$row_viacit = $viacit->fetch(PDO::FETCH_ASSOC);
									
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
                     ?>
                     </td>
                    <td>
                <?php $plan_arr=explode('#',$row_tmaster['plan_id']); ?>
                    <a href="#travel_info<?php echo $plan_arr[0]."_".$plan_arr[1]; ?>"  title="Travel status" data-toggle='modal' class="btn btn-primary active btn-sm "  onclick="travel_fun('<?php echo $plan_arr[0]; ?>','<?php echo $plan_arr[1]; ?>')" >View Details</a></td>
                   
                    </tr>
                    <?php 
						}//while end ?>
                  
                    </table>
                    <?php }else{?>
                   <table class="table table-striped table-hover datatable-example dataTable " width="100%" id="log_table">
                    <tr><td width="100%">
                    <center><strong style="color:#CCC; font-weight:600">No Travel Activities Today</strong></center>
                    </td>
                    </tr>
                    </table>
                    <?php }?>
            </div>
            
            <!-- log end -->
            

					<!-- BEGIN CAROUSEL ITEM -->
                     <?php
						
						$spots = $conn->prepare("SELECT * FROM hotspots_pro where spot_images!='' and status = 0 ORDER BY RAND() LIMIT 20");
						$spots->execute();
						$row_spots_main = $spots->fetchAll();
						$totalRows_spots = $spots->rowCount();
					?>
					<div class="the-box no-border">
					<h4 class="small-heading more-margin-bottom text-center">Travel Hot spots</h4>
						<div id="store-item-carousel-3" class="owl-carousel shop-carousel">
                        <?php
						foreach($row_spots_main as $row_spots)
						{
							$imgexp = explode(',',$row_spots['spot_images']);
							
							
							$city = $conn->prepare("SELECT * FROM dvi_cities where id=? and status = 0 ORDER BY RAND() LIMIT 25");
							$city->execute(array($row_spots[spot_city]));
							$row_city = $city->fetch(PDO::FETCH_ASSOC);
							$totalRows_city =$city->rowCount();
							
							if ($totalRows_city > 0)
							{
						?>
							<div class="item">
								<div class="media">
									<a class="pull-left show_hotss" href="<?php echo $_SESSION['grp'];?>/hotspot_images.php?sid=<?php echo $row_spots['hotspot_id']; ?>">
								 <img class="media-object sm" src="img_upload/hot_spots/<?php echo $imgexp[0]; ?>" width="80" height="80" alt="Image">
									</a>
									<div class="media-body">
									  <h4 class="media-heading"><a class="show_hotss" href="<?php echo $_SESSION['grp'];?>/hotspot_images.php?sid=<?php echo $row_spots['hotspot_id']; ?>"><?php echo $row_spots['spot_name']; ?> </a></h4>
									  <p class="brand"><?php echo $row_city['name']; ?></p>
									</div>
								</div>
							</div>
                            <?php
							}
						} 
						?>
						</div><!-- /#store-item-carousel-1 -->
					</div><!-- /.the-box .no-border -->
				</div><!-- /.container-fluid -->
             </div>

<script>

$(document).ready(function(e) {
    $('.chosen-select').chosen({width:'100%'});
});

function travel_fun(p0id,p1id)
{
	var ty=1;
	var datt=$('#cdate').val();
	$('.loader_ax').fadeIn();
	$.get('<?php echo $_SESSION['grp']; ?>/ajax_log.php?type='+ty+'&pid1='+p0id+'&pid2='+p1id+'&datt='+datt,function(result){
		$('.loader_ax').fadeOut(500);
		$('#model_travel_ajax').empty().html(result);
		});
	$('.travel_mod').attr('id','travel_info'+p0id+'_'+p1id);
}

function fn_city()
{
	var cid=$('#city_selt').val().trim();
	if(cid!='-')
	{
		$('#hotspot_city').addClass('add_host4');
		$('#hotspot_city').attr('href','AGENT/view_img_desc.php?cid='+cid);
	}else{
		alert('Please select any city ..');
		$('#hotspot_city').removeClass('add_host4');
		$('#hotspot_city').removeAttr('href');
	}
}

/*    $('#example1').datepicker({
        format: "yyyy-mm-dd"
    });

    $('.dp').on('changeDate', function () {
        $('.datepicker').hide();
		
		var datt=$('.dp').val();
		$('#cdate').val(datt);
		$('#tdate').empty().prepend(datt);
		$.get('<?php //echo $_SESSION['grp']; ?>/ajax_log.php?type=2&datt='+datt,function(result){
			//alert(result);
		$('#log_table').empty().html(result);
		$('#example1').datepicker({format: "yyyy-mm-dd"});
		});
    });*/

</script>              