<?php
require_once('../Connections/divdb.php');
$get_dtids = $_GET['dt_ids'];
$exp_dtids1 = implode(',',$get_dtids);
$exp_dtids = explode(',',$exp_dtids1);
$cnt_dtids = count($exp_dtids);

$arv_date=$_GET['arv_dd'];
$dep_date=$_GET['dep_dd'];

$frm=$_GET['frm'];


$chkrow = $conn->prepare("SELECT * FROM setting_dist");
$chkrow->execute();
$row_chkrow = $chkrow->fetch(PDO::FETCH_ASSOC);
$totalRows_chkrow = $chkrow->rowCount();

?>
<div id="daytrip_book_<?php echo $frm; ?>" class="the-box" style="margin-bottom:1px">
	<div class="form-group">
    	<div class="row">
        	<label class="col-sm-12" id="dt_lab_<?php echo $frm; ?>" style="text-align:center"> 
            DAY TRIP - Select your preferred daytrip cities below ( Optional ) 
          <br /><small><?php echo "[ From ".date("d-M-Y",strtotime($arv_date))." - to - ".date("d-M-Y",strtotime($dep_date))." ] - Itinerary"; ?></small>
            </label>
        </div>
	</div>
	<input type="hidden" value="<?php echo $cnt_dtids; ?>" id="day_trip_allows_cnt_<?php echo $frm; ?>" name="day_trip_allows_cnt_<?php echo $frm; ?>" />
    <input type="hidden" value="allow" id="day_trip_allows_<?php echo $frm; ?>" name="day_trip_allows_<?php echo $frm; ?>" />
    <?php
	for($dt2=0;$dt2<$cnt_dtids;$dt2++)
	{
		
		$cities = $conn->prepare("SELECT * FROM dvi_cities where id !=? and status = 0 ORDER BY name ASC");
		$cities->execute(array($exp_dtids[$dt2]));
		$row_cities_main =$cities->fetchAll();
		$totalRows_cities = $cities->rowCount();


		
		$dtcities = $conn->prepare("SELECT * FROM dvi_cities where id =? and status = 0");
		$dtcities->execute(array($exp_dtids[$dt2]));
		$row_dtcities = $dtcities->fetch(PDO::FETCH_ASSOC);
		$totalRows_dtcities =$dtcities->rowCount();

	?>
    	<div class="row" style="margin-top:20px">
        <div class="col-sm-12">
        <div class="col-sm-1"></div>
                <div class="col-sm-5">
                <label class="control-label"><label id="daytr_cnt_<?php echo $frm; ?>"></label> Choose day trip from - <?php echo $row_dtcities['name']; ?></label>
                </div>
            	<div class="col-sm-5">
                	<select id="<?php echo $frm; ?>_sel_dtid<?php echo $dt2; ?>" data-placeholder="Choose cities to visit" class="form-control chosen-select" multiple tabindex="6" onchange="hidesave();">
										<option value="Empty"></option>
                                        <?php
										foreach($row_cities_main as $row_cities)
										{
											$dist_diff = 0;
											
											
											$dist_calc1 = $conn->prepare("SELECT * FROM dvi_citydist where from_cityid =? and to_cityid =?");
											$dist_calc1->execute(array($row_dtcities['id'],$row_cities['id']));
											$row_dist_calc1 = $dist_calc1->fetch(PDO::FETCH_ASSOC);
											$Rows_dist_calc1 =$dist_calc1->rowCount();
											
											$trav_dist = $row_dist_calc1['dist'];
											if($Rows_dist_calc1 > 0)
											{
												$dist_diff = $row_dist_calc1['dist'];
											}
											else
											{
												
												$dist_calc2 = $conn->prepare("SELECT * FROM dvi_citydist where from_cityid =? and to_cityid =?");
												$dist_calc2->execute(array($row_cities['id'],$row_dtcities['id']));
												$row_dist_calc2 = $dist_calc2->fetch(PDO::FETCH_ASSOC);
												$Rows_dist_calc2 = $dist_calc2->rowCount();
												
												$trav_dist = $row_dist_calc2['dist'];
												
												if($Rows_dist_calc2 > 0)
												{
													$dist_diff = $row_dist_calc2['dist'];
												}
											}
									
											if ($dist_diff <= $row_chkrow['daytrip_dist'])
											{
												
												$dtstat = $conn->prepare("SELECT * FROM dvi_states where code =? and status = 0");
												$dtstat->execute(array($row_cities['region']));
												$row_dtstat = $dtstat->fetch(PDO::FETCH_ASSOC);
												$totalRows_dtstat = $dtstat->rowCount();
											?>
                                           
												<option value="<?php echo $row_cities['id'].'-'.$trav_dist.'-'.$row_cities['ss_dist'].'-'.$row_dtcities['name']; ?>"><?php echo $row_cities['name'].' - '.$row_dtstat['name']; ?></option>
												<?php
											}
										}
	
	?>
										</optgroup>
									</select>
				</div>
                <div class="col-sm-1"></div>
                </div>
                <?php if($dt2==$cnt_dtids-1){?>
                <div class="col-sm-12" style="margin-top:10px; border-top:#E8E1E1 1px solid">
                <br />
                <div class="col-sm-6" align="right" >
                <a class="btn btn-sm btn-info" onclick="trigger_getquot('go','<?php echo $frm; ?>')">Go with daytrip</a>
                </div>
                <div class="col-sm-6" align="left" >
                <a class="btn btn-sm btn-danger" onclick="trigger_getquot('no','<?php echo $frm; ?>')">No Need</a>
                </div>
                </div>
                <?php } ?>
    	</div>
	
    <?php
	}
	?>
</div>