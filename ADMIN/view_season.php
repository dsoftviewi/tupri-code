<style>
body {
    background-position: 50% 50%;
    margin:0px;
    padding:0px !important;
}
</style>

<html>
<head>
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
	<!--	<link href="../core/assets/plugins/slider/slider.min.css" rel="stylesheet">-->
		<link href="../core/assets/plugins/salvattore/salvattore.css" rel="stylesheet">
		<link href="../core/assets/plugins/toastr/toastr.css" rel="stylesheet">
		
		
		<!-- MAIN CSS (REQUIRED ALL PAGE)-->
		<link href="../core/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="../core/assets/css/style.css" rel="stylesheet">
		<link href="../core/assets/css/style-responsive.css" rel="stylesheet">
</head>        
      <body class="">

<?php 
require_once('../Connections/divdb.php');
$sno=$_GET['sno'];
$hotel_id=$_GET['hid'];

	$season = $conn->prepare("SELECT * FROM hotel_season where sno=? and status = '0' and hotel_id=?");
	$season->execute(array($sno,$hotel_id));
	$row_season = $season->fetch(PDO::FETCH_ASSOC);
	
	$hotel = $conn->prepare("SELECT * FROM hotel_pro where status = '0' and hotel_id=?");
	$hotel->execute(array($hotel_id));
	$row_hotel = $hotel->fetch(PDO::FETCH_ASSOC);
	
	$seashotel = $conn->prepare("SELECT * FROM setting_season");
	$seashotel->execute();
	//$row_seashotel = mysql_fetch_assoc($seashotel);
	//$row_seashotel=$seashotel->fetch(PDO::FETCH_ASSOC);
	

if ((isset($_POST["update_season"])) && ($_POST["update_season"] == "update_season_val")) {	


$update_season=$conn->prepare("update hotel_season set season1_rate=?, season2_rate=?, season3_rate=?, season4_rate=?, season5_rate=?, season6_rate=?, season7_rate=?, season8_rate=?, season9_rate=? where hotel_id=? and sno=?");
$update_season->execute(array($_POST['season1'],$_POST['season2'],$_POST['season3'],$_POST['season4'],$_POST['season5'],$_POST['season6'],$_POST['season7'],$_POST['season8'],$_POST['season9'],$hotel_id,$sno));

	echo "<script>parent.jQuery.fancybox.close();</script>";

}
	
if ((isset($_POST["remove_room"])) && ($_POST["remove_room"] == "remove_room_val")) {	


echo $update_remove=$conn->prepare("update hotel_season set status='1' where hotel_id=? and sno=?");
     $update_remove->execute(array($hotel_id,$sno));

echo "<script>parent.document.location.href='../admin_manahotel.php?&mm=".$_GET['mm']."&sm=".$_GET['sm']."&tost=".md5(1)."';</script>"; 
	echo "<script>parent.jQuery.fancybox.close();</script>";

}
	
	
								
?>
<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-primary">
							 <div class="panel-heading">
								<h3 class="panel-title">
									<?php echo $row_hotel['hotel_name']." - ".$row_season['room_type']; ?>&nbsp; details 
									<span class="right-content">
									<button id="edit_id" class="btn btn-primary  btn-rounded-lg dropdown-toggle" onClick="edit_fun()" data-toggle="dropdown">
										<i class="fa fa-cog"></i>&nbsp;Edit
										</button>
                                        <form name="remove_room" method="post">
                                         <button id="remove_id"  type="submit" style="display:none;"  class="btn btn-primary  btn-rounded-lg dropdown-toggle"  name="remove_room" value="remove_room_val" >
										<i class="fa fa-trash-o"></i>&nbsp;Remove
										</button>
                                        	</form>								
                                        </span>
								
								</h3>
							  </div> 
                           <form name="update_season" role="form"  method="post" >   
							  <div class="panel-body">
								<div class="row">
							<div class="col-sm-12">
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel =$seashotel->fetch(PDO::FETCH_ASSOC); 
									//echo $row_seashotel['season_id']; ?>
										  <label class="tooltips" data-toggle="tooltip" >Season 1 Rate <br><small style="font-size: 12px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                               <label id="season1_id" style="color:#C63">=&nbsp;&nbsp;&nbsp;<?php echo $row_season['season1_rate']." Rupee(s)" ; ?></label>
					<input type="text" name="season1" id="edit_season1" class="form-control"  placeholder="Season 1 Rate" value="<?php echo $row_season['season1_rate']; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                     <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC);
									///echo $row_seashotel['season_id']; ?>
										  <label class="tooltips" data-toggle="tooltip" title="<?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?>">Season 2 Rate <br><small style="font-size: 12px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season2_id" style="color:#C63">=&nbsp;&nbsp;&nbsp;<?php echo $row_season['season2_rate']." Rupee(s)" ; ?></label>
					<input type="text" name="season2" id="edit_season2" class="form-control"  placeholder="Season 2 Rate" value="<?php echo $row_season['season2_rate']; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
										   <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC);
									//echo $row_seashotel['season_id']; ?>
										  <label class="tooltips" data-toggle="tooltip" title="<?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?>">Season 3 Rate <br><small style="font-size: 12px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small> </label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season3_id" style="color:#C63">=&nbsp;&nbsp;&nbsp;<?php echo $row_season['season3_rate']." Rupee(s)" ; ?></label>
					<input type="text" name="season3" id="edit_season3" class="form-control"  placeholder="Season 3 Rate" value="<?php echo $row_season['season3_rate']; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
										  <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC);
									//echo $row_seashotel['season_id']; ?>
										  <label class="tooltips" data-toggle="tooltip" title="<?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?>">Season 4 Rate <br><small style="font-size: 12px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                      <label id="season4_id" style="color:#C63">=&nbsp;&nbsp;&nbsp;<?php echo $row_season['season4_rate']." Rupee(s)" ; ?></label>
					<input type="text" name="season4" id="edit_season4" class="form-control"  placeholder="Season 4 Rate" value="<?php echo $row_season['season4_rate']; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center" >
										   <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC);
									//echo $row_seashotel['season_id']; ?>
										  <label class="tooltips" data-toggle="tooltip" title="<?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?>">Season 5 Rate <br><small style="font-size: 12px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season5_id" style="color:#C63">=&nbsp;&nbsp;&nbsp;<?php echo $row_season['season5_rate']." Rupee(s)" ; ?></label>
					<input type="text" name="season5" id="edit_season5" class="form-control"  placeholder="Season 5 Rate" value="<?php echo $row_season['season5_rate']; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
										   <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC);
									//echo $row_seashotel['season_id']; ?>
										  <label class="tooltips" data-toggle="tooltip" title="<?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?>">Season 6 Rate <br><small style="font-size: 12px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season6_id" style="color:#C63">=&nbsp;&nbsp;&nbsp;<?php echo $row_season['season6_rate']." Rupee(s)" ; ?></label>
					<input type="text" name="season6" id="edit_season6" class="form-control"  placeholder="Season 6 Rate" value="<?php echo $row_season['season6_rate']; ?>" style="display:none">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
										  <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC);
									//echo $row_seashotel['season_id']; ?>
										  <label class="tooltips" data-toggle="tooltip" title="<?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?>">Season 7 Rate <br><small style="font-size: 12px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season7_id" style="color:#C63">=&nbsp;&nbsp;&nbsp;<?php echo $row_season['season7_rate']." Rupee(s)" ; ?></label>
					<input type="text" name="season7" id="edit_season7" class="form-control"  placeholder="Season 7 Rate" value="<?php echo $row_season['season7_rate']; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
										  <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC);
									//echo $row_seashotel['season_id']; ?>
										  <label class="tooltips" data-toggle="tooltip" title="<?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?>">Season 8 Rate <br><small style="font-size: 12px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season8_id" style="color:#C63">=&nbsp;&nbsp;&nbsp;<?php echo $row_season['season8_rate']." Rupee(s)" ; ?></label>
					<input type="text" name="season8" id="edit_season8" class="form-control"  placeholder="Season 8 Rate" value="<?php echo $row_season['season8_rate']; ?>" style="display:none">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    <div class="row">
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
										   <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC);
									//echo $row_seashotel['season_id']; ?>
										  <label class="tooltips" data-toggle="tooltip" title="<?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?>">Season 9 Rate <br><small style="font-size: 12px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season9_id" style="color:#C63">=&nbsp;&nbsp;&nbsp;<?php echo $row_season['season9_rate']." Rupee(s)" ; ?></label>
					<input type="text" name="season9" id="edit_season9" class="form-control"  placeholder="Season 9 Rate" value="<?php echo $row_season['season9_rate']; ?>" style="display:none">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                 <div class="row">
                                 <div class="col-sm-8" >
							<p id="note_id" style="color:#666; word-wrap:break-word; font-size:10px;"> <i style="color:#C63;">Note :</i> If you want to update your detail, please perform action on the above "Edit" button .
                            </p>
                           
                                </div>
                                <div class="col-sm-4">
                                <div class="form-group">
									<div class="pull-right">
                                    <button  id="cancel_id" style="display:none;"   class="btn btn-sm btn-default" onClick="cancel_edit()"><i class="fa fa-times-circle-o"></i> Cancel</button>
                                    
                                    <button type="submit" id="update_id" style="display:none;"   class="btn btn-sm btn-success" name="update_season" value="update_season_val"><i class="fa fa-upload"></i> Upload</button>
                                    </div>
								</div>
                                </div>
                                </div>
                                </div>
							  </div><!-- /.panel-body -->
							  <!--<div class="panel-footer">Panel footer</div>-->
							</div><!-- /.panel panel-default -->
                            </form>
						</div>
                        </div>
                        </div>
                        
 </body>    
 </html>    
 
 <script>
 $(document).ready(function(e) {
    $('.tooltips').tooltip();
});

 
 function edit_fun()
 {
	//$('#adult_id').hide(1000);
	//$('#edit_adults').show(1000);
	
	//$('#child_id').hide(1000);
	//$('#edit_child').show(1000);
	
	$('#season1_id').hide(1000);
	$('#edit_season1').show(1000);
	
	$('#season2_id').hide(1000);
	$('#edit_season2').show(1000);
	
	$('#season3_id').hide(1000);
	$('#edit_season3').show(1000);
	
	$('#season4_id').hide(1000);
	$('#edit_season4').show(1000);
	
	$('#season5_id').hide(1000);
	$('#edit_season5').show(1000);
	
	$('#season6_id').hide(1000);
	$('#edit_season6').show(1000);
	
	$('#season7_id').hide(1000);
	$('#edit_season7').show(1000);
	
	$('#season8_id').hide(1000);
	$('#edit_season8').show(1000);
	
	$('#season9_id').hide(1000);
	$('#edit_season9').show(1000);
	
	$('#remove_id').show(1000);
	$('#update_id').show(1000);
	$('#cancel_id').show(1000);
	$('#note_id').hide(1000);
	$('#edit_id').hide(1000);
 }
 
 
 function cancel_edit()
 {
	 //$('#edit_adults').hide(1000);
	//$('#adult_id').show(1000);
	
	//$('#edit_child').hide(1000);
	//$('#child_id').show(1000);
	
	$('#edit_season1').hide(1000);
	$('#season1_id').show(1000);
	
	$('#edit_season2').hide(1000);
	$('#season2_id').show(1000);
	
	$('#edit_season3').hide(1000);
	$('#season3_id').show(1000);
	
	$('#edit_season4').hide(1000);
	$('#season4_id').show(1000);
	
	$('#edit_season5').hide(1000);
	$('#season5_id').show(1000);
	
	$('#edit_season6').hide(1000);
	$('#season6_id').show(1000);
	
	$('#edit_season7').hide(1000);
	$('#season7_id').show(1000);
	
	$('#edit_season8').hide(1000);
	$('#season8_id').show(1000);
	
	$('#edit_season9').hide(1000);
	$('#season9_id').show(1000);
	
	$('#remove_id').hide(1000);
	$('#update_id').hide(1000);
	$('#cancel_id').hide(1000);
	$('#note_id').show(1000);
	$('#edit_id').show(1000);
	 
 }
 </script>
                               
                        <script src="../core/assets/js/jquery.min.js"></script>
                        <!-- MAIN JAVASRCIPT (REQUIRED ALL PAGE)-->
		
		<script src="../core/assets/js/bootstrap.min.js"></script>
		<script src="../core/assets/plugins/retina/retina.min.js"></script>
		<script src="../core/assets/plugins/nicescroll/jquery.nicescroll.js"></script>
		<script src="../core/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		<script src="../core/assets/plugins/backstretch/jquery.backstretch.min.js"></script>
        
        
		<!-- PLUGINS -->
        <script type="text/javascript" src="../core/assets/plugins/Tags/jquery.tagsinput.js"></script>
		<script src="../core/assets/plugins/skycons/skycons.js"></script>
		<script src="../core/assets/plugins/prettify/prettify.js"></script>
		<script src="../core/assets/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
		<script src="../core/assets/plugins/owl-carousel/owl.carousel.min.js"></script>
		<script src="../core/assets/plugins/chosen/chosen.jquery.min.js"></script>
		<script src="../core/assets/plugins/icheck/icheck.min.js"></script>
		<script src="../core/assets/plugins/datepicker/bootstrap-datepicker.js"></script>
		<script src="../core/assets/plugins/timepicker/bootstrap-timepicker.js"></script>
		<script src="../core/assets/plugins/mask/jquery.mask.min.js"></script>
		<script src="../core/assets/plugins/validator/bootstrapValidator.min.js"></script>
		<script src="../core/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
		<script src="../core/assets/plugins/datatable/js/bootstrap.datatable.js"></script>
		<!--<script src="../core/assets/plugins/summernote/summernote.min.js"></script>
		<script src="../core/assets/plugins/markdown/markdown.js"></script>
		<script src="../core/assets/plugins/markdown/to-markdown.js"></script>
		<script src="../core/assets/plugins/markdown/bootstrap-markdown.js"></script>
		<script src="../core/assets/plugins/slider/bootstrap-slider.js"></script>-->
		<script src="../core/assets/plugins/toastr/toastr.js"></script>
		
		<!-- MAIN APPS JS -->
		<script src="../core/assets/js/apps.js"></script>
		<script src="../core/assets/js/demo-panel-1.js"></script>
         <script src="../core/assets/plugins/jQuery1/form-validator/jquery.form-validator.js"></script>