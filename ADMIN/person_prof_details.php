<html>
<?php
require_once('../Connections/divdb.php');
include("../COMMN/smsfunc.php");
session_start();



$timezone = new DateTimeZone("Asia/Kolkata" );
$date = new DateTime();
$date->setTimezone($timezone );
$mm=$date->format('m');
$yy=$date->format('Y');
$mon=$date->format('F');
$dd=$date->format('m/d/Y');

$pers=substr($_GET['uid'],0,3);

?>
<head>
<link href="../core/assets/css/bootstrap.min.css" rel="stylesheet">
		
		<!-- MAIN CSS (REQUIRED ALL PAGE)       height:100%;
-->
		<link href="../core/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="../core/assets/css/style.css" rel="stylesheet">
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

td{
  padding: 6px;	
}
</style>

</head>
<body>
					<div class="row">
                    <?php if($pers=="DSR"){ 
					 
	$distr= $conn->prepare("SELECT * FROM distributor_pro where distr_id=?");
	$distr->execute(array($_GET['uid']));
	$row_distr= $distr->fetch(PDO::FETCH_ASSOC);
	$tot_distr= $distr->rowCount();
					
					?>
						<div class="col-sm-12">
							<div class="panel panel-primary" >
                          
							  <div class="panel-heading ">
								<h3 class="panel-title">&nbsp; <i class="fa fa-user"></i>&nbsp;
<?php  echo $row_distr['distr_fname']." ".$row_distr['distr_lname']." Profile View"; ?>

										<span class="right-content">
										Distributor
                                        </span>
										
</h3>
							  </div>
                              
                                <form name="update_pro" method="post" enctype="multipart/form-data">
							  <div class="panel-body">
								<div class="row">
                                <div class="col-sm-12" align="center">
                                <img src="../ADMIN/img_upload/distributor_img/<?php echo $row_distr['distr_img']; ?>" alt="<?php echo $row_distr['distr_fname']; ?>" height="190px" width="200px">
<input type="file" name="pro_pic"  class="inp form-control" style="display:none;  width: 300px;" >
                                
                                </div>
                                
								<div class="col-sm-12" style="margin-top:15px; border-top: #CCC solid 1px">
                                <p style="font-size:14px; font-weight:600; color:#CCC; text-align:center">Personal Information</p>
<div class="col-sm-6" >
<table>
<tr><td>First Name</td><td>:</td><td><label class="lab"><?php echo $row_distr['distr_fname']; ?></label> </td></tr>
<tr><td>Last Name</td><td>:</td><td><label class="lab"><?php echo $row_distr['distr_lname']; ?></label> </td></tr>
<tr><td>Email ID</td><td>:</td><td><label class="lab"><?php echo $row_distr['email_id']; ?></label> </td></tr>
<tr><td>Contact Number</td><td>:</td><td><label class="lab"><?php echo $row_distr['mobile_no']; ?></label> </td></tr>
<tr><td>Land-Line Number</td><td>:</td><td><label class="lab"><?php echo $row_distr['land_line']; ?></label> </td></tr>
</table>
</div>
<div class="col-sm-6">
<table>
<tr><td>Company Name</td><td>:</td><td><label class="lab"><?php echo $row_distr['comp_name']; ?></label> </td></tr>
<tr><td>Business Volume</td><td>:</td><td><label class="lab"><?php echo $row_distr['busi_volume']; ?></label> </td></tr>
<tr><td>Fax Number</td><td>:</td><td><label class="lab"><?php echo $row_distr['fax_no']; ?></label> </td></tr>
<tr><td>IATA Number</td><td>:</td><td><label class="lab"><?php echo $row_distr['iata_no']; ?></label> </td></tr>
<tr><td>Working State</td><td>:</td><td>
                           <?php 

$dvistate = $conn->prepare("SELECT * FROM dvi_states ");
$dvistate->execute();
//$row_dvistate= mysql_fetch_assoc($dvistate);
$row_dvistate_main=$dvistate->fetchAll();
?>
<select id="workstate" name="workstate" class="inp form-control " style="display:none" >
<?php $wname= '-'; foreach($row_dvistate_main as $row_dvistate){
	if($row_dvistate['code']==$row_distr['work_state']){
		$wname=$row_dvistate['name'];
	?>
    <option selected value="<?php echo $row_dvistate['code']; ?>"><?php echo $row_dvistate['name']; ?></option>
<?php }else{?>
	<option value="<?php echo $row_dvistate['code']; ?>"><?php echo $row_dvistate['name']; ?></option>
<?php } 
}?>
</select>
<label class="lab"><?php echo $wname; ?></label>
                                
 </td></tr>
</table>

</div>
                  			 	</div>
                                
                                
                                
                                <div class="col-sm-12" style="margin-top:10px; border-top:#CCC solid 1px;">
                                <p style="font-size:14px; font-weight:600; color:#CCC; text-align:center">Banking & Residential Information</p>
                                <div class="col-sm-6">
                                <table>
<tr><td>Account Number</td><td>:</td><td><label class="lab"><?php echo $row_distr['bank_acc_no']; ?></label> </td></tr>
<tr><td>IFSC Code</td><td>:</td><td><label class="lab"><?php echo $row_distr['bank_ifsc_code']; ?></label> </td></tr>
<tr><td>Address</td><td>:</td><td><label class="lab"><?php echo $row_distr['bank_addr']; ?></label> </td></tr>
</table>
                                </div>
                                 <div class="col-sm-6">
                                 <table>
                                 <tr><td>Home State</td><td>:</td><td> 
                                  <?php 

$dvistate = $conn->prepare("SELECT * FROM dvi_states where code=?");
$dvistate->execute(array($row_distr['state']));
$row_dvistate= $dvistate->fetch(PDO::FETCH_ASSOC);
?>

<label class="lab"><?php echo $row_dvistate['name']; ?></label>
                                 </td></tr>
                                 <tr><td>Home City</td><td>:</td><td id="home_city"> 
                                  <?php   

$dvicity = $conn->prepare("SELECT * FROM reg_cities where region=?");
$dvicity->execute(array($row_distr['state']));
$row_dvicity= $dvicity->fetch(PDO::FETCH_ASSOC);
?>

<label class="lab"><?php echo $row_dvicity['name']; ?></label>
                                 </td></tr>
                                 
<tr><td>Home Address</td><td>:</td><td><label class="lab"><?php echo $row_distr['distr_addr']; ?></label> 

</td></tr>

</table>
                                 </div>
                                </div>
                                
                                <div class="col-sm-12" style="margin-top:10px; border-top:#CCC solid 1px;">
                                <p style="font-size:14px; font-weight:600; color:#CCC; text-align:center">Reference Information</p>
                                <div class="col-sm-12">
                                <table>
<tr><td>Referred  Person ID </td><td>:</td><td><label class="lab"><?php echo $row_distr['refered_id']; ?></label> </td></tr>
<tr><td>Referred  Person Name </td><td>:</td><td><label class="lab"><?php echo $row_distr['refered_name']; ?></label> </td></tr>
<tr><td>Person - Relation </td><td>:</td><td><label class="lab"><?php echo $row_distr['refered_details']; ?></label> </td></tr>
<?php if($row_distr['ip_addr'] != ''){?>
<tr><td>IP Address  </td><td>:</td><td><label class="lab"><?php echo $row_distr['ip_addr']; ?></label> </td></tr>
<?php }?>
<tr><td>Registration Date  </td><td>:</td><td><label class="lab"><?php echo date("d-M-Y h:i:s a",strtotime($row_distr['datetime'])); ?></label> </td></tr>
</table>
                                </div>
                                </div>
                                
							  </div>
							</div><!-- /.panel panel-default -->
                            </form>
						</div>
                        </div>
                        <?php }//if end of profile edit
						else if($pers=="AGN"){
							//agent _profile
							
					 
	$agnt= $conn->prepare("SELECT * FROM agent_pro where agent_id=?");
	$agnt->execute(array($_GET['uid']));
	$row_agnt= $agnt->fetch(PDO::FETCH_ASSOC);
	$tot_agnt=$agnt->rowCount();
					
					?>
						<div class="col-sm-12">
							<div class="panel panel-primary" >
                          
							  <div class="panel-heading ">
								<h3 class="panel-title">&nbsp; <i class="fa fa-user"></i>&nbsp;
<?php  echo $row_agnt['agent_fname']." ".$row_agnt['agent_lname']." Profile View"; ?>

										<span class="right-content">
										Agent
                                        </span>
										
</h3>
							  </div>
                              
                                <form name="update_pro" method="post" enctype="multipart/form-data">
							  <div class="panel-body">
								<div class="row">
                                <div class="col-sm-12" align="center">
                                <img src="../ADMIN/img_upload/agent_img/<?php echo $row_agnt['agent_img']; ?>" alt="<?php echo $row_agnt['agent_fname']; ?>" height="190px" width="200px">
<input type="file" name="pro_pic"  class="inp form-control" style="display:none;  width: 300px;" >
                                
                                </div>
                                
								<div class="col-sm-12" style="margin-top:15px; border-top: #CCC solid 1px">
                                <p style="font-size:14px; font-weight:600; color:#CCC; text-align:center">Personal Information</p>
<div class="col-sm-6" >
<table>
<tr><td>First Name</td><td>:</td><td><label class="lab"><?php echo $row_agnt['agent_fname']; ?></label> </td></tr>
<tr><td>Last Name</td><td>:</td><td><label class="lab"><?php echo $row_agnt['agent_lname']; ?></label> </td></tr>
<tr><td>Email ID</td><td>:</td><td><label class="lab"><?php echo $row_agnt['email_id']; ?></label> </td></tr>
<tr><td>Contact Number</td><td>:</td><td><label class="lab"><?php echo $row_agnt['mobile_no']; ?></label> </td></tr>
<tr><td>Land-Line Number</td><td>:</td><td><label class="lab"><?php echo $row_agnt['land_line']; ?></label> </td></tr>
</table>
</div>
<div class="col-sm-6">
<table>
<tr><td>Company Name</td><td>:</td><td><label class="lab"><?php echo $row_agnt['comp_name']; ?></label> </td></tr>
<tr><td>Business Volume</td><td>:</td><td><label class="lab"><?php echo $row_agnt['busi_volume']; ?></label> </td></tr>
<tr><td>Fax Number</td><td>:</td><td><label class="lab"><?php echo $row_agnt['fax_no']; ?></label> </td></tr>
<tr><td>IATA Number</td><td>:</td><td><label class="lab"><?php echo $row_agnt['iata_no']; ?></label> </td></tr>
<tr><td>Working State</td><td>:</td><td>
                           <?php 

$dvistate = $conn->prepare("SELECT * FROM dvi_states ");
$dvistate->execute();
//$row_dvistate= mysql_fetch_assoc($dvistate);
$row_dvistate_main=$dvistate->fetchAll();
?>
<select id="workstate" name="workstate" class="inp form-control " style="display:none" >
<?php $wname= '-'; foreach($row_dvistate_main as $row_dvistate){
	if($row_dvistate['code']==$row_agnt['work_state']){
		$wname=$row_dvistate['name'];
	?>
    <option selected value="<?php echo $row_dvistate['code']; ?>"><?php echo $row_dvistate['name']; ?></option>
<?php }else{?>
	<option value="<?php echo $row_dvistate['code']; ?>"><?php echo $row_dvistate['name']; ?></option>
<?php } 
}?>
</select>
<label class="lab"><?php echo $wname; ?></label>
                                
 </td></tr>
</table>

</div>
                  			 	</div>
                                <div class="col-sm-12" style="margin-top:10px; border-top:#CCC solid 1px;">
                                <p style="font-size:14px; font-weight:600; color:#CCC; text-align:center">Banking & Residential Information</p>
                                <div class="col-sm-6">
                                <table>
<tr><td>Account Number</td><td>:</td><td><label class="lab"><?php echo $row_agnt['bank_acc_no']; ?></label> </td></tr>
<tr><td>IFSC Code</td><td>:</td><td><label class="lab"><?php echo $row_agnt['bank_ifsc_code']; ?></label> </td></tr>
<tr><td>Address</td><td>:</td><td><label class="lab"><?php echo $row_agnt['bank_addr']; ?></label> </td></tr>
</table>
                                </div>
                                 <div class="col-sm-6">
                                 <table>
                                 <tr><td>Home State</td><td>:</td><td> 
                                  <?php 

$dvistate = $conn->prepare("SELECT * FROM dvi_states where code=?");
$dvistate->execute(array($row_agnt['state']));
$row_dvistate= $dvistate->fetch(PDO::FETCH_ASSOC);
?>
<label class="lab"><?php echo $row_dvistate['name']; ?></label>
                                 </td></tr>
                                 <tr><td>Home City</td><td>:</td><td id="home_city"> 
                                  <?php   

$dvicity = $conn->prepare("SELECT * FROM reg_cities where region=?");
$dvicity->execute(array($row_agnt['state']));
$row_dvicity= $dvicity->fetch(PDO::FETCH_ASSOC);

?>

<label class="lab"><?php echo $row_dvicity['name']; ?></label>
                                 </td></tr>
                                 
<tr><td>Home Address</td><td>:</td><td><label class="lab"><?php echo $row_agnt['agent_addr']; ?></label> 

</td></tr>

</table>
                                 </div>
                                </div>
                                
                                <div class="col-sm-12" style="margin-top:10px; border-top:#CCC solid 1px;">
                                <p style="font-size:14px; font-weight:600; color:#CCC; text-align:center">Reference & Registration Information</p>
                                <div class="col-sm-12">
                                <table>
<tr><td>Referred  Person ID </td><td>:</td><td><label class="lab"><?php echo $row_agnt['refered_id']; ?></label> </td></tr>
<tr><td>Referred  Person Name </td><td>:</td><td><label class="lab"><?php echo $row_agnt['refered_name']; ?></label> </td></tr>
<tr><td>Person - Relation </td><td>:</td><td><label class="lab"><?php echo $row_agnt['refered_details']; ?></label> </td></tr>
<?php if($row_agnt['ip_addr'] != ''){?>
<tr><td>IP Address  </td><td>:</td><td><label class="lab"><?php echo $row_agnt['ip_addr']; ?></label> </td></tr>
<?php }?>
<tr><td>Registration Date  </td><td>:</td><td><label class="lab"><?php echo date("d-M-Y h:i:s a",strtotime($row_agnt['datetime'])); ?></label> </td></tr>
</table>
                                </div>
                                </div>
                                
							  </div>
							</div><!-- /.panel panel-default -->
                            </form>
						</div>
                        </div>
                        <?php 
							
							}?>
                        
                        </div>
                      
                        </body>
                        
                        <script src="../core/assets/js/jquery.min.js"></script>
                        <!-- MAIN JAVASRCIPT (REQUIRED ALL PAGE)-->
		
		<script src="../core/assets/js/bootstrap.min.js"></script>
		<script src="../core/assets/plugins/retina/retina.min.js"></script>
		<script src="../core/assets/plugins/nicescroll/jquery.nicescroll.js"></script>
		<script src="../core/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		<script src="../core/assets/plugins/backstretch/jquery.backstretch.min.js"></script>
      	<script src="../core/assets/js/apps.js"></script>
		<script src="../core/assets/js/demo-panel-1.js"></script>
                 
<script>

</script>

</html>
                        