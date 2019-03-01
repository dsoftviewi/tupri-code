<html>
<?php
require_once('../Connections/divdb.php');

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

if(isset($_GET['type']) && $_GET['type']==md5(1))
{
	if ((isset($_POST["MM_insertform"])) && ($_POST["MM_insertform"] == "form_entry_hotspot")) {
		
		$vehid = $conn->prepare("SELECT * FROM setting_ids  where sno =2");
		$vehid->execute();
		$row_vehid = $vehid->fetch(PDO::FETCH_ASSOC);
		$id=$row_vehid['id_name'].$row_vehid['id_number'];
		$idin=$row_vehid['id_number']+1;

$zero=0;
$hdesc=str_replace("'",">>>",$_POST['hdesc']);
//$timing=$_POST['stime'].' - '.$_POST['etime'];
$timing=$_POST['timing'];

echo $insertSQLupd = $conn->prepare("INSERT INTO hotspots_pro (hotspot_id, spot_name , spot_state, spot_city, spot_timings, video_link, `spot_desc`,spot_prior, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, '0')");
     $insertSQLupd->execute(array($id,$_POST['hname'],$_POST['hstate'],$_POST['hotel_city'],$timing,$_POST['hvideo'],$hdesc,$_POST['prior']));
				
				 //Update setting ids
			 		$insertSQLupd=$conn->prepare('update setting_ids set id_number=? where sno=2');
			 	 	$insertSQLupd->execute(array($idin));
		
		$cn1=$_POST['hname'];
	echo "<script>parent.document.location.href='../admin_manaitin.php?&mm=".$_GET['mm']."&sm=".$_GET['sm']."&tost=".md5(6)."&rec2=".$cn1."';</script>"; 
  	echo "<script>parent.jQuery.fancybox.close();</script>";
		
}
}

if(isset($_GET['type']) && $_GET['type']==md5(2))
{

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "typeexcel")) {
	
	$timezone = new DateTimeZone("Asia/Kolkata");
$date = new DateTime();
$date->setTimezone($timezone);
$tstamp= $date->format('Y_m_d_H_i_s');
$cn='';
	
	$fpaths=pathinfo($_FILES["excl"]["name"], PATHINFO_EXTENSION);
	$fnames=$tstamp.'.'.$fpaths;
	$excelfile="../uploadexcel/hotspot/".$fnames;
	move_uploaded_file($_FILES["excl"]["tmp_name"],$excelfile);
	
	define('CSV_PATH','../uploadexcel/hotspot/'); 
	
	$csv_file1 = CSV_PATH . "$fnames"; 
	$fp = file("$csv_file1", FILE_SKIP_EMPTY_LINES);
	$csvfile1 = fopen($csv_file1, 'r');
	$theData1 = fgets($csvfile1);
	$i1=0;
		while (!feof($csvfile1)) {
			$csv_data1[] = fgets($csvfile1, 1024);
			

			$csv_array1 = explode(",", $csv_data1[$i1]);
			$insert_csv1 = array();
			 $insert_csv1['hotspot_name'] = (isset($csv_array1[0]) ? $csv_array1[0] : '');
			 $insert_csv1['hotspot_city'] = (isset($csv_array1[1]) ? $csv_array1[1] : '');
			 //$insert_csv1['hotspot_state'] = (isset($csv_array1[2]) ? $csv_array1[2] : '');
			 $insert_csv1['hotspot_timing'] = (isset($csv_array1[2]) ? $csv_array1[2] : '');
			 $insert_csv1['hotspot_videolink'] = (isset($csv_array1[3]) ? $csv_array1[3] : '');
			  $insert_csv1['hotspot_prior'] = (isset($csv_array1[4]) ? $csv_array1[4] : '');
			
			
			if($insert_csv1['hotspot_name']!='')
			{
				$vehid = $conn->prepare("SELECT * FROM setting_ids  where sno =2");
				$vehid->execute();
				$row_vehid = $vehid->fetch(PDO::FETCH_ASSOC);
				$id=$row_vehid['id_name'].$row_vehid['id_number'];
				$idin=$row_vehid['id_number']+1;
				
				$cit_id = trim($insert_csv1['hotspot_city']);
				
				$sttid = $conn->prepare("SELECT * FROM dvi_cities  where id =?");
				$sttid->execute(array($cit_id));
				$row_sttid = $sttid->fetch(PDO::FETCH_ASSOC);
				
			 $insertSQL = $conn->prepare("INSERT INTO hotspots_pro (hotspot_id, spot_name, spot_city, spot_state, spot_timings, video_link, spot_desc, status) VALUES (?,?,?,?,?,?,?,'0')");
			 $insertSQL->execute(array($id,$insert_csv1['hotspot_name'],$insert_csv1['hotspot_city'],$row_sttid['region'],trim($insert_csv1['hotspot_timing']),trim($insert_csv1['hotspot_videolink']),$insert_csv1['hotspot_prior']));
			 
			  
			  //Update setting ids
			 	$insertSQLupd=$conn->prepare('update setting_ids set id_number=? where sno=2');
			 	$insertSQLupd->execute(array($idin));
			  
			}
			$i1++;
			
		}  
	fclose($csvfile1);
	
	$cn=count($fp)-1;
	$cn1=$cn.' records s are added Successfully..!';
	
	echo "<script>parent.document.location.href='../admin_manaitin.php?&mm=".$_GET['mm']."&sm=".$_GET['sm']."&tost=".md5(7)."&rec3=".$cn1."';</script>"; 
  	echo "<script>parent.jQuery.fancybox.close();</script>";
	
}

}

?>
<head>
<link href="../assets/css/bootstrap.min.css" rel="stylesheet">

		<link href="../core/assets/plugins/prettify/prettify.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/magnific-popup/magnific-popup.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/owl-carousel/owl.carousel.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/owl-carousel/owl.theme.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/owl-carousel/owl.transitions.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/chosen/chosen.min.css" rel="stylesheet">
		<!--<link href="../core/assets/plugins/icheck/skins/all.css" rel="stylesheet">-->
		<link href="../core/assets/plugins/datepicker/datepicker.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/validator/bootstrapValidator.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/summernote/summernote.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/markdown/bootstrap-markdown.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/datatable/css/bootstrap.datatable.min.css" rel="stylesheet">
<!--		<link href="../core/assets/plugins/morris-chart/morris.min.css" rel="stylesheet">
	<link href="../core/assets/plugins/c3-chart/c3.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/slider/slider.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/salvattore/salvattore.css" rel="stylesheet">
		<link href="../core/assets/plugins/toastr/toastr.css" rel="stylesheet">
		<link href="../core/assets/plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet">
		<link href="../core/assets/plugins/fullcalendar/fullcalendar/fullcalendar.print.css" rel="stylesheet" media="print">-->
			
		<!-- MAIN CSS (REQUIRED ALL PAGE)-->
		<link href="../core/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="../core/assets/css/style.css" rel="stylesheet">
		<link href="../core/assets/css/style-responsive.css" rel="stylesheet">
        
<style>
body {
    background-position: 50% 50%;
    margin:0px;
    padding:0px !important;
}
</style>

</head>
<body>
<?php if(isset($_GET['type']) && $_GET['type']==md5(1)){?>
<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-primary">
							  <div class="panel-heading">
								<h3 class="panel-title"><i class="fa fa-map-marker"></i> Add hotspot</h3>
							  </div>
							  <div class="panel-body">
								<div class="row">
							<div class="col-sm-12">
								 <form   method="post" name="form_entry_hotspot"  id="form_entry_hotspot" onSubmit="return validate_me()" >
                                 <input type="hidden" id="mm" value="<?php echo $_GET['mm'];?>">
                                   <input type="hidden" id="sm" value="<?php echo $_GET['sm'];?>">
                                                <div class="row">
									<div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Hotspot name" ><i class="fa fa fa-tag fa-fw"  ></i></span>
										  <input type="text" name="hname" id="hname"  class="form-control" placeholder="Hotspot name">
										</div>
									<!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->                                        </div>
                                    
                                        </div>
                                        
                                        <div class="col-sm-6">
                                        <div class="form-group">
                                         <div class="input-group">
                                         <span class="input-group-addon tooltips" data-original-title="Opening and Closing timing" ><i class="fa fa-clock-o fa-fw"  ></i></span>
										  <input type="text" name="timing" id="timing"  class="form-control" placeholder="Timing">
                                         </div>
                                        </div>
                                        </div>
                                        
                                        <!--<div class="col-sm-6">
                                        <div class="col-sm-6">
                                        <div class="form-group">
                                   
                                        <div class="input-group input-append bootstrap-timepicker">
												<input type="text" readonly name="stime" id="stm" class="form-control timepicker">
												<span class="input-group-addon add-on"><i class="fa fa-clock-o"></i></span>
											</div>
                                        <small class="help-block" id="stmerr">Opening time.</small>
                                        </div>
                                        </div>
                                        <div class="col-sm-6">
                                        <div class="form-group">
                                   
                                        <div class="input-group input-append bootstrap-timepicker">
												<input type="text" readonly name="etime" id="cltms" class="form-control timepicker">
												<span class="input-group-addon add-on"><i class="fa fa-clock-o"></i></span>
											</div>
                                        <small class="help-block" id="cltmerr">Closing time.</small>
                                        </div>
                                        </div>
									</div>-->
                                    </div>
                                    <div class="row">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group ">
                                    <?php 
									$hotelstate = $conn->prepare("SELECT * FROM dvi_states");
									$hotelstate->execute();
									//$row_hotelstate= mysql_fetch_assoc($hotelstate);
									$row_hotelstate_main=$hotelstate->fetchAll();
									?>
									<span class="input-group-addon tooltips" data-original-title="Hotspot Located State"><i class="fa fa-globe fa-fw"></i></span>
										 <select data-placeholder="Choose State" name="hstate" id="hstate" class="form-control chosen-select col-lg-12 " tabindex="2" onChange="find_city(this.value);change_prio_def();" >									
                                         <option ></option>	
										 <?php foreach($row_hotelstate_main as $row_hotelstate) {?>
										<option value="<?php echo $row_hotelstate['code'];?>"><?php echo $row_hotelstate['name'];?></option>
                                        <?php } ?>
									</select>
										</div>
                                       <!-- <small class="help-block" id="perklerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
                                        </div>
                                        
                                        
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group " id="default_city_id">
                                   
									<span class="input-group-addon tooltips" data-original-title="Hotspot Located City"><i class="fa fa-map-marker fa-fw"></i></span>
										 <select data-placeholder="Choose a State" id='hotel_city' name="hotel_city" class="form-control chosen-select  input-lg" tabindex="2">						<option value="" disabled>Choose state - initially</option>	
										
									</select >
										</div>
                                        <!--<div class="input-group" id="active_city_id"></div>-->
                                        </div>
                                        </div>
                                         <!-- /.col-sm-6 -->
                                </div>
                                <div class="row">
                                <div class="col-sm-6">
                                <div class="form-group">
										 <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Video Link"><i class="fa fa-video-camera fa-fw"></i></span>
										  <input type="text" class="form-control" id="vide" name="hvideo" placeholder="Video link">
										</div>
                                        <small class="help-block" id="seaterr" style=" display:none; color:#E9573F;" ></small>
                                        </div>
                                </div>
                                
                                <div class="col-sm-6">
                                <div class="form-group">
										 <div class="input-group" id="hotprior_div">
										<span class="input-group-addon tooltips" data-original-title="Hotspot Priority"><i class="fa fa-signal fa-fw"></i></span>
										  <input type="text" class="form-control" id="prior" name="prior" placeholder="Priority">
										</div>
                                        <small class="help-block" id="seaterr" style=" display:none; color:#E9573F;" ></small>
                                        </div>
                                </div>
                                
                                </div>
                                <div class="row">
                                <div class="col-sm-12">
                                <div class="the-box">
						<h4 class="small-title" align="center" style="color:#999;">Add Description </h4>
						
							<textarea name="hdesc" class="summernote-sm" placeholder="History"> History </textarea>
					
					</div><!-- /.the-box -->
                    </div>
                    </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                    <div class="form-group pull-right">
                                    <button type="submit"  name="form_entry_hotspot" value="form_entry_hotspot_val" class="btn btn-sm btn-success">
                                    <i class="fa fa-plus"></i> Submit</button>
                                    <button type="button" class="btn btn-sm btn-danger" onClick="parent.jQuery.fancybox.close();"><i class="fa fa-times"></i> Cancel</button>
                                        </div>
                                        </div>
                                </div>
                                 <input type="hidden" class="form-control" name="MM_insertform" value="form_entry_hotspot">
                                <input type="hidden" id="cnt2"><input type="hidden" id="cnt3"><input type="hidden" id="cnt4"><input type="hidden" id="cnt5"><input type="hidden" id="cnt6"><input type="hidden" id="cnt7">
											
                                 </form>
                                 
                                </div>
							  </div>
							</div><!-- /.panel panel-default -->
						</div>
                        </div>
                        </div>
<?php }                     
  if(isset($_GET['type']) && $_GET['type']==md5(2)){?>
<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-primary">
							  <div class="panel-heading">
								<h3 class="panel-title"><i class="fa fa-file-excel-o"></i> Upload file - Hotspots</h3>
							  </div>
							  <div class="panel-body">
								<div class="row">
							<div class="col-sm-12">
                            
								<div class="alert alert-danger alert-bold-border square fade in alert-dismissable">
								   <h4 align="center"><strong>Instructions!</strong></h4>
                                 <p class="text-muted text-justify" style="color:#434A54; text-indent:20px">
                                <i class="fa fa-star"></i> Please Note that the allowed XL file format for upload is  <strong class="text-danger">*.CSV (Comma separated values) only.</strong>
                                 </p>
                                 <p class="text-muted text-justify" style="color:#434A54; text-indent:20px">
                                <i class="fa fa-star"></i>  The File must consist of the following fields: Spot_name, City, State, Timings, Video link. Sample file attached for your reference<a href="../uploadexcel/Sample/hotspot/sample_upload_hotspots.csv" download style="text-decoration:none"><i class="fa fa-cloud-download fa-lg" ></i></a> .
                                 </p>
                                 <p class="text-muted text-justify" style="color:#434A54; text-indent:20px; page-break-inside:auto">
                                <i class="fa fa-star"></i> Save your spreadsheet XL file with extension as <strong class="text-danger">.csv</strong> and click Upload. Files with format other than .csv will not be allowed. Once you upload and submit, your XL sheet will be validated and any errors found will be displayed. Correct the errors if any and re-upload the file&nbsp;.</strong>
                                 </p>
                                 <p class="text-muted text-justify" style="color:#434A54; text-indent:20px">
                                <i class="fa fa-star"></i> If you still get any problems on uploading your files, please Contact <a style="text-decoration:none;" href="http://www.dvi.co.in" target="new">DoView Holidays (India) Pvt. Ltd</a>.</strong>
                                 </p>
                            
								</div>
                                 <form name="typeexcel" role="form"  method="post" enctype="multipart/form-data" onSubmit="Checkfiles()">
                                 <div class="row">
                                 <div class="col-sm-10" >
								<div class="form-group">
									<div class="input-group">
										<span class="input-group-btn">
											<span class="btn btn-default btn-file">
												Browse&hellip; <input type="file" name="excl"  id="confirm">
											</span>
										</span>
                                        <input type="text" class="form-control" id="nametxt" readonly>
									</div><!-- /.input-group -->
                                    <small id="err" class="help-block" style="color:#E9575C; display:none"></small>
								</div>
                                </div>
                                <div class="col-sm-2">
                                <div class="form-group">
									<div class="pull-right">
                                    <button type="submit"  onclick="return chkfile();" class="btn btn-sm btn-success" name="subex"><i class="fa fa-upload"></i> Upload</button>
                                    </div>
								</div>
                                </div>
                                </div>
                                 <input type="hidden" name="MM_insert" value="typeexcel" />
                                  <input type="hidden" id="errval" />
                                </form>
                                </div>
							  </div><!-- /.panel-body -->
							  <!--<div class="panel-footer">Panel footer</div>-->
							</div><!-- /.panel panel-default -->
						</div>
                        </div>
                        </div>
<?php }?>                        
                        </body>
                        
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
<!--		<script src="../core/assets/plugins/icheck/icheck.min.js"></script>-->
		<script src="../core/assets/plugins/datepicker/bootstrap-datepicker.js"></script>
		<script src="../core/assets/plugins/timepicker/bootstrap-timepicker.js"></script>
	<!--	<script src="../core/assets/plugins/mask/jquery.mask.min.js"></script>
		<script src="../core/assets/plugins/validator/bootstrapValidator.min.js"></script>-->
		<script src="../core/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
		<script src="../core/assets/plugins/datatable/js/bootstrap.datatable.js"></script>
		<script src="../core/assets/plugins/summernote/summernote.min.js"></script>
		<script src="../core/assets/plugins/markdown/markdown.js"></script>
		<script src="../core/assets/plugins/markdown/to-markdown.js"></script>
		<script src="../core/assets/plugins/markdown/bootstrap-markdown.js"></script>
		<!--<script src="../core/assets/plugins/slider/bootstrap-slider.js"></script>
		<script src="../core/assets/plugins/toastr/toastr.js"></script>-->
		
		<!-- MAIN APPS JS -->
		<script src="../core/assets/js/apps.js"></script>
		<script src="../core/assets/js/demo-panel-1.js"></script>
         <script src="../core/assets/plugins/jQuery1/form-validator/jquery.form-validator.js"></script>
        
                 
<script>

$('.tooltips').tooltip({});
$('.chosen-select').chosen({width : '100%'});

function find_city(state_id)
{
		var type=18;
	$.get("ajax_hotel.php?sid="+state_id+"&type="+type,function(result)
	{
		//alert(result);
		$('#default_city_id').empty().html(result);
							$('.chosen-select').chosen({'width':'100%'});
							$('.tooltips').tooltip({});
		
	});
	
}

//this is for tag validation
function ftagval()
{
	var tval;
	tval=$('#city').val();
	
	if(tval=='')
	{
		$('#tagerr').show('fade').html("Cities are required can't be empty.");
		return false;
	}
	else
	{
		$('#tagerr').empty().hide('fade');
		return true;
	}
}

$('.tagname').tagsInput({width:'auto'});

function chkfile()
{
	var filechk = $('#errval').val();
	if (filechk == '' || filechk ==1)
	{
		var txt;
		txt='Please choose file (.csv format) to upload';
		$('#err').html(txt).show('fade');
		$('#nametxt').css('border','1px solid #E9573F');
		return false
	}
	else
	{
		$('#err').empty().hide('fade');
		 $('#nametxt').css('border','1px solid #8CC152');
		return true;
	}
}

document.getElementById('confirm').addEventListener('change', checkFile, false);
approveletter.addEventListener('change', checkFile, false);

function checkFile(e) {

    var file_list = e.target.files;

    for (var i = 0, file; file = file_list[i]; i++) {
        var sFileName = file.name;
        var sFileExtension = sFileName.split('.')[sFileName.split('.').length - 1].toLowerCase();
        var iFileSize = file.size;
        var iConvert = (file.size / 10485760).toFixed(2);

        if (!(sFileExtension === "csv")) {
			
            txt = "File type : " + sFileExtension + "\n\n";
            txt += "Please make sure your file is in CSV format\n\n";
          	$('#err').html(txt).show('fade');
		   $('#nametxt').css('border','1px solid #E9573F');
		   $('#errval').val(1);
        }
		else
		{
			 $('#err').empty().hide('fade');
			 $('#nametxt').css('border','1px solid #8CC152');
			 $('#errval').val(0);
		}
    }
	
}


</script>                        
<script>
//validation for vehicle update form
function exmapleval()
{
	
	//For name
	if($('#vnum').val()=='')
	{
		$('#vnum').css('border','1px solid #E8573F');
 		$('#vnumerr').html("This field is required.").slideDown('slow');
		$('#cnt2').val(0);
	}
	else
	{
		//For name
		$('#vnum').css('border','1px solid #8CC152');
		$('#vnumerr').empty().slideUp('slow');
		$('#cnt2').val(1);
		
	}
	
	//For perkilo meter
	if($('#perkilo').val()=='')
	{
		$('#perkilo').css('border','1px solid #E8573F');
 		$('#perklerr').html("This field is required.").slideDown('slow');
		$('#cnt3').val(0);
	}
	else if($.isNumeric($('#perkilo').val())==false)
	{
		$('#perkilo').css('border','1px solid #E8573F');
		$('#perklerr').html("This is not number input give correct input format.").slideDown('slow');
		$('#cnt3').val(0);
	}
	else
	{
		//For perkilo meter
		$('#perkilo').css('border','1px solid #8CC152');
		$('#perklerr').empty().slideUp('slow');
		$('#cnt3').val(1);
		
	}
	
	//For total amount
	if($('#totamt').val()=='')
	{
		$('#totamt').css('border','1px solid #E8573F');
 		$('#totamterr').html("This field is required.").slideDown('slow');
		$('#cnt4').val(0);
	}
	else if($.isNumeric($('#totamt').val())==false)
	{
		$('#totamt').css('border','1px solid #E8573F');
		$('#totamterr').html("This is not number input give correct input format.").slideDown('slow');
		$('#cnt4').val(0);
	}
	else
	{
		//For perkilo meter
		$('#totamt').css('border','1px solid #8CC152');
		$('#totamterr').empty().slideUp('slow');
		$('#cnt4').val(1);
	}
	
	//For seats
	if($('#seat').val()=='')
	{
		$('#totamt').css('border','1px solid #E8573F');
 		$('#seaterr').html("This field is required.").slideDown('slow');
		$('#cnt5').val(0);
	}
	else
	{
		//For perkilo meter
		$('#seat').css('border','1px solid #8CC152');
		$('#seaterr').empty().slideUp('slow');
		$('#cnt5').val(1);
		
	}
	
	//For extra charge
	if($('#exchrg').val()=='')
	{
		$('#exchrg').css('border','1px solid #E8573F');
 		$('#excherr').html("This field is required.").slideDown('slow');
		$('#cnt6').val(0);
	}
	else if($.isNumeric($('#exchrg').val())==false)
	{
		$('#exchrg').css('border','1px solid #E8573F');
		$('#excherr').html("This is not number input give correct input format.").slideDown('slow');
		$('#cnt6').val(0);
	}
	else
	{
		//For perkilo meter
		$('#exchrg').css('border','1px solid #8CC152');
		$('#excherr').empty().slideUp('slow');
		$('#cnt6').val(1);
	}
	
	//For cities
	if($('#city').val()=='')
	{
 		$('#cityerr').html("This field is required.").slideDown('slow');
		$('#cnt7').val(0);
	}
	else
	{
		//For perkilo meter
		$('#cityerr').empty().slideUp('slow');
		$('#cnt7').val(1);
	}	
	var totval;
	totval=	parseInt($('#cnt2').val())+parseInt($('#cnt3').val())+parseInt($('#cnt4').val())+parseInt($('#cnt5').val())+parseInt($('#cnt6').val())+parseInt($('#cnt7').val());

	if(totval==6)
	{
		 return true;
	}
	else
	{
		return false;
	}

}

function change_priotity(cid)
{
	var type=19;
	$.get("ajax_hotel.php?cid="+cid+"&type="+type,function(result)
	{
		$('#hotprior_div').empty().html(result);
							$('.chosen-select').chosen({'width':'100%'});
							$('.tooltips').tooltip({});
		
	});
	
}

function change_prio_def()
{
	$('#hotprior_div').empty().html("<span class='input-group-addon tooltips' data-original-title='Hotspot Priority'><i class='fa  fa-signal fa-fw'></i></span><input type='text' name='prior' id='prior' value='1' class='form-control'/>");
}


function validate_me()
{
	var numbers =  /^\d+$/; 
	if($('#hname').val().trim()=='')
	{
		alert("Please Enter Hotspot Name");	
		$('#hname').focus();
		return false;
	}else if($('#hname').val().trim().length<4)
	{
		alert("Hotspot Name should be minimum 4 charactors");
		$('#hname').focus();
		return false;	
	}else if($('#timing').val().trim() =='')
	{
		alert('Please Enter Hotspot Visiting-Time');
		$('#timing').focus();
		return false;
	}else if($('#hstate').val() == '')
	{
		alert('Please Choose Hotspot Located State');
		$('#hstate').focus();
		return false;		
	}else if($('#hotel_city').val() == '')
	{
		alert('Please Choose Hotspot Located City');
		$('#hotel_city').focus();
		return false;		
	}else if($('#prior').val() == '')
	{
		alert('Please Choose Hotspot Priority');
		$('#prior').focus();
		return false;		
	}else if(!numbers.test($('#prior').val()))
	{
		alert('Please Enter Priority In Integer');
		$('#prior').focus();
		return false;		
	}else {
		return true;	
	}
	
}
</script>
</html>
                        