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
                    <form id="ExampleBootstrapValidationForm" name="ExampleBootstrapValidationForm" method="post" class="">
                    <input type="hidden" id="tot_num_of_form" name="tot_num_of_form" value="0">
                    <input type="hidden" id="check_boxss_br0" name="check_boxss_br0" value="2" />
                    <input type="hidden" id="befr_sub_input" name="befr_sub_input" value="0">
                     <input type="hidden" id="befr_htl_sub_input" name="befr_htl_sub_input" value="0">
                     <input type="hidden" value="0" id="day_trip_results" name="day_trip_results">
                     <input type="hidden" value="0" id="day_trip_counts" name="day_trip_counts">
                    <div class="the-box" style="border:#999 1px solid">
                    <div class="row" id="init_boxx" >
                       <div class="col-sm-12">
                    <div id="breakup_main_br0"  onclick="breakup_toggle_click('br0')" style="border:1px solid #3EAFDB; padding:6px; background-color:#E0F8FF; text-align:center; display:none; cursor:pointer " > <i class="fa fa-minus "></i>&nbsp;
                    <strong id="toggle_title_br0" class="flashit" style="color:#0184AB; background-color:#E0F8FF">Created Itinerary [ 02-Feb-2015 to 25-Feb-2015 ]</strong></div>
                    </div>
                        <div class="col-sm-12" id="breakup_sub_br0" >
                        <div class="col-sm-4" style=" background-color:rgb(239, 251, 255); border:1px solid rgb(172, 232, 255);">
                        	<table width="100%">
                            <tr><th colspan="3" style="text-align:center; color:#206682">Fill Out Below Details</th></tr>
                            <tr><td colspan="3"><hr style="margin-top:5px; margin-bottom:5px"></td></tr>
                            <tr><td width="58%" ><label class="control-label">No. Of Adults</label></td><td width="3%">:</td><td width="39%"><input class="form-control che_numb" type="number"  min="1" max="100" name="num_traveller_br0" id="num_traveller_br0" value="2">
                            <input type="hidden" value="2" id="adult_no_cal_br0" name="adult_no_cal_br0"/>
                            </td></tr>
                             <tr><td colspan="3">&nbsp;</td></tr>
                            <tr><td><label class="control-label">No. Of Children <small>(5-12 age)</small></label></td><td>:</td><td><input type="number"  min="0" max="25"  class="form-control che_numb" name="num_chd512_br0" id="num_chd512_br0" value="0">
                            <input type="hidden" value="0" id="child512_no_cal_br0" name="child512_no_cal_br0"/></td></tr>
                             <tr><td colspan="3">&nbsp;</td></tr>
                            <tr><td><label class="control-label">No. Of Babies <small>( below 5 age)</small></label></td><td>:</td><td><input type="number"  min="0" max="25" class="form-control che_numb" name="num_chd_b5_br0" id="num_chd_b5_br0" value="0">
                              <input type="hidden" value="0" id="child_no_cal_br0" name="child_no_cal_br0"/></td></tr>
                             <tr><td colspan="3">&nbsp;</td></tr>
                             <tr><td><label class="control-label">Travelling Days</label></td><td>:</td><td><input type="number"  min="2" max="100" class="form-control che_numb" name="num_tradays_br0" id="num_tradays_br0" value="3" onChange="fun_chang_days('br0',this.value)"></td></tr>
                             <tr><td colspan="3">&nbsp;</td></tr>
                             <tr><td><label class="control-label">Travelling Nights</label></td><td>:</td><td><input type="number"  min="1" max="100" class="form-control che_numb" name="num_tranight_br0" id="num_tranight_br0" value="2"  onChange="fun_chang_nights('br0',this.value)"></td></tr>
                             <tr><td colspan="3">&nbsp;</td></tr>
                            </table>
                            <table width="100%" style="border-top:1px dashed #4DADFF">
                            <tr><td width="40%" style="padding: 2px;"><label class="control-label">Choose </label></td>
                            <td width="10%">:</td>
                             <td  width="50%" >
                              <label style="font-weight:600; color:#2D426D">
                     <input type="radio" checked value="no_stay" id="stay_rm_ht1_br0" name="stay_rm_ht_br0" class="i-grey-square my_chec" onBlur="travel_or_stay('br0')">Transport Only</label>
                             </td></tr>
                             <tr><td width="40%"></td>
                            <td width="10%">:</td>
                             <td  width="50%" >
                               <label style="font-weight:600; color:#2D426D; ">
                             <input type="radio" value="yes_stay" id="stay_rm_ht_br0" name="stay_rm_ht_br0" class="i-grey-square my_chec" onBlur="travel_or_stay('br0')">Transport + Hotel</label>
                             </td></tr>
                             
                             <tr id="no_of_rooms_tr_br0" style="display:none;"><td><label class="control-label" style="margin-top: 7px;">No. Of Rooms</label></td><td>:</td><td><input type="number" class="form-control che_numb" name="num_room_htls_br0" id="num_room_htls_br0" value="1" style="margin-top: 7px; width: 125px;" min='1' max="50" >
                             </td></tr>
                            </table>
                        </div>
                         <div class="col-sm-8" style="padding-left:2px; padding-right:2px;">
                         <!--  <div id="iti_det_div_br0" style="border:#ADD3FF 1px solid; background-color:#F9FCFD; height: 320px; overflow-y:scroll">-->
                         <div id="iti_det_div_br0" style="border:#ADD3FF 1px solid; background-color:#F9FCFD;min-height: 332px;"> 
                         <div class="col-sm-12" align="center" style="margin-top: 10px;"><label class="control-label"> Itinerary Details</label></div>
                         <div class="col-sm-12" style="margin-top: 10px;">
                                    <label class="control-label col-sm-4" >Arrival Date & Time : </label>
                                        <div class="col-sm-4">
                                        <div class="input-group">
                          <span class="input-group-addon add-on tooltips" data-toggle='tooltip' data-original-title="Arrival Date"><i class="fa fa-calendar"></i></span>
                                     <input type="text" class="form-control datepickerz  tooltips" data-original-title='Choose Date' data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" name="arrdate_br0" id="arrdate_br0"  readonly style="  width: 100%;"></div>
                                     </div>
                                     <div class="col-sm-4">
                                     <div class="input-group">
                                      <span class="input-group-addon add-on tooltips" data-toggle='tooltip' data-original-title="Arrival Time"><i class="fa fa-clock-o"></i></span>
                                 <input type="text" class="form-control timepickera" name="arrtime_br0" id="arrtime_br0" readonly style="  width: 100%;">
                                        </div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-12"  style="margin-top: 15px;">
                                    <label class="control-label col-sm-4" >Departure Date & Time</label>
                                        <div class="col-sm-4">
                                        <div class="input-group">
                                        <span class="input-group-addon add-on tooltips" data-toggle='tooltip' data-original-title="Departure Date"><i class="fa fa-calendar-o"></i></span>
                                     <input type="text" class="form-control tooltips" placeholder="Dept.Date" data-original-title='No need to choose' name="depart_ddat_br0" id="depart_ddat_br0" readonly ></div>
                                     </div>
                                     <div class="col-sm-4">
                                     <div class="input-group">
                                      <span class="input-group-addon add-on tooltips" data-toggle='tooltip' data-original-title="Departure Time"><i class="fa fa-clock-o"></i></span>
                              <input type="text" class="form-control timepickera2 "  name="depart_time_br0" id="depart_time_br0"  style="width: 100%;">
                                        </div>
                                        </div>
                                </div>
                                <div class="col-sm-12" style="margin-top:15px">
                                    <label class="control-label col-sm-4" >Select Arrival City</label>
                                        <div class="col-sm-8">
                                            <div id="loading_side"></div>
                                            <div class="load_cities">
                                            <?php
                                            
//$query_cities = "SELECT * FROM dvi_cities WHERE type = 'AD' and status = 0 ORDER BY name ASC";
$cities= $conn->prepare("select t2.* from vehicle_rent as t1 inner join dvi_cities as t2 on t2.id=t1.city group by t1.city");
$cities->execute();
$row_cities_main = $cities->fetchAll();
$totalRows_cities = $cities->rowCount();
?>

<select class="form-control chosen-select" id="br0_st_city0" name="br0_st_city0" tabindex="2" onChange="getvehicles('br0',this.value)">
	<option value="">-- Select Orgin Point --</option>
    <?php
	foreach($row_cities_main as $row_cities)
	{
		
		$states = $conn->prepare("SELECT * FROM dvi_states where code=?");
		$states->execute(array($row_cities['region']));
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
                                <input type="hidden" id="br0_vehdiv" name="br0_vehdiv" value="0" />
                                <div class="col-sm-12" style="margin-top:15px">
                                <center><small class="help-block" id="br0_seaterr" style='display:none;color:#E9573F;'></small></center>
                                    <label class="control-label col-sm-4" >Select Vehicle</label>
                                    <div class="col-sm-6">
                                   <div id="br0_load_vehicl"><input type="text" value="Please Select Above City" class="form-control" readonly></div>
                                    </div>
                                    <div class="col-sm-2">
                                        <a data-toggle="tooltip" title="Add 1 more vehicle" class="btn btn-default tooltips" id="br0_addrow" style="display:none" onClick="get_extra_vehicle('br0','1')"><i class="fa fa-plus" style="color:#3EAFDB"></i></a>
                                    </div>
                                    </div>
                                    <div id="br0_vehlist"></div>
                                    	<a style="color:#FFF">.</a>
                                    </div>
                                    <div style="border:1px solid #CFE1EF; background-color:#EFFBFF" align="center">
                                    <button type="button" class="btn btn-sm btn-info" style="margin-top: 6px;margin-bottom: 7px;" onClick="make_itinerary('br0')">Make Itinerary</button></div>
                         </div>
                         <div class="col-sm-12" id="make_itinerary_div_br0" style=" margin-top:10px;"><!-- laoding date --></div>
                         <input type="hidden" id="br0_kit_kat" value=""  />
                            <input type="hidden" id="br0_kit_cityidd" name="br0_kit_cityidd" value=""  />
                            <input type="hidden" id="br0_kit_cityidd_prev" name="br0_kit_cityidd_prev" value=""  />
                            <input type="hidden" value="0" name="br0_traveldist" id="br0_traveldist" />
                            <input type="hidden" value="0" name="br0_traveldist_ess" id="br0_traveldist_ess" />
                            <input type="hidden" value="0" name="br0_day_traveldist" id="br0_day_traveldist" />
                            <input type="hidden" value="0" name="br0_day_travdist_ess" id="br0_day_travdist_ess" />
                            <input type="hidden" value="0" name="br0_dt_dist" id="br0_dt_dist" />
                            <input type="hidden" value="0" name="br0_dt_alssdist" id="br0_dt_alssdist" />
                            <input type="hidden" value="0" name="br0_dt_altrdist" id="br0_dt_altrdist" />
                            <input type="hidden" value="" name="br0_dt_citid" id="br0_dt_citid" />
                            <input type="hidden" value="" name="br0_dt_detls" id="br0_dt_detls" />
                            <input type="hidden" value="0" name="br0_trv_cnt" id="br0_trv_cnt" />
                            <input type="hidden" value="0" name="br0_trv_days" id="br0_trv_days" />
                            <input type="hidden" value="0" name="br0_trv_nights" id="br0_trv_nights" />
                            <input type="hidden" value="0" name="br0_trv_adult" id="br0_trv_adult" />
                            <input type="hidden" value="0" name="br0_trv_child" id="br0_trv_child" />
                            <input type="hidden" value="0" name="br0_trv_room" id="br0_trv_room" />
                            <input type="hidden" value="" id="br0_vehicles" name="br0_vehicles[]" />
                            <input type="hidden" value="" id="br0_dest_id" name="br0_dest_id" />
                            <input type='hidden' name='br0_ret_dist' id='br0_ret_dist' value=0>
                            <input type='hidden' name='br0_tr_tot_amt' id='br0_tr_tot_amt' value=0>
                            <input type='hidden' name='br0_pervehamt' id='br0_pervehamt' value=0>
                            <input type='hidden' name='br0_vehcitid' id='br0_vehcitid' value=''>
                            <input type='hidden' name='br0_permt_amt' id='br0_permt_amt' value=0>
                            <input type='hidden' name='br0_citydata[]' id='br0_citydata' value=''>
                            <input type='hidden' name='br0_formatdata' id='br0_formatdata' value=''>
                            <input type="hidden" name="br0_veh_upl" id="br0_veh_upl" value=''>
                            <input type="hidden" name="br0_all_veh_upl" id="br0_all_veh_upl" value=''>
                            <input type="hidden" name="br0_cid_arr" id="br0_cid_arr" value=''>
                            <input type="hidden" name="br0_veh_cit_dis" id="br0_veh_cit_dis" value=''>
							<input type="hidden" name="br0_subform" value="1">
                            
                            <input type='hidden' id='br0_d0' value='0' />
                            <input type='hidden' id='br0_c0' value='0' />
                            <input type="hidden" id="br0_callbackid" value="" />
                            <input type="hidden" id="br0_citarrid" value="" />
                            <input type="hidden" id="br0_daydiv" name="br0_daydiv" value="0" />   
                            
                            <input type="hidden" value="" id="br0_day_of_stay" name="br0_day_of_stay"  />
                            <input type="hidden" value="" id="br0_room_of_num" name="br0_room_of_num"  />
                            <input type="hidden" id="br0_tab_cnt" value="1" />
                            <input type="hidden" id="br0_htl_id0" value="" />
                          
                        </div>
                        <div id="parent_breakup"><!-- loading data from ajax_breakup.php  -- make_next_breakstay() --></div>
                        
                        <!-- loading itinerary dates -- start -->
                        
                        <!-- loading itinerary dates -- end -->
                        <div class="col-sm-12" style="margin-top:10px;display:none;"  id="breakup_submit_div">
                        <div class="col-sm-5" style="padding: 10px;background-color: #FFF8EF;border: 1px solid #ACE8FF;">
                         	<div class="col-sm-8" align="right"><strong>Do you need break up here :</strong></div>
                        	<div class="col-sm-2">
                           <button type="button" class="btn-sm btn btn-info my_break" value="no" id="break_btn_yes_br0" name="break_btn_br0" onClick="more_breakup()">Yes</button>
                            <!--<label style="font-weight:600; color:#2D426D; ">
                            <input type="radio" value="yes" id="break_btn_yes_br0" name="break_btn_br0" class="i-grey-square my_break">Yes </label>-->
                            </div>
                            <div class="col-sm-2">
                          <button type="button" class="btn-sm btn btn-danger my_break" value="no" id="break_btn_no_br0" name="break_btn_br0" onClick="no_more_breakup()">No</button>
                            <!--<label style="font-weight:600; color:#2D426D">
                            <input type="radio" checked value="no" id="break_btn_no_br0" name="break_btn_br0" class="i-grey-square my_break">No</label>--></div>
                        </div>
                        <div class="col-sm-7" style="padding: 10px;background-color: #FFF8EF;border: 1px solid #ACE8FF;">
                                        <div class="col-sm-6" align="center">
                                            <button type="button" id="mypln_br0" onClick="my_route('br0','m',<?php echo $agent_perc; ?>,<?php echo $agnt_adm_perc; ?>);" style="text-decoration:none;" class="btn btn-info btn-sm ">My planned itinerary</button>
                                           </div>
                                           <div class="col-sm-6" align="center">
                                           <button type="button" id="divpln_br0" onClick="my_route('br0','o',<?php echo $agent_perc; ?>,<?php echo $agnt_adm_perc; ?>);" style="text-decoration:none" class="btn btn-info btn-sm">Optimized itinerary (DVi Suggested)</button>
                                            </div>
                                            <input type="hidden" id="br0_viass_idss" name="br0_viass_idss" >
                                            <input type="hidden" id="br0_viass_dd" name="br0_viass_dd" >
                        </div>
                        </div>
                        <div id='modal_galary'><!-- loading modal dynamically for travel via-- from ajax_via_model.php --></div>
                            <div>
                            </div>
                            
                    </div>
                    
                    
                    <div id="secondary_boxx" style="display:none; margin-top: 10px;">
             <div class="row">
             <div class="col-sm-12" style="margin-top:10px;border: 1px sol;border-top: 1px solid #ccc;">
             <div id="tableee" style=" background-color:#FFF">
<div align="center" id="tablee_chld">
<p style=" font-weight:600; text-align:center" id="room_info_title">Room Information</p>
<table width="80%"  id="br0_new_room_table" bgcolor="#EAF4FA" border="1px solid" style=" border:1px solid #DFE9EF; background-color:#EAF4FA; color:#365686; margin-top:20px" >
<tr id="br0_new_rm_tr0"><th style="padding:10px" width="10%">Rooms</th><th style="padding:10px" width="10%">Adult</th><th style="padding:10px" width="15%">5 - 12 age child(ren)</th><th style="padding:10px" width="18%">Below 5 age child(ren)</th><th style="padding:10px" width="15%">Extra Bed</th></tr>
<tr id="br0_new_rm_tr1"><td style="padding:10px" id="br0_room_nw_td1">Room 1</td>
<td style="padding:10px" id="br0_adlt_nw_td1"><input type="text" id="br0_sel_adlt_nw1" name="br0_sel_adlt_nw1"  readonly class="form-control tooltips" ></td>
<td style="padding:10px" id="br0_ch512_nw_td1"><input type="text" id="br0_sel_nw_512ch1" name="br0_sel_nw_512ch1"  value="0" readonly class="form-control tooltips" ></td>
<td style="padding:10px" id="br0_chb5_nw_td1"><input type="text" id="br0_sel_nw_b5ch1" name="br0_sel_nw_b5ch1" value="0" readonly class="form-control tooltips" ></td>
<td style="padding:10px" id="br0_extr_nw_td1"><select id="br0_sel_nw_extr1" name="br0_sel_nw_extr1" class="form-control chosen-select"><option value="-" selected>Nil</option><option value="0">With Bed</option><option value="1">Without Bed</option></select></td></tr>
</table>

</div>
<div class="col-sm-12" id="food_only_div" style="margin-top:20px;">
<div class="col-sm-5" align="right"> Choose Food :</div>
<div class="col-sm-3">
    <input type="hidden" value="<?php echo "both_food"; ?>" name="food_categ_dvi" id="food_categ_dvi"/>
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
             <div class="row" id="br0_htl_sub_divs">
             <div class="col-sm-12" style="margin-top:20px"> 
             <hr style="margin-top: 10px;margin-bottom: 10px;">
                 <div class="col-sm-4"><a href="javascript:void()" id="stay_plan11" onClick="backto_init_boxx()" style="text-decoration:none; " class="btn btn-default">Back</a></div>
                 <div class="col-sm-3"><a href="javascript:void()" id="stay_plan11" onClick="dvi_sugg_hotel('0')" style="text-decoration:none; " class="btn btn-info">DVI Suggested Quote </a><input type="hidden" value="1" id='dvi_sug_hotel_txt' name="dvi_sug_hotel_txt"></div>
                <div class="col-sm-3">
             	<a href="javascript:void()" id="stay_plan11" onClick="plan_my_stay('hotelandtravelonly')" style="text-decoration:none; " class="btn btn-info">Plan On Own </a><input type="hidden" value="0" id='plan_my_stay_txt' name="plan_my_stay_txt"></div>
                <div class="col-sm-2"></div>
             </div>
             </div>
             
             <!-- Dvi suggested hotel div start -->
             <div class="row" id="dvi_sugg_hotel_div" style="display:none;">
             <div class="col-sm-12"  style=" margin-top:15px;">
             <hr style=" margin-top:10px; margin-bottom:10px">
             <p style="color:#CCC; font-weight:600; text-align:center" id="htl_info_title_br0">Hotel Information ( DVI Suggested )</p>
            	<div id="load_div_sugg_quote"><!-- Dvi sugg quote from dvi_sugg_hotels.php --></div>
            
            <div class="col-sm-12" align="center" style=" margin-top:15px;">
            <a class="btn btn-info" id='resume_hotel_sub' name="resume_hotel_sub" onClick="resume_later('dvi_sugg')" style="display:none;" >Save It</a>                      <!--   &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-info" id='plan_hotel_sub' name="plan_hotel_sub" onClick="show_hotel_list('dvi_sugg')" >Proceed</a>-->
            </div>
            
             </div>
             </div>
             <!-- Dvi suggested hotel div end -->
             <!-- Plan My Stay hotel start -->
             <div class="row" id="planmy_hotel_div" style="display:none">
             <div class="col-sm-12"  style=" margin-top:15px; ">
             <hr style=" margin-top:10px; margin-bottom:10px">
             <p style="color:#9C9C9C; font-weight:600; text-align:center" id="powhinfo_br0">Hotel Information ( Plan On Own )</p>
<div id="table_collection"> <!-- parent div -->
<!-- <table style="margin-top:20px" id="stay_tabell0"  class="table table-th-block " width="100%" ><thead align="center" ><th width="100%"><center>Progress Bar</center></th></table>-->
</div>
                                <input type="hidden" value="" id="prv_ch">
                                <div class="row" align="center">
<a class="btn btn-info" id="resume_hotel_pow" name="resume_hotel_pow" onClick="resume_later('plan_on_own')" style="display:">Save It own</a>
                                 <a class="btn btn-info" id='plan_hotel_sub' name="plan_hotel_sub" onClick="show_hotel_list('plan_mystay')" >Proceed</a>
                                </div>
             </div>
             </div>
             <!-- Plan My Stay hotel end -->
             
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
								<div class="panel-body" style="background-color: #FFFFFF;color: #01559E; font-size: 15px; font-family: calibri; font-weight:600">
									<div class="tab-content">
										<div class="tab-pane fade " id="shot_rep">
                                     <!--  <div id="addi_cost_toggle" style="border:1px solid #666; padding:6px; background-color:#FDE9BC; text-align:center"> ADD-ONS </div>
                                        <div id="addi_cost_load_div" style="display:none; background-color:#FFF9E9; border:1px solid #CCC"> addi_cost_load_div </div>-->
               <br><table id="best_route_br0" class="table table-th-block" style="border:1px solid #E8D1BF">
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
				<button type="button" class="btn btn-info" data-dismiss="modal" id="trav_save" onClick="manage_status('waiting')">Save</button>               <button type="button" class="btn btn-success"  id="trav_confirm1" onClick="hide_modal_trav_body()">Confirm</button>
               
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
             
                    
                    </div>
                    
                    
                    
                    </form>
                    
					<form id="" name="thplan"  method="post" class="">
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
                    
                    
                    
                    
                    
                    
                    
					<div class="the-box" >
      
                    
                    
                    <!-- after submit open this below modal to show itinerary details -->
                    <div class="modal fade" id="plan_det_info_mod" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static"  data-keyboard="false" >
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
                    
                    <?php /*?><input type="hidden" id="check_boxs" name="check_boxs" value=<?php if (isset($_GET['val']) && $_GET['val'] == '1') { ?> "1" <?php } elseif (isset($_GET['val']) && $_GET['val'] == '2') { ?> "2" <?php } elseif (isset($_GET['val']) && $_GET['val'] == '3') { ?> "3" <?php } ?> /><?php */?>
                           <?php /*?> <legend style="text-align:center; color:#036;margin-bottom: 5px;">Enter your trip details - Break Up </legend>
                        	
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
							</div><?php */?>
                            
                            <?php /*?><div style="border:1px #D7E3EA solid">
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
                            </div><?php */?>
                            
                            <div class="form-group" id="arr_info" style="display:none; margin-top:10px">
                                <?php /*?><div class="row">
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
                                    <input type="text" class="form-control timepickera" name="arrtime" id="arrtime" readonly style="  width: 100%;">
                                        </div>
                                        </div>
                                        <div class="col-sm-2"></div>
                                        </div>
                                </div><?php */?>
                                
                                <?php /*?><div class="row" style="margin-top:10px">
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
                                
                            </div><?php */?>
                          
                           
                           <?php /*?><div id="hotel_cate_only"  class="form-group" style="display:none;" >
                             <?php 
								$selcate="select DISTINCT category from hotel_pro where status='0'";
								
								$cate= mysql_query($selcate, $divdb) or die(mysql_error());
								//$row_cate=mysql_fetch_assoc($cate);
								$tot_cate=mysql_num_rows($cate);
								?>
                           
                           </div><?php */?>
                                                  
                            <?php /*?><div class="form-group" id="arrive_city" style="display:none; margin-top:10px">
                                <div class="row">
                                <div class="col-sm-12" style="margin-left:15px">
                                	<div class="col-sm-1"></div>
                                    <label class="control-label col-sm-3" >Select Arrival City</label>
                                        <div class="col-sm-6">
                                            <div id="loading_side"></div>
                                            <div class="load_cities">
                                            <?php
                                            
//$query_cities = "SELECT * FROM dvi_cities WHERE type = 'AD' and status = 0 ORDER BY name ASC";
$query_cities= "select t2.* from vehicle_rent as t1 inner join dvi_cities as t2 on t2.id=t1.city group by t1.city";
$cities = mysql_query($query_cities, $divdb) or die(mysql_error());
$row_cities = mysql_fetch_assoc($cities);
$totalRows_cities = mysql_num_rows($cities);
?>

<select class="form-control chosen-select" id="st_city" name="st_city" tabindex="2" onChange="getvehicles('br0',this.value);delrow();">
	<option value="">-- Select Source Point --</option>
    <?php
	do
	{
		
		$query_states = "SELECT * FROM dvi_states where code='$row_cities[region]'";
		$states = mysql_query($query_states, $divdb) or die(mysql_error());
		$row_states = mysql_fetch_assoc($states);
		$totalRows_states = mysql_num_rows($states);
	?>
		<option value="<?php echo $row_cities['id'].'-'.$row_cities['ss_dist']; ?>"><?php echo $row_cities['name'].' - '.$row_states['name']; ?></option>
        <?php
	}
	while($row_cities = mysql_fetch_assoc($cities));
		?>
</select>

                                            </div>
                                        </div>
                                </div>
                                    
                                </div>
                            </div><?php */?>
                        
                            <!--<div class="form-group" id="sel_vehicl" style="display:none;">
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
                            </div>-->
							
                         <?php /*?>	<div id="vehlist">
                         	</div>
							<br />
                            
                            
                         <div id="hotel_cate"  class="form-group" style="display:none;" >
                             <?php 
								$selcate="select DISTINCT category from hotel_pro where status='0'";
								
								$cate= mysql_query($selcate, $divdb) or die(mysql_error());
								//$row_cate=mysql_fetch_assoc($cate);
								$tot_cate=mysql_num_rows($cate);
								?>
                           </div><?php */?>
                            
                            <!--<div class="form-group" id="stay_detail_id" style="display:none;" >
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
							</div>-->
                            
                            <!--<div class="form-group" id="adult_child_cnt" style="display:none">
                            	
							</div>-->
                                
							<!--<div class="form-group" id="itiner_plan" style="display:none">
                            	<div class="row" align="center">
                        	<a href="javascript:void()" onClick="trans_hotel()" style="text-decoration:none" class="btn btn-info">Plan My Itinerary</a>
                            	</div>
                            </div>-->

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
            <td width="50%" align="center"><a  class=" btn btn-sm btn-info tooltips" data-toggle="modal"  data-original-title='Choose Travel Via' onClick="trv_via_fun('00',0)" ><i class="glyphicon glyphicon-random"></i>&nbsp; Via1</a></td>
           <td width="50%" align="center"><a class="add_hots4 btn btn-sm btn-default tooltips " id="atxt0-0" data-original-title='Click To View This City Pictures'  ><i  class="fa fa-picture-o"></i></a></td>
           <!--<td width="25%" align="center"><a  id="vvatxt0-0" class="view_video btn btn-sm btn-default tooltips" data-original-title='Click To View This City Video' ><i class="fa fa-video-camera"></i></a></td>-->
           
           </tr></table></center>
          
                                              </div><!-- -->
                                          </div>
                                      </div>
                                      </div>
                                           
                                   
                                   
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
                                            
                                           
                                    	<!--<div class="row">
                                            </div>-->
                                            </div>
                     
                                <!--<div class="form-group" id="stay_plan" style="display:none">
                                	<div class="row">
                                		<div class="col-sm-12">
                                    		<div>
                                        	<a href="javascript:void()" class="btn btn-info" onClick="plan_my_stay('hotelonly')" style="text-decoration:none"><strong style="color: #004000;">&nbsp;Plan My Stay</strong></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>-->
                                
                                
                                
                     <div id="directions_panel" ></div>
                               <!--<div class="the-box rounded" id="stay"  style="display:none;">
                                <div class="row table-responsive">
                                <!--<div id="show_stay_quote" style=" display:none;">
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
                                
	                                </div>-->
                                    <div class="" id="sun" style="background-color:#EFF2F5; display:none;" >
                                
                                <center>
                                <button type="button" id="vali_quote" class="btn btn-info" name="vali_quote"  onclick="validate_stay('br0')" value="vali_quote_val" >Validate</button>
                                <?php /*?><button type="button" id="get_sts_quote" class="btn btn-info" name="view_quote"  onclick="view_stay_quote(<?php echo $agent_perc; ?>),show_get_quote(),finalcall(0)" value="view_quote_val" >Get Quote</button><?php */?>
                   				<button type="button" id="get_sts_quote" class="btn btn-info" name="view_quote"  onclick="return quote_dt('br0',<?php echo $agent_perc; ?>,<?php echo $agnt_adm_perc; ?>)" value="view_quote_val" style="display:none;">Get Quote</button>
                                 <!--<button type="button" id="subplan" class="btn btn-info btn-block" data-toggle="modal" data-target="#SuccessModalColor" style="text-decoration:none; display:none">SUBMIT FOR APPROVAL</button>--
                                <button type="button" style="display:none;" id="get_prev_quote" class="btn btn-sm btn-default" onclick="show_prev_quote()" >Back</button>-->
                                 <button type="button" id="final_save_btn" style="display:none;"  class="btn btn-info" data-toggle="modal" data-target="#SuccessModalColor" >Proceed</button>
                               <!--  <button type="button" id="trav_quot" class="btn btn-info" name="trav_quot"  onclick="return quote_dt('br0',<?php echo $agent_perc; ?>,<?php echo $agnt_adm_perc; ?>)" value="view_quote_val" style="display:none;background-color: #EFF2F5; border-color: #EFF2F5;"></button>-->
                                </center>
                                </div>
                                     <div id="vehrents"></div>
				<!--	</div><!-- /.the-box -
                    </form>-->
             </div>
             </div>
             <!--</div>-->
             </form>
             </div>
</body>	

<script>
function fun_chang_days(fr,vl)
{
	if(vl!='' && vl!='0')
	{
		$('#num_tranight_'+fr).val(parseInt(vl)-1);	
	}else{
		$('#num_tranight_'+fr).val('1');	
		$('#num_tradays_'+fr).val('2');
	}
}

function fun_chang_nights(fr,vl)
{
	if(vl!='' && vl!='0')
	{
		$('#num_tradays_'+fr).val(parseInt(vl)+1);	
	}else{
		$('#num_tranight_'+fr).val('1');	
		$('#num_tradays_'+fr).val('2');
	}
}


$(document).ready(function()
{
	$(".my_chec").on('ifChecked', function (e) {
   		 var my_ch_id=$(this).attr('id');
		 var chec=$('#'+my_ch_id).val();
		 var chec1=my_ch_id.split('_');
		 //alert(chec1[3]);
		 var ch_frm=chec1[3];
		 	if(chec=='yes_stay')
			{
				$('#no_of_rooms_tr_'+ch_frm).fadeIn();
				$('#check_boxss_'+ch_frm).val('1');
				//$('#iti_det_div_'+ch_frm).height('363px');
			}else{
				$('#no_of_rooms_tr_'+ch_frm).hide();
				$('#check_boxss_'+ch_frm).val('2');
				//$('#iti_det_div_'+ch_frm).height('320px');
			}
            if($('#'+ch_frm+'_start_date0').length>0)
            {
                make_itinerary(ch_frm);
            }
	});
	
	
	$(".my_break").on('click', function (e) {});
	
	//check number of traveller - in numeric 
	 $('.che_numb').on('keypress',function(e){
			var num_ids=$(this).attr('id');
				if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
               		return false;
    			}
		});
		
		//datepicker start
		var nowTemp = new Date();
			var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
			$('.datepickerz').datepicker({
				onRender: function(date) 
				{
					return date.valueOf() < now.valueOf() ? 'disabled' : '';
				}
			}).on('changeDate', function(ev){
				var arrv_ids=$(this).attr('id');
				var arrr_ids1=arrv_ids.split('_');
				var prnt=arrr_ids1[1];
    			$(this).datepicker('hide');
				
				if($('#num_tradays_'+prnt).val().trim()=='' || parseInt($('#num_tradays_'+prnt).val())<2)
				{
					$('#num_tradays_'+prnt).val('2');
				}
				
				var dd1=parseInt($('#num_tradays_'+prnt).val());
				$('#num_tranight_'+prnt).val(dd1-1);
				var dd=parseInt($('#num_tranight_'+prnt).val());
				
				var d = new Date($('#arrdate_'+prnt).val());
				d.setDate(d.getDate() + dd);
				var end_date=moment(d).format('YYYY-MM-DD');
				$('#depart_ddat_'+prnt).val(end_date);
				
				//to call again make_itinerary
				if($('#'+prnt+'_start_date0').length>0)
				{
					//alert('make itin again');
					make_itinerary(prnt);	
				}
				
				
			});
		//datepicker end
		
		//time picker start
		$('.timepickera').timepicker({ defaultTime: '12:00 PM' });
		$('.timepickera2').timepicker({ defaultTime: '12:00 PM' });
		//time picker end
		
});

function more_breakup()
{
		var tot_this_day,vip;
		var valdn=0;
				for(var ll=0;ll<=$('#tot_num_of_form').val();ll++)//over all travelling city validation
				{
					vip="br"+ll;
					if($('#breakup_sub_'+vip).length>0)
					{
						tot_this_day=parseInt(daydiff(parseDate($('#arrdate_'+vip).val()), parseDate($('#depart_ddat_'+vip).val())))+1;
						for(var l=0;l<tot_this_day;l++)
						{
							if($('#'+vip+'_row_city'+l).length<=0 || $('#'+vip+'_row_city'+l).val().trim()=='')
							{
								valdn=1;
							}
						}
					}
				}
				if(valdn==0)
				{
					datesft='';
					var nntnf=parseInt($('#tot_num_of_form').val());
					var tnf=nntnf+1;
					$('#tot_num_of_form').val(tnf);
					var ntnf="br"+tnf;
					
					for(m=0;m<=nntnf;m++)
					{
						if($('#breakup_sub_br'+m).length>0)
						{
							datesft=$('#arrdate_br'+m).val()+' to '+$('#depart_ddat_br'+m).val()+' - Itinerary';
							$('#toggle_title_br'+m).empty().prepend(datesft);
							
							$('#breakup_main_br'+m).show();
							$('#breakup_sub_br'+m).slideUp(1000);	
						}
					}
					make_next_breakstay(ntnf);
					$('#breakup_submit_div').hide();
				}else{
						toastr.options={ "closeButton":true,"positionClass":"toast-top-right", "showMethod": "fadeIn", "hideMethod": "fadeOut" }
      					toastr.error('Please Enter All Travelling Cities!');
				}
	
}

function no_more_breakup()
{
		var tot_this_day,vip;
		var valdn=0;
				for(var ll=0;ll<=$('#tot_num_of_form').val();ll++)//over all travelling city validation
				{
					vip="br"+ll;
					if($('#breakup_sub_'+vip).length>0)
					{
						tot_this_day=parseInt(daydiff(parseDate($('#arrdate_'+vip).val()), parseDate($('#depart_ddat_'+vip).val())))+1;
						for(var l=0;l<tot_this_day;l++)
						{
							if($('#'+vip+'_row_city'+l).length<=0 || $('#'+vip+'_row_city'+l).val().trim()=='')
							{
								valdn=1;
							}
						}
					}
				}
				if(valdn==1)
				{
						toastr.options={ "closeButton":true,"positionClass":"toast-top-right", "showMethod": "fadeIn", "hideMethod": "fadeOut" }
      					toastr.error('Please Enter All Travelling Cities First!');
				}else{
						toastr.options={ "closeButton":true,"positionClass":"toast-top-right", "showMethod": "fadeIn", "hideMethod": "fadeOut" }
      					toastr.info('Ok! You can proceed with your created Itinerary!');
				}
}

function getvehicles(fr,city_id)
{    
	if (city_id != 0)
	{
		var cit_id = city_id.split('-');
		cit_id = cit_id[0].trim();
	}
	else
	{
		var cit_id = 0;
	}
	var inc=$('#'+fr+'_vehdiv').val();
	$('.loader_ax').fadeIn();
	$.get('AGENT/ref_vehicl.php', { city_id: cit_id, incr : inc, frm : fr}, function(data) {
		$('.loader_ax').fadeOut(500);
	  $('#'+fr+'_load_vehicl').html(data);
	  $('.chosen-select').chosen({ 'width':'100%'});
	  $('#'+fr+'_addrow').show();
	  seatinfo(fr);
	  
				//to call again make_itinerary
				if($('#'+fr+'_start_date0').length>0)
				{
					//alert('getveh make itin again');
					make_itinerary(fr);	
				}
				
				if($('#'+fr+'_vehdiv').val()>0)
				{
					//alert('remove extra veh');	
					$('#'+fr+'_vehlist').empty();
					$('#'+fr+'_vehdiv').val('0');
				}
	});
}

function get_extra_vehicle(fr,nus)
{
	var alr=(parseInt($('#'+fr+'_vehdiv').val())+1);
	$('#'+fr+'_vehdiv').val(alr);
	
	var city_id = $('#'+fr+'_st_city0').val();
	
	var cit_id = city_id.split('-');
	cit_id = cit_id[0].trim();
	var inc=alr;
	
	var sel_claus = "<div class='form-group' id='"+fr+"_delete"+alr+"'><div class='col-sm-12' style='margin-top:15px;'><label class='col-sm-4 control-label'>Extra Vehicle</label><div class='col-sm-6' id='"+fr+"_divs1"+alr+"'></div><div class='col-sm-2'><a title='Remove row' class='btn btn-default' onclick=remove_elmt_div('"+fr+"','"+alr+"')><i class='fa fa-trash-o' style='color:#3EAFDB'></i></a></div></div></div>";

	var div1 = document.createElement('div');
	div1.innerHTML = sel_claus;
	document.getElementById(fr+'_vehlist').appendChild(div1);
	$('.loader_ax').fadeIn();
	$.get('AGENT/ref_vehicl.php', { city_id: cit_id, incr : inc , frm:fr}, function(data) {
	  $('.loader_ax').fadeOut(500);
	  $('#'+fr+'_divs1'+alr).html(data);
	  $('.chosen-select').chosen({ 'width':'100%'});
	  seatinfo(fr);
	  $("#iti_det_div_br0").scrollTop(300);
	});
}

function remove_elmt_div(fr,id)
{ 
	$('#'+fr+'_delete'+id).remove();
	seatinfo(fr);
	$("#iti_det_div_br0").scrollTop(50);
}

function seatinfo(fr)
{   
	if($('#num_traveller_'+fr).val().trim()==''){ $('#num_traveller_'+fr).val('2'); }
	if($('#num_chd512_'+fr).val().trim()==''){ $('#num_chd512_'+fr).val('0'); }
	var trave_cnt = (parseInt($('#num_traveller_'+fr).val())+ parseInt($('#num_chd512_'+fr).val()));
	var seat_cnt=0; var tot_seats=0;
	var tot_vehdiv=$('#'+fr+'_vehdiv').val().trim();
	var chosen_city = $("#"+fr+"_st_city0").val();
	
	if (chosen_city != '')
	{	
		for (z=0;z<=tot_vehdiv;z++)
		{
			if($("#"+fr+"_st_vehic"+z).length>0)
			{
				var getvehinfo = $("#"+fr+"_st_vehic"+z).val();
				//alert(getvehinfo);
				if (typeof(getvehinfo) != "undefined" && getvehinfo !== null)
				{
					if (getvehinfo != '')
					{
						var res = getvehinfo.split("-");
						seat_cnt = res[1];
						tot_seats = tot_seats + parseInt(seat_cnt);
					}
				}
			}
		}
		
	//alert (tot_seats+'  '+trave_cnt);
		if (tot_seats < trave_cnt)
		{
				$('#'+fr+'_seaterr').text("Travellers count exceeds vehicle capacity.").show();
		}
		else 
		{
					if ($('#'+fr+'_seaterr').show())
					{
						$('#'+fr+'_seaterr').hide();
					}
		}
	}
}


function make_itinerary(fr)
{
	seatinfo(fr);
	if($('#num_traveller_'+fr).val().trim()=='')
	{
		$('#num_traveller_'+fr).focus();
		//alert('Please Enter Adult Details');
		toastr.options={ "closeButton":true,"positionClass":"toast-top-right", "showMethod": "fadeIn", "hideMethod": "fadeOut" }
      	toastr.error('Please Enter Adult Details .. !');
	}
	if($('#num_chd512_'+fr).val().trim()=='')
	{
		$('#num_chd512_'+fr).val('0')	
	}
	if($('#num_chd_b5_'+fr).val().trim()=='')
	{
		$('#num_chd_b5_'+fr).val('0')
	}
	
	var ncdays=parseInt(daydiff(parseDate($('#arrdate_'+fr).val()), parseDate($('#depart_ddat_'+fr).val())))+1;
	if($('#num_tradays_'+fr).val().trim()=='')
	{
		$('#num_tradays_'+fr).focus();
		toastr.options={ "closeButton":true,"positionClass":"toast-top-right", "showMethod": "fadeIn", "hideMethod": "fadeOut" }
      	toastr.error('Please Enter Travelling - Day Count ( Numerical Value Only ) ');
	}else if($('#num_tranight_'+fr).val().trim()=='')
	{
		$('#num_tranight_'+fr).focus();
		toastr.options={ "closeButton":true,"positionClass":"toast-top-right", "showMethod": "fadeIn", "hideMethod": "fadeOut" }
      	toastr.error('Please Enter Travelling - Night Count ( Numerical Value Only ) ');
	}/*else if($('#num_tranight_'+fr).val().trim()>$('#num_tradays_'+fr).val().trim()){
        alert($('#num_tranight_'+fr).val().trim()+'-'+$('#num_tradays_'+fr).val().trim())
		alert("Check");
		var day_c=(parseInt($('#num_tradays_'+fr).val().trim())-1);
		$('#num_tranight_'+fr).val(day_c);
		toastr.options={ "closeButton":true,"positionClass":"toast-top-right", "showMethod": "fadeIn", "hideMethod": "fadeOut" }
      	toastr.warning('Please make sure all details correct...! ');
	}*/else if($('#arrdate_'+fr).val().trim()=='')
	{
		$('#arrdate_'+fr).focus();
		toastr.options={ "closeButton":true,"positionClass":"toast-top-right", "showMethod": "fadeIn", "hideMethod": "fadeOut" }
      	toastr.error('Please pick arrival date !');
	}else if($('#depart_ddat_'+fr).val().trim()=='')
	{
		$('#arrdate_'+fr).focus();
		toastr.options={ "closeButton":true,"positionClass":"toast-top-right", "showMethod": "fadeIn", "hideMethod": "fadeOut" }
      	toastr.error('Please pick departure date !');
	}else if($('#'+fr+'_st_city0').val()=='')
	{
		$('#'+fr+'_st_city0').focus();
		toastr.options={ "closeButton":true,"positionClass":"toast-top-right", "showMethod": "fadeIn", "hideMethod": "fadeOut" }
      	toastr.warning('Please select your origin place (Arrival City)!');
	}else if($('#'+fr+'_seaterr').is(':visible'))
	{
		toastr.options={ "closeButton":true,"positionClass":"toast-top-right", "showMethod": "fadeIn", "hideMethod": "fadeOut" }
      	toastr.error('Travellers count exceeds vehicle capacity, Add more vehicle!');
	}else if(ncdays!=$('#num_tradays_'+fr).val()){
		//$('#num_tradays_'+fr).val(ncdays+1);
		//$('#num_tranight_'+fr).val(ncdays);
        $('#arrdate_'+fr).focus();
		toastr.options={ "closeButton":true,"positionClass":"toast-top-right", "showMethod": "fadeIn", "hideMethod": "fadeOut" }
      	toastr.warning('Please Pick Your Tour Date again!');
	}else{ 
			//insert 
			$('#adult_no_cal_'+fr).val($('#num_traveller_'+fr).val());
			$('#child512_no_cal_'+fr).val($('#num_chd512_'+fr).val());
			$('#child_no_cal_'+fr).val($('#num_chd_b5_'+fr).val());
			//insert
			var hbook=$('input[name=stay_rm_ht_'+fr+']:checked').val();
			if(hbook=='yes_stay')//hotel + transport
			{
				$('.loader_ax').fadeIn();  
				var sdate=$('#arrdate_'+fr).val();
				var edate=$('#depart_ddat_'+fr).val();
				$.get('AGENT/ajax_agent.php?type=30&checkdate1='+sdate+'&checkdate2='+edate,function(res)
				{
					$('.loader_ax').fadeOut();
					if(res.trim()=='yes')
					{
						$('#stop_modal').modal('show');
					}else{
						make_itinerary_divs(fr); //for only transport+hotel
					}
				});
			}else{//for only transport
				make_itinerary_divs(fr);
			}
	}
}


function make_itinerary_divs(fr)
{
	//alert('ready to make '+fr);
	$('#make_itinerary_div_'+fr).empty();
	$('#make_itinerary_div_'+fr).css('border','1px solid #B4EAFB');
	var tot_days=daydiff(parseDate($('#arrdate_'+fr).val()), parseDate($('#depart_ddat_'+fr).val()));
	var check_date='',new_fromto,lab_ne;
	lab_ne="<div style='text-align:center; margin-top:5px; margin-bottom:10px; color:#355E82'><strong>Your Itinerary</strong></div>";
	$(lab_ne).appendTo('#make_itinerary_div_'+fr);
	
	for (var dy=0;dy<=tot_days;dy++)
	{
				new_fromto = "<div class='form-group' id='"+fr+"_div"+dy+"'><div class='row'><div class='col-sm-12'><label class='control-label col-sm-2' style='text-align:center'>Day - <label id='"+fr+"_daycnt"+dy+"'></label></label><div class='col-sm-2'><input type='text' class='form-control tooltips' data-toggle='tooltip' data-original-title='Travel Date' data-date-format='yyyy-mm-dd' placeholder='yyyy-mm-dd' name='"+fr+"_start_date"+dy+"' id='"+fr+"_start_date"+dy+"' readonly='readonly'></div><div><div class='col-sm-3'><input class='form-control bold-border tooltips' type='text' name='"+fr+"_start_city"+dy+"' id='"+fr+"_start_city"+dy+"' readonly='readonly'></div><div class='col-sm-3' id='"+fr+"_load_cityrow"+dy+"'><input class='form-control bold-border tooltips' type='text' value='Choose Visiting City' readonly='readonly'></div></div><div class='col-sm-2'><center><table width='100%'><tr><td width='50%' align='center'><a id='via_cli_"+dy+"_"+fr+"' class=' btn btn-sm btn-info tooltips' data-original-title='Choose Travel Via'  ><i class='glyphicon glyphicon-random'></i>&nbsp; Via</a></td><td width='50%' align='center'><a  class='add_hots4 btn btn-sm btn-default tooltips' id='"+fr+"_atxt"+dy+"' data-original-title='Click To View This City Pictures'><i class='fa fa-picture-o'></i></a></td></tr></table></center></div></div></div><input type='hidden' id='"+fr+"_d"+dy+"' value='"+dy+"' /><input type='hidden' id='"+fr+"_c"+dy+"' value='0' /></div>";
				
				date4 = $('#arrdate_'+fr).data('datepicker').date;
				date5 = moment(date4);
				date5 = moment(date5).add('days', dy);
				
				var dymimus = dy - 1;
				$(new_fromto).appendTo('#make_itinerary_div_'+fr);
				$('.tooltips').tooltip();
				document.getElementById(fr+'_start_date'+dy).value = moment(date5).format('DD-MMM-YYYY');
				if(check_date=='')
				{
					check_date=moment(date5).format('YYYY-MM-DD');
				}else{
					check_date=check_date+'/'+moment(date5).format('YYYY-MM-DD');
				}
				$("#"+fr+"_daycnt"+dy).text(parseInt(dy) + 1);
				
				$('#via_cli_'+dy+'_'+fr).attr('onclick','trv_via_fun("'+dy+'","'+fr+'")');
				date4 = '';
				date5 = '';
	}//for end
	get_cities_first(fr,'0');
	var orig=$('#'+fr+'_st_city0 option:selected').text().split('-');
	$('#'+fr+'_start_city0').val(orig[0]);
	
	$('#breakup_submit_div').fadeIn();
	
}

function make_next_breakstay(fr)
{
	var brv_frm=parseInt($('#tot_num_of_form').val())-1;
    //alert("brv_frm= "+brv_frm);
	var datastring = $("#ExampleBootstrapValidationForm").serialize();
		$('.loader_ax').fadeIn();
        $.ajax({
            type: "POST",
            url: "AGENT/ajax_breakup.php?type=1",
            data: datastring,
            success: function(res)
			{
				$('.loader_ax').fadeOut();
				//alert(res);
				$(res).appendTo('#parent_breakup');
				//datepicker start
                var last_dp_date='';
                for(var last=brv_frm;last>=0;last--)
                {
                    if($('#depart_ddat_br'+last).length>0)
                    {
                       // alert("last = "+last)
                        last_dp_date=last;
                        break;
                    }

                }
            var prv_now = $('#depart_ddat_br'+last_dp_date).val();
		    var nowTemp = new Date(prv_now);
			var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
           
			$('.datepickerz').datepicker({
				onRender: function(date) 
				{
					return date.valueOf() < now.valueOf() ? 'disabled' : '';
				}
			}).on('changeDate', function(ev){
				var arrv_ids=$(this).attr('id');
				var arrr_ids1=arrv_ids.split('_');
				var prnt=arrr_ids1[1];
    			$(this).datepicker('hide');
				
				if($('#num_tradays_'+prnt).val().trim()=='' || parseInt($('#num_tradays_'+prnt).val())<2)
				{
					$('#num_tradays_'+prnt).val('2');
				}
				
				var dd1=parseInt($('#num_tradays_'+prnt).val());
				$('#num_tranight_'+prnt).val(dd1-1);
				var dd=parseInt($('#num_tranight_'+prnt).val());
				
				var d = new Date($('#arrdate_'+prnt).val());
				d.setDate(d.getDate() + dd);
				var end_date=moment(d).format('YYYY-MM-DD');
				$('#depart_ddat_'+prnt).val(end_date);
				
				//to call again make_itinerary
				if($('#'+prnt+'_start_date0').length>0)
				{
					//alert('inn make itin again');
					make_itinerary(prnt);	
				}
			});
		//datepicker end
				$('.chosen-select').chosen({width:'100%'});
				$('.timepickera').timepicker({ defaultTime: '12:00 PM' });
				$('.timepickera2').timepicker({ defaultTime: '12:00 PM' });
			}
			});

}

function remove_this_breakstay(fr,num)
{
	var prv1;
	var frmno=parseInt($('#tot_num_of_form').val())-1;
	
	//alert("Total ="+frmno);
	//alert("removing =" + fr);
	$("#breakup_sub_"+fr).remove();	
	$('#breakup_main_'+fr).remove();
	$('#befr_sub_input').val(parseInt($('#befr_sub_input').val())+1);
	
	for(var pv=frmno;pv=>0;pv--)
	{
		if($("#breakup_sub_br"+pv).length>0)
		{
			//alert('Live Last Dvi'+pv)	;
			$("#breakup_sub_br"+pv).slideDown(1000);
			$('#breakup_main_br'+pv).hide();
			break;
		}
	}
	$('#breakup_submit_div').show();
}

function breakup_toggle_click(fr)
{
	$('#breakup_sub_'+fr).slideToggle(1000);
}


function get_cities_first(fr,dy) 
{
	var arr_city_id=$('#'+fr+'_st_city0').val();
	var vehids=getvehids(fr);
	$('.loader_ax').fadeIn();
	//alert(fr+'/'+dy);
	$.get('AGENT/row_cities.php?chek='+$('#check_boxss_br0').val(), { incr1 : dy,frm : fr, city_id: arr_city_id, arr_vehids: vehids }, function(data) {
		//alert(data);
		$('.loader_ax').fadeOut(500);
		$('#'+fr+'_load_cityrow'+dy).html(data);
		$('.chosen-select1').chosen({ 'width':'100%'});
	});
}

function get_cities_middle(fr,dy) 
{
	//alert(dy);
	var arr_city_id=$('#'+fr+'_row_city'+dy).val();
	var ci_name=$('#'+fr+'_row_city'+dy+' option:selected').text().split('-');
	dy=(parseInt(dy)+1);
	
	var vehids=getvehids(fr);
	$('.loader_ax').fadeIn();
	$.get('AGENT/row_cities.php?chek='+$('#check_boxss_br0').val(), { incr1 : dy,frm : fr, city_id: arr_city_id, arr_vehids: vehids }, function(data) {
		$('.loader_ax').fadeOut(500);
		$('#'+fr+'_load_cityrow'+dy).html(data);
		$('.chosen-select1').chosen({ 'width':'100%'});
	});
	$('#'+fr+'_start_city'+dy).val(ci_name[0]);
}

function get_cities_new_last(fr,dy) 
{
	var arr_city_id=$('#'+fr+'_row_city'+dy).val();
	var ci_name=$('#'+fr+'_row_city'+dy+' option:selected').text().split('-');
	dy=(parseInt(dy)+1);
	var vehids=getvehids(fr);
	$('.loader_ax').fadeIn();
	$.get('AGENT/ref_cities1.php', { incr1 : dy, frm : fr, city_id: arr_city_id, arr_vehids: vehids }, function(data,sts,xh) 	    {
		$('.loader_ax').fadeOut(500);
		$('#'+fr+'_load_cityrow'+dy).html(data);
		$('.tooltips').tooltip();
	$('.chosen-select1').chosen({ 'width':'100%'});
	});
	$('#'+fr+'_start_city'+dy).val(ci_name[0]);
	//alert(fr+'  '+dy);
}

function getvehids(fr)
{
	var veh_cnt=$('#'+fr+'_vehdiv').val();
	var vehidarr='';
	for (var h=0;h<=veh_cnt;h++)
	{
		if($("#"+fr+"_st_vehic"+h).length>0)
		{
			var getvehinfo = $("#"+fr+"_st_vehic"+h).val();
			var res = getvehinfo.split("-");
			if(vehidarr=='')
			{
				vehidarr=res[0];
			}else{
				vehidarr+=','+res[0];
			}
		}
	}
	//alert(vehidarr);
	return vehidarr;
}


function nextrow_val(fr,rid)
{
	var ncdays=parseInt(daydiff(parseDate($('#arrdate_'+fr).val()), parseDate($('#depart_ddat_'+fr).val())));
	var nowsss=parseInt($('#'+fr+'_d'+rid).val());
	if((ncdays-1)!=rid)//not last row city
	{
		get_cities_middle(fr,nowsss);
	}else{
		get_cities_new_last(fr,nowsss);
	}
	
	/*if($('#mod_via_'+mrowid+'0_'+mrowid).length>0)
	{
		$('#mod_via_'+mrowid+'0_'+mrowid).remove();
	}*/

	var cid1= $('#'+fr+'_row_city'+nowsss).val().split('-');
	//alert('#atxt'+rowid);
	$('#'+fr+'_atxt'+nowsss).attr('href','AGENT/view_img_desc.php?cid='+cid1[0]);
	//$('#vvatxt'+rowid).attr('href','AGENT/view_video_spot.php?cid='+cid1[0]);
}

function trv_via_fun(nos,fr)
{
	/*if($('#mod_via_'+nos+'_'+vias).length!=0)
	{
		$('#mod_via_'+nos+'_'+vias).remove();
	}*/
	//alert(nos+' -- '+fr);
	
	if($('#mod_via_'+nos+'_'+fr).length==0)
	{
		var from_city_selt_txt=$('#'+fr+'_start_city'+nos).val();
		var to_city_selt_txt=$('#'+fr+'_row_city'+nos+' option:selected').text().split('-');
		var to_city_selt=$('#'+fr+'_row_city'+nos).val();
		var via_list;
		//alert(to_city_selt);
		if(to_city_selt.trim() != '')
		{
			//for changing dvi sugg funtion in to my planned itinerary
				if($('#'+fr+'_d'+nos).val()==0)
				{
					frm_cy0=$('#'+fr+'_st_city0').val().split('-');
					frm_cy=frm_cy0[0].trim();
					
					to_cy0=to_city_selt.split('-');
					to_cy=to_cy0[0].trim();
					//alert(frm_cy+' - '+to_cy);
				}else{
					vias1=parseInt($('#'+fr+'_d'+nos).val())-1;
					//alert('Vias1 ='+vias1+' nos='+nos);
					frm_cy0=$('#'+fr+'_row_city'+vias1).val().split('-');
					frm_cy=frm_cy0[0].trim();
					
					to_cy0=to_city_selt.split('-');
					to_cy=to_cy0[0].trim();
					//alert("others "+frm_cy+' - '+to_cy);
				}
				$('.loader_ax').fadeIn();
				$.ajax({
						type: 'POST',
						url: "AGENT/ajax_via_modal1.php",
						data: "nos="+nos+"&vias="+fr+"&from_city_selt_txt="+from_city_selt_txt+"&frm_cy="+frm_cy+"&to_cy="+to_cy+"&to_city_selt_txt="+to_city_selt_txt,
							success: function(da)
							{
								//alert(da);
								$('.loader_ax').fadeOut();
								$('#modal_galary').append(da);
								$('#mod_via_'+nos+'_'+fr).modal('show');
								$('.tooltips').tooltip();
								//$('.via_tab').destroy();
								$('.chosen-select').chosen({width:'100%'});
								$('#via_tab_'+nos+'_'+fr).dataTable();
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
		$('#mod_via_'+nos+'_'+fr).modal('show');	
	}
}

function my_route(fr,route_typ, agent_percnt, adm_percent)
{
	var frm_tttol=$('#tot_num_of_form').val().trim();
	var fr;
	//alert('Tott form='+frm_tttol);
	
	for(var g=0;g<=frm_tttol;g++)
	{
		fr="br"+g;
		if($('#num_traveller_'+fr).length>0) // to check if the total div is live or not
		{
			//alert("Now ="+fr); 
	var cit_names = [];
	var tot_dist = 0;
	var strt_city = $('#'+fr+'_st_city0 option:selected').text().split('-');
	var strt_cityid = $('#'+fr+'_st_city0').val().split('-');
	
	var st_cit = strt_city[0].trim();	
	var distance;
  	cit_names.push(st_cit);
	var start = st_cit;
	var trav_cit = []; var idarr = [];
	var road_locat; var locat_format;
	
	trav_cit.push(strt_cityid[0].trim());
	idarr.push(strt_cityid[0].trim());
	//alert(idarr);
	var dyb = $('#num_tranight_'+fr).val();
	//dyb--;
	
	var via_flg=0;
	var vss,vdd='';
	var arr_vss='-';
	for(var w1=0;w1<=dyb;w1++)
	{
		//viass_idss//via id arrangements
		if($('#sel_via_trav_cids_'+w1+'_'+w1).length>0 && $('#sel_via_trav_cids_'+w1+'_'+w1).val()!='')
		{
			via_flg=1;
			//alert($('#sel_via_trav_cids_'+w1+'_'+w1).val()+' - '+w1);
			vss=$('#sel_via_trav_cids_'+w1+'_'+w1).val().split('-');
			vss.shift();
			vss.pop();
			
			if(arr_vss=='-')
			{
				arr_vss=vss;
			}else{
				arr_vss=arr_vss.concat(vss);
			}
		}
		
		if($('#sel_via_trav_totdis_'+w1+'_'+fr).length>0 && $('#sel_via_trav_totdis_'+w1+'_'+fr).val()!='')
		{
				if(vdd=='')
				{
					vdd=$('#sel_via_trav_totdis_'+w1+'_'+fr).val();
				}else{
					vdd=vdd+'-'+$('#sel_via_trav_totdis_'+w1+'_'+fr).val();
				}
		}else{
				if(vdd=='')
				{
					vdd='NN';
				}else{
					vdd=vdd+'-'+'NN';
				}
		}
		
		var gethid = $('#'+fr+'_c'+w1).val();
	}
	
		for(var x1=0;x1<dyb;x1++)
		{
			var getrline = $('#'+fr+'_row_city'+x1+' option:selected').text();
			road_locat = getrline.split("-");
			var mid_cityid = $('#'+fr+'_row_city'+x1).val().split('-');
//alert(mid_cityid);
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
	//alert(JSON.stringify(trav_cit)); 
	var gethid1 = $('#'+fr+'_c'+dyb).val();
	$('#'+fr+'_viass_idss').val(arr_vss);
	$('#'+fr+'viass_dd').val(vdd);

	getrline1 = $('#'+fr+'_row_city'+dyb+' option:selected').text();
	road_locat1 = getrline1.split("-");
	var end = road_locat1[0].trim();
	//alert(dyb);
	var end_cityid = $('#'+fr+'_row_city'+dyb).val().split('-');
	//alert('end_cityid '+end_cityid);
	cit_names.push(end);
	var last_veh_cid = '';
	if (end_cityid[2].trim() == '1')
	{
		last_veh_cid = 'y';
	}
	trav_cit.push(end_cityid[0].trim());
	idarr.push(end_cityid[0].trim());
	//alert("idarr= "+idarr);
	
	$("#"+fr+"_dest_id").val(end_cityid[0].trim());
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
	
	$('#'+fr+'_kit_cityidd_prev').val(idarr);
	var format_dat = ''; var stor_city = ''; var phparr = [];
	$('.loader_ax').fadeIn();
	//alert('route_typ= '+route_typ+' idarr='+idarr+' trav_cit='+trav_cit+' last_veh_cid='+last_veh_cid+'viass_dd ='+vdd);
	
	$.ajax({
  url: "AGENT/dist_cities.php",
  dataType: 'json',
  async: false,
  data:{ route_type: route_typ, allcids: idarr, vehcitids: trav_cit, last_chk: last_veh_cid, viass: arr_vss, viass_dd: vdd},
  success: function(data) {
			$('#'+fr+'_kit_cityidd').val(data.cit_opt_idd);//for hotel city id 
			$('#'+fr+'_kit_kat').val(data.cit_optnnmm);
			$('#'+fr+'_cid_arr').val(data.cit_ord);
			$('#'+fr+'_traveldist').val(data.trav_totdist);
			$('#'+fr+'_traveldist_ess').val(data.trav_totdist_ess);
			$('#'+fr+'_day_traveldist').val(data.trav_dist);
			$('#'+fr+'_day_travdist_ess').val(data.trav_dist_ess);
			
			var cid_list = $('#'+fr+'_cid_arr').val().split(',');
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
			//alert("CD ="+phparr);
			$('#'+fr+'_citydata').val(phparr);
			$('#'+fr+'_formatdata').val(format_dat);
			var trval_cids = $('#'+fr+'_cid_arr').val();
			var exp_trval_cids = trval_cids.split(',');
			var summaryPanel = document.getElementById('directions_panel');
			summaryPanel.innerHTML = '';
			var tr_data = $('#'+fr+'_formatdata').val();
			
			var tr_data1 = tr_data.replace(/,\s*$/, "");
			var tr_data2 = tr_data1.split('~');
			
			$('#'+fr+'_veh_cit_dis').val(data.extdist);
			//alert('daytrip='+fr);
			daytrip(fr,agent_percnt,adm_percent);
		 }
		});//json end
		
		}//dead or not loop
	}//main for loop
	
	/*alert('daytrip='+fr);
	daytrip(fr,agent_percnt,adm_percent);*/
}

function daytrip(fr,agent_percnt,adm_percent)
{
	var dt_cid = $('#'+fr+'_cid_arr').val();
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
	//alert('day_tripss '+new_dtarr);
	uni_dtar = new_dtarr.filter(function(item, i, ar){ return ar.indexOf(item) === i; });
	
	var dtPanel = document.getElementById('dt_panel');
	
	if(uni_dtar.length > 0)
	{
		$('#rep_tabss').hide();
		var arv_dd=$('#arrdate_'+fr).val();
		var dep_dd=$('#depart_ddat_'+fr).val();
		$.get('<?php echo "AGENT/day_trip.php"; ?>', { dt_ids: uni_dtar, frm:fr, arv_dd:arv_dd, dep_dd:dep_dd }, function(data) 
		{
			//alert(data);
				$('#day_trip_results').val(parseInt($('#day_trip_results').val())+1);
				
				$('#day_trip_counts').val(parseInt($('#day_trip_counts').val())+1);
				//$("#dt_panel").html(data);
				
				//$('#travel_info_mod_close').attr('onclick','trigger_getquot()');
				//dtPanel.innerHTML = data;
				$('#dt_panel').append(data);
				
				if($('#check_boxss_br0').val()=='1')
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
	
	if($('#check_boxss_br0').val()!='2')
	{
		$('#stay_plan11').show();
	}
	/*else
	{
		$("#gmap_div1").hide();
	}*/

	if($('#check_boxss_br0').val() == '2')
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
			$('#'+fr+'_dt_citid').val(uni_dtar);
			$('#final_save_btn').hide();
			bestroute(fr);
		}
		else
		{
			//$('#dt_panel').hide();
			$('#show_distot').show();
			$('#show_days').show();
			$('#netamount').show();
			$('#trav_quot').hide();
			$('#'+fr+'_dt_citid').val('');
			$('#'+fr+'_dt_dist').val(0);
			$('#final_save_btn').show();
			
			$('#dt_panel select option').prop('selected',false).trigger('chosen:updated');
			$('.loader_ax').fadeOut(500);
			bestroute(fr);
			finalcall(fr,1,agent_percnt,adm_percent);
		}
	}
	
	if($('#check_boxss_br0').val() == '1')
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
			$('#'+fr+'_dt_citid').val(uni_dtar);
			$('#final_save_btn').hide();
			bestroute(fr);
		}
		else
		{
			//alert('day_trip_results= '+$('#day_trip_counts').val());
			
			if($('#day_trip_counts').val()>0)
			{
				$('#dt_panel').show();
			}else{
				$('#dt_panel').hide();	
			}
			
			$('#show_distot').show();
			$('#show_days').show();
			$('#netamount').hide();
			$('#trav_quot').hide();
			$('#'+fr+'_dt_citid').val('');
			$('#'+fr+'_dt_dist').val(0);
			$('#final_save_btn').hide();
			
			$('#dt_panel select option').prop('selected',false).trigger('chosen:updated');
			bestroute(fr);
			finalcall(fr,1,agent_percnt,adm_percent);
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

function trigger_getquot(wn,fr)
{
	
		var lcnt_dtp;
		var r_dtp;
		if(wn.trim()=='go')
		{
			//alert('go');
			//$('#trav_quot').trigger("click");
			//quote_dt(fr,<?php echo $agent_perc; ?>,<?php echo $agnt_adm_perc; ?>);
			
			if($('#day_trip_allows_'+fr).val().trim()=='allow')
			{
				/*$('#travel_info_mod_footer').show();
				$('#dt_panel').hide();
				$('#rep_tabss').fadeIn();*/
			}
		}else if(wn.trim()=='no')
		{
			if($('#day_trip_allows_cnt_'+fr).length>0)
			{
				lcnt_dtp=$('#day_trip_allows_cnt_'+fr).val().trim();
				if(lcnt_dtp>0)
				{
				   for(r_dtp=0;r_dtp<lcnt_dtp;r_dtp++)
				   {
					   $("#"+fr+"_sel_dtid"+r_dtp).val('').trigger("chosen:updated");
				   }
				}
			}
			//$('#trav_quot').trigger("click");
			//quote_dt(fr,<?php echo $agent_perc; ?>,<?php echo $agnt_adm_perc; ?>);
			/*$('#travel_info_mod_footer').show();
			$('#dt_panel').hide();
			$('#rep_tabss').fadeIn();*/
		}
		quote_dt(fr,<?php echo $agent_perc; ?>,<?php echo $agnt_adm_perc; ?>);	
		//for buttor showing modal
		/*if($('#day_trip_results').val()<=1)
		{
			var fomm=$('#tot_num_of_form').val();
			for(var f=0;f<=fomm;f++)
			{
				frc="br"+f;
				if($('#breakup_sub_br'+f).length>0)	
				{
					quote_dt(frc,<?php echo $agent_perc; ?>,<?php echo $agnt_adm_perc; ?>);	
					$('#travel_info_mod_footer').show();
					$('#dt_panel').hide();
					$('#rep_tabss').fadeIn();
				}
			}
		}else{
				$('#day_trip_results').val(parseInt($('#day_trip_results').val())-1);
				$('#daytrip_book_'+fr).hide();
		}*/
}


function quote_dt(fr,agent_percnt,adm_percent)
{
	//alert("QUOTE DT="+fr);
	var c_str = $('#'+fr+'_cid_arr').val();
	var c_arr = c_str.split(',');
	c_arr.pop();
	c_arr.shift();
	var dt_detl; var spl_dtl; var dt_ssdist = 0; var dt_alltrdist = 0; var dt_allssdist = 0; var dt_alldist = 0; var dt_trdist = 0; var stor_dt = ''; var valid_dt; var chk_cnt_dt = 0;
	dtcnt = $('#'+fr+'_dt_citid').val().split(',');
	//Validate the number of daytrip cities entered for each city
	for(var dt2=0;dt2<dtcnt.length;dt2++)
	{
		valid_dt = $("#"+fr+"_sel_dtid"+dt2).val();
		if (valid_dt != null && valid_dt != '')
		{
			chk_cnt_dt = c_arr.reduce(function(n, val) 
			{
				return n + (val === dtcnt[dt2]);
			}, 0);
			chk_cnt_dt1 = parseInt(chk_cnt_dt)-1;
			
			$('#day_trip_allows_'+fr).val('allow');
			if(valid_dt.length > chk_cnt_dt1)
			{
				spl_valid_dt = valid_dt[0].split('-');
				$('#day_trip_allows_'+fr).val('notallow');
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
		dt_detl = $("#"+fr+"_sel_dtid"+dt3).val();
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
	$('#'+fr+'_dt_dist').val(dt_alldist);
	$('#'+fr+'_dt_detls').val(stor_dt);
	$('#'+fr+'_dt_altrdist').val(dt_alltrdist);
	$('#'+fr+'_dt_alssdist').val(dt_allssdist);
		//	alert(stor_dt);
		//	alert(dt_alldist);
		//alert('final'+stor_dt+'_'+dt_alldist+'_'+dt_alltrdist+'_'+dt_allssdist);
		
		if($('#day_trip_results').val()<=1)
		{
			var fomm=$('#tot_num_of_form').val();
			for(var f=0;f<=fomm;f++)
			{
				frc="br"+f;
				if($('#breakup_sub_br'+f).length>0)	
				{
					finalcall(frc,1,agent_percnt,adm_percent);
					$('#travel_info_mod_footer').show();
					$('#dt_panel').hide();
					$('#rep_tabss').fadeIn();
					$('#final_save_btn').show();
				}
			}
		}else{
				$('#day_trip_results').val(parseInt($('#day_trip_results').val())-1);
				$('#daytrip_book_'+fr).hide();
		}
}

function bestroute(fr)
{
	if($("#best_route_"+fr).length>0)
	{
		$("#best_route_"+fr+" tbody tr").remove(); 
	}else{
		
		var fr1=fr.split('br');
		var fr2=fr1[1];
		var nxt_br='<br><table id="best_route_'+fr+'" class="table table-th-block" style="border:1px solid #E8D1BF"><thead><tr style="background-color:#EAE1D8; color:#73471C;"><th width="15%">Date</th><th width="20%" colspan="2"> From</th><th width="20%">To</th><th width="18%">Kilometres</th><th width="15%">Time</th></tr></thead><tbody ></tbody></table>';
		
		$(nxt_br).appendTo('#shot_rep');
		
	}
	var tabl_data = '';
	var vvdd='',vvmm='',vvhh='',vvdd1='',vvdd2,vvhm;
	var alldata = $('#'+fr+'_formatdata').val();
	
	var alldata1 = alldata.replace(/,\s*$/, "");
	var alldata2 = alldata1.split('~');
	
	for (var incr=0;incr<alldata2.length-1;incr++)
	{
		var date_read1 = $('#'+fr+'_start_date'+incr).val();
		var alldata3 = alldata2[incr].split('-');
		if($('#sel_via_trav_cnames_'+incr+'_'+fr).length>0 && ($('#sel_via_trav_cnames_'+incr+'_'+fr).val().trim()!=''))
		{
			vvdd=$('#sel_via_trav_totdis_'+incr+'_'+fr).val();
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
			
			tabl_data="<tr><td width='25%'>"+date_read1+"</td><td>"+alldata3[0]+"</td><td><i class='fa fa-random tooltips' data-original-title='"+$('#sel_via_trav_cnames_'+incr+'_'+fr).val()+"'></i></td><td>"+alldata3[1]+"</td><td>"+vvdd+"</td><td>"+vvhm+"<input type='hidden' id='trav_times"+incr+"' name='trav_times"+incr+"' value='"+vvhm+"'></td></tr>";
		}else{
			tabl_data="<tr><td width='25%'>"+date_read1+"</td><td>"+alldata3[0]+"</td><td><i class='fa fa-random tooltips' data-original-title='Travel Via Not Chosen'></i></td><td>"+alldata3[1]+"</td><td>"+alldata3[4]+"</td><td>"+alldata3[3]+"<input type='hidden' id='trav_times"+incr+"' name='trav_times"+incr+"' value='"+alldata3[3]+"'></td></tr>";
		}
		
		$(tabl_data).appendTo('#best_route_'+fr);
		$('.tooltips').tooltip();
	}
}

function finalcall(fr,getf,agent_percnt,adm_percent)
{
	//alert('final call');
	var getdt_dis = $('#'+fr+'_dt_dist').val();
	var show_dist_ess = $('#'+fr+'_traveldist_ess').val();
	var show_dt_ess = $('#'+fr+'_dt_altrdist').val();
	if(getdt_dis > 0)
	{
		var all_dist = parseInt($('#'+fr+'_traveldist').val()) + parseInt(getdt_dis);
		var show_trdist = parseInt(show_dist_ess) + parseInt(show_dt_ess);
	}
	else
	{
		var all_dist = $('#'+fr+'_traveldist').val();
		var show_trdist = parseInt(show_dist_ess);
	}

//my edit on 23-sep-2015

	if (getf == 1)
	{
		vehrent(fr,all_dist,1,agent_percnt,adm_percent,show_trdist);
	}
	else
	{
		vehrent(fr,all_dist,0,agent_percnt,adm_percent,show_trdist);
	}
	
	$('#show_distot').show();
	$('#show_days').show();
	
	if($('#check_boxss_br0').val() == '1')
	{
		$('#netamount').hide();
	}
	else
	{
		$('#netamount').show();
	}
}

var vehcnt = 0;
function vehrent(fr,travdist,flag,agent_percnt,adm_percent,disp_trdist)
{
	if (flag == 0)
	{
		var ct_extdis = ''; var getfirst = ''; var getfirst1 = ''; var appndcity = ''; var callbackid1 = '';
		callbackid1 = $("#"+fr+"_callbackid").val();
		getfirst = callbackid1.split(',');
		getfirst1 = getfirst[1].split('-');
		appndcity = $("#"+fr+"_citarrid").val()+'-'+getfirst1[1];
		ct_extdis =callbackid1+','+appndcity;
	}
	else if (flag == 1)
	{
		var ct_extdis = '';
		ct_extdis = $('#'+fr+'_veh_cit_dis').val();
	}
	//var plandays = parseInt($("#nn .dp-numberPicker-input").val());
	var plandays = parseInt($("#num_tradays_"+fr).val());
	var vehrental = ''; var myVehicle = new Array();
	
	veh_cnt=$('#'+fr+'_vehdiv').val();
	//alert("Veh_cnt = "+veh_cnt);
	for (var z=0;z<=veh_cnt;z++)
	{
		//alert('Vehicle rent ='+z);
		var vehname = $("#"+fr+"_st_vehic"+z).val();
		var getcityid = $("#"+fr+"_st_city0").val();
		
		//alert("Live ="+$("#"+fr+"_st_vehic"+z).length);
		//alert("vehname= "+vehname);
		//alert("getcityid= "+getcityid);
		if ($("#"+fr+"_st_vehic"+z).length>0)
		{
				var vehsplit = $('#'+fr+'_st_vehic'+z+' option:selected').text().split('~');
				var vehtyp = vehsplit[0];
				var vehsplit = vehname.split('-');
				var citysplit = getcityid.split('-');
				//vehcnt++;
				myVehicle.push(z+'~'+vehsplit[0].trim()+'~'+citysplit[0].trim()+'~'+vehtyp);
		}
	}
	
	//alert(JSON.stringify(myVehicle));
	$("#"+fr+"_vehicles").val(myVehicle);
	var allcitids = $('#'+fr+'_cid_arr').val();
	//alert(ct_extdis);
	//alert('Vehicle rent='+fr);
	if(myVehicle.length > 0)
	{
		//alert('arrsend ='+ myVehicle+', trdist ='+ travdist+', trdays='+ plandays+', ext_dist='+ ct_extdis+', allcids='+ allcitids);
		$.getJSON('<?php echo "AGENT/rent_vehicl.php"; ?>', { arrsend: myVehicle, trdist: travdist, trdays: plandays, ext_dist: ct_extdis, allcids: allcitids }, function(data) {
			//alert("Travel Veh ID : "+data.vehcitid);
			//alert("Value for 'detl': " + data.detl + "\nValue for 'retn': " + data.retn + "\nValue for 'netamt': " + data.netamt);
			//document.getElementById('show_rental').innerHTML=data.detl;
			$("#"+fr+"_veh_upl").val(data.vehupl);
			$("#"+fr+"_all_veh_upl").val(data.all_veh_rent);
			$("#"+fr+"_ret_dist").val(data.retn);
			$("#"+fr+"_tr_tot_amt").val(data.netamt);
			$("#"+fr+"_pervehamt").val(data.pervehamt);
			$("#"+fr+"_vehcitid").val(data.vehcitid);
			$("#"+fr+"_permt_amt").val(data.tot_perm_amt);
			if ($('#check_boxss_br0').val() == '2')
			{
				var dist_total = document.getElementById('show_distot');
				var total_days = document.getElementById('show_days');
				var plantrdays = parseInt($("#num_tradays_"+fr).val());
			
				var net_tot = document.getElementById('netamount');
				net_tot.innerHTML = '';
				 var netamt1=parseInt(data.netamt);
				// alert(netamt1);
				var admn_grand_tot = netamt1 + ((parseInt(adm_percent) / 100) * parseInt(netamt1));
				var agnt_grand_totl = parseInt(admn_grand_tot) + ((parseInt(agent_percnt) / 100) * parseInt(admn_grand_tot));
				//alert('ff'+agnt_grand_totl);
				agnt_grand_totl=Math.round(agnt_grand_totl);
				dist_total.innerHTML="<center><table width='90%'><tr><td width='40%'>Travel days</td><td>:</td><td width='40%'>"+plantrdays+"</td></tr><tr><td>Total travel distance ( Kms )</td><td>:</td><td>"+disp_trdist+"</td></tr><tr><td>Net charge for your transport (Rs.) </td><td>:</td><td>"+agnt_grand_totl.toLocaleString()+"/- </td></tr></table></center>";
				
			}
			else if ($('#check_boxss_br0').val() == '1')
			{
				var dist_total = document.getElementById('show_distot');
				var total_days = document.getElementById('show_days');
				var plantrdays = parseInt($("#num_tradays_"+fr).val());
				
			//	dist_total.innerHTML = "<strong> Total travel distance: "+disp_trdist+ " kms. </strong>" + '<br>';
				//total_days.innerHTML = "<strong> Travel days: "+plantrdays + "</strong>" + '<br>';
				
				var net_tot = document.getElementById('netamount');
				net_tot.innerHTML = ''; var netamt1=parseInt(data.netamt);
				var admn_grand_tot = netamt1 + ((parseInt(adm_percent) / 100) * parseInt(netamt1));
				var agnt_grand_totl = parseInt(admn_grand_tot) + ((parseInt(agent_percnt) / 100) * parseInt(admn_grand_tot));
					agnt_grand_totl=Math.round(agnt_grand_totl);
				//net_tot.innerHTML+= "<strong>Net charge for your transport: Rs. "+Math.round(agnt_grand_totl) + "</strong>" + '<br>';
				
				dist_total.innerHTML="<center><table width='90%'><tr><td width='40%'>Travel days</td><td>:</td><td width='40%'>"+plantrdays+"</td></tr><tr><td>Total travel distance ( Kms )</td><td>:</td><td>"+disp_trdist+"</td></tr><tr><td>Net charge for your transport (Rs.) </td><td>:</td><td>"+agnt_grand_totl.toLocaleString()+"/- </td></tr></table></center>";
				
				view_stay_quote(fr,<?php echo $agent_perc; ?>,<?php echo $agnt_adm_perc; ?>);
				show_get_quote();
			}
			
		//	$('#subplan').trigger('click');
		sendappr(fr);
		befr_before_submit(fr);
			
		}).error(function(jqXHR, textStatus, errorThrown) {
			alert(jqXHR.responseText);
    // Inspect the values of jqXHR, textStatus, errorThrown here.
});
	}

}

function befr_before_submit(fr)
{
	var bef_call=$('#befr_sub_input').val();
	if(bef_call==$('#tot_num_of_form').val())
	{
		//alert('Now Called');
		before_submit();
	}else{
		//alert('Not Called');
		$('#befr_sub_input').val(parseInt($('#befr_sub_input').val())+1);
	}
}

function sendappr(fr)
{
	var tot_pr=parseInt($("#num_traveller_"+fr).val())+parseInt($("#num_chd512_"+fr).val())+parseInt($("#num_chd_b5_"+fr).val());
				$("#"+fr+"_trv_cnt").val(tot_pr);
				$("#"+fr+"_trv_days").val($("#num_tradays_"+fr).val());
				$("#"+fr+"_trv_nights").val($("#num_tranight_"+fr).val());
				$("#"+fr+"_trv_adult").val($("#num_traveller_"+fr).val());
				$("#"+fr+"_trv_child").val($("#num_chd_b5_"+fr).val());
				$("#"+fr+"_trv_room").val($("#num_room_htls_"+fr).val());
				//document.thplan.submit();
				///return true;
}

function before_submit(fr)
{
	//alert('BEFORE SUBMIT ==');
	var checkboxx=$('#check_boxss_br0').val();
	var datastring = $("#ExampleBootstrapValidationForm").serialize();
		$('.loader_ax').fadeIn();
        $.ajax({
            type: "POST",
            url: "AGENT/before_submit.php?checkboxx="+checkboxx,
            data: datastring,
            success: function(res) {
               //  alert('Data send'+res);
				    var ress=res.trim().split("#");
					
					if($('#check_boxss_br0').val() == '2')
					{
						$.get('AGENT/itin_submit_trav_report.php?planid1='+ress[0]+'&planid2='+ress[1],function(result)
						{
							 $('.loader_ax').fadeOut(500);
							 $('#det_rep').empty().html(result);
							 $('#Travel_info_mod').modal('show');
						});
					}else if($('#check_boxss_br0').val() == '1')
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

function manage_trhot_status(sts)
{
	var frms=$('#tot_num_of_form').val().trim();
	$('#befr_htl_sub_input').val(frms);
	if(sts=='plan_my_stay')
	{
		$('#Travel_info_mod').hide();
		$('#init_boxx').hide();
		$('#secondary_boxx').fadeIn();
	
		//$('#table_collection0').empty();
	
		//room formation start
		//$('#stay').hide();
		//$('#'+fr+'_tableee').show();

		for(var frr=0;frr<=frms;frr++)
		{
			//alert("For ="+frr);
			fr1=frr;
			fr="br"+frr;
			if(fr1>0 && $('#arrdate_'+fr).length>0)
			{
				var sdarrdate=$('#arrdate_'+fr).val();
				var sdddatdate=$('#depart_ddat_'+fr).val();
				
		var rminfo="<p style=' font-weight:600; text-align:center'>Room Information [ From "+sdarrdate+" - to - "+sdddatdate+" ]</p><table width='80%'  id='"+fr+"_new_room_table' bgcolor='#EAF4FA' border='1px solid' style=' border:1px solid #DFE9EF; background-color:#EAF4FA; color:#365686; margin-top:20px' ><tr id='"+fr+"_new_rm_tr0'><th style='padding:10px' width='10%'>Rooms</th><th style='padding:10px' width='10%'>Adult</th><th style='padding:10px' width='15%'>5 - 12 age child(ren)</th><th style='padding:10px' width='18%'>Below 5 age child(ren)</th><th style='padding:10px' width='15%'>Extra Bed</th></tr><tr id='"+fr+"_new_rm_tr1'><td style='padding:10px' id='"+fr+"_room_nw_td1'>Room 1</td><td style='padding:10px' id='"+fr+"_adlt_nw_td1'><input type='text' id='"+fr+"_sel_adlt_nw1' name='"+fr+"_sel_adlt_nw1' readonly class='form-control tooltips' ></td><td style='padding:10px' id='"+fr+"_ch512_nw_td1'><input type='text' id='"+fr+"_sel_nw_512ch1' name='"+fr+"_sel_nw_512ch1'  value='0' readonly class='form-control tooltips' ></td><td style='padding:10px' id='"+fr+"_chb5_nw_td1'><input type='text' id='"+fr+"_sel_nw_b5ch1' name='"+fr+"_sel_nw_b5ch1' value='0' readonly class='form-control tooltips' ></td><td style='padding:10px' id='"+fr+"_extr_nw_td1'><select id='"+fr+"_sel_nw_extr1' name='"+fr+"_sel_nw_extr1' class='form-control chosen-select'><option value='-' selected>Nil</option><option value='0'>With Bed</option><option value='1'>Without Bed</option></select><input type='hidden' value='both_food' name='"+fr+"_food_categ_dvi' id='"+fr+"_food_categ_dvi'/></td></tr></table>";
		
				$(rminfo).appendTo('#tablee_chld');
			}
			
			var err_len=$('#'+fr+'_new_room_table tbody').children().length;
			var num_of_rooms=parseInt($("#num_room_htls_"+fr).val());	
			$('#room_of_num').val(num_of_rooms);
			var day_of_stay=parseInt($("#num_tranight_"+fr).val());	
			$('#'+fr+'_day_of_stay').val(day_of_stay);
			
			var tt_ad_val2=$('#adult_no_cal_'+fr).val();
			var tt_ad_val3;
			
			if(tt_ad_val2>=3)
			{
		$('#'+fr+'_adlt_nw_td1').empty().html("<select id='"+fr+"_sel_adlt_nw1' name='"+fr+"_sel_adlt_nw1' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_youth("+fr1+",this.value,1); find_no_adult_rem("+fr1+",this.value,1)'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>");
		$('.chosen-select').chosen({width:'100%'});
			}else if(tt_ad_val2>=2)
			{
		$('#'+fr+'_adlt_nw_td1').empty().html("<select id='"+fr+"_sel_adlt_nw1' name='"+fr+"_sel_adlt_nw1' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_youth("+fr1+",this.value,1); find_no_adult_rem("+fr1+",this.value,1)'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
		$('.chosen-select').chosen({width:'100%'});
			}else if(tt_ad_val2>=1)
			{
	$('#'+fr+'_adlt_nw_td1').empty().html("<select id='"+fr+"_sel_adlt_nw1' name='"+fr+"_sel_adlt_nw1' class='form-control chosen-select' data-placeholder='choose' onChange= find_no_youth("+fr1+",this.value,1); find_no_adult_rem("+fr1+",this.value,1)'> <option selected value='0'>choose</option><option value='1'>1</option></select>");
	$('.chosen-select').chosen({width:'100%'});
			}
			
			for(nw_rm=2;nw_rm<=num_of_rooms;nw_rm++)
			{	
				var new_rm_add="<tr id='"+fr+"_new_rm_tr"+nw_rm+"'><td style='padding:10px' id='"+fr+"_room_nw_td"+nw_rm+"'>Room "+nw_rm+"</td><td style='padding:10px' id='"+fr+"_adlt_nw_td"+nw_rm+"'><input type='text' id='"+fr+"_sel_adlt_nw"+nw_rm+"' value='0' name='"+fr+"_sel_adlt_nw"+nw_rm+"' readonly class='form-control tooltips'></td><td style='padding:10px' id='"+fr+"_ch512_nw_td"+nw_rm+"'><input type='text' value='0' id='"+fr+"_sel_nw_512ch"+nw_rm+"' name='"+fr+"_sel_nw_512ch"+nw_rm+"' readonly class='form-control tooltips' ></td><td style='padding:10px' id='"+fr+"_chb5_nw_td"+nw_rm+"'><input type='text' value='0' id='"+fr+"_sel_nw_b5ch"+nw_rm+"' name='"+fr+"_sel_nw_b5ch"+nw_rm+"' readonly class='form-control tooltips' ></td><td style='padding:10px' id='"+fr+"_extr_nw_td"+nw_rm+"'><select id='"+fr+"_sel_nw_extr"+nw_rm+"' name='"+fr+"_sel_nw_extr"+nw_rm+"' class='form-control chosen-select'><option value='-' selected>Nil</option><option value='0'>With Bed</option><option value='1'>Without Bed</option></select></td></tr>";
				
				var prvv=nw_rm-1;
				$(new_rm_add).insertAfter('#'+fr+'_new_rm_tr'+prvv);
				$('.chosen-select').chosen({width:'100%'});
			//	alert(fr+' = '+nw_rm);
			}
			//room formation end
											var romm_dates=$('#arrdate_'+fr).val()+' to '+$('#depart_ddat_'+fr).val();
											$('#room_info_title_'+fr).empty().prepend('Room Information - For [ '+romm_dates+' ]');
											$('#htl_info_title_'+fr).empty().prepend('Hotel Information - For [ '+romm_dates+' ]');
		}
		
		$('#tableee').show();
		for(var frr=0;frr<=frms;frr++)
		{/*
			fr1=frr;
			fr="br"+frr;
			//my_edit start
			if(fr1>0)
			{
					var sdarrdate=$('#arrdate_'+fr).val();
					var sdddatdate=$('#depart_ddat_'+fr).val();
				
				var mk_next="<div class='row'><div class='col-sm-12' style='margin-top:10px;border: 1px sol;border-top: 1px solid #ccc;'><div id='"+fr+"_tableee' style='background-color:#FFF; display:none'><div align='center'><p style=' font-weight:600; text-align:center'>Room Information [ From "+sdarrdate+" - to - "+sdddatdate+" ]</p><table width='80%'  id='"+fr+"_new_room_table' bgcolor='#EAF4FA' border='1px solid' style=' border:1px solid #DFE9EF; background-color:#EAF4FA; color:#365686; margin-top:20px' ><tr id='"+fr+"_new_rm_tr0'><th style='padding:10px' width='10%'>Rooms</th><th style='padding:10px' width='10%'>Adult</th><th style='padding:10px' width='15%'>5 - 12 age child(ren)</th><th style='padding:10px' width='18%'>Below 5 age child(ren)</th><th style='padding:10px' width='15%'>Extra Bed</th></tr><tr id='"+fr+"_new_rm_tr1'><td style='padding:10px' id='"+fr+"_room_nw_td1'>Room 1</td><td style='padding:10px' id='"+fr+"_adlt_nw_td1'><input type='text' id='"+fr+"_sel_adlt_nw1' name='"+fr+"_sel_adlt_nw1' readonly class='form-control tooltips' ></td><td style='padding:10px' id='"+fr+"_ch512_nw_td1'><input type='text' id='"+fr+"_sel_nw_512ch1' name='"+fr+"_sel_nw_512ch1'  value='0' readonly class='form-control tooltips' ></td><td style='padding:10px' id='"+fr+"_chb5_nw_td1'><input type='text' id='"+fr+"_sel_nw_b5ch1' name='"+fr+"_sel_nw_b5ch1' value='0' readonly class='form-control tooltips' ></td><td style='padding:10px' id='"+fr+"_extr_nw_td1'><select id='"+fr+"_sel_nw_extr1' name='"+fr+"_sel_nw_extr1' class='form-control chosen-select'><option value='-' selected>Nil</option><option value='0'>With Bed</option><option value='1'>Without Bed</option></select></td></tr></table><input type='hidden' value='both_food' name='"+fr+"_food_categ_dvi' id='"+fr+"_food_categ_dvi'/></div><div class='col-sm-12' id='"+fr+"_food_only_div' style='margin-top:20px;'><div class='col-sm-5' align='right'> Choose Food :</div><div class='col-sm-3'><select onChange='set_food_categ("+fr+",this.value)' data-placeholder='Choose Food' class='form-control chosen-select' id='"+fr+"_foodd_id' name='"+fr+"_foodd_id'><option></option><option value='lunch_rate'> Breakfast &amp; Lunch Only </option><option value='dinner_rate'> Breakfast&amp; Dinner Only </option><option value='both_food' selected> Breakfast, Lunch &amp; Dinner </option><option value='no'>Breakfast Only</option></select></div><div class='col-sm-4'></div></div></div></div></div><div class='row' id='"+fr+"_htl_sub_divs' style='display:none'><div class='col-sm-12' style='margin-top:20px'><hr style='margin-top: 10px;margin-bottom: 10px;'><div class='col-sm-4'><a href='javascript:void()' id='stay_plan11' onClick='backto_init_boxx()' style='text-decoration:none; ' class='btn btn-default'>Back</a></div><div class='col-sm-3'><a href='javascript:void()' id='stay_plan11' onClick='dvi_sugg_hotel("+fr1+")' style='text-decoration:none' class='btn btn-info'>DVI Suggested Quote</a><input type='hidden' value='1' id='dvi_sug_hotel_txt_"+fr+"' name='dvi_sug_hotel_txt_"+fr+"'></div><div class='col-sm-3'><a href='javascript:void()' id='stay_plan11' onClick=plan_my_stay('hotelandtravelonly','"+fr+"') style='text-decoration:none;' class='btn btn-info'>Plan On Own </a><input type='hidden' value='0' id='plan_my_stay_txt_"+fr+"' name='plan_my_stay_txt_"+fr+"'></div><div class='col-sm-2'></div></div></div><div class='row' id='dvi_sugg_hotel_div_"+fr+"' style='display:none;'><div class='col-sm-12'  style=' margin-top:15px;'><hr style=' margin-top:10px; margin-bottom:10px'><p style='color:#CCC; font-weight:600; text-align:center'>Hotel Information ( DVI Suggested )</p><div id='load_div_sugg_quote_"+fr+"'><div class='col-sm-12' align='center' style=' margin-top:15px;'><a class='btn btn-info' id='resume_hotel_sub_"+fr+"' name='resume_hotel_sub_"+fr+"' onClick=resume_later('dvi_sugg','"+fr+"') style='display:none' >Save It</a></div></div></div></div><div class='row' id='planmy_hotel_div_"+fr+"' style='display:none'><div class='col-sm-12'  style=' margin-top:15px; '><hr style=' margin-top:10px; margin-bottom:10px'><p style='color:#9C9C9C; font-weight:600; text-align:center' id='powhinfo_"+fr+"'>Hotel Information ( Plan On Own )</p><div id='"+fr+"_table_collection0'></div><input type='hidden' value='' id='prv_ch_"+fr+"'><div class='row' align='center'><a class='btn btn-info' id='resume_hotel_pow_"+fr+"' name='resume_hotel_pow_"+fr+"' onClick=resume_later('plan_on_own','"+fr+"') style='display:none'>Save It</a><a class='btn btn-info' id='plan_hotel_sub_"+fr+"' name='plan_hotel_sub_"+fr+"' onClick=show_hotel_list('plan_mystay','"+fr+"') >Proceed</a></div></div>";
				
				$(mk_next).appendTo('#secondary_boxx');
			}
			//my_edit end
			
			
			
			
			var err_len=$('#'+fr+'_new_room_table tbody').children().length;
			var num_of_rooms=parseInt($("#num_room_htls_"+fr).val());	
			$('#room_of_num').val(num_of_rooms);
			var day_of_stay=parseInt($("#num_tranight_"+fr).val());	
			$('#'+fr+'_day_of_stay').val(day_of_stay);
			
			var tt_ad_val2=$('#adult_no_cal_'+fr).val();
			var tt_ad_val3;
			
			if(tt_ad_val2>=3 )
			{
		$('#'+fr+'_adlt_nw_td1').empty().html("<select id='"+fr+"_sel_adlt_nw1' name='"+fr+"_sel_adlt_nw1' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_youth("+fr1+",this.value,1); find_no_adult_rem("+fr1+",this.value,1)'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>");
		$('.chosen-select').chosen({width:'100%'});
			}else if(tt_ad_val2>=2 )
			{
		$('#'+fr+'_adlt_nw_td1').empty().html("<select id='"+fr+"_sel_adlt_nw1' name='"+fr+"_sel_adlt_nw1' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_youth("+fr1+",this.value,1); find_no_adult_rem("+fr1+",this.value,1)'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
		$('.chosen-select').chosen({width:'100%'});
			}else if(tt_ad_val2>=1 )
			{
	$('#'+fr+'_adlt_nw_td1').empty().html("<select id='"+fr+"_sel_adlt_nw1' name='"+fr+"_sel_adlt_nw1' class='form-control chosen-select' data-placeholder='choose' onChange= find_no_youth("+fr1+",this.value,1); find_no_adult_rem("+fr1+",this.value,1)'> <option selected value='0'>choose</option><option value='1'>1</option></select>");
	$('.chosen-select').chosen({width:'100%'});
			}
			
			for(nw_rm=2;nw_rm<=num_of_rooms;nw_rm++)
			{	
				var new_rm_add="<tr id='"+fr+"_new_rm_tr"+nw_rm+"'><td style='padding:10px' id='"+fr+"_room_nw_td"+nw_rm+"'>Room "+nw_rm+"</td><td style='padding:10px' id='"+fr+"_adlt_nw_td"+nw_rm+"'><input type='text' id='"+fr+"_sel_adlt_nw"+nw_rm+"' value='0' name='"+fr+"_sel_adlt_nw"+nw_rm+"' readonly class='form-control tooltips'></td><td style='padding:10px' id='"+fr+"_ch512_nw_td"+nw_rm+"'><input type='text' value='0' id='"+fr+"_sel_nw_512ch"+nw_rm+"' name='"+fr+"_sel_nw_512ch"+nw_rm+"' readonly class='form-control tooltips' ></td><td style='padding:10px' id='"+fr+"_chb5_nw_td"+nw_rm+"'><input type='text' value='0' id='"+fr+"_sel_nw_b5ch"+nw_rm+"' name='"+fr+"_sel_nw_b5ch"+nw_rm+"' readonly class='form-control tooltips' ></td><td style='padding:10px' id='"+fr+"_extr_nw_td"+nw_rm+"'><select id='"+fr+"_sel_nw_extr"+nw_rm+"' name='"+fr+"_sel_nw_extr"+nw_rm+"' class='form-control chosen-select'><option value='-' selected>Nil</option><option value='0'>With Bed</option><option value='1'>Without Bed</option></select></td></tr>";
				
				var prvv=nw_rm-1;
				$(new_rm_add).insertAfter('#'+fr+'_new_rm_tr'+prvv);
				$('.chosen-select').chosen({width:'100%'});
			//	alert(fr+' = '+nw_rm);
			}
			//room formation end
											var romm_dates=$('#arrdate_'+fr).val()+' to '+$('#depart_ddat_'+fr).val();
											$('#room_info_title_'+fr).empty().prepend('Room Information - For [ '+romm_dates+' ]');
											$('#htl_info_title_'+fr).empty().prepend('Hotel Information - For [ '+romm_dates+' ]');
		*/}//main for loop
	
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

function dvi_sugg_hotel(frm)
{ 
	var fr="br"+frm;
	$('#'+fr+'_food_only_div').show();
	var troom=$('#num_room_htls_'+fr).val();
	var tadult=$('#num_traveller_'+fr).val();
	var tch512=$('#num_chd512_'+fr).val();
	var tch5blw=$('#num_chd_b5_'+fr).val();
	var tot_fpax=parseInt(tadult)+parseInt(tch512);
	var tot_pax=parseInt(tadult)+parseInt(tch512)+parseInt(tch5blw);
	var tot1=0,tot2=0,tot3=0;
	var extbed=''
	for(var l=1; l<=troom; l++)
	{
		tot1=tot1+parseInt($('#'+fr+'_sel_adlt_nw'+l).val());
		tot2=tot2+parseInt($('#'+fr+'_sel_nw_512ch'+l).val());
		tot3=tot3+parseInt($('#'+fr+'_sel_nw_b5ch'+l).val());
		
		if(extbed=='')
		{
			extbed=$('#'+fr+'_sel_nw_extr'+l).val();
		}else{
			extbed=extbed+','+$('#'+fr+'_sel_nw_extr'+l).val();
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
	var stay_cntt=parseInt($("#num_tranight_"+fr).val());
	var stdt=$('#arrdate_'+fr).val();
	//$('.loader_ax').fadeIn();
	/*$.get('AGENT/dvi_sugg_hotels.php?ccids='+$('#'+fr+'_kit_cityidd').val()+'&stay_cntt='+stay_cntt+'&stdate='+stdt+'&tot_fpax='+tot_fpax+'&troom='+troom+'&food_catd='+food_cate+'&tot_pax='+tot_pax+'&extbed='+extbed+'&frms='+fr,function(res){
		$('.loader_ax').fadeOut();
		$('#load_div_sugg_quote_'+fr).empty().html(res);
		
		$('.chosen-select').chosen({width:'100%'});
				if($('#hide_5star').length>0)
				{
					var hide5=$('#hide_5star').val().trim();
					$('#div_catg_'+hide5).hide();
				}
		});*/
		var datastring = $("#ExampleBootstrapValidationForm").serialize();
		$('.loader_ax').fadeIn();
		$.ajax({
			type :"POST",
		    data:datastring,
			url:"AGENT/dvi_sugg_hotels.php",
			success: function(res){
					//alert("DIV SUGG = "+res);
					$('.loader_ax').fadeOut();
					$('#load_div_sugg_quote').empty().html(res);
                    $('#resume_hotel_sub').show();
				}
			});
		
	}
	
}

function hidden_divs(hstr)
{
    //alert("hidden"+hstr);
    $('#div_catg_'+hstr).hide();
}

function set_cate(categ)
{
	var tfom=$('#tot_num_of_form').val();
	for(var tf=0;tf<=tfom;tf++)
	{
		var fr="br"+tf;
		if($('#'+fr+'_kit_cityidd').length>0)
		{
			var tc_arr=$('#'+fr+'_kit_cityidd').val().split(',');
			var hlid,disb='no';
			for(var ch=0; ch<tc_arr.length; ch++)//checking to disable button if hotel not available
			{
				hlid=$('#'+fr+'_hid_'+categ+'_'+ch).val().trim();
				if( hlid=='-' || hlid=='')
				{
					disb='yes';
				}
			}
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


function show_hotel_list(opt)
{
	if(opt=='plan_mystay' && $('#prev_catg').length>0)
	{
		$('#prev_catg').val('');
	}
	
	//alert("show_htl_list ="+opt);
	//if($('#prev_catg').length>0 && $('#prev_catg').val().trim()!='')//dvi suggested hotels
	if($('#prev_catg').length>0  && opt!='plan_mystay')//dvi suggested hotels
	{
		if($('#prev_catg').val().trim()=='' && opt!='plan_mystay')
		{
			alert('Please choose any category of hotels..');
		}else{
				var checkboxx=$('#check_boxss_br0').val();
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
							if($('#check_boxss_br0').val() == '1')
							{
										$('#trav_cancel').show();
										$('#trav_confirm1').show();
										$('#trhotl_cancel').hide();
										$('#trhotl_pms').hide();
										$('#trhotl_pms1').hide();
										$('#det_rep').empty().html(res);
										
										/*if($('#befr_htl_sub_input').val()=='0')
										{*/
											$('#Travel_info_mod').modal('show');
										/*}else{
											$('#befr_htl_sub_input').val(parseInt($('#befr_htl_sub_input').val())-1);
											
											$('#'+fr+'_tableee').hide();
											$('#'+fr+'_htl_sub_divs').hide();
											$('#dvi_sugg_hotel_div_'+fr).hide();
											
											var fr1=fr.split("br");
											var fr2=parseInt(fr1[1])+1;
											fr2="br"+fr2;
											var romm_dates=$('#arrdate_'+fr2).val()+' to '+$('#depart_ddat_'+fr2).val();
											$('#room_info_title_'+fr2).empty().prepend('Room Information - For [ '+romm_dates+' ]');
											$('#htl_info_title_'+fr2).empty().prepend('Hotel Information - For [ '+romm_dates+' ]');
											
											$('#'+fr2+'_tableee').show();
											$('#'+fr2+'_htl_sub_divs').show();
											$('#dvi_sugg_hotel_div_'+fr2).show();
										}*/
							}
					}
				});	
		}
	}else{///plan_mystay
            var totfomx=$('#tot_num_of_form').val();
            var csk=0;
            for(var fomx=0;fomx<=totfomx;fomx++)
            {
                fr="br"+fomx;
                if($("#num_tranight_"+fr).length>0)
                {
						//validation to plan_mystay
						var prv_c=$('#prv_ch').val();
						//alert("Inner =");
						if(prv_c != '')
						{
						$('#'+prv_c).css('background-color','#FFF');
						}
						var days=parseInt($("#num_tranight_"+fr).val());
						var rooms=parseInt($("#num_room_htls_"+fr).val());
						
						//alert("loop days ="+days);
						for(var dd=1;dd<=days;dd++)
						{
							//alert("For ="+dd);
							var mybtn=parseInt($('body #vali_quote').offset().top);
							var dates=$('#'+fr+'_sdat'+dd).val();
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
										if($('#'+fr+'_hot_rm_id'+dd+'_'+chy2).length>0 && $('#hot_rm_id'+dd+'_'+chy2).val()=='')
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
                    }//live or dead if end
				}//main for loop		
								//alert("CSK ="+csk);
						if(csk==0)
						{//call to plan_mystay
						
			var checkboxx=$('#check_boxss_br0').val();
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
						// alert('Hotel Data send'+res);
							
							if($('#check_boxss_br0').val() == '1')
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
									   //	$('#Travel_info_mod').modal('show');
											$('#Travel_info_mod').modal('show');
										
							}
					}
				});
						}//valid
	}//else end
	
}


function plan_my_stay(where)
{
    var tofrm=$('#tot_num_of_form').val();
    var fr;
    $('#table_collection').empty();
    for(var frmc=0;frmc<=tofrm;frmc++)
    {
        fr="br"+frmc;
        if($('#arrdate_'+fr).length>0)
        {
        
	var troom=$('#num_room_htls_'+fr).val();
	var tadult=$('#num_traveller_'+fr).val();
	var tch512=$('#num_chd512_'+fr).val();
	var tch5blw=$('#num_chd_b5_'+fr).val();
	var tot1=0,tot2=0,tot3=0;
	for(var l=1; l<=troom; l++)
	{
		tot1=tot1+parseInt($('#'+fr+'_sel_adlt_nw'+l).val());
		tot2=tot2+parseInt($('#'+fr+'_sel_nw_512ch'+l).val());
		tot3=tot3+parseInt($('#'+fr+'_sel_nw_b5ch'+l).val());
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
	
	
	var err_len=$('#'+fr+'_new_room_table tbody').children().length;
			//hotel information start
			var sdarrdate=$('#arrdate_'+fr).val();
			var sdddatdate=$('#depart_ddat_'+fr).val();
			//$('#powhinfo_'+fr).empty().prepend('Hotel Information ( Plan On Own ) <br> [ From '+sdarrdate+' - to -'+sdddatdate+']');
			
			var stay_days=parseInt($("#num_tranight_"+fr).val());
			var table_uniq;
			for(var days=1;days<=stay_days;days++)
			{
				//alert(fr+"_table_collection"+days);
				table_uniq="<div id='"+fr+"_table_collection"+days+"'><center><table id='"+fr+"_stay_tabell"+days+"' class='table' style='width:90%;margin-top:15px; border:#DFDADA 1px solid;'><tr style='height:20px; background-color:#FFFCF2'><td width='15%'>Date</td><td width='20%' id='"+fr+"_sdate_nw_td"+days+"' >23-Jun-2015</td><td witdh='15%'>Place:</td><td  id='"+fr+"_city_nw_td"+days+"'>xxx</td><td ><a id='"+fr+"_pic_view"+days+"' class='add_hots4 btn btn-sm btn-info' ><i class='fa fa-picture-o'></i>&nbsp;View Spot</a></td></tr><tr><td width='15%'>Category</td><td width='25%' id='"+fr+"_catag_nw_td"+days+"'><input type='text' class='form-control' disabled ></td><td width='5%'>&nbsp;</td><td id='"+fr+"_tdroom_nw_td"+days+"' rowspan='4' colspan='2' width='40%' style='border: #CAC6C6 1px solid; background-color: rgb(245, 245, 244);'><br><br><center>Choose hotel for finding available rooms</center></td></tr></tr><tr><td width='15%'>Hotel</td><td width='25%' id='"+fr+"_hotel_nw_td"+days+"' ><input type='text' class='form-control' disabled ></td><td>&nbsp;</td></tr></tr><tr><td width='5%'>Food</td><td id='"+fr+"_food_nw_td"+days+"'><input type='text' class='form-control' id='"+fr+"_food_id"+days+"' name='"+fr+"_food_id"+days+"' disabled ></td><td width='5%'> </td></tr></tr><tr><td width='15%'>Special</td><td width='25%' id='"+fr+"_spl_nw_td"+days+"'><input type='text' class='form-control' name='"+fr+"_ext_item_id"+days+"' id='"+fr+"_ext_item_id"+days+"' disabled ></td><td width='5%'></td></tr></table><input type='hidden' id='"+fr+"_htl_id"+days+"' value='' /></center></div>";

					var prv_day=days-1;
					//if(days==1){
					//$(table_uniq).appendTo('#'+fr+'_table_collection'+prv_day);
					//}else{
					//	$(table_uniq).insertAfter('#'+fr+'_table_collection'+prv_day);
					//}
                    $(table_uniq).appendTo('#table_collection');

			}
			
		var eat;
		for(var east=1;east<=stay_days;east++)
		{
			eat=east-1;
			var ddate=$('#'+fr+'_start_date'+eat).val();
			$('#'+fr+'_sdate_nw_td'+east).empty().html("<input class='form-control' type='text' readonly id='"+fr+"_sdat"+east+"' name='"+fr+"_sdat"+east+"' value='"+ddate+"'>");
			
			city_kitname=$('#'+fr+'_kit_kat').val().split(",");
			//alert(city_kitname);
			city_kitname1=city_kitname[eat];
	$('#'+fr+'_city_nw_td'+east).empty().html("<input type='text' class='form-control' value='"+city_kitname1+"' id='"+fr+"_kitcity"+eat+"' readonly='readonly' >");
		
			city_kitidd=$('#'+fr+'_kit_cityidd').val().split(",");
			idds=city_kitidd[eat];
			$('#'+fr+'_pic_view'+east).attr('href','AGENT/view_img_desc.php?cid='+idds);
			$('#'+fr+'_video_view'+east).attr('href','AGENT/view_video_spot.php?cid='+idds);
		}
	
		var kitkkk=$('#'+fr+'_kit_cityidd').val().split(",");
		var kithhh=kitkkk.length;
		var hugg;
		for(var hug=0; hug<kithhh; hug++)
		{
		  hugg=hug+1;
			$('#'+fr+'_htl_id'+hugg).val(kitkkk[hug]);
			find_hotel_categ(fr,kitkkk[hug],hugg);
			find_all_categ(fr,kitkkk[hug],hugg);
		}
	
	$('#sun').show();
	}//else validation rooms
        }//live or not if end
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

function find_hotel_rooms(fr,hid,no)
{
			var type=2;
			var rms=parseInt($("#num_room_htls_"+fr).val());	
			var datt=$('#'+fr+'_sdat'+no).val();
			$('.loader_ax').fadeIn();
			$.get('AGENT/ajax_agent.php?hid='+hid+'&no='+no+'&type='+type+'&tdate='+datt+'&rooms='+rms+'&fr='+fr,function(result){
				//$('.loader_ax').fadeOut();
				//alert(result);
			$('#'+fr+'_tdroom_nw_td'+no).empty().html(result);
			$('.chosen').chosen({'width':'100%'});
			
			find_special_amenity(fr,hid,no);
			find_food_category(fr,hid,no);
			find_rate_cbed(fr,hid,no);
			});
	
}

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

function find_rate_cbed(fr,val,no)
{
	var datt=$('#'+fr+'_sdat'+no).val();
	var ht_id=$('#'+fr+'_hotel_sel_id'+no).val();
	var type=11;
	$.get('AGENT/ajax_agent.php?val='+val+'&date='+datt+'&type='+type+'&hot_id='+ht_id+'&no='+no+'&fr='+fr,function(result){
	$('#'+fr+'_tdroom_nw_td'+no).append(result);
	});
}

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

function find_food_rate(fr,val,no)
{
    var datt=$('#'+fr+'_sdat'+no).val();
	var nums=parseInt($("#num_room_htls_"+fr).val());
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
	
	if(rmno==1){
	for(var yo1=2;yo1<=parseInt($("#num_room_htls_"+fr).val());yo1++)
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

function find_hb_room_rent(fr,val,no,rmno)
{
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

function fun_hb_remove(fr,rno,tno)
{
	$('#'+fr+'_tr_hb_'+rno+'_'+tno).remove();
}

/*function set_food_categ(fr,sfood)
{
    alert(fr+' / '+sfood);
	$('#'+fr+'_food_categ_dvi').val(sfood);	
}*/

function set_food_categ(sfood)
{
    //alert(sfood);
    $('#food_categ_dvi').val(sfood); 
}

function find_no_youth(fr,val,no)
{
	var fr1=fr;
	var fr="br"+fr;
	var tt_ad_val, tt_ad_val1;
	var num_new_rooms=parseInt($("#num_room_htls_"+fr).val());	
		var dis_nw=no+1;
		var jcnt=0;
	
	for(var dis=dis_nw;dis<=num_new_rooms;dis++)
	{				
	$('#'+fr+'_ch512_nw_td'+dis).empty().html("<input id='"+fr+"_sel_nw_512ch"+dis+"' name='"+fr+"_sel_nw_512ch"+dis+"' class='form-control tooltips ' value='0' readonly>");
		jcnt=jcnt+parseInt($('#'+fr+'_sel_nw_512ch'+dis).val());
	}
	for(var prv=1;prv<dis_nw;prv++)
	{
		if(no!=prv)
		jcnt=jcnt+parseInt($('#'+fr+'_sel_nw_512ch'+prv).val());
	}
	//alert("NOW 512="+jcnt);
	var mmmmm=parseInt($('#num_chd512_'+fr).val())-parseInt(jcnt);
	//alert("REm 512="+mmmmm);
	$('#child512_no_cal_'+fr).val(mmmmm);
	var ssum=$('#child512_no_cal_'+fr).val();
	tt_ad_val=ssum;
	tt_ad_val1=tt_ad_val;
	$('#child512_no_cal_'+fr).val(tt_ad_val1);
	var ddddsg=$('#child512_no_cal_'+fr).val();
	var new_no=no+1;
	var type=14;
var b5chbr=$('#num_chd_b5_'+fr).val();
//alert("RESSSS 512="+ddddsg);
		if(ddddsg>0)
		{
			//val=ddddsg;
			//alert("val= "+val);
			if(val==3)
			{
		$('#'+fr+'_ch512_nw_td'+no).empty().html("<select id='"+fr+"_sel_nw_512ch"+no+"' name='"+fr+"_sel_nw_512ch"+no+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5("+fr1+",this.value,"+no+"); find_no_ch512_rem("+fr1+",this.value,"+no+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
		$('.chosen-select').chosen({width:'100%'});
		
			if(b5chbr>0)
			{
		$('#'+fr+'_chb5_nw_td'+no).empty().html("<select id='"+fr+"_sel_nw_b5ch"+no+"' name='"+fr+"_sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem("+fr1+",this.value,"+no+")' class='form-control chosen-select' data-placeholder='choose'><option selected value='0'>choose</option><option value='1'>1</option></select>");
		$('.chosen-select').chosen({width:'100%'});
			}else{
					$('#'+fr+'_sel_nw_b5ch'+no).removeAttr('data-original-title').attr('data-original-title','No need');
					$('.tooltips').tooltip();
			}
		
		//for extra bed
		$('.chosen-select').chosen('destroy');
		$('#'+fr+'_sel_nw_extr'+no+' option').each(function(i,val){ if(val.value==0){ $(this).attr('selected',true); } });
		$('#'+fr+'_sel_nw_extr'+no).attr('disabled',true);
		//$('#sel_nw_extr'+no).removeAttr('data-original-title').addClass('tooltips').attr('date-original-title','Mandatory');
		//$('.tooltips').tooltip();
		$('.chosen-select').chosen({width:'100%'});
		
			}else if(val==2 )
			{
				//alert("INVal ="+val);
		$('#'+fr+'_ch512_nw_td'+no).empty().html("<select id='"+fr+"_sel_nw_512ch"+no+"' name='"+fr+"_sel_nw_512ch"+no+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5("+fr1+",this.value,"+no+"); find_no_ch512_rem("+fr1+",this.value,"+no+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
		$('.chosen-select').chosen({width:'100%'});
				//alert("Below 5 ="+b5chbr);
				if(b5chbr>0)
				{
			$('#'+fr+'_chb5_nw_td'+no).empty().html("<select id='"+fr+"_sel_nw_b5ch"+no+"' name='"+fr+"_sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem("+fr1+",this.value,"+no+")' class='form-control chosen-select' data-placeholder='choose'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
		$('.chosen-select').chosen({width:'100%'});
				}else{
						$('#'+fr+'_sel_nw_b5ch'+no).removeAttr('data-original-title').attr('data-original-title','No need');
						$('.tooltips').tooltip();
				}
		//for extra bed
		$('.chosen-select').chosen('destroy');
		$('#'+fr+'_sel_nw_extr'+no+' option').each(function(i,val){ if(val.value=='-'){ $(this).attr('selected',true); } });
		$('#'+fr+'_sel_nw_extr'+no).attr('disabled',false);
		$('.chosen-select').chosen({width:'100%'});
			}
			else if(val==1 )
			{
				//alert("INVal ="+val);
		$('#'+fr+'_ch512_nw_td'+no).empty().html("<select id='"+fr+"_sel_nw_512ch"+no+"' name='"+fr+"_sel_nw_512ch"+no+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5("+fr1+",this.value,"+no+"); find_no_ch512_rem("+fr1+",this.value,"+no+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
		$('.chosen-select').chosen({width:'100%'});	
			
			//alert("Below 5 ="+b5chbr);
			if(b5chbr>0)
			{

			$('#'+fr+'_chb5_nw_td'+no).empty().html("<select id='"+fr+"_sel_nw_b5ch"+no+"' name='"+fr+"_sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem("+fr1+",this.value,"+no+")' class='form-control chosen-select' data-placeholder='choose'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>");
		$('.chosen-select').chosen({width:'100%'});	
			}else{
				$('#'+fr+'_sel_nw_b5ch'+no).removeAttr('data-original-title').attr('data-original-title','No need');
					$('.tooltips').tooltip();
			}
		//for extra bed
		$('.chosen-select').chosen('destroy');
		$('#'+fr+'_sel_nw_extr'+no+' option').each(function(i,val){ if(val.value=='-'){ $(this).attr('selected',true); } });
		$('#'+fr+'_sel_nw_extr'+no).attr('disabled',false);
		$('.chosen-select').chosen({width:'100%'});
		
			}
			else 
			{
				alert('no need');
			}
			 
		}else{ //outer else for child512 count<0
				for(var ki=1;ki<=num_new_rooms;ki++)
				{
				$('#'+fr+'_sel_nw_512ch'+ki).removeAttr('data-original-title').attr('data-original-title','No need');
				$('.tooltips').tooltip();
				}
			
				//if(ddddsg>0)//for adult with below5 age // not ch512  
                if(b5chbr>0)//for adult with below5 age // not ch512  
				{
					if(val==3 )
					{
					$('#'+fr+'_chb5_nw_td'+no).empty().html("<select id='"+fr+"_sel_nw_b5ch"+no+"' name='"+fr+"_sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem("+fr1+",this.value,"+no+")' class='form-control chosen-select' data-placeholder='choose'><option selected value='0'>choose</option><option value='1'>1</option></select>");
				$('.chosen-select').chosen({width:'100%'});
				
			
		//for extra bed
		$('.chosen-select').chosen('destroy');
		$('#'+fr+'_sel_nw_extr'+no+' option').each(function(i,val){ if(val.value==0){ $(this).attr('selected',true); } });
		$('#'+fr+'_sel_nw_extr'+no).attr('disabled',true);
		//$('#sel_nw_extr'+no).removeAttr('data-original-title').addClass('tooltips').attr('data-original-title','Mandatory');
		$('.chosen-select').chosen({width:'100%'});
		//$('.tooltips').tooltip();
				
					}else if(val==2 )
					{
					$('#'+fr+'_chb5_nw_td'+no).empty().html("<select id='"+fr+"_sel_nw_b5ch"+no+"' name='"+fr+"_sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem("+fr1+",this.value,"+no+")' class='form-control chosen-select' data-placeholder='choose'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
				$('.chosen-select').chosen({width:'100%'});
				
				//for extra bed
		$('.chosen-select').chosen('destroy');
		$('#'+fr+'_sel_nw_extr'+no+' option').each(function(i,val){ if(val.value=='-'){ $(this).attr('selected',true); } });
		$('#'+fr+'_sel_nw_extr'+no).attr('disabled',false);
		$('.chosen-select').chosen({width:'100%'});
					}
					else if(val==1 )
					{
				$('#'+fr+'_chb5_nw_td'+no).empty().html("<select id='"+fr+"_sel_nw_b5ch"+no+"' name='"+fr+"_sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem("+fr1+",this.value,"+no+")' class='form-control chosen-select' data-placeholder='choose'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>");
				$('.chosen-select').chosen({width:'100%'});	
				
				$('.chosen-select').chosen('destroy');
		$('#'+fr+'_sel_nw_extr'+no+' option').each(function(i,val){ if(val.value=='-'){ $(this).attr('selected',true); } });
		$('#'+fr+'_sel_nw_extr'+no).attr('disabled',false);
		$('.chosen-select').chosen({width:'100%'});
					}
				}else{// for no ch512 and chb5
					for(var ki=1;ki<=num_new_rooms;ki++)
					{
					$('#'+fr+'_sel_nw_b5ch'+ki).removeAttr('data-original-title').attr('data-original-title','No need');
					$('.tooltips').tooltip();
					}
					
					if(val==3)
					{
								$('.chosen-select').chosen('destroy');
		$('#'+fr+'_sel_nw_extr'+no+' option').each(function(i,val){ if(val.value=='0'){ $(this).attr('selected',true); } });
		$('#'+fr+'_sel_nw_extr'+no).attr('disabled',false);
		$('.chosen-select').chosen({width:'100%'});
					}else if(val==2 )
					{
								$('.chosen-select').chosen('destroy');
		$('#'+fr+'_sel_nw_extr'+no+' option').each(function(i,val){ if(val.value=='-'){ $(this).attr('selected',true); } });
		$('#'+fr+'_sel_nw_extr'+no).attr('disabled',false);
		$('.chosen-select').chosen({width:'100%'});
						}else if(val==1 )
					{
								$('.chosen-select').chosen('destroy');
		$('#'+fr+'_sel_nw_extr'+no+' option').each(function(i,val){ if(val.value=='-'){ $(this).attr('selected',true); } });
		$('#'+fr+'_sel_nw_extr'+no).attr('disabled',false);
		$('.chosen-select').chosen({width:'100%'});
						}
				}
		}
}

function find_no_adult_rem(fr,val,no)
{
		var fr1=fr;
		fr="br"+fr;
			var tt_ad_val, tt_ad_val1;
			var num_new_rooms=parseInt($("#num_room_htls_"+fr).val());	
		var dis_nw=no+1;
		var jcnt=0;
	
	for(var dis=dis_nw;dis<=num_new_rooms;dis++)
	{				
		$('#'+fr+'_adlt_nw_td'+dis).empty().html("<input id='"+fr+"_sel_adlt_nw"+dis+"' name='"+fr+"_sel_adlt_nw"+dis+"' class='form-control tooltips ' value='0' readonly>");
		jcnt=jcnt+parseInt($('#'+fr+'_sel_adlt_nw'+dis).val());
	}
	for(var prv=1;prv<dis_nw;prv++)
	{
		jcnt=jcnt+parseInt($('#'+fr+'_sel_adlt_nw'+prv).val());
	}
	//alert("REM  ="+jcnt);
		var mkm=parseInt($('#num_traveller_'+fr).val())-parseInt(jcnt);
	$('#adult_no_cal_'+fr).val(mkm);
	//alert("Remaining ="+mkm);
	tt_ad_val=$('#adult_no_cal_'+fr).val();
	tt_ad_val1=tt_ad_val;
	$('#adult_no_cal_'+fr).val(tt_ad_val1);
	var new_no=no+1;
	//alert("final adult= "+tt_ad_val1);
	if(tt_ad_val1>=3 && num_new_rooms>=new_no)
	{
		$('#'+fr+'_adlt_nw_td'+new_no).empty().html("<select id='"+fr+"_sel_adlt_nw"+new_no+"' name='"+fr+"_sel_adlt_nw"+new_no+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_youth("+fr1+",this.value,"+new_no+"); find_no_adult_rem("+fr1+",this.value,"+new_no+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>");
		$('.chosen-select').chosen({width:'100%'});
		
	}else if(tt_ad_val1>=2 && num_new_rooms>=new_no)
	{
		$('#'+fr+'_adlt_nw_td'+new_no).empty().html("<select id='"+fr+"_sel_adlt_nw"+new_no+"' name='"+fr+"_sel_adlt_nw"+new_no+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_youth("+fr1+",this.value,"+new_no+"); find_no_adult_rem("+fr1+",this.value,"+new_no+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
		$('.chosen-select').chosen({width:'100%'});
		
	}else if(tt_ad_val1>=1 && num_new_rooms>=new_no)
	{
		$('#'+fr+'_adlt_nw_td'+new_no).empty().html("<select id='"+fr+"_sel_adlt_nw"+new_no+"' name='"+fr+"_sel_adlt_nw"+new_no+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_youth("+fr1+",this.value,"+new_no+"); find_no_adult_rem("+fr1+",this.value,"+new_no+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
		$('.chosen-select').chosen({width:'100%'});
	}else if(num_new_rooms>=new_no)
	{
	//no adult	
		for(var mm=new_no;mm<=num_new_rooms;mm++)
		{
			$('#'+fr+'_sel_adlt_nw'+mm).removeAttr('data-original-title').attr('data-original-title','No need');
			$('.tooltips').tooltip();
		}
	}
}

function find_no_chb5(fr,val,no)
{
	var fr1=fr;
		fr="br"+fr;
var adlt_val=$('#'+fr+'_sel_adlt_nw'+no).val();
var ch512_val=$('#'+fr+'_sel_nw_512ch'+no).val();;
var num_new_rooms=parseInt($("#num_room_htls_"+fr).val());	
		if($('#num_chd_b5_'+fr).val()>0 && $('#num_chd512_'+fr).val()>0)// for both the children having 
		{
				if(adlt_val==3 && ch512_val == 1)
				{//no b5
		$('#'+fr+'_chb5_nw_td'+no).empty().html("<input type='text' id='"+fr+"_sel_nw_b5ch"+no+"' name='"+fr+"_sel_nw_b5ch"+no+"' class='form-control tooltips' value='0'>");
				}else if(adlt_val==3 && ch512_val == 0)
				{
					// b5 - 1
			$('#'+fr+'_chb5_nw_td'+no).empty().html("<select id='"+fr+"_sel_nw_b5ch"+no+"' name='"+fr+"_sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem("+fr1+",this.value,"+no+")' class='form-control chosen-select' data-placeholder='choose'><option selected value='0'>choose</option><option value='1'>1</option></select>");
		$('.chosen-select').chosen({width:'100%'});
				}
				else if(adlt_val==2 && ch512_val == 2)
				{// no b5
		$('#'+fr+'_chb5_nw_td'+no).empty().html("<input type='text' id='"+fr+"_sel_nw_b5ch"+no+"' name='"+fr+"_sel_nw_b5ch"+no+"' class='form-control tooltips' value='0'>");
				}else if(adlt_val==2 && ch512_val == 1)
				{//  b5 -1
				$('#'+fr+'_chb5_nw_td'+no).empty().html("<select id='"+fr+"_sel_nw_b5ch"+no+"' name='"+fr+"_sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem("+fr1+",this.value,"+no+")' class='form-control chosen-select' data-placeholder='choose'><option selected value='0'>choose</option><option value='1'>1</option></select>");
		$('.chosen-select').chosen({width:'100%'});
					
				}else if(adlt_val==2 && ch512_val == 0)
				{//  b5 -2
				$('#'+fr+'_chb5_nw_td'+no).empty().html("<select id='"+fr+"_sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem("+fr1+",this.value,"+no+")' name='"+fr+"_sel_nw_b5ch"+no+"' class='form-control chosen-select' data-placeholder='choose'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
		$('.chosen-select').chosen({width:'100%'});	
				}else if(adlt_val==1 && ch512_val == 3)
				{//  b5 - no
		$('#'+fr+'_chb5_nw_td'+no).empty().html("<input type='text' id='"+fr+"_sel_nw_b5ch"+no+"' name='"+fr+"_sel_nw_b5ch"+no+"' class='form-control tooltips' value='0'>");			
				}else if(adlt_val==1 && ch512_val == 2)
				{//  b5 - 1
				$('#'+fr+'_chb5_nw_td'+no).empty().html("<select id='"+fr+"_sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem("+fr1+",this.value,"+no+")' name='"+fr+"_sel_nw_b5ch"+no+"' class='form-control chosen-select' data-placeholder='choose'><option selected value='0'>choose</option><option value='1'>1</option></select>");
		$('.chosen-select').chosen({width:'100%'});
					
				}else if(adlt_val==1 && ch512_val == 1)
				{//  b5 - 2
				$('#'+fr+'_chb5_nw_td'+no).empty().html("<select id='"+fr+"_sel_nw_b5ch"+no+"' name='"+fr+"_sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem("+fr1+",this.value,"+no+")' class='form-control chosen-select' data-placeholder='choose'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
		$('.chosen-select').chosen({width:'100%'});		
				}else if(adlt_val==1 && ch512_val == 0)
				{//  b5 - 3
		$('#'+fr+'_chb5_nw_td'+no).empty().html("<select id='"+fr+"_sel_nw_b5ch"+no+"' name='"+fr+"_sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem("+fr1+",this.value,"+no+")' class='form-control chosen-select' data-placeholder='choose'> <option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>");
		$('.chosen-select').chosen({width:'100%'});		
				}
		}else if($('#num_chd_b5_'+fr)>0)
		{
			alert('for no 5-12 but with b5ch');
		}
		else{// else for no young child ( below 5 not chosen)
			for(var ki=1;ki<=num_new_rooms;ki++)
			{
				$('#'+fr+'_sel_nw_b5ch'+ki).removeAttr('data-original-title').attr('data-original-title','No need');
				$('.tooltips').tooltip();
			}
		}
}

function find_no_ch512_rem(fr,val,no)
{
	var fr1=fr;
		fr="br"+fr;
	var tt_ad_val, tt_ad_val1;
	var num_new_rooms=parseInt($("#num_room_htls_"+fr).val());
	var ch512_ttoll=$('#num_chd512_'+fr).val();	
		var no_nw=no+1;
		var jcnt=0;
		var cur_val=val;
		//alert("ch512"+$('#child512_no_cal').val());
		//alert($('#sel_adlt_nw'+no_nw).val());
		for(var dis=no_nw;dis<=num_new_rooms;dis++)
		{				
	$('#ch512_nw_td'+dis).empty().html("<input id='"+fr+"_sel_nw_512ch"+dis+"' name='"+fr+"_sel_nw_512ch"+dis+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
		//jcnt=jcnt+parseInt($('#sel_nw_512ch'+dis).val());
		}
		
		for(var prv=1;prv<no_nw;prv++)
		{
			//if(no!=prv)
			jcnt=jcnt+parseInt($('#'+fr+'_sel_nw_512ch'+prv).val());
		}
		$('#child_no_cal_'+fr).val(parseInt($('#num_chd512_'+fr).val())-jcnt);
		//alert("REM 512="+$('#child_no_cal_'+fr).val());
		
		//$('#child512_no_cal').val(parseInt($('#child512_no_cal').val())-parseInt(cur_val));
		
		if(num_new_rooms >= no_nw)
		{	
			
		if($('#'+fr+'_sel_adlt_nw'+no_nw).val()==3)
		{
			//alert("adu 3");
			if($('#child_no_cal_'+fr).val()>=1)
			{
        $('#'+fr+'_ch512_nw_td'+no_nw).empty().html("<select id='"+fr+"_sel_nw_512ch"+no_nw+"' name='"+fr+"_sel_nw_512ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5("+fr1+",this.value,"+no_nw+"); find_no_ch512_rem("+fr1+",this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
        $('.chosen-select').chosen({width:'100%'});
			}else{
				for(var rem_td=no_nw;rem_td<=num_new_rooms;rem_td++)
				{
				$('#'+fr+'_ch512_nw_td'+rem_td).empty().html("<input id='"+fr+"_sel_nw_512ch"+rem_td+"' name='"+fr+"_sel_nw_512ch"+rem_td+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	       $('.tooltips').tooltip();
				}
			}
			
		}else if($('#'+fr+'_sel_adlt_nw'+no_nw).val()==2)
		{
			//alert("adu 2");
			if($('#child_no_cal_'+fr).val()>=2)
			{
				$('#'+fr+'_ch512_nw_td'+no_nw).empty().html("<select id='"+fr+"_sel_nw_512ch"+no_nw+"' name='"+fr+"_sel_nw_512ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5("+fr1+",this.value,"+no_nw+"); find_no_ch512_rem("+fr1+",this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
				$('.chosen-select').chosen({width:'100%'});
				//$('#child512_no_cal').val(parseInt($('#child512_no_cal').val())-parseInt(cur_val));
			}else if($('#child_no_cal_'+fr).val()>=1)
			{
				$('#'+fr+'_ch512_nw_td'+no_nw).empty().html("<select id='"+fr+"_sel_nw_512ch"+no_nw+"' name='"+fr+"_sel_nw_512ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5("+fr1+",this.value,"+no_nw+"); find_no_ch512_rem("+fr1+",this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
				$('.chosen-select').chosen({width:'100%'});
				//$('#child512_no_cal').val(parseInt($('#child512_no_cal').val())-parseInt(cur_val));
			}else{ //$('#child512_no_cal').val() ==0
				for(var rem_td=no_nw;rem_td<=num_new_rooms;rem_td++)
				{
				$('#'+fr+'_ch512_nw_td'+rem_td).empty().html("<input id='"+fr+"_sel_nw_512ch"+rem_td+"' name='"+fr+"_sel_nw_512ch"+rem_td+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
				}
			}
			
		}else if($('#'+fr+'_sel_adlt_nw'+no_nw).val()==1)
		{
			//alert("adu 1");
			if($('#child_no_cal_'+fr).val()>=3)
			{
				$('#'+fr+'_ch512_nw_td'+no_nw).empty().html("<select id='"+fr+"_sel_nw_512ch"+no_nw+"' name='"+fr+"_sel_nw_512ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5("+fr1+",this.value,"+no_nw+"); find_no_ch512_rem("+fr1+",this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>");
				$('.chosen-select').chosen({width:'100%'});
				//$('#child512_no_cal').val(parseInt($('#child512_no_cal').val())-parseInt(cur_val));
			}
			else if($('#'+fr+'_child512_no_cal').val()>=2)
			{
				$('#ch512_nw_td'+no_nw).empty().html("<select id='"+fr+"_sel_nw_512ch"+no_nw+"' name='"+fr+"_sel_nw_512ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5("+fr1+",this.value,"+no_nw+"); find_no_ch512_rem("+fr1+",this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
				$('.chosen-select').chosen({width:'100%'});
				//$('#child512_no_cal').val(parseInt($('#child512_no_cal').val())-parseInt(cur_val));
			}else if($('#'+fr+'_child512_no_cal').val()>=1)
			{
				//alert('#ch512_nw_td'+no_nw);
				$('#ch512_nw_td'+no_nw).empty().html("<select id='"+fr+"_sel_nw_512ch"+no_nw+"' name='"+fr+"_sel_nw_512ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5("+fr1+",this.value,"+no_nw+"); find_no_ch512_rem("+fr1+",this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
				$('.chosen-select').chosen({width:'100%'});
				//$('#child512_no_cal').val(parseInt($('#child512_no_cal').val())-parseInt(cur_val));
			}else{ //$('#child512_no_cal').val() ==0
				for(var rem_td=no_nw;rem_td<=num_new_rooms;rem_td++)
				{
				$('#'+fr+'_ch512_nw_td'+rem_td).empty().html("<input id='"+fr+"_sel_nw_512ch"+rem_td+"' name='"+fr+"_sel_nw_512ch"+rem_td+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
				}
			}
			
		}else if($('#'+fr+'_sel_adlt_nw'+no_nw).val()==0)
		{
			//alert("adu 0");
			//alert("CNC="+$('#child_no_cal_'+fr).val());
			if($('#child_no_cal_'+fr).val()>=3)
			{
				$('#ch512_nw_td'+no_nw).empty().html("<select id='"+fr+"_sel_nw_512ch"+no_nw+"' name='"+fr+"_sel_nw_512ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5("+fr1+",this.value,"+no_nw+"); find_no_ch512_rem("+fr1+",this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>");
				$('.chosen-select').chosen({width:'100%'});
				//$('#child512_no_cal').val(parseInt($('#child512_no_cal').val())-parseInt(cur_val));
			}
			else if($('#child_no_cal_'+fr).val()>=2)
			{
				$('#ch512_nw_td'+no_nw).empty().html("<select id='"+fr+"_sel_nw_512ch"+no_nw+"' name='"+fr+"_sel_nw_512ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5("+fr1+",this.value,"+no_nw+"); find_no_ch512_rem("+fr1+",this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
				$('.chosen-select').chosen({width:'100%'});
				//$('#child512_no_cal').val(parseInt($('#child512_no_cal').val())-parseInt(cur_val));
			}else if($('#child_no_cal_'+fr).val()>=1)
			{
				$('#'+fr+'_ch512_nw_td'+no_nw).empty().html("<select id='"+fr+"_sel_nw_512ch"+no_nw+"' name='"+fr+"_sel_nw_512ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5("+fr1+",this.value,"+no_nw+"); find_no_ch512_rem("+fr1+",this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
				$('.chosen-select').chosen({width:'100%'});
				//$('#child512_no_cal').val(parseInt($('#child512_no_cal').val())-parseInt(cur_val));
			}else{ //$('#child512_no_cal').val() ==0
				for(var rem_td=no_nw;rem_td<=num_new_rooms;rem_td++)
				{
				$('#'+fr+'_ch512_nw_td'+rem_td).empty().html("<input id='"+fr+"_sel_nw_512ch"+rem_td+"' name='"+fr+"_sel_nw_512ch"+rem_td+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
				}
			}
			
		}
		}//outer if
}




function find_chbelow5_rem(fr,val,no)
{
	//alert(val+'_'+no);
	var fr1=fr;
	fr="br"+fr;
	
	var tt_ad_val, tt_ad_val1;
	var num_new_rooms=parseInt($("#num_room_htls_"+fr).val());
	var chb5_ttoll=$('#num_chd_b5_'+fr).val();	
		var no_nw=no+1;
		var jcnt=0;
		var cur_val=val;
		//alert("ch512"+$('#child512_no_cal').val());
		//alert($('#sel_adlt_nw'+no_nw).val());
		for(var dis=no_nw;dis<=num_new_rooms;dis++)
		{				
	$('#'+fr+'_chb5_nw_td'+dis).empty().html("<input id='"+fr+"_sel_nw_b5ch"+dis+"' name='"+fr+"_sel_nw_b5ch"+dis+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
		//jcnt=jcnt+parseInt($('#sel_nw_512ch'+dis).val());
		}
		
		for(var prv=1;prv<no_nw;prv++)
		{
		jcnt=jcnt+parseInt($('#'+fr+'_sel_nw_b5ch'+prv).val());
		}
		$('#child_no_cal_'+fr).val(parseInt($('#num_chd_b5_'+fr).val())-jcnt);
		
		
		//$('#child512_no_cal').val(parseInt($('#child512_no_cal').val())-parseInt(cur_val));
		
if(num_new_rooms >= no_nw)
{	
		if($('#'+fr+'_sel_adlt_nw'+no_nw).val()==3)
		{
			if($('#'+fr+'_sel_nw_512ch'+no_nw).val()==1)
			{ //alert("adl 3 - c512h 1");
				
			$('#'+fr+'_chb5_nw_td'+no_nw).empty().html("<input id='"+fr+"_sel_nw_b5ch"+no_nw+"' name='"+fr+"_sel_nw_b5ch"+no_nw+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
			//no b5	
			}else{
				//alert("adl 3 - c512h 0");
			//1 -b5	
					if($('#child_no_cal_'+fr).val()>=1)
					{
			$('#'+fr+'_chb5_nw_td'+no_nw).empty().html("<select id='"+fr+"_sel_nw_b5ch"+no_nw+"' name='"+fr+"_sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem("+fr1+",this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
$('.chosen-select').chosen({width:'100%'});
					}else{
						//no need for
							for( var ui=no_nw; ui<=num_new_rooms; ui++)
							{
						$('#'+fr+'_chb5_nw_td'+ui).empty().html("<input id='"+fr+"_sel_nw_b5ch"+ui+"' name='"+fr+"_sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
							}
					}
			}
			
		}else if($('#'+fr+'_sel_adlt_nw'+no_nw).val()==2)
		{
			if($('#'+fr+'_sel_nw_512ch'+no_nw).val()==2)
			{
				//alert("adl 2 - c512h 2");
				if($('#child_no_cal_'+fr).val()>=1)
				{
				$('#'+fr+'_chb5_nw_td'+no_nw).empty().html("<input id='"+fr+"_sel_nw_b5ch"+no_nw+"' name='"+fr+"_sel_nw_b5ch"+no_nw+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
				}else{
						for( var ui=no_nw; ui<=num_new_rooms; ui++)
						{
						$('#'+fr+'_chb5_nw_td'+ui).empty().html("<input id='"+fr+"_sel_nw_b5ch"+ui+"' name='"+fr+"_sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
						}
				//no need for	
				}
				
			//no b5	
			}else if($('#'+fr+'_sel_nw_512ch'+no_nw).val()==1)
			{
				//alert("adl 2 - c512h 1");
				if($('#child_no_cal_'+fr).val()>=1)
				{
					$('#'+fr+'_chb5_nw_td'+no_nw).empty().html("<select id='"+fr+"_sel_nw_b5ch"+no_nw+"' name='"+fr+"_sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem("+fr1+",this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
$('.chosen-select').chosen({width:'100%'});
				}else{
					//no need for
						for( var ui=no_nw; ui<=num_new_rooms; ui++)
						{
						$('#'+fr+'_chb5_nw_td'+ui).empty().html("<input id='"+fr+"_sel_nw_b5ch"+ui+"' name='"+fr+"_sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
						}
				}
				//1-b5
			}else{
				//alert("adl 2 - c512h 0");
					if($('#child_no_cal_'+fr).val()>=2)
					{
					$('#'+fr+'_chb5_nw_td'+no_nw).empty().html("<select id='"+fr+"_sel_nw_b5ch"+no_nw+"' name='"+fr+"_sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem("+fr1+",this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
$('.chosen-select').chosen({width:'100%'});
					}else if($('#child_no_cal_'+fr).val()>=1)
					{
						$('#'+fr+'_chb5_nw_td'+no_nw).empty().html("<select id='"+fr+"_sel_nw_b5ch"+no_nw+"' name='"+fr+"_sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem("+fr1+",this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
$('.chosen-select').chosen({width:'100%'});
					}else{
						//no need for
							for( var ui=no_nw; ui<=num_new_rooms; ui++)
							{
						$('#'+fr+'_chb5_nw_td'+ui).empty().html("<input id='"+fr+"_sel_nw_b5ch"+ui+"' name='"+fr+"_sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
							}
					}
				//2-b5
			}
		}else if($('#'+fr+'_sel_adlt_nw'+no_nw).val()==1)
		{
			if($('#'+fr+'_sel_nw_512ch'+no_nw).val()==3)
			{
				//alert("adl 1 - c512h 3");
					if($('#child_no_cal_'+fr).val()>=1)
					{

				$('#'+fr+'_chb5_nw_td'+no_nw).empty().html("<input id='"+fr+"_sel_nw_b5ch"+no_nw+"' name='"+fr+"_sel_nw_b5ch"+no_nw+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
					}else{
					//no need for	
							for( var ui=no_nw; ui<=num_new_rooms; ui++)
							{
						$('#'+fr+'_chb5_nw_td'+ui).empty().html("<input id='"+fr+"_sel_nw_b5ch"+ui+"' name='"+fr+"_sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
							}
					}
			//no b5	
			}else if($('#'+fr+'_sel_nw_512ch'+no_nw).val()==2)
			{
				//alert("adl 1 - c512h 2");
					if($('#child_no_cal_'+fr).val()>=1)
					{
						$('#'+fr+'_chb5_nw_td'+no_nw).empty().html("<select id='"+fr+"_sel_nw_b5ch"+no_nw+"' name='"+fr+"_sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem("+fr1+",this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
$('.chosen-select').chosen({width:'100%'});
					}else{
						//no need for
							for( var ui=no_nw; ui<=num_new_rooms; ui++)
							{
						$('#'+fr+'_chb5_nw_td'+ui).empty().html("<input id='"+fr+"_sel_nw_b5ch"+ui+"' name='"+fr+"_sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
							}
					}
				//1-b5
			}else if($('#'+fr+'_sel_nw_512ch'+no_nw).val()==1)
			{
				//alert("adl 1 - c512h 1");
					if($('#child_no_cal_'+fr).val()>=2)
					{
						$('#'+fr+'_chb5_nw_td'+no_nw).empty().html("<select id='"+fr+"_sel_nw_b5ch"+no_nw+"' name='"+fr+"_sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem("+fr1+",this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
$('.chosen-select').chosen({width:'100%'});
					}else if($('#child_no_cal_'+fr).val()>=1)
					{
						$('#'+fr+'_chb5_nw_td'+no_nw).empty().html("<select id='"+fr+"_sel_nw_b5ch"+no_nw+"' name='"+fr+"_sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem("+fr1+",this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
$('.chosen-select').chosen({width:'100%'});
					}else{
					// no need for
						for( var ui=no_nw; ui<=num_new_rooms; ui++)
						{
						$('#'+fr+'_chb5_nw_td'+ui).empty().html("<input id='"+fr+"_sel_nw_b5ch"+ui+"' name='"+fr+"_sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
						}	
					}
				//2-b5
			}else{
				//alert("adl 1 - c512h 0");
						if($('#child_no_cal_'+fr).val()>=3)
						{
						$('#'+fr+'_chb5_nw_td'+no_nw).empty().html("<select id='"+fr+"sel_nw_b5ch"+no_nw+"' name='"+fr+"sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem("+fr1+",this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>");
$('.chosen-select').chosen({width:'100%'});
						}else if($('#child_no_cal_'+fr).val()>=2)
						{
						$('#'+fr+'_chb5_nw_td'+no_nw).empty().html("<select id='"+fr+"_sel_nw_b5ch"+no_nw+"' name='"+fr+"_sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem("+fr1+",this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
$('.chosen-select').chosen({width:'100%'});
						}else if($('#child_no_cal_'+fr).val()>=1)
						{
						$('#'+fr+'_chb5_nw_td'+no_nw).empty().html("<select id='"+fr+"_sel_nw_b5ch"+no_nw+"' name='"+fr+"_sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem("+fr1+",this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
$('.chosen-select').chosen({width:'100%'});
						}else
						{
						// no need for
							for( var ui=no_nw; ui<=num_new_rooms; ui++)
							{
						$('#'+fr+'_chb5_nw_td'+ui).empty().html("<input id='"+fr+"_sel_nw_b5ch"+ui+"' name='"+fr+"_sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
							}	
						}
				//3-b5
			}
			
		}else if($('#'+fr+'_sel_adlt_nw'+no_nw).val()==0)
		{
			if($('#'+fr+'_sel_nw_512ch'+no_nw).val()==3)
			{
				//alert("adl 0 - c512h 3");
				if($('#child_no_cal_'+fr).val()>=1)
				{
				$('#'+fr+'_chb5_nw_td'+no_nw).empty().html("<select id='"+fr+"_sel_nw_b5ch"+no_nw+"' name='"+fr+"_sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem("+fr1+",this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
$('.chosen-select').chosen({width:'100%'});
				}else{
				// no need for	
					for( var ui=no_nw; ui<=num_new_rooms; ui++)
					{
						$('#'+fr+'_chb5_nw_td'+ui).empty().html("<input id='"+fr+"_sel_nw_b5ch"+ui+"' name='"+fr+"_sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
					}
				}
			//1 b5	
			}else if($('#'+fr+'_sel_nw_512ch'+no_nw).val()==2)
			{
				//alert("adl 0 - c512h 2");
				if($('#child_no_cal_'+fr).val()>=2)
				{
				$('#'+fr+'_chb5_nw_td'+no_nw).empty().html("<select id='"+fr+"_sel_nw_b5ch"+no_nw+"' name='"+fr+"_sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem("+fr1+",this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
$('.chosen-select').chosen({width:'100%'});
				}else if($('#child_no_cal_'+fr).val()>=1)
				{
				$('#'+fr+'_chb5_nw_td'+no_nw).empty().html("<select id='"+fr+"_sel_nw_b5ch"+no_nw+"' name='"+fr+"_sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem("+fr1+",this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
$('.chosen-select').chosen({width:'100%'});	
				}else{
					// no need for
						for( var ui=no_nw; ui<=num_new_rooms; ui++)
						{
						$('#'+fr+'_chb5_nw_td'+ui).empty().html("<input id='"+fr+"_sel_nw_b5ch"+ui+"' name='"+fr+"_sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
						}
				}
				//2-b5
			}else if($('#'+fr+'_sel_nw_512ch'+no_nw).val()==1)
			{
				//alert("adl 0 - c512h 1");
				if($('#child_no_cal_'+fr).val()>=3)
				{
				$('#'+fr+'_chb5_nw_td'+no_nw).empty().html("<select id='"+fr+"_sel_nw_b5ch"+no_nw+"' name='"+fr+"_sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem("+fr1+",this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>");
$('.chosen-select').chosen({width:'100%'});
				}else if($('#child_no_cal_'+fr).val()>=2)
				{
						$('#'+fr+'_chb5_nw_td'+no_nw).empty().html("<select id='"+fr+"_sel_nw_b5ch"+no_nw+"' name='"+fr+"_sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem("+fr1+",this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
$('.chosen-select').chosen({width:'100%'});
				}else if($('#child_no_cal_'+fr).val()>=1)
				{
						$('#'+fr+'_chb5_nw_td'+no_nw).empty().html("<select id='"+fr+"_sel_nw_b5ch"+no_nw+"' name='"+fr+"_sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem("+fr1+",this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
$('.chosen-select').chosen({width:'100%'});
				}else
				{
				//no need for	
					for( var ui=no_nw; ui<=num_new_rooms; ui++)
					{
						$('#'+fr+'_chb5_nw_td'+ui).empty().html("<input id='"+fr+"_sel_nw_b5ch"+ui+"' name='"+fr+"_sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
					}
				}
				//3-b5
			}else{
				//alert("adl 0 - c512h 0");
				if($('#child_no_cal_'+fr).val()>=1)
				{
				$('#'+fr+'_chb5_nw_td'+no_nw).empty().html("<input id='"+fr+"_sel_nw_b5ch"+no_nw+"' name='"+fr+"_sel_nw_b5ch"+no_nw+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
				}else{
				//no need for
					for( var ui=no_nw; ui<=num_new_rooms; ui++)
					{
						$('#'+fr+'_chb5_nw_td'+ui).empty().html("<input id='"+fr+"_sel_nw_b5ch"+ui+"' name='"+fr+"_sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
					}
				}
				//no-b5
			}
		}
}//outer if
		
}
_

function houseboat_editable(hid,ctg,no,fr,sno)
{
   //alert(hid+' - '+ctg+' - '+no+' - '+sno);
   if(typeof sno === 'undefined'){
	   alert('Hello choosing house boat is very simple. choose \nUpto 3 paxs sharing one room please select 1 bed room house boat\n For 4 paxs please 2 bed room house boat\n For 6 paxs please 3 bed room house boat\n  For 8 paxs please 4 bed room house boat\n For 10 paxs please 5 bed room house boat\n ');
   }
   
    var datastring = $("#ExampleBootstrapValidationForm").serialize();
        $('.loader_ax').fadeIn();
        $.ajax({
            type :"POST",
            data:datastring,
            url:"AGENT/dvi_sugg_hotel_edit.php?edit_ctg="+ctg+"&edit_hid="+hid+"&edit_no="+no+"&edit_fr="+fr+"&sno="+sno,
            success: function(res){
               //alert(res);
                    $('.loader_ax').fadeOut();
                    $('#catg_tab_'+ctg).empty().html(res);
                    $('.chosen-select').chosen({width:'100%'});
                }
            });
}

function alertopt()
{
	//swal("Dear Agent, \n Great!!! you have created a better itnerary, hence you can go ahead with your own itinerary  !!!! \n\n Best regards - DVI Team");
}


function show_get_quote()
{
	$('#final_save_btn').show();
	//alert("div"+$('#check_boxs').val());
	//$('#tableee').hide();
	//$('#get_sts_quote').hide();
	if($('#check_boxss_br0').val() !='2')
	{
		$('#show_stay_quote').show();
		if($('#check_boxss_br0').val() =='1')
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
}


function resume_later(ss)
{
    var cplan=$('#sub_planid').val().split('#');
    var datastring = $("#ExampleBootstrapValidationForm").serialize();
        $('.loader_ax').fadeIn();
        $.ajax({
            type :"POST",
            data:datastring,
            url:"AGENT/ajax_agent.php?type=29",
            success: function(res){
               // alert(res);
                   cont_trv=$('#det_rep').html();
                    cont_htl=$('#load_div_sugg_quote').html();
                    //alert("hotel  "+cont_htl);
        $.post('AGENT/ajax_mail.php?type=2', { content_tvl: cont_trv , content_htl: cont_htl },function(con){ 
        //alert(con);
        });
                    alert('This itinerary plan will be resume later , Reference ID : '+$('#sub_planid').val());
                    location.reload();
                }
            });
        
}

function addi_cost_toggle_click()
{
    if($('#addi_cost_load_div').children().length == 0)
    {
        var datastring = $("#ExampleBootstrapValidationForm").serialize();
        $('.loader_ax').fadeIn();
        $.ajax({
            type :"POST",
            data:datastring,
            url:"AGENT/ajax_addi_cost.php?type=1",
            success: function(addi_res){
                        $('.loader_ax').fadeOut(500);
                        $('#addi_cost_load_div').empty().html(addi_res);
                        $('.chosen-select').chosen({width:'100%'});
                        $('#addi_cost_load_div').slideToggle(600);
                }
            });
    }else{
         $('#addi_cost_load_div').slideToggle(600);
    }
}

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
   // alert('go_with_add_ons');
    var datastring = $("#ExampleBootstrapValidationForm").serialize();
        $('.loader_ax').fadeIn();
        $.ajax({
            type: "POST",
            url: "AGENT/ajax_addi_cost.php?type=3",
            data: datastring,
            success: function(res)
            {
               // alert(res);
                if($('#check_boxss_br0').val() == '2')
                {
                        $.get('AGENT/itin_submit_trav_report.php',function(result)
                        {
                             $('.loader_ax').fadeOut(500);
                            // alert(result);
                             $('#det_rep').empty().html(result);
                             //$('#Travel_info_mod').modal('show');
                        });
                }else if($('#check_boxss_br0').val() == '1')
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

function back_to_stay()
{
    $('#Travel_info_mod').hide();
    $('#init_boxx').hide();
    $('#secondary_boxx').fadeIn();
}

function parseDate(str) 
{

   //var mdy = str.split('-')
    //return new Date(mdy[1], mdy[0]-1, mdy[2]);
    return new Date(str); 
}
function daydiff(first, second) 
{

    return Math.round((second-first)/(1000*60*60*24));
}

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

function only_number(n)
{
	 $('#addi_persons'+n).val($('#addi_persons'+n).val().replace(/[^0-9\.]/g,''));
	  if ((event.which != 46) && (event.which < 48 || event.which > 57)){
                event.preventDefault();
            }
}

var ndval;

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

function validate_stay(fr)
{
	alert('validate_stay()');
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

function view_stay_quote(fr,agnt_percnt,adm_brk_per)
{}

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









function trans_hotel()
{
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



function validate()
{
	if ($('#guestname').val() == '' || $('#mobil').val() == '' || $('#arrdet').val() == '' || $('#depdet').val() == '') 
	{
		$('#formerr').text("Please enter all the fields below..").show();
		return false;
	}
	return true;
}

function alertdist(distdiff)
{
	var alerdist = distdiff.split('-');
	if(alerdist[3].trim() > 175)
	{
		swal( "NOTE - The distance to your chosen departure airport/railway-station is "+alerdist[3].trim()+" kms. Hence request you to organize your travel accordingly for your smooth onward journey!");
	}
}


function alertdt(allow_cnt, dt_cit)
{
	alert("Dear <?php echo $user_fname; ?>, Only "+allow_cnt+" daytrip city allowed for "+dt_cit+".\n Please deselect the other cities");
	//swal("Dear <?php echo $user_fname; ?>, Only "+allow_cnt+" daytrip city allowed for "+dt_cit+".\n Please deselect the other cities");
}

function hidesave()
{
	$('#final_save_btn').hide();
}

function close_dropdown(nos)
{
		$('#via_indiv'+nos).hide();
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
			alert(gnamme+' - Itinerary Plan Successfully Sent To Administrator');
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


function backto_init_boxx()
{
	$('#trhotl_pms').hide();
	$('#trhotl_pms1').show();
	$('#secondary_boxx').hide();
	$('#init_boxx').fadeIn();
	$('#Travel_info_mod').modal('show');
}



</script>