<html>
<?php
require_once('../Connections/divdb.php');

/*if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "typeexcel")) 
{
}
*/

$chkrow = $conn->prepare("SELECT * FROM setting_dist");
$chkrow->execute();
$row_chkrow = $chkrow->fetch(PDO::FETCH_ASSOC);
$totalRows_chkrow =$chkrow->rowCount();
if (isset($_POST["submit_dist"]))
{
	if ($totalRows_chkrow == 0)
	{
		$insertSQL1 = $conn->prepare("INSERT INTO setting_dist (gen_dist, dep_dist, opt_dist, daytrip_dist, via_dist) VALUES (?,?,?,?,?)");
		$insertSQL1->execute(array($_POST['gendist'],$_POST['desdist'],$_POST['optdist'],$_POST['dtdist'],$_POST['dtdist_via']));
	}
	else
	{
		$updatecnt =$conn->prepare("UPDATE setting_dist SET gen_dist =?, dep_dist =?, opt_dist =?, daytrip_dist =?, via_dist=?");
		$updatecnt->execute(array($_POST['gendist'],$_POST['desdist'],$_POST['optdist'],$_POST['dtdist'],$_POST['dtdist_via']));
	}
	echo "<script>parent.document.location.href='../admin_manacities.php?&mm=".$_GET['mm']."&sm=".$_GET['sm']."&tost=".md5(5)."';</script>"; 
	echo "<script>parent.jQuery.fancybox.close();</script>";
	
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
<form name="set_dist" method="post">
				<?php                    
                if(isset($_GET['type']) && $_GET['type']==md5(1))
                {
                ?>
					<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-primary">
							  <div class="panel-heading">
								<h3 class="panel-title"><i class="fa fa-file-excel-o"></i> Distance Setting (Kms)</h3>
							  </div>
							  <div class="panel-body">
								<div class="row">
									<div class="col-sm-4">
                                    <label> Distance between cities (general)</label>
                                    
                                        </div>
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon" ><i class="fa fa-refresh"  ></i></span>
										  <input type="text" name="gendist" value="<?php echo $row_chkrow['gen_dist'] ?>" id="gendist" class="form-control" placeholder="Specify distance in kms">
										</div>
                                        <small class="help-block" id="cityerr" style="display:none; color:#E9573F;" ></small>
                                        </div>
                                    
                                        </div>
                                    </div><!-- /.panel-body -->
                                    
                                    <div class="row">
									<div class="col-sm-4">
                                    <label> Distance between cities (departure)</label>
                                    
                                        </div>
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon" ><i class="fa fa-refresh"  ></i></span>
										  <input type="text" value="<?php echo $row_chkrow['dep_dist'] ?>" name="desdist" id="desdist" class="form-control" placeholder="Specify distance in kms">
										</div>
                                        <small class="help-block" id="cityerr" style="display:none; color:#E9573F;" ></small>
                                        </div>
                                    
                                        </div>
                                    </div>
                                    
                                    <div class="row">
									<div class="col-sm-4">
                                    <label> Distance for optimization </label>
                                    
                                        </div>
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon" ><i class="fa fa-refresh"  ></i></span>
										  <input type="text" value="<?php echo $row_chkrow['opt_dist'] ?>" name="optdist" id="optdist" class="form-control" placeholder="Specify distance in kms">
										</div>
                                        <small class="help-block" id="cityerr" style="display:none; color:#E9573F;" ></small>
                                        </div>
                                    
                                        </div>
                                    </div>
                                    
                                    <div class="row">
									<div class="col-sm-4">
                                    	<label> Distance for Daytrip </label>
                                    </div>
                                    <div class="col-sm-6">
                                    	<div class="form-group">
                                    		<div class="input-group">
												<span class="input-group-addon" ><i class="fa fa-refresh"  ></i></span>
										  <input type="text" value="<?php echo $row_chkrow['daytrip_dist'] ?>" name="dtdist" id="dtdist" class="form-control" placeholder="Specify distance in kms">
										</div>
                                        <small class="help-block" id="cityerr" style="display:none; color:#E9573F;" ></small>
                                        </div>
                                    
                                        </div>
                                    </div>
                                    
                                    <!--<div class="row">
									<div class="col-sm-4">
                                    	<label> Distance for Travel Via </label>
                                    </div>
                                    <div class="col-sm-6">
                                    	<div class="form-group">
                                    		<div class="input-group">
												<span class="input-group-addon" ><i class="fa fa-refresh"  ></i></span>
										  <input type="text" value="<?php // echo $row_chkrow['via_dist'] ?>" name="dtdist_via" id="dtdist_via" class="form-control" placeholder="Specify distance in kms">
										</div>
                                        <small class="help-block" id="cityerr" style="display:none; color:#E9573F;" ></small>
                                        </div>
                                    
                                        </div>
                                    </div>-->
                                    
                                    <button type="submit" id="submit_dist" name="submit_dist" class="btn btn-primary" >Submit</button>
							  <!--<div class="panel-footer">Panel footer</div>-->
							</div><!-- /.panel panel-default -->
						</div>
                        </div>
                        </div>
<?php
}
?>
</form>
					
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
$('.tagname').tagsInput({width:'auto'});

</script>                        

</html>