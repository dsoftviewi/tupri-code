<html>
<?php
require_once('../Connections/divdb.php');


$states1 = $conn->prepare("SELECT * FROM dvi_states where status = 0");
$states1->execute();
$row_states1_main = $states1->fetchAll();
$totalRows_states1 = $states1->rowCount();

if(isset($_GET['type']) && $_GET['type']==md5(1))
{
	if (isset($_POST["subex1"])) 
	{
		$timezone = new DateTimeZone("Asia/Kolkata");
		$date = new DateTime();
		$date->setTimezone($timezone);
		$tstamp= $date->format('Y_m_d_H_i_s');
		$cn='';
		
		include('db_downloads.php');//for backuping all db
		
		$deletdist =$conn->prepare("TRUNCATE TABLE dvi_cities");
		$deletdist->execute();
		
		$fpaths=pathinfo($_FILES["excl1"]["name"], PATHINFO_EXTENSION);
		$fnames=$tstamp.'.'.$fpaths;
		$excelfile="../uploadexcel/cities/".$fnames;
		move_uploaded_file($_FILES["excl1"]["tmp_name"],$excelfile);
		
		define('CSV_PATH','../uploadexcel/cities/'); 
		
		$csv_file1 = CSV_PATH . "$fnames"; 
		$fp = file("$csv_file1", FILE_SKIP_EMPTY_LINES);
		$csvfile1 = fopen($csv_file1, 'r');
		$theData1 = fgets($csvfile1);
		$i1=0; $city_arr = array();
			while (!feof($csvfile1)) 
			{
				$csv_data1[] = fgets($csvfile1, 1024);
				$csv_array1 = explode(",", $csv_data1[$i1]);
				$insert_csv1 = array();
		
				$insert_csv1['cname'] = (isset($csv_array1[0]) ? $csv_array1[0] : '');
				$insert_csv1['stcode'] = (isset($csv_array1[1]) ? $csv_array1[1] : '');
				$insert_csv1['arr_dep'] = (isset($csv_array1[2]) ? $csv_array1[2] : '');
				$insert_csv1['ss_dist'] = (isset($csv_array1[3]) ? $csv_array1[3] : '');
				//print_r($insert_csv1)."<br>";
				
				if ($insert_csv1['cname'] != '')
				{
					if (strtoupper($insert_csv1['arr_dep']) == 'Y')
					{
						$arr_dep = 'AD';
					}
					else
					{
						$arr_dep = '';
					}
					
					$insertSQL1=$conn->prepare("INSERT INTO dvi_cities (country, region, name, type, ss_dist, status) values('IN',?,?,?,?, 0)");
					$insertSQL1->execute(array($insert_csv1['stcode'],$insert_csv1['cname'],$arr_dep,$insert_csv1['ss_dist']));
				}
				$i1++;
			}  
		fclose($csvfile1);
		
		foreach($row_states1_main as $row_states1)
		{
			
			$citycnt = $conn->prepare("SELECT COUNT(*) as ctycnt FROM dvi_cities where region =?");
			$citycnt->execute(array($row_states1['code']));
			$row_citycnt = $citycnt->fetch(PDO::FETCH_ASSOC);
			$totalRows_citycnt = $citycnt->rowCount();
			
			$updatecnt =$conn->prepare("UPDATE dvi_states SET cities =? WHERE code =?");
			$updatecnt->execute(array($row_citycnt['ctycnt'],$row_states1['code']));
		}
		
		
		$cn=count($fp)-1;
		$cn1=$cn.' records added successfully..!';
		$cl='success';	
		
		echo "<script>parent.document.location.href='../admin_manacities.php?&mm=".$_GET['mm']."&sm=".$_GET['sm']."&tost=1&msg=".$cn1."'</script>"; 
		echo "<script>parent.jQuery.fancybox.close();</script>";
		
	}
}

if(isset($_GET['type']) && $_GET['type']==md5(2))
{
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "typeexcel")) 
	{
		$timezone = new DateTimeZone("Asia/Kolkata");
		$date = new DateTime();
		$date->setTimezone($timezone);
		$tstamp= $date->format('Y_m_d_H_i_s');
		$cn='';
		
		include('db_downloads.php');//for backuping all db
		
		$deletdist =$conn->prepare("TRUNCATE TABLE dvi_citydist");
		$deletdist->execute();
		
		$fpaths=pathinfo($_FILES["excl"]["name"], PATHINFO_EXTENSION);
		$fnames=$tstamp.'.'.$fpaths;
		$excelfile="../uploadexcel/cities/".$fnames;
		move_uploaded_file($_FILES["excl"]["tmp_name"],$excelfile);
		
		define('CSV_PATH','../uploadexcel/cities/'); 
		
		$csv_file1 = CSV_PATH . "$fnames"; 
		$fp = file("$csv_file1", FILE_SKIP_EMPTY_LINES);
		$csvfile1 = fopen($csv_file1, 'r');
		$theData1 = fgets($csvfile1);
		$i1=0; $city_arr = array();
			while (!feof($csvfile1)) {
				$csv_data1[] = fgets($csvfile1, 1024);
				$csv_array1 = explode(",", $csv_data1[$i1]);
				if ($i1 == 0)
				{
					$t=1;
					for ($k=1;$k<=$t;$k++)
					{
						if(isset($csv_array1[$k]) && $csv_array1[$k] != '')
						{
							array_push($city_arr,$csv_array1[$k]);
							$t++;
						}
						else
						{
							$ccnt = $t-1;
							$t=$t-2;
						}
					}
				}
				else
				{
					$cit_id = $csv_array1[0]; 
					$insert_csv1 = array();
					for ($k1=1;$k1<=$ccnt;$k1++)
					{
						$insert_csv1[$k1] = (isset($csv_array1[$k1]) ? $csv_array1[$k1] : '');
					}
				}
				//print_r($insert_csv1);
				//echo "<br>";
				//print_r($city_arr);
				if ($i1 != 0)
				{
					for ($m=1;$m<$ccnt;$m++)
					{
						if ($insert_csv1[$m] != '')
						{
							$from_city = $cit_id;
							$n=$m-1;
							$to_city = $city_arr[$n];
				$insertSQL1=$conn->prepare("INSERT INTO dvi_citydist (from_cityid, to_cityid, dist, status) values(?,?,?,0)");
				$insertSQL1->execute(array($from_city,$to_city,$insert_csv1[$m]));
						}
					}
				}
				$i1++;
			}
		fclose($csvfile1);
		
		$insertSQL11=$conn->prepare("INSERT INTO dvi_citydist (from_cityid, to_cityid, dist, status) values(?,?,0,0)");
		$insertSQL11->execute(array($from_city,$from_city));
		
		$cn=count($fp)-1;
		$cn1=$cn.' records added successfully..!';
		$cl='success';	
		
		echo "<script>parent.document.location.href='../admin_manacities.php?&mm=".$_GET['mm']."&sm=".$_GET['sm']."&tost=2&msg=".$cn1."'</script>"; 
		echo "<script>parent.jQuery.fancybox.close();</script>";
	}
}

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
				<?php                    
                if(isset($_GET['type']) && $_GET['type']==md5(2))
                {
                ?>
					<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-primary">
							  <div class="panel-heading">
								<h3 class="panel-title"><i class="fa fa-file-excel-o"></i> Upload file - DVi cities distance chart</h3>
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
                                <i class="fa fa-star"></i>  Download sample file attached for your reference. The format must be exactly similar to the downloaded XL sheet.<a href="../uploadexcel/Sample/city/sample_distance_matrix.csv" download style="text-decoration:none"><i class="fa fa-cloud-download fa-lg" ></i></a> .
                                 </p>
                                 <p class="text-muted text-justify" style="color:#434A54; text-indent:20px; page-break-inside:auto">
                                <i class="fa fa-star"></i> Save your spreadsheet XL file with extension as <strong class="text-danger">.csv</strong> and click Upload. Files with format other than .csv will not be allowed. Once you upload and submit, your XL sheet will be validated and any errors found will be displayed. Correct the errors if any and re-upload the file&nbsp;.</strong>
                                 </p>
                                 <p class="text-muted text-justify" style="color:#434A54; text-indent:20px">
                                <i class="fa fa-star"></i> If you still get any problems on uploading your files, please Contact <a style="text-decoration:none;" href="http://www.dvi.co.in" target="new">DoView Holidays (India) Pvt. Ltd</a>.</strong>
                                 </p>
                            
								</div>
                                 <form name="typeexcel" role="form"  method="post" enctype="multipart/form-data" onSubmit="return chkfile();">
                                 <div class="row">
                                 <div class="col-sm-10" >
								<div class="form-group">
									<div class="input-group">
										<span class="input-group-btn">
											<span class="btn btn-default btn-file">
												Browse&hellip; <input type="file" name="excl"  id="confirm1">
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
                                    <button type="submit"   class="btn btn-sm btn-success" name="subex"><i class="fa fa-upload"></i> Upload1</button>
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
<?php
}
?>

					<?php                    
                    if(isset($_GET['type']) && $_GET['type']==md5(1))
                    {
                    ?>
					<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-primary">
							  <div class="panel-heading">
								<h3 class="panel-title"><i class="fa fa-file-excel-o"></i> Upload file - DVi served cities </h3>
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
                                <i class="fa fa-star"></i>  The File must consist of the following fields: City name, State code, Arrival/Departure. Sample file attached for your reference<a href="../uploadexcel/Sample/city/sample_upload_city.csv" download style="text-decoration:none"><i class="fa fa-cloud-download fa-lg" ></i></a> .
                                 </p>
                                <p class="text-muted text-justify" style="color:#434A54; text-indent:20px; page-break-inside:auto">
                                <i class="fa fa-star"></i> Save your spreadsheet XL file with extension as <strong class="text-danger">.csv</strong> and click Upload. Files with format other than .csv will not be allowed. Once you upload and submit, your XL sheet will be validated and any errors found will be displayed. Correct the errors if any and re-upload the file&nbsp;.</strong>
                                </p>
                                <p class="text-muted text-justify" style="color:#434A54; text-indent:20px">
                                <i class="fa fa-star"></i> If you still get any problems on uploading your files, please Contact <a style="text-decoration:none;" href="http://www.dvi.co.in" target="new">DoView Holidays (India) Pvt. Ltd</a>.</strong>
                                </p>
                            
								</div>
                                <form name="typeexcel1" role="form"  method="post" enctype="multipart/form-data" onSubmit="return chkfile1();">
                                <div class="row">
                                	<div class="col-sm-10" >
										<div class="form-group">
											<div class="input-group">
											<span class="input-group-btn">
											<span class="btn btn-default btn-file">
												Browse&hellip; <input type="file" name="excl1" id="approveletter">
											</span>
										</span>
                                        <input type="text" class="form-control" id="nametxt1" readonly>
									</div><!-- /.input-group -->
                                    <small id="err1" class="help-block" style="color:#E9575C; display:none"></small>
								</div>
                                </div>
                                <div class="col-sm-2">
                                <div class="form-group">
									<div class="pull-right">
                                    <button type="submit"  onclick="" class="btn btn-sm btn-success" name="subex1"><i class="fa fa-upload"></i> Upload</button>
                                    </div>
								</div>
                                </div>
                                </div>
                                 <input type="hidden" name="MM_insert1" value="typeexcel1" />
                                  <input type="hidden" id="errval1" />
                                </form>
                                </div>
							  </div><!-- /.panel-body -->
							  <!--<div class="panel-footer">Panel footer</div>-->
							</div><!-- /.panel panel-default -->
						</div>
                        </div>
                        </div>
<?php 
}
?>                        
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
	<!--	<script src="../core/assets/plugins/summernote/summernote.min.js"></script>
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

$('.tooltips').tooltip({});


//this is for tag validation
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
		return false;
	}
	else
	{
		$('#err').empty().hide('fade');
		 $('#nametxt').css('border','1px solid #8CC152');
		return true;
	}
}

document.getElementById('confirm1').addEventListener('change', checkFile, false);
//document.getElementById('approveletter').addEventListener('change', checkFile1, false);

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

function chkfile1()
{
	 var file_list = $('#approveletter').val();
	 var extension = file_list.substr((file_list.lastIndexOf('.') +1));
	
	if(extension != "csv")
	{
		$('#errval1').val(1);	
	}else{
		 $('#errval1').val(0);
	}
	
	var filechk = $('#errval1').val();
	if (filechk == '' || filechk ==1)
	{
		var txt;
		txt='Please choose file (.csv format) to upload';
		$('#err1').html(txt).show('fade');
		$('#nametxt1').css('border','1px solid #E9573F');
		return false;
	}
	else
	{
		$('#err1').empty().hide('fade');
		 $('#nametxt1').css('border','1px solid #8CC152');
		return true;
	}
}


</script>                        

</html>