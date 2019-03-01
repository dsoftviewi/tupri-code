<?php
if(isset($_GET['older']) && $_GET['older']=='yes'){
	$orders = $conn->prepare("SELECT * FROM travel_master where sub_paln_id!=''  ORDER BY sno DESC");
}else{
	$orders = $conn->prepare("SELECT * FROM travel_master where sub_paln_id!='' ORDER BY sno DESC LIMIT 100");	
}
$orders->execute();
$row_orders_main = $orders->fetchAll();
$totalRows_orders = $orders->rowCount();


if(isset($_GET['older']) && $_GET['older']=='yes'){
	$thorders = $conn->prepare("SELECT * FROM travel_master where SUBSTR(plan_id,1,2) = 'TH' and sub_paln_id!='' ORDER BY sno DESC");
}else{
	$thorders = $conn->prepare("SELECT * FROM travel_master where SUBSTR(plan_id,1,2) = 'TH' and sub_paln_id!='' ORDER BY sno DESC LIMIT 50");	
}
$thorders->execute();
$row_thorders_main = $thorders->fetchAll(); 
$totalRows_thorders = $thorders->rowCount();

if(isset($_GET['older']) && $_GET['older']=='yes'){
	$torders = $conn->prepare("SELECT * FROM travel_master where SUBSTR(plan_id,1,2) = 'T#' and sub_paln_id!='' ORDER BY sno DESC");
}else{
	$torders = $conn->prepare("SELECT * FROM travel_master where SUBSTR(plan_id,1,2) = 'T#' and sub_paln_id!='' ORDER BY sno DESC LIMIT 50");	
}
$torders->execute();
$row_torders_main = $torders->fetchAll(); 
$totalRows_torders = $torders->rowCount();


if(isset($_GET['older']) && $_GET['older']=='yes'){
	$horders = $conn->prepare("SELECT * FROM travel_master where SUBSTR(plan_id,1,2) = 'H#' and sub_paln_id!='' ORDER BY sno DESC");
}else{
	$horders = $conn->prepare("SELECT * FROM travel_master where SUBSTR(plan_id,1,2) = 'H#' and sub_paln_id!='' ORDER BY sno DESC LIMIT 50");
}
$horders->execute();
$row_horders = $horders->fetch(PDO::FETCH_ASSOC); 
$totalRows_horders = $horders->rowCount();
?>
<style>
.nav-dropdown-contents{
	height: auto;
	min-width: 248px;
	max-width: 240px;
	overflow-y:auto;
}

.nav-dropdown-contents ul{
	padding: 0;
	margin: 0;
	list-style: none;
}

.nav-dropdown-contents ul li{
	display: block;
	border-bottom: 1px solid #F5F7FA;
}

.nav-dropdown-contents.static-list ul li,

.nav-dropdown-contents ul li a{
	padding: 20px 10px 10px 20px;
	display: block;
	position: relative;
	height: 60px;
    overflow: hidden;

    text-overflow: ellipsis;

    white-space: nowrap;

	text-decoration: none;

	color: #656D78;

	background: #fff;

}

.nav-dropdown-contents ul li a:hover{

	color: #434A54;

}
.scroll-nav-dropdowns
{
	height:auto;
	width:240px;
}

</style>

					<div class="container-fluid">
					<!-- Begin page heading -->
					<h1 class="page-heading">Orders <small>View Order Details</small></h1>
					<!-- End page heading -->
				
					<!-- Begin breadcrumb -->
					<ol class="breadcrumb default square rsaquo sm">
						<li><a href="dashboard.php"><i class="fa fa-home"></i></a></li>
						<li><a href="dashboard.php">Dashboard</a></li>
						<li class="active">Order Pro</li>
					</ol>
					<!-- End breadcrumb -->
					<!-- BEGIN DATA TABLE -->
					<div class="the-box">
                    
                    <div class="modal fade" id="mail_settings_mod" tabindex="-1" role="dialog" aria-hidden="true">
										  <div class="modal-dialog" >
                    <form  name="form_agent_sett"  id="form_agent_sett"  method="post" onsubmit=" return check_numbers()" >
											<div class="modal-content modal-no-shadow modal-no-border" >
											  <div class="modal-header bg-info no-border">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h5 class="modal-title" style="font-family:Verdana, Geneva, sans-serif; font-weight:600;"> <i class="fa fa-cogs"></i>&nbsp;Mail Settings</h5>
											  </div>
											  <div class="modal-body">
                                                <div class="row">
                                                <div class="col-sm-12">
                                                <label>Mail Send To : </label>
                                                </div>
                                                <div class="col-sm-12">
                                                <?php
												$mail = $conn->prepare("SELECT * FROM settings_mail order by sno DESC");
												$mail->execute();
												$row_mail = $mail->fetch(PDO::FETCH_ASSOC);
												$tot_mail=$mail->rowCount();
												
												if($tot_mail>0)
												{
													$already_mail=$row_mail['mail_to'];
												}else{
													$frtmail = $conn->prepare("SELECT * FROM dvi_front_settings where sno='1'");
													$frtmail->execute();
													$row_frtmail = $frtmail->fetch(PDO::FETCH_ASSOC);
													$tot_frtmail=$frtmail->rowCount();
													if($tot_frtmail>0)
													{
														$already_mail=$row_frtmail['email'];
													}else{
														$already_mail='srini@v-i.in';
													}
												}
												?>
                                                
			<input type="text" class="tagname form-control" name="mail_to_input[]" id="mail_to_input" multiple data-placeholder="Mail To " value="<?php echo $already_mail; ?>"  />
            									</div>
							  					</div>
											  </div>
											  <div class="modal-footer">
                                              <strong style="color:#F00; font-size:10px;" class="pull-left">Note : * Created or modified itineraries are monitored by above mail address </strong>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="mail_sett" name="mail_sett" value="mail_sett_val" class="btn btn-success" onclick="mail_settings()">Submit</button>
											  </div>
											</div>                                </form>
										  </div>
										</div>

                    
                    
                    <div class="modal fade in" id="download_vouch" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;" data-backdrop="static">
										  <!-- ajax_voucher.php  loading from download_voucher() function -->
										</div>
                    
                    	<div class="panel with-nav-tabs panel-info panel-square panel-no-border">
						  <div class="panel-heading">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#view_all" data-toggle="tab"><i class="fa fa-database"></i>&nbsp; All bookings</a></li>
                                <li><a href="#tr_hot" data-toggle="tab"><i class="fa fa fa-building-o"></i>&nbsp; Travel + Hotel</a></li>
								<li><a href="#tr_only" data-toggle="tab"><i class="fa fa fa-automobile"></i>&nbsp; Travel only </a></li>
                                
                                <li class="pull-right"><a href="#mail_settings_mod" data-toggle='modal'>
                                <i class="fa fa fa-envolop"></i>&nbsp;Mail Settings </a></li>
                                <?php if(!isset($_GET['older'])){?>
                                <li class="pull-right"><a href="admin_manaorder.php?mm=59a64762ef215e93af370c7d8cb4a01a&sm=88174d7333bf9c294355d4b49152bbe4&older=yes"> Show More </a></li>
                                <?php }?>
							
							</ul>
						  </div>
							<div id="panel-collapse-1" class="collapse in">
								<div class="panel-body">
									<div class="tab-content">
										<div class="tab-pane fade in active" id="view_all">
											<?php 
											if($totalRows_orders > 0)
											{
											?>
												<div class="table-responsive">
												<table class="table table-striped table-hover table-default table-th-block datatable-example" style="border:1px solid #D5DAE0">
													<thead class="the-box dark full">
														<tr>
															<th>#</th>
															<th><i class="fa fa-ticket"></i>&nbsp; Travel id</th>
                                                            <th><i class="fa fa-calendar"></i>&nbsp; Booking date</th>
															<th><i class="fa fa-user"></i>&nbsp; Agent/Distr info</th>
															<th><i class="fa fa-suitcase"></i>&nbsp; Traveller info</th>
															<th><i class="fa fa-paper-plane"></i>&nbsp; Plan info</th>
															<th><i class="fa fa-support"></i>&nbsp; Status</th>
														</tr>
													</thead>
													<tbody>
													<?php
													$inc=1; $fsname = ''; $lsname = '';
													
													foreach($row_orders_main as $row_orders)
													{
														if ($row_orders['agent_id'] == '-' || $row_orders['agent_id'] == '')
														{
															$agnt = $conn->prepare("SELECT * FROM distributor_pro WHERE distr_id =?");
															$agnt->execute(array($row_orders['distr_id']));
															$row_agnt = $agnt->fetch(PDO::FETCH_ASSOC);
															
															$fsname = $row_agnt['distr_fname'];
															$lsname = $row_agnt['distr_lname'];
														}
														else
														{
															$agnt = $conn->prepare("SELECT * FROM agent_pro WHERE agent_id =?");
															$agnt->execute(array($row_orders['agent_id']));
															$row_agnt = $agnt->fetch(PDO::FETCH_ASSOC);
															
															$fsname = $row_agnt['agent_fname'];
															$lsname = $row_agnt['agent_lname'];
														}
														
														$agncity = $conn->prepare("SELECT * FROM reg_cities WHERE id =?");
														$agncity->execute(array($row_agnt['city']));
														$row_agncity = $agncity->fetch(PDO::FETCH_ASSOC);
														
														$agnstat = $conn->prepare("SELECT * FROM dvi_states WHERE code =?");
														$agnstat->execute(array($row_agnt['state']));
														$row_agnstat = $agnstat->fetch(PDO::FETCH_ASSOC);
														
														$id_mas=substr($row_orders['plan_id'],0,2);
						
														?>
														<tr class="odd gradeX">
															<td><?php echo $inc; ?></td>
															<td><?php echo $row_orders['plan_id']; 
															if($id_mas =='TH')
															{
															if($row_orders['status']!=0)
															{
															?>
                                                            <a  href="javascript:void(0);" class=" badge badge-default  tooltips pull-right"  data-original-title='Plan still not approved'><i class="fa fa-vine"></i></a>
                                                            <?php }else{ ?>
                                                            <a data-toggle='modal' class=" badge  badge-info  tooltips pull-right"  data-original-title='Download Hotel Vouchers ' onclick="download_vouchers('<?php echo $row_orders['plan_id']; ?>','<?php echo $row_orders['tr_name']; ?>')"><i class="fa fa-vine"></i></a>
                                                            <?php } 
															}else{?>
																<a  href="javascript:void(0);" class=" badge  badge-default  tooltips pull-right"  data-original-title='No vouchers for this plan'><i class="fa fa-vine"></i></a>
															<?php }?>
                                                            </td>
                                                            
                                                            <td><?php echo date("d-M-Y",strtotime(substr($row_orders['date_of_reg'],0,10))); ?>
                                                            <?php if($id_mas =='TH' && $row_orders['status'] == 5){?>
                                                            <a class=" badge  badge-default  tooltips pull-right"  data-original-title='Plan still not completed'><i class="fa fa-file-text"></i></a>
                                                            <?php }else{?>
                                                            <a class="show_pdf tooltips pull-right badge <?php if($id_mas =='TH') { ?>  badge-info <?php } ?> <?php if($id_mas =='T#') { ?>  badge-info <?php } ?>  <?php if($id_mas =='H#') { ?>  badge-info <?php } ?>" href="<?php echo $_SESSION['grp'];?>/my_report.php?mm=<?php echo $_GET['mm']; ?>&sm=<?php echo $_GET['sm'];?>&planid=<?php echo urlencode($row_orders['plan_id']); ?>" data-original-title='<?php echo $row_orders['plan_id'].' - Info';?>'><i class="fa fa-file-text"></i></a>
                                                            <?php } ?>
                                                            </td>
															<td>
                                                            <lable class="tooltips" data-original-title='<?php echo "From - ".$row_agncity['name'].', '.$row_agnstat['name']; ?>' ><?php echo $fsname.' '.$lsname.'<br>'; ?></lable></td>
															<td class="center"> <?php echo $row_orders['tr_name']; ?>
                                                            
                                                               <!-- Mailing start -->
                                                           <?php
											 if($id_mas =='TH')
											 {
														    if($row_orders['status']==0 || $row_orders['status']==2) {?>
                                                            <a class="pull-right badge badge-info tooltips" data-toggle='tooltip' data-original-title='Send Mail' target="_blank" href="AGENT/trhot_mailing.php?planid=<?php echo urlencode($row_orders['plan_id']); ?>"><i class="fa fa-envelope"></i></a>
                                                            <?php }else if($row_orders['status']==5){?>
                                                            <a class="pull-right badge badge-info tooltips" data-toggle='tooltip' data-original-title='Send Mail' target="_blank" href="AGENT/trhot_mailing_resume.php?planid=<?php echo urlencode($row_orders['plan_id']); ?>"><i class="fa fa-envelope"></i></a>
                                                            <?php }else{?>
															<a class="pull-right badge badge-warning tooltips" data-toggle='tooltip' data-original-title='Rejected/Cancelled'  target="_blank" href="AGENT/trvl_mailing.php?planid=<?php echo urlencode($row_orders['plan_id']); ?>"><i class="fa fa-envelope"></i></a>	
															<?php }
											 }else if($id_mas =='T#'){ 
                                                           if($row_orders['status']==3 || $row_orders['status']==0 || $row_orders['status']==2 || $row_orders['status']==5) {?>
                                                            <a class="pull-right badge badge-info tooltips" data-toggle='tooltip' data-original-title='Send Mail' target="_blank" href="AGENT/trvl_mailing.php?planid=<?php echo urlencode($row_orders['plan_id']); ?>"><i class="fa fa-envelope"></i></a>
                                                            <?php }else{?>
															<a class="pull-right badge badge-default tooltips" data-toggle='tooltip' data-original-title='Not Approved' href="javascript:void(0);"><i class="fa fa-envelope"></i></a>	
															<?php }
                                             }?>
                                                            <!-- Mailing end -->
                                                            
                                                            
                                                            
                                                            </td>
															<td>
                                                            <?php 
															if($id_mas =='TH' && $row_orders['status'] != 5)
															{?>
																<a class="show_pdf btn btn-info btn-sm" style="width:116px" title="Plan details" href="<?php echo $_SESSION['grp'];?>/itiner_trav_hotel.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&planid=<?php echo urlencode($row_orders['plan_id']); ?>"><i class="fa fa-building-o"></i> Plan detail</a>
															<?php }else if($id_mas =='TH' && $row_orders['status'] == 5)
															{?>
																<a class=" btn btn-default btn-sm tooltips" style="width:116px" data-original-title='Plan still not completed'><i class="fa fa-building-o"></i> Plan detail</a>
															<?php }else if($id_mas =='H#')
															{?>
																<?php /*?><a class="show_pdf btn btn-info btn-sm" style="width:116px"  title="Plan details" href="<?php echo $_SESSION['grp'];?>/itiner_hotel.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&planid=<?php echo urlencode($row_orders['plan_id']); ?>"><i class="fa fa-home"></i></i> Plan detail</a><?php */?>
															<?php }else if($id_mas =='T#')
															{?>
																<a class="show_pdf btn btn-info btn-sm" style="width:116px"   title="Plan details" href="<?php echo $_SESSION['grp'];?>/itiner_trav.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&planid=<?php echo urlencode($row_orders['plan_id']); ?>"><i class="fa fa-automobile"></i> Plan detail</a>
																
															<?php }
															?>
															</td>
															<td class="center">
															<?php
															if ($row_orders['status'] == 2)
															{
															?>
															<button title="Click to Approve/Reject" class="btn btn-info btn-perspective btn-xs" onclick="sendappr('<?php echo $row_orders['plan_id']; ?>')">Awaiting approval</button>
															<?php
															}
															elseif($row_orders['status'] == 0)
															{
																?>
                                                                <span class="form-control tooltips"  data-original-title="Approved By Admin" style="background-color: #C7E0C1;color: #3D7D40;font-weight: 600;"><i class="fa fa-thumbs-up"></i> Approved </span>
																<?php
															}
															elseif($row_orders['status'] == 1)
															{
																?>
                                                                <span class="form-control tooltips" data-original-title="Rejected By Admin" data-toggle="tooltip" style="background-color: #F1DFD8;color: #CE470D;font-weight: 600;"><i class="fa fa-thumbs-down"></i> Rejected &nbsp;&nbsp; </span>
																<?php
															}elseif($row_orders['status'] == 3)
															{
																?>
                                                                  <span class="form-control tooltips" data-original-title="Rejected By Agent/Distr" data-toggle="tooltip" style="background-color: #F5E9D9;color: #AB6113;font-weight: 600;"><i class="fa fa-thumbs-down"></i> Rejected &nbsp;&nbsp; </span>
																<?php
															}elseif($row_orders['status'] == 4)
															{
																?>
																   <span class="form-control tooltips" data-original-title="Itinerary On Progress" data-toggle="tooltip" style="background-color: #F5E699;color: ##A28804;font-weight: 600;"><i class="fa fa-recycle"></i> Progress </span>
																<?php
															}elseif($row_orders['status'] == 5)
															{
																?>
                                                                 <span class="form-control tooltips" data-original-title="Saved By Agent/Distr" data-toggle="tooltip" style="background-color: #EFEEE9;color: #777776;font-weight: 600;"><i class="fa  fa-play"></i> Saved &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
																<?php
															}
															?>
                                                            </td>
														</tr>
														<?php
														$inc++;
													}
													
													?>
													</tbody>
												</table>
                                                </div><!-- /.table-responsive -->
												<?php
											}
											else
											{
												?>
												<div class="alert alert-info alert-bold-border square fade in alert-dismissable">
														  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
														  <strong>Hold on!</strong> No orders places yet, 
														  <a  style="text-decoration:none"class="alert-link">for your approval.</a>
														</div>
						
												<?php
											}
											?>
						
										</div>
										<div class="tab-pane fade" id="tr_hot">
											<?php 
											if($totalRows_thorders > 0)
											{
											?>
												<div class="table-responsive">
												<table class="table table-striped table-hover table-default table-th-block datatable-example" style="border:1px solid #D5DAE0">
													<thead class="the-box dark full">
														<tr>
															<th>#</th>
															<th><i class="fa fa-ticket"></i>&nbsp; Travel id</th>
                                                            <th><i class="fa fa-calendar"></i>&nbsp; Booking date</th>
															<th><i class="fa fa-user"></i>&nbsp; Agent info</th>
															<th><i class="fa fa-suitcase"></i>&nbsp; Traveller info</th>
															<th><i class="fa fa-paper-plane"></i>&nbsp; Plan info</th>
															<th><i class="fa fa-support"></i>&nbsp; Status</th>
														</tr>
													</thead>
													<tbody>
													<?php
													$inc=1; $fsname= ''; $lsname = '';
													foreach($row_thorders_main as $row_thorders)
													{
														if ($row_thorders['agent_id'] == '-' || $row_thorders['agent_id'] == '')
														{
															$agnt1 = $conn->prepare("SELECT * FROM distributor_pro WHERE distr_id =?");
															$agnt1->execute(array($row_thorders['distr_id']));
															$row_agnt1 = $agnt1->fetch(PDO::FETCH_ASSOC);
															
															$fsname = $row_agnt1['distr_fname'];
															$lsname = $row_agnt1['distr_lname'];
														}
														else
														{
															$agnt1 = $conn->prepare("SELECT * FROM agent_pro WHERE agent_id =?");
															$agnt1->execute(array($row_thorders['agent_id']));
															$row_agnt1 = $agnt1->fetch(PDO::FETCH_ASSOC);
															
															$fsname = $row_agnt1['agent_fname'];
															$lsname = $row_agnt1['agent_lname'];
														}
														
														$agncity1 = $conn->prepare("SELECT * FROM reg_cities WHERE id =?");
														$agncity1->execute(array($row_agnt1['city']));
														$row_agncity1 = $agncity1->fetch(PDO::FETCH_ASSOC);
														
														$agnstat1 = $conn->prepare("SELECT * FROM dvi_states WHERE code =?");
														$agnstat1->execute(array($row_agnt1['state']));
														$row_agnstat1 = $agncity1->fetch(PDO::FETCH_ASSOC);
						
						
														?>
														<tr class="odd gradeX">
															<td><?php echo $inc; ?></td>
														<!--	<td><?php //echo $row_thorders['plan_id']; ?></td>-->
                                                            
                                                            
                                                            <td><?php echo $row_thorders['plan_id']; 
															if($row_thorders['status']!=0)
															{
															?>
                                                            <a  href="javascript:void(0);" class=" badge badge-default  tooltips pull-right"  data-original-title='Plan still not approved'><i class="fa fa-vine"></i></a>
                                                            <?php }else{ ?>
                                                            <a data-toggle='modal' class=" badge  badge-info  tooltips pull-right"  data-original-title='Download Hotel Vouchers ' onclick="download_vouchers('<?php echo $row_thorders['plan_id']; ?>','<?php echo $row_thorders['tr_name']; ?>')"><i class="fa fa-vine"></i></a>
                                                            <?php } ?>
                                                            </td>
                                                            
                                                            
                                                            <td><?php echo date('d-M-Y',strtotime(substr($row_thorders['date_of_reg'],0,10))); ?>
                                                            <?php if($row_thorders['status'] != 5){ ?>
                                                            <a class="show_pdf pull-right badge badge-info tooltips" href="<?php echo $_SESSION['grp'];?>/my_report.php?mm=<?php echo $_GET['mm']; ?>&sm=<?php echo $_GET['sm'];?>&planid=<?php echo urlencode($row_thorders['plan_id']); ?>" data-original-title='<?php echo $row_thorders['plan_id']." - info"; ?>'><i class="fa fa-file-text"></i></a>
                                                            <?php }else if($row_thorders['status'] == 5){?>
                                                             <a class=" badge  badge-default  tooltips pull-right"  data-original-title='Plan still not completed'><i class="fa fa-file-text"></i></a>
                                                            <?php } ?>
                                                            </td>
															<td>
                                                            <lable class="tooltips" data-original-title='<?php echo "From - ".$row_agncity1['name'].', '.$row_agnstat1['name']; ?>' ><?php echo $fsname.' '.$lsname.'<br>'; ?></lable>
														</td>
															<td class="center"> <?php echo $row_thorders['tr_name']; ?>
                                                            
                                                            
                                                             <!-- Mailing start -->
                                                           <?php
														    $id_mas=substr($row_thorders['plan_id'],0,2);
											 if($id_mas =='TH')
											 {
														    if($row_thorders['status']==0 || $row_thorders['status']==2) {?>
                                                            <a class="pull-right badge badge-info tooltips" data-toggle='tooltip' data-original-title='Send Mail' target="_blank" href="AGENT/trhot_mailing.php?planid=<?php echo urlencode($row_thorders['plan_id']); ?>"><i class="fa fa-envelope"></i></a>
                                                            <?php }else if($row_thorders['status']==5){?>
                                                            <a class="pull-right badge badge-info tooltips" data-toggle='tooltip' data-original-title='Send Mail' target="_blank" href="AGENT/trhot_mailing_resume.php?planid=<?php echo urlencode($row_thorders['plan_id']); ?>"><i class="fa fa-envelope"></i></a>
                                                            <?php }else{?>
															<a class="pull-right badge badge-warning tooltips" data-toggle='tooltip' data-original-title='Rejected/Cancelled'  target="_blank" href="AGENT/trvl_mailing.php?planid=<?php echo urlencode($row_thorders['plan_id']); ?>"><i class="fa fa-envelope"></i></a>	
															<?php }
											 }?>
                                                            <!-- Mailing end -->
                                                            
                                                            
                                                            </td>
															<td>
                                                            <?php 
                                                            $id_mas=substr($row_thorders['plan_id'],0,2);
															if($id_mas =='TH' && $row_thorders['status'] != 5)
															{?>
																<a class="show_pdf btn btn-info btn-sm"  title="Plan details" href="<?php echo $_SESSION['grp'];?>/itiner_trav_hotel.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&planid=<?php echo urlencode($row_thorders['plan_id']); ?>"><i class="fa fa-building-o"></i> Plan detail</a>
															<?php }else if($id_mas =='TH' && $row_thorders['status'] == 5){
															?>	
																<a class=" btn btn-default btn-sm tooltips"  data-original-title='Plan still not completed'><i class="fa fa-building-o"></i> Plan detail</a>
															<?php }?>
                                                       
															</td>
															<td class="center">
															<?php
															if ($row_thorders['status'] == 2)
															{
															?>
															<button title="Click to Approve/Reject" class="btn btn-info btn-perspective btn-xs" onclick="sendappr('<?php echo $row_thorders['plan_id']; ?>')">Awaiting approval</button>
															<?php
															}
															elseif($row_thorders['status'] == 0)
															{
																?>
                                                                 <span class="form-control tooltips"  data-original-title="Approved By Admin" style="background-color: #C7E0C1;color: #3D7D40;font-weight: 600;"><i class="fa fa-thumbs-up"></i> Approved </span>
																<?php
															}
															elseif($row_thorders['status'] == 1)
															{
																?>
																 <span class="form-control tooltips" data-original-title="Rejected By Admin" data-toggle="tooltip" style="background-color: #F1DFD8;color: #CE470D;font-weight: 600;"><i class="fa fa-thumbs-down"></i> Rejected &nbsp;&nbsp; </span>
																<?php
															}elseif($row_thorders['status'] == 3)
															{
																?>
																 <span class="form-control tooltips" data-original-title="Rejected By Agent/Distr" data-toggle="tooltip" style="background-color: #F5E9D9;color: #AB6113;font-weight: 600;"><i class="fa fa-thumbs-down"></i> Rejected &nbsp;&nbsp; </span>
																<?php
															}elseif($row_thorders['status'] == 4)
															{
																?>
																   <span class="form-control tooltips" data-original-title="Itinerary On Progress" data-toggle="tooltip" style="background-color: #F5E699;color: ##A28804;font-weight: 600;"><i class="fa fa-recycle"></i> Progress </span>
																<?php
															}elseif($row_thorders['status'] == 5)
															{
																?>
																 <span class="form-control tooltips" data-original-title="Saved By Agent/Distr" data-toggle="tooltip" style="background-color: #EFEEE9;color: #777776;font-weight: 600;"><i class="fa  fa-play"></i> Saved &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
																<?php
															}
															?></td>
														</tr>
														<?php
														$inc++;
													}
													
													?>
													</tbody>
												</table>
                                                </div><!-- /.table-responsive -->
												<?php
											}
											else
											{
												?>
												<div class="alert alert-info alert-bold-border square fade in alert-dismissable">
														  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
														  <strong>Hold on!</strong> No orders places yet, 
														  <a  style="text-decoration:none"class="alert-link">for your approval.</a>
														</div>
						
												<?php
											}
											?>
											
										</div>
										<div class="tab-pane fade" id="tr_only">
											<?php 
											if($totalRows_torders > 0)
											{
											?>
												<div class="table-responsive">
												<table class="table table-striped table-hover table-default table-th-block datatable-example" style="border:1px solid #D5DAE0">
													<thead class="the-box dark full">
														<tr>
															<th>#</th>
															<th><i class="fa fa-ticket"></i>&nbsp; Travel id</th>
                                                            <th><i class="fa fa-calendar"></i>&nbsp; Booking date</th>
															<th><i class="fa fa-user"></i>&nbsp; Agent info</th>
															<th><i class="fa fa-suitcase"></i>&nbsp; Traveller info</th>
															<th><i class="fa fa-paper-plane"></i>&nbsp; Plan info</th>
															<th><i class="fa fa-support"></i>&nbsp; Status</th>
														</tr>
													</thead>
													<tbody>
													<?php
													$inc=1; $fsname = ''; $lsname = '';
													foreach($row_torders_main as $row_torders)
													{
														if ($row_torders['agent_id'] == '-' || $row_torders['agent_id'] == '')
														{
															$agnt2 = $conn->prepare("SELECT * FROM distributor_pro WHERE distr_id =?");
															$agnt2->execute(array($row_torders['distr_id']));
															$row_agnt2 = $agnt2->fetch(PDO::FETCH_ASSOC);
															
															$fsname = $row_agnt2['distr_fname'];
															$lsname = $row_agnt2['distr_lname'];
														}
														else
														{
															$agnt2 = $conn->prepare("SELECT * FROM agent_pro WHERE agent_id =?");
															$agnt2->execute(array($row_torders['agent_id']));
															$row_agnt2 =$agnt2->fetch(PDO::FETCH_ASSOC);
															
															$fsname = $row_agnt2['agent_fname'];
															$lsname = $row_agnt2['agent_lname'];
														}
														
														$agncity2 = $conn->prepare("SELECT * FROM reg_cities WHERE id =?");
														$agncity2->execute(array($row_agnt2['city']));
														$row_agncity2 = $agncity2->fetch(PDO::FETCH_ASSOC);
														
														$agnstat2 = $conn->prepare("SELECT * FROM dvi_states WHERE code =?");
														$agnstat2->execute(array($row_agnt2['state']));
														$row_agnstat2 = $agnstat2->fetch(PDO::FETCH_ASSOC);
						
						
														?>
														<tr class="odd gradeX">
															<td><?php echo $inc; ?></td>
															<td><?php echo $row_torders['plan_id']; ?></td>
                                                            <td><?php echo date("d-M-Y",strtotime(substr($row_torders['date_of_reg'],0,10))); ?>
                                                            
                                                            <a class="show_pdf badge pull-right badge-info tooltips" href="<?php echo $_SESSION['grp'];?>/my_report.php?mm=<?php echo $_GET['mm']; ?>&sm=<?php echo $_GET['sm'];?>&planid=<?php echo urlencode($row_torders['plan_id']); ?>" data-original-title='<?php if($row_torders['status']!='5'){ echo $row_torders['plan_id']." -info" ; }else {?> Plan still not completed <?php }?>'><i class="fa fa-file-text"></i></a></td>
															<td>
															 <lable class="tooltips" data-original-title='<?php echo "From - ".$row_agncity2['name'].', '.$row_agnstat2['name']; ?>' ><?php echo $fsname.' '.$lsname; ?></lable>
															</td>
															<td class="center"> <?php echo $row_torders['tr_name']; ?>
                                                            
                                                              <!-- Mailing start -->
                                                           <?php
														   $id_mas=substr($row_torders['plan_id'],0,2);
											 if($id_mas =='T#'){ 
                                                           if($row_torders['status']==3 || $row_torders['status']==0 || $row_torders['status']==2 || $row_torders['status']==5) {?>
                                                            <a class="pull-right badge badge-info tooltips" data-toggle='tooltip' data-original-title='Send Mail' target="_blank" href="AGENT/trvl_mailing.php?planid=<?php echo urlencode($row_torders['plan_id']); ?>"><i class="fa fa-envelope"></i></a>
                                                            <?php }else{?>
															<a class="pull-right badge badge-default tooltips" data-toggle='tooltip' data-original-title='Not Approved' href="javascript:void(0);"><i class="fa fa-envelope"></i></a>	
															<?php }
                                             }?>
                                                            <!-- Mailing end -->
                                                            
                                                            </td>
															<td>
                                                            <?php 
															$id_mas=substr($row_torders['plan_id'],0,2);
															if($id_mas =='T#')
															{?>
                                                          <a class="show_pdf btn btn-info btn-sm tooltips"  title="<?php if($row_torders['status']=='5'){ ?>Plan still not completed<?php }?>" href="<?php echo $_SESSION['grp'];?>/itiner_trav.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&planid=<?php echo urlencode($row_torders['plan_id']); ?>"><i class="fa fa-automobile"></i> Plan detail</a>
															<?php } ?>
															</td>
															<td class="center">
															<?php
															if ($row_torders['status'] == 2)
															{
															?>
															<button title="Click to Approve/Reject" class="btn btn-info btn-perspective btn-xs" onclick="sendappr('<?php echo $row_torders['plan_id']; ?>')">Awaiting approval</button>
															
															<?php
															}
															elseif($row_torders['status'] == 0)
															{?>
																   <span class="form-control tooltips"  data-original-title="Approved By Admin" style="background-color: #C7E0C1;color: #3D7D40;font-weight: 600;"><i class="fa fa-thumbs-up"></i> Approved </span>
															<?php
															}
															elseif($row_torders['status'] == 1)
															{
															?>
																<span class="form-control tooltips" data-original-title="Rejected By Admin" data-toggle="tooltip" style="background-color: #F1DFD8;color: #CE470D;font-weight: 600;"><i class="fa fa-thumbs-down"></i> Rejected &nbsp;&nbsp; </span>
															<?php
															}elseif($row_torders['status'] == 3)
															{
																?>
																<span class="form-control tooltips" data-original-title="Rejected By Agent/Distr" data-toggle="tooltip" style="background-color: #F5E9D9;color: #AB6113;font-weight: 600;"><i class="fa fa-thumbs-down"></i> Rejected &nbsp;&nbsp; </span>
																<?php
															}elseif($row_torders['status'] == 4)
															{
																?>
																 <span class="form-control tooltips" data-original-title="Itinerary On Progress" data-toggle="tooltip" style="background-color: #F5E699;color: ##A28804;font-weight: 600;"><i class="fa fa-recycle"></i> Progress </span>
																<?php
															}elseif($row_torders['status'] == 5)
															{
																?>
																 <span class="form-control tooltips" data-original-title="Saved By Agent/Distr" data-toggle="tooltip" style="background-color: #EFEEE9;color: #777776;font-weight: 600;"><i class="fa  fa-play"></i> Saved &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
																<?php
															}
															?>
                                                            </td>
														</tr>
														<?php
														$inc++;
													}
													
													?>
													</tbody>
												</table>
                                                </div><!-- /.table-responsive -->
												<?php
											}
											else
											{
												?>
												<div class="alert alert-info alert-bold-border square fade in alert-dismissable">
														  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
														  <strong>Hold on!</strong> No orders places yet, 
														  <a  style="text-decoration:none"class="alert-link">for your approval.</a>
														</div>
												<?php
											}
											?>
											
										</div>
										<!-- /.tab-pane fade -->
									</div><!-- /.tab-content -->
								</div><!-- /.panel-body -->
							</div><!-- /.collapse in -->
						</div>
                    
					</div><!-- /.the-box .default -->
					<!-- END DATA TABLE -->
				</div><!-- /.container-fluid -->
                <!-- /.container-fluid -->
<script>


$(document).ready(function(e) {
    $('.tooltips').tooltip();
	$('.tagname').tagsInput({allowDuplicates: 'true', width:'100%'});
});

$(document).keydown(function(e) {
    if (e.keyCode == 27) return false;
});

function mail_settings()
{
	var mailto=$('#mail_to_input').val().trim();
	$('.loader_ax').fadeIn();
	$.get('<?php echo $_SESSION['grp']; ?>/ajax_voucher.php?type=4&mailto='+mailto,function(res){
				//alert(res);
				$('.loader_ax').fadeOut(500);
				$('#mail_settings_mod').modal('hide');
		});
}

function download_vouchers(pid,trn)
{
	var pidd=pid.split('#');
	$('.loader_ax').fadeIn();
	$.get('<?php echo $_SESSION['grp']; ?>/ajax_voucher.php?type=1&pid1='+pidd[0]+'&pid2='+pidd[1]+'&trname='+trn,function(res){
				$('.loader_ax').fadeOut(500);
				$('#download_vouch').empty().html(res);
				$('#download_vouch').modal('show');
		});
}


function sendappr(tpid)
{

	swal({
		title: 'APPROVE ITINERARY.. ARE YOU SURE?',
		//type: 'info',
		showCancelButton: true,
		confirmButtonClass: 'btn-info',
		confirmButtonText: 'APPROVE!',
		cancelButtonText: 'REJECT',
		closeOnConfirm: false,
		allowOutsideClick: true,
		allowEscapeKey: true,
		},
		function(isConfirm) 
		{
			if (isConfirm) 
			{
				$.get('<?php echo 'ADMIN/ordappr.php' ?>', { tpid : tpid, typ : 1 }, function(data) {
	parent.location.reload();
	});
			}
			else
			{
				$.get('<?php echo 'ADMIN/ordappr.php' ?>', { tpid : tpid, typ : 2 }, function(data) {
	parent.location.reload();
	});
			}
		});
		

}
</script>