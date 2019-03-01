<?php
/*//this is for incompleted Transport+hotel itinerary - may occur reload before save
$delete_middle="delete from travel_master where substr(plan_id,1,3)='TH#'and room_info='' and status='5'";
mysql_query($delete_middle, $divdb) or die(mysql_error());*/


if(isset($_GET['older']) && $_GET['older']=='yes'){
	$orders = $conn->prepare("SELECT * FROM travel_master where agent_id=? and sub_paln_id!='' ORDER BY sno DESC");
}else{
	$orders = $conn->prepare("SELECT * FROM travel_master where agent_id=? and sub_paln_id!='' ORDER BY sno DESC LIMIT 50");
}
$orders->execute(array($_SESSION['uid']));
$row_orders_main=$orders->fetchAll();
$totalRows_orders =$orders->rowCount();


if(isset($_GET['older']) && $_GET['older']=='yes'){
	$thorders = $conn->prepare("SELECT * FROM travel_master where agent_id=? and SUBSTR(plan_id,1,2) = 'TH' and sub_paln_id!='' ORDER BY sno DESC");
}else{
	$thorders = $conn->prepare("SELECT * FROM travel_master where agent_id=? and SUBSTR(plan_id,1,2) = 'TH'  and sub_paln_id!='' ORDER BY sno DESC LIMIT 50");	
}
$thorders->execute(array($_SESSION['uid']));
$row_thorders_main = $thorders->fetchAll();
$totalRows_thorders = $thorders->rowCount();


if(isset($_GET['older']) && $_GET['older']=='yes'){
	$torders = $conn->prepare("SELECT * FROM travel_master where agent_id=? and SUBSTR(plan_id,1,2) = 'T#' and sub_paln_id!='' ORDER BY sno DESC");
}else{
	$torders = $conn->prepare("SELECT * FROM travel_master where agent_id=? and SUBSTR(plan_id,1,2) = 'T#' and sub_paln_id!='' ORDER BY sno DESC LIMIT 50");
}
$torders->execute(array($_SESSION['uid']));
$row_torders_main = $torders->fetchAll();
$totalRows_torders = $torders->rowCount();


if(isset($_GET['older']) && $_GET['older']=='yes'){
	$horders = $conn->prepare("SELECT * FROM travel_master where agent_id=? and SUBSTR(plan_id,1,2) = 'H#' and sub_paln_id!='' ORDER BY sno DESC");
}else{
	$horders = $conn->prepare("SELECT * FROM travel_master where agent_id=? and SUBSTR(plan_id,1,2) = 'H#' and sub_paln_id!='' ORDER BY sno DESC LIMIT 50");
}
$horders->execute(array($_SESSION['uid']));
$row_horders = $horders->fetch(PDO::FETCH_ASSOC);
$totalRows_horders = $horders->rowCount();

?>

<style>
.flashit{ background: #FFF; color: #F00; text-align:center; font-weight:600; } /* Flash class and keyframe animation */
 .flashit{ -webkit-animation: flash linear 1s infinite; animation: flash linear 1s infinite; } @-webkit-keyframes flash { 0% { opacity: 1; } 350% { opacity: .1; } 100% { opacity: 1; } } @keyframes flash { 0% { opacity: 1; } 50% { opacity: .1; } 100% { opacity: 1; } } 
 
.flashit:hover{
	  -webkit-animation: flash linear  infinite; animation: flash linear  infinite; 
	  font-weight:700;
	  color:#090;
 }
 /* Pulse class and keyframe animation */
 .pulseit{ -webkit-animation: pulse linear .5s infinite; animation: pulse linear .5s infinite; } @-webkit-keyframes pulse { 0% { width:200px; } 50% { width:240px; } 100% { width:200px; } } @keyframes pulse { 0% { width:200px; } 50% { width:240px; } 100% { width:200px; } }
</style>

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
					<h1 class="page-heading">Itineraries <small>View Itinerary details</small></h1>
					<!-- End page heading -->
				
					<!-- Begin breadcrumb --> 
					<ol class="breadcrumb default square rsaquo sm">
						<li><a href="dashboard.php"><i class="fa fa-home"></i></a></li>
						<li><a href="dashboard.php">Dashboard</a></li>
						<li class="active">Manage Itinerary</li>
					</ol>
					<!-- End breadcrumb -->
					<!-- BEGIN DATA TABLE -->
					<div class="the-box">
                    <div class="modal fade in" id="download_vouch" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;" data-backdrop="static">
										  <!-- ajax_voucher.php  loading from download_voucher() function -->
					</div>
                    
                    <form name="resume_me_form" id="resume_me_form" >
                    <div class="modal fade" id="resume_transmodal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static"  data-keyboard="false"  >
										  <div class="modal-dialog modal-lg ">
											<div class="modal-content modal-no-shadow modal-no-border bg-default">
											  <div class="modal-header" style="color:#9A4C0B;" id='conform_transhead' >
												<h4 class="modal-title" style="text-align:center" >Submit Your Itinerary</h4>
											  </div>
          <div class="modal-body" style="padding-top: 5px; padding-left: 5px;padding-right: 20px; padding-bottom: 5px; height:450px; overflow-y:scroll; background-color:rgb(255, 249, 241)" id="resume_transmodal_body" ><!-- loading transport itinerary form itin_submit_trav_report.php -->
                                    </div>
                                              
          <div class="modal-body" id="resume_transmodal_body_confirm" style="padding-top: 5px; padding-left: 5px;padding-right: 20px; padding-bottom: 5px; height:450px; overflow-y:scroll; display:none">
                                          <div class="row" style="margin-top:10px;">
                                              <div class="col-sm-12" >
                                              <small class="help-block" id="formerr" style=' display:none;color:#E9573F; text-align:center'></small>
											  <div class="form-group">
                                              	<div class="col-sm-6">
                                                <table>
                                                <tr>
                                                <td class="input-group-addon default tooltips" title="Enter guest name"><i class="fa fa-user"></i></td>
                                                <td><select id="gtitle" class="form-control" name="gtitle" tabindex="2" style="border-color: #DAD9D9; color:#848688">									<option value="Mr" selected>Mr.</option>
                                                    <option value="Mrs">Mrs.</option>
													</select>
                                                </td>
                                                <td>
                                             <input type="text" class="form-control col-sm-4" placeholder="Guest name" name="guestname" id="guestname">
                                             	</td>
                                                </tr>
                                                </table>
                                                </div>
                                                    
                                                    <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon default tooltips" title="Enter contact number"><i class="fa fa-phone"></i></span>
                                                        <input type="text" class="form-control" placeholder="Mobile number" name="mobil" id="mobil">
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>
                                                </div>
                                                        
                                                        <div class="row" style="margin-top:10px;"> 
                                                        <div class="col-sm-12">                                  
                                                <div class="form-group">
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon default tooltips" title="Enter arrival flight/train details"><i class="fa  fa-sign-in"></i></span>
                                                        <input type="text" class="form-control" placeholder="Arrival flight/train details" name="arrdet" id="arrdet">
                                                    </div>
                                                    </div>
                                                    
                                                    <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon default tooltips" title="Enter departure flight/train details"><i class="fa  fa-sign-out"></i></span>
                                                        <input type="text" class="form-control" placeholder="Departure flight/train details" name="depdet" id="depdet">
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>
                                                </div>
                                    </div>
											  <div class="modal-footer" style="padding-top:10px; padding-bottom:10px" id="resume_trans_footer" >
                                              <div class="col-sm-11" align="center">
                       <button type="button" class="btn btn-danger"  onClick="manage_status1('cancel')">Cancel</button>
                       <button type="button" class="btn btn-success" onClick="manage_status1('confirm')">Confirm</button>
                        </div>
                        <div class="col-sm-1" align="right">
                        <button type="button" class="btn btn-default " data-dismiss="modal" >Close</button></div>
											  </div>
                                              
                                              <div class="modal-footer" style="padding-top:10px; padding-bottom:10px; display:none;" id="resume_transconfirm_footer">
                                              <div class="col-sm-11" align="center">
                       <button type="button" class="btn btn-success" onClick="manage_status1('submit')">Submit</button>
                        </div>
                        <div class="col-sm-1" align="right">
                        <button type="button" class="btn btn-default " onClick="manage_status1('close')">Close</button></div>
											  </div>
                                              
											</div><!-- /.modal-content .modal-no-shadow .modal-no-border .the-box .success .full -->
										  </div><!-- /.modal-dialog -->
										</div>
                    
                    
                    
                    
                    
                    
                 <div class="modal fade" id="resume_modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static"  data-keyboard="false"  >
										  <div class="modal-dialog modal-lg ">
											<div class="modal-content modal-no-shadow modal-no-border bg-default">
											  <div class="modal-header" style="color:#9A4C0B; display:none" id='conform_head' >
												<h4 class="modal-title" style="text-align:center" >Submit Your Itinerary</h4>
											  </div>
                                              
                                              <div class="modal-body" style="padding-top: 5px; padding-left: 5px;padding-right: 20px; padding-bottom: 5px" id="resume_modal_body">
                                              <div class="row">
                                              <div class="col-sm-12" style="height:525px; overflow-y:scroll">
                                              <div id="dt_panel" style="background-color:#F5F2EF"></div>
                                              
                          <div class="panel with-nav-tabs panel-default panel-square" id="rep_tabss">
						  <div class="panel-heading">
						  <ul class="nav nav-tabs">
								<li><a href="#itin_rep" data-toggle="tab" id="resume_header" onclick="show_itinerary()">Itinerary Report</a></li>
								<li class="active" id="holistt"><a href="#hotel_listt" data-toggle="tab" onclick="show_func_dvisug()">Dvi Sugg. Hotels</a></li>
                                <li id="pow_holistt"><a href="#pow_hotel_listt" id="pow_hotel" data-toggle="tab" onclick="hide_func_dvisug()">Plan on own</a></li>
						  </ul>
						  </div>
						  <div id="panel-collapse-1" class="collapse in">
								<div class="panel-body">
									<div class="tab-content">
										<div class="tab-pane fade" id="itin_rep">
                                            
										</div>
										<div class="tab-pane fade in active" id="hotel_listt">
										Please Wait ...
										</div>
                                        <div class="tab-pane fade " id="pow_hotel_listt">
                                         <input type="hidden" value="" id="prv_ch">
                                        <div  id="pow_hotel_listt0">
										</div>
										</div>
                                        
									</div>
								</div>
							</div>
							</div>
                                    </div>
                                    </div>
                                    </div>
                                              
                                            <div class="modal-body" id="resume_modal_body_confirm" style="padding-top: 5px; padding-left: 5px;padding-right: 20px; padding-bottom: 5px; height:450px; overflow-y:scroll; display:none">
                                          <div class="row" style="margin-top:10px;">
                                              <div class="col-sm-12" >
                                              <small class="help-block" id="formerr" style=' display:none;color:#E9573F; text-align:center'></small>
											  <div class="form-group">
                                              	<div class="col-sm-6">
                                                <table>
                                                <tr>
                                                <td class="input-group-addon default tooltips" title="Enter guest name"><i class="fa fa-user"></i></td>
                                                <td><select id="gtitle1" class="form-control" name="gtitle1" tabindex="2" style="border-color: #DAD9D9; color:#848688">									<option value="Mr" selected>Mr.</option>
                                                    <option value="Mrs">Mrs.</option>
													</select>
                                                </td>
                                                <td>
                                             <input type="text" class="form-control col-sm-4" placeholder="Guest name" name="guestname1" id="guestname1">
                                             	</td>
                                                </tr>
                                                </table>
                                                </div>
                                                    
                                                    <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon default tooltips" title="Enter contact number"><i class="fa fa-phone"></i></span>
                                                        <input type="text" class="form-control" placeholder="Mobile number" name="mobil1" id="mobil1">
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>
                                                </div>
                                                        
                                                        <div class="row" style="margin-top:10px;"> 
                                                        <div class="col-sm-12">                                  
                                                <div class="form-group">
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon default tooltips" title="Enter arrival flight/train details"><i class="fa  fa-sign-in"></i></span>
                                                        <input type="text" class="form-control" placeholder="Arrival flight/train details" name="arrdet1" id="arrdet1">
                                                    </div>
                                                    </div>
                                                    
                                                    <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon default tooltips" title="Enter departure flight/train details"><i class="fa  fa-sign-out"></i></span>
                                                        <input type="text" class="form-control" placeholder="Departure flight/train details" name="depdet1" id="depdet1">
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>
                                                </div>
                                    </div>
											  <div class="modal-footer" style="padding-top:10px; padding-bottom:10px" id="resume_tab_footer" >
                                              <div class="col-sm-11" align="center">
                       <button type="button" class="btn btn-danger"  onClick="manage_status('cancel')">Cancel</button>
                       <button type="button" class="btn btn-success" id="sugg_confirm" onClick="manage_status('confirm')">Confirm </button>
                         <button type="button" class="btn btn-success" id="pow_confirm" onClick="manage_status_pow()" style="display:none;">Confirm </button>
                        </div>
                        <div class="col-sm-1" align="right">
                        <button type="button" class="btn btn-default " data-dismiss="modal" >Close</button></div>
											  </div>
                                              
                                              <div class="modal-footer" style="padding-top:10px; padding-bottom:10px; display:none;" id="resume_confirm_footer">
                                              <div class="col-sm-11" align="center">
                       <button type="button" id="submt_dvi_sugg" class="btn btn-success" onClick="manage_status('submit')">Submit</button>
                        <button type="button" id="submt_pow" class="btn btn-success" onClick="manage_status_pow_confirm()" style="display:none;">Submit</button>
                       
                        </div>
                        <div class="col-sm-1" align="right">
                        <button type="button" class="btn btn-default " onClick="manage_status('close')">Close</button></div>
											  </div>
                                              
											</div><!-- /.modal-content .modal-no-shadow .modal-no-border .the-box .success .full -->
										  </div><!-- /.modal-dialog -->
										</div>
                                        <input type="hidden" value="" id="clicked_pid" name="clicked_pid" />
                       </form>
                    
                    
                    	<div class="panel with-nav-tabs panel-info panel-square panel-no-border">
						  <div class="panel-heading">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#view_all" data-toggle="tab"><i class="fa fa-database"></i>&nbsp; All bookings</a></li>
                                <li><a href="#tr_hot" data-toggle="tab"><i class="fa fa-building-o"></i> Travel + Hotel</a></li>
								<li><a href="#tr_only" data-toggle="tab"><i class="fa fa-automobile"></i> Travel only </a></li>
                                <li class="pull-right"><a href="agent_orderstatus.php?mm=59a64762ef215e93af370c7d8cb4a01a&sm=0d020d1a6aa04515f0389af057a103b4&older=yes"> Show More </a></li>
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
												<table class="table table-striped table-hover table-default table-th-block datatable-example" style="border:1px solid #D2CECE">
													<thead class="the-box dark full">
														<tr>
															<th>#</th>
															<th><i class="fa fa-ticket"></i>&nbsp; Travel id</th>
                                                            <th><i class="fa fa-calendar"></i>&nbsp; Booking date</th>
															<th><i class="fa fa-suitcase"></i>&nbsp; Traveller info</th>
															<th><i class="fa fa-paper-plane"></i>&nbsp; Plan info</th>
															<th width="18%"><i class="fa fa-support"></i>&nbsp; Status</th>
														</tr>
													</thead>
													<tbody>
													<?php
													$inc=1;
													foreach($row_orders_main as $row_orders)
													{
														
														$agnt = $conn->prepare("SELECT * FROM agent_pro WHERE agent_id =?");
														$agnt->execute(array($row_orders['agent_id']));
														$row_agnt = $agnt->fetch(PDO::FETCH_ASSOC);
														
														
														$agncity = $conn->prepare("SELECT * FROM dvi_cities WHERE id =?");
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
                                                            <a  href="javascript:void(0);" data-toggle='tooltip' class=" badge badge-default  tooltips pull-right"  data-original-title='Plan still not approved'><i class="fa fa-vine"></i></a>
                                                            <?php }else{ ?>
                                                            <a  data-toggle='tooltip' class=" badge  badge-info  tooltips pull-right"  data-original-title='Download Hotel Vouchers ' onclick="download_vouchers('<?php echo $row_orders['plan_id']; ?>','<?php echo $row_orders['tr_name']; ?>')"><i class="fa fa-vine"></i></a>
                                                            <?php } 
															}else{?>
																<a  data-toggle='tooltip' href="javascript:void(0);" class=" badge  badge-default  tooltips pull-right"  data-original-title='No vouchers for this plan'><i class="fa fa-vine"></i></a>
															<?php }?>
															
                                                            </td>
                                                            <td>
                                                            <?php echo date('d-M-Y', strtotime(substr($row_orders['date_of_reg'],0,10))); 
                                                            
                                                             if($id_mas =='T#' || ($id_mas =='TH' && $row_orders['status'] !='5' )) { ?>
                                                            <a class="show_pdf badge pull-right  <?php if($id_mas =='TH') { ?>  badge-info <?php } ?> <?php if($id_mas =='T#') { ?>  badge-info <?php } ?>  <?php if($id_mas =='H#') { ?>  badge-info <?php } ?>" data-toggle='tooltip' data-original-title='<?php echo $row_orders['tr_name']; ?> - Plan Report'  href="<?php echo $_SESSION['grp'];?>/my_report.php?mm=<?php echo $_GET['mm']; ?>&sm=<?php echo $_GET['sm'];?>&planid=<?php echo urlencode($row_orders['plan_id']); ?>" ><i class="fa fa-file-text"></i></a>
                                                            <?php }else{ //for status resume only to hotel?>
                                                            <a class=" badge pull-right  <?php if($id_mas =='TH') { ?>  badge-default <?php } ?> <?php if($id_mas =='T#') { ?>  badge-info <?php } ?>  <?php if($id_mas =='H#') { ?>  badge-info <?php } ?>" data-toggle='tooltip' data-original-title='<?php echo $row_orders['tr_name']; ?> - Pending Report'><i class="fa fa-file-text"></i></a>
                                                            <?php }?>
                                                            
                                                            </td>
															
															<td class="center">
                                                            <lable data-html='true' data-toggle='tooltip' class="tooltips" <?php if(trim($row_orders['tr_mobile'])!=''){ ?> data-original-title="<?php  echo "<i class='fa fa-phone'></i> ".$row_orders['tr_mobile']; ?>" <?php }?>>
															<?php echo $row_orders['tr_name']; ?></lable>
                                                            
                                                            <!-- Mailing start -->
                                                            
                                                           <?php
											 if($id_mas =='TH')
											 {
														    if($row_orders['status']==0 || $row_orders['status']==2) {?>
                                                            <a class="pull-right badge badge-info" data-toggle='tooltip' data-original-title='Send Mail' target="_blank" href="AGENT/trhot_mailing.php?planid=<?php echo urlencode($row_orders['plan_id']); ?>"><i class="fa fa-envelope"></i></a>
                                                            <?php }else if($row_orders['status']==5){?>
                                                            <a class="pull-right badge badge-info" data-toggle='tooltip' data-original-title='Send Mail' target="_blank" href="AGENT/trhot_mailing_resume.php?planid=<?php echo urlencode($row_orders['plan_id']); ?>"><i class="fa fa-envelope"></i></a>
                                                            <?php }else{?>
															<a class="pull-right badge badge-default" data-toggle='tooltip' data-original-title='Not Approved' href="javascript:void(0);"><i class="fa fa-envelope"></i></a>	
															<?php }
											 }else if($id_mas =='T#'){ 
                                                           if($row_orders['status']==0 || $row_orders['status']==2 || $row_orders['status']==5) {?>
                                                            <a class="pull-right badge badge-info" data-toggle='tooltip' data-original-title='Send Mail' target="_blank" href="AGENT/trvl_mailing.php?planid=<?php echo urlencode($row_orders['plan_id']); ?>"><i class="fa fa-envelope"></i></a>
                                                            <?php }else{?>
															<a class="pull-right badge badge-default" data-toggle='tooltip' data-original-title='Not Approved' href="javascript:void(0);"><i class="fa fa-envelope"></i></a>	
															<?php }
                                             }?>
                                                            
                                                            <!-- Mailing end -->
                                                            </td>
															<td>
                                                            <?php $id_mas=substr($row_orders['plan_id'],0,2);
															if($id_mas =='TH' && $row_orders['status'] == 0)
															{?>
																<a class="show_pdf btn btn-info btn-sm" data-toggle='tooltip' title="Plan details" href="<?php echo $_SESSION['grp'];?>/itiner_trav_hotel.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&planid=<?php echo urlencode($row_orders['plan_id']); ?>"><i class="fa  fa-building-o"></i> Download Voucher</a>
															<?php }else if($id_mas =='H#' && $row_orders['status'] == 0)
															{?>
																<a class="show_pdf btn btn-success btn-sm" data-toggle='tooltip' title="Plan details" href="<?php echo $_SESSION['grp'];?>/itiner_hotel.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&planid=<?php echo urlencode($row_orders['plan_id']); ?>"><i class="fa  fa-building-o"></i></i> Download Voucher</a>
															<?php }else if($id_mas =='T#' && $row_orders['status'] == 0)
															{?>
																<a class="show_pdf btn btn-info btn-sm" data-toggle='tooltip'  title="Plan details" href="<?php echo $_SESSION['grp'];?>/itiner_trav.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&planid=<?php echo urlencode($row_orders['plan_id']); ?>"><i class="fa fa-automobile"></i> Download Voucher</a>
																
															<?php }
															else
															{
																?>
                                                                <a class="btn btn-default btn-sm" data-toggle='tooltip' data-original-title="Plan not yet approved by either you/admin"> <i class="fa fa-automobile"></i> No Voucher&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
                                                                <?php
															}
															?>
															</td>
															<td class="center">
						<?php if ($row_orders['status'] == 4){
							?>
							<button  data-toggle='tooltip' style="background-color: #F1EBD1;color: #9C802E;font-weight: 600;" data-original-title='Click To Confirm' class="form-control" onclick="sendappr('<?php echo $row_orders['plan_id']; ?>')"><i class="fa fa-shield"></i> &nbsp;&nbsp;Waiting&nbsp;&nbsp;&nbsp;</button>
							<?php }
						elseif($row_orders['status'] == 0){ ?>
							<span class="form-control" style="background-color: #C7E0C1;color: #3D7D40;font-weight: 600;" data-toggle='tooltip' data-original-title='Confirmed Itinerary'><i class="fa fa-thumbs-up"></i> &nbsp;Confirmed </span>
							<?php }
						elseif($row_orders['status'] == 1){ ?>
							<span  class="form-control" style="background-color: #F1DFD8;color: #CE470D;font-weight: 600;" data-toggle='tooltip' data-original-title='Rejected Itinerary'><i class="fa fa-thumbs-down"></i> &nbsp;Rejected &nbsp;&nbsp;&nbsp; </span>
							<?php }
						elseif($row_orders['status'] == 2){ ?>
							<span class="form-control" style="background-color: #F7F5CF;color: #847B08;font-weight: 600;" data-toggle='tooltip' data-original-title='Booking Under Process'><i class="fa fa-refresh"></i> &nbsp;Under Processing </span>
							<?php }
						elseif($row_orders['status'] == 3){ ?>
							<span class="form-control" style="background-color: #F7F5CF;color: #847B08;font-weight: 600;"  data-toggle='tooltip' data-original-title='Cancelled By Customer'><i class="fa fa-times"></i> &nbsp;Cancelled &nbsp;&nbsp; </span> 
							<?php }elseif($row_orders['status'] == 5){ ?>
							<span class="form-control btn" style="background-color: #EAE0C4;color: #674016;font-weight: 600;"  data-toggle='tooltip' data-original-title='Waiting to resume' onclick="resume_me('<?php echo $row_orders['plan_id']; ?>')"><i class="fa fa-play"></i> &nbsp;&nbsp;Resume&nbsp;&nbsp;&nbsp; </span> 
							<?php }?>
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
														  <strong>Hold on!</strong> No orders placed yet, 
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
												<table class="table table-striped table-hover table-default table-th-block datatable-example" style="border:1px solid #D2CECE">
													<thead class="the-box dark full">
														<tr>
															<th>#</th>
															<th><i class="fa fa-ticket"></i>&nbsp; Travel id</th>
                                                            <th><i class="fa fa-calendar"></i>&nbsp; Booking date</th>
															<th><i class="fa fa-suitcase"></i>&nbsp; Traveller info</th>
															<th><i class="fa fa-paper-plane"></i>&nbsp; Plan info</th>
															<th><i class="fa fa-support"></i>&nbsp; Status</th>
														</tr>
													</thead>
													<tbody>
													<?php
													$inc=1;
													foreach($row_thorders_main as $row_thorders)
													{
														
														$agnt1 = $conn->prepare("SELECT * FROM agent_pro WHERE agent_id =?");
														$agnt1->execute(array($row_thorders['agent_id']));
														$row_agnt1 = $agnt1->fetch(PDO::FETCH_ASSOC);
														
														
														$agncity1 = $conn->prepare("SELECT * FROM dvi_cities WHERE id =?");
														$agncity1->execute(array($row_agnt1['city']));
														$row_agncity1 = $agncity1->fetch(PDO::FETCH_ASSOC);
														
														
														$agnstat1 = $conn->prepare("SELECT * FROM dvi_states WHERE code =?");
														$agnstat1->execute(array($row_agnt1['state']));
														$row_agnstat1 = $agnstat1->fetch(PDO::FETCH_ASSOC);
						
						
														?>
														<tr class="odd gradeX">
															<td><?php echo $inc; ?></td>
															<td><?php echo $row_thorders['plan_id']; 
                                                             if($id_mas =='TH')
															{
															if($row_thorders['status']!=0)
															{
															?>
                                                            <a  href="javascript:void(0);" data-toggle='tooltip' class=" badge badge-default  tooltips pull-right"  data-original-title='Plan still not approved'><i class="fa fa-vine"></i></a>
                                                            <?php }else{ ?>
                                                            <a  data-toggle='tooltip' class=" badge  badge-info  tooltips pull-right"  data-original-title='Download Hotel Vouchers ' onclick="download_vouchers('<?php echo $row_thorders['plan_id']; ?>','<?php echo $row_thorders['tr_name']; ?>')"><i class="fa fa-vine"></i></a>
                                                            <?php } 
															}else{?>
																<a  data-toggle='tooltip' href="javascript:void(0);" class=" badge  badge-default  tooltips pull-right"  data-original-title='No vouchers for this plan'><i class="fa fa-vine"></i></a>
															<?php }?>
                                                            
                                                            
                                                           <!-- <a class="show_pdf badge pull-right badge-info" data-toggle='tooltip' data-original-title='<?php// echo $row_thorders['tr_name']; ?> - Plan Report' href="<?php// echo $_SESSION['grp'];?>/my_report.php?mm=<?php// echo $_GET['mm']; ?>&sm=<?php// echo $_GET['sm'];?>&planid=<?php// echo urlencode($row_thorders['plan_id']); ?>"><i class="fa fa-file-text"></i></a>--></td>
                                                            <td>
                                                            <?php echo date('d-M-Y',strtotime(substr($row_thorders['date_of_reg'],0,10))); ?>&nbsp;&nbsp;
                                                            
                                                             <?php    if($row_thorders['status'] !='5' ) { ?>
                                                            <a class="show_pdf badge pull-right badge-info" data-toggle='tooltip' data-original-title='<?php echo $row_thorders['tr_name']; ?> - Plan Report'  href="<?php echo $_SESSION['grp'];?>/my_report.php?mm=<?php echo $_GET['mm']; ?>&sm=<?php echo $_GET['sm'];?>&planid=<?php echo urlencode($row_thorders['plan_id']); ?>" ><i class="fa fa-file-text"></i></a>
                                                            <?php }else{ //for status resume only to hotel?>
                                                            <a class=" badge pull-right  badge-default " data-toggle='tooltip' data-original-title='<?php echo $row_thorders['tr_name']; ?> - Pending Report'><i class="fa fa-file-text"></i></a>
                                                            <?php }?>
                                                            </td>
															<td class="center"> 
															 <lable data-html='true' data-toggle='tooltip' class="tooltips" <?php if(trim($row_thorders['tr_mobile'])!=''){ ?> data-original-title="<?php  echo "<i class='fa fa-phone'></i> ".$row_thorders['tr_mobile']; ?>" <?php }?>>
															<?php echo $row_thorders['tr_name']; ?></lable>
                                                            
                                                               <!-- Mailing start -->
                                                           <?php
														    if($row_thorders['status']==0 || $row_thorders['status']==2) {?>
                                                            <a class="pull-right badge badge-info" data-toggle='tooltip' data-original-title='Send Mail' target="_blank" href="AGENT/trhot_mailing.php?planid=<?php echo urlencode($row_thorders['plan_id']); ?>"><i class="fa fa-envelope"></i></a>
                                                            <?php }else if($row_thorders['status']==5){?>
                                                            <a class="pull-right badge badge-info" data-toggle='tooltip' data-original-title='Send Mail' target="_blank" href="AGENT/trhot_mailing_resume.php?planid=<?php echo urlencode($row_thorders['plan_id']); ?>"><i class="fa fa-envelope"></i></a>
                                                            <?php }else{?>
															<a class="pull-right badge badge-default" data-toggle='tooltip' data-original-title='Not Approved' href="javascript:void(0);"><i class="fa fa-envelope"></i></a>	
															<?php }?>
                                                            <!-- Mailing end -->
                                                            
														</td>
															<td>
                                                            <?php 
                                                             $id_mas=substr($row_thorders['plan_id'],0,2);
															if($id_mas =='TH' && $row_thorders['status'] == 0)
															{?>
																<a class="show_pdf btn btn-info btn-sm" data-toggle='tooltip'  title="Plan details" href="<?php echo $_SESSION['grp'];?>/itiner_trav_hotel.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&planid=<?php echo urlencode($row_thorders['plan_id']); ?>"><i class="fa fa-building-o"></i> Download Voucher</a>
															<?php }
															else
															{
																?>
                                                            <a class="btn btn-default btn-sm"  title="Plan not yet approved by either you/admin"> <i class="fa fa-automobile"></i>No Voucher&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>    
                                                                <?php
															}
															 ?>
                                                       
															</td>
                                                            
                                                            <td class="center">
						<?php if ($row_thorders['status'] == 4){
							?>
							<button  data-toggle='tooltip' style="background-color: #F1EBD1;color: #9C802E;font-weight: 600;" data-original-title='Click To Confirm' class="form-control" onclick="sendappr('<?php echo $row_thorders['plan_id']; ?>')"><i class="fa fa-shield"></i> &nbsp;&nbsp;Waiting&nbsp;&nbsp;&nbsp;</button>
							<?php }
						elseif($row_thorders['status'] == 0){ ?>
							<span class="form-control" style="background-color: #C7E0C1;color: #3D7D40;font-weight: 600;" data-toggle='tooltip' data-original-title='Confirmed Itinerary'><i class="fa fa-thumbs-up"></i> &nbsp;Confirmed </span>
							<?php }
						elseif($row_thorders['status'] == 1){ ?>
							<span  class="form-control" style="background-color: #F1DFD8;color: #CE470D;font-weight: 600;" data-toggle='tooltip' data-original-title='Rejected Itinerary'><i class="fa fa-thumbs-down"></i> &nbsp;Rejected </span>
							<?php }
						elseif($row_thorders['status'] == 2){ ?>
							<span class="form-control" style="background-color: #F7F5CF;color: #847B08;font-weight: 600;" data-toggle='tooltip' data-original-title='Booking Under Process'><i class="fa fa-refresh"></i> &nbsp;Under Processing </span>
							<?php }
						elseif($row_thorders['status'] == 3){ ?>
							<span class="form-control" style="background-color: #F7F5CF;color: #847B08;font-weight: 600;"  data-toggle='tooltip' data-original-title='Cancelled By Customer'><i class="fa fa-times"></i> &nbsp;Cancelled &nbsp;&nbsp;</span> 
							<?php }elseif($row_thorders['status'] == 5){ ?>
							<span class="form-control btn" style="background-color: #EAE0C4;color: #674016;font-weight: 600;"  data-toggle='tooltip' data-original-title='Waiting to resume' onclick="resume_me('<?php echo $row_thorders['plan_id']; ?>')"><i class="fa fa-play"></i> &nbsp;&nbsp;Resume&nbsp;&nbsp;&nbsp; </span> 
							<?php }?>                        </td>
                                                            
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
												<table class="table table-striped table-hover table-default table-th-block datatable-example" style="border:1px solid #D2CECE">
													<thead class="the-box dark full">
														<tr>
															<th>#</th>
															<th><i class="fa fa-ticket"></i>&nbsp; Travel id</th>
                                                            <th><i class="fa fa-calendar"></i>&nbsp; Booking date</th>
															<th><i class="fa fa-suitcase"></i>&nbsp; Traveller info</th>
															<th><i class="fa fa-paper-plane"></i>&nbsp; Plan info</th>
															<th><i class="fa fa-support"></i>&nbsp; Status</th>
														</tr>
													</thead>
													<tbody>
													<?php
													$inc=1;
													foreach($row_torders_main as $row_torders)
													{
														
														$agnt2 = $conn->prepare("SELECT * FROM agent_pro WHERE agent_id =?");
														$agnt2->execute(array($row_torders['agent_id']));
														$row_agnt2 = $agnt2->fetch(PDO::FETCH_ASSOC);
														
														
														$agncity2 = $conn->prepare("SELECT * FROM dvi_cities WHERE id =?");
														$agncity2->execute(array($row_agnt2['city']));
														$row_agncity2 = $agncity2->fetch(PDO::FETCH_ASSOC);
														
														
														$agnstat2 = $conn->prepare("SELECT * FROM dvi_states WHERE code =?");
														$agnstat2->execute(array($row_agnt2['state']));
														$row_agnstat2 = $agnstat2->fetch(PDO::FETCH_ASSOC);
						
						
														?>
														<tr class="odd gradeX">
															<td><?php echo $inc; ?></td>
															<td><?php echo $row_torders['plan_id']; ?>
                                                           </td>
                                                            
                                                            <td>
                                                            <?php echo date('d-M-Y',strtotime(substr($row_torders['date_of_reg'],0,10))); ?>
                                                            
                                                             <a class="show_pdf pull-right badge badge-info" data-toggle='tooltip' data-original-title='<?php echo $row_torders['tr_name']; ?> - Plan Report' href="<?php echo $_SESSION['grp'];?>/my_report.php?mm=<?php echo $_GET['mm']; ?>&sm=<?php echo $_GET['sm'];?>&planid=<?php echo urlencode($row_torders['plan_id']); ?>"><i class="fa fa-file-text"></i></a>
                                                            </td>
															<td class="center">
                                                            
                                                            <lable data-html='true' data-toggle='tooltip' class="tooltips" <?php if(trim($row_torders['tr_mobile'])!=''){ ?> data-original-title="<?php  echo "<i class='fa fa-phone'></i> ".$row_torders['tr_mobile']; ?>" <?php }?>>
															<?php echo $row_torders['tr_name']; ?></lable>
                                                         <!-- mail start -->   
                                                            <?php if($row_torders['status']=='0' || $row_torders['status']=='2' || $row_torders['status']=='5'){?>							<a class="pull-right badge badge-info" data-toggle='tooltip' data-original-title='Send Mail' target="_blank" href="AGENT/trvl_mailing.php?planid=<?php echo urlencode($row_torders['plan_id']); ?>"><i class="fa fa-envelope"></i></a>
															<?php }else{?>
									<a class="pull-right badge badge-default" data-toggle='tooltip' data-original-title='Not Approved' href="javascript:void(0);"><i class="fa fa-envelope"></i></a>
                                    
                                    <!-- Mail End -->
															<?php }?>
                                                           </td>
															<td>
                                                            <?php 
															
															 $id_mas=substr($row_torders['plan_id'],0,2);
															if($id_mas =='T#' && $row_torders['status'] == 0)
															{?>
                                                            
                                                            <a class="show_pdf btn btn-info btn-sm"  data-toggle='tooltip' title="Plan details" href="<?php echo $_SESSION['grp'];?>/itiner_trav.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&planid=<?php echo urlencode($row_torders['plan_id']); ?>"><i class="fa fa-automobile"></i> Download Voucher</a>
															<?php }
															else
															{
																?>
                                                               <a class="btn btn-default btn-sm" data-toggle='tooltip'  title="Plan not yet approved by either you/admin"> <i class="fa fa-automobile"></i> No Voucher &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a> 
                                                                <?php
															}
															 ?>
															</td>
															                                                            
                                                            <td class="center">
						<?php if ($row_torders['status'] == 4){
							?>
							<button  data-toggle='tooltip' style="background-color: #F1EBD1;color: #9C802E;font-weight: 600;" data-original-title='Click To Confirm' class="form-control" onclick="sendappr('<?php echo $row_torders['plan_id']; ?>')"><i class="fa fa-shield"></i> &nbsp;&nbsp;Waiting&nbsp;&nbsp;&nbsp;</button>
							<?php }
						elseif($row_torders['status'] == 0){ ?>
							<span class="form-control" style="background-color: #C7E0C1;color: #3D7D40;font-weight: 600;" data-toggle='tooltip' data-original-title='Confirmed Itinerary'><i class="fa fa-thumbs-up"></i> &nbsp;Confirmed </span>
							<?php }
						elseif($row_torders['status'] == 1){ ?>
							<span  class="form-control" style="background-color: #F1DFD8;color: #CE470D;font-weight: 600;" data-toggle='tooltip' data-original-title='Rejected Itinerary'><i class="fa fa-thumbs-down"></i> &nbsp;Rejected </span>
							<?php }
						elseif($row_torders['status'] == 2){ ?>
							<span class="form-control" style="background-color: #F7F5CF;color: #847B08;font-weight: 600;" data-toggle='tooltip' data-original-title='Booking Under Process'><i class="fa fa-refresh"></i> &nbsp;Under Processing </span>
							<?php }
						elseif($row_torders['status'] == 3){ ?>
							<span class="form-control" style="background-color: #F7F5CF;color: #847B08;font-weight: 600;"  data-toggle='tooltip' data-original-title='Cancelled By Customer'><i class="fa fa-times"></i> &nbsp;Cancelled &nbsp;&nbsp; </span> 
							<?php }elseif($row_torders['status'] == 5){ ?>
							<span class="form-control btn" style="background-color: #EAE0C4;color: #674016;font-weight: 600;"  data-toggle='tooltip' data-original-title='Waiting to resume' onclick="resume_me('<?php echo $row_torders['plan_id']; ?>')"><i class="fa fa-play"></i> &nbsp;&nbsp;Resume&nbsp;&nbsp;&nbsp; </span> 
							<?php }?>                       </td>
                                                            
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
$(document).keydown(function(e) {
    if (e.keyCode == 27) return false;
});

function no_need_add_ons()
{
	$('#addi_cost_load_div').slideToggle(500);
}

function addi_cost_toggle_click()
{
	var pid=$('#clicked_pid').val().trim();
	var planid=pid.split('#');
			if($('#addi_cost_load_div').children().length == 0)
			{
					$('.loader_ax').fadeIn();
					$.get('AGENT/ajax_addi_cost.php?type=4&pid1='+planid[0]+'&pid2='+planid[1],function(addi_res)
					{
						$('.loader_ax').fadeOut(500);
						$('#addi_cost_load_div').empty().html(addi_res);
						$('.chosen-select').chosen({width:'100%'});
						$('#addi_cost_load_div').slideToggle(600);
					});
			}else{
				$('#addi_cost_load_div').slideToggle(600);
			}
}

/*function addi_add_on_change(dat,fr)
{
	var sadd_val=$('#addi_cst_sel_'+dat).val();
	if(sadd_val!=null && sadd_val!='')
	{
		$('#addi_sno_'+dat).val(sadd_val);
		$('.loader_ax').fadeIn();
		$.get('AGENT/ajax_addi_cost.php?type=2&sadd_val='+sadd_val,function(amt_res){
				$('.loader_ax').fadeOut(500);
				$('#addi_cst_'+dat).val(amt_res.trim());
			});
	}else{
		$('#addi_cst_'+dat).val('');
		$('#addi_sno_'+dat).val('');
	}
}*/
function addi_add_on_change(dat,fr)
{
    var sadd_val=$('#'+fr+'_addi_cst_sel_'+dat).val();
    if(sadd_val!=null && sadd_val!='')
    {
        $('#'+fr+'_addi_sno_'+dat).val(sadd_val);
        $('.loader_ax').fadeIn();
        $.get('AGENT/ajax_addi_cost.php?type=2&sadd_val='+sadd_val+'&fr='+fr,function(amt_res){
                $('.loader_ax').fadeOut(500);
                $('#'+fr+'_addi_cst_'+dat).val(amt_res.trim());
            });
    }else{
        $('#'+fr+'_addi_cst_'+dat).val('');
        $('#'+fr+'_addi_sno_'+dat).val('');
    }
}


function go_with_add_ons()
{
	var pid=$('#clicked_pid').val().trim();
	var planid=pid.split('#');
	  //alert("PLN ID="+planid);
		$('.loader_ax').fadeIn();
		var datastring = $("#resume_trav_addi_cost").serialize();
        $.ajax({
            type: "POST",
            url: "AGENT/ajax_addi_cost.php?type=5&pid1="+planid[0]+"&pid2="+planid[1],
			      data: datastring,
            success: function(res)
			{
        //alert("SSS="+res);
				if(pid[0] == 'T')
				{
				$.get('AGENT/itin_submit_trav_report.php?plan_id1='+planid[0]+'&plan_id2='+planid[1]+'&res=show',function(result)
						{
               alert(result);
							 $('.loader_ax').fadeOut(500);
							 $('#resume_transmodal_body').empty().html(result);
						});
				}
			}
			});
}


function sendappr(tpid)
{
	swal({
		title: 'APPROVE ITINERARY.. ARE YOU SURE?',
		type: 'info',
		showCancelButton: true,
		confirmButtonClass: 'btn-info',
		confirmButtonText: 'APPROVE!',
		cancelButtonText: 'REJECT',
		closeOnConfirm: false,
		allowOutsideClick: true,
		},
		function(isConfirm) 
		{
			if (isConfirm) 
			{
				$.get('<?php echo $_SESSION['grp'].'/ordappr.php' ?>', { tpid : tpid, typ : 1 }, function(data) {
	parent.location.reload();
	});
			}
			else
			{
				$.get('<?php echo $_SESSION['grp'].'/ordappr.php' ?>', { tpid : tpid, typ : 2 }, function(data) {
	parent.location.reload();
	});
			}
		});
}

function resume_me(pid)
{
	$('#clicked_pid').val(pid);
	var planid=pid.split('#');
	if(planid[0]=='TH')
	{
		$('#pow_hotel_listt').removeClass('active in');
		$('#pow_holistt').removeClass('active');
		
		$('#hotel_listt').addClass('active in');
		$('#holistt').addClass('active');
		
		$.get('<?php echo $_SESSION['grp']; ?>/resume_itin.php?plan_id1='+planid[0]+'&plan_id2='+planid[1]+'&res=show',function(res)
		{
			$('#hotel_listt').empty().html(res);
			$('#resume_header').empty().prepend(pid+' - Itinerary');
			
			$('.chosen-select').chosen({width:'100%'});
			//call plan_on_own by using hidden values
			$('#pow_hotel').attr('onclick','plan_on_own(),hide_func_dvisug()');
			
					if($('#hide_5star').length>0)
					{
						var hide5=$('#hide_5star').val().trim();
						$('#div_catg_'+hide5).hide();
					}
					$('#resume_modal').modal('show');
			
					$.get('<?php echo $_SESSION['grp']; ?>/resume_rep_details.php?plan_id1='+planid[0]+'&plan_id2='+planid[1],function(ress){
						$('#itin_rep').empty().html(ress);
					});
		});
	}else if(planid[0]=='T')
	{
		$.get('<?php echo $_SESSION['grp']; ?>/itin_submit_trav_report.php?plan_id1='+planid[0]+'&plan_id2='+planid[1]+'&res=show',function(res)
		{
			$('#resume_transmodal_body').empty().html(res);
			$('#resume_transmodal').modal('show');
		});
	}
}


function houseboat_editable(hid,ctg,no)
{
	//alert(hid+' - '+ctg+' - '+no);
	var pid=$('#clicked_pid').val().trim();
	var planid=pid.split('#');
	
	$('.loader_ax').fadeIn();
	$.get('<?php echo $_SESSION['grp']; ?>/resume_itin_dvi_sugg.php?plan_id1='+planid[0]+'&plan_id2='+planid[1]+'&edit_ctg='+ctg+'&edit_hid='+hid+'&edit_no='+no,function(res)
		{
			$('.loader_ax').fadeOut();
			$('#catg_tab_'+ctg).empty().html(res);
			$('.chosen-select').chosen({width:'100%'});
		});
	
}


function set_cate(categ)
{
	var prv=$('#prev_catg').val().trim();
	if(prv != '')
	{
		$('#catg_tab_'+prv).css('border','');
		$('#catg_tab_'+prv).css('background-color','');
		$('#catg_tab_'+categ).css('border','3px solid #6EC7E8');
		$('#catg_tab_'+categ).css('background-color','#F3F3F3');
		$('#prev_catg').val(categ);
	}else{
		$('#catg_tab_'+categ).css('border','3px solid #6EC7E8');
		$('#catg_tab_'+categ).css('background-color','#F3F3F3');
		$('#prev_catg').val(categ);
	}
}

function manage_status(sts)
{
	var spid=$('#clicked_pid').val().trim().split('#');
	if(sts=='cancel')
	{
		$.get('<?php echo $_SESSION['grp']; ?>/ajax_agent.php?spid1='+spid[0]+'&spid2='+spid[1]+'&type=27',function(result)
		{
			alert('Itinerary Plan Is Cancelled - '+$('#clicked_pid').val());
			$('#clicked_pid').val('');
			location.reload();
			
		});
	}else if(sts=='confirm')
	{
		if($('#prev_catg').val()!='')
		{
			$('#resume_modal_body').hide();
			$('#resume_tab_footer').hide();
			$('#resume_modal_body_confirm').show();
			$('#conform_head').show();
			$('#resume_confirm_footer').show();
		}else{
			alert('Please select any option ..');
		}
		
	}else if(sts=='submit')
	{
		//alert($('#guestname1').val().trim()+'  '+$('#mobil1').val().trim()+'  '+$('#arrdet1').val().trim()+'  '+$('#depdet1').val().trim());
		
		var numbers = /^[0-9]+$/;
	if ($('#guestname1').val().trim() == '' || $('#mobil1').val().trim() == '' || $('#arrdet1').val().trim() == '' || $('#depdet1').val().trim() == '') 
		{
			alert('Please enter all the fields ..');
			//$('#formerr').text("Please enter all the fields below..").show();
		}else if($('#guestname1').val().length<4)
		{
			//$('#formerr').hide();
			alert('Guest name should be minimum 4 characters ..');
			$('#guestname1').focus();
		}else if(($('#mobil1').val().length<10) || (!$('#mobil1').val().match(numbers)))  
		{
			//$('#formerr').hide();
			alert('Enter Valid Mobile Number ( Numeric - min 10 Numbers)');
			$('#mobil1').focus();
		}else if($('#arrdet1').val().length<4)
		{
			//$('#formerr').hide();
			alert("Arrival-Detail should be minimum 4 characters ..");
			$('#arrdet1').focus();
		}else if($('#depdet1').val().length<4)
		{
			//$('#formerr').hide();
			alert("Departure-Detail should be minimum 4 characters ..");
			$('#depdet1').focus();
		}else{
				var datastring = $("#resume_me_form").serialize();
				$.ajax({
					type: "POST",
					url: "AGENT/resume_itin.php?plan_id1="+spid[0]+"&plan_id2="+spid[1]+"&res=insert",
					data: datastring,
					success: function(res) {
						//alert(res);
						$('#resume_modal').modal('hide');
						alert("Your Itinerary ("+$('#clicked_pid').val()+") - Successfully submitted");
						$('#clicked_pid').val('');
						location.reload();
					}
				});
		}
	}else if(sts=='close')
	{
		$('#resume_modal').modal('hide');
		$('#resume_modal_body').show();
		$('#resume_tab_footer').show();
		$('#resume_modal_body_confirm').hide();
		$('#conform_head').hide();
		$('#resume_confirm_footer').hide();
		$('#clicked_pid').val('');
	}
}

function manage_status1(sts)
{
	var spid=$('#clicked_pid').val().trim().split('#');
	if(sts=='cancel')
	{
		$.get('<?php echo $_SESSION['grp']; ?>/ajax_agent.php?spid1='+spid[0]+'&spid2='+spid[1]+'&type=27',function(result)
		{
			alert('Itinerary Plan Is Cancelled - '+$('#clicked_pid').val());
			$('#clicked_pid').val('');
			location.reload();
			
		});
	}else if(sts=='confirm')
	{
			$('#resume_transmodal_body').hide();
			$('#resume_trans_footer').hide();
			$('#resume_transmodal_body_confirm').show();
			$('#resume_transconfirm_footer').show();
		
	}else if(sts=='submit')
	{
		var numbers = /^[0-9]+$/;
		if ($('#guestname').val() == '' || $('#mobil').val() == '' || $('#arrdet').val() == '' || $('#depdet').val() == '') 
		{
		$('#formerr').text("Please enter all the fields below..").show();
		}else if($('#guestname').val().length<4)
		{
			$('#formerr').hide();
			alert('Guest name should be minimum 4 characters ..');
			$('#guestname').focus();
		}else if(($('#mobil').val().length<10) || (!$('#mobil').val().match(numbers)))  
		{
			$('#formerr').hide();
			alert('Enter Valid Mobile Number ( Numeric - min 10 Numbers)');
			$('#mobil').focus();
		}else if($('#arrdet').val().length<4)
		{
			$('#formerr').hide();
			alert("Arrival-Detail should be minimum 4 characters ..");
			$('#arrdet').focus();
		}else if($('#depdet').val().length<4)
		{
			$('#formerr').hide();
			alert("Departure-Detail should be minimum 4 characters ..");
			$('#depdet').focus();
		}else{
			var gnamme=$('#gtitle').val()+'. '+$('#guestname').val();
		$.get('<?php echo $_SESSION['grp']; ?>/ajax_agent.php?spid1='+spid[0]+'&spid2='+spid[1]+'&type=26'+'&gname='+gnamme+'&gmobi='+$('#mobil').val()+'&garrdet='+$('#arrdet').val()+'&gdepdet='+$('#depdet').val(),function(result)
		{
			$('#resume_transmodal').modal('hide');
			alert(gnamme+' - We are please to accept your request for reservation.If urgent please get in touch with your tour manager @ 9047776899/9047776849');
			location.reload();
					});
		}
	
	}else if(sts=='close')
	{
		$('#resume_transmodal').modal('hide');
		$('#resume_transmodal_body').show();
		$('#resume_trans_footer').show();
		$('#resume_transmodal_body_confirm').hide();
		$('#resume_transconfirm_footer').hide();
		$('#clicked_pid').val('');
	}
}

function plan_on_own()
{
  var itit_fr;
  var itn_form_tot=$('#itn_form_tot').val().split('-');
  $('#pow_hotel_listt0').empty();

  for(var fr=0;fr<itn_form_tot.length;fr++)
  {

    itit_fr=itn_form_tot[fr];
    var fb="fr"+fr;
    

var room_inf=$('input[name='+itit_fr+'_room_info_pow]').val().trim();

	//var room_inf=$('#'+itit_fr+'_room_info_pow').val().trim();
var num_sty_rooms=$('input[name='+itit_fr+'_stay_rooms_pow]').val().trim();
//	var num_sty_rooms=$('#'+itit_fr+'_stay_rooms_pow').val().trim();
var cities_id=$('input[name='+itit_fr+'_city_ids_pow]').val().trim();
	//var cities_id=$('#'+itit_fr+'_city_ids_pow').val().trim();
var cities_name=$('input[name='+itit_fr+'_city_idname_pow]').val().trim();
	//var cities_name=$('#'+itit_fr+'_city_idname_pow').val().trim();
var strt_date=$('input[name='+itit_fr+'_stdate_pow]').val().trim();
	//var strt_date=$('#'+itit_fr+'_stdate_pow').val().trim();
	 
  // alert(itit_fr);
	var day_cnt_arr=cities_name.split(',');
	var day_cnt=day_cnt_arr.length;
	
	/*alert(room_inf+' '+num_sty_rooms+' '+cities_id+' '+cities_name+'  '+strt_date);
	alert(day_cnt);*/
	//$('#pow_hotel_listt0').empty();
			var eat;
			var prv_day;
			for(var days=1;days<=day_cnt;days++)
			{
       // alert("DDD="+days);
				table_uniq="<div id='"+fb+"_pow_hotel_listt"+days+"'><center><table id='"+fb+"_stay_tabell"+days+"' class='table' style='width:90%;margin-top:15px; border:#DFDADA 1px solid;'><tr style='height:20px; background-color:#FFFCF2'><td width='15%'>Date</td><td width='20%' id='"+fb+"_sdate_nw_td"+days+"' >Waiting..</td><td witdh='15%'>Place:</td><td colspan='2' id='"+fb+"_city_nw_td"+days+"'>xxx</td></tr><tr><td width='15%'>Category</td><td width='25%' id='"+fb+"_catag_nw_td"+days+"'><input type='text' class='form-control' disabled ></td><td width='5%'>&nbsp;</td><td id='"+fb+"_tdroom_nw_td"+days+"' rowspan='4' colspan='2' width='40%' style='border: #CAC6C6 1px solid; background-color: rgb(245, 245, 244);'><br><br><center>Choose hotel for finding available rooms</center></td></tr></tr><tr><td width='15%'>Hotel</td><td width='25%' id='"+fb+"_hotel_nw_td"+days+"' ><input type='text' class='form-control' disabled ></td><td>&nbsp;</td></tr></tr><tr><td width='5%'>Food</td><td id='"+fb+"_food_nw_td"+days+"'><input type='text' class='form-control' id='"+fb+"_food_id"+days+"' name='"+fb+"_food_id"+days+"' disabled ></td><td width='5%'> </td></tr></tr><tr><td width='15%'>Special</td><td width='25%' id='"+fb+"_spl_nw_td"+days+"'><input type='text' class='form-control' name='"+fb+"_ext_item_id"+days+"' id='"+fb+"_ext_item_id"+days+"' disabled ></td><td width='5%'></td></tr></table><input type='hidden' id='"+fb+"_htl_id"+days+"' value='' /><input type='hidden' name='"+fb+"_itin_iid' id='"+fb+"_itin_iid' value='"+itit_fr+"'></center></div>";

					prv_day=days-1;
          $(table_uniq).appendTo('#pow_hotel_listt0');
				/*	if(days==1){
					$(table_uniq).appendTo('#'+fb+'_pow_hotel_listt'+prv_day);
					}else{
						$(table_uniq).insertAfter('#'+fb+'_pow_hotel_listt'+prv_day);
					}*/
					
		eat=days-1;
		city_kitname=day_cnt_arr[eat];
		var today =new Date(strt_date);
 		var d =new Date(new Date(today).setDate(today.getDate()+eat)); 
		var daysss=d.getDate() + '-' + (d.getMonth()+1) + '-' + d.getFullYear();
		
	  $('#'+fb+'_sdate_nw_td'+days).empty().html("<input class='form-control' type='text' readonly id='"+fb+"_sdat"+days+"' name='"+fb+"_sdat"+days+"' value='"+daysss+"'>");
		$('#'+fb+'_city_nw_td'+days).empty().html("<input type='text' class='form-control' value='"+city_kitname+"' id='"+fb+"_kitcity"+eat+"' readonly='readonly' >");
			}
			
		var kitkkk=cities_id.split(",");
		var kithhh=kitkkk.length;
		var hugg;

		for(var hug=0; hug<kithhh; hug++)
		{
		  hugg=hug+1;
			$('#'+fb+'_htl_id'+hugg).val(kitkkk[hug]);
			find_hotel_categ(fb,kitkkk[hug],hugg);
			find_all_categ(fb,kitkkk[hug],hugg);
		}
  }//main for loop
	
}

function find_hotel_categ(fr,cid,no)
{
  var datt=$('#'+fr+'_sdat'+no).val();
  var type=18;
    $.get('AGENT/ajax_agent.php?cid='+cid+'&no='+no+'&type='+type+'&tdate='+datt+'&fr='+fr,function(result){
    //alert(cid+' no '+no+' '+result);
    $('#'+fr+'_catag_nw_td'+no).empty().html(result);
    $('.chosen').chosen({'width':'100%'});
  });
}

/*function find_hotel_categ(cid,no)
{
	var datt=$('#sdat'+no).val();
	var type=18;
		$.get('AGENT/ajax_agent.php?cid='+cid+'&no='+no+'&type='+type+'&tdate='+datt,function(result){
			//alert(cid+' no '+no+' '+result);
	$('#catag_nw_td'+no).empty().html(result);
		$('.chosen').chosen({'width':'100%'});
	});
}*/

function find_all_categ(fr,cid,pno)
{
  var type=21;
  var datt=$('#'+fr+'_sdat'+pno).val();
  $('.loader_ax').fadeIn();
  $.get('AGENT/ajax_agent.php?cid='+cid+'&pno='+pno+'&type='+type+'&tdate='+datt+'&fr='+fr,function(result){
    $('.loader_ax').fadeOut(500);
    //alert(result);
    $('#'+fr+'_hotel_nw_td'+pno).empty().html(result);
    $('.chosen').chosen({'width':'100%'});
  });
}

/*function find_all_categ(fr,cid,pno)
{
  alert("AG GG sCAT - "+fr);
	var type=21;
	var datt=$('#'+fr+'_sdat'+pno).val();
	$('.loader_ax').fadeIn();
	$.get('AGENT/ajax_agent.php?cid='+cid+'&pno='+pno+'&type='+type+'&tdate='+datt,function(result){
		$('.loader_ax').fadeOut(500);
		//alert(result);
	$('#'+fr+'_hotel_nw_td'+pno).empty().html(result);
	$('.chosen').chosen({'width':'100%'});
	});
}*/

function find_stay_hotel(fr,categ,cid,no)
{
  $('#'+fr+'_food_nw_td'+no).empty().html("<input class='form-control' type='text' value='choose above hotel' disabled='disabled'>");
  $('#'+fr+'_spl_nw_td'+no).empty().html("<input class='form-control' type='text' value='choose above hotel' disabled='disabled'>");
  $('#'+fr+'_tdroom_nw_td'+no).empty().html("<center><br><br><label>Choose hotel for finding available rooms</label></center>");
  var type=1,cates;
  var datt=$('#'+fr+'_sdat'+no).val();
  $('.loader_ax').fadeIn();
  $.get('AGENT/ajax_agent.php?cid='+cid+'&no='+no+'&type='+type+'&cates='+categ+'&tdate='+datt+'&fr='+fr,function(result){
    $('.loader_ax').fadeOut(500);
  //alert(result);
  $('#'+fr+'_hotel_nw_td'+no).empty().html(result);
   $('.chosen').chosen({'width':'100%'});
  });
}

/*function find_stay_hotel(categ,cid,no)
{
	$('#food_nw_td'+no).empty().html("<input class='form-control' type='text' value='choose above hotel' disabled='disabled'>");
	$('#spl_nw_td'+no).empty().html("<input class='form-control' type='text' value='choose above hotel' disabled='disabled'>");
	$('#tdroom_nw_td'+no).empty().html("<center><br><br><label>Choose hotel for finding available rooms</label></center>");
	var type=1,cates;
	var datt=$('#sdat'+no).val();
	$('.loader_ax').fadeIn();
	$.get('AGENT/ajax_agent.php?cid='+cid+'&no='+no+'&type='+type+'&cates='+categ+'&tdate='+datt,function(result){
		$('.loader_ax').fadeOut(500);
	//alert(result);
	$('#hotel_nw_td'+no).empty().html(result);
	$('.chosen').chosen({'width':'100%'});
	});
}*/

function find_hotel_rooms(fr,hid,no)
{
      var type=2;
      var itit_frs=$('#'+fr+'_itin_iid').val().trim();
      
      var rms=parseInt($('input[name='+itit_frs+'_stay_rooms_pow]').val());  
      var datt=$('#'+fr+'_sdat'+no).val();
      $('.loader_ax').fadeIn();
      $.get('AGENT/ajax_agent.php?hid='+hid+'&no='+no+'&type='+type+'&tdate='+datt+'&rooms='+rms+'&fr='+fr,function(result){
        //$('.loader_ax').fadeOut();
      $('#'+fr+'_tdroom_nw_td'+no).empty().html(result);
      $('.chosen').chosen({'width':'100%'});
      
      find_special_amenity(fr,hid,no);
      find_food_category(fr,hid,no);
      find_rate_cbed(fr,hid,no);
      });
}

/*function find_hotel_rooms(hid,no)
{
			var type=2;
			var rms=$("#stay_rooms_pow").val().trim();	
			var datt=$('#sdat'+no).val();
			$('.loader_ax').fadeIn();
			$.get('AGENT/ajax_agent.php?hid='+hid+'&no='+no+'&type='+type+'&tdate='+datt+'&rooms='+rms,function(result){
				//$('.loader_ax').fadeOut();
				//alert(result);
			$('#tdroom_nw_td'+no).empty().html(result);
			$('.chosen').chosen({'width':'100%'});
			
			find_special_amenity(hid,no);
			find_food_category(hid,no);
			find_rate_cbed(hid,no);
			});
}*/

/*function find_special_amenity(hid,no)
{
	var sdt=$('#sdat'+no).val();
	var type=22;
	$('.loader_ax').fadeIn();
	$.get('AGENT/ajax_agent.php?hid='+hid+'&pno='+no+'&type='+type+'&daty='+sdt,function(result){
		$('.loader_ax').fadeOut(500);
	$('#spl_nw_td'+no).empty().html(result);
	$('.tooltips').tooltip();
	$('.chosen-select').chosen({width:'100%'});
	$('.tooltips').tooltip();
	});
}
*/
function find_special_amenity(fr,hid,no)
{
  var sdt=$('#'+fr+'_sdat'+no).val();
  var type=22;
  $('.loader_ax').fadeIn();
  $.get('AGENT/ajax_agent.php?hid='+hid+'&pno='+no+'&type='+type+'&daty='+sdt+'&fr='+fr,function(result){
    $('.loader_ax').fadeOut(500);
  $('#'+fr+'_spl_nw_td'+no).empty().html(result);
  $('.tooltips').tooltip();
  $('.chosen-select').chosen({width:'100%'});
  $('.tooltips').tooltip();
  });
}

/*function find_food_category(hid,no)
{
	var sdt1=$('#sdat'+no).val();
	var type=23;
	//$('.loader_ax').fadeIn();
	$.get('AGENT/ajax_agent.php?hid='+hid+'&pno='+no+'&type='+type+'&daty='+sdt1,function(result){
		$('.loader_ax').fadeOut(500);
	$('#food_nw_td'+no).empty().html(result);
	$('.chosen-select').chosen({width:'100%'});
	});
}*/

function find_food_category(fr,hid,no)
{
  var sdt1=$('#'+fr+'_sdat'+no).val();
  var type=23;
  //$('.loader_ax').fadeIn();
  $.get('AGENT/ajax_agent.php?hid='+hid+'&pno='+no+'&type='+type+'&daty='+sdt1+'&fr='+fr,function(result){
    $('.loader_ax').fadeOut(500);
  $('#'+fr+'_food_nw_td'+no).empty().html(result);
  $('.chosen-select').chosen({width:'100%'});
  });
}

/*function find_rate_cbed(val,no)
{
	var datt=$('#sdat'+no).val();
	var ht_id=$('#hotel_sel_id'+no).val();
	var type=11;
	$.get('AGENT/ajax_agent.php?val='+val+'&date='+datt+'&type='+type+'&hot_id='+ht_id+'&no='+no,function(result){
	$('#tdroom_nw_td'+no).append(result);
	});
}*/

function find_rate_cbed(fr,val,no)
{
  var datt=$('#'+fr+'_sdat'+no).val();
  var ht_id=$('#'+fr+'_hotel_sel_id'+no).val();
  var type=11;
  $.get('AGENT/ajax_agent.php?val='+val+'&date='+datt+'&type='+type+'&hot_id='+ht_id+'&no='+no+'&fr='+fr,function(result){
  $('#'+fr+'_tdroom_nw_td'+no).append(result);
  });
}

/*function find_room_rent(val,no,rmno)
{	
	$('.loader_ax').fadeIn();
	var datt=$('#sdat'+no).val();
	var type=10;
	$.get('AGENT/ajax_agent.php?val='+val+'&date='+datt+'&type='+type,function(result){
		$('.loader_ax').fadeOut(500);
		//alert(result.trim());
			if(result.trim() != '00')
			{
			$('#hot_rm_rent'+no+'_'+rmno).val(result.trim());
			}else
			{
			alert('Hotel Rooms Unavailable for this season');	
			}
	});
	
	if(rmno==1){
	for(var yo1=2;yo1<=$("#stay_rooms_pow").val().trim();yo1++)
	{
		$('.chosen').chosen('destroy');
		find_room_rent(val,no,yo1);
		
		hiu=$('#hot_rm_id'+no+'_1 option:selected').val();
		$('#hot_rm_id'+no+'_'+yo1+' option').each(function(i,val)
		{
			if(val.value==hiu)
			{
				$(this).attr('selected',true);
			}
		});
		$('.chosen').chosen({width:'100%'});
	}
	}
}*/

function find_room_rent(fr,val,no,rmno)
{ 
  $('.loader_ax').fadeIn();
  var datt=$('#'+fr+'_sdat'+no).val();
  var type=10;
  $.get('AGENT/ajax_agent.php?val='+val+'&date='+datt+'&type='+type+'&fr='+fr,function(result){
    $('.loader_ax').fadeOut(500);
    //alert(result.trim());
      if(result.trim() != '00')
      {
      $('#'+fr+'_hot_rm_rent'+no+'_'+rmno).val(result.trim());
      }else
      {
      alert('Hotel Rooms Unavailable for this season'); 
      }
  });
  
    var itit_frs=$('#'+fr+'_itin_iid').val().trim();
    var rms=parseInt($('input[name='+itit_frs+'_stay_rooms_pow]').val());  
  if(rmno==1){
  for(var yo1=2;yo1<=parseInt(rms);yo1++)
  {
    $('.chosen').chosen('destroy');
    find_room_rent(fr,val,no,yo1);
    
    hiu=$('#'+fr+'_hot_rm_id'+no+'_1 option:selected').val();
    $('#'+fr+'_hot_rm_id'+no+'_'+yo1+' option').each(function(i,val)
    {
      if(val.value==hiu)
      {
        $(this).attr('selected',true);
      }
    });
    $('.chosen').chosen({width:'100%'});
  }
  }
}

/*function find_food_rate(val,no)
{
    var datt=$('#sdat'+no).val();
	var nums=$("#stay_rooms_pow").val().trim();
	var ht_id=$('#hotel_sel_id'+no).val();
	if((datt.trim() != '')&& (ht_id.trim() != '') && (val.trim() != ''))
	{
		var type=12;
		$('.loader_ax').fadeIn();
		$.get('AGENT/ajax_agent.php?val='+val+'&date='+datt+'&type='+type+'&hot_id='+ht_id,function(result){
			$('.loader_ax').fadeOut(500);
		$('#foood_rate'+no).val(result.trim());
		});	
		}else{
		alert('Please enter hotel and date..');	
	}
}*/
function find_food_rate(fr,val,no)
{
    var datt=$('#'+fr+'_sdat'+no).val();
    var itit_frs=$('#'+fr+'_itin_iid').val().trim();
    var nums=parseInt($('input[name='+itit_frs+'_stay_rooms_pow]').val()); 
    // var nums=parseInt($("#num_room_htls_"+fr).val());
    var ht_id=$('#'+fr+'_hotel_sel_id'+no).val();
    if((datt.trim() != '')&& (ht_id.trim() != '') && (val.trim() != ''))
    {
    var type=12;
    $('.loader_ax').fadeIn();
    $.get('AGENT/ajax_agent.php?val='+val+'&date='+datt+'&type='+type+'&hot_id='+ht_id+'&fr='+fr,function(result){
      $('.loader_ax').fadeOut(500);
    $('#'+fr+'_foood_rate'+no).val(result.trim());
    }); 
    }else{
  alert('Please enter hotel and date..'); 
  }
}

function show_func_dvisug()
{
	$('#sugg_confirm').show();	
	$('#pow_confirm').hide();
	
	$('#submt_dvi_sugg').show();
	$('#submt_pow').hide();	
}

function hide_func_dvisug()
{
	$('#sugg_confirm').hide();	
	$('#pow_confirm').show();
	
	$('#submt_dvi_sugg').hide();
	$('#submt_pow').show();		
}

function manage_status_pow_confirm()
{
		var numbers = /^[0-9]+$/;
	   if ($('#guestname1').val().trim() == '' || $('#mobil1').val().trim() == '' || $('#arrdet1').val().trim() == '' || $('#depdet1').val().trim() == '') 
		{
			alert('Please enter all the fields');
		//$('#formerr').text("Please enter all the fields below..").show();
		}else if($('#guestname1').val().length<4)
		{
			//$('#formerr').hide();
			alert('Guest name should be minimum 4 characters ..');
			$('#guestname1').focus();
		}else if(($('#mobil1').val().length<10) || (!$('#mobil1').val().match(numbers)))  
		{
			//$('#formerr').hide();
			alert('Enter Valid Mobile Number ( Numeric - min 10 Numbers)');
			$('#mobil1').focus();
		}else if($('#arrdet1').val().length<4)
		{
			//$('#formerr').hide();
			alert("Arrival-Detail should be minimum 4 characters ..");
			$('#arrdet1').focus();
		}else if($('#depdet1').val().length<4)
		{
			//$('#formerr').hide();
			alert("Departure-Detail should be minimum 4 characters ..");
			$('#depdet1').focus();
		}else{
	
			var spidd=$('#clicked_pid').val().trim().split('#');
		//	var room_infpowd=$('#room_info_pow').val().trim();
			//var num_sty_roomspowd=$('#stay_rooms_pow').val().trim();
			//var cities_idpowd=$('#city_ids_pow').val().trim();
			//var cities_namepowd=$('#city_idname_pow').val().trim();
			// strt_datepowd=$('#stdate_pow').val().trim();
			
		//	var day_cnt_arrpowd=cities_namepowd.split(',');
		//	var day_cntpowd=day_cnt_arrpowd.length;
	
			var datastring = $("#resume_me_form").serialize();
									$.ajax({
										type: "POST",
										url: "AGENT/resume_planonown.php?plan_id1="+spidd[0]+"&plan_id2="+spidd[1],
										data: datastring,
										success: function(res) {
											//alert(res);
											$('#resume_modal').modal('hide');
											alert("Your Itinerary ("+$('#clicked_pid').val()+") - Successfully submitted");
											$('#clicked_pid').val('');
											location.reload();
										}
									});	
		}
}

function manage_status_pow()
{
  var frb=$('#itn_form_tot').val().split('-');
  var csk=0;
  for(var fb=0;fb<frb.length;fb++)
  {
    var itit_fr=frb[fb];
    var fr="fr"+fb;
	  var spid=frb[fb].split('#');

	  // var room_infpow=$('#room_info_pow').val().trim();
	  // var num_sty_roomspow=$('#stay_rooms_pow').val().trim();
	  // var cities_idpow=$('#city_ids_pow').val().trim();
	  // var cities_namepow=$('#city_idname_pow').val().trim();
	  // var strt_datepow=$('#stdate_pow').val().trim();

var room_infpow=$('input[name='+itit_fr+'_room_info_pow]').val().trim();
var num_sty_roomspow=$('input[name='+itit_fr+'_stay_rooms_pow]').val().trim();
var cities_idpow=$('input[name='+itit_fr+'_city_ids_pow]').val().trim();
var cities_namepow=$('input[name='+itit_fr+'_city_idname_pow]').val().trim();
var strt_datepow=$('input[name='+itit_fr+'_stdate_pow]').val().trim();

	   var day_cnt_arrpow=cities_namepow.split(',');
	   var day_cntpow=day_cnt_arrpow.length;
	   //alert("fff"+day_cntpow);
	          ///resume plan_mystay
						//validation to plan_mystay
						
						var prv_c=$('#prv_ch').val();
						if(prv_c != '')
						{
						$('#'+prv_c).css('background-color','#FFF');
						}
						var days=day_cntpow;
						var rooms=num_sty_roomspow;
					// 	alert(days);
						for(var dd=1;dd<=days;dd++)
						{
							var dates=$('#'+fr+'_sdat'+dd).val();;
							if($('#'+fr+'_hotel_sel_id'+dd).val().trim() =='')
							{
								alert('hotel does not choosed in '+dates);
								$('#'+fr+'_hotel_nw_td'+dd).css('background-color','#FCC');
								$('#prv_ch').val(fr+'_hotel_nw_td'+dd);
								csk=1;
								exit(0);
							}
							
							for(var chy2=1;chy2<=rooms;chy2++)
							{
										if($('#'+fr+'_hot_rm_id'+dd+'_'+chy2).length>0 && $('#'+fr+'_hot_rm_id'+dd+'_'+chy2).val()=='')
										{
											alert('hotel room does not choosed in '+dates);
											$('#'+fr+'_tdroom_nw_td'+dd).css('background-color','#FCC');
											$('#prv_ch').val(fr+'_tdroom_nw_td'+dd);
											csk=1;
											exit(0);
										}
							}
							
							if($('#'+fr+'_tr_cnt_'+dd).length>0 && $('#'+fr+'_tr_cnt_'+dd).val()!='')
							{
								for(var chy3=0;chy3<=$('#'+fr+'_tr_cnt_'+dd).val();chy3++)
								{
										if($('#'+fr+'_hot_hb_rm_id'+dd+'_'+chy3).length>0 && $('#'+fr+'_hot_hb_rm_id'+dd+'_'+chy3).val()=='')
										{
												alert('houseboat rooms does not choosed in '+dates);
												$('#'+fr+'_tdroom_nw_td'+dd).css('background-color','#FCC');
												$('#prv_ch').val(fr+'_tdroom_nw_td'+dd);
												csk=1;
												exit(0);
											}
								}
							}
						}
						
    }//main for loop
    if(csk==0)
            {
                  $('#resume_modal_body').hide();
                  $('#resume_tab_footer').hide();
                  $('#resume_modal_body_confirm').show();
                  $('#conform_head').show();
                  $('#resume_confirm_footer').show(); 
            }//valid
}


/*function fun_hb_add(hid,rno,tno)
{
	hid=hid.trim();
		var opt='';//getting already generated select option without calling ajax
		$('#hot_hb_rm_id'+rno+'_0 > option').each(function() {
			//alert(this.text + ' ' + this.value);
			if(opt=='')
			{
				opt="<option value='"+this.value+"'>"+this.text+"</option>";
			}else{
				opt=opt+"<option value='"+this.value+"'>"+this.text+"</option>";
			}
		});

		var tr_cnt=$('#tr_cnt_'+rno).val().trim();
		$('#tr_cnt_'+rno).val(parseInt(tr_cnt)+1);
		var ptno=tno;
		tno=parseInt(tno)+1;
		ctno=parseInt(ptno)+2;
	
		var tr_add='<tr id=tr_hb_'+rno+'_'+tno+'><td style="padding:9px;" width="5%">'+ctno+')</td><td style="padding:9px;" width="50%"><select class="form-control chosen" id="hot_hb_rm_id'+rno+'_'+tno+'" name="hot_hb_rm_id'+rno+'_'+tno+'" onchange="find_hb_room_rent(this.value,'+rno+','+tno+','+tno+')"  data-placeholder="Choose Room" >'+opt+'</select><input type="hidden" id="hot_hb_rm_rent'+rno+'_'+tno+'" name="hot_hb_rm_rent'+rno+'_'+tno+'"  /></td><td style="padding:9px;" width="40%"><select id="sel_hb_nw_extr'+rno+'_'+tno+'" name="sel_hb_nw_extr'+rno+'_'+tno+'" class="form-control chosen" ><option value="-" selected="">Nil</option><option value="0" >With Bed</option><option value="1">Without Bed</option></select></td><td style="padding:9px;" width="15%"><a class="btn btn-sm btn-danger" onclick="fun_hb_remove('+rno+','+tno+')"> <i class="fa fa-minus"></i></a></td></tr>';
	
		$('#btn_hb_'+rno).removeAttr('onclick').attr('onclick','fun_hb_add("'+hid+'","'+rno+'","'+tno+'")');
		
		$('#tr_hb_'+rno).append(tr_add);
	 	$('.chosen').chosen({'width':'100%'});
}*/

function fun_hb_add(fr,hid,rno,tno)
{
  hid=hid.trim();
    var opt='';//getting already generated select option without calling ajax
    $('#'+fr+'_hot_hb_rm_id'+rno+'_0 > option').each(function() {
      //alert(this.text + ' ' + this.value);
      if(opt=='')
      {
        opt="<option value='"+this.value+"'>"+this.text+"</option>";
      }else{
        opt=opt+"<option value='"+this.value+"'>"+this.text+"</option>";
      }
    });

    var tr_cnt=$('#'+fr+'_tr_cnt_'+rno).val().trim();
    $('#'+fr+'_tr_cnt_'+rno).val(parseInt(tr_cnt)+1);
    var ptno=tno;
    tno=parseInt(tno)+1;
    ctno=parseInt(ptno)+2;
  
    var tr_add='<tr id='+fr+'_tr_hb_'+rno+'_'+tno+'><td style="padding:9px;" width="5%">'+ctno+')</td><td style="padding:9px;" width="50%"><select class="form-control chosen" id="'+fr+'_hot_hb_rm_id'+rno+'_'+tno+'" name="'+fr+'_hot_hb_rm_id'+rno+'_'+tno+'" onchange="find_hb_room_rent("'+fr+'",this.value,'+rno+','+tno+','+tno+')"  data-placeholder="Choose Room" >'+opt+'</select><input type="hidden" id="'+fr+'_hot_hb_rm_rent'+rno+'_'+tno+'" name="'+fr+'_hot_hb_rm_rent'+rno+'_'+tno+'"  /></td><td style="padding:9px;" width="40%"><select id="'+fr+'_sel_hb_nw_extr'+rno+'_'+tno+'" name="'+fr+'_sel_hb_nw_extr'+rno+'_'+tno+'" class="form-control chosen" ><option value="-" selected="">Nil</option><option value="0" >With Bed</option><option value="1">Without Bed</option></select></td><td style="padding:9px;" width="15%"><a class="btn btn-sm btn-danger" id="'+fr+'_rmvbtn_hb_'+rno+'" onclick=fun_hb_remove("'+fr+'","'+rno+'","'+tno+'")> <i class="fa fa-minus"></i></a></td></tr>';
  
    //$('#'+fr+'_rmvbtn_hb_'+rno).attr('onclick','fun_hb_remove("'+fr+'","'+rno+'","'+tno+'")');
    $('#'+fr+'_btn_hb_'+rno).removeAttr('onclick').attr('onclick','fun_hb_add("'+fr+'","'+hid+'","'+rno+'","'+tno+'")');
    
    $('#'+fr+'_tr_hb_'+rno).append(tr_add);
    $('.chosen').chosen({'width':'100%'});
}

/*function find_hb_room_rent(val,no,rmno){
	
	$('.loader_ax').fadeIn();
	var datt=$('#sdat'+no).val();
	var type=10;
	$.get('AGENT/ajax_agent.php?val='+val+'&date='+datt+'&type='+type,function(result){
		$('.loader_ax').fadeOut(500);
		//alert(result.trim());
			if(result.trim() != '00')
			{
			$('#hot_hb_rm_rent'+no+'_'+rmno).val(result.trim());
			}else
			{
			alert('Hotel Rooms Unavailable for this season');	
			}
	});
	
}*/

function find_hb_room_rent(fr,val,no,rmno)
{
  //alert('d');
  $('.loader_ax').fadeIn();
  var datt=$('#'+fr+'_sdat'+no).val();
  var type=10;
  $.get('AGENT/ajax_agent.php?val='+val+'&date='+datt+'&type='+type+'&fr='+fr,function(result){
    $('.loader_ax').fadeOut(500);
    //alert(result.trim());
      if(result.trim() != '00')
      {
      $('#'+fr+'_hot_hb_rm_rent'+no+'_'+rmno).val(result.trim());
      }else
      {
      alert('Hotel Rooms Unavailable for this season'); 
      }
  });
}

/*function fun_hb_remove(rno,tno)
{
	$('#tr_hb_'+rno+'_'+tno).remove();
}*/
function fun_hb_remove(fr,rno,tno)
{
  $('#'+fr+'_tr_hb_'+rno+'_'+tno).remove();
}

/*function find_others_rate(val,no)
{
//alert(val+'='+no);	
	var values = []; 
	$('#ext_item_id'+no+' :selected').each(function(i, selected){ 
	  values[i] = $(selected).val(); 
	});

	var datt=$('#sdate'+no).val();

	var nums=$('#stay_rooms_pow').val().trim();
	var ht_id=$('#hotel_sel_id'+no).val();
	for(var ui=0;ui<nums-1;ui++)
	{
		ht_id=ht_id+','+$('#sel'+no+'_'+ui).val();
	}
	//alert(ht_id+','+values);
	var type=13;
	$.get('AGENT/ajax_agent.php?val='+values+'&date='+datt+'&type='+type+'&hot_id='+ht_id,function(result){
		//alert(result);
		
		if(result.trim() == '')
		{
			$('#others_rate'+no).val('0');
		}else
		{
		$('#others_rate'+no).val(result.trim());
		}
	});	
}*/


function find_others_rate(fr,val,no)
{
//alert(val+'='+no);  
  var values = []; 
  $('#'+fr+'_ext_item_id'+no+' :selected').each(function(i, selected){ 
    values[i] = $(selected).val(); 
  });

  var datt=$('#'+fr+'_sdate'+no).val();
  
  var nums=$('#num_room_htls_'+fr).val();
  var ht_id=$('#'+fr+'_hotel_sel_id'+no).val();
  
  var type=13;
  $.get('AGENT/ajax_agent.php?val='+values+'&date='+datt+'&type='+type+'&hot_id='+ht_id+'&fr='+fr,function(result){
    
    if(result.trim() == '')
    {
      $('#'+fr+'_others_rate'+no).val('0');
    }else
    {
    $('#'+fr+'_others_rate'+no).val(result.trim());
    }
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

</script>                