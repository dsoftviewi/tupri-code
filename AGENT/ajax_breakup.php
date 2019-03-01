<?php
require_once('../Connections/divdb.php');
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
//make next breakup
if(isset($_GET['type']) && $_GET['type']==1)
{ 
	$frm=trim($_POST['tot_num_of_form']);
	$check_box_br0=trim($_POST['check_boxss_br0']);
?>
     <div class="col-sm-12"  style="margin-top:15px;">
                    <div id="breakup_main_br<?php echo $frm; ?>"  onclick="breakup_toggle_click('br<?php echo $frm; ?>')" style="border:1px solid #3EAFDB; padding:6px; background-color:#E0F8FF; text-align:center; display:none; cursor:pointer" > 
                    <strong id="toggle_title_br<?php echo $frm; ?>" class="flashit" style="color:#0184AB; background-color:#E0F8FF"><i class="fa fa-minus "></i>&nbsp;Created Itinerary [ 02-Feb-2015 to 25-Feb-2015 ]</strong></div>
                    </div>
                        <div class="col-sm-12" id="breakup_sub_br<?php echo $frm; ?>">
                        <div class="col-sm-4" style=" background-color:rgb(239, 251, 255); border:1px solid rgb(172, 232, 255);">
                        	<table width="100%">
                            <tr><th colspan="3" style="text-align:center; color:#206682">Fill Out Below Details</th></tr>
                            <tr><td colspan="3"><hr style="margin-top:5px; margin-bottom:5px"></td></tr>
                            <tr><td width="58%" ><label class="control-label">No. Of Adults</label></td><td width="3%">:</td><td width="39%"><input class="form-control che_numb" type="number"  min="1" max="100" name="num_traveller_br<?php echo $frm; ?>" id="num_traveller_br<?php echo $frm; ?>" value="<?php echo  $_POST['num_traveller_br0']; ?>">
                            <input type="hidden" value="<?php echo  $_POST['num_traveller_br0']; ?>" id="adult_no_cal_br<?php echo $frm; ?>" name="adult_no_cal_br<?php echo $frm; ?>"></td></tr>
                             <tr><td colspan="3">&nbsp;</td></tr>
                            <tr><td><label class="control-label">No. Of Children <small>(5-12 age)</small></label></td><td>:</td><td><input type="number"  min="0" max="25"  class="form-control che_numb" name="num_chd512_br<?php echo $frm; ?>" id="num_chd512_br<?php echo $frm; ?>" value="<?php echo  $_POST['num_chd512_br0']; ?>">
                            <input type="hidden" value="<?php echo  $_POST['num_chd512_br0']; ?>" id="child512_no_cal_br<?php echo $frm; ?>" name="child512_no_cal_br<?php echo $frm; ?>">
                           </td></tr>
                             <tr><td colspan="3">&nbsp;</td></tr>
                            <tr><td><label class="control-label">No. Of Babies <small>( below 5 age)</small></label></td><td>:</td><td><input type="number"  min="0" max="25" class="form-control che_numb" name="num_chd_b5_br<?php echo $frm; ?>" id="num_chd_b5_br<?php echo $frm; ?>" value="<?php echo  $_POST['num_chd_b5_br0']; ?>">
                             <input type="hidden" value="<?php echo  $_POST['num_chd_b5_br0']; ?>" id="child_no_cal_br<?php echo $frm; ?>" name="child_no_cal_br<?php echo $frm; ?>"></td></tr>
                             <tr><td colspan="3">&nbsp;</td></tr>
                             <tr><td><label class="control-label">Travelling Days</label></td><td>:</td><td><input type="number"  min="2" max="100" class="form-control che_numb" name="num_tradays_br<?php echo $frm; ?>" id="num_tradays_br<?php echo $frm; ?>" value="<?php echo  $_POST['num_tradays_br0']; ?>" onchange="fun_chang_days('<?php echo 'br'.$frm; ?>',this.value)"></td></tr>
                             <tr><td colspan="3">&nbsp;</td></tr>
                             <tr><td><label class="control-label">Travelling Nights</label></td><td>:</td><td><input type="number"  min="1" max="100" class="form-control che_numb" name="num_tranight_br<?php echo $frm; ?>" id="num_tranight_br<?php echo $frm; ?>" value="<?php echo  $_POST['num_tranight_br0']; ?>" onchange="fun_chang_nights('<?php echo 'br'.$frm; ?>',this.value)"></td></tr>
                            <!-- <tr><td colspan="3">&nbsp;</td></tr>-->
                             <?php
							 $raval=0;
							  if($check_box_br0=='1'){?>
                             <tr id="no_of_rooms_tr_br<?php echo $frm; ?>" style=""><td><label class="control-label" style="margin-top: 7px;">No. Of Rooms</label></td><td>:</td><td><input type="number" class="form-control che_numb" name="num_room_htls_br<?php echo $frm; ?>" id="num_room_htls_br<?php echo $frm; ?>" value="<?php echo  $_POST['num_room_htls_br0']; ?>" style="margin-top: 15px;"></td></tr>
                             <?php $raval++; } ?>
                             <tr><td colspan="3">&nbsp;</td></tr>
                            </table>
                        </div>
                         <div class="col-sm-8" style="padding-left:2px; padding-right:2px;" >
                         <div id="iti_det_div_br<?php echo $frm; ?>" style="border:#ADD3FF 1px solid; background-color:#F9FCFD; min-height: 320px;"> 
                         <div class="col-sm-12" align="center" style="margin-top: 10px;"><label class="control-label"> Itinerary Details</label></div>
                         <div class="col-sm-12" style="margin-top: 10px;">
                                    <label class="control-label col-sm-4" >Arrival Date & Time : </label>
                                        <div class="col-sm-4">
                                        <div class="input-group">
                          <span class="input-group-addon add-on tooltips" data-toggle='tooltip' data-original-title="Arrival Date"><i class="fa fa-calendar"></i></span>
                                     <input type="text" class="form-control datepickerz  tooltips" data-original-title='Choose Date' data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" name="arrdate_br<?php echo $frm; ?>" id="arrdate_br<?php echo $frm; ?>"  readonly style="  width: 100%;"></div>
                                     </div>
                                     <div class="col-sm-4">
                                     <div class="input-group">
                                      <span class="input-group-addon add-on tooltips" data-toggle='tooltip' data-original-title="Arrival Time"><i class="fa fa-clock-o"></i></span>
                                 <input type="text" class="form-control timepickera" name="arrtime_br<?php echo $frm; ?>" id="arrtime_br<?php echo $frm; ?>" readonly style="  width: 100%;">
                                        </div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-12"  style="margin-top: 15px;">
                                    <label class="control-label col-sm-4" >Departure Date & Time</label>
                                        <div class="col-sm-4">
                                        <div class="input-group">
                                        <span class="input-group-addon add-on tooltips" data-toggle='tooltip' data-original-title="Departure Date"><i class="fa fa-calendar-o"></i></span>
                                     <input type="text" class="form-control tooltips" placeholder="Dept.Date" data-original-title='No need to choose' name="depart_ddat_br<?php echo $frm; ?>" id="depart_ddat_br<?php echo $frm; ?>" readonly ></div>
                                     </div>
                                     <div class="col-sm-4">
                                     <div class="input-group">
                                      <span class="input-group-addon add-on tooltips" data-toggle='tooltip' data-original-title="Departure Time"><i class="fa fa-clock-o"></i></span>
                              <input type="text" class="form-control timepickera2 "  name="depart_time_br<?php echo $frm; ?>" id="depart_time_br<?php echo $frm; ?>"  style="width: 100%;">
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

<select class="form-control chosen-select" id="br<?php echo $frm; ?>_st_city0" name="br<?php echo $frm; ?>_st_city0" tabindex="2" onChange="getvehicles('br<?php echo $frm; ?>',this.value)">
	<option value="">-- Select Orgin Point --</option>
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
                                <input type="hidden" id="br<?php echo $frm; ?>_vehdiv" name="br<?php echo $frm; ?>_vehdiv" value="0" />
                                <div class="col-sm-12" style="margin-top:15px">
                                <center><small class="help-block" id="br<?php echo $frm; ?>_seaterr" style='display:none;color:#E9573F;'></small></center>
                                    <label class="control-label col-sm-4" >Select Vehicle</label>
                                    <div class="col-sm-6">
                                   <div id="br<?php echo $frm; ?>_load_vehicl"><input type="text" value="Please Select Above City" class="form-control" readonly></div>
                                    </div>
                                    <div class="col-sm-2">
                                        <a data-toggle="tooltip" title="Add 1 more vehicle" class="btn btn-default tooltips" id="br<?php echo $frm; ?>_addrow" style="display:none" onClick="get_extra_vehicle('br<?php echo $frm; ?>','1')"><i class="fa fa-plus" style="color:#3EAFDB"></i></a>
                                    </div>
                                    </div>
                                    <div id="br<?php echo $frm; ?>_vehlist"></div>
                                    <a style="color:#FFF">.</a>
                                    </div>
                                    <div style="border:1px solid #CFE1EF; background-color:#EFFBFF" align="center">
                                    <button type="button" class="btn btn-sm btn-info" style="margin-top: 6px;margin-bottom: 7px;" onClick="make_itinerary('br<?php echo $frm; ?>')">Make Itinerary</button> 
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <button type="button" class="btn btn-sm btn-danger" style="margin-top: 6px;margin-bottom: 7px;" onClick="remove_this_breakstay('br<?php echo $frm; ?>','<?php echo $frm; ?>')">Remove Itinerary</button> 
                                    </div>
                         </div>
                         
                         <div class="col-sm-12" id="make_itinerary_div_br<?php echo $frm; ?>" style=" margin-top:10px;"></div>
                         
                         <input type="hidden" id="br<?php echo $frm; ?>_kit_kat" value=""  />
                            <input type="hidden" id="br<?php echo $frm; ?>_kit_cityidd" name="br<?php echo $frm; ?>_kit_cityidd" value=""  />
                            <input type="hidden" id="br<?php echo $frm; ?>_kit_cityidd_prev" name="br<?php echo $frm; ?>_kit_cityidd_prev" value=""  />
                            <input type="hidden" value="0" name="br<?php echo $frm; ?>_traveldist" id="br<?php echo $frm; ?>_traveldist" />
                            <input type="hidden" value="0" name="br<?php echo $frm; ?>_traveldist_ess" id="br<?php echo $frm; ?>_traveldist_ess" />
                            <input type="hidden" value="0" name="br<?php echo $frm; ?>_day_traveldist" id="br<?php echo $frm; ?>_day_traveldist" />
                            <input type="hidden" value="0" name="br<?php echo $frm; ?>_day_travdist_ess" id="br<?php echo $frm; ?>_day_travdist_ess" />
                            <input type="hidden" value="0" name="br<?php echo $frm; ?>_dt_dist" id="br<?php echo $frm; ?>_dt_dist" />
                            <input type="hidden" value="0" name="br<?php echo $frm; ?>_dt_alssdist" id="br<?php echo $frm; ?>_dt_alssdist" />
                            <input type="hidden" value="0" name="br<?php echo $frm; ?>_dt_altrdist" id="br<?php echo $frm; ?>_dt_altrdist" />
                            <input type="hidden" value="" name="br<?php echo $frm; ?>_dt_citid" id="br<?php echo $frm; ?>_dt_citid" />
                            <input type="hidden" value="" name="br<?php echo $frm; ?>_dt_detls" id="br<?php echo $frm; ?>_dt_detls" />
                            <input type="hidden" value="0" name="br<?php echo $frm; ?>_trv_cnt" id="br<?php echo $frm; ?>_trv_cnt" />
                            <input type="hidden" value="0" name="br<?php echo $frm; ?>_trv_days" id="br<?php echo $frm; ?>_trv_days" />
                            <input type="hidden" value="0" name="br<?php echo $frm; ?>_trv_nights" id="br<?php echo $frm; ?>_trv_nights" />
                            <input type="hidden" value="0" name="br<?php echo $frm; ?>_trv_adult" id="br<?php echo $frm; ?>_trv_adult" />
                            <input type="hidden" value="0" name="br<?php echo $frm; ?>_trv_child" id="br<?php echo $frm; ?>_trv_child" />
                            <input type="hidden" value="0" name="br<?php echo $frm; ?>_trv_room" id="br<?php echo $frm; ?>_trv_room" />
                            <input type="hidden" value="" id="br<?php echo $frm; ?>_vehicles" name="br<?php echo $frm; ?>_vehicles[]" />
                            <input type="hidden" value="" id="br<?php echo $frm; ?>_dest_id" name="br<?php echo $frm; ?>_dest_id" />
                            <input type='hidden' name='br<?php echo $frm; ?>_ret_dist' id='br<?php echo $frm; ?>_ret_dist' value=0>
                            <input type='hidden' name='br<?php echo $frm; ?>_tr_tot_amt' id='br<?php echo $frm; ?>_tr_tot_amt' value=0>
                            <input type='hidden' name='br<?php echo $frm; ?>_pervehamt' id='br<?php echo $frm; ?>_pervehamt' value=0>
                            <input type='hidden' name='br<?php echo $frm; ?>_vehcitid' id='br<?php echo $frm; ?>_vehcitid' value=''>
                            <input type='hidden' name='br<?php echo $frm; ?>_permt_amt' id='br<?php echo $frm; ?>_permt_amt' value=0>
                            <input type='hidden' name='br<?php echo $frm; ?>_citydata[]' id='br<?php echo $frm; ?>_citydata' value=''>
                            <input type='hidden' name='br<?php echo $frm; ?>_formatdata' id='br<?php echo $frm; ?>_formatdata' value=''>
                            <input type="hidden" name="br<?php echo $frm; ?>_veh_upl" id="br<?php echo $frm; ?>_veh_upl" value=''>
                            <input type="hidden" name="br<?php echo $frm; ?>_all_veh_upl" id="br<?php echo $frm; ?>_all_veh_upl" value=''>
                            <input type="hidden" name="br<?php echo $frm; ?>_cid_arr" id="br<?php echo $frm; ?>_cid_arr" value=''>
                            <input type="hidden" name="br<?php echo $frm; ?>_veh_cit_dis" id="br<?php echo $frm; ?>_veh_cit_dis" value=''>
							<input type="hidden" name="br<?php echo $frm; ?>_subform" value="1">
                            
                            <input type='hidden' id='br<?php echo $frm; ?>_d0' value='0' />
                            <input type='hidden' id='br<?php echo $frm; ?>_c0' value='0' />
                            <input type="hidden" id="br<?php echo $frm; ?>_callbackid" value="" />
                            <input type="hidden" id="br<?php echo $frm; ?>_citarrid" value="" />
                            <input type="hidden" id="br<?php echo $frm; ?>_daydiv" name="br<?php echo $frm; ?>_daydiv" value="0" />   
                            
                            <input type="hidden" value="" id="br<?php echo $frm; ?>_day_of_stay" name="br<?php echo $frm; ?>_day_of_stay"  />
                            <input type="hidden" value="" id="br<?php echo $frm; ?>_room_of_num" name="br<?php echo $frm; ?>_room_of_num"  />
                            <input type="hidden" id="br<?php echo $frm; ?>_tab_cnt" value="1" />
                            <input type="hidden" id="br<?php echo $frm; ?>_htl_id0" value="" />
                         
                        </div>
<?php
}
?>