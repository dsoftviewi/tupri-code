<html>
<?php
require_once('../Connections/divdb.php');

$states = $conn->prepare("SELECT * FROM dvi_states ORDER BY name ASC");
$states->execute();
//$row_states=$states->fetch(PDO::FETCH_ASSOC);
$row_states_main=$states->fetchAll();
$totalRows_states = $states->rowCount();

if(isset($_POST["addcity"])) 
{
	$getcode = $conn->prepare("SELECT * FROM dvi_states where code =?");
	$getcode->execute(array($_POST['state']));
	$row_getcode = $getcode->fetch(PDO::FETCH_ASSOC);
		
 	$insertcnt = $conn->prepare("INSERT INTO dvi_cities (country, region, name, latitude, longitude) VALUES ('IN',?,?,?,?)");
	$insertcnt->execute(array($row_getcode['code',$_POST['cityname'],$_POST['latit'],$_POST['longit']));
	
	$updatecnt =$conn->prepare("UPDATE dvi_states SET cities =? WHERE code =?");
	$updatecnt->execute(array($row_getcode[cities]+1,$_POST['state']));
	
  	echo "<script>parent.jQuery.fancybox.close(); parent.location.reload();</script>";
}


?>
<head>
<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
		
		<!-- MAIN CSS (REQUIRED ALL PAGE)       height:100%;
-->
		<link href="../core/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="../core/assets/css/style.css" rel="stylesheet">
        <link href="../core/assets/plugins/chosen/chosen.min.css" rel="stylesheet">
        <link href="../core/assets/plugins/icheck/skins/all.css" rel="stylesheet">
		<link href="../core/assets/css/style-responsive.css" rel="stylesheet">
         <link rel="stylesheet" type="text/css" href="../core/assets/plugins/Tags/jquery.tagsinput.css" />
         <link href="../core/assets/plugins/validator/bootstrapValidator.min.css" rel="stylesheet">
         <link href="../core/assets/plugins/toastr/toastr.css" rel="stylesheet">
         
        
<style>
body {
    background-position: 50% 50%;
    margin:0px;
    padding:0px !important;
}
</style>

</head>
<body>
					<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-primary">
							  <div class="panel-heading">
								<h3 class="panel-title"><i class="fa fa-building"></i> Add New City</h3>
							  </div>
							  <div class="panel-body">
								<div class="row">
							<div class="col-sm-12">
								 <form  id="exmapleval1" method="post" name="exmaplevals"  >
                                 <input type="hidden" id="mm" value="<?php echo $_GET['mm'];?>">
                                   <input type="hidden" id="sm" value="<?php echo $_GET['sm'];?>">
                                                <div class="row">
									<div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon" ><i class="fa fa-building"  ></i></span>
										  <input type="text" name="cityname" id="cityname" class="form-control" placeholder="City name" onBlur="retcity()">
										</div>
                                        <small class="help-block" id="cityerr" style="display:none; color:#E9573F;" ></small>
                                        </div>
                                    
                                        </div>
                                        <div class="col-sm-6">
                                        <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon"><i class="fa fa-cube" ></i></span>
										  <select class="form-control chosen-select" name="state" id="state" tabindex="2" onChange="retstate()">
											<option value="">-- Select State --</option>
                                            <?php
											foreach($row_states_main as $row_states);
											{
											?>
											<option value="<?php echo $row_states['code']; ?>"><?php echo $row_states['name']; ?></option>
                                            <?php
											}
											
											?>
										</select>
										</div>
                                        <small class="help-block" id="staterr" style=" display:none; color:#E9573F;" ></small>
                                        </div>
									</div>
                                    </div>
                                    
                                    <div class="row">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrows-h"></i></span>
										  <input type="text" class="form-control" id="latit" name="latit" placeholder="Enter Latitude" onBlur="retlat()">
										</div>
                                        <small class="help-block" id="laterr" style=" display:none; color:#E9573F;" ></small>
                                        </div>
                                        </div>
                                         <div class="col-sm-6">
								
                                    <div class="form-group">
										 <div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrows-v"></i></span>
										  <input type="text"  class="form-control" id="longit" name="longit" placeholder="Enter Longitude" onBlur="retlong()">
										</div>
                                        <small class="help-block" id="longerr" style=" display:none; color:#E9573F;" ></small>
                                        </div>
									</div><!-- /.col-sm-6 -->
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-12">
                                    <div class="form-group pull-right">
                                    <button type="submit" onClick="return chkdata()"  name="addcity" class="btn btn-sm btn-success">
                                    <i class="fa fa-plus"></i> Submit</button>
                                    <button type="button" class="btn btn-sm btn-danger" onClick="parent.jQuery.fancybox.close();"><i class="fa fa-times"></i> Cancel</button>
                                        </div>
                                        </div>
                                </div>
                                 </form>
                                 
                                </div>
							  </div>
							</div><!-- /.panel panel-default -->
						</div>
                        </div>
                        </div>
                      
                        </body>
                        
                        <script src="../core/assets/js/jquery.min.js"></script>
                        <!-- MAIN JAVASRCIPT (REQUIRED ALL PAGE)-->
		
		<script src="../core/assets/js/bootstrap.min.js"></script>
		<script src="../core/assets/plugins/retina/retina.min.js"></script>
		<script src="../core/assets/plugins/nicescroll/jquery.nicescroll.js"></script>
		<script src="../core/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		<script src="../core/assets/plugins/backstretch/jquery.backstretch.min.js"></script>
        <script src="../core/assets/plugins/chosen/chosen.jquery.min.js"></script>
        <script src="../core/assets/plugins/icheck/icheck.min.js"></script>

        <script type="text/javascript" src="../core/assets/plugins/Tags/jquery.tagsinput.js"></script>
        <script src="../core/assets/plugins/validator/bootstrapValidator.min.js"></script>
        <script src="../core/assets/plugins/toastr/toastr.js"></script>
        
        <!-- VALIDATOR EXAMPLE -->
      <!--  <script src="../core/assets/plugins/validator/example.js"></script>-->
     
     
		<!-- MAIN APPS JS -->
		<script src="../core/assets/js/apps.js"></script>
		<script src="../core/assets/js/demo-panel-1.js"></script>
         <script src="../core/assets/plugins/jQuery1/form-validator/jquery.form-validator.js"></script>
                 
<script>
$('.chosen-select').chosen({
	'width': '100%',
});
</script>
<script>		
function chkdata()
{
	var chkcity = $('#cityname').val();
	if (chkcity == '')
	{
		$('#cityerr').text("Enter city name.").show();
		return false
	}
	else
	{
		if ($("#cityerr").show())
		{
			$("#cityerr").hide();
		}
	}
	
	var chkstate = $('#state').val();
	if (chkstate == '')
	{
		$('#staterr').text("Choose the state where city belongs to.").show();
		return false
	}
	
	var chklat = $('#latit').val();
	if (chklat == '')
	{
		$('#laterr').text("Enter latitude of city added.").show();
		return false
	}
	else
	{
		if ($("#laterr").show())
		{
			$("#laterr").hide();
		}
	}
	
	var chklon = $('#longit').val();
	if (chklon == '')
	{
		$('#longerr').text("Enter longitude of city added.").show();
		return false
	}
	else
	{
		if ($("#longerr").show())
		{
			$("#longerr").hide();
		}
	}
	
	return true
}

function retstate()
{
	if ($("#staterr").show())
	{
		$("#staterr").hide();
	}
}

function retcity()
{
	if ($("#cityerr").show())
	{
		$("#cityerr").hide();
	}
}

function retlat()
{
	if ($("#laterr").show())
	{
		$("#laterr").hide();
	}
}

function retlong()
{
	if ($("#longerr").show())
	{
		$("#longerr").hide();
	}
}
</script>
</html>
                        