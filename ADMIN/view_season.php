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
		<link href="../core/assets/css/style-responsive.css" rel="stylesheetr
</head>        
      <body class="">

<?php 
require_once('../Connections/divdb.php');
$sno=$_GET['sno'];
$hotel_id=$_GET['hid'];


	$season = $conn->prepare("SELECT * FROM hotel_season where sno=? and status = '0' and hotel_id=? and  room_type = ?");
	$season->execute(array($sno,$hotel_id,str_replace(" ","_",$_GET['room_type'])));
	$row_season = $season->fetch(PDO::FETCH_ASSOC);
	
	$hotel = $conn->prepare("SELECT * FROM hotel_pro where status = '0' and hotel_id=?");
	$hotel->execute(array($hotel_id));
	$row_hotel = $hotel->fetch(PDO::FETCH_ASSOC);
	
	$seashotel = $conn->prepare("SELECT * FROM setting_season ss,hotel_season hs where ss.sno = hs.season_sno and hs.hotel_id=? and hs.room_type = ?");
	$seashotel->execute(array($hotel_id,str_replace(" ","_",$_GET['room_type'])));
	
	//$seashotel->debugDumpParams();
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
<?php echo $row_hotel['hotel_name']." - ".$row_season['room_type']; ?>&nbsp; details 
 <table class="table table-striped table-hover datatable-example" >
							<thead class="the-box dark full">
								<tr>
									
                                <th width="25%" ><center><i class="fa fa-calendar-o "></i>&nbsp; From Date</center></th>
                                <th width="25%" ><center><i class="fa fa-calendar "></i>&nbsp; To Date</center></th>
                                 <th width="25%" ><center><i class="fa fa-calendar "></i>&nbsp;Rate</th>
								</tr>
							</thead>
							<tbody>
                            
<tr class="even gradeA">

<td><center>
<input type="text" data-date-format="yyyy-mm-dd"  id="ed_fdate" class="datepick11 form-control " value="" name="ed_fdate"  /></center></td>
<td><center><label id="td_label"></label>
<input type="text" data-date-format="yyyy-mm-dd"  id="ed_tdate" class="datepick11 form-control " value="" name="ed_tdate"   /></center>
</td>
<td>
<input type="submit" name="submitDate" id="submitDate" class="form-control"  value="Get" onClick="getSeasonRate('Get')">
</td>

</tr>

<tr class="even gradeA">


<td>
<input type="text" name="season_rate" id="season_rate" class="form-control" placeholder="Rate" value="" onchange="changeButton(this)">
<input type="hidden" name="hid" id="hid" value = '<?php echo $_GET['hid'];?>' />
<input type="hidden" name="room_type" id="room_type" value = '<?php echo str_replace(" ","_",$_GET['room_type']);?>' />
</td>
<td>
<input type="submit" name="submitDate" id="submitDate" class="form-control"  value="Set" onClick="getSeasonRate('Set')">
</td>
<td>
<input type="hidden" name="hotel_season_no" id="hotel_season_no" value = '' />
<input type="submit" name="submitDate" id="deleteDate" class="form-control"  value="Delete" onClick="deleteSeasonRate()" style="display:none">
</td>
</tr>
                               
                                </tbody>
                                </table>
<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-primary">
							 <div class="panel-heading">
								<h3 class="panel-title">
									<?php echo $row_hotel['hotel_name']." - ".$row_season['room_type']; ?>&nbsp; details 
									
								
								</h3>
							  </div> 
                           <form name="update_season" role="form"  method="post" >   
							  <div class="panel-body">
								<div class="row">
							<div class="col-sm-12">
							<?php $i =1; while($row_seashotel =$seashotel->fetch(PDO::FETCH_ASSOC)){ 
									$key = 'season'.$i.'_rate';
									//echo $row_seashotel['season_id']; ?>
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    
										  <label class="tooltips" data-toggle="tooltip" >Season <?php echo $i;?> Rate <br><small style="font-size: 12px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                               <label id="season<?php echo $i;?>_id" style="color:#C63">=&nbsp;&nbsp;&nbsp;<?php echo $row_seashotel['season_rate']." Rupee(s)" ; ?></label>
					
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
									</div>
							<?php $i++;} ?>
                                    
                                  
                                    
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
		 
		 <script>
		  $(document).ready(function(e) {
    $('.tooltips').tooltip();
	 $('.datepick11').datepicker();
	 
});
 

function changeButton(obj){
	var rate = parseInt(obj.value);
	if(rate == 'NaN'){
		$('#season_rate').val(0);
	}
	
	if(rate >0 && rate != 'NaN'){
	//$('#submitDate').val('Set');
	}

}
function getSeasonRate(action){
	var rate = parseInt($('#season_rate').val());
	
	 var from_date = $('#ed_fdate').val();
	 var to_date = $('#ed_tdate').val();
	 var hid = $('#hid').val();
	 var room_type = $('#room_type').val();
	 $.get('ajax_others.php?from_date='+from_date+'&to_date='+to_date+'&action='+action+'&rate='+rate+'&hid='+hid+'&room_type='+room_type+'&type=16',function(result)
	{
		
		if(action == "Get"){
			response = result.trim();
			resp_arr = response.split('|');
			var hotel_rate = resp_arr[3];
			
			if(hotel_rate == ''){
					hotel_rate = 0;
			}
			$('#season_rate').val(hotel_rate);
			if(hotel_rate > 0){
				$('#hotel_season_no').val(resp_arr[0]);
				$('#deleteDate').show();
			}
			else{
				$('#deleteDate').hide();
			}
		}
		else{
			//$.fancybox.close();
		}
		
	});
}

function deleteSeasonRate(){
	
	var confirmFlag = confirm("Are you sure. You want to delete");
	var hotel_season_no = $('#hotel_season_no').val();
	
	if(confirmFlag){
		$.get('ajax_others.php?hotel_season_no='+hotel_season_no+'&type=17',function(result)
			{
				$('#deleteDate').hide();
			});
	}
}
</script>