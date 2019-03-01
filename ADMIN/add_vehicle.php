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

if ((isset($_POST["MM_insertform"])) && ($_POST["MM_insertform"] == "addvehiform")) {
		
		$vehid = $conn->prepare("SELECT * FROM setting_ids  where sno =1");
		$vehid->execute();
		$row_vehid =$vehid->fetch(PDO::FETCH_ASSOC);
		$id=$row_vehid['id_name'].$row_vehid['id_number'];
		$idin=$row_vehid['id_number']+1;



	 		 	$insertSQLupd=$conn->prepare('insert into vehicle_pro(vehi_id,vehicle_type,vehicle_seat) values(?,?,?)');
			  	$insertSQLupd->execute(array($id,$_POST['vehname'],$_POST['occu']));
				
				//this is for table 2
				
				$to='';
				$prch='';
				$prmkl='';
				
				for($i=1;$i<=$_POST['csa'];$i++)
				{
					
					if(isset($_POST['perday'.$i]) && $_POST['perday'.$i]!='')
					{
						$to=$_POST['perday'.$i];
					}
					else
					{
						$to=0;
					}
					
					if(isset($_POST['perkilo'.$i]) && $_POST['perkilo'.$i]!='')
					{
						$prch=$_POST['perkilo'.$i];
					}
					else
					{
						$prch=0;
					}
					
					if(isset($_POST['permxkl'.$i]) && $_POST['permxkl'.$i]!='')
					{
						$prmkl=$_POST['permxkl'.$i];
					}
					else
					{
						$prmkl=0;
					}
					
				if(isset($_POST['city'.$i]) && $_POST['city'.$i]!='')
				{
						
				$insertSQLupd=$conn->prepare('insert into vehicle_rent(vehicle_id,city,rent_day,charge_perkm,maxkm_perday) values(?,?,?,?,?)');
			    $insertSQLupd->execute(array($id,$_POST['city'.$i],$to,$prch,$prmkl));
					}
				}
				
				 //Update setting ids
			 	$insertSQLupd=$conn->prepare('update setting_ids set id_number=? where sno=1');
			 	$insertSQLupd->execute(array($idin));
		
		$cn=$_POST['vehname'].' was added Successfully..!';
		$cl='success';		
 	echo "<script>parent.document.location.href='../admin_manavehile.php?&mm=".$_GET['mm']."&sm=".$_GET['sm']."&tost=".md5(1)."&rec=".$cn."&clr=".$cl."';</script>"; 
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
	
	include('db_downloads.php');//for backuping all db
	
	$fpaths=pathinfo($_FILES["excl"]["name"], PATHINFO_EXTENSION);
	$fnames=$tstamp.'.'.$fpaths;
	$excelfile="../uploadexcel/vehicle/".$fnames;
	move_uploaded_file($_FILES["excl"]["tmp_name"],$excelfile);
	
	define('CSV_PATH','../uploadexcel/vehicle/'); 
	
	$csv_file1 = CSV_PATH . "$fnames"; 
	$fp = file("$csv_file1", FILE_SKIP_EMPTY_LINES);
	$csvfile1 = fopen($csv_file1, 'r');
	$theData1 = fgets($csvfile1);
	$i1=0;
		while (!feof($csvfile1)) {
			$csv_data1[] = fgets($csvfile1, 1024);
			$csv_array1 = explode(",", $csv_data1[$i1]);
			$insert_csv1 = array();
			$insert_csv1['vehicle_type'] = (isset($csv_array1[0]) ? $csv_array1[0] : '');
			$insert_csv1['capacity'] = (isset($csv_array1[1]) ? $csv_array1[1] : '');
			$insert_csv1['avail_cities'] = (isset($csv_array1[2]) ? $csv_array1[2] : '');
			$insert_csv1['perday_rental'] = (isset($csv_array1[3]) ? $csv_array1[3] : '');
			$insert_csv1['perkm_charge'] = (isset($csv_array1[4]) ? $csv_array1[4] : '');
			$insert_csv1['max_km_perday'] = (isset($csv_array1[5]) ? $csv_array1[5] : '');
			
			if($insert_csv1['vehicle_type']!='')
			{
				$vehid = $conn->prepare("SELECT * FROM setting_ids  where sno =1");
				$vehid->execute();
				$row_vehid = $vehid->fetch(PDO::FETCH_ASSOC);
				$id=$row_vehid['id_name'].$row_vehid['id_number'];
				$idin=$row_vehid['id_number']+1;
				
			$insertSQL1 = $conn->prepare("INSERT INTO vehicle_pro (vehi_id, vehicle_type, vehicle_seat) VALUES (?, ?, ?)");
			$insertSQL1->execute(array($id,$insert_csv1['vehicle_type'],$insert_csv1['capacity']));
			  
			  $expl_city = explode('\\',$insert_csv1['avail_cities']);
			  $expl_rent = explode('\\',$insert_csv1['perday_rental']);
			  $expl_kmchrg = explode('\\',$insert_csv1['perkm_charge']);
			  $expl_maxkm = explode('\\',$insert_csv1['max_km_perday']);
			  
			  $city_tot = count($expl_city);
			  
			  for($city_cnt=0;$city_cnt<$city_tot;$city_cnt++)
			  {
				  $insertSQL2=$conn->prepare("INSERT INTO `vehicle_rent` (vehicle_id, city, rent_day, charge_perkm, maxkm_perday) values(?,?,?,?,?)");
				  $insertSQL2->execute(array($id,$exp1_city['$city_cnt'],$exp1_rent['$city_cnt'],$expl_kmchrg[$city_cnt],$expl_maxkm['$city_cnt']));
			  }
			  
			  //Update setting ids
			 	$insertSQLupd=$conn->prepare('update setting_ids set id_number=? where sno=1');
			 	$insertSQLupd->execute(array($idin));
			  
			}
			$i1++;
			
		}  
	fclose($csvfile1);
	
	$cn=count($fp)-1;
	$cn1=$cn.' records s are added Successfully..!';
	$cl='success';	
	
	echo "<script>parent.document.location.href='../admin_manavehile.php?&mm=".$_GET['mm']."&sm=".$_GET['sm']."&tost=".md5(1)."&rec=".$cn1."&clr=".$cl."';</script>"; 
  	echo "<script>parent.jQuery.fancybox.close();</script>";
	
}

}
if(isset($_GET['type']) && $_GET['type']==md5(3))
{}

?>
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
		<link href="../core/assets/plugins/slider/slider.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/salvattore/salvattore.css" rel="stylesheet">
		<link href="../core/assets/plugins/toastr/toastr.css" rel="stylesheet">
		
		
		<!-- MAIN CSS (REQUIRED ALL PAGE)-->
		<link href="../core/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="../core/assets/css/style.css" rel="stylesheet">
		<link href="../core/assets/css/style-responsive.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="../core/assets/plugins/Tags/jquery.tagsinput.css" />
        
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
								<h3 class="panel-title"><i class="fa fa-taxi"></i> Add vehicle</h3>
							  </div>
							  <div class="panel-body">
								<div class="row">
							<div class="col-sm-12">
								 <form onSubmit="return exmapleval();"  method="post" name="exmaplevals"  >
                                 <input type="hidden" id="mm" value="<?php echo $_GET['mm'];?>">
                                   <input type="hidden" id="sm" value="<?php echo $_GET['sm'];?>">
                                                <div class="row">
									<div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Vehicle number" ><i class="fa fa-taxi fa-fw"  ></i></span>
										  <input type="text" autocomplete="off" name="vehname" id="vnum" class="form-control"  placeholder="Vehicle name">
										</div>
                                        <small class="help-block" id="vnumerr" style=" color:#E9573F;" >* mandatory</small>
                                        </div>
                                    
                                        </div>
                                        <div class="col-sm-6">
                                        <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Vehicle name"><i class="fa fa-taxi fa-fw" ></i></span>
										  <input type="text" autocomplete="off" class="form-control" id="seat" name="occu" placeholder="Occupancy">
										</div>
                                        <small class="help-block" id="seaterr" style=" color:#E9573F;" >* mandatory</small>
                                        </div>
                                        
									</div>
                                    </div>
                                <div class="row" id="nerow" >
                                    <div class="col-sm-6">
                                    <div class="col-sm-6">
                                    <div class="form-group" >
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Choose a city"><i class="fa fa-map-marker fa-fw"></i></span>
                                        <select class="form-control chosen-select" name="city1" id="citys" data-placeholder="Choose a city" >
                                          <option></option>
                                          <?php 
										 
		$cits1 = $conn->prepare("SELECT id,name FROM dvi_cities where type = 'AD' and status=0 ORDER BY name ASC");
		$cits1->execute();
		$row_cits1_main = $cits1->fetchAll();
		foreach($row_cits1_main as $row_cits1)
		{
?>
                                          <option value="<?php echo $row_cits1['id'];?>"><?php echo $row_cits1['name'];?></option>
                                          <?php }?>
                                          </select>
										  
										</div>
                                        <small class="help-block" id="cityserr" style="color:#E9573F;" >* mandatory</small>
                                        </div>
                                        </div>
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Per day rental"><i class="fa fa-inr fa-fw"></i></span>
										  <input type="text" autocomplete="off" class="form-control" id="totamt" name="perday1" placeholder="Per day rental">
										</div>
                                        <small class="help-block" id="totamterr" style="color:#E9573F;" >* mandatory</small>
                                        </div>
                                        </div>
                                    
                                        </div>
                                         <div class="col-sm-6">
								
                                    <div class="col-sm-5">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Per kilomater rental"><i class="fa fa-inr fa-fw"></i></span>
										  <input type="text" autocomplete="off" class="form-control" id="perkilo" name="perkilo1" placeholder="Per kilomater rental">
										</div>
                                        <small class="help-block" id="perklerr" style="color:#E9573F;" >* mandatory</small>
                                        </div>
                                        </div>
                                        <div class="col-sm-5">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Maximum kilometer per day"><i class="fa fa-tachometer fa-fw"></i></span>
										  <input type="text" autocomplete="off" class="form-control" id="permxkl" name="permxkl1" placeholder="Maximum kilometer per day">
										</div>
                                        <small class="help-block" id="permxklerr" style="color:#E9573F;" >* mandatory</small>
                                        </div>
                                        </div>
                                        <div class="col-sm-2">
                                        <div class="form-group">
										<a href="javascript:void(0)" id="addrow" class="input-group-addon tooltips" data-original-title="Add One"><i class="fa fa-plus fa-fw"></i></a>
                                        </div>
                                        </div>
                                        </div>
									</div>
                                    
                                <div class="row">
                                    <div class="col-sm-12">
                                    <div class="form-group pull-right">
                                    <button type="submit"  name="add" class="btn btn-sm btn-success">
                                    <i class="fa fa-plus"></i> Submit</button>
                                    <button type="button" class="btn btn-sm btn-danger" onClick="parent.jQuery.fancybox.close();"><i class="fa fa-times"></i> Cancel</button>
                                        </div>
                                        </div>
                                </div>
                                 <input type="hidden" class="form-control" name="MM_insertform" value="addvehiform">
                                <input type="hidden" id="cnt1"><input type="hidden" id="cnt2"><input type="hidden" id="cnt3"><input type="hidden" id="cnt4"><input type="hidden" id="cnt5"><input type="hidden" id="cnt6">
											 <input type="hidden" id="cn" name="csa" value="2">
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
								<h3 class="panel-title"><i class="fa fa-file-excel-o"></i> Upload file - Vehicles</h3>
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
                                <i class="fa fa-star"></i>  The File must consist of the following fields: vehicle_type, Capacity, avail_cities, perday_rental, perkm_charge, max_km_perday. Sample file attached for your reference<a href="../uploadexcel/Sample/vehicle/sample_upload_vehicle.csv" download style="text-decoration:none"><i class="fa fa-cloud-download fa-lg" ></i></a> .
                                 </p>
                                 <p class="text-muted text-justify" style="color:#434A54; text-indent:20px; page-break-inside:auto">
                                <i class="fa fa-star"></i> Save your spreadsheet XL file with extension as <strong class="text-danger">.csv</strong> and click Upload. Files with format other than .csv will not be allowed. Once you upload and submit, your XL sheet will be validated and any errors found will be displayed. Correct the errors if any and re-upload the file&nbsp;.</strong>
                                 </p>
                                 <p class="text-muted text-justify" style="color:#434A54; text-indent:20px">
                                <i class="fa fa-star"></i> If you still get any problems on uploading your files, please Contact <a style="text-decoration:none;" href="http://www.dvi.co.in" target="new">DoView Holidays (India) Private Ltd.</a>.</strong>
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
		<script src="../core/assets/plugins/icheck/icheck.min.js"></script>
		<script src="../core/assets/plugins/datepicker/bootstrap-datepicker.js"></script>
		<script src="../core/assets/plugins/timepicker/bootstrap-timepicker.js"></script>
		<script src="../core/assets/plugins/mask/jquery.mask.min.js"></script>
		<script src="../core/assets/plugins/validator/bootstrapValidator.min.js"></script>
		<script src="../core/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
		<script src="../core/assets/plugins/datatable/js/bootstrap.datatable.js"></script>
		<script src="../core/assets/plugins/summernote/summernote.min.js"></script>
		<script src="../core/assets/plugins/markdown/markdown.js"></script>
		<script src="../core/assets/plugins/markdown/to-markdown.js"></script>
		<script src="../core/assets/plugins/markdown/bootstrap-markdown.js"></script>
		<script src="../core/assets/plugins/slider/bootstrap-slider.js"></script>
		<script src="../core/assets/plugins/toastr/toastr.js"></script>
		
		<!-- MAIN APPS JS -->
		<script src="../core/assets/js/apps.js"></script>
		<script src="../core/assets/js/demo-panel-1.js"></script>
         <script src="../core/assets/plugins/jQuery1/form-validator/jquery.form-validator.js"></script>
        
                 
<script>

$('.tooltips').tooltip({});


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
//This is for remove row for entry form
function rediv(ss)
{ 
	var rm;
	rm=parseInt($('#cnupd').val());
	rm--;
	$('#cnupd').val(rm);
	$('#upderow'+ss).remove();
}

//validation for vehicle update form
function exmapleval()
{
	if($('#vnum').val()=='')
	{
		$('#vnum').css('border','1px solid #E8573F');
 		$('#vnumerr').html("This field is required.").slideDown('slow');
		$('#cnt1').val(0);
	}
	else
	{
		//For perkilo meter
		$('#vnum').css('border','1px solid #8CC152');
		$('#vnumerr').empty().slideUp('slow');
		$('#cnt1').val(1);
		
	}
	
	//For name
	if($('#citys').val()=='')
	{
 		$('#cityserr').html("This field is required.").slideDown('slow');
		$('#cnt2').val(0);
	}
	else
	{
		//For name
		$('#cityserr').empty().slideUp('slow');
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
		$('#seat').css('border','1px solid #E8573F');
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
	if($('#permxkl').val()=='')
	{
		$('#permxkl').css('border','1px solid #E8573F');
 		$('#permxklerr').html("This field is required.").slideDown('slow');
		$('#cnt6').val(0);
	}
	else if($.isNumeric($('#permxkl').val())==false)
	{
		$('#permxkl').css('border','1px solid #E8573F');
		$('#permxklerr').html("This is not number input give correct input format.").slideDown('slow');
		$('#cnt6').val(0);
	}
	else
	{
		//For perkilo meter
		$('#permxkl').css('border','1px solid #8CC152');
		$('#permxklerr').empty().slideUp('slow');
		$('#cnt6').val(1);
	}
	
	
	var totval;
	totval=	parseInt($('#cnt2').val())+parseInt($('#cnt3').val())+parseInt($('#cnt4').val())+parseInt($('#cnt5').val())+parseInt($('#cnt6').val())+parseInt($('#cnt1').val());

	if(totval==6)
	{
		 return true;
	}
	else
	{
		return false;
	}

}

//to add more rows
$('#addrow').click(function(e) {
    
	var type,cnt,xx;
	type=4;
	cnt=parseInt($('#cn').val());
	xx=parseInt($('#cn').val()-1);

	$.ajax({
	
	type : 'GET',
	url:"load_page.php",
	data: 'type='+type+'&cnt='+cnt,
	success: function(da)
	{
		
		
		$(da).insertAfter('#nerow');
	
		$('.chosen-select').chosen({'width':'100%'});
		cnt++;
		$('#cn').val(cnt);
		$('.tooltips').tooltip();
	}
		});
	
});
</script>
</html>
                        