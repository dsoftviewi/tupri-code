<style>
th{
	padding:5px;	
}
table{ 
		cellspacing:10;	
}

.modal-lg1{
	width:1000px;	
}

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


.flashit{ background: #FFF; color: #F00; text-align:center; font-weight:600; } /* Flash class and keyframe animation */

 .flashit:hover{
	  -webkit-animation: flash linear  infinite; animation: flash linear  infinite; 
	  font-weight:700;
	  color:#090;
 }
 .flashit{ -webkit-animation: flash linear 1s infinite; animation: flash linear 1s infinite; font-weight:600; } @-webkit-keyframes flash { 0% { opacity: 1; } 350% { opacity: .1; } 100% { opacity: 1; } } @keyframes flash { 0% { opacity: 1; } 50% { opacity: .1; } 100% { opacity: 1; } } 
 /* Pulse class and keyframe animation */
 .pulseit{ -webkit-animation: pulse linear .5s infinite; animation: pulse linear .5s infinite; } @-webkit-keyframes pulse { 0% { width:200px; } 50% { width:240px; } 100% { width:200px; } } @keyframes pulse { 0% { width:200px; } 50% { width:240px; } 100% { width:200px; } }
</style>

<?php
include("COMMN/smsfunc.php");

/*//this is for incompleted Transport+hotel itinerary - may occur reload before save
$delete_middle="delete from travel_master where substr(plan_id,1,3)='TH#'and room_info='' and status='5'";
mysql_query($delete_middle, $divdb) or die(mysql_error());*/

$timezone = new DateTimeZone("Asia/Kolkata" );
  $date = new DateTime();
  $date->setTimezone($timezone );
  $mm=$date->format('m');
  $mm1=$date->format('M');
  $yy=$date->format('Y');
  $dd=$date->format('d');
  $time=date("H:i:s");
  $ttoday=$date->format('Y-m-d');
  
if ($_SESSION['grp'] == 'AGENT')
{
	$agent_id=$_SESSION['uid'];

	$agent=$conn->prepare("select * from agent_pro where agent_id=?");
	$agent->execute(array($agent_id));
	$row_agent = $agent->fetch(PDO::FETCH_ASSOC);
	
	$user_fname=$row_agent['agent_fname'];
	$user_lname=$row_agent['agent_lname'];
	$user_email=$row_agent['email_id'];
	
	$distr_id = $row_agent['distr_id'];
	$agent_perc = $row_agent['my_percentage'];
	
	$agnt_adm_perc = $row_agent['brokerage_perc'];
}
elseif ($_SESSION['grp'] == 'DISTRB')
{
	$agent_id='-';
	
	$distrbut=$conn->prepare("select * from distributor_pro where distr_id=?");
	$distrbut->execute(array($_SESSION['uid']));
	$row_distrbut = $distrbut->fetch(PDO::FETCH_ASSOC);
	
	$user_fname=$row_distrbut['distr_fname'];
	$user_lname=$row_distrbut['distr_lname'];
	$user_email=$row_distrbut['email_id'];
	
	$distr_id = $_SESSION['uid'];
	$agent_perc = 0; $agnt_adm_perc = $row_distrbut['my_percentage'];
}

?>
<style>

.ss
{
	background-color:transparent !important ;
}
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
#loading_side
{
	width: 100%;
	position: absolute;
    left: 250px;
	margin-top:5px;
}
#loading_cityrow
{
	width: 100%;
	position: absolute;
    left: 250px;
	margin-top:5px;
}

</style>
<?php 
if (!isset($_GET['val']))
{
$_GET['val']=1; 
}?>
<body onLoad="prelim(<?php if (isset($_GET['val'])) { echo $_GET['val']; } else { echo '1'; }  ?>);">
<!--<div class="loader_ax" style="display: none;"></div>-->
			<div class="container-fluid">
					<!-- Begin breadcrumb -->
					<!--<ol class="breadcrumb default square rsaquo sm">
						<li><a href="index.html"><i class="fa fa-home"></i></a></li>
						<li><a style="text-decoration:none" href="dashboard.php">Dashboard</a></li>
						<li><a style="text-decoration:none">Create Itinerary</a></li>
                        <li class="active">New</li>
                        
					</ol>-->
					<!-- End breadcrumb -->
					<form id="ExampleBootstrapValidationForm" name="thplan"  method="post" class="">
                    
                <div class="modal fade" id="stop_modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static"  data-keyboard="false"  >
										  <div class="modal-dialog ">
											<div class="modal-content modal-no-shadow modal-no-border bg-default">
											  <div class="modal-header" style="color:#9A4C0B">
											<!--	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
												<h4 class="modal-title" style="text-align:center">Message</h4>
											  </div>
                                            <div class="modal-body"  style="padding-top: 5px; padding-left: 5px;padding-right: 20px; padding-bottom: 5px" align="center"><img src="images/stop.jpg" alt="Stop" style="width:100px; height:100px; opacity:0.5;" /><br>
                                            <strong style="color:#933;">Sorry! Some seasons are locked. <br> [ Some hotels are unavailable to make your itinerary... ]</strong>
                                    </div>
											  <div class="modal-footer" style="padding-top:10px; padding-bottom:10px" id="plan_det_info_btns" >
                                              <center>
                                              <a class="btn btn-danger" href="agent_manaorder.php?mm=23311f54cbcb20fd815e2574e8b07b39&sm=f0e2efabf331f439ad99596cea1accf3">Ok</a>
                                              
                                            <!--   <button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button>-->
					  
                                                </center>
											  </div>
											</div><!-- /.modal-content .modal-no-shadow .modal-no-border .the-box .success .full -->
										  </div><!-- /.modal-dialog -->
										</div>
                    
                    
                    
                    
                    <div class="modal fade" id="Travel_info_mod" tabindex="-1" role="dialog" aria-hidden="false" data-keyboard="false" data-backdrop='static'>
										  <div class="modal-dialog modal-lg1">
											<div class="modal-content modal-no-shadow modal-no-border bg-default">
											  <!--<div class="modal-header" style="color:#9A4C0B">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="modal-title" style="text-align:center">Best Possible Travel Route</h4>
											  </div>-->
                                            <div class="modal-body" style="padding-top: 5px; padding-left: 5px;padding-right: 20px; padding-bottom: 5px" id="report_modal_body">
                                              <div class="row">
                                              <div class="col-sm-12" style="height:525px; overflow-y:scroll">
                                              <div id="dt_panel" style="background-color:#F5F2EF"></div>
                                              
                          <div class="panel with-nav-tabs panel-default panel-square" id="rep_tabss">
						  <div class="panel-heading">
						  <ul class="nav nav-tabs">
								<li ><a href="#shot_rep" data-toggle="tab">Short Report</a></li>
								<li class="active"><a href="#det_rep" data-toggle="tab">Itinerary Report</a></li>
                               <!-- <li><a href="#det_trv_rep" data-toggle="tab">Travel Report</a></li>-->
						  </ul>
						  </div>
						  <div id="panel-collapse-1" class="collapse in">
								<div class="panel-body">
									<div class="tab-content">
										<div class="tab-pane fade " id="shot_rep">
                                     <!--  <div id="addi_cost_toggle" style="border:1px solid #666; padding:6px; background-color:#FDE9BC; text-align:center"> ADD-ONS </div>
                                        <div id="addi_cost_load_div" style="display:none; background-color:#FFF9E9; border:1px solid #CCC"> addi_cost_load_div </div>-->
                                        
                                            <br><table id="best_route" class="table table-th-block" style="border:1px solid #E8D1BF">
                 <thead>
                 <tr style="background-color:#EAE1D8; color:#73471C;">
                 <th width="15%">Date</th><th width="20%" colspan="2">From</th><th width="20%">To</th><th width="18%">Kilometres</th><th width="15%">Time</th></tr>
                 </thead>
                 <tbody ></tbody>
                 </table>
                 <strong style="font-size:12px; color:#999">* Without sightseeing kms</strong>
										</div>
										<div class="tab-pane fade in active" id="det_rep">
										Please Wait ...
										</div>
                                        <div class="tab-pane fade" id="det_trv_rep">
										<div id="show_distot"  style="display:none"></div>
										</div>
									</div>
								</div>
							</div>
							</div>
									<!--<div id="show_distot" style="display:none"></div>-->
                                    <div id="show_days" style="display:none"></div>
                                    <div id="netamount" style="display:none"></div>
                       				<div id="show_terms" style="display:none"></div>
                                    </div>
                                    </div>
                                    </div>
                                    
                                    <div class="modal-body" style="padding-top: 5px; padding-left: 5px;padding-right: 20px; padding-bottom: 5px; display:none;" id="report_modal_body_confirm">
                                              <div class="row" style="margin-top:10px;">
                                              <div class="col-sm-12" >
                                              <small class="help-block" id="formerr" style=' display:none;color:#E9573F; text-align:center'></small>
											  <div class="form-group">
                                              	<div class="col-sm-6">
                                                <table>
                                                <tr>
                                                <td class="input-group-addon default tooltips" title="Enter guest name"><i class="fa fa-user"></i></td>
                                                <td><select id="gtitle" class="form-control" name="gtitle" tabindex="2" style="border-color: #DAD9D9; color:#848688">									<option value="Mr" selected>Mr.</option>
                                                <option value="Ms">Ms.</option>
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
                                    
									 <div class="modal-footer" style="padding-top:10px; padding-bottom:10px" id="travel_info_mod_footer">
                                     <center>
               <button type="button" class="btn btn-danger" data-dismiss="modal" id="trav_cancel" onClick="manage_status('cancel')">Cancel</button>
				<button type="button" class="btn btn-info" data-dismiss="modal" id="trav_save" onClick="manage_status('waiting')">Save</button>
               <button type="button" class="btn btn-success"  id="trav_confirm1" onClick="hide_modal_trav_body()">Confirm</button>
               
    <button type="button" class="btn btn-danger" id="trhotl_cancel" onClick="manage_trhot_status('cancel')" style="display:none;">Cancel</button>
    <button type="button" class="btn btn-info"  id="trhotl_pms" data-dismiss="modal" onClick="manage_trhot_status('plan_my_stay'); 	" style="display:none;">Plan My Stay</button>
    <button type="button" class="btn btn-info"  id="trhotl_pms1" data-dismiss="modal" onClick="back_to_stay(); 	" style="display:none;">Plan My Stay</button>
                                    </center>
									 </div>
                                     
                                    <div class="modal-footer" style="padding-top:10px; padding-bottom:10px; display:none;" id="travel_info_mod_footer11">
                                     <center>
				<button type="button" class="btn btn-info"  id="trav_back" onClick="show_modal_trav_body()">Back</button>
               <button type="button" class="btn btn-success"  id="trav_confirm" onClick="manage_status('conform')">Submit</button>
                                    </center>
									 </div>
											</div><!-- /.modal-content .modal-no-shadow .modal-no-border .the-box .success .full -->
										  </div><!-- /.modal-dialog -->
										</div>
                    
                    
					<div class="the-box" id="init_boxx">
      
                    <div id='modal_galary'><!-- loading modal dynamically for travel via-- from ajax_via_model.php --></div>
                    
                    <!-- after submit open this below modal to show itinerary details -->
                    <div class="modal fade" id="plan_det_info_mod" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static"  data-keyboard="false"  >
										  <div class="modal-dialog modal-lg1 ">
											<div class="modal-content modal-no-shadow modal-no-border bg-default">
											  <div class="modal-header" style="color:#9A4C0B">
											<!--	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
												<h4 class="modal-title" style="text-align:center">Your Special Itinerary Details</h4>
											  </div>
                                            <div class="modal-body" id="plan_det_info_modbody" style="padding-top: 5px; padding-left: 5px;padding-right: 20px; padding-bottom: 5px">
                                    </div>
											  <div class="modal-footer" style="padding-top:10px; padding-bottom:10px" id="plan_det_info_btns" >
                                              <center>
                       <button type="button" class="btn btn-danger" data-dismiss="modal" onClick="manage_status('cancel')">Cancel</button>
					  
                                                </center>
											  </div>
											</div><!-- /.modal-content .modal-no-shadow .modal-no-border .the-box .success .full -->
										  </div><!-- /.modal-dialog -->
										</div>
                    
                    <!-- Below modal for showing travel details -->
                    
                    <input type="hidden" id="check_boxs" name="check_boxs" value=<?php if (isset($_GET['val']) && $_GET['val'] == '1') { ?> "1" <?php } elseif (isset($_GET['val']) && $_GET['val'] == '2') { ?> "2" <?php } elseif (isset($_GET['val']) && $_GET['val'] == '3') { ?> "3" <?php } ?> />
                            <legend style="text-align:center; color:#036;margin-bottom: 5px;">Enter your trip details </legend>
                        	
                            <div class="form-group">
                                <div class="row">
                                <div class="col-sm-12" >
                                <div class="col-sm-4" align="right">
                                 <div class="radio">
                                <label style="font-weight:600; color:#2D426D; ">Choose Your Trip Option :</label>
                                </div>
                                </div>
								<div class="col-sm-3">
                                   	<div class="radio">
										<label style="font-weight:600; color:#2D426D"><input type="radio" value="1" id="" class="i-grey-square book_opt" name="book_opt" <?php if (isset($_GET['val']) && $_GET['val'] == '1') { ?> checked="checked" <?php } ?>>Transport + Hotel</label>
									</div>
								</div>
                                <div class="col-sm-3">
                                        <div class="radio">
												  <label style="font-weight:600; color:#2D426D" ><input type="radio" value="2" id="" class="i-grey-square book_opt" name="book_opt" <?php if (isset($_GET['val']) && $_GET['val'] == '2') { ?> checked="checked" <?php } ?>>Transport Only</label>
										</div>
                                </div>
                                <div class="col-sm-2">
                               <!-- <a class="btn btn-sm btn-default pull-right" href="agent_manaorder1.php?mm=23311f54cbcb20fd815e2574e8b07b39&sm=f0e2efabf331f439ad99596cea1accf3">New</a>-->
                                </div>
                                </div>
                                </div>
							</div>
                            
                            <div style="border:1px #D7E3EA solid">
                            <div  style="margin:5px; background-color:rgb(247, 251, 255);display:none; " id="new_pax_cnt">
                            <div class="row"   style=" margin:0px; ">
                          <!--  <p style="color:#5A81AD; text-align:center; margin-top:10px; "> Fill The Following Information</p>
                            <hr style="margin-top: 5px;margin-bottom: 5px;">-->
                            <div class="col-sm-12" align="center">
                            <div class="col-sm-4"><label class="control-label">Adult(s)</label></div>
                            <div class="col-sm-4"><label class="control-label">Child(ren) [5 -12 age]</label></div>
                            <div class="col-sm-4"><label class="control-label">Young Child(ren) [Below 5 age]</label></div>
                            </div> 
                            <div class="col-sm-12"  align="center" style="margin-top:5px">
                            <div class="col-sm-4"><div id="na"></div>
                            <input type="hidden" value="1" id="adult_no_cnt" name="adult_no_cnt"/>
                            <input type="hidden" value="1" id="adult_no_cal" name="adult_no_cal"/>
                            </div>
                            <div class="col-sm-4"><div id="nc512"></div>
                            <input type="hidden" value="0" id="child512_no_cnt" name="child512_no_cnt"/>
                            <input type="hidden" value="0" id="child512_no_cal" name="child512_no_cal"/></div>
                            <div class="col-sm-4"><div id="nc"></div>
                            <input type="hidden" value="0" id="child_no_cnt" name="child_no_cnt"/> 
                            <input type="hidden" value="0" id="child_no_cal" name="child_no_cal"/>   </div>
                            </div>
                                 
                            </div>
                            <br>
                            </div>
                            
                            <div  style="margin:5px; background-color:rgb(247, 251, 255);display:none" id="trvl_day_cnt">
                            <div class="row"  style="">
                            <div class="col-sm-12" align="center">
                            <div class="col-sm-4" id="lab_tavelpax_cnt" style="display:none"><label class="control-label" style="">Travellers Count</label></div>
                            <div class="col-sm-4"><label class="control-label" style="margin-left:36px">Travel Nights</label></div>
                            <div class="col-sm-4"><label class="control-label">Travel Days</label></div>
                            <div class="col-sm-4" id="lab_rrom_cntt"><label class="control-label" style="margin-left:-40px">Room Count</label></div>
                            </div>
                        	<div class="col-sm-12" align="center" style="margin-top:5px">
                            <div class="col-sm-4" id="div_tavelpax_cnt" style="display:none"><div id="np"></div></div>
                            <div class="col-sm-4"><div id="nd" style="margin-left:26px"></div></div>
                            <div class="col-sm-4"><div id="nn"></div></div>
                            <div class="col-sm-4" id="div_rrom_cntt"><div id="totrooms" style="margin-left:-20px"></div></div>
                        	</div>
                                <br />
		                </div>
                        <br>
                        </div>
                            </div>
                            
                            
                            <div class="form-group" id="arr_info" style="display:none; margin-top:10px">
                                <div class="row">
                                <div class="col-sm-12" style="margin-left:15px;">
                                	<div class="col-sm-1"></div>
                                    <label class="control-label col-sm-3" >Arrival Date & Time</label>
                                        <div class="col-sm-3">
                                        <div class="input-group">
                                        <span class="input-group-addon add-on tooltips" data-toggle='tooltip' data-original-title="Arrival Date"><i class="fa fa-calendar"></i></span>
                                     <input type="text" class="form-control datepickerz  tooltips" data-original-title='Choose Date' data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" name="arrdate" id="arrdate"  readonly style="  width: 100%;"></div>
                                     </div>
                                     <div class="col-sm-3">
                                     <div class="input-group">
                                      <span class="input-group-addon add-on tooltips" data-toggle='tooltip' data-original-title="Arrival Time"><i class="fa fa-clock-o"></i></span>
                                    <input type="text" class="form-control timepickera "   name="arrtime" id="arrtime" readonly style="  width: 100%;">
                                        </div>
                                        </div>
                                        <div class="col-sm-2"></div>
                                        </div>
                                </div>
                                
                                <div class="row" style="margin-top:10px">
                                 <div class="col-sm-12" style="margin-left:15px;">
                                	<div class="col-sm-1"></div>
                                    <label class="control-label col-sm-3" >Departure Date & Time</label>
                                        <div class="col-sm-3">
                                        <div class="input-group">
                                        <span class="input-group-addon add-on tooltips" data-toggle='tooltip' data-original-title="Departure Date"><i class="fa fa-calendar-o"></i></span>
                                     <input type="text" class="form-control tooltips" placeholder="Dept.Date" data-original-title='No need to choose' name="depart_ddat" id="depart_ddat" readonly ></div>
                                     </div>
                                     <div class="col-sm-3">
                                     <div class="input-group">
                                      <span class="input-group-addon add-on tooltips" data-toggle='tooltip' data-original-title="Departure Time"><i class="fa fa-clock-o"></i></span>
                                    <input type="text" class="form-control timepickera2 "  name="depart_time" id="depart_time"  style="  width: 100%;">
                                        </div>
                                        </div>
                                        <div class="col-sm-2"></div>
                                </div>
                                
                            </div>
                            
                            
                       		<!--<div class="form-group" id="arr_info" style="display:none">
                            	<div class="col-sm-12" align="center" style="margin-top:20px;">
                                <div class="col-sm-4" align="center" ><label class="control-label">Arrival Date &nbsp;&nbsp;</label></div>
                                 <div class="col-sm-4" align="center"><label class="control-label">Arrival Time &nbsp;&nbsp;</label></div>
                                <div class="col-sm-4" align="center"><label class="control-label">Departure Time &nbsp;&nbsp;</label></div>
                                  </div>
                                  <div class="col-sm-12" align="center" style="margin-top:20px;">
                                  <div class="col-sm-4" align="center"><input type="text" class="form-control datepickerz" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" name="arrdate" id="arrdate" readonly style="  width: 50%;"></div>
                                        <div class="col-sm-4" align="center">
                                        
                                        <input type="text" class="form-control timepickera"  name="arrtime" id="arrtime" readonly style="  width: 50%;">
                                           
                                        </div>
                                      <div class="col-sm-4 " align="center">
                                        	<input type="text" class="form-control timepickera"  name="depart_time" id="depart_time" readonly style="  width: 50%;">
                                             <br>
                                             <br>
                                        </div>
                                    </div>
                                   
                        			</div>-->
                           
                           <div id="hotel_cate_only"  class="form-group" style="display:none;" >
                             <?php 
								$cate=$conn->prepare("select DISTINCT category from hotel_pro where status='0'");
								$cate->execute();
								//$row_cate=mysql_fetch_assoc($cate);
								$row_cate=$cate->fetch(PDO::FETCH_ASSOC);
								$tot_cate=$cate->rowCount();
								?>
                           
                           </div>
                                                  
                            <div class="form-group" id="arrive_city" style="display:none; margin-top:10px">
                                <div class="row">
                                <div class="col-sm-12" style="margin-left:15px">
                                	<div class="col-sm-1"></div>
                                    <label class="control-label col-sm-3" >Select Arrival City</label>
                                        <div class="col-sm-6">
                                            <div id="loading_side"></div>
                                            <div class="load_cities">
                                            <?php
                                            
//$query_cities = "SELECT * FROM dvi_cities WHERE type = 'AD' and status = 0 ORDER BY name ASC";
$cities= $conn->prepare("select t2.* from vehicle_rent as t1 inner join dvi_cities as t2 on t2.id=t1.city group by t1.city");
$cities->execute();
$row_cities_main = $cities->fetchAll();
$totalRows_cities = $cities->rowCount();
?>

<select class="form-control chosen-select" id="st_city" name="st_city" tabindex="2" onChange="getvehicles(this.value);delrow();">
	<option value="">-- Select Source Point --</option>
    <?php
	foreach($row_cities_main as $row_cities)
	{
		
		$states = $conn->prepare("SELECT * FROM dvi_states where code=?");
		$states->execute(array($row_cities[region]));
		$row_states = $states->fetch(PDO::FETCH_ASSOC);
		$totalRows_states = $states->rowCount();
	?>
		<option value="<?php echo $row_cities['id'].'-'.$row_cities['ss_dist']; ?>"><?php echo $row_cities['name'].' - '.$row_states['name']; ?></option>
        <?php
	}
	
		?>
</select>

                                            </div>
                                        </div>
                                </div>
                                    
                                </div>
                            </div>
                        
                            <div class="form-group" id="sel_vehicl" style="display:none;">
                                <div class="row">
                                  <div class="col-sm-12" style="margin-left:15px">
                                <div class="col-sm-1"></div>
                                    <label class="control-label col-sm-3" >Select Vehicle</label>
                                    <div class="col-sm-6">
                                        <div id="load_vehicl"><input type="text" value="Please Select Above City" class="form-control" readonly></div>
                                    </div>
                                    <div class="col-sm-2">
                                        <a data-toggle="tooltip" title="Add 1 more vehicle" class="btn btn-default tooltips" id="addrow" style="display:none" onClick="create_elmt();getvehicles1();"><i class="fa fa-plus" style="color:#3EAFDB"></i></a>
                                    </div>
                                    </div>
                                </div>
                            </div>
							
                         	<div id="vehlist">
                         	</div>
							<br />
                            
                            <input type="hidden" id="vehdiv" name="vehdiv" value="0" />
                         <div id="hotel_cate"  class="form-group" style="display:none;" >
                             <?php 
								$cate=$conn->prepare("select DISTINCT category from hotel_pro where status='0'");
								$cate->execute();
								//$row_cate=mysql_fetch_assoc($cate);
								$row_cate=$cate->fetch(PDO::FETCH_ASSOC);
								$tot_cate=$cate->rowCount();
								?>
                          
                           </div>
                         
             			
                            
                            <div class="form-group" id="stay_detail_id" style="display:none;" >
                            	<div class="row">
                                
                                <div class="col-sm-12">
                                <div class="col-sm-3"><label>Adults</label></div>
                                <div class="col-sm-3"><div id="nadult"></div><input type="hidden" id="hcnt_adl" name="hcnt_adl" /></div>
                                <div class="col-sm-3"><label>Children</label></div>
                                <div class="col-sm-3"><div id="nchild"></div><input type="hidden" id="hcnt_chd" name="hcnt_chd" /></div>
                                </div>
                                <div class="col-sm-12"  style="margin-top:15px;">
                                <div class="col-sm-3"><label>Days of stay</label></div>
                                <div class="col-sm-3"><div id="stayno"></div></div>
                                <div class="col-sm-3"><label>Rooms count</label></div>
                                <div class="col-sm-3"><div id="roomno"></div></div>
                                <input type="hidden" value="" id="nos_rms" />
                                </div>
                            
                        		</div>
							</div>
                            
                            <div class="form-group" id="adult_child_cnt" style="display:none">
                            	
							</div>
                                
							<div class="form-group" id="itiner_plan" style="display:none">
                            	<div class="row" align="center">
                        	<a href="javascript:void()" onClick="trans_hotel()" style="text-decoration:none" class="btn btn-info">Plan My Itinerary</a>
                            	</div>
                            </div>

                                <div id="book_det" style="display:none; border:2px solid rgb(249, 241, 229)">
                                    <div class="form-group" style="background-color:#F7EDE1; color:#C60; height:31px; font-weight:600;">
                                   
                                        <div class="row">
                                            <div class="col-sm-12" >
                                            <div class="col-sm-2" align="center">Days</div>
                                            <div class="col-sm-2" align="center">Date</div>
                                             <div class="col-sm-3" align="center">From City</div>
                                             <div class="col-sm-3" align="center">To City</div>
                                             <div class="col-sm-2" align="center">Others</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group" id="div0">
                                    	<div class="row">
                                        <div class="col-sm-12">
                             <label class="control-label col-sm-2" id="labdiv0" style="text-align:center">Day - <label id="daycnt"></label></label>
                                    		<div class="col-sm-2">
                                            	<input type="text" class="form-control tooltips" data-original-title='Travel Date'  data-date-format="yyyy-mm-dd" placeholder="dd-mmm-YYYY" name="start_date[]" id="start_date00" readonly>
                                            </div>
                                      <div id="fromto_row0">
                                         <div class="col-sm-3">
                                         <input class="form-control bold-border tooltips" type="text" name="start_city[]" id="start_city00" readonly>
                                         </div>
                                         <div class="col-sm-3"  id="load_cityrow00" style=""></div>
                                       	 <div class="col-sm-2">
                                        <center><table width="100%">
                                                        <tr>
           <!--<td width="25%" align="center">
           <li class="dropdown " id="via0" style="list-style:none;">
									<a class="dropdown-toggle btn btn-info btn-sm tooltips" data-toggle="dropdown" data-original-title='Travel Via' onClick="load_via('00',0)" >
										<i class="glyphicon glyphicon-random"></i>
									</a>
									<ul class="dropdown-menu square with-triangle pull-right" id="via_indiv0">
										<li>
											<div class="nav-dropdown-heading" id="via_head0" style="height:40px;background-color: antiquewhite;color: #B3792C;">
											Travel Via
											</div>
											<div class="slimScrollDiv" style="position: relative; overflow: hidden; width: 450px; height: 250px;" id="div_via0">	<div id="load_via_div0" style="height:203px; overflow-y:scroll">
                                         
                                            </div>
                                            <hr style="margin-top: 5px; margin-bottom: 5px;">
                                            <input type="text" value="1" id="disp_via_cnt0" name="disp_via_cnt0">
                                            <input type="text" value="" id="via_tt0" name="via_tt0">
                                            <a class="btn btn-danger btn-sm" onClick="close_dropdown('0')" >Close</a> 
                                            </div>
										</li>
									</ul>
								</li></td>-->
            <td width="50%" align="center"><a  class=" btn btn-sm btn-info tooltips" data-toggle="modal"  data-original-title='Choose Travel Via' onClick="trv_via_fun('00',0)" ><i class="glyphicon glyphicon-random"></i>&nbsp; Via</a></td>
           <td width="50%" align="center"><a class="add_hots4 btn btn-sm btn-default tooltips " id="atxt0-0" data-original-title='Click To View This City Pictures'  ><i  class="fa fa-picture-o"></i></a></td>
           <!--<td width="25%" align="center"><a  id="vvatxt0-0" class="view_video btn btn-sm btn-default tooltips" data-original-title='Click To View This City Video' ><i class="fa fa-video-camera"></i></a></td>-->
           
           </tr></table></center>
          
                                              </div><!-- -->
                                          </div>
                                      </div>
                                      </div>
                                            <input type='hidden' id='d0' value='0' />
                                            <input type='hidden' id='c0' value='0' />
                                            <input type="hidden" id="callbackid" value="" />
                                            <input type="hidden" id="citarrid" value="" />
                                </div>
                                    <input type="hidden" id="daydiv" name="daydiv" value="0" />   
                                   
                                   
                                    <!--<div class="form-group">
                                    	<div class="row">
                                            <div class="col-sm-3">
                                            <a href="javascript:void()" onClick="my_route('m',<?php // echo $agent_perc; ?>,<?php //echo $agnt_adm_perc; ?>);" style="text-decoration:none" class="btn btn-warning"><strong style="color: #004000;">My planned itinerary</strong></a>
                                            </div>
                                            
                                            <div class="col-sm-3">
                                            <a href="javascript:void()" onClick="my_route('o',<?php //echo $agent_perc; ?>,<?php //echo $agnt_adm_perc; ?>);" style="text-decoration:none" class="btn btn-info"><strong style="color: #004000;">Optimized itinerary(DVi Suggested)</strong></a>
                                            </div>
                                            
                                            <div class="col-sm-3" id="stay_plan11" style="display:none">
                                                	<a href="javascript:void()" onClick="plan_my_stay('hotelandtravelonly')" style="text-decoration:none" class="btn btn-info"><strong style="color: #004000;">Plan My Stay</strong></a>
                                    		</div>
                                            
                                            </div>
                                            </div>-->
                                            
                                           
                                    	<div class="row">
                                            <div class="col-sm-12" align="center" >
                                            <hr  style="margin-top:10px; margin-bottom:10px;">
                                            <a href="javascript:void()" id="mypln" onClick="my_route('m',<?php echo $agent_perc; ?>,<?php echo $agnt_adm_perc; ?>);" style="text-decoration:none" class="btn btn-info">My planned itinerary</a>
                                           
                                           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="javascript:void()" id="divpln" onClick="my_route('o',<?php echo $agent_perc; ?>,<?php echo $agnt_adm_perc; ?>);" style="text-decoration:none" class="btn btn-info">Optimized itinerary (DVi Suggested)</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            
                                                
                                    		
                                            <br><br>
                                            <input type="hidden" id="viass_idss" name="viass_idss" >
                                            <input type="hidden" id="viass_dd" name="viass_dd" >
                                            </div>
                                            </div>
                                           
                                            
                                            
                            <input type="hidden" id="kit_kat" value=""  />
                            <input type="hidden" id="kit_cityidd" name="kit_cityidd" value=""  />
                            
                             <input type="hidden" id="kit_cityidd_prev" name="kit_cityidd_prev" value=""  />
                            <input type="hidden" value="0" name="traveldist" id="traveldist" />
                            <input type="hidden" value="0" name="traveldist_ess" id="traveldist_ess" />
                            <input type="hidden" value="0" name="day_traveldist" id="day_traveldist" />
                            <input type="hidden" value="0" name="day_travdist_ess" id="day_travdist_ess" />
                            <input type="hidden" value="0" name="dt_dist" id="dt_dist" />
                            <input type="hidden" value="0" name="dt_alssdist" id="dt_alssdist" />
                            <input type="hidden" value="0" name="dt_altrdist" id="dt_altrdist" />
                            <input type="hidden" value="" name="dt_citid" id="dt_citid" />
                            <input type="hidden" value="" name="dt_detls" id="dt_detls" />
                            <input type="hidden" value="0" name="trv_cnt" id="trv_cnt" />
                            <input type="hidden" value="0" name="trv_days" id="trv_days" />
                            <input type="hidden" value="0" name="trv_nights" id="trv_nights" />
                            <input type="hidden" value="0" name="trv_adult" id="trv_adult" />
                            <input type="hidden" value="0" name="trv_child" id="trv_child" />
                            <input type="hidden" value="0" name="trv_room" id="trv_room" />
                            <input type="hidden" value="" id="vehicles" name="vehicles[]" />
                            <input type="hidden" value="" id="dest_id" name="dest_id" />
                            <input type='hidden' name='ret_dist' id='ret_dist' value=0>
                            <input type='hidden' name='tr_tot_amt' id='tr_tot_amt' value=0>
                            <input type='hidden' name='pervehamt' id='pervehamt' value=0>
                            <input type='hidden' name='vehcitid' id='vehcitid' value=''>
                            <input type='hidden' name='permt_amt' id='permt_amt' value=0>
                            <input type='hidden' name='citydata[]' id='citydata' value=''>
                            <input type='hidden' name='formatdata' id='formatdata' value=''>
                            <input type="hidden" name="veh_upl" id="veh_upl" value=''>
                            <input type="hidden" name="all_veh_upl" id="all_veh_upl" value=''>
                            <input type="hidden" name="cid_arr" id="cid_arr" value=''>
                            <input type="hidden" name="veh_cit_dis" id="veh_cit_dis" value=''>
							<input type="hidden" name="subform" value="1">
                            
                                            </div>
                     
                                <div class="form-group" id="stay_plan" style="display:none">
                                	<div class="row">
                                		<div class="col-sm-12">
                                    		<div>
                                        	<a href="javascript:void()" class="btn btn-info" onClick="plan_my_stay('hotelonly')" style="text-decoration:none"><strong style="color: #004000;">&nbsp;Plan My Stay</strong></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                
                     <div id="directions_panel" ></div>
                               <div class="the-box rounded" id="stay"  style="display:none;">
                                <div class="row table-responsive">
                                <div id="show_stay_quote" style=" display:none;">
                                <p id="stay_para">
                                    <strong> Dear Mr. <?php echo $user_fname.' '.$user_lname; ?></strong><br /> <br />
    
    <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Greetings !!!!</strong>
    <br /><br />
    
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Thank you very much for your all time support. Welcome to the world of difference , please find the below is the quote for your kind perusal. We have tried our level best to quote you the best deals in the market, if you have any queries , we request you to call us or write our reservation team to send you the best deals.<br />
                                    </p>
                                <strong>Hotel(s) selected for itinerary</strong>
                                <table id="stay_quote_table" class="table table-th-block " width="100%" >
                                <thead id="base_id0"><th width="15%" style="color:indianred">Date</th><th width="20%" style="color:indianred">Hotel Detail</th><th width="20%" style="color:indianred">Room Detail</th><th width="18%" style="color:indianred">Food Details</th><th width="15%" style="color:indianred">Others</th></thead>
                                </table>
                                <div id="show_terms1" ></div>
                                <input type="hidden" id="hotel_only_tot_amt" name="hotel_only_tot_amt" />
                                </div>
	                                    </div>
                                
                                <input type="hidden" value="" id="day_of_stay" name="day_of_stay"  />
                                <input type="hidden" value="" id="room_of_num" name="room_of_num"  />
                                <input type="hidden" id="tab_cnt" value="1" />
                                <input type="hidden" id="htl_id0" value="" />

	                                </div>
                                    <div class="the-box" id="sun" style="background-color:#EFF2F5; display:none;" >
                                
                                <center>
                                <button type="button" id="vali_quote" class="btn btn-info" name="vali_quote"  onclick="validate_stay()" value="vali_quote_val" >Validate</button>
                                <?php /*?><button type="button" id="get_sts_quote" class="btn btn-info" name="view_quote"  onclick="view_stay_quote(<?php echo $agent_perc; ?>),show_get_quote(),finalcall(0)" value="view_quote_val" >Get Quote</button><?php */?>
                   				<button type="button" id="get_sts_quote" class="btn btn-info" name="view_quote"  onclick="return quote_dt(<?php echo $agent_perc; ?>,<?php echo $agnt_adm_perc; ?>)" value="view_quote_val" style="display:none;">Get Quote</button>
                                 <!--<button type="button" id="subplan" class="btn btn-info btn-block" data-toggle="modal" data-target="#SuccessModalColor" style="text-decoration:none; display:none">SUBMIT FOR APPROVAL</button>--
                                <button type="button" style="display:none;" id="get_prev_quote" class="btn btn-sm btn-default" onclick="show_prev_quote()" >Back</button>-->
                                 <button type="button" id="final_save_btn" style="display:none;"  class="btn btn-info" data-toggle="modal" data-target="#SuccessModalColor" >Proceed</button>
                                 <button type="button" id="trav_quot" class="btn btn-info" name="trav_quot"  onclick="return quote_dt(<?php echo $agent_perc; ?>,<?php echo $agnt_adm_perc; ?>)" value="view_quote_val" style="display:none;background-color: #EFF2F5; border-color: #EFF2F5;"></button>
                                </center>
                                 
                                </div>
                               
                                     <div id="vehrents"></div>
				<!--	</div><!-- /.the-box -
                    
                    </form>-->
                
                    
                    <div class="the-box" id="gmap_div2" style="display:none;">
	                    <div class="row">
    	                    <div class="col-sm-12" id="diagramm">
        	                    <h4 class="small-title">TRAVEL MAP - ROAD PATH</h4>
                          		<div id="gmap_path2" style="height:1000px">
                               	</div>
                           	</div>
                        </div>
					</div>
             </div>
             </div>
             
             <div class="the-box" id="secondary_boxx" style="display:none">
             
             <div class="row">
             
             
             <div class="col-sm-12" style="margin-top:10px;border: 1px sol;border-top: 1px solid #ccc;">
             <div id="tableee" style=" background-color:#FFF">
<div align="center">
<p style=" font-weight:600; text-align:center">Room Information</p>
<table width="80%"  id="new_room_table" bgcolor="#EAF4FA" border="1px solid" style=" border:1px solid #DFE9EF; background-color:#EAF4FA; color:#365686; margin-top:20px" >
<tr id="new_rm_tr0"><th style="padding:10px" width="10%">Rooms</th><th style="padding:10px" width="10%">Adult</th><th style="padding:10px" width="15%">5 - 12 age child(ren)</th><th style="padding:10px" width="18%">Below 5 age child(ren)</th><th style="padding:10px" width="15%">Extra Bed</th></tr>
<tr id="new_rm_tr1"><td style="padding:10px" id="room_nw_td1">Room 1</td>
<td style="padding:10px" id="adlt_nw_td1"><input type="text" id="sel_adlt_nw1" name="sel_adlt_nw1"  readonly class="form-control tooltips" ></td>
<td style="padding:10px" id="ch512_nw_td1"><input type="text" id="sel_nw_512ch1" name="sel_nw_512ch1"  value="0" readonly class="form-control tooltips" ></td>
<td style="padding:10px" id="chb5_nw_td1"><input type="text" id="sel_nw_b5ch1" name="sel_nw_b5ch1" value="0" readonly class="form-control tooltips" ></td>
<td style="padding:10px" id="extr_nw_td1"><select id="sel_nw_extr1" name="sel_nw_extr1" class="form-control chosen-select"><option value="-" selected>Nil</option><option value="0">With Bed</option><option value="1">Without Bed</option></select></td></tr>
</table>
<input type="hidden" value="<?php echo "both_food"; ?>" name="<?php echo 'food_categ_dvi'; ?>" id="<?php echo 'food_categ_dvi'; ?>"/>
</div>
<div class="col-sm-12" id="food_only_div" style="margin-top:20px;">
<div class="col-sm-5" align="right"> Choose Food :</div>
<div class="col-sm-3">
<select onChange="set_food_categ(this.value)" data-placeholder="Choose Food " class="form-control chosen-select" id="foodd_id" name="foodd_id">
											<option></option>
                                            <option value="lunch_rate"> Breakfast &amp; Lunch Only </option>								
                                            <option value="dinner_rate"> Breakfast &amp; Dinner Only </option>                          
                                            <option value="both_food" selected> Breakfast, Lunch &amp; Dinner </option>	
                                            <option value='no'>Breakfast Only</option>			
</select>
</div>
<div class="col-sm-4"></div>
</div>

</div>
                                </div>
             </div>
             <div class="row">
             <div class="col-sm-12" style="margin-top:20px"> 
             <hr style="margin-top: 10px;margin-bottom: 10px;">
                 <div class="col-sm-4"><a href="javascript:void()" id="stay_plan11" onClick="backto_init_boxx()" style="text-decoration:none; " class="btn btn-default">Back</a></div>
                 <div class="col-sm-3"><a href="javascript:void()" id="stay_plan11" onClick="dvi_sugg_hotel()" style="text-decoration:none; " class="btn btn-info">DVI Suggested Quote </a><input type="hidden" value="1" id='dvi_sug_hotel_txt' name="dvi_sug_hotel_txt"></div>
                <div class="col-sm-3">
             	<a href="javascript:void()" id="stay_plan11" onClick="plan_my_stay('hotelandtravelonly')" style="text-decoration:none; " class="btn btn-info">Plan On Own </a><input type="hidden" value="0" id='plan_my_stay_txt' name="plan_my_stay_txt"></div>
                <div class="col-sm-2"></div>
             </div>
             </div>
             
             <!-- Dvi suggested hotel div start -->
             <div class="row" id="dvi_sugg_hotel_div" style="display:none;">
             <div class="col-sm-12"  style=" margin-top:15px;">
             <hr style=" margin-top:10px; margin-bottom:10px">
             <p style="color:#CCC; font-weight:600; text-align:center">Hotel Information ( DVI Suggested )</p>
            	<div id="load_div_sugg_quote"><!-- Dvi sugg quote from dvi_sugg_hotels.php --></div>
            
            <div class="col-sm-12" align="center" style=" margin-top:15px;">
                              <a class="btn btn-info" id='resume_hotel_sub' name="resume_hotel_sub" onClick="resume_later('dvi_sugg')" >Save It</a>                      <!--   &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-info" id='plan_hotel_sub' name="plan_hotel_sub" onClick="show_hotel_list('dvi_sugg')" >Proceed</a>-->
            </div>
            
             </div>
             </div>
             <!-- Dvi suggested hotel div end -->
             <!-- Plan My Stay hotel start -->
             <div class="row" id="planmy_hotel_div" style="display:none">
             <div class="col-sm-12"  style=" margin-top:15px; ">
             <hr style=" margin-top:10px; margin-bottom:10px">
             <p style="color:#CCC; font-weight:600; text-align:center">Hotel Information ( Plan On Own )</p>
<div id="table_collection0"> <!-- parent div -->
<!-- <table style="margin-top:20px" id="stay_tabell0"  class="table table-th-block " width="100%" ><thead align="center" ><th width="100%"><center>Progress Bar</center></th></table>-->
</div>
                                <input type="hidden" value="" id="prv_ch">
                                <div class="row" align="center">
                                <a class="btn btn-info" id="resume_hotel_pow" name="resume_hotel_pow" onClick="resume_later('plan_on_own')">Save It</a>
                                 <a class="btn btn-info" id='plan_hotel_sub' name="plan_hotel_sub" onClick="show_hotel_list('plan_mystay')" >Proceed</a>
                                </div>
             </div>
             </div>
             <!-- Plan My Stay hotel end -->
             
             </div>
             <!--</div>-->
             
             
             </form>
             </div>
</body>	
<script>
	
	$('ul.dropdown-menu').on('click', function(event){
        event.stopPropagation();
		});

$(document).ready(function(e) {
	
    $('.chosen-select').chosen({'width':'100%'});
});

function no_need_add_ons()
{
	$('#addi_cost_load_div').slideToggle(500);
}

function addi_cost_toggle_click()
{
			var gen_cities=$('#kit_cityidd_prev').val().trim();
			var arr_dat=$('#arrdate').val().trim();
			if($('#check_boxs').val()=='1'){
				var tot_pers=(parseInt($('#adult_no_cnt').val())+parseInt($('#child512_no_cnt').val()));
			}else{
				var tot_pers=parseInt($("#np .dp-numberPicker-input").val());
			}
			if($('#addi_cost_load_div').children().length == 0)
			{
					$('.loader_ax').fadeIn();
					$.get('AGENT/ajax_addi_cost.php?type=1&cities='+gen_cities+'&arr_dat='+arr_dat+'&tot_pers='+tot_pers,function(addi_res)
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

function only_number(n)
{
	 $('#addi_persons'+n).val($('#addi_persons'+n).val().replace(/[^0-9\.]/g,''));
	  if ((event.which != 46) && (event.which < 48 || event.which > 57)){
                event.preventDefault();
            }
}

function addi_add_on_change(dat)
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
}

var ndval;

$(document).ready(function()
{
	$("#np").dpNumberPicker(
	{
		min: 1,
	});
	
	$('#np').find('.dp-numberPicker-add').attr('id','add_np');
	$('#np').find('.dp-numberPicker-sub').attr('id','sub_np');
	$('#np').find('.dp-numberPicker-input').attr('id','input_np');
	
	$("#nd").dpNumberPicker(
	{
		min: 1,
		value:1
	});
	$('#nd').find('.dp-numberPicker-add').attr('id','add_nd');
	$('#nd').find('.dp-numberPicker-sub').attr('id','sub_nd');
	$('#nd').find('.dp-numberPicker-input').attr('id','input_nd');

	$("#nn").dpNumberPicker(
	{
		min: 2,
		value: 2
	});
	
	$('#nn').find('.dp-numberPicker-add').attr('id','add_nn');
	$('#nn').find('.dp-numberPicker-sub').attr('id','sub_nn');
	$('#nn').find('.dp-numberPicker-input').attr('id','input_nn');
	
	//$('#nn').find('.dp-numberPicker-add').attr('id','add_nn').addClass('disabled');
	//$('#nn').find('.dp-numberPicker-sub').attr('id','sub_nn').addClass('disabled');
	//$('#nn').find('.dp-numberPicker-input').attr('id','input_nn');
	
	$("#stayno").dpNumberPicker({ min: 1 });
	
	$("#roomno").dpNumberPicker({ min: 1, value:1 });
	
	$("#totrooms").dpNumberPicker({ min: 1, value:1 });
	
	$("#nadult").dpNumberPicker({ min: 0, value: 1 });
	
	$("#nchild").dpNumberPicker({min: 0, value: 0 });
	
	$("#na").dpNumberPicker({ min: 1, value:1 });
	
	$('#na').find('.dp-numberPicker-add').attr('id','add_na');
	$('#na').find('.dp-numberPicker-sub').attr('id','sub_na');
	$('#na').find('.dp-numberPicker-input').attr('id','input_na');
	
	$("#nc").dpNumberPicker(
	{
		min: 0,
		value:0,
	});
	
	$('#nc').find('.dp-numberPicker-add').attr('id','add_nc');
	$('#nc').find('.dp-numberPicker-sub').attr('id','sub_nc');
	$('#nc').find('.dp-numberPicker-input').attr('id','input_nc');
	
	$("#nc512").dpNumberPicker(
	{
		min: 0,
		value:0,
	});
	
	$('#nc512').find('.dp-numberPicker-add').attr('id','add_nc512');
	$('#nc512').find('.dp-numberPicker-sub').attr('id','sub_nc512');
	$('#nc512').find('.dp-numberPicker-input').attr('id','input_nc512');
	
	
	$('.book_opt').on('ifChecked', function(event){
		//alert($(this).val());
		
		<?php if ($_SESSION['grp'] == 'AGENT')
		{
			$code_nm = 'agent_manaorder';
		}
		else
		{
			$code_nm = 'distrb_manaorder';
		}
			?>
			if($(this).val() == 1)
			{
				window.location.href = '<?php echo $code_nm; ?>.php?mm=<?php echo $_GET['mm']; ?>&sm=<?php echo $_GET['sm'];?>&val=1';
			}
			else if($(this).val() == 2)
			{
				window.location.href = '<?php echo $code_nm; ?>.php?mm=<?php echo $_GET['mm']; ?>&sm=<?php echo $_GET['sm'];?>&val=2';
			}
			else if($(this).val() == 3)
			{
				window.location.href = '<?php echo $code_nm; ?>.php?mm=<?php echo $_GET['mm']; ?>&sm=<?php echo $_GET['sm'];?>&val=3';
			}
	});
});

$(document).ready(function(e) {
	var new_cnt=1;
	var room_new_cnt;
	$('#add_na').click(function()
	{
		$("#adult_no_cnt").val(parseInt($("#adult_no_cnt").val())+1);
		$("#adult_no_cal").val($("#adult_no_cnt").val());
		
		new_cnt=$("#np .dp-numberPicker-input").val();
		$("#np .dp-numberPicker-input").val(parseInt(new_cnt)+1);
	
		room_new_cnt=Math.ceil(parseInt($("#np .dp-numberPicker-input").val())/4);
		$("#totrooms .dp-numberPicker-input").val(room_new_cnt);
		$("#totrooms").dpNumberPicker({ min: room_new_cnt, value:room_new_cnt });
	});
	
	$('#sub_na').click(function()
	{
		
		if(parseInt($("#adult_no_cnt").val())>1)
		{
		$("#adult_no_cnt").val(parseInt($("#adult_no_cnt").val())-1);
		$("#adult_no_cal").val($("#adult_no_cnt").val());
		
		new_cnt=$("#np .dp-numberPicker-input").val();
		$("#np .dp-numberPicker-input").val(parseInt(new_cnt)-1);	
	
		room_new_cnt=Math.ceil(parseInt($("#np .dp-numberPicker-input").val())/4);
		$("#totrooms .dp-numberPicker-input").val(room_new_cnt);
		$("#totrooms").dpNumberPicker({ min: room_new_cnt, value:room_new_cnt });
		}
	});
	
	
	$('#add_nc').click(function()
	{
		$("#child_no_cnt").val(parseInt($("#child_no_cnt").val())+1);
		$("#child_no_cal").val($("#child_no_cnt").val());
	new_cnt=$("#np .dp-numberPicker-input").val();
	$("#np .dp-numberPicker-input").val(parseInt(new_cnt)+1);
	
	room_new_cnt=Math.ceil(parseInt($("#np .dp-numberPicker-input").val())/4);
	$("#totrooms .dp-numberPicker-input").val(room_new_cnt);
	$("#totrooms").dpNumberPicker({ min: room_new_cnt, value:room_new_cnt });
	});
	
	$('#sub_nc').click(function()
	{
		if(parseInt($("#child_no_cnt").val())>0)
		{
		$("#child_no_cnt").val(parseInt($("#child_no_cnt").val())-1);
		$("#child_no_cal").val($("#child_no_cnt").val());
		
		new_cnt=$("#np .dp-numberPicker-input").val();
		$("#np .dp-numberPicker-input").val(parseInt(new_cnt)-1);
	
		room_new_cnt=Math.ceil(parseInt($("#np .dp-numberPicker-input").val())/4);
		$("#totrooms .dp-numberPicker-input").val(room_new_cnt);	
		$("#totrooms").dpNumberPicker({ min: room_new_cnt, value:room_new_cnt });
		}
		
	});
	
    $('#add_nc512').click(function()
	{
	$("#child512_no_cnt").val(parseInt($("#child512_no_cnt").val())+1);
	$("#child512_no_cal").val($("#child512_no_cnt").val());
	
	new_cnt=$("#np .dp-numberPicker-input").val();
	$("#np .dp-numberPicker-input").val(parseInt(new_cnt)+1);
	
	
	room_new_cnt=Math.ceil(parseInt($("#np .dp-numberPicker-input").val())/4);
	$("#totrooms .dp-numberPicker-input").val(room_new_cnt);
	$("#totrooms").dpNumberPicker({ min: room_new_cnt, value:room_new_cnt });
	});
	
	$('#sub_nc512').click(function()
	{
	if(parseInt($("#child512_no_cnt").val())>0)
		{
		$("#child512_no_cnt").val(parseInt($("#child512_no_cnt").val())-1);
		$("#child512_no_cal").val($("#child512_no_cnt").val());
		
		new_cnt=$("#np .dp-numberPicker-input").val();
		$("#np .dp-numberPicker-input").val(parseInt(new_cnt)-1);
	
		room_new_cnt=Math.ceil(parseInt($("#np .dp-numberPicker-input").val())/4);
		$("#totrooms .dp-numberPicker-input").val(room_new_cnt);
		$("#totrooms").dpNumberPicker({ min: room_new_cnt, value:room_new_cnt });
		}
		
	});
});



function prelim(getv)
{
	if (getv == 1)
	{
		prelim1();
	}
	else if(getv == 2)
	{
		prelim2();
	}
	else if(getv == 3)
	{
		prelim3();
	}
}

function prelim1()//Transport + hotel
{
	$('#hotel_cate').show();
	$('#hotel_cate_only').hide();
	$('#sun').hide();
	$('#check_boxs').val('1');
	$('#lab_rrom_cntt').show();
	$('#div_rrom_cntt').show();
	$('#lab_tavelpax_cnt').hide();
	$('#div_tavelpax_cnt').hide();
	$('#get_sts_quote').hide();//get cote
	$('#new_pax_cnt').show();
	$('#trvlr_cnt').show();
	$('#arr_info').show();
	$('#arrive_city').show();
	$('#sel_vehicl').show();
	$('#trvl_day_cnt').show();
	$('#trvl_stay_det').show();
	$('#trvl_room_det').show();
	$('#adult_child_cnt').show();
	$('#itiner_plan').show();
	$('#stay_plan').hide();
	$('#stay').hide();
	$('#stay_para').hide();
	$('#tableee').hide();
	$('#vali_quote').show();
	if($('#of_tr0').length>0)
	{
		$('#of_tr0').remove();
	}
	
	if ($('#tab_cnt').val()>1) 
	{
		for(var ttt=0;ttt<=$('#tab_cnt').val();ttt++)
		{
			$('#of_tr0').remove();
			if($('#tr_id'+ttt).length>0)
			{
				if(ttt != 0)
				{
					$('#tr_id'+ttt).remove();
					$('#of_tr'+ttt).remove();
				}
				for(var ccc=0;ccc<$('#nos_rms').val();ccc++)
				{
					$('#tr_id'+ttt+'_'+ccc).remove();
				}
			}
		}
	}
			
	if($('#daydiv').val())
	{
		for(var ii=1; ii<$('#daydiv').val(); ii++)
		{
			$('#div'+ii).hide();
		}
		$('#book_det').hide();
	}
			
			
	$('#stay_detail_id').hide();
	$('#div0').show();
	$('#gmap_div1').hide();
}

function prelim2() //Transport only
{
	$('#hotel_cate').hide();
	$('#hotel_cate_only').hide();
	//$('#stay_quote_table').hide();
	$('#sun').hide();
	$('#check_boxs').val('2');
	$('#lab_rrom_cntt').hide();
	$('#div_rrom_cntt').hide();
	$('#lab_tavelpax_cnt').show();
	$('#div_tavelpax_cnt').show();
	$('#get_sts_quote').hide();//get quote
	
	$('#new_pax_cnt').hide();
	$('#trvlr_cnt').show();////show()
	$('#arr_info').show();////show()
	$('#arrive_city').show();//show()
	$('#sel_vehicl').show();//show()
	$('#trvl_day_cnt').show();//show()
	$('#trvl_stay_det').hide();//show()
	$('#trvl_room_det').hide();//show()trvl_room_det
	$('#adult_child_cnt').hide();
	$('#itiner_plan').show();//show()
	$('#stay_plan').hide();
	$('#stay_plan11').hide();
	$('#stay').hide();
	$('#stay_detail_id').hide();
	$('#vali_quote').hide();
	
	$('#div0').show();
	$('#tableee').hide();
	if($('#of_tr0').length>0)
	{
		$('#of_tr0').remove();
	}
	if ($('#tab_cnt').val()>1) 
	{
		for(var ttt=0;ttt<=$('#tab_cnt').val();ttt++)
		{
			if($('#tr_id'+ttt).length>0)
			{
				$('#of_tr'+ttt).remove();
				if(ttt != 0)
				{
					$('#tr_id'+ttt).remove();
					$('#of_tr'+ttt).remove();
				}
				for(var ccc=0;ccc<$('#nos_rms').val();ccc++)
				{
					$('#tr_id'+ttt+'_'+ccc).remove();
				}
			}
		}
	}
			
	if($('#daydiv').val())
	{
		for(var ii=1; ii<$('#daydiv').val(); ii++)
		{
			$('#div'+ii).hide();
		}
		$('#book_det').hide();
	}
}

function prelim3() //hotel only
{
			$('#hotel_cate').hide();
			$('#hotel_cate_only').show();
			$('#sun').hide();
			$('#check_boxs').val('3');
			
		
			$('#stay').hide();
			$('#trvlr_cnt').hide();
			$('#arr_info').show();
			$('#arrive_city').hide();//show()
			$('#sel_vehicl').hide();
			$('#trvl_day_cnt').hide();//show()
			$('#trvl_stay_det').hide();//show()
			$('#trvl_room_det').hide();//show()
			$('#adult_child_cnt').hide();//show()
			$('#stay_plan').show();//show()
			$('#stay_plan11').hide();
			$('#stay_para').show();
			$('#stay_detail_id').show();
			$('#itiner_plan').hide();
			//$('#show_rental').hide();
			$('#gmap_div1').hide();
			$('#gmap_div2').hide();
			$('#div0').hide();
			$('#tableee').hide();

if($('#of_tr0').length>0)
	{
$('#of_tr0').remove();
	}
	if($('#tr_id0_0').length>0)
	{
$('#tr_id0_0').remove();
	}

if ($('#tab_cnt').val()>1) 
{	
	for(var ttt=0;ttt<=$('#tab_cnt').val();ttt++)
	{
		if($('#tr_id'+ttt).length>0)
		{
			if(ttt != 0)
			{
				$('#tr_id'+ttt).remove();
				$('#of_tr'+ttt).remove();
			}
			for(var ccc=0;ccc<$('#nos_rms').val();ccc++)
			{
				$('#tr_id'+ttt+'_'+ccc).remove();
			}
		}
	}
}

$("#stayno").dpNumberPicker({ min: 1,});
if($('#daydiv').val())
{
	for(var ii=1; ii<$('#daydiv').val(); ii++)
	{
		$('#div'+ii).hide();
	}
	$('#book_det').hide();
}
}

function validate_stay()
{
	var csk=0;
	var prv_c=$('#prv_ch').val();
	if(prv_c != '')
	{
	$('#'+prv_c).css('background-color','#FFF');
	}
	var days=parseInt($("#nd .dp-numberPicker-input").val());
	var rooms=parseInt($("#totrooms .dp-numberPicker-input").val());
	
	var ck_ch512=0;
	var ck_chb5=0;
	for(var chy1=1;chy1<=rooms;chy1++)
	{
		ck_ch512=ck_ch512+parseInt($('#sel_nw_512ch'+chy1).val());
		ck_chb5=ck_chb5+parseInt($('#sel_nw_b5ch'+chy1).val());
	}
	
	if(ck_ch512!=$('#child512_no_cnt').val())
	{
		alert('Children 5 to 12 age group - Count value is mismatch,please validate..');
		$('#sel_adlt_nw1').focus();
		csk=1;
		return false;
	}
	
	if(ck_chb5 != $('#child_no_cnt').val())
	{
		alert('Children Below-5 age group - Count value is mismatch,please validate..');
		$('#sel_adlt_nw1').focus();
		csk=1;
		return false;
	}
	
	for(var dd=1;dd<=days;dd++)
	{
		var mybtn=parseInt($('body #vali_quote').offset().top);
		var dates=$('#sdat'+dd).val();
		if($('#hotel_sel_id'+dd).val().trim() =='')
		{
			
			alert('hotel does not choosed in '+dates);
			$('#hotel_nw_td'+dd).css('background-color','#FCC');
			$('#prv_ch').val('hotel_nw_td'+dd);
			csk=1;
			return false;
		}
	}
			for(var dd2=1;dd2<=days;dd2++)
			{
				var dates2=$('#sdat'+dd2).val();
				for(var chy2=1;chy2<=rooms;chy2++)
				{
					if($('#hot_rm_id'+dd2+'_'+chy2).val()=='')
					{
						alert('hotel room does not choosed in '+dates2);
						$('#tdroom_nw_td'+dd2).css('background-color','#FCC');
						$('#prv_ch').val('tdroom_nw_td'+dd2);
						csk=1;
						return false;
					}
				}
			}//parent for end
	
	if(csk==0)
	{
		alert('Hotel Details are validated successfully ..');
		$('#get_sts_quote').show();
		return true;
	}

}

function view_stay_quote(agnt_percnt,adm_brk_per)
{
	
	/*$('#show_stay_quote tbody tr').empty();
	$('#stay').show();
	var prt=parseInt($("#nd .dp-numberPicker-input").val());
	var chd=parseInt($("#totrooms .dp-numberPicker-input").val());
	var date;
	var view_elements,room_nmc;
	
	var tot_per_day=0;
	for(var s=1;s<=prt;s++)
	{
		var perday_amt=0;
		view_elements="<tr id='intr_id"+s+"'><td id='indt_id"+s+"'></td><td id='inhotel_id"+s+"'></td><td id='inroom_id"+s+"'></td><td id='foods_id"+s+"'></td><td id='inother_id"+s+"'><input type='hidden' id='perdayid"+s+"' name='perdayid"+s+"'></td></tr>";
		$(view_elements).appendTo('#stay_quote_table');
		
	date=$('#sdat'+s).val();
	label_date='<label>'+date+'</label><br>';
	$('#indt_id'+s).html(label_date);
	
	if($('#check_boxs').val()=='1')
	{
		s1=s-1;
		city_nm=$('#kitcity'+s1).val();
	}
	label_city='<label>In&nbsp;'+city_nm+'</label>';
	$('#indt_id'+s).append(label_city);
	
	hotel_nmp=$('#hotel_sel_id'+s+' option:selected').text();
	label_hotel='<label>'+hotel_nmp+'</label><br><label style="color:darkgray">'+$('#hot_addrs'+s).val()+'</label>';
	$('#inhotel_id'+s).html(label_hotel);

	for(var nw_rms=1;nw_rms<=chd;nw_rms++)
	{
		room_nmp=$('#hot_rm_id'+s+'_'+nw_rms+' option:selected').text();
		room_nmp_rent=+parseInt($('#hot_rm_rent'+s+'_'+nw_rms).val());
		tot_per_day=tot_per_day+room_nmp_rent;
		
		//for extra bed rate calculation
		if($('#sel_nw_extr'+nw_rms).val()=='0')
		{
			tot_per_day=tot_per_day+parseInt($('#withbed_rate'+s).val());
		}else if($('#sel_nw_extr'+nw_rms).val()=='1')
		{
			tot_per_day=tot_per_day+parseInt($('#withoutbed_rate'+s).val());
		}else if($('#sel_nw_extr'+nw_rms).val()=='-')
		{
			tot_per_day=tot_per_day+0;
		}
		
	}
	
	//for food rate calculation
	var food_person=parseInt($('#adult_no_cnt').val())+parseInt($('#child512_no_cnt').val());
	var ratt,oth_ratt;
	if($('#food_id'+s).val()=='lunch_rate')
	{
		tot_per_day=tot_per_day+(food_person*parseInt($('#foood_rate'+s).val()));
	}else if($('#food_id'+s).val()=='dinner_rate')
	{
		tot_per_day=tot_per_day+(food_person*parseInt($('#foood_rate'+s).val()));
	}else if($('#food_id'+s).val()=='both_food')
	{
		 ratt=$('#foood_rate'+s).val().split(',');
		tot_per_day=tot_per_day+(parseInt(food_person)* parseInt(ratt[0]));
	}
	
	oth_ratt=$('#others_rate'+s).val().split(',');
	tot_per_day=tot_per_day+parseInt(oth_ratt[0]);
	
	label_room='<label>'+room_nmp+'&nbsp;Room</label><br>';
	$('#inroom_id'+s).html(label_room);

	food_nmp=$('#food_id'+s+' option:selected').text();
	
	if(food_nmp.trim() != '')
	{
	var arr_frate=$('#foood_rate'+s).val().split(',');
	label_food='<label>&nbsp;'+food_nmp+'</label><br>';
	$('#foods_id'+s).append(label_food);
	}else
	{
		label_food='<label>&nbsp;No Food</label><br>';
	$('#foods_id'+s).append(label_food);
	}
	
	others_nmp=$('#food_id'+s+' option:selected').text();
	
	var values1 = []; 
	$('#ext_item_id'+s+' :selected').each(function(i, selected){ 
		  values1[i] = $(selected).val(); 
		});
	
		if(values1 != '')
		{
		label_other='<label>&nbsp;'+values1+'&nbsp;</label><br>';
		$('#inother_id'+s).append(label_other);
		}else
		{
			label_other='<label>&nbsp;No Special Amenities</label><br>';
		$('#inother_id'+s).append(label_other);
		}
	}
	//total amount
	$('#hotel_only_tot_amt').val(tot_per_day);
	view_elements1="<tr id='toat'><td id='tot_tr' colspan='5'></td></tr>";
	$(view_elements1).appendTo('#stay_quote_table');
	
	var net_tot = document.getElementById('netamount');
	
	net_tot.innerHTML = '';
	var hotel_chrg = $('#hotel_only_tot_amt').val();
	
	var trans_chrg = $("#tr_tot_amt").val();
	if ($('#check_boxs').val() == '2')
	{
		net_tot.innerHTML+= "<strong>Charge for transport: "+trans_chrg + "</strong>" + '<br>';
	}

	var grand_tot = parseInt(tot_per_day)+parseInt(trans_chrg);
	var admn_grt_ttol=parseInt(grand_tot) + ((parseInt(adm_brk_per) / 100) * parseInt(grand_tot));
	var agnt_grand_totl = parseInt(admn_grt_ttol) + ((parseInt(agnt_percnt) / 100) * parseInt(admn_grt_ttol));
	
	var label_totsts='<center><label>Total amount for transport and accomodation = Rs. '+Math.round(agnt_grand_totl)+'/-</label></center><br>';
	$('#tot_tr').append(label_totsts);
	var terms = "<br><strong><font color='red'>Terms & Conditions: </font></strong><br><strong>Package  Includes:</strong><br> Transfers and sightseeing  By  deluxe  tourists vehicle <strong><font color='red'>( Vehicles up hill driving and down hill would be on Non AC)</font></strong><br>Toll & Parking <br>Service Taxes <br>All local sightseeing in the same vehicle, every day after breakfast till sunset ( 0700 AM to 08PM)<br><font color='red'>If staying IN the House boat </font><br> House Boat with all Meals and Ac In the house boat operates from 09 PM to 06 Am only. <br> If the booking includes the extra bed it is facilitated with a folding cot or a mattress as an extra bed, as per the hotel policy.<br><br><strong><font color='red'> Hotel Check in and check out time at Hotel is 1200 Noon </font></strong><br><br> Rate does not include <br> Any international / Domestic Air Fare if any quoted separately <br> English speaking guide / escort charges Airport Tax <br> Extra bed All meals (other than above mentioned ones) <br> Personal nature expenses such as telephone calls, Laundry, soft / hard drinks, lunch tipping etc., <br> Camera fee at monuments. <br> Monument OR TEMPLE Entrance Fees Boat ride <br> Insurance. <br> Any Porterage services at Airport / Railway station. <br> Any other expenses not mentioned in the above cost. <br> Rates are subject to change in case of inflation or tax hikes, rates based on currently applicable taxes <br><br>IMPORTANT: Kindly note that names of hotels mentioned above only indicate that our rates have been based on usage of these hotels and it is not to be construed that accommodation is confirmed at these hotels until and unless we convey such confirmation to you. In the event of any of the above mentioned hotels not becoming available we shall book alternate accommodation at a similar or next best available hotel and shall pass on the difference of rates (supplement/reduction whatever applicable). <br> <font color='red'>Cancellation policy </font><br> CANCELLATION 30% of Package cost, if the cancellation is made 30 days prior to the departure. 50% of package cost, if the cancellation is made between 30-14 days prior to the departure.    |   70% of package cost, if the cancellation is made between 17-7 days prior to the departure.     |     100% of package cost, if the cancellation is made 7 days or less prior to the departure. <br> General  Policy <br> Child cost depends upon hotels rule which may vary from one hotel to another. The most common rules are as under...<br><br> Child up to 5 years is free. Child above 5 years to 12 will be charged as per hotel rule. Child above 12 years will be charged as adult. <br> If your reservation at hotels includes an extra bed, most hotels provide a folding cot or a mattress on floor as an extra bed. <br> Check in and check out in most of the hotels at 1200 noon in the cities, In Hill stastions check in 1400 hrs check out 11 hrs, Early check-in or late check-out is subject to availability and may be chargeable by the hotel. <br> To request for an early check-in or late check-out, kindly contact the hotel directly or inform us prior.";
				


				document.getElementById('show_terms1').innerHTML=terms;*/
				
}





function find_hotel_categ(cid,no)
{
	var datt=$('#sdat'+no).val();
	var type=18;
		$.get('AGENT/ajax_agent.php?cid='+cid+'&no='+no+'&type='+type+'&tdate='+datt,function(result){
			//alert(cid+' no '+no+' '+result);
	$('#catag_nw_td'+no).empty().html(result);
		$('.chosen').chosen({'width':'100%'});
	});
}


function show_child_bed(val,pno)
{
if(val != '0')
{
$('#extra_bed'+pno).prop("disabled",false).addClass("chosen-select");
$('.chosen-select').chosen({width:'100%'});
}else
{
$('#extra_id'+pno).empty().html("<input class='form-control' type='text' disabled='disabled'><input type='hidden' id='extra_rate"+pno+"' name='extra_rate"+pno+"'  value='0'/>");}
//alert('cfdfno'+pno);extra_id0
}

function show_child_bed1(val,pno,cno)
{
	//alert('c'+val);
	if(val != '0')
	{
$('#extra_bed'+pno+'_'+cno).prop("disabled",false).addClass("chosen-select");
$('.chosen-select').chosen({width:'100%'});
	}else
	{
		$('#extra_id'+pno+'_'+cno).empty().html("<input class='form-control' type='text' disabled='disabled'><input type='hidden' id='extra_rate"+pno+"_"+cno+"' name='extra_rate"+pno+"_"+cno+"'  value='0'/>");
	}
}



$(document).ready(function(e) {

	$('#add_nd').click(function()
	{
		var daval1=parseInt($('#input_nd').val())+1;
		$('#input_nn').val(daval1);
	});
	
	$('#sub_nd').click(function()
	{
		var daval2=parseInt($('#input_nd').val())+1;
		$('#input_nn').val(daval2);
	});
	
	
	
	$('#add_nn').click(function()
	{
		var daval1=parseInt($('#input_nn').val())-1;
		$('#input_nd').val(daval1);
	});
	
	$('#sub_nn').click(function()
	{
		var daval2=parseInt($('#input_nn').val())-1;
		$('#input_nd').val(daval2);
	});
	
	
	
	
    $('#add_np').click(function()
	{
		$('#total_no_cnt').val($('#input_np').val());
		$("#na").dpNumberPicker({ min: 0, value:$('#input_np').val(), max:$('#input_np').val()}); 
		/*$('#na').find('.dp-numberPicker-add').attr('id','add_na');
		$('#na').find('.dp-numberPicker-sub').attr('id','sub_na');
		$('#na').find('.dp-numberPicker-input').attr('id','input_na');
		$('#adult_no_cnt').val($('#input_np').val());
		$('#add_na').attr('onclick','add_childdd()');
		$('#sub_na').attr('onclick','sub_childdd()');*/
		
		$("#nc512").dpNumberPicker({ min: 0, value:0, max:$('#input_np').val()}); 
		$("#nc").dpNumberPicker({ min: 0, value:0, max:$('#input_np').val()}); 
		$('#nc512').find('.dp-numberPicker-add').attr('id','add_nc512');
		$('#nc512').find('.dp-numberPicker-sub').attr('id','sub_nc512');
		$('#nc512').find('.dp-numberPicker-input').attr('id','input_nc512');
		$('#add_nc512').attr('onclick','add_nc512()');
		$('#sub_nc512').attr('onclick','sub_nc512()');
		$('#child_no_cnt').val(0);
		$('#child512_no_cnt').val(0);
	});
	
	$('#sub_np').click(function()
	{
		$('#total_no_cnt').val($('#input_np').val());
		$("#na").dpNumberPicker({ min: 0, value:$('#input_np').val(),  max:$('#input_np').val()}); 
		$('#na').find('.dp-numberPicker-add').attr('id','add_na');
		$('#na').find('.dp-numberPicker-sub').attr('id','sub_na');
		$('#na').find('.dp-numberPicker-input').attr('id','input_na');
		$('#input_na').val($('#input_np').val());
		$('#add_na').attr('onclick','add_childdd()');
		$('#sub_na').attr('onclick','sub_childdd()');
		
		$("#nc512").dpNumberPicker({ min: 0, max:$('#input_np').val()}); 
		$('#nc512').find('.dp-numberPicker-add').attr('id','add_nc512');
		$('#nc512').find('.dp-numberPicker-sub').attr('id','sub_nc512');
		$('#nc512').find('.dp-numberPicker-input').attr('id','input_nc512');
		
		$('#add_nc512').attr('onclick','add_nc512()');
		$('#sub_nc512').attr('onclick','sub_nc512()');
		$('#adult_no_cnt').val($('#input_np').val());
		$('#child512_no_cnt').val(0);
		$('#child_no_cnt').val(0);
		$('#input_nc512').val(0);
		
		
	});

});

function add_nc512()
{
	$('#child512_no_cnt').val(parseInt($("#nc512 .dp-numberPicker-input").val()));	
}

function sub_nc512()
{ 
	$('#child512_no_cnt').val(parseInt($("#nc512 .dp-numberPicker-input").val()));
}

function set_value(cid,no)
{
	//alert(cid);
	//cid=cid.trim();
	$('#pic_view'+no).attr('href','AGENT/view_img_desc.php?cid='+cid);
	$('#video_view'+no).attr('href','AGENT/view_video_spot.php?cid='+cid);
	$('#htl_id'+no).val(cid);	
}

function remove_this_row(pno,cno)
{
		$('#tr_id'+pno+'_'+cno).hide();
}
function add_new_row(pno,cno)
{
	var next_cno=parseInt(cno)+1;
	var prev_cno=parseInt(cno)-1;

	var new_row="<tr id='tr_id"+pno+"_"+cno+"'><td id='city_td"+pno+"_"+cno+"'></td><td id='categ_td"+pno+"_"+cno+"'></td><td id='hotel_td"+pno+"_"+cno+"'></td><td id='room_td"+pno+"_"+cno+"'><input class='form-control' type='text'  disabled='disabled' /></td><td id='adult_td"+pno+"_"+cno+"'><select id='adult_sel"+pno+"_"+cno+"' onchange='find_no_youth1(this.value,"+pno+","+cno+")' name='adult_sel"+pno+"_"+cno+"' class='form-control chosen-select' data-placeholder='Choose'><option></option><option value='0'>Nil</option><option value='1' >1</option><option value='2' >2</option><option value='3' >3</option></select></td><td id='youth_td"+pno+"_"+cno+"'><input class='form-control' type='text'  disabled='disabled' /></td><td id='child_td"+pno+"_"+cno+"'><input class='form-control' type='text'  disabled='disabled' /></td><td id='extra_id"+pno+"_"+cno+"'><input class='form-control' type='text' disabled='disabled'><input type='hidden' id='extra_rate"+pno+"_"+cno+"' name='extra_rate"+pno+"_"+cno+"' value='0' /></td></tr>";
	

	if($('#tr_id'+pno+"_"+prev_cno).length>0)
	{
		$('#add_btn'+pno).attr('onclick','add_new_row('+pno+','+next_cno+')');
		$(new_row).insertAfter('#tr_id'+pno+'_'+prev_cno);
	}
	else
	{
		$('#add_btn'+pno).attr('onclick','add_new_row('+pno+','+next_cno+')');
		$(new_row).insertAfter('#tr_id'+pno);
	}
	
	var cityyy=$('#htl_id'+pno).val();
}

function find_all_categ(cid,pno)
{
	
	var type=21;
	var datt=$('#sdat'+pno).val();
	$('.loader_ax').fadeIn();
	$.get('AGENT/ajax_agent.php?cid='+cid+'&pno='+pno+'&type='+type+'&tdate='+datt,function(result){
		$('.loader_ax').fadeOut(500);
		//alert(result);
	$('#hotel_nw_td'+pno).empty().html(result);
	$('.chosen').chosen({'width':'100%'});
	});
}

function find_special_amenity(hid,no)
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

function find_food_category(hid,no)
{
	var sdt1=$('#sdat'+no).val();
	var type=23;
	//$('.loader_ax').fadeIn();
	$.get('AGENT/ajax_agent.php?hid='+hid+'&pno='+no+'&type='+type+'&daty='+sdt1,function(result){
		$('.loader_ax').fadeOut(500);
	$('#food_nw_td'+no).empty().html(result);
	$('.chosen-select').chosen({width:'100%'});
	});
}

function find_hotel_rooms(hid,no)
{
			var type=2;
			var rms=parseInt($("#totrooms .dp-numberPicker-input").val());	
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
	
}

function find_hb_room_rent(val,no,rmno){
	
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
	
}

function fun_hb_add(hid,rno,tno)
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
}


function fun_hb_remove(rno,tno)
{
	$('#tr_hb_'+rno+'_'+tno).remove();
}

function find_stay_hotel1(cid,pno,cno)
{	
	var type=5,cates;
	var datt=$('#sdate'+pno).val();
	
	if($('#check_boxs').val() == '1')
	{
		 cates=$('#hotel_catet_sel').val();
	}else if($('#check_boxs').val() == '3')
	{
		 cates=$('#hotel_catet_sel_only').val();
	}
	
	$.get('AGENT/ajax_agent.php?cid='+cid+'&pno='+pno+'&cno='+cno+'&type='+type+'&cates='+cates+'&tdate='+datt,function(result){
		//alert(result);
	$('#hotel_td'+pno+'_'+cno).empty().html(result);
	 $('.chosen').chosen({'width':'100%'});
	});
}

function find_hotel_rooms1(hid,pno,cno)
{
	var type=6;
	$('.loader_ax').fadeIn();
	$.get('AGENT/ajax_agent.php?hid='+hid+'&pno='+pno+'&cno='+cno+'&type='+type,function(result){
		$('.loader_ax').fadeOut(500);
	$('#room_td'+pno+'_'+cno).empty().html(result);
	//$('hotel_sel_id'+pno+'_'+cno).attr('id','sel'+pno+'_'+cno);
	
	 $('.chosen').chosen({'width':'100%'});
	});
}


function find_room_adult1(sno,pno,cno)
{
	//alert('re');	
	var type=7;
	$.get('AGENT/ajax_agent.php?sno='+sno+'&pno='+pno+'&cno='+cno+'&type='+type,function(result){
	$('#adult_td'+pno+'_'+cno).empty().html(result);
	 $('.chosen').chosen({'width':'100%'});
	});
	
	var type2=8;
	$.get('AGENT/ajax_agent.php?sno='+sno+'&pno='+pno+'&cno='+cno+'&type='+type2,function(result){
	$('#child_td'+pno+'_'+cno).empty().html(result);
	 $('.chosen').chosen({'width':'100%'});
	});
	
}

function find_stay_hotel(categ,cid,no)
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
}

function find_room_adult(sno,no)
{
	//alert('re');	
	var type=3;
	$('.loader_ax').fadeIn();
	$.get('AGENT/ajax_agent.php?sno='+sno+'&no='+no+'&type='+type,function(result){
	$('#adult_td'+no).empty().html(result);
	 $('.chosen').chosen({'width':'100%'});
	});
	
	var type1=4;
	$.get('AGENT/ajax_agent.php?sno='+sno+'&no='+no+'&type='+type1,function(result){
		$('.loader_ax').fadeOut(500);
	$('#child_td'+no).empty().html(result);
	 $('.chosen').chosen({'width':'100%'});
	});
	
}

var hiu;

function find_room_rent1(val,pno,cno)
{
	var datt=$('#sdate'+pno).val();
	var type=10;
	$('.loader_ax').fadeIn();
	$.get('AGENT/ajax_agent.php?val='+val+'&date='+datt+'&type='+type,function(result){
		$('.loader_ax').fadeOut(500);
	$('#hot_rm_rent'+pno+'_'+cno).val(result.trim());
	});
}

function find_room_rent(val,no,rmno)
{	$('.loader_ax').fadeIn();
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
	for(var yo1=2;yo1<=parseInt($("#totrooms .dp-numberPicker-input").val());yo1++)
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
}

function find_rate_cbed(val,no)
{
	var datt=$('#sdat'+no).val();
	var ht_id=$('#hotel_sel_id'+no).val();
	var type=11;
	$.get('AGENT/ajax_agent.php?val='+val+'&date='+datt+'&type='+type+'&hot_id='+ht_id+'&no='+no,function(result){
	$('#tdroom_nw_td'+no).append(result);
	});
}

function find_rate_cbed1(val,pno,cno)
{
	//alert(val+','+pno+','+cno);
	
	var datt=$('#sdate'+pno).val();
	
	//var ht_id=$('#sel'+pno+'_'+cno).val();
	var ht_id=$('#hotel_sel_id'+pno).val();
	//var ht_id=$('#hotel_sel_id'+pno+'_'+cno).val();
	//alert('date'+datt+'  ht_id'+ht_id);
	var type=11;
	$.get('AGENT/ajax_agent.php?val='+val+'&date='+datt+'&type='+type+'&hot_id='+ht_id,function(result){
	$('#extra_rate'+pno+'_'+cno).val(result.trim());
	});	
}


function find_food_rate(val,no)
{
    var datt=$('#sdat'+no).val();
	var nums=parseInt($("#totrooms .dp-numberPicker-input").val());
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
}


function find_no_youth1(val,pno,cno)
{
	//alert(val+' / '+pno+' / '+cno);

	var type=15;
	$.get('AGENT/ajax_agent.php?val='+val+'&pno='+pno+'&type='+type+'&cno='+cno,function(result){
	$('#youth_td'+pno+'_'+cno).empty().html(result);
	$('#child_td'+pno+'_'+cno).empty().html('<input class="form-control" type="text" disabled="disabled">');
	$('.chosen').chosen({width:'100%'});
	});
	
	if(pno == 0)
	{
	for(var yout=1;yout<$('#day_of_stay').val();yout++)
			{  
			 $('.chosen-select').chosen('destroy');
				hiu=$('#adult_sel'+pno+'_'+cno+' option:selected').val();
				$('#adult_sel'+yout+'_'+cno+' option').each(function(i,val)
				{
					if(val.value==hiu)
					{
					$(this).attr('selected',true);
					find_no_youth1(hiu,yout,cno);
					$('.chosen-select').chosen({width:'100%'});
					}
				});
				
				$('.chosen-select').chosen({width:'100%'});
				
			}
	}
	
	
}


function change_below5(val,adl_val,no)
{
	var type=16;
	$.get('AGENT/ajax_agent.php?val='+val+'&no='+no+'&type='+type+'&adl_val='+adl_val,function(result){
	$('#child_td'+no).empty().html(result);
	$('.chosen').chosen({width:'100%'});
	});
	
	if(no == 0)
	{
	for(var yut=1;yut<$('#day_of_stay').val();yut++)
			{ 
			 $('.chosen').chosen('destroy');
				hiu=$('#youth_sel'+no+' option:selected').val();
				$('#youth_sel'+yut+' option').each(function(i,val)
				{ 
					if(val.value==hiu)
					{
					$(this).attr('selected',true);
					change_below5(val,adl_val,yut);
					$('.chosen').chosen({width:'100%'});
					}
				});
				
				$('.chosen').chosen({width:'100%'});
				
			}
	}
	
	

}


function change_below51(val,adl_val,pno,cno)
{
	var type=17;
	$.get('AGENT/ajax_agent.php?val='+val+'&adl_val='+adl_val+'&pno='+pno+'&type='+type+'&cno='+cno,function(result){
	$('#child_td'+pno+'_'+cno).empty().html(result);
	$('.chosen').chosen({width:'100%'});
	});
	
	if(pno == 0)
	{
	for(var yut=1;yut<$('#day_of_stay').val();yut++)
			{ 
			 $('.chosen').chosen('destroy');
				hiu=$('#youth_sel'+pno+'_'+cno+' option:selected').val();
				$('#youth_sel'+yut+'_'+cno+' option').each(function(i,val)
				{ 
				
					if(val.value==hiu)
					{
					$(this).attr('selected',true);
					change_below51(val,adl_val,yut,cno);
					$('.chosen').chosen({width:'100%'});
					}
				});
				
				$('.chosen').chosen({width:'100%'});
				
			}
	}
}


function extra_below5(val,no)
{
if($('#hotel_sel_id'+no).length>0) {
	if($('#hotel_sel_id'+no).val() !='')
	{
			if(val!=0)
			{
				var type=24;
				$.get('AGENT/ajax_agent.php?no='+no+'&type='+type,function(result){
					//alert(result)
				$('#extra_id'+no).empty().html(result);
				$('.chosen').chosen({width:'100%'});
			});
			}else{
				$('#extra_id'+no).empty().html("<input class='form-control' id='extra_bed"+no+"' name='extra_bed"+no+"' value='-' type='text' disabled='disabled'><input type='hidden' id='extra_rate"+no+"' name='extra_rate"+no+"'  value='0'/>");
			}
	}else{
		alert("Please choose hotel..")	;
	}
}else{
alert("No hotel available..")	
}

}


function extra_below51(val,pno,cno)
{
if($('#hotel_sel_id'+pno).length>0) {
	if($('#hotel_sel_id'+pno).val() !='')
	{
			if(val!=0)
			{
				var type=25;
				$.get('AGENT/ajax_agent.php?pno='+pno+'&type='+type+'&cno='+cno,function(result){
					//alert(result)
				$('#extra_id'+pno+'_'+cno).empty().html(result);
				$('.chosen').chosen({width:'100%'});
			});
			}else{
				$('#extra_id'+pno+'_'+cno).empty().html("<input class='form-control' id='extra_bed"+pno+"_"+cno+"' name='extra_bed"+pno+"_"+cno+"' value='-' type='text' disabled='disabled'><input type='hidden' id='extra_rate"+pno+"_"+cno+"' name='extra_rate"+pno+"_"+cno+"'  value='0'/>");
			}
	}else{
		alert("Please choose hotel..")	;
	}
}else{
alert("No hotel available..");	
}
	
}

/*
$(document).ready(function(e) {
    $('.datepickerk').click(function() {
		alert('fdf'+$(this).val());
		/*datepicker({
    	onSelect: function(dateText, inst) {
        var date = $(this).val();
        alert('on select triggered'+date);
    }
	})
	});
});

function active_hotel_fun(pno)
{
	//alert('ff');
	
}*/

function find_others_rate(val,no)
{
//alert(val+'='+no);	
	var values = []; 
	$('#ext_item_id'+no+' :selected').each(function(i, selected){ 
	  values[i] = $(selected).val(); 
	});

	var datt=$('#sdate'+no).val();
	
	var nums=$('#room_of_num').val();
	var ht_id=$('#hotel_sel_id'+no).val();
	/*for(var ui=0;ui<nums-1;ui++)
	{
		ht_id=ht_id+','+$('#sel'+no+'_'+ui).val();
	}*/
	//alert(ht_id+','+values);
	var type=13;
	$.get('AGENT/ajax_agent.php?val='+values+'&date='+datt+'&type='+type+'&hot_id='+ht_id,function(result){
		
		if(result.trim() == '')
		{
			$('#others_rate'+no).val('0');
		}else
		{
		$('#others_rate'+no).val(result.trim());
		}
	});	
}

function show_get_quote()
{
	$('#final_save_btn').show();
	//alert("div"+$('#check_boxs').val());
	//$('#tableee').hide();
	//$('#get_sts_quote').hide();
	if($('#check_boxs').val() !='2')
	{
		$('#show_stay_quote').show();
		if($('#check_boxs').val() =='3')
		{
			$('#gmap_div1').hide();
		}
		if($('#check_boxs').val() =='1')
		{
			$('#stay').css('margin-top','-45px');
			$('#stay').css('border-top-style','hidden');
		}
	}
	else
	{
		$('#gmap_div1').show();	
		$('#stay').hide();
		$('#show_stay_quote').hide();
	}

	
	if($('#check_boxs').val() =='3')
	{
		$('#gmap_div1').hide();
		//alert('hhh'+$('#check_boxs').val());
	}
}


function find_no_chb5(val,no)
{
var adlt_val=$('#sel_adlt_nw'+no).val();
var ch512_val=$('#sel_nw_512ch'+no).val();;
var num_new_rooms=parseInt($("#totrooms .dp-numberPicker-input").val());	
		if($('#child_no_cnt').val()>0 && $('#child512_no_cnt').val()>0)// for both the children having 
		{
				if(adlt_val==3 && ch512_val == 1)
				{//no b5
		$('#chb5_nw_td'+no).empty().html("<input type='text' id='sel_nw_b5ch"+no+"' name='sel_nw_b5ch"+no+"' class='form-control tooltips' value='0'>");
				}else if(adlt_val==3 && ch512_val == 0)
				{
					// b5 - 1
			$('#chb5_nw_td'+no).empty().html("<select id='sel_nw_b5ch"+no+"' name='sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem(this.value,"+no+")' class='form-control chosen-select' data-placeholder='choose'><option selected value='0'>choose</option><option value='1'>1</option></select>");
		$('.chosen-select').chosen({width:'100%'});
				}
				else if(adlt_val==2 && ch512_val == 2)
				{// no b5
		$('#chb5_nw_td'+no).empty().html("<input type='text' id='sel_nw_b5ch"+no+"' name='sel_nw_b5ch"+no+"' class='form-control tooltips' value='0'>");
				}else if(adlt_val==2 && ch512_val == 1)
				{//  b5 -1
				$('#chb5_nw_td'+no).empty().html("<select id='sel_nw_b5ch"+no+"' name='sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem(this.value,"+no+")' class='form-control chosen-select' data-placeholder='choose'><option selected value='0'>choose</option><option value='1'>1</option></select>");
		$('.chosen-select').chosen({width:'100%'});
					
				}else if(adlt_val==2 && ch512_val == 0)
				{//  b5 -2
				$('#chb5_nw_td'+no).empty().html("<select id='sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem(this.value,"+no+")' name='sel_nw_b5ch"+no+"' class='form-control chosen-select' data-placeholder='choose'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
		$('.chosen-select').chosen({width:'100%'});	
				}else if(adlt_val==1 && ch512_val == 3)
				{//  b5 - no
		$('#chb5_nw_td'+no).empty().html("<input type='text' id='sel_nw_b5ch"+no+"' name='sel_nw_b5ch"+no+"' class='form-control tooltips' value='0'>");			
				}else if(adlt_val==1 && ch512_val == 2)
				{//  b5 - 1
				$('#chb5_nw_td'+no).empty().html("<select id='sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem(this.value,"+no+")' name='sel_nw_b5ch"+no+"' class='form-control chosen-select' data-placeholder='choose'><option selected value='0'>choose</option><option value='1'>1</option></select>");
		$('.chosen-select').chosen({width:'100%'});
					
				}else if(adlt_val==1 && ch512_val == 1)
				{//  b5 - 2
				$('#chb5_nw_td'+no).empty().html("<select id='sel_nw_b5ch"+no+"' name='sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem(this.value,"+no+")' class='form-control chosen-select' data-placeholder='choose'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
		$('.chosen-select').chosen({width:'100%'});		
				}else if(adlt_val==1 && ch512_val == 0)
				{//  b5 - 3
		$('#chb5_nw_td'+no).empty().html("<select id='sel_nw_b5ch"+no+"' name='sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem(this.value,"+no+")' class='form-control chosen-select' data-placeholder='choose'> <option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>");
		$('.chosen-select').chosen({width:'100%'});		
				}
		}else if($('#child_no_cnt')>0)
		{
			alert('for no 5-12 but with b5ch');
		}
		else{// else for no young child ( below 5 not chosen)
			for(var ki=1;ki<=num_new_rooms;ki++)
			{
				$('#sel_nw_b5ch'+ki).removeAttr('data-original-title').attr('data-original-title','No need');
				$('.tooltips').tooltip();
			}
		}
		
}
function find_chbelow5_rem(val,no)
{
	//alert(val+'_'+no);
	
	var tt_ad_val, tt_ad_val1;
	var num_new_rooms=parseInt($("#totrooms .dp-numberPicker-input").val());
	var chb5_ttoll=$('#child_no_cnt').val();	
		var no_nw=no+1;
		var jcnt=0;
		var cur_val=val;
		//alert("ch512"+$('#child512_no_cal').val());
		//alert($('#sel_adlt_nw'+no_nw).val());
		for(var dis=no_nw;dis<=num_new_rooms;dis++)
		{				
	$('#chb5_nw_td'+dis).empty().html("<input id='sel_nw_b5ch"+dis+"' name='sel_nw_b5ch"+dis+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
		//jcnt=jcnt+parseInt($('#sel_nw_512ch'+dis).val());
		}
		
		for(var prv=1;prv<no_nw;prv++)
		{
		jcnt=jcnt+parseInt($('#sel_nw_b5ch'+prv).val());
		}
		$('#child_no_cal').val(parseInt($('#child_no_cnt').val())-jcnt);
		
		
		//$('#child512_no_cal').val(parseInt($('#child512_no_cal').val())-parseInt(cur_val));
		
if(num_new_rooms >= no_nw)
{	
		if($('#sel_adlt_nw'+no_nw).val()==3)
		{
			if($('#sel_nw_512ch'+no_nw).val()==1)
			{ //alert("adl 3 - c512h 1");
				
			$('#chb5_nw_td'+no_nw).empty().html("<input id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
			//no b5	
			}else{
				//alert("adl 3 - c512h 0");
			//1 -b5	
					if($('#child_no_cal').val()>=1)
					{
			$('#chb5_nw_td'+no_nw).empty().html("<select id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
$('.chosen-select').chosen({width:'100%'});
					}else{
						//no need for
							for( var ui=no_nw; ui<=num_new_rooms; ui++)
							{
						$('#chb5_nw_td'+ui).empty().html("<input id='sel_nw_b5ch"+ui+"' name='sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
							}
					}
			}
			
		}else if($('#sel_adlt_nw'+no_nw).val()==2)
		{
			if($('#sel_nw_512ch'+no_nw).val()==2)
			{
				//alert("adl 2 - c512h 2");
				if($('#child_no_cal').val()>=1)
				{
				$('#chb5_nw_td'+no_nw).empty().html("<input id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
				}else{
						for( var ui=no_nw; ui<=num_new_rooms; ui++)
						{
						$('#chb5_nw_td'+ui).empty().html("<input id='sel_nw_b5ch"+ui+"' name='sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
						}
				//no need for	
				}
				
			//no b5	
			}else if($('#sel_nw_512ch'+no_nw).val()==1)
			{
				//alert("adl 2 - c512h 1");
				if($('#child_no_cal').val()>=1)
				{
					$('#chb5_nw_td'+no_nw).empty().html("<select id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
$('.chosen-select').chosen({width:'100%'});
				}else{
					//no need for
						for( var ui=no_nw; ui<=num_new_rooms; ui++)
						{
						$('#chb5_nw_td'+ui).empty().html("<input id='sel_nw_b5ch"+ui+"' name='sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
						}
				}
				//1-b5
			}else{
				//alert("adl 2 - c512h 0");
					if($('#child_no_cal').val()>=2)
					{
					$('#chb5_nw_td'+no_nw).empty().html("<select id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
$('.chosen-select').chosen({width:'100%'});
					}else if($('#child_no_cal').val()>=1)
					{
						$('#chb5_nw_td'+no_nw).empty().html("<select id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
$('.chosen-select').chosen({width:'100%'});
					}else{
						//no need for
							for( var ui=no_nw; ui<=num_new_rooms; ui++)
							{
						$('#chb5_nw_td'+ui).empty().html("<input id='sel_nw_b5ch"+ui+"' name='sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
							}
					}
				//2-b5
			}
		}else if($('#sel_adlt_nw'+no_nw).val()==1)
		{
			if($('#sel_nw_512ch'+no_nw).val()==3)
			{
				//alert("adl 1 - c512h 3");
					if($('#child_no_cal').val()>=1)
					{
				$('#chb5_nw_td'+no_nw).empty().html("<input id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
					}else{
					//no need for	
							for( var ui=no_nw; ui<=num_new_rooms; ui++)
							{
						$('#chb5_nw_td'+ui).empty().html("<input id='sel_nw_b5ch"+ui+"' name='sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
							}
					}
			//no b5	
			}else if($('#sel_nw_512ch'+no_nw).val()==2)
			{
				//alert("adl 1 - c512h 2");
					if($('#child_no_cal').val()>=1)
					{
						$('#chb5_nw_td'+no_nw).empty().html("<select id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
$('.chosen-select').chosen({width:'100%'});
					}else{
						//no need for
							for( var ui=no_nw; ui<=num_new_rooms; ui++)
							{
						$('#chb5_nw_td'+ui).empty().html("<input id='sel_nw_b5ch"+ui+"' name='sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
							}
					}
				//1-b5
			}else if($('#sel_nw_512ch'+no_nw).val()==1)
			{
				//alert("adl 1 - c512h 1");
					if($('#child_no_cal').val()>=2)
					{
						$('#chb5_nw_td'+no_nw).empty().html("<select id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
$('.chosen-select').chosen({width:'100%'});
					}else if($('#child_no_cal').val()>=1)
					{
						$('#chb5_nw_td'+no_nw).empty().html("<select id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
$('.chosen-select').chosen({width:'100%'});
					}else{
					// no need for
						for( var ui=no_nw; ui<=num_new_rooms; ui++)
						{
						$('#chb5_nw_td'+ui).empty().html("<input id='sel_nw_b5ch"+ui+"' name='sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
						}	
					}
				//2-b5
			}else{
				//alert("adl 1 - c512h 0");
						if($('#child_no_cal').val()>=3)
						{
						$('#chb5_nw_td'+no_nw).empty().html("<select id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>");
$('.chosen-select').chosen({width:'100%'});
						}else if($('#child_no_cal').val()>=2)
						{
						$('#chb5_nw_td'+no_nw).empty().html("<select id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
$('.chosen-select').chosen({width:'100%'});
						}else if($('#child_no_cal').val()>=1)
						{
						$('#chb5_nw_td'+no_nw).empty().html("<select id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
$('.chosen-select').chosen({width:'100%'});
						}else
						{
						// no need for
							for( var ui=no_nw; ui<=num_new_rooms; ui++)
							{
						$('#chb5_nw_td'+ui).empty().html("<input id='sel_nw_b5ch"+ui+"' name='sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
							}	
						}
				//3-b5
			}
			
		}else if($('#sel_adlt_nw'+no_nw).val()==0)
		{
			if($('#sel_nw_512ch'+no_nw).val()==3)
			{
				//alert("adl 0 - c512h 3");
				if($('#child_no_cal').val()>=1)
				{
				$('#chb5_nw_td'+no_nw).empty().html("<select id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
$('.chosen-select').chosen({width:'100%'});
				}else{
				// no need for	
					for( var ui=no_nw; ui<=num_new_rooms; ui++)
					{
						$('#chb5_nw_td'+ui).empty().html("<input id='sel_nw_b5ch"+ui+"' name='sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
					}
				}
			//1 b5	
			}else if($('#sel_nw_512ch'+no_nw).val()==2)
			{
				//alert("adl 0 - c512h 2");
				if($('#child_no_cal').val()>=2)
				{
				$('#chb5_nw_td'+no_nw).empty().html("<select id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
$('.chosen-select').chosen({width:'100%'});
				}else if($('#child_no_cal').val()>=1)
				{
				$('#chb5_nw_td'+no_nw).empty().html("<select id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
$('.chosen-select').chosen({width:'100%'});	
				}else{
					// no need for
						for( var ui=no_nw; ui<=num_new_rooms; ui++)
						{
						$('#chb5_nw_td'+ui).empty().html("<input id='sel_nw_b5ch"+ui+"' name='sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
						}
				}
				//2-b5
			}else if($('#sel_nw_512ch'+no_nw).val()==1)
			{
				//alert("adl 0 - c512h 1");
				if($('#child_no_cal').val()>=3)
				{
				$('#chb5_nw_td'+no_nw).empty().html("<select id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>");
$('.chosen-select').chosen({width:'100%'});
				}else if($('#child_no_cal').val()>=2)
				{
						$('#chb5_nw_td'+no_nw).empty().html("<select id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
$('.chosen-select').chosen({width:'100%'});
				}else if($('#child_no_cal').val()>=1)
				{
						$('#chb5_nw_td'+no_nw).empty().html("<select id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
$('.chosen-select').chosen({width:'100%'});
				}else
				{
				//no need for	
					for( var ui=no_nw; ui<=num_new_rooms; ui++)
					{
						$('#chb5_nw_td'+ui).empty().html("<input id='sel_nw_b5ch"+ui+"' name='sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
					}
				}
				//3-b5
			}else{
				//alert("adl 0 - c512h 0");
				if($('#child_no_cal').val()>=1)
				{
				$('#chb5_nw_td'+no_nw).empty().html("<input id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
				}else{
				//no need for
					for( var ui=no_nw; ui<=num_new_rooms; ui++)
					{
						$('#chb5_nw_td'+ui).empty().html("<input id='sel_nw_b5ch"+ui+"' name='sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
					}
				}
				//no-b5
			}
		}
}//outer if
		
}

function find_no_ch512_rem(val,no)
{
	var tt_ad_val, tt_ad_val1;
	var num_new_rooms=parseInt($("#totrooms .dp-numberPicker-input").val());
	var ch512_ttoll=$('#child512_no_cnt').val();	
		var no_nw=no+1;
		var jcnt=0;
		var cur_val=val;
		//alert("ch512"+$('#child512_no_cal').val());
		//alert($('#sel_adlt_nw'+no_nw).val());
		for(var dis=no_nw;dis<=num_new_rooms;dis++)
		{				
	$('#ch512_nw_td'+dis).empty().html("<input id='sel_nw_512ch"+dis+"' name='sel_nw_512ch"+dis+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
		//jcnt=jcnt+parseInt($('#sel_nw_512ch'+dis).val());
		}
		
		for(var prv=1;prv<no_nw;prv++)
		{
		jcnt=jcnt+parseInt($('#sel_nw_512ch'+prv).val());
		}
		$('#child512_no_cal').val(parseInt($('#child512_no_cnt').val())-jcnt);
		
		
		//$('#child512_no_cal').val(parseInt($('#child512_no_cal').val())-parseInt(cur_val));
		
		if(num_new_rooms >= no_nw)
		{	
			
		if($('#sel_adlt_nw'+no_nw).val()==3)
		{
			//alert("adu 3");
			if($('#child512_no_cal').val()>=1)
			{
$('#ch512_nw_td'+no_nw).empty().html("<select id='sel_nw_512ch"+no_nw+"' name='sel_nw_512ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5(this.value,"+no_nw+"); find_no_ch512_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
$('.chosen-select').chosen({width:'100%'});
			}else{
				for(var rem_td=no_nw;rem_td<=num_new_rooms;rem_td++)
				{
				$('#ch512_nw_td'+rem_td).empty().html("<input id='sel_nw_512ch"+rem_td+"' name='sel_nw_512ch"+rem_td+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
				}
			}
			
		}else if($('#sel_adlt_nw'+no_nw).val()==2)
		{
			//alert("adu 2");
			if($('#child512_no_cal').val()>=2)
			{
				$('#ch512_nw_td'+no_nw).empty().html("<select id='sel_nw_512ch"+no_nw+"' name='sel_nw_512ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5(this.value,"+no_nw+"); find_no_ch512_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
				$('.chosen-select').chosen({width:'100%'});
				//$('#child512_no_cal').val(parseInt($('#child512_no_cal').val())-parseInt(cur_val));
			}else if($('#child512_no_cal').val()>=1)
			{
				$('#ch512_nw_td'+no_nw).empty().html("<select id='sel_nw_512ch"+no_nw+"' name='sel_nw_512ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5(this.value,"+no_nw+"); find_no_ch512_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
				$('.chosen-select').chosen({width:'100%'});
				//$('#child512_no_cal').val(parseInt($('#child512_no_cal').val())-parseInt(cur_val));
			}else{ //$('#child512_no_cal').val() ==0
				for(var rem_td=no_nw;rem_td<=num_new_rooms;rem_td++)
				{
				$('#ch512_nw_td'+rem_td).empty().html("<input id='sel_nw_512ch"+rem_td+"' name='sel_nw_512ch"+rem_td+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
				}
			}
			
		}else if($('#sel_adlt_nw'+no_nw).val()==1)
		{
			//alert("adu 1");
			if($('#child512_no_cal').val()>=3)
			{
				$('#ch512_nw_td'+no_nw).empty().html("<select id='sel_nw_512ch"+no_nw+"' name='sel_nw_512ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5(this.value,"+no_nw+"); find_no_ch512_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>");
				$('.chosen-select').chosen({width:'100%'});
				//$('#child512_no_cal').val(parseInt($('#child512_no_cal').val())-parseInt(cur_val));
			}
			else if($('#child512_no_cal').val()>=2)
			{
				$('#ch512_nw_td'+no_nw).empty().html("<select id='sel_nw_512ch"+no_nw+"' name='sel_nw_512ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5(this.value,"+no_nw+"); find_no_ch512_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
				$('.chosen-select').chosen({width:'100%'});
				//$('#child512_no_cal').val(parseInt($('#child512_no_cal').val())-parseInt(cur_val));
			}else if($('#child512_no_cal').val()>=1)
			{
				$('#ch512_nw_td'+no_nw).empty().html("<select id='sel_nw_512ch"+no_nw+"' name='sel_nw_512ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5(this.value,"+no_nw+"); find_no_ch512_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
				$('.chosen-select').chosen({width:'100%'});
				//$('#child512_no_cal').val(parseInt($('#child512_no_cal').val())-parseInt(cur_val));
			}else{ //$('#child512_no_cal').val() ==0
				for(var rem_td=no_nw;rem_td<=num_new_rooms;rem_td++)
				{
				$('#ch512_nw_td'+rem_td).empty().html("<input id='sel_nw_512ch"+rem_td+"' name='sel_nw_512ch"+rem_td+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
				}
			}
			
		}else if($('#sel_adlt_nw'+no_nw).val()==0)
		{
			//alert("adu 0");
			if($('#child512_no_cal').val()>=3)
			{
				$('#ch512_nw_td'+no_nw).empty().html("<select id='sel_nw_512ch"+no_nw+"' name='sel_nw_512ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5(this.value,"+no_nw+"); find_no_ch512_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>");
				$('.chosen-select').chosen({width:'100%'});
				//$('#child512_no_cal').val(parseInt($('#child512_no_cal').val())-parseInt(cur_val));
			}
			else if($('#child512_no_cal').val()>=2)
			{
				$('#ch512_nw_td'+no_nw).empty().html("<select id='sel_nw_512ch"+no_nw+"' name='sel_nw_512ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5(this.value,"+no_nw+"); find_no_ch512_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
				$('.chosen-select').chosen({width:'100%'});
				//$('#child512_no_cal').val(parseInt($('#child512_no_cal').val())-parseInt(cur_val));
			}else if($('#child512_no_cal').val()>=1)
			{
				$('#ch512_nw_td'+no_nw).empty().html("<select id='sel_nw_512ch"+no_nw+"' name='sel_nw_512ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5(this.value,"+no_nw+"); find_no_ch512_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
				$('.chosen-select').chosen({width:'100%'});
				//$('#child512_no_cal').val(parseInt($('#child512_no_cal').val())-parseInt(cur_val));
			}else{ //$('#child512_no_cal').val() ==0
				for(var rem_td=no_nw;rem_td<=num_new_rooms;rem_td++)
				{
				$('#ch512_nw_td'+rem_td).empty().html("<input id='sel_nw_512ch"+rem_td+"' name='sel_nw_512ch"+rem_td+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
				}
			}
			
		}
		}//outer if
		
		
	
}

function find_no_youth(val,no)
{
	var tt_ad_val, tt_ad_val1;
	var num_new_rooms=parseInt($("#totrooms .dp-numberPicker-input").val());	
		var dis_nw=no+1;
		var jcnt=0;
	
	for(var dis=dis_nw;dis<=num_new_rooms;dis++)
	{				
	$('#ch512_nw_td'+dis).empty().html("<input id='sel_nw_512ch"+dis+"' name='sel_nw_512ch"+dis+"' class='form-control tooltips ' value='0' readonly>");
		jcnt=jcnt+parseInt($('#sel_nw_512ch'+dis).val());
	}
	for(var prv=1;prv<dis_nw;prv++)
	{
		jcnt=jcnt+parseInt($('#sel_nw_512ch'+prv).val());
	}
	
	$('#child512_no_cal').val(parseInt($('#child512_no_cnt').val())-jcnt);
	
	tt_ad_val=$('#child512_no_cal').val();
	tt_ad_val1=tt_ad_val;
	$('#child512_no_cal').val(tt_ad_val1);
	
	var new_no=no+1;
	
	var type=14;
		if($('#child512_no_cnt').val()>0)
		{
			/*$.get('AGENT/ajax_agent.php?val='+val+'&no='+no+'&type='+type,function(result){
			$('#ch512_nw_td'+no).empty().html(result);
			$('.chosen').chosen({width:'100%'});
			});*/
			
			if(val==3 )
			{
		$('#ch512_nw_td'+no).empty().html("<select id='sel_nw_512ch"+no+"' name='sel_nw_512ch"+no+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5(this.value,"+no+"); find_no_ch512_rem(this.value,"+no+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
		$('.chosen-select').chosen({width:'100%'});
		
			if($('#child_no_cnt').val()>0)
			{
			$('#chb5_nw_td'+no).empty().html("<select id='sel_nw_b5ch"+no+"' name='sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem(this.value,"+no+")' class='form-control chosen-select' data-placeholder='choose'><option selected value='0'>choose</option><option value='1'>1</option></select>");
		$('.chosen-select').chosen({width:'100%'});
			}else{
					$('#sel_nw_b5ch'+no).removeAttr('data-original-title').attr('data-original-title','No need');
					$('.tooltips').tooltip();
			}
		
		//for extra bed
		$('.chosen-select').chosen('destroy');
		$('#sel_nw_extr'+no+' option').each(function(i,val){ if(val.value==0){ $(this).attr('selected',true); } });
		$('#sel_nw_extr'+no).attr('disabled',true);
		//$('#sel_nw_extr'+no).removeAttr('data-original-title').addClass('tooltips').attr('date-original-title','Mandatory');
		//$('.tooltips').tooltip();
		$('.chosen-select').chosen({width:'100%'});
		
		
			}else if(val==2 )
			{
		$('#ch512_nw_td'+no).empty().html("<select id='sel_nw_512ch"+no+"' name='sel_nw_512ch"+no+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5(this.value,"+no+"); find_no_ch512_rem(this.value,"+no+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
		$('.chosen-select').chosen({width:'100%'});
		
				if($('#child_no_cnt').val()>0)
				{
			$('#chb5_nw_td'+no).empty().html("<select id='sel_nw_b5ch"+no+"' name='sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem(this.value,"+no+")' class='form-control chosen-select' data-placeholder='choose'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
		$('.chosen-select').chosen({width:'100%'});
				}else{
						$('#sel_nw_b5ch'+no).removeAttr('data-original-title').attr('data-original-title','No need');
					$('.tooltips').tooltip();
				}
		//for extra bed
		$('.chosen-select').chosen('destroy');
		$('#sel_nw_extr'+no+' option').each(function(i,val){ if(val.value=='-'){ $(this).attr('selected',true); } });
		$('#sel_nw_extr'+no).attr('disabled',false);
		$('.chosen-select').chosen({width:'100%'});
			}
			else if(val==1 )
			{
		$('#ch512_nw_td'+no).empty().html("<select id='sel_nw_512ch"+no+"' name='sel_nw_512ch"+no+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5(this.value,"+no+"); find_no_ch512_rem(this.value,"+no+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>");
		$('.chosen-select').chosen({width:'100%'});	
			
			if($('#child_no_cnt').val()>0)
			{
			$('#chb5_nw_td'+no).empty().html("<select id='sel_nw_b5ch"+no+"' name='sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem(this.value,"+no+")' class='form-control chosen-select' data-placeholder='choose'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>");
		$('.chosen-select').chosen({width:'100%'});	
			}else{
				$('#sel_nw_b5ch'+no).removeAttr('data-original-title').attr('data-original-title','No need');
					$('.tooltips').tooltip();
			}
		//for extra bed
		$('.chosen-select').chosen('destroy');
		$('#sel_nw_extr'+no+' option').each(function(i,val){ if(val.value=='-'){ $(this).attr('selected',true); } });
		$('#sel_nw_extr'+no).attr('disabled',false);
		$('.chosen-select').chosen({width:'100%'});
		
			}
			else 
			{
				alert('no need');
			}
			
		}else{ //outer else for child512 count<0
				for(var ki=1;ki<=num_new_rooms;ki++)
				{
				$('#sel_nw_512ch'+ki).removeAttr('data-original-title').attr('data-original-title','No need');
				$('.tooltips').tooltip();
				}
			
				if($('#child_no_cnt').val()>0)//for adult with below5 age // not ch512
				{
					if(val==3 )
					{
					$('#chb5_nw_td'+no).empty().html("<select id='sel_nw_b5ch"+no+"' name='sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem(this.value,"+no+")' class='form-control chosen-select' data-placeholder='choose'><option selected value='0'>choose</option><option value='1'>1</option></select>");
				$('.chosen-select').chosen({width:'100%'});
				
			
		//for extra bed
		$('.chosen-select').chosen('destroy');
		$('#sel_nw_extr'+no+' option').each(function(i,val){ if(val.value==0){ $(this).attr('selected',true); } });
		$('#sel_nw_extr'+no).attr('disabled',true);
		//$('#sel_nw_extr'+no).removeAttr('data-original-title').addClass('tooltips').attr('data-original-title','Mandatory');
		$('.chosen-select').chosen({width:'100%'});
		//$('.tooltips').tooltip();
				
					}else if(val==2 )
					{
					$('#chb5_nw_td'+no).empty().html("<select id='sel_nw_b5ch"+no+"' name='sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem(this.value,"+no+")' class='form-control chosen-select' data-placeholder='choose'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
				$('.chosen-select').chosen({width:'100%'});
				
				//for extra bed
		$('.chosen-select').chosen('destroy');
		$('#sel_nw_extr'+no+' option').each(function(i,val){ if(val.value=='-'){ $(this).attr('selected',true); } });
		$('#sel_nw_extr'+no).attr('disabled',false);
		$('.chosen-select').chosen({width:'100%'});
					}
					else if(val==1 )
					{
				$('#chb5_nw_td'+no).empty().html("<select id='sel_nw_b5ch"+no+"' name='sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem(this.value,"+no+")' class='form-control chosen-select' data-placeholder='choose'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>");
				$('.chosen-select').chosen({width:'100%'});	
				
				$('.chosen-select').chosen('destroy');
		$('#sel_nw_extr'+no+' option').each(function(i,val){ if(val.value=='-'){ $(this).attr('selected',true); } });
		$('#sel_nw_extr'+no).attr('disabled',false);
		$('.chosen-select').chosen({width:'100%'});
					}
				}else{// for no ch512 and chb5
					for(var ki=1;ki<=num_new_rooms;ki++)
					{
					$('#sel_nw_b5ch'+ki).removeAttr('data-original-title').attr('data-original-title','No need');
					$('.tooltips').tooltip();
					}
					
					if(val==3)
					{
								$('.chosen-select').chosen('destroy');
		$('#sel_nw_extr'+no+' option').each(function(i,val){ if(val.value=='0'){ $(this).attr('selected',true); } });
		$('#sel_nw_extr'+no).attr('disabled',false);
		$('.chosen-select').chosen({width:'100%'});
						}else if(val==2 )
					{
								$('.chosen-select').chosen('destroy');
		$('#sel_nw_extr'+no+' option').each(function(i,val){ if(val.value=='-'){ $(this).attr('selected',true); } });
		$('#sel_nw_extr'+no).attr('disabled',false);
		$('.chosen-select').chosen({width:'100%'});
						}else if(val==1 )
					{
								$('.chosen-select').chosen('destroy');
		$('#sel_nw_extr'+no+' option').each(function(i,val){ if(val.value=='-'){ $(this).attr('selected',true); } });
		$('#sel_nw_extr'+no).attr('disabled',false);
		$('.chosen-select').chosen({width:'100%'});
						}
					
				}
		}
}

function find_no_adult_rem(val,no)
{
		
	var tt_ad_val, tt_ad_val1;
	var num_new_rooms=parseInt($("#totrooms .dp-numberPicker-input").val());	
		var dis_nw=no+1;
		var jcnt=0;
	
	for(var dis=dis_nw;dis<=num_new_rooms;dis++)
	{				
		$('#adlt_nw_td'+dis).empty().html("<input id='sel_adlt_nw"+dis+"' name='sel_adlt_nw"+dis+"' class='form-control tooltips ' value='0' readonly>");
		jcnt=jcnt+parseInt($('#sel_adlt_nw'+dis).val());
	}
	for(var prv=1;prv<dis_nw;prv++)
	{
		jcnt=jcnt+parseInt($('#sel_adlt_nw'+prv).val());
	}
	
	$('#adult_no_cal').val(parseInt($('#adult_no_cnt').val())-jcnt);
	
	tt_ad_val=$('#adult_no_cal').val();
	tt_ad_val1=tt_ad_val;
	$('#adult_no_cal').val(tt_ad_val1);
	
	var new_no=no+1;
	if(tt_ad_val1>=3 && num_new_rooms>=new_no)
	{
		
		$('#adlt_nw_td'+new_no).empty().html("<select id='sel_adlt_nw"+new_no+"' name='sel_adlt_nw"+new_no+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_youth(this.value,"+new_no+"); find_no_adult_rem(this.value,"+new_no+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>");
		$('.chosen-select').chosen({width:'100%'});
		
	}else if(tt_ad_val1>=2 && num_new_rooms>=new_no)
	{
		$('#adlt_nw_td'+new_no).empty().html("<select id='sel_adlt_nw"+new_no+"' name='sel_adlt_nw"+new_no+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_youth(this.value,"+new_no+"); find_no_adult_rem(this.value,"+new_no+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
		$('.chosen-select').chosen({width:'100%'});
		
	}else if(tt_ad_val1>=1 && num_new_rooms>=new_no)
	{
		$('#adlt_nw_td'+new_no).empty().html("<select id='sel_adlt_nw"+new_no+"' name='sel_adlt_nw"+new_no+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_youth(this.value,"+new_no+"); find_no_adult_rem(this.value,"+new_no+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
		$('.chosen-select').chosen({width:'100%'});
	}else if(num_new_rooms>=new_no)
	{
	//no adult	
		for(var mm=new_no;mm<=num_new_rooms;mm++)
		{
			$('#sel_adlt_nw'+mm).removeAttr('data-original-title').attr('data-original-title','No need');
			$('.tooltips').tooltip();
		}
	}
}

function plan_my_stay(where)
{
	var troom=$('#room_of_num').val();
	var tadult=$('#adult_no_cnt').val();
	var tch512=$('#child512_no_cnt').val();
	var tch5blw=$('#child_no_cnt').val();
	var tot1=0,tot2=0,tot3=0;
	for(var l=1; l<=troom; l++)
	{
		tot1=tot1+parseInt($('#sel_adlt_nw'+l).val());
		tot2=tot2+parseInt($('#sel_nw_512ch'+l).val());
		tot3=tot3+parseInt($('#sel_nw_b5ch'+l).val());
	}
	if(tot1!=tadult)
	{
		alert('Total adult count must be '+tadult+'. Selected adult count value - mismatched. Please reselect adults per room..');
	}else if(tot2!=tch512)
	{
		alert('Total 5-12 age-child(ren) count must be '+tch512+'. Selected 5-12 age-child(ren) count value - mismatched. Please reselect 5-12 age-child(ren) per room..');
	}else if(tot3!=tch5blw)
	{
		alert('Total Below-5-age-child(ren) count must be '+tch5blw+'. Selected Below-5-age-child(ren) count value - mismatched. Please reselect Below-5-age-child(ren) per room..');
	}else{
	
	$('#food_only_div').hide();
	$('#dvi_sugg_hotel_div').hide();
	$('#planmy_hotel_div').fadeIn();
	$('#plan_my_stay_txt').val('1');
	$('#dvi_sug_hotel_txt').val('0');
	//for emptying initially
	$('#table_collection0').empty();
	var err_len=$('#new_room_table tbody').children().length;
			//hotel information start
			var stay_days=parseInt($("#nd .dp-numberPicker-input").val());
			var table_uniq;
			for(var days=1;days<=stay_days;days++)
			{
				table_uniq="<div id='table_collection"+days+"'><center><table id='stay_tabell"+days+"' class='table' style='width:90%;margin-top:15px; border:#DFDADA 1px solid;'><tr style='height:20px; background-color:#FFFCF2'><td width='15%'>Date</td><td width='20%' id='sdate_nw_td"+days+"' >23-Jun-2015</td><td witdh='15%'>Place:</td><td  id='city_nw_td"+days+"'>xxx</td><td ><a id='pic_view"+days+"' class='add_hots4 btn btn-sm btn-info' ><i class='fa fa-picture-o'></i>&nbsp;View Spot</a></td></tr><tr><td width='15%'>Category</td><td width='25%' id='catag_nw_td"+days+"'><input type='text' class='form-control' disabled ></td><td width='5%'>&nbsp;</td><td id='tdroom_nw_td"+days+"' rowspan='4' colspan='2' width='40%' style='border: #CAC6C6 1px solid; background-color: rgb(245, 245, 244);'><br><br><center>Choose hotel for finding available rooms</center></td></tr></tr><tr><td width='15%'>Hotel</td><td width='25%' id='hotel_nw_td"+days+"' ><input type='text' class='form-control' disabled ></td><td>&nbsp;</td></tr></tr><tr><td width='5%'>Food</td><td id='food_nw_td"+days+"'><input type='text' class='form-control' id='food_id"+days+"' name='food_id"+days+"' disabled ></td><td width='5%'> </td></tr></tr><tr><td width='15%'>Special</td><td width='25%' id='spl_nw_td"+days+"'><input type='text' class='form-control' name='ext_item_id"+days+"' id='ext_item_id"+days+"' disabled ></td><td width='5%'></td></tr></table><input type='hidden' id='htl_id"+days+"' value='' /></center></div>";

					var prv_day=days-1;
					if(days==1){
					$(table_uniq).appendTo('#table_collection'+prv_day);
					}else{
						$(table_uniq).insertAfter('#table_collection'+prv_day);
					}
			}
			
		var eat;
		for(var east=1;east<=stay_days;east++)
		{
			eat=east-1;
			var ddate=$('#start_date'+eat+'0').val();
			$('#sdate_nw_td'+east).empty().html("<input class='form-control' type='text' readonly id='sdat"+east+"' name='sdat"+east+"' value='"+ddate+"'>");
			
			city_kitname=$('#kit_kat').val().split(",");
			//alert(city_kitname);
			city_kitname1=city_kitname[eat];
	$('#city_nw_td'+east).empty().html("<input type='text' class='form-control' value='"+city_kitname1+"' id='kitcity"+eat+"' readonly='readonly' >");
		
			city_kitidd=$('#kit_cityidd').val().split(",");
			idds=city_kitidd[eat];
			$('#pic_view'+east).attr('href','AGENT/view_img_desc.php?cid='+idds);
			$('#video_view'+east).attr('href','AGENT/view_video_spot.php?cid='+idds);
			
		}
	
		var kitkkk=$('#kit_cityidd').val().split(",");
		var kithhh=kitkkk.length;
		var hugg;
		for(var hug=0; hug<kithhh; hug++)
		{
		  hugg=hug+1;
			$('#htl_id'+hugg).val(kitkkk[hug]);
			find_hotel_categ(kitkkk[hug],hugg);
			find_all_categ(kitkkk[hug],hugg);
			
		}
	
	$('#sun').show();
	}//else validation rooms
}


function trans_hotel()
{
	
/*This is for handling adult 4 - room 1 problem	
var fn_na=$("#na .dp-numberPicker-input").val();
	var fn_nc512=$("#nc512 .dp-numberPicker-input").val();
	var fn_nc=$("#nc .dp-numberPicker-input").val();
	alert(fn_nc);
	if((parseInt(fn_na)%4==0) && (fn_nc512==0) && (fn_nc==0))
	{
	alert("yes");	
	}*/
	
	var date2 = ''; var date4 = '';  var date5 = '';
	var arr_city_id = document.getElementById("st_city").value;
	var var_city = $('#st_city option:selected').html().split('-');
	date2 = $('#arrdate').data('datepicker').date;
		if (var_city[0] != '' && $("#seaterr0").is(":hidden") && $("#arrdate").val() != '' && $("#st_vehic0").val() != '')
		{
			var get_day=$('#daydiv').val();
			if(get_day > 0)
			{
				get_day--;
				for (var j=1;j<=get_day;j++)
				{
					document.getElementById('labdiv'+j).remove();
					document.getElementById('div'+j).remove();
				}
			}
			
			$('#daydiv').val(0);
			var vehidarr = getvehids();
			get_cities1(0,0,arr_city_id,vehidarr);
			loading_cityrow();
			
			$("#start_city00").val(var_city[0].trim()).attr('data-original-title',var_city[0].trim());
			
			var dd = date2.getDate();
			var mm = date2.getMonth() + 1;
			var y = date2.getFullYear();
			
			if (mm < 10)
			{
				var mm1 = '0'+mm;
			}
			else
			{
				var mm1 = mm;
			}
			
			if (dd < 10)
			{
				var dd1 = '0'+dd;
			}
			else
			{
				var dd1 = dd;
			}
			
			
			 var FormattedDate = y + '-' + mm1 + '-' + dd1;
			 var mydate = new Date(FormattedDate);
  			 var str = mydate.toString("MMMM-yyyy");
			 document.getElementById('start_date00').value = moment(str).format('DD-MMM-YYYY');
			
			$("#book_det").show();
			$("#daycnt").text(parseInt(day_cnt) + 1);
			//$("#row_line").show();
			
			var dy,cty;
			cty=0; dy=0;
			
			var tot_row_cnt = parseInt($("#nn .dp-numberPicker-input").val());
			var check_date='';
			
			for (var k=1;k<tot_row_cnt;k++)
			{
				dy++;
				
				new_fromto = "<div class='form-group' id='div"+dy+"'><div class='row'><div class='col-sm-12'><label class='control-label col-sm-2' style='text-align:center'>Day - <label id='daycnt"+dy+cty+"'></label></label><div class='col-sm-2'><input type='text' class='form-control tooltips' data-toggle='tooltip' data-original-title='Travel Date' data-date-format='yyyy-mm-dd' placeholder='yyyy-mm-dd' name='start_date[]' id='start_date"+dy+cty+"' readonly='readonly'></div><div><div class='col-sm-3'><input class='form-control bold-border tooltips' type='text' name='start_city[]' id='start_city"+dy+cty+"' readonly='readonly'></div><div class='col-sm-3' id='load_cityrow"+dy+cty+"'></div></div><div class='col-sm-2'><center><table width='100%'><tr><td width='50%' align='center'><a  class=' btn btn-sm btn-info tooltips' data-original-title='Choose Travel Via' onclick='trv_via_fun("+dy+cty+","+dy+")' ><i class='glyphicon glyphicon-random'></i>&nbsp; Via</a></td><td width='50%' align='center'><a  class='add_hots4 btn btn-sm btn-default tooltips' id='atxt"+dy+"-"+cty+"' data-original-title='Click To View This City Pictures'><i class='fa fa-picture-o'></i></a></td></tr></table></center></div></div></div><input type='hidden' id='d"+dy+"' value='"+dy+"' /><input type='hidden' id='c"+dy+"' value='0' /></div>";
				
				date4 = $('#arrdate').data('datepicker').date;
				date5 = moment(date4);
				
				date5 = moment(date5).add('days', k);
				
				var dymimus = dy - 1;
				$(new_fromto).insertAfter('#div'+dymimus);
				$('.tooltips').tooltip();
				document.getElementById('start_date'+dy+cty).value = moment(date5).format('DD-MMM-YYYY');
				if(check_date=='')
				{
					check_date=moment(date5).format('YYYY-MM-DD');
				}else{
					check_date=check_date+'/'+moment(date5).format('YYYY-MM-DD');
				}
				$("#daycnt"+dy+cty).text(parseInt(dy) + 1);
				
				date4 = ''; date5 = '';
				get_cities2(dy,cty);
			}
			
			//my edit start
			//to lock this itinerary when the season not available
			//alert("CD ="+check_date+' CDCC = '+$('#check_boxs').val());
			if(check_date!='' && $('#check_boxs').val()=='1')
			{    $('.loader_ax').fadeIn();  
				$.get('AGENT/ajax_agent.php?type=30&checkdate='+check_date,function(res){
					$('.loader_ax').fadeOut();
					//alert(res);
					if(res.trim()=='yes')
					{
						$('#stop_modal').modal('show');
					}
					
				});
			}
			//my edit end
			
			
			 $('#daydiv').val(tot_row_cnt);
			 var dptdat=parseInt(tot_row_cnt)-1;
			// $('#depart_ddat').val($('#start_date'+dptdat+'0').val());
			 
			 
			var nowTemp = new Date();
			var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

			$('.datepickerm').datepicker(
			{
			 	onRender: function(date) 
				{
					return date.valueOf() < now.valueOf() ? 'disabled' : '';
				}
			});
		}
		else
		{
			if (var_city[0] == '')
			{
				alert ('Choose arrival city');
			}
			else if ($("#seaterr0").is(":visible"))
			{
				alert ('Travellers number exceeds vehicle capacity');
			}
			else if($("#arrdate").val() == '')
			{
				alert ('Select arrival date and time');
			}
			else if ($("#st_vehic0").val() == '')
			{
				alert ('Choose vehicle for your travel');
			}
		}
		$('#quote').hide(); 
		//$('#subplan').hide(); 
		$('#stay_plan11').hide();
	
}

function nextrow_val(rowid)
{
	//alert("row"+rowid);
	var rowid1 = rowid.split('-');
	var mrowid = rowid1[0];
	var srowid = rowid1[1];
	
	if($('#mod_via_'+mrowid+'0_'+mrowid).length>0)
	{
		$('#mod_via_'+mrowid+'0_'+mrowid).remove();
	}

	var tocity_id = $('#row_city'+mrowid+srowid).val();
	var tocity_val = $('#row_city'+mrowid+srowid+' option:selected').text().split('-');
	srowid++;
	
	var getfrom_cit = $("#start_city"+mrowid+srowid).val();
	var lastrow_mins1 = $('#daydiv').val() - 2;
	var vehidarr = getvehids();
	$('.tooltips').tooltip();
	if (typeof getfrom_cit != "undefined" && lastrow_mins1 != mrowid)
	{
		$("#start_city"+mrowid+srowid).val(tocity_val[0].trim()).attr('data-original-title',tocity_val[0].trim());
		get_cities1(mrowid,srowid,tocity_id,vehidarr);
	}
	else if (lastrow_mins1 != mrowid)
	{
		srowid = 0; mrowid++;
		$("#start_city"+mrowid+srowid).val(tocity_val[0].trim()).attr('data-original-title',tocity_val[0].trim());
		get_cities1(mrowid,srowid,tocity_id,vehidarr);
	}
	else if (lastrow_mins1 == mrowid)
	{
		srowid = 0; mrowid++;
		$("#start_city"+mrowid+srowid).val(tocity_val[0].trim()).attr('data-original-title',tocity_val[0].trim());
		get_cities3(mrowid,srowid,tocity_id,vehidarr);
	}
	
	var cid1= tocity_id.split('-');
	//alert('#atxt'+rowid);
	$('#atxt'+rowid).attr('href','AGENT/view_img_desc.php?cid='+cid1[0]);
	//$('#vvatxt'+rowid).attr('href','AGENT/view_video_spot.php?cid='+cid1[0]);
}

function newfromto(id)
{
	var cty,dya;
	dya=$('#d'+id).val();
	cty=$('#c'+id).val();

	var check_empty = '';

	for(var t1=0;t1<=dya;t1++)
	{
		for(var s1=0;s1<=cty;s1++)
		{
			if ($('#row_city'+t1+s1).val() == '')
			{
				check_empty = 'Y';
			}
		}
	}
	 
	var tocity_id = $('#row_city'+dya+cty).val();
	
	if (check_empty == '')
	{
		cty++;
		
		new_fromto = "<div id='fromto_row"+dya+cty+"'><div class='form-group'><div class='row'><div class='col-sm-3'></div><label class='col-sm-1 control-label'>From: &nbsp;&nbsp;</label><div class='col-sm-2'><input class='form-control bold-border tooltips1' type='text' name='start_city[]' id='start_city"+dya+cty+"' readonly='readonly'></div><label class='control-label col-sm-1'>To: &nbsp;&nbsp;</label><div class='col-sm-3' id='load_cityrow"+dya+cty+"'></div></div></div></div>";
		
		$('#c'+id).val(cty);
		//get_cities2(dya,cty);
		var vehidarr = getvehids(); 
		get_cities1(dya,cty,tocity_id,vehidarr);
	//	cty--;
		$(new_fromto).appendTo('#div'+id);			
		
		var curday=$('#d'+id).val();
		var currec=$('#c'+id).val();
		var prevrec=currec - 1;
		var tocity_val = $('#row_city'+curday+prevrec+' option:selected').text().split('-');
		
		$("#start_city"+curday+currec).val(tocity_val[0].trim());
	}
	else
	{
		alert ('Select '+'TO'+' location');
	}
}

function remfromto(id)
{
	var ccnt;
	ccnt=$('#c'+id).val();
	
	if (ccnt > 0)
	{
		$('#fromto_row'+id+ccnt).remove();
		ccnt--;
		$('#c'+id).val(ccnt);
		
		
		var tocity_id = $('#row_city'+id+ccnt).val();
		var tocity_val = $('#row_city'+id+ccnt+' option:selected').text().split('-');
		
		id++; ccnt = 0;
		$("#start_city"+id+ccnt).val(tocity_val[0].trim());
		var vehidarr = getvehids();
		get_cities1(id,ccnt,tocity_id,vehidarr);
	}
}

function show_flightmap()
{
	$("#gmap_div1").show();
	$("#gmap_div2").show();
	
	var mapOptions = {
    zoom: 5,
    center: new google.maps.LatLng(21.0000, 78.0000),
    mapTypeId: google.maps.MapTypeId.TERRAIN
	};
	
	var getcord1 = $("#st_city").val();
	var loc1 = getcord1.split("-");
	var loc1_latlng = '('+loc1[1].trim()+','+loc1[2].trim()+')';

	var map = new google.maps.Map(document.getElementById('gmap_path1'),mapOptions);

	var locat;
	var getfline;
	var myTrip=new Array(); var popup_markers=new Array(); var popup_info=new Array();
	myTrip.push(new google.maps.LatLng(loc1[1].trim(),loc1[2].trim()));
	popup_markers.push(loc1[1].trim(),loc1[2].trim());
	popup_info.push($('#st_city option:selected').text());
	
	var dya = $('#daydiv').val();
	for(var w1=0;w1<=dya;w1++)
	{
		var gethid = $('#c'+w1).val();
		for(var x1=0;x1<=gethid;x1++)
		{
			getfline = $("#row_city"+w1+x1).val();
			locat = getfline.split("-");
			myTrip.push(new google.maps.LatLng(locat[1].trim(),locat[2].trim()));
			popup_markers.push(locat[1].trim(),locat[2].trim());
			var cityname_info = $('#row_city'+w1+x1+' option:selected').text();
			popup_info.push(cityname_info);
		} 
	}

	var flightPath = new google.maps.Polyline({
   // path: flightPlanCoordinates,
	path: myTrip,
    geodesic: true,
    strokeColor: '#FF0000',
    strokeOpacity: 2.0,
    strokeWeight: 3
	});
	
	
	//Markers setting code
	for (var i = 0; i < myTrip.length; i++)
	{
		var lat = popup_markers[i][1]
		var long = popup_markers[i][2]
		var info_window =  popup_info[i]
	
		latlngset = myTrip[i];
	
		var marker = new google.maps.Marker({  
			map: map, title: 'Cityname' , position: latlngset  
			});
			
			map.setCenter(marker.getPosition())
			var currentinfo = null;
			var content = "Location: " + (i+1) +  '</h3>' + " : " + info_window     
	
			var infowindow = new google.maps.InfoWindow()
			
			google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){ 
			return function() {
				if(currentinfo) { currentinfo.close();} 
			   infowindow.setContent(content);
			   infowindow.open(map,this);
			   currentinfo = infowindow;
			};
		})(marker,content,infowindow)); 
	  }
	
	flightPath.setMap(map);
	
}

function toRad(deg) 
{
	return deg * Math.PI/180;
}

var map;
var geocoder;
var origin1 = '';
var destination1 = '';
var destination2 = '';

function show_roadmap()
{
	
	if($('#kit_kat').val()!='')
	{
		$('#kit_kat').val('');	
		$('#stay_plan11').hide();
	}
	
	$("#callbackid").val('');
	//$("#gmap_div1").show();
	$("#gmap_div2").show();
	
	var mapOptions = 
	{
		zoom: 5,
		center: new google.maps.LatLng(21.0000, 78.0000),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	
	var tot_dist = 0;
	var strt_city = $('#st_city option:selected').text().split('-');
	var strt_cityid = $('#st_city').val().split('-');
	
	var st_cit = strt_city[0].trim()+', '+strt_city[1].trim();
	var directionsDisplay;
	var directionsService = new google.maps.DirectionsService();
	var distance;
	var map = new google.maps.Map(document.getElementById('gmap_path2'),mapOptions);
  
	directionsDisplay = new google.maps.DirectionsRenderer();
	directionsDisplay.setMap(map);
	
	var start = st_cit;
	//alert(start);
	var waypts = [];
	var trav_cit = []; var idarr = [];
	var road_locat; var locat_format;
	
	trav_cit.push(start+','+strt_cityid[0].trim());
	idarr.push(strt_cityid[0].trim());
	
	var dyb = $('#daydiv').val();
	dyb--;
	for(var w1=0;w1<=dyb;w1++)
	{
		var gethid = $('#c'+w1).val();
		
		if (w1 == dyb)
		{
			gethid--
		}
		for(var x1=0;x1<=gethid;x1++)
		{
			var getrline = $("#row_city"+w1+x1+' option:selected').text();
			road_locat = getrline.split("-");
			var mid_cityid = $('#row_city'+w1+x1).val().split('-');
			if (road_locat[0] != '')
			{
				locat_format = road_locat[0].trim()+', '+road_locat[1].trim();
				waypts.push({
				location:locat_format,
				stopover:true});
				if (mid_cityid[3] == '1')
				{
					trav_cit.push(locat_format+','+mid_cityid[0].trim());
				}
				idarr.push(mid_cityid[0].trim());
			}
		}
	}
	//alert(JSON.stringify(trav_cit)); 
	var gethid1 = $('#c'+dyb).val();
	
	getrline1 = $("#row_city"+dyb+gethid1+' option:selected').text();
	road_locat1 = getrline1.split("-");
	var end = road_locat1[0].trim()+', '+road_locat1[1].trim();
	var end_cityid = $('#row_city'+dyb+gethid1).val().split('-');
	//alert(end);
	trav_cit.push(end+','+end_cityid[0].trim());
	idarr.push(end_cityid[0].trim());
	//alert(idarr);
	$('#cid_arr').val(idarr);
	$("#dest_id").val(end_cityid[0].trim());
	
	var request = {
		  origin: start,
		  destination: end,
		  waypoints: waypts,
		  optimizeWaypoints: true,
		  travelMode: google.maps.TravelMode.DRIVING
	  };
		
	directionsService.route(request, function(response, status) {
	//	alert(status);
	if (status == google.maps.DirectionsStatus.OK) 
	{
		directionsDisplay.setDirections(response);
		var route = response.routes[0];
		var summaryPanel = document.getElementById('directions_panel');
		var dist_total = document.getElementById('show_distot');
		var spl_dist;
		summaryPanel.innerHTML = ''; 
		  // For each route, display summary information.
		  var kitfin = $('#kit_kat').val(); var stor_city = ''; var format_dat = ''; var phparr = [];
		  //var kitfin;
		for (var i = 0; i < route.legs.length; i++) 
		{
			var routeSegment = i + 1;
			summaryPanel.innerHTML += '<b>DAY: ' + routeSegment + '</b> &nbsp;';
			var date_read = moment($('#start_date'+i+'0').val()).format('MMMM Do YYYY, dddd');
			summaryPanel.innerHTML += '<b>('+date_read + ')</b> <br>';
			summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
			summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
			spl_dist = route.legs[i].distance.text.split("km");
			//alert(route.legs[i].start_address);
			if (spl_dist[0] != '')
			{
				var spl_dist1=spl_dist[0].replace(/\,/g,'');
			}
			else
			{
				var spl_dist1 = 1;
			}
			//Add 30kms for sight seeing every day.
			var spl_dist2 = parseInt(spl_dist1) + 30;
			summaryPanel.innerHTML += 'Travel distance: '+spl_dist2 + 'kms.' + '<br>';
			summaryPanel.innerHTML += 'Aproximative driving time: '+route.legs[i].duration.text+'.<br><br>';
			
			tot_dist+=parseInt(spl_dist2);
			var spl_stcity = route.legs[i].start_address.split(',');
			var spl_nxcity = route.legs[i].end_address.split(',');
			var spl_trtime = route.legs[i].duration.text;
			stor_city+=spl_stcity[0]+'-'+spl_nxcity[0]+'-'+spl_dist1+'-'+spl_trtime;
			format_dat+=spl_stcity[0]+'-'+spl_nxcity[0]+'-'+spl_dist1+'-'+spl_trtime+'~';
			phparr.push(stor_city);
			stor_city = '';
			var kit,kit1;
			if(i != 0)
			{
				 kit=route.legs[i].start_address;
				 kit1=kit.split(",");
			 
				 if(kitfin == '')
				 {
					 kitfin=kit1[0];
				 }
				 else
				 {
					 kitfin= kitfin+','+kit1[0];
				 }
			}
		}
		
		$('#kit_kat').val(kitfin);
		$('#citydata').val(phparr);
		$('#formatdata').val(format_dat);
		var jojo=$('#kit_kat').val();
		//alert('bef'+jojo);
		var ttyy=9;
		$.get('AGENT/ajax_agent.php?cname='+jojo+'&type='+ttyy,function(result)
		{
			//alert(result);
			$('#kit_cityidd').val(result);
		});
		dist_total.innerHTML = "<strong> Total travel distance: "+tot_dist + " kms. </strong>" + '<br>';
		$('#traveldist').val(tot_dist);
	}
	});

	var directionsService1 = new google.maps.DirectionsService();
	var start1 = trav_cit[0].split(',');
	var start2 = start1[0]+', '+start1[1];
	var end1 = trav_cit[trav_cit.length-1].split(',');
	var end2 = end1[0]+', '+end1[1];
	var findistarr = []; var tot_dist1 = 0;
	//alert(trav_cit);
	var dhn='',cyid=new Array();
	var dhan;
 
	for (var d1=0;d1<=trav_cit.length-1;d1++)
	{
		dhan=trav_cit[d1].split(',');
		if(dhn!='')
		{
			dhn=dhn+'-'+dhan[0]+','+dhan[1];
			cyid[d1]=dhan[2];
		}
		else
		{
			dhn=dhan[0]+','+dhan[1];
			cyid[d1]=dhan[2];
		}
	}

	var splcit1 = cyid.length-1;
	$('#citarrid').val(cyid[splcit1]);

	var lendhan=dhn.length;
	var trvl = dhn.split('-');
	var bb; var cc;
 
	for(var nu=0;nu<trvl.length-1;nu++)
	{
	    if(nu == 0)
		{
			destination1=trvl[trvl.length-1];
			origin1=trvl[0];
			geocoder = new google.maps.Geocoder();
			var service = new google.maps.DistanceMatrixService();
			
			service.getDistanceMatrix(
			{
				origins: [origin1],
				destinations: [destination1],
				travelMode: google.maps.TravelMode.DRIVING,
				unitSystem: google.maps.UnitSystem.METRIC,
				avoidHighways: false,
				avoidTolls: false
			},callback(cyid[nu]));
		}
		else
		{
			destination1=trvl[0];
			destination2=trvl[trvl.length-1];
			origin1=trvl[nu];
			geocoder = new google.maps.Geocoder();
			var service = new google.maps.DistanceMatrixService();
			service.getDistanceMatrix(
			{
				origins: [origin1],
				destinations: [destination1,destination2],
				travelMode: google.maps.TravelMode.DRIVING,
				unitSystem: google.maps.UnitSystem.METRIC,
				avoidHighways: false,
				avoidTolls: false
			},callback(cyid[nu]));
		}
	}

		google.maps.event.addListenerOnce(map, 'tilesloaded', function() {
			//$('#quote').show(); 
		if($('#check_boxs').val()!='2')
		{
		$('#stay_plan11').show();
		}
			
		if($('#check_boxs').val()=='2')
		{
 		$('#sun').show();
		}
    //google.maps.event.addListenerOnce(map, 'idle', function(){
    //if (typeof google === 'object' && typeof google.maps === 'object')
	//{
		/*var all_dist = $('#traveldist').val();
		vehrent(all_dist)
		$('#stay_plan11').show();*/
		
	//}
	//});
});
}

function my_route(route_typ, agent_percnt, adm_percent)
{
	/*if($('#check_boxs').val()=='2')
	{
		$('#final_save_btn').show();
	}*/
	if($('#kit_kat').val()!='')
	{
		$('#kit_kat').val('');	
		$('#stay_plan11').hide();
	}
	
	$("#callbackid").val('');
	//$("#gmap_div1").show();
	//$("#gmap_div2").show();
	var cit_names = [];
	var tot_dist = 0;
	var strt_city = $('#st_city option:selected').text().split('-');
	var strt_cityid = $('#st_city').val().split('-');
	
	var st_cit = strt_city[0].trim();	
	var distance;
  	cit_names.push(st_cit);
	var start = st_cit;
	var trav_cit = []; var idarr = [];
	var road_locat; var locat_format;
	
	trav_cit.push(strt_cityid[0].trim());
	idarr.push(strt_cityid[0].trim());
	
	var dyb = $('#daydiv').val();
	dyb--;
	
	var via_flg=0;
	var vss,vdd='';
	var arr_vss='-';
	for(var w1=0;w1<=dyb;w1++)
	{
		//viass_idss//via id arrangements
		if($('#sel_via_trav_cids_'+w1+'0_'+w1).length>0 && $('#sel_via_trav_cids_'+w1+'0_'+w1).val()!='')
		{
			via_flg=1;
			//alert($('#sel_via_trav_cids_'+w1+'0_'+w1).val()+' - '+w1);
			vss=$('#sel_via_trav_cids_'+w1+'0_'+w1).val().split('-');
			vss.shift();
			vss.pop();
			
			if(arr_vss=='-')
			{
				arr_vss=vss;
			}else{
				arr_vss=arr_vss.concat(vss);
			}
		}
		
		if($('#sel_via_trav_totdis_'+w1+'0_'+w1).length>0 && $('#sel_via_trav_totdis_'+w1+'0_'+w1).val()!='')
		{
				if(vdd=='')
				{
					vdd=$('#sel_via_trav_totdis_'+w1+'0_'+w1).val();
				}else{
					vdd=vdd+'-'+$('#sel_via_trav_totdis_'+w1+'0_'+w1).val();
				}
		}else{
				if(vdd=='')
				{
					vdd='NN';
				}else{
					vdd=vdd+'-'+'NN';
				}
		}
		
		var gethid = $('#c'+w1).val();
		
		if (w1 == dyb)
		{
			gethid--
		}
		for(var x1=0;x1<=gethid;x1++)
		{
			var getrline = $("#row_city"+w1+x1+' option:selected').text();
			road_locat = getrline.split("-");
			var mid_cityid = $('#row_city'+w1+x1).val().split('-');

			if (road_locat[0] != '')
			{
				//locat_format = road_locat[0].trim()+', '+road_locat[1].trim();
				locat_format = road_locat[0].trim();				
				cit_names.push(locat_format);
				if (mid_cityid[2].trim() == '1')
				{
					trav_cit.push(mid_cityid[0].trim());
				}
				idarr.push(mid_cityid[0].trim());
			}
		}
	}
	//alert(arr_vss);
	//alert(JSON.stringify(trav_cit)); 
	var gethid1 = $('#c'+dyb).val();
	//alert(arr_vss);
	$('#viass_idss').val(arr_vss);
	//alert("DDD "+vdd);
	$('#viass_dd').val(vdd);
	
	getrline1 = $("#row_city"+dyb+gethid1+' option:selected').text();
	road_locat1 = getrline1.split("-");
	var end = road_locat1[0].trim();
	var end_cityid = $('#row_city'+dyb+gethid1).val().split('-');
	//alert('end_cityid '+end_cityid);
	cit_names.push(end);
	var last_veh_cid = '';
	if (end_cityid[2].trim() == '1')
	{
		last_veh_cid = 'y';
	}
	trav_cit.push(end_cityid[0].trim());
	idarr.push(end_cityid[0].trim());
	//alert(idarr);
	
	$("#dest_id").val(end_cityid[0].trim());
	var prv_mid='';
	for(var sp=0;sp<idarr.length;sp++)
	{
		if(sp!=0 && sp!=idarr.length-1)
		{
			if(prv_mid=='')
			{
				prv_mid=idarr[sp];	
			}else{
				prv_mid=prv_mid+','+idarr[sp];
			}
		}
	}
	
	$('#kit_cityidd_prev').val(idarr);
	var format_dat = ''; var stor_city = ''; var phparr = [];
	$('.loader_ax').fadeIn();
	//alert('route_typ= '+route_typ+' idarr='+idarr+' trav_cit='+trav_cit+' last_veh_cid='+last_veh_cid);
	$.getJSON('<?php echo "AGENT/dist_cities.php"; ?>', { route_type: route_typ, allcids: idarr, vehcitids: trav_cit, last_chk: last_veh_cid, viass: arr_vss, viass_dd: vdd}, function(data) {
		//alert(data);
			//alert("Value for 'detl': " + data.detl + "\nValue for 'retn': " + data.retn + "\nValue for 'netamt': " + data.netamt);
			//document.getElementById('directions_panel').innerHTML=data.detl;
			//alert(route_typ);
			//alert('tot'+data.trav_dist);
			 /*if((prv_mid==data.cit_opt_idd) || via_flg==0)//only for optimized route // via may change depands upon this plan
			 {
				alert(via_flg+'Same '+prv_mid+'=='+data.cit_opt_idd);*/
			 
			$('#kit_cityidd').val(data.cit_opt_idd);//for hotel city id 
			$('#kit_kat').val(data.cit_optnnmm);
			$('#cid_arr').val(data.cit_ord);
			$('#traveldist').val(data.trav_totdist);
			$('#traveldist_ess').val(data.trav_totdist_ess);
			$('#day_traveldist').val(data.trav_dist);
			$('#day_travdist_ess').val(data.trav_dist_ess);
			
			var cid_list = $('#cid_arr').val().split(',');
			var trav_eachdist = data.trav_dist_ess.split(',');
			var trav_eachdist_ss = data.trav_dist.split(',');
			
			var trav_eachtime = data.frmt_time.split(',');
			if(route_typ == 'o')
			{
				var trav_eachstnm = data.cit_optnams.split('-');
				//alert('fail'+data.opt_fail);
				if (data.opt_fail == 'y')
				{
					alertopt();
				}
			}
			var trav_tim = '';
			for(var r1=0;r1<cid_list.length-1;r1++)
			{
				var r2 = r1 + 1;
				if (route_typ == 'm')
				{
					if (trav_eachtime[r1] == '')
					{
						trav_tim = '-';
					}
					else
					{
						trav_tim = trav_eachtime[r1];
					}
					stor_city+= cit_names[r1]+'-'+cit_names[r2]+'-'+trav_eachdist[r1]+'-'+trav_tim+'-'+trav_eachdist_ss[r1];
					format_dat+=cit_names[r1]+'-'+cit_names[r2]+'-'+trav_eachdist[r1]+'-'+trav_tim+'-'+trav_eachdist_ss[r1]+'~';
				}
				else if(route_typ == 'o')
				{
					if (trav_eachtime[r1] == '')
					{
						trav_tim = '-';
					}
					else
					{
						trav_tim = trav_eachtime[r1];
					}
					var trav_eachstnm1 = trav_eachstnm[r1].split(',');
					var trav_eachstnm2 = trav_eachstnm[r2].split(',');
					stor_city+= trav_eachstnm1[0].trim()+'-'+trav_eachstnm2[0].trim()+'-'+trav_eachdist[r1]+'-'+trav_tim+'-'+trav_eachdist_ss[r1];
					format_dat+=trav_eachstnm[r1]+'-'+trav_eachstnm[r2]+'-'+trav_eachdist[r1]+'-'+trav_tim+'-'+trav_eachdist_ss[r1]+'~';
				}
				phparr.push(stor_city);
				stor_city = '';
			}
			//alert(phparr);
			$('#citydata').val(phparr);
			/*var dist_total = document.getElementById('show_distot');
			var total_days = document.getElementById('show_days');*/
			$('#formatdata').val(format_dat);
			var trval_cids = $('#cid_arr').val();
			var exp_trval_cids = trval_cids.split(',');
			var summaryPanel = document.getElementById('directions_panel');
			summaryPanel.innerHTML = '';
			var tr_data = $('#formatdata').val();
			
			var tr_data1 = tr_data.replace(/,\s*$/, "");
			var tr_data2 = tr_data1.split('~');
			
			$('#veh_cit_dis').val(data.extdist);
			daytrip(agent_percnt,adm_percent);
			//alert(data.trav_totdist);
			/*}else{
				alert('Not Same '+prv_mid+'=='+data.cit_opt_idd);
				$('#not_same_mod').modal('show');
				 
			 }*/
		}).error(function(jqXHR, textStatus, errorThrown) {
			alert(jqXHR.responseText);
    // Inspect the values of jqXHR, textStatus, errorThrown here.
});
}

function daytrip(agent_percnt,adm_percent)
{
	var dt_cid = $('#cid_arr').val();
	var dt_carr = dt_cid.split(',');
	dt_carr.pop();
	dt_carr.shift();
	var temp_dtid = ''; var dt_selid = ''; var new_dtarr = []; var uni_dtar = [];
	for(var dt1=0;dt1<dt_carr.length;dt1++)
	{
		if(dt_carr[dt1] == temp_dtid)
		{
			new_dtarr.push(dt_carr[dt1]);
		}
		temp_dtid = dt_carr[dt1];
	}
	uni_dtar = new_dtarr.filter(function(item, i, ar){ return ar.indexOf(item) === i; });
	//alert('day_trip '+uni_dtar);
	var dtPanel = document.getElementById('dt_panel');
	
	if(uni_dtar.length > 0)
	{
		$('#rep_tabss').hide();
		$.get('<?php echo "AGENT/day_trip.php"; ?>', { dt_ids: uni_dtar }, function(data) 
		{
				//alert(data);
				//$("#dt_panel").html(data);
				
				//$('#travel_info_mod_close').attr('onclick','trigger_getquot()');
				dtPanel.innerHTML = data;
				
				if($('#check_boxs').val()=='1')
				{
					$('.loader_ax').fadeOut(500);
				$('#trav_cancel').hide();
				$('#trav_save').hide();
				$('#trav_confirm1').hide();
				$('#trhotl_cancel').show();
				$('#trhotl_pms').show();
				$('#travel_info_mod_footer').hide();
				$('#Travel_info_mod').modal('show');
				}else{
					$('.loader_ax').fadeOut(500);
					$('#travel_info_mod_footer').hide();
					$('#Travel_info_mod').modal('show');
				}
				
				$('.chosen-select').chosen({width:'100%'});
			}).error(function(jqXHR, textStatus, errorThrown) {
				alert(jqXHR.responseText);
		// Inspect the values of jqXHR, textStatus, errorThrown here.
		});
	}
	
	if($('#check_boxs').val()!='2')
	{
		$('#stay_plan11').show();
	}
	
	if($('#check_boxs').val() != '3')
	{
		$("#gmap_div1").show();
	}
	else
	{
		$("#gmap_div1").hide();
	}

	if($('#check_boxs').val() == '2')
	{
		$('#sun').show();
		$('#get_sts_quote').hide();
		if(uni_dtar.length > 0)
		{
			$('#show_distot').hide();
			$('#show_days').hide();
			$('#netamount').hide();
			$('#trav_quot').show();
			$('#dt_panel').show();
			$('#dt_citid').val(uni_dtar);
			$('#final_save_btn').hide();
			bestroute();
		}
		else
		{
			$('#dt_panel').hide();
			$('#show_distot').show();
			$('#show_days').show();
			$('#netamount').show();
			$('#trav_quot').hide();
			$('#dt_citid').val('');
			$('#dt_dist').val(0);
			$('#final_save_btn').show();
			
			$('#dt_panel select option').prop('selected',false).trigger('chosen:updated');
			$('.loader_ax').fadeOut(500);
			bestroute();
			finalcall(1,agent_percnt,adm_percent);
		}
	}
	
	if($('#check_boxs').val() == '1')
	{
		$('#sun').show();
		$('#get_sts_quote').hide();
		if(uni_dtar.length > 0)
		{
			$('#show_distot').hide();
			$('#show_days').hide();
			$('#netamount').hide();
			$('#trav_quot').hide();
			$('#dt_panel').show();
			$('#dt_citid').val(uni_dtar);
			$('#final_save_btn').hide();
			bestroute();
			
		}
		else
		{
			$('#dt_panel').hide();
			$('#show_distot').show();
			$('#show_days').show();
			$('#netamount').hide();
			$('#trav_quot').hide();
			$('#dt_citid').val('');
			$('#dt_dist').val(0);
			$('#final_save_btn').hide();
			
			$('#dt_panel select option').prop('selected',false).trigger('chosen:updated');
			bestroute();
			finalcall(1,agent_percnt,adm_percent);
			$('.loader_ax').fadeOut(500);
				$('#trav_cancel').hide();
				$('#trav_save').hide();
				$('#trav_confirm1').hide();
				$('#trhotl_cancel').show();
				$('#trhotl_pms').show();
				$('#Travel_info_mod').modal('show');
			
		}
	}
}

function quote_dt(agent_percnt,adm_percent)
{
	var c_str = $('#cid_arr').val();
	var c_arr = c_str.split(',');
	c_arr.pop();
	c_arr.shift();
	var dt_detl; var spl_dtl; var dt_ssdist = 0; var dt_alltrdist = 0; var dt_allssdist = 0; var dt_alldist = 0; var dt_trdist = 0; var stor_dt = ''; var valid_dt; var chk_cnt_dt = 0;
	dtcnt = $('#dt_citid').val().split(',');
	//Validate the number of daytrip cities entered for each city
	for(var dt2=0;dt2<dtcnt.length;dt2++)
	{
		valid_dt = $("#sel_dtid"+dt2).val();
		if (valid_dt != null && valid_dt != '')
		{
			chk_cnt_dt = c_arr.reduce(function(n, val) 
			{
				return n + (val === dtcnt[dt2]);
			}, 0);
			chk_cnt_dt1 = parseInt(chk_cnt_dt)-1;
			
			$('#day_trip_allows').val('allow');
			if(valid_dt.length > chk_cnt_dt1)
			{
				spl_valid_dt = valid_dt[0].split('-');
				$('#day_trip_allows').val('notallow');
				alertdt(chk_cnt_dt1, spl_valid_dt[3]);
				return false;
			}
			//$('#day_trip_allows').val('notallow');
			chk_cnt_dt1 = 0;
		}
		chk_cnt_dt1 = 0;
	}
	
	for(var dt3=0;dt3<dtcnt.length;dt3++)
	{
		dt_detl = $("#sel_dtid"+dt3).val();
		if (dt_detl != null && dt_detl != '')
		{
			for(var dt4=0;dt4<dt_detl.length;dt4++)
			{
				spl_detl = dt_detl[dt4].split('-');
				dt_trdist=spl_detl[1];
				dt_ssdist=spl_detl[2];
				dt_alltrdist+=parseInt(dt_trdist);
				dt_allssdist+=parseInt(dt_ssdist);
				stor_dt+= dtcnt[dt3]+'-'+spl_detl[0]+'-'+spl_detl[1]+'-'+spl_detl[2]+',';
				dt_alldist+=parseInt(dt_ssdist)+parseInt(dt_trdist)+parseInt(dt_trdist);
			}
		}
	}
	$('#dt_dist').val(dt_alldist);
	$('#dt_detls').val(stor_dt);
	$('#dt_altrdist').val(dt_alltrdist);
	$('#dt_alssdist').val(dt_allssdist);
//	alert(stor_dt);
//	alert(dt_alldist);
//alert('final'+stor_dt+'_'+dt_alldist+'_'+dt_alltrdist+'_'+dt_allssdist);
	finalcall(1,agent_percnt,adm_percent);
	$('#final_save_btn').show();
}

function finalcall(getf,agent_percnt,adm_percent)
{
	//alert('final call');
	var getdt_dis = $('#dt_dist').val();
	var show_dist_ess = $('#traveldist_ess').val();
	var show_dt_ess = $('#dt_altrdist').val();
	if(getdt_dis > 0)
	{
		var all_dist = parseInt($('#traveldist').val()) + parseInt(getdt_dis);
		var show_trdist = parseInt(show_dist_ess) + parseInt(show_dt_ess);
	}
	else
	{
		var all_dist = $('#traveldist').val();
		var show_trdist = parseInt(show_dist_ess);
	}

//my edit on 23-sep-2015

	if (getf == 1)
	{
		vehrent(all_dist,1,agent_percnt,adm_percent,show_trdist);
		
	}
	else
	{
		vehrent(all_dist,0,agent_percnt,adm_percent,show_trdist);
		
	}
	
	$('#show_distot').show();
	$('#show_days').show();
	
	if($('#check_boxs').val() == '1')
	{
		$('#netamount').hide();
	}
	else
	{
		$('#netamount').show();
	}
}

function bestroute()
{
	//$('#subplan').trigger('click');
	$("#best_route tbody tr").remove(); 
	var tabl_data = '';
	var vvdd='',vvmm='',vvhh='',vvdd1='',vvdd2,vvhm;
	var alldata = $('#formatdata').val();
	
	var alldata1 = alldata.replace(/,\s*$/, "");
	var alldata2 = alldata1.split('~');
	
	for (var incr=0;incr<alldata2.length-1;incr++)
	{
		
	//	var d = new Date($$('#start_date'+incr+'0').val());
				//var date_read1=moment(d).format('YYYY-MM-DD');
		
		var date_read1 = $('#start_date'+incr+'0').val();
		var alldata3 = alldata2[incr].split('-');
		
		if($('#sel_via_trav_cnames_'+incr+'0_'+incr).length>0 && ($('#sel_via_trav_cnames_'+incr+'0_'+incr).val().trim()!=''))
		{
			//alert($('#sel_via_trav_totdis_'+incr+'0_'+incr).val());
			vvdd=$('#sel_via_trav_totdis_'+incr+'0_'+incr).val();
			
			vvdd1=(parseInt(vvdd)/50)*60;
			vvdd2=parseInt(vvdd1);
			if(vvdd2<1)
			{
				vvhm='N/A';
			}else{
				vvhh=Math.floor(vvdd2/60);
				vvmm=vvdd2%60;
				vvhm=vvhh+" hours "+vvmm+" minutes";
			}
			
			tabl_data="<tr><td width='25%'>"+date_read1+"</td><td>"+alldata3[0]+"</td><td><i class='fa fa-random tooltips' data-original-title='"+$('#sel_via_trav_cnames_'+incr+'0_'+incr).val()+"'></i></td><td>"+alldata3[1]+"</td><td>"+vvdd+"</td><td>"+vvhm+"<input type='hidden' id='trav_times"+incr+"' name='trav_times"+incr+"' value='"+vvhm+"'></td></tr>";
		}else{
			tabl_data="<tr><td width='25%'>"+date_read1+"</td><td>"+alldata3[0]+"</td><td><i class='fa fa-random tooltips' data-original-title='Travel Via Not Chosen'></i></td><td>"+alldata3[1]+"</td><td>"+alldata3[4]+"</td><td>"+alldata3[3]+"<input type='hidden' id='trav_times"+incr+"' name='trav_times"+incr+"' value='"+alldata3[3]+"'></td></tr>";
		}
		
		$(tabl_data).appendTo('#best_route');
		$('.tooltips').tooltip();
		
	}
}

function before_submit()
{
	//alert('bef sub');
	var checkboxx=$('#check_boxs').val();
	var datastring = $("#ExampleBootstrapValidationForm").serialize();
		$('.loader_ax').fadeIn();
        $.ajax({
            type: "POST",
            url: "AGENT/before_submit.php?checkboxx="+checkboxx,
            data: datastring,
            success: function(res) {
                // alert('Data send'+res);
				    var ress=res.trim().split("#");
					
					if($('#check_boxs').val() == '2')
					{
						$.get('AGENT/itin_submit_trav_report.php?planid1='+ress[0]+'&planid2='+ress[1],function(result)
						{
							 $('.loader_ax').fadeOut(500);
							 //alert(result);
							 $('#det_rep').empty().html(result);
							 $('#Travel_info_mod').modal('show');
						});
					}else if($('#check_boxs').val() == '1')
					{
						$.get('AGENT/itin_submit_trhot_report.php?planid1='+ress[0]+'&planid2='+ress[1],function(result)
						{
								$('.loader_ax').fadeOut(500);
							 	$('#det_rep').empty().html(result);
							 	$('#trav_cancel').hide();
								$('#trav_save').hide();
								$('#trav_confirm1').hide();
								$('#trhotl_cancel').show();
								$('#trhotl_pms').show();
								$('#Travel_info_mod').modal('show');
							 	$('#Travel_info_mod').modal('show');
						});
					}
            }
        });
}


function go_with_add_ons()
{
	var datastring = $("#ExampleBootstrapValidationForm").serialize();
		$('.loader_ax').fadeIn();
        $.ajax({
            type: "POST",
            url: "AGENT/ajax_addi_cost.php?type=3",
            data: datastring,
            success: function(res)
			{
				//alert(res);
				if($('#check_boxs').val() == '2')
				{
						$.get('AGENT/itin_submit_trav_report.php',function(result)
						{
							 $('.loader_ax').fadeOut(500);
							// alert(result);
							 $('#det_rep').empty().html(result);
							 //$('#Travel_info_mod').modal('show');
						});
				}else if($('#check_boxs').val() == '1')
				{
						$.get('AGENT/itin_submit_trhot_report.php',function(result)
						{
								$('.loader_ax').fadeOut(500);
							 	$('#det_rep').empty().html(result);
						});
				}
				
			}
			});
}

/*function calculateDistances(org1,des1,des2) 
{
	destination1=des1;
	destination2=des2;
	origin1=org1;
	geocoder = new google.maps.Geocoder();
	var service = new google.maps.DistanceMatrixService();
	service.getDistanceMatrix(
	{
		origins: [origin1],
		destinations: [destination1,destination2],
		travelMode: google.maps.TravelMode.DRIVING,
		unitSystem: google.maps.UnitSystem.METRIC,
		avoidHighways: false,
		avoidTolls: false
	},callback);
}*/

var distarr = [];
function callback(city)
{
	return function(response, status) 
	{
		var pushstr=''; 
		var spl_dist4=0; var spl_dist3 = 0; var spl_dist21 = 0; 
		
		if (status != google.maps.DistanceMatrixStatus.OK) 
		{
			alert('Error was: ' + status);
		}
		else
		{
			var origins = response.originAddresses;
			var destinations = response.destinationAddresses;
			var ji;
			
			for (var i = 0; i < origins.length; i++) 
			{
				var results = response.rows[i].elements;
				for (var j = 0; j < results.length; j++) 
				{
					var spl_dist11 = results[j].distance.text.split("km");
					
					if (spl_dist11[0] != '')
					{
						spl_dist21=spl_dist11[0].replace(/\,/g,'');
					}
					else
					{
						spl_dist21 = 1;
					}
					spl_dist3 = parseInt(spl_dist21);
					spl_dist4+=spl_dist3;
			      }
				distarr.push(city+'-'+spl_dist4);
				$("#callbackid").val($("#callbackid").val()+','+city+'-'+spl_dist4);
				spl_dist4=0;
		    }
		}
	}
}

var vehcnt = 0;
function vehrent(travdist,flag,agent_percnt,adm_percent,disp_trdist)
{
	if (flag == 0)
	{
		var ct_extdis = ''; var getfirst = ''; var getfirst1 = ''; var appndcity = ''; var callbackid1 = '';
		callbackid1 = $("#callbackid").val();
		getfirst = callbackid1.split(',');
		getfirst1 = getfirst[1].split('-');
		appndcity = $("#citarrid").val()+'-'+getfirst1[1];
		ct_extdis =callbackid1+','+appndcity;
	}
	else if (flag == 1)
	{
		var ct_extdis = '';
		ct_extdis = $('#veh_cit_dis').val();
	}
	var plandays = parseInt($("#nn .dp-numberPicker-input").val());
	var vehrental = ''; var myVehicle = new Array();
	
	for (var z=0;z<=veh_cnt;z++)
	{
		var vehname = $("#st_vehic"+z).val();
		var getcityid = $("#st_city").val();
		
		if (typeof(vehname) != "undefined" && vehname !== null)
		{
			if (vehname != '')
			{
				var vehsplit = $('#st_vehic'+z+' option:selected').text().split('~');
				var vehtyp = vehsplit[0];
				var vehsplit = vehname.split('-');
				var citysplit = getcityid.split('-');
				vehcnt++;
				myVehicle.push(z+'~'+vehsplit[0].trim()+'~'+citysplit[0].trim()+'~'+vehtyp);
			}
		}
	}
	//alert(JSON.stringify(myVehicle));
	$("#vehicles").val(myVehicle);
	var allcitids = $('#cid_arr').val();
	//alert(ct_extdis);
	if(myVehicle.length > 0)
	{
		//alert('vehii');
		$.getJSON('<?php echo "AGENT/rent_vehicl.php"; ?>', { arrsend: myVehicle, trdist: travdist, trdays: plandays, ext_dist: ct_extdis, allcids: allcitids }, function(data) {
			//alert("Value for 'detl': " + data.detl + "\nValue for 'retn': " + data.retn + "\nValue for 'netamt': " + data.netamt);
			//document.getElementById('show_rental').innerHTML=data.detl;
			$("#veh_upl").val(data.vehupl);
			$("#all_veh_upl").val(data.all_veh_rent);
			$("#ret_dist").val(data.retn);
			$("#tr_tot_amt").val(data.netamt);
			$("#pervehamt").val(data.pervehamt);
			$("#vehcitid").val(data.vehcitid);
			$("#permt_amt").val(data.tot_perm_amt);
			if ($('#check_boxs').val() == '2')
			{
				var dist_total = document.getElementById('show_distot');
				var total_days = document.getElementById('show_days');
				var plantrdays = parseInt($("#nn .dp-numberPicker-input").val());
				
				//dist_total.innerHTML = "<strong> Total travel distance: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "+disp_trdist+ " kms. </strong>" + '<br>';
				//total_days.innerHTML = "<strong> Travel days: "+plantrdays + "</strong>" + '<br>';
				
				var net_tot = document.getElementById('netamount');
				net_tot.innerHTML = '';
				 var netamt1=parseInt(data.netamt);
				// alert(netamt1);
				var admn_grand_tot = netamt1 + ((parseInt(adm_percent) / 100) * parseInt(netamt1));
				var agnt_grand_totl = parseInt(admn_grand_tot) + ((parseInt(agent_percnt) / 100) * parseInt(admn_grand_tot));
				//alert('ff'+agnt_grand_totl);
				//net_tot.innerHTML+= "<strong>Net charge for your transport: Rs. "+Math.round(agnt_grand_totl) + "</strong>" + '<br>';
				agnt_grand_totl=Math.round(agnt_grand_totl);
				dist_total.innerHTML="<center><table width='90%'><tr><td width='40%'>Travel days</td><td>:</td><td width='40%'>"+plantrdays+"</td></tr><tr><td>Total travel distance ( Kms )</td><td>:</td><td>"+disp_trdist+"</td></tr><tr><td>Net charge for your transport (Rs.) </td><td>:</td><td>"+agnt_grand_totl.toLocaleString()+"/- </td></tr></table></center>";
				
				var terms = "<br><br><strong><font color='red'>Terms & Conditions: </font></strong><br> <strong>Package  Includes:</strong><br>Transfers and sightseeing  By  deluxe  tourists vehicle <strong><font color='red'>( Vehicles up hill driving and down hill would be on Non AC)</font></strong><br>Toll & Parking <br>Service Taxes <br>All local sightseeing in the same vehicle, every day after breakfast till sunset ( 0700 AM to 08PM)<br><br>IMPORTANT: Kindly note that  vehicles  mentioned above only indicate that our rates have been based on usage of the locations and Kilometres  and it is not to be construed that the same vehicles will be provided if the vehicles are not available in the selected locations we shall provide from the different neareast availble location for the same rate may change (supplement/reduction whatever applicable). Unless until we  Dvi Holidays sends you the written confirmation from reservation the quote is not final.";
				
				document.getElementById('show_terms').innerHTML=terms;
			}
			else if ($('#check_boxs').val() == '1')
			{
				//alert('1');
				var dist_total = document.getElementById('show_distot');
				var total_days = document.getElementById('show_days');
				var plantrdays = parseInt($("#nn .dp-numberPicker-input").val());
				
			//	dist_total.innerHTML = "<strong> Total travel distance: "+disp_trdist+ " kms. </strong>" + '<br>';
				//total_days.innerHTML = "<strong> Travel days: "+plantrdays + "</strong>" + '<br>';
				
				var net_tot = document.getElementById('netamount');
				net_tot.innerHTML = ''; var netamt1=parseInt(data.netamt);
				var admn_grand_tot = netamt1 + ((parseInt(adm_percent) / 100) * parseInt(netamt1));
				var agnt_grand_totl = parseInt(admn_grand_tot) + ((parseInt(agent_percnt) / 100) * parseInt(admn_grand_tot));
					agnt_grand_totl=Math.round(agnt_grand_totl);
				//net_tot.innerHTML+= "<strong>Net charge for your transport: Rs. "+Math.round(agnt_grand_totl) + "</strong>" + '<br>';
				
				dist_total.innerHTML="<center><table width='90%'><tr><td width='40%'>Travel days</td><td>:</td><td width='40%'>"+plantrdays+"</td></tr><tr><td>Total travel distance ( Kms )</td><td>:</td><td>"+disp_trdist+"</td></tr><tr><td>Net charge for your transport (Rs.) </td><td>:</td><td>"+agnt_grand_totl.toLocaleString()+"/- </td></tr></table></center>";
				
				view_stay_quote(<?php echo $agent_perc; ?>,<?php echo $agnt_adm_perc; ?>);
				show_get_quote();
			}
			
		//	$('#subplan').trigger('click');
		sendappr();
		//alert('call bef sub');
			before_submit();
			
		}).error(function(jqXHR, textStatus, errorThrown) {
			alert(jqXHR.responseText);
    // Inspect the values of jqXHR, textStatus, errorThrown here.
});
	}
	
}

function validate()
{
	if ($('#guestname').val() == '' || $('#mobil').val() == '' || $('#arrdet').val() == '' || $('#depdet').val() == '') 
	{
		$('#formerr').text("Please enter all the fields below..").show();
		return false;
	}
	return true;
}
function sendappr()
{
	
				$("#trv_cnt").val($("#np .dp-numberPicker-input").val());
				$("#trv_days").val($("#nn .dp-numberPicker-input").val());
				$("#trv_nights").val($("#nd .dp-numberPicker-input").val());
				$("#trv_adult").val($("#na .dp-numberPicker-input").val());
				$("#trv_child").val($("#nc .dp-numberPicker-input").val());
				$("#trv_room").val($("#totrooms .dp-numberPicker-input").val());
				//document.thplan.submit();
				///return true;
}


function alertdist(distdiff)
{
	var alerdist = distdiff.split('-');
	if(alerdist[3].trim() > 175)
	{
		swal("NOTE - The distance to your chosen departure airport/railway-station is "+alerdist[3].trim()+" kms. Hence request you to organize your travel accordingly for your smooth onward journey");
	}
}
function alertopt()
{
	swal("Dear Agent, \n Great!!! you have created a better itnerary, hence you can go ahead with your own itinerary  !!!! \n\n Best regards - DVI Team");
}

function alertdt(allow_cnt, dt_cit)
{
	swal("Dear <?php echo $user_fname; ?>, Only "+allow_cnt+" daytrip city allowed for "+dt_cit+".\n Please deselect the other cities");
}

function hidesave()
{
	$('#final_save_btn').hide();
}

function close_dropdown(nos)
{
		$('#via_indiv'+nos).hide();
}

function trv_via_fun(nos,vias)
{
	/*if($('#mod_via_'+nos+'_'+vias).length!=0)
	{
		$('#mod_via_'+nos+'_'+vias).remove();
	}*/
	if($('#mod_via_'+nos+'_'+vias).length==0)
	{
		var from_city_selt_txt=$('#start_city'+nos).val();
		var to_city_selt_txt=$('#row_city'+nos+' option:selected').text().split('-');
		var to_city_selt=$('#row_city'+nos).val();
		var via_list;
		if(to_city_selt.trim() != '')
		{
			//for changing dvi sugg funtion in to my planned itinerary
				if(vias==0)
				{
					frm_cy0=$('#st_city').val().split('-');
					frm_cy=frm_cy0[0].trim();
					
					to_cy0=to_city_selt.split('-');
					to_cy=to_cy0[0].trim();
					//alert(frm_cy+' - '+to_cy);
				}else{
					vias1=vias-1;
					frm_cy0=$('#row_city'+vias1+'0').val().split('-');
					frm_cy=frm_cy0[0].trim();
					
					to_cy0=to_city_selt.split('-');
					to_cy=to_cy0[0].trim();
					//alert("others "+frm_cy+' - '+to_cy);
				}
				$('.loader_ax').fadeIn();
				$.ajax({
						type: 'POST',
						url: "AGENT/ajax_via_modal.php",
						data: "nos="+nos+"&vias="+vias+"&from_city_selt_txt="+from_city_selt_txt+"&frm_cy="+frm_cy+"&to_cy="+to_cy+"&to_city_selt_txt="+to_city_selt_txt,
							success: function(da)
							{
								//alert(da);
								$('.loader_ax').fadeOut();
								$('#modal_galary').append(da);
								$('#mod_via_'+nos+'_'+vias).modal('show');
								$('.tooltips').tooltip();
								//$('.via_tab').destroy();
								$('.chosen-select').chosen({width:'100%'});
								$('#via_tab_'+nos+'_'+vias).dataTable();
							},
							error : function(xhr, status, error)
							{
								 alert(xhr.responseText);
							}
						});
		}else{
			alert('Please Choose Destination City');
		}
	}
	else{
		$('#mod_via_'+nos+'_'+vias).modal('show');	
	}
}


function extent_via(tr1,tr2,fid,eid,no)
{
	//alert(tr1+'/'+tr2+'/'+fid+'/'+eid+'/'+no);
	var mid=$('#via_sel_pick'+tr1+'_'+tr2+'_'+no).val().trim();
	if(mid!='')
	{
		var mmid=mid.split('-');
		var nxt=parseInt(no)+1;
		$('.loader_ax').fadeIn();
$.get('AGENT/ajax_via.php?type=3&nos='+tr1+'&vias='+tr2+'&frm_cy='+fid+'&to_cy='+eid+'&nextbox='+nxt+'&mid='+mmid[0]+'&befdist='+mmid[1],function(res){
	$('.loader_ax').fadeOut(500);
			var result=res.trim();
			if(result!='No Via')
			{
				$('#tot_vias'+tr1+'_'+tr2).val(parseInt($('#tot_vias'+tr1+'_'+tr2).val())+1);
				$('#pick_div_'+tr1+'_'+tr2+'_1').append(res);
				
				$('.chosen-select').chosen('destroy');
				$('#via_sel_pick'+tr1+'_'+tr2+'_'+no).prop("disabled",true).addClass("chosen-select");
				$('.chosen-select').chosen({width:'100%'});
				
				$('#btn_extend'+tr1+'_'+tr2+'_'+no).fadeOut();
				$('#btn_reduce'+tr1+'_'+tr2+'_'+no).fadeOut();
			}else{
				alert('No more cities available to visit as per rules..');	
			}
		});
	}else{
		alert('Please Select Any City');
		$('#via_sel_pick'+tr1+'_'+tr2+'_'+no).focus();
	}
}
 
function reduce_via(tr1,tr2,no)
{
	var pno=parseInt(no)-1;
	$('#tot_vias'+tr1+'_'+tr2).val(parseInt($('#tot_vias'+tr1+'_'+tr2).val())-1);
	$('#pick_div_'+tr1+'_'+tr2+'_'+no).remove();
	
	$('.chosen-select').chosen('destroy');
	$('#via_sel_pick'+tr1+'_'+tr2+'_'+pno).prop("disabled",false).addClass("chosen-select");
	$('.chosen-select').chosen({width:'100%'});
				
	$('#btn_extend'+tr1+'_'+tr2+'_'+pno).fadeIn();
	$('#btn_reduce'+tr1+'_'+tr2+'_'+pno).fadeIn();
	
}

function create_via_route(tr1,tr2,fid,eid,fname,ename)
{
	var loop_cnt=$('#tot_vias'+tr1+'_'+tr2).val().trim();
	var lval='',lvname='',lnames='',lvalid='',result1='',result2='',dist='';
	//alert(tr1+' = '+tr2+' = '+fid+' = '+eid+' = '+fname+' = '+ename+' L= '+loop_cnt);
	if(loop_cnt>0)
	{		
			var chk='no';
			for(var lll=1;lll<=loop_cnt;lll++)
			{
				lvalid=$('#via_sel_pick'+tr1+'_'+tr2+'_'+lll).val().trim().split('-');
				if(lvalid=='')
				{
					chk='yes';
				}
			}
			if(chk!='yes')
			{
				for(var ll=1;ll<=loop_cnt;ll++)
				{
					lvalid=$('#via_sel_pick'+tr1+'_'+tr2+'_'+ll).val().trim().split('-');
					lvname=$('#via_sel_pick'+tr1+'_'+tr2+'_'+ll+' option:selected').text().trim();
					
					if(lval=='')
					{
						lval=lvalid[0];	
						lvnames=lvname;
					}else{
						lval=lval+'-'+lvalid[0];	
						lvnames=lvnames+'-'+lvname;
					}
					dist=lvalid[2];
				}
				result1=fid+'-'+lval+'-'+eid;
				result2=fname+'-'+lvnames+'-'+ename;
				$('#sel_via_trav_cids_'+tr1+'_'+tr2).val(result1);
				$('#sel_via_trav_cnames_'+tr1+'_'+tr2).val(result2);
				$('#sel_via_trav_totdis_'+tr1+'_'+tr2).val(dist);
				$('#mod_via_'+tr1+'_'+tr2).modal('hide');
			}else{
				alert('Please Select All Ways..');
			}
	}else{
		$('#mod_via_'+tr1+'_'+tr2).modal('hide');
	}
	
}

function cancel_via_route(tr1,tr2)
{
	$('#mod_via_'+tr1+'_'+tr2).modal('hide');
	setTimeout(function(){
		$('#mod_via_'+tr1+'_'+tr2).remove();
		},1000);
}


function put_val_via_fun(id,cids,cnames,tot_dis)
{
	$('#sel_via_trav_cids_'+id).val(cids);
	$('#sel_via_trav_cnames_'+id).val(cnames);
	$('#sel_via_trav_totdis_'+id).val(tot_dis);	
	
	var MY_Plan =$('#mypln').attr('onclick');
	$('#divpln').removeAttr('onclick').attr('onclick',MY_Plan);
}

function trigger_getquot(wn)
{
	var lcnt_dtp;
	var r_dtp;
	
	if(wn.trim()=='go')
	{
		$('#trav_quot').trigger("click");
		if($('#day_trip_allows').val().trim()=='allow')
		{
			$('#travel_info_mod_footer').show();
			$('#dt_panel').hide();
			$('#rep_tabss').fadeIn();
		}
	}else if(wn.trim()=='no')
	{
		if($('#day_trip_allows_cnt').length>0)
		{
			lcnt_dtp=$('#day_trip_allows_cnt').val().trim();
			if(lcnt_dtp>0)
			{
			   for(r_dtp=0;r_dtp<lcnt_dtp;r_dtp++)
			   {
				 //  alert(r_dtp);
				   $("#sel_dtid"+r_dtp).val('').trigger("chosen:updated");
			   }
			}
		}
		$('#trav_quot').trigger("click");
		$('#travel_info_mod_footer').show();
		$('#dt_panel').hide();
		$('#rep_tabss').fadeIn();
	}
}

function manage_status(sts)
{
	var spid=$('#sub_planid').val().trim().split('#');
	if(sts=='cancel')
	{
		$.get('AGENT/ajax_agent.php?spid1='+spid[0]+'&spid2='+spid[1]+'&type=27',function(result)
		{	$('.loader_ax').fadeIn();
			var cont=$('#det_rep').html();
					$.post('AGENT/ajax_mail.php?type=4',{ content : cont },function(con){ $('.loader_ax').fadeOut();  });
			alert('Itinerary Plan Is Cancelled'+$('#sub_planid').val());
			location.reload();
		});
		
	}else if(sts=='conform')
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
			$('.loader_ax').fadeIn();
		$.get('AGENT/ajax_agent.php?spid1='+spid[0]+'&spid2='+spid[1]+'&type=26'+'&gname='+gnamme+'&gmobi='+$('#mobil').val()+'&garrdet='+$('#arrdet').val()+'&gdepdet='+$('#depdet').val(),function(result)
		{
			$('#Travel_info_mod').modal('hide');
					//sending mail 
					var cont=$('#det_rep').html();
					$.post('AGENT/ajax_mail.php?type=3',{ content : cont },function(con){ $('.loader_ax').fadeOut(); });
			alert(gnamme+' - We are please to accept your request for reservation.If urgent please get in touch with your tour manager @ 9047776899/9047776849');
			location.reload();
					});
		}
	}else if(sts=='waiting')
	{   $('.loader_ax').fadeIn();
		$.get('AGENT/ajax_agent.php?spid1='+spid[0]+'&spid2='+spid[1]+'&type=28',function(result)
		{
				var cont=$('#det_rep').html();
				$.post('AGENT/ajax_mail.php?type=1',{content: cont},function(con){
					//alert('rrrrr'+con);
					$('.loader_ax').fadeOut();
				});
			alert('Itinerary Plan Saved Successfully'+$('#sub_planid').val());
			location.reload();
		});
	}
}

function hide_modal_trav_body()
{
	$('#report_modal_body').hide();
	$('#travel_info_mod_footer').hide();
	$('#report_modal_body_confirm').show();
	$('#travel_info_mod_footer11').show();	
}

function show_modal_trav_body()
{
	$('#report_modal_body_confirm').hide();
	$('#travel_info_mod_footer11').hide();
	$('#report_modal_body').show();
	$('#travel_info_mod_footer').show();
		
}

function manage_trhot_status(sts)
{
	if(sts=='plan_my_stay')
	{
	$('#Travel_info_mod').hide();
	$('#init_boxx').hide();
	
	$('#secondary_boxx').fadeIn();
	
	$('#table_collection0').empty();
	var err_len=$('#new_room_table tbody').children().length;
	
	//room formation start
		$('#stay').hide();
		$('#tableee').show();
			var num_of_rooms=parseInt($("#totrooms .dp-numberPicker-input").val());	
			$('#room_of_num').val(num_of_rooms);
			var day_of_stay=parseInt($("#nd .dp-numberPicker-input").val());	
			$('#day_of_stay').val(day_of_stay);
			
			var tt_ad_val2=$('#adult_no_cal').val();
			var tt_ad_val3;
			
			if(tt_ad_val2>=3 )
			{
		$('#adlt_nw_td1').empty().html("<select id='sel_adlt_nw1' name='sel_adlt_nw1' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_youth(this.value,1); find_no_adult_rem(this.value,1)'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>");
		$('.chosen-select').chosen({width:'100%'});
			}else if(tt_ad_val2>=2 )
			{
		$('#adlt_nw_td1').empty().html("<select id='sel_adlt_nw1' name='sel_adlt_nw1' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_youth(this.value,1); find_no_adult_rem(this.value,1)'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
		$('.chosen-select').chosen({width:'100%'});
			}else if(tt_ad_val2>=1 )
			{
	$('#adlt_nw_td1').empty().html("<select id='sel_adlt_nw1' name='sel_adlt_nw1' class='form-control chosen-select' data-placeholder='choose' onChange= find_no_youth(this.value,1); find_no_adult_rem(this.value,1)'> <option selected value='0'>choose</option><option value='1'>1</option></select>");
	$('.chosen-select').chosen({width:'100%'});
			}
			
			for(nw_rm=2;nw_rm<=num_of_rooms;nw_rm++)
			{//alert(nw_rm);
				var new_rm_add="<tr id='new_rm_tr"+nw_rm+"'><td style='padding:10px' id='room_nw_td"+nw_rm+"'>Room "+nw_rm+"</td><td style='padding:10px' id='adlt_nw_td"+nw_rm+"'><input type='text' id='sel_adlt_nw"+nw_rm+"' value='0' name='sel_adlt_nw"+nw_rm+"' readonly class='form-control tooltips'></td><td style='padding:10px' id='ch512_nw_td"+nw_rm+"'><input type='text' value='0' id='sel_nw_512ch"+nw_rm+"' name='sel_nw_512ch"+nw_rm+"' readonly class='form-control tooltips' ></td><td style='padding:10px' id='chb5_nw_td"+nw_rm+"'><input type='text' value='0' id='sel_nw_b5ch"+nw_rm+"' name='sel_nw_b5ch"+nw_rm+"' readonly class='form-control tooltips' ></td><td style='padding:10px' id='extr_nw_td"+nw_rm+"'><select id='sel_nw_extr"+nw_rm+"' name='sel_nw_extr"+nw_rm+"' class='form-control chosen-select'><option value='-' selected>Nil</option><option value='0'>With Bed</option><option value='1'>Without Bed</option></select></td></tr>";
				
				var prvv=nw_rm-1;
				$(new_rm_add).insertAfter('#new_rm_tr'+prvv);
				$('.chosen-select').chosen({width:'100%'});
			}
			//room formation end
	
	}else if(sts=='cancel')
	{
		var spid=$('#sub_planid').val().trim().split('#');
		$.get('AGENT/ajax_agent.php?spid1='+spid[0]+'&spid2='+spid[1]+'&type=27',function(result)
		{
			alert($('#sub_planid').val()+' - Itinerary Plan is cancelled..');
			$('#Travel_info_mod').modal('hide');
			location.reload();
		});
	
	}
}

function backto_init_boxx()
{
	$('#trhotl_pms').hide();
	$('#trhotl_pms1').show();
	$('#secondary_boxx').hide();
	$('#init_boxx').fadeIn();
	$('#Travel_info_mod').modal('show');
}

function dvi_sugg_hotel()
{ 
	$('#food_only_div').show();
	var troom=$('#room_of_num').val();
	var tadult=$('#adult_no_cnt').val();
	var tch512=$('#child512_no_cnt').val();
	var tch5blw=$('#child_no_cnt').val();
	var tot_fpax=parseInt(tadult)+parseInt(tch512);
	var tot_pax=parseInt(tadult)+parseInt(tch512)+parseInt(tch5blw);
	var tot1=0,tot2=0,tot3=0;
	var extbed=''
	for(var l=1; l<=troom; l++)
	{
		tot1=tot1+parseInt($('#sel_adlt_nw'+l).val());
		tot2=tot2+parseInt($('#sel_nw_512ch'+l).val());
		tot3=tot3+parseInt($('#sel_nw_b5ch'+l).val());
		
		if(extbed=='')
		{
			extbed=$('#sel_nw_extr'+l).val();
		}else{
			extbed=extbed+','+$('#sel_nw_extr'+l).val();
		}
	}
	if(tot1!=tadult)
	{
		alert('Total adult count must be '+tadult+'. Selected adult count value - mismatched. Please reselect adults per room..');
	}else if(tot2!=tch512)
	{
		alert('Total 5-12 age-child(ren) count must be '+tch512+'. Selected 5-12 age-child(ren) count value - mismatched. Please reselect 5-12 age-child(ren) per room..');
	}else if(tot3!=tch5blw)
	{
		alert('Total Below-5-age-child(ren) count must be '+tch5blw+'. Selected Below-5-age-child(ren) count value - mismatched. Please reselect Below-5-age-child(ren) per room..');
	}else{

//for emptying initially
	$('#planmy_hotel_div').hide();
	$('#dvi_sugg_hotel_div').fadeIn();
	$('#plan_my_stay_txt').val('0');
	$('#dvi_sug_hotel_txt').val('1');
	
	var food_cate=$('#food_categ_dvi').val();
	var stay_cntt=parseInt($("#nd .dp-numberPicker-input").val());
	var stdt=$('#arrdate').val();
	$('.loader_ax').fadeIn();
	$.get('AGENT/dvi_sugg_hotels.php?ccids='+$('#kit_cityidd').val()+'&stay_cntt='+stay_cntt+'&stdate='+stdt+'&tot_fpax='+tot_fpax+'&troom='+troom+'&food_catd='+food_cate+'&tot_pax='+tot_pax+'&extbed='+extbed,function(res){
		$('.loader_ax').fadeOut();
		$('#load_div_sugg_quote').empty().html(res);
		$('.chosen-select').chosen({width:'100%'});
				if($('#hide_5star').length>0)
				{
					var hide5=$('#hide_5star').val().trim();
					$('#div_catg_'+hide5).hide();
				}
		});
		
	}
	
}

function show_hotel_list(opt)
{
	
	if(opt=='plan_mystay' && $('#prev_catg').length>0)
	{
		$('#prev_catg').val('');
	}
	
	//if($('#prev_catg').length>0 && $('#prev_catg').val().trim()!='')//dvi suggested hotels
	if($('#prev_catg').length>0  && opt!='plan_mystay')//dvi suggested hotels
	{
		if($('#prev_catg').val().trim()=='' && opt!='plan_mystay')
		{
			alert('Please choose any category of hotels..');
		}else{
				var checkboxx=$('#check_boxs').val();
				var datastring = $("#ExampleBootstrapValidationForm").serialize();
				$.ajax({
					type: "POST",
					url: "AGENT/before_hotel_submit.php?checkboxx="+checkboxx+'&option='+opt,
					data: datastring,
					beforeSend: function(bres){
							$('.loader_ax').fadeIn();
						},
					success: function(res) {
						 //alert('Hotel Data send'+res);
						 	$('.loader_ax').fadeOut();
							if($('#check_boxs').val() == '1')
							{
										$('#trav_cancel').show();
										$('#trav_confirm1').show();
										$('#trhotl_cancel').hide();
										$('#trhotl_pms').hide();
										$('#trhotl_pms1').hide();
										$('#det_rep').empty().html(res);
										$('#Travel_info_mod').modal('show');
							}
					}
				});	
						
		}
	}else{///plan_mystay
						//validation to plan_mystay
						var csk=0;
						var prv_c=$('#prv_ch').val();
						if(prv_c != '')
						{
						$('#'+prv_c).css('background-color','#FFF');
						}
						var days=parseInt($("#nd .dp-numberPicker-input").val());
						var rooms=parseInt($("#totrooms .dp-numberPicker-input").val());
						
						for(var dd=1;dd<=days;dd++)
						{
							var mybtn=parseInt($('body #vali_quote').offset().top);
							var dates=$('#sdat'+dd).val();
							if($('#hotel_sel_id'+dd).val().trim() =='')
							{
								
								alert('hotel does not choosed in '+dates);
								$('#hotel_nw_td'+dd).css('background-color','#FCC');
								$('#prv_ch').val('hotel_nw_td'+dd);
								csk=1;
								exit(0);
							}
							
							for(var chy2=1;chy2<=rooms;chy2++)
							{
										if($('#hot_rm_id'+dd+'_'+chy2).length>0 && $('#hot_rm_id'+dd+'_'+chy2).val()=='')
										{
											alert('hotel room does not choosed in '+dates);
											$('#tdroom_nw_td'+dd).css('background-color','#FCC');
											$('#prv_ch').val('tdroom_nw_td'+dd);
											csk=1;
											exit(0);
										}
							}
							
							if($('#tr_cnt_'+dd).length>0 && $('#tr_cnt_'+dd).val()!='')
							{
								for(var chy3=0;chy3<=$('#tr_cnt_'+dd).val();chy3++)
								{
											if($('#hot_hb_rm_id'+dd+'_'+chy3).length>0 && $('#hot_hb_rm_id'+dd+'_'+chy3).val()=='')
											{
												alert('houseboat rooms does not choosed in '+dates);
												$('#tdroom_nw_td'+dd).css('background-color','#FCC');
												$('#prv_ch').val('tdroom_nw_td'+dd);
												csk=1;
												exit(0);
											}
								}
							}
						}
								
						if(csk==0)
						{//call to plan_mystay
			var checkboxx=$('#check_boxs').val();
			var datastring = $("#ExampleBootstrapValidationForm").serialize();
				$.ajax({
					type: "POST",
					url: "AGENT/before_hotel_submit.php?checkboxx="+checkboxx+'&option='+opt,
					data: datastring,
					beforeSend: function(bres){
							$('.loader_ax').fadeIn();
						},
					success: function(res) {
						$('.loader_ax').fadeOut();
						 //alert('Hotel Data send'+res);
							
							if($('#check_boxs').val() == '1')
							{
										$('#trav_cancel').show();
										if(opt!='plan_mystay')
										{
										$('#trav_save').show();
										}
										$('#trav_confirm1').show();
										$('#trhotl_cancel').hide();
										$('#trhotl_pms').hide();
										$('#trhotl_pms1').hide();
									//alert(res);
										$('#det_rep').empty().html(res);
										$('#Travel_info_mod').modal('show');
							}
					}
				});
						}//valid
	}//else end
	
}

function set_cate(categ)
{
	var tc_arr=$('#kit_cityidd').val().split(',');
	var hlid,disb='no';
	for(var ch=0; ch<tc_arr.length; ch++)//checking to disable button if hotel not available
	{
		hlid=$('#hid_'+categ+'_'+ch).val().trim();
		if( hlid=='-' || hlid=='')
		{
			disb='yes';
		}
	}
	
	if(disb!='yes')
	{
			var prv=$('#prev_catg').val().trim();
			if(prv != '')
			{
				$('#catg_tab_'+prv).css('border','');
				$('#catg_tab_'+prv).css('background-color','');
				$('#plan_hotel_sub_'+prv).hide();
				$('#catg_tab_'+categ).css('border','3px solid #6EC7E8');
				$('#catg_tab_'+categ).css('background-color','#F3F3F3');
				$('#plan_hotel_sub_'+categ).show();
				$('#prev_catg').val(categ);
			}else{
				$('#catg_tab_'+categ).css('border','3px solid #6EC7E8');
				$('#catg_tab_'+categ).css('background-color','#F3F3F3');
				$('#plan_hotel_sub_'+categ).show();
				$('#prev_catg').val(categ);
			}
	}else{
		alert("Some Hotels are unavailable, hence you can't choose this option.. ");
		$('#btn_'+categ).addClass('disabled');
	}
}

function set_food_categ(sfood)
{
	$('#food_categ_dvi').val(sfood);	
}

function resume_later(ss)
{
	var food=$('#food_categ_dvi').val().trim();
	var troom=$('#room_of_num').val();
	var tadult=$('#adult_no_cnt').val();
	var tch512=$('#child512_no_cnt').val();
	var tch5blw=$('#child_no_cnt').val();
	var tot_fpax=parseInt(tadult)+parseInt(tch512);
	var tot_pax=parseInt(tadult)+parseInt(tch512)+parseInt(tch5blw);
	var tot1=0,tot2=0,tot3=0;
	var extbed='',adl='',c12='',cb5='';
	for(var l=1; l<=troom; l++)
	{
		if(adl=='')
		{
			adl=$('#sel_adlt_nw'+l).val();
		}else{
			adl=adl+','+$('#sel_adlt_nw'+l).val();
		}
		
		if(c12=='')
		{
			c12=$('#sel_nw_512ch'+l).val();
		}else{
			c12=c12+','+$('#sel_nw_512ch'+l).val();
		}
		
		if(cb5=='')
		{
			cb5=$('#sel_nw_512ch'+l).val();
		}else{
			cb5=cb5+','+$('#sel_nw_512ch'+l).val();
		}
		
		if(extbed=='')
		{
			extbed=$('#sel_nw_extr'+l).val();
		}else{
			extbed=extbed+','+$('#sel_nw_extr'+l).val();
		}
	}
	
	var tot_room=adl+'/'+c12+'/'+cb5+'/'+extbed+'/'+food; //adultperroom/child512 perroom/childb5 perroom/extra bed/food
	
	var cplan=$('#sub_planid').val().split('#');
	
	$.get('AGENT/ajax_agent.php?cplan1='+cplan[0]+'&cplan2='+cplan[1]+'&tot_room='+tot_room+'&type=29',function(ress)
	{
		//alert("MMMM "+$('#det_rep').html());
		cont_trv=$('#det_rep').html();
		cont_htl=$('#load_div_sugg_quote').html();
		//alert("hotel  "+cont_htl);
		$.post('AGENT/ajax_mail.php?type=2', { content_tvl: cont_trv , content_htl: cont_htl },function(con){ 
		//alert(con);
		});
			alert('This itinerary plan will be resume later , Reference ID : '+$('#sub_planid').val());
			location.reload();
	});
		
}

function back_to_stay()
{
	$('#Travel_info_mod').hide();
	$('#init_boxx').hide();
	$('#secondary_boxx').fadeIn();
}

function houseboat_editable(hid,ctg,no)
{
	//alert(hid+' - '+ctg+' - '+no);
	var troom=$('#room_of_num').val();
	var tadult=$('#adult_no_cnt').val();
	var tch512=$('#child512_no_cnt').val();
	var tch5blw=$('#child_no_cnt').val();
	var tot_fpax=parseInt(tadult)+parseInt(tch512);
	var tot_pax=parseInt(tadult)+parseInt(tch512)+parseInt(tch5blw);
	
	var extbed=''
	for(var l=1; l<=troom; l++)
	{
		if(extbed=='')
		{
			extbed=$('#sel_nw_extr'+l).val();
		}else{
			extbed=extbed+','+$('#sel_nw_extr'+l).val();
		}
	}
	
	var food_cate=$('#food_categ_dvi').val();
	var stay_cntt=parseInt($("#nd .dp-numberPicker-input").val());
	var stdt=$('#arrdate').val();
	
	$('.loader_ax').fadeIn();
	$.get('AGENT/dvi_sugg_hotel_edit.php?ccids='+$('#kit_cityidd').val()+'&stay_cntt='+stay_cntt+'&stdate='+stdt+'&tot_fpax='+tot_fpax+'&troom='+troom+'&food_catd='+food_cate+'&tot_pax='+tot_pax+'&extbed='+extbed+'&edit_ctg='+ctg+'&edit_hid='+hid+'&edit_no='+no,function(res){
		$('.loader_ax').fadeOut();
		$('#catg_tab_'+ctg).empty().html(res);
		$('.chosen-select').chosen({width:'100%'});
		
	});
	
}
</script>